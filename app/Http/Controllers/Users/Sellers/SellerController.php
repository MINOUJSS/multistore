<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Seller\Seller;
use App\Models\Seller\SellerOrderItems;
use App\Models\Seller\SellerOrders;
use App\Models\Seller\SellerProducts;
use App\Models\Seller\SellerProductsVisits;
use App\Models\Wilaya;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function index()
    {
        // get top products
        $topProducts = SellerOrderItems::select(
            'seller_products.id',
            'seller_products.name',
            'seller_products.image',
            DB::raw('SUM(seller_order_items.quantity) as total_sold'),
            DB::raw('COUNT(seller_order_items.id) as orders_count')
        )
        ->join('seller_products', 'seller_products.id', '=', 'seller_order_items.product_id')
        ->where('seller_products.seller_id', get_seller_data(auth()->user()->tenant_id)->id)
        ->groupBy('seller_products.id', 'seller_products.name', 'seller_products.image')
        ->orderByDesc('total_sold') // ترتيب حسب الكمية المباعة
        ->take(5) // مثلاً نجيب أفضل 10 منتجات
        ->get();
        // get top viewed products
        $topViewed = SellerProductsVisits::select(
            'seller_products.id',
            'seller_products.name',
            'seller_products.image',
            DB::raw('COUNT(seller_products_visits.id) as views_count')
        )
        ->join('seller_products', 'seller_products.id', '=', 'seller_products_visits.product_id')
        ->where('seller_products.seller_id', get_seller_data(auth()->user()->tenant_id)->id)
        ->groupBy('seller_products.id', 'seller_products.name', 'seller_products.image')
        ->orderByDesc('views_count')
        ->take(10)
        ->get();
        //  $topViewed = sellerProducts::where('seller_id', get_seller_data(auth()->user()->tenant_id)->id)
        // ->orderByDesc('view_count')
        // ->take(5) // أفضل 10 منتجات
        // ->get();

        // بيانات يومية (3 أيام قبل و3 أيام بعد اليوم الحالي)
        $start = now()->subDays(6)->startOfDay();
        $end = now()->addDays(0)->endOfDay();

        // جلب الطلبات من DB
        $dailyOrdersRaw = DB::table('seller_orders')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('seller_id', get_seller_data(auth()->user()->tenant_id)->id)
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // get seller products
        $products_ids = get_seller_products_ids(get_seller_data(auth()->user()->tenant_id)->id);
        // dailyVisitorsRow
        $dailyVisitorsRaw = DB::table('seller_products_visits')
        ->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
        ->whereIn('product_id', $products_ids)
        ->whereBetween('created_at', [$start, $end])
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('total', 'date');

        // تجهيز مصفوفة 7 أيام (بما فيها الأيام بدون طلبات = 0)
        $dailyOrders = collect();
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $formatted = $date->format('Y-m-d'); // شكل التاريخ
            $lables = $date->format('D');
            switch ($lables) {
                case $lables == 'Mon':
                    $lables = 'الاثنين';
                    break;
                case $lables == 'Tue':
                    $lables = 'الثلاثاء';
                    break;
                case $lables == 'Wed':
                    $lables = 'الاربعاء';
                    break;
                case $lables == 'Thu':
                    $lables = 'الخميس';
                    break;
                case $lables == 'Fri':
                    $lables = 'الجمعة';
                    break;
                case $lables == 'Sat':
                    $lables = 'السبت';
                    break;
                case $lables == 'Sun':
                    $lables = 'الاحد';
            }
            $dailyOrders[$lables] = $dailyOrdersRaw[$formatted] ?? 0;
        }
        // $dailyVisitors = collect();
        $dailyVisitors = collect();
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $formatted = $date->format('Y-m-d'); // شكل التاريخ
            $lables = $date->format('D');
            switch ($lables) {
                case $lables == 'Mon':
                    $lables = 'الاثنين';
                    break;
                case $lables == 'Tue':
                    $lables = 'الثلاثاء';
                    break;
                case $lables == 'Wed':
                    $lables = 'الاربعاء';
                    break;
                case $lables == 'Thu':
                    $lables = 'الخميس';
                    break;
                case $lables == 'Fri':
                    $lables = 'الجمعة';
                    break;
                case $lables == 'Sat':
                    $lables = 'السبت';
                    break;
                case $lables == 'Sun':
                    $lables = 'الاحد';
            }
            $dailyVisitors[$lables] = $dailyVisitorsRaw[$formatted] ?? 0;
        }
        // dd($dailyOrders);

        // //     // بيانات يومية (عدد الطلبات لكل يوم في الشهر الحالي)
        //     $dailyOrders = DB::table('seller_orders')
        // ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as total'))
        // ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        // ->groupBy('day')
        // ->pluck('total', 'day');

        // بيانات أسبوعية (6 أسابيع قبل + الحالي + 3 بعد)
        $startOfRange = now()->subWeeks(4)->startOfWeek();
        $endOfRange = now()->addWeeks(0)->endOfWeek();

        // جلب البيانات من DB
        $weeklyOrdersRaw = DB::table('seller_orders')
            ->select(
                DB::raw('YEARWEEK(created_at, 1) as yearweek'), // صيغة السنة+الأسبوع
                DB::raw('COUNT(*) as total')
            )
            ->where('seller_id', get_seller_data(auth()->user()->tenant_id)->id)
            ->whereBetween('created_at', [$startOfRange, $endOfRange])
            ->groupBy('yearweek')
            ->orderBy('yearweek')
            ->pluck('total', 'yearweek');

        // weeklyVisitorsRow
        $weeklyVisitorsRaw = DB::table('seller_products_visits')
        ->select(
            DB::raw('YEARWEEK(created_at, 1) as yearweek'), // صيغة السنة+الأسبوع
            DB::raw('COUNT(*) as total')
        )
        ->whereIn('product_id', $products_ids)
        ->whereBetween('created_at', [$startOfRange, $endOfRange])
        ->groupBy('yearweek')
        ->orderBy('yearweek')
        ->pluck('total', 'yearweek');

        // تجهيز مصفوفة كاملة (بما فيها الأسابيع بدون طلبات = 0)
        $weeklyOrders = collect();
        for ($date = $startOfRange->copy(); $date->lte($endOfRange); $date->addWeek()) {
            $yearweek = $date->format('oW'); // o=ISO year, W=ISO week number (مثلاً 202540)
            $label = 'أسبوع '.$date->format('W'); // مثال: "أسبوع 40"
            $weeklyOrders[$label] = $weeklyOrdersRaw[$yearweek] ?? 0;
        }

        $weeklyVisitors = collect();
        for ($date = $startOfRange->copy(); $date->lte($endOfRange); $date->addWeek()) {
            $yearweek = $date->format('oW'); // o=ISO year, W=ISO week number (مثلاً 202540)
            $label = 'أسبوع '.$date->format('W'); // مثال: "أسبوع 40"
            $weeklyVisitors[$label] = $weeklyVisitorsRaw[$yearweek] ?? 0;
        }

        // // بيانات أسبوعية
        // $weeklyOrders = DB::table('seller_orders')
        //     ->select(DB::raw('DAYNAME(created_at) as day'), DB::raw('COUNT(*) as total'))
        //     ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        //     ->groupBy('day')
        //     ->pluck('total', 'day');

        // بيانات شهرية (6 أشهر قبل و 6 أشهر بعد الشهر الحالي)
        $startMonth = now()->copy()->subMonths(12)->startOfMonth();
        $endMonth = now()->copy()->addMonths(0)->endOfMonth();

        $monthlyOrdersRaw = DB::table('seller_orders')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"),
                DB::raw('COUNT(*) as total')
            )
            ->where('seller_id', get_seller_data(auth()->user()->tenant_id)->id)
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->groupBy('ym')
            ->pluck('total', 'ym');

        // monthlyVisitorsRow
        $monthlyVisitorsRaw = DB::table('seller_products_visits')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"),
                DB::raw('COUNT(*) as total')
            )
            ->whereIn('product_id', $products_ids)
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->groupBy('ym')
            ->pluck('total', 'ym');

        // تجهيز المصفوفة (كل شهر بقيمة، وإذا ما فيه طلبات → 0)
        $monthlyLabels = [];
        $monthlyData = [];

        $current = $startMonth->copy();
        while ($current <= $endMonth) {
            $ym = $current->format('Y-m'); // مثال: 2025-01
            $monthlyLabels[] = $current->translatedFormat('F Y'); // مثال: يناير 2025
            $monthlyData[] = $monthlyOrdersRaw[$ym] ?? 0;
            $current->addMonth();
        }

        $monthlyVisitorsLabels = [];
        $monthlyVisitorsData = [];

        $current = $startMonth->copy();
        while ($current <= $endMonth) {
            $ym = $current->format('Y-m'); // مثال: 2025-01
            $monthlyVisitorsLabels[] = $current->translatedFormat('F Y'); // مثال: يناير 2025
            $monthlyVisitorsData[] = $monthlyVisitorsRaw[$ym] ?? 0;
            $current->addMonth();
        }

        // // بيانات شهرية
        // $monthlyOrders = DB::table('seller_orders')
        //     ->select(DB::raw('MONTHNAME(created_at) as month'), DB::raw('COUNT(*) as total'))
        //     ->whereYear('created_at', now()->year)
        //     ->groupBy('month')
        //     ->pluck('total', 'month');

        // توزيع حالات الطلبات
        $statusCounts = DB::table('seller_orders')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->where('seller_id', get_seller_data(auth()->user()->tenant_id)->id)
            ->groupBy('status')
            ->pluck('total', 'status');
        // ترجمة الحالات إلى العربية
        $statusTranslations = [
            'pending' => 'قيد الانتظار',
            'processing' => 'قيد المعالجة',
            'shipped' => 'تم الشحن',
            'delivered' => 'مكتمل',
            'canceled' => 'ملغى',
        ];

        // استبدال المفاتيح بالترجمة
        $translatedLabels = $statusCounts->keys()->map(function ($status) use ($statusTranslations) {
            return $statusTranslations[$status] ?? $status;
        });
        // ---------- حساب نسبة كل الطلبات -----------
        // الأسبوع الحالي
        $currentWeekAllOrders = DB::table('seller_orders')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // الأسبوع الماضي
        $lastWeekAllOrders = DB::table('seller_orders')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->count();

        // حساب النسبة
        if ($lastWeekAllOrders > 0) {
            $percentageAllWeekChange = (($currentWeekAllOrders - $lastWeekAllOrders) / $lastWeekAllOrders) * 100;
        } else {
            $percentageAllWeekChange = 0; // إذا لم يكن هناك طلبات الأسبوع الماضي
        }
        // ---------------------------------------------
        // الشهر الحالي
        $currentMonthAllOrders = DB::table('seller_orders')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // الشهر الماضي
        $lastMonthAllOrders = DB::table('seller_orders')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        // حساب النسبة
        if ($lastMonthAllOrders > 0) {
            $percentageAllChange = (($currentMonthAllOrders - $lastMonthAllOrders) / $lastMonthAllOrders) * 100;
        } else {
            $percentageAllChange = 0; // إذا لم يكن هناك طلبات الشهر الماضي
        }
        // ---------------------------------------------
        // ---------- حساب نسبة الطلبات لبمؤكدة -----------
        // الأسبوع الحالي
        $currentWeekConfirmedOrders = DB::table('seller_orders')
            ->where('status', 'processing')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // الأسبوع الماضي
        $lastWeekConfirmedOrders = DB::table('seller_orders')
            ->where('status', 'processing')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->count();

        // حساب النسبة
        if ($lastWeekConfirmedOrders > 0) {
            $percentageConfirmedWeekChange = (($currentWeekConfirmedOrders - $lastWeekConfirmedOrders) / $lastWeekConfirmedOrders) * 100;
        } else {
            $percentageConfirmedWeekChange = 0; // إذا لم يكن هناك طلبات الأسبوع الماضي
        }
        // ---------------------------------------------
        // الشهر الحالي
        $currentMonthConfirmedOrders = DB::table('seller_orders')
            ->where('status', 'processing')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // الشهر الماضي
        $lastMonthConfirmedOrders = DB::table('seller_orders')
            ->where('status', 'processing')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        // حساب النسبة
        if ($lastMonthConfirmedOrders > 0) {
            $percentageConfirmedChange = (($currentMonthConfirmedOrders - $lastMonthConfirmedOrders) / $lastMonthConfirmedOrders) * 100;
        } else {
            $percentageConfirmedChange = 0; // إذا لم يكن هناك طلبات الشهر الماضي
        }
        // ---------------------------------------------
        // ---------- حساب نسبة الطلبات المكتملة -----------
        // الأسبوع الحالي
        $currentWeekDeliveredOrders = DB::table('seller_orders')
            ->where('status', 'delivered')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // الأسبوع الماضي
        $lastWeekDeliveredOrders = DB::table('seller_orders')
            ->where('status', 'delivered')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->count();

        // حساب النسبة
        if ($lastWeekDeliveredOrders > 0) {
            $percentageDeliveredWeekChange = (($currentWeekDeliveredOrders - $lastWeekDeliveredOrders) / $lastWeekDeliveredOrders) * 100;
        } else {
            $percentageDeliveredWeekChange = 0; // إذا لم يكن هناك طلبات الأسبوع الماضي
        }
        // ---------------------------------------------
        // الشهر الحالي
        $currentMonthDeliveredOrders = DB::table('seller_orders')
            ->where('status', 'delivered')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // الشهر الماضي
        $lastMonthDeliveredOrders = DB::table('seller_orders')
            ->where('status', 'delivered')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        // حساب النسبة
        if ($lastMonthDeliveredOrders > 0) {
            $percentageDeliveredChange = (($currentMonthDeliveredOrders - $lastMonthDeliveredOrders) / $lastMonthDeliveredOrders) * 100;
        } else {
            $percentageDeliveredChange = 0; // إذا لم يكن هناك طلبات الشهر الماضي
        }
        // ---------------------------------------------
        // ---------- حساب نسبة الطلبات الملغاة -----------
        // الأسبوع الحالي
        $currentWeekCanceledOrders = DB::table('seller_orders')
            ->where('status', 'canceled')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // الأسبوع الماضي
        $lastWeekCanceledOrders = DB::table('seller_orders')
            ->where('status', 'canceled')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->count();

        // حساب النسبة
        if ($lastWeekCanceledOrders > 0) {
            $PercentageCanceledWeekChange = (($currentWeekCanceledOrders - $lastWeekCanceledOrders) / $lastWeekCanceledOrders) * 100;
        } else {
            $PercentageCanceledWeekChange = 0; // إذا لم يكن هناك طلبات الأسبوع الماضي
        }
        // ---------------------------------------------
        // ---------- حساب نسبة الطلبات الملغاة -----------
        // الشهر الحالي
        $currentMonthCanceledOrders = DB::table('seller_orders')
            ->where('status', 'canceled')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // الشهر الماضي
        $lastMonthCanceledOrders = DB::table('seller_orders')
            ->where('status', 'canceled')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        // حساب النسبة
        if ($lastMonthCanceledOrders > 0) {
            $percentageCanceledChange = (($currentMonthCanceledOrders - $lastMonthCanceledOrders) / $lastMonthCanceledOrders) * 100;
        } else {
            $percentageCanceledChange = 0; // إذا لم يكن هناك طلبات الشهر الماضي
        }
        // ---------------------------------------------
        // ---------- حساب نسبة الطلبات المتروكة -----------
        // الأسبوع الحالي
        $currentWeekAbandonedOrders = DB::table('seller_order_abandoneds')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // الأسبوع الماضي
        $lastWeekAbandonedOrders = DB::table('seller_order_abandoneds')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->count();

        // حساب النسبة
        if ($lastWeekAbandonedOrders > 0) {
            $weekPercentageAbandonedChange = (($currentWeekAbandonedOrders - $lastWeekAbandonedOrders) / $lastWeekAbandonedOrders) * 100;
        } else {
            $weekPercentageAbandonedChange = 0; // إذا لم يكن هناك طلبات الأسبوع الماضي
        }
        // ---------------------------------------------
        // ---------- حساب نسبة الطلبات المتروكة -----------
        // الشهر الحالي
        $currentMonthAbandonedOrders = DB::table('seller_order_abandoneds')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // الشهر الماضي
        $lastMonthAbandonedOrders = DB::table('seller_order_abandoneds')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        // حساب النسبة
        if ($lastMonthAbandonedOrders > 0) {
            $percentageAbandonedChange = (($currentMonthAbandonedOrders - $lastMonthAbandonedOrders) / $lastMonthAbandonedOrders) * 100;
        } else {
            $percentageAbandonedChange = 0; // إذا لم يكن هناك طلبات الشهر الماضي
        }
        // ---------------------------------------------

        $Seller = Seller::findOrfail(get_seller_data(auth()->user()->tenant_id)->id);
        $orders = SellerOrders::where('seller_id', get_seller_data(auth()->user()->tenant_id)->id)->get();

        // dd($seller->orderToDay);
        // return view('users.sellers.index', compact('seller', 'orders'));
        return view('users.sellers.index', [
            'seller' => $Seller,
            'orders' => $orders,
            'dailyLabels' => $dailyOrders->keys(),
            'dailyData' => $dailyOrders->values(),
            'dailyVisitorsLabels' => $dailyVisitors->keys(),
            'dailyVisitorsData' => $dailyVisitors->values(),
            'weeklyLabels' => $weeklyOrders->keys(),
            'weeklyData' => $weeklyOrders->values(),
            'weeklyVisitorsLabels' => $weeklyVisitors->keys(),
            'weeklyVisitorsData' => $weeklyVisitors->values(),
            'monthlyLabels' => $monthlyLabels,
            'monthlyData' => $monthlyData,
            'monthlyVisitorsLabels' => $monthlyVisitorsLabels,
            'monthlyVisitorsData' => $monthlyVisitorsData,
            'statusLabels' => $translatedLabels,
            'statusData' => $statusCounts->values(),
            'percentageAllChange' => round($percentageAllChange, 2), // رقم عشريين فقط
            'isAllIncrease' => $percentageAllChange >= 0, // لمعرفة إذا النسبة زيادة أو نقصان
            'percentageDeliveredChange' => round($percentageDeliveredChange, 2), // رقم عشريين فقط
            'isDeliveredIncrease' => $percentageDeliveredChange >= 0, // لمعرفة إذا النسبة زيادة أو نقصان
            'percentageCanceledChange' => round($percentageCanceledChange, 2), // رقم عشريين فقط
            'isCanceledIncrease' => $percentageCanceledChange >= 0, // لمعرفة إذا النسبة زيادة أو نقصان
            'percentageDeliveredChange' => round($percentageDeliveredChange, 2), // رقم عشريين فقط
            'isDeliveredIncrease' => $percentageDeliveredChange >= 0, // لمعرفة إذا النسبة زيادة أو نقصان
            'percentageAbandonedChange' => round($percentageAbandonedChange, 2), // رقم عشريين فقط
            'isAbandonedIncrease' => $percentageAbandonedChange >= 0, // لمعرفة إذا النسبة زيادة أو نقصان
            'percentageDeliveredWeekChange' => round($percentageDeliveredWeekChange, 2), // رقم عشريين فقط
            'isWeekDeliveredIncrease' => $percentageDeliveredWeekChange >= 0, // لمعرفة إذا النسبة زيادة أو نقصان
            'PercentageCanceledWeekChange' => round($PercentageCanceledWeekChange, 2), // رقم عشريين فقط
            'isWeekCanceledIncrease' => $PercentageCanceledWeekChange >= 0, // لمعرفة إذا النسبة زيادة أو نقصان
            'weekPercentageAbandonedChange' => round($weekPercentageAbandonedChange, 2), // رقم عشريين فقط
            'isWeekAbandonedIncrease' => $weekPercentageAbandonedChange >= 0, // لمعرفة إذا النسبة زيادة أو نقصان
            'percentageAllWeekChange' => round($percentageAllWeekChange, 2), // رقم عشريين فقط
            'isWeekAllIncrease' => $percentageAllWeekChange >= 0, // لمعرفة إذا النسبة زيادة أو نقصان
            'percentageConfirmedWeekChange' => round($percentageConfirmedWeekChange, 2), // رقم عشريين فقط
            'isWeekConfirmedIncrease' => $percentageConfirmedWeekChange >= 0, // لمعرفة إذا النسبة زيادة أو نقصان
            'topProducts' => $topProducts,
            'topViewed' => $topViewed,
        ]);
    }

    // // profile
    // public function profile()
    // {
    //     $seller = seller::findOrfail(get_seller_data(auth()->user()->tenant_id)->id);
    //     $user = get_user_data(auth()->user()->tenant_id);
    //     $wilayas = Wilaya::get();

    //     return view('users.sellers.profile.index', compact('seller', 'user', 'wilayas'));
    // }

    // get dayras
    public function get_dayras($wilaya_id)
    {
        $dayras = Dayra::where('wilaya_id', $wilaya_id)->get();
        $html = '<option value="null" selected>إختر الدائرة...</option>';
        foreach ($dayras as $dayra) {
            $html .= '<option value="'.$dayra->id.'">'.$dayra->ar_name.'</option>';
        }

        return $html;
    }

    // get baladias
    public function get_baladias($dayra_id)
    {
        $baladias = Baladia::where('dayra_id', $dayra_id)->get();
        $html = '<option value="null" selected>إختر البلدية...</option>';
        foreach ($baladias as $baladia) {
            $html .= '<option value="'.$baladia->id.'">'.$baladia->ar_name.'</option>';
        }

        return $html;
    }

    // get wilaya data
    public function get_wilaya_data($wilaya_id)
    {
        return response()->json(Wilaya::findOrfail($wilaya_id)); // Wilaya::findOrfail($wilaya_id);
    }
}
