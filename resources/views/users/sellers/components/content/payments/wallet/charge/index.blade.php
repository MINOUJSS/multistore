<div class="container mt-5">
    <h2 class="text-center mb-4">المحفظة</h2>

          <!-- بطاقة عرض الرصيد -->
      <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-success shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">الرصيد الحالي</h5>
                    <p class="h4">{{ number_format($current_balance, 2, ',', '.') }} د.ج</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card border-warning shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title text-warning">الرصيد قيد المراجعة</h5>
                    <p class="h4">{{ number_format($pending_balance, 2, ',', '.') }} د.ج</p>
                </div>
            </div>
        </div>
      </div>

<!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectPaymentMethodModal">
                            شحن الرصيد
                        </button>                          
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
                        <th>التاريخ</th>
                        <th>المبلغ</th>
                        <th>طريقة الدفع</th>
                        <th>تفاصيل</th>
                        <th>الإثبات</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($additions as $index => $addition)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $addition->created_at->format('Y-m-d') }}</td>
                            <td>{{ number_format($addition->amount, 2, ',', '.') }} د.ج</td>
                            <td>{{ $addition->payment_method }}</td>
                            <td>{{ $addition->description }}</td>
                            <td>
                              @if($addition->payment_proof)
                                  <a href="{{ asset('storage/app/public/' . $addition->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                      عرض الإثبات
                                  </a>
                              @else
                                  —
                              @endif
                            </td>
                            <td>
                              <span class="badge {{ $addition->status == 'approved' ? 'bg-success' : 'bg-warning' }}">
                                {{ $addition->status }}
                              </span>
                            </td>              
                            <td>
                                <button class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#invoiceDetailsModal"
                                    onclick="loadAdditionDetails({{ $addition->id }})">
                                    عرض التفاصيل
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- مودال تفاصيل الشحن -->
<div class="modal fade" id="invoiceDetailsModal" tabindex="-1" aria-labelledby="invoiceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- أكبر قليلاً لعرض التفاصيل -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceDetailsModalLabel">تفاصيل الشحن</h5>
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
        title: 'تم  شحن الفاتورة بنجاح',
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
            <i class="bi bi-credit-card-2-back-fill me-2"></i>الدفع عبر تطبيق Chargily
          </button>
  
          <!-- طريقة 2: بريدي موب -->
          <button class="btn btn-outline-success w-100 mb-3" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#baridiMobModal">
            <i class="bi bi-phone-fill me-2"></i>الدفع عبر بريدي موب
          </button>
  
          <!-- طريقة 3: CCP -->
          <button class="btn btn-outline-warning w-100 mb-3" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#ccpModal">
            <i class="bi bi-envelope-fill me-2"></i>الدفع عبر CCP / بريد الجزائر 
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
          <form id="chargilyForm" method="POST" action="{{ route('seller.chargilypay.redirect') }}">
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

<!-- Modal: شحن الرصيد عبر بريدي موب -->
<div class="modal fade" id="baridiMobModal" tabindex="-1" aria-labelledby="baridiMobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="baridiMobModalLabel">شحن الرصيد عبر بريدي موب</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('seller.wallet.recharge.baridimob')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="amount_baridi" class="form-label">المبلغ (د.ج)</label>
              <input type="number" name="amount" id="amount_baridi" class="form-control text-center" min="50" step="10" required>
            </div>
            {{-- <div class="mb-3">
              <label for="description_baridi" class="form-label">ملاحظة (اختياري)</label>
              <textarea name="description" id="description_baridi" class="form-control" rows="2" placeholder="معلومات إضافية..."></textarea>
            </div> --}}
            <div class="mb-3">
              <label for="proof_baridi" class="form-label">إرفاق إثبات الدفع</label>
              <input type="file" name="payment_proof" id="proof_baridi" class="form-control" accept="image/*,application/pdf" required>
              <small class="text-muted">صيغة مقبولة: صورة أو PDF</small>
            </div>
            <button type="submit" class="btn btn-success w-100">إرسال الطلب</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  

  <!-- Modal: شحن الرصيد عبر CCP -->
<div class="modal fade" id="ccpModal" tabindex="-1" aria-labelledby="ccpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="ccpModalLabel">شحن الرصيد عبر CCP / بريد الجزائر</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('seller.wallet.recharge.ccp')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="amount_ccp" class="form-label">المبلغ (د.ج)</label>
              <input type="number" name="amount" id="amount_ccp" class="form-control text-center" min="50" step="10" required>
            </div>
            {{-- <div class="mb-3">
              <label for="description_ccp" class="form-label">ملاحظة (اختياري)</label>
              <textarea name="description" id="description_ccp" class="form-control" rows="2" placeholder="معلومات إضافية..."></textarea>
            </div> --}}
            <div class="mb-3">
              <label for="proof_ccp" class="form-label">إرفاق إثبات الدفع</label>
              <input type="file" name="payment_proof" id="proof_ccp" class="form-control" accept="image/*,application/pdf" required>
              <small class="text-muted">صيغة مقبولة: صورة أو PDF</small>
            </div>
            <button type="submit" class="btn btn-warning w-100">إرسال الطلب</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  