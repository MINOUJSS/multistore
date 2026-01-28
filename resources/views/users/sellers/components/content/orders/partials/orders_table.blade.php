@forelse($orders as $order)
    <tr class="{!! get_order_status_class($order->status) !!}">
        <td>#{{ $order->order_number }}</td>
        <td>{{ $order->customer_name }}</td>
        <td>{!! seller_order_display_phone($order->id) !!}</td>
        {{-- <td>{{ $order->items_count }} منتجات</td> --}}
        <td>{{ number_format($order->total_price, 2) }} د.ج</td>
        <td>
            {{-- <select class="form-select form-select-sm confirm-status" data-order-id="{{ $order->id }}">
                <option value="pending" {{ $order->confirmation_status == 'pending' ? 'selected' : '' }}>لم يتم الاتصال بعد</option>
                <option value="call1" {{ $order->confirmation_status == 'call1' ? 'selected' : '' }}>أول اتصال</option>
                <option value="call2" {{ $order->confirmation_status == 'call2' ? 'selected' : '' }}>ثاني اتصال</option>
                <option value="call3" {{ $order->confirmation_status == 'call3' ? 'selected' : '' }}>ثالث اتصال</option>
                <option value="error_phone" {{ $order->confirmation_status == 'error_phone' ? 'selected' : '' }}>رقم الهاتف خاطئ</option>
                <option value="no_answer" {{ $order->confirmation_status == 'no_answer' ? 'selected' : '' }}>لم يجب</option>
                <option value="confirmed" {{ $order->confirmation_status == 'confirmed' ? 'selected' : '' }}>تم التأكيد</option>
            </select> --}}
            <select class="form-select confirmation-status" data-order-id="{{ $order->id }}">
                <option value="pending" {{ $order->confirmation_status == 'pending' ? 'selected' : '' }}>قيد الانتظار
                </option>
                <option value="call1" {{ $order->confirmation_status == 'call1' ? 'selected' : '' }}>الاتصال الأول
                </option>
                <option value="call2" {{ $order->confirmation_status == 'call2' ? 'selected' : '' }}>الاتصال الثاني
                </option>
                <option value="call3" {{ $order->confirmation_status == 'call3' ? 'selected' : '' }}>الاتصال الثالث
                </option>
                <option value="error_phone" {{ $order->confirmation_status == 'error_phone' ? 'selected' : '' }}>رقم
                    الهاتف خاطئ</option>
                <option value="no_answer" {{ $order->confirmation_status == 'no_answer' ? 'selected' : '' }}>لم يجب
                </option>
                <option value="confirmed" {{ $order->confirmation_status == 'confirmed' ? 'selected' : '' }}>تم التأكيد
                </option>
            </select>

        </td>
        <td>{{ $order->created_at->format('Y-m-d') }}</td>
        <td>
            <select class="form-select form-select-sm order-status" data-order-id="{{ $order->id }}">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>مكتمل</option>
                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>ملغي</option>
            </select>
        </td>
        <td>
            <button class="btn btn-sm btn-info view-order" data-order-id="{{ $order->id }}"
                onclick="view_order({{ $order->id }});">
                <i class="fas fa-eye"></i>
            </button>
            <button
                class="btn btn-sm {{ is_blocked_customer(auth()->user()->id, $order->id) ? 'btn-danger' : 'btn-success' }} block-customer"
                data-order-id="{{ $order->id }}" onclick="block_customer({{ $order->id }});">
                @if (!is_blocked_customer(auth()->user()->id, $order->id))
                    <i class="fas fa-unlock"></i>
                @else
                    <i class="fas fa-lock"></i>
                @endif
                {{-- <i class="fas fa-ban"></i> --}}
            </button>
            <button class="btn btn-sm btn-danger delete-order" data-order-id="{{ $order->id }}"
                onclick="delete_seller_order({{ $order->id }});">
                <i class="fas fa-trash"></i>
            </button>
            <a href="{{ route('seller.order.edit', $order->id) }}" class="btn btn-sm btn-success"><i
                    class="fas fa-edit"></i></a>
            {{-- test  --}}
            @if (auth()->user()->shipping_companies->count() > 0)
                @if ($order->shipping_company != null)
                    <button class="btn btn-sm btn-success tracking_parcel" data-order-id="{{ $order->id }}"
                        data-bs-toggle="modal" data-bs-target="#viewTrackingModal">
                        <i class="fa-solid fa-location-dot"></i>
                    </button>
                @else
                    <button class="btn btn-sm btn-primary select_company" data-order-id="{{ $order->id }}"
                        data-bs-toggle="modal" data-bs-target="#viewShippingModal">
                        <i class="fa-solid fa-truck-fast"></i>
                    </button>
                @endif
            @endif
            {{-- endtest  --}}
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center">لا توجد طلبات متاحة</td>
    </tr>
@endforelse
<!---->
<form id="shippingForm">
    @csrf
    <input id="input_order_id" type="hidden" name="order_id" value="null">
    <input id="input_shipping_company" type="hidden" name="shipping_company" value="null">
</form>
