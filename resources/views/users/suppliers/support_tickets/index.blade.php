@extends('layouts.users.dashboard.app')

@section('title', 'تذاكر الدعم الفني - لوحة المورد')

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('content')
<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-headset text-warning"></i>
                    <span class="fw-semibold">{{ __('مركز الخدمة والكول سنتر للموردين') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    تذاكر الدعم الفني والكول سنتر للموردين 🎧
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    متابعة الاستفسارات الخاصة بتوزيع المنتجات للجملة، المالية، ومتابعة ردود الإدارة فوراً.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <button type="button"
                    class="btn btn-light text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#newSupplierTicketModal">
                    <i class="fa-solid fa-plus-circle text-navy"></i>
                    <span>إنشاء تذكرة جديدة</span>
                </button>
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10"
            style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);">
        </div>
        <div class="position-absolute rounded-circle bg-primary opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white transition-all hover-lift">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold d-block mb-1">إجمالي التذاكر المسجلة</span>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalTicketsCount) }}</h3>
                    </div>
                    <div class="stat-icon-wrapper bg-navy-subtle text-navy p-3 rounded-3">
                        <i class="fa-solid fa-ticket fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white transition-all hover-lift">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold d-block mb-1">قيد المعالجة والدراسة</span>
                        <h3 class="fw-bold mb-0 text-warning">{{ number_format($openTicketsCount) }}</h3>
                    </div>
                    <div class="stat-icon-wrapper bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                        <i class="fa-solid fa-clock-rotate-left fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white transition-all hover-lift">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold d-block mb-1">تم الرد وإجابة الاستفسار</span>
                        <h3 class="fw-bold mb-0 text-success">{{ number_format($answeredTicketsCount) }}</h3>
                    </div>
                    <div class="stat-icon-wrapper bg-success bg-opacity-10 text-success p-3 rounded-3">
                        <i class="fa-solid fa-circle-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
            <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <i class="fa-solid fa-list-check text-navy"></i>
                <span>سجل التذاكر والمحادثات</span>
            </h5>
            <div class="d-flex align-items-center gap-1.5 flex-wrap">
                <a href="{{ route('supplier.support_tickets.index') }}"
                    class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold transition-all {{ !request()->filled('status') ? 'btn-supplier-primary' : 'btn-light text-dark' }}">
                    الكل
                </a>
                <a href="{{ route('supplier.support_tickets.index', ['status' => 'open']) }}"
                    class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold transition-all {{ request('status') === 'open' ? 'btn-warning text-dark' : 'btn-light text-dark' }}">
                    مفتوحة
                </a>
                <a href="{{ route('supplier.support_tickets.index', ['status' => 'answered']) }}"
                    class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold transition-all {{ request('status') === 'answered' ? 'btn-success text-white' : 'btn-light text-dark' }}">
                    تم الرد
                </a>
                <a href="{{ route('supplier.support_tickets.index', ['status' => 'closed']) }}"
                    class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold transition-all {{ request('status') === 'closed' ? 'btn-dark text-white' : 'btn-light text-dark' }}">
                    مغلقة
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 supplier-tickets-table">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">رقم التذكرة</th>
                            <th>العنوان والتفاصيل</th>
                            <th>القسم</th>
                            <th>الأولوية</th>
                            <th>الحالة</th>
                            <th>آخر تحديث</th>
                            <th class="text-end pe-4">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td class="ps-4" data-label="رقم التذكرة">
                                    <span class="fw-bold text-navy dir-ltr">#{{ $ticket->ticket_number }}</span>
                                </td>
                                <td data-label="العنوان والتفاصيل">
                                    <div class="fw-bold text-dark mb-0.5">{{ Str::limit($ticket->subject, 35) }}</div>
                                    <small class="text-muted leading-tight d-block">{{ Str::limit($ticket->message, 45) }}</small>
                                </td>
                                <td data-label="القسم">
                                    <span class="badge bg-light text-dark border small rounded-2 px-2 py-1">
                                        @switch($ticket->category)
                                            @case('technical') <i class="fa-solid fa-code text-primary me-1"></i> تقني @break
                                            @case('financial') <i class="fa-solid fa-coins text-success me-1"></i> مالي @break
                                            @case('shipping') <i class="fa-solid fa-truck text-warning me-1"></i> شحن/جملة @break
                                            @default <i class="fa-solid fa-circle-info text-info me-1"></i> عام
                                        @endswitch
                                    </span>
                                </td>
                                <td data-label="الأولوية">
                                    @switch($ticket->priority)
                                        @case('urgent') <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 px-2.5 py-1 rounded-pill">عاجل جداً</span> @break
                                        @case('high') <span class="badge bg-warning-subtle text-warning-emphasis border border-warning border-opacity-25 px-2.5 py-1 rounded-pill">عالي</span> @break
                                        @case('medium') <span class="badge bg-info-subtle text-info border border-info border-opacity-25 px-2.5 py-1 rounded-pill">متوسط</span> @break
                                        @default <span class="badge bg-light text-muted border px-2.5 py-1 rounded-pill">عادي</span>
                                    @endswitch
                                </td>
                                <td data-label="الحالة">
                                    @switch($ticket->status)
                                        @case('answered') <span class="badge bg-success text-white px-2.5 py-1 rounded-pill"><i class="fa-solid fa-check me-1"></i>تم الرد</span> @break
                                        @case('in_progress') <span class="badge bg-info text-white px-2.5 py-1 rounded-pill"><i class="fa-solid fa-spinner fa-spin me-1"></i>قيد المراجعة</span> @break
                                        @case('closed') <span class="badge bg-secondary text-white px-2.5 py-1 rounded-pill">مغلقة</span> @break
                                        @default <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill"><i class="fa-solid fa-clock me-1"></i>مفتوحة</span>
                                    @endswitch
                                </td>
                                <td class="text-muted small" data-label="آخر تحديث">
                                    {{ $ticket->updated_at->diffForHumans() }}
                                </td>
                                <td class="text-end pe-4" data-label="الإجراءات">
                                    <a href="{{ route('supplier.support_tickets.show', $ticket->id) }}"
                                        class="btn btn-sm btn-outline-navy rounded-3 px-3 fw-semibold">
                                        <i class="fa-solid fa-comments me-1"></i> فتح المحادثة
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div class="mb-3 display-4 text-navy opacity-50">🎫</div>
                                    <h6 class="fw-bold text-dark mb-1">لا يوجد تذاكر دعم فني للموردين حالياً</h6>
                                    <p class="small text-muted mb-3">يمكنك إنشاء تذكرة وسيقوم الفريق التقني المخصص للموردين بالمتابعة معك.</p>
                                    <button type="button" class="btn btn-supplier-primary rounded-3 px-4 py-2 fw-bold"
                                        data-bs-toggle="modal" data-bs-target="#newSupplierTicketModal">
                                        <i class="fa-solid fa-plus-circle me-1"></i> أنشئ تذكرتك الأولى
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tickets->hasPages())
                <div class="p-3 border-top bg-light-subtle d-flex justify-content-center">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Create Support Ticket for Supplier -->
