<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fa-solid fa-circle-xmark text-danger"></i> إثباتات الدفع المرفوضة</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">
            <i class="fa-solid fa-arrow-right"></i> العودة للرئيسية
        </a>
        <a href="{{ route('admin.payment_proof.disputes.refused.archive') }}" class="btn btn-sm btn-secondary">
            <i class="fa-solid fa-box-archive"></i>الأرشيف
        </a>
    </div>

    @if ($proofs->isEmpty())
        <div class="alert alert-info text-center shadow-sm">
            <i class="fa-solid fa-info-circle"></i> لا توجد أي إثباتات مرفوضة حالياً.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped align-middle shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>رقم الطلب</th>
                        <th>المورد</th>
                        <th>صورة الإثبات</th>
                        <th>سبب الرفض</th>
                        <th>المسؤول</th>
                        <th>تاريخ الرفض</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proofs as $proof)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge bg-primary">{{ $proof->order_number }}</span></td>
                            <td>
                                @if($proof->user)
                                    {{ $proof->user->name }}<br>
                                    <small class="text-muted">{{ $proof->user->email }}</small>
                                @else
                                    <span class="text-muted">غير معروف</span>
                                @endif
                            </td>
                            <td>
                                @if($proof->proof_path)
                                    <a href="{{ $proof->proof_path}}" target="_blank">
                                        <img src="{{$proof->proof_path}}" alt="إثبات الدفع" 
                                             style="width:60px;height:60px;object-fit:cover;border-radius:8px;border:1px solid #ddd;">
                                    </a>
                                @else
                                    <span class="text-muted">لا يوجد</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($proof->refuse_reason, 50) }}</td>
                            <td>
                                @if($proof->admin)
                                    {{ $proof->admin->name }}
                                @else
                                    <span class="text-muted">غير محدد</span>
                                @endif
                            </td>
                            <td>{{ $proof->created_at ? $proof->created_at->format('Y-m-d H:i') : '-' }}</td>
                            <td>
                                <a href="{{ route('admin.payment_proof.dispute.refused.show', $proof->id) }}" 
                                   class="btn btn-sm btn-outline-info">
                                    <i class="fa-solid fa-eye"></i> عرض
                                </a>
                                 @if($proof->status != 'in_review')
                                <form action="{{ route('admin.payment_proof.refused.destroy', $proof->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا السجل؟')">
                                        <i class="fa-solid fa-trash"></i> حذف
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $proofs->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>