@extends('layouts.users.dashboard.app')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
  خدمات وباقات المنصة
@endsection

@section('navbar')
  @include('users.sellers.components.navbar.navbar')
@endsection

@section('sidbar')
  @include('users.sellers.components.sidbar.sidbar')
@endsection

@section('content')
<style>
    /* ========================================================
       PLATFORM SERVICES - MODERN SELLER PALETTE
       Colors: Plum (#5b073e -> #a40c72 -> #be0681) & Dark Slate
       ======================================================== */
    :root {
        --seller-primary: #5b073e;
        --seller-primary-light: #7b0a54;
        --seller-gradient: linear-gradient(135deg, #42042d 0%, #680847 48%, #8e0b62 100%);
        --seller-surface: #ffffff;
        --seller-border: #f0e6ed;
        --seller-border-hover: #dca7c9;
        --seller-text-main: #2b1825;
        --seller-text-muted: #6e5f69;
    }

    .services-container {
        font-family: inherit;
        padding-bottom: 3rem;
    }

    /* Hero Banner */
    .services-hero-banner {
        background: var(--seller-gradient);
        border-radius: 1.25rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(91, 7, 62, 0.22);
        padding: 2.25rem 2rem;
        margin-bottom: 2rem;
    }

    .services-hero-banner::before {
        content: '';
        position: absolute;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0) 70%);
        top: -120px;
        left: -80px;
        border-radius: 50%;
        pointer-events: none;
    }

    .services-hero-banner::after {
        content: '';
        position: absolute;
        width: 280px;
        height: 280px;
        background: radial-gradient(circle, rgba(255, 193, 7, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
        bottom: -90px;
        right: -60px;
        border-radius: 50%;
        pointer-events: none;
    }

    .wallet-highlight-card {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 1rem;
        padding: 1.25rem 1.5rem;
        transition: transform 0.25s ease;
    }

    .wallet-highlight-card:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.16);
    }

    .stat-pill {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 50rem;
        padding: 0.5rem 1.15rem;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
    }

    /* Category Filter Tabs */
    .service-filter-btn {
        border-radius: 50rem;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.6rem 1.4rem;
        border: 1px solid var(--seller-border);
        background: #ffffff;
        color: var(--seller-text-muted);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .service-filter-btn:hover {
        color: var(--seller-primary);
        border-color: var(--seller-border-hover);
        background: #fdf7fb;
    }

    .service-filter-btn.active {
        background: var(--seller-primary);
        color: #ffffff;
        border-color: var(--seller-primary);
        box-shadow: 0 4px 14px rgba(91, 7, 62, 0.25);
    }

    /* Service Cards */
    .service-card {
        background: #ffffff;
        border: 1px solid var(--seller-border);
        border-radius: 1.25rem;
        transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }

    .service-card:hover {
        transform: translateY(-6px);
        border-color: var(--seller-border-hover);
        box-shadow: 0 16px 36px rgba(91, 7, 62, 0.09);
    }

    .service-card-header {
        padding: 1.75rem 1.5rem 0.75rem;
        position: relative;
    }

    .service-icon-box {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.45rem;
        margin-bottom: 1.15rem;
        transition: transform 0.3s ease;
    }

    .service-card:hover .service-icon-box {
        transform: scale(1.08) rotate(-4deg);
    }

    .icon-payment {
        background: #eef9f2;
        color: #198754;
        border: 1px solid #c9eed6;
    }

    .icon-store {
        background: #fff8eb;
        color: #d97706;
        border: 1px solid #fde2b4;
    }

    .icon-ai {
        background: #fbf0f8;
        color: #a40c72;
        border: 1px solid #f5cee9;
    }

    .service-card-body {
        padding: 0 1.5rem 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .service-feature-list {
        list-style: none;
        padding: 0;
        margin: 1.15rem 0;
    }

    .service-feature-item {
        font-size: 0.88rem;
        color: #4b5563;
        margin-bottom: 0.6rem;
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        line-height: 1.45;
    }

    .service-feature-item i {
        color: #10b981;
        font-size: 0.95rem;
        margin-top: 0.18rem;
        flex-shrink: 0;
    }

    .service-pricing-box {
        background: #faf6f9;
        border: 1px dashed var(--seller-border-hover);
        border-radius: 0.85rem;
        padding: 0.9rem 1.15rem;
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .service-card-footer {
        padding: 1.15rem 1.5rem;
        background: #ffffff;
        border-top: 1px solid var(--seller-border);
    }

    .btn-purchase-service {
        background: var(--seller-gradient);
        color: #ffffff;
        border: none;
        border-radius: 0.75rem;
        font-weight: 600;
        padding: 0.75rem 1rem;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.25s ease;
    }

    .btn-purchase-service:hover {
        color: #ffffff;
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(91, 7, 62, 0.28);
    }

    /* Quota Pill */
    .quota-badge-pill {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        font-weight: 700;
        border-radius: 50rem;
        padding: 0.25rem 0.8rem;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    /* Modal Styling */
    .modal-purchase-service .modal-content {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.18);
        overflow: hidden;
    }

    .modal-purchase-header {
        background: var(--seller-gradient);
        color: #ffffff;
        padding: 1.5rem;
    }

    .balance-breakdown-box {
        background: #fbf7fa;
        border: 1px solid #eedde7;
        border-radius: 0.9rem;
        padding: 1.15rem;
    }
</style>

<div class="container-fluid services-container px-3 px-md-4 mt-3">

    {{-- Session Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center mb-4" role="alert">
            <i class="fa-solid fa-circle-check fs-4 me-3 text-success"></i>
            <div>
                <strong>تم بنجاح!</strong> {{ session('success') }}
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 d-flex align-items-center mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation fs-4 me-3 text-danger"></i>
            <div>
                <strong>تنبيه:</strong> {{ session('error') }}
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- HERO BANNER --}}
    <div class="services-hero-banner">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-20 text-white small mb-3">
                    <i class="fa-solid fa-wand-magic-sparkles text-warning"></i>
                    <span>باقات وخدمات المنصة بالاستخدام</span>
                </div>
                <h2 class="fw-bold mb-2 text-white">باقات مرنة حسب عدد الطلبات والاستخدام ⚡</h2>
                <p class="text-white-50 mb-3 fs-6" style="max-width: 580px;">
                    اشترِ باقات طلبات حسب حاجتك الفعلية: طلبات دفع إلكتروني عبر شارجلي، أو طلبات دفع بالتحويل البنكي لزبائن متجرك، أو نقاط لتوليد صفحات الهبوط بالذكاء الاصطناعي. الرصيد تراكمي ولا ينتهي!
                </p>
                <div class="d-flex flex-wrap gap-2 pt-1">
                    <span class="stat-pill text-white">
                        <i class="fa-solid fa-bolt text-warning"></i>
                        <span>شارجلي المتبقي: <strong>{{ number_format($chargilyRemainingOrders) }}</strong> طلب</span>
                    </span>
                    <span class="stat-pill text-white">
                        <i class="fa-solid fa-building-columns text-info"></i>
                        <span>التحويل البنكي المتبقي: <strong>{{ number_format($bankTransferRemainingOrders) }}</strong> طلب</span>
                    </span>
                    <span class="stat-pill text-white">
                        <i class="fa-solid fa-brain text-white-50"></i>
                        <span>نقاط الذكاء الاصطناعي: <strong>{{ number_format($aiCreditsBalance) }}</strong> نقطة</span>
                    </span>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="wallet-highlight-card text-white">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-white-50 small d-flex align-items-center gap-2">
                            <i class="fa-solid fa-wallet text-warning fs-6"></i> رصيد محفظتك المتاح
                        </span>
                        <a href="{{ route('seller.wallet') }}" class="btn btn-sm btn-light rounded-pill px-3 py-1 fw-bold text-dark d-flex align-items-center gap-1 shadow-sm">
                            <i class="fa-solid fa-plus-circle text-primary"></i> شحن الرصيد
                        </a>
                    </div>
                    <div class="fs-2 fw-bolder mb-1 font-monospace">
                        {{ number_format($currentBalance, 2) }} <span class="fs-6 fw-normal">د.ج</span>
                    </div>
                    <p class="small text-white-50 mb-0">
                        <i class="fa-solid fa-circle-check text-success me-1"></i> يتم شراء جميع الباقات بخصم فوري ومباشر من رصيد المحفظة.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- CATEGORY FILTER PILLS --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div class="d-flex flex-wrap gap-2" id="categoryFilters">
            <button type="button" class="service-filter-btn active" data-filter="all">
                <i class="fa-solid fa-cubes"></i> الكل ({{ $services->count() }})
            </button>
            <button type="button" class="service-filter-btn" data-filter="payment">
                <i class="fa-solid fa-credit-card"></i> بوابات الدفع (شارجلي)
            </button>
            <button type="button" class="service-filter-btn" data-filter="store_features">
                <i class="fa-solid fa-building-columns"></i> الدفع بالتحويل البنكي
            </button>
            <button type="button" class="service-filter-btn" data-filter="ai_tools">
                <i class="fa-solid fa-wand-magic-sparkles"></i> أدوات الذكاء الاصطناعي
            </button>
        </div>

        <div class="text-muted small">
            <i class="fa-solid fa-layer-group text-primary me-1"></i> الرصيد تراكمي ويضاف مباشرةً عند كل عملية شراء
        </div>
    </div>

    {{-- SERVICES GRID --}}
    <div class="row g-4" id="servicesGrid">
        @forelse($services as $service)
            @php
                // Determine icon theme
                $iconClass = 'icon-store';
                if ($service->category === 'payment') $iconClass = 'icon-payment';
                elseif ($service->category === 'ai_tools') $iconClass = 'icon-ai';
            @endphp

            <div class="col-md-6 col-lg-4 service-grid-item" data-category="{{ $service->category }}">
                <div class="service-card">
                    
                    {{-- Badges --}}
                    @if($service->badge_text)
                        <span class="badge bg-{{ $service->badge_color ?? 'warning' }} position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill small">
                            {{ $service->badge_text }}
                        </span>
                    @endif

                    <div class="service-card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="service-icon-box {{ $iconClass }}">
                                <i class="{{ $service->icon }}"></i>
                            </div>

                            @if($service->isOrderQuota())
                                <span class="quota-badge-pill">
                                    <i class="fa-solid fa-cart-shopping"></i> {{ $service->orders_limit }} طلبات
                                </span>
                            @elseif($service->isCreditPack())
                                <span class="quota-badge-pill" style="background: #fdf2f8; color: #9d174d; border-color: #fbcfe8;">
                                    <i class="fa-solid fa-wand-magic-sparkles"></i> {{ $service->credits_amount }} نقطة
                                </span>
                            @endif
                        </div>

                        <h5 class="fw-bold mb-2 text-dark">{{ $service->name_ar }}</h5>
                        <p class="text-muted small mb-0" style="min-height: 48px; line-height: 1.5;">
                            {{ $service->description_ar }}
                        </p>
                    </div>

                    <div class="service-card-body">
                        {{-- Feature Highlights --}}
                        @if($service->features && is_array($service->features))
                            <ul class="service-feature-list">
                                @foreach($service->features as $feature)
                                    <li class="service-feature-item">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- Pricing Summary Box --}}
                        <div class="service-pricing-box">
                            <div>
                                <span class="text-muted small d-block">سعر الباقة الإجمالي</span>
                                <span class="fs-4 fw-bold text-dark font-monospace">{{ number_format($service->price, 0) }}</span>
                                <span class="small fw-semibold text-muted">د.ج</span>
                            </div>
                            <div class="text-end">
                                @if($service->isOrderQuota() && $service->price_per_order)
                                    <span class="badge bg-success bg-opacity-10 text-success fw-bold rounded-pill px-3 py-1 d-block mb-1">
                                        {{ $service->price_per_order }} د.ج / طلب
                                    </span>
                                    <span class="text-muted" style="font-size: 0.75rem;">(صالحة حتى الاستهلاك)</span>
                                @elseif($service->isCreditPack())
                                    <span class="badge bg-info bg-opacity-10 text-info fw-bold rounded-pill px-3 py-1 d-block mb-1">
                                        {{ $service->credits_amount }} نقطة AI
                                    </span>
                                    <span class="text-muted" style="font-size: 0.75rem;">(دون انتهاء صلاحية)</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer & Actions --}}
                    <div class="service-card-footer">
                        <button type="button" 
                                class="btn btn-purchase-service"
                                data-bs-toggle="modal" 
                                data-bs-target="#purchaseModal_{{ $service->id }}">
                            <i class="fa-solid fa-plus-circle"></i> شراء وإضافة للرصيد
                        </button>
                    </div>
                </div>
            </div>

            {{-- PURCHASE CONFIRMATION MODAL (WALLET ONLY) --}}
            <div class="modal fade modal-purchase-service" id="purchaseModal_{{ $service->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        
                        <div class="modal-purchase-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white bg-opacity-20 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                    <i class="{{ $service->icon }} text-warning fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="modal-title fw-bold text-white mb-0">تأكيد شراء الباقة</h6>
                                    <span class="text-white-50 small">{{ $service->name_ar }}</span>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4">
                            @php
                                $hasEnoughBalance = $currentBalance >= $service->price;
                                $balanceAfterPurchase = $currentBalance - $service->price;
                            @endphp

                            <div class="p-3 rounded-3 bg-light border mb-3">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="fa-solid fa-circle-check text-success"></i>
                                    <span class="fw-bold text-dark">
                                        @if($service->isOrderQuota())
                                            ستحصل على: <span class="text-primary">{{ $service->orders_limit }} طلبات جديدة</span> تضاف فوراً لحسابك
                                        @elseif($service->isCreditPack())
                                            ستحصل على: <span class="text-primary">{{ $service->credits_amount }} نقطة AI</span> تضاف فوراً لحسابك
                                        @endif
                                    </span>
                                </div>
                                <span class="text-muted small">يتم الخصم المباشر من رصيد محفظتك، والرصيد تراكمي ولا ينتهي بموعد زمني محدد.</span>
                            </div>

                            {{-- Financial Ledger Simulation --}}
                            <div class="balance-breakdown-box mb-3">
                                <div class="d-flex justify-content-between py-1 border-bottom border-light">
                                    <span class="text-muted small">رصيدك الحالي في المحفظة:</span>
                                    <span class="fw-bold font-monospace">{{ number_format($currentBalance, 2) }} د.ج</span>
                                </div>
                                <div class="d-flex justify-content-between py-1 border-bottom border-light text-danger">
                                    <span class="small">سعر الباقة المطلوب:</span>
                                    <span class="fw-bold font-monospace">- {{ number_format($service->price, 2) }} د.ج</span>
                                </div>
                                <div class="d-flex justify-content-between pt-2">
                                    <span class="fw-bold text-dark small">رصيدك المتبقي بعد الخصم:</span>
                                    <span class="fw-bold font-monospace {{ $hasEnoughBalance ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($balanceAfterPurchase, 2) }} د.ج
                                    </span>
                                </div>
                            </div>

                            @if($hasEnoughBalance)
                                <div class="alert alert-success d-flex align-items-center py-2 px-3 rounded-3 small mb-0">
                                    <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
                                    <span>رصيدك كافٍ لإتمام عملية الشراء فوراً وإضافة الرصيد إلى متجرك.</span>
                                </div>
                            @else
                                <div class="alert alert-danger py-2 px-3 rounded-3 small mb-3">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fa-solid fa-triangle-exclamation fs-5 me-2 text-danger"></i>
                                        <strong>رصيدك غير كافٍ!</strong>
                                    </div>
                                    <span>تحتاج إلى شحن <strong>{{ number_format(abs($balanceAfterPurchase), 2) }} د.ج</strong> إضافية لإتمام شراء هذه الباقة.</span>
                                </div>
                                <a href="{{ route('seller.wallet') }}" class="btn btn-warning w-100 fw-bold py-2 rounded-3 text-dark d-flex align-items-center justify-content-center gap-2">
                                    <i class="fa-solid fa-plus-circle"></i> شحن المحفظة الآن
                                </a>
                            @endif
                        </div>

                        <div class="modal-footer bg-light p-3 border-0">
                            <button type="button" class="btn btn-outline-secondary px-4 rounded-3" data-bs-dismiss="modal">إلغاء</button>
                            
                            @if($hasEnoughBalance)
                                <form action="{{ route('seller.services.purchase', $service->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-purchase-service px-4">
                                        <i class="fa-solid fa-check-circle"></i> تأكيد الخصم والشراء
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        @empty
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-box-open fs-1 text-muted mb-3 d-block"></i>
                <h5 class="text-muted">لا توجد خدمات متاحة حالياً</h5>
                <p class="text-muted small">سيتم إضافة باقات وخدمات جديدة قريباً من قبل إدارة المنصة.</p>
            </div>
        @endforelse
    </div>

</div>

{{-- CLIENT-SIDE FILTER JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterButtons = document.querySelectorAll('.service-filter-btn');
        const serviceItems = document.querySelectorAll('.service-grid-item');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                serviceItems.forEach(item => {
                    const category = item.getAttribute('data-category');
                    if (filter === 'all' || category === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endsection
