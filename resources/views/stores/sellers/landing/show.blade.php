<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landingPage->title ?? $product->name }} | {{ tenant('id') }}</title>
    <meta name="description" content="{{ $landingPage->hero_subheadline ?? $product->short_description }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: {{ $landingPage->theme_settings['primary_color'] ?? '#B03882' }};
            --primary-hover: #8f2868;
            --primary-light: rgba(176, 56, 130, 0.08);
            --dark-color: #1a1a2e;
            --accent-gold: #f59e0b;
        }
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #fbfbfd;
            color: #2d3748;
            overflow-x: hidden;
        }
        .announcement-bar {
            background: linear-gradient(135deg, #1f0717 0%, var(--primary-color) 100%);
            color: #fff;
            font-weight: 700;
            font-size: 0.92rem;
            padding: 8px 0;
            text-align: center;
        }
        .hero-section {
            background: radial-gradient(circle at 10% 20%, rgba(176, 56, 130, 0.04) 0%, rgba(255, 255, 255, 0) 90%);
            padding: 40px 0 60px 0;
        }
        .badge-offer {
            background: var(--primary-light);
            color: var(--primary-color);
            border: 1px solid rgba(176, 56, 130, 0.25);
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 50px;
            display: inline-block;
        }
        .hero-title {
            font-size: 2.3rem;
            font-weight: 900;
            line-height: 1.35;
            color: var(--dark-color);
            margin-top: 15px;
        }
        .hero-subtitle {
            font-size: 1.15rem;
            line-height: 1.8;
            color: #4b5563;
            margin-top: 15px;
        }
        .price-tag {
            background: #fff;
            border: 2px dashed var(--primary-color);
            border-radius: 16px;
            padding: 14px 20px;
            display: inline-flex;
            align-items: center;
            gap: 15px;
        }
        .current-price {
            font-size: 2.1rem;
            font-weight: 900;
            color: var(--primary-color);
        }
        .old-price {
            text-decoration: line-through;
            color: #9ca3af;
            font-size: 1.2rem;
            font-weight: 600;
        }
        .btn-order-now {
            background: linear-gradient(135deg, var(--primary-color) 0%, #d6479f 100%);
            color: #fff !important;
            font-size: 1.25rem;
            font-weight: 800;
            padding: 16px 36px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(176, 56, 130, 0.35);
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .btn-order-now:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(176, 56, 130, 0.45);
        }
        .pulse-animation {
            animation: pulse-glow 2s infinite;
        }
        @keyframes pulse-glow {
            0% { box-shadow: 0 0 0 0 rgba(176, 56, 130, 0.6); }
            70% { box-shadow: 0 0 0 16px rgba(176, 56, 130, 0); }
            100% { box-shadow: 0 0 0 0 rgba(176, 56, 130, 0); }
        }
        .product-img-box {
            background: #fff;
            border-radius: 24px;
            padding: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0,0,0,0.04);
            position: relative;
        }
        .product-main-img {
            width: 100%;
            height: auto;
            max-height: 480px;
            object-fit: cover;
            border-radius: 18px;
        }
        .feature-card {
            background: #fff;
            border-radius: 18px;
            padding: 24px;
            height: 100%;
            border: 1px solid #f0f0f5;
            box-shadow: 0 10px 25px rgba(0,0,0,0.02);
            transition: all 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(176, 56, 130, 0.08);
            border-color: rgba(176, 56, 130, 0.2);
        }
        .feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--primary-light);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 16px;
        }
        .pain-box {
            background: #fff5f5;
            border-right: 4px solid #ef4444;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 12px;
            font-weight: 600;
            color: #991b1b;
        }
        .guarantee-badge {
            background: #fff;
            border-radius: 16px;
            padding: 18px;
            text-align: center;
            box-shadow: 0 6px 16px rgba(0,0,0,0.04);
            border: 1px solid #eef2f6;
        }
        .order-container {
            background: #fff;
            border-radius: 28px;
            padding: 40px;
            box-shadow: 0 25px 60px rgba(176, 56, 130, 0.12);
            border: 2px solid rgba(176, 56, 130, 0.18);
        }
        .sticky-mobile-cta {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 12px 16px;
            box-shadow: 0 -8px 25px rgba(0,0,0,0.1);
            z-index: 999;
            display: none;
        }
        @media (max-width: 768px) {
            .hero-title { font-size: 1.7rem; }
            .order-container { padding: 24px 18px; }
            .sticky-mobile-cta { display: block; }
            body { padding-bottom: 75px; }
        }
    </style>
