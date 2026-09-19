<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="proof-details-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
         style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-7 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-file-invoice text-warning"></i>
                    <span class="fw-semibold">{{ __('تفاصيل إثبات الدفع المرفوض') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="font-monospace">#{{ $proof->id }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    إثبات الدفع رقم #{{ $proof->id }} ⚠️
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    مراجعة سبب الرفض المسجل من قِبل إدارة المنصة، فحص المرفقات، والتواصل المباشر لحل المشكلة وإعادة التأكيد.
                </p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    @if (Route::has('seller.payments_proofs_refuseds'))
                        <a href="{{ route('seller.payments_proofs_refuseds') }}" class="btn btn-light text-dark fw-bold px-3 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="fa-solid fa-arrow-right"></i>
                            <span>العودة للقائمة</span>
                        </a>
                    @else
                        <a href="javascript:history.back()" class="btn btn-light text-dark fw-bold px-3 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="fa-solid fa-arrow-right"></i>
                            <span>رجوع</span>
                        </a>
                    @endif

                    <button type="button" class="btn btn-warning text-dark fw-bold px-3 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2" onclick="document.getElementById('openChatBtn')?.click();" title="فتح نافذة المحادثة اللحظية حول هذا الرفض">
                        <i class="fa-solid fa-comments"></i>
                        <span>محادثة الإدارة</span>
                    </button>

                    <button type="button" class="btn btn-outline-light text-white fw-bold px-3 py-2.5 rounded-3 border-2 shadow-sm d-inline-flex align-items-center gap-2" onclick="location.reload();">
                        <i class="fa-solid fa-rotate-right"></i>
                        <span>تحديث</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 260px; height: 260px; top: -60px; left: -60px; pointer-events: none; filter: blur(45px);"></div>
        <div class="position-absolute rounded-circle bg-warning opacity-10" style="width: 190px; height: 190px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(35px);"></div>
    </div>

    <!-- Main Content Grid -->
    <div class="row g-4 mb-4">
        <!-- Left Column: Details & Reason (col-lg-7) -->
        <div class="col-lg-7">
            <!-- Refusal Reason Card (High Priority) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden bg-white">
                <div class="card-header bg-danger bg-opacity-10 border-0 py-3 px-4 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-danger fs-5"></i>
                    <h5 class="fw-bold mb-0 text-danger fs-6">سبب رفض إثبات الدفع من الإدارة</h5>
                </div>
                <div class="card-body p-4">
                    <div class="p-3 bg-danger bg-opacity-10 border border-danger border-opacity-15 rounded-3 mb-3">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fa-solid fa-circle-xmark text-danger mt-1 fs-5"></i>
                            <div class="flex-grow-1 text-danger" style="font-size: 0.95rem; line-height: 1.7;">
                                {{ $proof->refuse_reason ?? 'لم يتم تحديد سبب تفصيلي من قِبل الإدارة.' }}
                            </div>
                        </div>
                    </div>
                    @if(!empty($proof->admin_notes))
                        <div class="p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold text-dark mb-1 small">
                                <i class="fa-solid fa-note-sticky text-plum me-1"></i> ملاحظات إضافية من الإدارة:
                            </h6>
                            <p class="text-secondary mb-0 small" style="line-height: 1.6;">
                                {{ $proof->admin_notes }}
                            </p>
                        </div>
                    @endif
                    <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2 text-muted small">
                        <span><i class="fa-regular fa-clock me-1 text-danger"></i> وقت تسجيل الرفض:</span>
                        <span class="font-monospace fw-semibold text-dark">
                            {{ $proof->created_at ? $proof->created_at->format('Y-m-d H:i:s') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Transaction & Parties Info Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 bg-plum-subtle text-plum">
                        <i class="fa-solid fa-circle-info fs-6"></i>
                    </div>
                    <h5 class="fw-bold mb-0 text-dark fs-6">معلومات العملية والأطراف</h5>
                </div>
                <div class="card-body p-4 pt-2">
                    <div class="row g-3">
                        <!-- User Name -->
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 h-100 border">
                                <small class="text-muted d-block mb-1">
                                    <i class="fa-solid fa-user me-1 text-plum"></i> حساب المستخدم (البائع)
                                </small>
                                <span class="fw-bold text-dark d-block mb-1">
                                    {{ $proof->user->name ?? 'غير معروف' }}
                                </span>
                                @if(!empty($proof->user?->email))
                                    <span class="text-muted smaller d-block text-truncate">
                                        <i class="fa-regular fa-envelope me-1"></i> {{ $proof->user->email }}
                                    </span>
                                @endif
                                @if(!empty($proof->user?->phone))
                                    <span class="text-muted smaller d-block mt-1 font-monospace">
                                        <i class="fa-solid fa-phone me-1"></i> {{ $proof->user->phone }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Reviewing Admin -->
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 h-100 border">
                                <small class="text-muted d-block mb-1">
                                    <i class="fa-solid fa-user-shield me-1 text-plum"></i> المسؤول المراجع
                                </small>
                                <span class="fw-bold text-dark d-block mb-1">
                                    {{ $proof->admin->name ?? 'إدارة المنصة' }}
                                </span>
                                @if(!empty($proof->admin?->email))
                                    <span class="text-muted smaller d-block text-truncate">
                                        <i class="fa-regular fa-envelope me-1"></i> {{ $proof->admin->email }}
                                    </span>
                                @endif
                                <span class="badge bg-plum-subtle text-plum rounded-pill px-2.5 py-1 mt-1 small">
                                    فريق الإدارة والتدقيق
                                </span>
                            </div>
                        </div>

                        <!-- Order Number -->
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 h-100 border">
                                <small class="text-muted d-block mb-1">
                                    <i class="fa-solid fa-hashtag me-1 text-plum"></i> رقم الطلبية / المرجع
                                </small>
                                <span class="fw-bold font-monospace text-dark fs-6">
                                    {{ $proof->order_number ?? '#'.$proof->id }}
                                </span>
                            </div>
                        </div>

                        <!-- Creation Date -->
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 h-100 border">
                                <small class="text-muted d-block mb-1">
                                    <i class="fa-regular fa-calendar-check me-1 text-plum"></i> تاريخ ووقت الإرسال
                                </small>
                                <span class="fw-bold text-dark font-monospace">
                                    {{ $proof->created_at ? $proof->created_at->format('Y-m-d | H:i') : '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Attachment Viewer (col-lg-5) -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden h-100">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 rounded-3 bg-plum-subtle text-plum">
                            <i class="fa-solid fa-paperclip fs-6"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark fs-6">إثبات الدفع المرفق</h5>
                    </div>
                    @if(!empty($proof->proof_path))
                        <a href="{{ asset($proof->proof_path) }}" target="_blank" class="btn btn-sm btn-plum rounded-pill px-3 shadow-sm d-inline-flex align-items-center gap-1">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            <span>فتح الحجم الكامل</span>
                        </a>
                    @endif
                </div>
                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center bg-light bg-opacity-40">
                    @if(!empty($proof->proof_path))
                        @php
                            $fileName = basename($proof->proof_path);
                            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                            $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp']);
                        @endphp

                        @if ($isImage)
                            <div class="text-center w-100 mb-3">
                                <a href="{{ asset($proof->proof_path) }}" target="_blank" class="d-inline-block position-relative attachment-preview-wrapper" title="اضغط للتكبير">
                                    <img src="{{ asset($proof->proof_path) }}" alt="إثبات الدفع المرفق" class="img-fluid rounded-3 shadow-sm border" style="max-height: 380px; object-fit: contain; width: auto; max-width: 100%;">
                                    <div class="attachment-overlay d-flex align-items-center justify-content-center">
                                        <span class="btn btn-sm btn-light rounded-pill px-3 shadow fw-bold">
                                            <i class="fa-solid fa-magnifying-glass-plus me-1 text-plum"></i> تكبير الصورة
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="w-100 text-center">
                                <span class="badge bg-light text-secondary border font-monospace px-3 py-1.5 rounded-pill">
                                    <i class="fa-solid fa-file-image text-plum me-1"></i> {{ $fileName }}
                                </span>
                            </div>
                        @else
                            <!-- Document / PDF File Container -->
                            <div class="text-center p-4 bg-white rounded-4 border shadow-sm w-100 mb-3">
                                <div class="p-3 d-inline-flex rounded-circle bg-plum-subtle text-plum mb-3">
                                    <i class="fa-solid fa-file-lines fa-3x"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">{{ $fileName }}</h6>
                                <span class="badge bg-light text-uppercase text-secondary border mb-3">{{ $fileExtension }}</span>
                                <div>
                                    <a href="{{ asset($proof->proof_path) }}" target="_blank" class="btn btn-plum rounded-3 px-4 fw-semibold shadow-sm">
                                        <i class="fa-solid fa-download me-1"></i> تحميل / فتح المستند
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- No Attachment State -->
                        <div class="text-center py-5 text-muted">
                            <div class="p-3 d-inline-flex rounded-circle bg-light mb-3">
                                <i class="fa-solid fa-file-slash fa-3x text-secondary"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">لا يوجد ملف مرفق</h6>
                            <p class="small text-muted mb-0">لم يتم إرفاق أي وصل أو ملف مع هذا الإثبات.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Actions Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                @if (Route::has('seller.payments_proofs_refuseds'))
                    <a href="{{ route('seller.payments_proofs_refuseds') }}" class="btn btn-light border text-dark rounded-3 px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-arrow-right"></i>
                        <span>العودة إلى قائمة الإثباتات</span>
                    </a>
                @else
                    <a href="javascript:history.back()" class="btn btn-light border text-dark rounded-3 px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-arrow-right"></i>
                        <span>رجوع</span>
                    </a>
                @endif
            </div>

            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-plum text-white rounded-3 px-4 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-2" onclick="document.getElementById('openChatBtn')?.click();">
                    <i class="fa-solid fa-comments"></i>
                    <span>محادثة الإدارة حول الرفض</span>
                </button>
            </div>
        </div>
    </div>

    <!--- Include Realtime Chat Box (Preserved) --->
    @include('users.sellers.components.content.proofs_refused.inc.chat_box')
</div>

<style>
/* ================= THEME COLOR TOKENS ================= */
.text-plum { color: #a40c72 !important; }
.bg-plum { background-color: #a40c72 !important; }

.btn-plum {
    background: linear-gradient(135deg, #a40c72 0%, #be0681 100%) !important;
    color: #ffffff !important;
    border: none !important;
    transition: all 0.2s ease-in-out;
}
.btn-plum:hover {
    background: linear-gradient(135deg, #8a0a60 0%, #a40c72 100%) !important;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(164, 12, 114, 0.25) !important;
}

.bg-plum-subtle { background-color: rgba(164, 12, 114, 0.08) !important; }
.smaller { font-size: 0.78rem !important; }

/* Image Attachment Hover Effect */
.attachment-preview-wrapper {
    overflow: hidden;
    border-radius: 12px;
}
.attachment-preview-wrapper img {
    transition: transform 0.3s ease;
}
.attachment-preview-wrapper:hover img {
    transform: scale(1.03);
}
.attachment-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.2);
    opacity: 0;
    transition: opacity 0.25s ease;
    border-radius: 12px;
}
.attachment-preview-wrapper:hover .attachment-overlay {
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .proof-details-hero {
        padding: 1.5rem !important;
    }
}
</style>
