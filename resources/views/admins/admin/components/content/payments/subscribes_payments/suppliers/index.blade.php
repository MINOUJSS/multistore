<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-truck-field text-warning"></i>
                    <span>{{ __('إدارة اشتراكات الموردين') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🏬 طلبات تسديد الاشتراكات (الموردون) 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    مراجعة وتدقيق إثباتات تحويل اشتراكات الموردين والموافقة عليها لتفعيل الباقات والحسابات.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.payments.subscribes_payments') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm text-nowrap">
                        <i class="fa-solid fa-rotate-left me-1"></i> دليل الاشتراكات
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm text-nowrap">
                        <i class="fa-solid fa-house me-1"></i> الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Supplier Subscribes Payments Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white w-100 overflow-hidden mb-4" style="max-width: 100%;">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-calendar-check" style="color: #a40c72;"></i>
                <span>سجل طلبات تسديد اشتراكات الموردين</span>
            </div>
            <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill">إجمالي الطلبات: {{ $subscriptionRequests->count() }}</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle text-center mb-0" id="supplierSubscribesPaymentsTable">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="py-3">#</th>
                            <th class="py-3">المورد</th>
                            <th class="py-3">الخطة</th>
                            <th class="py-3">السعر</th>
                            <th class="py-3">المدة</th>
                            <th class="py-3">طريقة الدفع</th>
                            <th class="py-3">تاريخ</th>
                            <th class="py-3">الإثبات</th>
                            <th class="py-3">الحالة</th>
                            <th class="py-3">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscriptionRequests as $index => $order)
                            <tr>
                                <td data-label="#" class="fw-bold text-secondary">{{ $index + 1 }}</td>
                                <td data-label="المورد" class="fw-bold text-dark text-start px-3">{{ $order->supplier->full_name ?? '—' }}</td>
                                <td data-label="الخطة"><span class="badge bg-light text-dark border px-2.5 py-1 rounded-3">{{ $order->plan->name ?? '—' }}</span></td>
                                <td data-label="السعر" class="fw-bold text-primary dir-ltr">{{ number_format($order->price, 2, ',', '.') }} د.ج</td>
                                <td data-label="المدة" class="fw-semibold text-dark">{{ $order->duration }} يوم</td>
                                <td data-label="طريقة الدفع">
                                    @switch($order->payment_method)
                                        @case('wallet')
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2.5 py-1 rounded-pill">رصيد المحفظة</span>
                                            @break
                                        @case('baridimob')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill">بريدي موب</span>
                                            @break
                                        @case('ccp')
                                            <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-2.5 py-1 rounded-pill">CCP</span>
                                            @break
                                        @case('chargily')
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1 rounded-pill">chargily</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary px-2.5 py-1 rounded-pill">غير محدد</span>
                                    @endswitch
                                </td>
                                <td data-label="تاريخ" class="text-muted small dir-ltr">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td data-label="الإثبات">
                                    @if($order->payment_proof)
                                        <a href="{{ asset('storage/tenantsupplier/app/public/' . $order->payment_proof) }}"
                                           target="_blank" class="btn btn-sm btn-outline-primary rounded-3 px-2.5">
                                           <i class="fa-solid fa-eye me-1"></i> عرض
                                        </a>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td data-label="الحالة">
                                    @if($order->payment_status === 'unpaid')
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2.5 py-1 rounded-pill">قيد المراجعة</span>
                                    @elseif($order->payment_status === 'paid')
                                        <span class="badge bg-success px-2.5 py-1 rounded-pill">مدفوعة</span>
                                    @elseif($order->payment_status === 'failed')
                                        <span class="badge bg-danger px-2.5 py-1 rounded-pill">مرفوضة</span>
                                    @endif
                                </td>
                                <td data-label="الإجراء">
                                    @if($order->payment_status === 'unpaid' && $order->payment_proof != null)
                                        <form action="{{ route('admin.payments.suppliers.subscribe.approve', $order->id) }}" method="POST" onsubmit="return confirm('تأكيد الموافقة على الدفع؟');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success rounded-3 px-3">الموافقة</button>
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

            @if($subscriptionRequests->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fa-solid fa-truck-field fs-2 mb-2 d-block opacity-50"></i>
                    <span>لا توجد طلبات اشتراك حالياً.</span>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Pure CSS Responsive Table for #supplierSubscribesPaymentsTable */
@media (max-width: 991.98px) {
    #supplierSubscribesPaymentsTable, 
    #supplierSubscribesPaymentsTable tbody, 
    #supplierSubscribesPaymentsTable tr, 
    #supplierSubscribesPaymentsTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #supplierSubscribesPaymentsTable thead {
        display: none !important;
    }
    
    #supplierSubscribesPaymentsTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #supplierSubscribesPaymentsTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #supplierSubscribesPaymentsTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #supplierSubscribesPaymentsTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>
