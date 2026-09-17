<?php

namespace App\Events;

use App\Models\Supplier\Supplier;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateSupplierEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $supplier;
    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct(Supplier $supplier, ?User $user = null)
    {
        $this->supplier = $supplier;
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
