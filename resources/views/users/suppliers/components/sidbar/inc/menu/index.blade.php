<div class="menu">
    <div class="text-center px-3 mb-3">
        <a class="btn store-visit-btn w-100 py-2.5 px-3 d-flex align-items-center justify-content-center gap-2" href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(Auth::user()->tenant_id)->domains[0]->domain)}}" target="_blank">
            <i class="fa-solid fa-store fs-6"></i>
            <span>الإنتقال إلى المتجر</span>
            <i class="fa-solid fa-arrow-up-right-from-square small opacity-75 ms-auto"></i>
        </a>
    </div>

    <div class="item {{ request()->routeIs('supplier.dashboard') ? 'active' : '' }}">
        <a href="{{route('supplier.dashboard')}}"><i class="fa-solid fa-gauge"></i> <span>الرئيسية</span></a>
    </div>

    <div class="item {{ request()->routeIs('supplier.orders*') ? 'active' : '' }}">
        <a class="sub-btn" href="#"><i class="fa-solid fa-cart-shopping"></i> <span>الطلبات</span> <i class="fa-solid fa-angle-left dropdown ms-auto"></i></a>
        <div class="sub-menu">
            <a class="sub-item {{ request()->routeIs('supplier.orders') ? 'fw-bold text-white' : '' }}" href="{{route('supplier.orders')}}"><i class="fa-solid fa-cart-plus me-1"></i> الطلبات</a>
            <a class="sub-item {{ request()->routeIs('supplier.orders-abandoned') ? 'fw-bold text-white' : '' }}" href="{{route('supplier.orders-abandoned')}}"><i class="fa-solid fa-cart-arrow-down me-1"></i> الطلبات المتروكة</a>
        </div>
    </div>

    <div class="item {{ request()->routeIs('supplier.products') ? 'active' : '' }}">
        <a href="{{route('supplier.products')}}"><i class="fa-solid fa-box-open"></i> <span>المنتجات</span></a>
    </div>

    <div class="item {{ request()->routeIs('supplier.*coupons*') ? 'active' : '' }}">
        <a class="sub-btn" href="#"><i class="fa-solid fa-receipt"></i> <span>الكوبونات</span> <i class="fa-solid fa-angle-left dropdown ms-auto"></i></a>
        <div class="sub-menu">
            <a class="sub-item {{ request()->routeIs('supplier.coupons') ? 'fw-bold text-white' : '' }}" href="{{route('supplier.coupons')}}"><i class="fa-solid fa-ticket me-1"></i> الكوبونات</a>
            <a class="sub-item {{ request()->routeIs('supplier.products-coupons') ? 'fw-bold text-white' : '' }}" href="{{route('supplier.products-coupons')}}"><i class="fa-solid fa-diagram-project me-1"></i> ربط الكوبونات بالمنتجات</a>
            <a class="sub-item {{ request()->routeIs('supplier.categories-coupons') ? 'fw-bold text-white' : '' }}" href="{{route('supplier.categories-coupons')}}"><i class="fa-solid fa-diagram-project me-1"></i> ربط الكوبونات بالأقسام</a>
        </div>
    </div>

    <div class="item {{ request()->routeIs('supplier.shipping') ? 'active' : '' }}">
        <a href="{{route('supplier.shipping')}}"><i class="fa-solid fa-truck-fast"></i> <span>الشحن</span></a>
    </div>

    <div class="item {{ request()->routeIs('supplier.apps') ? 'active' : '' }}">
        <a href="{{route('supplier.apps')}}"><i class="fa-brands fa-sketch"></i> <span>التطبيقات</span></a>
    </div>

    <div class="item {{ request()->routeIs('supplier.subscription') ? 'active' : '' }}">
        <a href="{{route('supplier.subscription')}}"><i class="fa-regular fa-address-card"></i> <span>الإشتراك</span></a>
    </div>

    <div class="item {{ request()->routeIs('supplier.billing') ? 'active' : '' }}">
        <a href="{{route('supplier.billing')}}"><i class="fas fa-file-invoice"></i> <span>الفواتير</span></a>
    </div>

    <div class="item {{ request()->routeIs('supplier.wallet') ? 'active' : '' }}">
        <a href="{{route('supplier.wallet')}}"><i class="fas fa-wallet"></i> <span>المحفظة</span></a>
    </div>

    @if(get_supplier_data(Auth::user()->tenant_id)->plan_subscription->plan_id == 3 && get_supplier_data(Auth::user()->tenant_id)->approval_status=='approved' && Auth::user()->bank_settings!=null)
    <div class="item {{ request()->routeIs('supplier.payments_proofs_refuseds') ? 'active' : '' }}">
        <a href="{{route('supplier.payments_proofs_refuseds')}}"><i class="fa-solid fa-file-invoice-dollar"></i> <span>إثباتات الدفع المرفوضة</span></a>
    </div>
    @endif

    <div class="item {{ request()->routeIs('supplier.support_tickets*') ? 'active' : '' }}">
        <a href="{{route('supplier.support_tickets.index')}}"><i class="fa-solid fa-headset"></i> <span>تذاكر الدعم الفني</span></a>
    </div>

    <div class="item {{ request()->routeIs('supplier.settings') ? 'active' : '' }}">
        <a href="{{route('supplier.settings')}}"><i class="fa-solid fa-gear"></i> <span>الإعدادات</span></a>
    </div>
</div>