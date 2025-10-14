<!doctype html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--supplier meta-->
    @yield('meta')
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
        <section class="footer">
            <div class="container">
                <div class="footer-brand text-center">
                    <a
                        href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}"><img
                            src="{{ asset(get_store_logo(tenant('id'))) }}" width="50px" height="50px"
                            alt="logo"></a>
                </div>
                <hr>
                <div class="row footer-body">
                    <div class="col-md-3 footer-card" @if(get_tenant_data_by_type(tenant('id'))->pages[0]->status !== 'published' && get_tenant_data_by_type(tenant('id'))->pages[1]->status !== 'published' && get_tenant_data_by_type(tenant('id'))->pages[2]->status !== 'published') style="display: none;" @endif>
                        <h5 class="footer-title">عن المتجر</h5>
                        <hr class="title-underline">
                        <ul class="footer-ul">
                            @if (get_tenant_data_by_type(tenant('id'))->pages[0]->status === 'published')
                                <li class="footer-li"><a
                                        href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}/about">عن
                                        المتجر</a></li>
                            @endif
                            @if (get_tenant_data_by_type(tenant('id'))->pages[1]->status === 'published')
                                <li class="footer-li"><a
                                        href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}/shipping-policy">الشحن
                                        و التسليم</a></li>
                            @endif
                            @if (get_tenant_data_by_type(tenant('id'))->pages[2]->status === 'published')
                                <li class="footer-li"><a
                                        href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}/payment-policy">طرق
                                        الدفع</a></li>
                            @endif
                        </ul>
                        <ul class="footer-ul d-flex">
                            {{-- {{dd(get_supplier_data(tenant('id'))->plan_subscription->id);}} --}}
                            @if (get_supplier_data(tenant('id'))->plan_subscription->id !== 1)
                                @if (get_store_payment_methods(tenant('id'))->Chargily_Pay->status === 'active')
                                    <li class="footer-li p-1"><img
                                            src="{{ asset('asset/v1/users/store') }}/img/payments/eldhahabia.png"
                                            alt="" width="30px"></li>
                                    <li class="footer-li p-1"><img
                                            src="{{ asset('asset/v1/users/store') }}/img/payments/cib.png"
                                            alt="" width="30px"></li>
                                @endif
                                @if (get_store_payment_methods(tenant('id'))->BaridiMob->status === 'active')
                                    <li class="footer-li p-1"><img
                                            src="{{ asset('asset/v1/users/store') }}/img/payments/baridimaobe.png"
                                            alt="" width="30px"></li>
                                @endif
                                @if (get_store_payment_methods(tenant('id'))->Ccp->status === 'active')
                                    <li class="footer-li p-1"><img
                                            src="{{ asset('asset/v1/users/store') }}/img/payments/algerie post.png"
                                            alt="" width="30px"></li>
                                @endif
                            @endif
                            @if (get_store_payment_methods(tenant('id'))->Cash->status === 'active')
                                <li class="footer-li p-1"><img
                                        src="{{ asset('asset/v1/users/store') }}/img/payments/cod.png" alt=""
                                        width="30px"></li>
                            @endif
                        </ul>
                    </div>

                    <div class="col-md-3 footer-card" @if(get_tenant_data_by_type(tenant('id'))->pages[3]->status !== 'published' && get_tenant_data_by_type(tenant('id'))->pages[4]->status !== 'published' && get_tenant_data_by_type(tenant('id'))->pages[5]->status !== 'published') style="display: none;" @endif>
                        <h5 class="footer-title">الشروط والسياسات</h5>
                        <hr class="title-underline">
                        <ul class="footer-ul">
                            @if (get_tenant_data_by_type(tenant('id'))->pages[3]->status === 'published')
                            <li class="footer-li"><a
                                    href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}/terms-of-use">شروط
                                    الإستخدام</a></li>
                            @endif
                            @if (get_tenant_data_by_type(tenant('id'))->pages[4]->status === 'published')
                            <li class="footer-li"><a
                                    href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}/exchange-policy">سياسة
                                    الإستبدال و الإسترجاع</a></li>
                                    @endif
                                    @if (get_tenant_data_by_type(tenant('id'))->pages[5]->status === 'published')
                            <li class="footer-li"><a
                                    href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}/privacy-policy">السياسة
                                    الخصوصية</a></li>
                                    @endif
                        </ul>
                    </div>

                    <div class="col-md-3 footer-card" @if(get_tenant_data_by_type(tenant('id'))->pages[6]->status !== 'published' && get_tenant_data_by_type(tenant('id'))->pages[7]->status !== 'published') style="display: none;" @endif>
                        <h5 class="footer-title">اتصل بنا</h5>
                        <hr class="title-underline">
                        <ul class="footer-ul">
                            @if (get_tenant_data_by_type(tenant('id'))->pages[6]->status === 'published')
                            <li class="footer-li"><a
                                    href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}/contact-us">اتصل
                                    بنا</a></li>
                            @endif
                            @if (get_tenant_data_by_type(tenant('id'))->pages[7]->status === 'published')
                            <li class="footer-li"><a
                                    href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}/faq">الأسئلة
                                    الشائعة</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="col-md-3 footer-card">
                        <h5 class="footer-title">تواصل معنا</h5>
                        <hr class="title-underline">
                        <ul class="footer-ul d-inline">
                            <li class="footer-li"><i class="fa-solid fa-location-dot"></i>
                                {{ get_store_settings(get_user_data(tenant('id'))->id)[3]->description }}:
                                {{ get_store_settings(get_user_data(tenant('id'))->id)[3]->value }}</li>
                            <li class="footer-li"><i class="fa-solid fa-envelope"></i>
                                {{ get_store_settings(get_user_data(tenant('id'))->id)[2]->description }}:
                                {{ get_store_settings(get_user_data(tenant('id'))->id)[2]->value }}</li>
                        </ul>
                        <ul class="footer-ul d-flex">
                            @if (get_user_store_settings(tenant('id'), 'store_facebook')->value !== null &&
                                    get_user_store_settings(tenant('id'), 'store_facebook')->status == 'active')
                                <li class="footer-li p-2"><a
                                        href="{{ get_user_store_settings(tenant('id'), 'store_facebook')->value }}"><i
                                            class="fa-brands fa-facebook"></i></a></li>
                            @endif
                            @if (get_user_store_settings(tenant('id'), 'store_instagram')->value !== null &&
                                    get_user_store_settings(tenant('id'), 'store_instagram')->status == 'active')
                                <li class="footer-li p-2"><a
                                        href="{{ get_user_store_settings(tenant('id'), 'store_instagram')->value }}"><i
                                            class="fa-brands fa-square-instagram"></i></a></li>
                            @endif
                            @if (get_user_store_settings(tenant('id'), 'store_telegram')->value !== null &&
                                    get_user_store_settings(tenant('id'), 'store_telegram')->status == 'active')
                                <li class="footer-li p-2"><a
                                        href="{{ get_user_store_settings(tenant('id'), 'store_telegram')->value }}"><i
                                            class="fa-brands fa-telegram"></i></a></li>
                            @endif
                            @if (get_user_store_settings(tenant('id'), 'store_tiktok')->value !== null &&
                                    get_user_store_settings(tenant('id'), 'store_tiktok')->status == 'active')
                                <li class="footer-li p-2"><a
                                        href="{{ get_user_store_settings(tenant('id'), 'store_tiktok')->value }}"><i
                                            class="fa-brands fa-tiktok"></i></a></li>
                            @endif
                            @if (get_user_store_settings(tenant('id'), 'store_twitter')->value !== null &&
                                    get_user_store_settings(tenant('id'), 'store_twitter')->status == 'active')
                                <li class="footer-li p-2"><a
                                        href="{{ get_user_store_settings(tenant('id'), 'store_twitter')->value }}"><i
                                            class="fa-brands fa-twitter"></i></a></li>
                            @endif
                            @if (get_user_store_settings(tenant('id'), 'store_youtube')->value !== null &&
                                    get_user_store_settings(tenant('id'), 'store_youtube')->status == 'active')
                                <li class="footer-li p-2"><a
                                        href="{{ get_user_store_settings(tenant('id'), 'store_youtube')->value }}"><i
                                            class="fa-brands fa-youtube"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="row footer-footer">
                    <hr style="width:50%;margin-right: 25%;">
                    <div class="col-12 text-center">
                        @if (get_user_data(tenant('id'))->type == 'supplier' && get_supplier_data(tenant('id'))->plan_subscription->plan_id == 1)
                            جميع الحقوق محفوظة @ لـ: <a href="{{ route('site.index') }}"
                                target="_blank">{!! get_platform_data('platform_name')->value !!}</a>
                        @else
                            جميع الحقوق محفوظة @ <a
                                href="{{ request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain }}">{!! get_user_data(tenant('id'))->storeCopyright[0]->value !!}</a>
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
