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
                    <img src="{{asset('asset/users/store')}}/img/logo/store.png" alt="إسم المنتج" class="item-thumbnail" width="50px" height="50px"> 
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
            <img src="{{asset('asset/users/store')}}/img/logo/store.png" alt="إسم المنتج" class="item-thumbnail" width="50px" height="50px"> 
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