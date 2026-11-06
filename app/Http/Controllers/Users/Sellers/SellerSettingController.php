<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\ChargilySettingForTenants;
use App\Models\Seller\SellerPage;
use App\Models\User;
use App\Models\UserBanckAccounts;
use App\Models\UserBenefitSection;
use App\Models\UserStoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SellerSettingController extends Controller
{
    public function index()
    {
        $pages = SellerPage::where('seller_id', get_seller_data(auth()->user()->tenant_id)->id)->get();
        $settings = UserStoreSetting::where('user_id', auth()->user()->id)->get();
        $benefit_section = UserBenefitSection::where('user_id', auth()->user()->id)->first();

        return view('users.sellers.settings.index', compact('pages', 'settings', 'benefit_section'));
    }

    // update theme
    public function theme_update(Request $request, $user_id)
    {
        // filter data
        // if has file then update logo
        if ($image = $request->file('image')) {
            $mediaService = app(\App\Services\Seller\SellerMediaService::class);
            $store_name = get_seller_data(auth()->user()->tenant_id)->store_name;
            $seller_logo = UserStoreSetting::where('user_id', $user_id)->where('key', 'store_logo')->first();
            if ($seller_logo && $seller_logo->value) {
                $mediaService->deleteFile($seller_logo->value);
            }

            $upload = $mediaService->storeFile($image, "{$store_name}/images/logo");
            if ($seller_logo == null) {
                $seller_logo = new UserStoreSetting();
                $seller_logo->user_id = $user_id;
                $seller_logo->key = 'store_logo';
                $seller_logo->value = $upload['url'];
                $seller_logo->save();
            } else {
                $seller_logo->value = $upload['url'];
                $seller_logo->update();
            }
        }
        $seller_theme = UserStoreSetting::where('user_id', $user_id)->where('key', 'store_theme')->first();
        if ($seller_theme == null) {
            $seller_theme = new UserStoreSetting();
            $seller_theme->user_id = $user_id;
            $seller_theme->key = 'store_theme';
            $seller_theme->value = json_encode(
                ['primarycolor' => $request->primarycollor,
                    'bodytextcolor' => $request->bodytextcolor,
                    'footertextcolor' => $request->footertextcolor]
            );
            $seller_theme->save();
        }
        $seller_theme->value = json_encode(
            ['primarycolor' => $request->primarycollor,
                'bodytextcolor' => $request->bodytextcolor,
                'footertextcolor' => $request->footertextcolor]);
        $seller_theme->update();

        return redirect()->back()->with('success', 'تم التحديث بنجاح');
    }

    /**
     * Update store settings.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validation rules
        $rules = [
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
            'store_welcome_message' => 'nullable|string',
            'store_email' => 'nullable|email|max:255',
            'store_address' => 'nullable|string|max:500',
            'store_phone' => 'nullable|string|max:20',
            'store_facebook' => 'nullable|url|max:255',
            'store_telegram' => 'nullable|url|max:255',
            'store_tiktok' => 'nullable|url|max:255',
            'store_twitter' => 'nullable|url|max:255',
            'store_instagram' => 'nullable|url|max:255',
            'store_youtube' => 'nullable|url|max:255',
            'copyright' => 'nullable|string|max:255',
            'store_payment_methods' => 'required|array',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', 'store_setting'); // Add this line
        }
        //     if ($validator->fails()) {
        // return redirect(url()->previous() . '#store-setting-tab')
        //     ->withErrors($validator)
        //     ->withInput();
        // }

        // Get all validated data
        $validated = $validator->validated();

        // dd($validated['store_payment_methods'],$request['store_payment_methods']);
        // $user_setting=UserStoreSetting::where('user_id',$user->id)->get();
        // $store_payment_methods=$user_setting[17]->value;
        $array = [];
        foreach ($validated['store_payment_methods'] as $key => $value) {
            if (!isset($value['status'])) {
                $array[$key] = ['name' => $key, 'status' => 'inactive'];
            } else {
                $array[$key] = $value;
            }
        }
        $payment_values = json_encode($array);
        // dd($array);
        $validated['store_payment_methods'] = $array;

        // dd($validated['store_payment_methods'],json_decode($store_payment_methods));
        try {
            // Update or create each setting
            foreach ($validated as $key => $value) {
                UserStoreSetting::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'key' => $key,
                    ],
                    [
                        'value' => $key == 'store_payment_methods' ? $payment_values : $value,
                        'type' => $this->determineType($value),
                        'description' => $this->getDescription($key),
                        'status' => 'active',
                    ]
                );
            }

            return redirect()->route('seller.settings')
                ->with('success', 'تم تحديث الإعدادات بنجاح')
                ->with('activate_store_tab', true); // Add this line
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء حفظ الإعدادات: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Determine the type of the value.
     */
    private function determineType($value)
    {
        if (is_bool($value)) {
            return 'boolean';
        }
        if (is_numeric($value)) {
            return 'integer';
        }
        if (is_array($value) || is_object($value)) {
            return 'json';
        }

        return 'string';
    }

    /**
     * Get description for setting key.
     */
    private function getDescription($key)
    {
        $descriptions = [
            'store_name' => 'اسم المتجر',
            'store_description' => 'وصف المتجر',
            'store_email' => 'بريد المتجر الإلكتروني',
            'store_address' => 'عنوان المتجر',
            'store_phone' => 'هاتف المتجر',
            'store_facebook' => 'رابط فيسبوك',
            'store_telegram' => 'رابط تليجرام',
            'store_tiktok' => 'رابط تيك توك',
            'store_twitter' => 'رابط تويتر',
            'store_instagram' => 'رابط إنستجرام',
            'store_youtube' => 'رابط يوتيوب',
            'copyright' => 'حقوق النشر',
        ];

        return $descriptions[$key] ?? $key;
    }

    /**
     * Show the dedicated payment methods management page for the seller.
     */
    public function payment_methods()
    {
        $user = Auth::user();
        $tenantId = $user->tenant_id;
        $seller = get_seller_data($tenantId);

        // Fetch store payment methods configuration from user_store_settings
        $paymentSetting = UserStoreSetting::where('user_id', $user->id)->where('key', 'store_payment_methods')->first();
        $defaultPaymentMethods = [
            'Cash' => ['name' => 'Cash', 'status' => 'active'],
            'Chargily_Pay' => ['name' => 'ChargilyPay', 'status' => 'inactive'],
            'Ccp' => ['name' => 'Ccp', 'status' => 'inactive'],
            'BaridiMob' => ['name' => 'BaridiMob', 'status' => 'inactive'],
        ];

        if ($paymentSetting && !empty($paymentSetting->value)) {
            $decoded = json_decode($paymentSetting->value, true);
            $paymentMethods = is_array($decoded) ? array_merge($defaultPaymentMethods, $decoded) : $defaultPaymentMethods;
        } else {
            $paymentMethods = $defaultPaymentMethods;
        }

        // Fetch Chargily & Bank Account records
        $chargilySettings = $user->chargilySettings ?? ChargilySettingForTenants::where('user_id', $user->id)->first();
        $bankSettings = $user->bank_settings ?? UserBanckAccounts::where('user_id', $user->id)->first();

        // Check plan authorization
        $chargilyAuthorized = is_seller_chargily_authorized($tenantId);
        $bankAuthorized = is_seller_bank_transfer_authorized($tenantId);

        return view('users.sellers.payment_methods.index', compact(
            'paymentMethods',
            'chargilySettings',
            'bankSettings',
            'chargilyAuthorized',
            'bankAuthorized',
            'seller',
            'user'
        ));
    }

    /**
     * Update Chargily Pay settings and toggle its status in user_store_settings.
     */
    public function update_chargily_payment_method(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'public_key' => 'required|string',
            'secret_key' => 'required|string',
            'mode' => 'nullable|in:test,live,on',
        ], [
            'public_key.required' => 'يرجى إدخال المفتاح العام (Public Key)',
            'secret_key.required' => 'يرجى إدخال المفتاح السري (Secret Key)',
        ]);

        $chargily = ChargilySettingForTenants::where('user_id', $user->id)->first();
        if (!$chargily) {
            $chargily = new ChargilySettingForTenants();
            $chargily->user_id = $user->id;
        }
        $chargily->public_key = trim($request->public_key);
        $chargily->secret_key = trim($request->secret_key);
        $chargily->mode = ($request->mode === 'live' || $request->has('mode_live')) ? 'live' : 'test';
        $chargily->save();

        $chargilyStatus = $request->has('chargily_status') ? 'active' : 'inactive';
        $this->updatePaymentMethodStatusInSettings($user->id, 'Chargily_Pay', $chargilyStatus);

        return redirect()->back()->with('success', 'تم حفظ وتحديث إعدادات بوابة شارجيلي بنجاح!');
    }

    /**
     * Update Bank / CCP account details and toggle its status in user_store_settings.
     */
    public function update_bank_payment_method(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'bank_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
        ], [
            'bank_name.required' => 'يرجى إدخال اسم البنك أو الحساب البريدي',
            'name.required' => 'يرجى إدخال اسم صاحب الحساب',
            'account_number.required' => 'يرجى إدخال رقم الحساب أو CCP أو RIP',
        ]);

        $bank = UserBanckAccounts::where('user_id', $user->id)->first();
        if (!$bank) {
            $bank = new UserBanckAccounts();
            $bank->user_id = $user->id;
        }
        $bank->bank_name = trim($request->bank_name);
        $bank->name = trim($request->name);
        $bank->account_number = trim($request->account_number);
        $bank->save();

        $bankStatus = $request->has('bank_status') ? 'active' : 'inactive';
        $this->updatePaymentMethodStatusInSettings($user->id, 'Ccp', $bankStatus);
        $this->updatePaymentMethodStatusInSettings($user->id, 'BaridiMob', $bankStatus);

        return redirect()->back()->with('success', 'تم حفظ وتحديث بيانات التحويل البنكي والبريدي بنجاح!');
    }

    /**
     * Toggle status of any payment method in user_store_settings.
     */
    public function toggle_payment_method(Request $request)
    {
        $user = Auth::user();
        $method = $request->input('method');
        $statusInput = $request->input('status');
        $status = in_array($statusInput, ['active', '1', 1, true, 'true', 'on'], true) ? 'active' : 'inactive';

        if ($method === 'Bank_Transfer' || $method === 'bank') {
            $this->updatePaymentMethodStatusInSettings($user->id, 'Ccp', $status);
            $this->updatePaymentMethodStatusInSettings($user->id, 'BaridiMob', $status);
        } else {
            $this->updatePaymentMethodStatusInSettings($user->id, $method, $status);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تغيير حالة وسيلة الدفع بنجاح!',
                'status' => $status,
            ]);
        }

        return redirect()->back()->with('success', 'تم تعديل حالة وسيلة الدفع بنجاح!');
    }

    /**
     * Helper to update specific payment method status in user_store_settings table.
     */
    private function updatePaymentMethodStatusInSettings($userId, $methodKey, $status)
    {
        $setting = UserStoreSetting::where('user_id', $userId)->where('key', 'store_payment_methods')->first();
        $defaultPaymentMethods = [
            'Cash' => ['name' => 'Cash', 'status' => 'active'],
            'Chargily_Pay' => ['name' => 'ChargilyPay', 'status' => 'inactive'],
            'Ccp' => ['name' => 'Ccp', 'status' => 'inactive'],
            'BaridiMob' => ['name' => 'BaridiMob', 'status' => 'inactive'],
        ];

        $methods = $defaultPaymentMethods;
        if ($setting && !empty($setting->value)) {
            $decoded = json_decode($setting->value, true);
            if (is_array($decoded)) {
                $methods = array_merge($defaultPaymentMethods, $decoded);
            }
        }

        if (!isset($methods[$methodKey])) {
            $methods[$methodKey] = ['name' => $methodKey, 'status' => $status];
        } else {
            $methods[$methodKey]['status'] = $status;
        }

        UserStoreSetting::updateOrCreate(
            [
                'user_id' => $userId,
                'key' => 'store_payment_methods',
            ],
            [
                'value' => json_encode($methods),
                'type' => 'json',
                'description' => 'طرق الدفع المتاحة للمتجر',
                'status' => 'active',
            ]
        );
    }
}
