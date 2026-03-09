<div class="container-fluid">
    <div class="row">
        {{-- العمود الأيمن: فورم التعديل --}}
        <div class="col-lg-7 col-md-6 mt-2 mb-2 ">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>تعديل الطلب #{{ $order->order_number }}
                    </h5>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addItemModal">
                        <i class="fas fa-plus"></i> إضافة عنصر
                    </button>
                </div>
                <div class="card-body">
                    <form id="editOrderForm" action="{{ route('supplier.order.update', $order->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- بيانات العميل --}}
                        <div class="mb-3">
                            <label class="form-label">اسم العميل</label>
                            <input type="text" name="customer_name" class="form-control"
                                value="{{ old('customer_name', $order->customer_name) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            @if($order->phone_visiblity)
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $order->phone) }}" required disabled>
                                @else
                                <br>
                                {!!supplier_order_display_phone($order->id)!!}
                                @endif
                        </div>

                        {{-- <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="phone_visiblity" value="1"
                                {{ $order->phone_visiblity ? 'checked' : '' }}>
                            <label class="form-check-label">إظهار رقم الهاتف</label>
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label">العنوان</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $order->shipping_address) }}">
                        </div>
                        {{-- تأكيد الطلب --}}
                        <div class="mb-3">
                            <label class="form-label">تأكيد الطلب</label>
                            <select name="confirmation_status" class="form-select">
                                @php
                                    $confirmation_status = [
                                        'pending' => 'قيد الانتظار', // لم يتم الاتصال بعد
                                        'call1' => 'الإتصال الأول', // أول اتصال
                                        'call2' => 'الإتصال الثاني', // ثاني اتصال
                                        'call3' => 'الإتصال الثالث', // ثالث اتصال
                                        'error_phone' => 'رقم الهاتف خاطئ', // رقم الهاتف خاطئ
                                        'no_answer' => 'لم يجب', // لم يجب
                                        'confirmed' => 'تم التأكيد', // تم التأكيد
                                    ];
                                @endphp
                                @foreach ($confirmation_status as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ $order->confirmation == $value ? 'selected' : '' }}
                                        @if ($order->confirmation_status == $value) selected @endif>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- حالة الطلب --}}
                        <div class="mb-3">
                            <label class="form-label">حالة الشحن</label>
                            <select name="status" class="form-select">
                                @foreach (['pending' => 'قيد الانتظار', 'processing' => 'جار المعالجة', 'shipped' => 'تم الشحن', 'delivered' => 'تم التسليم', 'canceled' => 'ملغي'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ $order->status == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- المنتجات داخل الطلب --}}
                        <h5 class="mt-4 mb-3"><i class="fas fa-box me-2"></i>عناصر الطلب</h5>
                        <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>المنتج</th>
                                    <th>الخيار</th>
                                    <th>الصفة</th>
                                    <th>الكمية</th>
                                    <th>سعر الوحدة</th>
                                    <th>الإجمالي</th>
                                    <th>حذف</th>
                                </tr>
                            </thead>
                            <tbody id="orderItemsTable">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="item-name">{{ $item->product->name ?? '---' }}</td>

                                        {{-- variation_id --}}
                                        {{-- {{dd($order->items[1]->product->variations[0]) }} --}}
                                        <td>
                                            <select name="items[{{ $item->id }}][variation_id]"
                                                class="form-select">
                                                <option value="">بدون</option>
                                                @foreach ($item->product->variations ?? [] as $variation)
                                                    <option value="{{ $variation->id }}"
                                                        {{ $item->variation_id == $variation->id ? 'selected' : '' }}>
                                                        {{ $variation->sku }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        {{-- attribute_id --}}
                                        <td>
                                            <select name="items[{{ $item->id }}][attribute_id]"
                                                class="form-select">
                                                <option value="">بدون</option>
                                                @foreach ($item->product->attributes ?? [] as $attribute)
                                                    <option value="{{ $attribute->id }}"
                                                        data-additional_price="{{ $attribute->additional_price }}"
                                                        {{ $item->attribute_id == $attribute->id ? 'selected' : '' }}>
                                                        {{ $attribute->value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <input type="number" min="1"
                                                name="items[{{ $item->id }}][quantity]"
                                                value="{{ $item->quantity }}" class="form-control item-qty">
                                        </td>

                                        <td>
                                            <input type="number" step="0.01"
                                                name="items[{{ $item->id }}][unit_price]"
                                                value="{{ $item->unit_price }}" class="form-control item-price">
                                        </td>

                                        <td class="item-total">
                                            {{ number_format($item->unit_price * $item->quantity, 2) }}</td>

                                        <td>
                                            {{-- <button type="button" class="btn btn-danger btn-sm remove-item">
                                                <i class="fas fa-trash"></i>
                                            </button> --}}
                                            <button type="button" class="btn btn-danger btn-sm delete-item-btn"
                                                data-item-id="{{ $item->id ?? '' }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>


                        {{-- الأسعار الإجمالية --}}
                        <div class="mb-3">
                            {{-- <label class="form-label">إجمالي السعر</label> --}}
                            <input type="hidden" step="0.01" name="total_price" id="total_price"
                                class="form-control" value="{{ old('total_price', $order->total_price) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">الخصم</label>
                            <input type="number" step="0.01" name="discount" id="discount" class="form-control"
                                value="{{ old('discount', $order->discount) }}">
                        </div>
                        @if ($order->free_shipping === 'no')
                            <div class="row border p-3">
                                <h5>حساب تكلفة الشحن</h5>
                                <div class="col-4">
                                    <label for="wilaya" class="form-label">الولاية</label>
                                    <select name="wilaya" id="wilaya" class="form-select">
                                        <option value="0" selected>إختر الولاية...</option>
                                        @foreach ($wilayas as $wilaya)
                                            <option value="{{ $wilaya->id }}"
                                                {{ $order->wilaya_id == $wilaya->id ? 'selected' : '' }}>
                                                {{ get_wilaya_data($wilaya->id)->ar_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="dayra" class="form-label">الدائرة</label>
                                    <select name="dayra" id="dayra" class="form-select">
                                        <option value="0" selected>إختر الدائرة...</option>
                                        @if (get_dayras_of_wilaya($order->wilaya_id) != null)
                                            @foreach (get_dayras_of_wilaya($order->wilaya_id) as $dayra)
                                                <option value="{{ $dayra->id }}"
                                                    {{ $order->dayra_id == $dayra->id ? 'selected' : '' }}>
                                                    {{ get_dayra_data($dayra->id)->ar_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="baladia" class="form-label">البلدية</label>
                                    <select name="baladia" id="baladia" class="form-select">
                                        <option value="0" selected>إختر البلدية...</option>
                                        @if (get_baladias_of_dayra($order->dayra_id) != null)
                                            @foreach (get_baladias_of_dayra($order->dayra_id) as $baladia)
                                                <option value="{{ $baladia->id }}"
                                                    {{ $order->baladia_id == $baladia->id ? 'selected' : '' }}>
                                                    {{ get_baladia_data($baladia->id)->ar_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-4 mt-2">
                                    <input type="radio" name="shipping_type"
                                        @if ($order->shipping_type == 'to_home') checked @endif value="to_home"
                                        id="to_home" class="form-check-input">
                                    <label for="to_home" class="form-label">التوصيل للمنزل</label>
                                </div>
                                <div class="col-4 mt-2">
                                    <input type="radio" name="shipping_type"
                                        @if ($order->shipping_type == 'to_descktop') checked @endif value="to_descktop"
                                        id="to_descktop" class="form-check-input">
                                    <label for="to_descktop" class="form-label">التوصيل للمكتب</label>
                                </div>
                                <div class="col-4 mt-2">
                                    <input class="btn btn-primary" type="button" value="حساب تكلفة الشحن"
                                        onclick="calculateShipping()">
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">تكلفة الشحن</label>
                            <input type="number" step="0.01" name="shipping_cost" id="shipping_cost"
                                class="form-control" value="{{ old('shipping_cost', $order->shipping_cost) }}">
                        </div>

                        {{-- ملاحظات --}}
                        <div class="mb-3">
                            <label class="form-label">ملاحظات</label>
                            <textarea name="note" class="form-control" rows="3">{{ old('note', $order->note) }}</textarea>
                        </div>

                        {{-- زر الحفظ --}}
                        <div class="d-grid">
                            {{-- <button type="submit" id="saveOrderBtn" class="btn btn-success">💾 حفظ التعديلات</button> --}}
                            <button type="button" id="saveOrderBtn" class="btn btn-success">💾 حفظ
                                التعديلات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- العمود الأيسر: ملخص الطلب --}}
        <div class="col-lg-5 col-md-6 mt-2">
            <div class="sticky-top" style="top: 20px; z-index: 1019;">
                {{-- test  --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-3"><i class="fas fa-receipt me-2"></i>ملخص الطلب</h5>
                    </div>
                    <div class="card-body">
                        <div class="order-summary p-3 border rounded bg-white">
                            <div id="summaryItems">
                                @php
                                    $subtotal = 0;
                                @endphp
                                @foreach ($order->items as $item)
                                    @php
                                        $subtotal += $item->unit_price * $item->quantity;
                                    @endphp
                                    <div class="d-flex justify-content-between">
                                        <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                                        <span>{{ number_format($item->product->price, 2) }} د.ج</span>
                                    </div>
                                @endforeach
                            </div>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between mb-2">
                                <span>المجموع الفرعي</span>
                                <span id="summary_sub_total">{{ number_format($subtotal, 2) }} د.ج</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>الشحن</span>
                                <span id="summary_shipping">{{ number_format($order->shipping_cost, 2) }} د.ج</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>الخصم</span>
                                <span id="summary_discount">{{ number_format($order->discount, 2) }} د.ج</span>
                            </div>

                            <div class="d-flex justify-content-between total-price py-2 border-top border-bottom">
                                <span>المجموع الكلي</span>
                                <span id="summary_total">{{ number_format($order->total_price, 2) }}
                                    د.ج</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end test  --}}


            </div>
        </div>
    </div>
</div>


<!-- Modal إضافة عنصر -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addItemModalLabel">إضافة عنصر جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                {{-- اختيار المنتج --}}
                <div class="mb-3">
                    <label class="form-label">المنتج</label>
                    <select id="new_product" class="form-select">
                        <option value="null">اختر المنتج</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-variations='@json($product->variations)'
                                data-attributes='@json($product->attributes)'>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- اختيار الخيار (variation) --}}
                <div class="mb-3">
                    <label class="form-label">الخيار</label>
                    <select id="new_variation" class="form-select">
                        <option value="">بدون</option>
                    </select>
                </div>

                {{-- اختيار الصفة (attribute) --}}
                <div class="mb-3">
                    <label class="form-label">الصفة</label>
                    <select id="new_attribute" class="form-select">
                        <option value="">بدون</option>
                    </select>
                </div>

                {{-- الكمية --}}
                <div class="mb-3">
                    <label class="form-label">الكمية</label>
                    <input type="number" id="new_quantity" class="form-control" value="1" min="1">
                </div>

                {{-- سعر الوحدة --}}
                <div class="mb-3">
                    <label class="form-label">سعر الوحدة</label>
                    <input type="number" step="0.01" id="new_unit_price" class="form-control" value="0.00">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-success" id="addItemBtn">
                    <i class="fas fa-check me-1"></i> إضافة
                </button>
            </div>
        </div>
    </div>
</div>
<style>
/* ===== Tablets ===== */
@media (max-width: 992px) {

    .container-fluid{
        padding-left:10px;
        padding-right:10px;
    }

    /* إزالة sticky في التابلت */
    .sticky-top{
        position: relative !important;
        top:0 !important;
    }

    /* جدول الطلب */
    table{
        font-size:14px;
    }

}


/* ===== Mobile ===== */
@media (max-width: 768px) {

    /* الأعمدة تصبح تحت بعضها */
    .col-lg-7,
    .col-lg-5,
    .col-md-6{
        width:100%;
    }

    /* تقليل حجم العناوين */
    .card-header h5{
        font-size:16px;
    }

    /* الأزرار */
    .card-header button{
        font-size:13px;
        padding:5px 8px;
    }

    /* جدول الطلب */
    table{
        font-size:12px;
    }

    table th,
    table td{
        padding:6px;
    }

    /* المدخلات */
    .form-control,
    .form-select{
        font-size:14px;
        padding:6px;
    }

    /* عناصر الشحن */
    .row.border .col-4{
        width:100%;
        margin-bottom:10px;
    }
    .table-responsive table thead {
        display: none;
    }

    .table-responsive table,
    .table-responsive tbody,
    .table-responsive tr,
    .table-responsive td {
        display: block;
        width: 100%;
    }

    .table-responsive tr {
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 12px;
        padding: 10px;
        background: #fff;
    }

    .table-responsive td {
        text-align: right;
        padding: 8px 10px;
        position: relative;
        border: none;
        border-bottom: 1px solid #eee;
    }

    .table-responsive td:last-child {
        border-bottom: none;
    }

    /* العناوين داخل الخلايا */
    .table-responsive td::before {
        content: attr(data-label);
        font-weight: bold;
        display: block;
        margin-bottom: 4px;
        color: #555;
        text-align: right;
    }

    /* المدخلات */
    .table-responsive input,
    .table-responsive select {
        width: 100%;
        font-size: 14px;
    }

    .delete-item-btn {
        width: 100%;
    }



}


/* ===== Small Mobile ===== */
@media (max-width: 576px) {

    /* تصغير الجدول أكثر */
    table{
        font-size:11px;
    }

    table th{
        white-space:nowrap;
    }

    /* السماح بالسكرول الأفقي للجدول */
    table{
        display:block;
        overflow-x:auto;
        white-space:nowrap;
    }

    /* الملخص */
    .order-summary{
        font-size:14px;
    }

    /* زر الحفظ */
    #saveOrderBtn{
        font-size:14px;
        padding:10px;
    }

  

}
</style>
