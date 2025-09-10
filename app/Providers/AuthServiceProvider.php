<?php

namespace App\Providers;

use App\Models\Website;
use App\Models\Page;
use App\Models\MediaFile;
use App\Policies\WebsitePolicy;
use App\Policies\PagePolicy;
use App\Policies\MediaFilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Website::class => WebsitePolicy::class,
        Page::class => PagePolicy::class,
        MediaFile::class => MediaFilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
