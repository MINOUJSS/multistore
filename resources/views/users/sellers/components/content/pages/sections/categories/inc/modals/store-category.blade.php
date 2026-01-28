<!-- Add Store Category Modal -->
<div class="modal fade" id="addStoreCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">إضافة قسم للمتجر</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addStoreCategoryForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="category_id">القسم العام</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">اختر القسم العام</option>
                            @foreach($globalCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback error-category_id"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image">صورة القسم</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="invalid-feedback error-image"></div>
                    </div>

                    {{-- <div class="form-group mb-3">
                        <label for="icon">الأيقونة</label>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="مثال: fas fa-home">
                        <div class="invalid-feedback error-icon"></div>
                    </div> --}}

                    <div class="form-group mb-3">
                        <label for="order">ترتيب العرض</label>
                        <input type="number" class="form-control" id="order" name="order" value="0" min="0">
                        <div class="invalid-feedback error-order"></div>
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

<!-- Edit Store Category Modal -->
<div class="modal fade" id="editStoreCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">تعديل قسم المتجر</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editStoreCategoryForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_store_category_id" name="id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="edit_store_category_id_select">القسم العام</label>
                        <select class="form-control" id="edit_store_category_id_select" name="category_id" required>
                            <option value="">اختر القسم العام</option>
                            @foreach($globalCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback error-category_id"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_store_image">صورة القسم</label>
                        <input type="file" class="form-control" id="edit_store_image" name="image" accept="image/*">
                        <div class="invalid-feedback error-image"></div>
                        <div class="mt-2" id="current_store_image_container">
                            <img id="current_store_image_preview" src="" style="max-width: 100px; max-height: 80px;" class="img-thumbnail">
                            <p class="text-muted mt-1">الصورة الحالية</p>
                        </div>
                    </div>

                    {{-- <div class="form-group mb-3">
                        <label for="edit_store_icon">الأيقونة</label>
                        <input type="text" class="form-control" id="edit_store_icon" name="icon" placeholder="مثال: fas fa-home">
                        <div class="invalid-feedback error-icon"></div>
                    </div> --}}

                    <div class="form-group mb-3">
                        <label for="edit_store_order">ترتيب العرض</label>
                        <input type="number" class="form-control" id="edit_store_order" name="order" min="0">
                        <div class="invalid-feedback error-order"></div>
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