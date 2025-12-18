<?php

use App\Models\Supplier\SupplierProductVariations;

// function to chicke if supplier folder exists
function supplier_exists($store_name)
{
    // find the store
    $store = App\Models\Tenant::find($store_name.'.supplier');
    if ($store == null) {
        return true;
    } else {
        return false;
    }
}
// get tenant id from supplier id
function get_tenant_id_from_supplier($supplier_id)
{
    $supplier = App\Models\Supplier\Supplier::findOrfail($supplier_id);

    return $supplier->tenant_id;
}
// get supplier store name
function get_supplier_store_name($tenant_id)
{
    $store_name = explode('.', $tenant_id);

    return $store_name[0];
}
// get supplier status
function get_supplier_status($tenant_id)
{
    $supplier = App\Models\Supplier\Supplier::where('tenant_id', $tenant_id)->first();

    return $supplier->status;
}
// get supplier data
function get_supplier_data($tenant_id)
{
    $supplier = App\Models\Supplier\Supplier::where('tenant_id', $tenant_id)->first();

    return $supplier;
}
// get supplier data from id
function get_supplier_data_from_id($id)
{
    $supplier = App\Models\Supplier\Supplier::findOrFail($id);

    return $supplier;
}
// get supplier plan data
function get_supplier_plan_data($plan_id)
{
    $plan = App\Models\Supplier\SupplierPlan::where('id', $plan_id)->first();

    return $plan;
}
// has supplier settings
function has_supplier_settings($tenant_id)
{
    $user = App\Models\User::where('tenant_id', $tenant_id)->first();
    $setting = App\Models\UserStoreSetting::where('user_id', $user->id)->first();
    if ($setting !== null) {
        return true;
    } else {
        return false;
    }
}
// create default supplier store settings
function create_supplier_store_settings($user, $request)
{
    // $user: array:8 [▼
    // "name" => "Henemi amine"
    // "tenant_id" => "saoura.supplier"
    // "email" => "minou.bakho@yahoo.com"
    // "password" => "$2y$12$BGo5I.Zf9VWA9QYNOxMDJO7XBRSrEGVu3PNNhjJgnPEl3S4m8JRza"
    // "phone" => "0661752052"
    // "updated_at" => "2024-12-29 12:11:01"
    // "created_at" => "2024-12-29 12:11:01"
    // "id" => 2

    // $request: array:10 [▼
    // "_token" => "lezb7WBsmR7KyFgdBwIJdRp3GLqr8W8vIYNfxxeG"
    // "type" => "supplier"
    // "plan" => "المجانية"
    // "full_name" => "Henemi amine"
    // "email" => "minou.bakho@yahoo.com"
    // "phone" => "0661752052"
    // "store_name" => "saoura"
    // "password" => "MINOU1984"
    // "password_confirmation" => "MINOU1984"
    // "terms" => "on"
    $setting = new App\Models\UserStoreSetting();
    // add store name
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_name',
        'value' => $request->store_name,
        'type' => 'string',
        'description' => 'إسم المتجر',
        'status' => 'active',
    ]);
    // add store description
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_description',
        'value' => 'تكلم عن نشاطك التجاري',
        'type' => 'string',
        'description' => 'وصف المتجر',
        'status' => 'active',
    ]);
    // add store email
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_email',
        'value' => $request->email,
        'type' => 'string',
        'description' => 'البريد الإلكتروني للمتجر',
        'status' => 'active',
    ]);
    // add store address
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_address',
        'value' => 'عنوان متجرك',
        'type' => 'string',
        'description' => 'عنوان المتجر',
        'status' => 'active',
    ]);
    // add store phone
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_phone',
        'value' => '0660000000',
        'type' => 'string',
        'description' => 'رقم المتجر',
        'status' => 'active',
    ]);
    // add store logo
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_logo',
        'value' => '/asset/v1/users/store/img/logo/store.png',
        'type' => 'string',
        'description' => 'لوجو المتجر',
        'status' => 'active',
    ]);
    // add store language
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_language',
        'value' => 'ar',
        'type' => 'string',
        'description' => 'لغة المتجر',
        'status' => 'active',
    ]);
    // add store currency
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_currency',
        'value' => 'DZD',
        'type' => 'string',
        'description' => 'عملة المتجر',
        'status' => 'active',
    ]);
    // add store theme
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_theme',
        'value' => '{"primarycolor":"#343035","bodytextcolor":"#000000", "footertextcolor":"#ffffff"}',
        'type' => 'json',
        'description' => 'تصميم المتجر',
        'status' => 'active',
    ]);
    // add store favicon
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_favicon',
        'value' => '/asset/v1/users/store/img/logo/store.png',
        'type' => 'string',
        'description' => 'لوجو المتجر',
        'status' => 'active',
    ]);
    // add store facebook
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_facebook',
        'value' => 'facebook.com',
        'type' => 'string',
        'description' => 'صفحة فيسبوك المتجر',
        'status' => 'active',
    ]);
    // add store telegram
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_telegram',
        'value' => 'telegram.com',
        'type' => 'string',
        'description' => 'صفحة تيليجرام المتجر',
        'status' => 'active',
    ]);
    // add store tiktok
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_tiktok',
        'value' => 'tiktok.com',
        'type' => 'string',
        'description' => 'صفحة تيك توك المتجر',
        'status' => 'active',
    ]);
    // add store twitter
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_twitter',
        'value' => 'twitter.com',
        'type' => 'string',
        'description' => 'صفحة تويتر المتجر',
        'status' => 'active',
    ]);
    // add store instagram
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_instagram',
        'value' => 'instagram.com',
        'type' => 'string',
        'description' => 'صفحة انستقرام المتجر',
        'status' => 'active',
    ]);
    // add store youtube
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_youtube',
        'value' => 'youtube.com',
        'type' => 'string',
        'description' => 'صفحة يوتيوب المتجر',
        'status' => 'active',
    ]);
    // add copyright
    $setting->create([
        'user_id' => $user->id,
        'key' => 'copyright',
        'value' => get_platform_name(),
        'type' => 'string',
        'description' => 'حقوق النشر',
        'status' => 'active',
    ]);
    // create payment_methods
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_payment_methods',
        'value' => '{"Cash":{"name":"Cash","status":"active"},"Chargily_Pay":{"name":"ChargilyPay","status":"inactive"},"Ccp":{"name":"Ccp","status":"inactive"},"BaridiMob":{"name":"BaridiMob","status":"inactive"}}',
        'type' => 'json',
        'description' => 'طرق الدفع المتاحة للمتجر',
        'status' => 'active',
    ]);
    //add store welcome message
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_welcome_message',
        'value' => 'مرحبا بكم في متجرنا',
        'type' => 'string',
        'description' => 'رسالة الترحيب للمتجر',
        'status' => 'active',
    ]);
    //add store section welcome visibility
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_section_welcome_visibility',
        'value' => 'true',
        'type' => 'string',
        'description' => 'اظهار رسالة الترحيب للمتجر',
        'status' => 'active',
    ]);
    //add store section silder visibility
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_section_slider_visibility',
        'value' => 'true',
        'type' => 'string',
        'description' => 'اظهار السلايدر للمتجر',
        'status' => 'active',
    ]);
    //add store section categories visibility
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_section_categories_visibility',
        'value' => 'true',
        'type' => 'string',
        'description' => 'اظهار الفئات للمتجر',
        'status' => 'active',
    ]);
    //add store section faqs visibility
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_section_faqs_visibility',
        'value' => 'true',
        'type' => 'string',
        'description' => 'اظهار الاسئلة الشائعة للمتجر',
        'status' => 'active',
    ]);
    // add store form settings
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_order_form_settings',
        'value' => '{"form_title":"إملأ الإستمارة في الأسفل لتقديم طلبك","lable_customer_name":"الإسم الكامل","input_placeholder_customer_name":"ادخل الاسم الكامل","customer_name_required":"true","lable_customer_phone":"رقم الهاتف","input_placeholder_customer_phone":"ادخل رقم الهاتف","customer_phone_required":"true","lable_customer_address":"العنوان","input_placeholder_customer_address":"الحي، الشارع، رقم المنزل","customer_address_required":"false","customer_address_visible":"true","lable_customer_notes":"ملاحظات","input_placeholder_customer_notes":"ادخل ملاحظات","customer_notes_required":"false","customer_notes_visible":"true","lable_product_coupon_code":"كود الكوبون","input_placeholder_product_coupon_code":"أدخل كود الكوبون هنا للحصول على خصم","product_copoun_code_required":"false","form_submit_button":"اشتري الآن"}',
        'type' => 'json',
        'description' => 'اعدادات فورم الطلب للمتجر',
        'status' => 'active',
    ]);
}

