<div class="container-fluid py-3 py-md-4">
    <!-- ===== Page Header ===== -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1 fs-4 fs-md-3 text-break">
                <i class="fa-solid fa-chart-line text-primary me-2"></i>
                تفاصيل الحملة: {{ $campaign->title }}
            </h3>
            <p class="text-muted mb-0 small fs-md-6">عرض تقرير الإرسال وسجلات الوصول الفردية</p>
        </div>
        <div class="w-100 w-md-auto d-flex flex-wrap gap-2">
            @if ($campaign->failed_count > 0)
                <form action="{{ route('admin.email_campaigns.resend_failed', $campaign->id) }}" method="POST"
                    onsubmit="return confirm('هل أنت متأكد من إعادة إرسال الرسائل الفاشلة فقط (عدد: {{ $campaign->failed_count }})؟');" class="w-100 w-md-auto">
                    @csrf
                    <button type="submit" class="btn btn-warning shadow-sm px-3 py-2 w-100 w-md-auto text-nowrap fw-bold">
                        <i class="fa-solid fa-rotate-right me-1"></i> إعادة إرسال الفاشلة ({{ $campaign->failed_count }})
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.email_campaigns.index') }}" class="btn btn-outline-secondary shadow-sm px-4 py-2 w-100 w-md-auto text-nowrap">
                <i class="fa-solid fa-arrow-right me-1"></i> العودة للحملات
            </a>
        </div>
    </div>

    <!-- ===== Overview Cards ===== -->
    <div class="row mb-4 g-3">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 text-center h-100 stat-card">
                <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-users fa-lg"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">المستهدفين</h6>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($campaign->total_recipients) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 text-center h-100 stat-card">
                <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-circle-check fa-lg"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">تم الإرسال بنجاح</h6>
                    <h4 class="fw-bold text-success mb-0">{{ number_format($campaign->sent_count) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 text-center h-100 stat-card">
                <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-circle-exclamation fa-lg"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">فشل الإرسال</h6>
                    <h4 class="fw-bold text-danger mb-0">{{ number_format($campaign->failed_count) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 text-center h-100 stat-card">
                <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-percent fa-lg"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">نسبة الإنجاز</h6>
                    <h4 class="fw-bold text-info mb-0">{{ $campaign->success_rate }}%</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Campaign Meta Details Card ===== -->
    <div class="card shadow-sm border-0 mb-4 rounded-3">
        <div class="card-header bg-white py-3 px-3 px-md-4">
            <h5 class="fw-bold mb-0 fs-6 fs-md-5">
                <i class="fa-solid fa-circle-info text-primary me-2"></i> معلومات الحملة والمحتوى
            </h5>
        </div>
        <div class="card-body p-3 p-md-4">
            <div class="row g-3 mb-3">
                <div class="col-12 col-md-6">
                    <div class="p-3 bg-light rounded border-0 h-100">
                        <p class="mb-2 text-break">
                            <strong class="text-secondary d-block d-sm-inline mb-1 mb-sm-0">موضوع الرسالة (Subject):</strong> 
                            <span class="fw-bold text-dark">{{ $campaign->subject }}</span>
                        </p>
                        <p class="mb-0">
                            <strong class="text-secondary d-block d-sm-inline mb-1 mb-sm-0">الجمهور المستهدف:</strong> 
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-2 fw-normal">
                                {{ $campaign->target_audience_label }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="p-3 bg-light rounded border-0 h-100">
                        <p class="mb-2">
                            <strong class="text-secondary d-block d-sm-inline mb-1 mb-sm-0">الحالة الحالية:</strong>
                            @if ($campaign->status === 'completed')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1"><i class="fa-solid fa-check-circle me-1"></i> مكتملة</span>
                            @elseif ($campaign->status === 'sending')
                                <span class="badge bg-warning bg-opacity-10 text-dark border border-warning px-2 py-1"><i class="fa-solid fa-spinner fa-spin me-1"></i> جارٍ الإرسال في الخلفية</span>
                            @elseif ($campaign->status === 'queued')
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1"><i class="fa-solid fa-clock me-1"></i> في الانتظار</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1"><i class="fa-solid fa-xmark-circle me-1"></i> فشلت</span>
                            @endif
                        </p>
                        <p class="mb-0">
                            <strong class="text-secondary d-block d-sm-inline mb-1 mb-sm-0">تاريخ الإنشاء:</strong> 
                            <span class="text-dark dir-ltr">{{ $campaign->created_at->format('Y-m-d H:i') }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h6 class="fw-bold mb-2 text-dark"><i class="fa-solid fa-file-text me-1 text-secondary"></i> محتوى الرسالة المرسلة:</h6>
                <div class="p-3 bg-light rounded border text-dark fs-6 lh-base text-break" style="white-space: pre-line;">
                    {{ $campaign->content }}
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Logs Card ===== -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 fs-6 fs-md-5">
                <i class="fa-solid fa-list-check text-secondary me-2"></i> سجل الإرسال الفردي (Recipients Logs)
            </h5>
            <span class="badge bg-light text-dark border small">{{ $logs->total() }} سجل</span>
        </div>

        <!-- Desktop & Tablet View -->
        <div class="card-body p-0 d-none d-md-block">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 60px;">#</th>
                            <th scope="col">اسم المستلم</th>
                            <th scope="col">البريد الإلكتروني</th>
                            <th scope="col">النوع</th>
                            <th scope="col">حالة الإرسال</th>
                            <th scope="col">تاريخ الإرسال</th>
                            <th scope="col">تفاصيل الخطأ (إن وجد)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td class="fw-bold text-secondary">{{ $log->id }}</td>
                                <td class="fw-bold text-dark px-3 text-start">{{ $log->recipient_name ?: '—' }}</td>
                                <td class="px-3 text-start dir-ltr">{{ $log->recipient_email }}</td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1 text-uppercase">{{ $log->recipient_type }}</span>
                                </td>
                                <td>
                                    @if ($log->status === 'sent')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1"><i class="fa-solid fa-check me-1"></i> تم الإرسال</span>
                                    @elseif ($log->status === 'failed')
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1"><i class="fa-solid fa-xmark me-1"></i> فشل</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-dark border border-warning px-2 py-1"><i class="fa-solid fa-clock me-1"></i> قيد الانتظار</span>
                                    @endif
                                </td>
                                <td class="small text-muted dir-ltr">
                                    {{ $log->sent_at ? $log->sent_at->format('Y-m-d H:i:s') : '—' }}
                                </td>
                                <td class="small text-danger text-truncate" style="max-width: 250px;" title="{{ $log->error_message }}">
                                    {{ $log->error_message ?: '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-muted">
                                    <i class="fa-solid fa-inbox fa-3x mb-3 text-secondary d-block"></i>
                                    لا توجد سجلات تفصيلية متبقية لهذه الحملة حتى الآن.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View (< 768px) -->
        <div class="d-block d-md-none p-3">
            @forelse ($logs as $log)
                <div class="card border mb-3 shadow-sm rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold text-dark mb-0 text-break pe-2">{{ $log->recipient_name ?: 'مستلم بدون اسم' }}</h6>
                            <span class="badge bg-light text-secondary border">#{{ $log->id }}</span>
                        </div>
                        
                        <p class="small text-muted mb-2 text-break dir-ltr"><i class="fa-solid fa-envelope me-1"></i> {{ $log->recipient_email }}</p>

                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1 text-uppercase">{{ $log->recipient_type }}</span>
                            @if ($log->status === 'sent')
                                <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> تم الإرسال</span>
                            @elseif ($log->status === 'failed')
                                <span class="badge bg-danger"><i class="fa-solid fa-xmark me-1"></i> فشل</span>
                            @else
                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> قيد الانتظار</span>
                            @endif
                        </div>

                        @if ($log->error_message)
                            <div class="p-2 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded small text-danger mb-2 text-break">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $log->error_message }}
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> {{ $log->sent_at ? $log->sent_at->format('Y-m-d H:i:s') : '—' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-inbox fa-3x mb-3 text-secondary d-block"></i>
                    لا توجد سجلات تفصيلية متبقية لهذه الحملة حتى الآن.
                </div>
            @endforelse
        </div>

        @if ($logs->hasPages())
            <div class="card-footer bg-white py-3 px-3 px-md-4">
                {{ $logs->links('vendor.pagination.dashboard-pagination') }}
            </div>
        @endif
    </div>
</div>

<style>
.stat-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
}
</style>
