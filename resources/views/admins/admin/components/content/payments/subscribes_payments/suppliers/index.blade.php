<div class="container mt-5">
    <h2 class="text-center mb-4">
        <i class="fa-solid fa-calendar-check text-primary me-2"></i>
        طلبات تسديد الاشتراكات
    </h2>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>المورد</th>
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
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->supplier->full_name ?? '—' }}</td>
                            <td>{{ $order->plan->name ?? '—' }}</td>
                            {{-- <td>{{ number_format($order->price, 2, ',', '.') }} د.ج</td> --}}
                            <td>{{ number_format($order->price, 2, ',', '.') }} د.ج</td>
                            <td>{{ $order->duration }} يوم</td>
                            <td>
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
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                @if($order->payment_proof)
                                    <a href="{{ asset('storage/tenantsupplier/app/public/' . $order->payment_proof) }}"
                                       target="_blank" class="btn btn-sm btn-outline-primary">
                                       عرض
                                    </a>
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                @if($order->payment_status === 'unpaid')
                                    <span class="badge bg-secondary">قيد المراجعة</span>
                                @elseif($order->payment_status === 'paid')
                                    <span class="badge bg-success">مدفوعة</span>
                                @elseif($order->payment_status === 'failed')
                                    <span class="badge bg-danger">مرفوضة</span>
                                @endif
                            </td>
                            <td>
                                @if($order->payment_status === 'unpaid' && $order->payment_proof  != null)
                                    <form action="{{ route('admin.payments.suppliers.subscribe.approve', $order->id) }}" method="POST" onsubmit="return confirm('تأكيد الموافقة على الدفع؟');">
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

            @if($subscriptionRequests->isEmpty())
                <div class="text-center text-muted mt-4">لا توجد طلبات اشتراك حالياً.</div>
            @endif
        </div>
    </div>
</div>
