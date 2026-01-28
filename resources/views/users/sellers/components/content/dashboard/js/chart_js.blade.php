<!-- استدعاء مكتبة Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('ordersChart').getContext('2d');
        const ctx2 = document.getElementById('statusChart').getContext('2d');

        // بيانات وهمية مبدئية
        let chartData = {
            daily: {
                labels: @json($dailyLabels ?? []),
                data: @json($dailyData ?? [])
            },
            weekly: {
                labels: @json($weeklyLabels ?? []),
                data: @json($weeklyData ?? [])
            },
            monthly: {
                labels: @json($monthlyLabels ?? []),
                data: @json($monthlyData ?? [])
            }
        };
        //console.log(chartData);
        // مخطط الطلبات الخطي
        let ordersChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.daily.labels,
                datasets: [{
                    label:'كل الطلبات',
                    data: chartData.daily.data,
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

        // مخطط حالة الطلبات الدائري
        // خريطة الألوان لكل حالة (بالعربية)
        const statusColors = {
            "قيد الانتظار": {
                bg: 'rgba(255, 206, 86, 0.7)',
                border: 'rgba(255, 206, 86, 1)'
            },
            "قيد المعالجة": {
                bg: 'rgba(255, 159, 64, 0.7)', // برتقالي للخلفية
                border: 'rgba(255, 159, 64, 1)' // برتقالي للحدود
            },
            "تم الشحن": {
                bg: 'rgba(75, 192, 192, 0.7)',
                border: 'rgba(75, 192, 192, 1)'
            },
            "مكتمل": {
                bg: 'rgba(34, 197, 94, 0.7)',
                border: 'rgba(34, 197, 94, 1)'
            },
            "ملغى": {
                bg: 'rgba(239, 68, 68, 0.7)',
                border: 'rgba(239, 68, 68, 1)'
            }
        };
        // جلب labels من السيرفر
        let labels = @json($statusLabels ?? []);
        let data = @json($statusData ?? []);
        console.log(labels);

        // توليد المصفوفة المناسبة للألوان
        let backgroundColors = labels.map(label => statusColors[label]?.bg || 'rgba(0,0,0,0.3)');
        let borderColors = labels.map(label => statusColors[label]?.border || 'rgba(0,0,0,1)');
        //

        // إنشاء الرسم
        if (labels.length > 0 && data.length > 0) {

            let statusChart = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: 'Tahoma',
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });

        } else {
            let statusChart = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: ['لا يوجد طلبات'],
                    datasets: [{
                        data: [1],
                        backgroundColor: ['rgba(255,255,255,0.1)'],
                        borderColor: ['rgba(0,0,0,0.1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: 'Tahoma',
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });
        }


        // تغيير البيانات عند اختيار الفترة
        document.getElementById('timeRange').addEventListener('change', function() {
            let selected = this.value;
            ordersChart.data.labels = chartData[selected].labels;
            ordersChart.data.datasets[0].data = chartData[selected].data;
            ordersChart.update();
        });
        // تغيير البيانات عند اختيار الفترة (daily/weekly/monthly)
        // document.getElementById('timeRange').addEventListener('change', function() {
        //     let selected = this.value;
        //     if (chartData[selected]) {
        //         ordersChart.data.labels = chartData[selected].labels;
        //         ordersChart.data.datasets[0].data = chartData[selected].data;
        //         ordersChart.update();
        //     }
        // });


    });
</script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('ordersChart').getContext('2d');
        const ctx2 = document.getElementById('statusChart').getContext('2d');

        // بيانات من السيرفر
        let chartData = {
            daily: {
                labels: @json($dailyLabels ?? []),
                data: @json($dailyData ?? [])
            },
            weekly: {
                labels: @json($weeklyLabels ?? []),
                data: @json($weeklyData ?? [])
            },
            monthly: {
                labels: @json($monthlyLabels ?? []),
                data: @json($monthlyData ?? [])
            }
        };

        // مخطط الطلبات
        let ordersChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.weekly.labels,
                datasets: [{
                    label: 'عدد الطلبات',
                    data: chartData.weekly.data,
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
                            font: { family: 'Tahoma', size: 14 }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // فلترة بيانات اليومي: 3 أيام قبل و 3 أيام بعد
        function getDailyRange(labels, data) {
            let today = new Date().toISOString().split("T")[0]; // تاريخ اليوم بصيغة YYYY-MM-DD
            let idx = labels.indexOf(today);
            if (idx === -1) return { labels, data }; // في حال لم يجد اليوم

            let start = Math.max(0, idx - 3);
            let end = Math.min(labels.length, idx + 4); // +4 لأنه end غير شامل

            return {
                labels: labels.slice(start, end),
                data: data.slice(start, end)
            };
        }

        // مخطط الحالة الدائري
        const statusColors = {
            "قيد الانتظار": { bg: 'rgba(255, 206, 86, 0.7)', border: 'rgba(255, 206, 86, 1)' },
            "قيد المعالجة": { bg: 'rgba(255, 159, 64, 0.7)', border: 'rgba(255, 159, 64, 1)' },
            "تم الشحن": { bg: 'rgba(75, 192, 192, 0.7)', border: 'rgba(75, 192, 192, 1)' },
            "مكتمل": { bg: 'rgba(34, 197, 94, 0.7)', border: 'rgba(34, 197, 94, 1)' },
            "ملغى": { bg: 'rgba(239, 68, 68, 0.7)', border: 'rgba(239, 68, 68, 1)' }
        };

        let labels = @json($statusLabels ?? []);
        let data = @json($statusData ?? []);

        let backgroundColors = labels.map(label => statusColors[label]?.bg || 'rgba(0,0,0,0.3)');
        let borderColors = labels.map(label => statusColors[label]?.border || 'rgba(0,0,0,1)');

        let statusChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: 'Tahoma', size: 14 }
                        }
                    }
                }
            }
        });

        // تحديث عند تغيير الفترة
        document.getElementById('timeRange').addEventListener('change', function() {
            let selected = this.value;

            if (selected === "daily") {
                let filtered = getDailyRange(chartData.daily.labels, chartData.daily.data);
                ordersChart.data.labels = filtered.labels;
                ordersChart.data.datasets[0].data = filtered.data;
            } else if (chartData[selected]) {
                ordersChart.data.labels = chartData[selected].labels;
                ordersChart.data.datasets[0].data = chartData[selected].data;
            }

            ordersChart.update();
        });
    });
</script> --}}
