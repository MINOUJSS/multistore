@if (session('success'))
    <script>
        Swal.fire({
            title: 'نجاح!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'حسنًا'
        });
    </script>
@endif

<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-truck-fast text-warning"></i>
                    <span class="fw-semibold">{{ __('إدارة شركات وتكاملات الشحن للتوريد') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    إدارة شركات الشحن والتكامل الذكي للتوريد 📦
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    ربط شركات الشحن الجزائرية (Yalidine, ZRexpress, Maystro, DHD...)، تفعيل الخدمات، وإدارة التسعيرات المخصصة لشحنات التوريد والجملة بكل سهولة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <button class="btn btn-warning text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#ShippingCompaniesModal">
                        <i class="fas fa-plus"></i>
                        <span>إضافة شركة شحن</span>
                    </button>
                    <a class="btn btn-light text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2"
                        href="{{ route('supplier.shipping.edit') }}">
                        <i class="fas fa-calculator me-1 text-navy"></i>
                        <span>تسعير الشحن</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10"
            style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);">
        </div>
        <div class="position-absolute rounded-circle bg-primary opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    <!-- Statistical Indicator Cards Grid -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Integrated Companies -->
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-navy-subtle text-navy fw-bold">
                            <i class="fa-solid fa-truck-ramp-box fs-5"></i>
                        </span>
                        <span class="badge bg-light text-secondary rounded-pill small">المدمجة</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $companies->count() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">إجمالي الشركات المدمجة</p>
                </div>
            </div>
        </div>

        <!-- 2. Active Services -->
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-success-subtle text-success fw-bold">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success rounded-pill small">نشط</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $companies->where('status', 'active')->count() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">خدمات الشحن المفعلة</p>
                </div>
            </div>
        </div>

        <!-- 3. Available Gateways -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-info-subtle text-info fw-bold">
                            <i class="fa-solid fa-plug-circle-check fs-5"></i>
                        </span>
                        <span class="badge bg-info-subtle text-info rounded-pill small">البوابات</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">11</h3>
                    <p class="text-muted small mb-0 fw-semibold">بوابة شركة شحن متاحة للربط</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Integrated Shipping Companies Section -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
        <div class="card-header bg-white border-0 py-3.5 px-3 px-md-4 d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom border-light">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="avatar avatar-md rounded-3 bg-navy-subtle text-navy fw-bold me-1" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-boxes-packing fs-6"></i>
                </span>
                <h5 class="fw-bold mb-0 text-dark fs-6">شركات الشحن المدمجة بحساب التوريد</h5>
            </div>
            <button class="btn btn-sm btn-supplier-primary rounded-3 px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5" data-bs-toggle="modal" data-bs-target="#ShippingCompaniesModal">
                <i class="fa-solid fa-plus"></i>
                <span>ربط شركة جديدة</span>
            </button>
        </div>
        <div class="card-body p-3.5 p-md-4">
            <div class="row g-3">
                @if ($companies->count() > 0)
                    @foreach ($companies as $company)
                        @php
                            $companyData = json_decode($company->data);
                        @endphp
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card integration-card h-100 shadow-sm rounded-4 position-relative border border-light-subtle bg-white hover-lift transition-all">
                                {{-- حالة التفعيل --}}
                                @if ($company->status == 'active')
                                    <span class="badge bg-success-subtle text-success border border-success position-absolute top-0 end-0 m-3 px-3 py-1.5 rounded-pill fw-bold small">
                                        <i class="fa-solid fa-circle-check me-1"></i>مفعل
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border position-absolute top-0 end-0 m-3 px-3 py-1.5 rounded-pill fw-bold small">
                                        <i class="fa-solid fa-circle-pause me-1"></i>معطل
                                    </span>
                                @endif

                                <div class="card-body text-center p-4">
                                    {{-- شعار الشركة --}}
                                    <div class="integration-icon mb-3 d-flex align-items-center justify-content-center p-2 rounded-3 bg-light" style="height: 70px;">
                                        <img src="{{ $companyData->logo ?? asset('default-logo.png') }}"
                                            alt="{{ $company->name }}" height="45" class="img-fluid object-fit-contain" style="max-height: 48px;">
                                    </div>

                                    {{-- اسم الشركة --}}
                                    <h5 class="card-title fw-bold text-dark mb-2 fs-5">{{ $company->name }}</h5>

                                    {{-- وصف --}}
                                    <p class="card-text text-muted small mb-4 leading-relaxed">
                                        رفع طلبات الشحن والجملة إلى شركة <strong class="text-navy">{{ $company->name }}</strong> بضغطة زر واحدة تلقائياً.
                                    </p>

                                    {{-- أدوات التحكم --}}
                                    <div class="d-flex justify-content-center align-items-center flex-wrap gap-2 pt-2 border-top border-light">
                                        {{-- مفتاح التفعيل --}}
                                        <div class="form-check form-switch bg-light px-3 py-1.5 rounded-3 d-inline-flex align-items-center mb-0">
                                            <input class="form-check-input toggle-shipping me-2 ms-0" type="checkbox"
                                                data-company-id="{{ $company->id }}"
                                                {{ $company->status == 'active' ? 'checked' : '' }}>
                                            <label class="form-check-label small fw-semibold text-secondary mb-0">تفعيل الشحن</label>
                                        </div>

                                        {{-- زر الإعدادات --}}
                                        <button class="btn btn-sm btn-outline-primary rounded-3 px-3 py-1.5 fw-semibold" data-bs-toggle="modal"
                                            data-bs-target="#{{ $company->name }}Modal">
                                            <i class="fa-solid fa-gear me-1"></i> إعدادات
                                        </button>

                                        {{-- زر الحذف --}}
                                        <form action="{{ route('supplier.shipping-company.delete', $company->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('هل أنت متأكد من حذف شركة الشحن؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger rounded-3 px-3 py-1.5 fw-semibold delete-shipping-btn">
                                                <i class="fa-solid fa-trash me-1"></i> حذف
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="card h-100 text-center p-5 shadow-sm border border-2 border-dashed rounded-4 bg-light-subtle">
                            <div class="card-body py-4">
                                <div class="integration-icon text-primary mb-3">
                                    <img src="{{ asset('asset/v1/users/dashboard/img/other/Delivery-1.png') }}"
                                        alt="delivery" height="80" class="img-fluid mb-2">
                                </div>

                                <h4 class="card-title fw-bold text-dark mb-2">لا توجد شركات شحن مرتبطة بالحساب حالياً</h4>
                                <p class="text-muted mb-4 max-w-md mx-auto fs-6">قم بإضافة وتفعيل إحدى شركات الشحن المتاحة لتمكين خيارات التوصيل والطلب التلقائي لشحنات التوريد.</p>

                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-supplier-primary rounded-3 px-4 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center gap-2" data-bs-toggle="modal"
                                        data-bs-target="#ShippingCompaniesModal">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>إضافة شركة شحن جديدة</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
     START SHIPPING COMPANIES SELECTION MODAL
     ========================================== -->
<div class="modal fade" id="ShippingCompaniesModal" tabindex="-1" aria-labelledby="ShippingCompaniesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-supplier-header py-3.5 px-4">
                <h5 class="modal-title fw-bold text-white fs-6" id="ShippingCompaniesModalLabel">
                    <i class="fa-solid fa-truck-ramp-box me-2"></i>ربط وتكامل شركات الشحن
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-3">اختر شركة الشحن المراد ربط حساب التوريد بها لإدخال بيانات الـ API والتفعيل:</p>
                
                <div class="row g-3">
                    <!-- 1. YALIDINE -->
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="card h-100 border border-light-subtle rounded-3 text-center p-3 cursor-pointer hover-lift company-select-card"
                            data-bs-toggle="modal" data-bs-target="#YALIDINEModal">
                            <div class="d-flex align-items-center justify-content-center" style="height: 50px;">
                                <img src="https://i.imgur.com/LNDFb1h.png" alt="YALIDINE" class="img-fluid" style="max-height: 40px;" />
                            </div>
                            <span class="fw-bold text-dark small mt-2 d-block">Yalidine</span>
                        </div>
                    </div>

                    <!-- 2. Zrexpress -->
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="card h-100 border border-light-subtle rounded-3 text-center p-3 cursor-pointer hover-lift company-select-card"
                            data-bs-toggle="modal" data-bs-target="#ZrexpressModal">
                            <div class="d-flex align-items-center justify-content-center" style="height: 50px;">
                                <img src="https://i.imgur.com/eL1fmUM.jpeg" alt="Zrexpress" class="img-fluid" style="max-height: 40px;" />
                            </div>
                            <span class="fw-bold text-dark small mt-2 d-block">ZR Express</span>
                        </div>
                    </div>

                    <!-- 3. Ecotrack -->
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="card h-100 border border-light-subtle rounded-3 text-center p-3 cursor-pointer hover-lift company-select-card"
                            data-bs-toggle="modal" data-bs-target="#EcotrackModal">
                            <div class="d-flex align-items-center justify-content-center" style="height: 50px;">
                                <img src="https://i.imgur.com/aNXHaac.png" alt="Ecotrack" class="img-fluid" style="max-height: 40px;" />
                            </div>
                            <span class="fw-bold text-dark small mt-2 d-block">Ecotrack</span>
                        </div>
                    </div>

                    <!-- 4. Yalitec -->
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="card h-100 border border-light-subtle rounded-3 text-center p-3 cursor-pointer hover-lift company-select-card"
                            data-bs-toggle="modal" data-bs-target="#YalitecModal">
                            <div class="d-flex align-items-center justify-content-center" style="height: 50px;">
                                <img src="https://i.imgur.com/IsBfZGd.png" alt="Yalitec" class="img-fluid" style="max-height: 40px;" />
                            </div>
                            <span class="fw-bold text-dark small mt-2 d-block">Yalitec</span>
                        </div>
                    </div>

                    <!-- 5. MAYSTRO_DELIVERY -->
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="card h-100 border border-light-subtle rounded-3 text-center p-3 cursor-pointer hover-lift company-select-card"
                            data-bs-toggle="modal" data-bs-target="#MAYSTRO_DELIVERYModal">
                            <div class="d-flex align-items-center justify-content-center" style="height: 50px;">
                                <img src="https://i.imgur.com/Pjv1wp2.png" alt="MAYSTRO_DELIVERY" class="img-fluid" style="max-height: 40px;" />
                            </div>
                            <span class="fw-bold text-dark small mt-2 d-block">Maystro Delivery</span>
                        </div>
                    </div>

                    <!-- 6. ProColis -->
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="card h-100 border border-light-subtle rounded-3 text-center p-3 cursor-pointer hover-lift company-select-card"
                            data-bs-toggle="modal" data-bs-target="#ProColisModal">
                            <div class="d-flex align-items-center justify-content-center" style="height: 50px;">
                                <img src="https://i.imgur.com/DJqdUc3.png" alt="Procolis" class="img-fluid" style="max-height: 40px;" />
                            </div>
                            <span class="fw-bold text-dark small mt-2 d-block">ProColis</span>
                        </div>
                    </div>

                    <!-- 7. Noest -->
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="card h-100 border border-light-subtle rounded-3 text-center p-3 cursor-pointer hover-lift company-select-card"
                            data-bs-toggle="modal" data-bs-target="#NoestModal">
                            <div class="d-flex align-items-center justify-content-center" style="height: 50px;">
                                <img src="https://noest-dz.com/assets/img/logo_colors_new.png" alt="Noest" class="img-fluid" style="max-height: 40px;" />
                            </div>
                            <span class="fw-bold text-dark small mt-2 d-block">Noest</span>
                        </div>
                    </div>

                    <!-- 8. Expedigo -->
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="card h-100 border border-light-subtle rounded-3 text-center p-3 cursor-pointer hover-lift company-select-card"
                            data-bs-toggle="modal" data-bs-target="#ExpedigoModal">
                            <div class="d-flex align-items-center justify-content-center" style="height: 50px;">
                                <img src="https://i.imgur.com/P7Yma2X.png" alt="Expedigo" class="img-fluid" style="max-height: 40px;" />
                            </div>
                            <span class="fw-bold text-dark small mt-2 d-block">Expedigo</span>
                        </div>
                    </div>

                    <!-- 9. Elogistia -->
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="card h-100 border border-light-subtle rounded-3 text-center p-3 cursor-pointer hover-lift company-select-card"
                            data-bs-toggle="modal" data-bs-target="#ElogistiaModal">
                            <div class="d-flex align-items-center justify-content-center" style="height: 50px;">
                                <img src="https://i.imgur.com/aHASodC.png" alt="Elogistia" class="img-fluid" style="max-height: 40px;" />
                            </div>
                            <span class="fw-bold text-dark small mt-2 d-block">Elogistia</span>
                        </div>
                    </div>

                    <!-- 10. Guepex -->
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="card h-100 border border-light-subtle rounded-3 text-center p-3 cursor-pointer hover-lift company-select-card"
                            data-bs-toggle="modal" data-bs-target="#GuepexModal">
                            <div class="d-flex align-items-center justify-content-center" style="height: 50px;">
                                <img src="https://imgur.com/JkV2HXl.png" alt="Guepex" class="img-fluid" style="max-height: 40px;" />
                            </div>
                            <span class="fw-bold text-dark small mt-2 d-block">Guepex</span>
                        </div>
                    </div>

                    <!-- 11. DHD -->
                    <div class="col-6 col-sm-4 col-md-3">
                        <div class="card h-100 border border-light-subtle rounded-3 text-center p-3 cursor-pointer hover-lift company-select-card"
                            data-bs-toggle="modal" data-bs-target="#DHDModal">
                            <div class="d-flex align-items-center justify-content-center" style="height: 50px;">
                                <img src="https://i.imgur.com/PrM01pT.png" alt="DHD" class="img-fluid" style="max-height: 40px;" />
                            </div>
                            <span class="fw-bold text-dark small mt-2 d-block">DHD Express</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-3 px-4">
                <button type="button" class="btn btn-light rounded-3 px-4 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<!-- END SHIPPING COMPANIES SELECTION MODAL -->


<!-- Start Yalidin Modal -->
<div class="modal fade" id="YALIDINEModal" tabindex="-1" aria-labelledby="YALIDINEModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form id="YALIDINEForm">
                @csrf
                <input type="hidden" name="name" value="YALIDINE">

                <div class="modal-header bg-supplier-header py-3.5 px-4">
                    <h5 class="modal-title fw-bold text-white fs-6">
                        <i class="fa-solid fa-plug me-2"></i>ربط شركة Yalidine Express
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-4 text-center p-3 rounded-3 bg-light border">
                        <img src="https://i.imgur.com/LNDFb1h.png" alt="yalidine" height="45" class="img-fluid" />
                    </div>

                    <div class="mb-3">
                        <label for="yl-wilaya" class="form-label fw-semibold text-secondary small">ولاية الشحن الأساسية:</label>
                        <input type="text" class="form-control rounded-3 shadow-none" id="yl-wilaya" name="wilaya"
                            value="{{ old('wilaya', isset($yalidin) && $yalidin->count() ? json_decode($yalidin->data)->wilaya : '') }}" placeholder="مثال: Alger">
                        <div class="invalid-feedback" id="error-yl-wilaya"></div>
                    </div>

                    <div class="mb-3">
                        <label for="yl-api_id" class="form-label fw-semibold text-secondary small">API ID:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="yl-api_id" name="api_id"
                            value="{{ old('api_id', isset($yalidin) && $yalidin->count() ? json_decode($yalidin->data)->api_id : '') }}" placeholder="أدخل API ID الخاص بحساب ياليدين">
                        <div class="invalid-feedback" id="error-yl-api_id"></div>
                    </div>

                    <div class="mb-3">
                        <label for="yl-api_token" class="form-label fw-semibold text-secondary small">API TOKEN:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="yl-api_token" name="api_token"
                            value="{{ old('api_token', isset($yalidin) && $yalidin->count() ? json_decode($yalidin->data)->api_token : '') }}" placeholder="أدخل API Token الخاص بحساب ياليدين">
                        <div class="invalid-feedback" id="error-yl-api_token"></div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-outline-success rounded-3 px-3 fw-bold" id="testYalidineConnection">
                        <i class="fa-solid fa-wifi me-1"></i>اختبار الاتصال
                    </button>
                    <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">
                        <i class="fa-solid fa-save me-1"></i>حفظ البيانات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Yalidin Modal -->

<!-- Start ZRexpress Modal -->
<div class="modal fade" id="ZrexpressModal" tabindex="-1" aria-labelledby="ZrexpressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form id="zrexpressForm">
                @csrf
                <input type="hidden" name="name" value="Zrexpress">

                <div class="modal-header bg-supplier-header py-3.5 px-4">
                    <h5 class="modal-title fw-bold text-white fs-6">
                        <i class="fa-solid fa-plug me-2"></i>ربط شركة ZR Express
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-4 text-center p-3 rounded-3 bg-light border">
                        <img src="https://i.imgur.com/eL1fmUM.jpeg" alt="zrexpress" height="45" class="img-fluid" />
                    </div>

                    <div class="mb-3">
                        <label for="zr-token" class="form-label fw-semibold text-secondary small">Token المفتاح:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="zr-token" name="token"
                            value="{{ old('token', isset($zrexpress) && $zrexpress->count() ? json_decode($zrexpress->data)->token : '') }}" placeholder="أدخل Token">
                        <div class="invalid-feedback" id="error-zr-token"></div>
                    </div>

                    <div class="mb-3">
                        <label for="zr-cle" class="form-label fw-semibold text-secondary small">Cle السر المفتاحي:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="zr-cle" name="cle"
                            value="{{ old('cle', isset($zrexpress) && $zrexpress->count() ? json_decode($zrexpress->data)->cle : '') }}" placeholder="أدخل Cle">
                        <div class="invalid-feedback" id="error-zr-cle"></div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">
                        <i class="fa-solid fa-save me-1"></i>حفظ البيانات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End ZRexpress Modal -->

<!-- Start Ecotrack Modal -->
<div class="modal fade" id="EcotrackModal" tabindex="-1" aria-labelledby="EcotrackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-supplier-header py-3.5 px-4">
                <h5 class="modal-title fw-bold text-white fs-6"><i class="fa-solid fa-plug me-2"></i>ربط شركة Ecotrack</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="post">
                    <div class="mb-4 text-center p-3 rounded-3 bg-light border">
                        <img src="https://i.imgur.com/aNXHaac.png" alt="Ecotrack" height="45" class="img-fluid" />
                    </div>
                    <div class="mb-3">
                        <label for="ec-wilaya" class="form-label fw-semibold text-secondary small">ولاية الشحن :</label>
                        <input type="text" class="form-control rounded-3 shadow-none" id="ec-wilaya" name="wilaya">
                    </div>
                    <div class="mb-3">
                        <label for="ec-api_id" class="form-label fw-semibold text-secondary small">API ID:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="ec-api_id" name="api_id">
                    </div>
                    <div class="mb-3">
                        <label for="ec-api_token" class="form-label fw-semibold text-secondary small">API TOKEN:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="ec-api_token" name="api_token">
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-0 py-3 px-4">
                <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">حفظ</button>
            </div>
        </div>
    </div>
</div>
<!-- End Ecotrack Modal -->

<!-- Start Yalitec Modal -->
<div class="modal fade" id="YalitecModal" tabindex="-1" aria-labelledby="YalitecModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-supplier-header py-3.5 px-4">
                <h5 class="modal-title fw-bold text-white fs-6"><i class="fa-solid fa-plug me-2"></i>ربط شركة Yalitec</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="post">
                    <div class="mb-4 text-center p-3 rounded-3 bg-light border">
                        <img src="https://i.imgur.com/IsBfZGd.png" alt="Yalitec" height="45" class="img-fluid" />
                    </div>
                    <div class="mb-3">
                        <label for="yt-wilaya" class="form-label fw-semibold text-secondary small">ولاية الشحن :</label>
                        <input type="text" class="form-control rounded-3 shadow-none" id="yt-wilaya" name="wilaya">
                    </div>
                    <div class="mb-3">
                        <label for="yt-api_id" class="form-label fw-semibold text-secondary small">API ID:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="yt-api_id" name="api_id">
                    </div>
                    <div class="mb-3">
                        <label for="yt-api_token" class="form-label fw-semibold text-secondary small">API TOKEN:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="yt-api_token" name="api_token">
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-0 py-3 px-4">
                <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">حفظ</button>
            </div>
        </div>
    </div>
</div>
<!-- End Yalitec Modal -->

<!-- Start MAYSTRO_DELIVERY Modal -->
<div class="modal fade" id="MAYSTRO_DELIVERYModal" tabindex="-1" aria-labelledby="MAYSTRO_DELIVERYModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form id="MAYSTRO_DELIVERYForm">
                @csrf
                <input type="hidden" name="name" value="MAYSTRO_DELIVERY">

                <div class="modal-header bg-supplier-header py-3.5 px-4">
                    <h5 class="modal-title fw-bold text-white fs-6">
                        <i class="fa-solid fa-plug me-2"></i>ربط شركة Maystro Delivery
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-4 text-center p-3 rounded-3 bg-light border">
                        <img src="https://i.imgur.com/Pjv1wp2.png" alt="MAYSTRO_DELIVERY" height="45" class="img-fluid" />
                    </div>

                    <div class="mb-3">
                        <label for="api_id" class="form-label fw-semibold text-secondary small">API ID:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="api_id" name="id"
                            value="{{ old('id', isset($maystro) && $maystro->count() ? json_decode($maystro->data)->id : '') }}" placeholder="أدخل API ID">
                    </div>

                    <div class="mb-3">
                        <label for="api_token" class="form-label fw-semibold text-secondary small">API KEY:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="api_token" name="key"
                            value="{{ old('key', isset($maystro) && $maystro->count() ? json_decode($maystro->data)->key : '') }}" placeholder="أدخل API Key">
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-outline-success rounded-3 px-3 fw-bold" id="testMAYSTRO_DELIVERYConnection">
                        <i class="fa-solid fa-wifi me-1"></i>اختبار الاتصال
                    </button>
                    <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">
                        <i class="fa-solid fa-save me-1"></i>حفظ البيانات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End MAYSTRO_DELIVERY Modal -->

<!-- Start ProColis Modal -->
<div class="modal fade" id="ProColisModal" tabindex="-1" aria-labelledby="ProColisModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-supplier-header py-3.5 px-4">
                <h5 class="modal-title fw-bold text-white fs-6"><i class="fa-solid fa-plug me-2"></i>ربط شركة ProColis</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="post">
                    <div class="mb-4 text-center p-3 rounded-3 bg-light border">
                        <img src="https://i.imgur.com/DJqdUc3.png" alt="ProColis" height="45" class="img-fluid" />
                    </div>
                    <div class="mb-3">
                        <label for="pc-wilaya" class="form-label fw-semibold text-secondary small">ولاية الشحن :</label>
                        <input type="text" class="form-control rounded-3 shadow-none" id="pc-wilaya" name="wilaya">
                    </div>
                    <div class="mb-3">
                        <label for="pc-api_id" class="form-label fw-semibold text-secondary small">API ID:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="pc-api_id" name="api_id">
                    </div>
                    <div class="mb-3">
                        <label for="pc-api_token" class="form-label fw-semibold text-secondary small">API TOKEN:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="pc-api_token" name="api_token">
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-0 py-3 px-4">
                <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">حفظ</button>
            </div>
        </div>
    </div>
</div>
<!-- End ProColis Modal -->

<!-- Start Noest Modal -->
<div class="modal fade" id="NoestModal" tabindex="-1" aria-labelledby="NoestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-supplier-header py-3.5 px-4">
                <h5 class="modal-title fw-bold text-white fs-6"><i class="fa-solid fa-plug me-2"></i>ربط شركة Noest</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="post">
                    <div class="mb-4 text-center p-3 rounded-3 bg-light border">
                        <img src="https://noest-dz.com/assets/img/logo_colors_new.png" alt="Noest" height="45" class="img-fluid" />
                    </div>
                    <div class="mb-3">
                        <label for="no-wilaya" class="form-label fw-semibold text-secondary small">ولاية الشحن :</label>
                        <input type="text" class="form-control rounded-3 shadow-none" id="no-wilaya" name="wilaya">
                    </div>
                    <div class="mb-3">
                        <label for="no-api_id" class="form-label fw-semibold text-secondary small">API ID:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="no-api_id" name="api_id">
                    </div>
                    <div class="mb-3">
                        <label for="no-api_token" class="form-label fw-semibold text-secondary small">API TOKEN:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="no-api_token" name="api_token">
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-0 py-3 px-4">
                <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">حفظ</button>
            </div>
        </div>
    </div>
</div>
<!-- End Noest Modal -->

<!-- Start Expedigo Modal -->
<div class="modal fade" id="ExpedigoModal" tabindex="-1" aria-labelledby="ExpedigoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-supplier-header py-3.5 px-4">
                <h5 class="modal-title fw-bold text-white fs-6"><i class="fa-solid fa-plug me-2"></i>ربط شركة Expedigo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="post">
                    <div class="mb-4 text-center p-3 rounded-3 bg-light border">
                        <img src="https://i.imgur.com/P7Yma2X.png" alt="Expedigo" height="45" class="img-fluid" />
                    </div>
                    <div class="mb-3">
                        <label for="ex-wilaya" class="form-label fw-semibold text-secondary small">ولاية الشحن :</label>
                        <input type="text" class="form-control rounded-3 shadow-none" id="ex-wilaya" name="wilaya">
                    </div>
                    <div class="mb-3">
                        <label for="ex-api_id" class="form-label fw-semibold text-secondary small">API ID:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="ex-api_id" name="api_id">
                    </div>
                    <div class="mb-3">
                        <label for="ex-api_token" class="form-label fw-semibold text-secondary small">API TOKEN:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="ex-api_token" name="api_token">
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-0 py-3 px-4">
                <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">حفظ</button>
            </div>
        </div>
    </div>
</div>
<!-- End Expedigo Modal -->

<!-- Start Elogistia Modal -->
<div class="modal fade" id="ElogistiaModal" tabindex="-1" aria-labelledby="ElogistiaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-supplier-header py-3.5 px-4">
                <h5 class="modal-title fw-bold text-white fs-6"><i class="fa-solid fa-plug me-2"></i>ربط شركة Elogistia</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="post">
                    <div class="mb-4 text-center p-3 rounded-3 bg-light border">
                        <img src="https://i.imgur.com/aHASodC.png" alt="Elogistia" height="45" class="img-fluid" />
                    </div>
                    <div class="mb-3">
                        <label for="el-wilaya" class="form-label fw-semibold text-secondary small">ولاية الشحن :</label>
                        <input type="text" class="form-control rounded-3 shadow-none" id="el-wilaya" name="wilaya">
                    </div>
                    <div class="mb-3">
                        <label for="el-api_id" class="form-label fw-semibold text-secondary small">API ID:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="el-api_id" name="api_id">
                    </div>
                    <div class="mb-3">
                        <label for="el-api_token" class="form-label fw-semibold text-secondary small">API TOKEN:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="el-api_token" name="api_token">
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-0 py-3 px-4">
                <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">حفظ</button>
            </div>
        </div>
    </div>
</div>
<!-- End Elogistia Modal -->

<!-- Start Guepex Modal -->
<div class="modal fade" id="GuepexModal" tabindex="-1" aria-labelledby="GuepexModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-supplier-header py-3.5 px-4">
                <h5 class="modal-title fw-bold text-white fs-6"><i class="fa-solid fa-plug me-2"></i>ربط شركة Guepex</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="" method="post">
                    <div class="mb-4 text-center p-3 rounded-3 bg-light border">
                        <img src="https://www.guepex.com/assets/images/logo/logo-dark.webp" alt="Guepex" height="45" class="img-fluid" />
                    </div>
                    <div class="mb-3">
                        <label for="gu-wilaya" class="form-label fw-semibold text-secondary small">ولاية الشحن :</label>
                        <input type="text" class="form-control rounded-3 shadow-none" id="gu-wilaya" name="wilaya">
                    </div>
                    <div class="mb-3">
                        <label for="gu-api_id" class="form-label fw-semibold text-secondary small">API ID:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="gu-api_id" name="api_id">
                    </div>
                    <div class="mb-3">
                        <label for="gu-api_token" class="form-label fw-semibold text-secondary small">API TOKEN:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="gu-api_token" name="api_token">
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-0 py-3 px-4">
                <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">حفظ</button>
            </div>
        </div>
    </div>
</div>
<!-- End Guepex Modal -->

<!-- Start DHD Modal -->
<div class="modal fade" id="DHDModal" tabindex="-1" aria-labelledby="DHDModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form id="dhdForm">
                @csrf
                <input type="hidden" name="name" value="DHD">

                <div class="modal-header bg-supplier-header py-3.5 px-4">
                    <h5 class="modal-title fw-bold text-white fs-6">
                        <i class="fa-solid fa-plug me-2"></i>ربط شركة DHD Express
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="mb-4 text-center p-3 rounded-3 bg-light border">
                        <img src="https://i.imgur.com/PrM01pT.png" alt="DHD" height="45" class="img-fluid" />
                    </div>

                    <div class="mb-3">
                        <label for="dhd-token" class="form-label fw-semibold text-secondary small">API TOKEN المفتاح المفتاحي:</label>
                        <input type="text" class="form-control rounded-3 shadow-none font-monospace" id="dhd-token" name="token"
                            value="{{ old('token', isset($dhd) && $dhd->count() ? json_decode($dhd->data)->token : '') }}" placeholder="أدخل API Token">
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-outline-success rounded-3 px-3 fw-bold" id="testDHDConnection">
                        <i class="fa-solid fa-wifi me-1"></i>اختبار الاتصال
                    </button>
                    <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm">
                        <i class="fa-solid fa-save me-1"></i>حفظ البيانات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End DHD Modal -->

<style>
    .bg-navy-subtle {
        background-color: rgba(15, 23, 42, 0.1);
    }

    .border-navy-subtle {
        border-color: rgba(15, 23, 42, 0.25) !important;
    }

    .text-navy {
        color: #0f172a !important;
    }

    .bg-supplier-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
    }

    .btn-supplier-primary {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }

    .btn-supplier-primary:hover {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%) !important;
        color: #ffffff !important;
    }

    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .company-select-card {
        transition: border-color 0.2s ease, transform 0.2s ease;
    }

    .company-select-card:hover {
        border-color: #0f172a !important;
        background-color: rgba(15, 23, 42, 0.02);
    }

    .avatar-md {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    @media (max-width: 1024.98px) {
        .mobile-header-stack {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 1rem !important;
        }
    }
</style>
