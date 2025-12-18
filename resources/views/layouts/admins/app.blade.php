<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <!-- styles  -->
     <link rel="stylesheet" href="{{asset('asset/v1/users/dashboard')}}/css/style.css">
     <link rel="stylesheet" href="{{asset('asset/v1/users/dashboard')}}/css/appmedia.css">
     <link rel="stylesheet" href="{{asset('asset/v1/users/dashboard')}}/css/default-theme.css">
     <!-- fonts  -->
      <link rel="stylesheet" href="{{asset('asset/v1/users/dashboard')}}/fonts/all.css">
      <link rel="stylesheet" href="{{asset('asset/v1/users/dashboard')}}/css/appfont.css">
    <title>@yield('title')</title>
  </head>
  <body>
  @yield('style')
  @yield('sidebar')
     <!-- Start Main  -->
    <div class="app-wraper">
        <!-- Start Nav Bar-->
            @yield('navbar')
        <!-- end Nav Bar-->
         <!-- Start Content-->
            <div class="content">
              @yield('content')
            </div>
         <!-- End Content-->
         
        <!--Start Footer-->
            <div class="footer">
                <div class="text-center">
                    <small>جميع الحقوق محفوظة لمنصة <a href="#">متاجر ديزاد</a> @ <script>document.write(new Date().getFullYear())</script></small>
                </div>
            </div>
        <!--End Footer-->
    </div>
    <!-- End Main  -->

    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!--App js-->
    <script src="{{asset('asset/v1/users/dashboard')}}/js/jQuery-v3-7-1.js"></script>
    <script src="{{asset('asset/v1/users/dashboard')}}/js/app.js"></script>
    @yield('footer_js')
  </body>
</html>