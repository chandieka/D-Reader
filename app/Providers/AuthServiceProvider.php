<?php

namespace App\Providers;

use App\Models\Archive;
use App\Models\Gallery;
use App\Models\User;
use App\Policies\ArchivePolicy;
use App\Policies\GalleryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Archive::class => ArchivePolicy::class,
        Gallery::class, GalleryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('process-archive', [ArchivePolicy::class, 'process']);
    }
}
