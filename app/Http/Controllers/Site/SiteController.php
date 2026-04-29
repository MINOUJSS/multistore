<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Seller\SellerOrders;
use App\Models\Seller\SellerProducts;
use App\Models\Supplier\SupplierPlan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.index');
    }

    // privacy_policy
    public function privacy_policy()
    {
        return view('site.privacy_policy');
    }

    // show_suppliers_plans
    public function show_suppliers_plans()
    {
        $plans = SupplierPlan::all();

        return view('site.show_suppliers_plans', compact('plans'));
    }

    // show_sellers_plans
    public function show_sellers_plans()
    {
        $plans = SupplierPlan::all();

        return view('site.show_sellers_plans', compact('plans'));
    }

    // show_affiliate_marketers_plans
    public function show_affiliate_marketers_plans()
    {
        return view('site.show_affiliate_marketers_plans');
    }

    // show_shipers_plans
    public function show_shipers_plans()
    {
        return view('site.show_shipers_plans');
    }

    // download digital products
    public function entry($token)
    {
        $order = SellerOrders::where('download_token', $token)->firstOrFail();

        // تحقق من الدفع
        if ($order->payment_status !== 'paid') {
            abort(403);
        }

        // إنشاء رابط موقّت (5 دقائق)
        // $signedUrl = URL::temporarySignedRoute(
        //     'download.file',
        //     now()->addMinutes(5),
        //     ['token' => $order->download_token]
        // );
        // إنشاء Signed URL
        $signedUrl = URL::temporarySignedRoute(
            'site.product.download',
            now()->addMinutes(15), // رابط قصير العمر
            ['id' => $order->items->first()->product_id, 'token' => $token]
        );

        // إعادة التوجيه للرابط الموقّع
        return redirect($signedUrl);
    }

    public function download($id, $token)
    {
        $order = SellerOrders::where('download_token', $token)->first();
        // ❌ Token غير صالح
        if (!$order) {
            abort(403, 'رابط غير صالح');
        }

        // ❌ لم يتم الدفع
        if ($order->payment_status !== 'paid') {
            abort(403, 'الدفع غير مكتمل');
        }

        // ❌ انتهت الصلاحية
        if (now()->gt($order->download_expires_at)) {
            abort(403, 'انتهت صلاحية الرابط');
        }

        // ❌ تجاوز عدد التحميلات
        if ($order->downloads_count >= 3) {
            abort(403, 'تم تجاوز عدد التحميلات');
        }

        // زيادة عدد التحميلات
        $order->increment('downloads_count');

        $product = SellerProducts::where('id', $id)->first();
        $file = $product->file;
        // تقسيم الرابط
        $parts = explode('/storage/app/public/seller/', $file);
        // المسار داخل storage
        $filePath = $parts[1];

        return Storage::disk('seller')->download($filePath);
        // return response()->download($file);
    }
}
