<div class="container-fluid py-4 overflow-hidden" style="max-width: 100%;">
    <h2 class="text-center fw-bold mb-4">
        <i class="fa-solid fa-calendar-check text-primary me-2"></i>
        طلبات تسديد الاشتراكات (البائعون)
    </h2>

    <div class="card shadow-sm border-0 rounded-4 w-100 overflow-hidden" style="max-width: 100%;">
        <div class="card-body p-0">
            <div class="table-responsive p-0">
                <table class="table table-bordered table-hover text-center align-middle mb-0" id="sellerSubscribesPaymentsTable">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>البائع</th>
                            <th>الخطة</th>
                            <th>السعر</th>
                            <th>المدة</th>
                            <th>طريقة الدفع</th>
                            <th>تاريخ</th>
                            <th>الإثبات</th>
                            <th>الحالة</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscriptionRequests as $index => $order)
                            <tr>
                                <td data-label="#">{{ $index + 1 }}</td>
                                <td data-label="البائع" class="fw-semibold">{{ $order->seller->full_name ?? '—' }}</td>
                                <td data-label="الخطة">{{ $order->plan->name ?? '—' }}</td>
                                <td data-label="السعر" class="fw-bold">{{ number_format($order->price, 2, ',', '.') }} د.ج</td>
                                <td data-label="المدة">{{ $order->duration }} يوم</td>
                                <td data-label="طريقة الدفع">
                                    @switch($order->payment_method)
                                        @case('wallet')
                                            <span class="badge bg-info text-dark">رصيد المحفظة</span>
                                            @break
                                        @case('baridimob')
                                            <span class="badge bg-success">بريدي موب</span>
                                            @break
                                        @case('ccp')
                                            <span class="badge bg-warning text-dark">CCP</span>
                                            @break
                                        @case('chargily')
                                            <span class="badge bg-warning text-dark">chargily</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">غير محدد</span>
                                    @endswitch
                                </td>
                                <td data-label="تاريخ">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td data-label="الإثبات">
                                    @if($order->payment_proof)
                                        <a href="{{ asset('storage/app/public/' . $order->payment_proof) }}"
                                           target="_blank" class="btn btn-sm btn-outline-primary">
                                           عرض
                                        </a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td data-label="الحالة">
                                    @if($order->payment_status === 'unpaid')
                                        <span class="badge bg-secondary">قيد المراجعة</span>
                                    @elseif($order->payment_status === 'paid')
                                        <span class="badge bg-success">مدفوعة</span>
                                    @elseif($order->payment_status === 'failed')
                                        <span class="badge bg-danger">مرفوضة</span>
                                    @endif
                                </td>
                                <td data-label="الإجراء">
                                    @if($order->payment_status === 'unpaid' && $order->payment_proof != null)
                                        <form action="{{ route('admin.payments.sellers.subscribe.approve', $order->id) }}" method="POST" onsubmit="return confirm('تأكيد الموافقة على الدفع؟');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">الموافقة</button>
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

            @if($subscriptionRequests->isEmpty())
                <div class="text-center text-muted py-4">لا توجد طلبات اشتراك حالياً.</div>
            @endif
        </div>
    </div>
</div>

<style>
/* Pure CSS Responsive Table for #sellerSubscribesPaymentsTable */
@media (max-width: 991.98px) {
    #sellerSubscribesPaymentsTable, 
    #sellerSubscribesPaymentsTable tbody, 
    #sellerSubscribesPaymentsTable tr, 
    #sellerSubscribesPaymentsTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #sellerSubscribesPaymentsTable thead {
        display: none !important;
    }
    
    #sellerSubscribesPaymentsTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #sellerSubscribesPaymentsTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #sellerSubscribesPaymentsTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #sellerSubscribesPaymentsTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>
