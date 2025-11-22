@extends('admin.layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Analytics Dashboard</h1>
        <p class="page-subtitle">Statistik dan analisis aktivitas user</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.activity-logs.index') }}">Activity Logs</a>
            <span>/</span>
            <span>Analytics</span>
        </div>
    </div>

    <!-- Period Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="period-selector">
                <label>Periode:</label>
                <div class="period-buttons">
                    <a href="{{ route('admin.activity-logs.analytics', ['period' => 'today']) }}"
                        class="period-btn {{ $period == 'today' ? 'active' : '' }}">
                        Hari Ini
                    </a>
                    <a href="{{ route('admin.activity-logs.analytics', ['period' => 'week']) }}"
                        class="period-btn {{ $period == 'week' ? 'active' : '' }}">
                        Minggu Ini
                    </a>
                    <a href="{{ route('admin.activity-logs.analytics', ['period' => 'month']) }}"
                        class="period-btn {{ $period == 'month' ? 'active' : '' }}">
                        Bulan Ini
                    </a>
                    <a href="{{ route('admin.activity-logs.analytics', ['period' => 'year']) }}"
                        class="period-btn {{ $period == 'year' ? 'active' : '' }}">
                        Tahun Ini
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Stats -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: #dbeafe;">
                <i class="fas fa-mouse-pointer" style="color: #1e40af;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ number_format($stats['total_activities']) }}</div>
                <div class="stat-label">Total Aktivitas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #d1fae5;">
                <i class="fas fa-users" style="color: #065f46;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ number_format($stats['active_users']) }}</div>
                <div class="stat-label">Active Users</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7;">
                <i class="fas fa-layer-group" style="color: #92400e;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ number_format($stats['user_sessions']) }}</div>
                <div class="stat-label">Total Sessions</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fee2e2;">
                <i class="fas fa-clock" style="color: #991b1b;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['average_session_duration'] }}</div>
                <div class="stat-label">Avg. Duration (min)</div>
            </div>
        </div>
    </div>

    <div class="analytics-grid">
        <!-- Left Column -->
        <div class="analytics-main">
            <!-- Popular Pages -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-fire"></i>
                        Halaman Terpopuler
                    </h3>
                </div>
                <div class="card-body">
                    @if ($stats['popular_pages']->isNotEmpty())
                        <div class="popular-pages-list">
                            @foreach ($stats['popular_pages'] as $page)
                                <div class="popular-page-item">
                                    <div class="page-info">
                                        <i class="fas fa-file-alt"></i>
                                        <span class="page-name">{{ $page['route'] }}</span>
                                    </div>
                                    <div class="page-stats">
                                        <span class="visit-count">{{ number_format($page['visits']) }}</span>
                                        <div class="visit-bar"
                                            style="width: {{ ($page['visits'] / $stats['popular_pages']->first()['visits']) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada data</p>
                    @endif
                </div>
            </div>

            <!-- Hourly Activity Chart -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line"></i>
                        Aktivitas Per Jam
                    </h3>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="hourlyChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Daily Activity Chart -->
            @if (in_array($period, ['week', 'month', 'year']))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-area"></i>
                            Aktivitas Harian
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="dailyChart"></canvas>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="analytics-sidebar">
            <!-- Peak Hours -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-star"></i>
                        Jam Tersibuk
                    </h3>
                </div>
                <div class="card-body">
                    @if (!empty($stats['peak_hours']))
                        <div class="peak-hours-list">
                            @foreach ($stats['peak_hours'] as $hour => $count)
                                <div class="peak-hour-item">
                                    <div class="hour-badge">
                                        {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00
                                    </div>
                                    <div class="hour-count">
                                        <i class="fas fa-mouse-pointer"></i>
                                        {{ number_format($count) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada data</p>
                    @endif
                </div>
            </div>

            <!-- Device Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-mobile-alt"></i>
                        Device Statistics
                    </h3>
                </div>
                <div class="card-body">
                    <div class="device-stats">
                        @php
                            $total = array_sum($stats['device_stats']);
                        @endphp
                        @foreach ($stats['device_stats'] as $device => $count)
                            @php
                                $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                            @endphp
                            <div class="device-item">
                                <div class="device-info">
                                    <i
                                        class="fas fa-{{ $device == 'Mobile' ? 'mobile-alt' : ($device == 'Tablet' ? 'tablet-alt' : 'desktop') }}"></i>
                                    <span>{{ $device }}</span>
                                </div>
                                <div class="device-stat">
                                    <span class="device-count">{{ number_format($count) }}</span>
                                    <span class="device-percent">{{ number_format($percentage, 1) }}%</span>
                                </div>
                                <div class="device-bar">
                                    <div class="device-bar-fill" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Browser Stats -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fab fa-chrome"></i>
                        Browser Statistics
                    </h3>
                </div>
                <div class="card-body">
                    <div class="browser-stats">
                        @php
                            $browserTotal = array_sum($stats['browser_stats']);
                        @endphp
                        @foreach ($stats['browser_stats'] as $browser => $count)
                            @php
                                $percentage = $browserTotal > 0 ? ($count / $browserTotal) * 100 : 0;
                                $colors = [
                                    'Chrome' => '#4285f4',
                                    'Firefox' => '#ff7139',
                                    'Safari' => '#006cff',
                                    'Edge' => '#0078d7',
                                    'Other' => '#6b7280',
                                ];
                            @endphp
                            <div class="browser-item">
                                <div class="browser-info">
                                    <i class="fab fa-{{ strtolower($browser) }}"
                                        style="color: {{ $colors[$browser] ?? '#6b7280' }}"></i>
                                    <span>{{ $browser }}</span>
                                </div>
                                <div class="browser-stat">
                                    <span class="browser-count">{{ number_format($count) }}</span>
                                    <span class="browser-percent">{{ number_format($percentage, 1) }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-body {
            padding: 20px;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        /* Period Selector */
        .period-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .period-selector label {
            font-weight: 600;
            color: var(--dark);
        }

        .period-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .period-btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: 2px solid var(--border);
            background: white;
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .period-btn:hover {
            border-color: var(--primary);
            background: var(--light);
        }

        .period-btn.active {
            border-color: var(--primary);
            background: var(--primary);
            color: white;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6b7280;
            margin-top: 4px;
        }

        /* Analytics Grid */
        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 20px;
        }

        /* Popular Pages */
        .popular-pages-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .popular-page-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: var(--light);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .popular-page-item:hover {
            background: #e5e7eb;
        }

        .page-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .page-info i {
            color: var(--primary);
        }

        .page-name {
            font-weight: 500;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .page-stats {
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 150px;
        }

        .visit-count {
            font-weight: 600;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .visit-bar {
            height: 6px;
            background: var(--primary);
            border-radius: 3px;
            flex: 1;
            min-width: 50px;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
        }

        /* Peak Hours */
        .peak-hours-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .peak-hour-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: var(--light);
            border-radius: 8px;
        }

        .hour-badge {
            background: var(--primary);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .hour-count {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--dark);
            font-weight: 600;
        }

        .hour-count i {
            color: var(--primary);
        }

        /* Device Stats */
        .device-stats {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .device-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .device-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            color: var(--dark);
        }

        .device-info i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .device-stat {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }

        .device-count {
            font-weight: 600;
            color: var(--dark);
        }

        .device-percent {
            color: #6b7280;
        }

        .device-bar {
            height: 8px;
            background: var(--light);
            border-radius: 4px;
            overflow: hidden;
        }

        .device-bar-fill {
            height: 100%;
            background: var(--primary);
            transition: width 0.5s ease;
        }

        /* Browser Stats */
        .browser-stats {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .browser-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: var(--light);
            border-radius: 8px;
        }

        .browser-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .browser-info i {
            font-size: 1.2rem;
        }

        .browser-stat {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .browser-count {
            font-weight: 600;
            color: var(--dark);
        }

        .browser-percent {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .text-muted {
            color: #6b7280;
        }

        .text-center {
            text-align: center;
        }

        @media (max-width: 1024px) {
            .analytics-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Hourly Activity Chart
        const hourlyData = @json($stats['hourly_activity']);
        const hourlyLabels = Array.from({
            length: 24
        }, (_, i) => i.toString().padStart(2, '0') + ':00');
        const hourlyValues = hourlyLabels.map((_, i) => hourlyData[i] || 0);

        const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');
        new Chart(hourlyCtx, {
            type: 'bar',
            data: {
                labels: hourlyLabels,
                datasets: [{
                    label: 'Aktivitas',
                    data: hourlyValues,
                    backgroundColor: 'rgba(0, 83, 197, 0.8)',
                    borderColor: 'rgba(0, 83, 197, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Daily Activity Chart
        @if (in_array($period, ['week', 'month', 'year']))
            const dailyData = @json($stats['daily_activity']);
            const dailyLabels = Object.keys(dailyData);
            const dailyValues = Object.values(dailyData);

            const dailyCtx = document.getElementById('dailyChart').getContext('2d');
            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: dailyLabels,
                    datasets: [{
                        label: 'Aktivitas',
                        data: dailyValues,
                        backgroundColor: 'rgba(0, 83, 197, 0.1)',
                        borderColor: 'rgba(0, 83, 197, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        @endif
    </script>
@endpush
