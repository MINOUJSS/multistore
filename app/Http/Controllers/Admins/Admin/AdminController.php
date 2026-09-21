<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    // index
    public function index()
    {
        $users = User::all();
        $suppliers = User::where('type', 'supplier')->get();
        $sellers = User::where('type', 'seller')->get();
        $marketers = User::where('type', 'marketer')->get();

        // Calculate active subscribers statistics based on last_seens table (last 30 days)
        $activeDays = request()->get('active_days', 30);
        $activeThreshold = now()->subDays((int) $activeDays);

        $calculateActivity = function ($query = null) use ($activeThreshold) {
            $baseQuery = $query ? clone $query : User::query();
            $total = (clone $baseQuery)->count();
            $active = (clone $baseQuery)->whereHas('last_seen', function ($q) use ($activeThreshold) {
                $q->where('last_seen_at', '>=', $activeThreshold);
            })->count();
            $percentage = $total > 0 ? round(($active / $total) * 100, 1) : 0;

            return [
                'total' => $total,
                'active' => $active,
                'inactive' => max(0, $total - $active),
                'percentage' => $percentage,
            ];
        };

        $activityStats = [
            'all' => $calculateActivity(),
            'suppliers' => $calculateActivity(User::where('type', 'supplier')),
            'sellers' => $calculateActivity(User::where('type', 'seller')),
            'marketers' => $calculateActivity(User::where('type', 'marketer')),
            'period_days' => $activeDays,
        ];

        return view('admins.admin.dashboard.index', compact('users', 'suppliers', 'sellers', 'marketers', 'activityStats'));
    }
}
