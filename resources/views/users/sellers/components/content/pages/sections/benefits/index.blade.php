<style>
/* ================= BENEFITS PAGE MODERN STYLES ================= */
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

.icon-preview-box {
    width: 44px;
    height: 44px;
    background: rgba(164, 12, 114, 0.08);
    color: #a40c72;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: all 0.2s ease;
}

.icon-preview-box:hover {
    background: #a40c72;
    color: #ffffff;
    transform: scale(1.08);
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
    #elementsTable,
    #elementsTable tbody,
    #elementsTable tr,
    #elementsTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }

    #elementsTable thead {
        display: none !important;
    }

    #elementsTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }

    #elementsTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }

    #elementsTable tbody td:last-child {
        border-bottom: none !important;
    }

    #elementsTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
        text-align: right;
    }

    /* Empty state row on mobile */
    #elementsTable tbody td.empty-cell,
    #elementsTable tbody td[colspan] {
        display: block !important;
        text-align: center !important;
        border: none !important;
        padding: 2.5rem 1rem !important;
    }

    #elementsTable tbody td.empty-cell::before,
    #elementsTable tbody td[colspan]::before {
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
                    <i class="fa-solid fa-gem text-warning"></i>
                    <span class="fw-semibold">{{ __('تخصيص صفحات المتجر') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    ✨ إدارة وتخصيص قسم {{ $benefit->title }}
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6 text-start">
                    إدارة وتخصيص مميزات المتجر المعروضة للعملاء (الشحن السريع، الضمان، خدمة العملاء، والدفع عند الاستلام) لزيادة المبيعات وبناء الثقة.
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

    <!-- Section Overview & Status Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-center gy-3">
                <div class="col-12 col-lg-7">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white flex-shrink-0 shadow-sm"
                            style="width: 50px; height: 50px; background: linear-gradient(135deg, #a40c72 0%, #5b073e 100%);">
                            <i class="fa-solid fa-layer-group fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                <h4 class="fw-bold text-dark mb-0">{{ $benefit->title }}</h4>
                                @if ($benefit->status == 'active')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill small fw-bold">
                                        <i class="fa-solid fa-circle-check me-1"></i> مفعل على المتجر
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-muted border border-secondary-subtle px-2.5 py-1 rounded-pill small fw-bold">
                                        <i class="fa-solid fa-circle-xmark me-1"></i> معطل
                                    </span>
                                @endif
                            </div>
                            <p class="text-muted small mb-0 lh-base">
                                {{ $benefit->description ?? 'لا يوجد وصف مدخل لهذا القسم حالياً.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="d-flex align-items-center justify-content-lg-end gap-3 flex-wrap pt-2 pt-lg-0 border-top border-lg-0 border-light-subtle">
                        <!-- Edit Benefit Button -->
                        <button class="btn btn-outline-primary rounded-3 px-3 py-2 fw-semibold edit-benefit d-inline-flex align-items-center gap-1.5 shadow-none"
                            data-id="{{ $benefit->id }}">
                            <i class="fas fa-pen-to-square"></i>
                            <span>تعديل تفاصيل القسم</span>
                        </button>

                        <!-- Status Form -->
                        <form action="{{ route('seller.benefits.updateStatus') }}" method="POST" class="d-inline-flex align-items-center gap-2 m-0">
                            @csrf
                            <input type="hidden" name="benefit_id" value="{{ $benefit->id }}">
                            <div class="form-check form-switch mb-0 d-flex align-items-center gap-2 p-0">
                                <input class="form-check-input cursor-pointer ms-0 me-2" type="checkbox" id="sluster_status" name="benefit_status"
                                    style="width: 2.75rem; height: 1.4rem;"
                                    @if ($benefit->status == 'active') checked @endif>
                                <label class="form-check-label fw-bold text-dark small cursor-pointer" for="sluster_status">
                                    {{ $benefit->status == 'active' ? 'تفعيل القسم' : 'تعطيل القسم' }}
                                </label>
                            </div>
                            <button type="submit" class="btn btn-seller-primary btn-sm rounded-3 px-3 py-1.5 fw-bold shadow-sm">
                                <i class="fa-solid fa-check me-1"></i> حفظ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Elements List Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
        <div class="card-header bg-white py-3.5 px-4 border-bottom border-light-subtle d-flex align-items-center justify-content-between flex-wrap gap-2 card-header-actions">
            <div class="d-flex align-items-center gap-2.5">
                <i class="fa-solid fa-list-check text-plum fs-5"></i>
                <h5 class="fw-bold mb-0 text-dark">عناصر ومميزات القسم</h5>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 small fw-bold">
                    {{ count($benefits_elements) }} عنصر
                </span>
            </div>
            <button id="addElementBtn" class="btn btn-seller-primary px-3.5 py-2 rounded-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>إضافة عنصر جديد</span>
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap" id="elementsTable">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th style="width: 80px;" class="text-center">الأيقونة</th>
                            <th>العنوان</th>
                            <th>الوصف</th>
                            <th style="width: 100px;" class="text-center">ترتيب العرض</th>
                            <th style="width: 120px;" class="text-center pe-4">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($benefits_elements as $index => $element)
                            <tr>
                                <td class="ps-4 text-muted fw-bold small" data-label="#">
                                    {{ $index + 1 }}
                                </td>
                                <td class="text-center" data-label="الأيقونة">
                                    <div class="icon-preview-box shadow-sm mx-auto">
                                        {!! $element->icon !!}
                                    </div>
                                </td>
                                <td data-label="العنوان">
                                    <span class="fw-bold text-dark fs-7 d-block">
                                        {{ Str::limit($element->title, 40) }}
                                    </span>
                                </td>
                                <td data-label="الوصف">
                                    <span class="text-muted small text-wrap d-block" style="max-width: 420px; line-height: 1.4;">
                                        {{ Str::limit($element->description, 70) }}
                                    </span>
                                </td>
                                <td class="text-center" data-label="ترتيب العرض">
                                    <span class="badge bg-light text-dark border px-2.5 py-1.5 rounded-pill font-monospace fw-bold">
                                        {{ $element->order }}
                                    </span>
                                </td>
                                <td class="text-center pe-4" data-label="الإجراءات">
                                    <div class="d-inline-flex align-items-center gap-1.5">
                                        <button class="btn btn-circle btn-primary edit-element text-white shadow-sm"
                                            data-id="{{ $element->id }}" title="تعديل العنصر">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-circle btn-danger delete-element text-white shadow-sm"
                                            data-id="{{ $element->id }}" title="حذف العنصر">
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
                                            <i class="fa-solid fa-box-open text-muted fs-2"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">لا توجد عناصر مضافة في هذا القسم حالياً</h6>
                                        <p class="text-muted small mb-3">ابدأ بإضافة مميزات متجرك لتعزيز تجربة التسوق للزبائن.</p>
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

<!-- Add Element Modal -->
<div class="modal fade" id="addElementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-seller-gradient text-white py-3 px-4">
                <h5 class="modal-title fw-bold fs-6 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-plus-circle"></i>
                    <span>إضافة عنصر جديد</span>
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="addElementForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label for="title" class="form-label fw-bold text-dark small">العنوان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3 py-2" id="title" name="title" placeholder="مثال: شحن سريع ومضمون" required>
                        <div class="invalid-feedback error-title"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description" class="form-label fw-bold text-dark small">الوصف</label>
                        <textarea class="form-control rounded-3" id="description" name="description" rows="3" placeholder="اكتب تفاصيل الميزة بإيجاز..."></textarea>
                        <div class="invalid-feedback error-description"></div>
                    </div>

                    <!-- Font Awesome Instructions Alert -->
                    <div class="alert alert-info border-0 shadow-sm rounded-3 p-3 mb-3 position-relative" style="background-color: #f0f7ff; border-right: 4px solid #0d6efd !important;">
                        <div class="d-flex align-items-start gap-2.5">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-0.5"
                                 style="width: 32px; height: 32px; background: rgba(13, 110, 253, 0.12); color: #0d6efd;">
                                <i class="fa-solid fa-circle-info fs-6"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-dark mb-1 fs-7">طريقة اختيار ونسخ كود الأيقونة (Font Awesome):</h6>
                                <p class="text-muted small mb-2 lh-base">
                                    يمكنك اختيار أيقونة مناسبة من مكتبة <strong>Font Awesome</strong> المجانية، ثم نسخ كود الـ HTML الخاص بها ولصقه في حقل الأيقونة أدناه (مثال: <code>&lt;i class="fa-solid fa-truck-fast"&gt;&lt;/i&gt;</code>).
                                </p>
                                <a href="https://fontawesome.com/search?o=r&m=free" target="_blank" rel="noopener noreferrer" 
                                   class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1.5 shadow-none">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    <span>تصفح أيقونات Font Awesome المجانية</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="icon" class="form-label fw-bold text-dark small">كود الأيقونة (HTML Tag)</label>
                        <input type="text" class="form-control font-monospace rounded-3 py-2 text-start" id="icon" name="icon" placeholder='<i class="fa-solid fa-truck-fast"></i>' dir="ltr">
                        <div class="invalid-feedback error-icon"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="order" class="form-label fw-bold text-dark small">ترتيب العرض</label>
                                <input type="number" class="form-control rounded-3 py-2" id="order" name="order"
                                    value="0" min="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0 py-3 px-4">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-seller-primary rounded-3 px-4 fw-bold shadow-sm">حفظ العنصر</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Element Modal -->
<div class="modal fade" id="editElementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-seller-gradient text-white py-3 px-4">
                <h5 class="modal-title fw-bold fs-6 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>تعديل العنصر</span>
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="editElementForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_element_id" name="id">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label for="edit_title" class="form-label fw-bold text-dark small">العنوان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3 py-2" id="edit_title" name="title" required>
                        <div class="invalid-feedback error-title"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_description" class="form-label fw-bold text-dark small">الوصف</label>
                        <textarea class="form-control rounded-3" id="edit_description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback error-description"></div>
                    </div>

                    <!-- Font Awesome Instructions Alert -->
                    <div class="alert alert-info border-0 shadow-sm rounded-3 p-3 mb-3 position-relative" style="background-color: #f0f7ff; border-right: 4px solid #0d6efd !important;">
                        <div class="d-flex align-items-start gap-2.5">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-0.5"
                                 style="width: 32px; height: 32px; background: rgba(13, 110, 253, 0.12); color: #0d6efd;">
                                <i class="fa-solid fa-circle-info fs-6"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-dark mb-1 fs-7">طريقة اختيار ونسخ كود الأيقونة (Font Awesome):</h6>
                                <p class="text-muted small mb-2 lh-base">
                                    يمكنك اختيار أيقونة مناسبة من مكتبة <strong>Font Awesome</strong> المجانية، ثم نسخ كود الـ HTML الخاص بها ولصقه في حقل الأيقونة أدناه (مثال: <code>&lt;i class="fa-solid fa-truck-fast"&gt;&lt;/i&gt;</code>).
                                </p>
                                <a href="https://fontawesome.com/search?o=r&m=free" target="_blank" rel="noopener noreferrer" 
                                   class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1.5 shadow-none">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    <span>تصفح أيقونات Font Awesome المجانية</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_icon" class="form-label fw-bold text-dark small">كود الأيقونة (HTML Tag)</label>
                        <input type="text" class="form-control font-monospace rounded-3 py-2 text-start" id="edit_icon" name="icon" dir="ltr">
                        <div class="invalid-feedback error-icon"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="edit_order" class="form-label fw-bold text-dark small">ترتيب العرض</label>
                                <input type="number" class="form-control rounded-3 py-2" id="edit_order" name="order"
                                    min="0">
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

<!-- Edit Benefit Modal -->
<div class="modal fade" id="editBenefitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-seller-gradient text-white py-3 px-4">
                <h5 class="modal-title fw-bold fs-6 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>تعديل تفاصيل القسم</span>
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="editBenefitForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_benefit_id" name="id">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label for="edit_benefit_title" class="form-label fw-bold text-dark small">عنوان القسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3 py-2" id="edit_benefit_title" name="title" required>
                        <div class="invalid-feedback error-title"></div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="edit_benefit_description" class="form-label fw-bold text-dark small">وصف القسم <span class="text-danger">*</span></label>
                        <textarea class="form-control rounded-3" id="edit_benefit_description" name="description" rows="3" required></textarea>
                        <div class="invalid-feedback error-description"></div>
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
