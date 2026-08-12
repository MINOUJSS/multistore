@extends('layouts.admins.app')

@section('title', 'إدارة تذاكر الدعم الفني - الأدمن')

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
<div class="container-fluid px-4 py-4">

    <!-- Page Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-headset text-primary me-2"></i>إدارة تذاكر الدعم الفني والكول سنتر
            </h3>
            <p class="text-muted small mb-0">متابعة ومعالجة كافة بلاغات واستفسارات البائعين والموردين عبر المنصة.</p>
        </div>
    </div>

    <!-- Overview Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">إجمالي التذاكر</span>
                        <h4 class="fw-bold mb-0 text-dark mt-1">{{ number_format($totalCount) }}</h4>
                    </div>
                    <div class="stat-icon-wrapper bg-indigo-subtle text-indigo p-3 rounded-3">
                        <i class="fa-solid fa-ticket fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">تذاكر مفتوحة تنتظر الرد</span>
                        <h4 class="fw-bold mb-0 text-warning mt-1">{{ number_format($openCount) }}</h4>
                    </div>
                    <div class="stat-icon-wrapper bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                        <i class="fa-solid fa-clock-rotate-left fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">قيد المراجعة والمعالجة</span>
                        <h4 class="fw-bold mb-0 text-info mt-1">{{ number_format($inProgressCount) }}</h4>
                    </div>
                    <div class="stat-icon-wrapper bg-info bg-opacity-10 text-info p-3 rounded-3">
                        <i class="fa-solid fa-spinner fa-spin fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">تم الإجابة عليها</span>
                        <h4 class="fw-bold mb-0 text-success mt-1">{{ number_format($answeredCount) }}</h4>
                    </div>
                    <div class="stat-icon-wrapper bg-success bg-opacity-10 text-success p-3 rounded-3">
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
                    <input type="text" name="search" class="form-control rounded-3" placeholder="ابحث برقم التذكرة، العنوان، اسم المستخدم..." value="{{ request('search') }}">
                </div>
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select rounded-3">
                        <option value="">كل الحالات</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>مفتوحة</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>قيد المعالجة</option>
                        <option value="answered" {{ request('status') === 'answered' ? 'selected' : '' }}>تم الرد</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>مغلقة</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="category" class="form-select rounded-3">
                        <option value="">كل الأقسام</option>
                        <option value="technical" {{ request('category') === 'technical' ? 'selected' : '' }}>تقني</option>
                        <option value="financial" {{ request('category') === 'financial' ? 'selected' : '' }}>مالي</option>
                        <option value="shipping" {{ request('category') === 'shipping' ? 'selected' : '' }}>شحن</option>
                        <option value="general" {{ request('category') === 'general' ? 'selected' : '' }}>عام</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="priority" class="form-select rounded-3">
                        <option value="">الأولوية</option>
                        <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>طوارئ</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>عالي</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>متوسط</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>عادي</option>
                    </select>
                </div>
                <div class="col-6 col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-primary w-100 rounded-3">تصفية</button>
                    <a href="{{ route('admin.support_tickets.index') }}" class="btn btn-light border rounded-3"><i class="fa-solid fa-rotate-left"></i></a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tickets Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
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
                                <td class="ps-4">
                                    <span class="fw-bold text-primary dir-ltr">#{{ $ticket->ticket_number }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $ticket->user_name ?: 'تاجر المنصة' }}</div>
                                    <small class="text-muted dir-ltr">{{ $ticket->user_email }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ Str::limit($ticket->subject, 32) }}</div>
                                    <small class="text-muted">{{ Str::limit($ticket->message, 40) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border small">
                                        @switch($ticket->category)
                                            @case('technical') تقني @break
                                            @case('financial') مالي @break
                                            @case('shipping') شحن @break
                                            @default عام
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    @switch($ticket->priority)
                                        @case('urgent') <span class="badge bg-danger text-white px-2 py-1 rounded-pill">طوارئ 🔥</span> @break
                                        @case('high') <span class="badge bg-warning text-dark px-2 py-1 rounded-pill">عالي ⚡</span> @break
                                        @case('medium') <span class="badge bg-info text-white px-2 py-1 rounded-pill">متوسط</span> @break
                                        @default <span class="badge bg-light text-muted border px-2 py-1 rounded-pill">عادي</span>
                                    @endswitch
                                </td>
                                <td>
                                    @switch($ticket->status)
                                        @case('answered') <span class="badge bg-success text-white px-2.5 py-1 rounded-pill">تم الرد</span> @break
                                        @case('in_progress') <span class="badge bg-info text-white px-2.5 py-1 rounded-pill">قيد المعالجة</span> @break
                                        @case('closed') <span class="badge bg-secondary text-white px-2.5 py-1 rounded-pill">مغلقة</span> @break
                                        @default <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill">مفتوحة</span>
                                    @endswitch
                                </td>
                                <td class="text-muted small">
                                    {{ $ticket->updated_at->diffForHumans() }}
                                </td>
                                <td class="text-end pe-4">
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
@endsection
