<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-md-6">
            <div id="carouselExampleIndicators" class="carousel slide border rounded" data-bs-ride="carousel">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  {{-- <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button> --}}
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="{{asset($product->image)}}" class="d-block w-100" alt="...">
                  </div>
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
            <h3><span id="product_price">{{$product->price}}</span> <sup>د.ج</sup> <span class="text-decoration-line-through">200<sup>د.ج</sup></span></h3>
            <p class="">{{$product->short_description}}</p>
            {{-- order form  --}}
            <form class="row g-3 border p-3 rounded mt-3 mb-3">
                <div class="col-md-6">
                  <label for="inputEmail4" class="form-label">الإسم الكامل</label>
                  <input type="email" class="form-control" id="inputEmail4">
                </div>
                <div class="col-md-6">
                  <label for="inputPassword4" class="form-label">رقم الهاتف</label>
                  <input type="password" class="form-control" id="inputPassword4">
                </div>
                <div class="col-12">
                  <label for="inputAddress" class="form-label">العنوان</label>
                  <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                </div>
                <div class="col-md-4">
                    <label for="inputWilaya" class="form-label">الولاية</label>
                    <select id="inputWilaya" class="form-select">
                      <option selected>إختر الولاية...</option>
                      @foreach ($wilayas as $wilaya)
                      <option value="{{$wilaya->id}}">{{$wilaya->ar_name}}</option>
                      @endforeach
                    </select>
                  </div>
                <div class="col-md-4">
                  <label for="inputDayra" class="form-label">الدئرة</label>
                  <select id="inputDayra" class="form-select">
                    <option selected>إختر الدائرة...</option>
                    <option>...</option>
                  </select>
                </div>
                <div class="col-md-4">
                    <label for="inputBaladia" class="form-label">البلدية</label>
                    <select id="inputBaladia" class="form-select">
                        <option selected>إختر البلدية...</option>
                        <option>...</option>
                      </select>
                  </div>
                  <div class="row mb-3 mt-3">
                    <div class="col-md-4">
                        {{-- @livewire('supplier-item-qty-controller') --}}
                        <div class="d-flex justify-content-center">
                            <a class="btn border rounded" onclick="increment_qty({{$product->qty}});countTotalPrice()"><i class="fas fa-plus"></i></a>
                            <span id="livewier_qty" class="fw-bold w-100 text-center">{{$product->minimum_order_qty}}</span>
                            <input id="hidden_qty" type="hidden" name="qty" value="{{$product->minimum_order_qty}}">
                            <a class="btn border rounded" onclick="decrement_qty({{$product->minimum_order_qty}});countTotalPrice()"><i class="fas fa-minus"></i></a>  
                          </div>
                    </div>
                <div class="col-md-8">
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
                                        <span class="price">{{$product->price}} <sup>د.ج</sup></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="shipping" style="width: 80%;">
                                        <i class="fas fa-truck"></i> التوصيل
                                    </div>
                                    <div class="shipping-price" style="width: 20%;">
                                        <span id="shipping_price" class="price" >300</span> <sup>د.ج</sup>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="sum-text" style="width: 80%;">
                                        <i class="fa fa-calculator"></i> المجموع
                                    </div>
                                    <div class="sum-value" style="width: 20%;">
                                        <span id="total_price">{{($product->minimum_order_qty * $product->price)+300}}</span> <sup>د.ج</sup>
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