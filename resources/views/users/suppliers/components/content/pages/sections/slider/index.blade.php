<style>
/* ================= SUPPLIER SLIDERS PAGE MODERN STYLES ================= */
.text-navy {
    color: #2563eb !important;
}

.bg-supplier-gradient {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%) !important;
}

.btn-supplier-primary {
    background: linear-gradient(135deg, #0f172a 0%, #2563eb 100%);
    color: #ffffff;
    border: none;
    transition: all 0.25s ease;
}

.btn-supplier-primary:hover {
    background: linear-gradient(135deg, #090e1a 0%, #1d4ed8 100%);
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}

.slider-thumb-box {
    width: 86px;
    height: 48px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
}

.slider-thumb-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
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
    #slidersTable,
    #slidersTable tbody,
    #slidersTable tr,
    #slidersTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }

    #slidersTable thead {
        display: none !important;
    }

    #slidersTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }

    #slidersTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }

    #slidersTable tbody td:last-child {
        border-bottom: none !important;
    }

    #slidersTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
        text-align: right;
    }

    /* Empty state row on mobile */
    #slidersTable tbody td.empty-cell,
    #slidersTable tbody td[colspan] {
        display: block !important;
        text-align: center !important;
        border: none !important;
        padding: 2.5rem 1rem !important;
    }

    #slidersTable tbody td.empty-cell::before,
    #slidersTable tbody td[colspan]::before {
        display: none !important;
    }
}
</style>

<div class="container-fluid px-3 px-md-4 py-3">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden bg-supplier-gradient"
        style="border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-images text-warning"></i>
                    <span class="fw-semibold">{{ __('عروض وتخفيضات التوريد بالجملة') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🖼️ إدارة وتخصيص سلايدر متجر التوريد 🎠
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6 text-start">
                    تصميم وإدارة الشرائح الإعلانية وعروض التوريد الكبرى في الصفحة الرئيسية لمتجرك لتشجيع التجار على حجز طلبيات الجملة وعرض أحدث الحاويات والبضائع الواصلة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('supplier.dashboard') }}"
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
                            style="width: 50px; height: 50px; background: linear-gradient(135deg, #0f172a 0%, #2563eb 100%);">
                            <i class="fa-solid fa-photo-film fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                <h5 class="fw-bold text-dark mb-0">عرض شريط السلايدر على متجر التوريد</h5>
                                @if ($slider_status->value == 'true')
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
                                يمكنك التحكم في ظهور أو إخفاء سلايدر البانرات الإعلانية في الصفحة الرئيسية لمتجر التوريد بنقرة واحدة.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="d-flex align-items-center justify-content-lg-end gap-3 flex-wrap pt-2 pt-lg-0 border-top border-lg-0 border-light-subtle">
                        <form action="{{ route('supplier.sliders.updateStatus') }}" method="POST" class="d-inline-flex align-items-center gap-2 m-0">
                            @csrf
                            <div class="form-check form-switch mb-0 d-flex align-items-center gap-2 p-0">
                                <input class="form-check-input cursor-pointer ms-0 me-2" type="checkbox" id="sluster_status" name="slider_status"
                                    style="width: 2.75rem; height: 1.4rem;"
                                    @if ($slider_status->value == 'true') checked @endif>
                                <label class="form-check-label fw-bold text-dark small cursor-pointer" for="sluster_status">
                                    {{ $slider_status->value == 'true' ? 'تفعيل العرض' : 'تعطيل العرض' }}
                                </label>
                            </div>
                            <button type="submit" class="btn btn-supplier-primary btn-sm rounded-3 px-3.5 py-1.5 fw-bold shadow-sm">
                                <i class="fa-solid fa-check me-1"></i> حفظ الإعداد
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sliders Table Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
        <div class="card-header bg-white py-3.5 px-4 border-bottom border-light-subtle d-flex align-items-center justify-content-between flex-wrap gap-2 card-header-actions">
            <div class="d-flex align-items-center gap-2.5">
                <i class="fa-solid fa-film text-navy fs-5"></i>
                <h5 class="fw-bold mb-0 text-dark">قائمة شرائح السلايدر</h5>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 small fw-bold">
                    {{ count($sliders) }} شريحة
                </span>
            </div>
            <button id="addSliderBtn" class="btn btn-supplier-primary px-3.5 py-2 rounded-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>إضافة سلايدر جديد</span>
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap" id="slidersTable">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th style="width: 110px;" class="text-center">الصورة</th>
                            <th style="width: 25%;">العنوان</th>
                            <th>الوصف</th>
                            <th style="width: 100px;" class="text-center">الترتيب</th>
                            <th style="width: 110px;" class="text-center">الحالة</th>
                            <th style="width: 120px;" class="text-center pe-4">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sliders as $index => $slider)
                            <tr>
                                <td class="ps-4 text-muted fw-bold small" data-label="#">
                                    {{ $index + 1 }}
                                </td>
                                <td class="text-center" data-label="الصورة">
                                    @if ($slider->image)
                                        <div class="slider-thumb-box shadow-sm mx-auto">
                                            <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}">
                                        </div>
                                    @else
                                        <div class="slider-thumb-box mx-auto text-muted small">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td data-label="العنوان">
                                    <span class="fw-bold text-dark fs-7 d-block">
                                        {{ Str::limit($slider->title, 35) }}
                                    </span>
                                    @if ($slider->link)
                                        <a href="{{ $slider->link }}" target="_blank" class="small text-navy text-decoration-none d-inline-flex align-items-center gap-1 mt-0.5">
                                            <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.75rem;"></i>
                                            <span style="font-size: 0.78rem;">رابط الشريحة</span>
                                        </a>
                                    @endif
                                </td>
                                <td data-label="الوصف">
                                    <span class="text-muted small text-wrap d-block" style="max-width: 440px; line-height: 1.45;">
                                        {{ Str::limit($slider->description, 70) ?? '—' }}
                                    </span>
                                </td>
                                <td class="text-center" data-label="الترتيب">
                                    <span class="badge bg-light text-dark border px-2.5 py-1.5 rounded-pill font-monospace fw-bold">
                                        {{ $slider->order }}
                                    </span>
                                </td>
                                <td class="text-center" data-label="الحالة">
                                    @if ($slider->status == 'active')
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
                                        <button class="btn btn-circle btn-primary edit-slider text-white shadow-sm"
                                            data-id="{{ $slider->id }}" title="تعديل السلايدر">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-circle btn-danger delete-slider text-white shadow-sm"
                                            data-id="{{ $slider->id }}" title="حذف السلايدر">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 empty-cell">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3"
                                            style="width: 70px; height: 70px;">
                                            <i class="fa-solid fa-images text-muted fs-2"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">لا توجد شرائح سلايدر مضافة حالياً</h6>
                                        <p class="text-muted small mb-3">أضف شرائح إعلانية مميزة لعرض أقوى عروض الجملة والتخفيضات في متجر التوريد.</p>
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

