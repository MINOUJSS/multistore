<?php

namespace App\Services\Users\Sellers;

class Seller_TelegramChatBotService
{
    protected $telegramService;

    public function __construct(Seller_TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function getChatId()
    {
        $updates = json_decode($this->telegramService->getUpdates())->result;

        return $updates[0]->message->chat->id;
    }

    public function handleWebhook()
    {
        try {
            Log::info('Incoming webhook data:', request()->all());

            // $update = Telegram::commandsHandler(true);
            $update = Telegram::getWebhookUpdates();
            Log::debug('Telegram Update:', $update->toArray());

            // طريقة أفضل للتحقق من وجود رسالة
            if (!isset($update['message'])) {
                Log::info('Update does not contain a message');

                return 'ok';
            }

            $message = $update->getMessage();
            $chatId = $message->getChat()->getId();
            $text = trim($message->getText() ?? '');

            Log::info("Processing message from chat $chatId: $text");

            if ($text === '/start') {
                $response = "✅ تم تفعيل البوت بنجاح!\n\n";
                $response .= "🔹 <b>Chat ID الخاص بك هو:</b> <code>{$chatId}</code>\n";
                $response .= '🔹 سيتم إرسال إشعارات الطلبات هنا تلقائيًا';
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => $response,
                    'parse_mode' => 'HTML',
                ]);

                Log::info("Responded to /start command for chat $chatId");
            }
        } catch (\Throwable $e) {
            Log::error('Webhook processing failed: '.$e->getMessage(), [
                'exception' => $e->getTraceAsString(),
            ]);
        }

        return 'ok';
    }
}
