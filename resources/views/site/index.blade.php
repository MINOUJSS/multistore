@extends('site.layouts.app')
@section('hero')
    <!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>منصة متاجر ديزاد وجهتك الموثوقة للتجارة الإلكترونية</h1>
          <h2>تحّول من التجارة الكلاسيكية إلى التجارة الإلكترونية بسهولة و سرعة و أمتلك متجر إلكتروني خاص بك بجميع مزايا التجارة الإلكترونية مع توفير الخدمات المساندة له</h2>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <a href="#about" class="btn-get-started scrollto">إبدأ الآن</a>
            <a href="https://www.youtube.com/watch?v=cZRpUCWb_A4" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>فيديو تعريفي بالمنصة</span></a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="{{asset('asset/site/defaulte')}}/img/hero-img.png" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->
@endsection

{{-- @section('cliens')
    <!-- ======= Clients Section ======= -->
<section id="clients" class="clients section-bg">
    <div class="container">

      <div class="row" data-aos="zoom-in">

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="{{asset('asset/site/defaulte')}}/img/clients/client-1.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="{{asset('asset/site/defaulte')}}/img/clients/client-2.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="{{asset('asset/site/defaulte')}}/img/clients/client-3.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="{{asset('asset/site/defaulte')}}/img/clients/client-4.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="{{asset('asset/site/defaulte')}}/img/clients/client-5.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="{{asset('asset/site/defaulte')}}/img/clients/client-6.png" class="img-fluid" alt="">
        </div>

      </div>

    </div>
  </section><!-- End Cliens Section -->
@endsection --}}

@section('about')
    <!-- ======= About Us Section ======= -->
<section id="about" class="about">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>من نحن</h2>
      </div>

      <div class="row content">
        <div class="col-lg-6">
          <p>
            مرحباً بكم في منصتنا الإلكترونية المبتكرة، الحل الأمثل لتحويل تجارتك إلى العصر الرقمي في الجزائر! نحن نقدم بيئة متكاملة تجمع بين الموردين، تجار الجملة، تجار التجزئة، المسوقين بالعمولة، وشركات الشحن الصغيرة والمتوسطة في مكان واحد.
          </p>
          <h3>ما الذي نقدمه؟</h3>
          <ul>
            <li><i class="ri-check-double-line"></i> تواصل سلس: نحن نربط بين جميع أطراف العملية التجارية في بيئة واحدة سهلة الاستخدام. يمكنك الآن العثور على الموردين، التجار، والمسوقين بسهولة وإدارة جميع جوانب عملك من خلال منصة واحدة.</li>
            <li><i class="ri-check-double-line"></i> إدارة متكاملة: بفضل واجهتنا البسيطة والفعالة، يمكنك إدارة المنتجات، الطلبات، والدفع والشحن بكل يسر. نحن نوفر لك الأدوات التي تحتاجها لتحسين أداء عملك وزيادة مبيعاتك.</li>            
          </ul>
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0">
          <ul>
            <li><i class="ri-check-double-line"></i> شراكات استراتيجية: عقدنا شراكات مع شركات الشحن المحلية لتوفير خدمات توصيل موثوقة وسريعة، مما يضمن تجربة تسوق مرضية لعملائك.</li>
            <li><i class="ri-check-double-line"></i> دعم متواصل: نحن هنا لمساعدتك على كل خطوة. فريق الدعم الفني لدينا مستعد لحل أي مشكلة قد تواجهك، بالإضافة إلى تقديم برامج تدريبية لمساعدتك على الانتقال من التجارة الكلاسيكية إلى التجارة الإلكترونية بكل سهولة.</li>        
            <li><i class="ri-check-double-line"></i> أمان وموثوقية: نضع أمان بياناتك في قمة أولوياتنا. تعتمد منصتنا على أحدث تقنيات الحماية لضمان أن تكون عملياتك التجارية آمنة ومحمية.</li>
          </ul>
          {{-- <p>
            Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est laborum.
          </p>
          <a href="#" class="btn-learn-more">Learn More</a> --}}
        </div>
      </div>


    </div>
  </section><!-- End About Us Section -->
@endsection

@section('why-us')
    <!-- ======= Why Us Section ======= -->
