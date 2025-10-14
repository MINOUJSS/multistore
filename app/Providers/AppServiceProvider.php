<?php

namespace App\Providers;

use App\Services\Users\Suppliers\OrderNotificationService;
use App\Services\Users\Suppliers\TelegramService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TelegramService::class, function () {
            return new TelegramService();
        });

        $this->app->bind(OrderNotificationService::class, function ($app) {
            return new OrderNotificationService($app->make(TelegramService::class));
        });
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