</head>
<body>

    {{-- Top Announcement Bar --}}
    <div class="announcement-bar">
        <i class="fa-solid fa-truck-fast me-1"></i> تخفيض استثنائي لفترة محدودة + الدفع عند الاستلام بعد المعاينة!
    </div>

    {{-- Hero Section --}}
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge-offer">
                        <i class="fa-solid fa-fire me-1"></i> {{ $landingPage->marketing_angle_name }}
                    </span>
                    <h1 class="hero-title">
                        {{ $landingPage->hero_headline ?? $product->name }}
                    </h1>
                    <p class="hero-subtitle">
                        {{ $landingPage->hero_subheadline ?? $product->short_description }}
                    </p>

                    <div class="d-flex align-items-center gap-2 mb-4">
                        <div class="text-warning fs-5">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="fw-bold text-dark fs-6">(4.9/5) من أكثر من 650 مشترٍ راضٍ</span>
                    </div>

                    <div class="mb-4">
                        <div class="price-tag">
                            <div>
                                <span class="d-block small text-muted fw-bold">السعر الترويجي الخاص:</span>
                                <span class="current-price">{{ number_format($product->price, 0) }} د.ج</span>
                            </div>
                            <div>
                                <span class="d-block small text-muted fw-bold">السعر السابق:</span>
                                <span class="old-price">{{ number_format($product->price * 1.35, 0) }} د.ج</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="#order-section" class="btn-order-now pulse-animation">
                            <i class="fa-solid fa-cart-shopping me-1"></i> اطلب الآن والدفع عند الاستلام
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 text-center">
                    <div class="product-img-box">
                        @if ($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-main-img">
                        @else
                            <div class="p-5 bg-light rounded-4 text-muted">
                                <i class="fa-solid fa-box-open fa-4x mb-3 text-secondary"></i>
                                <h5>{{ $product->name }}</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Pain Points / The Problem Section --}}
    @if (!empty($content['pain_points']))
        <section class="py-5 bg-white">
            <div class="container">
                <div class="text-center max-w-700 mx-auto mb-5">
                    <span class="badge bg-danger-subtle text-danger px-3 py-1.5 rounded-pill fw-bold fs-6">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> هل تواجه هذه الصعوبات؟
                    </span>
                    <h2 class="fw-bold text-dark mt-3">لماذا تحتاج إلى هذا الحل الآن؟</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        @foreach ($content['pain_points'] as $pain)
                            <div class="pain-box">
                                <i class="fa-solid fa-circle-xmark me-2 text-danger"></i> {{ $pain }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Features & Benefits Section --}}
    @if (!empty($content['benefits']))
        <section class="py-5" style="background-color: #f7f7fc;">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="badge bg-primary-subtle text-plum px-3 py-1.5 rounded-pill fw-bold fs-6">
                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> مميزات استثنائية
                    </span>
                    <h2 class="fw-bold text-dark mt-3">ما الذي يجعل هذا المنتج اختيارك الأفضل؟</h2>
                </div>
                <div class="row g-4">
                    @foreach ($content['benefits'] as $index => $benefit)
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fa-solid {{ match($index) { 0 => 'fa-gem', 1 => 'fa-bolt', 2 => 'fa-shield-halved', default => 'fa-heart' } }}"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-2">{{ $benefit['title'] ?? '' }}</h5>
                                <p class="text-muted small mb-0 lh-base">{{ $benefit['description'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Guarantees Section --}}
    <section class="py-5 bg-white border-top border-bottom">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="guarantee-badge">
                        <i class="fa-solid fa-hand-holding-dollar fa-2x text-success mb-3"></i>
                        <h6 class="fw-bold">الدفع عند الاستلام</h6>
                        <p class="text-muted small mb-0">افحص طردك وعاينه أمام الموزع قبل دفع أي دينار.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="guarantee-badge">
                        <i class="fa-solid fa-truck-fast fa-2x text-primary mb-3"></i>
                        <h6 class="fw-bold">توصيل سريع وموثوق</h6>
                        <p class="text-muted small mb-0">شحن آمن ومباشر حتى باب منزلك في كافة الولايات.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="guarantee-badge">
                        <i class="fa-solid fa-medal fa-2x text-warning mb-3"></i>
                        <h6 class="fw-bold">ضمان الجودة 100%</h6>
                        <p class="text-muted small mb-0">منتج أصلي مطابق تماماً للمواصفات المعروضة.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials Section --}}
    @if (!empty($content['testimonials']))
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark">تجارب وآراء عملائنا</h2>
                    <p class="text-muted">انظر ماذا يقول المشترون بعد تجربة المنتج</p>
                </div>
                <div class="row g-4">
                    @foreach ($content['testimonials'] as $testimonial)
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                                <div class="text-warning mb-2">
                                    @for ($i = 0; $i < ($testimonial['rating'] ?? 5); $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                </div>
                                <p class="text-dark fw-semibold mb-3">"{{ $testimonial['comment'] ?? '' }}"</p>
                                <div class="mt-auto d-flex align-items-center gap-2">
                                    <div class="avatar bg-primary-subtle text-plum rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $testimonial['name'] ?? '' }}</h6>
                                        <small class="text-muted">{{ $testimonial['city'] ?? '' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Order COD Checkout Section --}}
    <section id="order-section" class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="order-container">
                        <div class="text-center mb-4">
                            <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-bold fs-6 mb-2">
                                <i class="fa-solid fa-bag-shopping me-1"></i> استمارة الطلب المباشر
                            </span>
                            <h2 class="fw-bold text-dark">املأ معلوماتك وسنتكفل بالباقي</h2>
                            <p class="text-muted small">الدفع يكون نقداً عند الاستلام بعد معاينة المنتج</p>
                        </div>

                        <form action="{{ route('tenant.order-with-items') }}" method="POST" id="landingOrderForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="payment_method" value="cod">
                            <input type="hidden" name="shipping_and_point" value="home">

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">الاسم واللقب بالكامل <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted"></i></span>
                                        <input type="text" name="name" class="form-control form-control-lg border-0 bg-light" placeholder="أدخل اسمك الكامل" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">رقم الهاتف <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-phone text-muted"></i></span>
                                        <input type="tel" name="phone" class="form-control form-control-lg border-0 bg-light" placeholder="مثال: 0555123456" pattern="^0[5-7][0-9]{8}$" required>
                                    </div>
                                    <small class="text-muted">سيتصل بك فريقنا لتأكيد الطلب وعنوان التوصيل.</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">الولاية <span class="text-danger">*</span></label>
                                    <select name="wilaya" class="form-select form-select-lg border-0 bg-light" required>
                                        <option value="">اختر ولايتك...</option>
                                        @foreach ($wilayas as $wilaya)
                                            <option value="{{ $wilaya->id }}">{{ $wilaya->zip_code }} - {{ $wilaya->ar_name ?? $wilaya->en_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">البلدية أو العنوان <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control form-control-lg border-0 bg-light" placeholder="اسم البلدية والحي" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">الكمية المطلوبة:</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="input-group" style="width: 140px;">
                                            <button type="button" class="btn btn-outline-secondary" onclick="changeQty(-1)"><i class="fa-solid fa-minus"></i></button>
                                            <input type="number" id="orderQty" name="qty" class="form-control text-center fw-bold" value="1" min="1" readonly>
                                            <button type="button" class="btn btn-outline-secondary" onclick="changeQty(1)"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                        <div class="ms-auto text-end">
                                            <span class="text-muted small d-block">المجموع الإجمالي:</span>
                                            <span class="fw-bold fs-4 text-plum" id="totalPriceDisplay">{{ number_format($product->price, 0) }} د.ج</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn w-100 py-3 text-white fw-bold fs-5 rounded-4 shadow-sm" style="background: linear-gradient(135deg, var(--primary-color) 0%, #d6479f 100%);">
                                        <i class="fa-solid fa-truck-ramp-box me-1"></i> {{ $content['cta_button_text'] ?? 'تأكيد الطلب الآن (الدفع عند الاستلام)' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQs Section --}}
    @if (!empty($content['faqs']))
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark">الأسئلة الشائعة</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="accordion" id="faqAccordion">
                            @foreach ($content['faqs'] as $index => $faq)
                                <div class="accordion-item border-0 mb-3 rounded-3 shadow-2xs overflow-hidden">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button fw-bold {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $index }}">
                                            {{ $faq['question'] ?? '' }}
                                        </button>
                                    </h2>
                                    <div id="faq-{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body text-muted lh-base">
                                            {{ $faq['answer'] ?? '' }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Footer --}}
    <footer class="py-4 text-center bg-white border-top text-muted small">
        <p class="mb-0">جميع الحقوق محفوظة &copy; {{ date('Y') }} - {{ tenant('id') }}</p>
    </footer>

    {{-- Sticky Mobile CTA Bar --}}
    <div class="sticky-mobile-cta">
        <div class="d-flex align-items-center justify-content-between gap-3">
            <div>
                <span class="d-block small text-muted">السعر:</span>
                <span class="fw-bold text-plum fs-5">{{ number_format($product->price, 0) }} د.ج</span>
            </div>
            <a href="#order-section" class="btn text-white fw-bold px-4 py-2.5 rounded-pill shadow-sm" style="background: var(--primary-color);">
                اطلب الآن <i class="fa-solid fa-arrow-left me-1"></i>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const unitPrice = {{ (float) $product->price }};
        function changeQty(diff) {
            const input = document.getElementById('orderQty');
            let val = parseInt(input.value) + diff;
            if (val < 1) val = 1;
            input.value = val;
            const total = val * unitPrice;
            document.getElementById('totalPriceDisplay').innerText = total.toLocaleString() + ' د.ج';
        }
    </script>
</body>
</html>
