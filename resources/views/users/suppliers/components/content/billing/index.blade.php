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
                        <a class="btn btn-success" href="{{route('supplier.wallet')}}"><i class="bi bi-wallet"> المحفظة</i></a>
                        {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectPaymentMethodModal">
                            شحن الرصيد
                        </button>                           --}}
                    </div>
                </div>
            </div>
        </div>
<!---->
    <div class="card">
        <div class="card-body table-responsive">
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

<!-- Modal: اختيار طريقة الدفع -->
<div class="modal fade" id="selectPaymentMethodModal" tabindex="-1" aria-labelledby="selectPaymentMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="selectPaymentMethodModalLabel">اختر طريقة شحن الرصيد</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
        </div>
        <div class="modal-body text-center">
  
          <p class="mb-4 text-muted">يرجى اختيار وسيلة الدفع المناسبة:</p>
  
          <!-- طريقة 1: Chargily -->
          <button class="btn btn-outline-primary w-100 mb-3" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#chargeBalanceModal">
            <i class="bi bi-phone-fill me-2"></i>الدفع عبر تطبيق Chargily
          </button>
  
          <!-- طريقة 2: CIB -->
          <button class="btn btn-outline-success w-100 mb-3 disabled" disabled>
            <i class="bi bi-credit-card-2-back-fill me-2"></i>الدفع عبر بطاقة CIB (قريبًا)
          </button>
  
          <!-- طريقة 3: CCP -->
          <button class="btn btn-outline-warning w-100 mb-3 disabled" disabled>
            <i class="bi bi-envelope-fill me-2"></i>الدفع عبر CCP / بريد الجزائر (قريبًا)
          </button>
  
          <!-- طريقة 4: PayPal -->
          <button class="btn btn-outline-dark w-100 mb-3 disabled" disabled>
            <i class="bi bi-paypal me-2"></i>الدفع عبر PayPal (قريبًا)
          </button>
  
        </div>
      </div>
    </div>
  </div>
  <!-- Modal: شحن الرصيد عبر Chargily -->
<div class="modal fade" id="chargeBalanceModal" tabindex="-1" aria-labelledby="chargeBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="chargeBalanceModalLabel">شحن الرصيد عبر Chargily</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
        </div>
        <div class="modal-body text-center">
          <form id="chargilyForm" method="POST" action="{{ route('supplier.chargilypay.redirect') }}">
            @csrf
            <input type="hidden" name="payment_type" value="wallet_topup">
                <input type="hidden" name="reference_id" value="{{auth()->user()->id}}">
            <div class="mb-3">
              <label for="amount" class="form-label">أدخل المبلغ (د.ج)</label>
              <input type="number" min="50" step="10" class="form-control text-center" name="amount" id="amount" placeholder="مثال: 1000" required>
              <small class="text-muted d-block mt-2">الحد الأدنى: 50 د.ج</small>
            </div>
            <button type="submit" class="btn btn-primary w-100">متابعة الدفع</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
