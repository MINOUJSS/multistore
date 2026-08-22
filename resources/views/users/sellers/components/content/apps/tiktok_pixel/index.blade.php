<div class="container-fluid py-3 px-3 px-md-4">
    @php
        $plan_id = get_seller_data(auth()->user()->tenant_id)->plan_subscription->plan_id;
        $tiktok_pixle = get_user_data(auth()->user()->tenant_id)->tiktok_pixle;
        $apps_count = $tiktok_pixle->count();
    @endphp

    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fab fa-tiktok text-warning"></i>
                    <span class="fw-semibold">{{ __('إدارة بكسل الإعلانات الرقمية') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    إعدادات بكسل تيك توك TikTok Pixel 🎵
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    تتبع حملاتك الإعلانية على TikTok وتحليل تحويلات الزوار والمستهدفين بدقة لزيادة مبيعات متجرك.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('seller.apps') }}"
                        class="btn btn-light text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fas fa-arrow-right"></i>
                        <span>الرجوع للتطبيقات</span>
                    </a>
                    <button
                        class="btn btn-warning text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addPixelModal"
                        @if ($plan_id == 1 || ($plan_id == 2 && $apps_count >= 1) || ($plan_id == 3 && $apps_count >= 4)) disabled @endif>
                        <i class="fas fa-plus"></i>
                        <span>إضافة بكسل جديد</span>
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
        <!-- 1. Total Configured Pixels -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold">
                            <i class="fab fa-tiktok fs-5"></i>
                        </span>
                        <span class="badge bg-light text-secondary rounded-pill small">الكل</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $pixels->count() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">إجمالي البكسلات المضافة</p>
                </div>
            </div>
        </div>

        <!-- 2. Active Pixels -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-success-subtle text-success fw-bold">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success rounded-pill small">نشط</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $pixels->where('status', 'active')->count() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">بكسلات تيك توك المفعلة</p>
                </div>
            </div>
        </div>

        <!-- 3. Inactive Pixels -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-secondary-subtle text-secondary fw-bold">
                            <i class="fa-solid fa-circle-pause fs-5"></i>
                        </span>
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill small">معطل</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $pixels->where('status', '!=', 'active')->count() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">بكسلات تيك توك المعطلة</p>
                </div>
            </div>
        </div>

        <!-- 4. Plan Limit -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-info-subtle text-info fw-bold">
                            <i class="fa-solid fa-layer-group fs-5"></i>
                        </span>
                        <span class="badge bg-info-subtle text-info rounded-pill small">حد الخطة</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">
                        {{ $plan_id == 1 ? '0' : ($plan_id == 2 ? '1' : '4') }}
                    </h3>
                    <p class="text-muted small mb-0 fw-semibold">الحد الأقصى المسموح بالخطة</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pixels Data Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
        <div
            class="card-header bg-white border-0 py-3.5 px-3 px-md-4 d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom border-light">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold me-1"
                    style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fab fa-tiktok fs-6"></i>
                </span>
                <h5 class="fw-bold mb-0 text-dark fs-6">قائمة بكسلات تيك توك TikTok Pixel</h5>
            </div>
            <button
                class="btn btn-seller-primary rounded-3 px-3 py-2 fs-6 fw-bold shadow-sm d-inline-flex align-items-center gap-2"
                data-bs-toggle="modal" data-bs-target="#addPixelModal"
                @if ($plan_id == 1 || ($plan_id == 2 && $apps_count >= 1) || ($plan_id == 3 && $apps_count >= 4)) disabled @endif>
                <i class="fas fa-plus"></i>
                <span>إضافة بكسل جديد</span>
            </button>
        </div>
        <div class="card-body p-0 p-md-3">
            <div class="table-responsive tiktok-pixel-table-responsive custom-table-scroll">
                <table class="table table-hover align-middle mb-0 tiktok-pixel-table">
                    <thead class="bg-light-subtle text-secondary small text-uppercase fw-bold border-bottom">
                        <tr>
                            <th width="60" class="ps-4 text-nowrap">#</th>
                            <th class="text-nowrap">معرف البكسل (Pixel ID)</th>
                            <th width="140" class="text-center text-nowrap">الحالة</th>
                            <th width="180" class="text-center pe-4 text-nowrap">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pixels as $index => $pixel)
                            <tr id="row-{{ $pixel->id }}">
                                <td scope="row" data-label="#" class="ps-md-4 fw-bold text-secondary">
                                    {{ $index + 1 }}
                                </td>
                                <td data-label="معرف البكسل (Pixel ID)">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="avatar avatar-xs rounded-circle bg-dark text-white fw-bold me-1"
                                            style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;">
                                            <i class="fab fa-tiktok"></i>
                                        </span>
                                        <span class="fw-bold text-dark font-monospace fs-6">
                                            {{ json_decode($pixel->data)->pixel_id }}
                                        </span>
                                    </div>
                                </td>
                                <td data-label="الحالة" class="text-center">
                                    <span
                                        class="badge {{ $pixel->status === 'active' ? 'bg-success-subtle text-success border border-success' : 'bg-secondary-subtle text-secondary border border-secondary' }} rounded-pill px-3 py-1.5 fw-semibold">
                                        {{ $pixel->status === 'active' ? 'مفعل' : 'غير مفعل' }}
                                    </span>
                                </td>
                                <td data-label="الإجراء" class="text-center pe-md-4">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <!-- زر التعديل -->
                                        <button
                                            class="btn btn-warning btn-sm rounded-3 px-3 py-1.5 edit-btn d-inline-flex align-items-center gap-1"
                                            data-id="{{ $pixel->id }}"
                                            data-pixel_id="{{ json_decode($pixel->data)->pixel_id }}"
                                            data-status="{{ $pixel->status }}">
                                            <i class="fas fa-edit"></i>
                                            <span>تعديل</span>
                                        </button>

                                        <!-- زر الحذف -->
                                        <button
                                            class="btn btn-danger btn-sm rounded-3 px-3 py-1.5 delete-btn d-inline-flex align-items-center gap-1"
                                            data-id="{{ $pixel->id }}">
                                            <i class="fas fa-trash"></i>
                                            <span>حذف</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- مودال (نموذج إضافة الإعدادات) -->
