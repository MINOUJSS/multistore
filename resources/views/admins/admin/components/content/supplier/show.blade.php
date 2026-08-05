{{-- resources/views/admin/suppliers/show.blade.php --}}
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                                <h5 class="h3 mb-0 text-gray-800">
                <i class="fa-solid fa-user me-2"></i> عمليات على حساب المورد 
            </h5>
                </div>
                <div class="card-body">
                                                    {{-- حالة الموافقة --}}
                                @if($supplier->approval_status == 'approved')
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#unApproveModal">حذف توثيق المورد</button>
                                @elseif($supplier->approval_status == 'pending')
                                    <button class="btn btn-primary" onclick="approveSupplier({{$supplier->id}})"> توثيق المورد</button>
                                @endif
                                <button class="btn btn-success" onclick="printSellerInfo()">
                                 طباعة معلومات المستخدم
                                </button>
                                <button class="btn btn-warning text-dark border-0 shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    <i class="fa-solid fa-key me-1"></i> تغيير كلمة المرور
                                </button>
                    
                </div>
            </div>
        </div>
    </div>
  <div id="printableArea">    
    {{-- معلومات المورد الرئيسية --}}
    <div class="row mb-4 mt-4">

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body d-flex flex-column flex-md-row align-items-center gap-4">

                    {{-- صورة المورد --}}
                    <div class="text-center">

                        <img
                            src="{{ $supplier->avatar ? asset($supplier->avatar) : asset('/asset/v1/users/dashboard/img/avatars/man.png') }}"
                            alt="{{ $supplier->full_name }}"
                            class="rounded-circle border"
                            width="130"
                            height="130"
                            style="object-fit: cover;"
                        >

                    </div>

                    {{-- المعلومات --}}
                    <div class="flex-grow-1">

                        <div class="d-flex flex-column flex-md-row justify-content-between">

                            <div>
                                <h2 class="fw-bold mb-1">
                                    {{ $supplier->full_name }}
                                </h2>

                                <p class="text-muted mb-2">
                                    {{ '@'.$supplier->store_name }}
                                </p>
                            </div>

                            <div class="mt-3 mt-md-0">

                                {{-- حالة التفعيل --}}
                                @if($supplier->status == 'active')

                                    <span class="badge bg-success px-3 py-2">
                                        مفعل
                                    </span>

                                @else

                                    <span class="badge bg-secondary px-3 py-2">
                                        غير مفعل
                                    </span>

                                @endif

                                {{-- حالة الموافقة --}}
                                @if($supplier->approval_status == 'approved')

                                    <span class="badge bg-primary px-3 py-2">
                                        تمت الموافقة
                                    </span>

                                @elseif($supplier->approval_status == 'pending')

                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        قيد المراجعة
                                    </span>

                                @else

                                    <span class="badge bg-danger px-3 py-2">
                                        مرفوض
                                    </span>

                                @endif

                            </div>

                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">
                                    البريد الإلكتروني
                                </small>

                                <strong>
                                    {{ $supplier->email }}
                                </strong>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">
                                    معرف التينانت
                                </small>

                                <strong>
                                    {{ $supplier->tenant_id }}
                                </strong>
                            </div>

                            <div class="col-md-4 mb-3">
                                <small class="text-muted d-block">
                                    الإسم الأول
                                </small>

                                <strong>
                                    {{ $supplier->first_name ?? '-' }}
                                </strong>
                            </div>

                            <div class="col-md-4 mb-3">
                                <small class="text-muted d-block">
                                    اللقب
                                </small>

                                <strong>
                                    {{ $supplier->last_name ?? '-' }}
                                </strong>
                            </div>

                            <div class="col-md-4 mb-3">
                                <small class="text-muted d-block">
                                    الجنس
                                </small>

                                <strong>
                                    @if($supplier->sex == 'male')
                                        ذكر
                                    @elseif($supplier->sex == 'female')
                                        أنثى
                                    @else
                                        -
                                    @endif
                                </strong>
                            </div>

                            <div class="col-md-4 mb-3">
                                <small class="text-muted d-block">
                                    تاريخ الميلاد
                                </small>

                                <strong>
                                    {{ $supplier->birth_date ?? '-' }}
                                </strong>
                            </div>

                            <div class="col-md-4 mb-3">
                                <small class="text-muted d-block">
                                    ضمن القائمة المعتمدة
                                </small>

                                <strong>
                                    {{ $supplier->part_of_approved_list == 'yes' ? 'نعم' : 'لا' }}
                                </strong>
                            </div>

                            <div class="col-md-4 mb-3">
                                <small class="text-muted d-block">
                                    تاريخ التسجيل
                                </small>

                                <strong>
                                    {{ $supplier->created_at->format('Y-m-d H:i') }}
                                </strong>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>

    {{-- معلومات العنوان --}}
    <div class="row mb-4">

        <div class="col-lg-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">
                        معلومات العنوان
                    </h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            الولاية
                        </small>

                        <strong>
                            {{ $supplier->wilaya ?? '-' }}
                        </strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            الدائرة
                        </small>

                        <strong>
                            {{ $supplier->dayra ?? '-' }}
                        </strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            البلدية
                        </small>

                        <strong>
                            {{ $supplier->baladia ?? '-' }}
                        </strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            العنوان الكامل
                        </small>

                        <strong>
                            {{ $supplier->address ?? '-' }}
                        </strong>
                    </div>

                </div>

            </div>

        </div>

        {{-- بطاقة الهوية --}}
        <div class="col-lg-6 mb-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">
                        صورة بطاقة الهوية
                    </h5>
                </div>

                <div class="card-body text-center">

                    @if($supplier->id_card_image)

                        <img
                            src="{{ asset($supplier->id_card_image) }}"
                            alt="بطاقة الهوية"
                            class="img-fluid rounded-4 border"
                            style="max-height: 400px;"
                        >

                    @else

                        <div class="py-5 text-muted">
                            لم يتم رفع صورة بطاقة الهوية
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- معلومات حساب المستخدم --}}
    <div class="row mb-4">

        <div class="col-12 mb-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="fw-bold mb-0">
                        معلومات الحساب
                    </h5>
                </div>

                <div class="card-body">

                    @if($user)

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <small class="text-muted d-block">
                                    الإسم
                                </small>

                                <strong>
                                    {{ $user->name }}
                                </strong>
                            </div>

                            <div class="col-md-3 mb-3">
                                <small class="text-muted d-block">
                                    البريد الإلكتروني
                                </small>

                                <strong>
                                    {{ $user->email }}
                                </strong>
                            </div>

                            <div class="col-md-3 mb-3">
                                <small class="text-muted d-block">
                                    رقم الهاتف
                                </small>

                                <strong>
                                    {{ $user->phone }}
                                </strong>
                            </div>

                            <div class="col-md-3 mb-3">
                                <small class="text-muted d-block">
                                    نوع الحساب
                                </small>

                                <strong>
                                    مورد
                                </strong>
                            </div>

                        </div>

                    @else

                        <div class="alert alert-warning rounded-4 mb-0">
                            لا يوجد حساب مستخدم مرتبط بهذا المورد.
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

  </div>

