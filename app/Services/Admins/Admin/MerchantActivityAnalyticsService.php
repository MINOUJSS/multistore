<?php

namespace App\Services\Admins\Admin;

use App\Models\LastSeen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MerchantActivityAnalyticsService
{
    /**
     * Get complete merchant activity analytics including timeline, devices, browsers, and connection points.
     */
    public function getAnalytics(string $type = 'seller'): array
    {
        return [
            'timeline' => $this->getTimelineActivity($type),
            'devices' => $this->getDeviceAndBrowserBreakdown($type),
            'locations' => $this->getLocationsAndIps($type),
            'kpis' => $this->getSummaryKpis($type),
        ];
    }

    /**
     * Get Daily, Monthly, and Yearly activity timelines.
     */
    public function getTimelineActivity(string $type = 'seller'): array
    {
        $userIdsQuery = User::where('type', $type)->select('id');

        // 1. Daily activity (Last 30 Days)
        $dailyLabels = [];
        $dailyData = [];
        $dailyUniqueMerchants = [];
        $startDate = now()->subDays(29)->startOfDay();
        $endDate = now()->endOfDay();

        $dailyStats = LastSeen::whereIn('user_id', $userIdsQuery)
            ->whereBetween('last_seen_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(last_seen_at) as date_key'),
                DB::raw('COUNT(*) as total_logins'),
                DB::raw('COUNT(DISTINCT user_id) as unique_users')
            )
            ->groupBy('date_key')
            ->pluck('total_logins', 'date_key')
            ->toArray();

        $dailyUniqueStats = LastSeen::whereIn('user_id', $userIdsQuery)
            ->whereBetween('last_seen_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(last_seen_at) as date_key'),
                DB::raw('COUNT(DISTINCT user_id) as unique_users')
            )
            ->groupBy('date_key')
            ->pluck('unique_users', 'date_key')
            ->toArray();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $formattedKey = $date->format('Y-m-d');
            $dailyLabels[] = $date->locale('ar')->translatedFormat('j M');
            $dailyData[] = $dailyStats[$formattedKey] ?? 0;
            $dailyUniqueMerchants[] = $dailyUniqueStats[$formattedKey] ?? 0;
        }

        // 2. Monthly activity (Last 12 Months)
        $monthlyLabels = [];
        $monthlyData = [];
        $startMonth = now()->subMonths(11)->startOfMonth();
        $endMonth = now()->endOfMonth();

        $monthlyStats = LastSeen::whereIn('user_id', $userIdsQuery)
            ->whereBetween('last_seen_at', [$startMonth, $endMonth])
            ->select(
                DB::raw('DATE_FORMAT(last_seen_at, "%Y-%m") as month_key'),
                DB::raw('COUNT(*) as total_logins')
            )
            ->groupBy('month_key')
            ->pluck('total_logins', 'month_key')
            ->toArray();

        for ($m = $startMonth->copy(); $m->lte($endMonth); $m->addMonth()) {
            $monthKey = $m->format('Y-m');
            $monthlyLabels[] = $m->locale('ar')->translatedFormat('F Y');
            $monthlyData[] = $monthlyStats[$monthKey] ?? 0;
        }

        // 3. Yearly activity (Last 5 Years)
        $yearlyLabels = [];
        $yearlyData = [];
        $currentYear = (int) now()->format('Y');
        $startYear = $currentYear - 4;

        $yearlyStats = LastSeen::whereIn('user_id', $userIdsQuery)
            ->whereYear('last_seen_at', '>=', $startYear)
            ->select(
                DB::raw('YEAR(last_seen_at) as year_key'),
                DB::raw('COUNT(*) as total_logins')
            )
            ->groupBy('year_key')
            ->pluck('total_logins', 'year_key')
            ->toArray();

        for ($yr = $startYear; $yr <= $currentYear; $yr++) {
            $yearlyLabels[] = (string) $yr;
            $yearlyData[] = $yearlyStats[$yr] ?? 0;
        }

        return [
            'daily' => [
                'labels' => $dailyLabels,
                'data' => $dailyData,
                'unique_merchants' => $dailyUniqueMerchants,
            ],
            'monthly' => [
                'labels' => $monthlyLabels,
                'data' => $monthlyData,
            ],
            'yearly' => [
                'labels' => $yearlyLabels,
                'data' => $yearlyData,
            ],
        ];
    }

    /**
     * Get Device Types, Operating Systems, and Browser breakdowns.
     */
    public function getDeviceAndBrowserBreakdown(string $type = 'seller'): array
    {
        $userIdsQuery = User::where('type', $type)->select('id');

        // Fetch recent last_seen records to parse User-Agents
        $records = LastSeen::whereIn('user_id', $userIdsQuery)
            ->latest('id')
            ->limit(2000)
            ->get(['device', 'browser']);

        $deviceCounts = [
            'Desktop' => 0,
            'Mobile' => 0,
            'Tablet' => 0,
        ];

        $platformCounts = [];
        $browserCounts = [];

        foreach ($records as $record) {
            $ua = $record->device ?? $record->browser ?? '';
            $parsed = $this->parseUserAgent($ua);

            $deviceCounts[$parsed['device_type']]++;

            $platform = $parsed['platform'];
            $platformCounts[$platform] = ($platformCounts[$platform] ?? 0) + 1;

            $browser = $parsed['browser'];
            $browserCounts[$browser] = ($browserCounts[$browser] ?? 0) + 1;
        }

        $total = $records->count() ?: 1;

        // Calculate device percentages
        $devicePercentages = [
            'Desktop' => round(($deviceCounts['Desktop'] / $total) * 100, 1),
            'Mobile' => round(($deviceCounts['Mobile'] / $total) * 100, 1),
            'Tablet' => round(($deviceCounts['Tablet'] / $total) * 100, 1),
        ];

        arsort($platformCounts);
        arsort($browserCounts);

        return [
            'total_analyzed' => $records->count(),
            'percentages' => $devicePercentages,
            'device_counts' => $deviceCounts,
            'devices' => [
                'labels' => ['حاسوب (Desktop)', 'هاتف ذكي (Mobile)', 'جهاز لوحي (Tablet)'],
                'counts' => array_values($deviceCounts),
                'percentages' => $devicePercentages,
            ],
            'platforms' => [
                'labels' => array_keys($platformCounts),
                'counts' => array_values($platformCounts),
            ],
            'browsers' => [
                'labels' => array_keys($browserCounts),
                'counts' => array_values($browserCounts),
            ],
        ];
    }

    /**
     * Get Top Connection IP addresses and Location details.
     */
    public function getLocationsAndIps(string $type = 'seller'): array
    {
        $userIdsQuery = User::where('type', $type)->select('id');

        $topIps = LastSeen::whereIn('user_id', $userIdsQuery)
            ->whereNotNull('ip_address')
            ->select(
                'ip_address',
                DB::raw('COUNT(*) as total_connections'),
                DB::raw('COUNT(DISTINCT user_id) as total_merchants'),
                DB::raw('MAX(last_seen_at) as last_activity'),
                DB::raw('MAX(device) as sample_device')
            )
            ->groupBy('ip_address')
            ->orderByDesc('total_connections')
            ->limit(8)
            ->get();

        $enrichedIps = $topIps->map(function ($row) {
            $parsed = $this->parseUserAgent($row->sample_device);
            return [
                'ip_address' => $row->ip_address,
                'location' => $this->analyzeIp($row->ip_address),
                'total_connections' => $row->total_connections,
                'total_merchants' => $row->total_merchants,
                'last_activity' => Carbon::parse($row->last_activity)->locale('ar')->diffForHumans(),
                'device_type' => $parsed['device_type'],
                'browser' => $parsed['browser'],
                'platform' => $parsed['platform'],
            ];
        });

        // Overview counts of Algeria vs Local/Other
        $totalIpsCount = LastSeen::whereIn('user_id', $userIdsQuery)->whereNotNull('ip_address')->count() ?: 1;
        $localCount = LastSeen::whereIn('user_id', $userIdsQuery)
            ->whereIn('ip_address', ['127.0.0.1', '::1'])
            ->count();
        $algeriaCount = max(0, $totalIpsCount - $localCount);

        return [
            'top_ips' => $enrichedIps,
            'summary' => [
                'total' => $totalIpsCount,
                'algeria_percentage' => round(($algeriaCount / $totalIpsCount) * 100, 1),
                'local_percentage' => round(($localCount / $totalIpsCount) * 100, 1),
            ],
        ];
    }

    /**
     * Get Quick KPI Summaries.
     */
    public function getSummaryKpis(string $type = 'seller'): array
    {
        $userIdsQuery = User::where('type', $type)->select('id');

        $todayStart = now()->startOfDay();
        $todayActiveMerchants = LastSeen::whereIn('user_id', $userIdsQuery)
            ->where('last_seen_at', '>=', $todayStart)
            ->distinct('user_id')
            ->count('user_id');

        $thisMonthStart = now()->startOfMonth();
        $thisMonthActiveMerchants = LastSeen::whereIn('user_id', $userIdsQuery)
            ->where('last_seen_at', '>=', $thisMonthStart)
            ->distinct('user_id')
            ->count('user_id');

        $totalLoginsRecorded = LastSeen::whereIn('user_id', $userIdsQuery)->count();

        // Top Device & Top Browser
        $topDeviceRow = LastSeen::whereIn('user_id', $userIdsQuery)
            ->latest('id')
            ->limit(500)
            ->pluck('device')
            ->map(fn($ua) => $this->parseUserAgent($ua)['device_type'])
            ->countBy()
            ->sortDesc()
            ->keys()
            ->first() ?? 'Desktop';

        $topBrowserRow = LastSeen::whereIn('user_id', $userIdsQuery)
            ->latest('id')
            ->limit(500)
            ->pluck('browser')
            ->map(fn($ua) => $this->parseUserAgent($ua)['browser'])
            ->countBy()
            ->sortDesc()
            ->keys()
            ->first() ?? 'Google Chrome';

        return [
            'today_active_merchants' => $todayActiveMerchants,
            'this_month_active_merchants' => $thisMonthActiveMerchants,
            'total_logins_recorded' => $totalLoginsRecorded,
            'top_device' => $topDeviceRow,
            'top_browser' => $topBrowserRow,
        ];
    }

    /**
     * Helper to parse User-Agent string.
     */
    public function parseUserAgent(?string $ua): array
    {
        if (empty($ua)) {
            return [
                'device_type' => 'Desktop',
                'platform' => 'حاسوب',
                'browser' => 'Chrome',
            ];
        }

        // 1. Device Type
        $isTablet = preg_match('/(ipad|tablet|(android(?!.*mobile))|(windows(?!.*phone)(.*touch))|kindle|playbook|silk)/i', $ua);
        $isMobile = !$isTablet && preg_match('/(mobile|ipod|iphone|android|blackberry|opera mini|opera mobi|windows phone|iemobile)/i', $ua);

        if ($isTablet) {
            $deviceType = 'Tablet';
        } elseif ($isMobile) {
            $deviceType = 'Mobile';
        } else {
            $deviceType = 'Desktop';
        }

        // 2. Platform / OS
        if (preg_match('/windows|win32/i', $ua)) {
            $platform = 'Windows';
        } elseif (preg_match('/android/i', $ua)) {
            $platform = 'Android';
        } elseif (preg_match('/iphone|ipad|ipod/i', $ua)) {
            $platform = 'iOS';
        } elseif (preg_match('/macintosh|mac os x/i', $ua)) {
            $platform = 'macOS';
        } elseif (preg_match('/linux/i', $ua)) {
            $platform = 'Linux';
        } else {
            $platform = 'أخرى';
        }

        // 3. Browser
        if (preg_match('/edg/i', $ua)) {
            $browser = 'Microsoft Edge';
        } elseif (preg_match('/opr|opera/i', $ua)) {
            $browser = 'Opera';
        } elseif (preg_match('/chrome|crios/i', $ua)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/firefox|fxios/i', $ua)) {
            $browser = 'Firefox';
        } elseif (preg_match('/safari/i', $ua)) {
            $browser = 'Safari';
        } else {
            $browser = 'متصفح آخر';
        }

        return [
            'device_type' => $deviceType,
            'platform' => $platform,
            'browser' => $browser,
        ];
    }

    /**
     * Identify location label from IP address.
     */
    public function analyzeIp(?string $ip): string
    {
        if (empty($ip)) {
            return 'غير معروف';
        }
        if (in_array($ip, ['127.0.0.1', '::1']) || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.') || str_starts_with($ip, '172.16.')) {
            return 'شبكة محلية (Local/LAN)';
        }
        return 'الجزائر 🇩🇿';
    }
}

