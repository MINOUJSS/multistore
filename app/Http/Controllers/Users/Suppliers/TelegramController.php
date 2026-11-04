<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Http\Controllers\Controller;
use App\Services\Users\Suppliers\TelegramChatBotService;
use App\Services\Users\Suppliers\TelegramService;
use App\AiAgents\ManagerAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
            Log::debug('Telegram Update:', $update);

            if (!isset($update['message'])) {
                Log::info('Update does not contain a message');
                return 'ok1';
            }

            $message = $update['message'];
            $chatId = (string) ($message['chat']['id'] ?? '');
            $text = trim($message['text'] ?? '');
            $senderName = $message['from']['first_name'] ?? 'User';

            Log::info("Processing message from chat $chatId ($senderName): $text");

            if (empty($text)) {
                return 'ok';
            }

            $adminChatId = (string) (config('telegram.admin_chat_id') ?: env('ADMIN_CHAT_ID'));

            // 1. إذا كانت الرسالة واردة من الأدمن (مدير المنصة)
            if (!empty($adminChatId) && $chatId === $adminChatId) {
                if ($text === '/start' || $text === '/help') {
                    $welcome = "👋 <b>أهلاً بك يا {$senderName} في غرفة التحكم الذكية لمنصة dzora.net!</b>\n\n" .
                               "أنا <b>مدير فريق وكلاء الذكاء الاصطناعي (ManagerAgent)</b>، وتحت إمرتي 6 وكلاء متخصصين:\n" .
                               "⚙️ <b>الباك إند:</b> معمارية Laravel والـ Multi-Tenancy.\n" .
                               "🎨 <b>الفرونت إند:</b> تصميم مكونات Blade و Tailwind CSS و Alpine.js.\n" .
                               "📢 <b>التسويق:</b> صناعة المحتوى الإعلاني وإحصائيات المنصة.\n" .
                               "🔍 <b>أخطاء السيرفر:</b> فحص سجلات laravel.log وتشخيص الأعطال.\n" .
                               "🖥️ <b>أخطاء الواجهات:</b> تشخيص كونسول المتصفح وأعطال الـ JavaScript.\n" .
                               "🛡️ <b>الأمن السيبراني:</b> كشف ثغرات OWASP والترقيعات الدفاعية.\n" .
                               "📊 <b>المنافسين:</b> استخبارات السوق الجزائري (Yalidine, Dropify, YouCan).\n\n" .
                               "💡 <b>كيف تتحكم بي؟</b>\n" .
                               "يمكنك كتابة أي طلب أو سؤال وسأقوم فورياً بالتنسيق مع الوكيل المناسب وتزويدك بالنتيجة هنا!";

                    $this->sendToTelegramSafe($chatId, $welcome);
                    return 'ok';
                }

                // إرسال إشارة "جاري الكتابة..."
                $this->sendChatAction($chatId, 'typing');

                // تشغيل مدير الوكلاء وتمرير رسالة الأدمن
                $sessionKey = 'telegram_chat_' . $chatId;
                $manager = new ManagerAgent($sessionKey);
                $reply = (string) $manager->respond($text);

                // إرسال الرد المنسق مع التجزئة الآمنة
                $this->sendToTelegramSafe($chatId, $reply);

                Log::info("ManagerAgent successfully replied to admin chat $chatId");
                return 'ok';
            }

            // 2. إذا كانت الرسالة واردة من مورد أو مستخدم عادي (Supplier / Other)
            if ($text === '/start') {
                $response = "✅ تم تفعيل البوت بنجاح!\n\n";
                $response .= "🔹 <b>الشات أيدي الخاص بك هو:</b> <code>{$chatId}</code>\n";
                $response .= '🔹 سيتم إرسال إشعارات الطلبات هنا تلقائيًا';
                $this->telegramService->sendMessage($chatId, $response);

                Log::info("Responded to /start command for chat $chatId");
            }

        } catch (\Throwable $e) {
            Log::error('Webhook processing failed: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
            ]);

            // إشعار الأدمن في حال حدوث خطأ
            if (isset($chatId) && !empty($adminChatId) && $chatId === $adminChatId) {
                $this->sendToTelegramSafe($chatId, "⚠️ عذراً، واجهت مشكلة أثناء معالجة طلبك: " . $e->getMessage());
            }
        }

        return 'ok';
    }

    /**
     * إرسال رسائل آمنة إلى تيليغرام مع تجزئتها عند اللزوم والتراجع التلقائي
     */
    protected function sendToTelegramSafe(string $chatId, string $text): void
    {
        $token = config('telegram.bot_token') ?: (string) env('TELEGRAM_BOT_TOKEN');
        if (empty($token)) {
            return;
        }

        $maxChunk = 3800;
        $chunks = [];

        if (mb_strlen($text) <= $maxChunk) {
            $chunks[] = $text;
        } else {
            $sections = explode("\n\n", $text);
            $curr = '';
            foreach ($sections as $sec) {
                if (mb_strlen($curr . "\n\n" . $sec) > $maxChunk) {
                    if (!empty($curr)) {
                        $chunks[] = $curr;
                    }
                    $curr = $sec;
                } else {
                    $curr .= (empty($curr) ? '' : "\n\n") . $sec;
                }
            }
            if (!empty($curr)) {
                $chunks[] = $curr;
            }
        }

        foreach ($chunks as $chunk) {
            try {
                $response = Http::timeout(8)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $chunk,
                    'parse_mode' => 'HTML',
                ]);

                if (!$response->successful()) {
                    // التراجع إلى نص عادي دون وسوم إذا رفض تيليغرام الـ HTML
                    Http::timeout(8)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                        'chat_id' => $chatId,
                        'text' => strip_tags($chunk),
                    ]);
                }
            } catch (\Throwable $e) {
                try {
                    Http::timeout(8)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                        'chat_id' => $chatId,
                        'text' => strip_tags($chunk),
                    ]);
                } catch (\Throwable $e2) {
                    Log::error("Failed to send telegram message in webhook: " . $e2->getMessage());
                }
            }

            usleep(250000); // مهلة ربع ثانية بين الأجزاء
        }
    }

    /**
     * إرسال حالة التفاعل (typing)
     */
    protected function sendChatAction(string $chatId, string $action = 'typing'): void
    {
        $token = config('telegram.bot_token') ?: (string) env('TELEGRAM_BOT_TOKEN');
        if (empty($token)) {
            return;
        }

        try {
            Http::timeout(3)->post("https://api.telegram.org/bot{$token}/sendChatAction", [
                'chat_id' => $chatId,
                'action' => $action,
            ]);
        } catch (\Throwable $e) {
            // تجاهل
        }
    }
}
