<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-user-gear text-warning"></i>
                    <span class="fw-semibold">{{ __('إعدادات الحساب والملف الشخصي') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    الملف الشخصي وإعدادات الحساب 👤
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    إدارة بياناتك الشخصية، معلومات المتجر، إعدادات الأمان، وتفاصيل حسابات الدفع والبنك.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('seller.dashboard') }}"
                    class="btn btn-light text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                    <i class="fas fa-arrow-right"></i>
                    <span>لوحة التحكم</span>
                </a>
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10"
            style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);">
        </div>
        <div class="position-absolute rounded-circle bg-warning opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    <!-- Alert Notifications -->
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3 p-3 mb-4">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 p-3 mb-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <span class="fw-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 p-3 mb-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                <span class="fw-semibold">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Sidebar - الصورة الشخصية ونسبة الاكتمال -->
        <div class="col-12 col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 text-center sticky-top" style="top: 20px;">
                <!-- صورة الملف مع تأثيرات -->
                <div class="avatar-upload mb-3 position-relative mx-auto" style="width: 120px; height: 120px;">
                    <img id="avatarPreview"
                        src="{{ is_seller_has_avatar($seller->tenant_id) ? $seller->avatar : asset('asset/v1/users/dashboard/img/avatars/man.png') }}"
                        class="rounded-circle border border-4 border-white shadow-sm" alt="صورة الملف الشخصي"
                        style="width: 100%; height: 120px; object-fit: cover;">
                    <form enctype="multipart/form-data">
                        <input id="avatarInput" type="file" name="avatar_Image" style="display: none;">
                    </form>
                    <button id="avataruploadbtn"
                        class="btn btn-seller-primary position-absolute bottom-0 end-0 rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 36px; height: 36px;">
                        <i class="fas fa-camera fs-6"></i>
                    </button>
                </div>

                <!-- معلومات المستخدم -->
                <h5 class="fw-bold text-dark mb-1">{{ $seller->full_name }}</h5>
                <p class="text-muted small mb-3">
                    <i class="fas fa-envelope me-1 text-plum"></i> {{ $user->email }}
                </p>

                <!-- مستوى اكتمال الملف (متوافق 100% مع progress_bar_js.blade.php) -->
                <div class="progress-wrapper p-3 bg-light-subtle rounded-4 border mb-3">
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="fw-bold text-dark">اكتمال الملف</span>
                        <span class="text-primary fw-bold">75%</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 8px;">
                        <div class="progress-bar bg-primary progress-bar-striped" style="width: 75%"></div>
                    </div>
                </div>

                <!-- Request Validation Action -->
                @if ($seller->approval_status != 'approved')
                    <div class="pt-2">
                        <form id="requestValidationForm" action="{{ route('seller.profile.request.validation') }}" method="POST">
                            @csrf
                        </form>
                        <button id="submit-validation-request" type="submit" class="btn btn-seller-primary w-100 rounded-3 py-2 fw-bold shadow-sm">
                            <i class="fa-solid fa-shield-check me-1"></i> طلب توثيق الحساب
                        </button>
                    </div>
                @else
                    <div class="d-inline-flex align-items-center gap-1.5 px-3 py-1.5 bg-success-subtle text-success border border-success border-opacity-25 rounded-pill small fw-bold">
                        <i class="fa-solid fa-circle-check"></i> حسابك موثق ومفعل
                    </div>
                @endif
            </div>
        </div>

        <!-- Main Content Panel -->
        <div class="col-12 col-lg-8 col-xl-9">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                <!-- Navigation Tabs Header -->
                <div class="card-header bg-light-subtle border-bottom p-3">
                    <ul class="nav nav-pills gap-2" id="profile-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-3 fw-bold px-3.5 py-2.5 active" id="personal-tab" data-bs-toggle="pill"
                                data-bs-target="#personal" type="button">
                                <i class="fas fa-user me-1.5 text-plum"></i> المعلومات الأساسية
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-3 fw-bold px-3.5 py-2.5" id="security-tab" data-bs-toggle="pill"
                                data-bs-target="#security" type="button">
                                <i class="fas fa-lock me-1.5 text-danger"></i> الأمان وكلمة المرور
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-3 fw-bold px-3.5 py-2.5" id="chargily-tab" data-bs-toggle="pill"
                                data-bs-target="#chargily" type="button">
                                <i class="fas fa-credit-card me-1.5 text-primary"></i> حساب شارجيلي
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-3 fw-bold px-3.5 py-2.5" id="bank-tab" data-bs-toggle="pill"
                                data-bs-target="#bank" type="button">
                                <i class="fas fa-bank me-1.5 text-success"></i> حسابي البنكي / CCP
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="tab-content" id="profile-tabContent">
                        <!-- Personal Info Tab -->
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <form action="{{ route('seller.profile.update') }}" method="POST" class="row g-4" enctype="multipart/form-data">
                                @csrf
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">الاسم الكامل</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                        <input name="full_name" type="text" class="form-control border-start-0" value="{{ $seller->full_name }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">اللقب</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-user-tag text-muted"></i></span>
                                        <input name="last_name" type="text" class="form-control border-start-0" value="{{ $seller->last_name }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">الإسم الأول</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                        <input name="first_name" type="text" class="form-control border-start-0" value="{{ $seller->first_name }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">البريد الإلكتروني</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                        <input type="email" name="email" class="form-control border-start-0" value="{{ $user->email }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">رقم الهاتف</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                                        <input type="tel" name="phone" class="form-control border-start-0" value="{{ $user->phone }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">الجنس</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-venus-mars text-muted"></i></span>
                                        <select class="form-select border-start-0" name="sex" id="sex">
                                            <option value="null">غير محددة</option>
                                            <option value="male" {{ $seller->sex == 'male' ? 'selected' : '' }}>ذكر</option>
                                            <option value="female" {{ $seller->sex == 'female' ? 'selected' : '' }}>انثى</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">تاريخ الميلاد</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar-day text-muted"></i></span>
                                        <input type="date" class="form-control border-start-0" name="birth_date" id="birth_date"
                                            value="{{ $seller->birth_date ?? '' }}" max="{{ now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">قائمة التجار الموثوقين</label>
                                    <div class="p-2.5 border rounded-3 bg-light-subtle d-flex align-items-center gap-3">
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input cursor-pointer" type="checkbox"
                                                id="approved_list_chekbox" name="part_of_approved_list"
                                                {{ $seller->part_of_approved_list == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold text-dark small cursor-pointer" for="approved_list_chekbox">تفعيل الظهور في القائمة</label>
                                        </div>
                                    </div>
                                    <small class="text-muted fs-7 mt-1 d-block">إذا كنت ترغب في أن يظهر اسمك واسم متجرك على المنصة قم بتفعيل هذا الخيار.</small>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">اسم المتجر</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-store text-muted"></i></span>
                                        <input type="text" name="store_name" class="form-control border-start-0" value="{{ $seller->store_name }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">الولاية</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                        <select id="inputWilaya" name="wilaya" class="form-select border-start-0 @error('wilaya') is-invalid @enderror">
                                            <option value="null" selected>إختر الولاية...</option>
                                            @foreach ($wilayas as $wilaya)
                                                <option value="{{ $wilaya->id }}"
                                                    {{ old('wilaya') == $wilaya->id || $seller->wilaya == $wilaya->id ? 'selected' : '' }}>
                                                    {{ get_wilaya_data($wilaya->id)->ar_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('wilaya')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">الدائرة</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-map-marked-alt text-muted"></i></span>
                                        <select id="inputDayra" name="dayra" class="form-select border-start-0 @error('dayra') is-invalid @enderror">
                                            <option value="null" selected>إختر البلدية...</option>
                                            @if ($seller->dayra !== null)
                                                <option value="{{ $seller->dayra }}" selected>
                                                    {{ get_dayra_data($seller->dayra)->ar_name }}</option>
                                            @else
                                                <option value="null">...</option>
                                            @endif
                                        </select>
                                        @error('dayra')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">البلدية</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-map-pin text-muted"></i></span>
                                        <select id="inputBaladia" class="form-select border-start-0" name="baladia">
                                            <option value="null">غير محددة</option>
                                            @if ($seller->baladia !== null)
                                                <option value="{{ $seller->baladia }}" selected>
                                                    {{ get_baladia_data($seller->baladia)->ar_name }}</option>
                                            @else
                                                <option value="null">...</option>
                                            @endif
                                            <option value="null">...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark small">العنوان الكامل</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-map-marked-alt text-muted"></i></span>
                                        <textarea name="address" class="form-control border-start-0" rows="3" placeholder="العنوان التفصيلي...">{{ $seller->address }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark small">صورة بطاقة التعريف الوطنية (أو جواز السفر)</label>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-id-card text-muted"></i></span>
                                        <input type="file" class="form-control border-start-0" name="id_card_image" id="id_card_image" accept="image/*">
                                    </div>
                                    <small class="text-muted fs-7">مطلوبة لتوثيق حسابك وتفعيل خدمة الدفع Chargily و BaridiMob و CCP.</small>
                                </div>
                                @if ($seller->id_card_image != null)
                                    <div class="col-12 text-center">
                                        <div class="p-2 border rounded-4 bg-light-subtle d-inline-block shadow-sm">
                                            <img src="{{ $seller->id_card_image }}" alt="وثيقة الهوية" class="img-fluid rounded-3" style="max-height: 200px; object-fit: contain;">
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-seller-primary px-5 py-2.5 rounded-3 fw-bold shadow-sm">
                                        <i class="fas fa-save me-1"></i> حفظ التغييرات
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Security Tab -->
                        <div class="tab-pane fade" id="security" role="tabpanel">
                            <form action="{{ route('seller.profile.password.update') }}" method="POST" class="row g-4">
                                @csrf
                                <div class="col-12">
                                    <div class="alert alert-info border-0 rounded-3 bg-plum-subtle text-plum p-3">
                                        <i class="fas fa-info-circle me-1"></i> اترك الحقول فارغة إذا كنت لا تريد تغيير كلمة المرور الحالية.
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">كلمة المرور الحالية</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                        <input name="old_password" type="password"
                                            class="form-control border-start-0 border-end-0 @error('old_password') is-invalid @enderror"
                                            value="{{ old('old_password') }}">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('old_password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">كلمة المرور الجديدة</label>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                        <input name="password" type="password"
                                            class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                            value="{{ old('password') }}">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted fs-7">8 أحرف على الأقل مع رموز وأرقام.</small>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">تأكيد كلمة المرور الجديدة</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                        <input name="password_confirmation" type="password"
                                            class="form-control border-start-0 border-end-0 @error('password_confirmation') is-invalid @enderror"
                                            value="{{ old('password_confirmation') }}">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-seller-primary px-5 py-2.5 rounded-3 fw-bold shadow-sm">
                                        <i class="fas fa-lock me-1"></i> تحديث كلمة المرور
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Chargily Tab -->
                        <div class="tab-pane fade" id="chargily" role="tabpanel">
                            <form action="{{ route('seller.profile.chargily-settings.update') }}" method="POST" class="row g-4">
                                @csrf
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">المفتاح العام (Public key)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                                        <input type="text" name="public_key" class="form-control border-start-0"
                                            @if ($chargily_settings != null) value="{{ $chargily_settings->public_key }}" @endif>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">المفتاح السري (Secret key)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                                        <input type="text" name="secret_key" class="form-control border-start-0"
                                            @if ($chargily_settings != null) value="{{ $chargily_settings->secret_key }}" @endif>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">وضع التشغيل (Live / Test Mode)</label>
                                    <div class="p-2.5 border rounded-3 bg-light-subtle d-flex align-items-center gap-3">
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input cursor-pointer" type="checkbox" name="mode"
                                                id="flexSwitchCheckDefault"
                                                @if ($chargily_settings != null && $chargily_settings->mode == 'live') checked @endif>
                                            <label class="form-check-label fw-bold text-dark small cursor-pointer" for="flexSwitchCheckDefault">Live Mode (وضع الحقيقي)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-seller-primary w-100 rounded-3 py-2.5 fw-bold shadow-sm">
                                        <i class="fas fa-save me-1"></i> حفظ إعدادات Chargily
                                    </button>
                                </div>
                            </form>
                            @if ($chargily_settings != null)
                                <form action="{{ route('seller.profile.chargily-settings.delete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100 rounded-3 py-2.5 fw-bold mt-3"
                                        onsubmit="return confirm('هل أنت متأكد من حذف حساب Chargily؟')">
                                        <i class="fas fa-trash me-1"></i> حذف حساب Chargily
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Bank Tab -->
                        <div class="tab-pane fade" id="bank" role="tabpanel">
                            <form action="{{ route('seller.profile.bank-settings.update') }}" method="POST" class="row g-4">
                                @csrf
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">الاسم الكامل للحساب البنكي</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                        <input type="text" name="name" class="form-control border-start-0"
                                            @if ($bank_settings != null) value="{{ $bank_settings->name }}" @endif
                                            placeholder="اسمك الحقيقي في البنك...">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">اسم البنك / المؤسسة</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-bank text-muted"></i></span>
                                        <input type="text" name="bank_name" class="form-control border-start-0"
                                            @if ($bank_settings != null) value="{{ $bank_settings->bank_name }}" @endif
                                            placeholder="مثال: بريد الجزائر (CCP)، BNA، BEA ...">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold text-dark small">رقم الحساب (RIP / RIB)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                                        <input type="text" name="account_number" class="form-control border-start-0"
                                            @if ($bank_settings != null) value="{{ $bank_settings->account_number }}" @endif
                                            placeholder="Rip: 007779999XXXXXXX">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-seller-primary w-100 rounded-3 py-2.5 fw-bold shadow-sm">
                                        <i class="fas fa-save me-1"></i> حفظ البيانات البنكية
                                    </button>
                                </div>
                            </form>

                            @if ($bank_settings != null)
                                <form action="{{ route('seller.profile.bank-settings.delete') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100 rounded-3 py-2.5 fw-bold mt-3"
                                        onsubmit="return confirm('هل أنت متأكد من حذف البيانات البنكية؟')">
                                        <i class="fas fa-trash me-1"></i> حذف البيانات البنكية
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-plum-subtle {
        background-color: rgba(164, 12, 114, 0.1);
    }

    .border-plum-subtle {
        border-color: rgba(164, 12, 114, 0.25) !important;
    }

    .text-plum {
        color: #a40c72 !important;
    }

    .bg-plum-gradient {
        background: linear-gradient(135deg, #a40c72 0%, #790b54 100%) !important;
    }

    .btn-seller-primary {
        background: linear-gradient(135deg, #a40c72 0%, #790b54 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }

    .btn-seller-primary:hover {
        background: linear-gradient(135deg, #790b54 0%, #5b073e 100%) !important;
        color: #ffffff !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .avatar-upload {
        transition: transform 0.3s ease;
    }

    .avatar-upload:hover {
        transform: scale(1.03);
    }

    /* Style Nav Pills Tabs */
    #profile-tab .nav-link {
        color: #475569;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    #profile-tab .nav-link.active {
        color: #ffffff !important;
        background: linear-gradient(135deg, #a40c72 0%, #790b54 100%) !important;
        border-color: transparent !important;
        box-shadow: 0 4px 10px rgba(164, 12, 114, 0.25);
    }

    #profile-tab .nav-link.active i {
        color: #ffffff !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                const icon = this.querySelector('i');
                if (icon) {
                    icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
                }
            });
        });

        // Check if we should activate specific tabs
        const shouldActivateSecurityTab = {{ session()->has('activate_security_tab') ? 'true' : 'false' }};
        const shouldActivateChargilyTab = {{ session()->has('activate_chargily_tab') ? 'true' : 'false' }};
        const shouldActivatebankTab = {{ session()->has('activate_bank_tab') ? 'true' : 'false' }};

        if (shouldActivateSecurityTab) {
            const securityTab = document.getElementById('security-tab');
            const securityPane = document.getElementById('security');

            document.querySelectorAll('#profile-tab .nav-link').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));

            securityTab.classList.add('active');
            securityPane.classList.add('show', 'active');
            securityTab.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else if (shouldActivateChargilyTab) {
            const chargilyTab = document.getElementById('chargily-tab');
            const chargilyPane = document.getElementById('chargily');

            document.querySelectorAll('#profile-tab .nav-link').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));

            chargilyTab.classList.add('active');
            chargilyPane.classList.add('show', 'active');
            chargilyTab.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else if (shouldActivatebankTab) {
            const bankTab = document.getElementById('bank-tab');
            const bankPane = document.getElementById('bank');

            document.querySelectorAll('#profile-tab .nav-link').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));

            bankTab.classList.add('active');
            bankPane.classList.add('show', 'active');
            bankTab.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        // Clear the activation flag from session
        @if (session()->has('activate_security_tab'))
            fetch('{{ route('seller.clear.tab.flag') }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        @endif
    });
</script>
