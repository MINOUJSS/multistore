<div class="container mt-5">
    <h2 class="mb-4 text-center">إعدادات إشعارات Telegram</h2>

    <!-- زر فتح المودال -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTelegramModal">
        <i class="fas fa-plus"></i> إضافة 
    </button>

    <!-- جدول عرض الإعدادات -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>رقم</th>
                        <th>معرف الـ Chat في Telegram</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($telegramSettings as $index => $telegram)
                    <tr id="row-{{ $telegram->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ json_decode($telegram->data)->chat_id }}</td>
                        <td>
                            <span class="badge {{ $telegram->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $telegram->status === 'active' ? 'مفعل' : 'غير مفعل' }}
                            </span>
                        </td>
                        <td>
                            <!-- زر التعديل -->
                            <button class="btn btn-warning btn-sm edit-btn" 
                                    data-id="{{ $telegram->id }}"
                                    data-chat_id="{{ json_decode($telegram->data)->chat_id }}"
                                    data-status="{{ $telegram->status }}">
                                <i class="fas fa-edit"></i> تعديل
                            </button>

                            <!-- زر الحذف -->
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $telegram->id }}">
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
<div class="modal fade" id="addTelegramModal" tabindex="-1" aria-labelledby="addTelegramModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTelegramModalLabel">إضافة إعدادات إشعارات Telegram</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="AddTelegramNotificationForm">
                    <input type="hidden" name="app_name" value="telegram_notifications">
                    
                    <div class="mb-3">
                        <label class="form-label">معرف الـ Chat في Telegram</label>
                        <input type="text" name="chat_id" id="chat_id" class="form-control" placeholder="أدخل معرف الـ Chat">
                        <div class="invalid-feedback" id="error-chat_id"></div>
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
<div class="modal fade" id="editTelegramModal" tabindex="-1" aria-labelledby="editTelegramModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTelegramModalLabel">تعديل إعدادات إشعارات Telegram</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="EditTelegramNotificationForm">
                    <input type="hidden" name="id" id="edit_id"> <!-- ✅ حفظ الـ id هنا -->
                    <input type="hidden" name="app_name" value="telegram_notifications">
                    
                    <div class="mb-3">
                        <label class="form-label">معرف الـ Chat في Telegram</label>
                        <input type="text" name="chat_id" id="edit_chat_id" class="form-control" placeholder="أدخل معرف الـ Chat">
                        <div class="invalid-feedback" id="error-chat_id"></div>
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
