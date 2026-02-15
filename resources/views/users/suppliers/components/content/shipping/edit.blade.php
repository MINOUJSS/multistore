<style>
/* ================= SHIPPING PRICING – RESPONSIVE ================= */
@media (max-width: 991.98px) {

    /* منع الالتصاق بحواف الشاشة */
    .container-fluid {
        padding-left: 12px;
        padding-right: 12px;
    }

    /* إخفاء رأس الجدول */
    table thead {
        display: none;
    }

    /* تحويل الجدول إلى بلوكات */
    table,
    table tbody,
    table tr,
    table td,
    table th {
        display: block;
        width: 100%;
    }

    /* كل ولاية ككارت */
    table tbody tr {
        margin-bottom: 15px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px;
        background: #fff;
    }

    /* الخلايا */
    table tbody tr td,
    table tbody tr th {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border: none;
        text-align: right;
    }

    /* العناوين */
    table tbody tr td::before,
    table tbody tr th::before {
        content: attr(data-label);
        font-weight: 600;
        color: #555;
        margin-left: 10px;
        white-space: nowrap;
    }

    /* الحقول */
    table input.form-control {
        max-width: 140px;
        text-align: center;
    }

    /* checkbox */
    table input[type="checkbox"] {
        transform: scale(1.1);
    }

    /* زر الحفظ */
    form > button[type="submit"] {
        width: 100%;
        margin-top: 15px;
    }

    /* العنوان */
    .d-flex.justify-content-between.align-items-center {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>
@if(session('success'))
    <script>
        Swal.fire({
            title: 'نجاح!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'حسنًا'
        });
    </script>
@endif

<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>تسعير الشحن</h2>
        {{-- <div>
            <button class="btn btn-primary"><i class="fas fa-plus me-2"></i>إضافة شحنة جديدة</button>
            <a class="btn btn-success" href="{{route('seller.shipping.edit')}}"><i class="fas fa-plus me-2"></i>تسعير الشحن</a>  
        </div> --}}
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('seller.shipping.update') }}" method="POST">
                @csrf
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <td>
                                <input class="form-check-input check-all" type="checkbox" data-column="wilaya">
                            </td>
                            <th scope="col">الولاية</th>
                            <td>
                                <input class="form-check-input check-all" type="checkbox" data-column="home">
                            </td>
                            <th scope="col">الشحن للمنزل</th>
                            <td>
                                <input class="form-check-input check-all" type="checkbox" data-column="stop_desck">
                            </td>
                            <th scope="col">الشحن للمكتب</th>
                            <td>
                                <input class="form-check-input check-all" type="checkbox" data-column="additional">
                            </td>
                            <th scope="col">تكلفة إضافية للشحن لبلديات الولاية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prices as $index => $price)
                        <tr>
                            <th scope="row" data-label="#">{{ $index + 1 }}</th>
                            <td>
                                <input class="form-check-input check-wilaya" type="checkbox" name="wilaya_{{ $price->wilaya_id }}" 
                                    {{ old("wilaya_{$price->wilaya_id}", $price->shipping_available_to_wilaya) ? 'checked' : '' }}>
                            </td>
                            <td data-label="الولاية">{{ get_wilaya_data($price->wilaya_id)->ar_name }}</td>
                            <td data-label="تفعيل التوصيل للمنزل">
                                <input class="form-check-input check-home" type="checkbox" name="to_home_wilaya_{{ $price->wilaya_id }}" 
                                    {{ old("to_home_wilaya_{$price->wilaya_id}", $price->shipping_available_to_home) ? 'checked' : '' }}>
                            </td>
                            <td data-label="سعر التوصيل للمنزل">
                                <input class="form-control" type="number" step="any" name="to_home_w_{{ $price->wilaya_id }}" 
                                    value="{{ old("to_home_w_{$price->wilaya_id}", $price->to_home_price) }}" min="0">
                            </td>
                            <td data-label="تفعيل التوصيل للمكتب">
                                <input class="form-check-input check-stop_desck" type="checkbox" name="to_stop_desck_wilaya_{{ $price->wilaya_id }}" 
                                    {{ old("to_stop_desck_wilaya_{$price->wilaya_id}", $price->shipping_available_to_stop_desck) ? 'checked' : '' }}>
                            </td>
                            <td data-label="سعر التوصيل للمكتب">
                                <input class="form-control" type="number" step="any" name="to_desck_w_{{ $price->wilaya_id }}" 
                                    value="{{ old("to_desck_w_{$price->wilaya_id}", $price->stop_desck_price) }}" min="0">
                            </td>
                            <td data-label="سعر التوصيل إضافي لبلديات الولاية">
                                <input class="form-check-input check-additional" type="checkbox" name="additional_wilaya_{{ $price->wilaya_id }}" 
                                    {{ old("additional_wilaya_{$price->wilaya_id}", $price->additional_price_status) ? 'checked' : '' }}>
                            </td>
                            <td>
                                <input class="form-control" type="number" step="any" name="additional_w_{{ $price->wilaya_id }}" 
                                    value="{{ old("additional_w_{$price->wilaya_id}", $price->additional_price) }}" min="0">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </form>            
            
        </div>
    </div>
    


</div>