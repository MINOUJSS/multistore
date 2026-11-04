<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AiAgents\ManagerAgent;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramAiChatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:telegram-chat 
                            {--listen : Run as a continuous real-time listening worker}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'التحاور المباشر والتحكم في مدير الوكلاء (ManagerAgent) عبر تطبيق تيليغرام واستقبال الأوامر في الوقت الفعلي';

    protected string $token;
    protected string $adminChatId;

    public function __construct()
    {
        parent::__construct();
        $this->token = config('telegram.bot_token') ?: (string) env('TELEGRAM_BOT_TOKEN');
        $this->adminChatId = (string) (config('telegram.admin_chat_id') ?: env('ADMIN_CHAT_ID'));
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (empty($this->token)) {
            $this->error("❌ خطأ: TELEGRAM_BOT_TOKEN غير معرّف في ملف .env.");
            return Command::FAILURE;
        }

        if (empty($this->adminChatId)) {
            $this->error("❌ خطأ: ADMIN_CHAT_ID غير معرّف في ملف .env.");
            return Command::FAILURE;
        }

        $isListenMode = (bool) $this->option('listen');

        if ($isListenMode) {
            $this->info("🤖 بدء وضع الاستماع الحي المباشر (Real-time Listening Worker)...");
            $this->line("📡 البوت متصل الآن بـ ManagerAgent ويستمع للرسائل الواردة من حساب الأدمن: {$this->adminChatId}");
            $this->comment("اضغط Ctrl+C لإيقاف الاستماع في أي وقت.\n");

            while (true) {
                $this->pollUpdates();
                sleep(2); // استطلاع سريع كل ثانيتين للرد الفوري
            }
        } else {
            // وضع التشغيل المفرد (المجدول عبر Laravel Schedule)
            $this->pollUpdates();
            return Command::SUCCESS;
        }

        return Command::SUCCESS;
    }

    /**
     * جلب التحديثات ومعالجة الرسائل
     */
    protected function pollUpdates(): void
    {
        $lastUpdateId = cache('last_telegram_ai_update_id', 0);
        $isFirstRun = !cache()->has('last_telegram_ai_update_id');

        try {
            $response = Http::timeout(8)->get("https://api.telegram.org/bot{$this->token}/getUpdates", [
                'offset' => $lastUpdateId + 1,
                'timeout' => 5,
                'limit' => 10,
            ]);

            if (!$response->successful()) {
                return;
            }

            $updates = $response->json('result') ?? [];
            if (empty($updates)) {
                return;
            }

            foreach ($updates as $update) {
                $updateId = $update['update_id'];

                // إذا كان التشغيل الأول، نتجاهل الرسائل القديمة التي مر عليها أكثر من دقيقتين
                $messageDate = $update['message']['date'] ?? 0;
                if ($isFirstRun && (time() - $messageDate > 180)) {
                    $lastUpdateId = $updateId;
                    continue;
                }

                $this->processMessageUpdate($update);
                $lastUpdateId = $updateId;
            }

            cache(['last_telegram_ai_update_id' => $lastUpdateId], now()->addDays(7));

        } catch (\Throwable $e) {
            Log::error("TelegramAiChat polling error: " . $e->getMessage());
        }
    }

    /**
     * معالجة الرسالة الفردية والتحقق من الأدمن
     */
    protected function processMessageUpdate(array $update): void
    {
        if (!isset($update['message']['text'])) {
            return;
        }

        $message = $update['message'];
        $senderChatId = (string) ($message['chat']['id'] ?? '');
        $text = trim($message['text'] ?? '');
        $senderName = $message['from']['first_name'] ?? 'Admin';

        // 🛡️ حماية صارمة: الاستجابة حصراً للأدمن المصرح له
        if ($senderChatId !== $this->adminChatId) {
            $this->warn("⚠️ محاولة اتصال غير مصرح بها من Chat ID: {$senderChatId}");
            return;
        }

        $this->info("💬 رسالة واردة من {$senderName}: \"{$text}\"");

        // 1. أمر البداية أو المساعدة
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

            $this->sendToTelegram($senderChatId, $welcome);
            return;
        }

        // 2. إرسال مؤشر "جاري الكتابة..." في تيليغرام
        $this->sendChatAction($senderChatId, 'typing');

        try {
            // تهيئة مدير الوكلاء بجلسة محادثة مستمرة تحفظ السياق
            $sessionKey = 'telegram_chat_' . $senderChatId;
            $manager = new ManagerAgent($sessionKey);

            $this->line("⏳ ManagerAgent يقوم بالتحليل والتفويض...");
            $reply = (string) $manager->respond($text);

            $this->info("✅ تم الحصول على رد المدير، جاري الإرسال...");
            $this->sendToTelegram($senderChatId, $reply);

        } catch (\Throwable $e) {
            $this->error("❌ خطأ أثناء معالجة رسالة الذكاء الاصطناعي: " . $e->getMessage());
            $this->sendToTelegram($senderChatId, "⚠️ عذراً، حدث خطأ أثناء معالجة طلبك: " . $e->getMessage());
        }
    }

    /**
     * إرسال رسالة إلى تيليغرام مع تجزئتها بأمان
     */
    protected function sendToTelegram(string $chatId, string $text): void
    {
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
            $this->dispatchTelegramMessage($chatId, $chunk);
            usleep(250000);
        }
    }

    /**
     * تنفيذ طلب إرسال الرسالة مع دعم التراجع الآمن عن HTML
     */
    protected function dispatchTelegramMessage(string $chatId, string $message): void
    {
        try {
            $response = Http::timeout(8)->post("https://api.telegram.org/bot{$this->token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            // إذا فشل تيليغرام في تفكيك وسم HTML، نعيد الإرسال كنص عادي
            if (!$response->successful()) {
                Http::timeout(8)->post("https://api.telegram.org/bot{$this->token}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => strip_tags($message),
                ]);
            }
        } catch (\Throwable $e) {
            try {
                Http::timeout(8)->post("https://api.telegram.org/bot{$this->token}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => strip_tags($message),
                ]);
            } catch (\Throwable $e2) {
                Log::error("Failed to send telegram message: " . $e2->getMessage());
            }
        }
    }

    /**
     * إرسال حالة التفاعل (typing)
     */
    protected function sendChatAction(string $chatId, string $action = 'typing'): void
    {
        try {
            Http::timeout(3)->post("https://api.telegram.org/bot{$this->token}/sendChatAction", [
                'chat_id' => $chatId,
                'action' => $action,
            ]);
        } catch (\Throwable $e) {
            // تجاهل
        }
    }
}

