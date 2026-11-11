<style>
    .merchant-analytics-section .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .merchant-analytics-section .btn-period {
        font-size: 0.82rem;
        font-weight: 600;
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        transition: all 0.2s ease;
    }
    .merchant-analytics-section .btn-period:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
    }
    .merchant-analytics-section .btn-period.active {
        background: linear-gradient(135deg, #5c0649 0%, #be0681 100%);
        color: #ffffff !important;
        border-color: #5c0649;
        box-shadow: 0 4px 10px rgba(190, 6, 129, 0.25);
    }
    .merchant-stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .device-progress-item {
        margin-bottom: 0.75rem;
    }
    .device-progress-item:last-child {
        margin-bottom: 0;
    }
    .ip-table-wrapper {
        max-height: 380px;
        overflow-y: auto;
    }
</style>

<div class="mb-4 merchant-analytics-section">
    <!-- Section Header with Period Controls -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h5 class="fw-bold mb-1 text-dark">
                <i class="fa-solid fa-chart-area me-2" style="color: #be0681;"></i>
                تحليلات نشاط واتصال التجار (الأجهزة، المواقع، والفترات)
            </h5>
            <span class="text-muted small">
                رصد تفاعلي لمعدل نشاط التجار، الأجهزة والمتصفحات الأكثر استخداماً، وعناوين الاتصال اعتماداً على جدول <code>last_seens</code>
            </span>
        </div>
        <div class="d-flex align-items-center gap-1 bg-white p-1 rounded-pill shadow-sm border">
            <button type="button" class="btn btn-period active" data-period="daily">
                <i class="fa-solid fa-calendar-day me-1"></i> يومي (30 يوماً)
            </button>
            <button type="button" class="btn btn-period" data-period="monthly">
                <i class="fa-solid fa-calendar-week me-1"></i> شهري (12 شهراً)
            </button>
            <button type="button" class="btn btn-period" data-period="yearly">
                <i class="fa-solid fa-calendar me-1"></i> سنوي (5 سنوات)
            </button>
        </div>
    </div>

    <!-- Quick Mini KPIs -->
    <div class="row g-3 mb-3">
        <!-- Active Today -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper" style="background-color: rgba(16, 185, 129, 0.12); color: #10b981;">
                            <i class="fa-solid fa-user-clock fa-lg"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill small fw-bold">اليوم</span>
                    </div>
                    <div class="text-muted small mb-1 fw-semibold">تجار نشطون اليوم</div>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($merchantActivity['kpis']['today_active_merchants'] ?? 0) }}</h4>
                </div>
            </div>
        </div>

        <!-- Active This Month -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper" style="background-color: rgba(79, 70, 229, 0.12); color: #4f46e5;">
                            <i class="fa-solid fa-calendar-check fa-lg"></i>
                        </span>
                        <span class="badge bg-primary-subtle text-primary px-2 py-1 rounded-pill small fw-bold">هذا الشهر</span>
                    </div>
                    <div class="text-muted small mb-1 fw-semibold">تجار نشطون هذا الشهر</div>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($merchantActivity['kpis']['this_month_active_merchants'] ?? 0) }}</h4>
                </div>
            </div>
        </div>

        <!-- Top Device -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper" style="background-color: rgba(190, 6, 129, 0.12); color: #be0681;">
                            @if (($merchantActivity['kpis']['top_device'] ?? '') === 'Mobile')
                                <i class="fa-solid fa-mobile-screen-button fa-lg"></i>
                            @elseif (($merchantActivity['kpis']['top_device'] ?? '') === 'Tablet')
                                <i class="fa-solid fa-tablet-screen-button fa-lg"></i>
                            @else
                                <i class="fa-solid fa-laptop fa-lg"></i>
                            @endif
                        </span>
                        <span class="badge bg-secondary-subtle text-dark px-2 py-1 rounded-pill small fw-bold">الجهاز الأكثر</span>
                    </div>
                    <div class="text-muted small mb-1 fw-semibold">الجهاز المفضل للتجار</div>
                    <h4 class="fw-bold mb-0 text-dark">
                        @if (($merchantActivity['kpis']['top_device'] ?? '') === 'Mobile')
                            هاتف ذكي (Mobile)
                        @elseif (($merchantActivity['kpis']['top_device'] ?? '') === 'Tablet')
                            جهاز لوحي (Tablet)
                        @else
                            حاسوب (Desktop)
                        @endif
                    </h4>
                </div>
            </div>
        </div>

        <!-- Top Browser -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper" style="background-color: rgba(245, 158, 11, 0.12); color: #f59e0b;">
                            <i class="fa-brands fa-chrome fa-lg"></i>
                        </span>
                        <span class="badge bg-warning-subtle text-warning-emphasis px-2 py-1 rounded-pill small fw-bold">المتصفح الأبرز</span>
                    </div>
                    <div class="text-muted small mb-1 fw-semibold">المتصفح الأكثر استخداماً</div>
                    <h4 class="fw-bold mb-0 text-dark text-truncate" title="{{ $merchantActivity['kpis']['top_browser'] ?? 'Chrome' }}">
                        {{ $merchantActivity['kpis']['top_browser'] ?? 'Google Chrome' }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Primary Row: Activity Timeline Chart + Devices Distribution Chart -->
    <div class="row g-3 mb-3">
        <!-- Main Timeline Chart (Daily / Monthly / Yearly) -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <div>
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="fa-solid fa-chart-line me-2" style="color: #be0681;"></i>
                                منحنى نشاط وتسجيل دخول التجار
                            </h6>
                            <span class="text-muted small" id="merchantChartSubtitle">
                                عرض عدد تسجيلات الدخول اليومية والتجار الفريدين لآخر 30 يوماً
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="merchant-stat-pill bg-light text-dark border">
                                <span class="badge rounded-circle p-1" style="background-color: #be0681;">&nbsp;</span>
                                <span id="merchantChartTotalLabel">إجمالي التسجيلات</span>
                            </span>
                        </div>
                    </div>

                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="merchantActivityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Devices Breakdown (Desktop vs Mobile vs Tablet) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold text-dark mb-0">
                            <i class="fa-solid fa-laptop-mobile me-2" style="color: #4f46e5;"></i>
                            نوع الأجهزة المستخدمة
                        </h6>
                        <span class="badge bg-light text-muted border small">آخر 2000 نشاط</span>
                    </div>

                    <div style="position: relative; height: 180px; width: 100%;" class="mb-3">
                        <canvas id="merchantDeviceChart"></canvas>
                    </div>

                    <!-- Progress breakdown -->
                    <div class="pt-2 border-top">
                        <div class="device-progress-item">
                            <div class="d-flex justify-content-between align-items-center small mb-1">
                                <span class="fw-semibold text-dark">
                                    <i class="fa-solid fa-desktop me-1 text-primary"></i> حاسوب (Desktop)
                                </span>
                                <span class="fw-bold text-dark">{{ $merchantActivity['devices']['percentages']['Desktop'] ?? 0 }}%</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 6px; background-color: #e2e8f0;">
                                <div class="progress-bar rounded-pill" style="width: {{ $merchantActivity['devices']['percentages']['Desktop'] ?? 0 }}%; background-color: #4f46e5;"></div>
                            </div>
                        </div>

                        <div class="device-progress-item">
                            <div class="d-flex justify-content-between align-items-center small mb-1">
                                <span class="fw-semibold text-dark">
                                    <i class="fa-solid fa-mobile-screen me-1" style="color: #10b981;"></i> هاتف ذكي (Mobile)
                                </span>
                                <span class="fw-bold text-dark">{{ $merchantActivity['devices']['percentages']['Mobile'] ?? 0 }}%</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 6px; background-color: #e2e8f0;">
                                <div class="progress-bar rounded-pill" style="width: {{ $merchantActivity['devices']['percentages']['Mobile'] ?? 0 }}%; background-color: #10b981;"></div>
                            </div>
                        </div>

                        <div class="device-progress-item">
                            <div class="d-flex justify-content-between align-items-center small mb-1">
                                <span class="fw-semibold text-dark">
                                    <i class="fa-solid fa-tablet-screen-button me-1" style="color: #f59e0b;"></i> جهاز لوحي (Tablet)
                                </span>
                                <span class="fw-bold text-dark">{{ $merchantActivity['devices']['percentages']['Tablet'] ?? 0 }}%</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 6px; background-color: #e2e8f0;">
                                <div class="progress-bar rounded-pill" style="width: {{ $merchantActivity['devices']['percentages']['Tablet'] ?? 0 }}%; background-color: #f59e0b;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Row: Browsers & Platforms Breakdown + IP Addresses & Connection Points -->
    <div class="row g-3">
        <!-- Browsers & Operating Systems -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3 p-md-4">
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="fa-solid fa-globe me-2" style="color: #0d9488;"></i>
                        المتصفحات وأنظمة التشغيل
                    </h6>

                    <!-- Top Browsers -->
                    <div class="mb-4">
                        <div class="text-muted small fw-semibold mb-2">أبرز المتصفحات المستخدمة:</div>
                        @php
                            $browserLabels = $merchantActivity['devices']['browsers']['labels'] ?? [];
                            $browserCounts = $merchantActivity['devices']['browsers']['counts'] ?? [];
                            $totalBrowserCount = array_sum($browserCounts) ?: 1;
                        @endphp

                        @forelse(array_slice($browserLabels, 0, 4) as $idx => $bName)
                            @php
                                $bCount = $browserCounts[$idx] ?? 0;
                                $bPercent = round(($bCount / $totalBrowserCount) * 100, 1);
                            @endphp
                            <div class="d-flex align-items-center justify-content-between py-1.5 border-bottom border-light">
                                <div class="d-flex align-items-center gap-2">
                                    @if(str_contains(strtolower($bName), 'chrome'))
                                        <i class="fa-brands fa-chrome text-warning fs-6"></i>
                                    @elseif(str_contains(strtolower($bName), 'safari'))
                                        <i class="fa-brands fa-safari text-primary fs-6"></i>
                                    @elseif(str_contains(strtolower($bName), 'edge'))
                                        <i class="fa-brands fa-edge text-info fs-6"></i>
                                    @elseif(str_contains(strtolower($bName), 'firefox'))
                                        <i class="fa-brands fa-firefox-browser text-danger fs-6"></i>
                                    @else
                                        <i class="fa-solid fa-window-maximize text-secondary fs-6"></i>
                                    @endif
                                    <span class="small fw-semibold text-dark">{{ $bName }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-light text-dark border small">{{ $bCount }}</span>
                                    <span class="small text-muted" style="min-width: 40px; text-align: left;">{{ $bPercent }}%</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">لا توجد بيانات متصفحات مسجلة حتى الآن.</p>
                        @endforelse
                    </div>

                    <!-- Operating Systems Tags -->
                    <div>
                        <div class="text-muted small fw-semibold mb-2">أنظمة التشغيل (OS):</div>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $osLabels = $merchantActivity['devices']['platforms']['labels'] ?? [];
                                $osCounts = $merchantActivity['devices']['platforms']['counts'] ?? [];
                            @endphp

                            @forelse($osLabels as $idx => $platformName)
                                @php
                                    $pCount = $osCounts[$idx] ?? 0;
                                @endphp
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-3 small d-inline-flex align-items-center gap-1.5">
                                    @if(str_contains(strtolower($platformName), 'windows'))
                                        <i class="fa-brands fa-windows text-primary"></i>
                                    @elseif(str_contains(strtolower($platformName), 'android'))
                                        <i class="fa-brands fa-android text-success"></i>
                                    @elseif(str_contains(strtolower($platformName), 'ios') || str_contains(strtolower($platformName), 'mac'))
                                        <i class="fa-brands fa-apple text-dark"></i>
                                    @elseif(str_contains(strtolower($platformName), 'linux'))
                                        <i class="fa-brands fa-linux text-warning"></i>
                                    @else
                                        <i class="fa-solid fa-microchip text-secondary"></i>
                                    @endif
                                    <span>{{ $platformName }}</span>
                                    <strong class="ms-1 text-primary">({{ $pCount }})</strong>
                                </span>
                            @empty
                                <span class="text-muted small">لا توجد بيانات كافية</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Connection Locations & Top IP Addresses -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <div>
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="fa-solid fa-network-wired me-2" style="color: #3b82f6;"></i>
                                أصل الاتصال وعناوين IP النشطة للتجار
                            </h6>
                            <span class="text-muted small">أبرز عناوين IP المسجلة في جدول <code>last_seens</code> مع تقدير الموقع</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-pill small">
                                🇩🇿 {{ $merchantActivity['locations']['summary']['algeria_percentage'] ?? 100 }}% اتصال وطني
                            </span>
                        </div>
                    </div>

                    <div class="table-responsive ip-table-wrapper">
                        <table class="table table-hover table-borderless align-middle mb-0 text-nowrap">
                            <thead class="table-light rounded-3 text-muted small">
                                <tr>
                                    <th class="border-0">عنوان IP</th>
                                    <th class="border-0">الموقع المقدر</th>
                                    <th class="border-0 text-center">التكرار</th>
                                    <th class="border-0 text-center">التجار</th>
                                    <th class="border-0">البيئة / الجهاز</th>
                                    <th class="border-0 text-end">آخر ظهور</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @forelse($merchantActivity['locations']['top_ips'] ?? [] as $ipRow)
                                    <tr>
                                        <td>
                                            <span class="fw-bold font-monospace text-dark bg-light px-2 py-1 rounded border">
                                                {{ $ipRow['ip_address'] }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(str_contains($ipRow['location'], 'الجزائر'))
                                                <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill">
                                                    {{ $ipRow['location'] }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-pill">
                                                    {{ $ipRow['location'] }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 rounded-pill">
                                                {{ number_format($ipRow['total_connections']) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info-subtle text-info-emphasis fw-bold px-2 py-1 rounded-pill">
                                                {{ number_format($ipRow['total_merchants']) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-1.5 text-muted">
                                                @if($ipRow['device_type'] === 'Mobile')
                                                    <i class="fa-solid fa-mobile-screen text-success"></i>
                                                @elseif($ipRow['device_type'] === 'Tablet')
                                                    <i class="fa-solid fa-tablet-screen-button text-warning"></i>
                                                @else
                                                    <i class="fa-solid fa-laptop text-primary"></i>
                                                @endif
                                                <span>{{ $ipRow['platform'] }} / {{ $ipRow['browser'] }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end text-muted">
                                            <i class="fa-regular fa-clock me-1"></i>{{ $ipRow['last_activity'] }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fa-solid fa-info-circle me-1"></i> لا توجد بيانات اتصال كافية في جدول <code>last_seens</code> حتى الآن.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN (if not loaded) & Interactive Script -->
@once
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
@endonce

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Data payloads from backend
    const timelineData = @json($merchantActivity['timeline'] ?? []);
    const deviceData = @json($merchantActivity['devices'] ?? []);

    // 2. Main Timeline Activity Chart
    const activityCtx = document.getElementById('merchantActivityChart');
    if (!activityCtx) return;

    let activityChart = null;

    function renderTimeline(period) {
        const periodInfo = timelineData[period] || { labels: [], data: [] };
        const labels = periodInfo.labels || [];
        const dataValues = periodInfo.data || [];
        const uniqueValues = periodInfo.unique_merchants || [];

        const isDaily = period === 'daily';

        const datasets = [
            {
                label: 'إجمالي مرات تسجيل الدخول',
                data: dataValues,
                borderColor: '#be0681',
                backgroundColor: 'rgba(190, 6, 129, 0.12)',
                borderWidth: 2.5,
                fill: true,
                tension: 0.35,
                pointRadius: isDaily ? 3 : 5,
                pointHoverRadius: 6,
                pointBackgroundColor: '#be0681',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2
            }
        ];

        // If daily, show unique active merchants as a complementary dashed line
        if (isDaily && uniqueValues.length > 0) {
            datasets.push({
                label: 'تجار فريدون نشطون (Unique)',
                data: uniqueValues,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.05)',
                borderWidth: 2,
                borderDash: [5, 5],
                fill: false,
                tension: 0.35,
                pointRadius: 3,
                pointHoverRadius: 5,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 1.5
            });
        }

        if (activityChart) {
            activityChart.data.labels = labels;
            activityChart.data.datasets = datasets;
            activityChart.update('active');
            return;
        }

        activityChart = new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        position: 'top',
                        rtl: true,
                        labels: {
                            font: { family: 'inherit', size: 12 },
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    },
                    tooltip: {
                        rtl: true,
                        titleFont: { family: 'inherit' },
                        bodyFont: { family: 'inherit' },
                        padding: 10,
                        boxPadding: 4,
                        callbacks: {
                            label: function (ctx) {
                                return ctx.dataset.label + ': ' + ctx.parsed.y + ' عملية';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { family: 'inherit', size: 11 }
                        },
                        grid: {
                            color: 'rgba(226, 232, 240, 0.6)'
                        }
                    },
                    x: {
                        ticks: {
                            font: { family: 'inherit', size: 11 }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Initialize with Daily
    renderTimeline('daily');

    // Handle period button clicks
    const periodButtons = document.querySelectorAll('.merchant-analytics-section .btn-period');
    const subtitleEl = document.getElementById('merchantChartSubtitle');

    periodButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            periodButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const period = this.getAttribute('data-period');
            renderTimeline(period);

            if (subtitleEl) {
                if (period === 'daily') {
                    subtitleEl.textContent = 'عرض عدد تسجيلات الدخول اليومية والتجار الفريدين لآخر 30 يوماً';
                } else if (period === 'monthly') {
                    subtitleEl.textContent = 'عرض إجمالي تسجيلات دخول التجار لكل شهر على مدار آخر 12 شهراً';
                } else if (period === 'yearly') {
                    subtitleEl.textContent = 'عرض إجمالي تسجيلات دخول التجار السنوية لآخر 5 سنوات';
                }
            }
        });
    });

    // 3. Devices Breakdown Doughnut Chart
    const deviceCtx = document.getElementById('merchantDeviceChart');
    if (deviceCtx && deviceData && deviceData.devices) {
        new Chart(deviceCtx, {
            type: 'doughnut',
            data: {
                labels: deviceData.devices.labels || ['حاسوب', 'هاتف', 'لوحي'],
                datasets: [{
                    data: deviceData.devices.counts || [0, 0, 0],
                    backgroundColor: ['#4f46e5', '#10b981', '#f59e0b'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        rtl: true,
                        callbacks: {
                            label: function (ctx) {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0) || 1;
                                const val = ctx.parsed;
                                const pct = ((val / total) * 100).toFixed(1);
                                return ctx.label + ': ' + val + ' (' + pct + '%)';
                            }
                        }
                    }
                },
                cutout: '72%'
            }
        });
    }
});
</script>

