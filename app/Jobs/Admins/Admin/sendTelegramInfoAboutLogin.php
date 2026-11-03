<?php

namespace App\Jobs\Admins\Admin;

use App\Services\Users\Suppliers\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendTelegramInfoAboutLogin implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $telegramservice = new TelegramService();
        $message = '<b>تم تسجيل الدخول إلى لوحة التحكم الأدمن</b>';
        $telegramservice->sendMessage(config('telegram.admin_chat_id'), $message);
    }
}
