<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-gears text-warning"></i>
                    <span>{{ __('تكوين وإعدادات المنصة الشاملة') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    ⚙️ إعدادات المنصة العامة 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    إدارة قيم، حقول، وتفعيل خصائص المنصة والمتغيرات البرمجية.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm text-nowrap">
                        <i class="fa-solid fa-house me-1"></i> الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session()->get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Settings Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4">
            <!-- Navigation Tabs -->
            <ul class="nav nav-pills custom-settings-tabs gap-2" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-3 px-4 py-2.5 fw-bold" id="google-analitics-tab" data-bs-toggle="tab" data-bs-target="#google-analitics" type="button" role="tab" aria-controls="google analitics" aria-selected="true">
                        <i class="fa-solid fa-sliders me-2"></i> إعدادات المنصة (Platform Settings)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-3 px-4 py-2.5 fw-bold" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                        <i class="fa-solid fa-user-gear me-2"></i> الملف الشخصي (Profile)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-3 px-4 py-2.5 fw-bold" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
                        <i class="fa-solid fa-envelope me-2"></i> معلومات التواصل (Contact)
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="google-analitics" role="tabpanel" aria-labelledby="google-analitics-tab">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf

                        <div class="row g-4 mb-4">
                            @foreach($settings as $setting)
                                <div class="col-12">
                                    <div class="card border shadow-sm rounded-4 bg-white overflow-hidden">
                                        <div class="card-header bg-light border-0 py-3 px-4 d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fa-solid fa-key" style="color: #a40c72;"></i>
                                                <strong class="text-dark fs-6">{{ ucwords(str_replace('_',' ', $setting->key)) }}</strong>
                                            </div>
                                            <span class="badge bg-white text-muted border px-2.5 py-1 rounded-pill small dir-ltr">
                                                ID: {{ $setting->id }}
                                            </span>
                                        </div>

                                        <div class="card-body p-4">
                                            {{-- Key --}}
                                            <input type="hidden"
                                                   name="settings[{{ $setting->id }}][key]"
                                                   value="{{ $setting->key }}">

                                            {{-- Value --}}
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-dark mb-2">
                                                    القيمة (Value)
                                                </label>

                                                @if($setting->type == 'text')
                                                    <textarea class="form-control rounded-3 border-secondary-subtle" rows="6" name="settings[{{ $setting->id }}][value]">{{ $setting->value }}</textarea>
                                                @elseif($setting->type == 'boolean')
                                                    <select class="form-select rounded-3 border-secondary-subtle" name="settings[{{ $setting->id }}][value]">
                                                        <option value="1" {{ $setting->value ? 'selected' : '' }}>نعم (Yes)</option>
                                                        <option value="0" {{ !$setting->value ? 'selected' : '' }}>لا (No)</option>
                                                    </select>
                                                @else
                                                    <input type="text" class="form-control rounded-3 border-secondary-subtle" name="settings[{{ $setting->id }}][value]" value="{{ $setting->value }}">
                                                @endif
                                            </div>

                                            {{-- Description --}}
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-muted mb-2 small">
                                                    الوصف (Description)
                                                </label>
                                                <textarea class="form-control rounded-3 border-secondary-subtle" rows="2" name="settings[{{ $setting->id }}][description]">{{ $setting->description }}</textarea>
                                            </div>

                                            {{-- Status --}}
                                            <div class="form-check form-switch p-0 d-flex align-items-center gap-2">
                                                <input class="form-check-input ms-0 me-2" type="checkbox" value="active" name="settings[{{ $setting->id }}][status]" id="switch_{{ $setting->id }}" {{ $setting->status=='active' ? 'checked' : '' }}>
                                                <label class="form-check-label fw-semibold text-dark mb-0" for="switch_{{ $setting->id }}">
                                                    حالة التفعيل (Active)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary px-4 py-2.5 rounded-3 fw-bold shadow-sm" style="background-color: #a40c72; border-color: #a40c72;">
                                <i class="fa-solid fa-floppy-disk me-1"></i> حفظ جميع الإعدادات
                            </button>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-user-gear fs-1 mb-2 d-block opacity-50"></i>
                        <span>قسم الملف الشخصي متوفر ضمن تبويبات الأدمن الرئيسية.</span>
                    </div>
                </div>

                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-envelope-open-text fs-1 mb-2 d-block opacity-50"></i>
                        <span>قسم معلومات التواصل متوفر ضمن تبويبات المنصة الرئيسية.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .custom-settings-tabs .nav-link {
        color: #495057;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        transition: all .25s ease;
    }
    .custom-settings-tabs .nav-link:hover {
        background: #e9ecef;
        color: #a40c72;
    }
    .custom-settings-tabs .nav-link.active {
        background: #a40c72 !important;
        color: #ffffff !important;
        border-color: #a40c72 !important;
        box-shadow: 0 4px 12px rgba(164, 12, 114, 0.25);
    }
</style>