// get store settings
function get_store_settings($user_id)
{
    $settings = APP\Models\UserStoreSetting::where('user_id', $user_id)->get();

    return $settings;
}

function get_store_parimary_color($tenant_id)
{
    $user = App\Models\User::where('tenant_id', $tenant_id)->first();
    $setting = App\Models\UserStoreSetting::where('user_id', $user->id)->where('key', 'store_theme')->first();
    if ($setting == null) {
        return '#343035';
    }

    return json_decode($setting->value)->primarycolor ?? '#343035';
}

function get_store_secondary_color($tenant_id)
{
    $user = App\Models\User::where('tenant_id', $tenant_id)->first();
    $setting = App\Models\UserStoreSetting::where('user_id', $user->id)->where('key', 'store_theme')->first();
    if ($setting == null) {
        return '#343035';
    }

    return json_decode($setting->value)->secondarycolor ?? '#343035';
}
// get store color logo
function get_store_logo($tenant_id)
{
    $user = App\Models\User::where('tenant_id', $tenant_id)->first();
    $setting = App\Models\UserStoreSetting::where('user_id', $user->id)->where('key', 'store_logo')->first();
    if ($setting == null) {
        return '/asset/v1/users/store/img/logo/store.png';
    }

    return $setting->value ?? '/asset/v1/users/store/img/logo/store.png';
}

