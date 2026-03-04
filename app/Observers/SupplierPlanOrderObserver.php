<?php

namespace App\Observers;

use App\Models\Supplier\SupplierPlanOrder;
use App\Services\Users\Suppliers\TelegramService;

class SupplierPlanOrderObserver
{
    public function created(SupplierPlanOrder $order)
    {
        if (
            !in_array($order->payment_method, ['wallet', 'chargily', null])
            && $order->status === 'pending'
        ) {
            $telegram = app(TelegramService::class);

            $message = "
💰 <b>طلب اشتراك مورد يحتاج موافقة</b>

🏢 المورد: {$order->supplier->full_name}
💵 المبلغ: {($order->price - $order->discount)}
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
