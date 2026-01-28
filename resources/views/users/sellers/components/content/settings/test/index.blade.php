<div class="container">
    <h1 class="h3 mb-0 text-gray-800">إعدادات النظام</h1>
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general" aria-selected="true" role="tab">
                        <i class="fas fa-store me-2"></i>إعدادات المتجر
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#shipping" aria-selected="false" tabindex="-1" role="tab">
                        <i class="fas fa-truck me-2"></i>الشحن والتوصيل
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#payment" aria-selected="false" tabindex="-1" role="tab">
                        <i class="fas fa-credit-card me-2"></i>طرق الدفع
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#email" aria-selected="false" tabindex="-1" role="tab">
                        <i class="fas fa-envelope me-2"></i>إعدادات البريد
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#appearance" aria-selected="false" tabindex="-1" role="tab">
                        <i class="fas fa-paint-brush me-2"></i>المظهر
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#security" aria-selected="false" tabindex="-1" role="tab">
                        <i class="fas fa-shield-alt me-2"></i>الأمان
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-4" id="settingsTabContent">
                <!-- General Settings -->
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">اسم المتجر</label>
                                <input type="text" class="form-control" value="المتجر الإلكتروني">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">شعار المتجر</label>
                                <input type="file" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">عملة المتجر</label>
                                <select class="form-select">
                                    <option>ريال سعودي (SAR)</option>
                                    <option>دولار أمريكي (USD)</option>
                                    <option>يورو (EUR)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">المنطقة الزمنية</label>
                                <select class="form-select">
                                    <option>توقيت مكة المكرمة (UTC+3)</option>
                                    <option>توقيت جرينتش (UTC)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">عنوان المتجر</label>
                                <textarea class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="tel" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الضريبة (%)</label>
                                <input type="number" class="form-control" value="15">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Settings -->
                <div class="tab-pane fade" id="shipping" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">شركات الشحن</label>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label">أرامكس</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label">DHL</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input">
                                    <label class="form-check-label">فيديكس</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">تكلفة الشحن الافتراضية</label>
                                <input type="number" class="form-control" value="30">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">مناطق التوصيل</label>
                                <select class="form-select" multiple="" size="5">
                                    <option selected="">الرياض</option>
                                    <option selected="">جدة</option>
                                    <option selected="">الدمام</option>
                                    <option>مكة</option>
                                    <option>المدينة</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الشحن المجاني للطلبات فوق</label>
                                <input type="number" class="form-control" value="500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div class="tab-pane fade" id="payment" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">بوابات الدفع</label>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label">مدى</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label">فيزا/ماستركارد</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label">آبل باي</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label">الدفع عند الاستلام</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">معرف التاجر</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">المفتاح السري</label>
                                <input type="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">وضع التشغيل</label>
                                <select class="form-select">
                                    <option>تجريبي</option>
                                    <option>إنتاج</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Settings -->
                <div class="tab-pane fade" id="email" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">خادم SMTP</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">المنفذ</label>
                                <input type="number" class="form-control" value="587">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">اسم المستخدم</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">كلمة المرور</label>
                                <input type="password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">البريد المرسل</label>
                                <input type="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">اسم المرسل</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">تشفير SSL</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label">تفعيل</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appearance Settings -->
                <div class="tab-pane fade" id="appearance" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">النمط</label>
                                <select class="form-select">
                                    <option>فاتح</option>
                                    <option>داكن</option>
                                    <option>تلقائي</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">اللون الرئيسي</label>
                                <input type="color" class="form-control form-control-color" value="#4e73df">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الخط</label>
                                <select class="form-select">
                                    <option>Tajawal</option>
                                    <option>Cairo</option>
                                    <option>Almarai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">حجم الخط</label>
                                <select class="form-select">
                                    <option>صغير</option>
                                    <option selected="">متوسط</option>
                                    <option>كبير</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">تخطيط القائمة</label>
                                <select class="form-select">
                                    <option>ثابت</option>
                                    <option selected="">قابل للطي</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">الأيقونات</label>
                                <select class="form-select">
                                    <option selected="">Font Awesome</option>
                                    <option>Material Icons</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="tab-pane fade" id="security" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">المصادقة الثنائية</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input">
                                    <label class="form-check-label">تفعيل</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">مدة الجلسة (دقيقة)</label>
                                <input type="number" class="form-control" value="30">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">حظر IP بعد</label>
                                <input type="number" class="form-control" value="5">
                                <small class="text-muted">عدد المحاولات الفاشلة</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">تعقيد كلمة المرور</label>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label">أحرف كبيرة وصغيرة</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label">أرقام</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label">رموز خاصة</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked="">
                                    <label class="form-check-label">8 أحرف على الأقل</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">تغيير كلمة المرور كل</label>
                                <select class="form-select">
                                    <option>30 يوم</option>
                                    <option>60 يوم</option>
                                    <option>90 يوم</option>
                                    <option selected="">لا يلزم</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary" id="saveSettings">
            <i class="fas fa-save me-2"></i>حفظ التغييرات
        </button>
    </div>
</div>