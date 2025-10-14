<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>MatajeDZ</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('asset/v1/site/defaulte')}}/img/favicon.png" rel="icon">
  {{-- <link rel="icon" href="{{asset('asset/v1/site/defaulte')}}/img/favicon.png"> --}}
  {{-- <link href="{{asset('asset/v1/site/defaulte')}}/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

  <!-- Google Fonts -->
  {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> --}}

  <!-- Vendor CSS Files -->
  <link href="{{asset('asset/v1/site/defaulte')}}/css/aos.css" rel="stylesheet">
  <link href="{{asset('asset/v1/site/defaulte')}}/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{asset('asset/v1/site/defaulte')}}/css/bootstrap-rtl.min.css" rel="stylesheet">
  <link href="{{asset('asset/v1/site/defaulte')}}/css/bootstrap-icons.css" rel="stylesheet">
  <link href="{{asset('asset/v1/site/defaulte')}}/css/boxicons.css" rel="stylesheet">
  <link href="{{asset('asset/v1/site/defaulte')}}/css/glightbox.min.css" rel="stylesheet">
  <link href="{{asset('asset/v1/site/defaulte')}}/css/remixicon.css" rel="stylesheet">
  <link href="{{asset('asset/v1/site/defaulte')}}/css/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('asset/v1/site/defaulte')}}/css/style.css" rel="stylesheet">
  <link href="{{asset('asset/v1/site/defaulte')}}/css/theme_one.css" rel="stylesheet">
  <!--My Editing-->
  <link href="{{asset('asset/v1/site/defaulte')}}/css/mystyle.css" rel="stylesheet">
  {{-- My Fonts --}}
  <link rel="stylesheet" href="{{asset('asset/v1/site/defaulte')}}/css/kufi_font.css">
  <!--google analitices-->
  @yield('google_analitics')
  <!-- =======================================================
  * Template Name: Arsha
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
  <div class="container d-flex align-items-center">

    <h1 class="logo my-me-auto"><a href="index.html">MatajeDZ</a></h1>
    <!-- Uncomment below if you prefer to use an image logo -->
    <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

    <nav id="navbar" class="navbar">
      <ul>
        <li><a class="nav-link scrollto active" href="#hero">الرئيسية</a></li>
        <li><a class="nav-link scrollto" href="#about">من نحن</a></li>
        <li><a class="nav-link scrollto" href="#services">خدماتنا</a></li>
        {{-- <li><a class="nav-link   scrollto" href="#portfolio">أعمالنا</a></li> --}}
        {{-- <li><a class="nav-link scrollto" href="#team">فريق العمل</a></li> --}}
        {{-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="#">Drop Down 1</a></li>
            <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
              <ul>
                <li><a href="#">Deep Drop Down 1</a></li>
                <li><a href="#">Deep Drop Down 2</a></li>
                <li><a href="#">Deep Drop Down 3</a></li>
                <li><a href="#">Deep Drop Down 4</a></li>
                <li><a href="#">Deep Drop Down 5</a></li>
              </ul>
            </li>
            <li><a href="#">Drop Down 2</a></li>
            <li><a href="#">Drop Down 3</a></li>
            <li><a href="#">Drop Down 4</a></li>
          </ul>
        </li> --}}
        <li><a class="nav-link scrollto" href="#contact">إتصل بنا</a></li>
        <li><a class="getstarted scrollto" href="#about">إبدأ الآن</a></li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->

  </div>
</header><!-- End Header -->
  {{-- @yield('header') --}}

  @yield('hero')

  <main id="main">

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
          <h3>Matajerdz</h3>
          <p>
            {{-- A108 Adam Street <br>
            New York, NY 535022<br> --}}
            الجزائر العاصمة <br><br>
            <strong>الهاتف:</strong> +1 5589 55488 55<br>
            <strong>البريد الإلكتروني:</strong> info@example.com<br>
          </p>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>روابط مهمة</h4>
          <ul>
            <li><i class="bx bx-chevron-left"></i> <a href="#">الرئيسية</a></li>
            <li><i class="bx bx-chevron-left"></i> <a href="#">من نحن</a></li>
            <li><i class="bx bx-chevron-left"></i> <a href="#">خدماتنا</a></li>
            <li><i class="bx bx-chevron-left"></i> <a href="#">سياسة خصوصية</a></li>
            {{-- <li><i class="bx bx-chevron-left"></i> <a href="#">Privacy policy</a></li> --}}
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>خدماتنا</h4>
          <ul>
            <li><i class="bx bx-chevron-left"></i> <a href="{{route('site.show_suppliers_plans')}}">إنضم إلينا كمورد أو تاجر جملة</a></li>
            <li><i class="bx bx-chevron-left"></i> <a href="{{route('site.show_sellers_plans')}}">إنضم إلينا كتاجر تجزئة</a></li>
            <li><i class="bx bx-chevron-left"></i> <a href="{{route('site.show_affiliate_marketers_plans')}}">إنضم إلينا كمسوق بالعمولة</a></li>
            <li><i class="bx bx-chevron-left"></i> <a href="{{route('site.show_shipers_plans')}}">إنضم إلينا كشركة شحن صغيرة أو متوسطة</a></li>
            {{-- <li><i class="bx bx-chevron-left"></i> <a href="#">Graphic Design</a></li> --}}
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>حساباتنا على مواقع التواصل الإجتماعي</h4>
          <p>انضم إلى مجتمعنا على وسائل التواصل الاجتماعي للحصول على آخر الأخبار والعروض الحصرية! كن أول من يعلم عن التحديثات والفعاليات، وتواصل معنا مباشرة لمشاركة أفكارك وتجاربك. تابعنا الآن لجعل تجربتك معنا أكثر تفاعلاً وإثارة!</p>
          <div class="social-links mt-3">
            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="container footer-bottom clearfix">
    <div class="copyright">
      &copy; كل الحقوق محفوظة <strong><span>{!! get_platform_data('platform_name')->value !!}</span></strong>.
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
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
<script src="{{asset('asset/v1/site/defaulte')}}/js/aos.js"></script>
<script src="{{asset('asset/v1/site/defaulte')}}/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('asset/v1/site/defaulte')}}/js/glightbox.min.js"></script>
<script src="{{asset('asset/v1/site/defaulte')}}/js/isotope.pkgd.min.js"></script>
<script src="{{asset('asset/v1/site/defaulte')}}/js/swiper-bundle.min.js"></script>
<script src="{{asset('asset/v1/site/defaulte')}}/js/noframework.waypoints.js"></script>
<script src="{{asset('asset/v1/site/defaulte')}}/js/validate.js"></script>

<!-- Template Main JS File -->
<script src="{{asset('asset/v1/site/defaulte')}}/js/main.js"></script> 

</body>

</html>