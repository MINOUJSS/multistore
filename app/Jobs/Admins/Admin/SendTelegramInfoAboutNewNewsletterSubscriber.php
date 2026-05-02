<?php

namespace App\Jobs\Admins\Admin;

use App\Services\Users\Suppliers\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTelegramInfoAboutNewNewsletterSubscriber implements ShouldQueue
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
        $message = '<b>اشتراك جديد في النشرة البريدية</b> \n';
        foreach ($this->data as $key => $value) {
            $message .= "<b>{$key}:</b> {$value}\n";
        }
        $telegramservice->sendMessage(env('ADMIN_CHAT_ID'), $message);
    }
}
