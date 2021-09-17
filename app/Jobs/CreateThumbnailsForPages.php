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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pages = $this->gallery->pages;
        $width = 640; // the witdh that will be use to ratio in the image height (in px)

        if (isset($pages)){
            foreach ($pages as $page) {
                $filePath = public_path('/assets/galleries/') . $this->gallery->dir_path . '/' . $page->filename; // page image full path
                $destination = public_path('/assets/thumbnails/') . $this->gallery->dir_path; // full path for save location

                $img = Image::make($filePath);
                if (!$img->width() <= $width){
                    $ratio = $width / $img->width(); // get the ratio for the width
                } else {
                    $ratio = 1;
                }

                $height = $img->height() * $ratio; // get the final width after adjusted by the ratio
                $img->resize($width, $height)->save($destination . $img->filename, 100, 'jpg');
                $page->thumbnail = $img->filename . '.' . $img->extension;
                $page->save();
            }
            // set 1st page as gallery thumbnail
            $this->gallery->thumbnail = $page[0]->thumbnail;
            $this->gallery->save();
        } else {
            throw new Exception("Gallery ". $this->gallery->id . " don't yet have pages");
        }
    }
}
