<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    <!-- styles  -->
     <link rel="stylesheet" href="{{asset('asset/users/dashboard')}}/css/style.css">
     <link rel="stylesheet" href="{{asset('asset/users/dashboard')}}/css/appmedia.css">
     <link rel="stylesheet" href="{{asset('asset/users/dashboard')}}/css/default-theme.css">
     <!-- fonts  -->
      <link rel="stylesheet" href="{{asset('asset/users/dashboard')}}/fonts/all.css">
      <link rel="stylesheet" href="{{asset('asset/users/dashboard')}}/css/appfont.css">
    <title>لوحة التحكم</title>
  </head>
  <body>
  <!-- Start Sid Bar  -->
    <div class="app-sidebar">
        <div class="logo-box text-center">
            <img class="logo-image" src="{{asset('asset/users/dashboard')}}/img/logo/store.png" alt="" widgh="50px" height="50px">
            <div class="user-name">
                <h6>إسم المستخدم</h6>
            </div>
        </div>   
        <hr>
        <!--Start Menu-->
        <div class="menu">
            <div class="item"><a href="#"><i class="fa-solid fa-gauge"></i> الرئيسية</a></div>
            <div class="item">
                <a class="sub-btn" href="#"><i class="fa-solid fa-cart-shopping"></i> الطلبات <i class="fa-solid fa-angle-left dropdown"></i></a>
                <div class="sub-menu">
                    <a class="sub-item" href="#"><i class="fa-solid fa-cart-plus"></i> الطلبات</a>
                    <a class="sub-item" href="#"><i class="fa-solid fa-cart-plus"></i> الطلبات المتروكة</a>
                </div>
            </div>
            <div class="item"><a href="#"><i class="fa-solid fa-box-open"></i> المنتجات</a></div>
            <div class="item"><a href="#"><i class="fa-solid fa-palette"></i> تصميم المتجر</a></div>
            <div class="item"><a href="#"><i class="fa-solid fa-truck-fast"></i> الشحن</a></div>
            <div class="item"><a href="#"><i class="fa-brands fa-sketch"></i> التطبيقات</a></div>
            <div class="item"><a href="#"><i class="fa-solid fa-gear"></i> الإعدادت</a></div>
        </div>
        <!--End Menu-->
    </div>
    <!-- End Sid Bar  -->

    <!-- Start Mbile Sidebar -->
      <!-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">Enable body scrolling</button> -->

<div class="offcanvas offcanvas-start d-lg-block d-lg-none d-xl-block d-xl-none d-xxl-block d-xxl-none" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
  <div class="offcanvas-header">
    <!-- <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Offcanvas with body scrolling</h5> -->
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="logo-box text-center">
      <img class="logo-image" src="{{asset('asset/users/dashboard')}}/img/logo/store.png" alt="" widgh="50px" height="50px">
      <div class="user-name">
          <h6>إسم المستخدم</h6>
      </div>
  </div>   
  <hr>
    <!--Start Menu-->
    <div class="menu">
      <div class="item"><a href="#"><i class="fa-solid fa-gauge"></i> الرئيسية</a></div>
      <div class="item">
          <a class="sub-btn" href="#"><i class="fa-solid fa-cart-shopping"></i> الطلبات <i class="fa-solid fa-angle-left dropdown"></i></a>
          <div class="sub-menu">
              <a class="sub-item" href="#"><i class="fa-solid fa-cart-plus"></i> الطلبات</a>
              <a class="sub-item" href="#"><i class="fa-solid fa-cart-plus"></i> الطلبات المتروكة</a>
          </div>
      </div>
      <div class="item"><a href="#"><i class="fa-solid fa-box-open"></i> المنتجات</a></div>
      <div class="item"><a href="#"><i class="fa-solid fa-palette"></i> تصميم المتجر</a></div>
      <div class="item"><a href="#"><i class="fa-solid fa-truck-fast"></i> الشحن</a></div>
      <div class="item"><a href="#"><i class="fa-brands fa-sketch"></i> التطبيقات</a></div>
      <div class="item"><a href="#"><i class="fa-solid fa-gear"></i> الإعدادت</a></div>
  </div>
  <!--End Menu-->
  </div>
