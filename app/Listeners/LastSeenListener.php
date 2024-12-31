<?php

namespace App\Listeners;

use App\Models\LastSeen;
use App\Events\UserLogedInEvent;
use Illuminate\Support\Facades\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LastSeenListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLogedInEvent $event): void
    {
        $ip_address = request()->server('REMOTE_ADDR');
        //
        LastSeen::create([
            'user_id' => $event->user->id,
            'ip_address' => $ip_address,
            'device' => Request::header('User-Agent'),
            'browser' => Request::header('User-Agent'),
            'last_seen_at' => now(),
        ]);
    }
}
