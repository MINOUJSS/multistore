<!doctype html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--supplier meta-->
    @yield('meta')
    <link rel="icon" type="image/png" href="{{asset(get_store_logo(tenant('id')))}}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">    <!-- fonts -->
    <!-- font -->
     <link rel="stylesheet" href="{{asset('asset/users/store')}}/fonts/all.css">
     <link rel="stylesheet" href="{{asset('asset/users/store')}}/css/appfont.css">
    <!-- supplier fonts -->
    @yield('fonts')
     <!-- style -->
     <link rel="stylesheet" href="{{asset('asset/users/store')}}/css/style.css">
     <link rel="stylesheet" href="{{asset('asset/users/store')}}/css/default-theme.css">
     <link rel="stylesheet" href="{{asset('asset/users/store')}}/css/appmedia.css">
    <!-- supplier style -->
     @yield('header_style')
     <!-- js files -->
     @yield('header_js')
    <!-- fcb pixle -->
    @yield('fcb_pixle')
    <!-- google analytics -->
    @yield('google_analytics')
    <!---->
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
            <a href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(tenant('id'))->domains[0]->domain)}}"><img src="{{asset(get_store_logo(tenant('id')))}}" width="50px" height="50px" alt="logo"></a>
        </div>
        <hr>
        <div class="row footer-body">
            <div class="col-md-3 footer-card">
                <h5 class="footer-title">عن المتجر</h5>
                <hr class="title-underline">
                <ul class="footer-ul">
                    <li class="footer-li"><a href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(tenant('id'))->domains[0]->domain)}}/about">عن المتجر</a></li>                    
                    <li class="footer-li"><a href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(tenant('id'))->domains[0]->domain)}}/shipping-policy">الشحن و التسليم</a></li>
                    <li class="footer-li"><a href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(tenant('id'))->domains[0]->domain)}}/payment-policy">طرق الدفع</a></li>
                </ul>
                <ul class="footer-ul d-flex">
                    <li class="footer-li p-1"><img src="{{asset('asset/users/store')}}/img/payments/eldhahabia.png" alt="" width="30px"></li>
                    <li class="footer-li p-1"><img src="{{asset('asset/users/store')}}/img/payments/cib.png" alt="" width="30px"></li>
                    <li class="footer-li p-1"><img src="{{asset('asset/users/store')}}/img/payments/baridimaobe.png" alt="" width="30px"></li>
                    <li class="footer-li p-1"><img src="{{asset('asset/users/store')}}/img/payments/algerie post.png" alt="" width="30px"></li>
                    <li class="footer-li p-1"><img src="{{asset('asset/users/store')}}/img/payments/cod.png" alt="" width="30px"></li>
                </ul>
            </div>

            <div class="col-md-3 footer-card">
                <h5 class="footer-title">الشروط والسياسات</h5>
                <hr class="title-underline">
                <ul class="footer-ul">
                    <li class="footer-li"><a href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(tenant('id'))->domains[0]->domain)}}/terms-of-use">شروط الإستخدام</a></li>
                    <li class="footer-li"><a href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(tenant('id'))->domains[0]->domain)}}/exchange-policy">سياسة الإستبدال و الإسترجاع</a></li>
                    <li class="footer-li"><a href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(tenant('id'))->domains[0]->domain)}}/privacy-policy">السياسة الخصوصية</a></li>
                </ul>
            </div>

            <div class="col-md-3 footer-card">
                <h5 class="footer-title">اتصل بنا</h5>
                <hr class="title-underline">
                <ul class="footer-ul">
                    <li class="footer-li"><a href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(tenant('id'))->domains[0]->domain)}}/contact-us">اتصل بنا</a></li>
                    <li class="footer-li"><a href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(tenant('id'))->domains[0]->domain)}}/faq">الأسئلة الشائعة</a></li>
                </ul>
            </div>

            <div class="col-md-3 footer-card">
                <h5 class="footer-title">تواصل معنا</h5>
                <hr class="title-underline">
                <ul class="footer-ul">
                    <li class="footer-li"><i class="fa-solid fa-location-dot"></i> العنوان : حي200 مسكن الجزائر</li>
                    <li class="footer-li"><i class="fa-solid fa-envelope"></i> البريد الإلكتروني : {{get_supplier_data(tenant('id'))->tenant->users[0]->email}}</li>
                </ul>
                <ul class="footer-ul d-flex">
                    <li class="footer-li p-2"><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                    <li class="footer-li p-2"><a href="#"><i class="fa-brands fa-square-instagram"></i></a></li>
                    <li class="footer-li p-2"><a href="#"><i class="fa-brands fa-telegram"></i></a></li>
                    <li class="footer-li p-2"><a href="#"><i class="fa-brands fa-tiktok"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="row footer-footer">
            <hr style="width:50%;margin-right: 25%;">
            <div class="col-12 text-center">
                جميع الحقوق محفوظة @ لمنصة <a href="{{route('site.index')}}">متاجر ديزاد</a>
            </div>
        </div>
        </div>
     </section>
    <!-- end footer  -->
</div> <!-- end general container -->
     
    <!-- js files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{asset('asset/users/store')}}/js/jQuery-v3-7-1.js"></script>
    <script src="{{asset('asset/users/store')}}/js/app.js"></script>
  </body>
</html>