<section id="why-us" class="why-us section-bg">
    <div class="container-fluid" data-aos="fade-up">

      <div class="row">

        <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch  order-2 order-lg-1">

          <div class="content">
            <h3><strong>لماذا نحن؟</strong> انضم إلينا اليوم وابدأ رحلتك في عالم التجارة الإلكترونية مع منصة متكاملة ومبتكرة تدعم نمو عملك وتحقيق أهدافك التجارية.</h3>
            <p>
              نحن نقدم منصة شاملة تجمع جميع الأطراف في مكان واحد، مما يسهل عليك إدارة جميع جوانب عملك التجاري من مكان واحد.
            </p>
          </div>

          <div class="accordion-list">
            <ul>
              <li>
                <a data-bs-toggle="collapse" class="collapse" data-bs-target="#accordion-list-1"><span>01</span> توسيع نطاق عملك <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                  <p>
                    بفضل منصتنا، يمكنك الوصول إلى قاعدة عملاء أوسع وزيادة مبيعاتك بشكل كبير. نحن نساعدك على استكشاف أسواق جديدة وتنمية عملك.
                  </p>
                </div>
              </li>

              <li>
                <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2" class="collapsed"><span>02</span> واجهة مستخدم سهلة وبسيطة <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
                  <p>
                    صممنا منصتنا لتكون سهلة الاستخدام، مما يتيح لك إدارة منتجاتك وطلباتك ودفعك وشحنك بكل سهولة وفعالية.
                  </p>
                </div>
              </li>

              <li>
                <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3" class="collapsed"><span>03</span> أمان وموثوقية <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
                  <p>
                    نضع أمان بياناتك في قمة أولوياتنا. نعتمد على أحدث تقنيات الحماية لضمان أن تكون جميع عملياتك التجارية آمنة ومحمية.                  </p>
                </div>
              </li>

              <li>
                <a data-bs-toggle="collapse" data-bs-target="#accordion-list-4" class="collapsed"><span>04</span> شراكات استراتيجية مع شركات الشحن<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                <div id="accordion-list-4" class="collapse" data-bs-parent=".accordion-list">
                  <p>
                    تعاوننا مع شركات الشحن المحلية لتوفير خدمات توصيل موثوقة وسريعة، مما يضمن تجربة تسوق مرضية لعملائك.                  </p>
                </div>
              </li>

              <li>
                <a data-bs-toggle="collapse" data-bs-target="#accordion-list-5" class="collapsed"><span>05</span> نظام عمولة مغري للمسوقين<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                <div id="accordion-list-5" class="collapse" data-bs-parent=".accordion-list">
                  <p>
                    نقدم نظام عمولة مغري لجذب أفضل المسوقين بالعمولة، مما يعزز من فرص زيادة مبيعاتك وانتشار علامتك التجارية.                  </p>
                </div>
              </li>
              <li>
                <a data-bs-toggle="collapse" data-bs-target="#accordion-list-6" class="collapsed"><span>06</span> دعم متواصل وبرامج تدريبية<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                <div id="accordion-list-6" class="collapse" data-bs-parent=".accordion-list">
                  <p>
                    نحن هنا لدعمك في كل خطوة. فريق الدعم الفني لدينا متاح لحل أي مشكلة قد تواجهك، ونقدم برامج تدريبية شاملة لمساعدتك على الانتقال السلس من التجارة الكلاسيكية إلى التجارة الإلكترونية.                  </p>
                </div>
              </li>
              <li>
                <a data-bs-toggle="collapse" data-bs-target="#accordion-list-7" class="collapsed"><span>07</span> تحسين مستمر وتطوير<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                <div id="accordion-list-7" class="collapse" data-bs-parent=".accordion-list">
                  <p>
                    نحن نلتزم بتحسين منصتنا باستمرار بناءً على ملاحظات المستخدمين واحتياجات السوق المتغيرة، مما يضمن لك الحصول على أفضل تجربة تجارية ممكنة                  </p>
                </div>
              </li>

            </ul>
          </div>


        </div>

        <div class="col-lg-5 align-items-stretch order-1 order-lg-2 img" style='background-image: url("{{asset('asset/site/defaulte')}}/img/why-us.png");' data-aos="zoom-in" data-aos-delay="150">&nbsp;</div>
      </div>

    </div>
  </section><!-- End Why Us Section -->
@endsection

@section('skills')
    <!-- ======= Skills Section ======= -->
