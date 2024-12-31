<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>إعدادات التطبيق والتكاملات</h2>
        <button class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            إضافة تكامل جديد
        </button>
    </div>

    <!-- Analytics Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">التحليلات والتتبع</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Google Analytics -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge bg-success status-badge">مفعل</span>
                        <div class="card-body text-center">
                            <div class="integration-icon text-primary">
                                <i class="fab fa-google"></i>
                            </div>
                            <h5 class="card-title">Google Analytics</h5>
                            <p class="card-text">تتبع حركة الزوار وتحليل سلوك المستخدمين</p>
                            <div class="mb-3">
                                <label class="form-label">معرف التتبع (Tracking ID)</label>
                                <input type="text" class="form-control" placeholder="UA-XXXXXXXXX-X">
                            </div>
                            <div class="form-check form-switch mb-3 d-flex justify-content-center">
                                <input class="form-check-input ms-2" type="checkbox" checked="">
                                <label class="form-check-label">تفعيل التتبع</label>
                            </div>
                            <button class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </div>
                </div>

                <!-- Facebook Pixel -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge bg-success status-badge">مفعل</span>
                        <div class="card-body text-center">
                            <div class="integration-icon text-primary">
                                <i class="fab fa-facebook"></i>
                            </div>
                            <h5 class="card-title">Facebook Pixel</h5>
                            <p class="card-text">تتبع تحويلات الإعلانات وسلوك الزوار</p>
                            <div class="mb-3">
                                <label class="form-label">معرف Pixel</label>
                                <input type="text" class="form-control" placeholder="XXXXXXXXXXXXXXXXXX">
                            </div>
                            <div class="form-check form-switch mb-3 d-flex justify-content-center">
                                <input class="form-check-input ms-2" type="checkbox" checked="">
                                <label class="form-check-label">تفعيل التتبع</label>
                            </div>
                            <button class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </div>
                </div>

                <!-- Snapchat Pixel -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge bg-warning status-badge">غير مكتمل</span>
                        <div class="card-body text-center">
                            <div class="integration-icon text-warning">
                                <i class="fab fa-snapchat"></i>
                            </div>
                            <h5 class="card-title">Snapchat Pixel</h5>
                            <p class="card-text">تتبع حملات سناب شات الإعلانية</p>
                            <div class="mb-3">
                                <label class="form-label">معرف Pixel</label>
                                <input type="text" class="form-control" placeholder="XXXXXXXXXXXXXXXXXX">
                            </div>
                            <div class="form-check form-switch mb-3 d-flex justify-content-center">
                                <input class="form-check-input ms-2" type="checkbox">
                                <label class="form-check-label">تفعيل التتبع</label>
                            </div>
                            <button class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media Integration -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">تكامل وسائل التواصل الاجتماعي</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Instagram -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge bg-success status-badge">متصل</span>
                        <div class="card-body text-center">
                            <div class="integration-icon text-danger">
                                <i class="fab fa-instagram"></i>
                            </div>
                            <h5 class="card-title">Instagram</h5>
                            <p class="card-text">عرض منتجات المتجر على Instagram</p>
                            <button class="btn btn-outline-danger">إلغاء الربط</button>
                        </div>
                    </div>
                </div>

                <!-- TikTok -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge bg-secondary status-badge">غير متصل</span>
                        <div class="card-body text-center">
                            <div class="integration-icon text-dark">
                                <i class="fab fa-tiktok"></i>
                            </div>
                            <h5 class="card-title">TikTok</h5>
                            <p class="card-text">ربط المتجر مع حساب TikTok للأعمال</p>
                            <button class="btn btn-dark">ربط الحساب</button>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Business -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge bg-success status-badge">متصل</span>
                        <div class="card-body text-center">
                            <div class="integration-icon text-success">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <h5 class="card-title">WhatsApp Business</h5>
                            <p class="card-text">إدارة المحادثات وإشعارات الطلبات</p>
                            <div class="mb-3">
                                <input type="text" class="form-control" value="+966501234567" readonly="">
                            </div>
                            <button class="btn btn-outline-success">تحديث الرقم</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Gateways -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">بوابات الدفع</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- PayPal -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge bg-success status-badge">مفعل</span>
                        <div class="card-body text-center">
                            <div class="integration-icon text-primary">
                                <i class="fab fa-paypal"></i>
                            </div>
                            <h5 class="card-title">PayPal</h5>
                            <p class="card-text">استقبال المدفوعات عبر PayPal</p>
                            <div class="mb-3">
                                <label class="form-label">البريد الإلكتروني للحساب</label>
                                <input type="email" class="form-control" placeholder="email@example.com">
                            </div>
                            <div class="form-check form-switch mb-3 d-flex justify-content-center">
                                <input class="form-check-input ms-2" type="checkbox" checked="">
                                <label class="form-check-label">وضع الاختبار</label>
                            </div>
                            <button class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </div>
                </div>

                <!-- Stripe -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge bg-warning status-badge">غير مكتمل</span>
                        <div class="card-body text-center">
                            <div class="integration-icon text-info">
                                <i class="fab fa-stripe"></i>
                            </div>
                            <h5 class="card-title">Stripe</h5>
                            <p class="card-text">معالجة المدفوعات عبر Stripe</p>
                            <div class="mb-3">
                                <label class="form-label">مفتاح API العام</label>
                                <input type="text" class="form-control" placeholder="pk_test_XXXXXXXX">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">مفتاح API السري</label>
                                <input type="password" class="form-control" placeholder="sk_test_XXXXXXXX">
                            </div>
                            <button class="btn btn-info text-white">تفعيل الحساب</button>
                        </div>
                    </div>
                </div>

                <!-- Apple Pay -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge bg-secondary status-badge">غير مفعل</span>
                        <div class="card-body text-center">
                            <div class="integration-icon text-dark">
                                <i class="fab fa-apple-pay"></i>
                            </div>
                            <h5 class="card-title">Apple Pay</h5>
                            <p class="card-text">قبول المدفوعات عبر Apple Pay</p>
                            <button class="btn btn-dark">إعداد Apple Pay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Marketing -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">التسويق عبر البريد الإلكتروني</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Mailchimp -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge bg-success status-badge">مفعل</span>
                        <div class="card-body text-center">
                            <div class="integration-icon text-warning">
                                <i class="fab fa-mailchimp"></i>
                            </div>
                            <h5 class="card-title">Mailchimp</h5>
                            <p class="card-text">إدارة القوائم البريدية والحملات</p>
                            <div class="mb-3">
                                <label class="form-label">مفتاح API</label>
                                <input type="text" class="form-control" placeholder="XXXXXXXXXX">
                            </div>
                            <button class="btn btn-warning text-white">تحديث الإعدادات</button>
                        </div>
                    </div>
                </div>

                <!-- SendGrid -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge bg-secondary status-badge">غير مفعل</span>
                        <div class="card-body text-center">
                            <div class="integration-icon text-primary">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5 class="card-title">SendGrid</h5>
                            <p class="card-text">إرسال رسائل البريد الإلكتروني التلقائية</p>
                            <button class="btn btn-primary">ربط الحساب</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>