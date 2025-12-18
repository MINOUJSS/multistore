<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fa-solid fa-circle-xmark text-danger"></i> تفاصيل إثبات الدفع المرفوض</h3>
        <a href="{{ route('admin.payment_proof.disputes.refused') }}" class="btn btn-sm btn-secondary">
            <i class="fa-solid fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <h5 class="text-primary mb-3"><i class="fa-solid fa-receipt"></i> بيانات الطلب</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>رقم الطلب:</strong> {{ $proof->order_number }}</li>
                        <li class="list-group-item">
                            <strong>المورد:</strong>
                            @if($proof->user)
                                {{ $proof->user->name }} <br>
                                <small class="text-muted">{{ $proof->user->email }}</small>
                            @else
                                <span class="text-muted">غير معروف</span>
                            @endif
                        </li>
                        <li class="list-group-item"><strong>المسؤول الذي رفض الدفع:</strong>
                            {{ $proof->admin->name ?? 'غير محدد' }}
                        </li>
                        <li class="list-group-item"><strong>تاريخ الرفض:</strong>
                            {{ $proof->created_at ? $proof->created_at->format('Y-m-d H:i') : '-' }}
                        </li>
                    </ul>
                </div>

                <div class="col-md-6 text-center">
                    <h5 class="text-danger mb-3"><i class="fa-solid fa-image"></i> صورة الإثبات</h5>
                    @php
                    $split_path = explode('/', $proof->proof_path);
                    $path = '';
                    for($i = 4; $i < count($split_path); $i++){
                        $path .= $split_path[$i] . ($i != count($split_path) - 1 ? '/': '');
                    }
                    @endphp
                    {{-- {{dd($proof->proof_path,$path)}} --}}
                    @if($proof->proof_path && file_exists(storage_path($path)))
                        <a href="{{$proof->proof_path}}" target="_blank">
                            <img src="{{$proof->proof_path}}" alt="إثبات الدفع"
                                 class="img-fluid rounded shadow-sm border"
                                 style="max-width: 100%; height: auto;">
                        </a>
                    @else
                        <p class="text-muted">لا توجد صورة متاحة.</p>
                    @endif
                </div>
            </div>

            <hr class="my-4">

            <div class="mt-3">
                <h5 class="text-warning mb-3"><i class="fa-solid fa-comment-dots"></i> سبب الرفض</h5>
                <div class="p-3 bg-light rounded border">
                    {{ $proof->refuse_reason ?? 'لم يتم ذكر سبب محدد.' }}
                </div>
            </div>
            @if($proof->status != 'in_review')       
            <div class="mt-4 text-end">
                <a class="btn btn-sm btn-primary" href="#"><i class="fa-solid fa-arrow-left"></i>إنشاء ملف PDF</a>
                <form action="{{-- route('admin.payments_refused.destroy', $proof->id) --}}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا السجل نهائياً؟')">
                        <i class="fa-solid fa-trash"></i> حذف السجل
                    </button>
                </form>
            </div>
            @endif

            {{-- New form for editing admin_notes and status --}}
            <div class="mt-4">
                <h5 class="text-primary mb-3"><i class="fa-solid fa-pen-to-square"></i> تعديل الحالة والملاحظات</h5>
                <form action="{{ route('admin.payment_proof.refused.update', $proof->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">ملاحظات الأدمن</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3">{{ $proof->admin_notes ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">الحالة</label>
                        <select class="form-select" id="status" name="status">
                            <option value="in_review" {{ $proof->status == 'in_review' ? 'selected' : '' }}>قيد المراجعة</option>
                            <option value="approved" {{ $proof->status == 'approved' ? 'selected' : '' }}>مقبول</option>
                            <option value="refused" {{ $proof->status == 'refused' ? 'selected' : '' }}>مرفوض</option>
                            <option value="archived" {{ $proof->status == 'archived' ? 'selected' : '' }}>مؤرشف</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> حفظ التغييرات
                    </button>
                </form>
            </div>
            {{-- End of new form --}}

        </div> {{-- Closing card-body --}}
    </div> {{-- Closing card --}}
    <!--include chat box-->
    @include('admins.admin.components.content.payments_proofs_refused.inc.chat_box')
</div> {{-- Closing container --}}
