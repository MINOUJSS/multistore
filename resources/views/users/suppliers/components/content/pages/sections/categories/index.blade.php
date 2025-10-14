<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">إدارة الأقسام</h1>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-info">
            {{ session()->get('message') }}
            <button type="button" class="btn-close left" data-bs-dismiss="alert" aria-label="Close"
                style="float: left;"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <!-- Global Categories Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">الأقسام العامة</h6>
                    <button id="addGlobalCategoryBtn" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة قسم عام
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="globalCategoriesTable">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">الاسم</th>
                                    {{-- <th width="25%">الرابط</th> --}}
                                    <th width="25%">الوصف</th>
                                    <th width="10%">القسم الأب</th>
                                    <th width="10%">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($globalCategories as $index => $category)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        {{-- <td>{{ $category->slug }}</td> --}}
                                        <td>{{ Str::limit($category->description, 40) }}</td>
                                        <td>{{ $category->parent?->name ?? 'رئيسي' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-circle btn-primary edit-global-category"
                                                data-id="{{ $category->slug }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-circle btn-danger delete-global-category"
                                                data-id="{{ $category->slug }}">
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
                    <form action="{{ route('supplier.categories.updateStatus') }}" method="POST" class="row">
                        @csrf
                        <!-- التشيك بوكس على اليسار -->
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="categories_status" name="categories_status"
                                     @if ($categories_status->value == 'true') checked @endif>
                                <label class="form-check-label" for="categories_status">تفعيل عرض الأقسام على المتجر</label>
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

            <!-- Store Categories Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">أقسام المتجر</h6>
                    <button id="addStoreCategoryBtn" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة قسم للمتجر
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="storeCategoriesTable">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">الصورة</th>
                                    <th width="20%">القسم العام</th>
                                    {{-- <th width="10%">الأيقونة</th> --}}
                                    <th width="10%">الترتيب</th>
                                    <th width="10%">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($storeCategories as $index => $storeCategory)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if ($storeCategory->image)
                                                <img src="{{ asset($storeCategory->image) }}" style="max-width: 60px;">
                                            @else
                                                <span class="text-muted">لا توجد صورة</span>
                                            @endif
                                        </td>
                                        <td>{{ $storeCategory->category->name }}</td>
                                        {{-- <td>{{ $storeCategory->icon }}</td> --}}
                                        <td>{{ $storeCategory->order }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-circle btn-primary edit-store-category"
                                                data-id="{{ $storeCategory->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-circle btn-danger delete-store-category"
                                                data-id="{{ $storeCategory->id }}">
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
        </div>
    </div>
</div>

<!-- Modals for Global Categories -->
@include('users.suppliers.components.content.pages.sections.categories.inc.modals.global-category')

<!-- Modals for Store Categories -->
@include('users.suppliers.components.content.pages.sections.categories.inc.modals.store-category')

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