<!-- Add Slider Modal -->
<div class="modal fade" id="addSliderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-supplier-gradient text-white py-3 px-4">
                <h5 class="modal-title fw-bold fs-6 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-plus-circle"></i>
                    <span>إضافة سلايدر جديد</span>
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="addSliderForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label for="title" class="form-label fw-bold text-dark small">العنوان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3 py-2" id="title" name="title" placeholder="مثال: خصم 20% على حاويات الأجهزة الكهرومنزلية" required>
                        <div class="invalid-feedback error-title"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description" class="form-label fw-bold text-dark small">الوصف الترويجي</label>
                        <textarea class="form-control rounded-3" id="description" name="description" rows="3" placeholder="اكتب نبذة مختصرة عن عرض الجملة..."></textarea>
                        <div class="invalid-feedback error-description"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image" class="form-label fw-bold text-dark small">صورة السلايدر <span class="text-danger">*</span></label>
                        <input type="file" class="form-control rounded-3 py-2" id="image" name="image" accept="image/*" required>
                        <div class="invalid-feedback error-image"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="link" class="form-label fw-bold text-dark small">الرابط الموجه (URL)</label>
                        <input type="text" class="form-control rounded-3 py-2 text-start" id="link" name="link" placeholder="https://example.com/product" dir="ltr">
                        <div class="invalid-feedback error-link"></div>
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
                                <label for="status" class="form-label fw-bold text-dark small">حالة السلايدر</label>
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
                    <button type="submit" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">حفظ السلايدر</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Slider Modal -->
<div class="modal fade" id="editSliderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-supplier-gradient text-white py-3 px-4">
                <h5 class="modal-title fw-bold fs-6 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>تعديل السلايدر</span>
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="editSliderForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_slider_id" name="id">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label for="edit_title" class="form-label fw-bold text-dark small">العنوان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3 py-2" id="edit_title" name="title" required>
                        <div class="invalid-feedback error-title"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_description" class="form-label fw-bold text-dark small">الوصف الترويجي</label>
                        <textarea class="form-control rounded-3" id="edit_description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback error-description"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_image" class="form-label fw-bold text-dark small">تغيير صورة السلايدر</label>
                        <input type="file" class="form-control rounded-3 py-2" id="edit_image" name="image" accept="image/*">
                        <div class="invalid-feedback error-image"></div>
                        <div class="mt-2.5 p-2 bg-light rounded-3" id="current_image_container">
                            <span class="text-muted small fw-bold d-block mb-1.5">الصورة الحالية المعروضة:</span>
                            <img id="current_image_preview" src=""
                                style="max-width: 220px; max-height: 120px; object-fit: cover;" class="rounded-3 shadow-sm border">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_link" class="form-label fw-bold text-dark small">الرابط الموجه (URL)</label>
                        <input type="text" class="form-control rounded-3 py-2 text-start" id="edit_link" name="link" dir="ltr">
                        <div class="invalid-feedback error-link"></div>
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
                                <label for="edit_status" class="form-label fw-bold text-dark small">حالة السلايدر</label>
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
                    <button type="submit" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">حفظ التغييرات</button>
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
