<?php

namespace App\Observers;

use App\Models\Seller\SellerPlanOrder;
use App\Services\Users\Suppliers\TelegramService;

class SellerPlanOrderObserver
{
    public function created(SellerPlanOrder $order)
    {
        if (
            !in_array($order->payment_method, ['wallet', 'chargily'])
            && $order->status === 'pending'
        ) {
            $telegram = app(TelegramService::class);

            $message = "
💰 <b>طلب اشتراك تاجر يحتاج موافقة</b>

👤 التاجر: {$order->seller->name}
💵 المبلغ: {$order->amount}
💳 طريقة الدفع: {$order->payment_method}
🕒 الوقت: {$order->created_at->format('Y-m-d H:i')}
";

            $telegram->sendMessage(
                env('ADMIN_CHAT_ID'),
                trim($message)
            );
        }
    }
}
