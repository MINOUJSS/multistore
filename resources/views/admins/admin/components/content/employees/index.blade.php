<div class="container-fluid py-4 overflow-hidden" style="max-width: 100%;">
    <div class="page-header text-center mb-4">
        <h2 class="fw-bold text-primary">
            👨‍💼 قائمة الموظفين
        </h2>
        <p class="text-muted mb-0">إدارة بيانات الموظفين والتحكم في عمليات التعديل والحذف</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 w-100 overflow-hidden" style="max-width: 100%;">
        <div class="table-responsive p-0">
            <table class="table table-hover align-middle mb-0" id="employeesTable">
                <thead class="table-primary text-center">
                    <tr>
                        <th>#</th>
                        <th>الاسم الكامل</th>
                        <th>البريد الإلكتروني</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($employees as $employee)
                        <tr>
                            <td data-label="#">{{ $employee->id }}</td>
                            <td data-label="الاسم الكامل" class="fw-semibold">{{ $employee->name }}</td>
                            <td data-label="البريد الإلكتروني">{{ $employee->email }}</td>
                            <td data-label="الإجراءات">
                                <div class="d-flex justify-content-center justify-content-lg-center align-items-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.employees.edit', $employee->id) }}"
                                       class="btn btn-sm btn-outline-primary px-3">
                                       <i class="fa fa-edit"></i> تعديل
                                    </a>

                                    <form action="{{ route('admin.employees.destroy', $employee->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا الموظف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3">
                                            <i class="fa fa-trash"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted py-4">
                                <i class="fa fa-info-circle"></i> لا يوجد موظفون حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .page-header h2 {
        font-size: 1.8rem;
    }

    table th, table td {
        vertical-align: middle !important;
    }

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

    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .page-header p {
            font-size: 0.85rem;
        }
        .btn {
            font-size: 0.8rem;
            padding: 4px 8px;
        }
    }
</style>
