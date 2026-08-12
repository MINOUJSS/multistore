<style>
    #add_digital_dropzone {
        margin-top: 10px;
        height: 100px;
        width: 100px;
        cursor: pointer;
        border: 2px dashed #706c6cfd;
        border-radius: 5px;
        align-content: center;
        text-align: center;
        padding: 30px;
        transition: 0.3s;
    }

    #edit_digital_dropzone {
        margin-top: 10px;
        height: 100px;
        width: 100px;
        cursor: pointer;
        border: 2px dashed #706c6cfd;
        border-radius: 5px;
        align-content: center;
        text-align: center;
        padding: 30px;
        transition: 0.3s;
    }

    #add_digital_dropzone:hover {
        background: #f8f9fa;
    }

    #edit_digital_dropzone:hover {
        background: #f8f9fa;
    }

    #add_digitalPreview {
        margin-top: 10px;
        height: 100px !important;
        width: 100% !important;
    }

    #edit_digitalPreview {
        margin-top: 10px;
        height: 100px !important;
        width: 100% !important;
    }

    /* ================================
   FORCE FULL WIDTH TABLE (MOBILE)
   ================================ */
    @media (max-width: 991.98px) {

        /* 1️⃣ كسر قيود container */
        .container {
            max-width: 100% !important;
            padding-left: 0px !important;
            padding-right: 0rem !important;
            margin: 0 !important;
            align-content: center;
        }

        .container-fluid {
            max-width: 100% !important;
            padding-left: 0rem !important;
            padding-right: 0rem !important;
            margin: 0 !important;
            align-content: center;
        }

        /* 2️⃣ card بدون حواف جانبية */
        .card {
            border-radius: 5px !important;
            margin-left: 0.5rem !important;
            margin-right: 0.5rem !important;
        }

        .card-body {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }

        /* 3️⃣ table-responsive يملأ الشاشة */
        .table-responsive {
            width: 90vw !important;
            /* margin-left: calc(-50vw + 50%) !important; */
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: auto !important;
        }

        /* 4️⃣ الجدول نفسه */
        table.table {
            width: 100% !important;
            min-width: 900px;
            /* يسمح بالتمرير */
            margin: 0 !important;
        }

        th,
        td {
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
        }

        /* 5️⃣ منع الفراغ الوهمي */
        body {
            overflow-x: hidden;
        }
    }
