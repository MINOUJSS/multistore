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
                        <i class="fa-solid fa-id-card text-warning"></i>
                        <span>{{ __('الملف الشخصي للموظف') }}</span>
                        <span class="opacity-50">|</span>
                        <span>#{{ $employee->id }}</span>
                    </div>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    👨‍💼 {{ $employee->name }} 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    عرض كافة تفاصيل الحساب، المنصب الوظيفي، وبيانات التواصل الخاصة بالموظف.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm">
                        <i class="fa-solid fa-pen-to-square me-1"></i> تعديل البيانات
                    </a>
                    <a href="{{ route('admin.employees') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
                        <i class="fa-solid fa-list me-1"></i> العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Details Cards -->
    <div class="row g-4 mb-4">
        <!-- Profile Card Left -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white text-center p-4 h-100">
                <div class="mb-3 position-relative d-inline-block mx-auto">
                    @if($employee->photo)
                        <img src="{{ asset('storage/' . $employee->photo) }}" alt="{{ $employee->name }}" class="rounded-circle border border-4 border-white shadow-sm object-fit-cover" width="110" height="110">
                    @else
                        <div class="avatar-lg rounded-circle d-flex align-items-center justify-content-center fw-bold fs-2 mx-auto border border-4 border-white shadow-sm" style="width: 110px; height: 110px; background-color: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                            {{ mb_substr($employee->name, 0, 1) }}
                        </div>
                    @endif
                    <span class="position-absolute bottom-0 start-0 bg-success text-white rounded-circle p-1 border border-2 border-white" title="حساب نشط" style="width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;">
                        <i class="fa-solid fa-check"></i>
                    </span>
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ $employee->name }}</h5>
                <p class="text-muted small mb-3 dir-ltr">{{ $employee->email }}</p>
                <div class="mb-4">
                    <span class="badge px-3 py-2 rounded-pill fw-semibold" style="background-color: rgba(164, 12, 114, 0.1); color: #a40c72;">
                        <i class="fa-solid fa-user-shield me-1"></i>
                        @switch($employee->type)
                            @case('manager') مدير النظام @break
                            @case('support') موظف دعم فني @break
                            @case('developer') مطور برمجيات @break
                            @case('financial_manager') مدير حسابات @break
                            @default {{ $employee->type }}
                        @endswitch
                    </span>
                </div>
                <div class="d-flex justify-content-center gap-2 pt-3 border-top">
                    <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-sm btn-primary rounded-3 px-3">
                        <i class="fa-solid fa-pen-to-square me-1"></i> تعديل
                    </a>
                    <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموظف؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3">
                            <i class="fa-solid fa-trash me-1"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Details Card Right -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                <h5 class="fw-bold text-dark mb-4 border-bottom pb-3">
                    <i class="fa-solid fa-circle-info me-2" style="color: #a40c72;"></i> التفاصيل والمعلومات الأساسية
                </h5>
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3 border-0">
                            <small class="text-muted fw-semibold d-block mb-1">الاسم الكامل:</small>
                            <div class="fw-bold text-dark fs-6">{{ $employee->name }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3 border-0">
                            <small class="text-muted fw-semibold d-block mb-1">البريد الإلكتروني:</small>
                            <div class="fw-bold text-dark fs-6 dir-ltr text-start">{{ $employee->email }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3 border-0">
                            <small class="text-muted fw-semibold d-block mb-1">رقم الهاتف:</small>
                            <div class="fw-bold text-dark fs-6 dir-ltr text-start">{{ $employee->phone ?: 'غير محدد' }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3 border-0">
                            <small class="text-muted fw-semibold d-block mb-1">المنصب / الصفة:</small>
                            <div class="fw-bold text-dark fs-6">
                                @switch($employee->type)
                                    @case('manager') مدير النظام @break
                                    @case('support') موظف دعم فني @break
                                    @case('developer') مطور برمجيات @break
                                    @case('financial_manager') مدير حسابات @break
                                    @default {{ $employee->type }}
                                @endswitch
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3 border-0">
                            <small class="text-muted fw-semibold d-block mb-1">تاريخ الانضمام:</small>
                            <div class="fw-bold text-dark fs-6">{{ $employee->created_at ? $employee->created_at->format('Y-m-d') : 'غير معروف' }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="p-3 bg-light rounded-3 border-0">
                            <small class="text-muted fw-semibold d-block mb-1">آخر تحديث:</small>
                            <div class="fw-bold text-dark fs-6">{{ $employee->updated_at ? $employee->updated_at->diffForHumans() : 'غير معروف' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
