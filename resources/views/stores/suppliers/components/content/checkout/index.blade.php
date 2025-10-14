    <style>
        :root {
            --primary-color: #5a6f80;
            --secondary-color: #f8f9fa;
            --accent-color: #e9ecef;
        }

        /* body {
            background-color: var(--secondary-color);
            font-family: 'Tajawal', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        } */

        .checkout-container {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(90, 111, 128, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px;
            font-size: 1.1rem;
        }

        .btn-primary:hover {
            background-color: #4a5b69;
            border-color: #3e4b56;
        }

        .order-summary {
            background-color: var(--accent-color);
            border-radius: 8px;
            padding: 15px;
            height: 100%;
        }

        .product-item {
            border-bottom: 1px solid #dee2e6;
            padding: 12px 0;
        }

        .total-price {
            font-weight: bold;
            font-size: 1.2rem;
            color: var(--primary-color);
        }

        .color-swatch {
            width: 20px;
            height: 20px;
            display: inline-block;
            border: 1px solid #dee2e6;
        }

        /* تحسينات التجاوب */
        @media (max-width: 992px) {
            .checkout-container {
                margin: 10px auto;
                padding: 15px;
            }

            .btn-primary {
                padding: 10px;
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            .checkout-container {
                border-radius: 0;
                box-shadow: none;
                margin: 0;
                padding: 10px;
            }

            .col-md-7,
            .col-md-5 {
                padding: 0 5px;
            }

            h2 {
                font-size: 1.5rem;
            }

            h5 {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            body {
                font-size: 14px;
            }

            .form-control,
            .form-select,
            .btn {
                font-size: 14px;
            }

            .product-item {
                padding: 8px 0;
            }
        }
    </style>

    @php
        $free_shipping = true;
    @endphp
    @foreach (session('cart')->items as $item)
        @php
            if ($item['free_shipping'] === 'no') {
                $free_shipping = false;
            }
        @endphp
    @endforeach

    <div class="checkout-container">
        <h2 class="mb-4 text-center"><i class="fas fa-shopping-cart me-2"></i>إتمام الطلب</h2>

        <div class="row g-3">
            <div class="col-lg-7 col-md-6">
                <div class="sticky-top" style="top: 20px; z-index: 1019;">
                    <h5 class="mb-3"><i class="fas fa-truck me-2"></i>معلومات الشحن</h5>
                    <form action="{{ route('tenant.order-with-items') }}" method="POST">
                        @csrf
                        <div class="col-12 text-center">
                            <p>{{ $order_form->form_title }}</p>
                        </div>
                        <input type="hidden" name="device_fingerprint" id="device_fingerprint">
                        <div class="row g-3">
                            {{-- test --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label">{{$order_form->lable_customer_name}} <sup class="text-danger">@if($order_form->customer_name_required === 'true')*@endif</sup></label>
                                <input type="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name') }}" placeholder="{{$order_form->input_placeholder_customer_name}}" @if($order_form->customer_name_required === 'true') required @endif>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">{{$order_form->lable_customer_phone}} <sup class="text-danger">@if($order_form->customer_phone_required === 'true')*@endif</sup></label>
                                <input type="phone" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror" id="phone"
                                    value="{{ old('phone') }}" placeholder="{{$order_form->input_placeholder_customer_phone}}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12" style="display: @if($order_form->customer_address_visible === 'true') block @else none @endif">
                                <label for="address" class="form-label">{{$order_form->lable_customer_address}} <sup class="text-danger">@if($order_form->customer_address_required === 'true')*@endif</sup></label>
                                <input type="text" name="address"
                                    class="form-control @error('address') is-invalid @enderror" id="address"
                                    value="{{ old('address') }}" placeholder="{{$order_form->input_placeholder_customer_address}}" @if($order_form->customer_address_required === 'true' && $order_form->customer_address_visible === 'true') required @endif>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12" style="display: @if($order_form->customer_notes_visible === 'true') block @else none @endif">
                                <label for="note" class="form-label">{{$order_form->lable_customer_notes}} <sup class="text-danger">@if($order_form->customer_notes_required === 'true')*@endif</sup></label>
                                <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note" rows="3" placeholder="{{$order_form->input_placeholder_customer_notes}}" @if($order_form->customer_notes_required === 'true' && $order_form->customer_notes_visible === 'true') required @endif></textarea>
                                @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="inputWilaya" class="form-label">الولاية</label>
                                <select id="inputWilaya" name="wilaya"
                                    class="form-select @error('wilaya') is-invalid @enderror"
                                    onchange="show_shipping_prices(this.value);">
                                    <option value="0" selected>إختر الولاية...</option>
                                    @foreach ($wilayas as $wilaya)
                                        <option value="{{ $wilaya->id }}"
                                            {{ old('wilaya') == $wilaya->id ? 'selected' : '' }}>
                                            {{ get_wilaya_data($wilaya->id)->ar_name }}
                                        </option>
                                        {{-- <option value="{{ $wilaya->id }}" {{ old('wilaya') == $wilaya->id ? 'selected' : '' }}>
                              {{ get_wilaya_data($wilaya->id)->ar_name }}
                          </option> --}}
                                    @endforeach
                                </select>

                                @error('wilaya')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="inputDayra" class="form-label">الدئرة</label>
                                <select id="inputDayra" name="dayra"
                                    class="form-select @error('dayra') is-invalid @enderror">
                                    <option value="0" selected>إختر الدائرة ...</option>
                                    <option value="0">...</option>
                                </select>
                                @error('dayrea')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="inputBaladia" class="form-label">البلدية</label>
                                <select id="inputBaladia" name="baladia"
                                    class="form-select @error('baladia') is-invalid @enderror">
                                    <option value="0" selected>إختر البلدية ...</option>
                                    <option value="0">...</option>
                                </select>
                                @error('baladia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="row mt-3 mb-3">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5>التوصيل</h5>

                                        @if ($free_shipping)
                                            <p id="show_shipping_price">التوصيل مجاني</p>
                                        @else
                                            <p id="show_shipping_price">إختر الولاية</p>
                                        @endif
                                    </div>
                                    <div id="shipping_method"
                                        class="row d-flex justify-content-between align-items-center"
                                        style="display: none !important;">

                                        <div class="col-md-6">
                                            <div class="card p-3 text-center border option-card" id="card_home"
                                                onclick="selectOption('home');show_to_home_price();countTotalPrice();">
                                                <input class="form-check-input d-none" type="radio" id="to_home"
                                                    name="shipping_and_point" value="home"
                                                    {{ old('shipping_and_point', 'home') == 'home' ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="to_home">التوصيل
                                                    للمنزل</label>
                                                <p id="to_home_price">00</p><sup> د.ج</sup>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card p-3 text-center border option-card" id="card_descktop"
                                                onclick="selectOption('descktop');show_to_desck_price();countTotalPrice();">
                                                <input class="form-check-input d-none" type="radio"
                                                    id="to_descktop" name="shipping_and_point" value="descktop"
                                                    {{ old('shipping_and_point') == 'descktop' ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="to_descktop">التوصيل
                                                    للمكتب</label>
                                                <p id="to_desck_price">00</p><sup> د.ج</sup>
                                            </div>
                                        </div>

                                    </div>

                                    @error('shipping_and_point')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="row mt-3 mb-3">
                    <div class="col-md-12">
                      <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5>التوصيل</h5>
                      </div>
                      <div id="shipping_method" class="row d-flex justify-content-between align-items-center" style="display: none !important;">
 
                        <div class="col-md-6">
                            <div class="card p-3 text-center border option-card" id="card_home" onclick="selectOption('home');show_to_home_price();countTotalPrice();">
                                <input class="form-check-input d-none" type="radio" id="to_home" name="shipping_and_point" value="home" 
                                    {{ old('shipping_and_point','home') == 'home' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="to_home">التوصيل للمنزل</label>
                                <p id="to_home_price">00</p><sup> د.ج</sup>
                            </div>
                        </div> 
                        
                        <div class="col-md-6">
                          <div class="card p-3 text-center border option-card" id="card_descktop" onclick="selectOption('descktop');show_to_desck_price();countTotalPrice();">
                              <input class="form-check-input d-none" type="radio" id="to_descktop" name="shipping_and_point" value="descktop" 
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
                  </div> --}}

                            {{-- <div class="col-md-6">
                            <label for="fullName" class="form-label">الاسم الكامل</label>
                            <input type="text" class="form-control" id="fullName" value="{{$order->customer_name}}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="tel" class="form-control" id="phone" value="{{$order->phone}}" required>
                        </div>
                        
                        <div class="col-12">
                            <label for="address" class="form-label">العنوان</label>
                            <textarea class="form-control" id="address" rows="2" required></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="city" class="form-label">المدينة</label>
                            <select class="form-select" id="city" required>
                                <option value="" selected >اختر المدينة</option>
                                <option value="الرياض">الرياض</option>
                                <option value="جدة">جدة</option>
                                <option value="مكة">مكة</option>
                                <option value="الدمام">الدمام</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="district" class="form-label">الحي</label>
                            <input type="text" class="form-control" id="district" required>
                        </div> --}}
                        </div>
                        {{-- </form> --}}

                        <h5 class="mt-4 mb-3"><i class="fas fa-credit-card me-2"></i>طريقة الدفع</h5>
                        <div class="payment-methods">
                            <div class="form-check p-3 border rounded">
                                <input class="form-check-input" type="radio" name="payment_method"
                                    id="cashOnDelivery" value="cod" checked>
                                <label class="form-check-label d-flex align-items-center" for="cashOnDelivery">
                                    <i class="fas fa-money-bill-wave me-2 fs-5"></i>
                                    <div>
                                        <div>الدفع عند الاستلام</div>
                                        <small class="text-muted">الدفع نقداً عند التسليم</small>
                                    </div>
                                </label>
                            </div>

                            @if (is_supplier_aproved(tenant('id')) && is_chargily_settings_exists(tenant('id')))
                                <div class="form-check mb-2 p-3 border rounded">
                                    <input class="form-check-input" type="radio" name="payment_method"
                                        id="creditCard" value="chargily">
                                    <label class="form-check-label d-flex align-items-center" for="creditCard">
                                        <i class="far fa-credit-card me-2 fs-5"></i>
                                        <div>
                                            <div>chargily</div>
                                            <small class="text-muted">Cib,El Dahabia </small>
                                        </div>
                                    </label>
                                </div>
                            @endif

                            @if (is_supplier_aproved(tenant('id')) && is_supplier_bank_account_exists(tenant('id')))
                                <div class="form-check mb-2 p-3 border rounded">
                                    <input class="form-check-input" type="radio" name="payment_method"
                                        id="mada" value="verments">
                                    <label class="form-check-label d-flex align-items-center" for="mada">
                                        <i class="fas fa-credit-card me-2 fs-5"></i>
                                        <div>
                                            <div>حوالة بنكية</div>
                                            <small class="text-muted">Ccp, Baridimob, ...</small>
                                        </div>
                                    </label>
                                </div>
                            @endif

                        </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-6">
                <div class="sticky-top" style="top: 20px; z-index: 1019;">
                    <h5 class="mb-3"><i class="fas fa-receipt me-2"></i>ملخص الطلب</h5>
                    <div class="order-summary">
                        @include('stores.suppliers.components.content.checkout.inc.items')

                        {{-- <div class="product-item d-flex align-items-start">
                        <img src="https://via.placeholder.com/60" alt="ماكينة حلاقة" class="me-3 rounded" width="60" height="60">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold">ماكينة حلاقة</span>
                                <span>199 ر.س</span>
                            </div>
                            <small class="text-muted d-block">الكمية: 1</small>
                            <small class="text-muted d-block">اللون: فضي</small>
                        </div>
                    </div> --}}

                        <hr class="my-3">
                        <div class="col-12">
                            <label for="coupon" class="form-label">كود الكوبون</label>
                            <input type="text" name="coupon"
                                class="form-control @error('coupon') is-invalid @enderror" id="coupon"
                                value="{{ old('coupon') }}" placeholder="أدخل كود الكوبون هنا للحصول على خصم">
                            @error('coupon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr class="my-3">

                        <div class="d-flex justify-content-between mb-2">
                            <span>المجموع الفرعي</span>
                            @if (session()->has('cart') && session()->get('cart')->totalPrice != null)
                                <div class="d-flex justify-content-between">
                                    <span
                                        id="sub_total">{{ number_format(session()->get('cart')->totalPrice, 2) }}</span>
                                    <sup>د.ج</sup>
                                </div>
                            @else
                                <div class="d-flex justify-content-between">
                                    <span id="sub_total">0.00</span>
                                    <sup>د.ج</sup>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>الشحن</span>
                            {{-- <span>0 ر.س</span> --}}
                            <div class="d-flex justify-content-between">
                                <span id="shipping_price" class="price">00</span><sup>د.ج</sup>
                            </div>


                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>الخصم</span>
                            <div class="d-flex justify-content-between">
                                <span id="discount" class="text-danger">00</span><sup>د.ج</sup>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between total-price py-2 border-top border-bottom">
                            <span>المجموع الكلي</span>
                            <div class="d-flex justify-content-between">
                                <span id="total">{{ number_format(session()->get('cart')->totalPrice, 2) }}</span>
                                <sup>د.ج</sup>
                            </div>
                        </div>

                        {{-- <div class="form-check mt-4 mb-3">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                        <label class="form-check-label" for="agreeTerms">
                            أوافق على <a href="#" class="text-decoration-underline">الشروط والأحكام</a> وسياسة الخصوصية
                        </label>
                    </div> --}}

                        <div class="d-grid">
                            <button class="btn btn-primary">
                                <i class="fas fa-check-circle me-2"></i>تأكيد الطلب
                            </button>
                        </div>
                        </form>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-lock me-1"></i>معلومات الدفع مشفرة وآمنة
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
