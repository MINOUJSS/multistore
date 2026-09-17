<!doctype html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--supplier meta-->
    @yield('meta')
    @if(isset($product))
    <!-- opimazetion meta -->
    <meta property="og:type" content="product">
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($product->description), 160) }}">
    <meta property="og:image" content="{{ asset('storage/'.$product->image) }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $product->name }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($product->description), 160) }}">
    <meta name="twitter:image" content="{{ asset('storage/'.$product->image) }}">
    @endif
    <!---->
    <link rel="icon" type="image/png" href="{{ asset(get_store_logo(tenant('id'))) }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <!-- fonts -->
    <!-- font -->
    <link rel="stylesheet" href="{{ asset('asset/v1/users/store') }}/fonts/all.css">
    <link rel="stylesheet" href="{{ asset('asset/v1/users/store') }}/css/appfont.css">
    <!-- supplier fonts -->
    @yield('fonts')
    <!-- style -->
    <link rel="stylesheet" href="{{ asset('asset/v1/users/store') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('asset/v1/users/store') }}/css/default-theme.css">
    <link rel="stylesheet" href="{{ asset('asset/v1/users/store') }}/css/appmedia.css">
    <!-- supplier style -->
    @yield('header_style')
    <!-- js files -->
    @yield('header_js')
    <!-- fcb pixles -->
    {!! display_facebook_pixel() !!}
    <!-- google analytics -->
    {!! display_google_analytics() !!}
    <!-- tiktok pixel -->
    {!! display_tiktok_pixel() !!}
    <!--microsoft_clarity-->
    {!! display_microsoft_clarity() !!}
    <!--style-->
    @yield('style')
</head>

