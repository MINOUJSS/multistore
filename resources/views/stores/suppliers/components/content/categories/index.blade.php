<div class="container">
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
</div>