<div class="container mt-5">
    <h2 class="mb-4 text-center">إعدادات Microsoft Clarity</h2>
@php
    $plan_id=get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id;
    $clarity=get_user_data(auth()->user()->tenant_id)->clarity;
    $apps_count=$clarity->count();
@endphp
    <!-- زر فتح المودال -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addClarityModal" @if (($plan_id==1) ||($plan_id==2 && $apps_count>=1) || ($plan_id==3 && $apps_count>=2))
      disabled  
    @endif>
        <i class="fas fa-plus"></i> إضافة 
    </button>

    <!-- جدول عرض الإعدادات -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>رقم</th>
                        <th>معرف Clarity</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clarities as $index => $clarity)
                    <tr id="row-{{ $clarity->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ json_decode($clarity->data)->clarity_id }}</td>
                        <td>
                            <span class="badge {{ $clarity->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $clarity->status === 'active' ? 'مفعل' : 'غير مفعل' }}
                            </span>
                        </td>
                        <td>
                            <!-- زر التعديل -->
                            <button class="btn btn-warning btn-sm edit-btn" 
                                    data-id="{{ $clarity->id }}"
                                    data-clarity_id="{{ json_decode($clarity->data)->clarity_id }}"
                                    data-status="{{ $clarity->status }}">
                                <i class="fas fa-edit"></i> تعديل
                            </button>

                            <!-- زر الحذف -->
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $clarity->id }}">
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

<!-- مودال إضافة إعدادات Microsoft Clarity -->
<div class="modal fade" id="addClarityModal" tabindex="-1" aria-labelledby="addClarityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClarityModalLabel">إضافة إعدادات Microsoft Clarity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="AddClarityForm">
                    <input type="hidden" name="app_name" value="microsoft_clarity">
                    
                    <div class="mb-3">
                        <label class="form-label">معرف Clarity</label>
                        <input type="text" name="clarity_id" id="clarity_id" class="form-control" placeholder="XXXXXXXXX">
                        <div class="invalid-feedback" id="error-clarity_id"></div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                        <label class="form-check-label" for="status">تفعيل Clarity</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100">حفظ الإعدادات</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- مودال تعديل إعدادات Microsoft Clarity -->
<div class="modal fade" id="editClarityModal" tabindex="-1" aria-labelledby="editClarityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClarityModalLabel">تعديل إعدادات Microsoft Clarity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="EditClarityForm">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="app_name" value="microsoft_clarity">
                    
                    <div class="mb-3">
                        <label class="form-label">معرف Clarity</label>
                        <input type="text" name="clarity_id" id="edit_clarity_id" class="form-control" placeholder="XXXXXXXXX">
                        <div class="invalid-feedback" id="error-edit-clarity_id"></div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" id="edit_status" checked>
                        <label class="form-check-label" for="edit_status">تفعيل Clarity</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100">حفظ الإعدادات</button>
                </form>
            </div>
        </div>
    </div>
</div>
