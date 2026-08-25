@extends('layouts.admins.app')

@section('title', 'إدارة تذاكر الدعم الفني - الأدمن')

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-headset text-warning"></i>
                    <span>{{ __('مركز الدعم الفني والكول سنتر') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🎧 إدارة تذاكر الدعم الفني 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    متابعة ومعالجة كافة بلاغات واستفسارات البائعين والموردين عبر المنصة بسهولة وسرعة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 bg-white bg-opacity-15 rounded-3 border border-white border-opacity-20 text-white">
                    <i class="fa-solid fa-bell text-warning fs-5"></i>
                    <div class="text-start">
                        <div class="small opacity-75">تذاكر تنتظر الرد</div>
                        <div class="fw-bold fs-5">{{ number_format($openCount) }} تذكرة</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Stat Cards Style -->
    <style>
        .dashboard-stat-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .dashboard-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08) !important;
        }
        .stat-icon-wrapper {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .bg-indigo-subtle { background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; }
        .bg-amber-subtle { background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        .bg-info-subtle { background-color: rgba(14, 165, 233, 0.1); color: #0ea5e9; }
        .bg-emerald-subtle { background-color: rgba(16, 185, 129, 0.1); color: #10b981; }
    </style>

    <!-- Overview Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white dashboard-stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">إجمالي التذاكر</span>
                        <h4 class="fw-bold mb-0 text-dark mt-1">{{ number_format($totalCount) }}</h4>
                    </div>
                    <div class="stat-icon-wrapper bg-indigo-subtle">
                        <i class="fa-solid fa-ticket fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white dashboard-stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">تنتظر الرد</span>
                        <h4 class="fw-bold mb-0 text-warning mt-1">{{ number_format($openCount) }}</h4>
                    </div>
                    <div class="stat-icon-wrapper bg-amber-subtle">
                        <i class="fa-solid fa-clock-rotate-left fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white dashboard-stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">قيد المعالجة</span>
                        <h4 class="fw-bold mb-0 text-info mt-1">{{ number_format($inProgressCount) }}</h4>
                    </div>
                    <div class="stat-icon-wrapper bg-info-subtle">
                        <i class="fa-solid fa-spinner fa-spin fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white dashboard-stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">تم الإجابة عليها</span>
                        <h4 class="fw-bold mb-0 text-success mt-1">{{ number_format($answeredCount) }}</h4>
                    </div>
                    <div class="stat-icon-wrapper bg-emerald-subtle">
                        <i class="fa-solid fa-circle-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.support_tickets.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0 rounded-end-3" placeholder="ابحث برقم التذكرة، العنوان، اسم المستخدم..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select bg-light border-0 rounded-3">
                        <option value="">كل الحالات</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>مفتوحة</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>قيد المعالجة</option>
                        <option value="answered" {{ request('status') === 'answered' ? 'selected' : '' }}>تم الرد</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>مغلقة</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="category" class="form-select bg-light border-0 rounded-3">
                        <option value="">كل الأقسام</option>
                        <option value="technical" {{ request('category') === 'technical' ? 'selected' : '' }}>تقني</option>
                        <option value="financial" {{ request('category') === 'financial' ? 'selected' : '' }}>مالي</option>
                        <option value="shipping" {{ request('category') === 'shipping' ? 'selected' : '' }}>شحن</option>
                        <option value="general" {{ request('category') === 'general' ? 'selected' : '' }}>عام</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="priority" class="form-select bg-light border-0 rounded-3">
                        <option value="">الأولوية</option>
                        <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>طوارئ</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>عالي</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>متوسط</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>عادي</option>
                    </select>
                </div>
                <div class="col-6 col-md-2 d-flex gap-1">
                    <button type="submit" class="btn text-white w-100 rounded-3 fw-semibold" style="background-color: #a40c72;"><i class="fa-solid fa-filter me-1"></i> تصفية</button>
                    <a href="{{ route('admin.support_tickets.index') }}" class="btn btn-light border rounded-3" title="إعادة ضبط"><i class="fa-solid fa-rotate-left"></i></a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tickets Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="supportTicketsTable">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">التذكرة</th>
                            <th>المستخدم / المتجر</th>
                            <th>موضوع التذكرة</th>
                            <th>القسم</th>
                            <th>الأولوية</th>
                            <th>الحالة</th>
                            <th>تاريخ التحديث</th>
                            <th class="text-end pe-4">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td class="ps-4" data-label="التذكرة">
                                    <span class="fw-bold text-primary dir-ltr">#{{ $ticket->ticket_number }}</span>
                                </td>
                                <td data-label="المستخدم / المتجر">
                                    <div class="fw-bold text-dark">{{ $ticket->user_name ?: 'تاجر المنصة' }}</div>
                                    <small class="text-muted dir-ltr">{{ $ticket->user_email }}</small>
                                </td>
                                <td data-label="موضوع التذكرة">
                                    <div class="fw-bold text-dark">{{ Str::limit($ticket->subject, 32) }}</div>
                                    <small class="text-muted">{{ Str::limit($ticket->message, 40) }}</small>
                                </td>
                                <td data-label="القسم">
                                    <span class="badge bg-light text-dark border small px-2.5 py-1 rounded-3">
                                        @switch($ticket->category)
                                            @case('technical') تقني @break
                                            @case('financial') مالي @break
                                            @case('shipping') شحن @break
                                            @default عام
                                        @endswitch
                                    </span>
                                </td>
                                <td data-label="الأولوية">
                                    @switch($ticket->priority)
                                        @case('urgent') <span class="badge bg-danger text-white px-2 py-1 rounded-pill">طوارئ 🔥</span> @break
                                        @case('high') <span class="badge bg-warning text-dark px-2 py-1 rounded-pill">عالي ⚡</span> @break
                                        @case('medium') <span class="badge bg-info text-white px-2 py-1 rounded-pill">متوسط</span> @break
                                        @default <span class="badge bg-light text-muted border px-2 py-1 rounded-pill">عادي</span>
                                    @endswitch
                                </td>
                                <td data-label="الحالة">
                                    @switch($ticket->status)
                                        @case('answered') <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1 rounded-pill">تم الرد</span> @break
                                        @case('in_progress') <span class="badge bg-info bg-opacity-10 text-info px-2.5 py-1 rounded-pill">قيد المعالجة</span> @break
                                        @case('closed') <span class="badge bg-secondary bg-opacity-10 text-secondary px-2.5 py-1 rounded-pill">مغلقة</span> @break
                                        @default <span class="badge bg-warning bg-opacity-10 text-warning px-2.5 py-1 rounded-pill">مفتوحة</span>
                                    @endswitch
                                </td>
                                <td data-label="تاريخ التحديث" class="text-muted small">
                                    {{ $ticket->updated_at->diffForHumans() }}
                                </td>
                                <td data-label="الإجراءات" class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('admin.support_tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary rounded-3 px-3">
                                            <i class="fa-solid fa-comments me-1"></i> فتح ومعالجة
                                        </a>
                                        <form action="{{ route('admin.support_tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من حذف التذكرة؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <div class="mb-2 fs-1 opacity-50">🎧</div>
                                    <h6>لا يوجد تذاكر دعم فني مطابقة للفيلتر الحالي</h6>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tickets->hasPages())
                <div class="p-3 border-top bg-light d-flex justify-content-center">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Pure CSS Responsive Table Standard for #supportTicketsTable */
@media (max-width: 991.98px) {
    #supportTicketsTable, 
    #supportTicketsTable tbody, 
    #supportTicketsTable tr, 
    #supportTicketsTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #supportTicketsTable thead {
        display: none !important;
    }
    
    #supportTicketsTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #supportTicketsTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #supportTicketsTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #supportTicketsTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>
@endsection
