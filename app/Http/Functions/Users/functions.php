<?php

// get tenant data
function get_tenant_data($tenant_id)
{
    $tenant = App\Models\Tenant::find($tenant_id);

    return $tenant;
}
// get tenant data
function get_tenant_data_by_type($tenant_id)
{
    $user = get_user_data($tenant_id);
    if ($user->type == 'supplier') {
        $result = App\Models\Supplier\Supplier::where('tenant_id', $tenant_id)->first();
    } elseif ($user->type == 'seller') {
        $result = App\Models\Seller::where('tenant_id', $tenant_id)->first();
    }

    return $result;
}
// tenant to slug
function tenant_to_slug($tenant_id)
{
    $tenant = explode('.', $tenant_id);
    if (count($tenant) > 1) {
        return $tenant[0].'-'.$tenant[1];
    } else {
        return $tenant[0];
    }
}
// get user data
function get_user_data_from_id($user_id)
{
    $user = App\Models\User::find($user_id);

    return $user;
}

function get_user_data_from_supplier_id($supplier_id)
{
    $supplier = App\Models\Supplier\Supplier::findOrfail($supplier_id);
    $user = get_user_data($supplier->tenant_id);

    return $user;
}
function get_user_data($tenant_id)
{
    $user = App\Models\User::where('tenant_id', $tenant_id)->first();

    return $user;
}
// get user store settings by key
function get_user_store_settings($tenant_id, $key)
{
    $user = App\Models\User::where('tenant_id', $tenant_id)->first();
    $setting = App\Models\UserStoreSetting::where('user_id', $user->id)->where('key', $key)->first();

    return $setting;
}
// display facebook pixel
function display_facebook_pixel()
{
    // get supplier fb pixels
    $apps = App\Models\UserApps::where('user_id', get_user_data(tenant('id'))->id)->where('app_name', 'facebook_pixel')->get();
    $html = '';
    foreach ($apps as $app) {
        $pixel_id = json_decode($app->data)->pixel_id;
        if ($app->status == 'active') {
            $html .= <<<HTML
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;
      n.push=n;
      n.loaded=!0;
      n.version='2.0';
      n.queue=[];
      t=b.createElement(e);t.async=!0;
      t.src=v;
      s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)
      }(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      
      fbq('init', '$pixel_id'); 
      fbq('track', 'PageView');
    </script>
    <noscript>
      <img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=$pixel_id&ev=PageView&noscript=1"/>
    </noscript>
    HTML;
        }
    }

    return $html;
}

// display Google analytics
function display_google_analytics()
{
    // get supplier google analytics
    $apps = App\Models\UserApps::where('user_id', get_user_data(tenant('id'))->id)->where('app_name', 'google_analytics')->get();
    $html = '';
    foreach ($apps as $app) {
        // معرف التتبع العام (يمكن تغييره وفقًا للمستخدم)
        $measurement_id = json_decode($app->data)->tracking_id;
        // كود Google Analytics
        if ($app->status == 'active') {
            $html .= <<<HTML
    <script async src="https://www.googletagmanager.com/gtag/js?id=$measurement_id"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){ dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', '$measurement_id'); // معرف التتبع الخاص بك
    </script>
    HTML;
        }
    }

    return $html;
}

// display tiktok pixel
function display_tiktok_pixel()
{
    $apps = App\Models\UserApps::where('user_id', get_user_data(tenant('id'))->id)->where('app_name', 'tiktok_pixel')->get();
    $html = '';
    foreach ($apps as $app) {
        // معرف التتبع العام (يمكن تغييره وفقًا للمستخدم)
        $pixel_id = json_decode($app->data)->pixel_id;
        if ($app->status == 'active') {
            $html .= <<<HTML
    <script>
      !function (w, d, t) {
        w.TiktokAnalyticsObject=t;
        var ttq=w[t]=w[t]||[];
        ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"];
        ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};
        for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);
        ttq.instance=function(t){var e=ttq._i[t]||[];for(var n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e};
        ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";
        ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},
        ttq._o[e]=n||{};
        var o=document.createElement("script");
        o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;
        var a=document.getElementsByTagName("script")[0];
        a.parentNode.insertBefore(o,a)};
        ttq.load('$pixel_id'); 
        ttq.page();
      }(window, document, 'ttq');
    </script>
    HTML;
        }
    }

    return $html;
}