<section id="skills" class="skills">
    <div class="container" data-aos="fade-up">

      <div class="row">
        <div class="col-lg-6 d-flex align-items-center" data-aos="fade-right" data-aos-delay="100">
          <img src="{{asset('asset/site/defaulte')}}/img/skills.png" class="img-fluid" alt="">
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
          <h3> نظام الدفع لدينا </h3>
          <p class="fst-italic">
            نظام الدفع الخاص بنا مصمم ليكون سهلاً وسلساً، مما يتيح للعملاء إجراء عمليات الشراء بسرعة ودون عناء. نحن نوفر تجربة دفع مريحة وسهلة الاستخدام تلبي توقعاتك وتوقعات عملائك.</br>
            لتلبية احتياجات جميع المستخدمين، نقدم مجموعة متنوعة من خيارات الدفع، بما في ذلك:
          </p>
          <ul>
            <li>الدفع بالبطاقات الائتمانية والخصم المباشر: نقبل معظم البطاقات العالمية والمحلية.
            </li>
            <li>الدفع عبر التحويلات المصرفية: يمكنك اختيار الدفع من خلال التحويلات البنكية المباشرة.
            </li>
            <li>الدفع عبر المحافظ الإلكترونية: نحن ندعم مجموعة من المحافظ الإلكترونية الشهيرة لتوفير المزيد من الخيارات.
            </li>
            <li>الدفع نقداً عند الاستلام: نقدم خيار الدفع نقداً عند استلام المنتجات لضمان راحة عملائك الذين يفضلون الدفع بهذه الطريقة.
            </li>
          </ul>
          {{-- <div class="skills-content">

            <div class="progress">
              <span class="skill">HTML <i class="val">100%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

            <div class="progress">
              <span class="skill">CSS <i class="val">90%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

            <div class="progress">
              <span class="skill">JavaScript <i class="val">75%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

            <div class="progress">
              <span class="skill">Photoshop <i class="val">55%</i></span>
              <div class="progress-bar-wrap">
                <div class="progress-bar" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

          </div> --}}

        </div>
      </div>

    </div>
  </section><!-- End Skills Section -->
@endsection

@section('services')
    <!-- ======= Services Section ======= -->
<section id="services" class="services section-bg">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>خدماتنا</h2>
        <p>نوفر لك منصة متكاملة تدعم جميع جوانب التجارة الإلكترونية، بدءًا من تسجيل الموردين والتجار، وإدارة المنتجات والطلبات، وصولًا إلى خيارات الدفع الآمنة وخدمات الشحن الموثوقة. هدفنا هو تسهيل عملياتك التجارية وتحقيق نجاحك في السوق الرقمية بكل سهولة ويسر.</p>
      </div>

      <div class="row">
        <div class="col-xl-3 col-md-3 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
          <div class="icon-box">
            <div class="icon"><i class="bx bxl-dribbble"></i></div>
            <h4><a href=""> الموردين وتجار الجملة</a></h4>
            <p>تمنحك منصتنا فرصة للوصول إلى قاعدة عملاء أوسع وزيادة مبيعاتك بشكل كبير. نقدم لك أدوات متقدمة لإدارة المنتجات والطلبات بكفاءة، ونظام دفع آمن وموثوق، بالإضافة إلى دعم فني متواصل لضمان تجربة تجارية سلسة وناجحة. انضم إلينا الآن واستفد من شراكات استراتيجية مع شركات الشحن لتوصيل منتجاتك بسرعة وفعالية.</p>
          </div>
        </div>

        <div class="col-xl-3 col-md-3 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-file"></i></div>
            <h4><a href="">تجار التجزئة</a></h4>
            <p>تمنحك منصتنا فرصة لزيادة مبيعاتك من خلال الوصول إلى عملاء جدد بسهولة. نقدم لك أدوات مرنة لإدارة منتجاتك وطلباتك، مع خيارات دفع آمنة ومتعددة تناسب احتياجات عملائك. استفد من شراكاتنا مع شركات الشحن لتوفير توصيل سريع وموثوق، ودعم فني متواصل لضمان تجربة تجارية سلسة وناجحة. انضم إلينا الآن وطور أعمالك في عالم التجارة الإلكترونية.</p>
          </div>
        </div>

        <div class="col-xl-3 col-md-3 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="300">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-tachometer"></i></div>
            <h4><a href="">المسوقين بالعمولة</a></h4>
            <p>تقدم منصتنا للمسوقين بالعمولة فرصة لكسب عمولات مجزية من خلال ترويج المنتجات والخدمات المتنوعة. نوفر لك أدوات تتبع متقدمة وتقارير تفصيلية لقياس الأداء وتحقيق أفضل النتائج. انضم إلينا اليوم واستفد من دعم فني مستمر وبرامج تحفيزية تزيد من أرباحك في عالم التسويق الإلكتروني.</p>
          </div>
        </div>

        <div class="col-xl-3 col-md-3 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="400">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-layer"></i></div>
            <h4><a href="">شركات الشحن</a></h4>
            <p>توفر منصتنا لشركات الشحن الصغيرة والمتوسطة فرصة للتوسع وزيادة قاعدة عملائها. نمنحك الوصول إلى مجموعة واسعة من التجار والموردين الذين يحتاجون إلى خدمات الشحن الموثوقة. استمتع بإدارة عملياتك بكفاءة، وتحسين خدمات التوصيل من خلال شراكتنا. انضم إلينا الآن لتعزيز نموك في سوق التجارة الإلكترونية.</p>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Services Section -->
