<div class="container-fluid py-4 overflow-hidden" style="max-width: 100%;">
    <h2 class="text-center fw-bold mb-4">طلبات شحن الرصيد (بريدي موب و CCP)</h2>

    <div class="card shadow-sm border-0 w-100 overflow-hidden" style="max-width: 100%;">
        <div class="card-body p-0">
            <div class="table-responsive p-0">
                <table class="table table-bordered table-hover text-center align-middle mb-0" id="paymentsTable">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>المستخدم</th>
                            <th>المبلغ</th>
                            <th>الطريقة</th>
                            <th>تاريخ الإرسال</th>
                            <th>ملاحظة</th>
                            <th>الإثبات</th>
                            <th>الحالة</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $index => $request)
                            <tr>
                                <td data-label="#">{{ $index + 1 }}</td>
                                <td data-label="المستخدم">{{ $request->user->name ?? '—' }}</td>
                                <td data-label="المبلغ" class="fw-bold">{{ number_format($request->amount, 2, ',', '.') }} د.ج</td>
                                <td data-label="الطريقة">
                                    @if($request->payment_method === 'BaridiMob')
                                        <span class="badge bg-success">بريدي موب</span>
                                    @elseif($request->payment_method === 'Ccp')
                                        <span class="badge bg-warning text-dark">CCP</span>
                                    @endif
                                </td>
                                <td data-label="تاريخ الإرسال">{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                <td data-label="ملاحظة">{{ $request->description ?? '—' }}</td>
                                <td data-label="الإثبات">
                                    @if($request->payment_proof)
                                        <a href="{{ asset('storage/tenantsupplier/app/public/' . $request->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            عرض الإثبات
                                        </a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td data-label="الحالة">
                                    @if($request->status === 'pending')
                                        <span class="badge bg-secondary">قيد المراجعة</span>
                                    @elseif($request->status === 'approved')
                                        <span class="badge bg-success">تمت الموافقة</span>
                                    @endif
                                </td>
                                <td data-label="إجراء">
                                    @if($request->status === 'pending')
                                        <form action="{{ route('admin.payment.approve', $request->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">الموافقة</button>
                                        </form>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($requests->isEmpty())
                <div class="text-center text-muted py-4">لا توجد طلبات حالياً.</div>
            @endif
        </div>
    </div>
</div>

<style>
/* Pure CSS Responsive Table for #paymentsTable */
@media (max-width: 991.98px) {
    #paymentsTable, 
    #paymentsTable tbody, 
    #paymentsTable tr, 
    #paymentsTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #paymentsTable thead {
        display: none !important;
    }
    
    #paymentsTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #paymentsTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #paymentsTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #paymentsTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>
