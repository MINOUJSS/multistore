<?php

namespace App\Jobs\Admins\Admin;

use App\Models\Seller\Seller;
use App\Services\Users\Suppliers\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTelegramInfoAboutNewSeller implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public $seller;

    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $telegramservice = new TelegramService();
        $message = '<b>تم تسجيل بائع جديد جديد</b> \n\n';

        $telegramservice->sendMessage(env('ADMIN_CHAT_ID'), $message);
    }
}
