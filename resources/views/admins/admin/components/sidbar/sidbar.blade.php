<!-- Start Sid Bar  -->
<div class="app-sidebar">
    <div class="logo-box text-center">
        <img class="logo-image" src="{{asset('asset/users/dashboard')}}/img/logo/store.png" alt="" widgh="50px" height="50px">
        <div class="user-name">
            <h6>{{Auth::guard('admin')->user()->type}}</h6>
        </div>
    </div>   
    <hr>
    <!--Start Menu-->
    <div class="menu">
        <div class="item"><a href="{{{route('admin.dashboard')}}}"><i class="fa-solid fa-gauge"></i> الرئيسية</a></div>
        <div class="item">
            <a class="sub-btn" href="#"><i class="fa-solid fa-money-bill-wave"></i> المدفوعات <i class="fa-solid fa-angle-left dropdown"></i></a>
            <div class="sub-menu">
                <a class="sub-item" href="{{{route('admin.payments.recharge_requests')}}}"><i class="fa-solid fa-wallet"></i> طلبات شحن الرصيد</a>
                <a class="sub-item" href="{{{route('admin.payments.invoices_payments')}}}"><i class="fa-solid fa-file-invoice-dollar"></i>تسديد الفواتير</a>
            </div>
        </div>
        <div class="item">
            <a class="sub-btn" href="#"><i class="fa-solid fa-users"></i> المشتركين <i class="fa-solid fa-angle-left dropdown"></i></a>
            <div class="sub-menu">
                <a class="sub-item" href="{{route('admin.suppliers')}}"><i class="fa-solid fa-user"></i> الموردين</a>
                <a class="sub-item" href="#"><i class="fa-solid fa-user"></i> تجار التجزئة</a>
                <a class="sub-item" href="#"><i class="fa-solid fa-user"></i> شركات التوصيل</a>
                <a class="sub-item" href="#"><i class="fa-solid fa-user"></i> المسوقين</a>
            </div>
        </div>
        <div class="item"><a href="#"><i class="fa-solid fa-box-open"></i> المنتجات</a></div>
        <div class="item"><a href="{{route('admin.settings')}}"><i class="fa-solid fa-gear"></i> الإعدادت</a></div>
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
  <div class="item"><a href="{{{route('admin.dashboard')}}}"><i class="fa-solid fa-gauge"></i> الرئيسية</a></div>
  <div class="item">
    <a class="sub-btn" href="#"><i class="fa-solid fa-money-bill-wave"></i> المدفوعات <i class="fa-solid fa-angle-left dropdown"></i></a>
    <div class="sub-menu">
        <a class="sub-item" href="{{{route('admin.payments.recharge_requests')}}}"><i class="fa-solid fa-wallet"></i> طلبات شحن الرصيد</a>
        <a class="sub-item" href="{{{route('admin.payments.invoices_payments')}}}"><i class="fa-solid fa-file-invoice-dollar"></i>تسديد الفواتير</a>
    </div>
  </div>
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
  <div class="item"><a href="{{route('admin.settings')}}"><i class="fa-solid fa-gear"></i> الإعدادت</a></div>
</div>
<!--End Menu-->
</div>
</div>
  <!--End Mbile Sidebar-->