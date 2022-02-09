<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public const ACCEPTABLE_TYPE = [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/gif',
        'image/bmp',
        'image/x-windows-bmp',
        'image/webp'
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
