<?php

namespace App\Providers;

use App\Events\CreateSellerEvent;
use App\Events\CreateSupplierEvent;
use App\Events\UserLogedInEvent;
use App\Listeners\CreateDefaultContentForSellerListener;
use App\Listeners\CteateDefaultContentForSupplierListener;
use App\Listeners\LastSeenListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserLogedInEvent::class => [
            LastSeenListener::class,
        ],
        CreateSupplierEvent::class => [
            CteateDefaultContentForSupplierListener::class,
        ],
        CreateSellerEvent::class => [
            CreateDefaultContentForSellerListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
