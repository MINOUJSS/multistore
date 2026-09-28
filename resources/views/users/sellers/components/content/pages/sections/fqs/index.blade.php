<style>
/* ================= FAQS PAGE MODERN STYLES ================= */
.text-plum {
    color: #a40c72 !important;
}

.bg-seller-gradient {
    background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%) !important;
}

.btn-seller-primary {
    background: linear-gradient(135deg, #5b073e 0%, #a40c72 100%);
    color: #ffffff;
    border: none;
    transition: all 0.25s ease;
}

.btn-seller-primary:hover {
    background: linear-gradient(135deg, #46052f 0%, #87095d 100%);
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(164, 12, 114, 0.25);
}

.table > :not(caption) > * > * {
    padding: 0.95rem 1rem;
    vertical-align: middle;
}

.btn-circle {
    width: 34px;
    height: 34px;
    padding: 0;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.825rem;
    transition: all 0.2s ease;
}

.btn-circle:hover {
    transform: scale(1.1);
}

/* ================= TABLE RESPONSIVE CONTAINMENT ================= */
.card-body .table-responsive {
    width: 100% !important;
    max-width: 100% !important;
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
}

.pagination {
    flex-wrap: wrap !important;
    justify-content: center !important;
    margin-bottom: 0 !important;
    gap: 4px;
}

.pagination .page-item .page-link {
    font-size: 0.85rem;
    padding: 0.35rem 0.65rem;
    border-radius: 6px !important;
}

/* ================= RESPONSIVE ADJUSTMENTS ================= */
@media (max-width: 767.98px) {
    .dashboard-hero {
        padding: 1.5rem !important;
        border-radius: 1rem !important;
    }
    .card-header-actions {
        flex-direction: column;
        align-items: stretch !important;
        gap: 0.75rem;
    }
    .card-header-actions .btn {
        width: 100%;
    }
}

/* ================= PURE CSS RESPONSIVE TABLE CARD TRANSFORMATION (< 992px) ================= */
@media (max-width: 991.98px) {
    #faqsTable,
    #faqsTable tbody,
    #faqsTable tr,
    #faqsTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }

    #faqsTable thead {
        display: none !important;
    }

    #faqsTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }

    #faqsTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }

    #faqsTable tbody td:last-child {
        border-bottom: none !important;
    }

    #faqsTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
        text-align: right;
    }

    /* Empty state row on mobile */
    #faqsTable tbody td.empty-cell,
    #faqsTable tbody td[colspan] {
        display: block !important;
        text-align: center !important;
        border: none !important;
        padding: 2.5rem 1rem !important;
    }

    #faqsTable tbody td.empty-cell::before,
    #faqsTable tbody td[colspan]::before {
        display: none !important;
    }
}
</style>

