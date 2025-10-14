<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">إدارة السلايدرات</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">قائمة السلايدرات</h6>
                    <button id="addSliderBtn" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة سلايدر جديد
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="slidersTable">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">الصورة</th>
                                    <th width="20%">العنوان</th>
                                    <th width="20%">الوصف</th>
                                    <th width="10%">الترتيب</th>
                                    <th width="10%">الحالة</th>
                                    <th width="15%">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sliders as $index => $slider)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if ($slider->image)
                                                <img src="{{ asset($slider->image) }}" alt="Slider Image"
                                                    style="max-width: 100px; max-height: 60px;">
                                            @else
                                                <span class="text-muted">لا توجد صورة</span>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($slider->title, 30) }}</td>
                                        <td>{{ Str::limit($slider->description, 40) }}</td>
                                        <td>{{ $slider->order }}</td>
                                        <td>
                                            @if ($slider->status == 'active')
                                                <span class="badge bg-success">نشط</span>
                                            @else
                                                <span class="badge bg-danger">غير نشط</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-circle btn-primary edit-slider"
                                                data-id="{{ $slider->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-circle btn-danger delete-slider"
                                                data-id="{{ $slider->id }}">
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
                    <form action="{{ route('supplier.sliders.updateStatus') }}" method="POST" class="row">
                        @csrf
                        <!-- التشيك بوكس على اليسار -->
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="sluster_status" name="slider_status"
                                    @if ($slider_status->value == 'true') checked @endif>
                                <label class="form-check-label" for="slider_status">تفعيل السلايدر</label>
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

<!-- Add Slider Modal -->
<div class="modal fade" id="addSliderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">إضافة سلايدر جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="addSliderForm" enctype="multipart/form-data">
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
                        <label for="image">صورة السلايدر</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*"
                            required>
                        <div class="invalid-feedback error-image"></div>
                    </div>

                    <div class="form-group">
                        <label for="link">الرابط</label>
                        <input type="text" class="form-control" id="link" name="link">
                        <div class="invalid-feedback error-link"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order">ترتيب العرض</label>
                                <input type="number" class="form-control" id="order" name="order"
                                    value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">الحالة</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="active" selected>نشط</option>
                                    <option value="inactive">غير نشط</option>
                                </select>
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

<!-- Edit Slider Modal -->
<div class="modal fade" id="editSliderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">تعديل السلايدر</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="editSliderForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_slider_id" name="id">
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
                        <label for="edit_image">صورة السلايدر</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        <div class="invalid-feedback error-image"></div>
                        <div class="mt-2" id="current_image_container">
                            <img id="current_image_preview" src=""
                                style="max-width: 200px; max-height: 150px;" class="img-thumbnail">
                            <p class="text-muted mt-1">الصورة الحالية</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_link">الرابط</label>
                        <input type="text" class="form-control" id="edit_link" name="link">
                        <div class="invalid-feedback error-link"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_order">ترتيب العرض</label>
                                <input type="number" class="form-control" id="edit_order" name="order"
                                    min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_status">الحالة</label>
                                <select class="form-control" id="edit_status" name="status">
                                    <option value="active">نشط</option>
                                    <option value="inactive">غير نشط</option>
                                </select>
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
