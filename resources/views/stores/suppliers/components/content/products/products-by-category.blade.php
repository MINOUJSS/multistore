<div class="container">
@if (!empty($products))
<section>
    <div class="container">
        <div class="row">
            <div class="row products-container">
                <h2 class="text-center mb-5 mt-5">منتجات التصنيف</h2>
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
</div>