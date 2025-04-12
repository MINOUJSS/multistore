<div class="container mt-5">
    <h2 class="mb-4 text-center">إعدادات Google Analytics</h2>

    <!-- زر فتح المودال -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addanalyticsModal">
        <i class="fas fa-plus"></i> إضافة 
    </button>

    <!-- جدول عرض الإعدادات -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>رقم</th>
                        <th>معرف التتبع (Tracking ID)</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($analytics as $index => $analitic)
                    <tr id="row-{{ $analitic->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ json_decode($analitic->data)->tracking_id }}</td>
                        <td>
                            <span class="badge {{ $analitic->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $analitic->status === 'active' ? 'مفعل' : 'غير مفعل' }}
                            </span>
                        </td>
                        <td>
                            <!-- زر التعديل -->
                            <button class="btn btn-warning btn-sm edit-btn" 
                                    data-id="{{ $analitic->id }}"
                                    data-tracking_id="{{ json_decode($analitic->data)->tracking_id }}"
                                    data-status="{{ $analitic->status }}">
                                <i class="fas fa-edit"></i> تعديل
                            </button>

                            <!-- زر الحذف -->
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $analitic->id }}">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </td>
                    </tr> 
                    @endforeach

                    
                    <!-- أضف المزيد من البيانات هنا -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- مودال (نموذج إضافة الإعدادات) -->
<div class="modal fade" id="addanalyticsModal" tabindex="-1" aria-labelledby="addanalyticsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addanalyticsModalLabel">إضافة إعدادات Google Analytics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="AddGoogleAnalyticsForm">
                    <input type="hidden" name="app_name" value="google_analytics">
                    
                    <div class="mb-3">
                        <label class="form-label">معرف التتبع (Tracking ID)</label>
                        <input type="text" name="tracking_id" id="tracking_id" class="form-control" placeholder="G-XXXXXXXXXX">
                        <div class="invalid-feedback" id="error-tracking_id"></div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                        <label class="form-check-label" for="status">تفعيل التتبع</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100">حفظ الإعدادات</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- مودال تعديل الإعدادات -->
<div class="modal fade" id="editanalyticsModal" tabindex="-1" aria-labelledby="editanalyticsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editanalyticsModalLabel">تعديل إعدادات Google Analytics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="EditGoogleAnalyticsForm">
                    <input type="hidden" name="id" id="edit_id"> <!-- ✅ حفظ الـ id هنا -->
                    <input type="hidden" name="app_name" value="google_analytics">
                    
                    <div class="mb-3">
                        <label class="form-label">معرف التتبع (Tracking ID)</label>
                        <input type="text" name="tracking_id" id="edit_tracking_id" class="form-control" placeholder="G-XXXXXXXXXX">
                        <div class="invalid-feedback" id="error-tracking_id"></div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" id="edit_status" checked>
                        <label class="form-check-label" for="edit_status">تفعيل التتبع</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100">حفظ الإعدادات</button>
                </form>
            </div>
        </div>
    </div>
</div>
