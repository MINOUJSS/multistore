<style>
/* ================= SUPPLIER CATEGORIES PAGE MODERN STYLES ================= */
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

.category-thumb-box {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
}

.category-thumb-box img {
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
    #storeCategoriesTable,
    #storeCategoriesTable tbody,
    #storeCategoriesTable tr,
    #storeCategoriesTable td,
    #globalCategoriesTable,
    #globalCategoriesTable tbody,
    #globalCategoriesTable tr,
    #globalCategoriesTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }

    #storeCategoriesTable thead,
    #globalCategoriesTable thead {
        display: none !important;
    }

    #storeCategoriesTable tbody tr,
    #globalCategoriesTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }

    #storeCategoriesTable tbody td,
    #globalCategoriesTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }

    #storeCategoriesTable tbody td:last-child,
    #globalCategoriesTable tbody td:last-child {
        border-bottom: none !important;
    }

    #storeCategoriesTable tbody td::before,
    #globalCategoriesTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
        text-align: right;
    }

    /* Empty state row on mobile */
    #storeCategoriesTable tbody td.empty-cell,
    #storeCategoriesTable tbody td[colspan],
    #globalCategoriesTable tbody td.empty-cell,
    #globalCategoriesTable tbody td[colspan] {
        display: block !important;
        text-align: center !important;
        border: none !important;
        padding: 2.5rem 1rem !important;
    }

    #storeCategoriesTable tbody td.empty-cell::before,
    #storeCategoriesTable tbody td[colspan]::before,
    #globalCategoriesTable tbody td.empty-cell::before,
    #globalCategoriesTable tbody td[colspan]::before {
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
                    <i class="fa-solid fa-shapes text-warning"></i>
                    <span class="fw-semibold">{{ __('تخصيص تصنيفات متجر التوريد بالجملة') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    📁 إدارة تصنيفات وأقسام متجر التوريد 🏷️
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6 text-start">
                    تنظيم وتصنيف المنتجات في أقسام عامة وتخصيص طريقة عرضها بصور مميزة وترتيب مخصص لتسهيل تصفح المتجر للتجار والمشترين بالجملة وزيادة المبيعات.
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
                            <i class="fa-solid fa-folder-tree fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                <h5 class="fw-bold text-dark mb-0">عرض شريط الأقسام على متجر التوريد</h5>
                                @if ($categories_status->value == 'true')
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
                                يمكنك التحكم في ظهور شريط التصنيفات للتجار في الصفحة الرئيسية لمتجر التوريد لتسهيل استعراض البضائع.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="d-flex align-items-center justify-content-lg-end gap-3 flex-wrap pt-2 pt-lg-0 border-top border-lg-0 border-light-subtle">
                        <form action="{{ route('supplier.categories.updateStatus') }}" method="POST" class="d-inline-flex align-items-center gap-2 m-0">
                            @csrf
                            <div class="form-check form-switch mb-0 d-flex align-items-center gap-2 p-0">
                                <input class="form-check-input cursor-pointer ms-0 me-2" type="checkbox" id="categories_status" name="categories_status"
                                    style="width: 2.75rem; height: 1.4rem;"
                                    @if ($categories_status->value == 'true') checked @endif>
                                <label class="form-check-label fw-bold text-dark small cursor-pointer" for="categories_status">
                                    {{ $categories_status->value == 'true' ? 'تفعيل العرض' : 'تعطيل العرض' }}
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

    <!-- Store Categories Card (أقسام متجر التوريد المخصصة) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
        <div class="card-header bg-white py-3.5 px-4 border-bottom border-light-subtle d-flex align-items-center justify-content-between flex-wrap gap-2 card-header-actions">
            <div class="d-flex align-items-center gap-2.5">
                <i class="fa-solid fa-store text-navy fs-5"></i>
                <h5 class="fw-bold mb-0 text-dark">أقسام متجر التوريد (Store Categories)</h5>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 small fw-bold">
                    {{ count($storeCategories) }} قسم
                </span>
            </div>
            <button id="addStoreCategoryBtn" class="btn btn-supplier-primary px-3.5 py-2 rounded-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>إضافة قسم للمتجر</span>
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap" id="storeCategoriesTable">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th style="width: 90px;" class="text-center">الصورة</th>
                            <th>القسم العام المرتبط</th>
                            <th style="width: 110px;" class="text-center">ترتيب العرض</th>
                            <th style="width: 120px;" class="text-center pe-4">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($storeCategories as $index => $storeCategory)
                            <tr>
                                <td class="ps-4 text-muted fw-bold small" data-label="#">
                                    {{ $index + 1 }}
                                </td>
                                <td class="text-center" data-label="الصورة">
                                    @if ($storeCategory->image)
                                        <div class="category-thumb-box shadow-sm mx-auto">
                                            <img src="{{ asset($storeCategory->image) }}" alt="{{ $storeCategory->category->name ?? 'Category' }}">
                                        </div>
                                    @else
                                        <div class="category-thumb-box mx-auto text-muted small">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td data-label="القسم العام المرتبط">
                                    <span class="fw-bold text-dark fs-7 d-block">
                                        {{ $storeCategory->category->name ?? 'قسم غير متوفر' }}
                                    </span>
                                </td>
                                <td class="text-center" data-label="ترتيب العرض">
                                    <span class="badge bg-light text-dark border px-2.5 py-1.5 rounded-pill font-monospace fw-bold">
                                        {{ $storeCategory->order }}
                                    </span>
                                </td>
                                <td class="text-center pe-4" data-label="الإجراءات">
                                    <div class="d-inline-flex align-items-center gap-1.5">
                                        <button class="btn btn-circle btn-primary edit-store-category text-white shadow-sm"
                                            data-id="{{ $storeCategory->id }}" title="تعديل قسم المتجر">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-circle btn-danger delete-store-category text-white shadow-sm"
                                            data-id="{{ $storeCategory->id }}" title="حذف قسم المتجر">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 empty-cell">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3"
                                            style="width: 70px; height: 70px;">
                                            <i class="fa-solid fa-store-slash text-muted fs-2"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">لم يتم تخصيص أقسام لمتجر التوريد بعد</h6>
                                        <p class="text-muted small mb-3">اختر قسماً عاماً وحدد صورته وترتيبه ليظهر في متجر التوريد.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Global Categories Card (الأقسام العامة) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
        <div class="card-header bg-white py-3.5 px-4 border-bottom border-light-subtle d-flex align-items-center justify-content-between flex-wrap gap-2 card-header-actions">
            <div class="d-flex align-items-center gap-2.5">
                <i class="fa-solid fa-sitemap text-navy fs-5"></i>
                <h5 class="fw-bold mb-0 text-dark">الأقسام العامة للمنتجات</h5>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 small fw-bold">
                    {{ count($globalCategories) }} قسم
                </span>
            </div>
            <button id="addGlobalCategoryBtn" class="btn btn-outline-primary px-3.5 py-2 rounded-3 fw-bold shadow-none d-inline-flex align-items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>إضافة قسم عام</span>
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap" id="globalCategoriesTable">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th>الاسم</th>
                            <th>الوصف</th>
                            <th style="width: 140px;">القسم الأب</th>
                            <th style="width: 120px;" class="text-center pe-4">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($globalCategories as $index => $category)
                            <tr>
                                <td class="ps-4 text-muted fw-bold small" data-label="#">
                                    {{ $index + 1 }}
                                </td>
                                <td data-label="الاسم">
                                    <span class="fw-bold text-dark fs-7 d-block">
                                        {{ $category->name }}
                                    </span>
                                </td>
                                <td data-label="الوصف">
                                    <span class="text-muted small text-wrap d-block" style="max-width: 420px; line-height: 1.4;">
                                        {{ Str::limit($category->description, 60) ?? '—' }}
                                    </span>
                                </td>
                                <td data-label="القسم الأب">
                                    @if ($category->parent)
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-pill small fw-semibold">
                                            <i class="fa-solid fa-folder me-1"></i> {{ $category->parent->name }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-muted px-2.5 py-1 rounded-pill small fw-semibold">
                                            قسم رئيسي
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center pe-4" data-label="الإجراءات">
                                    <div class="d-inline-flex align-items-center gap-1.5">
                                        <button class="btn btn-circle btn-primary edit-global-category text-white shadow-sm"
                                            data-id="{{ $category->slug }}" title="تعديل القسم العام">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-circle btn-danger delete-global-category text-white shadow-sm"
                                            data-id="{{ $category->slug }}" title="حذف القسم العام">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 empty-cell">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3"
                                            style="width: 70px; height: 70px;">
                                            <i class="fa-solid fa-folder-open text-muted fs-2"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">لا توجد أقسام عامة مسجلة</h6>
                                        <p class="text-muted small mb-3">أضف أقساماً عامة لتصنيف منتجات متجر التوريد وتنظيمها.</p>
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

<!-- Modals for Global Categories -->
@include('users.suppliers.components.content.pages.sections.categories.inc.modals.global-category')

<!-- Modals for Store Categories -->
@include('users.suppliers.components.content.pages.sections.categories.inc.modals.store-category')

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