</div>
      <!--End Mbile Sidebar-->

     <!-- Start Main  -->
    <div class="app-wraper">
        <!-- Start Nav Bar-->
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
              <div class="container-fluid">
                <a id="3bar" class="navbar-brand d-none d-sm-block d-sm-none d-md-block" href="#"><i class="fa-solid fa-bars"></i></a>
                <a id="3bar1" class="navbar-brand d-md-none d-lg-block d-lg-none d-xl-block d-xl-none d-xxl-block d-xxl-none" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="fa-solid fa-bars"></i></a>
                
                <div class="dz-mobile-nav d-lg-block d-lg-none d-xl-block d-xl-none d-xxl-block d-xxl-none">
                  <div style="padding: 10px;">
                    <a class="dz-nav-icon" href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                        <span class="top-0 start-100 translate-middle badge rounded-pill bg-danger dz-badge-color">
                            0
                          </span>
                  </div>
                  <ul class="navbar-nav">
                    <li class="nav-item dropdown dz-nav-profile">
                      <span>إسم المستخدم</span>
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="avatar" src="{{asset('asset/users/dashboard')}}/img/avatars/man.png" alt="avatar" height="30" width="30">
                      </a>
                      <ul class="dropdown-menu position-absolute">
                        <div class="dz-nav-profile-info" >
                          <p class="text-center">email@email.com</p>
                          <hr>
                        </div>
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-boxes-packing"></i> بقاتي</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user"></i> حسابي</a></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
              <!---->
              <div class="collapse navbar-collapse left-nav-menu" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <div class="dz-nav-box">
                    <li class="nav-item">
                        <div class="rasidi-box text-center">
                            <a class="nav-link dz-small-nav-text" aria-current="page" href="#">الرصيد</a>
                            <span class="text-success">1000.00 د.ج</span>

                            <div class="vr m-2"></div>

                            <a class="nav-link dz-small-nav-text" aria-current="page" href="#">مستحقات الدفع</a>
                            <span class="text-danger">0.00 د.ج</span>
                        </div>
                      </li>
                      <div class="vr m-2"></div>
                    <!-- <li class="nav-item position-relative">
                    <a class="dz-nav-icon" aria-current="page" href="#"><i class="fa-solid fa-envelope"></i></a>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        0
                      </span>
                </li>
                  <li class="nav-item position-relative">
                    <a class="dz-nav-icon" href="#"><i class="fa-solid fa-bell"></i></a>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        0
                      </span>
                </li> -->
                  <li class="nav-item position-relative">
                    <a class="dz-nav-icon" href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger dz-badge-color">
                        0
                      </span>
                  </li>
                </div>
                  <li class="nav-item dropdown dz-nav-profile">
                    <span>إسم المستخدم</span>
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <img class="avatar" src="{{asset('asset/users/dashboard')}}/img/avatars/man.png" alt="avatar" height="30" width="30">
                    </a>
                    <ul class="dropdown-menu">
                      <div class="dz-nav-profile-info" >
                        <p class="text-center">email@email.com</p>
                        <hr>
                      </div>
                      <li><a class="dropdown-item" href="#"><i class="fa-solid fa-boxes-packing"></i> بقاتي</a></li>
                      <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user"></i> حسابي</a></li>
                      <li><a class="dropdown-item text-danger" href="#"><i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              <!---->
            </nav>
        <!-- end Nav Bar-->

         <!-- Start Content-->
            <div class="content">


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
    <script src="{{asset('asset/users/dashboard')}}/js/jQuery-v3-7-1.js"></script>
    <script src="{{asset('asset/users/dashboard')}}/js/app.js"></script>
  </body>
</html>