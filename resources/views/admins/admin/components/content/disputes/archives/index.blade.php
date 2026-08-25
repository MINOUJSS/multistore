<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-7 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-folder-open text-warning"></i>
                    <span>{{ __('أرشيف المستندات والملفات') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    📂 أرشيف ملفات النزاعات (PDF) 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    سجل وثائق ومستندات الـ PDF المؤرشفة للنزاعات والشكاوى المعالجة بالمنصة.
                </p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <form method="GET" action="{{-- route('admin.disputes.archive') --}}" class="d-flex flex-wrap gap-2 justify-content-lg-end" role="search">
                    <div class="input-group input-group-sm rounded-3 overflow-hidden shadow-sm style-search" style="max-width: 320px;">
                        <input type="text" name="search" class="form-control border-0 px-3 bg-white text-dark" placeholder="ابحث عن رقم النزاع أو المورد..." value="{{ request('search') }}">
                        <button class="btn btn-warning text-dark fw-bold px-3 border-0" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- حالة لا يوجد بيانات -->
    @if ($archives->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 bg-white p-5 text-center my-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info rounded-circle p-3 mb-3 mx-auto" style="width: 60px; height: 60px;">
                <i class="fa-solid fa-circle-info fs-3"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">لا توجد ملفات أرشيف حالياً</h5>
            <p class="text-muted small mb-0">لم يتم أرشفة أي وثائق أو ملفات PDF لنزاعات معالجة مؤخراً.</p>
        </div>
    @else
        <!-- جدول الأرشيف -->
        <div class="card border-0 shadow-sm rounded-4 bg-white w-100 overflow-hidden mb-4" style="max-width: 100%;">
            <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-file-pdf text-danger"></i>
                    <span>سجل ملفات النزاعات المؤرشفة</span>
                </div>
                <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill">عدد الملفات: {{ $archives->count() }}</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive p-0">
                    <table class="table table-hover align-middle text-center mb-0" id="disputesArchivesTable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="py-3">#</th>
                                <th class="py-3">اسم الملف</th>
                                <th class="py-3">رقم النزاع</th>
                                <th class="py-3">معرف البائع</th>
                                <th class="py-3">اسم الزبون</th>
                                <th class="py-3">رقم هاتف الزبون</th>
                                <th class="py-3">البريد الألكتروني للزبون</th>
                                <th class="py-3">تاريخ الإنشاء</th>
                                <th class="py-3">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($archives as $archive)
                                <tr>
                                    <td data-label="#" class="fw-bold text-secondary">{{ $loop->iteration }}</td>
                                    <td data-label="اسم الملف" class="text-truncate px-3 text-start" style="max-width: 200px;">
                                        <i class="fa-solid fa-file-pdf text-danger me-1 fs-6"></i>
                                        <span class="fw-bold text-dark dir-ltr">{{ $archive->file_name }}</span>
                                    </td>
                                    <td data-label="رقم النزاع"><span class="badge bg-light text-secondary border px-2.5 py-1.5 rounded-3 fw-bold">{{ $archive->dispute_id ?? '-' }}</span></td>
                                    <td data-label="معرف البائع" class="fw-semibold text-dark">{{ $archive->seller_id ?? 'غير معروف' }}</td>
                                    <td data-label="اسم الزبون" class="fw-bold text-dark">{{ $archive->customer_name ?? 'غير معروف' }}</td>
                                    <td data-label="رقم هاتف الزبون" class="dir-ltr text-muted small">{{ $archive->customer_phone ?? 'غير معروف' }}</td>
                                    <td data-label="البريد الألكتروني للزبون" class="dir-ltr text-muted small">{{ $archive->customer_email ?? 'غير معروف' }}</td>
                                    <td data-label="تاريخ الإنشاء" class="text-muted small">{{ $archive->created_at->format('Y-m-d H:i') }}</td>
                                    <td data-label="العمليات">
                                        <div class="d-flex justify-content-center flex-wrap gap-1">
                                            <a href="{{ asset('storage/app/' . $archive->file_path) }}" target="_blank" 
                                                class="btn btn-sm btn-outline-info rounded-3 px-2" title="عرض الملف">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.payment_proof.dispute.archive.download', $archive->id) }}" 
                                                class="btn btn-sm btn-outline-success rounded-3 px-2" title="تحميل">
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                            <form method="POST" 
                                                  action="{{ route('admin.payment_proof.dispute.archive.destroy', $archive->id) }}" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    onclick="return confirm('⚠️ هل أنت متأكد من حذف هذا الملف؟')" 
                                                    class="btn btn-sm btn-outline-danger rounded-3 px-2" title="حذف">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- ترقيم الصفحات -->
                <div class="p-3 text-center border-top bg-light">
                    {{ $archives->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @endif
</div>

<style>
/* Pure CSS Responsive Table for #disputesArchivesTable */
@media (max-width: 991.98px) {
    #disputesArchivesTable, 
    #disputesArchivesTable tbody, 
    #disputesArchivesTable tr, 
    #disputesArchivesTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #disputesArchivesTable thead {
        display: none !important;
    }
    
    #disputesArchivesTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #disputesArchivesTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #disputesArchivesTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #disputesArchivesTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>