<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="d-lg-block d-lg-none d-xl-block d-xl-none d-xxl-block d-xxl-none">
            <i id="search-btn" class="fa-solid fa-magnifying-glass"></i>
            <button type="button" class="btn position-relative" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                <i class="fa-solid fa-cart-shopping"></i>
                <span
                    class="nav-cart-qty position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">
                    @if (session()->has('cart'))
                        {{ session()->get('cart')->totalQty }}
                    @else
                        0
                    @endif
                    <span class="visually-hidden">unread messages</span>
                </span>
            </button>
        </div>
        <a class="navbar-brand"
            href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}"><img
                src="{{ asset(get_store_logo(tenant('id'))) }}" width="50px" height="50px" alt="logo"></a>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav hstacks gap-3 mx-auto">
                <a class="nav-link active" aria-current="page"
                    href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}">الرئيسية</a>
                                    <a class="nav-link"
                    href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}/products">منتجاتنا</a>
                <a class="nav-link"
                    href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}/contact-us">إتصل
                    بنا</a>
                <a class="nav-link"
                    href="{{ url(request()->server('REQUEST_SCHEME') . '://' . get_tenant_data(tenant('id'))->domains[0]->domain) }}/categories">التصنيفات</a>
                <!-- <a class="nav-link disabled" aria-disabled="false">Disabled</a> -->
            </div>
            <div class="navbar-nav search-btn">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="navbar-nav" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                aria-controls="offcanvasScrolling">
                <ul class="list-group list-group-horizontal cart">
                    <li class="nav-cart-total list-group-item">
                        @if (session()->has('cart'))
                            {{ number_format(session()->get('cart')->totalPrice, 2) }}
                        @else
                            0.00
                        @endif
                        <span>د.ج</span>
                    </li>
                    <li class="list-group-item"><i class="fa-solid fa-cart-shopping"></i>
                        <span
                            class="nav-cart-qty position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">
                            @if (session()->has('cart'))
                                {{ session()->get('cart')->totalQty }}
                            @else
                                0
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!--start search-->
<div class="container">
    <div class="input-group mb-3 search-box" style="display: none !important; align-items: center;">
        <!---->
        @if(count(get_supplier_categories(tenant('id'))) > 0)
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false" style="flex-shrink: 0;" id="categoryDropdownBtn">كل الأصناف</button>
        <ul class="dropdown-menu" id="categoryDropdown">
            @foreach (get_supplier_categories(tenant('id')) as $category)
                @if ($category->name == 'بدون تصنيف')
                    <li><a class="dropdown-item" href="#" data-category-id="{{ $category->id }}">{{ $category->name }}</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                @else
                    <li><a class="dropdown-item" href="#" data-category-id="{{ $category->id }}">{{ $category->name }}</a></li>
                @endif
            @endforeach
        </ul>
        @endif
        <!---->
        <form class="d-flex" action="{{route('tenant.products-search')}}" method="GET" style="flex-grow: 1; min-width: 0;">
            {{-- @csrf --}}
            @if(count(get_supplier_categories(tenant('id'))) > 0)
            <input type="hidden" class="form-control" name="category" id="selectedCategory" value="{{ get_supplier_categories(tenant('id'))[0]->id }}">
            @endif
            <input type="text" class="form-control" name="search" aria-label="Text input with dropdown button" style="flex-grow: 1; min-width: 0;">
            <button type="submit" class="input-group-text" id="inputGroup-sizing-default" style="flex-shrink: 0;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>
</div>

{{-- <!--start search-->
<div class="container">
    <div class="input-group mb-3 search-box" style="display: none !important; align-items: center;">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false" style="flex-shrink: 0;">كل الأصناف</button>
        <ul class="dropdown-menu">
            <!-- محتوى القائمة المنسدلة -->
                        @foreach (get_supplier_categories(tenant('id')) as $category)
                @if ($category->name == 'بدون تصنيف')
                    <li><a class="dropdown-item" href="#">{{ $category->name }}</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                @else
                    <li><a class="dropdown-item" href="#">{{ $category->name }}</a></li>
                @endif
            @endforeach
        </ul>
        <form class="d-flex" action="{{route('tenant.products-search')}}" method="POST" style="flex-grow: 1; min-width: 0;">
            @csrf
            <input type="hidden" class="form-control" name="category" value="{{get_supplier_categories(tenant('id'))[0]->id}}">
            <input type="text" class="form-control" name="search" aria-label="Text input with dropdown button" style="flex-grow: 1; min-width: 0;">
            <button type="submit" class="input-group-text" id="inputGroup-sizing-default" style="flex-shrink: 0;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>
</div> --}}


<!--end search-->
