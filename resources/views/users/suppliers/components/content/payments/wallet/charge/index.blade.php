<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-7 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-wallet text-warning"></i>
                    <span class="fw-semibold">{{ __('إدارة المحفظة الإلكترونية للتوريد') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    إدارة وشحن المحفظة الإلكترونية للتوريد 👛
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    تابع أرصدتك الحالية والمتبقية لحساب التوريد، واشحن محفظتك بمرونة عبر وسائل الدفع الوطنية المتاحة لإكمال معاملتك فورًا.
                </p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <button class="btn btn-warning text-dark fw-bold px-4 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2 fs-6"
                    data-bs-toggle="modal" data-bs-target="#selectPaymentMethodModal">
                    <i class="fa-solid fa-plus-circle"></i>
                    <span>شحن الرصيد الآن</span>
                </button>
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10"
            style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);">
        </div>
        <div class="position-absolute rounded-circle bg-primary opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    <!-- Statistical Indicator Cards Grid -->
    <div class="row g-3 mb-4">
        <!-- 1. Current Available Balance -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-success-subtle text-success fw-bold">
                            <i class="fa-solid fa-wallet fs-5"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 fw-bold">متاح للاستخدام</span>
                    </div>
                    <h2 class="fw-bold mb-1 text-dark">{{ number_format($current_balance, 2, ',', '.') }} <span class="fs-6 text-muted">د.ج</span></h2>
                    <p class="text-muted small mb-0 fw-semibold">الرصيد الحالي الجاهز للخصم</p>
                </div>
            </div>
        </div>

        <!-- 2. Pending Balance -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-warning-subtle text-warning-emphasis fw-bold">
                            <i class="fa-solid fa-clock-rotate-left fs-5"></i>
                        </span>
                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-1 fw-bold">قيد المعالجة</span>
                    </div>
                    <h2 class="fw-bold mb-1 text-dark">{{ number_format($pending_balance, 2, ',', '.') }} <span class="fs-6 text-muted">د.ج</span></h2>
                    <p class="text-muted small mb-0 fw-semibold">الرصيد المعلق قيد مراجعة الإدارة</p>
                </div>
            </div>
        </div>

        <!-- 3. Total Top-up Operations -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-navy-subtle text-navy fw-bold">
                            <i class="fa-solid fa-receipt fs-5"></i>
                        </span>
                        <span class="badge bg-navy-subtle text-navy rounded-pill px-3 py-1 fw-bold">إجمالي العمليات</span>
                    </div>
                    <h2 class="fw-bold mb-1 text-dark">{{ $additions->count() }} <span class="fs-6 text-muted">عملیة</span></h2>
                    <p class="text-muted small mb-0 fw-semibold">إجمالي طلبات الشحن المسجلة</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Wallet Transactions Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
        <div class="card-header bg-white border-0 py-3.5 px-3 px-md-4 d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom border-light">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="avatar avatar-md rounded-3 bg-navy-subtle text-navy fw-bold me-1"
                    style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-list-check fs-6"></i>
                </span>
                <h5 class="fw-bold mb-0 text-dark fs-6">سجل عمليات شحن المحفظة للتوريد</h5>
            </div>
            <button class="btn btn-supplier-primary rounded-3 px-3.5 py-2 fs-6 fw-bold shadow-sm d-inline-flex align-items-center gap-2"
                data-bs-toggle="modal" data-bs-target="#selectPaymentMethodModal">
                <i class="fa-solid fa-plus-circle"></i>
                <span>شحن الرصيد</span>
            </button>
        </div>
        <div class="card-body p-0 p-md-3">
            <div class="table-responsive wallet-table-responsive custom-table-scroll">
                <table class="table table-hover align-middle mb-0 wallet-table">
                    <thead class="bg-light-subtle text-secondary small text-uppercase fw-bold border-bottom">
                        <tr>
                            <th width="60" class="ps-4 text-nowrap">#</th>
                            <th width="120" class="text-nowrap">التاريخ</th>
                            <th class="text-nowrap">المبلغ</th>
                            <th class="text-nowrap">طريقة الدفع</th>
                            <th class="text-nowrap">تفاصيل</th>
                            <th class="text-center text-nowrap">الإثبات</th>
                            <th width="120" class="text-center text-nowrap">الحالة</th>
                            <th width="140" class="text-center pe-4 text-nowrap">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($additions as $index => $addition)
                            <tr>
                                <td scope="row" data-label="#" class="ps-md-4 fw-bold text-secondary">
                                    {{ $index + 1 }}
                                </td>
                                <td data-label="التاريخ" class="text-nowrap">
                                    <span class="fw-semibold text-dark small">{{ $addition->created_at->format('Y-m-d') }}</span>
                                </td>
                                <td data-label="المبلغ">
                                    <span class="fw-bold text-success fs-6">
                                        {{ number_format($addition->amount, 2, ',', '.') }} د.ج
                                    </span>
                                </td>
                                <td data-label="طريقة الدفع">
                                    <span class="badge bg-light text-dark border px-2.5 py-1.5 fw-semibold">
                                        <i class="fa-solid fa-credit-card me-1 text-navy"></i> {{ $addition->payment_method }}
                                    </span>
                                </td>
                                <td data-label="تفاصيل">
                                    <span class="text-secondary small">{{ $addition->description ?? '—' }}</span>
                                </td>
                                <td data-label="الإثبات" class="text-center">
                                    @if($addition->payment_proof)
                                        <a href="{{ asset('storage/tenantsupplier/' . $addition->payment_proof) }}" target="_blank"
                                            class="btn btn-sm btn-outline-navy rounded-3 px-2.5 py-1 small d-inline-flex align-items-center gap-1">
                                            <i class="fa-solid fa-file-arrow-down"></i>
                                            <span>عرض الإثبات</span>
                                        </a>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td data-label="الحالة" class="text-center">
                                    @php
                                        switch ($addition->status) {
                                            case 'pending':
                                                $statusClass = 'bg-warning-subtle text-warning-emphasis border border-warning';
                                                $statusLabel = 'في الانتظار';
                                                break;
                                            case 'approved':
                                                $statusClass = 'bg-success-subtle text-success border border-success';
                                                $statusLabel = 'مقبول';
                                                break;
                                            default:
                                                $statusClass = 'bg-danger-subtle text-danger border border-danger';
                                                $statusLabel = 'مرفوض';
                                                break;
                                        }
                                    @endphp
                                    <span class="badge {{ $statusClass }} rounded-pill px-3 py-1.5 fw-semibold">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td data-label="الإجراء" class="text-center pe-md-4">
                                    <button class="btn btn-light btn-sm text-dark rounded-3 px-3 py-1.5 border d-inline-flex align-items-center gap-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#invoiceDetailsModal"
                                        onclick="loadAdditionDetails({{ $addition->id }})">
                                        <i class="fa-solid fa-eye text-navy"></i>
                                        <span>التفاصيل</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- مودال تفاصيل الشحن -->
<div class="modal fade" id="invoiceDetailsModal" tabindex="-1" aria-labelledby="invoiceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white py-3.5 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-sm rounded-3 bg-white bg-opacity-20 text-white"
                        style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-file-invoice"></i>
                    </span>
                    <h5 class="modal-title fw-bold mb-0 fs-6 text-white" id="invoiceDetailsModalLabel">تفاصيل عملية الشحن</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <div id="invoice-details-content">
                    <div class="text-center py-4 text-muted">
                        <div class="spinner-border spinner-border-sm text-navy me-2" role="status"></div>
                        <span>جاري تحميل تفاصيل الشحن...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: اختيار طريقة الدفع -->
<div class="modal fade" id="selectPaymentMethodModal" tabindex="-1" aria-labelledby="selectPaymentMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white py-3.5 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-sm rounded-3 bg-white bg-opacity-20 text-white"
                        style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-wallet"></i>
                    </span>
                    <h5 class="modal-title fw-bold mb-0 fs-6 text-white" id="selectPaymentMethodModalLabel">اختر طريقة شحن الرصيد</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body p-4 bg-white text-center">
                <p class="mb-4 text-muted small">اختر وسيلة الدفع التي تناسبك لشحن حسابك الإلكتروني بسهولة:</p>

                <!-- طريقة 1: Chargily -->
                <button class="btn btn-outline-navy w-100 py-3 mb-3 rounded-3 fw-bold d-flex align-items-center justify-content-between px-3"
                    data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#chargeBalanceModal">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-credit-card fs-5 text-navy"></i>
                        <span>الدفع عبر Chargily (البطاقة الذهبية / CIB)</span>
                    </div>
                    <i class="fa-solid fa-chevron-left text-muted"></i>
                </button>

                <!-- طريقة 2: بريدي موب -->
                <button class="btn btn-outline-success w-100 py-3 mb-3 rounded-3 fw-bold d-flex align-items-center justify-content-between px-3"
                    data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#baridiMobModal">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-mobile-screen-button fs-5 text-success"></i>
                        <span>الدفع عبر تطبيق بريدي موب BaridiMob</span>
                    </div>
                    <i class="fa-solid fa-chevron-left text-muted"></i>
                </button>

                <!-- طريقة 3: CCP -->
                <button class="btn btn-outline-warning text-dark w-100 py-3 mb-3 rounded-3 fw-bold d-flex align-items-center justify-content-between px-3"
                    data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#ccpModal">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-building-columns fs-5 text-warning"></i>
                        <span>الدفع عبر CCP / بريد الجزائر</span>
                    </div>
                    <i class="fa-solid fa-chevron-left text-muted"></i>
                </button>

                <!-- طريقة 4: PayPal -->
                <button class="btn btn-outline-secondary w-100 py-3 mb-0 rounded-3 fw-bold d-flex align-items-center justify-content-between px-3 opacity-50 cursor-not-allowed" disabled>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fab fa-paypal fs-5"></i>
                        <span>الدفع عبر PayPal (قريبًا)</span>
                    </div>
                    <span class="badge bg-secondary">قريبًا</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: شحن الرصيد عبر Chargily -->
<div class="modal fade" id="chargeBalanceModal" tabindex="-1" aria-labelledby="chargeBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white py-3.5 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-sm rounded-3 bg-white bg-opacity-20 text-white"
                        style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-credit-card"></i>
                    </span>
                    <h5 class="modal-title fw-bold mb-0 fs-6 text-white" id="chargeBalanceModalLabel">شحن الرصيد عبر ChargilyPay</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <form id="chargilyForm" method="POST" action="{{ route('supplier.chargilypay.redirect') }}">
                    @csrf
                    <input type="hidden" name="payment_type" value="wallet_topup">
                    <input type="hidden" name="reference_id" value="{{ auth()->user()->id }}">

                    <div class="mb-3.5 text-start">
                        <label for="amount" class="form-label fw-bold text-dark small">أدخل المبلغ المطلوب شحنه (د.ج) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i class="fa-solid fa-coins"></i></span>
                            <input type="number" min="50" step="10" class="form-control rounded-end-3 shadow-none border-start-0 text-center fw-bold fs-5"
                                name="amount" id="amount" placeholder="مثال: 1000" required>
                        </div>
                        <small class="text-muted d-block mt-2 fs-7"><i class="fa-solid fa-circle-info text-navy me-1"></i> الحد الأدنى للشحن هو 50 د.ج</small>
                    </div>

                    <button type="submit"
                        class="btn btn-supplier-primary w-100 rounded-3 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-lock"></i>
                        <span>المتابعة والدفع الآمن</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: شحن الرصيد عبر بريدي موب -->
<div class="modal fade" id="baridiMobModal" tabindex="-1" aria-labelledby="baridiMobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white py-3.5 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-sm rounded-3 bg-white bg-opacity-20 text-white"
                        style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </span>
                    <h5 class="modal-title fw-bold mb-0 fs-6 text-white" id="baridiMobModalLabel">شحن الرصيد عبر تطبيق بريدي موب</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body p-4 bg-white text-start">
                <form action="{{ route('supplier.wallet.recharge.baridimob') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3.5">
                        <label for="amount_baridi" class="form-label fw-bold text-dark small">المبلغ المطلوب شحنه (د.ج) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i class="fa-solid fa-coins"></i></span>
                            <input type="number" name="amount" id="amount_baridi" class="form-control rounded-end-3 shadow-none border-start-0 text-center fw-bold fs-5"
                                min="50" step="10" placeholder="مثال: 1000" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="proof_baridi" class="form-label fw-bold text-dark small">إرفاق إثبات التحويل <span class="text-danger">*</span></label>
                        <input type="file" name="payment_proof" id="proof_baridi" class="form-control rounded-3 shadow-none" accept="image/*,application/pdf" required>
                        <small class="text-muted d-block mt-1 fs-7">الصيغ المقبولة: صورة (JPG, PNG) أو ملف PDF</small>
                    </div>

                    <button type="submit"
                        class="btn btn-success w-100 rounded-3 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>إرسال طلب الشحن</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: شحن الرصيد عبر CCP -->
<div class="modal fade" id="ccpModal" tabindex="-1" aria-labelledby="ccpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white py-3.5 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-sm rounded-3 bg-white bg-opacity-20 text-white"
                        style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-building-columns"></i>
                    </span>
                    <h5 class="modal-title fw-bold mb-0 fs-6 text-white" id="ccpModalLabel">شحن الرصيد عبر CCP / بريد الجزائر</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body p-4 bg-white text-start">
                <form action="{{ route('supplier.wallet.recharge.ccp') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3.5">
                        <label for="amount_ccp" class="form-label fw-bold text-dark small">المبلغ المطلوب شحنه (د.ج) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i class="fa-solid fa-coins"></i></span>
                            <input type="number" name="amount" id="amount_ccp" class="form-control rounded-end-3 shadow-none border-start-0 text-center fw-bold fs-5"
                                min="50" step="10" placeholder="مثال: 1000" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="proof_ccp" class="form-label fw-bold text-dark small">إرفاق إثبات الحوالة <span class="text-danger">*</span></label>
                        <input type="file" name="payment_proof" id="proof_ccp" class="form-control rounded-3 shadow-none" accept="image/*,application/pdf" required>
                        <small class="text-muted d-block mt-1 fs-7">الصيغ المقبولة: صورة (JPG, PNG) أو ملف PDF</small>
                    </div>

                    <button type="submit"
                        class="btn btn-warning text-dark w-100 rounded-3 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>إرسال طلب الشحن</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert notifications -->
@if(session()->has('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'خطأ',
        text: '{{ session('error') }}',
        confirmButtonText: 'حسناً',
        timer: 3000
    });
</script>
@endif

@if(session()->has('paid'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'تم شحن الفاتورة بنجاح',
        text: '{{ session('success') }}',
        confirmButtonText: 'حسناً',
        timer: 3000
    });
</script>
@endif

@if(session()->has('order'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'تم إرسال طلب شحن الرصيد بنجاح',
        text: '{{ session('order') }}',
        confirmButtonText: 'حسناً'
    });
</script>
@endif

<style>
    /* ================================
       PURE CSS RESPONSIVE TABLE PROTOCOL (SAFE-UI-STYLING SKILL)
       Targeting screens up to 1024.98px (Tablets / iPad / 1024px displays)
       ================================ */
    @media (max-width: 1024.98px) {

        .wallet-table-responsive table.wallet-table,
        .wallet-table-responsive table.wallet-table tbody,
        .wallet-table-responsive table.wallet-table tr,
        .wallet-table-responsive table.wallet-table td,
        .wallet-table-responsive table.wallet-table th {
            display: block !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .wallet-table-responsive table.wallet-table thead {
            display: none !important;
        }

        .wallet-table-responsive table.wallet-table tbody tr {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            margin-bottom: 1.25rem !important;
            padding: 0.85rem 1.15rem !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04) !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .wallet-table-responsive table.wallet-table tbody tr:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .wallet-table-responsive table.wallet-table tbody td,
        .wallet-table-responsive table.wallet-table tbody th {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 0.75rem 0.5rem !important;
            border: none !important;
            border-bottom: 1px dashed #e2e8f0 !important;
            white-space: normal !important;
            text-align: right !important;
            font-size: 0.9rem;
        }

        .wallet-table-responsive table.wallet-table tbody td:last-child {
            border-bottom: none !important;
        }

        .wallet-table-responsive table.wallet-table tbody td::before,
        .wallet-table-responsive table.wallet-table tbody th::before {
            content: attr(data-label);
            font-weight: 700;
            color: #64748b;
            font-size: 0.85rem;
            margin-left: 1rem;
            flex-shrink: 0;
        }
    }

    /* Responsive adjustments specifically for 768px - 1024px tablet landscape screens */
    @media (min-width: 768px) and (max-width: 1024.98px) {
        .wallet-table-responsive table.wallet-table tbody tr {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.5rem 1.5rem !important;
            padding: 1.25rem !important;
        }

        .wallet-table-responsive table.wallet-table tbody td,
        .wallet-table-responsive table.wallet-table tbody th {
            border-bottom: 1px dashed #f1f5f9 !important;
        }

        .wallet-table-responsive table.wallet-table tbody th[data-label="#"] {
            grid-column: 1 / -1;
            border-bottom: 1px solid #e2e8f0 !important;
            padding-bottom: 0.5rem !important;
        }

        .wallet-table-responsive table.wallet-table tbody td[data-label="الإجراء"] {
            grid-column: 1 / -1;
            border-bottom: none !important;
            padding-top: 0.5rem !important;
        }
    }

    /* Optimization for Desktop Screens > 1024px */
    @media (min-width: 1025px) {
        .wallet-table th {
            font-size: 0.82rem;
            letter-spacing: 0.3px;
            padding: 0.9rem 0.75rem;
        }

        .wallet-table td,
        .wallet-table th {
            padding: 0.85rem 0.75rem;
            font-size: 0.875rem;
        }
    }

    .bg-navy-subtle {
        background-color: rgba(15, 23, 42, 0.1);
    }

    .border-navy-subtle {
        border-color: rgba(15, 23, 42, 0.25) !important;
    }

    .text-navy {
        color: #0f172a !important;
    }

    .bg-supplier-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
    }

    .btn-supplier-primary {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }

    .btn-supplier-primary:hover {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%) !important;
        color: #ffffff !important;
    }

    .btn-outline-navy {
        border-color: #0f172a !important;
        color: #0f172a !important;
    }

    .btn-outline-navy:hover {
        background-color: #0f172a !important;
        color: #ffffff !important;
    }

    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .avatar-md {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-table-scroll {
        -webkit-overflow-scrolling: touch;
        overflow-x: auto !important;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f8fafc;
    }

    .custom-table-scroll::-webkit-scrollbar {
        height: 6px;
    }

    .custom-table-scroll::-webkit-scrollbar-track {
        background: #f8fafc;
        border-radius: 4px;
    }

    .custom-table-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .custom-table-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>