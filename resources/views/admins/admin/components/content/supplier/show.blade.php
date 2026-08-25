<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-7 mb-3 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <a href="{{ route('admin.suppliers') }}" class="btn btn-sm btn-light text-dark rounded-circle border-0 shadow-sm" title="العودة للقائمة">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small border border-white border-opacity-10">
                        <i class="fa-solid fa-store text-warning"></i>
                        <span>{{ __('ملف وتفاصيل المورد') }}</span>
                        <span class="opacity-50">|</span>
                        <span>{{ '@'.$supplier->store_name }}</span>
                    </div>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🏬 {{ $supplier->full_name }} 👋
                </h1>
                <div class="d-flex align-items-center gap-2 flex-wrap text-white-50">
                    <span>البريد: <strong class="text-white dir-ltr">{{ $supplier->email }}</strong></span>
                    <span class="opacity-50">•</span>
                    <span>تاريخ التسجيل: <strong class="text-white">{{ $supplier->created_at->format('Y-m-d') }}</strong></span>
                </div>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    {{-- حالة الموافقة --}}
                    @if($supplier->approval_status == 'approved')
                        <button class="btn btn-danger text-white fw-bold px-3 py-2 rounded-3 shadow-sm border-0" data-bs-toggle="modal" data-bs-target="#unApproveModal">
                            <i class="fa-solid fa-user-xmark me-1"></i> حذف توثيق المورد
                        </button>
                    @elseif($supplier->approval_status == 'pending')
                        <button class="btn btn-success text-white fw-bold px-3 py-2 rounded-3 shadow-sm border-0" onclick="approveSupplier({{$supplier->id}})">
                            <i class="fa-solid fa-user-check me-1"></i> توثيق المورد
                        </button>
                    @endif
                    <button class="btn btn-light text-dark fw-bold px-3 py-2 rounded-3 shadow-sm border-0" onclick="printSellerInfo()">
                        <i class="fa-solid fa-print me-1"></i> طباعة المعلومات
                    </button>
                    <button class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 shadow-sm border-0" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fa-solid fa-key me-1"></i> تغيير كلمة المرور
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="printableArea">   
        <!-- Supplier Main Profile Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-4">
                    {{-- Avatar --}}
                    <div class="text-center position-relative">
                        <img src="{{ $supplier->avatar ? asset($supplier->avatar) : asset('/asset/v1/users/dashboard/img/avatars/man.png') }}"
                            alt="{{ $supplier->full_name }}"
                            class="rounded-circle border shadow-sm object-fit-cover"
                            width="120" height="120">
                    </div>

                    {{-- Info Details --}}
                    <div class="flex-grow-1 w-100">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
                            <div>
                                <h3 class="fw-bold text-dark mb-1">{{ $supplier->full_name }}</h3>
                                <p class="text-primary mb-0 dir-ltr text-start fw-semibold">{{ '@'.$supplier->store_name }}</p>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                {{-- Activation Status --}}
                                @if($supplier->status == 'active')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill fw-bold">مفعل</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border px-3 py-1.5 rounded-pill fw-bold">غير مفعل</span>
                                @endif

                                {{-- Approval Status --}}
                                @if($supplier->approval_status == 'approved')
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1.5 rounded-pill fw-bold">تمت الموافقة</span>
                                @elseif($supplier->approval_status == 'pending')
                                    <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 px-3 py-1.5 rounded-pill fw-bold">قيد المراجعة</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-1.5 rounded-pill fw-bold">مرفوض</span>
                                @endif
                            </div>
                        </div>

                        <div class="row g-3 pt-3 border-top">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">البريد الإلكتروني:</small>
                                    <div class="fw-bold text-dark dir-ltr text-start small">{{ $supplier->email }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">معرف التينانت:</small>
                                    <div class="fw-bold text-dark dir-ltr text-start small">{{ $supplier->tenant_id }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">الإسم الأول واللقب:</small>
                                    <div class="fw-bold text-dark fs-6">{{ $supplier->first_name ?? '-' }} {{ $supplier->last_name ?? '' }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">الجنس:</small>
                                    <div class="fw-bold text-dark fs-6">
                                        @if($supplier->sex == 'male') ذكر @elseif($supplier->sex == 'female') أنثى @else - @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">تاريخ الميلاد:</small>
                                    <div class="fw-bold text-dark fs-6 dir-ltr text-start">{{ $supplier->birth_date ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">ضمن القائمة المعتمدة:</small>
                                    <div class="fw-bold text-dark fs-6">{{ $supplier->part_of_approved_list == 'yes' ? 'نعم' : 'لا' }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted fw-semibold d-block mb-1">تاريخ التسجيل:</small>
                                    <div class="fw-bold text-dark fs-6 dir-ltr text-start">{{ $supplier->created_at->format('Y-m-d H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address & ID Card Row -->
        <div class="row g-4 mb-4">
            <!-- Address Card -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4">
                    <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                        <i class="fa-solid fa-location-dot me-2" style="color: #a40c72;"></i> معلومات العنوان
                    </h5>
                    <div class="row g-3">
                        <div class="col-12 col-sm-4">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted fw-semibold d-block mb-1">الولاية:</small>
                                <div class="fw-bold text-dark fs-6">{{ $supplier->wilaya ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted fw-semibold d-block mb-1">الدائرة:</small>
                                <div class="fw-bold text-dark fs-6">{{ $supplier->dayra ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted fw-semibold d-block mb-1">البلدية:</small>
                                <div class="fw-bold text-dark fs-6">{{ $supplier->baladia ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted fw-semibold d-block mb-1">العنوان الكامل:</small>
                                <div class="fw-bold text-dark fs-6">{{ $supplier->address ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ID Card Image Card -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4 text-center">
                    <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom text-start">
                        <i class="fa-solid fa-id-card me-2" style="color: #a40c72;"></i> صورة بطاقة الهوية
                    </h5>
                    @if($supplier->id_card_image)
                        <a href="{{ asset($supplier->id_card_image) }}" target="_blank" class="d-inline-block mt-2">
                            <img src="{{ asset($supplier->id_card_image) }}" alt="بطاقة الهوية" class="img-fluid rounded-4 border shadow-sm object-fit-cover hover-lift" style="max-height: 250px;">
                        </a>
                    @else
                        <div class="p-4 bg-light rounded-3 text-muted my-auto">
                            <i class="fa-solid fa-id-card fs-2 mb-2 d-block opacity-50"></i>
                            <span>لم يتم رفع صورة بطاقة الهوية بعد.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Account Linked Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 p-4">
            <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                <i class="fa-solid fa-user-gear me-2" style="color: #a40c72;"></i> معلومات حساب المستخدم المرتبط
            </h5>
            @if($user)
                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">الإسم الكامل:</small>
                            <div class="fw-bold text-dark fs-6">{{ $user->name }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">البريد الإلكتروني:</small>
                            <div class="fw-bold text-dark dir-ltr text-start small">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">رقم الهاتف:</small>
                            <div class="fw-bold text-dark dir-ltr text-start small">{{ $user->phone }}</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted fw-semibold d-block mb-1">نوع الحساب:</small>
                            <div class="fw-bold text-primary fs-6">مورد (Supplier)</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning rounded-3 mb-0">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> لا يوجد حساب مستخدم مرتبط بهذا المورد حالياً.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- :::::::::::: Modals ::::::::::::: --}}
{{-- unpproveModal --}}
    <div class="modal fade" id="unApproveModal" tabindex="-1" aria-labelledby="unApproveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="unApproveModalLabel">حذف توثيق المورد</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.supplier.unapprove', $supplier->id) }}" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
                        <div class="mb-3">
                          <label for="exampleFormControlTextarea1" class="form-label fw-semibold">سبب حذف التوثيق</label>
                          <textarea name="reason" class="form-control rounded-3" placeholder="أدخل سبب إلغاء التوثيق هنا..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-danger rounded-3 fw-bold">حذف توثيق المورد</button>
                    </div>
                </form>
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