<div class="container mt-5">
    <h2 class="text-center mb-4">طلبات تخليص الفواتير  (بريدي موب و CCP)</h2>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
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
                    @foreach($invoices as $index => $invoice)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $invoice->user->name ?? '—' }}</td>
                            <td>{{ number_format($invoice->amount, 2, ',', '.') }} د.ج</td>
                            <td>
                                @if($invoice->payment_method === 'baridi-mob')
                                    <span class="badge bg-success">بريدي موب</span>
                                @elseif($invoice->payment_method === 'Ccp')
                                    <span class="badge bg-warning text-dark">CCP</span>
                                @endif
                            </td>
                            <td>{{ $invoice->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $invoice->description ?? '—' }}</td>
                            <td>
                                @if($invoice->payment_proof)
                                    <a href="{{ asset('storage/tenantsupplier/app/public/' . $invoice->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        عرض الإثبات
                                    </a>
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                @if($invoice->status === 'under_review')
                                    <span class="badge bg-secondary">قيد المراجعة</span>
                                @elseif($invoice->status === 'approved')
                                    <span class="badge bg-success">تمت الموافقة</span>
                                @endif
                            </td>
                            <td>
                                @if($invoice->status === 'under_review')
                                    <form action="{{ route('admin.payments.invoice.approve', $invoice->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟');">
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

            @if($invoices->isEmpty())
                <div class="text-center text-muted mt-4">لا توجد طلبات حالياً.</div>
            @endif
        </div>
    </div>
</div>
