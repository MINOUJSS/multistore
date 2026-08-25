<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <a href="{{ route('admin.payment_proof.disputes') }}" class="btn btn-sm btn-light text-dark rounded-circle border-0 shadow-sm" title="العودة للقائمة">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small border border-white border-opacity-10">
                        <i class="fa-solid fa-scale-balanced text-warning"></i>
                        <span>{{ __('تفاصيل وقرارات النزاع') }}</span>
                        <span class="opacity-50">|</span>
                        <span>#{{ $dispute->id }}</span>
                    </div>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    ⚖️ النزاع رقم #{{ $dispute->id }} 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    طلب رقم: <strong class="text-white">{{ $dispute->order_number }}</strong> — الموضوع: <span class="text-white-50">{{ $dispute->subject }}</span>
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.payment_proof.disputes') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
                        <i class="fa-solid fa-list me-1"></i> العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Order Info Card -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4">
                <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-receipt me-2" style="color: #a40c72;"></i> معلومات الطلب
                </h5>
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">رقم الطلب:</small>
                            <div class="fw-bold text-dark fs-6">{{ $dispute->order_number }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">تاريخ الإنشاء:</small>
                            <div class="fw-bold text-dark fs-6 dir-ltr text-start">{{ $dispute->created_at->format('Y-m-d H:i') }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">البائع / المورد:</small>
                            <div class="fw-bold text-dark fs-6">{{ $dispute->seller_id ?? 'غير متوفر' }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">الحالة الحالية:</small>
                            <div>
                                <span class="badge px-3 py-1.5 rounded-pill fw-semibold
                                    @switch($dispute->status)
                                        @case('open') bg-warning text-dark @break
                                        @case('in_review') bg-info text-dark @break
                                        @case('resolved') bg-success @break
                                        @case('escalated') bg-danger @break
                                        @case('rejected') bg-secondary @break
                                        @case('closed') bg-dark @break
                                    @endswitch">
                                    {{ __('statuses.' . $dispute->status) ?? $dispute->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Info Card -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4">
                <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                    <i class="fa-solid fa-user me-2" style="color: #a40c72;"></i> بيانات الزبون
                </h5>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">الاسم الكامل:</small>
                            <div class="fw-bold text-dark fs-6">{{ $dispute->customer_name ?? 'غير متوفر' }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">البريد الإلكتروني:</small>
                            <div class="fw-bold text-dark fs-6 dir-ltr text-start">{{ $dispute->customer_email ?? 'غير متوفر' }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">رقم الهاتف:</small>
                            <div class="fw-bold text-dark fs-6 dir-ltr text-start">{{ $dispute->customer_phone ?? 'غير متوفر' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dispute Description Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-message me-2" style="color: #a40c72;"></i>تفاصيل وقضية النزاع
            </h5>
        </div>
        <div class="card-body p-4">
            <h6 class="fw-bold text-primary mb-2"><b>الموضوع: </b>{{ $dispute->subject }}</h6>
            <div class="fs-6 mt-3">
                <b class="d-block mb-2 text-dark">الوصف والتفاصيل:</b>
                <div class="p-3.5 bg-light rounded-4 text-dark leading-relaxed border-0" style="white-space: pre-line;">
                    {!! nl2br(e($dispute->description)) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Attachments Card -->
    @if (!empty($dispute->attachments))
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-0">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-paperclip me-2" style="color: #a40c72;"></i>الأدلة والملفات المرفقة
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-wrap gap-3">
                    @foreach (json_decode($dispute->attachments, true) as $index => $file)
                        @php
                            $isImage = in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']);
                            $fileUrl = asset('storage/' . $file);
                        @endphp

                        @if ($isImage)
                            <a href="{{ $fileUrl }}" target="_blank" class="d-inline-block">
                                <img src="{{ $fileUrl }}" alt="attachment" class="rounded-3 border shadow-sm object-fit-cover hover-lift"
                                    style="width: 140px; height: 140px;">
                            </a>
                        @else
                            <a href="{{ $fileUrl }}" target="_blank"
                                class="btn btn-light border btn-sm rounded-3 px-3 py-2 d-inline-flex align-items-center gap-2">
                                <i class="fa-solid fa-paperclip text-primary"></i> <span>مرفق {{ $index + 1 }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Admin Notes Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-comments me-2" style="color: #a40c72;"></i>ملاحظات الموظف / لجنة التحكيم
            </h5>
        </div>
        <div class="card-body p-4">
            @if ($dispute->admin_notes)
                <div class="bg-light border-0 rounded-3 p-3 mb-3 text-dark">{!! nl2br(e($dispute->admin_notes)) !!}</div>
            @else
                <p class="text-muted small mb-3">لا توجد ملاحظات منسقة حالياً.</p>
            @endif

            <form action="{{-- route('admin.payment_proof.dispute.updateNotes', $dispute->id) --}}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <textarea name="admin_notes" class="form-control bg-light border-0 rounded-3" rows="4" placeholder="أضف ملاحظات لجنة التحكيم أو الإدارة هنا...">{{ old('admin_notes', $dispute->admin_notes) }}</textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn text-white rounded-3 px-4 py-2 fw-bold" style="background-color: #a40c72;">
                        <i class="fa-solid fa-floppy-disk me-1"></i> حفظ الملاحظات
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Status Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-toggle-on me-2" style="color: #a40c72;"></i>إدارة وحسم حالة النزاع
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.payment_proof.dispute.updateStatus', $dispute->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-8">
                        <select name="status" class="form-select bg-light border-0 rounded-3 py-2.5" required>
                            <option value="">-- اختر الحالة الجديدة --</option>
                            @foreach (['open', 'in_review', 'resolved', 'escalated', 'rejected', 'closed'] as $status)
                                <option value="{{ $status }}" @selected($dispute->status === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <button type="submit" class="btn text-white w-100 rounded-3 py-2.5 fw-bold" style="background-color: #a40c72;">
                            <i class="fa-solid fa-rotate me-1"></i> تحديث الحالة
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('admins.admin.components.content.disputes.inc.chat_box')
</div>
