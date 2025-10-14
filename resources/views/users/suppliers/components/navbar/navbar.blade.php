<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a id="3bar" class="navbar-brand d-none d-sm-block d-sm-none d-md-block" href="#"><i
                class="fa-solid fa-bars"></i></a>
        <a id="3bar1" class="navbar-brand d-md-none d-lg-block d-lg-none d-xl-block d-xl-none d-xxl-block d-xxl-none"
            href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
            aria-controls="offcanvasScrolling"><i class="fa-solid fa-bars"></i></a>

        <div class="dz-mobile-nav d-lg-block d-lg-none d-xl-block d-xl-none d-xxl-block d-xxl-none">
            <div style="padding: 10px;">
                <a class="dz-nav-icon" href="{{ route('supplier.orders') }}"><i
                        class="fa-solid fa-cart-shopping"></i></a>
                <span class="top-0 start-100 translate-middle badge rounded-pill bg-danger dz-badge-color">
                    {{ supplier_orders_unreaded() }}
                </span>
            </div>
            <ul class="navbar-nav">
                <li class="nav-item dropdown dz-nav-profile">
                    <span>{{ Auth::user()->name }}</span>
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img id="mobile-avatar" class="avatar" src="{{ is_supplier_has_avatar(auth()->user()->tenant_id) ?get_supplier_avatar(auth()->user()->tenant_id) : asset('asset/v1/users/dashboard/img/avatars/man.png') }}"
                            alt="avatar" height="30" width="30">
                    </a>
                    <ul class="dropdown-menu position-absolute" style="z-index:10000!important;">
                        <div class="dz-nav-profile-info">
                            <p class="text-center">{{ Auth::user()->email }}</p>
                            <hr>
                        </div>
                        <li><a class="dropdown-item" href="{{ route('supplier.subscription') }}"><i
                                    class="fa-solid fa-boxes-packing"></i> الخطة{{ get_supplier_plan_data(get_supplier_subscription_data(get_supplier_data(auth()->user()->tenant_id)->id)->plan_id)->name }}</a>
                            <span>
                                @if (get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id == 1)
                                    (صلاحية الخطة مدى الحياة)
                                @else
                                    (صلاحية الخطة
                                    {{ appDiffInDays(now(), get_supplier_data(auth()->user()->tenant_id)->plan_subscription->subscription_end_date) }}
                                    يوم)
                                @endif
                            </span>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('supplier.profile') }}"><i
                                    class="fa-solid fa-user"></i> حسابي</a></li>
                        <li><a class="dropdown-item text-danger" href="#"><i
                                    class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج</a></li>
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
                        <a class="nav-link dz-small-nav-text" aria-current="page"
                            href="{{ route('supplier.wallet') }}">الرصيد</a>
                        <span class="text-success">{{ get_user_data(Auth::user()->tenant->id)->balance->balance }}
                            د.ج</span>

                        <div class="vr m-2"></div>

                        <a class="nav-link dz-small-nav-text" aria-current="page"
                            href="{{ route('supplier.billing') }}">مستحقات الدفع</a>
                        <span
                            class="text-danger">{{ get_user_data(Auth::user()->tenant->id)->balance->outstanding_amount }}
                            د.ج</span>
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
                    <a class="dz-nav-icon" href="{{ route('supplier.orders') }}"><i
                            class="fa-solid fa-cart-shopping"></i></a>
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger dz-badge-color">
                        {{ supplier_orders_unreaded() }}
                    </span>
                </li>
            </div>
            <li class="nav-item dropdown dz-nav-profile">
                <span>{{ Auth::user()->name }}</span>
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img id="pc-avatar" class="avatar" src="{{ is_supplier_has_avatar(auth()->user()->tenant_id) ?get_supplier_avatar(auth()->user()->tenant_id) : asset('asset/v1/users/dashboard/img/avatars/man.png') }}"
                        alt="avatar" height="30" width="30">
                </a>
                <ul class="dropdown-menu">
                    <div class="dz-nav-profile-info">
                        <p class="text-center">{{ Auth::user()->email }}</p>
                        <hr>
                    </div>
                    <li class="text-center"><a class="dropdown-item" href="{{ route('supplier.subscription') }}"><i
                                class="fa-solid fa-boxes-packing"></i> الخطة
                            {{ get_supplier_plan_data(get_supplier_subscription_data(get_supplier_data(auth()->user()->tenant_id)->id)->plan_id)->name }}</a>
                        <span>
                            @if (get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id == 1)
                                (صلاحية الخطة مدى الحياة)
                            @else
                                (صلاحية الخطة
                                {{ appDiffInDays(now(), get_supplier_data(auth()->user()->tenant_id)->plan_subscription->subscription_end_date) }}
                                يوم)
                            @endif
                        </span>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('supplier.profile') }}"><i
                                class="fa-solid fa-user"></i> حسابي</a></li>
                    <li>
                        {{-- <a class="dropdown-item text-danger" href="{{ route('supplier.logout') }}"><i class="fa-solid fa-right-from-bracket"></i>
               تسجيل الخروج  
              </a> --}}
                        <form action="{{ route('supplier.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">تسجيل الخروج</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!---->
</nav>
