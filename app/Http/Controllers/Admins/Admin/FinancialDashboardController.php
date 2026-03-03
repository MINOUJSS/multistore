<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialLedger;

class FinancialDashboardController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();

        $totalIncome = FinancialLedger::where('type', 'income')->sum('amount');
        $totalExpense = FinancialLedger::where('type', 'expense')->sum('amount');

        $todayIncome = FinancialLedger::where('type', 'income')
            ->where('created_at', '>=', $today)
            ->sum('amount');

        $todayExpense = FinancialLedger::where('type', 'expense')
            ->where('created_at', '>=', $today)
            ->sum('amount');

        $transactionsCount = FinancialLedger::where('created_at', '>=', $today)->count();

        $latestTransactions = FinancialLedger::latest()
            ->limit(10)
            ->get();

        // بيانات الرسم البياني (آخر 7 أيام)
        $chartData = FinancialLedger::selectRaw("
                DATE(created_at) as date,
                SUM(CASE WHEN type='income' THEN amount ELSE 0 END) as income,
                SUM(CASE WHEN type='expense' THEN amount ELSE 0 END) as expense
            ")
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admins.admin.dashboard.financial', compact(
            'totalIncome',
            'totalExpense',
            'todayIncome',
            'todayExpense',
            'transactionsCount',
            'latestTransactions',
            'chartData'
        ));
    }
}
