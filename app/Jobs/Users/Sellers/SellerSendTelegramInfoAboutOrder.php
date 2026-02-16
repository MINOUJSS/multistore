<?php

namespace App\Jobs\Users\Sellers;

use App\Models\Seller\SellerOrders;
use App\Services\Users\Suppliers\OrderNotificationService;
use App\Services\Users\Suppliers\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SellerSendTelegramInfoAboutOrder implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     */
    public function __construct(SellerOrders $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->notification = new OrderNotificationService(new TelegramService());
        $this->notification->sendOrderNotificationToSeller($this->order);
    }
}
