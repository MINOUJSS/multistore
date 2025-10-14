<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchTelegramUpdates extends Command
{
    protected $signature = 'telegram:fetch-updates';
    protected $description = 'Fetch Telegram updates and process /start commands';

    public function handle()
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $lastUpdateId = cache('last_telegram_update_id', 0);

        $response = Http::get("https://api.telegram.org/bot{$token}/getUpdates", [
            'offset' => $lastUpdateId + 1,
            'timeout' => 30,
        ]);

        if (!$response->successful()) {
            Log::error('Failed to fetch Telegram updates', ['response' => $response->body()]);
            return;
        }

        $updates = $response->json()['result'] ?? [];

        foreach ($updates as $update) {
            $this->processUpdate($update);
            $lastUpdateId = $update['update_id'];
        }

        cache(['last_telegram_update_id' => $lastUpdateId]);
    }

    protected function processUpdate(array $update)
    {
        if (!isset($update['message']['text']) || $update['message']['text'] !== '/start') {
            return;
        }

        $message = $update['message'];
        $chatId = $message['chat']['id'];
        $userId = $message['from']['id'];
        $username = $message['from']['username'] ?? null;
        $firstName = $message['from']['first_name'] ?? '';

        // // البحث عن المورد باستخدام اسم المستخدم أو أي معرف آخر
        // $supplier = DB::table('suppliers')
        //     ->where('telegram_username', $username)
        //     ->first();

        // if (!$supplier) {
        //     $this->sendMessage($chatId, "⚠️ لم يتم العثور على حساب مورد مرتبط بهذا الحساب في نظامنا");
        //     return;
        // }

        // // تحديث chat_id في قاعدة البيانات
        // DB::table('suppliers')
        //     ->where('id', $supplier->id)
        //     ->update(['telegram_chat_id' => $chatId]);

        // إرسال رسالة التأكيد
        $response = "✅ تم تفعيل البوت بنجاح!\n\n";
        $response .= "🔹 <b>Chat ID الخاص بك هو:</b> <code>{$chatId}</code>\n";
        $response .= "🔹 سيتم إرسال إشعارات الطلبات هنا تلقائيًا";

        $this->sendMessage($chatId, $response);

        $this->info("Processed /start from: {$firstName} (Chat ID: {$chatId})");
    }

    protected function sendMessage($chatId, $text)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        
        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ]);
    }
}
