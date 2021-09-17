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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RarArchive;


class ProcessUploadedRarArchive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // uploaded archive to be process into gallery and pages
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
        // $this->onQueue('ProcessUploadArchives'); // optional
    }

    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        $archiveName = $this->archive->filename . '.' . $this->archive->archive_type;
        $archiveFilePath = realpath(public_path('assets/archives') . "/" . $archiveName);

        // metas for gallery
        $pageNames = [];

        $rar = RarArchive::open($archiveFilePath);

        if ($rar !== false) {
            $entries = $rar->getEntries();
            usort($entries, function($a, $b) {
                return $a->getName() <=> $b->getName();
            });

            // loop to extract the file
            for ($i = 0; $i < count($entries); $i++) {
                $entry = $entries[$i];
                // check if the rar entry is not a directory
                if (!$entry->isDirectory()) {
                    $pageNames[$i] = $entry->getName();
                    if (!$entry->extract($this->destination)) {
                        $rar->close();
                        throw new Exception("Failed to Extract Archive ID: " . $this->archive->id);
                    }
                }
            }
            $rar->close();

            // Persist if succeed
            // create a gallery entries in the datapase for the given archives
            $gallery = Gallery::create([
                'user_id' => $this->uploader->id,
                'title' => $this->galleryMetadata['title'],
                'title_original' => $this->galleryMetadata['titleOriginal'],
                'dir_path' => $this->galleryName,
            ]);

            // add the gallery id to the parent archive
            $this->archive->gallery_id = $gallery->id;
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

            $this->finish($gallery);
        } else {
            throw new Exception("Failed to open the Archive ID: " . $this->archive->id);
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
    public function finish(Gallery $gallery)
    {
        CreateThumbnailsForPages::dispatch($gallery);
    }
}
