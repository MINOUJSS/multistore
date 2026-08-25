<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-circle-xmark text-warning"></i>
                    <span>{{ __('إداريات التدقيق المالي') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🚫 إثباتات الدفع المرفوضة 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    عرض وحفظ سجل إثباتات التحويلات الحسابية والدفع التي تم رفضها وتوثيق أسباب الرفض.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.payment_proof.disputes.refused.archive') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm text-nowrap">
                        <i class="fa-solid fa-box-archive me-1"></i> الأرشيف
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm text-nowrap">
                        <i class="fa-solid fa-arrow-right me-1"></i> الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if ($proofs->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 bg-white p-5 text-center my-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info rounded-circle p-3 mb-3 mx-auto" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-circle-info fs-3"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">لا توجد إثباتات دفع مرفوضة حالياً</h5>
            <p class="text-muted small mb-0">جميع السجلات والتحويلات معالجة ولم تسجل أي مرفوضات معلقة.</p>
        </div>
    @else
        <!-- Refused Payments Table Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white w-100 overflow-hidden mb-4" style="max-width: 100%;">
            <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-list-ul" style="color: #a40c72;"></i>
                    <span>سجل إثباتات الدفع المرفوضة</span>
                </div>
                <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill">عدد الإثباتات: {{ $proofs->count() }}</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive p-0">
                    <table class="table table-hover align-middle text-center mb-0" id="refusedPaymentsTable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="py-3">#</th>
                                <th class="py-3">رقم الطلب</th>
                                <th class="py-3">المورد</th>
                                <th class="py-3">صورة الإثبات</th>
                                <th class="py-3">سبب الرفض</th>
                                <th class="py-3">المسؤول</th>
                                <th class="py-3">تاريخ الرفض</th>
                                <th class="py-3">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proofs as $proof)
                                <tr>
                                    <td data-label="#" class="fw-bold text-secondary">{{ $loop->iteration }}</td>
                                    <td data-label="رقم الطلب"><span class="badge bg-light text-primary border px-2.5 py-1.5 rounded-3 fw-bold">{{ $proof->order_number }}</span></td>
                                    <td data-label="المورد" class="text-start px-3">
                                        @if($proof->user)
                                            <div class="fw-bold text-dark">{{ $proof->user->name }}</div>
                                            <small class="text-muted dir-ltr d-block">{{ $proof->user->email }}</small>
                                        @else
                                            <span class="text-muted">غير معروف</span>
                                        @endif
                                    </td>
                                    <td data-label="صورة الإثبات">
                                        @if($proof->proof_path)
                                            <a href="{{ $proof->proof_path}}" target="_blank" class="d-inline-block">
                                                <img src="{{$proof->proof_path}}" alt="إثبات الدفع" class="rounded-3 border shadow-sm object-fit-cover hover-lift"
                                                     style="width:52px; height:52px;">
                                            </a>
                                        @else
                                            <span class="text-muted small">لا يوجد</span>
                                        @endif
                                    </td>
                                    <td data-label="سبب الرفض" class="text-start px-3 text-break small text-danger fw-semibold">
                                        {{ Str::limit($proof->refuse_reason, 50) }}
                                    </td>
                                    <td data-label="المسؤول">
                                        @if($proof->admin)
                                            <span class="badge bg-light text-dark border px-2.5 py-1 rounded-3">{{ $proof->admin->name }}</span>
                                        @else
                                            <span class="text-muted small">غير محدد</span>
                                        @endif
                                    </td>
                                    <td data-label="تاريخ الرفض" class="text-muted small">
                                        {{ $proof->created_at ? $proof->created_at->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td data-label="الإجراءات">
                                        <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                            <a href="{{ route('admin.payment_proof.dispute.refused.show', $proof->id) }}" 
                                               class="btn btn-sm btn-outline-info rounded-3 px-2.5">
                                                <i class="fa-solid fa-eye me-1"></i> عرض
                                            </a>
                                            @if($proof->status != 'in_review')
                                                <form action="{{ route('admin.payment_proof.refused.destroy', $proof->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2.5"
                                                            onclick="return confirm('هل أنت متأكد من حذف هذا السجل؟')">
                                                        <i class="fa-solid fa-trash me-1"></i> حذف
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3 text-center border-top bg-light">
                    {{ $proofs->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @endif
</div>

<style>
/* Pure CSS Responsive Table for #refusedPaymentsTable */
@media (max-width: 991.98px) {
    #refusedPaymentsTable, 
    #refusedPaymentsTable tbody, 
    #refusedPaymentsTable tr, 
    #refusedPaymentsTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #refusedPaymentsTable thead {
        display: none !important;
    }
    
    #refusedPaymentsTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #refusedPaymentsTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #refusedPaymentsTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #refusedPaymentsTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>