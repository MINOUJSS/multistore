<?php

namespace App\Notifications\Users\Sellers;

use App\Models\Seller\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerUnApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The seller instance.
     *
     * @var Seller
     */
    public $seller;

    /**
     * The rejection reason.
     *
     * @var string|null
     */
    public $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct(Seller $seller, ?string $reason = null)
    {
        $this->seller = $seller;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $recipientName = $this->seller->full_name ?? $notifiable->name ?? 'تاجرنا العزيز';

        $mail = (new MailMessage())
            ->subject('تحديث بشأن طلب توثيق حسابك التجاري')
            ->greeting('مرحباً ' . $recipientName . '،')
            ->line('نأسف لإبلاغك بأنه تم رفض أو إلغاء توثيق حسابك التجاري على المنصة.');

        if (!empty($this->reason)) {
            $mail->line('**سبب الرفض:** ' . $this->reason);
        }

        return $mail
            ->line('يرجى مراجعة الملاحظات أعلاه، وتحديث البيانات أو المستندات المطلوبة في ملفك الشخصي ثم إعادة تقديم طلب التوثيق.')
            ->action('الانتقال إلى الملف الشخصي', route('seller.profile'))
            ->line('شكرًا لتفهمك واستخدامك لمنصتنا!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'seller_id' => $this->seller->id,
            'reason' => $this->reason,
            'title' => 'تم رفض توثيق الحساب',
        ];
    }
}
