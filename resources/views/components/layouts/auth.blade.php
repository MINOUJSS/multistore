<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <!-- styles  -->
     <link rel="stylesheet" href="{{asset('//asset/users/auth')}}/css/style.css">
     <link rel="stylesheet" href="{{asset('//asset/users/auth')}}/css/appmedia.css">
     <link rel="stylesheet" href="{{asset('//asset/users/auth')}}/css/default-theme.css">
     <!-- fonts  -->
      <link rel="stylesheet" href="{{asset('/asset/users/auth')}}/fonts/all.css">
      <link rel="stylesheet" href="{{asset('/asset/users/auth')}}/css/appfont.css">
      <title>لوحة التحكم</title>
  </head>
  <body>
  <div class="container-fluid">
    <div class="row">
      <!--start sid-->
      <div class="col-md-6">
        <div class="dz-auth-box">
          <div class="logo-box text-center">
            <img src="{{asset('/asset/users/auth')}}/img/logo/store.png" width="50" height="50" alt="logo">
          </div>
          <h5 class="text-center p-4">تسجيل الدخول إلى حسابك</h5>
          <form>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">البريد الإكتروني</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="email@example.com">
              <!-- <div id="emailHelp" class="form-text">لن ن.</div> -->
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">كلمة المرور</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="كلمة المرور">
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">تذكرني</label>
              <a class="forget-link" href="">نسيت كلمة المرور؟</a>
            </div>
            <button type="submit" class="btn dz-btn-primary">متابعة</button>
          </form>
        </div>
      </div>
      <!--end rigth sid-->
      <!--start left sid-->
      <div class="col-md-6 dz-auth-bg d-none d-sm-block d-sm-none d-md-block">
        <div class="dz-center-box">
          <div class="logo-box">
            <img src="{{asset('/asset/users/auth')}}/img/logo/store.png" width="50" height="50" alt="logo">
          </div>
          <!---->
          <div class="" bis_skin_checked="1">
            <h3 class="text-white text-3xl font-bold">ابدأ في تنمية عملك بسرعة</h3>
            <p class="dz-text-sm dz-text-color-gris">قم بإنشاء متجر إلكتروني وتمتع بالوصول إلى جميع الميزات مدى الحياة ، لا يلزم وجود بطاقة ائتمان.</p>
            <div class="flex items-center -space-x-2 overflow-hidden" bis_skin_checked="1">
              <img src="https://randomuser.me/api/portraits/women/79.jpg" class="rounded-full">
              <img src="https://api.uifaces.co/our-content/donated/xZ4wg2Xj.jpg" class="rounded-full">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=faces&amp;fit=crop&amp;h=200&amp;w=200&amp;s=a72ca28288878f8404a795f39642a46f" class="rounded-full">
              <img src="https://randomuser.me/api/portraits/men/86.jpg" class="rounded-full">
              <img src="https://images.unsplash.com/photo-1510227272981-87123e259b17?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=faces&amp;fit=crop&amp;h=200&amp;w=200&amp;s=3759e09a5b9fbe53088b23c615b6312e" class="rounded-full">
              <p class="dz-text-sm dz-float-right dz-text-color-gris">انضم إلى19181+ تاجر</p>
            </div>
          </div>
          <!---->
        </div>
      </div>
      <!--end left side-->
    </div>
  </div>
    <!-- Bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!--App js-->
    <script src="{{asset('/asset/users/auth')}}/js/jQuery-v3-7-1.js"></script>
    <script src="{{asset('/asset/users/auth')}}/js/app.js"></script>
  </body>
</html>