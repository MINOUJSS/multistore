<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-file-invoice-dollar text-warning"></i>
                    <span>{{ __('إدارة طلبات تسوية الفواتير') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🧾 طلبات تخليص الفواتير (بريدي موب و CCP) 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    مراجعة وتدقيق إثباتات تحويل تخليص الفواتير والموافقة عليها وتوثيق السجلات المالية.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm text-nowrap">
                        <i class="fa-solid fa-house me-1"></i> الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices Payments Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white w-100 overflow-hidden mb-4" style="max-width: 100%;">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-receipt" style="color: #a40c72;"></i>
                <span>سجل طلبات تخليص الفواتير</span>
            </div>
            <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill">إجمالي الفواتير: {{ $invoices->count() }}</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle text-center mb-0" id="invoicesPaymentsTable">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="py-3">#</th>
                            <th class="py-3">المستخدم</th>
                            <th class="py-3">المبلغ</th>
                            <th class="py-3">الطريقة</th>
                            <th class="py-3">تاريخ الإرسال</th>
                            <th class="py-3">ملاحظة</th>
                            <th class="py-3">الإثبات</th>
                            <th class="py-3">الحالة</th>
                            <th class="py-3">إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $index => $invoice)
                            <tr>
                                <td data-label="#" class="fw-bold text-secondary">{{ $index + 1 }}</td>
                                <td data-label="المستخدم" class="fw-bold text-dark text-start px-3">{{ $invoice->user->name ?? '—' }}</td>
                                <td data-label="المبلغ" class="fw-bold text-primary dir-ltr">{{ number_format($invoice->amount, 2, ',', '.') }} د.ج</td>
                                <td data-label="الطريقة">
                                    @if($invoice->payment_method === 'baridi-mob')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill">بريدي موب</span>
                                    @elseif($invoice->payment_method === 'Ccp')
                                        <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2.5 py-1 rounded-pill">CCP</span>
                                    @endif
                                </td>
                                <td data-label="تاريخ الإرسال" class="text-muted small dir-ltr">{{ $invoice->created_at->format('Y-m-d H:i') }}</td>
                                <td data-label="ملاحظة" class="text-muted small text-start px-3">{{ $invoice->description ?? '—' }}</td>
                                <td data-label="الإثبات">
                                    @if($invoice->payment_proof)
                                        @if(get_user_data_from_user_id($invoice->user_id)->type==='supplier')
                                            <a href="{{ asset('storage/tenantsupplier/app/public/' . $invoice->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-3 px-2.5">
                                                <i class="fa-solid fa-file-image me-1"></i> عرض الإثبات
                                            </a>
                                        @elseif(get_user_data_from_user_id($invoice->user_id)->type==='seller')
                                            <a href="{{ asset('storage/app/public/' . $invoice->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-3 px-2.5">
                                                <i class="fa-solid fa-file-image me-1"></i> عرض الإثبات
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td data-label="الحالة">
                                    @if($invoice->status === 'under_review')
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2.5 py-1 rounded-pill">قيد المراجعة</span>
                                    @elseif($invoice->status === 'approved')
                                        <span class="badge bg-success px-2.5 py-1 rounded-pill">تمت الموافقة</span>
                                    @endif
                                </td>
                                <td data-label="إجراء">
                                    @if($invoice->status === 'under_review')
                                        <form action="{{ route('admin.payments.invoice.approve', $invoice->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm rounded-3 px-3">الموافقة</button>
                                        </form>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($invoices->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fa-solid fa-file-invoice-dollar fs-2 mb-2 d-block opacity-50"></i>
                    <span>لا توجد طلبات تخليص فواتير حالياً.</span>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Pure CSS Responsive Table for #invoicesPaymentsTable */
@media (max-width: 991.98px) {
    #invoicesPaymentsTable, 
    #invoicesPaymentsTable tbody, 
    #invoicesPaymentsTable tr, 
    #invoicesPaymentsTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #invoicesPaymentsTable thead {
        display: none !important;
    }
    
    #invoicesPaymentsTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #invoicesPaymentsTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #invoicesPaymentsTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #invoicesPaymentsTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>
