<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('visitorsChart').getContext('2d');
        // const ctx2 = document.getElementById('visitorsChart2').getContext('2d');

        // بيانات وهمية مبدئية
        let visitorsChartData = {
            daily: {
                labels: @json($dailyVisitorsLabels ?? []),
                data: @json($dailyVisitorsData ?? [])
            },
            weekly: {
                labels: @json($weeklyVisitorsLabels ?? []),
                data: @json($weeklyVisitorsData ?? [])
            },
            monthly: {
                labels: @json($monthlyVisitorsLabels ?? []),
                data: @json($monthlyVisitorsData ?? [])
            }
        };
                let visitorsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: visitorsChartData.daily.labels,
                datasets: [{
                    label: 'عدد الزوار',
                    data: visitorsChartData.daily.data,
                    backgroundColor: 'rgba(37, 99, 235, 0.2)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            font: {
                                family: 'Tahoma',
                                size: 14
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        // تغيير البيانات عند اختيار الفترة
        document.getElementById('visitorsTimeRange').addEventListener('change', function() {
            let selected = this.value;
            visitorsChart.data.labels = visitorsChartData[selected].labels;
            visitorsChart.data.datasets[0].data = visitorsChartData[selected].data;
            visitorsChart.update();
        });
    });
</script>