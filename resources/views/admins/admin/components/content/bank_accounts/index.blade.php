<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm"
         style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-7 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-building-columns text-warning"></i>
                    <span>{{ __('إدارة الحسابات المالية للمنصة') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🏦 الحسابات البنكية للمنصة 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start fs-6">
                    إدارة حسابات بريدي موب، CCP، ومختلف الحسابات البنكية الجزائرية المعتمدة لاستقبال مدفوعات شحن الرصيد والاشتراكات.
                </p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <button type="button" class="btn btn-warning text-dark fw-bold px-3 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2"
                            data-bs-toggle="modal" data-bs-target="#addBankAccountModal">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>إضافة حساب بنكي جديد</span>
                    </button>

                    <button type="button" class="btn btn-outline-light text-white fw-bold px-3 py-2.5 rounded-3 border-2 shadow-sm d-inline-flex align-items-center gap-2" onclick="location.reload();">
                        <i class="fa-solid fa-rotate-right"></i>
                        <span>تحديث</span>
                    </button>

                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2.5 rounded-3 border-2 shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-house"></i>
                        <span>الرئيسية</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 280px; height: 280px; top: -60px; left: -60px; pointer-events: none; filter: blur(50px);"></div>
        <div class="position-absolute rounded-circle bg-warning opacity-10" style="width: 200px; height: 200px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(40px);"></div>
    </div>

    <!-- Session Feedback Alerts -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4 p-3 d-flex align-items-center gap-3">
            <div class="avatar-sm rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                <i class="fa-solid fa-check fs-6"></i>
            </div>
            <div class="flex-grow-1 fw-bold text-dark">
                {{ session()->get('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4 p-3">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="fa-solid fa-triangle-exclamation text-danger fs-5"></i>
                <h6 class="mb-0 fw-bold text-danger">يرجى تصحيح الأخطاء التالية:</h6>
            </div>
            <ul class="mb-0 small ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- KPI Stat Cards -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Accounts -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3 p-xl-3.5 transition-hover">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">إجمالي الحسابات</span>
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalAccounts }}</h3>
                    </div>
                    <div class="avatar-md rounded-4 bg-plum-subtle text-plum d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-building-columns fs-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Active Accounts -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3 p-xl-3.5 transition-hover">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">الحسابات المفعلة (نشطة)</span>
                        <h3 class="fw-bold mb-0 text-success">{{ $activeAccounts }}</h3>
                    </div>
                    <div class="avatar-md rounded-4 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-circle-check fs-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Post & BaridiMob Accounts -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3 p-xl-3.5 transition-hover">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">بريدي موب & CCP</span>
                        <h3 class="fw-bold mb-0 text-warning-emphasis">{{ $postalAccounts }}</h3>
                    </div>
                    <div class="avatar-md rounded-4 bg-warning bg-opacity-15 text-warning-emphasis d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-mobile-screen-button fs-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Commercial Banks -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3 p-xl-3.5 transition-hover">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">البنوك الوطنية والأخرى</span>
                        <h3 class="fw-bold mb-0 text-primary">{{ $commercialBanks }}</h3>
                    </div>
                    <div class="avatar-md rounded-4 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-vault fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & View Controls -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3 p-md-4">
            <form method="GET" action="{{ route('admin.bank_accounts.index') }}" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label class="form-label small fw-bold text-muted mb-1">نوع الحساب</label>
                    <select name="type" class="form-select rounded-3 shadow-none" onchange="this.form.submit()">
                        <option value="">-- جميع الأنواع --</option>
                        <option value="baridimob" {{ request('type') == 'baridimob' ? 'selected' : '' }}>بريدي موب (BaridiMob)</option>
                        <option value="ccp" {{ request('type') == 'ccp' ? 'selected' : '' }}>بريد الجزائر (CCP)</option>
                        <option value="bank" {{ request('type') == 'bank' ? 'selected' : '' }}>بنوك جزائرية (BNA, BEA, CPA...)</option>
                        <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>أخرى</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="form-label small fw-bold text-muted mb-1">حالة الحساب</label>
                    <select name="status" class="form-select rounded-3 shadow-none" onchange="this.form.submit()">
                        <option value="">-- جميع الحالات --</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>نشط ومفعل فقط</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>معطل أو موقوف</option>
                    </select>
                </div>

                <div class="col-md-2 text-md-end mt-md-4">
                    <a href="{{ route('admin.bank_accounts.index') }}" class="btn btn-light w-100 rounded-3 border text-dark fw-semibold">
                        <i class="fa-solid fa-arrows-rotate me-1"></i> إعادة ضبط
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bank Accounts Virtual Cards Display -->
    @if ($accounts->count() > 0)
        <div class="row g-4 mb-4">
            @foreach ($accounts as $account)
                <div class="col-md-6 col-xl-4">
                    <div class="bank-card-container position-relative h-100 rounded-4 p-4 text-white shadow-sm overflow-hidden d-flex flex-column justify-content-between"
                         style="background: {{ $account->card_gradient }}; min-height: 255px;">

                        <!-- Card Top Bar -->
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="card-chip-sim"></div>
                                    <span class="badge {{ $account->is_active ? 'bg-white bg-opacity-25 text-white' : 'bg-danger text-white' }} px-2.5 py-1 rounded-pill small">
                                        <i class="fa-solid {{ $account->is_active ? 'fa-check' : 'fa-ban' }} me-1"></i>
                                        {{ $account->is_active ? 'نشط' : 'معطل' }}
                                    </span>
                                    @if ($account->is_default)
                                        <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill small fw-bold">
                                            <i class="fa-solid fa-star me-1"></i> رئيسي
                                        </span>
                                    @endif
                                </div>
                                <span class="badge bg-black bg-opacity-30 text-white rounded-pill px-3 py-1 font-monospace small">
                                    {{ $account->type_label }}
                                </span>
                            </div>

                            <!-- Bank Name -->
                            <h5 class="fw-bold mb-1 text-white tracking-wide text-truncate" title="{{ $account->bank_name }}">
                                {{ $account->bank_name }}
                            </h5>
                        </div>

                        <!-- Card Middle: Account / RIP Number -->
                        <div class="my-3">
                            <span class="text-white-50 smaller d-block mb-1">
                                {{ !empty($account->rip) ? 'رقم التعريف البريدي/البنكي (RIP/RIB):' : 'رقم الحساب الجاري:' }}
                            </span>
                            <div class="d-flex align-items-center justify-content-between bg-black bg-opacity-25 rounded-3 px-3 py-2 border border-white border-opacity-10">
                                <span class="font-monospace fs-5 fw-bold text-white tracking-wider user-select-all text-truncate" id="acc_num_{{ $account->id }}" dir="ltr" style="direction: ltr !important; unicode-bidi: isolate;">
                                    {{ $account->display_number }}
                                </span>
                                <button type="button" class="btn btn-sm btn-link text-white text-opacity-75 hover-white p-0 border-0"
                                        onclick="copyToClipboard('{{ !empty($account->rip) ? $account->rip : $account->account_number }}', 'تم نسخ الرقم بنجاح!')"
                                        title="نسخ الرقم">
                                    <i class="fa-regular fa-copy fs-6"></i>
                                </button>
                            </div>
                            @if (!empty($account->ccp_key))
                                <div class="mt-1 d-flex align-items-center gap-2">
                                    <span class="text-white-50 smaller">المفتاح (Clé):</span>
                                    <span class="badge bg-white bg-opacity-20 text-white font-monospace fw-bold" dir="ltr">{{ $account->ccp_key }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Card Bottom: Name & Action Buttons -->
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3 border-top border-white border-opacity-15 pt-2">
                                <div>
                                    <span class="text-white-50 smaller d-block">صاحب الحساب:</span>
                                    <span class="fw-bold text-white small text-truncate d-block" style="max-width: 180px;">
                                        {{ $account->account_name }}
                                    </span>
                                </div>
                                @if (!empty($account->iban))
                                    <div class="text-end">
                                        <span class="text-white-50 smaller d-block">IBAN:</span>
                                        <span class="font-monospace smaller text-white-50">{{ Str::limit($account->iban, 12) }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Card Action Toolbar -->
                            <div class="d-flex align-items-center justify-content-between pt-1">
                                <!-- Status Toggle Form -->
                                <form action="{{ route('admin.bank_accounts.toggle_status', $account->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $account->is_active ? 'btn-outline-light' : 'btn-success' }} rounded-pill px-3 py-1 smaller fw-semibold shadow-none"
                                            title="{{ $account->is_active ? 'تعطيل الحساب' : 'تفعيل الحساب' }}">
                                        <i class="fa-solid {{ $account->is_active ? 'fa-pause' : 'fa-play' }} me-1"></i>
                                        {{ $account->is_active ? 'إيقاف مؤقت' : 'تفعيل الحساب' }}
                                    </button>
                                </form>

                                <div class="d-flex align-items-center gap-2">
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-sm btn-light text-dark rounded-pill px-3 py-1 fw-bold shadow-sm"
                                            data-id="{{ $account->id }}"
                                            data-type="{{ $account->account_type }}"
                                            data-bank="{{ $account->bank_name }}"
                                            data-name="{{ $account->account_name }}"
                                            data-rip="{{ $account->rip }}"
                                            data-number="{{ $account->account_number }}"
                                            data-key="{{ $account->ccp_key }}"
                                            data-iban="{{ $account->iban }}"
                                            data-swift="{{ $account->swift_code }}"
                                            data-notes="{{ $account->notes }}"
                                            data-active="{{ $account->is_active ? '1' : '0' }}"
                                            data-default="{{ $account->is_default ? '1' : '0' }}"
                                            onclick="openEditAccountModal(this)"
                                            title="تعديل بيانات الحساب">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> تعديل
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.bank_accounts.destroy', $account->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirmDeleteAccount(event, '{{ $account->bank_name }} - {{ $account->account_name }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-white rounded-pill px-2.5 py-1 shadow-sm" title="حذف الحساب نهائياً">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Card Decorative Circles -->
                        <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 130px; height: 130px; top: -30px; right: -30px; pointer-events: none;"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $accounts->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="card border-0 shadow-sm rounded-4 bg-white p-5 text-center my-4">
            <div class="avatar-xl mx-auto mb-3 bg-light text-muted rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                <i class="fa-solid fa-building-columns fs-1 opacity-50"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">لا توجد حسابات بنكية مضافة حتى الآن</h4>
            <p class="text-muted small mx-auto mb-4" style="max-width: 480px;">
                يمكنك البدء بإضافة حساب بريدي موب، حساب CCP، أو أي حساب بنكي في البنوك الجزائرية ليتمكن التجار والموردون من شحن أرصدتهم بسهولة.
            </p>
            <div>
                <button type="button" class="btn btn-plum px-4 py-2.5 rounded-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addBankAccountModal">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span>إضافة أول حساب بنكي الآن</span>
                </button>
            </div>
        </div>
    @endif

</div>

<!-- Modal: إضافة حساب بنكي جديد -->
<div class="modal fade" id="addBankAccountModal" tabindex="-1" aria-labelledby="addBankAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white py-3.5 px-4"
                 style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 100%);">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-sm rounded-3 bg-white bg-opacity-20 text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="fa-solid fa-building-columns"></i>
                    </span>
                    <h5 class="modal-title fw-bold mb-0 fs-6 text-white" id="addBankAccountModalLabel">إضافة حساب بنكي / مالي جديد للمنصة</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <form action="{{ route('admin.bank_accounts.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 bg-white text-start">
                    <!-- Quick Bank Presets -->
                    <div class="mb-3.5">
                        <label class="form-label fw-bold text-dark small">اختيار سريع لمؤسسة مالية جزائرية:</label>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3" onclick="setPreset('baridimob', 'بريدي موب - BaridiMob')">
                                🟢 بريدي موب
                            </button>
                            <button type="button" class="btn btn-outline-warning text-dark btn-sm rounded-pill px-3" onclick="setPreset('ccp', 'بريد الجزائر - Algérie Poste')">
                                🟡 بريد الجزائر (CCP)
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="setPreset('bank', 'البنك الوطني الجزائري - BNA')">
                                🔵 BNA
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="setPreset('bank', 'بنك الجزائر الخارجي - BEA')">
                                🔵 BEA
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="setPreset('bank', 'القرض الشعبي الجزائري - CPA')">
                                🔵 CPA
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="setPreset('bank', 'بنك الفلاحة والتنمية الريفية - BADR')">
                                🔵 BADR
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="setPreset('bank', 'بنك التنمية المحلية - BDL')">
                                🔵 BDL
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="setPreset('bank', 'بنك البركة الجزائري - Al Baraka')">
                                🔵 البركة
                            </button>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Account Type -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">نوع الحساب <span class="text-danger">*</span></label>
                            <select name="account_type" id="add_account_type" class="form-select rounded-3 shadow-none" required onchange="handleAccountTypeChange('add')">
                                <option value="baridimob">بريدي موب (BaridiMob)</option>
                                <option value="ccp">بريد الجزائر (CCP)</option>
                                <option value="bank">حساب بنكي وطني (Algerian Bank)</option>
                                <option value="other">أخرى</option>
                            </select>
                        </div>

                        <!-- Bank Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">اسم البنك / المؤسسة <span class="text-danger">*</span></label>
                            <input type="text" name="bank_name" id="add_bank_name" class="form-control rounded-3 shadow-none" placeholder="مثال: بريدي موب، BNA..." required>
                        </div>

                        <!-- Account Holder Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">اسم صاحب الحساب (الاسم الكامل) <span class="text-danger">*</span></label>
                            <input type="text" name="account_name" id="add_account_name" class="form-control rounded-3 shadow-none" placeholder="مثال: محمد بن علي أو اسم الشركة" required>
                        </div>

                        <!-- RIP / RIB Number (Crucial for BaridiMob & Transfers) -->
                        <div class="col-md-6" id="add_rip_wrapper">
                            <label class="form-label fw-bold text-dark small">رقم التعريف البريدي/البنكي (RIP / RIB - 20 رقم)</label>
                            <input type="text" name="rip" id="add_rip" class="form-control rounded-3 shadow-none font-monospace" placeholder="00799999002345678912" maxlength="30" dir="ltr">
                            <small class="text-muted smaller">أساسي جداً لعمليات التحويل عبر تطبيق بريدي موب والتحويلات البنكية.</small>
                        </div>

                        <!-- Account Number (For CCP or Standard Bank) -->
                        <div class="col-md-4" id="add_account_number_wrapper">
                            <label class="form-label fw-bold text-dark small">رقم الحساب (CCP أو بنكي)</label>
                            <input type="text" name="account_number" id="add_account_number" class="form-control rounded-3 shadow-none font-monospace" placeholder="مثال: 0023456789" dir="ltr">
                        </div>

                        <!-- CCP Key (Clé) -->
                        <div class="col-md-2" id="add_ccp_key_wrapper">
                            <label class="form-label fw-bold text-dark small">المفتاح (Clé)</label>
                            <input type="text" name="ccp_key" id="add_ccp_key" class="form-control rounded-3 shadow-none font-monospace text-center" placeholder="99" maxlength="4" dir="ltr">
                        </div>

                        <!-- IBAN (Optional) -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">رقم الحساب الدولي (IBAN) <span class="text-muted smaller">(اختياري)</span></label>
                            <input type="text" name="iban" id="add_iban" class="form-control rounded-3 shadow-none font-monospace" placeholder="DZ00 0000 0000 0000 0000 0000" dir="ltr">
                        </div>

                        <!-- Swift Code (Optional) -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">كود السويفت (BIC / SWIFT) <span class="text-muted smaller">(اختياري)</span></label>
                            <input type="text" name="swift_code" id="add_swift_code" class="form-control rounded-3 shadow-none font-monospace" placeholder="BNPADZAL" dir="ltr">
                        </div>

                        <!-- Notes / Instructions -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small">ملاحظات وإرشادات للعملاء عند الشحن <span class="text-muted smaller">(اختياري)</span></label>
                            <textarea name="notes" id="add_notes" class="form-control rounded-3 shadow-none" rows="2" placeholder="مثال: يرجى كتابة رقم هاتفك في خانة البيان (Motif) عند التحويل لسرعة التأكيد..."></textarea>
                        </div>

                        <!-- Checkboxes: Active & Default -->
                        <div class="col-12">
                            <div class="p-3 bg-light rounded-3 d-flex flex-wrap gap-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="add_is_active" value="1" checked>
                                    <label class="form-check-label fw-semibold text-dark small" for="add_is_active">تفعيل الحساب فوراً للاستخدام</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_default" id="add_is_default" value="1">
                                    <label class="form-check-label fw-semibold text-dark small" for="add_is_default">تعيين كحساب افتراضي رئيسي لهذا النوع</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3 border-top-0">
                    <button type="button" class="btn btn-secondary rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-plum rounded-3 px-4 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>حفظ الحساب البنكي</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: تعديل حساب بنكي -->
<div class="modal fade" id="editBankAccountModal" tabindex="-1" aria-labelledby="editBankAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white py-3.5 px-4"
                 style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 100%);">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-sm rounded-3 bg-white bg-opacity-20 text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </span>
                    <h5 class="modal-title fw-bold mb-0 fs-6 text-white" id="editBankAccountModalLabel">تعديل بيانات الحساب البنكي</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <form id="editBankAccountForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 bg-white text-start">

                    <div class="row g-3">
                        <!-- Account Type -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">نوع الحساب <span class="text-danger">*</span></label>
                            <select name="account_type" id="edit_account_type" class="form-select rounded-3 shadow-none" required onchange="handleAccountTypeChange('edit')">
                                <option value="baridimob">بريدي موب (BaridiMob)</option>
                                <option value="ccp">بريد الجزائر (CCP)</option>
                                <option value="bank">حساب بنكي وطني (Algerian Bank)</option>
                                <option value="other">أخرى</option>
                            </select>
                        </div>

                        <!-- Bank Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">اسم البنك / المؤسسة <span class="text-danger">*</span></label>
                            <input type="text" name="bank_name" id="edit_bank_name" class="form-control rounded-3 shadow-none" required>
                        </div>

                        <!-- Account Holder Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">اسم صاحب الحساب <span class="text-danger">*</span></label>
                            <input type="text" name="account_name" id="edit_account_name" class="form-control rounded-3 shadow-none" required>
                        </div>

                        <!-- RIP Number -->
                        <div class="col-md-6" id="edit_rip_wrapper">
                            <label class="form-label fw-bold text-dark small">رقم التعريف البريدي/البنكي (RIP / RIB)</label>
                            <input type="text" name="rip" id="edit_rip" class="form-control rounded-3 shadow-none font-monospace" maxlength="30" dir="ltr">
                        </div>

                        <!-- Account Number -->
                        <div class="col-md-4" id="edit_account_number_wrapper">
                            <label class="form-label fw-bold text-dark small">رقم الحساب</label>
                            <input type="text" name="account_number" id="edit_account_number" class="form-control rounded-3 shadow-none font-monospace" dir="ltr">
                        </div>

                        <!-- CCP Key (Clé) -->
                        <div class="col-md-2" id="edit_ccp_key_wrapper">
                            <label class="form-label fw-bold text-dark small">المفتاح (Clé)</label>
                            <input type="text" name="ccp_key" id="edit_ccp_key" class="form-control rounded-3 shadow-none font-monospace text-center" maxlength="4" dir="ltr">
                        </div>

                        <!-- IBAN -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">رقم الحساب الدولي (IBAN)</label>
                            <input type="text" name="iban" id="edit_iban" class="form-control rounded-3 shadow-none font-monospace" dir="ltr">
                        </div>

                        <!-- Swift Code -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark small">كود السويفت (BIC / SWIFT)</label>
                            <input type="text" name="swift_code" id="edit_swift_code" class="form-control rounded-3 shadow-none font-monospace" dir="ltr">
                        </div>

                        <!-- Notes -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small">ملاحظات وإرشادات للعملاء</label>
                            <textarea name="notes" id="edit_notes" class="form-control rounded-3 shadow-none" rows="2"></textarea>
                        </div>

                        <!-- Checkboxes -->
                        <div class="col-12">
                            <div class="p-3 bg-light rounded-3 d-flex flex-wrap gap-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active" value="1">
                                    <label class="form-check-label fw-semibold text-dark small" for="edit_is_active">تفعيل الحساب للاستخدام</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_default" id="edit_is_default" value="1">
                                    <label class="form-check-label fw-semibold text-dark small" for="edit_is_default">حساب رئيسي افتراضي</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3 border-top-0">
                    <button type="button" class="btn btn-secondary rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-plum rounded-3 px-4 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-arrows-rotate"></i>
                        <span>تحديث التغييرات</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Page Styling -->
<style>
/* ================= THEME COLOR TOKENS ================= */
.text-plum { color: #a40c72 !important; }
.bg-plum { background-color: #a40c72 !important; }
.bg-plum-subtle { background-color: rgba(164, 12, 114, 0.08) !important; }

.btn-plum {
    background: linear-gradient(135deg, #a40c72 0%, #be0681 100%) !important;
    color: #ffffff !important;
    border: none !important;
    transition: all 0.2s ease-in-out;
}
.btn-plum:hover {
    background: linear-gradient(135deg, #8a0a60 0%, #a40c72 100%) !important;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(164, 12, 114, 0.25) !important;
}

.smaller { font-size: 0.78rem !important; }
.tracking-wide { letter-spacing: 0.5px; }
.tracking-wider { letter-spacing: 1px; }

/* Bank Card Aesthetic */
.bank-card-container {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    border: 1px solid rgba(255, 255, 255, 0.12);
}
.bank-card-container:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15) !important;
}

/* Card SIM Chip Simulation */
.card-chip-sim {
    width: 32px;
    height: 24px;
    background: linear-gradient(135deg, #fcd34d 0%, #f59e0b 50%, #d97706 100%);
    border-radius: 4px;
    border: 1px solid rgba(0, 0, 0, 0.15);
    position: relative;
}
.card-chip-sim::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: rgba(0, 0, 0, 0.2);
}

.hover-white:hover {
    color: #ffffff !important;
    opacity: 1 !important;
}

.transition-hover {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.transition-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06) !important;
}
</style>

<!-- Custom JavaScript -->
<script>
// Quick Presets Selector
function setPreset(type, bankName) {
    const typeSelect = document.getElementById('add_account_type');
    const nameInput = document.getElementById('add_bank_name');
    if (typeSelect && nameInput) {
        typeSelect.value = type;
        nameInput.value = bankName;
        handleAccountTypeChange('add');
    }
}

// Handle Form UI Visibility according to Account Type
function handleAccountTypeChange(prefix) {
    const type = document.getElementById(prefix + '_account_type').value;
    const ripWrapper = document.getElementById(prefix + '_rip_wrapper');
    const accNumWrapper = document.getElementById(prefix + '_account_number_wrapper');
    const ccpKeyWrapper = document.getElementById(prefix + '_ccp_key_wrapper');

    if (type === 'baridimob') {
        ripWrapper.classList.remove('d-none');
        accNumWrapper.classList.remove('d-none');
        ccpKeyWrapper.classList.add('d-none');
    } else if (type === 'ccp') {
        ripWrapper.classList.remove('d-none');
        accNumWrapper.classList.remove('d-none');
        ccpKeyWrapper.classList.remove('d-none');
    } else {
        ripWrapper.classList.remove('d-none');
        accNumWrapper.classList.remove('d-none');
        ccpKeyWrapper.classList.add('d-none');
    }
}

// Copy Text to Clipboard Helper
function copyToClipboard(text, successMsg) {
    if (!text || text === '—') return;
    navigator.clipboard.writeText(text).then(function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'تم النسخ!',
                text: successMsg || 'تم نسخ الرقم بنجاح إلى الحافظة.',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        } else {
            alert(successMsg || 'تم النسخ بنجاح!');
        }
    }).catch(function() {
        const tempInput = document.createElement('input');
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        alert('تم النسخ!');
    });
}

// Open Edit Account Modal with Instant HTML5 Data Attributes
function openEditAccountModal(el) {
    const modalEl = document.getElementById('editBankAccountModal');
    const form = document.getElementById('editBankAccountForm');

    if (!modalEl || !form || !el) return;

    const data = el.dataset;
    const accountId = data.id;

    // Set form action URL
    const updateUrlPattern = "{{ route('admin.bank_accounts.update', ':id') }}";
    form.action = updateUrlPattern.replace(':id', accountId);

    // Populate all fields instantly from HTML5 dataset
    document.getElementById('edit_account_type').value = data.type || 'baridimob';
    document.getElementById('edit_bank_name').value = data.bank || '';
    document.getElementById('edit_account_name').value = data.name || '';
    document.getElementById('edit_rip').value = data.rip || '';
    document.getElementById('edit_account_number').value = data.number || '';
    document.getElementById('edit_ccp_key').value = data.key || '';
    document.getElementById('edit_iban').value = data.iban || '';
    document.getElementById('edit_swift_code').value = data.swift || '';
    document.getElementById('edit_notes').value = data.notes || '';
    document.getElementById('edit_is_active').checked = data.active === '1';
    document.getElementById('edit_is_default').checked = data.default === '1';

    // Update field visibility according to account type
    handleAccountTypeChange('edit');

    // Show the modal
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}

// Delete Confirmation
function confirmDeleteAccount(event, accountName) {
    event.preventDefault();
    const form = event.target;

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'هل أنت متأكد من الحذف؟',
            text: 'سيتم حذف الحساب (' + accountName + ') نهائياً من النظام.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'نعم، احذف الحساب',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        return false;
    }

    if (confirm('هل أنت متأكد من حذف الحساب (' + accountName + ')؟')) {
        form.submit();
    }
    return false;
}
</script>
