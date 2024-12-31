<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="d-lg-block d-lg-none d-xl-block d-xl-none d-xxl-block d-xxl-none">
        <i id="search-btn" class="fa-solid fa-magnifying-glass"></i>
            <button type="button" class="btn position-relative" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">
                    0
                    <span class="visually-hidden">unread messages</span>
                </span>
                </button>
      </div>
      <a class="navbar-brand" href="{{url(request()->server('REQUEST_SCHEME').'://'.get_tenant_data(tenant('id'))->domains[0]->domain)}}"><img src="{{asset(get_store_logo(tenant('id')))}}" width="50px" height="50px" alt="logo"></a>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav hstacks gap-3 mx-auto">
          <a class="nav-link active" aria-current="page" href="#">الرئيسية</a>
          <a class="nav-link" href="#">المميزات</a>
          <a class="nav-link" href="#">الأسعار</a>
          <!-- <a class="nav-link disabled" aria-disabled="false">Disabled</a> -->
        </div>
        <div class="navbar-nav search-btn">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div class="navbar-nav" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
            <ul class="list-group list-group-horizontal cart">
                <li class="list-group-item">0.00 <span>د.ج</span></li>
                <li class="list-group-item"><i class="fa-solid fa-cart-shopping"></i>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge">
                    0
                  </span>
                </li>
              </ul>
        </div>
      </div>
    </div>
  </nav>
  <!--start search-->
  <div class="container">
    <div class="input-group mb-3 search-box" style="display: none;">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">كل الأصناف</button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">الصنف 1</a></li>
          <li><a class="dropdown-item" href="#">الصنف 2</a></li>
          <li><a class="dropdown-item" href="#">الصنف 3</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#">الصنف 4</a></li>
        </ul>
        <input type="text" class="form-control" aria-label="Text input with dropdown button">
        <button type="submit" class="input-group-text" id="inputGroup-sizing-default"><i class="fa-solid fa-magnifying-glass"></i></button>
      </div>
  </div>
  <!--end search-->