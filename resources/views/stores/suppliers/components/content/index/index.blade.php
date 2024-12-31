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
<section>
    <div class="container">
        <div class="row">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="{{asset('asset/users/store/img/slider/pc-slider1.png')}}" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="{{asset('asset/users/store/img/slider/pc-silder2.png')}}" class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="{{asset('asset/users/store/img/slider/pc-slider3.png')}}" class="d-block w-100" alt="...">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">السابق</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">التالي</span>
                </button>
              </div>
            
              {{-- category section  --}}
            <section class="featured-products py-5">
                <div class="container">
                    <h2 class="text-center mb-5 fade-in">الفئات المميزة</h2>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card category-card zoom-hover">
                                <img src="{{asset('asset/users/store/img/categories/all.png')}}" class="card-img-top" alt="إلكترونيات">
                                <div class="card-body">
                                    <h5 class="card-title">كل الفآت</h5>
                                    <p class="card-text">أحدث المنتجات</p>
                                    <a href="products.html" class="btn btn-outline-primary btn-ripple">استعرض المنتجات</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card category-card zoom-hover">
                                <img src="{{asset('asset/users/store/img/categories/clothe.png')}}" class="card-img-top" alt="أزياء">
                                <div class="card-body">
                                    <h5 class="card-title">أزياء</h5>
                                    <p class="card-text">أحدث صيحات الموضة</p>
                                    <a href="products.html" class="btn btn-outline-primary btn-ripple">استعرض المنتجات</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card category-card zoom-hover">
                                <img src="{{asset('asset/users/store/img/categories/clean.png')}}" class="card-img-top" alt="منزل">
                                <div class="card-body">
                                    <h5 class="card-title">مستلزمات النظافة</h5>
                                    <p class="card-text">كل ما يلزم النظافة</p>
                                    <a href="products.html" class="btn btn-outline-primary btn-ripple">استعرض المنتجات</a>
                                </div>
                            </div>
                        </div>
            
                        <div class="col-md-3">
                            <div class="card category-card zoom-hover">
                                <img src="{{asset('asset/users/store/img/categories/baby.png')}}" class="card-img-top" alt="منزل">
                                <div class="card-body">
                                    <h5 class="card-title">مستلزمات الأطفال</h5>
                                    <p class="card-text">كل ما يلزم طفلك</p>
                                    <a href="products.html" class="btn btn-outline-primary btn-ripple">استعرض المنتجات</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
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
<section>
    <div class="container">
        <div class="row">
            <div class="row products-container">
                <h2 class="text-center mb-5">احدث المنتجات</h2>
                <!-- Product Card Template -->
                <div class="col-md-3 mb-4">
                    <div class="card product-card product-hover">
                        <div class="position-relative zoom-hover">
                            <img src="{{asset('asset/users/store/img/products/product.webp')}}" class="card-img-top" alt="منتج">
                            <button class="quick-view-btn btn btn-light btn-ripple" data-product-id="1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">اسم المنتج</h5>
                            <div class="mb-2">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="far fa-star text-warning"></i>
                                <span class="ms-1">(4.0)</span>
                            </div>
                            <p class="price mb-3">2999 د.ج</p>
                            <div class="product-actions">
                                <a href="product-details.html" class="btn btn-outline-primary btn-ripple">عرض التفاصيل</a>
                                <button class="btn btn-primary btn-ripple" onclick="addToCartAnimation(this)">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Repeat product cards as needed -->
                <div class="col-md-3 mb-4">
                    <div class="card product-card product-hover">
                        <div class="position-relative zoom-hover">
                            <img src="{{asset('asset/users/store/img/products/product.webp')}}" class="card-img-top" alt="منتج">
                            <button class="quick-view-btn btn btn-light btn-ripple" data-product-id="1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">اسم المنتج</h5>
                            <div class="mb-2">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="far fa-star text-warning"></i>
                                <span class="ms-1">(4.0)</span>
                            </div>
                            <p class="price mb-3">2999 د.ج</p>
                            <div class="product-actions">
                                <a href="product-details.html" class="btn btn-outline-primary btn-ripple">عرض التفاصيل</a>
                                <button class="btn btn-primary btn-ripple" onclick="addToCartAnimation(this)">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-md-3 mb-4">
                    <div class="card product-card product-hover">
                        <div class="position-relative zoom-hover">
                            <img src="{{asset('asset/users/store/img/products/product.webp')}}" class="card-img-top" alt="منتج">
                            <button class="quick-view-btn btn btn-light btn-ripple" data-product-id="1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">اسم المنتج</h5>
                            <div class="mb-2">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="far fa-star text-warning"></i>
                                <span class="ms-1">(4.0)</span>
                            </div>
                            <p class="price mb-3">2999 د.ج</p>
                            <div class="product-actions">
                                <a href="product-details.html" class="btn btn-outline-primary btn-ripple">عرض التفاصيل</a>
                                <button class="btn btn-primary btn-ripple" onclick="addToCartAnimation(this)">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-md-3 mb-4">
                    <div class="card product-card product-hover">
                        <div class="position-relative zoom-hover">
                            <img src="{{asset('asset/users/store/img/products/product.webp')}}" class="card-img-top" alt="منتج">
                            <button class="quick-view-btn btn btn-light btn-ripple" data-product-id="1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">اسم المنتج</h5>
                            <div class="mb-2">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="far fa-star text-warning"></i>
                                <span class="ms-1">(4.0)</span>
                            </div>
                            <p class="price mb-3">2999 د.ج</p>
                            <div class="product-actions">
                                <a href="product-details.html" class="btn btn-outline-primary btn-ripple">عرض التفاصيل</a>
                                <button class="btn btn-primary btn-ripple" onclick="addToCartAnimation(this)">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</section>


{{-- fqa section  --}}
<section>
    <div class="container">
        <div class="row">
            <div class="row fqa-container mb-5">
                <h2 class="text-center mb-5">الاسئلة الشائعة</h2>
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                          Accordion Item #1
                        </button>
                      </h2>
                      <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body">
                          <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                          Accordion Item #2
                        </button>
                      </h2>
                      <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body">
                          <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                          Accordion Item #3
                        </button>
                      </h2>
                      <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                        <div class="accordion-body">
                          <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                      </div>
                    </div>
                  </div>
                
                </div>
            </div>
        </div>
    </div>
</section>
