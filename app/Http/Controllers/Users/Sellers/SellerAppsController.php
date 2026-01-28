<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\UserApps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerAppsController extends Controller
{
    public function index()
    {
        $google_analytics = UserApps::where('user_id', Auth::user()->id)->where('app_name', 'google_analytics')->first();
        $facebook_pixel = UserApps::where('user_id', Auth::user()->id)->where('app_name', 'facebook_pixel')->first();

        return view('users.sellers.apps.index', compact('google_analytics', 'facebook_pixel'));
    }

    // ----------------google_analytics
    public function google_analytics()
    {
        $analytics = UserApps::where('user_id', Auth::user()->id)->where('app_name', 'google_analytics')->get();

        return view('users.sellers.apps.google_analytics.index', compact('analytics'));
    }

    // store_google_analytics
    public function store_google_analytics(Request $request)
    {
        // التحقق من حق المورد في إضافة كود جديد
        $userApps = UserApps::where('user_id', Auth::user()->id)->where('app_name', 'google_analytics')->get();
        $plan_id = get_seller_data(auth()->user()->tenant_id)->plan_subscription->plan_id;
        if ($plan_id == 1) {
            return response()->json([
                'success' => false,
                'message' => 'لايمكنك إضافة كود الأناليتيك',
            ]);
        } elseif ($plan_id == 2 && count($userApps) >= 1) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 1.',
            ]);
        } elseif ($plan_id == 3 && count($userApps) >= 2) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 2.',
            ]);
        }
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'tracking_id' => 'required|string|max:50',
        ], [
            'tracking_id.required' => 'يرجى إدخال معرف التتبع (Tracking ID).',
        ]);

        $user = Auth::user();

        // حفظ البيانات الجديدة في قاعدة البيانات
        $googleAnalytics = UserApps::create([
            'user_id' => $user->id,
            'app_name' => 'google_analytics',
            'data' => json_encode(['tracking_id' => $request->tracking_id]),
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم حفظ إعدادات Google Analytics بنجاح!',
            'data' => $googleAnalytics,
        ]);
    }

    public function update_google_analytics(Request $request, $id)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'tracking_id' => 'required|string|max:50',
        ], [
            'tracking_id.required' => 'يرجى إدخال معرف التتبع (Tracking ID).',
        ]);

        $user = Auth::user();
        $googleAnalytics = UserApps::where('user_id', $user->id)
            ->where('id', $id)
            ->where('app_name', 'google_analytics')
            ->first();

        if (!$googleAnalytics) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على إعدادات Google Analytics!',
            ], 404);
        }

        // تحديث البيانات
        $googleAnalytics->update([
            'data' => json_encode(['tracking_id' => $request->tracking_id]),
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث إعدادات Google Analytics بنجاح!',
            'data' => $googleAnalytics,
        ]);
    }

    // delete google_analytics
    public function delete_google_analytics($id)
    {
        try {
            $analytic = UserApps::where('id', $id)->where('app_name', 'google_analytics')->first();

            if (!$analytic) {
                return response()->json(['success' => false, 'message' => 'الإعداد غير موجود.'], 404);
            }

            $analytic->delete(); // حذف الإعداد

            return response()->json(['success' => true, 'message' => 'تم حذف الإعداد بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء الحذف.'], 500);
        }
    }

    /**
     * جلب إعدادات Google Analytics للمستخدم الحالي.
     */
    public function getSettings()
    {
        $user = Auth::user();
        $userApps = UserApps::where('user_id', $user->id)
                           ->where('app_name', 'google_analytics')
                           ->get();

        return response()->json([
            'success' => true,
            'data' => $userApp ? json_decode($userApp->data) : null,
            'status' => $userApp ? $userApp->status : 'inactive',
        ]);
    }

    // -------------------facebook_pixel
    public function facebook_pixel()
    {
        $pixels = UserApps::where('user_id', Auth::user()->id)->where('app_name', 'facebook_pixel')->get();

        return view('users.sellers.apps.facebook_pixel.index', compact('pixels'));
    }

    // إضافة Facebook Pixel
    public function store_facebook_pixel(Request $request)
    {
        // التحقق من حق المورد في إضافة كود جديد
        $userApps = UserApps::where('user_id', Auth::user()->id)->where('app_name', 'facebook_pixel')->get();
        $plan_id = get_seller_data(auth()->user()->tenant_id)->plan_subscription->plan_id;
        if ($plan_id == 1 && count($userApps) >= 1) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 1.',
            ]);
        } elseif ($plan_id == 2 && count($userApps) >= 2) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 2.',
            ]);
        } elseif ($plan_id == 3 && count($userApps) >= 4) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 4.',
            ]);
        }
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'pixel_id' => 'required|string|max:50',
        ], [
            'pixel_id.required' => 'يرجى إدخال معرف البكسل (Pixel ID).',
        ]);

        $user = Auth::user();

        // حفظ البيانات الجديدة في قاعدة البيانات
        $facebookPixel = UserApps::create([
            'user_id' => $user->id,
            'app_name' => 'facebook_pixel',
            'data' => json_encode(['pixel_id' => $request->pixel_id]),
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم حفظ إعدادات Facebook Pixel بنجاح!',
            'data' => $facebookPixel,
        ]);
    }

    // تحديث Facebook Pixel
    public function update_facebook_pixel(Request $request, $id)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'pixel_id' => 'required|string|max:50',
        ], [
            'pixel_id.required' => 'يرجى إدخال معرف البكسل (Pixel ID).',
        ]);

        $user = Auth::user();
        $facebookPixel = UserApps::where('user_id', $user->id)
            ->where('id', $id)
            ->where('app_name', 'facebook_pixel')
            ->first();

        if (!$facebookPixel) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على إعدادات Facebook Pixel!',
            ], 404);
        }

        // تحديث البيانات
        $facebookPixel->update([
            'data' => json_encode(['pixel_id' => $request->pixel_id]),
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث إعدادات Facebook Pixel بنجاح!',
            'data' => $facebookPixel,
        ]);
    }

    // حذف Facebook Pixel
    public function delete_facebook_pixel($id)
    {
        try {
            $pixel = UserApps::where('id', $id)->where('app_name', 'facebook_pixel')->first();

            if (!$pixel) {
                return response()->json(['success' => false, 'message' => 'الإعداد غير موجود.'], 404);
            }

            $pixel->delete(); // حذف الإعداد

            return response()->json(['success' => true, 'message' => 'تم حذف الإعداد بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء الحذف.'], 500);
        }
    }

    // ------------------tiktok_pixel
    public function tiktok_pixel()
    {
        $pixels = UserApps::where('user_id', Auth::user()->id)->where('app_name', 'tiktok_pixel')->get();

        return view('users.sellers.apps.tiktok_pixel.index', compact('pixels'));
    }

    // إضافة TikTok Pixel
    public function store_tiktok_pixel(Request $request)
    {
        // التحقق من حق المورد في إضافة كود جديد
        $userApps = UserApps::where('user_id', Auth::user()->id)->where('app_name', 'tiktok_pixel')->get();
        $plan_id = get_seller_data(auth()->user()->tenant_id)->plan_subscription->plan_id;
        if ($plan_id == 1) {
            return response()->json([
                'success' => false,
                'message' => 'لايمكنك إضافة كود تيكتوك بيكسل',
            ]);
        } elseif ($plan_id == 2 && count($userApps) >= 1) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 1.',
            ]);
        } elseif ($plan_id == 3 && count($userApps) >= 4) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 4.',
            ]);
        }
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'pixel_id' => 'required|string|max:50',
        ], [
            'pixel_id.required' => 'يرجى إدخال معرف البكسل (Pixel ID).',
        ]);

        $user = Auth::user();

        // حفظ البيانات الجديدة في قاعدة البيانات
        $tiktokPixel = UserApps::create([
            'user_id' => $user->id,
            'app_name' => 'tiktok_pixel',
            'data' => json_encode(['pixel_id' => $request->pixel_id]),
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم حفظ إعدادات TikTok Pixel بنجاح!',
            'data' => $tiktokPixel,
        ]);
    }

    // تحديث TikTok Pixel
    public function update_tiktok_pixel(Request $request, $id)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'pixel_id' => 'required|string|max:50',
        ], [
            'pixel_id.required' => 'يرجى إدخال معرف البكسل (Pixel ID).',
        ]);

        $user = Auth::user();
        $tiktokPixel = UserApps::where('user_id', $user->id)
            ->where('id', $id)
            ->where('app_name', 'tiktok_pixel')
            ->first();

        if (!$tiktokPixel) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على إعدادات TikTok Pixel!',
            ], 404);
        }

        // تحديث البيانات
        $tiktokPixel->update([
            'data' => json_encode(['pixel_id' => $request->pixel_id]),
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث إعدادات TikTok Pixel بنجاح!',
            'data' => $tiktokPixel,
        ]);
    }

    // حذف TikTok Pixel
    public function delete_tiktok_pixel($id)
    {
        try {
            $pixel = UserApps::where('id', $id)->where('app_name', 'tiktok_pixel')->first();

            if (!$pixel) {
                return response()->json(['success' => false, 'message' => 'الإعداد غير موجود.'], 404);
            }

            $pixel->delete(); // حذف الإعداد

            return response()->json(['success' => true, 'message' => 'تم حذف الإعداد بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء الحذف.'], 500);
        }
    }

    // -------------------google_sheet
    public function google_sheet()
    {
        $sheets = UserApps::where('user_id', Auth::user()->id)->where('app_name', 'google_sheets')->get();

        return view('users.sellers.apps.google_sheet.index', compact('sheets'));
    }

    // إضافة Google Sheets
    public function store_google_sheets(Request $request)
    {
        // التحقق من حق المورد في إضافة كود جديد
        $userApps = UserApps::where('user_id', Auth::user()->id)->where('app_name', 'google_sheets')->get();
        $plan_id = get_seller_data(auth()->user()->tenant_id)->plan_subscription->plan_id;
        if ($plan_id == 1) {
            return response()->json([
                'success' => false,
                'message' => 'لايمكنك إضافة كود  Google Sheets.',
            ]);
        } elseif ($userApps != null && ($plan_id == 2 || $plan_id == 3) && count($userApps) >= 1) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 1.',
            ]);
        }
        // elseif($plan_id==3 && count($userApps)>=2)
        // {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'الحد الأقصى لإضافة كود جديد هو 2.',
        //     ]);
        // }

        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'sheet_id' => 'required|string',
        ], [
            'sheet_id.required' => 'يرجى إدخال معرف Google Sheet.',
        ]);

        $user = Auth::user();

        // حفظ البيانات في قاعدة البيانات
        $googleSheet = UserApps::create([
            'user_id' => $user->id,
            'app_name' => 'google_sheets',
            'data' => json_encode(['sheet_id' => $request->sheet_id]),
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم حفظ إعدادات Google Sheets بنجاح!',
            'data' => $googleSheet,
        ]);
    }

    // تحديث Google Sheets
    public function update_google_sheets(Request $request, $id)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'sheet_id' => 'required|string|max:100',
        ], [
            'sheet_id.required' => 'يرجى إدخال معرف Google Sheet.',
        ]);

        $user = Auth::user();
        $googleSheet = UserApps::where('user_id', $user->id)
            ->where('id', $id)
            ->where('app_name', 'google_sheets')
            ->first();

        if (!$googleSheet) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على إعدادات Google Sheets!',
            ], 404);
        }

        // تحديث البيانات
        $googleSheet->update([
            'data' => json_encode(['sheet_id' => $request->sheet_id]),
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث إعدادات Google Sheets بنجاح!',
            'data' => $googleSheet,
        ]);
    }

    // حذف Google Sheets
    public function delete_google_sheets($id)
    {
        try {
            $sheet = UserApps::where('id', $id)->where('app_name', 'google_sheets')->first();

            if (!$sheet) {
                return response()->json(['success' => false, 'message' => 'الإعداد غير موجود.'], 404);
            }

            $sheet->delete(); // حذف الإعداد

            return response()->json(['success' => true, 'message' => 'تم حذف الإعداد بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء الحذف.'], 500);
        }
    }

    // -------------------telegram notifications
    public function telegram_notifications()
    {
        $telegramSettings = UserApps::where('user_id', Auth::user()->id)->where('app_name', 'telegram_notifications')->get();

        return view('users.sellers.apps.telegram_notifications.index', compact('telegramSettings'));
    }

    // إضافة إعدادات Telegram
    public function store_telegram_notification(Request $request)
    {
        // التحقق من حق المورد في إضافة كود جديد
        $userApps = UserApps::where('user_id', Auth::user()->id)->where('app_name', 'telegram_notifications')->get();
        $plan_id = get_seller_data(auth()->user()->tenant_id)->plan_subscription->plan_id;
        if ($plan_id == 1 && count($userApps) >= 1) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 1.',
            ]);
        } elseif ($plan_id == 2 && count($userApps) >= 1) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 1.',
            ]);
        } elseif ($plan_id == 3 && count($userApps) >= 1) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 1.',
            ]);
        }
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'chat_id' => 'required|string|max:50',
        ], [
            'chat_id.required' => 'يرجى إدخال معرف الـ Chat في Telegram.',
        ]);

        $user = Auth::user();

        // حفظ البيانات الجديدة في قاعدة البيانات
        $telegramNotification = UserApps::create([
            'user_id' => $user->id,
            'app_name' => 'telegram_notifications',
            'data' => json_encode(['chat_id' => $request->chat_id]),
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم حفظ إعدادات إشعارات Telegram بنجاح!',
            'data' => $telegramNotification,
        ]);
    }

    // تحديث إعدادات Telegram
    public function update_telegram_notification(Request $request, $id)
    {
        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'chat_id' => 'required|string|max:50',
        ], [
            'chat_id.required' => 'يرجى إدخال معرف الـ Chat في Telegram.',
        ]);

        $user = Auth::user();
        $telegramNotification = UserApps::where('user_id', $user->id)
            ->where('id', $id)
            ->where('app_name', 'telegram_notifications')
            ->first();

        if (!$telegramNotification) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على إعدادات إشعارات Telegram!',
            ], 404);
        }

        // تحديث البيانات
        $telegramNotification->update([
            'data' => json_encode(['chat_id' => $request->chat_id]),
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث إعدادات إشعارات Telegram بنجاح!',
            'data' => $telegramNotification,
        ]);
    }

    // حذف إعدادات Telegram
    public function delete_telegram_notification($id)
    {
        try {
            $telegramNotification = UserApps::where('id', $id)
                ->where('app_name', 'telegram_notifications')
                ->first();

            if (!$telegramNotification) {
                return response()->json(['success' => false, 'message' => 'الإعداد غير موجود.'], 404);
            }

            $telegramNotification->delete(); // حذف الإعداد

            return response()->json(['success' => true, 'message' => 'تم حذف الإعداد بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء الحذف.'], 500);
        }
    }
    // //
    // public function storeGoogleAnalytics(Request $request)
    // {
    //     // التحقق من صحة البيانات
    //     $validatedData = $request->validate([
    //         'tracking_id' => 'required|string|max:50',
    //     ], [
    //         'tracking_id.required' => 'يرجى إدخال معرف التتبع (Tracking ID).',
    //     ]);

    //     $user = Auth::user();
    //     $data = json_encode(['tracking_id' => $request->tracking_id]);

    //     // البحث عن التطبيق الخاص بالمستخدم أو إنشاؤه
    //     $userApp = UserApps::updateOrCreate(
    //         [
    //             'user_id'  => $user->id,
    //             'app_name' => 'google_analytics',
    //         ],
    //         [
    //             'data'   => $data,
    //             'status' => $request->has('status') ? 'active' : 'inactive'
    //         ]
    //     );

    //     return response()->json(['success' => true, 'message' => 'تم حفظ الإعدادات بنجاح!']);
    // }

    // //
    // public function storeFacebookPixel(Request $request)
    // {
    //     // التحقق من صحة البيانات
    //     $validatedData = $request->validate([
    //         'fp_pixel_id' => 'required|string|max:50',
    //     ], [
    //         'fp_pixel_id.required' => 'يرجى إدخال معرف التتبع (Pixel ID).',
    //     ]);

    //     $user = Auth::user();
    //     $data = json_encode(['pixel_id' => $request->fp_pixel_id]);

    //     // البحث عن التطبيق الخاص بالمستخدم أو إنشاؤه
    //     $userApp = UserApps::updateOrCreate(
    //         [
    //             'user_id'  => $user->id,
    //             'app_name' => 'facebook_pixel',
    //         ],
    //         [
    //             'data'   => $data,
    //             'status' => $request->has('fp_status') ? 'active' : 'inactive'
    //         ]
    //     );

    //     return response()->json(['success' => true, 'message' => 'تم حفظ الإعدادات بنجاح!']);
    // }

    // ------------------clarity
    // ------------------microsoft_clarity
    public function clarity()
    {
        $clarities = UserApps::where('user_id', Auth::id())
            ->where('app_name', 'clarity')
            ->get();

        return view('users.sellers.apps.clarity.index', compact('clarities'));
    }

    // إضافة Microsoft Clarity
    public function store_clarity(Request $request)
    {
        // التحقق من صلاحية المورد
        $userApps = UserApps::where('user_id', Auth::id())
            ->where('app_name', 'clarity')
            ->get();

        $plan_id = get_seller_data(Auth::user()->tenant_id)->plan_subscription->plan_id;

        if ($plan_id == 1) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكنك إضافة كود Microsoft Clarity.',
            ]);
        } elseif ($plan_id == 2 && $userApps->count() >= 1) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 1.',
            ]);
        } elseif ($plan_id == 3 && $userApps->count() >= 2) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأقصى لإضافة كود جديد هو 2.',
            ]);
        }

        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'clarity_id' => 'required|string|max:50',
        ], [
            'clarity_id.required' => 'يرجى إدخال معرف Microsoft Clarity (Clarity ID).',
        ]);

        $clarity = UserApps::create([
            'user_id' => Auth::id(),
            'app_name' => 'clarity',
            'data' => json_encode(['clarity_id' => $request->clarity_id]),
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم حفظ إعدادات Microsoft Clarity بنجاح!',
            'data' => $clarity,
        ]);
    }

    // تحديث Microsoft Clarity
    public function update_clarity(Request $request, $id)
    {
        $validatedData = $request->validate([
            'clarity_id' => 'required|string|max:50',
        ], [
            'clarity_id.required' => 'يرجى إدخال معرف Microsoft Clarity (Clarity ID).',
        ]);

        $clarity = UserApps::where('user_id', Auth::id())
            ->where('app_name', 'clarity')
            ->where('id', $id)
            ->first();

        if (!$clarity) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على إعدادات Microsoft Clarity!',
            ], 404);
        }

        $clarity->update([
            'data' => json_encode(['clarity_id' => $request->clarity_id]),
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث إعدادات Microsoft Clarity بنجاح!',
            'data' => $clarity,
        ]);
    }

    // حذف Microsoft Clarity
    public function delete_clarity($id)
    {
        try {
            $clarity = UserApps::where('id', $id)
                ->where('app_name', 'clarity')
                ->first();

            if (!$clarity) {
                return response()->json([
                    'success' => false,
                    'message' => 'الإعداد غير موجود.',
                ], 404);
            }

            $clarity->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الإعداد بنجاح!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء الحذف.',
            ], 500);
        }
    }
}
