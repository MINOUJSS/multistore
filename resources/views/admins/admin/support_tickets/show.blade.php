@extends('layouts.admins.app')

@section('title', 'معالجة التذكرة - ' . $ticket->ticket_number)

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
                <div class="d-flex align-items-center gap-2 mb-3">
                    <a href="{{ route('admin.support_tickets.index') }}" class="btn btn-sm btn-light text-dark rounded-circle border-0 shadow-sm" title="العودة للقائمة">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small border border-white border-opacity-10">
                        <i class="fa-solid fa-headset text-warning"></i>
                        <span>{{ __('تذكرة رقم') }} #{{ $ticket->ticket_number }}</span>
                    </div>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    {{ $ticket->subject }}
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    صاحب التذكرة: <strong class="text-white">{{ $ticket->user_name }}</strong> ({{ $ticket->user_type }}) — <span class="dir-ltr text-white-50">{{ $ticket->user_email }}</span>
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.support_tickets.index') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
                        <i class="fa-solid fa-list me-1"></i> العودة للتذاكر
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Controls Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
        <form action="{{ route('admin.support_tickets.update_status', $ticket->id) }}" method="POST" class="row align-items-center g-3">
            @csrf
            <div class="col-12 col-md-4 border-end-md">
                <label class="text-muted small fw-semibold d-block mb-1">تحديث حالة التذكرة:</label>
                <select name="status" class="form-select bg-light border-0 rounded-3">
                    <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>مفتوحة (Open)</option>
                    <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>قيد المعالجة (In Progress)</option>
                    <option value="answered" {{ $ticket->status === 'answered' ? 'selected' : '' }}>تم الرد (Answered)</option>
                    <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>مغلقة (Closed)</option>
                </select>
            </div>

            <div class="col-12 col-md-4 border-end-md">
                <label class="text-muted small fw-semibold d-block mb-1">تحديث الأولوية:</label>
                <select name="priority" class="form-select bg-light border-0 rounded-3">
                    <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>عادي (Low)</option>
                    <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>متوسط (Medium)</option>
                    <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>عالي (High)</option>
                    <option value="urgent" {{ $ticket->priority === 'urgent' ? 'selected' : '' }}>طوارئ (Urgent)</option>
                </select>
            </div>

            <div class="col-12 col-md-4 d-flex align-items-end">
                <button type="submit" class="btn text-white w-100 rounded-3 fw-bold" style="background-color: #a40c72;">
                    <i class="fa-solid fa-floppy-disk me-1"></i> حفظ التغييرات
                </button>
            </div>
        </form>
    </div>

    <!-- Chat Thread Section -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-comments me-2" style="color: #a40c72;"></i>محادثة وتفاصيل التذكرة</h5>
            <span class="badge bg-light text-muted border px-3 py-1.5 rounded-pill">تم الإنشاء: {{ $ticket->created_at->diffForHumans() }}</span>
        </div>

        <div class="card-body p-3 p-md-4 bg-light bg-opacity-50">
            <!-- Initial User Message -->
            <div class="d-flex flex-column align-items-start mb-4">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-primary text-white rounded-circle p-2" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <strong class="text-dark small">{{ $ticket->user_name }} ({{ $ticket->user_type }})</strong>
                    <small class="text-muted ms-2">{{ $ticket->created_at->diffForHumans() }}</small>
                </div>
                <div class="p-3.5 bg-white border border-light-subtle rounded-4 shadow-sm text-dark leading-relaxed ms-0 ms-md-4 w-100 max-w-2xl">
                    <h6 class="fw-bold text-primary mb-2">{{ $ticket->subject }}</h6>
                    {!! nl2br(e($ticket->message)) !!}

                    @if(!empty($ticket->attachments))
                        <div class="mt-3 pt-2 border-top">
                            <small class="fw-bold text-muted d-block mb-2"><i class="fa-solid fa-paperclip me-1"></i>المرفقات الأوليّة:</small>
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
                            <span class="badge bg-primary text-white rounded-circle p-2" style="width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <strong class="text-dark small">{{ $reply->sender_name }} (التاجر)</strong>
                            <small class="text-muted ms-2">{{ $reply->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="p-3.5 bg-white border border-light-subtle rounded-4 shadow-sm text-dark leading-relaxed ms-0 ms-md-4 w-100 max-w-2xl">
                            {!! nl2br(e($reply->message)) !!}

                            @if(!empty($reply->attachments))
                                <div class="mt-3 pt-2 border-top">
                                    <small class="fw-bold text-muted d-block mb-2"><i class="fa-solid fa-paperclip me-1"></i>المرفقات:</small>
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
                            <strong class="text-dark small me-1">{{ $reply->sender_name ?: 'فريق الأدمن والدعم' }} 🎧</strong>
                            <span class="badge text-white rounded-circle p-2" style="background-color: #a40c72; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-shield-halved"></i>
                            </span>
                        </div>
                        <div class="p-3.5 text-white rounded-4 shadow-sm leading-relaxed me-0 me-md-4 w-100 max-w-2xl" style="background-color: #a40c72;">
                            {!! nl2br(e($reply->message)) !!}

                            @if(!empty($reply->attachments))
                                <div class="mt-3 pt-2 border-top border-white border-opacity-25">
                                    <small class="fw-bold text-white-50 d-block mb-2"><i class="fa-solid fa-paperclip me-1"></i>المرفقات من الأدمن:</small>
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
        <div class="card-footer bg-white p-3 p-md-4 border-top">
            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-reply me-1 text-primary"></i>رد الأدمن المباشر على التذكرة:</h6>
            <form action="{{ route('admin.support_tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <textarea name="message" rows="4" class="form-control rounded-3 bg-light border-0" placeholder="اكتب ردك وملاحظاتك المباشرة للمستخدم..." required></textarea>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-2 w-100 w-md-auto">
                        <input type="file" name="attachments[]" class="form-control form-control-sm bg-light border-0 rounded-3" multiple accept="image/*,.pdf,.doc" style="max-width: 250px;">
                        <select name="status" class="form-select form-select-sm bg-light border-0 rounded-3" style="width: auto;">
                            <option value="answered" selected>تعيين الحالة: تم الرد</option>
                            <option value="in_progress">تعيين الحالة: قيد المراجعة</option>
                            <option value="closed">تعيين الحالة: إغلاق التذكرة</option>
                        </select>
                    </div>
                    <button type="submit" class="btn text-white px-4 py-2 fw-bold rounded-3 w-100 w-md-auto" style="background-color: #a40c72;">
                        <i class="fa-solid fa-paper-plane me-1"></i> إرسال الرد
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
