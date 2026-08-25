<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <a href="{{ route('admin.payment_proof.disputes.refused') }}" class="btn btn-sm btn-light text-dark rounded-circle border-0 shadow-sm" title="العودة للقائمة">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small border border-white border-opacity-10">
                        <i class="fa-solid fa-circle-xmark text-warning"></i>
                        <span>{{ __('تفاصيل الإثبات المرفوض') }}</span>
                    </div>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🚫 طلب رقم: {{ $proof->order_number }} 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    المورد: <strong class="text-white">{{ $proof->user->name ?? 'غير معروف' }}</strong> — المسؤول: <span class="text-white-50">{{ $proof->admin->name ?? 'غير محدد' }}</span>
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.payment_proof.disputes.refused') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
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
                    <i class="fa-solid fa-receipt me-2" style="color: #a40c72;"></i> بيانات الطلب والمورد
                </h5>
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">رقم الطلب:</small>
                            <div class="fw-bold text-dark fs-6">{{ $proof->order_number }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">تاريخ الرفض:</small>
                            <div class="fw-bold text-dark fs-6 dir-ltr text-start">{{ $proof->created_at ? $proof->created_at->format('Y-m-d H:i') : '-' }}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">المورد المستهدف:</small>
                            @if($proof->user)
                                <div class="fw-bold text-dark fs-6">{{ $proof->user->name }}</div>
                                <small class="text-muted dir-ltr d-block">{{ $proof->user->email }}</small>
                            @else
                                <span class="text-muted fs-6">غير معروف</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">المسؤول الذي رفض الدفع:</small>
                            <div class="fw-bold text-dark fs-6">{{ $proof->admin->name ?? 'غير محدد' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Proof Image Card -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4 text-center">
                <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom text-start">
                    <i class="fa-solid fa-image me-2" style="color: #a40c72;"></i> صورة الإثبات المعالجة
                </h5>
                @php
                $split_path = explode('/', $proof->proof_path);
                $path = '';
                for($i = 4; $i < count($split_path); $i++){
                    $path .= $split_path[$i] . ($i != count($split_path) - 1 ? '/': '');
                }
                @endphp
                @if($proof->proof_path && file_exists(storage_path($path)))
                    <a href="{{$proof->proof_path}}" target="_blank" class="d-inline-block mt-2">
                        <img src="{{$proof->proof_path}}" alt="إثبات الدفع"
                             class="rounded-4 border shadow-sm object-fit-cover hover-lift img-fluid"
                             style="max-height: 220px; width: auto;">
                    </a>
                @else
                    <div class="p-4 bg-light rounded-3 text-muted my-auto">
                        <i class="fa-solid fa-image-slash fs-2 mb-2 d-block opacity-50"></i>
                        <span>لا توجد صورة إثبات متاحة أو الملف غير موجود.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Refusal Reason Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-comment-dots me-2 text-danger"></i>سبب الرفض المسجل
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="p-3.5 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-4 text-danger leading-relaxed">
                {{ $proof->refuse_reason ?? 'لم يتم ذكر سبب محدد.' }}
            </div>

            @if($proof->status != 'in_review')       
                <div class="mt-4 d-flex justify-content-end gap-2 flex-wrap">
                    <a class="btn btn-outline-primary rounded-3 px-3 py-2 fw-bold" href="#"><i class="fa-solid fa-file-pdf me-1"></i> إنشاء ملف PDF</a>
                    <form action="{{-- route('admin.payments_refused.destroy', $proof->id) --}}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-3 px-3 py-2 fw-bold"
                                onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا السجل نهائياً؟')">
                            <i class="fa-solid fa-trash me-1"></i> حذف السجل
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Status & Notes Form Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-pen-to-square me-2" style="color: #a40c72;"></i>تعديل الحالة والملاحظات
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.payment_proof.refused.update', $proof->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="admin_notes" class="form-label fw-bold text-dark">ملاحظات الأدمن:</label>
                    <textarea class="form-control bg-light border-0 rounded-3" id="admin_notes" name="admin_notes" rows="3" placeholder="أضف ملاحظات الأدمن هنا...">{{ $proof->admin_notes ?? '' }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="status" class="form-label fw-bold text-dark">الحالة الحالية:</label>
                    <select class="form-select bg-light border-0 rounded-3 py-2.5" id="status" name="status">
                        <option value="in_review" {{ $proof->status == 'in_review' ? 'selected' : '' }}>قيد المراجعة</option>
                        <option value="approved" {{ $proof->status == 'approved' ? 'selected' : '' }}>مقبول</option>
                        <option value="refused" {{ $proof->status == 'refused' ? 'selected' : '' }}>مرفوض</option>
                        <option value="archived" {{ $proof->status == 'archived' ? 'selected' : '' }}>مؤرشف</option>
                    </select>
                </div>

                <button type="submit" class="btn text-white px-4 py-2.5 rounded-3 fw-bold shadow-sm" style="background-color: #a40c72;">
                    <i class="fa-solid fa-floppy-disk me-1"></i> حفظ التغييرات
                </button>
            </form>
        </div>
    </div>

    <!-- Include Chat Box -->
    @include('admins.admin.components.content.payments_proofs_refused.inc.chat_box')
</div>
