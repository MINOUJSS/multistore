@forelse($orders as $order)
    <tr>
        <td data-label="رقم الطلب">#{{ $order->order_number }}</td>
        <td data-label="العميل">{{ $order->customer_name }}</td>
        <td data-label="رقم الهاتف">{!! supplier_order_abandoned_display_phone($order->id) !!}</td>
        <td data-label="المنتجات">{{ $order->items_count }} منتجات</td>
        <td data-label="الإجمالي">{{ number_format($order->total_price, 2) }} د.ج</td>
        <td data-label="تاريخ الطلب">{{ $order->created_at->format('Y-m-d') }}</td>
        <td data-label="الحالة">
            <select class="form-select form-select-sm order-status" data-order-id="{{ $order->id }}">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>جديد</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>مكتمل</option>
                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>ملغي</option>
            </select>
        </td>
        <td data-label="الإجراءات">
            <button class="btn btn-sm btn-info view-order" data-order-id="{{ $order->id }}">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-danger delete-order" data-order-id="{{ $order->id }}" onclick="delete_supplier_order({{ $order->id }});">
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