<div class="modal fade" id="newSupplierTicketModal" tabindex="-1" aria-labelledby="newSupplierTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white border-0 py-3" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <h5 class="modal-title fw-bold mb-0 text-white fs-6" id="newSupplierTicketModalLabel">
                    <i class="fa-solid fa-headset me-2"></i> إنشاء تذكرة دعم فني خاصة بالمورد
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <form action="{{ route('supplier.support_tickets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 text-start">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="category" class="form-label fw-bold small text-dark">قسم الدعم الفني: <span class="text-danger">*</span></label>
                            <select name="category" id="category" class="form-select rounded-3" required>
                                <option value="technical" selected>مشكلة تقنية / توزيع المنتجات والجملة</option>
                                <option value="financial">استفسار مالي / أرباح وسحوبات المورد</option>
                                <option value="shipping">الشحن وإدارة الطلبات</option>
                                <option value="general">استفسار عام / اقتراحات</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="priority" class="form-label fw-bold small text-dark">مستوى الأولوية: <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-select rounded-3" required>
                                <option value="low">عادي (خلال 24 ساعة)</option>
                                <option value="medium" selected>متوسط (مستعجل)</option>
                                <option value="high">عالي (هام جداً)</option>
                                <option value="urgent">طوارئ (خلال دقائق)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label fw-bold small text-dark">عنوان التذكرة: <span class="text-danger">*</span></label>
                        <input type="text" name="subject" id="subject" class="form-control rounded-3" placeholder="أدخل موضوع التذكرة بوضوح..." required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label fw-bold small text-dark">تفاصيل الاستفسار أو المشكلة: <span class="text-danger">*</span></label>
                        <textarea name="message" id="message" rows="5" class="form-control rounded-3" placeholder="اشرح طلبك بالتفصيل ليتسنى لمشرفي الموردين مساعدتك..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="attachments" class="form-label fw-bold small text-dark">مرفقات أو صور توضيحية (اختياري):</label>
                        <input type="file" name="attachments[]" id="attachments" class="form-control rounded-3" multiple accept="image/*,.pdf,.doc,.docx">
                        <small class="text-muted">يمكنك رفع الفواتير أو الصور لمساعدة الفريق (حد أقصى 5 ميجابايت للملف).</small>
                    </div>
                </div>

                <div class="modal-footer bg-light-subtle border-top px-4 py-3">
                    <button type="button" class="btn btn-light text-dark rounded-3 px-4 fw-bold" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-supplier-primary rounded-3 px-4 py-2 fw-bold">
                        <i class="fa-solid fa-paper-plane me-1"></i> إرسال التذكرة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-navy-subtle {
        background-color: rgba(15, 23, 42, 0.1);
    }

    .border-navy-subtle {
        border-color: rgba(15, 23, 42, 0.25) !important;
    }

    .text-navy {
        color: #0f172a !important;
    }

    .bg-supplier-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
    }

    .btn-supplier-primary {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }

    .btn-supplier-primary:hover {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%) !important;
        color: #ffffff !important;
    }

    .btn-outline-navy {
        border-color: #0f172a !important;
        color: #0f172a !important;
    }

    .btn-outline-navy:hover {
        background-color: #0f172a !important;
        color: #ffffff !important;
    }

    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }

    /* 1024px Pure CSS Responsive Table */
    @media (max-width: 1024.98px) {
        .supplier-tickets-table thead {
            display: none;
        }

        .supplier-tickets-table,
        .supplier-tickets-table tbody,
        .supplier-tickets-table tr,
        .supplier-tickets-table td {
            display: block;
            width: 100%;
        }

        .supplier-tickets-table tr {
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .supplier-tickets-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0 !important;
            border-bottom: 1px dashed #f1f5f9;
            text-align: left !important;
        }

        .supplier-tickets-table td:last-child {
            border-bottom: none;
            padding-top: 0.75rem !important;
            justify-content: flex-end;
        }

        .supplier-tickets-table td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.85rem;
            color: #64748b;
            margin-left: 1rem;
        }

        .supplier-tickets-table td.ps-4 {
            padding-left: 0 !important;
        }

        .supplier-tickets-table td.pe-4 {
            padding-right: 0 !important;
        }
    }
</style>
@endsection
