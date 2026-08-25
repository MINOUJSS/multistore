<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-box-archive text-warning"></i>
                    <span>{{ __('أرشيف الأمان والسلامة') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    📦 النسخ الإحتياطية للنظام 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    إدارة ملفات النسخ الاحتياطية لقواعد البيانات والمشاريع، التنزيل الفوري والحذف المباشر.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.backup.index') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm">
                        <i class="fa-solid fa-rotate me-1"></i> تحديث السجل
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
                <div class="fw-semibold">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-exclamation fs-5 me-2 text-danger"></i>
                <div class="fw-semibold">{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Backups Card -->
    <div class="card border-0 shadow-sm rounded-4 w-100 overflow-hidden mb-4" style="max-width: 100%;">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-server" style="color: #a40c72;"></i>
                <span>ملفات النسخ الاحتياطي المخزنة</span>
            </div>
            <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill">عدد الملفات: {{ count($files) }}</span>
        </div>

        <div class="card-body p-0">
            <form id="bulkDeleteForm"
                  action="{{ route('admin.backup.bulk-delete') }}"
                  method="POST">
                @csrf
                @method('DELETE')

                <div class="p-3 bg-light bg-opacity-50 border-bottom d-flex align-items-center justify-content-between">
                    <button type="submit"
                            form="bulkDeleteForm"
                            class="btn btn-danger btn-sm rounded-3 px-3 fw-semibold"
                            onclick="return confirm('هل تريد حذف جميع الملفات المحددة؟')">
                        <i class="fa-solid fa-trash me-1"></i> حذف المحدد
                    </button>
                    <small class="text-muted">قم بتحديد الملفات ثم اضغط على حذف المحدد</small>
                </div>

                <div class="table-responsive p-0">
                    <table class="table table-hover align-middle mb-0" id="backupsTable">
                        <thead class="bg-light text-muted small text-center">
                            <tr>
                                <th width="40" class="py-3">
                                    <input type="checkbox" class="form-check-input" id="checkAll">
                                </th>
                                <th class="py-3">إسم الملف</th>
                                <th class="py-3">حجم الملف</th>
                                <th class="py-3">مسار الملف</th>
                                <th class="py-3">تاريخ إنشاء الملف</th>
                                <th width="180" class="py-3">العمليات</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @forelse($files as $file)
                                <tr>
                                    <td data-label="تحديد">
                                        <input type="checkbox"
                                               class="form-check-input file-checkbox"
                                               name="files[]"
                                               value="{{ $file['name'] }}">
                                    </td>
                                    <td data-label="إسم الملف" class="fw-bold text-dark">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <i class="fa-solid fa-file-zipper text-warning fs-5"></i>
                                            <span class="text-break dir-ltr">{{ $file['name'] }}</span>
                                        </div>
                                    </td>

                                    <td data-label="حجم الملف">
                                        <span class="badge bg-light text-dark border px-2.5 py-1 rounded-3">{{ $file['size'] }} MB</span>
                                    </td>

                                    <td data-label="مسار الملف" class="text-break dir-ltr text-start">
                                        <small class="text-muted small">{{ $file['path'] }}</small>
                                    </td>

                                    <td data-label="تاريخ إنشاء الملف" class="text-muted small">
                                        {{ $file['last_modified'] }}
                                    </td>

                                    <td data-label="العمليات">
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">
                                            <a href="{{ route('admin.backup.download', $file['name']) }}"
                                               class="btn btn-success btn-sm rounded-3 px-3">
                                                <i class="fa-solid fa-download me-1"></i> تحميل
                                            </a>

                                            <form action="{{ route('admin.backup.delete', $file['name']) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('هل تريد حذف الملف؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-outline-danger btn-sm rounded-3 px-3">
                                                    <i class="fa-solid fa-trash me-1"></i> حذف
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-box-open fs-2 mb-2 d-block opacity-50"></i>
                                        <h6>لا توجد ملفات نسخ إحتياطية مخزنة حالياً.</h6>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Pure CSS Responsive Table for #backupsTable */
@media (max-width: 991.98px) {
    #backupsTable, 
    #backupsTable tbody, 
    #backupsTable tr, 
    #backupsTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #backupsTable thead {
        display: none !important;
    }
    
    #backupsTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #backupsTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #backupsTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #backupsTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('checkAll');
        if (checkAll) {
            checkAll.addEventListener('change', function () {
                const checkboxes = document.querySelectorAll('.file-checkbox');
                checkboxes.forEach(cb => cb.checked = checkAll.checked);
            });
        }
    });
</script>
