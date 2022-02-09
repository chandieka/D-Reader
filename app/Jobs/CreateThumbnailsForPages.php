<?php

namespace App\Jobs;

use App\Models\Gallery;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;

class CreateThumbnailsForPages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $gallery;

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
    public function __construct(Gallery $gallery)
    {
        $this->gallery = $gallery;

        $this->onConnection('database');
        // $this->onQueue('ProcessPagesThumbnails'); // optional
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pages = $this->gallery->pages;
        $destination = public_path('assets/thumbnails/') . $this->gallery->dir_path; // full path for save location

        if (isset($pages) && !is_dir($destination)) {
            if (!is_dir($destination)) {
                mkdir($destination);
            }

            foreach ($pages as $page) {
                $width = 320; // the witdh that will be use to ratio in the image height (in px)
                $filePath = public_path('assets/galleries/') . $this->gallery->dir_path . '/' . $page->filename;

                $img = Image::make($filePath);

                if ($img->width() <= $width) {
                    $width = $img->width();
                }

                $img->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destination . '/' . $img->filename . '.jpg', 100, 'jpg');

                $page->thumbnail = $img->filename . '.' . $img->extension;
                $page->save();
            }

            $this->gallery->thumbnail = $pages[0]->thumbnail;
            $this->gallery->save();

            $this->finish($this->gallery);
        } else {
            throw new Exception("Gallery " . $this->gallery->id . " don't yet have pages");
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
        ResizeGalleryPage::dispatch($gallery, $gallery->pages);
    }
}
