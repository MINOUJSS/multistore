<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Http\Controllers\Controller;
use App\Services\Users\Suppliers\TelegramChatBotService;
use App\Services\Users\Suppliers\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    protected $telegramService;
    protected $telegramchatbotservice;

    public function __construct(TelegramService $telegramService, TelegramChatBotService $telegramchatbotservice)
    {
        $this->telegramService = $telegramService;
        $this->telegramchatbotservice = $telegramchatbotservice;
    }

    public function getSupplierChatId()
    {
        dd($this->telegramchatbotservice->getChatId());
    }

    // set webhook
    public function setWebhook()
    {
        $this->telegramService->setWebhook();

        return response()->json(['message' => 'تم إعداد الويب هوك بنجاح']);
    }

    // webhook
    public function webhook(Request $request)
    {
        try {
            Log::info('Incoming webhook data1:', $request->all());

            $update = request()->all();
            // $update = Telegram::getWebhookUpdates();
            Log::debug('Telegram Update:', $update);

            // طريقة أفضل للتحقق من وجود رسالة
            if (!isset($update['message'])) {
                Log::info('Update does not contain a message');

                return 'ok1';
            }

            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = trim($message['text'] ?? '');
            // $message = $update->getMessage();
            // $chatId = $message->getChat()->getId();
            // $text = trim($message->getText() ?? '');

            Log::info("Processing message from chat $chatId: $text");

            if ($text === '/start') {
                $response = "✅ تم تفعيل البوت بنجاح!\n\n";
                $response .= "🔹 <b>الشات أيدي الخاص بك هو:</b> <code>{$chatId}</code>\n";
                $response .= '🔹 سيتم إرسال إشعارات الطلبات هنا تلقائيًا';
                // send response
                $this->telegramService->sendMessage($chatId, $response);

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
