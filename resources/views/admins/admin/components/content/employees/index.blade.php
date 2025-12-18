<div class="container my-4">
    <div class="page-header text-center mb-4">
        <h2 class="fw-bold text-primary">
            👨‍💼 قائمة الموظفين
        </h2>
        <p class="text-muted">إدارة بيانات الموظفين والتحكم في عمليات التعديل والحذف</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-hover align-middle mb-0">
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
                        <td>{{ $employee->id }}</td>
                        <td class="fw-semibold">{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
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

{{-- ✅ تحسينات تصميم إضافية --}}
<style>
    .page-header h2 {
        font-size: 1.8rem;
    }

    table th, table td {
        vertical-align: middle !important;
    }

    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 1.5rem;
        }
        .table-responsive {
            font-size: 0.9rem;
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
