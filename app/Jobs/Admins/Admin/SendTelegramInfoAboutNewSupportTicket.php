<?php

namespace App\Jobs\Admins\Admin;

use App\Models\SupportTicket;
use App\Services\Users\Suppliers\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendTelegramInfoAboutNewSupportTicket implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $ticket;

    /**
     * Create a new job instance.
     */
    public function __construct(SupportTicket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $chatId = config('services.telegram.admin_chat_id') ?? env('ADMIN_CHAT_ID');
        if (!$chatId) {
            Log::warning('Telegram Admin Chat ID is not configured.');
            return;
        }

        $telegramService = new TelegramService();

        $priorityEmoji = match ($this->ticket->priority) {
            'urgent' => '🔴 عاجلة جداً',
            'high' => '🟠 مرتفعة',
            'medium' => '🟡 متوسطة',
            default => '🟢 منخفضة',
        };

        $userTypeLabel = match ($this->ticket->user_type) {
            'seller' => 'بائع',
            'supplier' => 'مورد',
            default => $this->ticket->user_type,
        };

        $message = "🎫 <b>تذكرة دعم فني جديدة</b>\n";
        $message .= "━━━━━━━━━━━━━━\n\n";
        $message .= "🔢 <b>رقم التذكرة:</b> <code>#{$this->ticket->ticket_number}</code>\n";
        $message .= "👤 <b>المرسل:</b> {$this->ticket->user_name} ({$userTypeLabel})\n";
        $message .= "📧 <b>البريد:</b> {$this->ticket->user_email}\n";
        if (!empty($this->ticket->user_phone)) {
            $message .= "📞 <b>الهاتف:</b> {$this->ticket->user_phone}\n";
        }
        $message .= "📂 <b>القسم:</b> {$this->ticket->category}\n";
        $message .= "⚡ <b>الأولوية:</b> {$priorityEmoji}\n";
        $message .= "📝 <b>الموضوع:</b> {$this->ticket->subject}\n\n";
        $cleanMessage = \Illuminate\Support\Str::limit(strip_tags($this->ticket->message), 250);
        $message .= "💬 <b>الرسالة:</b>\n<i>{$cleanMessage}</i>\n\n";
        $message .= "━━━━━━━━━━━━━━\n";
        $message .= "🔗 <b>رابط التذكرة للإدارة:</b>\n";
        $message .= route('admin.support_tickets.show', $this->ticket->id);

        try {
            $telegramService->sendMessage($chatId, $message);
        } catch (\Exception $e) {
            Log::error('Send Telegram Support Ticket Error: ' . $e->getMessage());
        }
    }
}
