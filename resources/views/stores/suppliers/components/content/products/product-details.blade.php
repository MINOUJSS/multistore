<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-md-6">
            <div id="carouselExampleIndicators" class="carousel slide border rounded" data-bs-ride="carousel">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  @if(count($product_images)>0)
                  @foreach ($product_images as $index=>$product_image)
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$index+1}}" aria-label="Slide {{($index+1)+1}}"></button>
                  @endforeach
                  @endif
                  {{-- <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button> --}}
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="{{$product->image}}" class="d-block w-100" alt="...">
                  </div>
                  @if(count($product_images)>0)
                  @foreach ($product_images as $product_image)
                  <div class="carousel-item">
                    <img src="{{$product_image->image_path}}" class="d-block w-100" alt="...">
                  </div>
                  @endforeach
                  @endif
                  {{-- <div class="carousel-item">
                    <img src="..." class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="..." class="d-block w-100" alt="...">
                  </div> --}}
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
        </div>
        <div class="col-md-6">
            <h2 class="">{{$product->name}}</h2>
            <div class="mb-2">
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="far fa-star text-warning"></i>
                <span class="ms-1">(4.0)</span>
            </div>
            <h3>
              @if(supplier_product_has_discount($product->id))
              <span id="product_price">{{$product->activeDiscount->discount_amount}}</span> <sup>د.ج</sup> <span class="text-decoration-line-through text-danger">{{$product->price}}<sup>د.ج</sup></span><sup><span class="text-success"> (-{{$product->activeDiscount->discount_percentage}}%)</span></sup>
              @else
              <span id="product_price">{{$product->price}}</span> <sup>د.ج</sup>
              @endif
            </h3>
            <p class="">{{$product->short_description}}</p>
            {{-- order form  --}}
            <form id="orderForm" action="/order" class="row g-3 border p-3 rounded mt-3 mb-3" method="POST">
              @csrf  
              <div class="col-md-6">
                  <label for="name" class="form-label">الإسم الكامل</label>
                  <input type="name" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}">
                  @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="phone" class="form-label">رقم الهاتف</label>
                  <input type="phone"  name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone') }}" onchange="create_abandoned_order();">
                  @error('phone')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-12">
                  <label for="address" class="form-label">العنوان</label>
                  <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address" value="{{ old('address') }}" placeholder="الحي، الشارع، رقم المنزل">
                  @error('address')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-4">
                    <label for="inputWilaya" class="form-label">الولاية</label>
                    <select id="inputWilaya" name="wilaya" class="form-select @error('wilaya') is-invalid @enderror" onchange="show_shipping_prices(this.value);">
                      <option value="0" selected>إختر الولاية...</option>
                      @foreach ($wilayas as $wilaya)
                          <option value="{{ $wilaya->wilaya_id }}" {{ old('wilaya') == $wilaya->wilaya_id ? 'selected' : '' }}>
                              {{ get_wilaya_data($wilaya->wilaya_id)->ar_name }}
                          </option>
                      @endforeach
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
                        <h5>التوصيل</h5>
                        <p id="show_shipping_price">إختر الولاية</p>
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
                  </div>
                  <!--product options-->
                  @if(supplier_product_has_variations($product->id) && count($product->variations)>1)
                  <div class="row mt-3 mb-3">
                    <div class="col-md-12">
                      <h5>إختر اللون</h5>
                      @foreach($product_variations as $product_variation)
                      <input class="form-check-input" type="radio" name="product_varition" value="{{$product_variation->id}}" style="background-color: {{$product_variation->color}};width:30px;height:30px;border:1px solid #000;">
                      @endforeach
                    </div>     
                  </div>
                  @endif
                  @if(supplier_product_has_attributes($product->id) && count($product->attributes)>1)
                  <div class="row mt-3 mb-3">
                    <div class="col-md-12">
                      @foreach($product_attributes as $index => $product_attribute)
                      @if($index==0)
                      <h5>إختر {{get_supplier_attribute_name($product_attribute->attribute->id)}}</h5>
                      @endif
                      @if(atrribute_has_more_values($product_attribute->attribute_id))
                      <input class="form-check-input" type="radio" name="product_attribute" value="{{$product_attribute->id}}">
                      <label for="product_attribute">{{$product_attribute->value}}</label>
                      @endif
                      @endforeach
                    </div>     
                  </div>
                  @endif
                  <!--/product options-->
                  <!--payment method-->
                  <div class="row mb-3 mt-3">
                    <div class="col-md-12">
                      <h5>إختر طريقة الدفع</h5>
                      <input class="form-check-input" type="radio" name="payment_method" value="cod" checked/>
                      <label for="chargily">الدفع عند الإستلام</label>
                      <input class="form-check-input" type="radio" name="payment_method" value="chargily"/>
                      <label for="chargily">البطاقة الدهبية أو CIB</label>
                      <input class="form-check-input" type="radio" name="payment_method" value="baridimob"/>
                      <label for="chargily">بريدي موب</label>
                    </div>
                  </div>
                  <!--/payment method-->
                  <div class="row mb-3 mt-3">
                    <div class="col-md-4">
                        {{-- @livewire('supplier-item-qty-controller') --}}
                        <div class="d-flex justify-content-center">
                            <a class="btn border rounded" onclick="increment_qty({{$product->qty}});countTotalPrice()"><i class="fas fa-plus"></i></a>
                            <span id="livewier_qty" class="fw-bold w-100 text-center">{{$product->minimum_order_qty}}</span>
                            <input id="hidden_qty" type="hidden" name="qty" value="{{$product->minimum_order_qty}}">
                            @error('qty')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <a class="btn border rounded" onclick="decrement_qty({{$product->minimum_order_qty}});countTotalPrice()"><i class="fas fa-minus"></i></a>  
                          </div>
                    </div>
                <div class="col-md-8">
                  {{-- <input type="hidden" name="supplier_id" value="{{$product->supplier_id}}" /> --}}
                  {{-- <input type="hidden" name="user_id" value="{{(auth()->user())? auth()->user()->id : 'null' }}"/> --}}
                  <input type="hidden" name="product_id" value="{{$product->id}}"/>
                  {{-- <input type="hidden" name="product_name" value="{{$product->name}}"/>
                  @if(supplier_product_has_discount($product->id))
                  <input type="hidden" name="price" value="{{$product->activeDiscount->discount_amount}}" />
                  @else
                  <input type="hidden" name="price" value="{{$product->price}}" />
                  @endif
                  <input type="hidden" name="shipping_cost" value="0"/>
                  @if(supplier_product_has_discount($product->id))
                  <input type="hidden" name="form_total_amount" id="form_total_amount" value="{{($product->minimum_order_qty * $product->activeDiscount->discount_amount)+300}}" />
                  @else
                  <input type="hidden" name="form_total_amount" id="form_total_amount" value="{{($product->minimum_order_qty * $product->price)+300}}" />
                  @endif --}}
                  <button type="submit" class="form-control btn btn-primary"><i class="fas fa-shopping-cart"></i>اشتري الآن</button>
                </div>
                  </div>
                <div class="col-12">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                              <i class="fas fa-shopping-cart"></i>  ملخص الطلبية
                            </button>
                          </h2>
                          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="sm-product-img" style="width: 20%;">
                                        <img src="{{asset($product->image)}}" height="50px" width="50px" alt="">
                                    </div>
                                    <div class="sm-product-name w-60" style="width: 50%;">
                                        <h3 class="">{{$product->name}}</h3>
                                    </div>
                                    <div class="qty" style="width: 10%;">
                                        X<span id="qty">{{$product->minimum_order_qty}}</span>
                                    </div>
                                    <div class="sm-product-price" style="width: 20%;">
                                      @if(supplier_product_has_discount($product->id))
                                      <span class="price">{{$product->activeDiscount->discount_amount}} <sup>د.ج</sup></span>
                                      @else
                                      <span class="price">{{$product->price}} <sup>د.ج</sup></span>
                                      @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="shipping" style="width: 80%;">
                                        <i class="fas fa-truck"></i> التوصيل
                                    </div>
                                    <div class="shipping-price" style="width: 20%;">
                                        <span id="shipping_price" class="price" >إختر الولاية</span><sup> د.ج</sup>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="sum-text" style="width: 80%;">
                                        <i class="fa fa-calculator"></i> المجموع
                                    </div>
                                    <div class="sum-value" style="width: 20%;">
                                      @if(supplier_product_has_discount($product->id))
                                      <span id="total_price">{{($product->minimum_order_qty * $product->activeDiscount->discount_amount)}}</span> <sup>د.ج</sup>
                                      @else
                                      <span id="total_price">{{($product->minimum_order_qty * $product->price)}}</span> <sup>د.ج</sup>
                                      @endif
                                    </div>
                                </div>
                                
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
              </form>
            {{-- end form  --}}
            {!!$product->description!!}
        </div>
    </div>
</div>