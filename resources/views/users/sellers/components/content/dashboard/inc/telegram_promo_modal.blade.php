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
<!-- Telegram Promotion Modal -->
<div class="modal fade" id="telegramPromoModal" tabindex="-1" aria-labelledby="telegramPromoModalLabel" aria-hidden="true" dir="rtl">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden position-relative tg-promo-card">
            
            <!-- Modal Header with Vibrant Marketing Gradient -->
            <div class="tg-promo-header p-4 p-md-5 text-white position-relative">
                <!-- Background Decorative Glows -->
                <div class="tg-glow-circle tg-glow-1"></div>
                <div class="tg-glow-circle tg-glow-2"></div>
                
                <div class="d-flex justify-content-between align-items-start position-relative z-1 mb-3">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-20 rounded-pill text-white small border border-white border-opacity-25 backdrop-blur">
                        <span class="badge bg-warning text-dark fw-bold rounded-pill px-2 py-0.5"><i class="fas fa-bolt me-1"></i> مجاني 100%</span>
                        <span class="fw-semibold">ميزة حصرية لزيادة مبيعاتك</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white opacity-75 hover-opacity-100" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>

                <div class="row align-items-center position-relative z-1">
                    <div class="col-lg-9">
                        <h3 class="fw-black mb-2 text-white display-6 fs-3" id="telegramPromoModalLabel">
                            لا تفوّت أي طلبية بعد اليوم! 🚀
                        </h3>
                        <p class="text-white-50 mb-0 fs-6 leading-relaxed">
                            حوّل هاتفك إلى مركز إشعارات ذكي لمتجرك واستقبل تنبيهات فورية بالصوت لكل طلب جديد ومبيعة، وتقارير دورية لأداء الزوار عبر <strong class="text-white">تليجرام (Telegram)</strong> مجاناً.
                        </p>
                    </div>
                    <div class="col-lg-3 text-center d-none d-lg-block">
                        <div class="tg-icon-circle-wrapper mx-auto">
                            <div class="tg-icon-circle shadow-lg">
                                <i class="fab fa-telegram-plane"></i>
                            </div>
                            <div class="tg-pulse-ring"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Body: Key Value Propositions -->
            <div class="modal-body p-4 p-md-4 bg-light">
                <div class="row g-3 mb-3">
                    <!-- Feature 1: Realtime Orders -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 rounded-4 shadow-sm p-3 bg-white tg-feature-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="stat-icon-wrapper bg-info-subtle text-info rounded-3">
                                    <i class="fas fa-bell fs-5"></i>
                                </div>
                                <span class="badge bg-danger-subtle text-danger fw-bold rounded-pill small">خلال 1 ثانية</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">إشعارات لحظية للطلبات</h6>
                            <p class="text-muted small mb-0 leading-relaxed">
                                تنبيه فوري بالصوت والاهتزاز فور قيام أي زبون بالطلب، لتتصل به مباشرة وتضاعف نسبة تأكيد طلبياتك قبل أن يلغيها.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2: Smart Traffic Reports -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 rounded-4 shadow-sm p-3 bg-white tg-feature-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="stat-icon-wrapper bg-success-subtle text-success rounded-3">
                                    <i class="fas fa-chart-line fs-5"></i>
                                </div>
                                <span class="badge bg-success-subtle text-success fw-bold rounded-pill small">تقارير ذكية</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">تقارير الزوار الدورية</h6>
                            <p class="text-muted small mb-0 leading-relaxed">
                                ملخص دوري (يومي، أسبوعي، شهري) يوضح عدد زوار متجرك، والمنتجات الأكثر طلباً ومعدلات التحويل بدون عناء تسجيل الدخول.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3: Free & Instant Setup -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 rounded-4 shadow-sm p-3 bg-white tg-feature-card">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="stat-icon-wrapper bg-warning-subtle text-warning rounded-3">
                                    <i class="fas fa-bolt fs-5"></i>
                                </div>
                                <span class="badge bg-warning-subtle text-warning fw-bold rounded-pill small">بدون رسوم</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">ربط سريع ومجاني</h6>
                            <p class="text-muted small mb-0 leading-relaxed">
                                ربط فوري خلال أقل من دقيقة بخطوتين فقط، متوافق بالكامل مع جميع الأجهزة والهواتف دون أي تكلفة إضافية.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Trust / Urgency Banner -->
                <div class="p-3 rounded-3 border border-primary border-opacity-10 d-flex align-items-center gap-3 bg-white shadow-xs">
                    <div class="flex-shrink-0 text-primary">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark small">سرعة التأكيد ترفع مبيعاتك بنسبة تفوق 40%!</div>
                        <div class="text-muted" style="font-size: 0.8rem;">
                            التجار الذين يتصلون بالزبون خلال الدقائق الخمس الأولى يضمنون أعلى نسبة استلام وتوصيل ناجح.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer: Clear Call to Actions -->
            <div class="modal-footer p-3 p-md-4 bg-white border-top-0 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <button type="button" class="btn btn-light text-secondary rounded-3 px-3 py-2 fw-semibold order-2 order-sm-1" data-bs-dismiss="modal">
                    سأقوم بالربط لاحقاً
                </button>
                <a href="{{ route('seller.app.telegram-notifications') }}" class="btn btn-primary tg-action-btn fw-bold px-4 py-2.5 rounded-3 shadow d-inline-flex align-items-center gap-2 order-1 order-sm-2 text-white">
                    <i class="fab fa-telegram-plane fs-5"></i>
                    <span>تفعيل إشعارات تليجرام الآن (مجاناً)</span>
                    <i class="fas fa-arrow-left small me-1"></i>
                </a>
            </div>

        </div>
    </div>
</div>

<!-- Scoped Styles for Telegram Promo Modal -->
<style>
    .tg-promo-card {
        border: none !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
    }

    .tg-promo-header {
        background: linear-gradient(135deg, #102a45 0%, #0d47a1 50%, #0088cc 100%);
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
        background: rgba(0, 210, 255, 0.25);
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

    .tg-icon-circle {
        width: 76px;
        height: 76px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0088cc;
        font-size: 2.4rem;
        position: relative;
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .tg-icon-circle-wrapper:hover .tg-icon-circle {
        transform: scale(1.08) rotate(-8deg);
    }

    .tg-pulse-ring {
        position: absolute;
        width: 86px;
        height: 86px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.5);
        animation: tgPulse 2s infinite ease-out;
        z-index: 1;
    }

    @keyframes tgPulse {
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

    .tg-feature-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .tg-feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .tg-action-btn {
        background: linear-gradient(135deg, #0088cc 0%, #0077b5 100%) !important;
        border: none !important;
        transition: all 0.25s ease !important;
    }

    .tg-action-btn:hover {
        background: linear-gradient(135deg, #0077b5 0%, #005f94 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 136, 204, 0.35) !important;
    }

    .backdrop-blur {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
</style>

<!-- Session Control Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sessionKey = 'seller_telegram_promo_popup_seen';
        const alreadySeen = sessionStorage.getItem(sessionKey);

        if (!alreadySeen) {
            // انتظار هادئ 1.3 ثانية لضمان اكتمال تحميل عناصر الصفحة والمخططات
            setTimeout(function () {
                const modalElement = document.getElementById('telegramPromoModal');
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

