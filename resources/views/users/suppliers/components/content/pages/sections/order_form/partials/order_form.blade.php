            {{-- order form  --}}
            <form id="orderForm"  action="#" class="row g-3 border p-3 rounded mt-3 mb-3 order-form">
                <div class="col-12 text-center">
                    <p id="form_title">{{$order_form->form_title}}</p>
                </div>
                <div class="col-md-6">
                    <label id="form_lable_customer_name" for="name" class="form-label">{{$order_form->lable_customer_name}} <sup id="form_required_customer_name" class="text-danger">@if($order_form->customer_name_required === 'true')*@endif</sup></label>
                    <input type="name" name="name" class="form-control form-input @error('name') is-invalid @enderror"
                        id="name" value="{{ old('name') }}" placeholder="{{$order_form->input_placeholder_customer_name}}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label id="form_lable_customer_phone" for="phone" class="form-label">{{$order_form->lable_customer_phone}} <sup id="form_required_customer_phone" class="text-danger">*</sup></label>
                    <input type="phone" name="phone" class="form-control form-input @error('phone') is-invalid @enderror"
                        id="phone" value="{{ old('phone') }}" placeholder="{{$order_form->input_placeholder_customer_phone}}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div id="form_address_group" class="col-12" style="display: @if($order_form->customer_address_visible === 'true') block @else none @endif">
                    <label id="form_lable_customer_address" for="address" class="form-label">{{$order_form->lable_customer_address}} <sup id="form_required_customer_address" class="text-danger">@if($order_form->customer_address_required === 'true')*@endif</sup></label>
                    <input type="text" name="address" class="form-control form-input @error('address') is-invalid @enderror"
                        id="address" value="{{ old('address') }}" placeholder="{{$order_form->input_placeholder_customer_address}}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div id="form_notes_group" class="col-12" style="display: @if($order_form->customer_notes_visible === 'true') block @else none @endif" >
                    <label id="form_lable_customer_notes" for="note" class="form-label">{{$order_form->lable_customer_notes}} <sup id="form_required_customer_notes" class="text-danger">@if($order_form->customer_notes_required === 'true')*@endif</sup></label>
                    <textarea name="notes" class="form-control form-input @error('note') is-invalid @enderror" id="notes" rows="3" placeholder="{{$order_form->input_placeholder_customer_notes}}"></textarea>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="inputWilaya" class="form-label">الولاية</label>
                    <select id="inputWilaya" name="wilaya" class="form-select @error('wilaya') is-invalid @enderror">
                        <option value="0" selected>إختر الولاية...</option>
                            <option value="1">
                                أدرار
                            </option>
                    </select>

                    @error('wilaya')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="inputDayra" class="form-label">الدئرة</label>
                    <select id="inputDayra" name="dayra" class="form-select @error('dayrea') is-invalid @enderror">
                        <option value="0" selected>إختر الدائرة...</option>
                        <option value="0">...</option>
                    </select>
                    @error('dayrea')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="inputBaladia" class="form-label">البلدية</label>
                    <select id="inputBaladia" name="baladia" class="form-select @error('baladia') is-invalid @enderror">
                        <option value="0" selected>إختر البلدية...</option>
                        <option value="0">...</option>
                    </select>
                    @error('baladia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5>
                                <i class="fas fa-truck"></i>
                                التوصيل
                            </h5>
                                <p id="show_shipping_price">إختر الولاية</p>
                        </div>
                        <div id="shipping_method" class="row d-flex justify-content-between align-items-center"
                            style="display: none !important;">

                            <div class="col-md-6">
                                <div class="card p-3 text-center border option-card" id="card_home">
                                    <input class="form-check-input d-none" type="radio" id="to_home"
                                        name="shipping_and_point" value="home"
                                        {{ old('shipping_and_point', 'home') == 'home' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="to_home">التوصيل للمنزل</label>
                                    <p id="to_home_price">00</p><sup> د.ج</sup>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card p-3 text-center border option-card" id="card_descktop">
                                    <input class="form-check-input d-none" type="radio" id="to_descktop"
                                        name="shipping_and_point" value="descktop"
                                        {{ old('shipping_and_point') == 'descktop' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="to_descktop">التوصيل للمكتب</label>
                                    <p id="to_desck_price">00</p><sup> د.ج</sup>
                                </div>
                            </div>

                        </div>

                        @error('shipping_and_point')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!--product options-->
                    <div class="row mt-3 mb-3">
                        <div class="col-md-12">
                            <h5>إختر اللون</h5>
                                <input class="form-check-input" type="radio" name="product_varition"
                                    value="1"
                                    style="background-color:#ff00ff;width:30px;height:30px;border:1px solid #000;">
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-md-12">
                                    <h5>إختر الخاصية</h5>

                                    {{-- <input class="form-check-input" type="radio" name="product_attribute"
                                        value="{{ $product_attribute->id }}" onchange="get_attribute_id(this);" @if ($product_attributes[0]['id'] == $product_attribute['id']) checked @endif> --}}
                                    <input class="form-check-input" type="radio" name="product_attribute"
                                        data-unit-price="300"
                                        data-aditional-price="100"
                                        value="1">
                                    <label for="product_attribute">الماركة</label>
                        </div>
                    </div>
                <!--/product options-->
                <!--payment method-->

                <div class="row mb-4 mt-4">
                    <div class="col-md-12">
                        <h5 class="mb-3 fw-bold text-dark sub-title">طريقة الدفع</h5>
                        <div class="d-flex flex-wrap gap-3">

                            <!-- الدفع عند الاستلام -->
                            <div class="payment-option">
                                <input type="radio" name="payment_method" id="cod" value="cod"
                                    class="payment-radio" checked>
                                <label for="cod" class="payment-label">
                                    <div class="payment-content">
                                        <i class="fas fa-money-bill-wave payment-icon"></i>
                                        <span class="payment-text">الدفع عند الاستلام</span>
                                    </div>
                                </label>
                            </div>
                                <!-- Chargily -->
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" id="chargily" value="chargily"
                                        class="payment-radio">
                                    <label for="chargily" class="payment-label">
                                        <div class="payment-content">
                                            <i class="fas fa-credit-card payment-icon"></i>
                                            <span class="payment-text">Chargily</span>
                                        </div>
                                    </label>
                                </div>

                                <!-- التحويل البنكي -->
                                <div class="payment-option">
                                    <input type="radio" name="payment_method" id="bank_transfer" value="verments"
                                        class="payment-radio">
                                    <label for="bank_transfer" class="payment-label">
                                        <div class="payment-content">
                                            <i class="fas fa-university payment-icon"></i>
                                            <span class="payment-text">تحويل بنكي</span>
                                        </div>
                                    </label>
                                </div>

                        </div>
                    </div>
                </div>
                    <!---->
                    <div class="col-md-12 mb-4">
                        <label id="form_product_coupon_code" for="coupon" class="form-label">{{$order_form->lable_product_coupon_code}}</label>
                        <input id="coupon" type="text" name="coupon"
                            class="form-control form-input @error('coupon') is-invalid @enderror"
                            value="{{ old('coupon') }}" data-product-id="1"
                            placeholder="{{$order_form->input_placeholder_product_coupon_code}}">
                        @error('coupon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!---->

                <!--/payment method-->
                <div class="row mb-3 mt-3">
                    <div class="col-md-4">
                        {{-- @livewire('supplier-item-qty-controller') --}}
                        <div class="d-flex justify-content-center">
                            <a class="btn border rounded form-btn"><i
                                    class="fas fa-plus"></i></a>
                            <span id="livewier_qty"
                                class="fw-bold w-100 text-center">1</span>
                            <input id="hidden_qty" type="hidden" name="qty"
                                value="1">
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <a class="btn border rounded form-btn"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="col-md-8">

                        <input type="hidden" name="product_id" value="1" />

                        <button type="button" class="form-control btn form-btn btn-primary form-btn-primary"><i
                                class="fas fa-shopping-cart"></i><span id="form_submit_button">{{$order_form->form_submit_button}}</span></button>
                    </div>
                </div>
                <div class="col-12">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    <i class="fas fa-shopping-cart"></i> ملخص الطلبية
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="sm-product-img" style="width: 20%;">
                                            <img src="{{ asset('asset/v1/users/store') }}/img/products/product.webp" height="50px" width="50px"
                                                alt="">
                                        </div>
                                        <div class="sm-product-name w-60" style="width: 50%;">
                                            <h3 class="">إسم المنتج</h3>
                                        </div>
                                        <div class="qty" style="width: 10%;">
                                            X<span id="qty">1</span>
                                        </div>
                                        <div class="sm-product-price" style="width: 20%;">
                                                <span id="unit_price" class="price">300.00
                                                </span><sup>د.ج</sup>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="shipping" style="width: 80%;">
                                            <i class="fas fa-calculator"></i> المجموع الفرعي
                                        </div>
                                        <div class="shipping-price" style="width: 20%;">
                                                <span id="sub_total" class="price">300.00
                                                </span><sup>د.ج</sup>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="shipping" style="width: 80%;">
                                            <i class="fas fa-truck"></i> التوصيل
                                        </div>
                                        <div class="shipping-price" style="width: 20%;">
                                            <span id="shipping_price"
                                                class="price">{{ number_format(00, 2) }}</span><sup> د.ج</sup>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="discount" style="width: 80%;">
                                            <i class="fas fa-percentage"></i> الخصم
                                        </div>
                                        <div class="shipping-price" style="width: 20%;">
                                            <span id="discount"
                                                class="price">{{ number_format(00, 2) }}</span><sup> د.ج</sup>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="sum-text" style="width: 80%;">
                                            <b><i class="fa fa-calculator"></i> المجموع </b>
                                        </div>
                                        <div class="sum-value" style="width: 20%;">
                                            <b>

                                                <span id="total_price"
                                                    data-totalprice="300">
                                                    300.00
                                                    <sup>د.ج</sup>
                                                </span>
                                            </b>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            {{-- end form  --}}
