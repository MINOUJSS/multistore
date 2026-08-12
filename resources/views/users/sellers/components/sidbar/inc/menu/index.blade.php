<div class="menu">
    <div class="text-center px-3 mb-3">
        <a class="btn store-visit-btn w-100 py-2.5 px-3 d-flex align-items-center justify-content-center gap-2" href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(Auth::user()->tenant_id)->domains[0]->domain)}}" target="_blank">
            <i class="fa-solid fa-store fs-6"></i>
            <span>الإنتقال إلى المتجر</span>
            <i class="fa-solid fa-arrow-up-right-from-square small opacity-75 ms-auto"></i>
        </a>
    </div>

    <div class="item {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
        <a href="{{route('seller.dashboard')}}"><i class="fa-solid fa-gauge"></i> <span>الرئيسية</span></a>
    </div>

    <div class="item {{ request()->routeIs('seller.orders*') ? 'active' : '' }}">
        <a class="sub-btn" href="#"><i class="fa-solid fa-cart-shopping"></i> <span>الطلبات</span> <i class="fa-solid fa-angle-left dropdown ms-auto"></i></a>
        <div class="sub-menu">
            <a class="sub-item {{ request()->routeIs('seller.orders') ? 'fw-bold text-white' : '' }}" href="{{route('seller.orders')}}"><i class="fa-solid fa-cart-plus me-1"></i> الطلبات</a>
            <a class="sub-item {{ request()->routeIs('seller.orders-abandoned') ? 'fw-bold text-white' : '' }}" href="{{route('seller.orders-abandoned')}}"><i class="fa-solid fa-cart-arrow-down me-1"></i> الطلبات المتروكة</a>
        </div>
    </div>

    <div class="item {{ request()->routeIs('seller.products') ? 'active' : '' }}">
        <a href="{{route('seller.products')}}"><i class="fa-solid fa-box-open"></i> <span>المنتجات</span></a>
    </div>

    <div class="item {{ request()->routeIs('seller.*coupons*') ? 'active' : '' }}">
        <a class="sub-btn" href="#"><i class="fa-solid fa-receipt"></i> <span>الكوبونات</span> <i class="fa-solid fa-angle-left dropdown ms-auto"></i></a>
        <div class="sub-menu">
            <a class="sub-item {{ request()->routeIs('seller.coupons') ? 'fw-bold text-white' : '' }}" href="{{route('seller.coupons')}}"><i class="fa-solid fa-ticket me-1"></i> الكوبونات</a>
            <a class="sub-item {{ request()->routeIs('seller.products-coupons') ? 'fw-bold text-white' : '' }}" href="{{route('seller.products-coupons')}}"><i class="fa-solid fa-diagram-project me-1"></i> ربط الكوبونات بالمنتجات</a>
            <a class="sub-item {{ request()->routeIs('seller.categories-coupons') ? 'fw-bold text-white' : '' }}" href="{{route('seller.categories-coupons')}}"><i class="fa-solid fa-diagram-project me-1"></i> ربط الكوبونات بالأقسام</a>
        </div>
    </div>

    <div class="item {{ request()->routeIs('seller.shipping') ? 'active' : '' }}">
        <a href="{{route('seller.shipping')}}"><i class="fa-solid fa-truck-fast"></i> <span>الشحن</span></a>
    </div>

    <div class="item {{ request()->routeIs('seller.apps') ? 'active' : '' }}">
        <a href="{{route('seller.apps')}}"><i class="fa-brands fa-sketch"></i> <span>التطبيقات</span></a>
    </div>

    <div class="item {{ request()->routeIs('seller.subscription') ? 'active' : '' }}">
        <a href="{{route('seller.subscription')}}"><i class="fa-regular fa-address-card"></i> <span>الإشتراك</span></a>
    </div>

    <div class="item {{ request()->routeIs('seller.billing') ? 'active' : '' }}">
        <a href="{{route('seller.billing')}}"><i class="fas fa-file-invoice"></i> <span>الفواتير</span></a>
    </div>

    <div class="item {{ request()->routeIs('seller.wallet') ? 'active' : '' }}">
        <a href="{{route('seller.wallet')}}"><i class="fas fa-wallet"></i> <span>المحفظة</span></a>
    </div>

    @if(get_seller_data(Auth::user()->tenant_id)->plan_subscription->plan_id == 3 && get_seller_data(Auth::user()->tenant_id)->approval_status=='approved' && Auth::user()->bank_settings!=null)
    <div class="item {{ request()->routeIs('seller.payments_proofs_refuseds') ? 'active' : '' }}">
        <a href="{{route('seller.payments_proofs_refuseds')}}"><i class="fa-solid fa-file-invoice-dollar"></i> <span>إثباتات الدفع المرفوضة</span></a>
    </div>
    @endif

    <div class="item {{ request()->routeIs('seller.support_tickets*') ? 'active' : '' }}">
        <a href="{{route('seller.support_tickets.index')}}"><i class="fa-solid fa-headset"></i> <span>تذاكر الدعم الفني</span></a>
    </div>

    <div class="item {{ request()->routeIs('seller.settings') ? 'active' : '' }}">
        <a href="{{route('seller.settings')}}"><i class="fa-solid fa-gear"></i> <span>الإعدادات</span></a>
    </div>
</div>