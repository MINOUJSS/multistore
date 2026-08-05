<div class="container-fluid py-4 overflow-hidden" style="max-width: 100%;">

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <h3 class="mb-0 fw-bold">النسخ الإحتياطية</h3>

        <a href="{{ route('admin.backup.index') }}"
           class="btn btn-primary">
            تحديث
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4 w-100 overflow-hidden" style="max-width: 100%;">
        <div class="card-body p-0">
            <form id="bulkDeleteForm"
                  action="{{ route('admin.backup.bulk-delete') }}"
                  method="POST">

                @csrf
                @method('DELETE')

                <div class="m-3 d-flex gap-2">
                    <button type="submit"
                            form="bulkDeleteForm"
                            class="btn btn-danger"
                            onclick="return confirm('هل تريد حذف جميع الملفات المحددة؟')">
                        حذف المحدد
                    </button>
                </div>

                <div class="table-responsive p-0">
                    <table class="table align-middle mb-0" id="backupsTable">
                        <thead class="table-light">
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th>إسم الملف</th>
                                <th>حجم الملف</th>
                                <th>مسار الملف</th>
                                <th>تاريخ إنشاء الملف</th>
                                <th width="180">العمليات</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($files as $file)
                                <tr>
                                    <td data-label="تحديد">
                                        <input type="checkbox"
                                               class="file-checkbox"
                                               name="files[]"
                                               value="{{ $file['name'] }}">
                                    </td>
                                    <td data-label="إسم الملف">
                                        <strong class="text-break">{{ $file['name'] }}</strong>
                                    </td>

                                    <td data-label="حجم الملف">
                                        {{ $file['size'] }} MB
                                    </td>

                                    <td data-label="مسار الملف" class="text-break dir-ltr text-start">
                                        <small class="text-muted">{{ $file['path'] }}</small>
                                    </td>

                                    <td data-label="تاريخ إنشاء الملف">
                                        {{ $file['last_modified'] }}
                                    </td>

                                    <td data-label="العمليات">
                                        <div class="d-flex gap-2 justify-content-start justify-content-lg-start">
                                            <a href="{{ route('admin.backup.download', $file['name']) }}"
                                               class="btn btn-success btn-sm">
                                                تحميل
                                            </a>

                                            <form action="{{ route('admin.backup.delete', $file['name']) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('هل تريد حذف الملف؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm">
                                                    حذف
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        لاتوجد ملفات إحتياطية.
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