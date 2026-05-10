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
        $message = '<b>تم تسجيل بائع جديد جديد</b><br/>';
        $message .= '<b>الإسم : </b><span>'.$this->data['full_name'].'</span>';
        $message .= '<b>إسم المتجر : </b><span>'.$this->data['store_name'].'</span>';
        $message .= '<b>البريد الإلكتروني : </b><span>'.$this->data['email'].'</span>';
        $message .= '<b>الخطة(الباقة) : </b><span>'.$this->data['paln_name'].'</span>';

        $telegramservice->sendMessage(env('ADMIN_CHAT_ID'), $message);
    }
}
