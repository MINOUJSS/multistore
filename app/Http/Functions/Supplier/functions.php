<?php

use App\models\SupplierProductVariations;
//function to chicke if supplier folder exists
function supplier_exists($store_name)
{
    //find the store
    $store=App\Models\Tenant::find($store_name.'.supplier');
    if($store==null)
    {
        return true;
    }
    else
    {
        return false;
    }

}
//get tenant id from supplier id
function get_tenant_id_from_supplier($supplier_id)
{
    $supplier=App\Models\Supplier::findOrfail($supplier_id);
    return $supplier->tenant_id;
}
//get supplier store name
function get_supplier_store_name($tenant_id)
{
    $store_name=explode('.',$tenant_id);
    return $store_name[0];
}
//get supplier status
function get_supplier_status($tenant_id)
{
    $supplier=App\Models\Supplier::where('tenant_id',$tenant_id)->first();
    return $supplier->status;
}
//get supplier data
function get_supplier_data($tenant_id)
{
    $supplier=App\Models\Supplier::where('tenant_id',$tenant_id)->first();
    return $supplier;
}
//get supplier plan data
function get_supplier_plan_data($plan_id)
{
    $plan=App\Models\SupplierPlan::where('id',$plan_id)->first();
    return $plan;
}
//has supplier settings
function has_supplier_settings($tenant_id)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    $setting=App\Models\UserStoreSetting::where('user_id',$user->id)->first();
    if($setting!==null)
    {
        return true;
    }else
    {
        return false;
    }
    
}
//create default supplier store settings
function create_supplier_store_settings($user,$request)
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
   $setting= new App\Models\UserStoreSetting;
    //add store name
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_name',
        'value' => $request->store_name,
        'type' => 'string',
        'description' => 'إسم المتجر',
        'status' => 'active',
    ]);
       //add store description
       $setting->create([
        'user_id' => $user->id,
        'key' => 'store_description',
        'value' => 'تكلم عن نشاطك التجاري',
        'type' => 'string',
        'description' => 'وصف المتجر',
        'status' => 'active',
    ]);
    //add store email
    $setting->create([
       'user_id' => $user->id,
       'key' => 'store_email',
       'value' => $request->email,
       'type' => 'string',
       'description' => 'البريد الإلكتروني للمتجر',
       'status' =>'active',
    ]);
    //add store address
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_address',
        'value' => 'عنوان متجرك',
        'type' => 'string',
        'description' => 'عنوان المتجر',
        'status' => 'active',
    ]);
    //add store phone
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_phone',
        'value' => '0660000000',
        'type' => 'string',
        'description' => 'رقم المتجر',
        'status' => 'active',
    ]);
    //add store logo
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_logo',
        'value' => '/asset/users/store/img/logo/store.png',
        'type' => 'string',
        'description' => 'لوجو المتجر',
        'status' => 'active',
    ]);
    //add store language
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_language',
        'value' => 'ar',
        'type' => 'string',
        'description' => 'لغة المتجر',
        'status' => 'active',
    ]);
    //add store currency
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_currency',
        'value' => 'DZD',
        'type' => 'string',
        'description' => 'عملة المتجر',
        'status' => 'active',
    ]);
    //add store theme
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_theme',
        'value' => '{"primarycolor":"#343035","primaryfontcolor":"#ffffff", "secondarycolor":"#000000"}',
        'type' => 'string',
        'description' => 'تصميم المتجر',
        'status' => 'active',
    ]);
    //add store favicon
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_favicon',
        'value' => '/asset/users/store/img/logo/store.png',
        'type' => 'string',
        'description' => 'لوجو المتجر',
        'status' => 'active',
    ]);
    //add store facebook
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_facebook',
        'value' => 'facebook.com',
        'type' => 'string',
        'description' => 'صفحة فيسبوك المتجر',
        'status' => 'active',
    ]);
    //add store telegram
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_telegram',
        'value' => 'telegram.com',
        'type' => 'string',
        'description' => 'صفحة تيليجرام المتجر',
        'status' => 'active',
    ]);
    //add store tiktok
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_tiktok',
        'value' => 'tiktok.com',
        'type' => 'string',
        'description' => 'صفحة تيك توك المتجر',
        'status' => 'active',
    ]);
    //add store twitter
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_twitter',
        'value' => 'twitter.com',
        'type' => 'string',
        'description' => 'صفحة تويتر المتجر',
        'status' => 'active',
    ]);
    //add store instagram
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_instagram',
        'value' => 'instagram.com',
        'type' => 'string',
        'description' => 'صفحة انستقرام المتجر',
        'status' => 'active',
    ]);
    //add store youtube
    $setting->create([
        'user_id' => $user->id,
        'key' => 'store_youtube',
        'value' => 'youtube.com',
        'type' => 'string',
        'description' => 'صفحة يوتيوب المتجر',
        'status' => 'active',
    ]);
    //add copyright
    $setting->create([
        'user_id' => $user->id,
        'key' => 'copyright',
        'value' => 'copyright',
        'type' => 'string',
        'description' => 'حقوق النشر',
        'status' => 'active',
    ]);
    //add google_analytics
    $setting->create([
        'user_id' => $user->id,
        'key' => 'google_analytics',
        'value' => 'enter google analytics code here',
        'type' => 'string',
        'description' => 'تتبع المتجر',
        'status' => 'active',
    ]);
    //add facebook pixel
    $setting->create([
        'user_id' => $user->id,
        'key' => 'facebook_pixel',
        'value' => 'enter facebook pixel code here',
        'type' => 'string',
        'description' => '',
        'status' => 'active',
    ]);
}
//
function get_store_parimary_color($tenant_id)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    $setting=App\Models\UserStoreSetting::where('user_id',$user->id)->where('key','store_theme')->first();
    if($setting==null)
    {
        return '#343035';
    }
    return json_decode($setting->value)->primarycolor ?? '#343035';
}
//get store color logo
function get_store_logo($tenant_id)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    $setting=App\Models\UserStoreSetting::where('user_id',$user->id)->where('key','store_logo')->first();
    if($setting==null)
    {
        return '/asset/users/store/img/logo/store.png';
    }
    return $setting->value ?? '/asset/users/store/img/logo/store.png';
}
//
function get_store_body_text_color($tenant_id)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    $setting=App\Models\UserStoreSetting::where('user_id',$user->id)->where('key','store_theme')->first();
    if($setting==null)
    {
        return '#000000';
    }
    return json_decode($setting->value)->bodytextcolor ?? '#000000';
}
//
function get_store_footer_text_color($tenant_id)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    $setting=App\Models\UserStoreSetting::where('user_id',$user->id)->where('key','store_theme')->first();
    if($setting==null)
    {
        return '#ffffff';
    }
    return json_decode($setting->value)->footertextcolor ?? '#ffffff';
}
//create default supplier dashboard settings
function create_supplier_dashboard_settings($user,$request)
{
        //add store name to dashboard
        $user->dashboard_settings()->create([
            'key' => 'store_name',
            'value' => $request->store_name,
            'type' => 'string',
            'description' => 'إسم المتجر',
            'status' => 'active',
        ]);
        //add theme
        $user->dashboard_settings()->create([
            'key' => 'dashboard_theme',
            'value' => 'default',
            'type' => 'string',
            'description' => 'تصميم لوحة التحكم',
            'status' => 'active',
        ]);
}
//get_supplier_product_category
function get_supplier_product_category($product_id)
{
    $product=App\models\SupplierProducts::findOrFail($product_id);
    if ($product->category_id!==null)
    {
        $category=App\models\Category::findOrFail($product->category_id);
        return $category->name;
    }else
    {
        return 'بدون تصنيف';
    }
   
}
//get_supplier_product_price
function get_supplier_product_price($product_id)
{
  $product=App\models\SupplierProducts::findOrFail($product_id);
  if($product->activeDiscount)
  {
    $price=$product->price - $product->activeDiscount->discount_amount;
    return $price;
  }else
  {
    return $product->price;
  }
}
//s_p_has_free_shipping(
function s_p_has_free_shipping($product_id)
{
    $product=App\models\SupplierProducts::findOrFail($product_id);
    if($product->free_shipping=='yes')
    {
        return 'نعم';
    }else
    {
        return 'لا';
    }
}
//supplier_product_has_discount
function supplier_product_has_discount($id)
{
    $product=App\models\SupplierProducts::findOrFail($id);
    $discount=App\models\SupplierProductDiscounts::where('product_id',$product->id)->where('status','active')
                                                    ->whereDate('start_date', '<=', now())
                                                    ->whereDate('end_date', '>=', now())  
                                                    ->first();
    if($discount!==null)
    {
        return true;
    }else
    {
        return false;
    }
}
//
function supplier_product_has_variations($id)
{
    $product=App\models\SupplierProducts::findOrFail($id);
    $vartiations=App\models\SupplierProductVariations::where('product_id',$product->id)->get();
    if($vartiations!==null)
    {
        return true;
    }else
    {
        return false;
    }
}
//
function supplier_product_has_attributes($id)
{
    $product=App\models\SupplierProducts::findOrFail($id);
    $attributes=App\models\SupplierProductAttributes::where('product_id',$product->id)->get();
    if($attributes!==null)
    {
        return true;
    }else
    {
        return false;
    }
}
//
function get_supplier_attribute_name($attribute_id)
{
    $attribute=App\Models\SupplierAttribute::find($attribute_id);
    if($attribute!==null)
    {
        return $attribute->name;
    }else
    {
        return null;
    }
}
//
function atrribute_has_more_values($attribute_id)
{
    $p_attr=App\Models\SupplierProductAttributes::where('attribute_id',$attribute_id)->get();
    if(count($p_attr)>1)
    {
        return true;
    }else
    {
        return false;
    }
}
//
function supplier_orders_unreaded()
{
    //get_supplier_data
    $supplier=get_supplier_data(auth()->user()->tenant_id);
    //get supplier orders
    $orders=App\Models\SupplierOrders::where('supplier_id',$supplier->id)->where('is_readed','false')->get();
    return count($orders);;
}
//
function get_supplier_product_data($product_id)
{
    $product=App\Models\SupplierProducts::findOrfail($product_id);
    return $product;
}
//
function get_supplier_subscription_data($supplier_id)
{
    $subscription=App\Models\SupplierPlanSubscription::where('supplier_id',$supplier_id)->first();
    return $subscription;
}
//
function get_supplier_categories($supplier_id,$tenant_id)
{
    $slug=tenant_to_slug($tenant_id);
    $categories=App\Models\Category::where('slug','like',$slug.'-%')->get();
    return $categories;
}
//check phone visibility autorization
function supplier_order_display_phone($order_id)
{
    $order = App\Models\SupplierOrders::findOrFail($order_id);
    if ($order->phone_visiblity==true) {
        return $order->phone;
    } else {
        return '<img src="' . asset('asset/users/dashboard/img/other/lock.png') . '" alt="phone" onclick="unlock_phone_number(' . $order->id . ')" style="cursor: pointer;" />';
    }
}