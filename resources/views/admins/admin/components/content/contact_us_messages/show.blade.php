<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <a href="{{ route('admin.contact.messages') }}" class="btn btn-sm btn-light text-dark rounded-circle border-0 shadow-sm" title="العودة للقائمة">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small border border-white border-opacity-10">
                        <i class="fa-solid fa-envelope-open text-warning"></i>
                        <span>{{ __('محتوى رسالة الاتصال') }}</span>
                    </div>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    {{ $message->subject }}
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    المرسل: <strong class="text-white">{{ $message->name }}</strong> — <span class="dir-ltr text-white-50">{{ $message->email }}</span>
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.contact.messages') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
                        <i class="fa-solid fa-list me-1"></i> العودة للرسائل
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
                <div class="fw-semibold">{{ session()->get('success') }}</div>
            </div>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Message Content Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0 d-flex align-items-center justify-content-between">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-paper-plane me-2" style="color: #a40c72;"></i>تفاصيل وقراءة الرسالة
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-muted fw-semibold d-block mb-1">اسم المرسل:</small>
                        <div class="fw-bold text-dark fs-6">{{ $message->name }}</div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="p-3 bg-light rounded-3">
                        <small class="text-muted fw-semibold d-block mb-1">البريد الإلكتروني:</small>
                        <div class="fw-bold text-dark fs-6 dir-ltr text-start">{{ $message->email }}</div>
                    </div>
                </div>
            </div>

            <div class="p-3.5 bg-light bg-opacity-50 border rounded-4 text-dark leading-relaxed">
                <h6 class="fw-bold text-primary mb-2"><b>الموضوع: </b>{{ $message->subject }}</h6>
                <div class="fs-6 mt-3">
                    <b>نص الرسالة: </b>
                    <p class="mb-0 mt-2 text-secondary">{!! nl2br(e($message->message)) !!}</p>
                </div>
            </div>
        </div>
    </div>

    @if(count($message->replies)==0 && $message->is_read==0)
        <!-- Reply Form Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-0">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-reply me-2" style="color: #a40c72;"></i>فورم الرد على الرسالة
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.contact.message.reply', $message->id) }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="reply" class="form-label fw-semibold text-dark mb-2">نص الرد المباشر</label>
                        <textarea class="form-control bg-light border-0 rounded-3" name="reply" id="reply" rows="4" placeholder="اكتب رد الأدمن المباشر للعميل..." required></textarea>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn text-white px-4 py-2 fw-bold rounded-3" style="background-color: #a40c72;">
                            <i class="fa-solid fa-paper-plane me-1"></i> إرسال الرد
                        </button>
                        <button type="button" class="btn btn-outline-danger px-4 py-2 fw-bold rounded-3" onclick="ignoreReply({{ $message->id }})">
                            <i class="fa-solid fa-eye-slash me-1"></i> تجاهل الرد
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        @if(count($message->replies)>0)
            <!-- Existing Replies Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-0">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="fa-solid fa-comments me-2" style="color: #a40c72;"></i>سجل الردود المعالجة
                    </h5>
                </div>
                <div class="card-body p-4">
                    @foreach($message->replies as $reply)
                        <div class="p-3.5 bg-light rounded-4 mb-3 border">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold text-dark mb-0">
                                    <i class="fa-solid fa-user-shield me-1 text-primary"></i> تم الرد من طرف: {{ get_admin_data_from_id($reply->admin_id)->name }}
                                </h6>
                                <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="card-text text-secondary mb-0"><b>الرد: </b>{{ $reply->reply }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @else 
            <!-- Ignored Status Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
                <div class="card-body p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle p-3 mb-2" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-eye-slash fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-1">تم تجاهل الرد على هذه الرسالة</h5>
                    <p class="text-muted small mb-0">تم تعليم هذه الرسالة كمقروءة وتجاهل الرد التلقائي عليها.</p>
                </div>
            </div>
        @endif
    @endif

</div>