@extends('layouts.users.dashboard.app')

@section('title', 'محادثة التذكرة - ' . $ticket->ticket_number)

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
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('seller.support_tickets.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <h3 class="fw-bold mb-0 text-dark">
                    تذكرة رقم <span class="dir-ltr text-primary">#{{ $ticket->ticket_number }}</span>
                </h3>
            </div>
            <p class="text-muted small mb-0">{{ $ticket->subject }}</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            @if($ticket->status !== 'closed')
                <form action="{{ route('seller.support_tickets.close', $ticket->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من إغلاق هذه التذكرة؟')">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-3 px-3">
                        <i class="fa-solid fa-lock me-1"></i> إغلاق التذكرة
                    </button>
                </form>
            @endif
            <a href="{{ route('seller.support_tickets.index') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
                العودة للتذاكر
            </a>
        </div>
    </div>

    <!-- Ticket Summary Banner -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
        <div class="row align-items-center g-3">
            <div class="col-6 col-md-3 border-end border-light">
                <small class="text-muted d-block">حالة التذكرة</small>
                @switch($ticket->status)
                    @case('answered') <span class="badge bg-success text-white px-2.5 py-1 rounded-pill mt-1"><i class="fa-solid fa-check me-1"></i>تم الرد</span> @break
                    @case('in_progress') <span class="badge bg-info text-white px-2.5 py-1 rounded-pill mt-1"><i class="fa-solid fa-spinner fa-spin me-1"></i>قيد المراجعة</span> @break
                    @case('closed') <span class="badge bg-secondary text-white px-2.5 py-1 rounded-pill mt-1">مغلقة</span> @break
                    @default <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill mt-1"><i class="fa-solid fa-clock me-1"></i>مفتوحة</span>
                @endswitch
            </div>

            <div class="col-6 col-md-3 border-end border-light">
                <small class="text-muted d-block">قسم الدعم</small>
                <span class="fw-bold text-dark mt-1 d-inline-block">
                    @switch($ticket->category)
                        @case('technical') تقني / متجر @break
                        @case('financial') مالي وسحوبات @break
                        @case('shipping') الشحن والدعم @break
                        @default استفسار عام
                    @endswitch
                </span>
            </div>

            <div class="col-6 col-md-3 border-end border-light">
                <small class="text-muted d-block">مستوى الأولوية</small>
                <span class="fw-bold text-dark mt-1 d-inline-block">
                    @switch($ticket->priority)
                        @case('urgent') عاجل جداً 🔥 @break
                        @case('high') عالي ⚡ @break
                        @case('medium') متوسط @break
                        @default عادي
                    @endswitch
                </span>
            </div>

            <div class="col-6 col-md-3">
                <small class="text-muted d-block">تاريخ الإنشاء</small>
                <span class="fw-semibold text-muted mt-1 d-inline-block small">{{ $ticket->created_at->format('Y-m-d H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- Chat Thread Section -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-header bg-white py-3 px-4 border-0">
            <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-comments me-2 text-primary"></i>سجل المحادثة والردود</h5>
        </div>

        <div class="card-body p-4 bg-light bg-opacity-50">
            <!-- Initial Message -->
            <div class="d-flex flex-column align-items-start mb-4">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-primary text-white rounded-circle p-2" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <strong class="text-dark small">{{ $ticket->user_name }} (أنت)</strong>
                    <small class="text-muted ms-2">{{ $ticket->created_at->diffForHumans() }}</small>
                </div>
                <div class="p-3 bg-white border border-light-subtle rounded-3 shadow-xs max-w-2xl text-dark leading-relaxed ms-4">
                    <h6 class="fw-bold text-primary mb-2">{{ $ticket->subject }}</h6>
                    {!! nl2br(e($ticket->message)) !!}

                    @if(!empty($ticket->attachments))
                        <div class="mt-3 pt-2 border-top">
                            <small class="fw-bold text-muted d-block mb-1"><i class="fa-solid fa-paperclip me-1"></i>المرفقات:</small>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($ticket->attachments as $attachment)
                                    <a href="{{ asset($attachment) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 small">
                                        <i class="fa-solid fa-file me-1"></i> معاينة الملف
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
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-primary text-white rounded-circle p-2" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <strong class="text-dark small">{{ $reply->sender_name }} (أنت)</strong>
                            <small class="text-muted ms-2">{{ $reply->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="p-3 bg-white border border-light-subtle rounded-3 shadow-xs max-w-2xl text-dark leading-relaxed ms-4">
                            {!! nl2br(e($reply->message)) !!}

                            @if(!empty($reply->attachments))
                                <div class="mt-3 pt-2 border-top">
                                    <small class="fw-bold text-muted d-block mb-1"><i class="fa-solid fa-paperclip me-1"></i>المرفقات:</small>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($reply->attachments as $attachment)
                                            <a href="{{ asset($attachment) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 small">
                                                <i class="fa-solid fa-file me-1"></i> معاينة الملف
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="d-flex flex-column align-items-end mb-4">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <small class="text-muted me-2">{{ $reply->created_at->diffForHumans() }}</small>
                            <strong class="text-primary small">فريق الكول سنتر والدعم الفني 🎧</strong>
                            <span class="badge text-white rounded-circle p-2" style="background-color: #a40c72; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-headset"></i>
                            </span>
                        </div>
                        <div class="p-3 text-white rounded-3 shadow-xs max-w-2xl leading-relaxed me-4" style="background-color: #a40c72;">
                            {!! nl2br(e($reply->message)) !!}

                            @if(!empty($reply->attachments))
                                <div class="mt-3 pt-2 border-top border-white border-opacity-25">
                                    <small class="fw-bold text-white-50 d-block mb-1"><i class="fa-solid fa-paperclip me-1"></i>المرفقات من الدعم:</small>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($reply->attachments as $attachment)
                                            <a href="{{ asset($attachment) }}" target="_blank" class="btn btn-sm btn-light text-dark rounded-3 small">
                                                <i class="fa-solid fa-file me-1"></i> تحميل / معاينة
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
                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-reply me-1 text-primary"></i>إضافة رد جديد:</h6>
                <form action="{{ route('seller.support_tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <textarea name="message" rows="4" class="form-control rounded-3" placeholder="اكتب ردك هنا ليتواصل معك فريق الدعم المباشر..." required></textarea>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                        <div>
                            <input type="file" name="attachments[]" class="form-control form-control-sm rounded-3" multiple accept="image/*,.pdf,.doc">
                        </div>
                        <button type="submit" class="btn text-white px-4 fw-bold rounded-3" style="background-color: #a40c72;">
                            <i class="fa-solid fa-paper-plane me-1"></i> إرسال الرد
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="card-footer bg-light p-3 text-center text-muted border-top">
                <i class="fa-solid fa-lock me-1"></i> هذه التذكرة مغلقة. إذا كانت لديك مشكلة جديدة يمكنك إنشاء تذكرة جديدة.
            </div>
        @endif
    </div>

</div>
@endsection