<div class="modal fade" id="addPixelModal" tabindex="-1" aria-labelledby="addPixelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white py-3.5 px-4"
                style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 100%);">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-sm rounded-3 bg-white bg-opacity-20 text-white"
                        style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fab fa-tiktok"></i>
                    </span>
                    <h5 class="modal-title fw-bold mb-0 fs-6 text-white" id="addPixelModalLabel">إضافة إعدادات TikTok
                        Pixel</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="إغلاق"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <form id="AddTikTokPixelForm">
                    <input type="hidden" name="app_name" value="tiktok_pixel">

                    <div class="mb-3.5">
                        <label class="form-label fw-bold text-dark small">معرف البكسل (Pixel ID) <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i
                                    class="fab fa-tiktok"></i></span>
                            <input type="text" name="pixel_id" id="pixel_id"
                                class="form-control rounded-end-3 shadow-none border-start-0"
                                placeholder="مثال: CXXXXXXXXXXXXXX">
                        </div>
                        <div class="invalid-feedback d-block mt-1 small" id="error-pixel_id"></div>
                    </div>

                    <div class="p-3 bg-light rounded-3 border mb-4">
                        <div class="form-check form-switch d-flex align-items-center justify-content-between p-0 mb-0">
                            <label class="form-check-label fw-bold text-dark small mb-0" for="status">تفعيل البكسل
                                تلقائيًا</label>
                            <input class="form-check-input ms-0 shadow-none" type="checkbox" name="status"
                                id="status" checked style="width: 2.5em; height: 1.25em;">
                        </div>
                    </div>

                    <button type="submit"
                        class="btn btn-seller-primary w-100 rounded-3 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>حفظ وإضافة البكسل</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- مودال تعديل الإعدادات -->
<div class="modal fade" id="editPixelModal" tabindex="-1" aria-labelledby="editPixelModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white py-3.5 px-4"
                style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 100%);">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-sm rounded-3 bg-white bg-opacity-20 text-white"
                        style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fas fa-edit"></i>
                    </span>
                    <h5 class="modal-title fw-bold mb-0 fs-6 text-white" id="editPixelModalLabel">تعديل إعدادات TikTok
                        Pixel</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="إغلاق"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <form id="EditTikTokPixelForm">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="app_name" value="tiktok_pixel">

                    <div class="mb-3.5">
                        <label class="form-label fw-bold text-dark small">معرف البكسل (Pixel ID) <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i
                                    class="fab fa-tiktok"></i></span>
                            <input type="text" name="pixel_id" id="edit_pixel_id"
                                class="form-control rounded-end-3 shadow-none border-start-0"
                                placeholder="XXXXXXXXXX">
                        </div>
                        <div class="invalid-feedback d-block mt-1 small" id="error-pixel_id"></div>
                    </div>

                    <div class="p-3 bg-light rounded-3 border mb-4">
                        <div class="form-check form-switch d-flex align-items-center justify-content-between p-0 mb-0">
                            <label class="form-check-label fw-bold text-dark small mb-0" for="edit_status">تفعيل
                                البكسل</label>
                            <input class="form-check-input ms-0 shadow-none" type="checkbox" name="status"
                                id="edit_status" checked style="width: 2.5em; height: 1.25em;">
                        </div>
                    </div>

                    <button type="submit"
                        class="btn btn-seller-primary w-100 rounded-3 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>حفظ التعديلات</span>
                    </button>
                </form>
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

        .tiktok-pixel-table-responsive table.tiktok-pixel-table,
        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody,
        .tiktok-pixel-table-responsive table.tiktok-pixel-table tr,
        .tiktok-pixel-table-responsive table.tiktok-pixel-table td,
        .tiktok-pixel-table-responsive table.tiktok-pixel-table th {
            display: block !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .tiktok-pixel-table-responsive table.tiktok-pixel-table thead {
            display: none !important;
        }

        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody tr {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            margin-bottom: 1.25rem !important;
            padding: 0.85rem 1.15rem !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04) !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody tr:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody td,
        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody th {
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

        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody td:last-child {
            border-bottom: none !important;
        }

        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody td::before,
        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody th::before {
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
        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody tr {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.5rem 1.5rem !important;
            padding: 1.25rem !important;
        }

        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody td,
        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody th {
            border-bottom: 1px dashed #f1f5f9 !important;
        }

        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody th[data-label="#"] {
            grid-column: 1 / -1;
            border-bottom: 1px solid #e2e8f0 !important;
            padding-bottom: 0.5rem !important;
        }

        .tiktok-pixel-table-responsive table.tiktok-pixel-table tbody td[data-label="الإجراء"] {
            grid-column: 1 / -1;
            border-bottom: none !important;
            padding-top: 0.5rem !important;
        }
    }

    /* Optimization for Desktop Screens > 1024px */
    @media (min-width: 1025px) {
        .tiktok-pixel-table th {
            font-size: 0.82rem;
            letter-spacing: 0.3px;
            padding: 0.9rem 0.75rem;
        }

        .tiktok-pixel-table td,
        .tiktok-pixel-table th {
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
