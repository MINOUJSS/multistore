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

<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-map-location-dot text-warning"></i>
                    <span class="fw-semibold">{{ __('إدارة تسعير وولايات الشحن') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    تسعير الشحن والتوصيل للولايات 🚚
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    ضبط أسعار الشحن المنزلي والمكتبي، التكاليف الإضافية وتفعيل التوصيل لكل ولاية من الولايات الـ 58
                    بطريقة سلسة ومنظمة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('seller.shipping') }}"
                        class="btn btn-light text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fas fa-arrow-right"></i>
                        <span>الرجوع لشركات الشحن</span>
                    </a>
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
        <!-- 1. Total Wilayas -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold">
                            <i class="fa-solid fa-map-location-dot fs-5"></i>
                        </span>
                        <span class="badge bg-light text-secondary rounded-pill small">الكل</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ count($prices) }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">إجمالي ولايات الوطن</p>
                </div>
            </div>
        </div>

        <!-- 2. Active Wilayas -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-success-subtle text-success fw-bold">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success rounded-pill small">مفعل</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">
                        {{ $prices->where('shipping_available_to_wilaya', 1)->count() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">ولايات مفعل بها الشحن</p>
                </div>
            </div>
        </div>

        <!-- 3. Home Delivery Active -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-info-subtle text-info fw-bold">
                            <i class="fa-solid fa-house-chimney-user fs-5"></i>
                        </span>
                        <span class="badge bg-info-subtle text-info rounded-pill small">للمنزل</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">
                        {{ $prices->where('shipping_available_to_home', 1)->count() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">ولايات بها توصيل للمنزل</p>
                </div>
            </div>
        </div>

        <!-- 4. Desk Delivery Active -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-warning-subtle text-warning fw-bold">
                            <i class="fa-solid fa-building-user fs-5"></i>
                        </span>
                        <span class="badge bg-warning-subtle text-warning rounded-pill small">للمكتب</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">
                        {{ $prices->where('shipping_available_to_stop_desck', 1)->count() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">ولايات بها توصيل للمكتب</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing Form & Table Container -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
        <div
            class="card-header bg-white border-0 py-3.5 px-3 px-md-4 d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom border-light">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold me-1"
                    style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-calculator fs-6"></i>
                </span>
                <h5 class="fw-bold mb-0 text-dark fs-6">جدول أسعار الشحن والتوصيل لولايات الوطن</h5>
            </div>
            <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill small fw-semibold">
                <i class="fa-solid fa-truck-moving me-1 text-plum"></i> 58 ولاية
            </span>
        </div>
        <div class="card-body p-0 p-md-3">
            <form action="{{ route('seller.shipping.update') }}" method="POST">
                @csrf
                <div class="table-responsive shipping-edit-table-responsive custom-table-scroll">
                    <table class="table table-hover align-middle mb-0 shipping-edit-table">
                        <thead class="bg-light-subtle text-secondary small text-uppercase fw-bold border-bottom">
                            <tr>
                                <th width="50" class="ps-4 text-nowrap">#</th>
                                <th width="60" class="text-center text-nowrap">
                                    <div class="d-flex flex-column align-items-center gap-1"
                                        title="تحديد / إلغاء تحديد تفعيل الولاية للكل">
                                        <span class="small opacity-75">الولايات</span>
                                        <input class="form-check-input check-all" type="checkbox" data-column="wilaya">
                                    </div>
                                </th>
                                <th class="text-nowrap">الولاية</th>
                                <th width="60" class="text-center text-nowrap">
                                    <div class="d-flex flex-column align-items-center gap-1"
                                        title="تحديد / إلغاء تحديد تفعيل المنزل للكل">
                                        <span class="small opacity-75">المنزل</span>
                                        <input class="form-check-input check-all" type="checkbox" data-column="home">
                                    </div>
                                </th>
                                <th class="text-nowrap">سعر التوصيل للمنزل</th>
                                <th width="60" class="text-center text-nowrap">
                                    <div class="d-flex flex-column align-items-center gap-1"
                                        title="تحديد / إلغاء تحديد تفعيل المكتب للكل">
                                        <span class="small opacity-75">المكتب</span>
                                        <input class="form-check-input check-all" type="checkbox"
                                            data-column="stop_desck">
                                    </div>
                                </th>
                                <th class="text-nowrap">سعر التوصيل للمكتب</th>
                                <th width="60" class="text-center text-nowrap">
                                    <div class="d-flex flex-column align-items-center gap-1"
                                        title="تحديد / إلغاء تحديد التكلفة الإضافية للكل">
                                        <span class="small opacity-75">إضافي</span>
                                        <input class="form-check-input check-all" type="checkbox"
                                            data-column="additional">
                                    </div>
                                </th>
                                <th class="pe-4 text-nowrap">تكلفة إضافية للبلديات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prices as $index => $price)
                                <tr>
                                    <td scope="row" data-label="#" class="ps-md-4 fw-bold text-secondary">
                                        {{ $index + 1 }}
                                    </td>
                                    <td data-label="تفعيل الشحن للولاية" class="text-center">
                                        <input class="form-check-input check-wilaya" type="checkbox"
                                            name="wilaya_{{ $price->wilaya_id }}"
                                            {{ old("wilaya_{$price->wilaya_id}", $price->shipping_available_to_wilaya) ? 'checked' : '' }}>
                                    </td>
                                    <td data-label="الولاية">
                                        <span class="fw-bold text-dark fs-6 d-inline-flex align-items-center gap-1.5">
                                            <i class="fa-solid fa-location-dot text-plum"></i>
                                            {{ get_wilaya_data($price->wilaya_id)->ar_name }}
                                        </span>
                                    </td>
                                    <td data-label="تفعيل التوصيل للمنزل" class="text-center">
                                        <input class="form-check-input check-home" type="checkbox"
                                            name="to_home_wilaya_{{ $price->wilaya_id }}"
                                            {{ old("to_home_wilaya_{$price->wilaya_id}", $price->shipping_available_to_home) ? 'checked' : '' }}>
                                    </td>
                                    <td data-label="سعر التوصيل للمنزل">
                                        <div class="input-group input-group-sm max-w-160">
                                            <input
                                                class="form-control text-center fw-semibold rounded-start-3 shadow-none"
                                                type="number" step="any"
                                                name="to_home_w_{{ $price->wilaya_id }}"
                                                value="{{ old("to_home_w_{$price->wilaya_id}", $price->to_home_price) }}"
                                                min="0" placeholder="0.00">
                                            <span
                                                class="input-group-text bg-light text-muted small rounded-end-3">د.ج</span>
                                        </div>
                                    </td>
                                    <td data-label="تفعيل التوصيل للمكتب" class="text-center">
                                        <input class="form-check-input check-stop_desck" type="checkbox"
                                            name="to_stop_desck_wilaya_{{ $price->wilaya_id }}"
                                            {{ old("to_stop_desck_wilaya_{$price->wilaya_id}", $price->shipping_available_to_stop_desck) ? 'checked' : '' }}>
                                    </td>
                                    <td data-label="سعر التوصيل للمكتب">
                                        <div class="input-group input-group-sm max-w-160">
                                            <input
                                                class="form-control text-center fw-semibold rounded-start-3 shadow-none"
                                                type="number" step="any"
                                                name="to_desck_w_{{ $price->wilaya_id }}"
                                                value="{{ old("to_desck_w_{$price->wilaya_id}", $price->stop_desck_price) }}"
                                                min="0" placeholder="0.00">
                                            <span
                                                class="input-group-text bg-light text-muted small rounded-end-3">د.ج</span>
                                        </div>
                                    </td>
                                    <td data-label="تفعيل تكلفة إضافية للبلديات" class="text-center">
                                        <input class="form-check-input check-additional" type="checkbox"
                                            name="additional_wilaya_{{ $price->wilaya_id }}"
                                            {{ old("additional_wilaya_{$price->wilaya_id}", $price->additional_price_status) ? 'checked' : '' }}>
                                    </td>
                                    <td data-label="مبلغ التكلفة الإضافية للبلديات" class="pe-md-4">
                                        <div class="input-group input-group-sm max-w-160">
                                            <input
                                                class="form-control text-center fw-semibold rounded-start-3 shadow-none"
                                                type="number" step="any"
                                                name="additional_w_{{ $price->wilaya_id }}"
                                                value="{{ old("additional_w_{$price->wilaya_id}", $price->additional_price) }}"
                                                min="0" placeholder="0.00">
                                            <span
                                                class="input-group-text bg-light text-muted small rounded-end-3">د.ج</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div
                    class="p-3 p-md-4 bg-light border-top border-light d-flex justify-content-end align-items-center gap-2">
                    <button type="submit"
                        class="btn btn-seller-primary rounded-3 px-4 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>حفظ تعديلات التسعير</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* ================================
       PURE CSS RESPONSIVE TABLE PROTOCOL (SAFE-UI-STYLING SKILL)
       Targeting screens up to 1024.98px (Tablets / iPad / 1024px displays)
       ================================ */
    @media (max-width: 1024.98px) {

        .shipping-edit-table-responsive table.shipping-edit-table,
        .shipping-edit-table-responsive table.shipping-edit-table tbody,
        .shipping-edit-table-responsive table.shipping-edit-table tr,
        .shipping-edit-table-responsive table.shipping-edit-table td,
        .shipping-edit-table-responsive table.shipping-edit-table th {
            display: block !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .shipping-edit-table-responsive table.shipping-edit-table thead {
            display: none !important;
        }

        .shipping-edit-table-responsive table.shipping-edit-table tbody tr {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            margin-bottom: 1.25rem !important;
            padding: 0.85rem 1.15rem !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04) !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .shipping-edit-table-responsive table.shipping-edit-table tbody tr:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .shipping-edit-table-responsive table.shipping-edit-table tbody td,
        .shipping-edit-table-responsive table.shipping-edit-table tbody th {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 0.75rem 0.5rem !important;
            border: none !important;
            border-bottom: 1px dashed #e2e8f0 !important;
            white-space: normal !important;
            text-align: right !important;
            font-size: 0.9rem;
        }

        .shipping-edit-table-responsive table.shipping-edit-table tbody td:last-child {
            border-bottom: none !important;
        }

        .shipping-edit-table-responsive table.shipping-edit-table tbody td::before,
        .shipping-edit-table-responsive table.shipping-edit-table tbody th::before {
            content: attr(data-label);
            font-weight: 700;
            color: #64748b;
            font-size: 0.85rem;
            margin-left: 1rem;
            flex-shrink: 0;
        }

        .max-w-160 {
            max-width: 170px !important;
        }
    }

    /* Responsive adjustments specifically for 768px - 1024px tablet landscape screens */
    @media (min-width: 768px) and (max-width: 1024.98px) {
        .shipping-edit-table-responsive table.shipping-edit-table tbody tr {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.5rem 1.5rem !important;
            padding: 1.25rem !important;
        }

        .shipping-edit-table-responsive table.shipping-edit-table tbody td,
        .shipping-edit-table-responsive table.shipping-edit-table tbody th {
            border-bottom: 1px dashed #f1f5f9 !important;
        }

        .shipping-edit-table-responsive table.shipping-edit-table tbody th[data-label="#"] {
            grid-column: 1 / -1;
            border-bottom: 1px solid #e2e8f0 !important;
            padding-bottom: 0.5rem !important;
        }

        .shipping-edit-table-responsive table.shipping-edit-table tbody td[data-label="الولاية"] {
            grid-column: 1 / -1;
            border-bottom: 1px solid #e2e8f0 !important;
            padding-bottom: 0.5rem !important;
        }
    }

    /* Optimization for Desktop Screens > 1024px */
    @media (min-width: 1025px) {
        .shipping-edit-table th {
            font-size: 0.82rem;
            letter-spacing: 0.3px;
            padding: 0.9rem 0.75rem;
        }

        .shipping-edit-table td,
        .shipping-edit-table th {
            padding: 0.85rem 0.75rem;
            font-size: 0.875rem;
        }

        .max-w-160 {
            max-width: 140px;
        }
    }

    .card,
    .card-body {
        min-width: 0 !important;
        max-width: 100% !important;
    }

    .table-responsive {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
        display: block;
    }

    .custom-table-scroll {
        -webkit-overflow-scrolling: touch;
        overflow-x: auto !important;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f8fafc;
    }

    .custom-table-scroll::-webkit-scrollbar {
        height: 6px;
    }

    .custom-table-scroll::-webkit-scrollbar-track {
        background: #f8fafc;
        border-radius: 4px;
    }

    .custom-table-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .custom-table-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .bg-plum-subtle {
        background-color: rgba(164, 12, 114, 0.1);
    }

    .border-plum-subtle {
        border-color: rgba(164, 12, 114, 0.25) !important;
    }

    .text-plum {
        color: #a40c72 !important;
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
</style>
