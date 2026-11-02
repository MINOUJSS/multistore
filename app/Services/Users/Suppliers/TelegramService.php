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
        $this->botToken = config('telegram.bot_token');
        $baseUrl = rtrim(config('telegram.api_url', 'https://api.telegram.org'), '/');
        $this->apiUrl = "{$baseUrl}/bot{$this->botToken}";
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

        // $telegram_link = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = Http::post(
            "https://api.telegram.org/bot{$token}/sendMessage",
            [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]
        );

        // Log::info('the telegrame request:', $telegram_link);

        Log::info('Telegram API response', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
        Log::info('TOKEN', [
            'token' => config('telegram.bot_token'),
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
