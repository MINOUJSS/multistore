<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-users-gear text-warning"></i>
                    <span>{{ __('إدارة فريق العمل') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    👨‍💼 سجل الموظفين والإداريين 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    إدارة بيانات الموظفين، التحكم في الصلاحيات، وإضافة أعضاء جدد إلى فريق المنصة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.employees.create') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm">
                        <i class="fa-solid fa-user-plus me-1"></i> إضافة موظف جديد
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
                <div class="fw-semibold">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Employees Table Card -->
    <div class="card border-0 shadow-sm rounded-4 w-100 overflow-hidden" style="max-width: 100%;">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-id-card" style="color: #a40c72;"></i>
                <span>قائمة الموظفين المسجلين</span>
            </div>
            <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill">إجمالي الموظفين: {{ $employees->count() }}</span>
        </div>
        <div class="table-responsive p-0">
            <table class="table table-hover align-middle mb-0" id="employeesTable">
                <thead class="bg-light text-muted small text-center">
                    <tr>
                        <th class="py-3">#</th>
                        <th class="py-3">الاسم الكامل</th>
                        <th class="py-3">البريد الإلكتروني</th>
                        <th class="py-3">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($employees as $employee)
                        <tr>
                            <td data-label="#">
                                <span class="fw-bold text-primary dir-ltr">#{{ $employee->id }}</span>
                            </td>
                            <td data-label="الاسم الكامل" class="fw-bold text-dark">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center fw-bold text-primary" style="background-color: rgba(79, 70, 229, 0.1); width: 32px; height: 32px;">
                                        {{ mb_substr($employee->name, 0, 1) }}
                                    </div>
                                    <span>{{ $employee->name }}</span>
                                </div>
                            </td>
                            <td data-label="البريد الإلكتروني" class="text-muted dir-ltr">{{ $employee->email }}</td>
                            <td data-label="الإجراءات">
                                <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                    <a href="{{ route('admin.employees.edit', $employee->id) }}"
                                       class="btn btn-sm btn-outline-primary rounded-3 px-3">
                                       <i class="fa fa-edit me-1"></i> تعديل
                                    </a>

                                    <form action="{{ route('admin.employees.destroy', $employee->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا الموظف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3">
                                            <i class="fa fa-trash me-1"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted py-5">
                                <i class="fa-solid fa-users-slash fs-2 mb-2 d-block opacity-50"></i>
                                <h6>لا يوجد موظفون حالياً في النظام</h6>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Pure CSS Responsive Table for #employeesTable */
@media (max-width: 991.98px) {
    #employeesTable, 
    #employeesTable tbody, 
    #employeesTable tr, 
    #employeesTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #employeesTable thead {
        display: none !important;
    }
    
    #employeesTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #employeesTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #employeesTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #employeesTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>
