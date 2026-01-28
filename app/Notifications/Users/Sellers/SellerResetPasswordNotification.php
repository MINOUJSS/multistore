<?php

namespace App\Notifications\Users\Sellers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class SellerResetPasswordNotification extends ResetPassword
{
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('إعادة تعيين كلمة المرور')
            ->line('اضغط على الزر أدناه لإعادة تعيين كلمة المرور')
            ->action(
                'إعادة تعيين كلمة المرور',
                route('seller.password.reset', $this->token)
            )
            ->line('إذا لم تطلب إعادة تعيين كلمة المرور، تجاهل هذه الرسالة.');
    }
}
