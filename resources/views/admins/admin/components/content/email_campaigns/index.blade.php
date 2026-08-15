<div class="container-fluid py-3 py-md-4">
    <!-- ===== Page Header ===== -->
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1 fs-4 fs-md-3">
                <i class="fa-solid fa-paper-plane text-primary me-2"></i>
                حملات البريد الإلكتروني (Email Marketing)
            </h3>
            <p class="text-muted mb-0 small fs-md-6">إرسال رسائل ترويجية وتذكيرية لإعادة تنشيط البائعين والموردين غير
                النشطين</p>
        </div>
        <div class="w-100 w-md-auto">
            <a href="{{ route('admin.email_campaigns.create') }}"
                class="btn btn-primary shadow-sm px-4 py-2 w-100 w-md-auto text-nowrap">
                <i class="fa-solid fa-plus me-1"></i> إنشاء حملة جديدة
            </a>
        </div>
    </div>

    <!-- ===== Stats Cards ===== -->
    <div class="row mb-4 g-3">
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card shadow-sm border-0 text-center h-100 stat-card">
                <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle mb-3 d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-bullhorn fa-lg"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">إجمالي الحملات</h6>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($totalCampaigns) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card shadow-sm border-0 text-center h-100 stat-card">
                <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info rounded-circle mb-3 d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-users-viewfinder fa-lg"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">إجمالي المستهدفين</h6>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($totalRecipientsCount) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card shadow-sm border-0 text-center h-100 stat-card">
                <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success rounded-circle mb-3 d-flex align-items-center justify-content-center"
                        style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-circle-check fa-lg"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">الرسائل المرسلة بنجاح</h6>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($totalSentCount) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Main Card ===== -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 fs-6 fs-md-5">
                <i class="fa-solid fa-list text-secondary me-2"></i> سجل الحملات البريدية
            </h5>
            <span class="badge bg-light text-dark border small">{{ $campaigns->total() }} حملة</span>
        </div>

        <!-- Desktop & Tablet Table View -->
        <div class="card-body p-0 d-none d-md-block">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 60px;">#</th>
                            <th scope="col">عنوان الحملة</th>
                            <th scope="col">موضوع الرسالة</th>
                            <th scope="col">الجمهور المستهدف</th>
                            <th scope="col">عدد المستهدفين</th>
                            <th scope="col">الناجحة / الفاشلة</th>
                            <th scope="col">الحالة</th>
                            <th scope="col">التاريخ</th>
                            <th scope="col" style="width: 120px;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($campaigns as $campaign)
                            <tr>
                                <td class="fw-bold text-secondary">{{ $campaign->id }}</td>
                                <td class="fw-bold text-dark text-start px-3">{{ $campaign->title }}</td>
                                <td class="text-start px-3 text-truncate" style="max-width: 220px;"
                                    title="{{ $campaign->subject }}">
                                    {{ $campaign->subject }}
                                </td>
                                <td>
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 border border-primary border-opacity-25 rounded-pill fw-normal">
                                        {{ $campaign->target_audience_label }}
                                    </span>
                                </td>
                                <td class="fw-bold">{{ number_format($campaign->total_recipients) }}</td>
                                <td>
                                    <span
                                        class="text-success fw-bold">{{ number_format($campaign->sent_count) }}</span>
                                    /
                                    <span
                                        class="text-danger fw-bold">{{ number_format($campaign->failed_count) }}</span>
                                </td>
                                <td>
                                    @if ($campaign->status === 'completed')
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1"><i
                                                class="fa-solid fa-check-circle me-1"></i> مكتملة</span>
                                    @elseif ($campaign->status === 'sending')
                                        <span
                                            class="badge bg-warning bg-opacity-10 text-dark border border-warning px-2 py-1"><i
                                                class="fa-solid fa-spinner fa-spin me-1"></i> جارٍ الإرسال</span>
                                    @elseif ($campaign->status === 'queued')
                                        <span
                                            class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1"><i
                                                class="fa-solid fa-clock me-1"></i> في الانتظار</span>
                                    @elseif ($campaign->status === 'failed')
                                        <span
                                            class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1"><i
                                                class="fa-solid fa-xmark-circle me-1"></i> فشلت</span>
                                    @else
                                        <span
                                            class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">مسودة</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $campaign->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.email_campaigns.show', $campaign->id) }}"
                                            class="btn btn-sm btn-outline-info" title="عرض التفاصيل والسجلات">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        @if ($campaign->failed_count > 0)
                                            <form action="{{ route('admin.email_campaigns.resend_failed', $campaign->id) }}"
                                                method="POST" onsubmit="return confirm('هل أنت متأكد من إعادة إرسال الرسائل الفاشلة فقط (عدد: {{ $campaign->failed_count }})؟');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning"
                                                    title="إعادة إرسال الرسائل الفاشلة فقط ({{ $campaign->failed_count }})">
                                                    <i class="fa-solid fa-rotate-right"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.email_campaigns.destroy', $campaign->id) }}"
                                            method="POST" onsubmit="return confirm('هل أنت تأكد من حذف هذه الحملة؟');">
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
                                    <i class="fa-solid fa-inbox fa-3x mb-3 text-secondary d-block"></i>
                                    لا توجد أي حملات بريدية حالياً. اضغط على <strong>"إنشاء حملة جديدة"</strong> للبدء.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View (< 768px) -->
        <div class="d-block d-md-none p-3">
            @forelse ($campaigns as $campaign)
                <div class="card border mb-3 shadow-sm rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold text-dark mb-0 text-break pe-2">{{ $campaign->title }}</h6>
                            <span class="badge bg-light text-secondary border">#{{ $campaign->id }}</span>
                        </div>
                        <p class="small text-muted mb-2 text-break"><i class="fa-solid fa-envelope me-1"></i>
                            {{ $campaign->subject }}</p>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span
                                class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill">
                                {{ $campaign->target_audience_label }}
                            </span>
                            @if ($campaign->status === 'completed')
                                <span class="badge bg-success"><i class="fa-solid fa-check-circle me-1"></i>
                                    مكتملة</span>
                            @elseif ($campaign->status === 'sending')
                                <span class="badge bg-warning text-dark"><i
                                        class="fa-solid fa-spinner fa-spin me-1"></i> جارٍ الإرسال</span>
                            @elseif ($campaign->status === 'queued')
                                <span class="badge bg-info"><i class="fa-solid fa-clock me-1"></i> في الانتظار</span>
                            @elseif ($campaign->status === 'failed')
                                <span class="badge bg-danger"><i class="fa-solid fa-xmark-circle me-1"></i>
                                    فشلت</span>
                            @else
                                <span class="badge bg-secondary">مسودة</span>
                            @endif
                        </div>

                        <div class="bg-light p-2 rounded mb-3 small d-flex justify-content-between text-center">
                            <div>
                                <span class="text-muted d-block">المستهدفين</span>
                                <strong class="text-dark">{{ number_format($campaign->total_recipients) }}</strong>
                            </div>
                            <div>
                                <span class="text-muted d-block">ناجحة</span>
                                <strong class="text-success">{{ number_format($campaign->sent_count) }}</strong>
                            </div>
                            <div>
                                <span class="text-muted d-block">فاشلة</span>
                                <strong class="text-danger">{{ number_format($campaign->failed_count) }}</strong>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i>
                                {{ $campaign->created_at->format('Y-m-d H:i') }}</span>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.email_campaigns.show', $campaign->id) }}"
                                    class="btn btn-sm btn-outline-info px-2">
                                    <i class="fa-solid fa-eye me-1"></i> عرض
                                </a>
                                @if ($campaign->failed_count > 0)
                                    <form action="{{ route('admin.email_campaigns.resend_failed', $campaign->id) }}"
                                        method="POST" onsubmit="return confirm('هل أنت متأكد من إعادة إرسال الرسائل الفاشلة فقط (عدد: {{ $campaign->failed_count }})؟');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-warning px-2"
                                            title="إعادة إرسال الرسائل الفاشلة فقط ({{ $campaign->failed_count }})">
                                            <i class="fa-solid fa-rotate-right me-1"></i> إعادة الفاشلة
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.email_campaigns.destroy', $campaign->id) }}"
                                    method="POST" onsubmit="return confirm('هل أنت تأكد من حذف هذه الحملة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-2">
                                        <i class="fa-solid fa-trash me-1"></i> حذف
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-inbox fa-3x mb-3 text-secondary d-block"></i>
                    لا توجد أي حملات بريدية حالياً. اضغط على <strong>"إنشاء حملة جديدة"</strong> للبدء.
                </div>
            @endforelse
        </div>

        @if ($campaigns->hasPages())
            <div class="card-footer bg-white py-3 px-3 px-md-4">
                {{ $campaigns->links('vendor.pagination.dashboard-pagination') }}
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
