<?php

namespace App\Jobs\Admins\Admin;

use App\Models\User;
use App\Services\Users\Suppliers\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendTelegramInfoAboutRequestValidation implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Send Telegram Info About Request Validation');
        $telegramService = new TelegramService();

        $message = "🆕 <b>تم استلام طلب توثيق جديد</b>\n";
        $message .= "━━━━━━━━━━━━━━\n\n";

        $message .= "👤 <b>المستخدم:</b> {$this->user->name}\n";
        $message .= "📞 <b>الهاتف:</b> {$this->user->phone}\n";
        $message .= "🏪 <b>نوع العضوية:</b> {$this->user->type}\n";
        $message .= "📅 <b>تاريخ التسجيل:</b> {$this->user->created_at?->format('Y-m-d H:i')}\n\n";

        $message .= "🔎 <b>الحالة:</b> بانتظار المراجعة\n";
        $message .= "━━━━━━━━━━━━━━\n";
        $message .= '⚡ <i>يرجى مراجعة الوثائق واتخاذ القرار المناسب.</i>';
        if ($this->user->type == 'supplier') {
            $message .= "\n\n🔗 <b>رابط لوحة التحكم: ".route('admin.supplier.show', $this->user->id)."</b>\n";
        } else {
            $message .= "\n\n🔗 <b>رابط لوحة التحكم: ".route('admin.seller.show', $this->user->id)."</b>\n";
        }

        try {
            $telegramService->sendMessage(
                config('services.telegram.admin_chat_id'),
                $message
            );
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
