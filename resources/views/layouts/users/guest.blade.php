<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <!-- styles  -->
     <link rel="stylesheet" href="{{asset('asset/users/auth')}}/css/style.css">
     <link rel="stylesheet" href="{{asset('asset/users/auth')}}/css/appmedia.css">
     <link rel="stylesheet" href="{{asset('asset/users/auth')}}/css/default-theme.css">
     <!-- fonts  -->
      <link rel="stylesheet" href="{{asset('asset/users/auth')}}/fonts/all.css">
      <link rel="stylesheet" href="{{asset('asset/users/auth')}}/css/appfont.css">
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
    <script src="{{asset('asset/users/auth')}}/js/jQuery-v3-7-1.js"></script>
    <script src="{{asset('asset/users/auth')}}/js/app.js"></script>
  </body>
</html>