function get_store_body_text_color($tenant_id)
{
    $user = App\Models\User::where('tenant_id', $tenant_id)->first();
    $setting = App\Models\UserStoreSetting::where('user_id', $user->id)->where('key', 'store_theme')->first();
    if ($setting == null) {
        return '#000000';
    }

    return json_decode($setting->value)->bodytextcolor ?? '#000000';
}

function get_store_footer_text_color($tenant_id)
{
    $user = App\Models\User::where('tenant_id', $tenant_id)->first();
    $setting = App\Models\UserStoreSetting::where('user_id', $user->id)->where('key', 'store_theme')->first();
    if ($setting == null) {
        return '#ffffff';
    }

    return json_decode($setting->value)->footertextcolor ?? '#ffffff';
}
// get store payment methods
function get_store_payment_methods($tenant_id)
{
    $user = App\Models\User::where('tenant_id', $tenant_id)->first();
    $setting = App\Models\UserStoreSetting::where('user_id', $user->id)->where('key', 'store_payment_methods')->first();
    // if ($setting == null) {
    //     return '{
    //     "Cash":{"name":"Cash","status":"active"},
    //     "Chargily_Pay":{"name":"ChargilyPay","status":"active"},
    //     "Ccp":{"name":"Ccp","status":"active"},
    //     "BaridiMob":{"name":"BaridiMob","status":"active"},
    //     }';
    // }

    return json_decode($setting->value);

    // return $setting->value ?? '{
    //     "Cash":{"name":"Cash","status":"active"},
    //     "Chargily_Pay":{"name":"ChargilyPay","status":"active"},
    //     "Ccp":{"name":"Ccp","status":"active"},
    //     "BaridiMob":{"name":"BaridiMob","status":"active"},
    //     }';
}
// create default supplier dashboard settings
function create_supplier_dashboard_settings($user, $request)
{
    // add store name to dashboard
    $user->dashboard_settings()->create([
        'key' => 'store_name',
        'value' => $request->store_name,
        'type' => 'string',
        'description' => 'إسم المتجر',
        'status' => 'active',
    ]);
    // add theme
    $user->dashboard_settings()->create([
        'key' => 'dashboard_theme',
        'value' => 'default',
        'type' => 'string',
        'description' => 'تصميم لوحة التحكم',
        'status' => 'active',
    ]);
}
// get_supplier_product_category
function get_supplier_product_category($product_id)
{
    $product = App\Models\Supplier\SupplierProducts::findOrFail($product_id);
    if ($product->category_id !== null) {
        $category = App\Models\Category::findOrFail($product->category_id);

        return $category->name;
    } else {
        return 'بدون تصنيف';
    }
}
// get_supplier_product_price
function get_supplier_product_price($product_id)
{
    $product = App\Models\Supplier\SupplierProducts::findOrFail($product_id);
    if ($product->activeDiscount) {
        $price = $product->activeDiscount->discount_amount;
        return $price;
    } else {
        return $product->price;
    }
}
// s_p_has_free_shipping(
function s_p_has_free_shipping($product_id)
{
    $product = App\Models\Supplier\SupplierProducts::findOrFail($product_id);
    if ($product->free_shipping == 'yes') {
        return 'نعم';
    } else {
        return 'لا';
    }
}

