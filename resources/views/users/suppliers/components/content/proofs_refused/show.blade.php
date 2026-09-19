<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="proof-details-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-7 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-file-invoice text-warning"></i>
                    <span class="fw-semibold">{{ __('تفاصيل إثبات الدفع المرفوض (مورد)') }}</span>
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
                    @if (Route::has('supplier.payments_proofs_refuseds'))
                        <a href="{{ route('supplier.payments_proofs_refuseds') }}" class="btn btn-light text-dark fw-bold px-3 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
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
        <div class="position-absolute rounded-circle bg-info opacity-10" style="width: 260px; height: 260px; top: -60px; left: -60px; pointer-events: none; filter: blur(45px);"></div>
        <div class="position-absolute rounded-circle bg-primary opacity-10" style="width: 190px; height: 190px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(35px);"></div>
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
                    <div class="p-3 bg-danger bg-opacity-10 border-start border-danger border-4 rounded-3 mb-3">
                        <p class="text-danger fw-semibold fs-5 mb-0" style="line-height: 1.6;">
                            {{ $proof->refuse_reason ?? $proof->reason_refused ?? 'لم يتم تحديد سبب الرفض بالتفصيل من قبل الإدارة.' }}
                        </p>
                    </div>

                    @if (!empty($proof->admin_notes))
                        <div class="p-3 bg-light border-start border-secondary border-3 rounded-3 mb-3">
                            <span class="d-block fw-bold text-secondary small mb-1">ملاحظات إضافية من الإدارة:</span>
                            <p class="text-dark mb-0 small">{{ $proof->admin_notes }}</p>
                        </div>
                    @endif

                    <div class="alert alert-light border d-flex align-items-start gap-3 rounded-3 mb-0">
                        <i class="fa-solid fa-circle-info text-primary fs-5 mt-1"></i>
                        <div class="small text-muted">
                            <strong class="text-dark d-block mb-1">ما الخطوة التالية؟</strong>
                            يرجى مراجعة سبب الرفض أعلاه والتأكد من مطابقة بيانات الدفع أو وضوح صورة الوصل. يمكنك التواصل المباشر مع إدارة المنصة عبر زر "محادثة الإدارة" لتوضيح أي نقطة أو رفع إثبات دفع جديد بعد تسوية الخلاف.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction & Parties Details Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar-sm rounded-3 bg-indigo-subtle text-indigo d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="fa-solid fa-circle-nodes fs-6"></i>
                        </div>
                        <h5 class="fw-bold mb-0 fs-6 text-dark">بيانات المعاملة والأطراف</h5>
                    </div>
                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1.5 rounded-pill fw-semibold">
                        <i class="fa-solid fa-ban me-1"></i> مرفوض
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <span class="text-muted small d-block mb-1">رقم الإثبات في النظام</span>
                                <span class="fw-bold font-monospace fs-6 text-dark">#{{ $proof->id }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <span class="text-muted small d-block mb-1">رقم الطلبية المرتبطة</span>
                                <span class="fw-bold font-monospace fs-6 text-indigo">
                                    {{ $proof->order_number ?? $proof->order_num ?? 'غير محدد' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <span class="text-muted small d-block mb-1">حساب المورد (المرسل)</span>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <div class="rounded-circle bg-indigo text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                        {{ mb_substr($proof->user?->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark fs-6">{{ $proof->user?->name ?? 'غير معروف' }}</div>
                                        <div class="text-muted smaller">{{ $proof->user?->email ?? '—' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <span class="text-muted small d-block mb-1">المسؤول الذي قام بالرفض</span>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                        <i class="fa-solid fa-user-shield"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark fs-6">{{ $proof->admin?->name ?? 'إدارة المنصة' }}</div>
                                        <div class="text-muted smaller">{{ $proof->admin?->email ?? 'مسؤول النظام' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <span class="text-muted small d-block mb-1">تاريخ ووقت الإرسال</span>
                                <div class="fw-bold text-dark">
                                    <i class="fa-regular fa-calendar-days text-muted me-1"></i>
                                    {{ $proof->created_at ? $proof->created_at->format('Y-m-d H:i A') : '—' }}
                                </div>
                                <span class="text-muted smaller">
                                    {{ $proof->created_at ? $proof->created_at->diffForHumans() : '' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <span class="text-muted small d-block mb-1">تاريخ الرفض والمراجعة</span>
                                <div class="fw-bold text-danger">
                                    <i class="fa-regular fa-clock text-danger me-1"></i>
                                    @if (!empty($proof->refused_at))
                                        {{ \Carbon\Carbon::parse($proof->refused_at)->format('Y-m-d H:i A') }}
                                    @else
                                        {{ $proof->updated_at ? $proof->updated_at->format('Y-m-d H:i A') : '—' }}
                                    @endif
                                </div>
                                <span class="text-muted smaller">
                                    @if (!empty($proof->refused_at))
                                        {{ \Carbon\Carbon::parse($proof->refused_at)->diffForHumans() }}
                                    @else
                                        {{ $proof->updated_at ? $proof->updated_at->diffForHumans() : '' }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Attachment & Actions (col-lg-5) -->
        <div class="col-lg-5">
            <!-- Attachment Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar-sm rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="fa-solid fa-paperclip fs-6"></i>
                        </div>
                        <h5 class="fw-bold mb-0 fs-6 text-dark">ملف إثبات الدفع المرفق</h5>
                    </div>
                    <span class="badge bg-light text-muted border px-2.5 py-1 rounded-pill small">المرفق</span>
                </div>
                <div class="card-body p-4 text-center">
                    @php
                        $filePath = $proof->proof_path ?? '';
                        $fileName = basename($filePath);
                        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp']);
                    @endphp

                    @if (!empty($filePath))
                        @if ($isImage)
                            <div class="position-relative attachment-preview-wrapper mb-3 mx-auto" style="max-width: 360px;">
                                <a href="{{ $filePath }}" target="_blank" title="عرض الصورة بالحجم الكامل" class="d-block overflow-hidden rounded-4 border shadow-sm">
                                    <img src="{{ $filePath }}" alt="Attachment Image" class="img-fluid w-100 d-block" style="max-height: 380px; object-fit: contain; background: #f8fafc;">
                                </a>
                                <div class="attachment-overlay d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ $filePath }}" target="_blank" class="btn btn-light btn-sm rounded-pill shadow px-3 fw-bold">
                                        <i class="fa-solid fa-up-right-and-down-left-from-center me-1"></i> تكبير
                                    </a>
                                    <a href="{{ $filePath }}" download class="btn btn-indigo btn-sm rounded-pill shadow px-3 fw-bold text-white">
                                        <i class="fa-solid fa-download me-1"></i> تحميل
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <a href="{{ $filePath }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-3 px-3">
                                    <i class="fa-solid fa-eye me-1"></i> فتح في نافذة مستقلة
                                </a>
                                <a href="{{ $filePath }}" download class="btn btn-outline-secondary btn-sm rounded-3 px-3">
                                    <i class="fa-solid fa-download me-1"></i> تنزيل الملف
                                </a>
                            </div>
                        @else
                            <div class="p-4 bg-light rounded-4 border border-dashed mb-3 text-center">
                                <div class="avatar-lg mx-auto mb-3 bg-white text-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 68px; height: 68px;">
                                    <i class="fa-solid fa-file-pdf fs-2 text-danger"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1 text-truncate" title="{{ $fileName }}">{{ $fileName }}</h6>
                                <p class="text-muted small mb-3">مستند إثبات دفع مرفق</p>
                                <a href="{{ $filePath }}" download class="btn btn-indigo px-4 py-2 rounded-3 text-white fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                    <span>تحميل المستند الآن</span>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="p-4 bg-light rounded-4 text-center text-muted">
                            <i class="fa-solid fa-file-circle-xmark fs-1 text-secondary mb-2 opacity-50"></i>
                            <p class="mb-0 small">لا يوجد ملف إثبات دفع مرفق لهذه المعاملة.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Fast Chat Action Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden text-white"
                 style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                <div class="card-body p-4 text-center">
                    <div class="rounded-circle bg-white bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                        <i class="fa-solid fa-comments fs-3 text-warning"></i>
                    </div>
                    <h5 class="fw-bold mb-2">هل لديك استفسار أو اعتراض؟</h5>
                    <p class="text-white-50 small mb-3">
                        يمكنك بدء محادثة فورية ومباشرة مع إدارة المنصة للاستفسار عن سبب الرفض أو إرسال توضيحات حول هذا الإثبات.
                    </p>
                    <button type="button" class="btn btn-warning text-dark fw-bold w-100 py-2.5 rounded-3 shadow-sm d-inline-flex align-items-center justify-content-center gap-2"
                            onclick="document.getElementById('openChatBtn')?.click();">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>محادثة الإدارة حول الرفض</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!--- Include Realtime Chat Box (Preserved) --->
    @include('users.suppliers.components.content.proofs_refused.inc.chat_box')
</div>

<style>
/* ================= THEME COLOR TOKENS ================= */
.text-indigo { color: #4f46e5 !important; }
.bg-indigo { background-color: #4f46e5 !important; }

.btn-indigo {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%) !important;
    color: #ffffff !important;
    border: none !important;
    transition: all 0.2s ease-in-out;
}
.btn-indigo:hover {
    background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%) !important;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25) !important;
}

.bg-indigo-subtle { background-color: rgba(79, 70, 229, 0.08) !important; }
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
