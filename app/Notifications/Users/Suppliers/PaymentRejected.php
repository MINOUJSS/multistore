<?php

namespace App\Notifications\Users\Suppliers;

use Illuminate\Bus\Queueable;
use App\Models\Supplier\SupplierOrders;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentRejected extends Notification implements ShouldQueue
{
        use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(SupplierOrders $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        // يمكنك استخدام 'mail' أو 'database' أو 'broadcast'
        return ['database','mail']; // نبدأ بـ database ويمكنك توسيعها لاحقًا
    }

    /**
     * Get the array representation of the notification (for database).
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'رفض إثبات الدفع',
            'message' => "تم رفض إثبات الدفع للطلب رقم <a href='/admin/supplier/orders/{$this->order->id}'>#{$this->order->order_number}</a>.",
            'order_id' => $this->order->id,
            'customer_name' => $this->order->customer_name,
            'amount' => $this->order->total_price,
            'time' => now()->format('Y-m-d H:i'),
        ];
    }

    /**
     * يمكنك أيضًا تفعيل الإرسال عبر البريد في المستقبل:
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('رفض إثبات الدفع')
            ->greeting('مرحبًا،')
            ->line("تم رفض إثبات الدفع للطلب رقم #{$this->order->order_number}.")
            ->action('عرض الطلب', url("/admin/orders/{$this->order->id}"))
            ->line('يرجى مراجعة تفاصيل الطلب في أقرب وقت ممكن.');
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
