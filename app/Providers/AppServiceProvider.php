<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tenancy\Affects\Filesystems\Events\ConfigureDisk;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paginator::useBootstrapFive();
        // Paginator::useBootstrapFour();
        // Paginator::defaultView('vendor.pagination.default');
 
        // Paginator::defaultSimpleView('vendor.pagination.simple-default');
    }
}
