@php
    $telegramConnected = false;
    if (auth()->check()) {
        $telegramConnected = \App\Models\UserApps::where('user_id', auth()->id())
            ->where('app_name', 'telegram_notifications')
            ->where('status', 'active')
            ->exists();
    }
@endphp

@if (!$telegramConnected)
<!-- Supplier Telegram Promotion Modal -->
<div class="modal fade" id="supplierTelegramPromoModal" tabindex="-1" aria-labelledby="supplierTelegramPromoModalLabel" aria-hidden="true" dir="rtl">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden position-relative tg-supplier-promo-card">
            
            <!-- Modal Header with Slate & Electric Blue Wholesale Gradient -->
            <div class="tg-supplier-promo-header p-4 p-md-5 text-white position-relative">
                <!-- Background Decorative Glows -->
                <div class="tg-glow-circle tg-glow-1"></div>
                <div class="tg-glow-circle tg-glow-2"></div>
                
                <div class="d-flex justify-content-between align-items-start position-relative z-1 mb-3">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-20 rounded-pill text-white small border border-white border-opacity-25 backdrop-blur">
                        <span class="badge bg-warning text-dark fw-bold rounded-pill px-2 py-0.5"><i class="fas fa-bolt me-1"></i> مجاني 100%</span>
                        <span class="fw-semibold">ميزة حصرية لتسريع التوريد</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white opacity-75 hover-opacity-100" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>

                <div class="row align-items-center position-relative z-1">
                    <div class="col-lg-9">
                        <h3 class="fw-black mb-2 text-white display-6 fs-3" id="supplierTelegramPromoModalLabel">
                            طوّر أعمال التوريد ولا تفوّت أي طلبية جملة! 📦⚡
                        </h3>
                        <p class="text-white-50 mb-0 fs-6 leading-relaxed">
                            حوّل هاتفك إلى مركز قيادة وإشعارات لمستودعك واستقبل تنبيهات فورية بالصوت لطلبات التجار وحركات التوريد، مع تقارير دورية لأداء الزوار عبر <strong class="text-white">تليجرام (Telegram)</strong> مجاناً.
                        </p>
                    </div>
                    <div class="col-lg-3 text-center d-none d-lg-block">
                        <div class="tg-icon-circle-wrapper mx-auto">
                            <div class="tg-supplier-icon-circle shadow-lg">
                                <i class="fab fa-telegram-plane"></i>
                            </div>
                            <div class="tg-supplier-pulse-ring"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Body: Key Value Propositions for Wholesale Suppliers -->
            <div class="modal-body p-4 p-md-4 bg-light">
                <div class="row g-3 mb-3">
                    <!-- Feature 1: Realtime Wholesale Orders -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 rounded-4 shadow-sm p-3 bg-white tg-supplier-feature-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="stat-icon-wrapper bg-primary-subtle text-primary rounded-3">
                                    <i class="fas fa-boxes-stacked fs-5"></i>
                                </div>
                                <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill small">تنبيه لحظي</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">إشعارات طلبات الجملة</h6>
                            <p class="text-muted small mb-0 leading-relaxed">
                                تنبيه فوري فور قيام أي تاجر أو مسوق بطلب كميات جملة أو سحب منتجات، لتجهيز طلبياتك فوراً وكسب ثقة التجار.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2: Smart Traffic & Inventory Reports -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 rounded-4 shadow-sm p-3 bg-white tg-supplier-feature-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="stat-icon-wrapper bg-success-subtle text-success rounded-3">
                                    <i class="fas fa-chart-line fs-5"></i>
                                </div>
                                <span class="badge bg-success-subtle text-success fw-bold rounded-pill small">تقارير دورية</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">تقارير الزوار والمنتجات</h6>
                            <p class="text-muted small mb-0 leading-relaxed">
                                تقارير ذكية دورية (يومية، أسبوعية، شهرية) توضح عدد زوار متجرك والمنتجات الأكثر طلباً وسحباً من التجار لتنظيم مخزونك.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3: Free & Instant Setup -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 rounded-4 shadow-sm p-3 bg-white tg-supplier-feature-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="stat-icon-wrapper bg-warning-subtle text-warning rounded-3">
                                    <i class="fas fa-bolt fs-5"></i>
                                </div>
                                <span class="badge bg-warning-subtle text-warning fw-bold rounded-pill small">مجاني دائماً</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">ربط سريع بدون تكلفة</h6>
                            <p class="text-muted small mb-0 leading-relaxed">
                                تفعيل سهل خلال أقل من دقيقة، متوافق بالكامل مع جميع الأجهزة والهواتف لتبقى على اتصال دائم بمستودعك أينما كنت.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Trust / Efficiency Banner -->
                <div class="p-3 rounded-3 border border-primary border-opacity-10 d-flex align-items-center gap-3 bg-white shadow-xs">
                    <div class="flex-shrink-0 text-primary">
                        <i class="fas fa-truck-fast fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark small">سرعة تجهيز الشحنات تجعل متجرك الخيار الأول للتجار!</div>
                        <div class="text-muted" style="font-size: 0.8rem;">
                            الموردون الذين يتلقون إشعارات فورية يعالجون طلبات التوريد بنسبة أسرع بـ 3 أضعاف، مما يضاعف ولاء المسوقين لمنتجاتهم.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer: Clear Call to Actions -->
            <div class="modal-footer p-3 p-md-4 bg-white border-top-0 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <button type="button" class="btn btn-light text-secondary rounded-3 px-3 py-2 fw-semibold order-2 order-sm-1" data-bs-dismiss="modal">
                    لاحقاً، استكشف لوحة التوريد
                </button>
                <a href="{{ route('supplier.app.telegram-notifications') }}" class="btn btn-primary tg-supplier-action-btn fw-bold px-4 py-2.5 rounded-3 shadow d-inline-flex align-items-center gap-2 order-1 order-sm-2 text-white">
                    <i class="fab fa-telegram-plane fs-5"></i>
                    <span>تفعيل إشعارات تليجرام للتوريد (مجاناً)</span>
                    <i class="fas fa-arrow-left small me-1"></i>
                </a>
            </div>

        </div>
    </div>
