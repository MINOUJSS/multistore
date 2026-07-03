<style>
.icon-box{
    position: relative;
    background: #fff;
    border-radius: 20px;
    padding: 30px 24px;
    transition: all .3s ease;
}

.icon-box:hover{
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,.08);
}

.service-btn{
    width:100%;
    background:#B03882;
    color:white;
    border-radius:12px;
    font-weight:700;
    padding:12px;
}

.service-btn:hover{
    background:#8E2D68;
    color:white;
}

.service-features{
    padding-right:18px;
    margin-top:15px;
}

.service-features li{
    margin-bottom:8px;
}

.seller-card{
    border:2px solid #B03882;
    transform: scale(1.03);
}

.new-badge{
    position:absolute;
    top:-12px;
    right:20px;
    background:#B03882;
    color:white;
    padding:6px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:700;
}

.digital-box{
    background:#F8E4F1;
    border:1px solid #E5A6CA;
    padding:14px;
    border-radius:14px;
    margin-top:15px;
}
</style>

<!-- ======= Services Section ======= -->
<section id="services" class="services section-bg py-5">
    <div class="container" data-aos="fade-up">

        <div class="section-title text-center mb-5">
            <span class="badge rounded-pill px-4 py-2 mb-3"
                style="background:#F8E4F1;color:#B03882;font-size:14px;">
                منصة متكاملة للجميع
            </span>

            <h2 style="color:#1d1d1f;font-weight:800;">
                حلول ذكية لكل أطراف التجارة الإلكترونية
            </h2>

            <p class="mt-3" style="max-width:850px;margin:auto;">
                اختر نوع حسابك وابدأ رحلتك معنا بسهولة. نوفر لك الأدوات، الأتمتة، والدعم
                الذي تحتاجه لتنمية تجارتك داخل السوق الرقمية الجزائرية.
            </p>
        </div>

        <div class="row g-4">

            <!-- تجار التجزئة -->
            <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="200">
                <div class="icon-box seller-card w-100 shadow">

                    <div class="new-badge">ميزة جديدة 🚀</div>

                    <div class="icon"><i class="bx bx-cart"></i></div>
                    <h4>تجار التجزئة</h4>

                    <p>
                        أنشئ متجرك وابدأ البيع أونلاين بسهولة مع أدوات احترافية لإدارة أعمالك.
                    </p>

                    <div class="digital-box">
                        <strong>بيع المنتجات الرقمية الآن!</strong>
                        <small class="d-block mt-2">
                            يمكنك بيع الكورسات، الكتب الإلكترونية،
                            الملفات، الأكواد والتصاميم مع تسليم فوري بعد الدفع.
                        </small>
                    </div>

                    <ul class="service-features mt-3">
                        <li>إدارة الطلبات والشحن</li>
                        <li>دفع إلكتروني متعدد</li>
                        <li>تقارير مبيعات ذكية</li>
                    </ul>

                    <a class="btn service-btn mt-3"
                        href="{{route('site.show_sellers_plans')}}">
                        إبدأ الآن
                    </a>
                </div>
            </div>

            <!-- الموردين -->
            <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                <div class="icon-box w-100 shadow-sm">
                    <div class="icon"><i class="bx bx-store"></i></div>
                    <h4>الموردين وتجار الجملة</h4>

                    <p>
                        وسّع نشاطك التجاري ووصل إلى آلاف التجار والعملاء.
                    </p>

                    <ul class="service-features">
                        <li>إدارة المنتجات والطلبات بسهولة</li>
                        <li>مدفوعات آمنة وموثوقة</li>
                        <li>شحن سريع عبر شركائنا</li>
                    </ul>

                    <a class="btn service-btn mt-3"
                        href="{{route('site.show_suppliers_plans')}}">
                        إبدأ الآن
                    </a>
                </div>
            </div>

            <!-- المسوقين -->
            <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="300">
                <div class="icon-box w-100 shadow-sm">
                    <div class="icon"><i class="bx bx-line-chart"></i></div>
                    <h4>المسوقين بالعمولة</h4>

                    <p>
                        روّج للمنتجات واربح عمولات مجزية مع نظام تتبع احترافي.
                    </p>

                    <ul class="service-features">
                        <li>روابط تتبع ذكية</li>
                        <li>إحصائيات دقيقة</li>
                        <li>عمولات محفزة</li>
                    </ul>

                    <a class="btn service-btn mt-3"
                        href="{{route('site.show_affiliate_marketers_plans')}}">
                        إبدأ الآن
                    </a>
                </div>
            </div>

            <!-- الشحن -->
            <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="400">
                <div class="icon-box w-100 shadow-sm">
                    <div class="icon"><i class="bx bx-package"></i></div>
                    <h4>شركات الشحن</h4>

                    <p>
                        زد عدد عملائك ووفر خدمات توصيل موثوقة للتجار والموردين.
                    </p>

                    <ul class="service-features">
                        <li>طلبات شحن أكثر</li>
                        <li>تتبع الشحنات</li>
                        <li>توسيع قاعدة العملاء</li>
                    </ul>

                    <a class="btn service-btn mt-3"
                        href="{{route('site.show_shipers_plans')}}">
                        إبدأ الآن
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>