@endsection

{{-- @section('cta')
    <!-- ======= Cta Section ======= -->
<section id="cta" class="cta">
    <div class="container" data-aos="zoom-in">

      <div class="row">
        <div class="col-lg-9 text-center text-lg-start">
          <h3>Call To Action</h3>
          <p> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
        <div class="col-lg-3 cta-btn-container text-center">
          <a class="cta-btn align-middle" href="#">Call To Action</a>
        </div>
      </div>

    </div>
  </section><!-- End Cta Section -->
@endsection --}}

{{-- @section('portfolio')
    <!-- ======= Portfolio Section ======= -->
<section id="portfolio" class="portfolio">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Portfolio</h2>
        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
      </div>

      <ul id="portfolio-flters" class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
        <li data-filter="*" class="filter-active">All</li>
        <li data-filter=".filter-app">App</li>
        <li data-filter=".filter-card">Card</li>
        <li data-filter=".filter-web">Web</li>
      </ul>

      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <div class="portfolio-img"><img src="{{asset('asset/site/defaulte')}}/img/portfolio/portfolio-1.jpg" class="img-fluid" alt=""></div>
          <div class="portfolio-info">
            <h4>App 1</h4>
            <p>App</p>
            <a href="assets/img/portfolio/portfolio-1.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 1"><i class="bx bx-plus"></i></a>
            <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
          <div class="portfolio-img"><img src="{{asset('asset/site/defaulte')}}/img/portfolio/portfolio-2.jpg" class="img-fluid" alt=""></div>
          <div class="portfolio-info">
            <h4>Web 3</h4>
            <p>Web</p>
            <a href="assets/img/portfolio/portfolio-2.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
            <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <div class="portfolio-img"><img src="{{asset('asset/site/defaulte')}}/img/portfolio/portfolio-3.jpg" class="img-fluid" alt=""></div>
          <div class="portfolio-info">
            <h4>App 2</h4>
            <p>App</p>
            <a href="assets/img/portfolio/portfolio-3.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 2"><i class="bx bx-plus"></i></a>
            <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
          <div class="portfolio-img"><img src="{{asset('asset/site/defaulte')}}/img/portfolio/portfolio-4.jpg" class="img-fluid" alt=""></div>
          <div class="portfolio-info">
            <h4>Card 2</h4>
            <p>Card</p>
            <a href="assets/img/portfolio/portfolio-4.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 2"><i class="bx bx-plus"></i></a>
            <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
          <div class="portfolio-img"><img src="{{asset('asset/site/defaulte')}}/img/portfolio/portfolio-5.jpg" class="img-fluid" alt=""></div>
          <div class="portfolio-info">
            <h4>Web 2</h4>
            <p>Web</p>
            <a href="assets/img/portfolio/portfolio-5.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 2"><i class="bx bx-plus"></i></a>
            <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <div class="portfolio-img"><img src="{{asset('asset/site/defaulte')}}/img/portfolio/portfolio-6.jpg" class="img-fluid" alt=""></div>
          <div class="portfolio-info">
            <h4>App 3</h4>
            <p>App</p>
            <a href="assets/img/portfolio/portfolio-6.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 3"><i class="bx bx-plus"></i></a>
            <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
          <div class="portfolio-img"><img src="{{asset('asset/site/defaulte')}}/img/portfolio/portfolio-7.jpg" class="img-fluid" alt=""></div>
          <div class="portfolio-info">
            <h4>Card 1</h4>
            <p>Card</p>
            <a href="assets/img/portfolio/portfolio-7.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 1"><i class="bx bx-plus"></i></a>
            <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
          <div class="portfolio-img"><img src="{{asset('asset/site/defaulte')}}/img/portfolio/portfolio-8.jpg" class="img-fluid" alt=""></div>
          <div class="portfolio-info">
            <h4>Card 3</h4>
            <p>Card</p>
            <a href="assets/img/portfolio/portfolio-8.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 3"><i class="bx bx-plus"></i></a>
            <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
          <div class="portfolio-img"><img src="{{asset('asset/site/defaulte')}}/img/portfolio/portfolio-9.jpg" class="img-fluid" alt=""></div>
          <div class="portfolio-info">
            <h4>Web 3</h4>
            <p>Web</p>
            <a href="assets/img/portfolio/portfolio-9.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
            <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Portfolio Section -->
@endsection --}}

