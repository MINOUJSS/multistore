<div class="container-fluid px-3 px-md-4 py-3 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-wallet text-warning"></i>
                    <span>{{ __('لوحة التحكم المالية') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    📊 الإحصائيات والمؤشرات المالية 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    إليك ملخص شامل ومحدث للمداخيل، المصاريف، صافي الأرباح، والعمليات المالية في المنصة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.payments.recharge_requests') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm">
                        <i class="fa-solid fa-bolt me-1"></i> طلبات الشحن
                    </a>
                    <a href="{{ route('admin.payments.invoices_payments') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
                        <i class="fa-solid fa-file-invoice-dollar me-1"></i> الفواتير
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards Style -->
    <style>
        .dashboard-stat-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .dashboard-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08) !important;
        }
        .stat-icon-wrapper {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .bg-emerald-subtle { background-color: rgba(16, 185, 129, 0.1); color: #10b981; }
        .bg-rose-subtle { background-color: rgba(244, 63, 94, 0.1); color: #f43f5e; }
        .bg-indigo-subtle { background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; }
        .bg-amber-subtle { background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    </style>

    <!-- KPI Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Income -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper bg-emerald-subtle">
                            <i class="fa-solid fa-arrow-down-left-and-arrow-up-right-to-center fa-lg"></i>
                        </span>
                        <span class="badge bg-emerald-subtle px-2.5 py-1 rounded-pill fw-semibold small">مداخيل</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">إجمالي المداخيل</h6>
                    <h4 class="text-success fw-bold mb-0">{{ number_format($totalIncome) }} <small class="fs-6 text-muted">DZD</small></h4>
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper bg-rose-subtle">
                            <i class="fa-solid fa-arrow-right-from-bracket fa-lg"></i>
                        </span>
                        <span class="badge bg-rose-subtle px-2.5 py-1 rounded-pill fw-semibold small">مصاريف</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">إجمالي المصاريف</h6>
                    <h4 class="text-danger fw-bold mb-0">{{ number_format($totalExpense) }} <small class="fs-6 text-muted">DZD</small></h4>
                </div>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper bg-indigo-subtle">
                            <i class="fa-solid fa-scale-balanced fa-lg"></i>
                        </span>
                        <span class="badge bg-indigo-subtle px-2.5 py-1 rounded-pill fw-semibold small">الربح</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">صافي الربح</h6>
                    <h4 class="text-primary fw-bold mb-0">{{ number_format($totalIncome - $totalExpense) }} <small class="fs-6 text-muted">DZD</small></h4>
                </div>
            </div>
        </div>

        <!-- Today Transactions -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper bg-amber-subtle">
                            <i class="fa-solid fa-receipt fa-lg"></i>
                        </span>
                        <span class="badge bg-amber-subtle px-2.5 py-1 rounded-pill fw-semibold small">اليوم</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">عمليات اليوم</h6>
                    <h4 class="fw-bold mb-0 text-dark">{{ $transactionsCount }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 w-100 overflow-hidden" style="max-width: 100%;">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-chart-line" style="color: #a40c72;"></i>
            <span>المداخيل مقابل المصاريف (آخر 7 أيام)</span>
        </div>
        <div class="card-body p-3 overflow-hidden" style="max-width: 100%;">
            <div class="chart-container">
                <canvas id="financeChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Latest Transactions Table -->
    <div class="card border-0 shadow-sm rounded-4 w-100 overflow-hidden" style="max-width: 100%;">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-list-check" style="color: #a40c72;"></i>
            <span>آخر العمليات المالية</span>
        </div>
        <div class="table-responsive p-0">
            <table class="table table-hover align-middle mb-0" id="financialTransactionsTable">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>النوع</th>
                        <th>التصنيف</th>
                        <th>المبلغ</th>
                        <th>الملاحظة</th>
                        <th>الوقت</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($latestTransactions as $tx)
                        <tr>
                            <td data-label="#">{{ $tx->id }}</td>
                            <td data-label="النوع">
                                <span class="badge rounded-pill px-2.5 py-1 {{ $tx->type == 'income' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}">
                                    {{ $tx->type == 'income' ? 'مداخيل' : 'مصاريف' }}
                                </span>
                            </td>
                            <td data-label="التصنيف"><span class="badge bg-light text-dark fw-normal border px-2.5 py-1 rounded-3">{{ $tx->category }}</span></td>
                            <td data-label="المبلغ" class="fw-bold">{{ number_format($tx->amount) }} {{ $tx->currency }}</td>
                            <td data-label="الملاحظة">{{ $tx->note }}</td>
                            <td data-label="الوقت" class="text-muted small">{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-muted">
                                <i class="fa-solid fa-circle-info me-1"></i>
                                لا توجد عمليات مالية
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const data = {
        labels: {!! json_encode($chartData->pluck('date')) !!},
        datasets: [
            {
                label: 'مداخيل',
                data: {!! json_encode($chartData->pluck('income')) !!},
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            },
            {
                label: 'مصاريف',
                data: {!! json_encode($chartData->pluck('expense')) !!},
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }
        ]
    };

    new Chart(document.getElementById('financeChart'), {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            resizeDelay: 100,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>

<style>
/* Chart Responsiveness Constraints */
.chart-container {
    position: relative;
    width: 100% !important;
    max-width: 100% !important;
    height: 300px;
    overflow: hidden;
}

#financeChart {
    width: 100% !important;
    max-width: 100% !important;
    height: 100% !important;
}

/* Pure CSS Responsive Table for #financialTransactionsTable */
@media (max-width: 991.98px) {
    #financialTransactionsTable, 
    #financialTransactionsTable tbody, 
    #financialTransactionsTable tr, 
    #financialTransactionsTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #financialTransactionsTable thead {
        display: none !important;
    }
    
    #financialTransactionsTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #financialTransactionsTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #financialTransactionsTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #financialTransactionsTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>
