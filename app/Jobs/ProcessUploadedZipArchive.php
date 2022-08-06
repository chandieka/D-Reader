<?php

namespace App\Jobs;

use App\Models\Archive;
use App\Models\Gallery;
use App\Models\Page;
use App\Providers\AppServiceProvider;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ProcessUploadedZipArchive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $archive;
    protected $galleryMetadata;
    protected $galleryName;
    protected $destination;

    /**
    * The number of times the job may be attempted.
    *
    * @var int
    */
    public $tries = 1; // TODO: add to 3 tries and handle the clean up before retries

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
    public function __construct(Archive $archive, Array $galleryMetadata = null)
    {
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

        $zip = new ZipArchive();
        // open the archive with read-only access
        $res = $zip->open($archiveFilePath, ZipArchive::RDONLY);

        if ($res === true) {
            $pageNames = [];
            // get the name for each pages
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $pageNames[$i] = $zip->getNameIndex($i);
            }


            // extra all pages into the destination
            if (!$zip->extractTo($this->destination)) {
                $zip->close();
                throw new Exception("Failed to Extract the Archive");
            }

            // close the stream
            $zip->close();

            // Persist if succeed
            // create a gallery entries in the datapase for the given archives
            $gallery = null;
            if ($this->galleryMetadata != null) {
                $gallery = Gallery::create([
                    'user_id' => $this->archive->user->id,
                    'archive_id' => $this->archive->id,
                    'title' => $this->galleryMetadata['title'],
                    'title_original' => $this->galleryMetadata['titleOriginal'],
                    'dir_path' => $this->galleryName,
                ]);
            } else {
                $gallery = Gallery::create([
                    'user_id' => $this->archive->user->id,
                    'archive_id' => $this->archive->id,
                    // use archive filename as gallery title
                    // replace all "_" found in to an empy space for the title
                    'title' => str_replace("_", " ", pathinfo($this->archive->original_filename, PATHINFO_FILENAME)),
                    'dir_path' => $this->galleryName,
                ]);
            }

            // add the archive id to the gallery
            $this->archive->isProcess = true;
            $this->archive->save();

            // sanitised the item so only image remain
            for ($i = 0; $i < count($pageNames); $i++) {
                $pageName = $pageNames[$i];
                $path = public_path('/assets/galleries/') . $gallery->dir_path . '/' . $pageName;
                $isAccepted = false;

                foreach (AppServiceProvider::ACCEPTABLE_TYPE as $type) {
                    if ($type == mime_content_type($path)) {
                        $isAccepted = true;
                    }
                }

                if (!$isAccepted) {
                    array_splice($pageNames, $i, 1);
                    Storage::disk('gallery')->delete($path);
                }
            }

            // sort the array from small to big by filename
            sort($pageNames, SORT_NATURAL | SORT_FLAG_CASE);

            // create the pages entries in the datapase for the given for the gallery
            for ($i = 0; $i < count($pageNames); $i++) {
                Page::create([
                    'gallery_id' => $gallery->id,
                    'filename' => $pageNames[$i],
                    'page_number' => $i + 1,
                ]);
            }

            $this->finish($gallery);
        } else {
            throw new Exception("Failed to open the Archive ID: " . $this->archive->id);
        }
    }

    /**
     * Call this method when the job is finish
     *
     * @param App\Models\Gallery $gallery
     *
     *
     * @return void
     */
    public function finish(Gallery $gallery)
    {
        CreateThumbnailsForPages::dispatch($gallery);
    }
}
