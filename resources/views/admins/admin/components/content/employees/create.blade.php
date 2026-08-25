<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <a href="{{ route('admin.employees') }}" class="btn btn-sm btn-light text-dark rounded-circle border-0 shadow-sm" title="العودة للقائمة">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small border border-white border-opacity-10">
                        <i class="fa-solid fa-user-plus text-warning"></i>
                        <span>{{ __('إضافة عضو جديد') }}</span>
                        <span class="opacity-50">|</span>
                        <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                    </div>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    ➕ إضافة موظف جديد 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    قم بملء البيانات والمعلومات التالية لإضافة موظف وتحديد منصبه وتراخيصه في النظام.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.employees') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
                        <i class="fa-solid fa-list me-1"></i> العودة إلى القائمة
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center mb-1">
                <i class="fa-solid fa-triangle-exclamation fs-5 me-2 text-danger"></i>
                <strong class="fw-bold">حدثت بعض الأخطاء أثناء إدخال البيانات:</strong>
            </div>
            <ul class="mb-0 mt-2 pe-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
                <div class="fw-semibold">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-user-gear" style="color: #a40c72;"></i>
            <span>معلومات وبيانات الموظف الجديد</span>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold text-dark">الاسم الكامل <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted"></i></span>
                            <input type="text" name="name" id="name" class="form-control bg-light border-0 rounded-end-3"
                                   placeholder="أدخل الاسم الكامل للموظف" value="{{ old('name') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold text-dark">البريد الإلكتروني <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="email" name="email" id="email" class="form-control bg-light border-0 rounded-end-3"
                                   placeholder="example@email.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold text-dark">كلمة المرور <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-key text-muted"></i></span>
                            <input type="text" name="password" id="password" class="form-control bg-light border-0 rounded-end-3"
                                   placeholder="********" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="type" class="form-label fw-semibold text-dark">المنصب / الصلاحية <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user-shield text-muted"></i></span>
                            <select class="form-select bg-light border-0 rounded-end-3" name="type" id="type">
                                <option value="manager">مدير</option>
                                <option value="support">موظف</option>
                                <option value="devloper">مطور</option>
                                <option value="financial_manager">مدير الحسابات</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold text-dark">رقم الهاتف</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-phone text-muted"></i></span>
                            <input type="text" name="phone" id="phone" class="form-control bg-light border-0 rounded-end-3"
                                   placeholder="05xxxxxxxx" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="photo" class="form-label fw-semibold text-dark">صورة الموظف الشخصية</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-image text-muted"></i></span>
                            <input type="file" name="photo" id="photo" class="form-control bg-light border-0 rounded-end-3">
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4 pt-3 border-top">
                    <button type="submit" class="btn text-white px-4 py-2.5 fw-bold rounded-3" style="background-color: #a40c72;">
                        <i class="fa-solid fa-floppy-disk me-1"></i> حفظ الموظف
                    </button>

                    <a href="{{ route('admin.employees') }}" class="btn btn-light border px-4 py-2.5 rounded-3 fw-semibold">
                        <i class="fa-solid fa-arrow-right me-1"></i> العودة إلى القائمة
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