<div class="container-fluid px-3 px-md-4 py-3">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden bg-seller-gradient"
        style="border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-circle-question text-warning"></i>
                    <span class="fw-semibold">{{ __('تخصيص صفحات المتجر') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    ❓ إدارة وتخصيص الأسئلة الشائعة (FAQ) 💬
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6 text-start">
                    إدارة الأسئلة الأكثر تكراراً وإجاباتها النموذجية لإزالة الشكوك لدى المتسوقين، تعزيز الشفافية وبناء الثقة في متجرك لزيادة معدل إتمام الطلبات.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('seller.dashboard') }}"
                        class="btn btn-light text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fas fa-arrow-right"></i>
                        <span>لوحة التحكم</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Decorative Glow Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10"
            style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);">
        </div>
        <div class="position-absolute rounded-circle bg-warning opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('message'))
        <div class="alert alert-info border-0 shadow-sm rounded-3 p-3 mb-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-info fs-5"></i>
                <span class="fw-semibold">{{ session()->get('message') }}</span>
            </div>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Section Overview & Display Status Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-center gy-3">
                <div class="col-12 col-lg-7">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white flex-shrink-0 shadow-sm"
                            style="width: 50px; height: 50px; background: linear-gradient(135deg, #a40c72 0%, #5b073e 100%);">
                            <i class="fa-solid fa-comments-question-check fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                <h5 class="fw-bold text-dark mb-0">عرض قسم الأسئلة الشائعة على المتجر</h5>
                                @if ($faqs_status->value == 'true')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill small fw-bold">
                                        <i class="fa-solid fa-circle-check me-1"></i> مفعل على واجهة المتجر
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-muted border border-secondary-subtle px-2.5 py-1 rounded-pill small fw-bold">
                                        <i class="fa-solid fa-circle-xmark me-1"></i> معطل حالياً
                                    </span>
                                @endif
                            </div>
                            <p class="text-muted small mb-0 lh-base">
                                يمكنك التحكم في إظهار أو إخفاء قسم الأسئلة الشائعة في متجرك للمتسوقين بنقرة واحدة.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="d-flex align-items-center justify-content-lg-end gap-3 flex-wrap pt-2 pt-lg-0 border-top border-lg-0 border-light-subtle">
                        <form action="{{ route('seller.faqs.updateStatus') }}" method="POST" class="d-inline-flex align-items-center gap-2 m-0">
                            @csrf
                            <div class="form-check form-switch mb-0 d-flex align-items-center gap-2 p-0">
                                <input class="form-check-input cursor-pointer ms-0 me-2" type="checkbox" id="faqs_status" name="faqs_status"
                                    style="width: 2.75rem; height: 1.4rem;"
                                    @if ($faqs_status->value == 'true') checked @endif>
                                <label class="form-check-label fw-bold text-dark small cursor-pointer" for="faqs_status">
                                    {{ $faqs_status->value == 'true' ? 'تفعيل العرض' : 'تعطيل العرض' }}
                                </label>
                            </div>
                            <button type="submit" class="btn btn-seller-primary btn-sm rounded-3 px-3.5 py-1.5 fw-bold shadow-sm">
                                <i class="fa-solid fa-check me-1"></i> حفظ الإعداد
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQs Table Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
        <div class="card-header bg-white py-3.5 px-4 border-bottom border-light-subtle d-flex align-items-center justify-content-between flex-wrap gap-2 card-header-actions">
            <div class="d-flex align-items-center gap-2.5">
                <i class="fa-solid fa-list-ol text-plum fs-5"></i>
                <h5 class="fw-bold mb-0 text-dark">قائمة الأسئلة الشائعة</h5>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 small fw-bold">
                    {{ count($faqs) }} سؤال
                </span>
            </div>
            <button id="addFaqBtn" class="btn btn-seller-primary px-3.5 py-2 rounded-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>إضافة سؤال جديد</span>
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap" id="faqsTable">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th style="width: 30%;">السؤال</th>
                            <th>الإجابة</th>
                            <th style="width: 100px;" class="text-center">الترتيب</th>
                            <th style="width: 110px;" class="text-center">الحالة</th>
                            <th style="width: 120px;" class="text-center pe-4">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($faqs as $index => $faq)
                            <tr>
                                <td class="ps-4 text-muted fw-bold small" data-label="#">
                                    {{ $index + 1 }}
                                </td>
                                <td data-label="السؤال">
                                    <span class="fw-bold text-dark fs-7 d-block">
                                        {{ Str::limit($faq->question, 50) }}
                                    </span>
                                </td>
                                <td data-label="الإجابة">
                                    <span class="text-muted small text-wrap d-block" style="max-width: 480px; line-height: 1.45;">
                                        {{ Str::limit($faq->answer, 80) }}
                                    </span>
                                </td>
                                <td class="text-center" data-label="الترتيب">
                                    <span class="badge bg-light text-dark border px-2.5 py-1.5 rounded-pill font-monospace fw-bold">
                                        {{ $faq->order }}
                                    </span>
                                </td>
                                <td class="text-center" data-label="الحالة">
                                    @if ($faq->status == 'active')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill small fw-semibold">
                                            <i class="fa-solid fa-circle-check me-1"></i> نشط
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill small fw-semibold">
                                            <i class="fa-solid fa-circle-xmark me-1"></i> غير نشط
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center pe-4" data-label="الإجراءات">
                                    <div class="d-inline-flex align-items-center gap-1.5">
                                        <button class="btn btn-circle btn-primary edit-faq text-white shadow-sm"
                                            data-id="{{ $faq->id }}" title="تعديل السؤال">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-circle btn-danger delete-faq text-white shadow-sm"
                                            data-id="{{ $faq->id }}" title="حذف السؤال">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 empty-cell">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3"
                                            style="width: 70px; height: 70px;">
                                            <i class="fa-solid fa-circle-question text-muted fs-2"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">لا توجد أسئلة شائعة مضافة حالياً</h6>
                                        <p class="text-muted small mb-3">أضف الأسئلة الشائعة التي يطرحها العملاء لمساعدتهم في اتخاذ قرار الشراء.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ================= MODALS ================= --}}

