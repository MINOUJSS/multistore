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