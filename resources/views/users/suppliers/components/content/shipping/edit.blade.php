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
            <a class="btn btn-success" href="{{route('supplier.shipping.edit')}}"><i class="fas fa-plus me-2"></i>تسعير الشحن</a>  
        </div> --}}
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('supplier.shipping.update') }}" method="POST">
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
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>
                                <input class="form-check-input check-wilaya" type="checkbox" name="wilaya_{{ $price->wilaya_id }}" 
                                    {{ old("wilaya_{$price->wilaya_id}", $price->shipping_available_to_wilaya) ? 'checked' : '' }}>
                            </td>
                            <td>{{ get_wilaya_data($price->wilaya_id)->ar_name }}</td>
                            <td>
                                <input class="form-check-input check-home" type="checkbox" name="to_home_wilaya_{{ $price->wilaya_id }}" 
                                    {{ old("to_home_wilaya_{$price->wilaya_id}", $price->shipping_available_to_home) ? 'checked' : '' }}>
                            </td>
                            <td>
                                <input class="form-control" type="number" step="any" name="to_home_w_{{ $price->wilaya_id }}" 
                                    value="{{ old("to_home_w_{$price->wilaya_id}", $price->to_home_price) }}" min="0">
                            </td>
                            <td>
                                <input class="form-check-input check-stop_desck" type="checkbox" name="to_stop_desck_wilaya_{{ $price->wilaya_id }}" 
                                    {{ old("to_stop_desck_wilaya_{$price->wilaya_id}", $price->shipping_available_to_stop_desck) ? 'checked' : '' }}>
                            </td>
                            <td>
                                <input class="form-control" type="number" step="any" name="to_desck_w_{{ $price->wilaya_id }}" 
                                    value="{{ old("to_desck_w_{$price->wilaya_id}", $price->stop_desck_price) }}" min="0">
                            </td>
                            <td>
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