<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <link rel="icon" type="image/png" href="{{ asset('asset/v1/site/defaulte')}}/img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- styles  -->
    <link rel="stylesheet" href="{{ asset('asset/v1/users/dashboard') }}/test/css/style.css">
    <link rel="stylesheet" href="{{ asset('asset/v1/users/dashboard') }}/test/css/default-theme.css">
    <link rel="stylesheet" href="{{ asset('asset/v1/users/dashboard') }}/test/css/appmedia.css">
    @yield('css')
    <!-- fonts  -->
    <link rel="stylesheet" href="{{ asset('asset/v1/users/dashboard') }}/fonts/all.css">
    <link rel="stylesheet" href="{{ asset('asset/v1/users/dashboard') }}/css/appfont.css">
    @yield('fonts')
    <!-- js files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('header_js')
    <!-- google analitics -->
    @yield('google_analitics')

    <title>@yield('title')</title>
    <!--page style-->
    @yield('style')
</head>

<body>
    {{ last_seen_user() }}
    <!-- Start Main  -->
    <div class="container-fluid app-wraper ">
    <div class="content-side">
        @yield('navbar')
        {{-- info bar  --}}
        <div class="row">
           <div class="container">
            <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">

        <div>
            <i class="fas fa-flask me-2"></i>
            <strong>منصة دزورة في المرحلة التجريبية</strong>
        </div>

        <button class="btn btn-sm btn-dark"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#betaSupport"
                aria-expanded="true">
            <i class="fas fa-chevron-down"></i>
        </button>

    </div>

    <div class="collapse show" id="betaSupport">

        <div class="card-body">

            <div class="alert alert-warning mb-4">
                <h5 class="mb-3">
                    👋 مرحباً بك في النسخة التجريبية من <strong>Dzora</strong>
                </h5>

                <p class="mb-2">
                    شكراً لاستخدامك المنصة ومساهمتك في تطويرها.
                </p>

                <p class="mb-2">
                    قد تواجه بعض الأخطاء أو تحتاج إلى مساعدة أثناء استخدام المنصة،
                    وهذا أمر طبيعي خلال المرحلة التجريبية.
                </p>

                <p class="mb-0">
                    إذا واجهتك أي مشكلة أو كان لديك أي استفسار أو اقتراح،
                    فإن فريق الدعم جاهز لمساعدتك.
                </p>
            </div>

            <div class="row g-3">

                <div class="col-lg-4 col-md-6">

                    <div class="border rounded p-3 h-100 text-center">

                        <div class="fs-2 mb-2">
                            📞
                        </div>

                        <h6>الهاتف</h6>

                        <div class="fw-bold mb-3">
                            0672816709
                        </div>

                        <a href="tel:672816709"
                           class="btn btn-primary w-100">
                            اتصال مباشر
                        </a>

                    </div>

                </div>

                <div class="col-lg-4 col-md-6">

                    <div class="border rounded p-3 h-100 text-center">

                        <div class="fs-2 mb-2">
                            💬
                        </div>

                        <h6>واتساب</h6>

                        <div class="fw-bold mb-3">
                            +213672816709
                        </div>

                        <a href="https://wa.me/213672816709"
                           target="_blank"
                           class="btn btn-success w-100">
                            مراسلة واتساب
                        </a>

                    </div>

                </div>

                <div class="col-lg-4 col-md-12">

                    <div class="border rounded p-3 h-100 text-center">

                        <div class="fs-2 mb-2">
                            💡
                        </div>

                        <h6>لديك اقتراح؟</h6>

                        <p class="small text-muted mb-3">
                            نرحب بجميع اقتراحاتكم لتطوير المنصة.
                        </p>

                        <a href="{{ route('site.index')}}?#contact"
                           class="btn btn-outline-primary w-100" target="_blank">
                            إرسال اقتراح
                        </a>

                    </div>

                </div>

            </div>

            <hr>

            <div class="text-center text-muted small">

                🚀 شكراً لمساهمتك في تطوير منصة
                <strong>Dzora</strong>.
                كل ملاحظة منك تساعدنا على تقديم تجربة أفضل للجميع.

            </div>

        </div>

    </div>
</div>
           </div>
        </div>
        @yield('content')

        <!-- Footer -->
        <div class="footer">
            <div class="text-center">
                <small>جميع الحقوق محفوظة لمنصة 
                    <a href="{{ route('site.index') }}" target="_blank">
                        {!! get_platform_data('platform_name')->value !!}
                    </a> 
                    @ <script>document.write(new Date().getFullYear())</script>
                </small>
            </div>
        </div>
    </div>
        @yield('sidbar')   <!-- صححت sidbar إلى sidebar -->
</div>

    <!-- End Main  -->

    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!--App js-->
    <script src="{{ asset('asset/v1/users/dashboard') }}/js/jQuery-v3-7-1.js"></script>
    <script src="{{ asset('asset/v1/users/dashboard') }}/js/app.js"></script>
    @include('users/sellers/components/navbar/js/user_notification_js')
    @include('sweetalert::alert')
    @yield('footer_js')
</body>

</html>