<body>
    <!-- end general container -->
    <div class="container-fluid">
        <!-- start header -->
        <section class="header">
            @yield('navbar')

            @yield('cart')
        </section>
        <!-- end header -->

        <!-- start main -->
        <section class="main">
            <div class="container-fluid">
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </section>
        <!-- end main -->

        <!-- start footer -->
        @php
            $tenantModel = get_tenant_data(tenant('id'));
            $tenantDomain = optional($tenantModel?->domains?->first())->domain ?? request()->getHost();
            $tenantBaseUrl = url(request()->server('REQUEST_SCHEME') . '://' . $tenantDomain);

            $tenantPagesData = get_tenant_data_by_type(tenant('id'));
            $pages = $tenantPagesData?->pages ?? collect();

            $pageAbout = $pages->firstWhere('slug', 'about') ?? $pages->get(0);
            $pageShipping = $pages->firstWhere('slug', 'shipping-policy') ?? $pages->get(1);
            $pagePayment = $pages->firstWhere('slug', 'payment-policy') ?? $pages->get(2);
            $pageTerms = $pages->firstWhere('slug', 'terms-of-use') ?? $pages->get(3);
            $pageExchange = $pages->firstWhere('slug', 'exchange-policy') ?? $pages->get(4);
            $pagePrivacy = $pages->firstWhere('slug', 'privacy-policy') ?? $pages->get(5);
            $pageContact = $pages->firstWhere('slug', 'contact-us') ?? $pages->get(6);
            $pageFaq = $pages->firstWhere('slug', 'faq') ?? $pages->get(7);

            $userData = get_user_data(tenant('id'));
            $storeSettings = $userData ? get_store_settings($userData->id) : collect();
            $storeAddressSetting = $storeSettings->firstWhere('key', 'store_address') ?? $storeSettings->get(3);
            $storeEmailSetting = $storeSettings->firstWhere('key', 'store_email') ?? $storeSettings->get(2);

            $storeFacebook = get_user_store_settings(tenant('id'), 'store_facebook');
            $storeInstagram = get_user_store_settings(tenant('id'), 'store_instagram');
            $storeTelegram = get_user_store_settings(tenant('id'), 'store_telegram');
            $storeTiktok = get_user_store_settings(tenant('id'), 'store_tiktok');
            $storeTwitter = get_user_store_settings(tenant('id'), 'store_twitter');
            $storeYoutube = get_user_store_settings(tenant('id'), 'store_youtube');

            $storeCopyright = $userData?->storeCopyright?->first()?->value ?? ($userData?->name ?? 'dzora');

            $paymentMethods = get_store_payment_methods(tenant('id'));
            $sellerData = is_seller(tenant('id')) ? get_seller_data(tenant('id')) : null;
            $supplierData = is_supplier(tenant('id')) ? get_supplier_data(tenant('id')) : null;
        @endphp
        <section class="footer">
            <div class="container">
                <div class="footer-brand text-center">
                    <a href="{{ $tenantBaseUrl }}"><img
                            src="{{ asset(get_store_logo(tenant('id'))) }}" width="50px" height="50px"
                            alt="logo"></a>
                </div>
                <hr>
                <div class="row footer-body">
                    <div class="col-md-3 footer-card" @if(($pageAbout?->status !== 'published') && ($pageShipping?->status !== 'published') && ($pagePayment?->status !== 'published')) style="display: none;" @endif>
                        <h5 class="footer-title">عن المتجر</h5>
                        <hr class="title-underline">
                        <ul class="footer-ul">
                            @if ($pageAbout?->status === 'published')
                                <li class="footer-li"><a
                                        href="{{ $tenantBaseUrl }}/about">عن
                                        المتجر</a></li>
                            @endif
                            @if ($pageShipping?->status === 'published')
                                <li class="footer-li"><a
                                        href="{{ $tenantBaseUrl }}/shipping-policy">الشحن
                                        و التسليم</a></li>
                            @endif
                            @if ($pagePayment?->status === 'published')
                                <li class="footer-li"><a
                                        href="{{ $tenantBaseUrl }}/payment-policy">طرق
                                        الدفع</a></li>
                            @endif
                        </ul>
                        <ul class="footer-ul d-flex">
                            {{-- if is seller --}}
                            @if(is_seller(tenant('id')))
                                @if (($sellerData?->plan_subscription?->id ?? 1) !== 1)
                                    @if (($paymentMethods?->Chargily_Pay?->status ?? '') === 'active')
                                        <li class="footer-li p-1"><img
                                                src="{{ asset('asset/v1/users/store') }}/img/payments/eldhahabia.png"
                                                alt="" width="30px"></li>
                                        <li class="footer-li p-1"><img
                                                src="{{ asset('asset/v1/users/store') }}/img/payments/cib.png"
                                                alt="" width="30px"></li>
                                    @endif
                                    @if (($paymentMethods?->BaridiMob?->status ?? '') === 'active')
                                        <li class="footer-li p-1"><img
                                                src="{{ asset('asset/v1/users/store') }}/img/payments/baridimaobe.png"
                                                alt="" width="30px"></li>
                                    @endif
                                    @if (($paymentMethods?->Ccp?->status ?? '') === 'active')
                                        <li class="footer-li p-1"><img
                                                src="{{ asset('asset/v1/users/store') }}/img/payments/algerie post.png"
                                                alt="" width="30px"></li>
                                    @endif
                                @endif
                            @elseif(is_supplier(tenant('id')))
                                {{-- else if is supplier --}}
                                @if (($supplierData?->plan_subscription?->id ?? 1) !== 1)
                                    @if (($paymentMethods?->Chargily_Pay?->status ?? '') === 'active')
                                        <li class="footer-li p-1"><img
                                                src="{{ asset('asset/v1/users/store') }}/img/payments/eldhahabia.png"
                                                alt="" width="30px"></li>
                                        <li class="footer-li p-1"><img
                                                src="{{ asset('asset/v1/users/store') }}/img/payments/cib.png"
                                                alt="" width="30px"></li>
                                    @endif
                                    @if (($paymentMethods?->BaridiMob?->status ?? '') === 'active')
                                        <li class="footer-li p-1"><img
                                                src="{{ asset('asset/v1/users/store') }}/img/payments/baridimaobe.png"
                                                alt="" width="30px"></li>
                                    @endif
                                    @if (($paymentMethods?->Ccp?->status ?? '') === 'active')
                                        <li class="footer-li p-1"><img
                                                src="{{ asset('asset/v1/users/store') }}/img/payments/algerie post.png"
                                                alt="" width="30px"></li>
                                    @endif
                                @endif
                            @endif

                            @if (($paymentMethods?->Cash?->status ?? '') === 'active')
                                <li class="footer-li p-1"><img
                                        src="{{ asset('asset/v1/users/store') }}/img/payments/cod.png" alt=""
                                        width="30px"></li>
                            @endif
                        </ul>
                    </div>

                    <div class="col-md-3 footer-card" @if(($pageTerms?->status !== 'published') && ($pageExchange?->status !== 'published') && ($pagePrivacy?->status !== 'published')) style="display: none;" @endif>
                        <h5 class="footer-title">الشروط والسياسات</h5>
                        <hr class="title-underline">
                        <ul class="footer-ul">
                            @if ($pageTerms?->status === 'published')
                            <li class="footer-li"><a
                                    href="{{ $tenantBaseUrl }}/terms-of-use">شروط
                                    الإستخدام</a></li>
                            @endif
                            @if ($pageExchange?->status === 'published')
                            <li class="footer-li"><a
                                    href="{{ $tenantBaseUrl }}/exchange-policy">سياسة
                                    الإستبدال و الإسترجاع</a></li>
                            @endif
                            @if ($pagePrivacy?->status === 'published')
                            <li class="footer-li"><a
                                    href="{{ $tenantBaseUrl }}/privacy-policy">السياسة
                                    الخصوصية</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="col-md-3 footer-card" @if(($pageContact?->status !== 'published') && ($pageFaq?->status !== 'published')) style="display: none;" @endif>
                        <h5 class="footer-title">اتصل بنا</h5>
                        <hr class="title-underline">
                        <ul class="footer-ul">
                            @if ($pageContact?->status === 'published')
                            <li class="footer-li"><a
                                    href="{{ $tenantBaseUrl }}/contact-us">اتصل
                                    بنا</a></li>
                            @endif
                            @if ($pageFaq?->status === 'published')
                            <li class="footer-li"><a
                                    href="{{ $tenantBaseUrl }}/faq">الأسئلة
                                    الشائعة</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="col-md-3 footer-card">
                        <h5 class="footer-title">تواصل معنا</h5>
                        <hr class="title-underline">
                        <ul class="footer-ul d-inline">
                            @if ($storeAddressSetting && $storeAddressSetting->value)
                                <li class="footer-li"><i class="fa-solid fa-location-dot"></i>
                                    {{ $storeAddressSetting->description ?? 'عنوان المتجر' }}:
                                    {{ $storeAddressSetting->value }}</li>
                            @endif
                            @if ($storeEmailSetting && $storeEmailSetting->value)
                                <li class="footer-li"><i class="fa-solid fa-envelope"></i>
                                    {{ $storeEmailSetting->description ?? 'البريد الإلكتروني' }}:
                                    {{ $storeEmailSetting->value }}</li>
                            @endif
                        </ul>
                        <ul class="footer-ul d-flex">
                            @if ($storeFacebook?->value && $storeFacebook?->status == 'active')
                                <li class="footer-li p-2"><a
                                        href="{{ $storeFacebook->value }}"><i
                                            class="fa-brands fa-facebook"></i></a></li>
                            @endif
                            @if ($storeInstagram?->value && $storeInstagram?->status == 'active')
                                <li class="footer-li p-2"><a
                                        href="{{ $storeInstagram->value }}"><i
                                            class="fa-brands fa-square-instagram"></i></a></li>
                            @endif
                            @if ($storeTelegram?->value && $storeTelegram?->status == 'active')
                                <li class="footer-li p-2"><a
                                        href="{{ $storeTelegram->value }}"><i
                                            class="fa-brands fa-telegram"></i></a></li>
                            @endif
                            @if ($storeTiktok?->value && $storeTiktok?->status == 'active')
                                <li class="footer-li p-2"><a
                                        href="{{ $storeTiktok->value }}"><i
                                            class="fa-brands fa-tiktok"></i></a></li>
                            @endif
                            @if ($storeTwitter?->value && $storeTwitter?->status == 'active')
                                <li class="footer-li p-2"><a
                                        href="{{ $storeTwitter->value }}"><i
                                            class="fa-brands fa-twitter"></i></a></li>
                            @endif
                            @if ($storeYoutube?->value && $storeYoutube?->status == 'active')
                                <li class="footer-li p-2"><a
                                        href="{{ $storeYoutube->value }}"><i
                                            class="fa-brands fa-youtube"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="row footer-footer">
                    <hr style="width:50%;margin-right: 25%;">
                    <div class="col-12 text-center">
                        @if ($userData?->type == 'supplier' && (get_supplier_data(tenant('id'))?->plan_subscription?->plan_id ?? null) == 1)
                            جميع الحقوق محفوظة @ لـ: <a href="{{ route('site.index') }}"
                                target="_blank">{!! get_platform_data('platform_name')?->value !!}</a>
                        @else
                            جميع الحقوق محفوظة @ <a
                                href="{{ $tenantBaseUrl }}">{!! $storeCopyright !!}</a>
                        @endif

                        {{-- <small>جميع الحقوق محفوظة  {!! get_user_data(tenant('id'))->storeCopyright[0]->value !!} @ <script>document.write(new Date().getFullYear())</script></small> --}}
                    </div>
                </div>
            </div>
        </section>
        <!-- end footer  -->
    </div> <!-- end general container -->

    <!-- js files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ asset('asset/v1/users/store') }}/js/jQuery-v3-7-1.js"></script>
    <script src="{{ asset('asset/v1/users/store') }}/js/app.js"></script>
    @yield('footer_js')
</body>

</html>
