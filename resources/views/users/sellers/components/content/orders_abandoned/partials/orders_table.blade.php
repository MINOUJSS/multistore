@forelse($orders as $order)
<tr>
    <td>#{{ $order->order_number }}</td>
    <td>{{ $order->customer_name }}</td>
    <td>{!! seller_order_abandoned_display_phone($order->id) !!}</td>
    <td>{{ $order->items_count }} منتجات</td>
    <td>{{ number_format($order->total_price, 2) }} د.ج</td>
    <td>{{ $order->created_at->format('Y-m-d') }}</td>
    <td>
        <select class="form-select form-select-sm order-status" data-order-id="{{ $order->id }}">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>جديد</option>
            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>مكتمل</option>
            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>ملغي</option>
        </select>
    </td>
    <td>
        <button class="btn btn-sm btn-info view-order" data-order-id="{{ $order->id }}">
            <i class="fas fa-eye"></i>
        </button>
        <button class="btn btn-sm btn-danger delete-order" data-order-id="{{ $order->id }}" onclick="delete_seller_order({{ $order->id }});">
            <i class="fas fa-trash"></i>
        </button>
        <button class="btn btn-sm btn-success move_to_order" data-order-id="{{ $order->id }}">
            <i class="fa-solid fa-cart-arrow-down"></i>
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center">لا توجد طلبات متاحة</td>
</tr>
@endforelse
