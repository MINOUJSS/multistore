<div class="container mt-5">
    <h2 class="text-center mb-4">فواتير تاجر الجملة</h2>
<!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        <a href="{{route('supplier.billing.invoice.create')}}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i>تحرير فاتورة جديدة
                        </a>
                    </div>
                </div>
            </div>
        </div>
<!---->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>رقم الفاتورة</th>
                        <th>التاريخ</th>
                        <th>المبلغ الإجمالي</th>
                        <th>طريقة الدفع</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $index => $invoice)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                            <td>{{ number_format($invoice->amount, 2, ',', '.') }} د.ج</td>
                            <td>{{ $invoice->payment_method }}</td>
                            <td>
                                <span class="badge {{ $invoice->status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#invoiceDetailsModal"
                                    onclick="loadInvoiceDetails({{ $invoice->id }})">
                                    عرض التفاصيل
                                </button>
                                @if($invoice->payment_proof && $invoice->status != 'paid')
                                <form action="{{ route('supplier.billing.invoice.deleteProof', $invoice->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف إثبات الدفع؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> حذف الإثبات
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- مودال تفاصيل الفاتورة -->
<div class="modal fade" id="invoiceDetailsModal" tabindex="-1" aria-labelledby="invoiceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- أكبر قليلاً لعرض التفاصيل -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceDetailsModalLabel">تفاصيل الفاتورة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <div id="invoice-details-content">
                    <div class="text-center">جاري التحميل...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--sweet alert-->
@if(session()->has('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'تم تحرير الفاتوترة بنجاح',
        text: '{{ session('success') }}',
        confirmButtonText: 'حسناً',
        timer: 3000
    });
</script>
@endif

@if(session()->has('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'خطاء',
        text: '{{ session('error') }}',
        confirmButtonText: 'حسناً',
        timer: 3000
    });
</script>
@endif

@if(session()->has('paid'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'تم  الدفع بنجاح',
        text: '{{ session('success') }}',
        confirmButtonText: 'حسناً',
        timer: 3000
    });
</script>
@endif
