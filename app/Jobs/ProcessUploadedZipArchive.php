<?php

namespace App\Jobs;

use App\Models\Archive;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use ZipArchive;

class ProcessUploadedZipArchive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $archive;
    protected $galleryMetadata;
    protected $galleryName;
    protected $destination;
    protected $uploader;

    /**
    * The number of times the job may be attempted.
    *
    * @var int
    */
    public $tries = 1;

    /**
    * The maximum number of unhandled exceptions to allow before failing.
    *
    * @var int
    */
    public $maxExceptions = 1;

    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct(User $uploader, Archive $archive, Array $galleryMetadata)
    {
        $this->uploader = $uploader;
        $this->archive = $archive;
        $this->galleryMetadata = $galleryMetadata;
        $this->galleryName = Str::uuid();
        $this->destination = public_path('assets/galleries') . "/" . $this->galleryName;
        $this->onConnection('database');
        // $this->onQueue('ProcessUploadArchive'); // optional
    }

    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        $archiveFilePath = public_path('assets/archives') . "/" . $this->archive->filename;

        // metas for gallery
        $pageNames = [];

        $zip = new ZipArchive();
        // open the archive with read-only access
        $res = $zip->open($archiveFilePath, ZipArchive::RDONLY);

        if ($res === true) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                // get the name for each pages
                $pageNames[$i] = $zip->getNameIndex($i);
            }

            // sort the array from small to big by filename
            usort($pageNames, function($a, $b){
                return $a <=> $b;
            });

            // extra all pages into the destination
            if (!$zip->extractTo($this->destination)) {
                $zip->close();
                throw new Exception("Failed to Extract the Archive");
            }

            // close the stream
            $zip->close();

            // Persist if succeed
            // create a gallery entries in the datapase for the given archives
            $gallery = Gallery::create([
                'user_id' => $this->uploader->id,
                'archive_id' => $this->archive->id,
                'title' => $this->galleryMetadata['title'],
                'title_original' => $this->galleryMetadata['titleOriginal'],
                'dir_path' => $this->galleryName,
            ]);

            // add the archive id to the gallery
            $this->archive->isProcess = true;
            $this->archive->save();

            // create the pages entries in the datapase for the given for the gallery
            for ($i = 0; $i < count($pageNames); $i++) {
                Page::create([
                    'gallery_id' => $gallery->id,
                    'filename' => $pageNames[$i],
                    'page_number' => $i + 1,
                ]);
            }

            $this->finish($gallery, $this->archive);
        } else {
            throw new Exception("Failed to open the Archive");
        }
    }

    /**
     * Call this method when the job is finish
     *
     * @param App\Models\Gallery $gallery
     * @param App\Models\Archive $Archive
     *
     * @return void
     */
    public function finish(Gallery $gallery, Archive $archive)
    {
        CreateThumbnailsForPages::dispatch($gallery);
    }
}
