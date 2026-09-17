<?php

namespace App\Events;

use App\Models\Seller\Seller;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateSellerEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $seller;
    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct(Seller $seller, ?User $user = null)
    {
        $this->seller = $seller;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
