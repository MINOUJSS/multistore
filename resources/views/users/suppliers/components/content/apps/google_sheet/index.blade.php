<div class="container mt-5">
    <h2 class="mb-4 text-center">إعدادات Google Sheets</h2>

    <!-- زر فتح المودال -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSheetModal">
        <i class="fas fa-plus"></i> إضافة 
    </button>

    <!-- جدول عرض الإعدادات -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>رقم</th>
                        <th>معرف Google Sheet</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sheets as $index => $sheet)
                    <tr id="row-{{ $sheet->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ json_decode($sheet->data)->sheet_id }}</td>
                        <td>
                            <span class="badge {{ $sheet->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $sheet->status === 'active' ? 'مفعل' : 'غير مفعل' }}
                            </span>
                        </td>
                        <td>
                            <!-- زر التعديل -->
                            <button class="btn btn-warning btn-sm edit-btn" 
                                    data-id="{{ $sheet->id }}"
                                    data-sheet_id="{{ json_decode($sheet->data)->sheet_id }}"
                                    data-status="{{ $sheet->status }}">
                                <i class="fas fa-edit"></i> تعديل
                            </button>

                            <!-- زر الحذف -->
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $sheet->id }}">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- مودال (نموذج إضافة الإعدادات) -->
<div class="modal fade" id="addSheetModal" tabindex="-1" aria-labelledby="addSheetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSheetModalLabel">إضافة إعدادات Google Sheets</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="AddGoogleSheetForm">
                    <input type="hidden" name="app_name" value="google_sheets">
                    
                    <div class="mb-3">
                        <label class="form-label">معرف Google Sheet</label>
                        <input type="text" name="sheet_id" id="sheet_id" class="form-control" placeholder="Enter Sheet ID">
                        <div class="invalid-feedback" id="error-sheet_id"></div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                        <label class="form-check-label" for="status">تفعيل</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100">حفظ الإعدادات</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- مودال تعديل الإعدادات -->
<div class="modal fade" id="editSheetModal" tabindex="-1" aria-labelledby="editSheetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSheetModalLabel">تعديل إعدادات Google Sheets</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="EditGoogleSheetForm">
                    <input type="hidden" name="id" id="edit_id"> <!-- ✅ حفظ الـ id هنا -->
                    <input type="hidden" name="app_name" value="google_sheets">
                    
                    <div class="mb-3">
                        <label class="form-label">معرف Google Sheet</label>
                        <input type="text" name="sheet_id" id="edit_sheet_id" class="form-control" placeholder="Enter Sheet ID">
                        <div class="invalid-feedback" id="error-sheet_id"></div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" id="edit_status" checked>
                        <label class="form-check-label" for="edit_status">تفعيل</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100">حفظ الإعدادات</button>
                </form>
            </div>
        </div>
    </div>
</div>
