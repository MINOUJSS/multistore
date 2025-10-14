<!-- Start Sid Bar  -->
<div class="app-sidebar">
    <div class="logo-box text-center">
        <img class="logo-image" src="{{asset('asset/v1/users/dashboard')}}/img/logo/store.png" alt="" widgh="50px" height="50px">
        <div class="user-name">
            <h6>{{Auth::user()->tenant_id}}</h6>
        </div>
    </div>   
    <hr>
    <!--Start Menu-->
    @include('users.suppliers.components.sidbar.inc.menu.index')
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
  <img class="logo-image" src="{{asset('asset/v1/users/dashboard')}}/img/logo/store.png" alt="" widgh="50px" height="50px">
  <div class="user-name">
      <h6>{{Auth::user()->name}}</h6>
  </div>
</div>   
<hr>
<!--Start Menu-->
@include('users.suppliers.components.sidbar.inc.menu.index')
<!--End Menu-->
</div>
</div>
  <!--End Mbile Sidebar-->