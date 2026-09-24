<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">
    @php
        $telegramApp = $user?->telegrame_chat_id?->first();
        $telegramChatId = null;
        $telegramStatus = null;
        if ($telegramApp && !empty($telegramApp->data)) {
            $decodedData = json_decode($telegramApp->data);
            $telegramChatId = $decodedData->chat_id ?? null;
            $telegramStatus = $telegramApp->status ?? 'active';
        }
    @endphp

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm"
        style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-7 mb-3 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <a href="{{ route('admin.sellers') }}"
                        class="btn btn-sm btn-light text-dark rounded-circle border-0 shadow-sm" title="العودة للقائمة">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <div
                        class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small border border-white border-opacity-10">
                        <i class="fa-solid fa-user-tie text-warning"></i>
                        <span>{{ __('ملف وتفاصيل البائع') }}</span>
                        <span class="opacity-50">|</span>
                        <span>{{ '@' . $seller->store_name }}</span>
                    </div>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🏪 {{ $seller->full_name }} 👋
                </h1>
                <div class="d-flex align-items-center gap-2 flex-wrap text-white-50">
                    <span>البريد: <strong class="text-white dir-ltr">{{ $seller->email }}</strong></span>
                    <span class="opacity-50">•</span>
                    <span>تاريخ التسجيل: <strong
                            class="text-white">{{ $seller->created_at->format('Y-m-d') }}</strong></span>
                    @if ($telegramChatId)
                        <span class="opacity-50">•</span>
                        <span>تليغرام:
                            <strong class="text-white dir-ltr">
                                <i class="fab fa-telegram text-info me-1"></i>
                                @if (str_starts_with($telegramChatId, '@'))
                                    <a href="https://t.me/{{ ltrim($telegramChatId, '@') }}" target="_blank"
                                        class="text-white text-decoration-underline" title="فتح المحادثة في تليغرام">
                                        {{ $telegramChatId }}
                                    </a>
                                @else
                                    {{ $telegramChatId }}
                                @endif
                            </strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    {{-- حالة الموافقة --}}
                    @if ($seller->approval_status == 'approved' || $seller->approval_status == 'pending')
                        <button class="btn btn-danger text-white fw-bold px-3 py-2 rounded-3 shadow-sm border-0"
                            data-bs-toggle="modal" data-bs-target="#unApproveModal">
                            <i class="fa-solid fa-user-xmark me-1"></i> رفض توثيق البائع
                        </button>
                        <button class="btn btn-success text-white fw-bold px-3 py-2 rounded-3 shadow-sm border-0"
                            onclick="approveSeller({{ $seller->id }})">
                            <i class="fa-solid fa-user-check me-1"></i> توثيق البائع
                        </button>
                    @elseif($seller->approval_status == 'pending')
                        <button class="btn btn-success text-white fw-bold px-3 py-2 rounded-3 shadow-sm border-0"
                            onclick="approveSeller({{ $seller->id }})">
                            <i class="fa-solid fa-user-check me-1"></i> توثيق البائع
                        </button>
                    @endif
                    <button class="btn btn-light text-dark fw-bold px-3 py-2 rounded-3 shadow-sm border-0"
                        onclick="printSellerInfo()">
                        <i class="fa-solid fa-print me-1"></i> طباعة المعلومات
                    </button>
                    <button class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 shadow-sm border-0"
                        data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fa-solid fa-key me-1"></i> تغيير كلمة المرور
                    </button>
                    <button class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 shadow-sm border-2"
                        data-bs-toggle="modal" data-bs-target="#resetStoreModal"
                        title="إعادة ضبط مظهر وإعدادات المتجر إلى الوضع الافتراضي">
                        <i class="fa-solid fa-arrows-rotate me-1"></i> إعادة ضبط المتجر
                    </button>
                    <button class="btn btn-danger text-white fw-bold px-3 py-2 rounded-3 shadow-sm border-0"
                        data-bs-toggle="modal" data-bs-target="#resetBalanceModal"
                        title="تصفير رصيد البائع مع التحذير وتسجيل السبب">
                        <i class="fa-solid fa-wallet me-1"></i> تصفير الرصيد
                    </button>
                    <button class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 shadow-sm border-2"
                        data-bs-toggle="modal" data-bs-target="#cleanSellerTempModal"
                        title="تنظيف الملفات المؤقتة المتراكمة في مجلد temp لهذا البائع">
                        <i class="fa-solid fa-broom me-1"></i> تنظيف المؤقتات
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="printableArea">
        <!-- Seller Main Profile Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-4">
                    {{-- Avatar --}}
                    <div class="text-center position-relative">
                        <img src="{{ $seller->avatar ? asset($seller->avatar) : asset('/asset/v1/users/dashboard/img/avatars/man.png') }}"
                            alt="{{ $seller->full_name }}" class="rounded-circle border shadow-sm object-fit-cover"
                            width="120" height="120">
                    </div>

                    {{-- Info Details --}}
                    <div class="flex-grow-1 w-100">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
                            <div>
                                <h3 class="fw-bold text-dark mb-1">{{ $seller->full_name }}</h3>
                                <p class="text-primary mb-0 dir-ltr text-start fw-semibold">
                                    {{ '@' . $seller->store_name }}</p>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                {{-- Activation Status --}}
                                @if ($seller->status == 'active')
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill fw-bold">مفعل</span>
                                @else
                                    <span
                                        class="badge bg-secondary bg-opacity-10 text-secondary border px-3 py-1.5 rounded-pill fw-bold">غير
                                        مفعل</span>
                                @endif

                                {{-- Approval Status --}}
                                @if ($seller->approval_status == 'approved')
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1.5 rounded-pill fw-bold">تمت
                                        الموافقة</span>
                                @elseif($seller->approval_status == 'pending')
                                    <span
                                        class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-3 py-1.5 rounded-pill fw-bold">قيد
                                        المراجعة</span>
                                @else
                                    <span
                                        class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1.5 rounded-pill fw-bold">مرفوض</span>
                                @endif
                            </div>
                        </div>

                        <div class="row g-3 pt-3 border-top">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">البريد الإلكتروني:</small>
                                    <div class="fw-bold text-dark dir-ltr text-start small">{{ $seller->email }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">معرف التينانت:</small>
                                    <div class="fw-bold text-dark dir-ltr text-start small">{{ $seller->tenant_id }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">الإسم الأول واللقب:</small>
                                    <div class="fw-bold text-dark fs-6">{{ $seller->first_name ?? '-' }}
                                        {{ $seller->last_name ?? '' }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">الجنس:</small>
                                    <div class="fw-bold text-dark fs-6">
                                        @if ($seller->sex == 'male')
                                            ذكر
                                        @elseif($seller->sex == 'female')
                                            أنثى
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">تاريخ الميلاد:</small>
                                    <div class="fw-bold text-dark fs-6 dir-ltr text-start">
                                        {{ $seller->birth_date ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">ضمن القائمة المعتمدة:</small>
                                    <div class="fw-bold text-dark fs-6">
                                        {{ $seller->part_of_approved_list == 'yes' ? 'نعم' : 'لا' }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">تاريخ التسجيل:</small>
                                    <div class="fw-bold text-dark fs-6 dir-ltr text-start">
                                        {{ $seller->created_at->format('Y-m-d H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders KPI Stats Grid -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fw-semibold small d-block mb-1">إجمالي طلبات المنتجات</span>
                            <h3 class="fw-bold mb-0 text-dark">{{ number_format($ordersCount ?? 0) }}</h3>
                        </div>
                        <div class="rounded-4 p-3 d-flex align-items-center justify-content-center"
                            style="background: rgba(164, 12, 114, 0.1); color: #a40c72; width: 54px; height: 54px;">
                            <i class="fa-solid fa-cart-shopping fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small d-flex align-items-center gap-1">
                        <i class="fa-solid fa-chart-line text-primary"></i>
                        <span>العدد الكلي للطلبات على منتجات البائع</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fw-semibold small d-block mb-1">طلبات مكتملة / مستلمة</span>
                            <h3 class="fw-bold mb-0 text-success">{{ number_format($deliveredOrdersCount ?? 0) }}</h3>
                        </div>
                        <div class="rounded-4 p-3 d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success"
                            style="width: 54px; height: 54px;">
                            <i class="fa-solid fa-circle-check fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small d-flex align-items-center gap-1">
                        <i class="fa-solid fa-truck-ramp-box text-success"></i>
                        <span>تم تسليمها للزبائن بنجاح</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fw-semibold small d-block mb-1">قيد المعالجة والانتظار</span>
                            <h3 class="fw-bold mb-0 text-warning">{{ number_format($pendingOrdersCount ?? 0) }}</h3>
                        </div>
                        <div class="rounded-4 p-3 d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning"
                            style="width: 54px; height: 54px;">
                            <i class="fa-solid fa-clock-rotate-left fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small d-flex align-items-center gap-1">
                        <i class="fa-solid fa-spinner text-warning"></i>
                        <span>طلبات قيد المتابعة والتجهيز</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted fw-semibold small d-block mb-1">إثباتات دفع الزبائن</span>
                            <h3 class="fw-bold mb-0" style="color: #5c0649;">
                                {{ number_format($ordersWithProofCount ?? 0) }}</h3>
                        </div>
                        <div class="rounded-4 p-3 d-flex align-items-center justify-content-center"
                            style="background: rgba(92, 6, 73, 0.1); color: #5c0649; width: 54px; height: 54px;">
                            <i class="fa-solid fa-receipt fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small d-flex align-items-center gap-1">
                        <i class="fa-solid fa-file-invoice-dollar" style="color: #be0681;"></i>
                        <span>وصولات دفع مرفوعة للمراقبة</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address & ID Card Row -->
        <div class="row g-4 mb-4">
            <!-- Address Card -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4">
                    <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                        <i class="fa-solid fa-location-dot me-2" style="color: #a40c72;"></i> معلومات العنوان
                    </h5>
                    <div class="row g-3">
                        <div class="col-12 col-sm-4">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted fw-semibold d-block mb-1">الولاية:</small>
                                <div class="fw-bold text-dark fs-6">{{ $seller->wilaya ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted fw-semibold d-block mb-1">الدائرة:</small>
                                <div class="fw-bold text-dark fs-6">{{ $seller->dayra ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted fw-semibold d-block mb-1">البلدية:</small>
                                <div class="fw-bold text-dark fs-6">{{ $seller->baladia ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted fw-semibold d-block mb-1">العنوان الكامل:</small>
                                <div class="fw-bold text-dark fs-6">{{ $seller->address ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ID Card Image Card -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4 text-center">
                    <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom text-start">
                        <i class="fa-solid fa-id-card me-2" style="color: #a40c72;"></i> صورة بطاقة الهوية
                    </h5>
                    @if ($seller->id_card_image)
                        <a href="{{ asset($seller->id_card_image) }}" target="_blank" class="d-inline-block mt-2">
                            <img src="{{ asset($seller->id_card_image) }}" alt="بطاقة الهوية"
                                class="img-fluid rounded-4 border shadow-sm object-fit-cover hover-lift"
                                style="max-height: 250px;">
                        </a>
                    @else
                        <div class="p-4 bg-light rounded-3 text-muted my-auto">
                            <i class="fa-solid fa-id-card fs-2 mb-2 d-block opacity-50"></i>
                            <span>لم يتم رفع صورة بطاقة الهوية بعد.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Account Linked Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 p-4">
            <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                <i class="fa-solid fa-user-gear me-2" style="color: #a40c72;"></i> معلومات حساب المستخدم المرتبط
            </h5>
            @if ($user)
                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-lg">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <small class="text-muted fw-semibold d-block mb-1">الإسم الكامل:</small>
                            <div class="fw-bold text-dark fs-6">{{ $user->name }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <small class="text-muted fw-semibold d-block mb-1">البريد الإلكتروني:</small>
                            <div class="fw-bold text-dark dir-ltr text-start small">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <small class="text-muted fw-semibold d-block mb-1">رقم الهاتف:</small>
                            <div class="fw-bold text-dark dir-ltr text-start small">{{ $user->phone }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <small class="text-muted fw-semibold d-block mb-1">نوع الحساب:</small>
                            <div class="fw-bold text-primary fs-6">بائع (Seller)</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <small class="text-muted fw-semibold d-block mb-1">
                                <i class="fab fa-telegram text-info me-1"></i> تليجرام (Chat ID):
                            </small>
                            @if ($telegramChatId)
                                <div class="d-flex align-items-center justify-content-between gap-1 flex-wrap">
                                    <div class="fw-bold text-dark dir-ltr font-monospace small">
                                        @if (str_starts_with($telegramChatId, '@'))
                                            <a href="https://t.me/{{ ltrim($telegramChatId, '@') }}" target="_blank"
                                                class="text-primary text-decoration-none"
                                                title="فتح المحادثة في تليغرام">
                                                {{ $telegramChatId }} <i
                                                    class="fa-solid fa-arrow-up-right-from-square"
                                                    style="font-size: 10px;"></i>
                                            </a>
                                        @else
                                            {{ $telegramChatId }}
                                        @endif
                                    </div>
                                    <span
                                        class="badge {{ $telegramStatus === 'active' ? 'bg-success' : 'bg-secondary' }} bg-opacity-10 {{ $telegramStatus === 'active' ? 'text-success' : 'text-secondary' }} border px-2 py-0.5 rounded-pill"
                                        style="font-size: 10px;">
                                        {{ $telegramStatus === 'active' ? 'نشط' : 'معطل' }}
                                    </span>
                                </div>
                            @else
                                <div class="text-muted small">غير متاح / غير مرتبط</div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning rounded-3 mb-0">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> لا يوجد حساب مستخدم مرتبط بهذا البائع حالياً.
                </div>
            @endif
        </div>

        <!-- Payment Gateways & Financial Accounts Row -->
        <div class="row g-4 mb-4">
            <!-- Bank Account Card -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-building-columns" style="color: #a40c72;"></i>
                            <span>الحساب البنكي للبائع</span>
                        </h5>
                        @if ($bankAccount)
                            <span
                                class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill fw-bold">
                                <i class="fa-solid fa-circle-check me-1"></i> مضاف ومفعّل
                            </span>
                        @else
                            <span
                                class="badge bg-secondary bg-opacity-10 text-secondary border px-3 py-1.5 rounded-pill fw-bold">
                                <i class="fa-solid fa-circle-xmark me-1"></i> غير مضاف
                            </span>
                        @endif
                    </div>

                    @if ($bankAccount)
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <small class="text-muted fw-semibold d-block mb-1">اسم المؤسسة البنكية /
                                        البريد:</small>
                                    <div class="fw-bold text-dark fs-6 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-landmark text-primary"></i>
                                        <span>{{ $bankAccount->bank_name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <small class="text-muted fw-semibold d-block mb-1">اسم صاحب الحساب:</small>
                                    <div class="fw-bold text-dark fs-6 d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-user-tag text-info"></i>
                                        <span>{{ $bankAccount->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 bg-light rounded-3">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <small class="text-muted fw-semibold">رقم الحساب البنكي / RIP / CCP:</small>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary py-0 px-2 rounded-2"
                                            onclick="navigator.clipboard.writeText('{{ $bankAccount->account_number }}'); this.innerText='تم النسخ!'; setTimeout(() => this.innerText='نسخ', 2000)">
                                            <i class="fa-solid fa-copy me-1"></i> نسخ
                                        </button>
                                    </div>
                                    <div
                                        class="fw-bold text-dark font-monospace fs-5 dir-ltr text-start user-select-all">
                                        {{ $bankAccount->account_number }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-light rounded-3 text-center text-muted my-auto">
                            <i class="fa-solid fa-building-columns fs-2 mb-2 d-block opacity-50"></i>
                            <h6 class="fw-bold text-dark">لا يوجد حساب بنكي مسجل</h6>
                            <p class="small text-muted mb-0">لم يقم هذا البائع بإدخال بيانات حسابه البنكي أو البريدي
                                (CCP/RIP) في إعدادات متجره بعد.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Chargily Gateway Card -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-credit-card" style="color: #a40c72;"></i>
                            <span>بوابة الدفع الإلكتروني (شارجيلي Pay)</span>
                        </h5>
                        @if ($chargilySetting)
                            <span
                                class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill fw-bold">
                                <i class="fa-solid fa-link me-1"></i> متصل ومربوط
                            </span>
                        @else
                            <span
                                class="badge bg-secondary bg-opacity-10 text-secondary border px-3 py-1.5 rounded-pill fw-bold">
                                <i class="fa-solid fa-link-slash me-1"></i> غير مفعل
                            </span>
                        @endif
                    </div>

                    @if ($chargilySetting)
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <small class="text-muted fw-semibold d-block mb-1">بيئة العمل الحالية:</small>
                                    <div>
                                        @if ($chargilySetting->mode === 'live')
                                            <span class="badge bg-success text-white px-3 py-1.5 rounded-pill fw-bold">
                                                <i class="fa-solid fa-bolt me-1"></i> وضع الإنتاج الحقيقي (Live)
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold">
                                                <i class="fa-solid fa-vial me-1"></i> وضع الاختبار التجريبي (Test)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <small class="text-muted fw-semibold d-block mb-1">تاريخ ربط الحساب:</small>
                                    <div class="fw-bold text-dark fs-6 dir-ltr text-start">
                                        {{ $chargilySetting->created_at ? $chargilySetting->created_at->format('Y-m-d') : '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 bg-light rounded-3">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <small class="text-muted fw-semibold">المفتاح العام (Public Key):</small>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary py-0 px-2 rounded-2"
                                            onclick="navigator.clipboard.writeText('{{ $chargilySetting->public_key }}'); this.innerText='تم النسخ!'; setTimeout(() => this.innerText='نسخ', 2000)">
                                            <i class="fa-solid fa-copy me-1"></i> نسخ
                                        </button>
                                    </div>
                                    <div class="fw-bold text-dark font-monospace small dir-ltr text-start text-truncate"
                                        title="{{ $chargilySetting->public_key }}">
                                        {{ \Illuminate\Support\Str::limit($chargilySetting->public_key, 35, '...') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-light rounded-3 text-center text-muted my-auto">
                            <i class="fa-solid fa-credit-card fs-2 mb-2 d-block opacity-50"></i>
                            <h6 class="fw-bold text-dark">بوابة شارجيلي غير مربوطة</h6>
                            <p class="small text-muted mb-0">لم يقم هذا البائع بربط مفاتيح API الخاصة ببوابة Chargily
                                Pay (CIB / الذهبية) في متجره بعد.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Customer Orders & Payment Proofs Auditing Section -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
            <div
                class="card-header bg-white border-0 p-4 d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-2.5 rounded-3 text-white d-flex align-items-center justify-content-center"
                        style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 100%); width: 44px; height: 44px;">
                        <i class="fa-solid fa-money-check-dollar fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">إثباتات الدفع لطلبات زبائن البائع (مراقبة وتدقيق)</h5>
                        <small class="text-muted">مراجعة التحويلات ووصولات الدفع المرفوعة لطلبات الزبائن الخاصة بمتجر
                            هذا البائع</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-semibold">
                        إجمالي المعروض: {{ $ordersWithProofs->count() }} إثبات
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                @if ($ordersWithProofs->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase fw-bold border-bottom">
                                <tr>
                                    <th class="py-3 px-4">رقم الطلب</th>
                                    <th class="py-3">الزبون</th>
                                    <th class="py-3">الهاتف</th>
                                    <th class="py-3">المبلغ الإجمالي</th>
                                    <th class="py-3">طريقة الدفع</th>
                                    <th class="py-3">حالة الدفع</th>
                                    <th class="py-3">حالة الطلب</th>
                                    <th class="py-3">تاريخ الطلب</th>
                                    <th class="py-3 px-4 text-center">إثبات الدفع</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ordersWithProofs as $order)
                                    <tr>
                                        <td class="py-3 px-4">
                                            <span
                                                class="fw-bold text-dark dir-ltr font-monospace">#{{ $order->order_number }}</span>
                                        </td>
                                        <td class="py-3">
                                            <div class="fw-semibold text-dark">
                                                {{ $order->customer_name ?? 'غير محدد' }}</div>
                                            @if ($order->email)
                                                <small
                                                    class="text-muted dir-ltr text-start d-block">{{ $order->email }}</small>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            <span
                                                class="dir-ltr text-start font-monospace small text-dark">{{ $order->phone }}</span>
                                        </td>
                                        <td class="py-3">
                                            <span
                                                class="fw-bold text-dark">{{ number_format($order->total_price, 2) }}</span>
                                            <small class="text-muted">د.ج</small>
                                        </td>
                                        <td class="py-3">
                                            <span
                                                class="badge bg-light text-dark border px-2.5 py-1 rounded-pill small">
                                                {{ $order->payment_method === 'verments' ? 'تحويل بنكي / CCP' : $order->payment_method }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            @if ($order->payment_status === 'paid')
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill fw-semibold">
                                                    <i class="fa-solid fa-check me-1"></i> مدفوع
                                                </span>
                                            @elseif($order->payment_status === 'pending')
                                                <span
                                                    class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2.5 py-1 rounded-pill fw-semibold">
                                                    <i class="fa-solid fa-clock me-1"></i> معلق
                                                </span>
                                            @else
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2.5 py-1 rounded-pill fw-semibold">
                                                    {{ $order->payment_status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            @php
                                                $statusBadges = [
                                                    'pending' => [
                                                        'bg' => 'bg-warning bg-opacity-10',
                                                        'text' => 'text-dark',
                                                        'label' => 'قيد الانتظار',
                                                    ],
                                                    'processing' => [
                                                        'bg' => 'bg-info bg-opacity-10',
                                                        'text' => 'text-info',
                                                        'label' => 'قيد المعالجة',
                                                    ],
                                                    'shipped' => [
                                                        'bg' => 'bg-primary bg-opacity-10',
                                                        'text' => 'text-primary',
                                                        'label' => 'تم الشحن',
                                                    ],
                                                    'delivered' => [
                                                        'bg' => 'bg-success bg-opacity-10',
                                                        'text' => 'text-success',
                                                        'label' => 'مكتمل / مسلّم',
                                                    ],
                                                    'canceled' => [
                                                        'bg' => 'bg-danger bg-opacity-10',
                                                        'text' => 'text-danger',
                                                        'label' => 'ملغي',
                                                    ],
                                                ];
                                                $badgeInfo = $statusBadges[$order->status] ?? [
                                                    'bg' => 'bg-secondary bg-opacity-10',
                                                    'text' => 'text-secondary',
                                                    'label' => $order->status,
                                                ];
                                            @endphp
                                            <span
                                                class="badge {{ $badgeInfo['bg'] }} {{ $badgeInfo['text'] }} border px-2.5 py-1 rounded-pill fw-semibold">
                                                {{ $badgeInfo['label'] }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <small class="text-muted dir-ltr text-start d-block">
                                                {{ $order->created_at ? $order->created_at->format('Y-m-d H:i') : $order->order_date ?? '-' }}
                                            </small>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <div class="d-inline-flex align-items-center gap-2">
                                                @php
                                                    $proofUrl = str_starts_with($order->payment_proof, 'http')
                                                        ? $order->payment_proof
                                                        : asset($order->payment_proof);
                                                @endphp
                                                <img src="{{ $proofUrl }}"
                                                    alt="وصل الطلب #{{ $order->order_number }}"
                                                    class="rounded-3 border shadow-sm object-fit-cover hover-lift"
                                                    width="42" height="42" style="cursor: pointer;"
                                                    onclick="inspectPaymentProof('{{ $proofUrl }}', '#{{ $order->order_number }}', '{{ addslashes($order->customer_name ?? 'غير محدد') }}', '{{ number_format($order->total_price, 2) }} د.ج', '{{ $order->created_at ? $order->created_at->format('Y-m-d H:i') : '' }}')"
                                                    title="انقر لتكبير الوصل">
                                                <button type="button"
                                                    class="btn btn-sm btn-light border px-2.5 py-1.5 rounded-3 fw-semibold text-dark shadow-xs"
                                                    onclick="inspectPaymentProof('{{ $proofUrl }}', '#{{ $order->order_number }}', '{{ addslashes($order->customer_name ?? 'غير محدد') }}', '{{ number_format($order->total_price, 2) }} د.ج', '{{ $order->created_at ? $order->created_at->format('Y-m-d H:i') : '' }}')"
                                                    title="معاينة إثبات الدفع">
                                                    <i class="fa-solid fa-magnifying-glass-plus text-primary me-1"></i>
                                                    <span class="small">معاينة</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-5 text-center text-muted">
                        <i class="fa-solid fa-file-invoice-dollar fs-1 mb-3 d-block opacity-25"
                            style="color: #a40c72;"></i>
                        <h6 class="fw-bold text-dark">لا توجد إثباتات دفع مسجلة لهذا البائع حالياً</h6>
                        <p class="small text-muted mb-0">عندما يقوم زبائن هذا البائع برفع وصولات الدفع للطلبات عبر
                            التحويل البنكي، ستظهر هنا للمراقبة والتدقيق الإداري.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- :::::::::::: Modals ::::::::::::: --}}
{{-- unpproveModal --}}
<div class="modal fade" id="unApproveModal" tabindex="-1" aria-labelledby="unApproveModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="unApproveModalLabel">حذف توثيق البائع</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.seller.unapprove', $seller->id) }}" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <input type="hidden" name="seller_id" value="{{ $seller->id }}">
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label fw-semibold">سبب حذف
                            التوثيق</label>
                        <textarea name="reason" class="form-control rounded-3" placeholder="أدخل سبب إلغاء التوثيق هنا..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-danger rounded-3 fw-bold">حذف توثيق البائع</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- sweetalert  --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('approval_status') == 'unapproved')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: 'تم حذف التوثيق بنجاح'
        })
    </script>
@endif

<!-- Modal 1: تغيير كلمة المرور -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-warning bg-opacity-10 border-0">
                <h5 class="modal-title fw-bold" id="changePasswordModalLabel">
                    <i class="fa-solid fa-key text-warning me-2"></i> تغيير كلمة المرور للبائع
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changePasswordForm" action="{{ route('admin.seller.changePassword', $seller->id) }}"
                method="POST">
                @csrf
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label for="newPasswordInput" class="form-label fw-semibold">كلمة المرور الجديدة</label>
                        <div class="input-group">
                            <input type="text" name="password" id="newPasswordInput" class="form-control"
                                placeholder="أدخل كلمة المرور الجديدة..." required minlength="6">
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="generateRandomPassword()" title="توليد كلمة مرور عشوائية">
                                <i class="fa-solid fa-arrows-rotate me-1"></i> توليد
                            </button>
                        </div>
                        <div class="form-text text-muted">يجب أن تحتوي كلمة المرور على 6 أحرف على الأقل.</div>
                    </div>
                    <div id="changePasswordError" class="alert alert-danger d-none mb-0"></div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" id="savePasswordBtn" class="btn btn-warning text-dark fw-bold rounded-3">
                        <i class="fa-solid fa-floppy-disk me-1"></i> حفظ كلمة المرور
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: عرض كلمة المرور الجديدة لنسخها -->
<div class="modal fade" id="passwordSuccessModal" tabindex="-1" aria-labelledby="passwordSuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-success text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="passwordSuccessModalLabel">
                    <i class="fa-solid fa-circle-check me-2"></i> تم تغيير كلمة المرور بنجاح
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="text-muted mb-3">تم تسجيل كلمة المرور الجديدة بنجاح في قاعدة البيانات. يمكنك نسخها أدناه
                    لإرسالها للبائع:</p>
                <div class="input-group mb-3">
                    <input type="text" id="displayNewPassword"
                        class="form-control text-center font-monospace fs-5 fw-bold bg-light" readonly>
                    <button class="btn btn-primary px-3" type="button" onclick="copyNewPassword()">
                        <i class="fa-solid fa-copy me-1"></i> <span id="copyBtnText">نسخ كلمة المرور</span>
                    </button>
                </div>
                <div id="copyAlertSuccess" class="alert alert-success d-none py-2 mb-0" role="alert">
                    <i class="fa-solid fa-check me-1"></i> تم نسخ كلمة المرور إلى الحافظة بنجاح!
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary w-100 rounded-3"
                    data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: معاينة وتدقيق إثبات الدفع للزبون -->
<div class="modal fade" id="inspectProofModal" tabindex="-1" aria-labelledby="inspectProofModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white px-4 py-3 border-0"
                style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 100%);">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-receipt fs-5"></i>
                    <h5 class="modal-title fw-bold fs-6 mb-0" id="inspectProofModalLabel">
                        معاينة وتدقيق إثبات الدفع
                    </h5>
                    <span id="modalOrderNumber"
                        class="badge bg-white text-dark rounded-pill px-2.5 py-1 ms-2 font-monospace"></span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-4">
                        <div class="p-2.5 bg-white rounded-3 border">
                            <small class="text-muted d-block mb-1">اسم الزبون:</small>
                            <span id="modalCustomerName" class="fw-bold text-dark small">-</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-2.5 bg-white rounded-3 border">
                            <small class="text-muted d-block mb-1">المبلغ الإجمالي:</small>
                            <span id="modalOrderTotal" class="fw-bold text-success small">-</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-2.5 bg-white rounded-3 border">
                            <small class="text-muted d-block mb-1">تاريخ العملية:</small>
                            <span id="modalOrderDate"
                                class="fw-bold text-dark dir-ltr text-start small font-monospace">-</span>
                        </div>
                    </div>
                </div>

                <div class="text-center p-3 bg-white rounded-4 border shadow-sm">
                    <img id="modalProofImage" src="" alt="وصل الدفع" class="img-fluid rounded-3 shadow-sm"
                        style="max-height: 520px; object-fit: contain; width: auto;">
                </div>
            </div>
            <div class="modal-footer bg-white border-top-0 px-4 py-3 d-flex justify-content-between">
                <a id="modalDownloadBtn" href="#" target="_blank"
                    class="btn btn-primary rounded-3 px-4 fw-semibold">
                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> فتح الصورة بالحجم الكامل
                </a>
                <button type="button" class="btn btn-secondary rounded-3 px-4 fw-semibold"
                    data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: تأكيد إعادة ضبط متجر البائع للوضع الافتراضي -->
<div class="modal fade" id="resetStoreModal" tabindex="-1" aria-labelledby="resetStoreModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-danger text-white px-4 py-3 border-0">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                    <h5 class="modal-title fw-bold fs-6 mb-0" id="resetStoreModalLabel">
                        تحذير: تأكيد إعادة ضبط متجر البائع
                    </h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <div class="d-inline-flex p-3 rounded-circle bg-danger bg-opacity-10 text-danger mb-3">
                        <i class="fa-solid fa-arrows-rotate fa-3x"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">هل أنت متأكد من رغبتك في إعادة ضبط هذا المتجر؟</h5>
                    <p class="text-muted small mb-0">المتجر: <strong
                            class="text-primary">{{ $seller->store_name }}</strong> ({{ $seller->tenant_id }})</p>
                </div>

                <div class="alert alert-warning border-0 rounded-3 p-3 mb-3">
                    <h6 class="fw-bold text-dark mb-2"><i
                            class="fa-solid fa-circle-exclamation text-warning me-1"></i> الإجراءات التي ستتم للواجهة:
                    </h6>
                    <ul class="text-secondary small mb-0 ps-3">
                        <li>إعادة ضبط السلايدر والبنرات الترويجية للمتجر إلى الوضع الافتراضي.</li>
                        <li>إعادة ضبط قسم "لماذا تختارنا" والأسئلة الشائعة والصفحات التعريفية.</li>
                        <li>إعادة تسعيرات الشحن لجميع الولايات للأسعار الافتراضية الأولية.</li>
                        <li>إعادة تعيين ألوان وهوية مظهر المتجر الافتراضية.</li>
                    </ul>
                </div>

                <div class="alert alert-success border-0 rounded-3 p-3 mb-0">
                    <h6 class="fw-bold text-success mb-2"><i class="fa-solid fa-shield-check me-1"></i> أمان المنتجات
                        والبيانات (مضمونة 100%):</h6>
                    <p class="text-muted small mb-0">
                        <strong>لن يتم حذف أو تغيير أي منتج</strong> أضافه البائع إطلاقاً، وستبقى جميع سجلات طلبات
                        الزبائن، والبيانات البنكية، والمحفظة المالية، وبيانات تسجيل الدخول كما هي تماماً.
                    </p>
                </div>

                <div id="resetStoreErrorAlert" class="alert alert-danger d-none mt-3 mb-0 py-2 small"></div>
            </div>
            <div class="modal-footer bg-light border-0 px-4 py-3 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary rounded-3 px-4 fw-semibold"
                    data-bs-dismiss="modal">إلغاء</button>
                <button type="button" id="confirmResetStoreBtn"
                    class="btn btn-danger rounded-3 px-4 fw-bold shadow-sm"
                    onclick="executeResetStore({{ $seller->id }})">
                    <i class="fa-solid fa-arrows-rotate me-1"></i> تأكيد إعادة الضبط الآن
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: تصفير رصيد البائع -->
<div class="modal fade" id="resetBalanceModal" tabindex="-1" aria-labelledby="resetBalanceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-danger text-white border-0 py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                    <h5 class="modal-title fw-bold fs-6 mb-0" id="resetBalanceModalLabel">
                        تحذير: تصفير رصيد محفظة البائع
                    </h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <div class="d-inline-flex p-3 rounded-circle bg-danger bg-opacity-10 text-danger mb-2">
                        <i class="fa-solid fa-wallet fa-3x"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">هل أنت متأكد من رغبتك في تصفير رصيد هذا البائع؟</h5>
                    <p class="text-muted small mb-0">البائع: <strong
                            class="text-primary">{{ $seller->full_name }}</strong> ({{ '@' . $seller->store_name }})
                    </p>
                </div>

                {{-- Balance Info Box --}}
                <div class="card border-0 bg-light rounded-3 p-3 mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted fw-semibold small">الرصيد الحالي في المحفظة:</span>
                        <span
                            class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill fw-bold fs-6">
                            <span
                                class="dir-ltr d-inline-block">{{ number_format($user?->balance?->balance ?? 0, 2) }}</span>
                            د.ج
                        </span>
                    </div>
                    @if (($user?->balance?->outstanding_amount ?? 0) > 0)
                        <div class="d-flex align-items-center justify-content-between mt-2 pt-2 border-top">
                            <span class="text-muted fw-semibold small">مستحقات المنصة على البائع:</span>
                            <span
                                class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1.5 rounded-pill fw-bold">
                                <span
                                    class="dir-ltr d-inline-block">{{ number_format($user?->balance?->outstanding_amount ?? 0, 2) }}</span>
                                د.ج
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Warning Alert --}}
                <div class="alert alert-danger border-0 rounded-3 p-3 mb-3">
                    <div class="d-flex gap-2">
                        <i class="fa-solid fa-circle-exclamation fs-5 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <strong class="d-block mb-1">تنبيه أمني وإداري صارم:</strong>
                            <span class="small">سيؤدي هذا الإجراء فوراً إلى جعل رصيد محفظة البائع <strong>0.00
                                    د.ج</strong>، وتسجيل حركة مالية رسمية في السجل المالي، وإرسال إشعار مباشر إلى لوحة
                                تحكم البائع بالسبب المكتوب أدناه.</span>
                        </div>
                    </div>
                </div>

                {{-- Reason Input --}}
                <div class="mb-3">
                    <label for="resetBalanceReason" class="form-label fw-bold text-dark">
                        سبب تصفير الرصيد <span class="text-danger">*</span>
                    </label>
                    <textarea name="reason" id="resetBalanceReason" class="form-control rounded-3" rows="3" required
                        placeholder="أدخل سبب تصفير الرصيد بالتفصيل هنا (إلزامي للتوثيق ولإشعار البائع)..."></textarea>
                    <div class="form-text text-muted small">هذا الحقل إلزامي لضمان الشفافية وأرشفة سبب العملية.</div>
                </div>

                {{-- Confirmation Checkbox --}}
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="confirmResetBalanceCheck">
                    <label class="form-check-label text-dark small fw-semibold" for="confirmResetBalanceCheck">
                        أؤكد مسؤوليتي الإدارية الكاملة عن تصفير رصيد هذا البائع وتوثيق السبب أعلاه.
                    </label>
                </div>

                <div id="resetBalanceErrorAlert" class="alert alert-danger d-none mt-2 mb-0 py-2 small"></div>
            </div>
            <div class="modal-footer bg-light border-0 px-4 py-3 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary rounded-3 px-4 fw-semibold"
                    data-bs-dismiss="modal">إلغاء</button>
                <button type="button" id="confirmResetBalanceBtn"
                    class="btn btn-danger rounded-3 px-4 fw-bold shadow-sm"
                    onclick="executeResetBalance({{ $seller->id }})">
                    <i class="fa-solid fa-wallet me-1"></i> تأكيد تصفير الرصيد الآن
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: تنظيف الملفات المؤقتة للبائع -->
@php
    $lastSeenRec = $user?->last_seen?->first();
    $isSellerOffline = !$lastSeenRec || $lastSeenRec->last_seen_at < now()->subHour();
    $storeNameClean = get_seller_store_name($seller->tenant_id);
    $sellerTempDir = $storeNameClean . '/temp';
    $tempFilesCount = \Illuminate\Support\Facades\Storage::disk('seller')->exists($sellerTempDir)
        ? count(\Illuminate\Support\Facades\Storage::disk('seller')->allFiles($sellerTempDir))
        : 0;
@endphp
<div class="modal fade" id="cleanSellerTempModal" tabindex="-1" aria-labelledby="cleanSellerTempModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-warning bg-opacity-10 border-0 py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-broom text-warning fs-5"></i>
                    <h5 class="modal-title fw-bold fs-6 mb-0 text-dark" id="cleanSellerTempModalLabel">
                        تنظيف الملفات المؤقتة للبائع (temp)
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.seller.clean_temp', $seller->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="text-center mb-3">
                        <div class="d-inline-flex p-3 rounded-circle bg-warning bg-opacity-10 text-warning mb-2">
                            <i class="fa-solid fa-broom fa-3x"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">تنظيف مجلد الملفات المؤقتة (temp)</h5>
                        <p class="text-muted small mb-0">المتجر: <strong
                                class="text-primary">{{ $seller->store_name }}</strong>
                            ({{ '@' . $seller->store_name }})</p>
                    </div>

                    <div class="card border-0 bg-light rounded-3 p-3 mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted small fw-semibold">حالة اتصال البائع:</span>
                            @if ($isSellerOffline)
                                <span class="badge bg-secondary px-2.5 py-1 rounded-pill fw-bold">
                                    <i class="fa-solid fa-circle-xmark me-1"></i> غير متصل (Offline)
                                </span>
                            @else
                                <span class="badge bg-success px-2.5 py-1 rounded-pill fw-bold">
                                    <i class="fa-solid fa-circle-check me-1"></i> متصل حالياً (Online)
                                </span>
                            @endif
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-muted small fw-semibold">آخر نشاط مسجل:</span>
                            <span class="small text-dark fw-bold">
                                {{ $lastSeenRec?->last_seen_at ? \Carbon\Carbon::parse($lastSeenRec->last_seen_at)->diffForHumans() : 'لا يوجد نشاط مسجل' }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted small fw-semibold">عدد الملفات المؤقتة حالياً:</span>
                            <span class="badge bg-dark px-2.5 py-1 rounded-pill fw-bold">
                                {{ $tempFilesCount }} ملف
                            </span>
                        </div>
                    </div>

                    @if (!$isSellerOffline)
                        <div class="alert alert-danger border-0 rounded-3 p-3 mb-0 small">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i>
                            <strong>تنبيه:</strong> البائع متصل أو كان نشطاً خلال الساعة الأخيرة. لا يُنصح بحذف الملفات
                            المؤقتة الآن لتفادي مقاطعة أي عملية رفع جارية من قبل البائع.
                        </div>
                    @else
                        <div class="alert alert-info border-0 rounded-3 p-3 mb-0 small">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            سيتم حذف كافة الملفات غير المكتملة داخل
                            <code>storage/app/public/seller/{{ $storeNameClean }}/temp/</code> وتنظيف السجلات التابعة
                            لها بقاعدة البيانات بأمان.
                        </div>
                    @endif
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary rounded-3 px-4 fw-semibold"
                        data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold rounded-3 px-4 shadow-sm"
                        {{ !$isSellerOffline ? 'disabled' : '' }}>
                        <i class="fa-solid fa-broom me-1"></i> تأكيد تنظيف مجلد temp
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function executeResetBalance(sellerId) {
        const btn = document.getElementById('confirmResetBalanceBtn');
        const reasonInput = document.getElementById('resetBalanceReason');
        const confirmCheck = document.getElementById('confirmResetBalanceCheck');
        const errorAlert = document.getElementById('resetBalanceErrorAlert');

        if (errorAlert) {
            errorAlert.classList.add('d-none');
            errorAlert.innerText = '';
        }

        const reason = reasonInput ? reasonInput.value.trim() : '';

        if (!reason) {
            if (errorAlert) {
                errorAlert.innerText = 'يرجى كتابة سبب تصفير الرصيد بشكل واضح قبل المتابعة.';
                errorAlert.classList.remove('d-none');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'حقل إلزامي',
                    text: 'يرجى كتابة سبب تصفير الرصيد قبل المتابعة.',
                    confirmButtonColor: '#be0681',
                    confirmButtonText: 'حسناً'
                });
            }
            if (reasonInput) reasonInput.focus();
            return;
        }

        if (!confirmCheck || !confirmCheck.checked) {
            if (errorAlert) {
                errorAlert.innerText = 'يرجى تأكيد مسؤوليتك الإدارية بوضع علامة الصح على مربع التأكيد.';
                errorAlert.classList.remove('d-none');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'تأكيد مطلوب',
                    text: 'يرجى تأكيد الإقرار بالمسؤولية قبل تصفير الرصيد.',
                    confirmButtonColor: '#be0681',
                    confirmButtonText: 'حسناً'
                });
            }
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> جاري التصفير...';

        fetch('{{ route('admin.seller.reset_balance', $seller->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    reason: reason
                })
            })
            .then(response => response.json().then(data => ({
                status: response.status,
                body: data
            })))
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-wallet me-1"></i> تأكيد تصفير الرصيد الآن';

                if (res.body.success) {
                    const modalEl = document.getElementById('resetBalanceModal');
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modal.hide();

                    Swal.fire({
                        icon: 'success',
                        title: 'تم التصفير بنجاح',
                        text: res.body.message || 'تم تصفير رصيد محفظة البائع بنجاح.',
                        confirmButtonColor: '#701a75',
                        confirmButtonText: 'حسناً'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    if (errorAlert) {
                        errorAlert.innerText = res.body.message || 'حدث خطأ أثناء تصفير الرصيد.';
                        errorAlert.classList.remove('d-none');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: res.body.message || 'حدث خطأ أثناء تصفير الرصيد.',
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: 'حسناً'
                        });
                    }
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-wallet me-1"></i> تأكيد تصفير الرصيد الآن';
                if (errorAlert) {
                    errorAlert.innerText = 'حدث خطأ في الاتصال بالخادم، يرجى إعادة المحاولة.';
                    errorAlert.classList.remove('d-none');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في الاتصال',
                        text: 'حدث خطأ في الاتصال بالخادم، يرجى إعادة المحاولة.',
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'حسناً'
                    });
                }
            });
    }

    function executeResetStore(sellerId) {
        const btn = document.getElementById('confirmResetStoreBtn');
        const errorAlert = document.getElementById('resetStoreErrorAlert');

        if (errorAlert) {
            errorAlert.classList.add('d-none');
            errorAlert.innerText = '';
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> جاري إعادة الضبط...';

        fetch('{{ route('admin.seller.reset_store', $seller->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json().then(data => ({
                status: response.status,
                body: data
            })))
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-arrows-rotate me-1"></i> تأكيد إعادة الضبط الآن';

                if (res.body.success) {
                    const modalEl = document.getElementById('resetStoreModal');
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modal.hide();

                    Swal.fire({
                        icon: 'success',
                        title: 'تمت إعادة الضبط بنجاح',
                        text: res.body.message || 'تمت إعادة ضبط المتجر إلى الوضعية الافتراضية بنجاح.',
                        confirmButtonColor: '#701a75',
                        confirmButtonText: 'حسناً'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    if (errorAlert) {
                        errorAlert.innerText = res.body.message || 'حدث خطأ أثناء إعادة ضبط المتجر.';
                        errorAlert.classList.remove('d-none');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: res.body.message || 'حدث خطأ أثناء إعادة ضبط المتجر.',
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: 'حسناً'
                        });
                    }
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-arrows-rotate me-1"></i> تأكيد إعادة الضبط الآن';
                if (errorAlert) {
                    errorAlert.innerText = 'حدث خطأ في الاتصال بالخادم، يرجى إعادة المحاولة.';
                    errorAlert.classList.remove('d-none');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في الاتصال',
                        text: 'حدث خطأ في الاتصال بالخادم، يرجى إعادة المحاولة.',
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'حسناً'
                    });
                }
            });
    }

    function inspectPaymentProof(imageUrl, orderNumber, customerName, total, orderDate) {
        document.getElementById('modalProofImage').src = imageUrl;
        document.getElementById('modalOrderNumber').innerText = orderNumber;
        document.getElementById('modalCustomerName').innerText = customerName;
        document.getElementById('modalOrderTotal').innerText = total;
        document.getElementById('modalOrderDate').innerText = orderDate;
        document.getElementById('modalDownloadBtn').href = imageUrl;

        const inspectModal = new bootstrap.Modal(document.getElementById('inspectProofModal'));
        inspectModal.show();
    }

    function generateRandomPassword() {
        const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        let password = "";
        for (let i = 0; i < 10; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('newPasswordInput').value = password;
    }

    function copyNewPassword() {
        const passwordInput = document.getElementById('displayNewPassword');
        passwordInput.select();
        passwordInput.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(passwordInput.value).then(function() {
            const copyBtnText = document.getElementById('copyBtnText');
            const alertBox = document.getElementById('copyAlertSuccess');
            copyBtnText.innerText = 'تم النسخ!';
            alertBox.classList.remove('d-none');
            setTimeout(() => {
                copyBtnText.innerText = 'نسخ كلمة المرور';
                alertBox.classList.add('d-none');
            }, 3000);
        }).catch(function(err) {
            alert('تعذر النسخ تلقائياً: ' + err);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const changePasswordForm = document.getElementById('changePasswordForm');
        if (changePasswordForm) {
            changePasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const submitBtn = document.getElementById('savePasswordBtn');
                const errorBox = document.getElementById('changePasswordError');
                const passwordInput = document.getElementById('newPasswordInput');

                errorBox.classList.add('d-none');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> جاري الحفظ...';

                const formData = new FormData(changePasswordForm);

                fetch(changePasswordForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json().then(data => ({
                        status: response.status,
                        body: data
                    })))
                    .then(res => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML =
                            '<i class="fa-solid fa-floppy-disk me-1"></i> حفظ كلمة المرور';

                        if (res.body.success) {
                            // Hide Modal 1
                            const modal1El = document.getElementById('changePasswordModal');
                            const modal1 = bootstrap.Modal.getInstance(modal1El) || new bootstrap
                                .Modal(modal1El);
                            modal1.hide();

                            // Set password in Modal 2
                            document.getElementById('displayNewPassword').value = res.body
                                .new_password;

                            // Show Modal 2
                            const modal2El = document.getElementById('passwordSuccessModal');
                            const modal2 = new bootstrap.Modal(modal2El);
                            modal2.show();

                            // Clear input
                            passwordInput.value = '';
                        } else {
                            errorBox.innerText = res.body.message ||
                                'حدث خطأ أثناء تغيير كلمة المرور';
                            errorBox.classList.remove('d-none');
                        }
                    })
                    .catch(err => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML =
                            '<i class="fa-solid fa-floppy-disk me-1"></i> حفظ كلمة المرور';
                        errorBox.innerText = 'حدث خطأ في الاتصال بالسيرفر';
                        errorBox.classList.remove('d-none');
                    });
            });
        }

        @if (session('new_password'))
            document.getElementById('displayNewPassword').value = "{{ session('new_password') }}";
            const modal2El = document.getElementById('passwordSuccessModal');
            const modal2 = new bootstrap.Modal(modal2El);
            modal2.show();
        @endif
    });
</script>
