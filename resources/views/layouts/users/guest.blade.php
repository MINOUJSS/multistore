<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    @if(app()->getLocale() == 'ar')
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    @else
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @endif
    <!-- styles  -->
     <link rel="stylesheet" href="{{asset('asset/v1/users/auth')}}/css/style.css">
     <link rel="stylesheet" href="{{asset('asset/v1/users/auth')}}/css/appmedia.css">
     <link rel="stylesheet" href="{{asset('asset/v1/users/auth')}}/css/default-theme.css">
     <style>
       [dir="ltr"] .dz-auth-bg {
         left: auto !important;
         right: 0 !important;
       }
       [dir="ltr"] input:focus {
         direction: ltr !important;
       }
       .lang-dropdown-btn {
         background: #ffffff;
         border: 1px solid #e2e8f0;
         color: #475569;
         font-size: 0.85rem;
         font-weight: 500;
         transition: all 0.2s ease;
       }
       .lang-dropdown-btn:hover, .lang-dropdown-btn:focus {
         background: #f8fafc;
         border-color: #cbd5e1;
         color: #0f172a;
       }
       .lang-dropdown-menu {
         min-width: 150px;
         border: 1px solid rgba(0,0,0,0.08);
         box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.05);
         border-radius: 12px;
         padding: 6px;
       }
       .lang-dropdown-menu .dropdown-item {
         border-radius: 8px;
         padding: 8px 12px;
         font-size: 0.875rem;
         font-weight: 500;
       }
       .lang-dropdown-menu .dropdown-item.active,
       .lang-dropdown-menu .dropdown-item:active {
         background-color: #f1f5f9;
         color: #c10792;
         font-weight: 600;
       }
     </style>
     <!-- fonts  -->
      <link rel="stylesheet" href="{{asset('asset/v1/users/auth')}}/fonts/all.css">
      <link rel="stylesheet" href="{{asset('asset/v1/users/auth')}}/css/appfont.css">
      <!-- google analitics -->
      @yield('google_analitics')
      <!-- clarity -->
      @yield('clarity')
    <title>@yield('title')</title>
  </head>
  <body>
  <div class="container-fluid">
    <div class="row">
      @yield('content')
    </div>
  </div>
    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!--App js-->
    <script src="{{asset('asset/v1/users/auth')}}/js/jQuery-v3-7-1.js"></script>
    <script src="{{asset('asset/v1/users/auth')}}/js/app.js"></script>
    <!--My js-->
    @yield('footer_js')
  </body>
</html>