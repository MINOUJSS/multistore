<?php

// get platform data by key
function get_platform_data($key)
{
    return App\Models\PlatformSetting::where('key', $key)->first();
}
// paragraph to slug
function paragraph_to_slug($paragraph)
{
    $words = explode(' ', $paragraph);
    $slug = '';
    foreach ($words as $index => $word) {
        $slug .= $word;
        if ($index < count($words) - 1) {
            $slug .= '-';
        }
    }

    return $slug;
}
// product name to slug
function product_name_to_slug($product_name)
{
    $words = explode(' ', $product_name);
    $slug = '';
    foreach ($words as $index => $word) {
        $slug .= $word;
        if ($index < count($words) - 1) {
            $slug .= '-';
        }
    }

    return $slug;
}

function get_platform_comition($product_price)
{
    return 10;
}
// get_order_abandoned_comition
function get_order_abandoned_comition($plan_id)
{
    if ($plan_id == 1) {
        return 10;
    } elseif ($plan_id == 2) {
        return 5;
    } else {
        return 0;
    }
}
// plan phone visibilty autorization in normal order
function plan_phone_visibilty_autorization($plan_id, $customer_name)
{
    $plan = App\Models\Supplier\SupplierPlan::where('id', $plan_id)->first();

    if (get_user_data(tenant('id'))->freeOrder->quantity > 0 && strcasecmp($customer_name, 'test') !== 0) {
        $quntity = get_user_data(tenant('id'))->freeOrder->quantity;
        // if is free plan decrement quntity
        if ($plan->id == 1) {
            $quntity = $quntity - 1;
        }

        get_user_data(tenant('id'))->freeOrder->update(['quantity' => $quntity]);

        return true;
    }

    if ($plan->id != 1) {
        return true;
    }

    return false;
}

function get_wilaya_data($id)
{
    $wilaya = App\Models\Wilaya::find($id);
    if ($wilaya == null) {
        return 'هذه الولاية غير موجودة';
    }

    return $wilaya;
}

function get_dayra_data($id)
{
    $dayra = App\Models\Dayra::find($id);
    if ($dayra == null) {
        return 'هذه الدائرة غير موجودة';
    }

    return $dayra;
}

function get_baladia_data($id)
{
    $baladia = App\Models\Baladia::find($id);
    if ($baladia == null) {
        return 'هذه البلدية غير موجودة';
    }

    return $baladia;
}
// get dayras of wilaya
function get_dayras_of_wilaya($wilaya_id)
{
    $wilaya = App\Models\Wilaya::find($wilaya_id);

    if ($wilaya) {
        return $wilaya->dayras;
    } else {
        return null;
    }
}
// get baladias of dayra
function get_baladias_of_dayra($dayra_id)
{
    $dayra = App\Models\Dayra::find($dayra_id);
    if ($dayra) {
        return $dayra->baladias;
    } else {
        return null;
    }
}
// الفرق بين تاريخين بالأيام
function appDiffInDays($dateA, $dateB)
{
    $date1 = Carbon\Carbon::parse($dateA);
    $date2 = Carbon\Carbon::parse($dateB);

    $diffInDays = $date1->diffInDays($date2);

    return $diffInDays;
}
// الأموال المتبقية من الإشتراك الحالي
function get_rest_off_current_supplier_plan($supplier_id, $current_plan_id, $new_plan_id, $rest_days)
{
    $current_plan = App\Models\Supplier\SupplierPlan::findOrFail($current_plan_id);
    $new_plan = App\Models\Supplier\SupplierPlan::findOrFail($new_plan_id);

    $current_subscription = App\Models\Supplier\SupplierPlanSubscription::where('supplier_id', $supplier_id)->first();

    if (!$current_subscription || $current_subscription->duration == 0 || $current_subscription->plan_id == 1) {
        return 0;
    }

    // حساب السعر اليومي للاشتراك الحالي
    // $day_price = $current_plan->price / $current_subscription->duration;
    $day_price = $current_subscription->price / $current_subscription->duration;

    // القيمة المتبقية
    $rest_off_current_plan = $day_price * $rest_days;

    // تقريب لرقمين بعد الفاصلة
    return round($rest_off_current_plan, 2);
}

// الأموال المتبقية من الإشتراك الحالي
function get_rest_off_current_seller_plan($seller_id, $current_plan_id, $new_plan_id, $rest_days)
{
    $current_plan = App\Models\Seller\SellerPlan::findOrFail($current_plan_id);
    $new_plan = App\Models\Seller\SellerPlan::findOrFail($new_plan_id);

    $current_subscription = App\Models\Seller\SellerPlanSubscription::where('seller_id', $seller_id)->first();

    if (!$current_subscription || $current_subscription->duration == 0 || $current_subscription->plan_id == 1) {
        return 0;
    }

    // حساب السعر اليومي للاشتراك الحالي
    // $day_price = $current_plan->price / $current_subscription->duration;
    $day_price = $current_subscription->price / $current_subscription->duration;

    // القيمة المتبقية
    $rest_off_current_plan = $day_price * $rest_days;

    // تقريب لرقمين بعد الفاصلة
    return round($rest_off_current_plan, 2);
}

function get_plan_price_from_id_and_duration($plan_id, $duration)
{
    $plan = App\Models\Supplier\SupplierPlan::findOrFail($plan_id);
    if ($plan->prices != null) {
        return $plan->prices->where('duration', $duration)->first()->price;
    }

    return $plan->price;
}
// getplatform name
function get_platform_name()
{
    return 'متاجر الجزائر';
}

function is_cart_has_this_product($product_id)
{
    $cart = session()->get('cart');
    if (isset($cart->items[$product_id]) && $cart->items[$product_id] != null) {
        return true;
    }

    return false;
}

function get_order_status_class($status)
{
    switch ($status) {
        case 'pending':
            return 'text-warning table-warning';
        case 'processing':
            return 'text-warning table-primary';
        case 'shipped':
            return 'text-warning table-info';
        case 'delivered':
            return 'text-warning table-info table-success';
        case 'canceled':
            return 'text-warning table-info table-danger';
        default:
            return 'text-warning table-info';
    }
}

function getYoutubeVideoId($url)
{
    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);

    return $matches[1] ?? null;
}
// vimeo
function get_vimeo_id(string $url): ?string
{
    // Match both "vimeo.com/123456789" and "player.vimeo.com/video/123456789"
    preg_match('/(?:vimeo\.com\/(?:video\/)?)([0-9]+)/', $url, $matches);

    return $matches[1] ?? null;
}
