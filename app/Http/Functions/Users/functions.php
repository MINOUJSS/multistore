<?php

//get tenant data
function get_tenant_data($tenant_id)
{
    $tenant=App\Models\Tenant::find($tenant_id);
    return $tenant;
}
//tenant to slug
function tenant_to_slug($tenant_id)
{
    $tenant=explode('.',$tenant_id);
    if(count($tenant)>1){
        return $tenant[0].'-'.$tenant[1];
    }else{
        return $tenant[0];
    }
}
//get user data
function get_user_data_from_id($user_id)
{
    $user=App\Models\User::find($user_id);
    return $user;
}
//
function get_user_data_from_supplier_id($supplier_id)
{
    $supplier=App\Models\Supplier::findOrfail($supplier_id);
    $user=get_user_data($supplier->tenant_id);
    return $user;
}
function get_user_data($tenant_id)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    return $user;
}
//get user store settings by key
function get_user_store_settings($tenant_id,$key)
{
    $user=App\Models\User::where('tenant_id',$tenant_id)->first();
    $setting=App\Models\UserStoreSetting::where('user_id',$user->id)->where('key',$key)->first();
    return $setting;
}
//display facebook pixel
function display_facebook_pixel()
{
    //get supplier fb pixels
    $apps=App\Models\UserApps::where('user_id',get_user_data(tenant('id'))->id)->where('app_name','facebook_pixel')->get();
    $html='';
    foreach($apps as $app){
        $pixel_id=json_decode($app->data)->pixel_id;
        if($app->status=='active'){
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

//display Google analytics
function display_google_analytics()
{
    //get supplier google analytics
    $apps=App\Models\UserApps::where('user_id',get_user_data(tenant('id'))->id)->where('app_name','google_analytics')->get();
    $html='';
    foreach($apps as $app){
        // معرف التتبع العام (يمكن تغييره وفقًا للمستخدم)
        $measurement_id=json_decode($app->data)->tracking_id;  
    // كود Google Analytics
    if($app->status=='active'){
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

//display tiktok pixel
function display_tiktok_pixel()
{
    $apps=App\Models\UserApps::where('user_id',get_user_data(tenant('id'))->id)->where('app_name','tiktok_pixel')->get();
    $html='';
    foreach($apps as $app){
        // معرف التتبع العام (يمكن تغييره وفقًا للمستخدم)
        $pixel_id=json_decode($app->data)->pixel_id;
        if($app->status=='active'){ 
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
//
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LastSeen;

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
            'user_id'      => $userId,
            'ip_address'   => $ipAddress,
            'device'       => $userAgent,
            'browser'      => $userAgent,
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

