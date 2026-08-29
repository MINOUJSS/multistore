<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <meta content="" name="description">
    <meta content="" name="keywords">

    <title>@yield('title')</title>

    <!-- Favicons -->
    <link href="{{ asset('asset/v1/site/defaulte') }}/img/favicon.png" rel="icon">
    {{-- <link rel="icon" href="{{asset('asset/v1/site/defaulte')}}/img/favicon.png"> --}}
    {{-- <link href="{{asset('asset/v1/site/defaulte')}}/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

    <!-- Google Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"> --}}

    {{-- My Fonts --}}
    <link rel="stylesheet" href="{{ asset('asset/v1/site/defaulte') }}/css/kufi_font.css">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('asset/v1/site/defaulte') }}/css/aos.css" rel="stylesheet">
    <link href="{{ asset('asset/v1/site/defaulte') }}/css/bootstrap.min.css" rel="stylesheet">
    @if (app()->getLocale() == 'ar')
        <link href="{{ asset('asset/v1/site/defaulte') }}/css/bootstrap-rtl.min.css" rel="stylesheet">
    @endif
    <link href="{{ asset('asset/v1/site/defaulte') }}/css/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('asset/v1/site/defaulte') }}/css/boxicons.css" rel="stylesheet">
    <link href="{{ asset('asset/v1/site/defaulte') }}/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('asset/v1/site/defaulte') }}/css/remixicon.css" rel="stylesheet">
    <link href="{{ asset('asset/v1/site/defaulte') }}/css/swiper-bundle.min.css" rel="stylesheet">
    <!-- js files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template Main CSS File -->
    <link href="{{ asset('asset/v1/site/defaulte') }}/css/style.css" rel="stylesheet">
    <link href="{{ asset('asset/v1/site/defaulte') }}/css/theme_one.css" rel="stylesheet">
    <!--My Editing-->
    <link href="{{ asset('asset/v1/site/defaulte') }}/css/mystyle.css" rel="stylesheet">
    <!--google analitices-->
    @yield('google_analitics')

    <!-- Custom #B03882 Header & Preloader Styling -->
    <style>
        /* Permanent Dark Gradient Glassmorphic Header Background & Overflow Fix */
        #header {
            z-index: 99999 !important;
            overflow: visible !important;
        }

        #header .container {
            overflow: visible !important;
        }

        #header,
        #header.header-scrolled,
        #header.header-inner-pages {
            background: linear-gradient(135deg, rgba(26, 5, 19, 0.95) 0%, rgba(45, 11, 32, 0.95) 50%, rgba(70, 16, 50, 0.95) 100%) !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
            border-bottom: 1px solid rgba(176, 56, 130, 0.35) !important;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.4) !important;
        }

        @media (max-width: 991px) {
            .navbar-mobile {
                position: fixed !important;
                overflow-x: hidden !important;
                overflow-y: auto !important;
                top: 0 !important;
                right: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                background: linear-gradient(135deg, rgba(20, 4, 15, 0.98) 0%, rgba(35, 8, 25, 0.98) 50%, rgba(55, 12, 38, 0.98) 100%) !important;
                backdrop-filter: blur(16px) !important;
                -webkit-backdrop-filter: blur(16px) !important;
                z-index: 999999 !important;
            }

            .navbar-mobile ul {
                display: block !important;
                position: relative !important;
                top: 0 !important;
                right: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                margin: 80px auto 30px auto !important;
                width: calc(100% - 40px) !important;
                max-width: 500px !important;
                padding: 20px 10px !important;
                background: #2D0B20 !important;
                border: 1px solid rgba(176, 56, 130, 0.4) !important;
                border-radius: 18px !important;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.7) !important;
                z-index: 9999999 !important;
            }

            .navbar-mobile li {
                display: block !important;
                width: 100% !important;
            }

            .navbar-mobile a,
            .navbar-mobile a:focus {
                padding: 12px 20px !important;
                font-size: 16px !important;
                color: #ffffff !important;
                display: block !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            }

            .navbar-mobile a:hover,
            .navbar-mobile .active,
            .navbar-mobile li:hover>a {
                color: #ff85c6 !important;
                background: rgba(176, 56, 130, 0.25) !important;
                border-radius: 8px !important;
            }

            .navbar-mobile .getstarted,
            .navbar-mobile .getstarted:focus {
                margin: 15px auto 5px auto !important;
                display: block !important;
                text-align: center !important;
                background: linear-gradient(135deg, #B03882 0%, #d6479f 100%) !important;
                color: #ffffff !important;
                border-radius: 50px !important;
                border: none !important;
            }

            .mobile-nav-toggle {
                position: relative;
                z-index: 99999999 !important;
            }

            .navbar-mobile .mobile-nav-toggle {
                position: fixed !important;
                top: 20px !important;
                z-index: 99999999 !important;
            }

            html[lang="ar"] .navbar-mobile .mobile-nav-toggle,
            html[dir="rtl"] .navbar-mobile .mobile-nav-toggle {
                left: 20px !important;
                right: auto !important;
            }

            html[lang="en"] .navbar-mobile .mobile-nav-toggle,
            html[dir="ltr"] .navbar-mobile .mobile-nav-toggle {
                right: 20px !important;
                left: auto !important;
            }
        }

        /* Modern #B03882 Preloader Styling */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 99999;
            overflow: hidden;
            background: linear-gradient(135deg, #160411 0%, #2A091E 50%, #4A1236 100%) !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #preloader:before {
            content: "";
            position: fixed;
            top: calc(50% - 35px);
            left: calc(50% - 35px);
            border: 4px solid rgba(176, 56, 130, 0.2);
            border-top: 4px solid #B03882;
            border-right: 4px solid #ff85c6;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            animation: animate-preloader 0.9s cubic-bezier(0.68, -0.55, 0.27, 1.55) infinite;
            box-shadow: 0 0 30px rgba(176, 56, 130, 0.6), inset 0 0 15px rgba(255, 133, 198, 0.4);
        }

        #preloader:after {
            content: "";
            position: fixed;
            top: calc(50% - 20px);
            left: calc(50% - 20px);
            border: 3px solid transparent;
            border-bottom: 3px solid #ff85c6;
            border-left: 3px solid #B03882;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: animate-preloader-reverse 1.2s linear infinite;
        }

        @keyframes animate-preloader {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes animate-preloader-reverse {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(-360deg);
            }
        }

        /*--------------------------------------------------------------
        # Modern Dark Footer Styling (#B03882)
        --------------------------------------------------------------*/
        #footer {
            background: linear-gradient(180deg, #180512 0%, #29081e 50%, #150410 100%) !important;
            color: rgba(255, 255, 255, 0.85) !important;
            font-size: 14px;
            position: relative;
            border-top: 1px solid rgba(176, 56, 130, 0.3);
        }

        #footer .footer-top {
            background: transparent !important;
            padding: 60px 0 30px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        #footer .footer-top .footer-contact {
            margin-bottom: 30px;
        }

        #footer .footer-top .footer-contact h3 {
            font-size: 28px;
            margin: 0 0 10px 0;
            padding: 2px 0 2px 0;
            line-height: 1.2;
            font-weight: 800;
            color: #ffffff !important;
            background: linear-gradient(135deg, #ffffff 0%, #ff85c6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        #footer .footer-top .footer-contact p {
            font-size: 14px;
            line-height: 24px;
            margin-bottom: 0;
            color: rgba(255, 255, 255, 0.75) !important;
        }

        #footer .footer-top h4 {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff !important;
            position: relative;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        #footer .footer-top h4::after {
            content: '';
            position: absolute;
            display: block;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #B03882 0%, #d6479f 100%);
            bottom: 0;
            right: 0;
            border-radius: 3px;
        }

        #footer .footer-top .footer-links {
            margin-bottom: 30px;
        }

        #footer .footer-top .footer-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #footer .footer-top .footer-links ul li {
            padding: 8px 0;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        #footer .footer-top .footer-links ul li:first-child {
            padding-top: 0;
        }

        #footer .footer-top .footer-links ul i {
            color: #ff85c6 !important;
            font-size: 18px;
            margin-left: 8px;
            line-height: 1;
            transition: transform 0.3s ease;
        }

        #footer .footer-top .footer-links ul a {
            color: rgba(255, 255, 255, 0.75) !important;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            font-weight: 500;
        }

        #footer .footer-top .footer-links ul a:hover {
            color: #ff85c6 !important;
            transform: translateX(-5px);
        }

        #footer .footer-top .footer-links ul li:hover i {
            transform: translateX(-3px);
            color: #ffffff !important;
        }

        #footer .footer-top .footer-links p {
            color: rgba(255, 255, 255, 0.7) !important;
            line-height: 1.6;
        }

        #footer .footer-top .social-links a {
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(176, 56, 130, 0.2) !important;
            color: #ff85c6 !important;
            line-height: 1;
            margin-left: 10px;
            border-radius: 50%;
            width: 42px;
            height: 42px;
            border: 1px solid rgba(228, 93, 164, 0.3);
            transition: all 0.3s ease;
        }

        #footer .footer-top .social-links a:hover {
            background: linear-gradient(135deg, #B03882 0%, #d6479f 100%) !important;
            color: #ffffff !important;
            transform: translateY(-3px) scale(1.08);
            box-shadow: 0 8px 20px rgba(176, 56, 130, 0.45) !important;
            border-color: transparent;
        }

        #footer .footer-bottom {
            padding: 25px 0;
            color: rgba(255, 255, 255, 0.7) !important;
        }

        #footer .copyright {
            float: right;
            font-size: 14px;
        }

        #footer .copyright strong a {
            color: #ff85c6 !important;
            transition: color 0.3s ease;
        }

        #footer .copyright strong a:hover {
            color: #ffffff !important;
        }

        /* Tablet & Mobile Responsive Footer */
        @media (max-width: 991px) {
            #footer .footer-top {
                padding: 40px 0 20px 0;
            }

            #footer .footer-top .footer-contact h3 {
                font-size: 22px;
            }

            #footer .footer-top h4 {
                font-size: 16px;
                margin-top: 10px;
            }

            #footer .footer-top .footer-links ul a {
                font-size: 13.5px;
            }
        }

        @media (max-width: 575px) {
            #footer .footer-bottom {
                text-align: center;
            }

            #footer .copyright {
                float: none;
                margin-bottom: 10px;
            }
        }

        /* Navbar Language Selector Styling */
        .navbar .dropdown ul {
            background: #2D0B20 !important;
            border: 1px solid rgba(176, 56, 130, 0.35) !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
            padding: 8px 0 !important;
        }

        .navbar .dropdown ul a {
            color: #ffffff !important;
            font-size: 14px !important;
            padding: 8px 16px !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            transition: all 0.3s ease !important;
        }

        .navbar .dropdown ul a:hover {
            color: #ff85c6 !important;
            background: rgba(176, 56, 130, 0.25) !important;
        }

        .lang-btn {
            border: 1px solid rgba(176, 56, 130, 0.4) !important;
            background: rgba(176, 56, 130, 0.15) !important;
            border-radius: 30px !important;
            padding: 6px 14px !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            transition: all 0.3s ease !important;
        }

        .lang-btn:hover {
            background: linear-gradient(135deg, #B03882 0%, #d6479f 100%) !important;
            border-color: transparent !important;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(176, 56, 130, 0.35) !important;
        }
    </style>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center">

            <h1 class="logo"
                @if (app()->getLocale() == 'ar') style="margin-left: auto !important;" @else style="margin-right: auto !important;" @endif>
                <a href="{{ route('site.index') }}">{{ config('app.name') }}</a>
            </h1>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active"
                            href="{{ config('app.url') }}?#hero">{{ __('site.home') }}</a></li>
                    <li><a class="nav-link scrollto"
                            href="{{ config('app.url') }}?#how-it-works">{{ __('site.how_it_works') }}</a>
                    </li>
                    <li><a class="nav-link scrollto"
                            href="{{ config('app.url') }}?#skills">{{ __('site.features') }}</a></li>
                    <li><a class="nav-link scrollto"
                            href="{{ config('app.url') }}?#services">{{ __('site.services') }}</a></li>
                    <li><a class="nav-link scrollto" href="{{ config('app.url') }}?#faq">{{ __('site.faq') }}</a></li>
                    <li><a class="nav-link scrollto"
                            href="{{ config('app.url') }}?#contact">{{ __('site.contact') }}</a></li>
                    <li class="dropdown"><a href="#" class="lang-btn"><span>🌐
                                {{ app()->getLocale() == 'ar' ? 'العربية' : (app()->getLocale() == 'fr' ? 'Français' : 'English') }}</span>
                            <i class="bi bi-chevron-down ms-1"></i></a>
                        <ul>
                            <li><a href="{{ url('setlang/ar') }}">🇩🇿 العربية</a></li>
                            <li><a href="{{ url('setlang/fr') }}">🇫🇷 Français</a></li>
                            <li><a href="{{ url('setlang/en') }}">🇬🇧 English</a></li>
                        </ul>
                    </li>
                    <li><a class="getstarted scrollto"
                            href="{{ config('app.url') }}?#services">{{ __('site.get_started') }}</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->
    {{-- @yield('header') --}}

    @yield('hero')

    <main id="main">

        @yield('content')

        @yield('cliens')

        @yield('about')

        @yield('why-us')

        @yield('skills')

        @yield('services')

        @yield('cta')

        @yield('portfolio')

        @yield('team')

        @yield('pricing')

        @yield('faq')

        @yield('contact')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        @yield('footer-newsletter')

        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>{{ config('app.name') }}</h3>
                        <p>
                            {{ __('site.address_value') }} <br><br>
                            <strong>{{ __('site.phone_label') }}</strong> 0672816709 (+213)<br>
                            <strong>{{ __('site.email_label') }}</strong> dzora.net@gmail.com<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>{{ __('site.useful_links') }}</h4>
                        <ul>
                            <li><i class="bx bx-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i> <a
                                    href="{{ config('app.url') }}?#hero">{{ __('site.home') }}</a>
                            </li>
                            <li><i class="bx bx-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i> <a
                                    href="{{ config('app.url') }}?#how-it-works">{{ __('site.how_it_works') }}</a>
                            </li>
                            <li><i class="bx bx-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i> <a
                                    href="{{ config('app.url') }}?#skills">{{ __('site.features') }}</a></li>
                            <li><i class="bx bx-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i> <a
                                    href="{{ config('app.url') }}?#services">{{ __('site.services') }}</a></li>
                            <li><i class="bx bx-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i> <a
                                    href="{{ route('site.privacy_policy') }}">{{ __('site.privacy_policy') }}</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>{{ __('site.our_services') }}</h4>
                        <ul>
                            <li><i class="bx bx-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i> <a
                                    href="{{ route('site.show_suppliers_plans') }}">{{ __('site.join_as_supplier') }}</a>
                            </li>
                            <li><i class="bx bx-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i> <a
                                    href="{{ route('site.show_sellers_plans') }}">{{ __('site.join_as_seller') }}</a>
                            </li>
                            <li><i class="bx bx-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i> <a
                                    href="{{ route('site.show_affiliate_marketers_plans') }}">{{ __('site.join_as_affiliate') }}</a>
                            </li>
                            <li><i class="bx bx-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i> <a
                                    href="{{ route('site.show_shipers_plans') }}">{{ __('site.join_as_shipper') }}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>{{ __('site.social_accounts') }}</h4>
                        <p>{{ __('site.social_desc') }}</p>
                        <div class="social-links mt-3">
                            <a href="https://www.youtube.com/@Dzora-net" class="twitter"><i
                                    class="bx bxl-youtube"></i></a>
                            <a href="https://www.facebook.com/profile.php?id=61589654940299" class="facebook"><i
                                    class="bx bxl-facebook"></i></a>
                            <a href="https://www.instagram.com/dzora_net/" class="instagram"><i
                                    class="bx bxl-instagram"></i></a>
                            <a href="https://www.tiktok.com/@dzora_net" class="tiktok"><i
                                    class="bx bxl-tiktok"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container footer-bottom clearfix">
            <div class="copyright">
                &copy; {{ __('site.all_rights_reserved') }} <strong><a href="{{ config('app.url') }}"
                        style="color: #ffffff"><span>{{ config('app.name') }}</span></a></strong>.
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/ -->
                {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('asset/v1/site/defaulte') }}/js/aos.js"></script>
    <script src="{{ asset('asset/v1/site/defaulte') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('asset/v1/site/defaulte') }}/js/glightbox.min.js"></script>
    <script src="{{ asset('asset/v1/site/defaulte') }}/js/isotope.pkgd.min.js"></script>
    <script src="{{ asset('asset/v1/site/defaulte') }}/js/swiper-bundle.min.js"></script>
    <script src="{{ asset('asset/v1/site/defaulte') }}/js/noframework.waypoints.js"></script>
    <script src="{{ asset('asset/v1/site/defaulte') }}/js/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('asset/v1/site/defaulte') }}/js/main.js"></script>
    @yield('footer_js')

</body>

</html>