function display_microsoft_clarity()
{
    $apps = App\Models\UserApps::where('user_id', get_user_data(tenant('id'))->id)
        ->where('app_name', 'clarity')
        ->get();

    $html = '';

    foreach ($apps as $app) {
        if ($app->status === 'active') {
            $project_id = json_decode($app->data)->clarity_id ?? null;

            if ($project_id) {
                $html .= <<<HTML
<script type="text/javascript">
(function(c,l,a,r,i,t,y){
    c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
    t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
    y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
})(window, document, "clarity", "script", "{$project_id}");
</script>
HTML;
            }
        }
    }

    return $html;
}

use App\Models\LastSeen;
use Illuminate\Support\Facades\Auth;

function last_seen_user()
{
    $request = request(); // يمكنك أيضًا استخدام Illuminate\Support\Facades\Request::instance()

    // الحصول على عنوان IP بأكثر طريقة موثوقة ممكنة
    $ipAddress = getRealIpAddress();

    // معلومات الجهاز والمتصفح
    $userAgent = $request->header('User-Agent') ?? 'unknown';

    // معرف المستخدم إذا كان مسجلاً
    $userId = Auth::check() ? Auth::id() : null;

    // التحقق من وجود زيارة مسجلة اليوم
    $existingVisit = LastSeen::where('user_id', $userId)
        ->where('ip_address', $ipAddress)
        ->whereDate('last_seen_at', now()->toDateString())
        ->first();

    // إذا لم توجد زيارة، سجل واحدة جديدة
    if (!$existingVisit) {
        LastSeen::create([
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'device' => $userAgent,
            'browser' => $userAgent,
            'last_seen_at' => now(),
        ]);
    }
}
function getRealIpAddress()
{
    $request = request();

    if ($request->server('HTTP_X_FORWARDED_FOR')) {
        return explode(',', $request->server('HTTP_X_FORWARDED_FOR'))[0];
    }

    return $request->getClientIp() ?? $request->server('REMOTE_ADDR') ?? 'unknown';
}

function is_valid_coupon_for_orders(App\Models\userCoupons $coupon = null, $cart_amount, $user_type)
{
    // // search supplier products and categories
    // if ($user_type == 'supplier') {
    //     $coupons_products = App\Models\Supplier\SupplierProductsCoupons::all();
    //     if ($coupons_products->count() !== 0) {
    //         foreach ($coupons_products as $item) {
    //             if ($item->coupon_id == $coupon->id) {
    //                 return false;
    //             }
    //         }
    //     }
    //     $coupons_categories = App\Models\UserCategoriesCoupons::all();
    //     if ($coupons_categories->count() !== 0) {
    //         foreach ($coupons_categories as $item) {
    //             if ($item->coupon_id == $coupon->id) {
    //                 return false;
    //             }
    //         }
    //     }

        

    //     //return true;
    // } else {
    //     $coupon = \App\Models\userCoupons::find($coupon_id);
    //     if ($coupon && $coupon->is_active == 1 && $coupon->start_date <= now() && $coupon->end_date >= now() && $coupon->min_order_amount <= $cart_amount && $coupon->usage_per_user <= $coupon->usage_limit) {
    //         return true;
    //     }
    // }

    // return false;
    // $coupon = \App\Models\userCoupons::find($coupon_id);
        if ($coupon != null && $coupon->is_active == 1 && $coupon->start_date <= now() && $coupon->end_date >= now() && $coupon->min_order_amount <= $cart_amount && $coupon->usage_per_user <= $coupon->usage_limit) {
            return true;
        }else
        {
            return false;
        }
}

function is_valid_coupon_for_product(App\Models\userCoupons $coupon, $cart_amount, $user_type, $product_id)
{
    // search supplier products and categories
    if ($user_type == 'supplier') {
        $coupons_products = App\Models\Supplier\SupplierProductsCoupons::all();
        if ($coupons_products->count() !== 0) {
            foreach ($coupons_products as $item) {
                if ($item->coupon_id == $coupon->id && $item->product_id == $product_id) {
                    return true;
                }
            }
        }
    }

    return false;
}

function is_blocked_customer($user_id, $order_id)
{
    $order = App\Models\Supplier\SupplierOrders::findOrfail($order_id);
    $ip_address = $order->ip_address;
    $device_fingerprint = $order->device_fingerprint;
    $is_blocked = App\Models\UserBlockedCustomers::where('user_id', $user_id)->where('ip_address', $ip_address)->where('device_fingerprint', $device_fingerprint)->exists();
    if ($is_blocked) {
        return true;
    } else {
        return false;
    }
}
//
function is_verment_settings_exists($tenant_id)
{
    $user = App\Models\User::where('tenant_id', $tenant_id)->first();
    $verment_settings = $user->bank_settings()->exists();
    if ($verment_settings) {
        return true;
    } else {
        return false;
    }
}
