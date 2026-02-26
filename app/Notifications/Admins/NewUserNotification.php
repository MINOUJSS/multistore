<?php

namespace App\Notifications\Admins;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Channels.
     */
    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Database notification.
     */
    public function toDatabase($notifiable): array
    {
        $data = $this->resolveUserData();
        $plan = $data['plan']; // ✅ استخرج plan من المصفوفة

        return [
            'title' => 'مشترك جديد',
            'message' => $data['label'],
            'user_id' => $this->user->id,
            'user_type' => $this->user->type,

            'plan' => $data['plan_name'],
            'price' => $plan?->price,
            'discount' => $plan?->discount,
            'duration' => $plan?->duration,
            'payment_method' => $plan?->payment_method,
            'payment_status' => $plan?->payment_status,
            'status' => $plan?->status,

            'url' => $data['url'],
            'created_at' => now(),
        ];
    }

    /**
     * Mail notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $data = $this->resolveUserData();

        return (new MailMessage())
            ->subject('مشترك جديد')
            ->greeting('مرحبًا،')
            ->line($data['label'])
            ->line('نوع المستخدم: '.$this->user->type)
            ->line('الخطة: '.$data['plan_name'])
            ->action('عرض التفاصيل', url($data['url']));
    }

    /**
     * Shared logic.
     */
    private function resolveUserData(): array
    {
        $plan = null;
        $planName = 'غير محدد';
        $url = '#';
        $label = 'تم تسجيل مستخدم جديد';

        if ($this->user->type === 'seller') {
            $seller = get_seller_data($this->user->tenant_id);
            $plan = $seller?->plan_subscription;
            $planName = $plan ? get_seller_plan_data($plan->plan_id)->name : 'غير محدد';
            $url = "/ah-admin/sellers/{$this->user->id}";
            $label = 'تم تسجيل بائع جديد';
        }

        if ($this->user->type === 'supplier') {
            $supplier = get_supplier_data($this->user->tenant_id);
            $plan = $supplier?->plan_subscription;
            $planName = $plan ? get_supplier_plan_data($plan->plan_id)->name : 'غير محدد';
            $url = "/ah-admin/suppliers/{$this->user->id}";
            $label = 'تم تسجيل مورد جديد';
        }

        return [
            'plan' => $plan,
            'plan_name' => $planName,
            'url' => $url,
            'label' => $label,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
        ];
    }
}
