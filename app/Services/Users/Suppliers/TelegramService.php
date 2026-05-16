<?php

namespace App\Services\Users\Suppliers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        // $response = Http::post("{$this->apiUrl}/sendMessage", [
        //     'chat_id' => $chatId,
        //     'text' => $message,
        //     'parse_mode' => 'HTML',
        // ]);

        // return $response->successful();
        $token = $this->botToken;

        $response = Http::post(
            "https://api.telegram.org/bot{$token}/sendMessage",
            [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]
        );

        Log::info('Telegram API response', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return $response->json();
    }

    // get Updates
    public function getUpdates()
    {
        $response = Http::post("{$this->apiUrl}/getUpdates", [
            'offset' => 0,
            'timeout' => 30,
        ]);

        return $response;
    }

    // setWebhook
    public function setWebhook()
    {
        $url = config('app.url').'/test/api/webhook';
        // $response = Telegram::setWebhook(['url' => $url]);
        $response = Http::post("{$this->apiUrl}/setWebhook", [
            'url' => $url,
        ]);

        return $response ? 'تم إعداد الويب هوك بنجاح' : 'فشل الإعداد';
    }
}