{{-- @section('team')
    <!-- ======= Team Section ======= -->
<section id="team" class="team section-bg">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>فريق العمل</h2>
        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
      </div>

      <div class="row">

        <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="100">
          <div class="member d-flex align-items-start">
            <div class="pic"><img src="{{asset('asset/site/defaulte')}}/img/team/team-1.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>Walter White</h4>
              <span>Chief Executive Officer</span>
              <p>Explicabo voluptatem mollitia et repellat qui dolorum quasi</p>
              <div class="social">
                <a href=""><i class="ri-twitter-fill"></i></a>
                <a href=""><i class="ri-facebook-fill"></i></a>
                <a href=""><i class="ri-instagram-fill"></i></a>
                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="200">
          <div class="member d-flex align-items-start">
            <div class="pic"><img src="{{asset('asset/site/defaulte')}}/img/team/team-2.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>Sarah Jhonson</h4>
              <span>Product Manager</span>
              <p>Aut maiores voluptates amet et quis praesentium qui senda para</p>
              <div class="social">
                <a href=""><i class="ri-twitter-fill"></i></a>
                <a href=""><i class="ri-facebook-fill"></i></a>
                <a href=""><i class="ri-instagram-fill"></i></a>
                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mt-4" data-aos="zoom-in" data-aos-delay="300">
          <div class="member d-flex align-items-start">
            <div class="pic"><img src="{{asset('asset/site/defaulte')}}/img/team/team-3.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>William Anderson</h4>
              <span>CTO</span>
              <p>Quisquam facilis cum velit laborum corrupti fuga rerum quia</p>
              <div class="social">
                <a href=""><i class="ri-twitter-fill"></i></a>
                <a href=""><i class="ri-facebook-fill"></i></a>
                <a href=""><i class="ri-instagram-fill"></i></a>
                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 mt-4" data-aos="zoom-in" data-aos-delay="400">
          <div class="member d-flex align-items-start">
            <div class="pic"><img src="{{asset('asset/site/defaulte')}}/img/team/team-4.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>Amanda Jepson</h4>
              <span>Accountant</span>
              <p>Dolorum tempora officiis odit laborum officiis et et accusamus</p>
              <div class="social">
                <a href=""><i class="ri-twitter-fill"></i></a>
                <a href=""><i class="ri-facebook-fill"></i></a>
                <a href=""><i class="ri-instagram-fill"></i></a>
                <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Team Section -->
@endsection --}}

{{-- @section('pricing')
    <!-- ======= Pricing Section ======= -->
<section id="pricing" class="pricing">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>الأسعار</h2>
        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
      </div>

      <div class="row">

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
          <div class="box">
            <h3>Free Plan</h3>
            <h4><sup>$</sup>0<span>per month</span></h4>
            <ul>
              <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
              <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
              <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
              <li class="na"><i class="bx bx-x"></i> <span>Pharetra massa massa ultricies</span></li>
              <li class="na"><i class="bx bx-x"></i> <span>Massa ultricies mi quis hendrerit</span></li>
            </ul>
            <a href="#" class="buy-btn">Get Started</a>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="200">
          <div class="box featured">
            <h3>Business Plan</h3>
            <h4><sup>$</sup>29<span>per month</span></h4>
            <ul>
              <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
              <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
              <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
              <li><i class="bx bx-check"></i> Pharetra massa massa ultricies</li>
              <li><i class="bx bx-check"></i> Massa ultricies mi quis hendrerit</li>
            </ul>
            <a href="#" class="buy-btn">Get Started</a>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
          <div class="box">
            <h3>Developer Plan</h3>
            <h4><sup>$</sup>49<span>per month</span></h4>
            <ul>
              <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
              <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
              <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
              <li><i class="bx bx-check"></i> Pharetra massa massa ultricies</li>
              <li><i class="bx bx-check"></i> Massa ultricies mi quis hendrerit</li>
            </ul>
            <a href="#" class="buy-btn">Get Started</a>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Pricing Section -->
@endsection --}}

