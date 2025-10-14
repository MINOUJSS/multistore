<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">قسم  {{$benefit->title}}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th width="20%">العنوان</th>
                                <th width="80%">الوصف</th>
                                <th width="10%">الإجراءات</th>
                            </tr>
                            <tr>
                                <td>{{ $benefit->title }}</td>
                                <td>{{ $benefit->description }}</td>
                                <td>
                                    <button class="btn btn-sm btn-circle btn-primary edit-benefit"
                                        data-id="{{ $benefit->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    {{-- <button class="btn btn-sm btn-circle btn-danger delete-benefit"
                                        data-id="{{ $benefit->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button> --}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">قائمة قسم {{$benefit->title}}</h6>
                    <button id="addElementBtn" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة عنصر جديد
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="elementsTable">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">العنوان</th>
                                    <th width="20%">الوصف</th>
                                    <th width="20%">الأيقونة</th>
                                    <th width="10%">الترتيب</th>
                                    <th width="15%">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($benefits_elements as $index => $element)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ Str::limit($element->title, 30) }}</td>
                                        <td>{{ Str::limit($element->description, 40) }}</td>
                                        <td>{!!$element->icon !!}</td>
                                        <td>{{ $element->order }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-circle btn-primary edit-element"
                                                data-id="{{ $element->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-circle btn-danger delete-element"
                                                data-id="{{ $element->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!---->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{route('supplier.benefits.updateStatus')}}" method="POST" class="row">
                        @csrf
                        <input type="hidden" name="benefit_id" value="{{$benefit->id}}">
                        <!-- التشيك بوكس على اليسار -->
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="sluster_status" name="benefit_status"
                                    @if ($benefit->status == 'active') checked @endif>
                                <label class="form-check-label" for="benefit_status">تفعيل قسم {{$benefit->title}}</label>
                            </div>
                        </div>

                        <!-- الزر على اليمين -->
                        <div class="col-md-6 text-end">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
            <!---->
        </div>
    </div>
</div>

{{-- //modals --}}

<!-- Add Element Modal -->
<div class="modal fade" id="addElementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">إضافة عنصر جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="addElementForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">العنوان</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                        <div class="invalid-feedback error-title"></div>
                    </div>

                    <div class="form-group">
                        <label for="description">الوصف</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback error-description"></div>
                    </div>

                    <div class="form-group">
                        <label for="icon">الأيقونة</label>
                        <input type="text" class="form-control" id="icon" name="icon">
                        <div class="invalid-feedback error-icon"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order">ترتيب العرض</label>
                                <input type="number" class="form-control" id="order" name="order"
                                    value="0" min="0">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Element Modal -->
<div class="modal fade" id="editElementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">تعديل العنصر</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="editElementForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_element_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_title">العنوان</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                        <div class="invalid-feedback error-title"></div>
                    </div>

                    <div class="form-group">
                        <label for="edit_description">الوصف</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback error-description"></div>
                    </div>

                    <div class="form-group">
                        <label for="edit_icon">الأيقونة</label>
                        <input type="text" class="form-control" id="edit_icon" name="icon">
                        <div class="invalid-feedback error-icon"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_order">ترتيب العرض</label>
                                <input type="number" class="form-control" id="edit_order" name="order"
                                    min="0">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- edite benefit Modal -->
<div class="modal fade" id="editBenefitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">تعديل القسم</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="editBenefitForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_benefit_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_benefit_title">العنوان</label>
                        <input type="text" class="form-control" id="edit_benefit_title" name="title" required>
                        <div class="invalid-feedback error-title"></div>
                    </div>
                    <div class="form-group">
                        <label for="edit_benefit_description">الوصف</label>
                        <input type="text" class="form-control" id="edit_benefit_description" name="description" required>
                        <div class="invalid-feedback error-description"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- sweet alert  --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
@if (session('success'))
    <script>
        Swal.fire({
            title: 'نجاح!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'حسنًا'
        });
    </script>
@endif
