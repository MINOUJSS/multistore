<div class="menu">
    <div class="item"><a href="{{{route('admin.dashboard')}}}"><i class="fa-solid fa-gauge"></i> الرئيسية</a></div>
    <div class="item">
        <a class="sub-btn" href="#"><i class="fa-solid fa-money-bill-wave"></i> المدفوعات <i class="fa-solid fa-angle-left dropdown"></i></a>
        <div class="sub-menu">
            <a class="sub-item" href="{{{route('admin.payments.recharge_requests')}}}"><i class="fa-solid fa-wallet"></i> طلبات شحن الرصيد</a>
            <a class="sub-item" href="{{{route('admin.payments.invoices_payments')}}}"><i class="fa-solid fa-file-invoice-dollar"></i>تسديد الفواتير</a>
            <a class="sub-item" href="{{{route('admin.payments.subscribes_payments')}}}"><i class="fa-solid fa-calendar-check"></i> تسديد الإشتراكات</a>
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