function is_free_shipping($product_id)
{
    $product = App\Models\Supplier\SupplierProducts::findOrFail($product_id);
    if ($product->free_shipping == 'yes') {
        return true;
    } else {
        return false;
    }
}
// supplier_product_has_discount
function supplier_product_has_discount($id)
{
    $product = App\Models\Supplier\SupplierProducts::findOrFail($id);
    $discount = App\Models\Supplier\SupplierProductDiscounts::where('product_id', $product->id)->where('status', 'active')
                                                    ->whereDate('start_date', '<=', now())
                                                    ->whereDate('end_date', '>=', now())
                                                    ->first();
    if ($discount !== null) {
        return true;
    } else {
        return false;
    }
}

function supplier_product_has_variations($id)
{
    $product = App\Models\Supplier\SupplierProducts::findOrFail($id);
    $vartiations = App\Models\Supplier\SupplierProductVariations::where('product_id', $product->id)->get();
    if (count($vartiations)>0) {
        return true;
    } else {
        return false;
    }
}
// get supplier product variations data
function get_supplier_product_variation_data($id)
{
    $variation = App\Models\Supplier\SupplierProductVariations::findOrFail($id);

    return $variation;
}
// get supplier product attributes data
function get_supplier_attribute_data($id)
{
    $attribute = App\Models\Supplier\SupplierAttribute::findOrFail($id);

    return $attribute;
}

function supplier_product_has_attributes($id)
{
    $product = App\Models\Supplier\SupplierProducts::findOrFail($id);
    $attributes = App\Models\Supplier\SupplierProductAttributes::where('product_id', $product->id)->get();
    if (count($attributes)>0) {
        return true;
    } else {
        return false;
    }
}

function get_supplier_attribute_name($attribute_id)
{
    $attribute = App\Models\Supplier\SupplierAttribute::find($attribute_id);
    if ($attribute !== null) {
        return $attribute->name;
    } else {
        return null;
    }
}

function atrribute_has_more_values($attribute_id)
{
    $p_attr = App\Models\Supplier\SupplierProductAttributes::where('attribute_id', $attribute_id)->get();
    if (count($p_attr) > 1) {
        return true;
    } else {
        return false;
    }
}

function supplier_orders_unreaded()
{
    // get_supplier_data
    $supplier = get_supplier_data(auth()->user()->tenant_id);
    // get supplier orders
    $orders = App\Models\Supplier\SupplierOrders::where('supplier_id', $supplier->id)->where('is_readed', 'false')->get();

    return count($orders);
}

