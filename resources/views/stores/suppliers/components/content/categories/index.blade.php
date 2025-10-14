{{-- <div class="container">
    @if (!empty($categories))
    <section class="featured-products py-5">
        <div class="container">
            <h2 class="text-center mb-5 fade-in">الأصناف المميزة</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="card category-card zoom-hover">
                        <img src="{{asset('asset/v1/users/store/img/categories/0.png')}}" class="card-img-top" alt="إلكترونيات">
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
</div> --}}

{{-- <div class="container">
  @if (!empty($categories))
  <section class="featured-products py-5">
    <div class="container">
      <h2 class="text-center mb-5 fade-in">الأصناف المميزة</h2>
      <div class="row g-4">
        <!-- بطاقة "كل الأصناف" -->
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card h-100 shadow-sm border-0 category-card zoom-hover">
            <img src="{{asset('asset/v1/users/store/img/categories/0.png')}}" class="card-img-top rounded-top" alt="كل الأصناف">
            <div class="card-body d-flex flex-column justify-content-between">
              <div>
                <h5 class="card-title fw-bold">كل الأصناف</h5>
                <p class="card-text text-muted small">أحدث المنتجات</p>
              </div>
              <a href="/products" class="btn btn-outline-primary btn-sm mt-3 w-100">استعرض المنتجات</a>
            </div>
          </div>
        </div>

        <!-- الأصناف الديناميكية -->
        @foreach ($categories as $key => $category)
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card h-100 shadow-sm border-0 category-card zoom-hover">
            <img src="{{asset($category->image)}}" class="card-img-top rounded-top" alt="{{$category->category->name}}">
            <div class="card-body d-flex flex-column justify-content-between">
              <div>
                <h5 class="card-title fw-bold">{{$category->category->name}}</h5>
                <p class="card-text text-muted small">{{$category->category->description}}</p>
              </div>
              <a href="/products-by-category/{{$category->category_id}}" class="btn btn-outline-primary btn-sm mt-3 w-100">استعرض المنتجات</a>
            </div>
          </div>
        </div>
        @endforeach

      </div>
    </div>
  </section>
  @endif
</div> --}}


<div class="container">
@if (!empty($categories))
<section class="featured-products py-5">
  <div class="container">
    <h2 class="text-center mb-5 fade-in title">الأصناف و المميزة</h2>
    <div class="row g-3 justify-content-center">

      <!-- كارت "كل الأصناف" -->
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <div class="card text-center shadow-sm border-0 zoom-hover p-2 h-100">
          <img src="{{ asset('asset/v1/users/store/img/categories/0.png') }}" class="rounded-circle mx-auto d-block" alt="كل الأصناف" width="80" height="80">
          <div class="card-body p-2">
            <h6 class="card-title fw-bold mb-1 small">كل الأصناف</h6>
            <p class="text-muted small mb-2">أحدث المنتجات</p>
            <a href="/products" class="btn btn-sm btn-outline-primary btn-ripple w-100">عرض</a>
          </div>
        </div>
      </div>

      <!-- الكروت الديناميكية -->
      @foreach ($categories as $key => $category)
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <div class="card text-center shadow-sm border-0 zoom-hover p-2 h-100">
          <img src="{{ asset($category->image) }}" class="rounded-circle mx-auto d-block" alt="{{ $category->category->name }}" width="80" height="80">
          <div class="card-body p-2">
            <h6 class="card-title fw-bold mb-1 small">{{ $category->category->name }}</h6>
            <p class="text-muted small mb-2">{{ Str::limit($category->category->description, 30) }}</p>
            <a href="/products-by-category/{{ $category->category_id }}" class="btn btn-sm btn-outline-primary btn-ripple w-100">عرض</a>
          </div>
        </div>
      </div>
      @endforeach

    </div>
  </div>
</section>
@endif
</div>
