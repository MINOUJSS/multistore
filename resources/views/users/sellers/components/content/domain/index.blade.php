<div class="container-fluid py-3 px-3 px-md-4 domain-management-container">
    <!-- Dynamic Hero Welcome Banner -->
    <div class="domain-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-globe text-warning"></i>
                    <span class="fw-semibold">إعدادات النطاق والهوية الرقمية</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    إدارة النطاقات والدومين المخصص 🌐
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    اربط متجرك بنطاقك التجاري الخاص (مثل <code>yourbrand.com</code>) لتعزيز ثقة عملائك، مع شهادة أمان SSL مجانية وتلقائية وحماية سحابية عبر Cloudflare.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <span class="badge bg-white bg-opacity-15 text-white px-3.5 py-2.5 rounded-3 border border-white border-opacity-20 d-inline-flex align-items-center gap-2 fs-6 fw-semibold">
                        <i class="fa-solid fa-shield-halved text-success"></i>
                        <span>حماية وSSL مجانية</span>
                    </span>
                    <span class="badge bg-white bg-opacity-15 text-white px-3.5 py-2.5 rounded-3 border border-white border-opacity-20 d-inline-flex align-items-center gap-2 fs-6 fw-semibold">
                        <i class="fa-solid fa-server text-warning"></i>
                        <span>{{ $customDomains->count() }} نطاقات مضافة</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10"
            style="width: 260px; height: 260px; top: -60px; left: -60px; pointer-events: none; filter: blur(45px);">
        </div>
        <div class="position-absolute rounded-circle bg-warning opacity-10"
            style="width: 190px; height: 190px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(35px);">
        </div>
    </div>

    <!-- Feedback Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-3 p-3.5" role="alert">
            <span class="avatar avatar-sm rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px;">
                <i class="fa-solid fa-circle-check fs-5"></i>
            </span>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-bold">{{ session('success') }}</h6>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-3 p-3.5" role="alert">
            <span class="avatar avatar-sm rounded-circle bg-danger text-white d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px;">
                <i class="fa-solid fa-triangle-exclamation fs-5"></i>
            </span>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-bold">{{ session('error') }}</h6>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 p-3.5" role="alert">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="fa-solid fa-circle-exclamation text-danger fs-5"></i>
                <h6 class="mb-0 fw-bold">يرجى تصحيح الأخطاء التالية:</h6>
            </div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Quick Indicator Stat Cards -->
    <div class="row g-3 mb-4">
        <!-- 1. Primary Default Domain Card -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white domain-stat-card hover-lift">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold">
                            <i class="fa-solid fa-store fs-5"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill small">الأساسي</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">دومين المنصة الافتراضي</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fw-bold text-dark font-monospace text-truncate fs-6" dir="ltr" style="max-width: 180px;" title="{{ $primaryDomain->domain ?? '-' }}">
                            {{ $primaryDomain->domain ?? 'غير محدد' }}
                        </span>
                        @if($primaryDomain)
                            <a href="https://{{ $primaryDomain->domain }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1" title="زيارة المتجر">
                                <i class="fa-solid fa-arrow-up-right-from-square small"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Custom Domains Count Card -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white domain-stat-card hover-lift">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-primary-subtle text-primary fw-bold">
                            <i class="fa-solid fa-globe fs-5"></i>
                        </span>
                        <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 rounded-pill small">
                            {{ $customDomains->where('status', 'active')->count() }} نشط
                        </span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">الدومينات المخصصة</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $customDomains->count() }}</h3>
                </div>
            </div>
        </div>

        <!-- 3. SSL Security Status Card -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white domain-stat-card hover-lift">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-success-subtle text-success fw-bold">
                            <i class="fa-solid fa-shield-halved fs-5"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill small">تلقائي</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">شهادة الأمان السحابية</h6>
                    <div class="d-flex align-items-center gap-1.5 text-success fw-bold fs-6">
                        <i class="fa-solid fa-lock"></i>
                        <span>Cloudflare SSL (نشطة)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Domain Setup Card (Designed Like Okwin + Multi-Store Polish) -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-transparent border-0 pt-4 px-3 px-md-4 pb-0">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-sm rounded-3 bg-plum-subtle text-plum d-inline-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-link fs-6"></i>
                    </span>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">ربط النطاق</h5>
                        <small class="text-muted">اختر طريقة الربط المناسبة ثم أدخل اسم النطاق الخاص بك</small>
                    </div>
                </div>

                <!-- Connection Method Switcher (Nameservers vs CNAME) -->
                <ul class="nav nav-pills bg-light p-1 rounded-3 small flex-wrap" id="domainMethodTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-2 fw-semibold px-3 py-1.5"
                                id="method-ns-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#method-ns"
                                type="button"
                                role="tab"
                                aria-selected="true">
                            <i class="fa-solid fa-server me-1"></i> أسماء الخوادم (Nameservers)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-2 fw-semibold px-3 py-1.5"
                                id="method-cname-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#method-cname"
                                type="button"
                                role="tab"
                                aria-selected="false">
                            <i class="fa-solid fa-code-compare me-1"></i> سجل CNAME
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-body px-3 px-md-4 py-4">
            <form action="{{ route('seller.domain.store') }}" method="POST" id="domainConnectForm">
                @csrf

                <!-- Form Fields Row: Domain Name + Store (Same layout as Okwin) -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-7 col-lg-8">
                        <label for="domain_input" class="form-label fw-bold small text-secondary">
                            إسم النطاق <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-lg border rounded-3 overflow-hidden domain-input-group">
                            <span class="input-group-text bg-white border-0 text-muted px-3">
                                <i class="fa-solid fa-globe"></i>
                            </span>
                            <input type="text"
                                   name="domain"
                                   id="domain_input"
                                   value="{{ old('domain') }}"
                                   class="form-control border-0 text-start font-monospace @error('domain') is-invalid @enderror"
                                   placeholder="example.com"
                                   dir="ltr"
                                   required>
                        </div>
                        <small class="form-text text-muted mt-1.5 d-block">
                            <i class="fa-solid fa-circle-info text-primary me-1"></i>
                            أدخل النطاق دون بادئة <code>https://</code> أو مسارات إضافية.
                        </small>
                    </div>

                    <div class="col-12 col-md-5 col-lg-4">
                        <label class="form-label fw-bold small text-secondary">
                            المتجر
                        </label>
                        <div class="input-group input-group-lg border rounded-3 bg-light overflow-hidden">
                            <span class="input-group-text bg-light border-0 text-muted px-3">
                                <i class="fa-solid fa-store"></i>
                            </span>
                            <input type="text"
                                   class="form-control bg-light border-0 text-start fw-bold text-dark font-monospace"
                                   value="{{ $tenant->id ?? (Auth::user()->tenant_id ?? 'store') }}"
                                   dir="ltr"
                                   readonly>
                        </div>
                    </div>
                </div>

                <!-- Tab Content: Instructions Box -->
                <div class="tab-content mb-4" id="domainMethodTabsContent">
                    <!-- Method 1: Nameservers (Okwin Style) -->
                    <div class="tab-pane fade show active" id="method-ns" role="tabpanel" aria-labelledby="method-ns-tab">
                        <div class="border rounded-4 p-3.5 p-md-4 bg-light-subtle">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                                <h6 class="fw-bold mb-0 text-dark">
                                    قم بإضافة سجلات أسماء الخوادم التالية إلى أسماء نطاقك:
                                </h6>
                                <button type="button"
                                        class="btn btn-sm btn-outline-primary rounded-3 px-3 py-1.5 fw-semibold"
                                        onclick="copyAllNameservers()">
                                    <i class="fa-regular fa-copy me-1" id="copy_all_icon"></i>
                                    <span>نسخ جميع الخوادم</span>
                                </button>
                            </div>

                            <!-- Nameservers Box (Exact Okwin Look with Modern Polish) -->
                            <div class="bg-white border rounded-3 p-3 shadow-2xs font-monospace text-start" dir="ltr">
                                <div class="d-flex align-items-center justify-content-between py-2 border-bottom flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 px-2 py-1 small">NS 1</span>
                                        <span class="fs-6 fw-bold text-dark text-break" id="ns1_text">{{ $ns1 ?? 'ns1.dzora.net' }}</span>
                                    </div>
                                    <button type="button"
                                            class="btn btn-sm btn-link text-decoration-none text-muted p-1 hover-primary"
                                            onclick="copyText('{{ $ns1 ?? 'ns1.dzora.net' }}', this)"
                                            title="نسخ NS 1">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                </div>

                                <div class="d-flex align-items-center justify-content-between py-2 pt-3 flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 px-2 py-1 small">NS 2</span>
                                        <span class="fs-6 fw-bold text-dark text-break" id="ns2_text">{{ $ns2 ?? 'ns2.dzora.net' }}</span>
                                    </div>
                                    <button type="button"
                                            class="btn btn-sm btn-link text-decoration-none text-muted p-1 hover-primary"
                                            onclick="copyText('{{ $ns2 ?? 'ns2.dzora.net' }}', this)"
                                            title="نسخ NS 2">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-3 text-muted small">
                                <i class="fa-solid fa-circle-info text-primary me-1"></i>
                                ادخل إلى لوحة تحكم مزود النطاق الخاص بك (Namecheap, GoDaddy, Dynadot...)، اختر <strong>Custom DNS</strong> ثم الصق الخوادم أعلاه.
                            </div>
                        </div>
                    </div>

                    <!-- Method 2: CNAME Record (Alternative) -->
                    <div class="tab-pane fade" id="method-cname" role="tabpanel" aria-labelledby="method-cname-tab">
                        <div class="border rounded-4 p-3.5 p-md-4 bg-light-subtle">
                            <h6 class="fw-bold mb-3 text-dark">
                                قم بإضافة سجل CNAME في لوحة إدارة الـ DNS لنطاقك:
                            </h6>

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center bg-white mb-2" id="cnameTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>النوع (Type)</th>
                                            <th>المضيف / الاسم (Name)</th>
                                            <th>الهدف / القيمة (Target / Value)</th>
                                            <th>حالة البروكسي (Proxy)</th>
                                            <th>TTL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-label="النوع"><span class="badge bg-primary px-3 py-1.5 font-monospace">CNAME</span></td>
                                            <td data-label="المضيف"><code class="fw-bold fs-6">@</code> <span class="text-muted small">(أو <code>www</code>)</span></td>
                                            <td data-label="الهدف">
                                                <div class="d-inline-flex align-items-center gap-2 bg-light px-3 py-1.5 rounded-3 border">
                                                    <code id="cname_target" class="fw-bold text-dark font-monospace text-break" dir="ltr">{{ $fallbackOrigin }}</code>
                                                    <button type="button" class="btn btn-sm btn-link text-primary p-0" onclick="copyText('{{ $fallbackOrigin }}', this)" title="نسخ">
                                                        <i class="fa-regular fa-copy"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td data-label="البروكسي"><span class="badge bg-secondary px-2 py-1 small">DNS Only (رمادي)</span></td>
                                            <td data-label="TTL"><span class="text-muted font-monospace">Auto</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-2 text-muted small">
                                <i class="fa-solid fa-lightbulb text-warning me-1"></i>
                                هذه الطريقة مفيدة إذا كان لديك بريد إلكتروني نشط (MX Records) على نطاقك وتريد الإبقاء عليه دون تغيير أسماء الخوادم بالكامل.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button (Okwin Blue Button Style with Responsive Touch) -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold py-3 shadow-sm d-flex align-items-center justify-content-center gap-2 hover-lift" style="background-color: #0d6efd; border-color: #0d6efd;">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>تأكيد وإضافة النطاق</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Secondary Info Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Default Store Domain Card -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="avatar avatar-sm rounded-3 bg-light text-primary d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-store fs-6"></i>
                        </span>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">الدومين الافتراضي لمتجرك</h5>
                            <small class="text-muted">الرابط الممنوح لمتجرك تلقائياً على منصة dzora</small>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    @if($primaryDomain)
                        <div class="p-3 rounded-3 bg-light border border-dashed d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-circle-check text-success fs-5"></i>
                                <div>
                                    <div class="fw-bold font-monospace text-dark text-break" dir="ltr">{{ $primaryDomain->domain }}</div>
                                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill small mt-1">
                                        نشط ويعمل دائماً
                                    </span>
                                </div>
                            </div>
                            <a href="https://{{ $primaryDomain->domain }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-3 px-3 py-1.5">
                                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> زيارة المتجر
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Help & Verification Info Card -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="avatar avatar-sm rounded-3 bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-clock-rotate-left fs-6"></i>
                        </span>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">مدة انتشار الـ DNS والتفعيل</h5>
                            <small class="text-muted">معلومات حول تفعيل النطاقات الجديدة</small>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <p class="text-muted small mb-2 lh-base">
                        قد يستغرق انتشار أسماء الخوادم (DNS Propagation) عالمياً ما بين <strong>15 دقيقة إلى 24 ساعة</strong> كحد أقصى حسب مزود النطاق الخاص بك.
                    </p>
                    <div class="d-flex align-items-center gap-2 text-success small fw-semibold">
                        <i class="fa-solid fa-shield-check fs-6"></i>
                        <span>يتم إصدار شهادة SSL السحابية وتفعيلها تلقائياً بمجرد اكتمال التوجيه.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Connected Custom Domains List Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-transparent border-0 pt-4 px-3 px-md-4 pb-2">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-sm rounded-3 bg-success-subtle text-success d-inline-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-list-check fs-6"></i>
                    </span>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">النطاقات المربوطة بالمتجر</h5>
                        <small class="text-muted">قائمة النطاقات الخاصة وحالة الربط وشهادة الأمان SSL</small>
                    </div>
                </div>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill font-monospace">
                    {{ $customDomains->count() }} نطاق مخصص
                </span>
            </div>
        </div>
        <div class="card-body px-3 px-md-4 pb-4">
            @if($customDomains->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="connectedDomainsTable">
                        <thead class="table-light">
                            <tr>
                                <th>النطاق (Domain)</th>
                                <th class="text-center">حالة النطاق</th>
                                <th class="text-center">شهادة SSL</th>
                                <th class="text-center">تاريخ الإضافة</th>
                                <th class="text-end">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customDomains as $customDomain)
                                <tr>
                                    <td data-label="النطاق">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-globe text-primary"></i>
                                            <span class="fw-bold font-monospace fs-6 text-break" dir="ltr">{{ $customDomain->domain }}</span>
                                            @if($customDomain->status === 'active')
                                                <a href="https://{{ $customDomain->domain }}" target="_blank" class="text-muted small ms-1" title="فتح المتجر">
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td data-label="حالة النطاق" class="text-center">
                                        @if($customDomain->status === 'active')
                                            <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill">
                                                <i class="fa-solid fa-circle-check me-1"></i> نشط ويعمل
                                            </span>
                                        @elseif($customDomain->status === 'pending')
                                            <span class="badge bg-warning-subtle text-warning border border-warning border-opacity-25 px-3 py-1.5 rounded-pill">
                                                <i class="fa-solid fa-clock-rotate-left me-1"></i> قيد التحقق (Pending)
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 px-3 py-1.5 rounded-pill">
                                                <i class="fa-solid fa-circle-xmark me-1"></i> {{ $customDomain->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td data-label="شهادة SSL" class="text-center">
                                        @if($customDomain->ssl_status === 'active')
                                            <span class="badge bg-success text-white px-2.5 py-1 rounded-pill">
                                                <i class="fa-solid fa-lock me-1"></i> مفعلة وآمنة
                                            </span>
                                        @elseif($customDomain->ssl_status === 'pending_validation')
                                            <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill">
                                                <i class="fa-solid fa-lock-open me-1"></i> جاري التحقق
                                            </span>
                                        @else
                                            <span class="badge bg-secondary text-white px-2.5 py-1 rounded-pill">
                                                <i class="fa-solid fa-lock-open me-1"></i> {{ $customDomain->ssl_status ?? 'قيد المعالجة' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td data-label="تاريخ الإضافة" class="text-center text-muted small">
                                        {{ $customDomain->created_at ? $customDomain->created_at->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td data-label="الإجراءات" class="text-end">
                                        <div class="d-inline-flex gap-2">
                                            <!-- Check Status Button -->
                                            <a href="{{ route('seller.domain.check', $customDomain->id) }}"
                                               class="btn btn-sm btn-outline-primary rounded-3 px-2.5 py-1"
                                               title="تحديث والتحقق من حالة الدومين">
                                                <i class="fa-solid fa-arrows-rotate me-1"></i> فحص الحالة
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('seller.domain.destroy', $customDomain->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا الدومين المخصص؟');"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2.5 py-1" title="حذف الدومين">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="avatar avatar-xl rounded-circle bg-light text-muted mx-auto mb-3 d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-globe fs-2 text-secondary opacity-50"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">لم تقم بإضافة دومين مخصص بعد</h6>
                    <p class="text-muted small mb-0">أدخل اسم النطاق الخاص بك في النموذج أعلاه لربطه مباشرة بمتجرك.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Scoped Styles for Domain Management View */
    .domain-management-container {
        min-width: 0 !important;
        max-width: 100% !important;
    }

    .bg-plum-subtle {
        background-color: rgba(164, 12, 114, 0.1) !important;
    }

    .text-plum {
        color: #a40c72 !important;
    }

    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .hover-primary:hover {
        color: #0d6efd !important;
    }

    .avatar-md {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-sm {
        width: 36px;
        height: 36px;
    }

    .shadow-2xs {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .backdrop-blur {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    /* Prevent table horizontal overflow on parent */
    .table-responsive {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
    }

    /* Pure CSS Responsive Table for Mobile (< 992px) */
    @media (max-width: 991.98px) {
        #connectedDomainsTable,
        #connectedDomainsTable tbody,
        #connectedDomainsTable tr,
        #connectedDomainsTable td {
            display: block;
            width: 100% !important;
            box-sizing: border-box;
        }

        #connectedDomainsTable thead {
            display: none !important;
        }

        #connectedDomainsTable tbody tr {
            background: #ffffff;
            border: 1px solid #e9ecef !important;
            border-radius: 14px;
            margin-bottom: 1rem;
            padding: 0.5rem 0.75rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
        }

        #connectedDomainsTable tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.65rem 0.5rem;
            border: none !important;
            border-bottom: 1px dashed #edf2f7 !important;
            white-space: normal !important;
            text-align: left;
        }

        #connectedDomainsTable tbody td:last-child {
            border-bottom: none !important;
        }

        #connectedDomainsTable tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            color: #495057;
            font-size: 0.85rem;
            margin-left: 1rem;
            flex-shrink: 0;
            text-align: right;
        }

        /* Mobile CNAME Table */
        #cnameTable,
        #cnameTable tbody,
        #cnameTable tr,
        #cnameTable td {
            display: block;
            width: 100% !important;
            box-sizing: border-box;
        }

        #cnameTable thead {
            display: none !important;
        }

        #cnameTable tbody tr {
            display: block;
            border: none;
        }

        #cnameTable tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.6rem 0.5rem;
            border: none !important;
            border-bottom: 1px dashed #edf2f7 !important;
        }

        #cnameTable tbody td:last-child {
            border-bottom: none !important;
        }

        #cnameTable tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            color: #495057;
            font-size: 0.85rem;
            margin-left: 1rem;
            flex-shrink: 0;
            text-align: right;
        }
    }
</style>

<script>
function copyText(text, btnElement) {
    navigator.clipboard.writeText(text).then(function() {
        const icon = btnElement.querySelector('i');
        const originalClass = icon.className;
        icon.className = 'fa-solid fa-check text-success';
        setTimeout(function() {
            icon.className = originalClass;
        }, 1800);
    });
}

function copyAllNameservers() {
    const ns1El = document.getElementById('ns1_text');
    const ns2El = document.getElementById('ns2_text');
    const ns1 = ns1El ? ns1El.innerText.trim() : '';
    const ns2 = ns2El ? ns2El.innerText.trim() : '';
    const text = ns1 + '\n' + ns2;

    navigator.clipboard.writeText(text).then(function() {
        const icon = document.getElementById('copy_all_icon');
        if (icon) {
            icon.className = 'fa-solid fa-check text-success me-1';
            setTimeout(function() {
                icon.className = 'fa-regular fa-copy me-1';
            }, 1800);
        }
    });
}
</script>
