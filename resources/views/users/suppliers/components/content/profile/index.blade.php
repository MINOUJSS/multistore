<div class="container py-4">
    <div class="row">
        <!-- Sidebar - تصميم جانبي حديث -->
        <div class="col-lg-3 mb-4">
            <div class="profile-sidebar bg-white rounded-4 shadow-sm p-4 sticky-top" style="top: 20px;">
                <div class="text-center">
                    <!-- صورة الملف مع تأثيرات -->
                    <div class="avatar-upload mb-3 position-relative mx-auto" style="width: 120px;">
                        
                        <img id="avatarPreview"
                            src="{{ is_supplier_has_avatar($supplier->tenant_id) ? $supplier->avatar : asset('asset/v1/users/dashboard/img/avatars/man.png') }}"
                            class="rounded-circle border border-4 border-white shadow" alt="صورة الملف الشخصي"
                            style="width: 100%; height: 120px; object-fit: cover;">
                        <form enctype="multipart/form-data">
                            <input id="avatarInput" type="file" name="avatar_Image" style="display: none;">
                        </form>
                        <button id="avataruploadbtn"
                            class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle p-2"
                            style="width: 36px; height: 36px;">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <!-- معلومات المستخدم -->
                    <h4 class="fw-bold mb-1">{{ $supplier->full_name }}</h4>
                    <p class="text-muted mb-3">
                        <i class="fas fa-envelope me-2"></i> {{ $user->email }}
                    </p>

                    <!-- مستوى اكتمال الملف -->
                    <div class="progress-wrapper mb-4">
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="fw-medium">اكتمال الملف</span>
                            <span class="text-primary fw-bold">75%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary progress-bar-striped" style="width: 75%"></div>
                        </div>
                    </div>
                </div>

                {{-- <!-- قائمة التنقل -->
                <nav class="nav flex-column gap-2">
                    <a href="#" class="nav-link active bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                        <i class="fas fa-user-circle me-2"></i> الملف الشخصي
                    </a>
                    <a href="#" class="nav-link text-dark rounded-3 p-3">
                        <i class="fas fa-shopping-bag me-2"></i> طلباتي
                    </a>
                    <a href="#" class="nav-link text-dark rounded-3 p-3">
                        <i class="fas fa-heart me-2"></i> المفضلة
                    </a>
                    <a href="#" class="nav-link text-dark rounded-3 p-3">
                        <i class="fas fa-map-marker-alt me-2"></i> العناوين
                    </a>
                    <a href="#" class="nav-link text-dark rounded-3 p-3">
                        <i class="fas fa-lock me-2"></i> الأمان
                    </a>
                </nav> --}}
            </div>
        </div>

        <!-- Main Content - محتوى رئيسي حديث -->
        <div class="col-lg-9">
            <div class="profile-content bg-white rounded-4 shadow-sm overflow-hidden">
                <!-- Header with Gradient Background -->
                <div class="profile-header bg-gradient-primary text-white p-4">
                    <h3 class="fw-bold mb-0"><i class="fas fa-user-edit me-2"></i> تعديل الملف الشخصي</h3>
                </div>

                <!-- Tab Content - تصميم حديث للألسنة -->
                <div class="p-4">
                    <!-- Display general form errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Display success message if exists -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Display error message if exists -->
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <ul class="nav nav-pills mb-4" id="profile-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="pill"
                                data-bs-target="#personal" type="button">
                                <i class="fas fa-user me-2"></i> المعلومات الأساسية
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="security-tab" data-bs-toggle="pill" data-bs-target="#security"
                                type="button">
                                <i class="fas fa-lock me-2"></i> الأمان
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="chargily-tab" data-bs-toggle="pill" data-bs-target="#chargily"
                                type="button">
                                <i class="fas fa-credit-card me-2"></i> حساب شارجيلي
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bank-tab" data-bs-toggle="pill" data-bs-target="#bank"
                                type="button">
                                <i class="fas fa-bank me-2"></i> حسابي البنكي
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="profile-tabContent">
                        <!-- Personal Info Tab -->
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <form action="{{ route('supplier.profile.update') }}" method="POST" class="row g-4"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">الاسم الكامل</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                        <input name="full_name" type="text" class="form-control"
                                            value="{{ $supplier->full_name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">اللقب</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-user-tag"></i></span>
                                        <input name="last_name" type="text" class="form-control"
                                            value="{{ $supplier->last_name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">الإسم</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                        <input name="first_name" type="text" class="form-control"
                                            value="{{ $supplier->first_name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">البريد الإلكتروني</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" value="{{ $user->email }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">رقم الهاتف</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                        <input type="tel" name="phone" class="form-control"
                                            value="{{ $user->phone }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">الجنس</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i
                                                class="fas fa-venus-mars"></i></span>
                                        <select class="form-select" name="sex" id="sex">
                                            <option value="null">غير محددة</option>
                                            <option value="male" {{ $supplier->sex == 'male' ? 'selected' : '' }}>
                                                ذكر
                                            </option>
                                            <option value="female" {{ $supplier->sex == 'female' ? 'selected' : '' }}>
                                                انثى</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">تاريخ الميلاد</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i
                                                class="fas fa-calendar-day"></i></span>
                                        <input type="date" class="form-control" name="birth_date" id="birth_date"
                                            value="{{ $supplier->birth_date ?? '' }}"
                                            max="{{ now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">قائمة التجار الموثوقين</label>
                                    <div class="input-group">

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                id="approved_list_chekbox" name="part_of_approved_list"
                                                {{ $supplier->part_of_approved_list == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="part_of_approved_list">تفعيل</label>
                                        </div>
                                    </div>
                                    <small class="text-muted">إذا كنت ترغب في أن يظهر إسمك و إسم متجرك على منصتنا قم
                                        بتفعيل هذا الخيار</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">إسم المتجر</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-store"></i></span>
                                        <input type="taxt" name="store_name" class="form-control"
                                            value="{{ $supplier->store_name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">الولاية</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i
                                                class="fas fa-map-marker-alt"></i></span>
                                        <select id="inputWilaya" name="wilaya"
                                            class="form-select @error('wilaya') is-invalid @enderror">
                                            <option value="null" selected>إختر الولاية...</option>
                                            @foreach ($wilayas as $wilaya)
                                                <option value="{{ $wilaya->id }}"
                                                    {{ old('wilaya') == $wilaya->id || $supplier->wilaya == $wilaya->id ? 'selected' : '' }}>
                                                    {{ get_wilaya_data($wilaya->id)->ar_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('wilaya')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">الدائرة</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i
                                                class="fas fa-map-marked-alt"></i></span>
                                                {{-- {{dd($supplier->dayra);}} --}}
                                        <select id="inputDayra" name="dayra"
                                            class="form-select @error('dayra') is-invalid @enderror">
                                            <option value="null" selected>إختر البلدية...</option>
                                            @if ($supplier->dayra !== null)
                                                <option value="{{ $supplier->dayra }}" selected>
                                                    {{ get_dayra_data($supplier->dayra)->ar_name }}</option>
                                            @else
                                                <option value="null">...</option>
                                            @endif
                                        </select>
                                        @error('dayra')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">البلدية</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-map-pin"></i></span>
                                        <select id="inputBaladia" class="form-select" name="baladia" id="baladia">
                                            <option value="null">غير محددة</option>
                                            @if ($supplier->baladia !== null)
                                                <option value="{{ $supplier->baladia }}" selected>
                                                    {{ get_baladia_data($supplier->baladia)->ar_name }}</option>
                                            @else
                                                <option value="null">...</option>
                                            @endif
                                            <option value="null">...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-medium">العنوان</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i
                                                class="fas fa-map-marked-alt"></i></span>
                                        <textarea name="address" class="form-control" rows="3" placeholder="العنوان...">{{ $supplier->address }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-medium">صورة بطاقة التعريف الوطنية(جواز السفر)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-id-card"></i></span>
                                        <input type="file" class="form-control" name="id_card_image"
                                            id="id_card_image" accept="image/*">
                                    </div>
                                    <small class="text-muted">مطلوبة لتوثيق حسابك و تفعيل خدمة الدفع شارجلي و بريدي موب
                                        و ccp</small>
                                </div>
                                @if ($supplier->id_card_image != null)
                                    <div class="col-12 text-center">
                                        <img src="{{ $supplier->id_card_image }}" alt="وثيقة الهوية" width="300px">
                                    </div>
                                @endif
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-4 py-2 fw-medium">
                                        <i class="fas fa-save me-2"></i> حفظ التغييرات
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Security Tab -->
                        <div class="tab-pane fade" id="security" role="tabpanel">
                            <form action="{{ route('supplier.profile.password.update') }}" method="POST"
                                class="row g-4">
                                @csrf
                                <div class="col-12">
                                    <div class="alert alert-info border-0 bg-light-info">
                                        <i class="fas fa-info-circle me-2"></i> اترك الحقول فارغة إذا كنت لا تريد تغيير
                                        كلمة المرور
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">كلمة المرور الحالية</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                        <input name="old_password" type="password"
                                            class="form-control @error('old_password') is-invalid @enderror"
                                            value="{{ old('old_password') }}">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('old_password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">كلمة المرور الجديدة</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                        <input name="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            value="{{ old('password') }}">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">8 أحرف على الأقل مع رموز وأرقام</small>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">تأكيد كلمة المرور</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                        <input name="password_confirmation" type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            value="{{ old('password_confirmation') }}">
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-4 py-2 fw-medium">
                                        <i class="fas fa-lock me-2"></i> تحديث كلمة المرور
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- chargily Tab -->
                        <div class="tab-pane fade" id="chargily" role="tabpanel">

                            <form action="{{ route('supplier.profile.chargily-settings.update') }}" method="POST"
                                class="row g-4">
                                @csrf
                                {{-- <div class="col-12">
                                    <div class="alert alert-info border-0 bg-light-info">
                                        <i class="fas fa-info-circle me-2"></i> اترك الحقول فارغة إذا كنت لا تريد تغيير
                                        كلمة المرور
                                    </div>
                                </div> --}}

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">المفتاح العام (Public key)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-key"></i></span>
                                        <input type="text" name="public_key" class="form-control"
                                            @if ($chargily_settings != null) value="{{ $chargily_settings->public_key }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">المفتاح السري (Secret key)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-key"></i></span>
                                        <input type="text" name="secret_key" class="form-control"
                                            @if ($chargily_settings != null) value="{{ $chargily_settings->secret_key }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Live Or Test Mode</label>
                                    <div class="input-group">

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="mode"
                                                id="flexSwitchCheckDefault"
                                                @if ($chargily_settings != null && $chargily_settings->mode == 'live') checked @endif>
                                            <label class="form-check-label" for="flexSwitchCheckDefault">Live
                                                Mode</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-4 py-2 fw-medium">
                                        <i class="fas fa-save me-2"></i> حفظ
                                    </button>
                                </div>
                            </form>

                        </div>

                        <!-- bank Tab -->
                        <div class="tab-pane fade" id="bank" role="tabpanel">

                            <form action="{{ route('supplier.profile.bank-settings.update') }}" method="POST"
                                class="row g-4">
                                @csrf
                                {{-- <div class="col-12">
                                    <div class="alert alert-info border-0 bg-light-info">
                                        <i class="fas fa-info-circle me-2"></i> اترك الحقول فارغة إذا كنت لا تريد تغيير
                                        كلمة المرور
                                    </div>
                                </div> --}}

                                <div class="col-md-6">
                                    <label class="form-label fw-medium">الإسم</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                        <input type="text" name="name" class="form-control"
                                            @if ($bank_settings != null) value="{{ $bank_settings->name }}" @endif
                                            placeholder="اسمك الحقيقي في البنك">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">اسم البنك</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-bank"></i></span>
                                        <input type="text" name="bank_name" class="form-control"
                                            @if ($bank_settings != null) value="{{ $bank_settings->bank_name }}" @endif
                                            placeholder="مثال: بريد الجزائر(CCP) ... إلخ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium"> رقم الحساب</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-key"></i></span>
                                        <input type="text" name="account_number" class="form-control"
                                            @if ($bank_settings != null) value="{{ $bank_settings->account_number }}" @endif
                                            placeholder="Rip: 007779999XXXXXXX">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-4 py-2 fw-medium">
                                        <i class="fas fa-save me-2"></i> حفظ
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS الإضافي -->
<style>
    .profile-sidebar {
        border-left: 4px solid #0d6efd;
    }

    .profile-header {
        background: linear-gradient(135deg, #0d6efd, #0dcaf0);
    }

    .nav-pills .nav-link.active {
        background-color: #0d6efd;
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
    }

    .avatar-upload {
        transition: all 0.3s ease;
    }

    .avatar-upload:hover {
        transform: scale(1.05);
    }

    .nav-link {
        transition: all 0.2s ease;
    }

    .nav-link:hover {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>

{{-- <!-- JavaScript للتفاعلات -->
<script>
    // تبديل رؤية كلمة المرور
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                '<i class="fas fa-eye-slash"></i>';
        });
    });
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if we should activate the store settings tab
        const shouldActivateSecurityTab = {{ session()->has('activate_security_tab') ? 'true' : 'false' }};
        const shouldActivateChargilyTab = {{ session()->has('activate_chargily_tab') ? 'true' : 'false' }};
        const shouldActivatebankTab = {{ session()->has('activate_bank_tab') ? 'true' : 'false' }};

        if (shouldActivateSecurityTab) {
            // Get the tab and pane elements
            const securityTab = document.getElementById('security-tab');
            const securityPane = document.getElementById('security');

            // Remove active classes from all tabs/panes
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });

            // Add active classes to store settings tab
            securityTab.classList.add('active');
            securityPane.classList.add('show', 'active');

            // Scroll to the tab if needed
            securityTab.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        } else if (shouldActivateChargilyTab) {
            // Get the tab and pane elements
            const chargilyTab = document.getElementById('chargily-tab');
            const chargilyPane = document.getElementById('chargily');

            // Remove active classes from all tabs/panes
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });

            // Add active classes to store settings tab
            chargilyTab.classList.add('active');
            chargilyPane.classList.add('show', 'active');

            // Scroll to the tab if needed
            chargilyTab.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        } else if (shouldActivatebankTab) {
            // Get the tab and pane elements
            const bankTab = document.getElementById('bank-tab');
            const bankPane = document.getElementById('bank');

            // Remove active classes from all tabs/panes
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });

            // Add active classes to store settings tab
            bankTab.classList.add('active');
            bankPane.classList.add('show', 'active');

            // Scroll to the tab if needed
            bankTab.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }

        // Clear the activation flag from session
        @if (session()->has('activate_security_tab'))
            fetch('{{ route('supplier.clear.tab.flag') }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        @endif
    });
</script>
