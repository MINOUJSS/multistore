<div class="container-fluid">

    <h3 class="mb-4">📊 لوحة التحكم المالية</h3>

    <!-- KPI Cards -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small>إجمالي المداخيل</small>
                    <h4 class="text-success">{{ number_format($totalIncome) }} DZD</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small>إجمالي المصاريف</small>
                    <h4 class="text-danger">{{ number_format($totalExpense) }} DZD</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small>صافي الربح</small>
                    <h4 class="text-primary">
                        {{ number_format($totalIncome - $totalExpense) }} DZD
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small>عمليات اليوم</small>
                    <h4>{{ $transactionsCount }}</h4>
                </div>
            </div>
        </div>

    </div>

    <!-- Chart -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            📈 المداخيل مقابل المصاريف (آخر 7 أيام)
        </div>
        <div class="card-body">
            <canvas id="financeChart"></canvas>
        </div>
    </div>

    <!-- Latest Transactions -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            📋 آخر العمليات المالية
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>النوع</th>
                        <th>التصنيف</th>
                        <th>المبلغ</th>
                        <th>الملاحظة</th>
                        <th>الوقت</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($latestTransactions as $tx)
                        <tr>
                            <td>{{ $tx->id }}</td>
                            <td>
                                <span class="badge {{ $tx->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $tx->type }}
                                </span>
                            </td>
                            <td>{{ $tx->category }}</td>
                            <td>{{ number_format($tx->amount) }} {{ $tx->currency }}</td>
                            <td>{{ $tx->note }}</td>
                            <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
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
                borderWidth: 2,
            },
            {
                label: 'مصاريف',
                data: {!! json_encode($chartData->pluck('expense')) !!},
                borderWidth: 2,
            }
        ]
    };

    new Chart(document.getElementById('financeChart'), {
        type: 'line',
        data: data,
    });
</script>