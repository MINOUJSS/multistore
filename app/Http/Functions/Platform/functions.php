<?php
//get platform data by key
function get_platform_data($key)
{
    return App\Models\PlatformSetting::where('key', $key)->first();
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