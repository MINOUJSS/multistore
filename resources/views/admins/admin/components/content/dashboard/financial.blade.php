<div class="container-fluid py-4 overflow-hidden" style="max-width: 100%;">

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <h3 class="fw-bold mb-0">📊 لوحة التحكم المالية</h3>
    </div>

    <!-- KPI Cards -->
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <small class="text-muted mb-1">إجمالي المداخيل</small>
                    <h4 class="text-success fw-bold mb-0">{{ number_format($totalIncome) }} DZD</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <small class="text-muted mb-1">إجمالي المصاريف</small>
                    <h4 class="text-danger fw-bold mb-0">{{ number_format($totalExpense) }} DZD</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <small class="text-muted mb-1">صافي الربح</small>
                    <h4 class="text-primary fw-bold mb-0">
                        {{ number_format($totalIncome - $totalExpense) }} DZD
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <small class="text-muted mb-1">عمليات اليوم</small>
                    <h4 class="fw-bold mb-0">{{ $transactionsCount }}</h4>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart Card -->
    <div class="card shadow-sm border-0 mb-4 w-100 overflow-hidden" style="max-width: 100%;">
        <div class="card-header bg-white fw-bold py-3">
            📈 المداخيل مقابل المصاريف (آخر 7 أيام)
        </div>
        <div class="card-body p-3 overflow-hidden" style="max-width: 100%;">
            <div class="chart-container">
                <canvas id="financeChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Latest Transactions Table -->
    <div class="card shadow-sm border-0 w-100 overflow-hidden" style="max-width: 100%;">
        <div class="card-header bg-white fw-bold py-3">
            📋 آخر العمليات المالية
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
                                <span class="badge {{ $tx->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $tx->type }}
                                </span>
                            </td>
                            <td data-label="التصنيف">{{ $tx->category }}</td>
                            <td data-label="المبلغ" class="fw-bold">{{ number_format($tx->amount) }} {{ $tx->currency }}</td>
                            <td data-label="الملاحظة">{{ $tx->note }}</td>
                            <td data-label="الوقت">{{ $tx->created_at->format('Y-m-d H:i') }}</td>
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
