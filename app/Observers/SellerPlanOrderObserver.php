<?php

namespace App\Observers;

use App\Models\Seller\SellerPlanOrder;
use App\Services\Users\Suppliers\TelegramService;

class SellerPlanOrderObserver
{
    public function created(SellerPlanOrder $order)
    {
        if (
            !in_array($order->payment_method, ['wallet', 'chargily'], true)
            && $order->status === 'pending'
        ) {
            $telegram = app(TelegramService::class);

            $amount = $order->price - ($order->discount ?? 0);

            $link = route('admin.payments.sellers.subscribes_payments');

            $message = "
        💰 <b>طلب اشتراك تاجر ربما يحتاج موافقة</b>

        🏢 المورد: {$order->seller->full_name}
        💵 المبلغ: {$amount}
        💳 الرابط: {$link}
        🕒 الوقت: {$order->created_at->format('Y-m-d H:i')}
        ";

            $telegram->sendMessage(
                env('ADMIN_CHAT_ID'),
                trim($message)
            );
        }
    }
}
