    @php
        use App\Models\Dispute;
        use App\Models\ContactMessage;
        $newPaymentProofDisputesCount = Dispute::where('status', 'open')->count();
        $unread_message_count=Contactmessage::where('is_read',0)->count();
        $DisputesCount = $newPaymentProofDisputesCount;
    @endphp
    <div class="menu">
        <div class="item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge"></i> الرئيسية</a></div>
        @if (auth()->guard('admin')->user()->type == 'admin')
        <div class="item"><a href="{{ route('admin.financial.dashboard') }}"><i class="fa-solid fa-money-bill"></i> المالية</a></div>
        <div class="item">
            <a class="sub-btn" href="#"><i class="fa-solid fa-users-gear"></i>إدارة الموظفين
                <i class="fa-solid fa-angle-left dropdown"></i>
            </a>
            <div class="sub-menu">
                <a class="sub-item d-flex" href="{{ route('admin.employees') }}"><i class="fa-solid fa-users"></i>
                    الموظفين
                </a>
                <a class="sub-item d-flex" href="{{ route('admin.employees.create') }}"><i class="fa-solid fa-user-plus"></i>
                    إضافة موظف
                </a>
            </div>
        </div>
        @endif
        <!--start messages and chat-->
        <div class="item">
            <a class="sub-btn" href="#"><i class="fa-solid fa-envelope"></i>إدارة الرسائل 
                @if ($unread_message_count > 0)
                    <span class="badge bg-danger ms-2">{{ $unread_message_count }}</span>
                @endif
                <i class="fa-solid fa-angle-left dropdown"></i>
            </a>
            <div class="sub-menu">
                <a class="sub-item d-flex" href="{{ route('admin.contact.messages') }}"><i class="fa-solid fa-envelope"></i>
                    رسائل صفحة الهبوط
                </a>
                {{-- <a class="sub-item d-flex" href="{{ route('admin.general.chat') }}"><i class="fa-solid fa-user-plus"></i>
                   غرفة الدردشة العامة
                </a> --}}
                 
            </div>
        </div>
        <!--end messages and chat-->
        <div class="item">
            <a class="sub-btn" href="#"><i class="fa-solid fa-scale-balanced"></i>الشكاوى والنزاعات
                @if ($DisputesCount > 0)
                    <span class="badge bg-danger ms-2">{{ $DisputesCount }}</span>
                @endif
                <i class="fa-solid fa-angle-left dropdown"></i>
            </a>
            <div class="sub-menu">
                <a class="sub-item d-flex" href="{{ route('admin.payment_proof.disputes.refused') }}"><i
                        class="fa-solid fa-file-invoice-dollar"></i>
                    إثباتات الدفع المرفوضة من طرف البائعين
                    @if ($newPaymentProofDisputesCount > 0)
                        <span class="badge bg-danger ms-2">{{ $newPaymentProofDisputesCount }}</span>
                    @endif
                </a>
                <a class="sub-item d-flex" href="{{ route('admin.payment_proof.disputes') }}"><i
                        class="fa-solid fa-file-invoice-dollar"></i>
                    شكاوي الزبائن البائعين
                    @if ($newPaymentProofDisputesCount > 0)
                        <span class="badge bg-danger ms-2">{{ $newPaymentProofDisputesCount }}</span>
                    @endif
                </a>

                <a class="sub-item d-flex" href="{{ route('admin.payment_proof.disputes.archives') }}"><i
                        class="fa-solid fa-file-invoice-dollar"></i>
                    أرشيف ملفات النزاعات
                </a>

            </div>
        </div>
        <div class="item">
            <a class="sub-btn" href="#"><i class="fa-solid fa-money-bill-wave"></i> المدفوعات <i
                    class="fa-solid fa-angle-left dropdown"></i></a>
            <div class="sub-menu">
                <a class="sub-item" href="{{ route('admin.payments.recharge_requests') }}"><i
                        class="fa-solid fa-wallet"></i> طلبات شحن الرصيد</a>
                <a class="sub-item" href="{{ route('admin.payments.invoices_payments') }}"><i
                        class="fa-solid fa-file-invoice-dollar"></i>تسديد الفواتير</a>
                <a class="sub-item" href="{{ route('admin.payments.subscribes_payments') }}"><i
                        class="fa-solid fa-calendar-check"></i> تسديد الإشتراكات</a>
            </div>
        </div>
        <div class="item">
            <a class="sub-btn" href="#"><i class="fa-solid fa-users"></i> المشتركين <i
                    class="fa-solid fa-angle-left dropdown"></i></a>
            <div class="sub-menu">
                <a class="sub-item" href="{{ route('admin.suppliers') }}"><i class="fa-solid fa-user"></i> الموردين</a>
                <a class="sub-item" href="{{ route('admin.sellers') }}"><i class="fa-solid fa-user"></i> تجار التجزئة</a>
                <a class="sub-item" href="#"><i class="fa-solid fa-user"></i> شركات التوصيل</a>
                <a class="sub-item" href="#"><i class="fa-solid fa-user"></i> المسوقين</a>
            </div>
        </div>
        <div class="item"><a href="#"><i class="fa-solid fa-box-open"></i> المنتجات</a></div>
        <div class="item"><a href="{{ route('admin.settings') }}"><i class="fa-solid fa-gear"></i> الإعدادت</a></div>
    </div>
