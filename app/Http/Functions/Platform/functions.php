<?php
//get platform data by key
function get_platform_data($key)
{
    return App\Models\PlatformSetting::where('key', $key)->first();
}
//paragraph to slug
function paragraph_to_slug($paragraph)
{
    $words=explode(' ',$paragraph);
    $slug="";
    foreach($words as $index=>$word)
    {
       $slug.=$word;
        if($index<count($words)-1)
        {
            $slug.='-';  
        }
    }
    return $slug;
}
//product name to slug
function product_name_to_slug($product_name)
{
    $words=explode(' ',$product_name);
    $slug="";
    foreach($words as $index=>$word)
    {
       $slug.=$word;
        if($index<count($words)-1)
        {
            $slug.='-';  
        }
    }
    return $slug;
}
//
function get_platform_comition($product_price)
{
    return 10;
}
//plan phone visibilty autorization in normal order
function plan_phone_visibilty_autorization($plan_id)
{
    $plan=App\Models\SupplierPlan::where('id',$plan_id)->first();
    if($plan->price===0)
    {
        return false;
    }else
    {
        return true;
    }
}
//
function get_wilaya_data($id)
{
    $wilaya=App\Models\Wilaya::findOrfail($id);
    if($wilaya==null)
    {
        return 'هذه الولاية غير موجودة';
    }
    return $wilaya;
}
//
function get_dayra_data($id)
{
    $dayra=App\Models\Dayra::findOrfail($id);
    if($dayra==null)
    {
        return 'هذه الدائرة غير موجودة';
    }
    return $dayra;
}
//الفرق بين تاريخين بالأيام
function appDiffInDays($dateA,$dateB)
{

$date1 = Carbon\Carbon::parse($dateA);
$date2 = Carbon\Carbon::parse($dateB);

$diffInDays = $date1->diffInDays($date2);
return $diffInDays;
}
// الأموال المتبقية من الإشتراك الحالي
function get_rest_off_current_supplier_plan($supplier_id, $current_plan_id, $new_plan_id, $rest_days)
{
    $current_plan = App\Models\SupplierPlan::findOrFail($current_plan_id);
    $new_plan = App\Models\SupplierPlan::findOrFail($new_plan_id);


    $current_subscription = App\Models\SupplierPlanSubscription::where('supplier_id', $supplier_id)->first();

    if (!$current_subscription || $current_subscription->duration == 0 || $current_subscription->plan_id==1) {
        return 0;
    }

    // حساب السعر اليومي للاشتراك الحالي
    //$day_price = $current_plan->price / $current_subscription->duration;
    $day_price = $current_subscription->price / $current_subscription->duration;

    // القيمة المتبقية
    $rest_off_current_plan = $day_price * $rest_days;

    // تقريب لرقمين بعد الفاصلة
    return round($rest_off_current_plan, 2);
}
//
function get_plan_price_from_id_and_duration($plan_id, $duration)
{
    $plan = App\Models\SupplierPlan::findOrFail($plan_id);
    if($plan->prices != null)
    {
        return $plan->prices->where('duration', $duration)->first()->price;
    }
    return $plan->price ;
}
