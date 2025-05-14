<?php

namespace App\Notifications\Users\Suppliers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiredNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
        $url=explode(request()->server('REQUEST_SCHEME').'://',route('supplier.subscription'));
        $protocol=request()->server('REQUEST_SCHEME');
        $newurl="supplier.{$url[1]}";
        return (new MailMessage)
            ->subject('انتهاء الاشتراك الخاص بك')
            ->greeting('مرحبًا!')
            ->line('لقد انتهت مدة اشتراكك الحالي وتمت إعادتك تلقائيًا إلى الخطة المجانية.')
            ->action('عرض الخطط المتاحة',$newurl)
            ->line('شكرًا لاستخدامك منصتنا!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
