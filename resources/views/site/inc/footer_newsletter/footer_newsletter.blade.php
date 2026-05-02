<div class="footer-newsletter">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <h4>اشترك في النشرة الإخبارية</h4>
          <p>لا تفوت فرصة البقاء على اطلاع دائم على آخر التحديثات والعروض الحصرية! اشترك في نشرتنا الإخبارية لتصلك أحدث المستجدات حول المنصة، بما في ذلك العروض الترويجية والتحديثات التقنية ونصائح التجارة الإلكترونية. كل ذلك مجانًا وبضغطة زر واحدة. انضم اليوم لتكن أول من يحصل على الفرص الحصرية والتخفيضات الخاصة!</p>
          {{-- alert --}}
          <div class="subscribe-alert">
          </div>

          <form action="{{route('site.newsletter.subscribe')}}" method="post">
            @csrf
            <input type="text" name="website" style="display:none">
            <input type="email" name="subscriber_email"><input type="submit" name="subscriber_submit" value="إشتراك">
          </form>
        </div>
      </div>
    </div>
  </div>