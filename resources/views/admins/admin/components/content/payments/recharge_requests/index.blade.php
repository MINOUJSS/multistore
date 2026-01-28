<div class="container mt-5">
    <h2 class="text-center mb-4">طلبات شحن الرصيد (بريدي موب و CCP)</h2>

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
                    @foreach($requests as $index => $request)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $request->user->name ?? '—' }}</td>
                            <td>{{ number_format($request->amount, 2, ',', '.') }} د.ج</td>
                            <td>
                                @if($request->payment_method === 'BaridiMob')
                                    <span class="badge bg-success">بريدي موب</span>
                                @elseif($request->payment_method === 'Ccp')
                                    <span class="badge bg-warning text-dark">CCP</span>
                                @endif
                            </td>
                            <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $request->description ?? '—' }}</td>
                            <td>
                                @if($request->payment_proof)
                                    @if(get_user_data_from_user_id($request->user_id)->type==='supplier')
                                                                    <a href="{{ asset('storage/tenantsupplier/app/public/' . $request->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        عرض الإثبات
                                    </a>
                                    @elseif(get_user_data_from_user_id($request->user_id)->type==='seller')
                                                                    <a href="{{ asset('storage/app/public/' . $request->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        عرض الإثبات
                                    </a>
                                    @endif

                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                @if($request->status === 'pending')
                                    <span class="badge bg-secondary">قيد المراجعة</span>
                                @elseif($request->status === 'approved')
                                    <span class="badge bg-success">تمت الموافقة</span>
                                @endif
                            </td>
                            <td>
                                @if($request->status === 'pending')
                                    <form action="{{ route('admin.payments.recharge.approve', $request->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟');">
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

            @if($requests->isEmpty())
                <div class="text-center text-muted mt-4">لا توجد طلبات حالياً.</div>
            @endif
        </div>
    </div>
</div>
