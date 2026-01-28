<div class="menu">
    <div class="text-center">
        <a class="btn btn-primary app-btn-primary m-4 p-2" href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(Auth::user()->tenant_id)->domains[0]->domain)}}" target="_blank"><i class="fa-solid fa-store"></i> الإنتقال إلى المتجر</a>
    </div>
    <div class="item"><a href="{{route('seller.dashboard')}}"><i class="fa-solid fa-gauge"></i> الرئيسية</a></div>
       {{-- <div class="item">
        <a class="sub-btn" href="#"><i class="fas fa-file-alt"></i> الصفحات <i class="fa-solid fa-angle-left dropdown"></i></a>
        <div class="sub-menu">
            <a class="sub-item" href="{{route('seller.faqs.index')}}"><i class="fas fa-question-circle"></i> صفحة الأسئلة الشائعة</a>
        </div>
    </div> --}}
    <div class="item">
        <a class="sub-btn" href="#"><i class="fa-solid fa-cart-shopping"></i> الطلبات <i class="fa-solid fa-angle-left dropdown"></i></a>
        <div class="sub-menu">
            <a class="sub-item" href="{{route('seller.orders')}}"><i class="fa-solid fa-cart-plus"></i> الطلبات</a>
            <a class="sub-item" href="{{route('seller.orders-abandoned')}}"><i class="fa-solid fa-cart-plus"></i> الطلبات المتروكة</a>
        </div>
    </div>
    <div class="item"><a href="{{route('seller.products')}}"><i class="fa-solid fa-box-open"></i> المنتجات</a></div>
    {{-- <div class="item"><a href="{{route('seller.store-design')}}"><i class="fa-solid fa-palette"></i> تصميم المتجر</a></div> --}}
    <div class="item">
        <a class="sub-btn"><i class="fa-solid fa-receipt"></i> الكوبونات <i class="fa-solid fa-angle-left dropdown"></i></a>
    <div class="sub-menu">
        <a class="sub-item" href="{{route('seller.coupons')}}"><i class="fa-solid fa-ticket"></i> الكوبونات</a>
        <a class="sub-item" href="{{route('seller.products-coupons')}}"><i class="fa-solid fa-diagram-project"></i> ربط الكوبونات بالمنتجات</a>
        <a class="sub-item" href="{{route('seller.categories-coupons')}}"><i class="fa-solid fa-diagram-project"></i> ربط الكوبونات بالأقسام</a>
    </div>
    </div>
    <div class="item"><a href="{{route('seller.shipping')}}"><i class="fa-solid fa-truck-fast"></i> الشحن</a></div>
    <div class="item"><a href="{{route('seller.apps')}}"><i class="fa-brands fa-sketch"></i> التطبيقات</a></div>
    <div class="item"><a href="{{route('seller.subscription')}}"><i class="fa-regular fa-address-card"></i> الإشتراك</a></div>
    <div class="item"><a href="{{route('seller.billing')}}"><i class="fas fa-file-invoice"></i> الفواتير</a></div>
    <div class="item"><a href="{{route('seller.wallet')}}"><i class="fas fa-wallet"></i> المحفظة</a></div>
    <div class="item"><a href="{{route('seller.payments_proofs_refuseds')}}"><i class="fa-solid fa-file-invoice-dollar"></i> إثباتات الدفع المرفوضة</a></div>
    <div class="item"><a href="{{route('seller.settings')}}"><i class="fa-solid fa-gear"></i> الإعدادت</a></div>
</div>