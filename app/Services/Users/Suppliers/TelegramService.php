<?php

namespace App\Services\Users\Suppliers;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected $botToken;
    protected $apiUrl;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}";
    }

    public function sendMessage($chatId, $message)
    {
        $response = Http::post("{$this->apiUrl}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ]);

        return $response->successful();
    }
    //get Updates
    public function getUpdates()
    {
        $response = Http::post("{$this->apiUrl}/getUpdates", [
            'offset' => 0,
            'timeout' => 30,
        ]);
        return $response;
    }
        //setWebhook
    public function setWebhook()
    {
        $url = 'https://018e-154-121-96-60.ngrok-free.app/test/api/webhook';
        //$response = Telegram::setWebhook(['url' => $url]);
        $response = Http::post("{$this->apiUrl}/setWebhook", [
            'url' => $url,
        ]);
        
        return $response ? 'تم إعداد الويب هوك بنجاح' : 'فشل الإعداد';
    }
}