<?php

namespace App\Jobs;

use App\Models\Gallery;
use App\Models\Page;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManagerStatic as Image;

class ResizeGalleryPage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $gallery = null;
    protected $pages = null;

    /**
    * The number of times the job may be attempted.
    *
    * @var int
    */
    public $tries = 3; // TODO: add to 3 tries and handle the clean up before retries

    /**
    * The maximum number of unhandled exceptions to allow before failing.
    *
    * @var int
    */
    public $maxExceptions = 1;

    /**
    * Create a new job instance.
    *
    * @param App\Models\Gallery $gallery
    * @return void
    */
    public function __construct(Gallery $gallery, Collection $pages)
    {
        $this->gallery = $gallery;
        $this->pages = $pages;
        $this->onConnection('database');
    }

    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        foreach ($this->pages as $page) {
            $filePath = public_path('/assets/galleries/' . $this->gallery->dir_path . '/' . $page->filename);
            $dirPath = pathinfo($filePath, PATHINFO_DIRNAME);
            $filename = pathinfo($filePath, PATHINFO_FILENAME);

            $img = Image::make($filePath)->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($dirPath . '/' . $filename, 100, 'PNG');
        }
    }
}
