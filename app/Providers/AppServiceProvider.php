<?php

namespace App\Providers;

use App\Models\BalanceTransaction;
use App\Models\FinancialLedger;
use App\Models\Seller\SellerPlanOrder;
use App\Models\Supplier\SupplierPlanOrder;
use App\Observers\BalanceTransactionObserver;
use App\Observers\FinancialLedgerObserver;
use App\Observers\SellerPlanOrderObserver;
use App\Observers\SupplierPlanOrderObserver;
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
        FinancialLedger::observe(FinancialLedgerObserver::class);
        SellerPlanOrder::observe(SellerPlanOrderObserver::class);
        SupplierPlanOrder::observe(SupplierPlanOrderObserver::class);
        BalanceTransaction::observe(BalanceTransactionObserver::class);
    }
}
