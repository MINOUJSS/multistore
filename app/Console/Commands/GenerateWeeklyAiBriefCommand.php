<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AiAgents\ManagerAgent;
use App\Services\Users\Suppliers\TelegramService;
use Illuminate\Support\Facades\Log;

class GenerateWeeklyAiBriefCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:weekly-brief 
                            {--telegram : Send the brief directly to Admin via Telegram}
                            {--chat-id= : Custom Telegram Chat ID to override default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تشغيل فريق وكلاء الذكاء الاصطناعي أسبوعياً لجمع ابتكارات الباك إند والفرونت إند والمنافسين وإرسال التقرير التنفيذي عبر تيليغرام';

    /**
     * Execute the console command.
     */
    public function handle(TelegramService $telegramService): int
    {
        $this->info("🤖 جاري بدء جلسة التقرير الأسبوعي لفريق وكلاء الذكاء الاصطناعي (dzora.net)...");

        $prompt = <<<PROMPT
أنت القائد التقني (Tech Lead) ومدير فريق الوكلاء لمنصة dzora.net.
حان الآن موعد "الاجتماع الأسبوعي لابتكارات المنصة واستخبارات السوق".

المطلوب منك إدارة الاجتماع وإصدار التقرير الأسبوعي عبر الخطوات التالية:
1. استشر وكيل مهندس الباك إند (BackendArchitectAgent) لمعرفة أحدث الابتكارات التقنية في بيئة Laravel و Multi-Tenancy وحزم المنصة.
2. استشر وكيل الفرونت إند (FrontendAgent) لمعرفة أحدث تريندات تصميم واجهات المتاجر ومكونات Blade و Tailwind CSS.
3. استشر وكيل المنافسين (CompetitorAgent) لمعرفة أبرز تحركات السوق والتجارة الإلكترونية في الجزائر واقتراح ميزة تنافسية نوعية لزيادة المبيعات وخفض الروتور.
4. استشر وكيل الأمان وموثوقية النظام للتأكد من استقرار المنصة.

قم بصياغة "التقرير الأسبوعي الشامل للابتكار والنمو (Weekly AI Executive Brief)" بصيغة منسقة وموجزة وجذابة تتضمن:
- 🚀 أبرز ابتكارات الأسبوع المقترحة (الباك إند والفرونت إند).
- 📊 نبض السوق الجزائري والمنافسين (Yalidine, Chargily, COD).
- 🛡️ الحالة الفنية والأمنية للنظام.
- 🎯 التوصية الاستراتيجية الأولى للأسبوع القادم.
PROMPT;

        try {
            $this->comment("⏳ يقوم مدير الوكلاء بالتنسيق والتشاور مع الفريق المتخصص...");
            $manager = new ManagerAgent('weekly_cron_' . date('Y_W'));
            $report = (string) $manager->respond($prompt);

            $this->info("✅ تم إعداد التقرير الأسبوعي بنجاح من قبل مدير الوكلاء!");
            $this->line("\n" . str_repeat('=', 60));
            $this->line($report);
            $this->line(str_repeat('=', 60) . "\n");

            // الإرسال عبر تيليغرام
            $sendTelegram = $this->option('telegram');
            $customChatId = $this->option('chat-id');
            $chatId = $customChatId ?: (config('telegram.admin_chat_id') ?: env('ADMIN_CHAT_ID'));

            if ($sendTelegram || !empty($customChatId)) {
                if (empty($chatId)) {
                    $this->warn("⚠️ لم يتم تحديد ADMIN_CHAT_ID في ملف .env أو إعدادات telegram.php، تم تخطي الإرسال.");
                } else {
                    $this->info("📲 جاري إرسال التقرير الأسبوعي إلى تيليغرام (Chat ID: {$chatId})...");
                    $this->sendTelegramInChunks($telegramService, $chatId, $report);
                    $this->info("🎉 تم إرسال التقرير الأسبوعي بنجاح إلى حساب التيليغرام!");
                }
            }

            Log::info("Weekly AI Brief generated successfully.", [
                'week' => date('Y-W'),
                'telegram_sent' => (bool)$sendTelegram,
            ]);

            return Command::SUCCESS;

        } catch (\Throwable $e) {
            $this->error("❌ حدث خطأ أثناء إعداد التقرير الأسبوعي: " . $e->getMessage());
            Log::error("Weekly AI Brief Failed: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return Command::FAILURE;
        }
    }

    /**
     * إرسال التقرير مجزءاً لضمان عدم تجاوز حد رسائل تيليغرام (4096 حرف).
     */
    protected function sendTelegramInChunks(TelegramService $telegramService, string $chatId, string $text): void
    {
        $header = "📢 <b>التقرير الأسبوعي الذكي لمنصة dzora.net</b>\n" .
                  "📅 الأسبوع: " . date('Y/W') . " | " . now()->format('Y-m-d') . "\n\n";

        $fullMessage = $header . $text;

        // تيليغرام يقبل حد أقصى 4096 حرفاً، نقتطع كل 3800 حرف بأمان
        $maxChunkSize = 3800;

        if (mb_strlen($fullMessage) <= $maxChunkSize) {
            $telegramService->sendMessage($chatId, $fullMessage);
            return;
        }

        // تجزئة الرسالة في حال كانت طويلة
        $chunks = [];
        $sections = explode("\n\n", $fullMessage);
        $currentChunk = '';

        foreach ($sections as $section) {
            if (mb_strlen($currentChunk . "\n\n" . $section) > $maxChunkSize) {
                if (!empty($currentChunk)) {
                    $chunks[] = $currentChunk;
                }
                $currentChunk = $section;
            } else {
                $currentChunk .= (empty($currentChunk) ? '' : "\n\n") . $section;
            }
        }
        if (!empty($currentChunk)) {
            $chunks[] = $currentChunk;
        }

        $totalParts = count($chunks);
        foreach ($chunks as $index => $chunk) {
            $partNum = $index + 1;
            $prefix = $totalParts > 1 ? "<b>[الجزء {$partNum}/{$totalParts}]</b>\n\n" : "";
            $telegramService->sendMessage($chatId, $prefix . $chunk);
            usleep(300000); // 300ms pause between chunks to respect Telegram rate limits
        }
    }
}

