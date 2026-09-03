<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-pen-to-square text-warning"></i>
                    <span>{{ __('تعديل الخطة') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ $plan->name }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    ✏️ تعديل الخطة: {{ $plan->name }}
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    تعديل البيانات الأساسية للخطة كاسم الخطة وسعرها الافتراضي والوصف التعريفي.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.supplier_plans.show', $plan->id) }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm">
                        <i class="fa-solid fa-gear me-1"></i> إدارة الأسعار والصلاحيات
                    </a>
                    <a href="{{ route('admin.supplier_plans.index') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
                        <i class="fa-solid fa-arrow-right me-1"></i> القائمة
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

    <!-- Edit Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-pen-nib" style="color: #a40c72;"></i>
                        <span>تحديث بيانات الخطة (#{{ $plan->id }})</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.supplier_plans.update', $plan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold text-dark">
                                اسم الخطة <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror"
                                   placeholder="اسم الخطة..."
                                   value="{{ old('name', $plan->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                       value="{{ old('price', $plan->price) }}"
                                       required>
                                <span class="input-group-text bg-light fw-bold text-muted px-3">د.ج (DZD)</span>
                            </div>
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold text-dark">
                                وصف الخطة
                            </label>
                            <textarea name="description"
                                      id="description"
                                      rows="4"
                                      class="form-control rounded-3 @error('description') is-invalid @enderror"
                                      placeholder="وصف الخطة...">{{ old('description', $plan->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top">
                            <a href="{{ route('admin.supplier_plans.show', $plan->id) }}" class="btn btn-light px-4 py-2 rounded-3 text-muted fw-semibold">
                                إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-bold shadow-sm" style="background-color: #a40c72; border-color: #a40c72;">
                                <i class="fa-solid fa-save me-1"></i> حفظ التعديلات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
