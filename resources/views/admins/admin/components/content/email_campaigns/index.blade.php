<div class="container-fluid py-4">
    <!-- ===== Page Header ===== -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fa-solid fa-paper-plane text-primary me-2"></i>
                حملات البريد الإلكتروني (Email Marketing)
            </h3>
            <p class="text-muted mb-0">إرسال رسائل ترويجية وتذكيرية لإعادة تنشيط البائعين والموردين غير النشطين</p>
        </div>
        <div>
            <a href="{{ route('admin.email_campaigns.create') }}" class="btn btn-primary shadow-sm px-4">
                <i class="fa-solid fa-plus me-1"></i> إنشاء حملة جديدة
            </a>
        </div>
    </div>

    <!-- ===== Stats Cards ===== -->
    <div class="row mb-4 g-3">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-bullhorn fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted mb-1">إجمالي الحملات</h6>
                    <h4 class="fw-bold mb-0">{{ number_format($totalCampaigns) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-users-viewfinder fa-2x text-info mb-2"></i>
                    <h6 class="text-muted mb-1">إجمالي المستهدفين</h6>
                    <h4 class="fw-bold mb-0">{{ number_format($totalRecipientsCount) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                    <h6 class="text-muted mb-1">الرسائل المرسلة بنجاح</h6>
                    <h4 class="fw-bold mb-0">{{ number_format($totalSentCount) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Table Card ===== -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">سجل الحملات البريدية</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>عنوان الحملة</th>
                            <th>موضوع الرسالة</th>
                            <th>الجمهور المستهدف</th>
                            <th>عدد المستهدفين</th>
                            <th>المرسلة / الفاشلة</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($campaigns as $campaign)
                            <tr>
                                <td>{{ $campaign->id }}</td>
                                <td class="fw-bold text-dark">{{ $campaign->title }}</td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $campaign->subject }}</td>
                                <td>
                                    <span class="badge bg-soft-primary text-primary px-3 py-2 border border-primary border-opacity-25 rounded-pill">
                                        {{ $campaign->target_audience_label }}
                                    </span>
                                </td>
                                <td class="fw-bold">{{ number_format($campaign->total_recipients) }}</td>
                                <td>
                                    <span class="text-success fw-bold">{{ number_format($campaign->sent_count) }}</span> /
                                    <span class="text-danger fw-bold">{{ number_format($campaign->failed_count) }}</span>
                                </td>
                                <td>
                                    @if ($campaign->status === 'completed')
                                        <span class="badge bg-success"><i class="fa-solid fa-check-circle me-1"></i> مكتملة</span>
                                    @elseif ($campaign->status === 'sending')
                                        <span class="badge bg-warning text-dark"><i class="fa-solid fa-spinner fa-spin me-1"></i> جارٍ الإرسال</span>
                                    @elseif ($campaign->status === 'queued')
                                        <span class="badge bg-info"><i class="fa-solid fa-clock me-1"></i> في الانتظار</span>
                                    @elseif ($campaign->status === 'failed')
                                        <span class="badge bg-danger"><i class="fa-solid fa-xmark-circle me-1"></i> فشلت</span>
                                    @else
                                        <span class="badge bg-secondary">مسودة</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $campaign->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.email_campaigns.show', $campaign->id) }}" class="btn btn-sm btn-outline-info" title="عرض التفاصيل والسجلات">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.email_campaigns.destroy', $campaign->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من حذف هذه الحملة؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-5 text-muted">
                                    <i class="fa-solid fa-inbox fa-3x mb-3 d-block"></i>
                                    لا توجد أي حملات بريدية حالياً. اضغط على <strong>"إنشاء حملة جديدة"</strong> للبدء.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($campaigns->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>
</div>
