<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <h3 class="mb-0 text-dark">
            <i class="fa-solid fa-box-archive text-secondary"></i> أرشيف إثباتات الدفع المرفوضة
        </h3>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-house"></i> الرئيسية
            </a>
            <a href="{{ route('admin.payment_proof.disputes.refused') }}" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-rotate-left"></i> العودة إلى القائمة
            </a>
        </div>
    </div>

    @if ($archives->isEmpty())
        <div class="alert alert-info text-center shadow-sm">
            <i class="fa-solid fa-circle-info"></i> لا توجد ملفات أرشيف متاحة حالياً.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped align-middle shadow-sm">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>رقم الطلب</th>
                        <th>المورد</th>
                        <th>الملف المؤرشف (PDF)</th>
                        <th>تاريخ الأرشفة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($archives as $archive)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $archive->order_number ?? '-' }}</span>
                            </td>
                            <td>
                                @if($archive->user_name)
                                    <strong>{{ $archive->user_name }}</strong><br>
                                    <small class="text-muted">{{ $archive->user_email ?? '' }}</small>
                                @else
                                    <span class="text-muted">غير محدد</span>
                                @endif
                            </td>
                            <td>
                                @if($archive->archive_pdf_path)
                                    <a href="{{ asset('storage/'.$archive->archive_pdf_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                        <i class="fa-solid fa-file-pdf"></i> عرض الملف
                                    </a>
                                @else
                                    <span class="text-muted">غير متوفر</span>
                                @endif
                            </td>
                            <td>
                                {{ $archive->archived_at ? \Carbon\Carbon::parse($archive->archived_at)->format('Y-m-d H:i') : '-' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.payment_proof.dispute.refused.download', $archive->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-download"></i> تحميل
                                </a>
                                <form action="{{ route('admin.payment_proof.dispute.refused.destroy', $archive->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('هل تريد حذف هذا الملف من الأرشيف نهائيًا؟')">
                                        <i class="fa-solid fa-trash"></i> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $archives->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<style>
    @media (max-width: 768px) {
        table thead {
            display: none;
        }
        table tbody tr {
            display: block;
            margin-bottom: 1rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 10px;
        }
        table tbody td {
            display: flex;
            justify-content: space-between;
            text-align: right;
            padding: 8px 5px;
            border: none !important;
        }
        table tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            color: #555;
        }
    }
</style>
