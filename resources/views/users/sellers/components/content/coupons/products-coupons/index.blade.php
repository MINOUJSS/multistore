<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-link text-warning"></i>
                    <span class="fw-semibold">{{ __('إدارة عروض المنتجات') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    ربط الكوبونات بالمنتجات 🔗
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    تخصيص وتحديد الكوبونات لمنتجات معينة بمتجرك، متابعة التخفيضات المخصصة وإدارة العلاقات بسهولة وسرعة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="#linkFormSection" class="btn btn-warning text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fas fa-plus"></i>
                        <span>ربط جديد</span>
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
        <!-- 1. Total Links -->
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold">
                            <i class="fa-solid fa-link fs-5"></i>
                        </span>
                        <span class="badge bg-light text-secondary rounded-pill small">الروابط</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $relations->count() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">إجمالي الكوبونات المرتبطة</p>
                </div>
            </div>
        </div>

        <!-- 2. Available Coupons -->
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-info-subtle text-info fw-bold">
                            <i class="fa-solid fa-ticket fs-5"></i>
                        </span>
                        <span class="badge bg-info-subtle text-info rounded-pill small">المتاحة</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ count($coupons) }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">الكوبونات المتاحة</p>
                </div>
            </div>
        </div>

        <!-- 3. Available Products -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-success-subtle text-success fw-bold">
                            <i class="fa-solid fa-boxes-stacked fs-5"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success rounded-pill small">المنتجات</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ count($products) }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">المنتجات المتاحة للتخصيص</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔹 اختيار الكوبون والمنتجات Form Section -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white" id="linkFormSection">
        <div class="card-header bg-white border-0 py-3.5 px-3 px-md-4 d-flex align-items-center gap-2 border-bottom border-light">
            <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold me-1" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-plus-minus fs-6"></i>
            </span>
            <h5 class="fw-bold mb-0 text-dark fs-6">تخصيص وربط كوبون بمنتجات</h5>
        </div>
        <div class="card-body p-3.5 p-md-4">
            <form id="couponProductForm" action="{{ route('seller.products-coupons.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary small">
                            <i class="fa-solid fa-ticket me-1 text-plum"></i> اختر الكوبون
                        </label>
                        <select name="coupon_id" id="coupon_id" class="form-select rounded-3 border-light-subtle shadow-none" required>
                            <option value="">-- اختر الكوبون --</option>
                            @foreach($coupons as $coupon)
                                <option value="{{ $coupon->id }}">{{ $coupon->code }} - {{ $coupon->description }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary small">
                            <i class="fa-solid fa-boxes-stacked me-1 text-plum"></i> اختر المنتجات
                        </label>
                        <select name="product_ids[]" id="product_ids" class="form-select select2 rounded-3 border-light-subtle shadow-none" multiple required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-1"><i class="fa-solid fa-circle-info me-1"></i>يمكنك اختيار أكثر من منتج في نفس الوقت.</small>
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-seller-primary rounded-3 px-4 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="fa fa-link"></i>
                            <span>ربط الكوبون بالمنتجات المحددة</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 🔹 جدول العلاقات الحالية Table Container -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
        <div class="card-header bg-white border-0 py-3.5 px-3 px-md-4 d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom border-light">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold me-1" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-table-list fs-6"></i>
                </span>
                <h5 class="fw-bold mb-0 text-dark fs-6">جدول العلاقات المخصصة الحالية</h5>
            </div>
            <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill small fw-semibold">
                <i class="fa-solid fa-layer-group me-1 text-plum"></i> إجمالي الروابط: {{ $relations->count() }}
            </span>
        </div>
        <div class="card-body p-0 p-md-3">
            <div class="table-responsive relations-table-responsive custom-table-scroll">
                <table class="table table-hover align-middle mb-0 relations-table">
                    <thead class="bg-light-subtle text-secondary small text-uppercase fw-bold border-bottom">
                        <tr>
                            <th class="ps-4 text-nowrap">الكوبون</th>
                            <th class="text-nowrap">المنتج</th>
                            <th class="text-nowrap">الخصم</th>
                            <th class="text-nowrap">تاريخ الإنشاء</th>
                            <th class="pe-4 text-end text-nowrap">إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($relations as $relation)
                            <tr>
                                <td data-label="الكوبون" class="ps-md-4">
                                    <span class="badge bg-plum-subtle text-plum fw-bold font-monospace px-3 py-1.5 fs-6 rounded-3 border border-plum-subtle">
                                        <i class="fa-solid fa-ticket me-1"></i>{{ $relation->coupon->code }}
                                    </span>
                                </td>
                                <td data-label="المنتج">
                                    <span class="fw-bold text-dark fs-6">{{ $relation->product->name }}</span>
                                </td>
                                <td data-label="الخصم">
                                    @if($relation->coupon->type == 'fixed')
                                        <span class="badge bg-primary-subtle text-primary border border-primary px-2.5 py-1.5 rounded-3 fw-semibold"><i class="fa-solid fa-money-bill me-1"></i>{{ number_format($relation->coupon->value, 2) }} دج</span>
                                    @else
                                        <span class="badge bg-info-subtle text-info border border-info px-2.5 py-1.5 rounded-3 fw-semibold"><i class="fa-solid fa-percent me-1"></i>{{ $relation->coupon->value }}%</span>
                                    @endif
                                </td>
                                <td data-label="تاريخ الإنشاء">
                                    <span class="text-secondary small fw-medium"><i class="fa-regular fa-clock me-1 text-muted"></i>{{ $relation->created_at->format('Y-m-d H:i') }}</span>
                                </td>
                                <td data-label="إجراء" class="pe-md-4 text-end">
                                    <form action="{{ route('seller.products-coupons.destroy', $relation->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3 py-1 shadow-2xs fw-semibold">
                                            <i class="fa fa-trash me-1"></i> حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5 fw-semibold">
                                    <i class="fa-solid fa-circle-exclamation text-secondary fs-4 d-block mb-2"></i>
                                    لا توجد علاقات ربط مخصصة حالياً
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* ================================
       PURE CSS RESPONSIVE TABLE PROTOCOL (SAFE-UI-STYLING SKILL)
       Targeting screens up to 1024.98px (Tablets / iPad / 1024px displays)
       ================================ */
    @media (max-width: 1024.98px) {
        .relations-table-responsive table.relations-table,
        .relations-table-responsive table.relations-table tbody,
        .relations-table-responsive table.relations-table tr,
        .relations-table-responsive table.relations-table td {
            display: block !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .relations-table-responsive table.relations-table thead {
            display: none !important;
        }

        .relations-table-responsive table.relations-table tbody tr {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            margin-bottom: 1.25rem !important;
            padding: 0.85rem 1.15rem !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04) !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .relations-table-responsive table.relations-table tbody tr:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .relations-table-responsive table.relations-table tbody td {
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

        .relations-table-responsive table.relations-table tbody td:last-child {
            border-bottom: none !important;
            justify-content: flex-end !important;
            gap: 0.5rem;
            padding-top: 1rem !important;
        }

        .relations-table-responsive table.relations-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            color: #64748b;
            font-size: 0.85rem;
            margin-left: 1rem;
            flex-shrink: 0;
        }
    }

    /* Responsive adjustments specifically for 768px - 1024px tablet landscape screens */
    @media (min-width: 768px) and (max-width: 1024.98px) {
        .relations-table-responsive table.relations-table tbody tr {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.5rem 1.5rem !important;
            padding: 1.25rem !important;
        }

        .relations-table-responsive table.relations-table tbody td {
            border-bottom: 1px dashed #f1f5f9 !important;
        }

        .relations-table-responsive table.relations-table tbody td[data-label="الكوبون"] {
            grid-column: 1 / -1;
            border-bottom: 1px solid #e2e8f0 !important;
            padding-bottom: 0.5rem !important;
        }

        .relations-table-responsive table.relations-table tbody td[data-label="إجراء"] {
            grid-column: 1 / -1;
            border-bottom: none !important;
            justify-content: flex-end !important;
        }
    }

    /* Optimization for Desktop Screens > 1024px */
    @media (min-width: 1025px) {
        .relations-table th {
            font-size: 0.82rem;
            letter-spacing: 0.3px;
            padding: 0.9rem 0.75rem;
        }

        .relations-table td {
            padding: 0.85rem 0.75rem;
            font-size: 0.875rem;
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

@push('scripts')
<script>
$(document).ready(function () {
    // تفعيل select2
    if ($.fn.select2) {
        $('.select2').select2({ dir: "rtl", width: '100%' });
    }

    // SweetAlert للحذف
    $('.delete-form').on('submit', function (e) {
        e.preventDefault();
        let form = this;
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف هذا الربط نهائيًا.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        } else {
            if (confirm('هل أنت متأكد من حذف هذا الربط؟')) {
                form.submit();
            }
        }
    });
});
</script>
@endpush
