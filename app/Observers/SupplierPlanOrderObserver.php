<?php

namespace App\Observers;

use App\Models\Supplier\SupplierPlanOrder;
use App\Services\Users\Suppliers\TelegramService;

class SupplierPlanOrderObserver
{
    public function created(SupplierPlanOrder $order)
    {
        if (
            !in_array($order->payment_method, ['wallet', 'chargily'], true)
            && $order->status === 'pending'
        ) {
            $telegram = app(TelegramService::class);

            $amount = $order->price - ($order->discount ?? 0);

            $link = route('admin.payments.suppliers.subscribes_payments');

            $message = "
        💰 <b>طلب اشتراك مورد ربما يحتاج موافقة</b>

        🏢 المورد: {$order->supplier->full_name}
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
