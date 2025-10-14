<?php

namespace App\Jobs\Users\Suppliers;

use Illuminate\Bus\Queueable;
use App\Models\Supplier\SupplierOrders;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Users\Suppliers\TelegramService;
use App\Services\Users\Suppliers\OrderNotificationService;

class sendTelegramInfoAboutOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    /**
     * Create a new job instance.
     */
    public function __construct(SupplierOrders $order)
    {
        //
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $this->notification = new OrderNotificationService(new TelegramService());
        $this->notification->sendOrderNotificationToSupplier($this->order);
    }
}
