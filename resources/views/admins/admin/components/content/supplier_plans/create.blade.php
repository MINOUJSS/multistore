<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-plus-circle text-warning"></i>
                    <span>{{ __('إضافة خطة جديدة') }}</span>
                    <span class="opacity-50">|</span>
                    <span>خطط الموردين</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    ✨ إنشاء خطة موردين جديدة
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    قم بملء البيانات الأساسية للخطة، وبعد الحفظ ستتمكن من تخصيص فترات التسعير (30، 90، 180، 365 يوماً) وإدارة الصلاحيات والمميزات.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.supplier_plans.index') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
                        <i class="fa-solid fa-arrow-right me-1"></i> العودة لقائمة الخطط
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-start">
                <i class="fa-solid fa-triangle-exclamation fs-5 me-2 mt-1 text-danger"></i>
                <div>
                    <strong class="d-block mb-1">يرجى تصحيح الأخطاء التالية:</strong>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Create Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-file-circle-plus" style="color: #a40c72;"></i>
                        <span>البيانات الأساسية للخطة</span>
                    </div>
                    <span class="text-muted small">جميع الحقول المعلمة بـ (*) إلزامية</span>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.supplier_plans.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold text-dark">
                                اسم الخطة <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror"
                                   placeholder="مثال: الخطة المجانية، الخطة المتقدمة، الخطة الاحترافية..."
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">الاسم الذي يظهر للموردين عند الترقية أو الاشتراك.</small>
                        </div>

                        <div class="mb-4">
                            <label for="price" class="form-label fw-semibold text-dark">
                                السعر الافتراضي للخطة (د.ج) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number"
                                       name="price"
                                       id="price"
                                       step="0.01"
                                       min="0"
                                       class="form-control form-control-lg rounded-start-3 @error('price') is-invalid @enderror"
                                       placeholder="0.00"
                                       value="{{ old('price', 0) }}"
                                       required>
                                <span class="input-group-text bg-light fw-bold text-muted px-3">د.ج (DZD)</span>
                            </div>
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">أدخل 0 إذا كانت الخطة مجانية بالكامل. يمكنك تخصيص فترات أسعار إضافية لاحقاً.</small>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold text-dark">
                                وصف الخطة
                            </label>
                            <textarea name="description"
                                      id="description"
                                      rows="4"
                                      class="form-control rounded-3 @error('description') is-invalid @enderror"
                                      placeholder="اكتب وصفاً موجزاً وجذاباً للخطة يوضح لمن تناسب هذه الخطة وأهم فوائدها...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info rounded-3 border-0 d-flex align-items-center gap-2 p-3 mb-4" style="background-color: rgba(79, 70, 229, 0.08); color: #3730a3;">
                            <i class="fa-solid fa-circle-info fs-5"></i>
                            <div class="small">
                                <strong>ملاحظة هامة:</strong> بعد الضغط على "حفظ الخطة"، سيتم نقلك مباشرة إلى لوحة تفاصيل الخطة حيث يمكنك إضافة مدد اشتراك مخصصة (كالاشتراك السنوي أو الفصلي) وضبط الصلاحيات المتاحة.
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top">
                            <a href="{{ route('admin.supplier_plans.index') }}" class="btn btn-light px-4 py-2 rounded-3 text-muted fw-semibold">
                                إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-bold shadow-sm" style="background-color: #a40c72; border-color: #a40c72;">
                                <i class="fa-solid fa-check me-1"></i> حفظ ومتابعة التخصيص
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
