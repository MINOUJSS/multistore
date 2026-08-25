<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-box-archive text-warning"></i>
                    <span>{{ __('أرشيف الملفات والمستندات') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    📂 أرشيف إثباتات الدفع المرفوضة 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    سجل وثائق وملفات PDF المؤرشفة لإثباتات الدفع المرفوضة للرجوع إليها وتنزيلها.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.payment_proof.disputes.refused') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm text-nowrap">
                        <i class="fa-solid fa-rotate-left me-1"></i> قائمة المرفوضات
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm text-nowrap">
                        <i class="fa-solid fa-house me-1"></i> الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if ($archives->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 bg-white p-5 text-center my-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info rounded-circle p-3 mb-3 mx-auto" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-circle-info fs-3"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">لا توجد ملفات أرشيف متاحة حالياً</h5>
            <p class="text-muted small mb-0">لم يتم أرشفة أي وثائق أو ملفات PDF لإثباتات مرفوضة مؤخراً.</p>
        </div>
    @else
        <!-- Archive Table Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white w-100 overflow-hidden mb-4" style="max-width: 100%;">
            <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-folder-open" style="color: #a40c72;"></i>
                    <span>سجل ملفات الأرشيف المؤرشفة</span>
                </div>
                <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill">عدد الملفات: {{ $archives->count() }}</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive p-0">
                    <table class="table table-hover align-middle text-center mb-0" id="refusedPaymentsArchivesTable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="py-3">#</th>
                                <th class="py-3">رقم الطلب</th>
                                <th class="py-3">المورد</th>
                                <th class="py-3">الملف المؤرشف (PDF)</th>
                                <th class="py-3">تاريخ الأرشفة</th>
                                <th class="py-3">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($archives as $archive)
                                <tr>
                                    <td data-label="#" class="fw-bold text-secondary">{{ $loop->iteration }}</td>
                                    <td data-label="رقم الطلب">
                                        <span class="badge bg-light text-primary border px-2.5 py-1.5 rounded-3 fw-bold">{{ $archive->order_number ?? '-' }}</span>
                                    </td>
                                    <td data-label="المورد" class="text-start px-3">
                                        @if($archive->user_name)
                                            <div class="fw-bold text-dark">{{ $archive->user_name }}</div>
                                            <small class="text-muted dir-ltr d-block">{{ $archive->user_email ?? '' }}</small>
                                        @else
                                            <span class="text-muted small">غير محدد</span>
                                        @endif
                                    </td>
                                    <td data-label="الملف المؤرشف (PDF)">
                                        @if($archive->archive_pdf_path)
                                            <a href="{{ asset('storage/'.$archive->archive_pdf_path) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-3 px-3">
                                                <i class="fa-solid fa-file-pdf me-1"></i> عرض الملف
                                            </a>
                                        @else
                                            <span class="text-muted small">غير متوفر</span>
                                        @endif
                                    </td>
                                    <td data-label="تاريخ الأرشفة" class="text-muted small">
                                        {{ $archive->archived_at ? \Carbon\Carbon::parse($archive->archived_at)->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td data-label="الإجراءات">
                                        <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                            <a href="{{ route('admin.payment_proof.dispute.refused.download', $archive->id) }}" class="btn btn-sm btn-outline-primary rounded-3 px-2.5">
                                                <i class="fa-solid fa-download me-1"></i> تحميل
                                            </a>
                                            <form action="{{ route('admin.payment_proof.dispute.refused.destroy', $archive->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2.5"
                                                        onclick="return confirm('هل تريد حذف هذا الملف من الأرشيف نهائيًا؟')">
                                                    <i class="fa-solid fa-trash me-1"></i> حذف
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3 text-center border-top bg-light">
                    {{ $archives->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @endif
</div>

<style>
/* Pure CSS Responsive Table for #refusedPaymentsArchivesTable */
@media (max-width: 991.98px) {
    #refusedPaymentsArchivesTable, 
    #refusedPaymentsArchivesTable tbody, 
    #refusedPaymentsArchivesTable tr, 
    #refusedPaymentsArchivesTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #refusedPaymentsArchivesTable thead {
        display: none !important;
    }
    
    #refusedPaymentsArchivesTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #refusedPaymentsArchivesTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #refusedPaymentsArchivesTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #refusedPaymentsArchivesTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>
