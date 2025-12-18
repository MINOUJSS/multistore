<div class="container">
    <div class="container-fluid mt-4">

        <!-- عنوان الصفحة -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="fa-solid fa-scale-balanced me-2 text-primary"></i> تفاصيل النزاع رقم #{{ $dispute->id }}</h4>
            <a href="{{ route('admin.payment_proof.disputes') }}" class="btn btn-secondary btn-sm">
                ← العودة إلى القائمة
            </a>
        </div>

        <!-- معلومات الطلب -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <i class="fa-solid fa-receipt me-2"></i> معلومات الطلب
            </div>
            <div class="card-body">
                <p><strong>رقم الطلب:</strong> {{ $dispute->order_number }}</p>
                <p><strong>البائع / المورد:</strong> {{ $dispute->seller_id ?? 'غير متوفر' }}</p>
                <p><strong>تاريخ الإنشاء:</strong> {{ $dispute->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>الحالة الحالية:</strong>
                    <span
                        class="badge 
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
                </p>
            </div>
        </div>

        <!-- بيانات الزبون -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                <i class="fa-solid fa-user me-2"></i> بيانات الزبون
            </div>
            <div class="card-body">
                <p><strong>الاسم:</strong> {{ $dispute->customer_name ?? 'غير متوفر' }}</p>
                <p><strong>البريد الإلكتروني:</strong> {{ $dispute->customer_email ?? 'غير متوفر' }}</p>
                <p><strong>رقم الهاتف:</strong> {{ $dispute->customer_phone ?? 'غير متوفر' }}</p>
            </div>
        </div>

        <!-- تفاصيل النزاع -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning">
                <i class="fa-solid fa-message me-2"></i> تفاصيل النزاع
            </div>
            <div class="card-body">
                <p><strong>الموضوع:</strong> {{ $dispute->subject }}</p>
                <p><strong>الوصف:</strong></p>
                <div class="border p-2 rounded bg-light">
                    {!! nl2br(e($dispute->description)) !!}
                </div>
            </div>
        </div>

        <!-- الأدلة المرفقة -->
        @if (!empty($dispute->attachments))
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-info text-white">
                    <i class="fa-solid fa-paperclip me-2"></i> الأدلة المرفقة
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3">
                        @foreach (json_decode($dispute->attachments, true) as $index => $file)
                            <!---->
                            @php
                                $isImage = in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']);
                                $fileUrl = asset('storage/' . $file);
                            @endphp

                            @if ($isImage)
                                <a href="{{ $fileUrl }}" target="_blank">
                                    <img src="{{ $fileUrl }}" alt="attachment" class="rounded mt-1 border"
                                        style="max-width:150px; max-height:150px; border:1px solid #ccc;">
                                </a>
                            @else
                                <a href = "{{ $fileUrl }}" target = "_blank"
                                    class = "btn btn-light btn-sm d-inline-block me-1"> 📎مرفق
                                    {{ $index + 1 }} </a>
                            @endif

                            <!---->
                            {{-- <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-decoration-none">
                                <img src="{{ asset('storage/' . $file) }}" class="rounded border" width="120"
                                    alt="Attachment">
                            </a> --}}
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- ملاحظات الإدارة -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-secondary text-white">
                <i class="fa-solid fa-comments me-2"></i> ملاحظات الموظف / لجنة التحكيم
            </div>
            <div class="card-body">
                @if ($dispute->admin_notes)
                    <div class="bg-light border rounded p-2">{!! nl2br(e($dispute->admin_notes)) !!}</div>
                @else
                    <p class="text-muted">لا توجد ملاحظات حالياً.</p>
                @endif

                <form action="{{-- route('admin.payment_proof.dispute.updateNotes', $dispute->id) --}}" method="POST" class="mt-3">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <textarea name="admin_notes" class="form-control" rows="4" placeholder="أضف ملاحظتك هنا...">{{ old('admin_notes', $dispute->admin_notes) }}</textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-success">💬 حفظ الملاحظات</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- تغيير الحالة -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-dark text-white">
                <i class="fa-solid fa-toggle-on me-2"></i> إدارة حالة النزاع
            </div>
            <div class="card-body">
                <form action="{{ route('admin.payment_proof.dispute.updateStatus', $dispute->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <select name="status" class="form-select" required>
                                <option value="">-- اختر الحالة --</option>
                                @foreach (['open', 'in_review', 'resolved', 'escalated', 'rejected', 'closed'] as $status)
                                    <option value="{{ $status }}" @selected($dispute->status === $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="submit" class="btn btn-primary w-100">🔄 تحديث الحالة</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    @include('admins.admin.components.content.disputes.inc.chat_box')
</div>