</style>
<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-boxes-stacked text-warning"></i>
                    <span class="fw-semibold">{{ __('إدارة كتالوج المنتجات') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    إدارة وتتبع منتجات المتجر 📦
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    إضافة وإدارة منتجاتك، تنظيم الأسعار والمخزون والتصنيفات، ومتابعة حالة العرض بطريقة عصرية وسريعة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <button type="button"
                        class="btn btn-warning text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addModal" onclick="ClearValidationErrors();">
                        <i class="fas fa-plus"></i>
                        <span>إضافة منتج جديد</span>
                    </button>
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

    <!-- Statistical Indicator Cards Grid -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Products -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold">
                            <i class="fa-solid fa-boxes-stacked fs-5"></i>
                        </span>
                        <span class="badge bg-light text-secondary rounded-pill small">الكل</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $productStats['total'] ?? $products->total() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">إجمالي المنتجات</p>
                </div>
            </div>
        </div>

        <!-- 2. Active Products -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-success-subtle text-success fw-bold">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success rounded-pill small">نشط</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $productStats['active'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">منتجات نشطة</p>
                </div>
            </div>
        </div>

        <!-- 3. Categories -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-primary-subtle text-primary fw-bold">
                            <i class="fa-solid fa-tags fs-5"></i>
                        </span>
                        <span class="badge bg-primary-subtle text-primary rounded-pill small">الأصناف</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $productStats['categories'] ?? count($categories) }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">التصنيفات المتاحة</p>
                </div>
            </div>
        </div>

        <!-- 4. Physical Products -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-info-subtle text-info fw-bold">
                            <i class="fa-solid fa-box-open fs-5"></i>
                        </span>
                        <span class="badge bg-info-subtle text-info rounded-pill small">مادي</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $productStats['physical'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">منتجات مادية</p>
                </div>
            </div>
        </div>

        <!-- 5. Digital Products -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-secondary-subtle text-secondary fw-bold">
                            <i class="fa-solid fa-file-arrow-down fs-5"></i>
                        </span>
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill small">رقمي</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $productStats['digital'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">منتجات رقمية</p>
                </div>
            </div>
        </div>

        <!-- 6. Out of stock -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-warning-subtle text-warning fw-bold">
                            <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                        </span>
                        <span class="badge bg-warning-subtle text-warning rounded-pill small">المخزون</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $productStats['out_of_stock'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">منخفض / نفذ المخزون</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Control Panel -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-3.5 p-md-4">
            <div class="row g-2 g-md-3">
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-semibold text-secondary small">
                        <i class="fa-solid fa-tags me-1 text-plum"></i> التصنيف
                    </label>
                    <select id="categoryFilter" class="form-select rounded-3 border-light-subtle shadow-none">
                        <option value="">جميع التصنيفات</option>
                        @foreach ($categories as $category)
                            @if ($category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-semibold text-secondary small">
                        <i class="fa-solid fa-filter me-1 text-plum"></i> الحالة
                    </label>
                    <select id="statusFilter" class="form-select rounded-3 border-light-subtle shadow-none">
                        <option value="all">جميع الحالات</option>
                        <option value="active">نشط</option>
                        <option value="inactive">غير نشط</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold text-secondary small">
                        <i class="fa-solid fa-magnifying-glass me-1 text-plum"></i> البحث المباشر
                    </label>
                    <input id="searchFilter" type="text"
                        class="form-control rounded-3 border-light-subtle shadow-none"
                        placeholder="ابحث باسم المنتج، الكود...">
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end mt-2 mt-md-0">
                    <button id="searchBtn"
                        class="btn btn-seller-primary w-100 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 py-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>بحث</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table Container -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
        <div
            class="card-header bg-white border-0 py-3.5 px-4 d-flex align-items-center justify-content-between border-bottom border-light">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-boxes-stacked text-plum fs-5"></i>
                <h5 class="fw-bold mb-0 text-dark fs-6">قائمة منتجات المتجر</h5>
                <button id="bulkDeleteBtn"
                    class="btn btn-danger btn-sm d-none shadow-sm fw-semibold ms-3 rounded-pill px-3 py-1">
                    <i class="fas fa-trash me-1"></i> حذف المحددة (<span id="selectedCount">0</span>)
                </button>
            </div>
            <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill small fw-semibold">
                إجمالي المعروض: {{ $products->count() }} منتج
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle text-secondary small text-uppercase fw-bold border-bottom">
                        <tr>
                            <th width="40" class="ps-4"><input type="checkbox" id="selectAllProducts"
                                    class="form-check-input"></th>
                            <th class="text-nowrap">صورة</th>
                            <th class="text-nowrap">اسم المنتج</th>
                            <th class="text-nowrap">التصنيف</th>
                            <th class="text-nowrap">السعر</th>
                            <th class="text-nowrap">التكلفة</th>
                            <th class="text-nowrap">المخزون</th>
                            <th class="text-nowrap">نوع المنتج</th>
                            <th class="text-nowrap">التوصيل المجاني</th>
                            <th class="text-nowrap">الحالة</th>
                            <th class="pe-4 text-end text-nowrap">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="productList">
                        @foreach ($products as $product)
                            <tr>
                                <td class="ps-4"><input type="checkbox" class="form-check-input product-checkbox"
                                        value="{{ $product->id }}"></td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset($product->image) }}" alt="Product"
                                            class="rounded-3 border" width="48" height="48"
                                            style="object-fit: cover;">
                                    @else
                                        <div class="avatar avatar-md rounded-3 bg-light text-secondary fw-bold">
                                            <i class="fa-solid fa-box"></i>
                                        </div>
                                    @endif
                                </td>
                                <td style="max-width: 220px;">
                                    <span class="fw-bold text-dark d-inline-block text-truncate align-middle"
                                        style="max-width: 200px;" title="{{ $product->name }}">
                                        {{ \Illuminate\Support\Str::limit($product->name, 35, '...') }}
                                    </span>
                                </td>
                                <td><span
                                        class="badge bg-light text-dark border fw-semibold px-2.5 py-1.5 rounded-2">{{ get_seller_product_category($product->id) }}</span>
                                </td>
                                <td><span
                                        class="fw-bold text-plum">{{ get_seller_product_price($product->id) }}</span>
                                </td>
                                @if ($product->product_type == 'physical')
                                    <td><span class="text-secondary">{{ $product->cost }}</span></td>
                                    <td><span
                                            class="badge {{ $product->qty > 0 ? 'bg-info-subtle text-info border border-info' : 'bg-warning-subtle text-warning border border-warning' }} rounded-pill px-2.5 py-1">{{ $product->qty }}</span>
                                    </td>
                                @else
                                    <td><span class="text-muted small">غير مكلف</span></td>
                                    <td><span
                                            class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1">غير
                                            محدود</span></td>
                                @endif
                                <td><span
                                        class="badge bg-light text-secondary border px-2.5 py-1 rounded-2">{{ $product->product_type == 'physical' ? 'مادي' : 'رقمي' }}</span>
                                </td>
                                <td>{!! seller_p_has_free_shipping($product->id) == 'نعم'
                                    ? '<span class="badge bg-success-subtle text-success border border-success px-2.5 py-1 rounded-pill">نعم</span>'
                                    : '<span class="badge bg-light text-muted border px-2.5 py-1 rounded-pill">لا</span>' !!}</td>
                                <td><span
                                        class="badge {{ $product->status == 'active' ? 'bg-success-subtle text-success border border-success' : 'bg-danger-subtle text-danger border border-danger' }} px-3 py-1.5 rounded-pill fw-bold">{{ $product->status == 'active' ? 'نشط' : 'غير نشط' }}</span>
                                </td>
                                <td class="pe-4 text-end text-nowrap">
                                    <button value="{{ $product->id }}"
                                        class="btn btn-sm btn-outline-primary rounded-2 editproduct px-2.5 py-1 me-1"
                                        data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="fas fa-edit me-1"></i> تعديل
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-2 delete-product px-2.5 py-1"
                                        value="{{ $product->id }}" data-id="{{ $product->id }}">
                                        <i class="fas fa-trash me-1"></i> حذف
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="p-4 border-top border-light d-flex justify-content-center">
                    {{ $products->links('vendor.pagination.dashboard-pagination') }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .bg-plum-subtle {
            background-color: rgba(164, 12, 114, 0.1);
        }

        .text-plum {
            color: #a40c72 !important;
        }

        .btn-seller-primary {
            background: linear-gradient(135deg, #a40c72 0%, #85095c 100%);
            color: #ffffff;
            border: none;
        }

        .btn-seller-primary:hover {
            background: linear-gradient(135deg, #85095c 0%, #660646 100%);
            color: #ffffff;
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

        .bg-seller-header {
            background: linear-gradient(135deg, #a40c72 0%, #790b54 100%) !important;
            color: #ffffff !important;
        }

        .btn-seller-primary {
            background: linear-gradient(135deg, #a40c72 0%, #790b54 100%) !important;
            color: #ffffff !important;
            border: none !important;
        }

        .btn-seller-primary:hover {
            background: linear-gradient(135deg, #790b54 0%, #5b073e 100%) !important;
            color: #ffffff !important;
        }

        .btn-outline-plum {
            color: #a40c72 !important;
            border-color: #a40c72 !important;
        }

        .btn-outline-plum:hover {
            background-color: #a40c72 !important;
            color: #ffffff !important;
        }
    </style>

    {{-- add product modela  --}}


    <!-- add product attribut Modal -->
    <div class="modal fade" id="addProductAttributModal" tabindex="-1" aria-labelledby="addAtrributModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إضافة خاصية</h5>
                    <div id="modalButtonContainer" style="position: absolute;left:0;margin-left:15px;"></div>
                </div>
                <div class="modal-body">
                    <form id="attributeForm" method="post">
                        @csrf
                        <div class="col-md-12">
                            <label for="attribute_name" class="form-label">إسم الخاصية</label>
                            <input type="text" class="form-control" id="attribute_name" name="attribute_name"
                                placeholder="الماركة،النوع،الحجم...إلخ">
                            <span class="text-danger error-atrribute_name"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel_atrribute">إلغاء</button> --}}
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#editModal">إلغاء</button>
                    <button type="button" class="btn btn-seller-primary" id="save_atrribute" data-bs-toggle="modal"
                        data-bs-target="#editModal">حفظ</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add product Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">إضافة منتج</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--start-->
                    <div id="addFormErrors"></div>
                    <form id="addForm" method="POST" enctype="application/x-www-form-urlencoded" class="row g-3">
                        @csrf
                        <div class="col-12 bg-seller-header rounded p-2 text-center">معلومات المنتج</div>
                        <input type="hidden" name="add_product_id" id="add_product_id">
                        <div class="col-md-6">
                            <label for="add_inputProductType" class="form-label">نوع المنتج</label>
                            <select id="add_inputProductType" class="form-select" name="add_product_type">
                                <option value="physical" id="add_product_type_physical">مادي</option>
                                <option value="digital" id="add_product_type_digital">رقمي</option>
                            </select>
                            <span class="text-danger error-product_type"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="add_product_name" class="form-label">إسم المنتج</label>
                            <input type="text" class="form-control" id="add_product_name"
                                name="add_product_name">
                            <span class="text-danger error-add_product_name error-validation"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="inputCategory" class="form-label">الأصناف</label>
                            <select id="add_inputCategory" class="form-select" name="add_product_category">
                                <option value="null"selected>اختر صنف</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" id="add_p_cat_{{ $category->id }}">
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-add_product_category error-validation"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="inputCost" class="form-label">التكلفة</label>
                            <input type="text" class="form-control" id="add_inputCost" name="add_product_cost"
                                required>
                            <span class="text-danger error-add_product_cost error-validation"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="inputPrice" class="form-label">السعر</label>
                            <input type="text" class="form-control" id="add_inputPrice" name="add_product_price"
                                required>
                            <span class="text-danger error-add_product_price error-validation"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="inputQty" class="form-label">الكمية المتوفرة</label>
                            <input type="text" class="form-control" id="add_inputQty" name="add_product_qty"
                                required>
                            <span class="text-danger error-add_product_qty error-validation"></span>
                        </div>
                        {{-- <div class="col-md-6">
                            <label for="inputMiniQty" class="form-label">أقل كمية ممكنة للطلب</label> --}}
                        <input type="hidden" class="form-control" id="add_inputMinQty" name="add_product_min_qty"
                            required value="1">
                        {{-- <span class="text-danger error-add_product_min_qty error-validation"></span>
                        </div> --}}
                        <div class="col-md-6">
                            <label for="inputMiniQty" class="form-label">تقييم المنتج</label>
                            <input type="number" class="form-control" id="add_inputReview"
                                name="add_product_review" value="5" min="1" max="5">
                            <span class="text-danger error-add_product_review error-validation"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="inputCondition" class="form-label">حالة المنتج</label>
                            <select id="add_inputCondition" class="form-select" name="add_product_condition">
                                <option value="new" id="add_product_status_new">جديد</option>
                                <option value="used" id="add_product_status_used">مستعمل</option>
                                <option value="refurbished" id="add_product_status_refurbished">تم تجديده</option>
                                <option value="old" id="add_product_status_old">قديم</option>
                            </select>
                            <span class="text-danger error-add_product_condition error-validation"></span>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="add_free_shipping" id="add_free_shipping"
                                    type="checkbox" checked>
                                <label class="form-check-label" for="add_free_shipping">توصيل مجاني</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="add_status" id="add_product_status"
                                    type="checkbox" checked>
                                <label class="form-check-label" for="status">عرض المنتج</label>
                            </div>
                        </div>
                        <div class="col-12 bg-seller-header rounded p-2 text-center">الصورة و المعرض</div>
                        <div class="col-md-6">
                            <ul class="p-3" style="float:right;">
                                <li>
                                    الصورة الرئيسية
                                </li>
                                <li>المقياس:450X450</li>
                                <li>الحجم:2MB</li>

                            </ul>
                            <div id="add_dropzone" onclick="add_browsdialog()" onchange="add_previewLogo(event)">
                                <i class="fa fa-cloud-upload"></i>
                                <input type="file" name="add_image"class="form-control" id="add_product_image"
                                    accept="image/*" style="display: none;">
                            </div>
                        </div>
                        {{-- <div class="col-12"> --}}
                        {{-- <span class="text-danger error-add_image error-validation"></span> --}}
                        {{-- </div>              --}}
                        <div class=" col-md-6">
                            <div id="add_logoPreview" class="preview"
                                style="background-size: contain; background-repeat: no-repeat;">
                            </div>
                            <span class="text-danger error-add_image error-validation"></span>
                        </div>
                        <hr>
                        <h5 class="mb-3 text-center">صور إضافية للمنتج</h5>
                        <div class="col-md-12">
                            <div id="add_multi_image" class="dropzone dragover" onclick="add_browsdialogmultifile()">
                                <i class="fa fa-cloud-upload"></i>
                                <input type="file" name="add_images[]"class="form-control" id="add_product_images"
                                    accept="image/*" multiple style="display: none;">
                            </div>
                            <span class="text-danger error-add_product_images error-validation"></span>
                            <div class=" col-md-12">
                                <div class="add_images_container" id="add_images_container">

                                </div>
                            </div>
                        </div>
                        <section id="digital_file_section" style="display: none;">
                            <div class="col-12 bg-seller-header rounded p-2 text-center">الملف الرقمي</div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="p-3" style="float:right;">
                                        <li>الملف الرئيسي</li>
                                        <li>الصيغ المسموحة: ZIP, PDF, MP4</li>
                                        <li>الحجم الأقصى: 50MB</li>
                                    </ul>

                                    <div id="add_digital_dropzone1" onclick="add_browsDigitalFile()"
                                        onchange="add_previewDigitalFile(event)">
                                        {{-- <i class="fa fa-cloud-upload"></i> --}}
                                        <input type="file" name="add_digital_file" class="form-control"
                                            id="addDigitalFile" accept=".zip,.pdf,.mp4" style="display: none;">
                                        <input type="hidden" name="digital_temp_id" id="add_digital_temp_id">
                                    </div>
                                </div>

                                {{-- <div class="col-md-6">
                            <div id="add_digitalPreview" class="preview"
                                style="display:flex; align-items:center; justify-content:center; height:150px; border:1px dashed #ccc;">
                                <span>لم يتم اختيار ملف</span>
                            </div>
                            <span class="text-danger error-add_digital_file error-validation"></span>
                        </div>
                        </div> --}}
                        </section>

                        <div class="col-12 bg-seller-header rounded p-2 text-center">فيديوهات المنتج</div>
                        <div class="container mb-5">
                            <div class="d-flex justify-content-center m-3"><a class="btn btn-seller-primary"
                                    id="add_add_video"><i class="fa fa-add"></i></a></div>
                            <div class="container" id="add_product_video">
                                <!---->

                                <!---->
                            </div>
                        </div>
                        <section id="add_attribute_color_section">

                            <div class="col-12 bg-seller-header rounded p-2 text-center">خصائص المنتج</div>
                            <div class="container mb-5">
                                <div class="d-flex justify-content-center m-3"><a class="btn btn-seller-primary"
                                        data-bs-toggle="modal" data-bs-target="#addProductAttributModal"
                                        onclick="returnToForm('addForm')"><i class="fa fa-add"></i>إضافة خاصية
                                        جديدة</a>
                                </div>
                                <div class="d-flex justify-content-center m-3"><a class="btn btn-seller-primary"
                                        id="add_add_attribute"><i class="fa fa-add"></i></a></div>
                                <div class="container" id="add_product_attribute">
                                    <!---->

                                    <!---->
                                </div>
                            </div>

                            <div class="col-12 bg-seller-header rounded p-2 text-center">ألوان المنتج</div>
                            <div class="container mb-5">
                                <div class="d-flex justify-content-center m-3"><a class="btn btn-seller-primary"
                                        id="add_add_variation"><i class="fa fa-add"></i></a></div>
                                <div class="container" id="add_product_variation">
                                </div>
                            </div>

                            <div class="col-12 bg-seller-header rounded p-2 text-center">تخفيضات للمنتج</div>
                            <div class="container mb-5">
                                <div class="d-flex justify-content-center m-3"><a class="btn btn-seller-primary"
                                        id="add_add_discount" onclick="add_add_discount();"><i
                                            class="fa fa-add"></i></a>
                                </div>
                                <div class="container" id="add_product_discount">
                                </div>
                            </div>

                        </section>

                        <div class="col-12 bg-seller-header rounded p-2 text-center">وصف المنتج</div>
                        <div class="col-12">
                            <label for="add_inputShortDescription" class="form-label">وصف قصير عن المنتج</label>
                            <textarea class="form-control" name="add_product_short_description" rows="5" id="add_inputShortDescription"></textarea>
                            <span class="text-danger error-add_product_short_description error-validation"></span>
                        </div>
                        <!--    -->
                        <div class="col-12 mb-5 pb-5">
                            <label for="add_inputDescription" class="form-label">وصف المنتج</label>
                            <input type="hidden" name="add_product_description" id="add_product_description">
                            <!-- Create the editor container -->
                            <div class="" id="add_editor">
                            </div>
                            <span class="text-danger error-add_product_description error-validation"></span>
                        </div>
                    </form>
                    <!--end-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-seller-primary" id="save_product">حفظ</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit product Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="editFormErrors"></div>
                    <form id="editForm" method="POST" enctype="application/x-www-form-urlencoded" class="row g-3">
                        @csrf
                        <div class="col-12 bg-seller-header rounded p-2 text-center">معلومات المنتج</div>
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="col-md-6">
                            <label for="edit_inputProductType" class="form-label">نوع المنتج</label>
                            <select id="edit_inputProductType" class="form-select" name="product_type">
                                <option value="physical" id="edit_product_type_physical">مادي</option>
                                <option value="digital" id="edit_product_type_digital">رقمي</option>
                            </select>
                            <span class="text-danger error-product_type"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="product_name" class="form-label">إسم المنتج</label>
                            <input type="text" class="form-control" id="product_name" name="product_name">
                            <span class="text-danger error-product_name"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="inputCategory" class="form-label">الأصناف</label>
                            <select id="inputCategory" class="form-select" name="product_category">
                                {{-- <option value="null"selected>اختر صنف</option> --}}
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" id="p_cat_{{ $category->id }}">
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-product_category"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="inputCost" class="form-label">التكلفة</label>
                            <input type="text" class="form-control" id="edit_inputCost" name="product_cost"
                                required>
                            <span class="text-danger error-product_cost"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="inputPrice" class="form-label">السعر</label>
                            <input type="text" class="form-control" id="inputPrice" name="product_price"
                                required>
                            <span class="text-danger error-product_price"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="inputQty" class="form-label">الكمية المتوفرة</label>
                            <input type="text" class="form-control" id="edit_inputQty" name="product_qty"
                                required>
                            <span class="text-danger error-product_qty"></span>
                        </div>
                        <div class="col-md-6" style="display: none;">
                            <label for="inputMiniQty" class="form-label">أقل كمية ممكنة للطلب</label>
                            <input type="text" class="form-control" id="edit_inputMinQty" name="product_min_qty"
                                required>
                            <span class="text-danger error-product_min_qty"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="inputMiniQty" class="form-label">تقييم المنتج</label>
                            <input type="number" class="form-control" id="inputReview" name="product_review"
                                min="1" max="5">
                            <span class="text-danger error-product_review error-validation"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_inputCondition" class="form-label">حالة المنتج</label>
                            <select id="edit_inputCondition" class="form-select" name="product_condition">
                                <option value="new" id="edit_product_status_new">جديد</option>
                                <option value="used" id="edit_product_status_used">مستعمل</option>
                                <option value="refurbished" id="edit_product_status_refurbished">تم تجديده</option>
                                <option value="old" id="edit_product_status_old">قديم</option>
                            </select>
                            <span class="text-danger error-product_category"></span>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="free_shipping" id="edit_free_shipping"
                                    type="checkbox" checked>
                                <label class="form-check-label" for="free_shipping">توصيل مجاني</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="status" id="product_status" type="checkbox"
                                    checked>
                                <label class="form-check-label" for="status">عرض المنتج</label>
                            </div>
                        </div>
                        <div class="col-12 bg-seller-header rounded p-2 text-center">الصورة و المعرض</div>
                        <div class="col-md-6">
                            <ul class="p-3" style="float:right;">
                                <li>
                                    الصورة الرئيسية
                                </li>
                                <li>المقياس:450X450</li>
                                <li>الحجم:2MB</li>

                            </ul>
                            <div id="dropzone" onclick="browsdialog()" onchange="previewLogo(event)">
                                <i class="fa fa-cloud-upload"></i>
                                <input type="file" name="image"class="form-control" id="product_image"
                                    accept="image/*" style="display: none;">
                            </div>
                            <span class="text-danger error-product_image"></span>
                        </div>
                        <div class=" col-md-6">
                            <div id="logoPreview" class="preview"
                                style="background-size: contain; background-repeat: no-repeat;">
                            </div>
                        </div>
                        <hr>
                        <h5 class="mb-3 text-center">صور إضافية للمنتج</h5>
                        <div class="col-md-12">
                            <div id="multi_image" class="dropzone dragover" onclick="browsdialogmultifile()">
                                <i class="fa fa-cloud-upload"></i>
                                <input type="file" name="images[]"class="form-control" id="product_images"
                                    accept="image/*" multiple style="display: none;">
                            </div>
                            <span class="text-danger error-product_images"></span>
                            <div class=" col-md-12">
                                <div class="images_container" id="images_container">
                                    {{-- <div class="image">
                      <img src="{{asset('asset/site/defaulte/img/cta-bg.jpg')}}" alt="image">
                        <span>&times</span>
                    </div>
                    <div class="image">
                    <img src="{{asset('asset/site/defaulte/img/cta-bg.jpg')}}" alt="image">
                      <span>&times</span>
                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <section id="edit_digital_file_section" style="display: none;">
                            <div class="col-12 bg-seller-header rounded p-2 text-center">الملف الرقمي</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="p-3" style="float:right;">
                                        <li>الملف الرئيسي</li>
                                        <li>الصيغ المسموحة: ZIP, PDF, MP4</li>
                                        <li>الحجم الأقصى: 50MB</li>
                                    </ul>

                                    <div id="edit_digital_dropzone1" onclick="edit_browsDigitalFile()"
                                        onchange="edit_previewDigitalFile(event)">
                                        {{-- <i class="fa fa-cloud-upload"></i> --}}
                                        <input type="file" name="digital_file" class="form-control"
                                            id="editDigitalFile" accept=".zip,.pdf,.mp4" style="display: none;">
                                        <input type="hidden" name="digital_temp_id" id="edit_digital_temp_id">
                                    </div>
                                </div>

                                {{-- <div class="col-md-6">
                            <div id="edit_digitalPreview" class="preview"
                                style="display:flex; align-items:center; justify-content:center; height:150px; border:1px dashed #ccc;">
                                <span>لم يتم اختيار ملف</span>
                            </div>
                            <span class="text-danger error-edit_digital_file error-validation"></span>
                        </div> --}}
                            </div>
                        </section>
                        <div class="col-12 bg-seller-header rounded p-2 text-center">فيديوهات المنتج</div>
                        <div class="container mb-5">
                            <div class="d-flex justify-content-center m-3"><a class="btn btn-seller-primary"
                                    id="add_video"><i class="fa fa-add"></i></a></div>
                            <div class="container" id="product_video">
                                <!---->

                                <!---->
                            </div>
                        </div>

                        <div class="col-12 bg-seller-header rounded p-2 text-center">خصائص المنتج</div>
                        <div class="container mb-5">
                            <div class="d-flex justify-content-center m-3"><a class="btn btn-seller-primary"
                                    data-bs-toggle="modal" data-bs-target="#addProductAttributModal"
                                    onclick="returnToForm('editForm')"><i class="fa fa-add"></i>إضافة خاصية جديدة</a>
                            </div>
                            <div class="d-flex justify-content-center m-3"><a class="btn btn-seller-primary"
                                    id="add_attribute"><i class="fa fa-add"></i></a></div>
                            <div class="container" id="product_attribute">
                                <!---->

                                <!---->
                            </div>
                        </div>
                        <div class="col-12 bg-seller-header rounded p-2 text-center">ألوان المنتج</div>
                        <div class="container mb-5">
                            <div class="d-flex justify-content-center m-3"><a class="btn btn-seller-primary"
                                    id="add_variation"><i class="fa fa-add"></i></a></div>
                            <div class="container" id="product_variation">
                                {{--
                                
                                --}}
                            </div>
                        </div>

                        <div class="col-12 bg-seller-header rounded p-2 text-center">تخفيضات للمنتج</div>
                        <div class="container mb-5">
                            <div class="d-flex justify-content-center m-3"><a class="btn btn-seller-primary"
                                    id="add_discount" onclick="add_discount();"><i class="fa fa-add"></i></a></div>
                            <div class="container" id="product_discount">
                                {{--
                                
                                --}}
                            </div>
                        </div>

                        <div class="col-12 bg-seller-header rounded p-2 text-center">وصف المنتج</div>
                        <div class="col-12">
                            <label for="inputShortDescription" class="form-label">وصف قصير عن المنتج</label>
                            <textarea class="form-control" name="product_short_description" rows="5" id="inputShortDescription"></textarea>
                            <span class="text-danger error-product_short_description error-validation"></span>
                        </div>
                        <!--    -->
                        <div class="col-12 mb-5 pb-5">
                            <label for="inputDescription" class="form-label">وصف المنتج</label>
                            <input type="hidden" name="product_description" id="product_description">
                            <!-- Create the editor container -->
                            <div class="" id="editor">
                            </div>
                            <span class="text-danger error-product_description error-validation"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-seller-primary" id="save">حفظ</button>
                </div>
            </div>
        </div>
    </div>

</div>