function get_supplier_product_data($product_id)
{
    $product = App\Models\Supplier\SupplierProducts::findOrfail($product_id);

    return $product;
}
// get supplier products ids in array
function get_supplier_products_ids($supplier_id)
{
    $products = App\Models\Supplier\SupplierProducts::where('supplier_id', $supplier_id)->get();
    $ids = [];
    foreach ($products as $product) {
        $ids[] = $product->id;
    }

    return $ids;
}

function get_supplier_subscription_data($supplier_id)
{
    $subscription = App\Models\Supplier\SupplierPlanSubscription::where('supplier_id', $supplier_id)->first();

    return $subscription;
}
// $supplier_id,
function get_supplier_categories($tenant_id)
{
    $slug = tenant_to_slug($tenant_id);
    $categories = App\Models\Category::where('slug', 'like', $slug.'-%')->get();

    return $categories;
}
// check phone visibility autorization
function supplier_order_display_phone($order_id)
{
    $order = App\Models\Supplier\SupplierOrders::findOrFail($order_id);
    if ($order->phone_visiblity == true) {
        return $order->phone;
    } else {
        return '<img src="'.asset('asset/v1/users/dashboard/img/other/lock.png').'" alt="phone" onclick="unlock_phone_number('.$order->id.')" style="cursor: pointer;" />';
    }
}
// check phone visibility autorization
function supplier_order_abandoned_display_phone($order_id)
{
    $order = App\Models\Supplier\SupplierOrderAbandoned::findOrFail($order_id);
    if ($order->phone_visiblity == true) {
        return $order->phone;
    } else {
        return '<img src="'.asset('asset/v1/users/dashboard/img/other/lock.png').'" alt="phone" onclick="unlock_phone_number('.$order->id.')" style="cursor: pointer;" />';
    }
}

function get_shipping_cost($end_point, $wilaya_id, $dayra_id = 0, $baladia_id = 0)
{
    $cost = App\Models\ShippingPrice::where('user_id', get_user_data(tenant('id'))->id)
                                    ->where('wilaya_id', $wilaya_id)
                                    ->first();

    // التأكد من وجود بيانات التسعير
    if (!$cost) {
        return 0; // أو أي قيمة افتراضية مناسبة
    }

    if ($end_point === 'home') {
        if ($dayra_id == 0 && $baladia_id == 0) {
            return $cost->to_home_price ?? 0;
        } else {
            if (get_dayra_data($dayra_id)->ar_name === get_wilaya_data($wilaya_id)->ar_name) {
                return $cost->to_home_price ?? 0;
            } else {
                return ($cost->to_home_price ?? 0) + ($cost->additional_price ?? 0);
            }
        }
    }

    return $cost->stop_desck_price ?? 0;
}

function syncSupplierOrderWithGoogleSheet(App\Models\Supplier\SupplierOrders $order)
{
    // dd(storage_path('app/google-sheets/credentials.json'));
    try {
        // 1. Initialize Google Client
        $client = new Google\Client();

        // 2. Set authentication credentials
        // Correct path - use storage_path() instead of asset()
        $client->setAuthConfig('C:\xampp\htdocs\projects\multi-store\storage/tenantsupplier\google-sheet/credentials.json');
        $client->addScope(Google\Service\Sheets::SPREADSHEETS);

        // 3. Create Sheets service
        $service = new Google\Service\Sheets($client);
        $spreadsheetId = '1B8TIC-w7qqaAG2U9B6-nm2vhquq5kuMc28j9kqAX96Y';

        // 4. Prepare order data for Google Sheet
        $values = [
            [
                $order->created_at->format('Y-m-d H:i:s'), // Formatted datetime
                $order->order_number,
                $order->customer_name,
                $order->phone,
                $order->shipping_address,
                $order->total_price,
                $order->shipping_cost,
                $order->status,
            ],
        ];

        // 5. Prepare request body
        $body = new Google\Service\Sheets\ValueRange([
            'values' => $values,
        ]);

        // 6. Set parameters
        $params = [
            'valueInputOption' => 'USER_ENTERED', // Changed to USER_ENTERED for better formatting
            'insertDataOption' => 'INSERT_ROWS',   // Explicitly insert new rows
        ];

        // 7. Append data to sheet
        $result = $service->spreadsheets_values->append(
            $spreadsheetId,
            'Sheet1!A1:H', // Updated range to match your 8 columns
            $body,
            $params
        );

        // 8. Return success response
        return [
            'success' => true,
            'updated_cells' => $result->getUpdates()->getUpdatedCells(),
            'updated_range' => $result->getUpdates()->getUpdatedRange(),
        ];
    } catch (Exception $e) {
        // 9. Handle errors
        Log::error('Google Sheets sync failed: '.$e->getMessage());

        return [
            'success' => false,
            'error' => $e->getMessage(),
            'order_id' => $order->id,
        ];
    }
}

