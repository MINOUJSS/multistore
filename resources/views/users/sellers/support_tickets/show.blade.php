@extends('layouts.users.dashboard.app')

@section('title', 'محادثة التذكرة - ' . $ticket->ticket_number)

@section('sidbar')
    @include('users.sellers.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('users.sellers.components.navbar.navbar')
@endsection

@section('content')
<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-comments text-warning"></i>
                    <span class="fw-semibold">{{ __('تفاصيل المحادثة والدعم المباشر') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start dir-ltr text-lg-start d-flex align-items-center gap-2">
                    <span>محادثة التذكرة</span>
                    <span class="text-warning">#{{ $ticket->ticket_number }}</span>
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    موضوع التذكرة: <strong class="text-white">{{ $ticket->subject }}</strong>
                </p>
            </div>
            <div class="col-lg-4 text-lg-end d-flex flex-wrap align-items-center justify-content-lg-end gap-2">
                @if($ticket->status !== 'closed')
                    <form action="{{ route('seller.support_tickets.close', $ticket->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من إغلاق هذه التذكرة؟')">
                        @csrf
                        <button type="submit" class="btn btn-outline-light fw-bold px-3.5 py-2.5 rounded-3 shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="fa-solid fa-lock"></i>
                            <span>إغلاق التذكرة</span>
                        </button>
                    </form>
                @endif
                <a href="{{ route('seller.support_tickets.index') }}"
                    class="btn btn-light text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                    <i class="fas fa-arrow-right"></i>
                    <span>سجل التذاكر</span>
                </a>
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

    <!-- Ticket Summary Banner Grid -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4">
        <div class="row align-items-center g-3 text-center text-md-start">
            <div class="col-6 col-md-3 border-end-md">
                <small class="text-muted d-block fw-bold mb-1">حالة التذكرة</small>
                @switch($ticket->status)
                    @case('answered') <span class="badge bg-success text-white px-3 py-1.5 rounded-pill fs-7"><i class="fa-solid fa-check me-1"></i>تم الرد</span> @break
                    @case('in_progress') <span class="badge bg-info text-white px-3 py-1.5 rounded-pill fs-7"><i class="fa-solid fa-spinner fa-spin me-1"></i>قيد المراجعة</span> @break
                    @case('closed') <span class="badge bg-secondary text-white px-3 py-1.5 rounded-pill fs-7">مغلقة</span> @break
                    @default <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fs-7"><i class="fa-solid fa-clock me-1"></i>مفتوحة</span>
                @endswitch
            </div>

            <div class="col-6 col-md-3 border-end-md">
                <small class="text-muted d-block fw-bold mb-1">قسم الدعم</small>
                <span class="fw-bold text-dark fs-6">
                    @switch($ticket->category)
                        @case('technical') <i class="fa-solid fa-code text-primary me-1"></i> تقني / متجر @break
                        @case('financial') <i class="fa-solid fa-coins text-success me-1"></i> مالي وسحوبات @break
                        @case('shipping') <i class="fa-solid fa-truck text-warning me-1"></i> الشحن والدعم @break
                        @default <i class="fa-solid fa-circle-info text-info me-1"></i> استفسار عام
                    @endswitch
                </span>
            </div>

            <div class="col-6 col-md-3 border-end-md">
                <small class="text-muted d-block fw-bold mb-1">مستوى الأولوية</small>
                <span class="fw-bold text-dark fs-6">
                    @switch($ticket->priority)
                        @case('urgent') <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 px-2.5 py-1 rounded-pill">عاجل جداً 🔥</span> @break
                        @case('high') <span class="badge bg-warning-subtle text-warning-emphasis border border-warning border-opacity-25 px-2.5 py-1 rounded-pill">عالي ⚡</span> @break
                        @case('medium') <span class="badge bg-info-subtle text-info border border-info border-opacity-25 px-2.5 py-1 rounded-pill">متوسط</span> @break
                        @default <span class="badge bg-light text-muted border px-2.5 py-1 rounded-pill">عادي</span>
                    @endswitch
                </span>
            </div>

            <div class="col-6 col-md-3">
                <small class="text-muted d-block fw-bold mb-1">تاريخ الإنشاء</small>
                <span class="fw-semibold text-dark fs-6">{{ $ticket->created_at->format('Y-m-d H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- Chat Thread Section -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-bottom">
            <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <i class="fa-solid fa-comments text-plum"></i>
                <span>سجل المحادثة والردود</span>
            </h5>
        </div>

        <div class="card-body p-4 bg-light-subtle">
            <!-- Initial Message -->
            <div class="d-flex flex-column align-items-start mb-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-plum-subtle text-plum rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fa-solid fa-user fs-6"></i>
                    </span>
                    <div>
                        <strong class="text-dark small d-block">{{ $ticket->user_name }} (أنت)</strong>
                        <small class="text-muted fs-7">{{ $ticket->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                <div class="p-4 bg-white border rounded-4 shadow-sm max-w-2xl text-dark leading-relaxed ms-md-4 w-100">
                    <h6 class="fw-bold text-plum mb-2 border-bottom pb-2">{{ $ticket->subject }}</h6>
                    {!! nl2br(e($ticket->message)) !!}

                    @if(!empty($ticket->attachments))
                        <div class="mt-3 pt-3 border-top">
                            <small class="fw-bold text-muted d-block mb-2"><i class="fa-solid fa-paperclip me-1"></i>المرفقات المرفوقة:</small>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($ticket->attachments as $attachment)
                                    <a href="{{ asset($attachment) }}" target="_blank" class="btn btn-sm btn-outline-plum rounded-3 small fw-semibold">
                                        <i class="fa-solid fa-file-arrow-down me-1"></i> معاينة الملف / المرفق
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Replies Thread -->
            @foreach($ticket->replies as $reply)
                @if($reply->sender_type === 'user')
                    <div class="d-flex flex-column align-items-start mb-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-plum-subtle text-plum rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-user fs-6"></i>
                            </span>
                            <div>
                                <strong class="text-dark small d-block">{{ $reply->sender_name }} (أنت)</strong>
                                <small class="text-muted fs-7">{{ $reply->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="p-4 bg-white border rounded-4 shadow-sm max-w-2xl text-dark leading-relaxed ms-md-4 w-100">
                            {!! nl2br(e($reply->message)) !!}

                            @if(!empty($reply->attachments))
                                <div class="mt-3 pt-3 border-top">
                                    <small class="fw-bold text-muted d-block mb-2"><i class="fa-solid fa-paperclip me-1"></i>المرفقات المرفوقة:</small>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($reply->attachments as $attachment)
                                            <a href="{{ asset($attachment) }}" target="_blank" class="btn btn-sm btn-outline-plum rounded-3 small fw-semibold">
                                                <i class="fa-solid fa-file-arrow-down me-1"></i> معاينة الملف / المرفق
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="d-flex flex-column align-items-end mb-4 text-start">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="text-end">
                                <strong class="text-plum small d-block">فريق الكول سنتر والدعم الفني 🎧</strong>
                                <small class="text-muted fs-7">{{ $reply->created_at->diffForHumans() }}</small>
                            </div>
                            <span class="badge bg-seller-primary text-white rounded-circle p-2 d-inline-flex align-items-center justify-content-center shadow-xs" style="width: 36px; height: 36px;">
                                <i class="fa-solid fa-headset fs-6"></i>
                            </span>
                        </div>
                        <div class="p-4 text-white rounded-4 shadow-sm max-w-2xl leading-relaxed me-md-4 w-100" style="background: linear-gradient(135deg, #a40c72 0%, #790b54 100%);">
                            {!! nl2br(e($reply->message)) !!}

                            @if(!empty($reply->attachments))
                                <div class="mt-3 pt-3 border-top border-white border-opacity-25">
                                    <small class="fw-bold text-white-50 d-block mb-2"><i class="fa-solid fa-paperclip me-1"></i>المرفقات من فريق الدعم:</small>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($reply->attachments as $attachment)
                                            <a href="{{ asset($attachment) }}" target="_blank" class="btn btn-sm btn-light text-dark rounded-3 small fw-semibold shadow-xs">
                                                <i class="fa-solid fa-download me-1"></i> تحميل / معاينة
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Add Reply Form -->
        @if($ticket->status !== 'closed')
            <div class="card-footer bg-white p-4 border-top">
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-reply me-1 text-plum"></i>إضافة رد جديد:</h6>
                <form action="{{ route('seller.support_tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <textarea name="message" rows="4" class="form-control rounded-3 p-3" placeholder="اكتب ردك هنا ليتواصل معك فريق الدعم المباشر..." required></textarea>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                        <div class="w-100 w-sm-auto">
                            <input type="file" name="attachments[]" class="form-control rounded-3" multiple accept="image/*,.pdf,.doc">
                        </div>
                        <button type="submit" class="btn btn-seller-primary px-5 py-2.5 rounded-3 fw-bold shadow-sm w-100 w-sm-auto">
                            <i class="fa-solid fa-paper-plane me-1"></i> إرسال الرد
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="card-footer bg-light p-4 text-center text-muted border-top">
                <i class="fa-solid fa-lock me-1"></i> هذه التذكرة مغلقة. إذا كانت لديك مشكلة جديدة يمكنك إنشاء تذكرة جديدة من صفحة سجل التذاكر.
            </div>
        @endif
    </div>

</div>

<style>
    .bg-plum-subtle {
        background-color: rgba(164, 12, 114, 0.1);
    }

    .border-plum-subtle {
        border-color: rgba(164, 12, 114, 0.25) !important;
    }

    .text-plum {
        color: #a40c72 !important;
    }

    .bg-seller-primary {
        background: linear-gradient(135deg, #a40c72 0%, #790b54 100%) !important;
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
        border-color: #a40c72 !important;
        color: #a40c72 !important;
    }

    .btn-outline-plum:hover {
        background-color: #a40c72 !important;
        color: #ffffff !important;
    }

    @media (min-width: 768px) {
        .border-end-md {
            border-left: 1px solid #e2e8f0 !important;
        }
    }
</style>
@endsection
