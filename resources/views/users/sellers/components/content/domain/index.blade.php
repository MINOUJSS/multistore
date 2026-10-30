<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15">
                    <i class="fa-solid fa-globe text-warning"></i>
                    <span class="fw-semibold">إعدادات النطاق والهوية</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">Cloudflare SSL for SaaS</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    إدارة الدومين المخصص 🌐
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    اربط متجرك بنطاقك التجاري الخاص (مثل <code>yourbrand.com</code>) لتعزيز ثقة عملائك، مع شهادة أمان SSL تلقائية وحماية سحابية متقدمة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <span class="badge bg-white bg-opacity-15 text-white px-3.5 py-2.5 rounded-3 border border-white border-opacity-20 d-inline-flex align-items-center gap-2 fs-6 fw-semibold">
                        <i class="fa-solid fa-shield-halved text-success"></i>
                        <span>حماية وSSL مجانية</span>
                    </span>
                </div>
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10"
            style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);">
        </div>
        <div class="position-absolute rounded-circle bg-warning opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    <!-- Feedback Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center gap-3 p-3.5" role="alert">
            <span class="avatar avatar-sm rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
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
            <span class="avatar avatar-sm rounded-circle bg-danger text-white d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
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

    <div class="row g-4 mb-4">
        <!-- Connect New Domain Card -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="rounded-3 p-2 text-white" style="background-color: #a40c72;">
                            <i class="fa-solid fa-plus-circle"></i>
                        </span>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">ربط دومين مخصص جديد</h5>
                            <small class="text-muted">أدخل اسم النطاق الخاص بك للبدء في توجيهه إلى متجرك</small>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <form action="{{ route('seller.domain.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="domain_input" class="form-label fw-bold small text-secondary">
                                اسم الدومين <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-lg border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0 text-muted px-3">
                                    <i class="fa-solid fa-link"></i>
                                </span>
                                <input type="text"
                                       name="domain"
                                       id="domain_input"
                                       value="{{ old('domain') }}"
                                       class="form-control border-0 text-start font-monospace @error('domain') is-invalid @enderror"
                                       placeholder="example.com أو store.example.com"
                                       dir="ltr"
                                       required>
                            </div>
                            <small class="form-text text-muted mt-2 d-block">
                                <i class="fa-solid fa-circle-info text-primary me-1"></i>
                                أدخل النطاق مجرداً دون بادئة <code>https://</code> أو مسارات إضافية.
                            </small>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-2">
                            <span class="text-muted small">
                                <i class="fa-solid fa-shield-halved text-success me-1"></i> يتم تفعيل شهادة SSL تلقائياً خلال دقائق
                            </span>
                            <button type="submit" class="btn text-white px-4 py-2.5 rounded-3 fw-bold shadow-sm" style="background-color: #a40c72;">
                                <i class="fa-solid fa-cloud-arrow-up me-1"></i> ربط الدومين الآن
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Primary Subdomain Card -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="rounded-3 p-2 bg-light text-primary">
                            <i class="fa-solid fa-store"></i>
                        </span>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">الدومين الافتراضي للمتجر</h5>
                            <small class="text-muted">الرابط الممنوح لمتجرك على المنصة</small>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    @if($primaryDomain)
                        <div class="p-3 rounded-3 bg-light border border-dashed mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-check-circle text-success fs-5"></i>
                                    <div>
                                        <div class="fw-bold font-monospace text-dark" dir="ltr">{{ $primaryDomain->domain }}</div>
                                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill small mt-1">
                                            دومين المنصة الأساسي (نشط)
                                        </span>
                                    </div>
                                </div>
                                <a href="https://{{ $primaryDomain->domain }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-3">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> زيارة
                                </a>
                            </div>
                        </div>
                    @else
                        <p class="text-muted small">لا يوجد دومين افتراضي مسجل حالياً.</p>
                    @endif

                    <div class="bg-light-subtle p-3 rounded-3 border">
                        <h6 class="fw-bold small mb-2 text-dark">
                            <i class="fa-solid fa-lightbulb text-warning me-1"></i> ملاحظة هامة:
                        </h6>
                        <p class="text-muted small mb-0 lh-base">
                            يبقى الدومين الافتراضي يعمل دائماً كنسخة احتياطية حتى بعد ربط وتفعيل أي دومين مخصص خاص بك.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DNS Setup Instructions Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
            <div class="d-flex align-items-center gap-2">
                <span class="rounded-3 p-2 bg-warning-subtle text-warning">
                    <i class="fa-solid fa-screwdriver-wrench fs-5"></i>
                </span>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">تعليمات ضبط الـ DNS لدى مزود الدومين الخاص بك</h5>
                    <small class="text-muted">قم بإضافة السجل التالي في لوحة تحكم نطاقك (Namecheap, GoDaddy, Cloudflare, etc.)</small>
                </div>
            </div>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center mb-3">
                    <thead class="table-light">
                        <tr>
                            <th class="py-2.5">النوع (Type)</th>
                            <th class="py-2.5">الاسم / المضيف (Name / Host)</th>
                            <th class="py-2.5">القيمة / الهدف (Value / Target)</th>
                            <th class="py-2.5">حالة البروكسي (Proxy Status)</th>
                            <th class="py-2.5">TTL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge bg-primary px-3 py-2 font-monospace">CNAME</span></td>
                            <td>
                                <code class="fw-bold fs-6">@</code>
                                <small class="text-muted d-block">(أو اسم النطاق الفرعي مثل <code>store</code>)</small>
                            </td>
                            <td>
                                <div class="d-inline-flex align-items-center gap-2 bg-light px-3 py-1.5 rounded-3 border">
                                    <code id="cname_target" class="fw-bold text-dark fs-6 font-monospace" dir="ltr">{{ $fallbackOrigin }}</code>
                                    <button type="button" class="btn btn-sm btn-outline-primary border-0 p-1" onclick="copyCnameTarget()" title="نسخ">
                                        <i class="fa-regular fa-copy" id="copy_icon"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary px-2.5 py-1.5 small">DNS Only (رمادي)</span>
                            </td>
                            <td>
                                <span class="text-muted font-monospace">Auto</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="d-flex align-items-start gap-2 p-2.5 bg-light rounded-3">
                        <span class="badge bg-dark rounded-circle">1</span>
                        <small class="text-secondary">ادخل إلى لوحة تحكم النطاق لدى مزود الدومين الخاص بك.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start gap-2 p-2.5 bg-light rounded-3">
                        <span class="badge bg-dark rounded-circle">2</span>
                        <small class="text-secondary">أضف سجل <strong>CNAME</strong> يوجه إلى <code>{{ $fallbackOrigin }}</code>.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start gap-2 p-2.5 bg-light rounded-3">
                        <span class="badge bg-dark rounded-circle">3</span>
                        <small class="text-secondary">اضغط على زر <strong>تحديث الحالة</strong> للتحقق من التفعيل وإصدار شهادة SSL.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Connected Custom Domains List Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-3 p-2 bg-success-subtle text-success">
                        <i class="fa-solid fa-list-check"></i>
                    </span>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">الدومينات المخصصة المربوطة</h5>
                        <small class="text-muted">قائمة النطاقات الخاصة بمتجرك وحالة ربطها وشهادات الأمان</small>
                    </div>
                </div>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill font-monospace">
                    {{ $customDomains->count() }} دومين مخصص
                </span>
            </div>
        </div>
        <div class="card-body px-4 pb-4">
            @if($customDomains->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>الدومين (Domain)</th>
                                <th class="text-center">حالة النطاق (Status)</th>
                                <th class="text-center">شهادة SSL</th>
                                <th class="text-center">تاريخ الإضافة</th>
                                <th class="text-end">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customDomains as $customDomain)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-globe text-primary"></i>
                                            <span class="fw-bold font-monospace fs-6" dir="ltr">{{ $customDomain->domain }}</span>
                                            @if($customDomain->status === 'active')
                                                <a href="https://{{ $customDomain->domain }}" target="_blank" class="text-muted small" title="فتح الموقع">
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
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
                                    <td class="text-center">
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
                                    <td class="text-center text-muted small">
                                        {{ $customDomain->created_at ? $customDomain->created_at->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-2">
                                            <!-- Check Status Button -->
                                            <a href="{{ route('seller.domain.check', $customDomain->id) }}"
                                               class="btn btn-sm btn-outline-primary rounded-3"
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
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="حذف الدومين">
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
                    <p class="text-muted small mb-3">يمكنك ربط اسم نطاقك الخاص مثل (store.com) بكل سهولة عبر النموذج أعلاه.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function copyCnameTarget() {
    const text = document.getElementById('cname_target').innerText.trim();
    navigator.clipboard.writeText(text).then(function() {
        const icon = document.getElementById('copy_icon');
        icon.className = 'fa-solid fa-check text-success';
        setTimeout(function() {
            icon.className = 'fa-regular fa-copy';
        }, 2000);
    });
}
</script>