<!-- Add FAQ Modal -->
<div class="modal fade" id="addFaqModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-seller-gradient text-white py-3 px-4">
                <h5 class="modal-title fw-bold fs-6 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-plus-circle"></i>
                    <span>إضافة سؤال جديد</span>
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="addFaqForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label for="question" class="form-label fw-bold text-dark small">السؤال <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3 py-2" id="question" name="question" placeholder="مثال: كم تستغرق مدة توصيل الطلب؟" required>
                        <div class="invalid-feedback error-question"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="answer" class="form-label fw-bold text-dark small">الإجابة النموذجية <span class="text-danger">*</span></label>
                        <textarea class="form-control rounded-3" id="answer" name="answer" rows="4" placeholder="اكتب الإجابة المفصلة بوضوح..." required></textarea>
                        <div class="invalid-feedback error-answer"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="form-group mb-0">
                                <label for="order" class="form-label fw-bold text-dark small">ترتيب العرض</label>
                                <input type="number" class="form-control rounded-3 py-2" id="order" name="order" value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="status" class="form-label fw-bold text-dark small">حالة السؤال</label>
                                <select class="form-select rounded-3 py-2" id="status" name="status">
                                    <option value="active" selected>نشط (يظهر في المتجر)</option>
                                    <option value="inactive">غير نشط (مخفي)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0 py-3 px-4">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-seller-primary rounded-3 px-4 fw-bold shadow-sm">حفظ السؤال</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit FAQ Modal -->
<div class="modal fade" id="editFaqModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-seller-gradient text-white py-3 px-4">
                <h5 class="modal-title fw-bold fs-6 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>تعديل السؤال</span>
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="editFaqForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_faq_id" name="id">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label for="edit_question" class="form-label fw-bold text-dark small">السؤال <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3 py-2" id="edit_question" name="question" required>
                        <div class="invalid-feedback error-question"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_answer" class="form-label fw-bold text-dark small">الإجابة النموذجية <span class="text-danger">*</span></label>
                        <textarea class="form-control rounded-3" id="edit_answer" name="answer" rows="4" required></textarea>
                        <div class="invalid-feedback error-answer"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="form-group mb-0">
                                <label for="edit_order" class="form-label fw-bold text-dark small">ترتيب العرض</label>
                                <input type="number" class="form-control rounded-3 py-2" id="edit_order" name="order" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="edit_status" class="form-label fw-bold text-dark small">حالة السؤال</label>
                                <select class="form-select rounded-3 py-2" id="edit_status" name="status">
                                    <option value="active">نشط (يظهر في المتجر)</option>
                                    <option value="inactive">غير نشط (مخفي)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0 py-3 px-4">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-seller-primary rounded-3 px-4 fw-bold shadow-sm">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- sweet alert --}}
@if (session('success'))
    <script>
        Swal.fire({
            title: 'نجاح!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'حسنًا'
        });
    </script>
@endif