@section('faq')
    <!-- ======= Frequently Asked Questions Section ======= -->
<section id="faq" class="faq section-bg">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>الأسئلة الشائعة</h2>
        <p>هل لديك استفسارات حول كيفية استخدام منصتنا؟ تحقق من قسم الأسئلة الشائعة لدينا للحصول على إجابات سريعة وشاملة حول التسجيل، الدفع، إضافة المنتجات، والتواصل مع شركات الشحن. نحن هنا لجعل تجربتك معنا سلسة ومريحة!</p>
      </div>

      <div class="faq-list">
        <ul>
          <li data-aos="fade-up" data-aos-delay="100">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">ما هي هذه المنصة وماذا تقدم؟ <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
              <p>
                منصتنا هي منصة إلكترونية تجمع الموردين، تجار الجملة، تجار التجزئة، المسوقين بالعمولة، وشركات الشحن الصغيرة والمتوسطة في مكان واحد. نهدف إلى تسهيل عملية التجارة الإلكترونية في الجزائر من خلال توفير بيئة متكاملة تدعم جميع جوانب التجارة.              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="200">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-2" class="collapsed">كيف يمكنني التسجيل في المنصة؟ <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
              <p>
                للتسجيل في المنصة، يمكنك زيارة صفحة التسجيل واتباع الخطوات البسيطة لإنشاء حساب جديد. ستحتاج إلى تقديم بعض المعلومات الأساسية مثل الاسم والبريد الإلكتروني وكلمة المرور.              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="300">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-3" class="collapsed">ما هي وسائل الدفع المتاحة؟ <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
              <p>
                نحن نوفر عدة خيارات للدفع، بما في ذلك الدفع بالبطاقات الائتمانية والخصم المباشر، التحويلات المصرفية، المحافظ الإلكترونية، والدفع نقداً عند الاستلام.              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="400">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-4" class="collapsed">هل نظام الدفع آمن؟ <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
              <p>
                نعم، نظام الدفع لدينا مؤمن بأحدث تقنيات التشفير لضمان حماية معلوماتك المالية. نحن نلتزم بمعايير الأمان العالمية لحماية جميع العمليات المالية.              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="500">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-5" class="collapsed">كيف يمكنني إضافة منتجات جديدة إلى متجري؟ <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
              <p>
                بمجرد تسجيلك كمورد أو تاجر، يمكنك بسهولة إضافة منتجات جديدة من خلال لوحة التحكم الخاصة بك. ستتمكن من إضافة تفاصيل المنتجات والصور والأسعار.              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="500">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-6" class="collapsed">كيف يمكنني التواصل مع شركات الشحن؟ <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-6" class="collapse" data-bs-parent=".faq-list">
              <p>
                عند إتمام عملية البيع، يمكنك اختيار شركة الشحن المفضلة لديك من قائمة شركائنا المعتمدين، وسيتم توفير جميع تفاصيل الاتصال والتتبع.              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="500">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-7" class="collapsed">ماذا أفعل إذا واجهت مشكلة في استخدام المنصة؟ <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-7" class="collapse" data-bs-parent=".faq-list">
              <p>
                إذا واجهت أي مشكلة، يمكنك التواصل مع فريق الدعم الفني لدينا من خلال صفحة "اتصل بنا" أو عبر الدردشة المباشرة. نحن هنا لمساعدتك على مدار الساعة.              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="500">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-8" class="collapsed">هل هناك رسوم للاشتراك في المنصة؟ <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-8" class="collapse" data-bs-parent=".faq-list">
              <p>
                نعم، هناك رسوم اشتراك تعتمد على نوع الحساب والخدمات التي تحتاجها. يمكنك العثور على تفاصيل الرسوم على صفحة "الخطط والتسعير".              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="500">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-9" class="collapsed">كيف يمكنني الانضمام كمسوق بالعمولة؟ <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-9" class="collapse" data-bs-parent=".faq-list">
              <p>
                إذا كنت مهتمًا بأن تصبح مسوقًا بالعمولة، يمكنك التسجيل من خلال صفحة "انضم كشريك" واتباع الخطوات المطلوبة. سنقدم لك جميع الأدوات اللازمة لبدء العمل وكسب العمولات.              </p>
            </div>
          </li>

          <li data-aos="fade-up" data-aos-delay="500">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-10" class="collapsed">كيف أضمن جودة المنتجات المعروضة؟ <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
            <div id="faq-list-10" class="collapse" data-bs-parent=".faq-list">
              <p>
                نحن نعمل مع موردين وتجار موثوقين ونعتمد على تقييمات المستخدمين لضمان جودة المنتجات. يمكنك مراجعة تقييمات المنتجات والتجار قبل الشراء.              </p>
            </div>
          </li>

        </ul>
      </div>

    </div>
  </section><!-- End Frequently Asked Questions Section -->
