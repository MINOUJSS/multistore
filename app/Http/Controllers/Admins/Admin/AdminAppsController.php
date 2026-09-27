<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserApps;
use Illuminate\Http\Request;

class AdminAppsController extends Controller
{
    /**
     * App definitions with metadata (labels, icons, colors).
     */
    protected array $supportedApps = [
        'facebook_pixel' => [
            'name' => 'بيكسل فيسبوك',
            'english_name' => 'Facebook Pixel',
            'icon' => 'fa-brands fa-facebook',
            'color' => '#1877f2',
            'bg_class' => 'bg-primary-subtle text-primary',
        ],
        'google_analytics' => [
            'name' => 'إحصائيات جوجل',
            'english_name' => 'Google Analytics',
            'icon' => 'fa-brands fa-google',
            'color' => '#ea4335',
            'bg_class' => 'bg-danger-subtle text-danger',
        ],
        'tiktok_pixel' => [
            'name' => 'بيكسل تيك توك',
            'english_name' => 'TikTok Pixel',
            'icon' => 'fa-brands fa-tiktok',
            'color' => '#000000',
            'bg_class' => 'bg-dark-subtle text-dark',
        ],
        'google_sheets' => [
            'name' => 'جداول بيانات جوجل',
            'english_name' => 'Google Sheets',
            'icon' => 'fa-solid fa-file-excel',
            'color' => '#0f9d58',
            'bg_class' => 'bg-success-subtle text-success',
        ],
        'telegram_notifications' => [
            'name' => 'إشعارات تيليجرام',
            'english_name' => 'Telegram Notifications',
            'icon' => 'fa-brands fa-telegram',
            'color' => '#0088cc',
            'bg_class' => 'bg-info-subtle text-info',
        ],
        'clarity' => [
            'name' => 'مايكروسوفت كلاريتي',
            'english_name' => 'Microsoft Clarity',
            'icon' => 'fa-solid fa-chart-line',
            'color' => '#ff5722',
            'bg_class' => 'bg-warning-subtle text-warning',
        ],
    ];

    /**
     * Display statistics and listing of user applications.
     */
    public function index(Request $request)
    {
        // 1. Overall KPIs Summary
        $totalApps = UserApps::count();
        $activeApps = UserApps::where('status', 'active')->count();
        $inactiveApps = UserApps::where('status', 'inactive')->count();

        $sellerAppsCount = UserApps::whereHas('user', function ($q) {
            $q->where('type', 'seller');
        })->count();

        $supplierAppsCount = UserApps::whereHas('user', function ($q) {
            $q->where('type', 'supplier');
        })->count();

        $uniqueUsersCount = UserApps::distinct('user_id')->count('user_id');

        $summary = [
            'total_apps' => $totalApps,
            'active_apps' => $activeApps,
            'inactive_apps' => $inactiveApps,
            'seller_apps' => $sellerAppsCount,
            'supplier_apps' => $supplierAppsCount,
            'unique_users' => $uniqueUsersCount,
        ];

        // 2. Breakdown per App Name
        $appsDistribution = [];
        $registeredAppNames = UserApps::select('app_name')
            ->distinct()
            ->pluck('app_name')
            ->filter();

        // Merge supported app keys with any other found in database
        $allAppKeys = collect(array_keys($this->supportedApps))
            ->merge($registeredAppNames)
            ->unique();

        foreach ($allAppKeys as $appKey) {
            $meta = $this->supportedApps[$appKey] ?? [
                'name' => ucfirst(str_replace('_', ' ', $appKey)),
                'english_name' => ucfirst(str_replace('_', ' ', $appKey)),
                'icon' => 'fa-solid fa-cube',
                'color' => '#6b7280',
                'bg_class' => 'bg-secondary-subtle text-secondary',
            ];

            $total = UserApps::where('app_name', $appKey)->count();
            $active = UserApps::where('app_name', $appKey)->where('status', 'active')->count();
            $sellers = UserApps::where('app_name', $appKey)->whereHas('user', fn($q) => $q->where('type', 'seller'))->count();
            $suppliers = UserApps::where('app_name', $appKey)->whereHas('user', fn($q) => $q->where('type', 'supplier'))->count();

            $percentage = $totalApps > 0 ? round(($total / $totalApps) * 100, 1) : 0;

            $appsDistribution[$appKey] = array_merge($meta, [
                'key' => $appKey,
                'total' => $total,
                'active' => $active,
                'sellers' => $sellers,
                'suppliers' => $suppliers,
                'percentage' => $percentage,
            ]);
        }

        // 3. Filtered Query for the Table
        $filters = [
            'type' => $request->get('type', 'all'),
            'app_name' => $request->get('app_name', 'all'),
            'status' => $request->get('status', 'all'),
            'search' => $request->get('search'),
        ];

        $query = UserApps::with('user')->latest('id');

        if (!empty($filters['type']) && $filters['type'] !== 'all') {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('type', $filters['type']);
            });
        }

        if (!empty($filters['app_name']) && $filters['app_name'] !== 'all') {
            $query->where('app_name', $filters['app_name']);
        }

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $searchTerm = '%' . trim($filters['search']) . '%';
            $query->where(function ($sub) use ($searchTerm) {
                $sub->where('app_name', 'like', $searchTerm)
                    ->orWhereHas('user', function ($uq) use ($searchTerm) {
                        $uq->where('name', 'like', $searchTerm)
                           ->orWhere('store_name', 'like', $searchTerm)
                           ->orWhere('email', 'like', $searchTerm)
                           ->orWhere('phone', 'like', $searchTerm);
                    });
            });
        }

        $appsList = $query->paginate(15)->withQueryString();

        return view('admins.admin.apps.index', [
            'summary' => $summary,
            'appsDistribution' => $appsDistribution,
            'appsList' => $appsList,
            'supportedApps' => $this->supportedApps,
            'filters' => $filters,
        ]);
    }
}
