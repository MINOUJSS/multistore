<?php

namespace App\Observers;

use App\Models\FinancialLedger;
use App\Services\Users\Suppliers\TelegramService;

class FinancialLedgerObserver
{
    public function created(FinancialLedger $ledger)
    {
        $telegram = app(TelegramService::class);

        $emoji = $ledger->type === 'income' ? '💰' : '💸';

        $message = "
{$emoji} <b>عملية مالية جديدة</b>

📌 النوع: {$ledger->type}
📂 التصنيف: {$ledger->category}
💵 المبلغ: {$ledger->amount} {$ledger->currency}
📝 ملاحظة: {$ledger->note}
🕒 الوقت: {$ledger->created_at->format('Y-m-d H:i')}
";

        $telegram->sendMessage(
            env('ADMIN_CHAT_ID'),
            trim($message)
        );
    }
}
