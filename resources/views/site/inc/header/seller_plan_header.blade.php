    <!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>{{__('site.header_seller_plan_title')}}</h1>
          <h2>{{__('site.header_seller_plan_description')}}</h2>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <h2>{{__('site.have_account_quistion')}}
            <a href="{{route('seller.login')}}" class="btn-get-started scrollto">{{__('site.login')}}</a>
          <a href="https://youtu.be/ZZABbglFOT4" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>{{__('site.how_to_register_on_the_platform_as_a_seller')}}</span></a>  
          </h2>
            
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="{{asset('asset/v1/site/defaulte')}}/img/hero.jpeg" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

</section><!-- End Hero -->