</div>

{{-- :::::::::::: Modals ::::::::::::: --}}
{{-- unpproveModal --}}
    <div class="modal fade" id="unApproveModal" tabindex="-1" aria-labelledby="unApproveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unApproveModalLabel">حذف توثيق المورد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.supplier.unapprove', $supplier->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
                        <div class="mb-3">
                          <label for="exampleFormControlTextarea1" class="form-label">سبب حذف التوثيق</label>
                          <textarea name="reason" class="form-control" placeholder="سبب الحذف"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                    
                        <button type="submit" class="btn btn-danger">حذف توثيق المورد</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{-- sweetalert  --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('approval_status')=='unapproved' )
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'تم حذف التوثيق بنجاح'
            })  
        </script>
    @endif

<!-- Modal 1: تغيير كلمة المرور -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-warning bg-opacity-10 border-0">
                <h5 class="modal-title fw-bold" id="changePasswordModalLabel">
                    <i class="fa-solid fa-key text-warning me-2"></i> تغيير كلمة المرور للمورد
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changePasswordForm" action="{{ route('admin.supplier.changePassword', $supplier->id) }}" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label for="newPasswordInput" class="form-label fw-semibold">كلمة المرور الجديدة</label>
                        <div class="input-group">
                            <input type="text" name="password" id="newPasswordInput" class="form-control" placeholder="أدخل كلمة المرور الجديدة..." required minlength="6">
                            <button type="button" class="btn btn-outline-secondary" onclick="generateRandomPassword()" title="توليد كلمة مرور عشوائية">
                                <i class="fa-solid fa-arrows-rotate me-1"></i> توليد
                            </button>
                        </div>
                        <div class="form-text text-muted">يجب أن تحتوي كلمة المرور على 6 أحرف على الأقل.</div>
                    </div>
                    <div id="changePasswordError" class="alert alert-danger d-none mb-0"></div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" id="savePasswordBtn" class="btn btn-warning text-dark fw-bold rounded-3">
                        <i class="fa-solid fa-floppy-disk me-1"></i> حفظ كلمة المرور
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: عرض كلمة المرور الجديدة لنسخها -->
<div class="modal fade" id="passwordSuccessModal" tabindex="-1" aria-labelledby="passwordSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-success text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="passwordSuccessModalLabel">
                    <i class="fa-solid fa-circle-check me-2"></i> تم تغيير كلمة المرور بنجاح
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="text-muted mb-3">تم تسجيل كلمة المرور الجديدة بنجاح في قاعدة البيانات. يمكنك نسخها أدناه لإرسالها للمورد:</p>
                <div class="input-group mb-3">
                    <input type="text" id="displayNewPassword" class="form-control text-center font-monospace fs-5 fw-bold bg-light" readonly>
                    <button class="btn btn-primary px-3" type="button" onclick="copyNewPassword()">
                        <i class="fa-solid fa-copy me-1"></i> <span id="copyBtnText">نسخ كلمة المرور</span>
                    </button>
                </div>
                <div id="copyAlertSuccess" class="alert alert-success d-none py-2 mb-0" role="alert">
                    <i class="fa-solid fa-check me-1"></i> تم نسخ كلمة المرور إلى الحافظة بنجاح!
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary w-100 rounded-3" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<script>
function generateRandomPassword() {
    const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
    let password = "";
    for (let i = 0; i < 10; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('newPasswordInput').value = password;
}

function copyNewPassword() {
    const passwordInput = document.getElementById('displayNewPassword');
    passwordInput.select();
    passwordInput.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(passwordInput.value).then(function() {
        const copyBtnText = document.getElementById('copyBtnText');
        const alertBox = document.getElementById('copyAlertSuccess');
        copyBtnText.innerText = 'تم النسخ!';
        alertBox.classList.remove('d-none');
        setTimeout(() => {
            copyBtnText.innerText = 'نسخ كلمة المرور';
            alertBox.classList.add('d-none');
        }, 3000);
    }).catch(function(err) {
        alert('تعذر النسخ تلقائياً: ' + err);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const changePasswordForm = document.getElementById('changePasswordForm');
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = document.getElementById('savePasswordBtn');
            const errorBox = document.getElementById('changePasswordError');
            const passwordInput = document.getElementById('newPasswordInput');
            
            errorBox.classList.add('d-none');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> جاري الحفظ...';

            const formData = new FormData(changePasswordForm);

            fetch(changePasswordForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> حفظ كلمة المرور';

                if (res.body.success) {
                    // Hide Modal 1
                    const modal1El = document.getElementById('changePasswordModal');
                    const modal1 = bootstrap.Modal.getInstance(modal1El) || new bootstrap.Modal(modal1El);
                    modal1.hide();

                    // Set password in Modal 2
                    document.getElementById('displayNewPassword').value = res.body.new_password;

                    // Show Modal 2
                    const modal2El = document.getElementById('passwordSuccessModal');
                    const modal2 = new bootstrap.Modal(modal2El);
                    modal2.show();

                    // Clear input
                    passwordInput.value = '';
                } else {
                    errorBox.innerText = res.body.message || 'حدث خطأ أثناء تغيير كلمة المرور';
                    errorBox.classList.remove('d-none');
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> حفظ كلمة المرور';
                errorBox.innerText = 'حدث خطأ في الاتصال بالسيرفر';
                errorBox.classList.remove('d-none');
            });
        });
    }

    @if(session('new_password'))
        document.getElementById('displayNewPassword').value = "{{ session('new_password') }}";
        const modal2El = document.getElementById('passwordSuccessModal');
        const modal2 = new bootstrap.Modal(modal2El);
        modal2.show();
    @endif
});
</script>