<div class="container">
{{-- section for welcome message --}}
<section>
    <div class="container">
        <div class="row welcome-container">
            <h2 class="text-center">مرحبا بكم في متجرنا</h2>
            <p class="text-center">تمتلك متجرنا مجموعة من المنتجات والخدمات التي تقدمها لكم</p>
        </div>
    </div>
</section>

{{-- slider section  --}}
@if (!empty($sliders))
<section>
    <div class="container">
        <div class="row">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach ($sliders as $key => $slider)
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$key}}" @if ($key == 0){{"class=active aria-current=true"}} @endif aria-label="Slide {{$key+1}}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach ($sliders as $key => $slider)
                  <div class="carousel-item @if ($key == 0){{"active"}} @endif">
                    <img src="{{asset($slider->image)}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{$slider->title}}</h5>
                        <p>{{$slider->description}}</p>
                      </div>
                  </div>
                    @endforeach
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
    </div>
</section>
@endif        
              {{-- category section  --}}
@if (!empty($categories))
<section class="featured-products py-5">
    <div class="container">
        <h2 class="text-center mb-5 fade-in">الأصناف المميزة</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card category-card zoom-hover">
                    <img src="{{asset('asset/users/store/img/categories/0.png')}}" class="card-img-top" alt="إلكترونيات">
                    <div class="card-body">
                        <h5 class="card-title">كل الأصناف</h5>
                        <p class="card-text">أحدث المنتجات</p>
                        <a href="/products" class="btn btn-outline-primary btn-ripple">استعرض المنتجات</a>
                    </div>
                </div>
            </div>
            @foreach ($categories as $key => $category)
            <div class="col-md-3">
                <div class="card category-card zoom-hover">
                    <img src="{{asset($category->image)}}" class="card-img-top" alt="إلكترونيات">
                    <div class="card-body">
                        <h5 class="card-title">{{$category->category->name}}</h5>
                        <p class="card-text">{{$category->category->description}}</p>
                        <a href="/products-by-category/{{$category->category_id}}" class="btn btn-outline-primary btn-ripple">استعرض المنتجات</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
{{-- benefits section  --}}
<section>
    <div class="container">
        <div class="row">
            <section class="benefits-section py-5 glass-effect">
                <div class="container">
                    <h2 class="text-center mb-5">لماذا تختارنا؟</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="benefit-card">
                                <i class="fas fa-truck"></i>
                                <h4>شحن سريع</h4>
                                <p>توصيل سريع لجميع أنحاء البلاد</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="benefit-card">
                                <i class="fas fa-shield-alt"></i>
                                <h4>دفع آمن</h4>
                                <p>طرق دفع متعددة وآمنة</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="benefit-card">
                                <i class="fas fa-undo"></i>
                                <h4>ضمان الإرجاع</h4>
                                <p>إرجاع مجاني خلال 14 يوم</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>


{{-- last product section  --}}
@if (!empty($products))
<section>
    <div class="container">
        <div class="row">
            <div class="row products-container">
                <h2 class="text-center mb-5">احدث المنتجات</h2>
                <!-- Product Card Template -->
                @foreach ($products as $key => $product)
                <div class="col-md-3 mb-4">
                    <div class="card product-card product-hover">
                        <div class="position-relative zoom-hover">
                            <img src="{{asset($product->image)}}" class="card-img-top" alt="{{$product->name}}">
                            <button class="quick-view-btn btn btn-light btn-ripple" data-product-id="{{$key}}">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$product->name}}</h5>
                            <div class="mb-2">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="far fa-star text-warning"></i>
                                <span class="ms-1">(4.0)</span>
                            </div>
                            <p class="price mb-3">{{$product->price}} <sup>د.ج</sup></p>
                            <div class="product-actions">
                                <a href="/product/{{$product->id}}" class="btn btn-outline-primary btn-ripple">عرض التفاصيل</a>
                                <button class="btn btn-primary btn-ripple" onclick="addToCartAnimation(this)">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach     
            </div>
        </div>
    </div>
</section>
@endif

{{-- fqa section  --}}
<section>
    <div class="container">
        <div class="row">
            <div class="row fqa-container mb-5">
                <h2 class="text-center mb-5">الاسئلة الشائعة</h2>
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    @foreach ($faqs as $key => $faq)
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="panelsStayOpen-heading{{$key}}">
                        <button class="accordion-button @if($key !== 0){{'collapsed'}}@endif" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{$key}}" @if($key == 0){{'aria-expanded=true'}}@else{{'aria-expanded=false'}}@endif aria-controls="panelsStayOpen-collapse{{$key}}">
                          {{$faq->question}}
                        </button>
                      </h2>
                      <div id="panelsStayOpen-collapse{{$key}}" class="accordion-collapse collapse @if($key == 0){{'show'}}@else{{'collapsed'}}@endif" @if($key == 0){{'aria-labelledby=panelsStayOpen-headingshow'}}@endif aria-labelledby="panelsStayOpen-heading{{$key}}">
                        <div class="accordion-body">
                          {{$faq->answer}}
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                
                </div>
            </div>
        </div>
    </div>
</section>
