<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-gear text-warning"></i>
                    <span class="fw-semibold">{{ __('مركز إعدادات متجر التوريد والهوية البصرية') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    إعدادات المتجر والتصميم للتوريد ⚙️
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    تخصيص الهوية البصرية، ألوان الثيم، بيانات المتجر الأساسية، الصفحات التعريفية، وأقسام الواجهة من مكان واحد.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('supplier.dashboard') }}"
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
        <div class="position-absolute rounded-circle bg-primary opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 p-3 mb-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <span class="fw-semibold">{{ session()->get('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Card with Custom Tabs Header -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
        <!-- Navigation Tabs Header -->
        <div class="card-header bg-light-subtle border-bottom p-3">
            <ul class="nav nav-pills gap-2" id="myTab" role="tablist">
                <!-- Theme Tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-3 fw-bold px-3.5 py-2.5 {{ session('active_tab') == 'store_setting' ? '' : 'active' }}"
                        id="theme-tab" data-bs-toggle="tab" data-bs-target="#theme" type="button" role="tab"
                        aria-controls="theme" aria-selected="true">
                        <i class="fa-solid fa-palette me-1.5 text-navy"></i> الثيم والهوية
                    </button>
                </li>

                <!-- Store Setting Tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-3 fw-bold px-3.5 py-2.5 {{ session('active_tab') == 'store_setting' ? 'active' : '' }}"
                        id="store-setting-tab" data-bs-toggle="tab" data-bs-target="#store-setting" type="button"
                        role="tab" aria-controls="store-setting" aria-selected="false">
                        <i class="fas fa-store-alt me-1.5 text-primary"></i> إعدادات المتجر
                    </button>
                </li>

                <!-- Store Pages Tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-3 fw-bold px-3.5 py-2.5" id="about-store-tab" data-bs-toggle="tab" data-bs-target="#about-store"
                        type="button" role="tab" aria-controls="about-store" aria-selected="false">
                        <i class="fa-solid fa-file-contract me-1.5 text-success"></i> صفحات المتجر
                    </button>
                </li>

                <!-- Store Content Tab -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-3 fw-bold px-3.5 py-2.5" id="content-store-tab" data-bs-toggle="tab" data-bs-target="#content-store"
                        type="button" role="tab" aria-controls="content-store" aria-selected="false">
                        <i class="fa-solid fa-cubes-stacked me-1.5 text-info"></i> محتوى الواجهة
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4 p-md-5">
            <div class="tab-content" id="myTabContent">
                <!-- TAB 1: THEME & LOGO -->
                <div class="tab-pane fade {{ session('active_tab') == 'store_setting' ? '' : 'show active' }}"
                    id="theme" role="tabpanel" aria-labelledby="theme-tab">
                    <form action="{{ route('supplier.theme-update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- الشعار والهوية البصرية -->
                        <div class="card border rounded-4 p-4 mb-4 bg-light-subtle">
                            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                                <i class="fa-solid fa-image text-navy me-1"></i> شعار وهوية المتجر
                            </h5>

                            <div class="row align-items-center g-4">
                                <div class="col-12 col-md-5 col-lg-4">
                                    <label for="storeLogo" class="form-label fw-bold text-dark mb-1">رفع شعار المتجر</label>
                                    <p class="text-muted small mb-2">المواصفات الفنية الموصى بها للشعار:</p>
                                    <ul class="text-muted small ps-3 mb-0">
                                        <li>الأبعاد الموصى بها: 300 × 300 بيكسل</li>
                                        <li>الامتدادات المقبولة: JPEG, PNG, JPG</li>
                                        <li>حجم الملف الأقصى: 2 ميجابايت</li>
                                    </ul>
                                </div>

                                <div class="col-12 col-md-4 col-lg-4 text-center">
                                    <div id="dropzone" onclick="browsdialog()" onchange="previewLogo(event)"
                                        class="p-4 border border-2 border-dashed rounded-4 bg-white cursor-pointer transition-all hover-shadow text-center">
                                        <i class="fa-solid fa-cloud-arrow-up display-5 text-navy mb-2"></i>
                                        <span class="d-block fw-bold text-dark small">اضغط هنا لاختيار الشعار</span>
                                        <span class="text-muted fs-7">أو اسحب وأفلت الملف</span>
                                        <input type="file" name="image" class="form-control" id="storeLogo" accept="image/*" style="display: none;">
                                    </div>
                                </div>

                                <div class="col-12 col-md-3 col-lg-4 text-center">
                                    <span class="d-block fw-bold text-dark small mb-2">معاينة الشعار الحالي</span>
                                    <div id="logoPreview" class="preview rounded-4 border p-2 bg-white d-inline-block shadow-sm"
                                        style="width: 150px; height: 150px; background-image: url('{{ get_store_logo(Auth::user()->tenant_id) }}'); background-size: contain; background-repeat: no-repeat; background-position: center;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- قسم الألوان -->
                        <div class="card border rounded-4 p-4 mb-4 bg-light-subtle">
                            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                                <i class="fa-solid fa-swatchbook text-navy me-1"></i> ألوان الثيم وتنسيق النصوص
                            </h5>

                            <div class="row g-4">
                                <div class="col-12 col-md-4">
                                    <div class="bg-white p-3.5 rounded-3 border text-start">
                                        <label for="primaryColor" class="form-label fw-bold text-dark small mb-2">اللون الرئيسي للمتجر</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <input type="color" class="form-control form-control-color w-100 rounded-3 cursor-pointer" id="primaryColor"
                                                value="{{ get_store_parimary_color(Auth::user()->tenant_id) }}" style="height: 45px;">
                                            <input type="hidden" name="primarycollor" id="hiddenPrimaryCollor"
                                                value="{{ get_store_parimary_color(Auth::user()->tenant_id) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="bg-white p-3.5 rounded-3 border text-start">
                                        <label for="bodytextcolor" class="form-label fw-bold text-dark small mb-2">لون الخط الرئيسي للمتجر</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <input type="color" class="form-control form-control-color w-100 rounded-3 cursor-pointer" id="bodytextcolor"
                                                value="{{ get_store_body_text_color(Auth::user()->tenant_id) }}" style="height: 45px;">
                                            <input type="hidden" name="bodytextcolor" id="hiddenbodytextcolor"
                                                value="{{ get_store_body_text_color(Auth::user()->tenant_id) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="bg-white p-3.5 rounded-3 border text-start">
                                        <label for="footertextcolor" class="form-label fw-bold text-dark small mb-2">لون الخط في الفوتر (Footer)</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <input type="color" class="form-control form-control-color w-100 rounded-3 cursor-pointer" id="footertextcolor"
                                                value="{{ get_store_footer_text_color(Auth::user()->tenant_id) }}" style="height: 45px;">
                                            <input type="hidden" name="footertextcolor" id="hiddenfootertextcolor"
                                                value="{{ get_store_footer_text_color(Auth::user()->tenant_id) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- زر الحفظ -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-supplier-primary px-5 py-2.5 rounded-3 fw-bold shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1"></i> حفظ إعدادات الثيم
                            </button>
                        </div>
                    </form>
                </div>

                <!-- TAB 2: STORE SETTING -->
                <div class="tab-pane fade {{ session('active_tab') == 'store_setting' ? 'show active' : '' }}"
                    id="store-setting" role="tabpanel" aria-labelledby="store-setting-tab">
                    @include('users.suppliers.components.content.settings.inc.setting_form')
                </div>

                <!-- TAB 3: STORE PAGES -->
                <div class="tab-pane fade" id="about-store" role="tabpanel" aria-labelledby="about-store-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                        @foreach ($pages as $page)
                            <div class="col">
                                <div class="card h-100 border shadow-sm rounded-4 overflow-hidden transition-all hover-lift">
                                    <div class="card-body d-flex flex-column justify-content-between p-4">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="card-title fw-bold text-dark mb-0">{{ $page['title'] }}</h5>
                                                @if($page['status'] == 'published')
                                                    <span class="badge bg-success-subtle text-success border border-success rounded-pill px-2.5 py-1 small">منشورة</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-2.5 py-1 small">مسودة</span>
                                                @endif
                                            </div>
                                            <p class="card-text text-muted small leading-relaxed line-clamp-3 mb-3">
                                                {{ $page['meta_description'] ?: 'لا يوجد وصف مختصر لهذه الصفحة.' }}
                                            </p>
                                        </div>
                                        <button class="btn btn-outline-navy w-100 rounded-3 fw-bold mt-3" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $page['id'] }}">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> تعديل المحتوى
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Page Edit Modal -->
                            <div class="modal fade" id="editModal{{ $page['id'] }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $page['id'] }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <form method="POST" action="{{ route('supplier.page.update', $page->id) }}">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-header bg-navy-subtle border-bottom">
                                                <h5 class="modal-title fw-bold text-navy" id="editModalLabel{{ $page->id }}">
                                                    <i class="fa-solid fa-file-pen me-1"></i> تعديل محتوى: {{ $page->title }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                            </div>

                                            <div class="modal-body p-4 text-start">
                                                <!-- العنوان -->
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark small">عنوان الصفحة</label>
                                                    <input type="text" class="form-control rounded-3" name="title"
                                                        value="{{ $page->title }}" required>
                                                </div>

                                                <!-- المحتوى -->
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark small">محتوى الصفحة</label>
                                                    <div id="editor{{ $page->id }}" class="quill-editor bg-white rounded-3 border"
                                                        style="height: 300px;">{!! $page->content !!}</div>
                                                    <input type="hidden" name="content" id="contentInput{{ $page->id }}">
                                                </div>

                                                <!-- ميتا تايتل -->
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark small">العنوان المحسن (Meta Title)</label>
                                                    <input type="text" class="form-control rounded-3" name="meta_title"
                                                        value="{{ $page->meta_title }}">
                                                </div>

                                                <!-- ميتا وصف -->
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark small">الوصف المحسن (Meta Description)</label>
                                                    <textarea class="form-control rounded-3" name="meta_description" rows="3">{{ $page->meta_description }}</textarea>
                                                </div>

                                                <!-- كلمات مفتاحية -->
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark small">الكلمات المفتاحية (Meta Keywords)</label>
                                                    <input type="text" class="form-control rounded-3" name="meta_keywords"
                                                        value="{{ $page->meta_keywords }}">
                                                </div>

                                                <!-- الحالة -->
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark small">حالة النشر</label>
                                                    <select class="form-select rounded-3" name="status">
                                                        <option value="published" {{ $page->status == 'published' ? 'selected' : '' }}>منشورة العامة</option>
                                                        <option value="draft" {{ $page->status == 'draft' ? 'selected' : '' }}>مسودة غير منشورة</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="modal-footer bg-light-subtle border-top">
                                                <button type="submit" class="btn btn-supplier-primary px-4 rounded-3 fw-bold"
                                                    onclick="saveEditorContent({{ $page->id }})">حفظ التغييرات</button>
                                                <button type="button" class="btn btn-light text-dark px-4 rounded-3 fw-bold"
                                                    data-bs-dismiss="modal">إغلاق</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- TAB 4: STORE CONTENT -->
                <div class="tab-pane fade" id="content-store" role="tabpanel" aria-labelledby="content-store-tab">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <div class="col">
                            <div class="card h-100 border shadow-sm rounded-4 overflow-hidden transition-all hover-lift">
                                <div class="card-body d-flex flex-column justify-content-between p-4">
                                    <div>
                                        <div class="d-inline-flex align-items-center justify-content-center p-3 rounded-3 bg-navy-subtle text-navy mb-3">
                                            <i class="fa-solid fa-images fs-4"></i>
                                        </div>
                                        <h5 class="card-title fw-bold text-dark mb-2">قسم السلايدر (Sliders)</h5>
                                        <p class="card-text text-muted small leading-relaxed">
                                            إدارة صور البانرات الإعلانية المتحركة في الواجهة الرئيسية لمتجر التوريد.
                                        </p>
                                    </div>
                                    <a href="{{ route('supplier.sliders.index') }}" class="btn btn-supplier-primary w-100 rounded-3 fw-bold mt-3">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> تعديل المحتوى
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card h-100 border shadow-sm rounded-4 overflow-hidden transition-all hover-lift">
                                <div class="card-body d-flex flex-column justify-content-between p-4">
                                    <div>
                                        <div class="d-inline-flex align-items-center justify-content-center p-3 rounded-3 bg-primary-subtle text-primary mb-3">
                                            <i class="fa-solid fa-list-check fs-4"></i>
                                        </div>
                                        <h5 class="card-title fw-bold text-dark mb-2">قسم أصناف المنتجات</h5>
                                        <p class="card-text text-muted small leading-relaxed">
                                            تنظيم وترتيب فئات وأقسام منتجات التوريد المعروضة للزبائن.
                                        </p>
                                    </div>
                                    <a href="{{ route('supplier.categories.index') }}" class="btn btn-supplier-primary w-100 rounded-3 fw-bold mt-3">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> تعديل المحتوى
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card h-100 border shadow-sm rounded-4 overflow-hidden transition-all hover-lift">
                                <div class="card-body d-flex flex-column justify-content-between p-4">
                                    <div>
                                        <div class="d-inline-flex align-items-center justify-content-center p-3 rounded-3 bg-success-subtle text-success mb-3">
                                            <i class="fa-solid fa-gem fs-4"></i>
                                        </div>
                                        <h5 class="card-title fw-bold text-dark mb-2">قسم {{ $benefit_section->title }}</h5>
                                        <p class="card-text text-muted small leading-relaxed">
                                            تعديل مزايا وخصائص المبيعات والضمانات المعروضة في المتجر.
                                        </p>
                                    </div>
                                    <a href="{{ route('supplier.benefits.element.index') }}" class="btn btn-supplier-primary w-100 rounded-3 fw-bold mt-3">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> تعديل المحتوى
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card h-100 border shadow-sm rounded-4 overflow-hidden transition-all hover-lift">
                                <div class="card-body d-flex flex-column justify-content-between p-4">
                                    <div>
                                        <div class="d-inline-flex align-items-center justify-content-center p-3 rounded-3 bg-warning-subtle text-warning-emphasis mb-3">
                                            <i class="fa-solid fa-circle-question fs-4"></i>
                                        </div>
                                        <h5 class="card-title fw-bold text-dark mb-2">قسم الأسئلة الشائعة</h5>
                                        <p class="card-text text-muted small leading-relaxed">
                                            إضافة وتعديل الأسئلة الشائعة والإجابات الجاهزة للعملاء.
                                        </p>
                                    </div>
                                    <a href="{{ route('supplier.faqs.index') }}" class="btn btn-supplier-primary w-100 rounded-3 fw-bold mt-3">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> تعديل المحتوى
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card h-100 border shadow-sm rounded-4 overflow-hidden transition-all hover-lift">
                                <div class="card-body d-flex flex-column justify-content-between p-4">
                                    <div>
                                        <div class="d-inline-flex align-items-center justify-content-center p-3 rounded-3 bg-info-subtle text-info mb-3">
                                            <i class="fa-solid fa-wpforms fs-4"></i>
                                        </div>
                                        <h5 class="card-title fw-bold text-dark mb-2">قسم فورم الطلب</h5>
                                        <p class="card-text text-muted small leading-relaxed">
                                            تحديد الحقول المطلوبة والشكل العام لاستمارة الشراء المباشر.
                                        </p>
                                    </div>
                                    <a href="{{ route('supplier.order-form.index') }}" class="btn btn-supplier-primary w-100 rounded-3 fw-bold mt-3">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> تعديل المحتوى
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

    .btn-outline-navy {
        border-color: #0f172a !important;
        color: #0f172a !important;
    }

    .btn-outline-navy:hover {
        background-color: #0f172a !important;
        color: #ffffff !important;
    }

    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    /* Style Nav Pills Tabs */
    #myTab .nav-link {
        color: #475569;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    #myTab .nav-link.active {
        color: #ffffff !important;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        border-color: transparent !important;
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.25);
    }

    #myTab .nav-link.active i {
        color: #ffffff !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if we should activate the store settings tab
        const shouldActivateStoreTab = {{ session()->has('activate_store_tab') ? 'true' : 'false' }};

        if (shouldActivateStoreTab) {
            // Get the tab and pane elements
            const storeTab = document.getElementById('store-setting-tab');
            const storePane = document.getElementById('store-setting');

            // Remove active classes from all tabs/panes
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });

            // Add active classes to store settings tab
            storeTab.classList.add('active');
            storePane.classList.add('show', 'active');

            // Scroll to the tab if needed
            storeTab.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }

        // Clear the activation flag from session
        @if (session()->has('activate_store_tab'))
            fetch('{{ route('supplier.clear.tab.flag') }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        @endif
    });
</script>
