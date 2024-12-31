<?php
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
    return json_decode($setting->value)->primarycolor ?? '#343035';
}
//get store color logo
function get_store_logo($tenant_id)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    $setting=App\Models\UserStoreSetting::where('user_id',$user->id)->where('key','store_logo')->first();
    return $setting->value ?? '/asset/users/store/img/logo/store.png';
}
//
function get_store_body_text_color($tenant_id)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    $setting=App\Models\UserStoreSetting::where('user_id',$user->id)->where('key','store_theme')->first();
    return json_decode($setting->value)->bodytextcolor ?? '#000000';
}
//
function get_store_footer_text_color($tenant_id)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    $setting=App\Models\UserStoreSetting::where('user_id',$user->id)->where('key','store_theme')->first();
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
//create default supplier categories
function create_default_supplier_categories($user)
{

}
//create default supplier products
function create_default_supplier_products($user)
{

}
