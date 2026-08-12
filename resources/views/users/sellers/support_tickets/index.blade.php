@extends('layouts.users.dashboard.app')

@section('title', 'تذاكر الدعم الفني - لوحة التاجر')

@section('sidbar')
    @include('users.sellers.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('users.sellers.components.navbar.navbar')
@endsection

@section('content')
<div class="container-fluid px-4 py-3">

    <!-- Header Section -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-headset text-primary me-2"></i>تذاكر الدعم الفني والكول سنتر
            </h3>
            <p class="text-muted small mb-0">يمكنك متابعة استفساراتك، تقديم طلبات المساعدة الفنية، أو متابعة التذاكر السابقة بسهولة.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary shadow-sm px-4 fw-bold rounded-3" style="background-color: #a40c72; border-color: #a40c72;" data-bs-toggle="modal" data-bs-target="#newTicketModal">
                <i class="fa-solid fa-plus-circle me-1"></i> إنشاء تذكرة جديدة
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">إجمالي التذاكر</span>
                        <h4 class="fw-bold mb-0 text-dark mt-1">{{ number_format($totalTicketsCount) }}</h4>
                    </div>
                    <div class="stat-icon-wrapper bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                        <i class="fa-solid fa-ticket fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">قيد المعالجة والدراسة</span>
                        <h4 class="fw-bold mb-0 text-warning mt-1">{{ number_format($openTicketsCount) }}</h4>
                    </div>
                    <div class="stat-icon-wrapper bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                        <i class="fa-solid fa-clock-rotate-left fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">تم الرد وإجابة الاستفسار</span>
                        <h4 class="fw-bold mb-0 text-success mt-1">{{ number_format($answeredTicketsCount) }}</h4>
                    </div>
                    <div class="stat-icon-wrapper bg-success bg-opacity-10 text-success p-3 rounded-3">
                        <i class="fa-solid fa-circle-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-list-check me-2 text-primary"></i>سجل التذاكر</h5>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('seller.support_tickets.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 {{ !request()->filled('status') ? 'active' : '' }}">الكل</a>
                <a href="{{ route('seller.support_tickets.index', ['status' => 'open']) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 {{ request('status') === 'open' ? 'active' : '' }}">مفتوحة</a>
                <a href="{{ route('seller.support_tickets.index', ['status' => 'answered']) }}" class="btn btn-sm btn-outline-success rounded-pill px-3 {{ request('status') === 'answered' ? 'active' : '' }}">تم الرد</a>
                <a href="{{ route('seller.support_tickets.index', ['status' => 'closed']) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 {{ request('status') === 'closed' ? 'active' : '' }}">مغلقة</a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
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
                                <td class="ps-4">
                                    <span class="fw-bold text-dark dir-ltr">#{{ $ticket->ticket_number }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ Str::limit($ticket->subject, 35) }}</div>
                                    <small class="text-muted">{{ Str::limit($ticket->message, 45) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border small">
                                        @switch($ticket->category)
                                            @case('technical') <i class="fa-solid fa-code text-primary me-1"></i> تقني @break
                                            @case('financial') <i class="fa-solid fa-coins text-success me-1"></i> مالي @break
                                            @case('shipping') <i class="fa-solid fa-truck text-warning me-1"></i> شحن @break
                                            @default <i class="fa-solid fa-circle-info text-info me-1"></i> عام
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    @switch($ticket->priority)
                                        @case('urgent') <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill">عاجل جداً</span> @break
                                        @case('high') <span class="badge bg-warning-subtle text-warning border border-warning border-opacity-25 px-2 py-1 rounded-pill">عالي</span> @break
                                        @case('medium') <span class="badge bg-info-subtle text-info border border-info border-opacity-25 px-2 py-1 rounded-pill">متوسط</span> @break
                                        @default <span class="badge bg-light text-muted border px-2 py-1 rounded-pill">عادي</span>
                                    @endswitch
                                </td>
                                <td>
                                    @switch($ticket->status)
                                        @case('answered') <span class="badge bg-success text-white px-2.5 py-1 rounded-pill"><i class="fa-solid fa-check me-1"></i>تم الرد</span> @break
                                        @case('in_progress') <span class="badge bg-info text-white px-2.5 py-1 rounded-pill"><i class="fa-solid fa-spinner fa-spin me-1"></i>قيد المراجعة</span> @break
                                        @case('closed') <span class="badge bg-secondary text-white px-2.5 py-1 rounded-pill">مغلقة</span> @break
                                        @default <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill"><i class="fa-solid fa-clock me-1"></i>مفتوحة</span>
                                    @endswitch
                                </td>
                                <td class="text-muted small">
                                    {{ $ticket->updated_at->diffForHumans() }}
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('seller.support_tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary rounded-3 px-3">
                                        <i class="fa-solid fa-comments me-1"></i> فتح المحادثة
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div class="mb-3 fs-1 opacity-50">🎫</div>
                                    <h6>لا يوجد تذاكر دعم فني حالياً</h6>
                                    <p class="small text-muted mb-3">يمكنك إنشاء تذكرة جديدة وسيقوم فريق الكول سنتر والدعم الفني بمساعدتك فوراً.</p>
                                    <button type="button" class="btn btn-sm btn-primary rounded-3 px-4" style="background-color: #a40c72; border-color: #a40c72;" data-bs-toggle="modal" data-bs-target="#newTicketModal">
                                        أنشئ تذكرتك الأولى
                                    </button>
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

<!-- Modal Create Support Ticket -->
<div class="modal fade" id="newTicketModal" tabindex="-1" aria-labelledby="newTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white border-0 py-3" style="background: linear-gradient(135deg, #be0681 0%, #a40c72 100%);">
                <h5 class="modal-title fw-bold mb-0 text-white fs-6" id="newTicketModalLabel">
                    <i class="fa-solid fa-headset me-2"></i> إنشاء تذكرة دعم فني جديدة
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <form action="{{ route('seller.support_tickets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="category" class="form-label fw-bold small">قسم الدعم الفني: <span class="text-danger">*</span></label>
                            <select name="category" id="category" class="form-select rounded-3" required>
                                <option value="technical" selected>مشكلة تقنية / خلل بالمتجر</option>
                                <option value="financial">استفسار مالي / أرصدة وسحوبات</option>
                                <option value="shipping">الشحن وشركات التوصيل</option>
                                <option value="general">استفسار عام / اقتراحات</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="priority" class="form-label fw-bold small">مستوى الأولوية: <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-select rounded-3" required>
                                <option value="low">عادي (خلال 24 ساعة)</option>
                                <option value="medium" selected>متوسط (مستعجل)</option>
                                <option value="high">عالي (هام جداً)</option>
                                <option value="urgent">طوارئ (خلال دقائق)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label fw-bold small">عنوان التذكرة: <span class="text-danger">*</span></label>
                        <input type="text" name="subject" id="subject" class="form-control rounded-3" placeholder="أدخل موضوع التذكرة بوضوح..." required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label fw-bold small">تفاصيل الاستفسار أو المشكلة: <span class="text-danger">*</span></label>
                        <textarea name="message" id="message" rows="5" class="form-control rounded-3" placeholder="اشرح مشكلتك بالتفصيل ليتسنى لفريق الدعم مساعدتك فوراً..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="attachments" class="form-label fw-bold small">مرفقات أو صور توضيحية (اختياري):</label>
                        <input type="file" name="attachments[]" id="attachments" class="form-control rounded-3" multiple accept="image/*,.pdf,.doc,.docx">
                        <small class="text-muted">يمكنك رفع صور الشاشة أو ملفات PDF لمساعدة الفريق (حد أقصى 5 ميجابايت للملف).</small>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn text-white rounded-3 px-4 fw-bold" style="background-color: #a40c72;">
                        <i class="fa-solid fa-paper-plane me-1"></i> إرسال التذكرة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
