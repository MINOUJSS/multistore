@extends('layouts.admins.app')

@section('title', 'معالجة التذكرة - ' . $ticket->ticket_number)

@section('sidebar')
    @include('admins.admin.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('admins.admin.components.navbar.navbar')
@endsection

@section('content')
<div class="container-fluid px-4 py-4">

    <!-- Header Section -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('admin.support_tickets.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <h3 class="fw-bold mb-0 text-dark">
                    معالجة التذكرة رقم <span class="dir-ltr text-primary">#{{ $ticket->ticket_number }}</span>
                </h3>
            </div>
            <p class="text-muted small mb-0">{{ $ticket->subject }}</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.support_tickets.index') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
                العودة للتذاكر
            </a>
        </div>
    </div>

    <!-- Ticket Controls Banner -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
        <form action="{{ route('admin.support_tickets.update_status', $ticket->id) }}" method="POST" class="row align-items-center g-3">
            @csrf
            <div class="col-12 col-md-3 border-end border-light">
                <label class="text-muted small d-block mb-1">تحديث حالة التذكرة:</label>
                <select name="status" class="form-select form-select-sm rounded-3">
                    <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>مفتوحة (Open)</option>
                    <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>قيد المعالجة (In Progress)</option>
                    <option value="answered" {{ $ticket->status === 'answered' ? 'selected' : '' }}>تم الرد (Answered)</option>
                    <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>مغلقة (Closed)</option>
                </select>
            </div>

            <div class="col-12 col-md-3 border-end border-light">
                <label class="text-muted small d-block mb-1">تحديث الأولوية:</label>
                <select name="priority" class="form-select form-select-sm rounded-3">
                    <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>عادي (Low)</option>
                    <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>متوسط (Medium)</option>
                    <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>عالي (High)</option>
                    <option value="urgent" {{ $ticket->priority === 'urgent' ? 'selected' : '' }}>طوارئ (Urgent)</option>
                </select>
            </div>

            <div class="col-12 col-md-3 border-end border-light">
                <small class="text-muted d-block mb-1">المستخدم صاحبة التذكرة:</small>
                <div class="fw-bold text-dark">{{ $ticket->user_name }} ({{ $ticket->user_type }})</div>
                <small class="text-muted dir-ltr d-block">{{ $ticket->user_email }}</small>
            </div>

            <div class="col-12 col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3">
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>

    <!-- Chat Thread Section -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-header bg-white py-3 px-4 border-0">
            <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-comments me-2 text-primary"></i>محادثة وتفاصيل التذكرة</h5>
        </div>

        <div class="card-body p-4 bg-light bg-opacity-50">
            <!-- Initial User Message -->
            <div class="d-flex flex-column align-items-start mb-4">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-primary text-white rounded-circle p-2" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <strong class="text-dark small">{{ $ticket->user_name }} ({{ $ticket->user_type }})</strong>
                    <small class="text-muted ms-2">{{ $ticket->created_at->diffForHumans() }}</small>
                </div>
                <div class="p-3 bg-white border border-light-subtle rounded-3 shadow-xs max-w-2xl text-dark leading-relaxed ms-4">
                    <h6 class="fw-bold text-primary mb-2">{{ $ticket->subject }}</h6>
                    {!! nl2br(e($ticket->message)) !!}

                    @if(!empty($ticket->attachments))
                        <div class="mt-3 pt-2 border-top">
                            <small class="fw-bold text-muted d-block mb-1"><i class="fa-solid fa-paperclip me-1"></i>المرفقات الأوليّة:</small>
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
                            <strong class="text-dark small">{{ $reply->sender_name }} (التاجر)</strong>
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
                            <strong class="text-primary small">{{ $reply->sender_name ?: 'فريق الأدمن والدعم' }} 🎧</strong>
                            <span class="badge bg-indigo-subtle text-indigo rounded-circle p-2" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-crown"></i>
                            </span>
                        </div>
                        <div class="p-3 bg-primary text-white rounded-3 shadow-xs max-w-2xl leading-relaxed me-4">
                            {!! nl2br(e($reply->message)) !!}

                            @if(!empty($reply->attachments))
                                <div class="mt-3 pt-2 border-top border-white border-opacity-25">
                                    <small class="fw-bold text-white-50 d-block mb-1"><i class="fa-solid fa-paperclip me-1"></i>المرفقات من الأدمن:</small>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($reply->attachments as $attachment)
                                            <a href="{{ asset($attachment) }}" target="_blank" class="btn btn-sm btn-light text-dark rounded-3 small">
                                                <i class="fa-solid fa-file me-1"></i> معاينة الملف
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

        <!-- Admin Reply Form -->
        <div class="card-footer bg-white p-4 border-top">
            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-reply me-1 text-primary"></i>رد الأدمن على التذكرة:</h6>
            <form action="{{ route('admin.support_tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <textarea name="message" rows="4" class="form-control rounded-3" placeholder="اكتب ردك وملاحظاتك المباشرة للمستخدم..." required></textarea>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <input type="file" name="attachments[]" class="form-control form-control-sm rounded-3" multiple accept="image/*,.pdf,.doc">
                        <select name="status" class="form-select form-select-sm rounded-3" style="width: auto;">
                            <option value="answered" selected>تعيين الحالة: تم الرد</option>
                            <option value="in_progress">تعيين الحالة: قيد المراجعة</option>
                            <option value="closed">تعيين الحالة: إغلاق التذكرة</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary px-4 fw-bold rounded-3">
                        <i class="fa-solid fa-paper-plane me-1"></i> إرسال الرد
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