</div>

<!-- Scoped Styles for Supplier Telegram Promo Modal -->
<style>
    .tg-supplier-promo-card {
        border: none !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.3) !important;
    }

    .tg-supplier-promo-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 45%, #2563eb 100%);
        overflow: hidden;
    }

    .tg-glow-circle {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        filter: blur(45px);
    }

    .tg-glow-1 {
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.15);
        top: -60px;
        right: -40px;
    }

    .tg-glow-2 {
        width: 180px;
        height: 180px;
        background: rgba(56, 189, 248, 0.25);
        bottom: -50px;
        left: 20%;
    }

    .tg-icon-circle-wrapper {
        position: relative;
        width: 90px;
        height: 90px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tg-supplier-icon-circle {
        width: 76px;
        height: 76px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 2.4rem;
        position: relative;
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .tg-icon-circle-wrapper:hover .tg-supplier-icon-circle {
        transform: scale(1.08) rotate(-8deg);
    }

    .tg-supplier-pulse-ring {
        position: absolute;
        width: 86px;
        height: 86px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.5);
        animation: tgSupplierPulse 2s infinite ease-out;
        z-index: 1;
    }

    @keyframes tgSupplierPulse {
        0% {
            transform: scale(0.9);
            opacity: 0.8;
        }
        70% {
            transform: scale(1.25);
            opacity: 0;
        }
        100% {
            transform: scale(1.3);
            opacity: 0;
        }
    }

    .tg-supplier-feature-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .tg-supplier-feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08) !important;
    }

    .tg-supplier-action-btn {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
        border: none !important;
        transition: all 0.25s ease !important;
    }

    .tg-supplier-action-btn:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(37, 99, 235, 0.35) !important;
    }

    .backdrop-blur {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
</style>

<!-- Session Control Script for Supplier -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sessionKey = 'supplier_telegram_promo_popup_seen';
        const alreadySeen = sessionStorage.getItem(sessionKey);

        if (!alreadySeen) {
            // انتظار هادئ 1.3 ثانية لضمان اكتمال تحميل عناصر الصفحة والمخططات
            setTimeout(function () {
                const modalElement = document.getElementById('supplierTelegramPromoModal');
                if (modalElement && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const promoModal = new bootstrap.Modal(modalElement, {
                        backdrop: 'static',
                        keyboard: true
                    });
                    promoModal.show();
                    // تسجيل الظهور في sessionStorage للجلسة الحالية
                    sessionStorage.setItem(sessionKey, 'true');
                }
            }, 1300);
        }
    });
</script>
@endif

