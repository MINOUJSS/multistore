<div class="container my-4">
    <div class="page-header text-center mb-4">
        <h2 class="fw-bold text-primary">
            ✏️ تعديل بيانات الموظف
        </h2>
        <p class="text-muted">قم بتحديث المعلومات الخاصة بالموظف في النظام</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-triangle me-2"></i> حدثت بعض الأخطاء أثناء إدخال البيانات:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">الاسم الكامل</label>
                        <input type="text" name="name" id="name" class="form-control"
                               placeholder="أدخل الاسم الكامل" value="{{ old('name', $employee->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" class="form-control"
                               placeholder="example@email.com" value="{{ old('email', $employee->email) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold">كلمة المرور الجديدة (اختياري)</label>
                        <input type="password" name="password" id="password" class="form-control"
                               placeholder="اتركه فارغًا إن لم ترغب بالتغيير">
                    </div>

                    <div class="col-md-6">
                        <label for="type" class="form-label fw-semibold">المنصب</label>
                        <select class="form-control" name="type" id="type">
                            <option value="manager" {{ $employee->type == 'manager' ? 'selected' : '' }}>مدير</option>
                            <option value="support" {{ $employee->type == 'support' ? 'selected' : '' }}>موظف دعم</option>
                            <option value="developer" {{ $employee->type == 'developer' ? 'selected' : '' }}>مطور</option>
                            <option value="financial_manager" {{ $employee->type == 'financial_manager' ? 'selected' : '' }}>مدير الحسابات</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold">رقم الهاتف</label>
                        <input type="text" name="phone" id="phone" class="form-control"
                               placeholder="05xxxxxxxx" value="{{ old('phone', $employee->phone) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="photo" class="form-label fw-semibold">صورة الموظف</label>
                        <input type="file" name="photo" id="photo" class="form-control">
                        @if ($employee->photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="صورة الموظف" class="img-thumbnail" width="120">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa fa-save me-2"></i> حفظ التعديلات
                    </button>

                    <a href="{{ route('admin.employees') }}" class="btn btn-outline-secondary px-4">
                        <i class="fa fa-arrow-right me-2"></i> العودة إلى القائمة
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 🎨 تحسينات التصميم --}}
<style>
    .page-header h2 {
        font-size: 1.8rem;
    }

    label {
        color: #333;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 1.5rem;
        }
        .card-body {
            padding: 1.5rem !important;
        }
    }

    @media (max-width: 576px) {
        .btn {
            font-size: 0.85rem;
            padding: 6px 12px;
        }
    }
</style>
