<?php

namespace App\Jobs;

use App\Models\Archive;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessUploadedZipArchive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
/ uploaded archive to be process into gallery and pages
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
        $archiveName = $this->archive->filename . '.' . $this->archive->archive_type;
        $archiveFilePath = realpath(public_path('assets/archives') . "/" . $archiveName);

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

            // extra all pages into the destination
            if (!$zip->extractTo($destination)) {
                $zip->close();
                throw new Exception("Failed to Extract the Archive");
            }

            // close the stream
            $zip->close();

            // Persist if succeed
            // create a gallery entries in the datapase for the given archives
            $gallery = Gallery::create([
                'user_id' => $this->uploader->id,
                'title' => $this->galleryMetadata['title'],
                'title_original' => $this->galleryMetadata['titleOriginal'],
                'dir_path' => $this->galleryName,
            ]);

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
        CreateThumbnailsForPages::dispatch($gallery)->chain([
            function ($archive, $gallery) {
                // add the gallery id to the parent archive
                $archive->gallery_id = $gallery->id;
                $archive->isProcess = true;
                $archive->save();
            },
        ]);
    }
}
