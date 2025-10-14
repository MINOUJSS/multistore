@foreach ($coupons as $coupon)
    <tr>
        <td>{{ $coupon->code }}</td>
        <td>{{ $coupon->description }}</td>
        <td>
            @if ($coupon->type == 'percent')
                <span class="badge bg-info">نسبة مئوية</span>
            @else
                <span class="badge bg-primary">مبلغ ثابت</span>
            @endif
        </td>
        <td>
            @if ($coupon->type == 'percent')
                {{ $coupon->value }}%
            @else
                {{ number_format($coupon->value, 2) }} د.ج
            @endif
        </td>
        <td>{{ \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') }}</td>
        <td>{{ \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d') }}</td>
        <td>{{ number_format($coupon->min_order_amount, 2) }} د.ج</td>
        <td>{{ $coupon->usage_per_user }} / {{ $coupon->usage_limit ?? '∞' }}</td>
        <td>
            @if ($coupon->isExpired())
                <span class="badge bg-danger">منتهي</span>
            @elseif($coupon->isScheduled())
                <span class="badge bg-warning text-dark">مجدول</span>
            @else
                <span class="badge bg-success">نشط</span>
            @endif
        </td>
        <td>
            @if ($coupon->isActive())
                <span class="badge bg-success">مفعل</span>
            @else
                <span class="badge bg-danger">غير مفعل</span>
            @endif
        </td>
        <td>
            <button value="{{ $coupon->id }}" class="btn btn-sm btn-info edit-coupon" data-bs-toggle="modal"
                data-bs-target="#editCouponModal">
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger delete-coupon" value="{{ $coupon->id }}">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
@endforeach
