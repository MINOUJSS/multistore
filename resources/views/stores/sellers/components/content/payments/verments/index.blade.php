    <style>
        :root {
            --primary-color: #5a6f80;
            --secondary-color: #f8f9fa;
            --accent-color: #e9ecef;
        }

        body {
            background-color: var(--secondary-color);
            font-family: 'Tajawal', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

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

    <div class="checkout-container">
        <h2 class="mb-4 text-center">
            {{-- <i class="fas fa-shopping-cart me-2"></i>إتمام الطلب --}}
            <img src="{{ asset('asset/v1/users/store') }}/img/payments/bank.png" class="img-fluid" alt="chargily"
                width="200px" />
        </h2>

        <div class="row g-3">
            <div class="col-lg-7 col-md-6">
                <div class="sticky-top" style="top: 20px; z-index: 1019;">
                    <h5 class="mb-3"><i class="fas fa-truck me-2"></i>معلومات الشحن</h5>
                    <form>
                        <div class="row g-3">
                            {{-- test --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label">الإسم الكامل</label>
                                <input type="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="@if (old('name')) {{ old('name') }}@else{{ $order->customer_name }} @endif"
                                    disabled>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">رقم الهاتف</label>
                                <input type="phone" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror" id="phone"
                                    value="@if (old('phone')) {{ old('phone') }}@else{{ $order->phone }} @endif"
                                    disabled>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">العنوان</label>
                                <input type="text" name="address"
                                    class="form-control @error('address') is-invalid @enderror" id="address"
                                    value="@if (old('address')) {{ old('address') }}@else{{ $order->shipping_address }} @endif"
                                    placeholder="الحي، الشارع، رقم المنزل" disabled>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="inputWilaya" class="form-label">الولاية</label>
                                <select id="inputWilaya" name="wilaya"
                                    class="form-select @error('wilaya') is-invalid @enderror" disabled>
                                    <option value="0" selected>إختر الولاية...</option>
                                    @foreach ($wilayas as $wilaya)
                                        <option value="{{ $wilaya->id }}"
                                            {{ old('wilaya') == $wilaya->id || $order->wilaya_id == $wilaya->id ? 'selected' : '' }}>
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
                                    class="form-select @error('dayrea') is-invalid @enderror" disabled>
                                    <option value="0" selected>غير محددة ...</option>
                                    @if ($order->wilaya_id != null)
                                        @foreach (get_wilaya_data($order->wilaya_id)->dayras as $dayra)
                                            <option value="{{ $dayra->id }}"
                                                {{ old('dayra') == $dayra->id || $order->dayra_id == $dayra->id ? 'selected' : '' }}>
                                                {{ get_dayra_data($dayra->id)->ar_name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="0">...</option>
                                    @endif
                                    {{-- <option value="0">...</option> --}}
                                </select>
                                @error('dayrea')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="inputBaladia" class="form-label">البلدية</label>
                                <select id="inputBaladia" name="baladia"
                                    class="form-select @error('baladia') is-invalid @enderror" disabled>
                                    <option value="0" selected>غير محددة ...</option>

                                    @if ($order->dayra_id != null && get_dayra_data($order->dayra_id) !== 'هذه الدائرة غير موجودة')
                                        @foreach (get_dayra_data($order->dayra_id)->baladias as $baladia)
                                            <option value="{{ $baladia->id }}"
                                                {{ old('baladia') == $baladia->id || $order->baladia_id == $baladia->id ? 'selected' : '' }}>
                                                {{ get_baladia_data($baladia->id)->ar_name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="0">...</option>
                                    @endif
                                    {{-- <option value="0">...</option> --}}
                                </select>
                                @error('baladia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                <option value="" selected disabled>اختر المدينة</option>
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
                    </form>

                    {{-- <h5 class="mt-4 mb-3"><i class="fas fa-credit-card me-2"></i>طريقة الدفع</h5>
                <div class="payment-methods">
                    <div class="form-check mb-2 p-3 border rounded">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" checked>
                        <label class="form-check-label d-flex align-items-center" for="creditCard">
                            <i class="far fa-credit-card me-2 fs-5"></i>
                            <div>
                                <div>بطاقة ائتمانية</div>
                                <small class="text-muted">Visa, MasterCard, Mada</small>
                            </div>
                        </label>
                    </div>
                    
                    <div class="form-check mb-2 p-3 border rounded">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="mada">
                        <label class="form-check-label d-flex align-items-center" for="mada">
                            <i class="fas fa-credit-card me-2 fs-5"></i>
                            <div>
                                <div>مدى</div>
                                <small class="text-muted">مدفوعات آمنة عبر مدى</small>
                            </div>
                        </label>
                    </div>
                    
                    <div class="form-check p-3 border rounded">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="cashOnDelivery">
                        <label class="form-check-label d-flex align-items-center" for="cashOnDelivery">
                            <i class="fas fa-money-bill-wave me-2 fs-5"></i>
                            <div>
                                <div>الدفع عند الاستلام</div>
                                <small class="text-muted">الدفع نقداً عند التسليم</small>
                            </div>
                        </label>
                    </div>
                </div> --}}
                </div>
            </div>

            <div class="col-lg-5 col-md-6">
                <div class="sticky-top" style="top: 20px; z-index: 1019;">
                    <h5 class="mb-3"><i class="fas fa-receipt me-2"></i>ملخص الطلب</h5>
                    <div class="order-summary">
                        @php
                            $sub_total = 0;
                            $total = 0;
                            $discount = 0;
                        @endphp
                        @foreach ($order->items as $item)
                            <div class="product-item d-flex align-items-start">
                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                    class="me-3 rounded" width="60" height="60">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-semibold">{{ $item->product->name }}</span>
                                        {{-- @if (seller_product_has_discount($item->product->id))
                                <span>{{$item->product->activeDiscount->discount_amount}}<sup>د.ج</sup></span> <span class="text-decoration-line-through text-danger">{{$item->product->price}}<sup>د.ج</sup></span><sup><span class="text-success"> (-{{$item->product->activeDiscount->discount_percentage}}%)</span></sup>
                                @else
                                <span>{{$item->product->price}}<sup>د.ج</sup></span>
                                @endif --}}

                                        {{-- @if (seller_product_has_discount($item->product->id))
                                    <div style="text-align: left;">
                                        <span>{{$item->product->activeDiscount->discount_amount}}<sup>د.ج</sup></span> 
                                        <span class="text-decoration-line-through text-danger">{{$item->product->price}}<sup>د.ج</sup></span>
                                        <sup><span class="text-success"> (-{{$item->product->activeDiscount->discount_percentage}}%)</span></sup>
                                    </div>
                                @else --}}
                                        <div style="text-align: left;">
                                            <span>{{ $item->product->price }}<sup>د.ج</sup></span>
                                        </div>
                                        {{-- @endif --}}
                                    </div>
                                    <small class="text-muted d-block">الكمية: {{ $item->quantity }}</small>
                                    {{-- <small class="text-muted d-block">اللون: أبيض</small> --}}
                                    @if ($item->variation != null)
                                        <small class="text-muted d-block"> {{ $item->variation->sku }}</small>
                                    @endif
                                    @if ($item->attribute != null)
                                        <small class="text-muted d-block">{{ $item->attribute->attribute->name }} :
                                            {{ $item->attribute->value }}</small>
                                    @endif
                                </div>
                            </div>
                            @php
                                if ($item->product->activeDiscount) {
                                    $discount +=
                                        ($item->product->price - $item->product->activeDiscount->discount_amount) *
                                        $item->quantity;
                                }
                                $sub_total += $item->product->price * $item->quantity;
                                seller_product_has_discount($item->product->id)
                                    ? ($total += $item->product->activeDiscount->discount_amount * $item->quantity)
                                    : ($total += $item->product->price * $item->quantity);
                            @endphp
                        @endforeach


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

                        <div class="d-flex justify-content-between mb-2">
                            <span>المجموع الفرعي</span>
                            {{-- @if (seller_product_has_discount($item->product->id))
                        <span>{{$item->product->activeDiscount->discount_amount * $item->quantity}} <sup>د.ج</sup></span>
                        @else --}}
                            <span>{{ $sub_total }} <sup>د.ج</sup></span>
                            {{-- @endif --}}
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>الشحن</span>
                            <span>{{ $order->shipping_cost }} <sup>د.ج</sup></span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span>الخصم</span>
                            <span class="text-danger">- {{ $discount }} <sup>د.ج</sup></span>
                            {{-- @if (seller_product_has_discount($item->product->id))
                        <span class="text-danger">- {{($item->product->price - $item->product->activeDiscount->discount_amount) * $item->quantity}} <sup>د.ج</sup></span>
                        @else
                        <span class="text-danger">- 0.00 <sup>د.ج</sup></span>
                        @endif --}}
                        </div>

                        <div class="d-flex justify-content-between total-price py-2 border-top border-bottom mb-3">
                            <span>المجموع الكلي</span>
                            <span>{{ $total + $order->shipping_cost }} <sup>د.ج</sup></span>
                            {{-- @if (seller_product_has_discount($item->product->id))
                        <span>{{($item->product->activeDiscount->discount_amount * $item->quantity) + $order->shipping_cost}} <sup>د.ج</sup></span>
                        @else
                        <span>{{($item->unit_price * $item->quantity) + $order->shipping_cost}} <sup>د.ج</sup></span>
                        @endif --}}
                        </div>

                        {{-- <div class="form-check mt-4 mb-3">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                        <label class="form-check-label" for="agreeTerms">
                            أوافق على <a href="#" class="text-decoration-underline">الشروط والأحكام</a> وسياسة الخصوصية
                        </label>
                    </div> --}}
                        <div class="card shadow-sm border-0 mb-3">
    <div class="card-header text-center">
        <h5 class="mb-0">🏦 معلومات الحساب البنكي الخاص بالبائع</h5>
    </div>
    <div class="card-body bg-light">
        <ul class="list-unstyled mb-0">
            <li><strong>👤 المستفيد:</strong> {{ get_user_data(tenant('id'))->bank_settings->name }}</li>
            <li><strong>💳 رقم الحساب (RIP):</strong> {{ get_user_data(tenant('id'))->bank_settings->account_number }}</li>
            <li><strong>🏛️ البنك:</strong> {{ get_user_data(tenant('id'))->bank_settings->bank_name }}</li>
        </ul>

        <div class="mt-3 p-3 rounded bg-success text-white shadow-sm">
            <p class="mb-1"><strong>🆔 معرف البائع:</strong> {{ tenant('id') }}</p>
            <p class="mb-0"><strong>📦 رقم الطلبية:</strong> {{ $order->order_number }}</p>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-warning text-dark">
        <h6 class="mb-0">⚠️ تنبيه هام</h6>
    </div>
    <div class="card-body bg-light">
        <p class="fw-bold">
            تضمن المنصة للزبون حق تقديم شكوى رسمية في حالة الضرر من هذه المعاملة عبر اتباع الخطوات التالية:
        </p>
        <ol class="mb-0">
            <li>📋 انسخ رقم الطلبية، معرف البائع، ورقم الحساب البنكي واحتفظ بهم إلى غاية استلام الطلبية.</li>
            <li>🚨 في حالة وجود مشكلة، يمكن التبليغ من خلال الرابط التالي:
                <a href="{{ route('site.dispute.create') }}" target="_blank" class="fw-bold text-decoration-underline text-primary">
                    إضغط هنا لتقديم شكوى
                </a>
            </li>
        </ol>
    </div>
</div>

                        @if ($order->payment_status !== 'paid')
                            <form action="{{ route('tenant.payments.verments_pay') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf <!-- Laravel CSRF protection -->
                                <div class="d-grid">
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <input type="hidden" name="wilaya_id" value="{{ $order->wilaya_id }}">
                                    <input type="hidden" name="dayra_id" value="{{ $order->dayra_id }}">
                                    <input type="hidden" name="baladia_id" value="{{ $order->baladia_id }}">
                                    <input type="file" name="payment_proof" id="payment_proof"
                                        class="form-control mb-3 mt-3 @error('payment_proof') is-invalid @enderror"
                                        accept="application/pdf, image/jpeg, image/png" required>
                                    @error('payment_proof')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    {{-- <button class="btn btn-primary">
                                <i class="fas fa-check-circle me-2"></i>تأكيد الطلب
                            </button> --}}
                                    <!-- Add any hidden fields or form inputs here if needed -->
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check-circle me-2"></i>تأكيد الطلب
                                    </button>
                                </div>
                            </form>
                        @endif

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
