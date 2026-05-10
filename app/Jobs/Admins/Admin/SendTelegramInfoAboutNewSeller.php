<?php

namespace App\Jobs\Admins\Admin;

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
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $telegramservice = new TelegramService();
        $message = "🆕 <b>تم تسجيل بائع جديد</b>\n\n";

        $message .= "👤 <b>الإسم:</b> {$this->data['full_name']}\n";

        $message .= "🏪 <b>إسم المتجر:</b> {$this->data['store_name']}\n";

        $message .= "📧 <b>البريد الإلكتروني:</b> {$this->data['email']}\n";

        $message .= "📦 <b>الخطة:</b> {$this->data['plan_name']}";

        $telegramservice->sendMessage(env('ADMIN_CHAT_ID'), $message);
    }
}
