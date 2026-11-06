@php
    $tenantDomain = get_tenant_data(Auth::user()->tenant_id)->domains[0]->domain ?? request()->getHost();
    $webhookUrl = url(request()->server('REQUEST_SCHEME').'://'.$tenantDomain) . '/api/chargily-pay/webhook';

    $isCashActive = ($paymentMethods['Cash']['status'] ?? 'inactive') === 'active';
    $isChargilyActive = ($paymentMethods['Chargily_Pay']['status'] ?? 'inactive') === 'active';
    $isBankActive = (($paymentMethods['Ccp']['status'] ?? 'inactive') === 'active') || (($paymentMethods['BaridiMob']['status'] ?? 'inactive') === 'active');
    
    $activeCount = ($isCashActive ? 1 : 0) + ($isChargilyActive ? 1 : 0) + ($isBankActive ? 1 : 0);
@endphp

<div class="container-fluid py-3 px-3 px-md-4" dir="rtl">

    <!-- Hero Welcome Banner -->
    <div class="p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden rounded-4"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #2563eb 100%);">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-15 rounded-pill text-white small mb-3 border border-white border-opacity-20 backdrop-blur">
                    <i class="fa-solid fa-credit-card text-warning"></i>
                    <span class="fw-semibold">بوابات الدفع الإلكتروني والتحويل</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ $activeCount }} من 3 وسائل مفعلة حالياً</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    طرق ووسائل الدفع المعتمدة 💳
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    تحكم في بوابات الدفع الإلكترونية لمتجرك لتسهيل الشراء على زبائنك بالبطاقة الذهبية، CIB، التحويل البنكي والبريدي، أو الدفع عند الاستلام.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('seller.settings') }}" class="btn btn-light text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-gear"></i>
                        <span>إعدادات المتجر العامة</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10"
            style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);">
        </div>
        <div class="position-absolute rounded-circle bg-primary opacity-20"
            style="width: 200px; height: 200px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(35px);">
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 p-3 mb-4 d-flex align-items-center gap-3" role="alert">
            <i class="fa-solid fa-circle-check fs-4 text-success"></i>
            <div class="fw-semibold">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 p-3 mb-4 d-flex align-items-center gap-3" role="alert">
            <i class="fa-solid fa-circle-exclamation fs-4 text-danger"></i>
            <div class="fw-semibold">{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 p-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2 mb-2 fw-bold">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>يرجى مراجعة الأخطاء التالية:</span>
            </div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Payment Methods Cards Grid -->
    <div class="row g-4">

        <!-- ==========================================
             1. CHARGILY PAY GATEWAY (CIB / EDAHABIA)
        ========================================== -->
        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden payment-card">
                <div class="card-header bg-white border-bottom border-light p-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-wrapper rounded-3 text-white shadow-sm" style="background: linear-gradient(135deg, #0088cc 0%, #005f9e 100%);">
                            <i class="fa-solid fa-credit-card fs-5"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h5 class="fw-bold text-dark mb-0">شارجيلي باي (Chargily Pay)</h5>
                                @if($isChargilyActive)
                                    <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 small fw-bold">
                                        <i class="fa-solid fa-circle-check me-1"></i> مفعل
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 small fw-bold">
                                        <i class="fa-solid fa-circle-pause me-1"></i> معطل
                                    </span>
                                @endif
                            </div>
                            <p class="text-muted small mb-0">الدفع الإلكتروني بالبطاقة الذهبية وبطاقات CIB البنكية</p>
                        </div>
                    </div>
                    <div>
                        @if($chargilyAuthorized)
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 small fw-semibold" title="مفعل في خطتك">
                                <i class="fa-solid fa-award me-1"></i> متاح في باقتك
                            </span>
                        @else
                            <a href="{{ route('seller.subscription') }}" class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2.5 py-1 text-decoration-none small fw-semibold" title="اضغط للترقية">
                                <i class="fa-solid fa-crown me-1"></i> يتطلب ترقية الباقة
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Webhook Alert / Instruction -->
                    <div class="alert alert-light border shadow-2xs rounded-3 p-3 mb-4 bg-light">
                        <div class="d-flex align-items-start gap-2.5">
                            <i class="fa-solid fa-circle-info text-primary mt-1 fs-5"></i>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark small mb-1">رابط الـ Webhook الخاص بمتجرك:</div>
                                <p class="text-muted small mb-2" style="font-size: 0.8rem;">
                                    لاستقبال تأكيد الدفع اللحظي، انسخ هذا الرابط وضعه في إعدادات Webhook بحسابك على منصة <strong>Chargily</strong>:
                                </p>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="chargilyWebhookUrl" class="form-control font-monospace bg-white text-dark small text-start border" value="{{ $webhookUrl }}" readonly>
                                    <button class="btn btn-outline-primary fw-semibold px-3" type="button" onclick="copyWebhookUrl()">
                                        <i class="fa-regular fa-copy me-1"></i> نسخ الرابط
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chargily Settings Form -->
                    <form action="{{ route('seller.payment_methods.chargily.update') }}" method="POST">
                        @csrf
                        
                        <!-- Toggle Switch -->
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 border bg-light mb-4">
                            <div>
                                <label class="fw-bold text-dark mb-0 cursor-pointer" for="chargily_status_toggle">
                                    تفعيل وسيلة الدفع شارجيلي بالمتجر
                                </label>
                                <div class="text-muted small" style="font-size: 0.8rem;">إظهار خيار الدفع الإلكتروني بالبطاقة الذهبية و CIB لزبائن المتجر عند الشراء</div>
                            </div>
                            <div class="form-check form-switch fs-5 m-0 p-0 d-flex align-items-center">
                                <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" id="chargily_status_toggle" name="chargily_status" value="active" {{ $isChargilyActive ? 'checked' : '' }}>
                            </div>
                        </div>

                        <!-- Mode Switch (Test vs Live) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark small">بيئة العمل (Mode)</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="form-check card-radio p-3 border rounded-3 h-100 {{ ($chargilySettings?->mode ?? 'test') == 'test' ? 'border-primary bg-primary-subtle' : 'bg-light' }}">
                                        <input class="form-check-input" type="radio" name="mode" id="mode_test" value="test" {{ ($chargilySettings?->mode ?? 'test') == 'test' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold text-dark small cursor-pointer" for="mode_test">
                                            <i class="fa-solid fa-flask text-secondary me-1"></i> وضع التجربة (Test Mode)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check card-radio p-3 border rounded-3 h-100 {{ ($chargilySettings?->mode ?? '') == 'live' ? 'border-success bg-success-subtle' : 'bg-light' }}">
                                        <input class="form-check-input" type="radio" name="mode" id="mode_live" value="live" {{ ($chargilySettings?->mode ?? '') == 'live' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold text-dark small cursor-pointer" for="mode_live">
                                            <i class="fa-solid fa-bolt text-warning me-1"></i> وضع الإنتاج الفعلي (Live Mode)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Public Key -->
                        <div class="mb-3">
                            <label for="chargily_public_key" class="form-label fw-bold text-dark small">
                                المفتاح العام (Public Key) <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control rounded-3 font-monospace small" id="chargily_public_key" name="public_key" value="{{ old('public_key', $chargilySettings?->public_key) }}" placeholder="test_pk_... أو live_pk_..." required>
                        </div>

                        <!-- Secret Key -->
                        <div class="mb-4">
                            <label for="chargily_secret_key" class="form-label fw-bold text-dark small">
                                المفتاح السري (Secret Key) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control rounded-start-3 font-monospace small" id="chargily_secret_key" name="secret_key" value="{{ old('secret_key', $chargilySettings?->secret_key) }}" placeholder="test_sk_... أو live_sk_..." required>
                                <button class="btn btn-outline-secondary rounded-end-3" type="button" onclick="toggleSecretVisibility('chargily_secret_key', this)">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary fw-bold px-4 py-2.5 rounded-3 d-inline-flex align-items-center gap-2 shadow-sm">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>حفظ إعدادات شارجيلي</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ==========================================
             2. BANK TRANSFER / CCP / BARIDIMOB
        ========================================== -->
        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden payment-card">
                <div class="card-header bg-white border-bottom border-light p-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-wrapper rounded-3 text-white shadow-sm" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                            <i class="fa-solid fa-building-columns fs-5"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h5 class="fw-bold text-dark mb-0">التحويل البنكي والبريدي (CCP / BaridiMob)</h5>
                                @if($isBankActive)
                                    <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 small fw-bold">
                                        <i class="fa-solid fa-circle-check me-1"></i> مفعل
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 small fw-bold">
                                        <i class="fa-solid fa-circle-pause me-1"></i> معطل
                                    </span>
                                @endif
                            </div>
                            <p class="text-muted small mb-0">استقبال التحويلات عبر تطبيق بريدي موب والحساب الجاري CCP</p>
                        </div>
                    </div>
                    <div>
                        @if($bankAuthorized)
                            <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 small fw-semibold" title="مفعل في خطتك">
                                <i class="fa-solid fa-award me-1"></i> متاح في باقتك
                            </span>
                        @else
                            <a href="{{ route('seller.subscription') }}" class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2.5 py-1 text-decoration-none small fw-semibold" title="اضغط للترقية">
                                <i class="fa-solid fa-crown me-1"></i> يتطلب باقة محترف
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Instruction Alert -->
                    <div class="alert alert-light border shadow-2xs rounded-3 p-3 mb-4 bg-light">
                        <div class="d-flex align-items-start gap-2.5">
                            <i class="fa-solid fa-circle-info text-success mt-1 fs-5"></i>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark small mb-1">طريقة عمل التحويل البنكي بالمتجر:</div>
                                <p class="text-muted small mb-0" style="font-size: 0.8rem;">
                                    عند تفعيل هذه الوسيلة، ستظهر بيانات حسابك للزبون عند إتمام الطلب مع خانة لرفع وصل التحويل (Reçu) للتحقق منه وتأكيد الطلبية.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Settings Form -->
                    <form action="{{ route('seller.payment_methods.bank.update') }}" method="POST">
                        @csrf
                        
                        <!-- Toggle Switch -->
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 border bg-light mb-4">
                            <div>
                                <label class="fw-bold text-dark mb-0 cursor-pointer" for="bank_status_toggle">
                                    تفعيل وسيلة التحويل البنكي والبريدي بالمتجر
                                </label>
                                <div class="text-muted small" style="font-size: 0.8rem;">إتاحة خيار الدفع عبر بريدي موب / CCP لزبائن المتجر</div>
                            </div>
                            <div class="form-check form-switch fs-5 m-0 p-0 d-flex align-items-center">
                                <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" id="bank_status_toggle" name="bank_status" value="active" {{ $isBankActive ? 'checked' : '' }}>
                            </div>
                        </div>

                        <!-- Bank Name -->
                        <div class="mb-3">
                            <label for="bank_name" class="form-label fw-bold text-dark small">
                                اسم البنك أو المؤسسة المالية <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control rounded-3 small" id="bank_name" name="bank_name" value="{{ old('bank_name', $bankSettings?->bank_name ?? 'بريد الجزائر (Algérie Poste - BaridiMob)') }}" placeholder="مثال: بريد الجزائر (BaridiMob / CCP) أو بنك الفلاحة والتنمية الريفية" required>
                        </div>

                        <!-- Account Holder Name -->
                        <div class="mb-3">
                            <label for="account_holder_name" class="form-label fw-bold text-dark small">
                                اسم ولقب صاحب الحساب <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control rounded-3 small" id="account_holder_name" name="name" value="{{ old('name', $bankSettings?->name) }}" placeholder="الاسم الكامل كما هو مسجل في الحساب أو البطاقة" required>
                        </div>

                        <!-- Account Number / CCP / RIP -->
                        <div class="mb-4">
                            <label for="account_number" class="form-label fw-bold text-dark small">
                                رقم الحساب البريدي الجاري / RIP / CCP <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control rounded-3 font-monospace small" id="account_number" name="account_number" value="{{ old('account_number', $bankSettings?->account_number) }}" placeholder="مثال: 00799999000123456789 أو 12345678 Clé 99" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success fw-bold px-4 py-2.5 rounded-3 d-inline-flex align-items-center gap-2 shadow-sm text-white">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>حفظ بيانات الحساب البنكي</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ==========================================
             3. CASH ON DELIVERY (COD)
        ========================================== -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden payment-card">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8 mb-3 mb-lg-0">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon-wrapper rounded-3 text-white shadow-sm" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%);">
                                    <i class="fa-solid fa-money-bill-wave fs-5"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h5 class="fw-bold text-dark mb-0">الدفع عند الاستلام (Cash On Delivery - COD)</h5>
                                        @if($isCashActive)
                                            <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 small fw-bold">
                                                <i class="fa-solid fa-circle-check me-1"></i> مفعل
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 small fw-bold">
                                                <i class="fa-solid fa-circle-pause me-1"></i> معطل
                                            </span>
                                        @endif
                                        <span class="badge bg-light text-secondary rounded-pill small">مجاني لجميع الخطط</span>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        استلام قيمة الطلبية نقداً يدويّاً من الزبون عند تسليم الشحنة عبر مندوب شركة الشحن والتوصيل.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <form action="{{ route('seller.payment_methods.toggle') }}" method="POST" class="d-inline-flex align-items-center gap-3">
                                @csrf
                                <input type="hidden" name="method" value="Cash">
                                <input type="hidden" name="status" value="{{ $isCashActive ? 'inactive' : 'active' }}">
                                
                                @if($isCashActive)
                                    <button type="submit" class="btn btn-outline-danger fw-bold px-3.5 py-2 rounded-3 d-inline-flex align-items-center gap-2" onclick="return confirm('هل أنت متأكد من رغبتك في تعطيل الدفع عند الاستلام؟')">
                                        <i class="fa-solid fa-power-off"></i>
                                        <span>تعطيل الدفع عند الاستلام</span>
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-outline-success fw-bold px-3.5 py-2 rounded-3 d-inline-flex align-items-center gap-2">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <span>تفعيل الدفع عند الاستلام</span>
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Custom Page Styling -->
<style>
    .payment-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .payment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.08) !important;
    }
    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>

<!-- Copy and UI Scripts -->
<script>
    function copyWebhookUrl() {
        const input = document.getElementById('chargilyWebhookUrl');
        if (!input) return;

        input.select();
        input.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(input.value).then(function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'تم النسخ!',
                    text: 'تم نسخ رابط الـ Webhook بنجاح إلى الحافظة.',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            } else {
                alert('تم نسخ الرابط بنجاح!');
            }
        });
    }

    function toggleSecretVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

