<!doctype html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/logo/store.png">
    <title>Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">    <!-- fonts -->
    <!-- font -->
     <link rel="stylesheet" href="fonts/all.css">
     <link rel="stylesheet" href="css/appfont.css">
    <!-- style -->
     <link rel="stylesheet" href="css/style.css">
     <link rel="stylesheet" href="css/default-theme.css">
     <link rel="stylesheet" href="css/appmedia.css">
    <!-- js files -->
    <!-- fcb pixle -->
    <!-- google analytics -->
  </head>
  <body>
    <!-- end general container -->
    <div class="container-fluid">
    <!-- start header -->
     <section class="header">
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
          <a class="navbar-brand" href="#"><img src="img/logo/store.png" width="50px" height="50px" alt="logo"></a>
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
      <!--start cart main-->
      <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header bg-body-tertiary">
          <h5 class="offcanvas-title" id="offcanvasScrollingLabel">سلة مشترياتي</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <!-- <p>Try scrolling the rest of the page to see this option in action.</p> -->
          <main class="cart-body">
            <div class="cart-list" bis_skin_checked="1">
              <form action="/">
                <ul class="list-unstyled">
                  <li class="cart-item">
                    <img src="img/logo/store.png" alt="إسم المنتج" class="item-thumbnail" width="50px" height="50px"> 
                    <div class="item-body" bis_skin_checked="1">
                      <div class="item-details" bis_skin_checked="1">
                        <h6><a href="#">مجفف الشعر</a></h6> 
                      <div class="quantity-wrapper" bis_skin_checked="1">
                        <span class="quantity">الكمية <small>1</small></span> 
                        <span class="currency-value"><span class="value">199</span>
                        <span class="currency">&nbsp;د.ج</span></span></div></div> 
                      <div class="item-actions" bis_skin_checked="1">
                        <button type="button"><i class="fa-solid fa-pen"></i></button> 
                        <button type="button"><i class="fa-solid fa-trash-can"></i></button>
                      </div>
                    </div>
          </li>
          <li class="cart-item">
            <img src="img/logo/store.png" alt="إسم المنتج" class="item-thumbnail" width="50px" height="50px"> 
            <div class="item-body" bis_skin_checked="1">
              <div class="item-details" bis_skin_checked="1">
                <h6><a href="#">ماكنة حلاقة من النوع الرفيع</a></h6> 
              <div class="quantity-wrapper" bis_skin_checked="1">
                <span class="quantity">الكمية <small>1</small></span> 
                <span class="currency-value"><span class="value">199</span>
                <span class="currency">&nbsp;د.ج</span></span></div></div> 
              <div class="item-actions" bis_skin_checked="1">
                <button type="button"><i class="fa-solid fa-pen"></i></button> 
                <button type="button"><i class="fa-solid fa-trash-can"></i></button>
              </div>
            </div>
  </li>
        </ul>
      </form>
    </div> 
  </main>
  <footer class="cart-footer bg-body-tertiary">
    <h6>مجموع سلة التسوق
    <span class="currency-value"><span class="value">0</span><span class="currency">&nbsp;د.ج</span></span>
    </h6> 
<div class="cart-actions vstacks gap-3 p-2" bis_skin_checked="1">
    <button class="btn btn-primary w-100">شراء الآن</button>
     <a class="btn btn-default w-100">استمر في التسوق</a>
    </div>
</footer>
        </div>
      </div>
      <!--end cart main-->
    </section>
    <!-- end header -->

    <!-- start main -->
     <section class="main">
        <div class="container-fluid">
            <div class="row">
                
            </div>
        </div>
     </section>
    <!-- end main -->

    <!-- start footer -->
     <section class="footer">
        <div class="container">
        <div class="footer-brand text-center">
            <a href="#"><img src="img/logo/store.png" width="50px" height="50px" alt="logo"></a>
        </div>
        <hr>
        <div class="row footer-body">
            <div class="col-md-3 footer-card">
                <h5 class="footer-title">عن المتجر</h5>
                <hr class="title-underline">
                <ul class="footer-ul">
                    <li class="footer-li"><a href="#">عن المتجر</a></li>                    
                    <li class="footer-li"><a href="#">الشحن و التسليم</a></li>
                    <li class="footer-li"><a href="#">طرق الدفع</a></li>
                </ul>
                <ul class="footer-ul d-flex">
                    <li class="footer-li p-1"><img src="img/payments/eldhahabia.png" alt="" width="30px"></li>
                    <li class="footer-li p-1"><img src="img/payments/cib.png" alt="" width="30px"></li>
                    <li class="footer-li p-1"><img src="img/payments/baridimaobe.png" alt="" width="30px"></li>
                    <li class="footer-li p-1"><img src="img/payments/algerie post.png" alt="" width="30px"></li>
                    <li class="footer-li p-1"><img src="img/payments/cod.png" alt="" width="30px"></li>
                </ul>
            </div>

            <div class="col-md-3 footer-card">
                <h5 class="footer-title">الشروط والسياسات</h5>
                <hr class="title-underline">
                <ul class="footer-ul">
                    <li class="footer-li"><a href="#">شروط الإستخدام</a></li>
                    <li class="footer-li"><a href="#">سياسة الإستبدال و الإسترجاع</a></li>
                    <li class="footer-li"><a href="#">السياسة الخصوصية</a></li>
                </ul>
            </div>

            <div class="col-md-3 footer-card">
                <h5 class="footer-title">اتصل بنا</h5>
                <hr class="title-underline">
                <ul class="footer-ul">
                    <li class="footer-li"><a href="#">اتصل بنا</a></li>
                    <li class="footer-li"><a href="#">الأسئلة الشائعة</a></li>
                </ul>
            </div>

            <div class="col-md-3 footer-card">
                <h5 class="footer-title">تواصل معنا</h5>
                <hr class="title-underline">
                <ul class="footer-ul">
                    <li class="footer-li"><i class="fa-solid fa-location-dot"></i> العنوان : حي200 مسكن الجزائر</li>
                    <li class="footer-li"><i class="fa-solid fa-envelope"></i> البريد الإلكتروني : email@email.com</li>
                </ul>
                <ul class="footer-ul d-flex">
                    <li class="footer-li p-2"><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                    <li class="footer-li p-2"><a href="#"><i class="fa-brands fa-square-instagram"></i></a></li>
                    <li class="footer-li p-2"><a href="#"><i class="fa-brands fa-telegram"></i></a></li>
                    <li class="footer-li p-2"><a href="#"><i class="fa-brands fa-tiktok"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="row footer-footer">
            <hr style="width:50%;margin-right: 25%;">
            <div class="col-12 text-center">
                جميع الحقوق محفوظة @ لمنصة <a href="#">متاجر ديزاد</a>
            </div>
        </div>
        </div>
     </section>
    <!-- end footer  -->
</div> <!-- end general container -->
     
    <!-- js files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/jQuery-v3-7-1.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>