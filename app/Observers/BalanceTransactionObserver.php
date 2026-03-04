<?php

namespace App\Observers;

use App\Models\BalanceTransaction;
use App\Services\Users\Suppliers\TelegramService;

class BalanceTransactionObserver
{
    public function created(BalanceTransaction $transaction)
    {
        if ($transaction->status === 'pending') {
            $telegram = app(TelegramService::class);

            $message = "
💰 <b>طلب شحن رصيد يحتاج مراجعة</b>

👤 المستخدم: {$transaction->user->name}
💵 المبلغ: {$transaction->amount}
🕒 الوقت: {$transaction->created_at->format('Y-m-d H:i')}
";

            $telegram->sendMessage(
                env('ADMIN_CHAT_ID'),
                trim($message)
            );
        }
    }
}