@endsection

@section('contact')
    <!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>إتصل بنا</h2>
        <p>نحن نرحب بكل استفساراتك واقتراحاتك. لا تتردد في الاتصال بنا لأي استفسار أو مساعدة تحتاجها. يمكنك التواصل مع فريق خدمة العملاء لدينا عبر البريد الإلكتروني أو الهاتف خلال ساعات العمل، أو استخدام النموذج أدناه للحصول على دعم فوري. نحن هنا لمساعدتك في تحقيق أهدافك التجارية وضمان رضاك التام.</p>
      </div>

      <div class="row">

        <div class="col-lg-5 d-flex align-items-stretch">
          <div class="info">
            <div class="address">
              <i class="bi bi-geo-alt"></i>
              <h4>العنوان:</h4>
              <p>A108 Adam Street, New York, NY 535022</p>
            </div>

            <div class="email">
              <i class="bi bi-envelope"></i>
              <h4>البريد الإلكتروني:</h4>
              <p>info@example.com</p>
            </div>

            <div class="phone">
              <i class="bi bi-phone"></i>
              <h4>رقم الهاتف:</h4>
              <p>+1 5589 55488 55s</p>
            </div>

            {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe> --}}
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d102286.38396938733!2d3.0541521472319664!3d36.75978277379741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x128fad6795639515%3A0x4ba4b4c9d0a7e602!2sAlgiers!5e0!3m2!1sen!2sdz!4v1719439133741!5m2!1sen!2sdz" width=100% height=290px style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>

        </div>

        <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
          <form action="forms/contact.php" method="post" role="form" class="php-email-form">
            <div class="row">
              <div class="form-group col-md-6">
                <label for="name">اسمك</label>
                <input type="text" name="name" class="form-control" id="name" required>
              </div>
              <div class="form-group col-md-6">
                <label for="name">بريدك الإلكتروني</label>
                <input type="email" class="form-control" name="email" id="email" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name">الموضوع</label>
              <input type="text" class="form-control" name="subject" id="subject" required>
            </div>
            <div class="form-group">
              <label for="name">الرسالة</label>
              <textarea class="form-control" name="message" rows="10" required></textarea>
            </div>
            <div class="my-3">
              <div class="loading">تحميل</div>
              <div class="error-message"></div>
              <div class="sent-message">تم ارسال رسالتك. شكرًا لك!</div>
            </div>
            <div class="text-center"><button type="submit">أرسل رسالة</button></div>
          </form>
        </div>

      </div>

    </div>
  </section><!-- End Contact Section -->
@endsection

@section('footer-newsletter')
<div class="footer-newsletter">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <h4>اشترك في النشرة الإخبارية</h4>
          <p>لا تفوت فرصة البقاء على اطلاع دائم على آخر التحديثات والعروض الحصرية! اشترك في نشرتنا الإخبارية لتصلك أحدث المستجدات حول المنصة، بما في ذلك العروض الترويجية والتحديثات التقنية ونصائح التجارة الإلكترونية. كل ذلك مجانًا وبضغطة زر واحدة. انضم اليوم لتكن أول من يحصل على الفرص الحصرية والتخفيضات الخاصة!</p>
          <form action="" method="post">
            @csrf
            <input type="email" name="email"><input type="submit" value="إشتراك">
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection