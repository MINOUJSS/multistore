<!-- Add Global Category Modal -->
<div class="modal fade" id="addGlobalCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">إضافة قسم عام جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addGlobalCategoryForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name">اسم القسم</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback error-name"></div>
                    </div>

                    {{-- <div class="form-group mb-3">
                        <label for="slug">الرابط (Slug)</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                        <div class="invalid-feedback error-slug"></div>
                    </div> --}}

                    <div class="form-group mb-3">
                        <label for="description">الوصف</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback error-description"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="parent_id">القسم الأب</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">اختر قسم أب</option>
                            @foreach($globalCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback error-parent_id"></div>
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

<!-- Edit Global Category Modal -->
<div class="modal fade" id="editGlobalCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">تعديل القسم العام</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editGlobalCategoryForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_global_category_id" name="id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="edit_global_name">اسم القسم</label>
                        <input type="text" class="form-control" id="edit_global_name" name="name" required>
                        <div class="invalid-feedback error-name"></div>
                    </div>

                    {{-- <div class="form-group mb-3">
                        <label for="edit_global_slug">الرابط (Slug)</label>
                        <input type="text" class="form-control" id="edit_global_slug" name="slug" required>
                        <div class="invalid-feedback error-slug"></div>
                    </div> --}}

                    <div class="form-group mb-3">
                        <label for="edit_global_description">الوصف</label>
                        <textarea class="form-control" id="edit_global_description" name="description" rows="3"></textarea>
                        <div class="invalid-feedback error-description"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="edit_global_parent_id">القسم الأب</label>
                        <select class="form-control" id="edit_global_parent_id" name="parent_id">
                            <option value="">اختر قسم أب</option>
                            @foreach($globalCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback error-parent_id"></div>
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