function is_supplier_has_plan_order($supplier_id)
{
    $order = App\Models\Supplier\SupplierPlanOrder::where('supplier_id', $supplier_id)->where('status', 'pending')->first();
    if ($order) {
        return true;
    } else {
        return false;
    }
}

// function is_ supplier
function is_supplier($tenant_id)
{
    $supplier = App\Models\Supplier\Supplier::where('tenant_id', $tenant_id)->first();
    if ($supplier) {
        return true;
    } else {
        return false;
    }
}

   // function is_supplier_aproved
    function is_supplier_aproved($tenant_id)
    {
        $supplier = App\Models\Supplier\Supplier::where('tenant_id', $tenant_id)->first();
        if ($supplier->approval_status == 'approved') {
            return true;
        } else {
            return false;
        }
    }
    // function is_chargily_settings_exists
    function is_chargily_settings_exists($tenant_id)
    {
        $user = App\Models\User::where('tenant_id', $tenant_id)->first();
        $chagily_settings = $user->chargilySettings;
        if ($chagily_settings) {
            return true;
        } else {
            return false;
        }
    }
    //function is_supplier_bank_account_exists
    function is_supplier_bank_account_exists($tenant_id)
    {
        $user = App\Models\User::where('tenant_id', $tenant_id)->first();
        $bank_account = $user->bank_settings;
        if ($bank_account) {
            return true;
        } else {
            return false;
        }
    }
    //is supplier has avatar
    function is_supplier_has_avatar($tenant_id)
    {
        $supplier = App\Models\Supplier\Supplier::where('tenant_id', $tenant_id)->first();
        if ($supplier->avatar) {
            return true;
        } else {
            return false;
        }
    }
    //get supplier avatar
    function get_supplier_avatar($tenant_id)
    {
        $supplier = App\Models\Supplier\Supplier::where('tenant_id', $tenant_id)->first();
        return $supplier->avatar;
    }
    //
    function is_product_has_coupon($product_id)
    {
        $coupons_products = App\Models\Supplier\SupplierProductsCoupons::where('product_id', $product_id)->get();
        if ($coupons_products->count() !== 0) {
            return true;
        } else {
            return false;
        }
    }

    //
    function get_coupon_discount($product_id,$coupon_code,$user_type)
    {
        //get user type
        $coupon_discount=0;
        if(is_product_has_coupon($product_id))
        {
            if($user_type=='supplier')
            {
              $product=\App\Models\Supplier\SupplierProducts::findOrfail($product_id);  
            }
            elseif($user_type=='seller')
            {
              $product=\App\Models\SellerProducts::findOrfail($product_id);
            }
        
         $coupon=\App\Models\userCoupons::where('code', $coupon_code)->where('is_active', 1)->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->first(); 
         if($coupon && $coupon->is_active==1 && $coupon->start_date<=now() && $coupon->end_date>=now() && $coupon->usage_per_user <= $coupon->usage_limit)
         {
            if($coupon->type=='percent')
            {
                $coupon_discount=($product->price*$coupon->value)/100;
            }
            else
            {
                $coupon_discount=$coupon->value;
            }
            return $coupon_discount;        
         }      
        }
        return $coupon_discount;
    }
    //
    function supplier_product_min_qty($product_id)
    {
        $product=\App\Models\Supplier\SupplierProducts::findOrfail($product_id);
        return $product->minimum_order_qty ?? 1;
    }
