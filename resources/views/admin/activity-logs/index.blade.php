@extends('admin.layouts.app')

@section('title', 'Activity Logs')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Activity Logs</h1>
        <p class="page-subtitle">Monitor dan tracking aktivitas user</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Activity Logs</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: #dbeafe;">
                <i class="fas fa-chart-line" style="color: #1e40af;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ number_format($stats['total']) }}</div>
                <div class="stat-label">Total Activities</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #d1fae5;">
                <i class="fas fa-calendar-day" style="color: #065f46;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ number_format($stats['today']) }}</div>
                <div class="stat-label">Hari Ini</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7;">
                <i class="fas fa-calendar-week" style="color: #92400e;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ number_format($stats['this_week']) }}</div>
                <div class="stat-label">Minggu Ini</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fee2e2;">
                <i class="fas fa-users" style="color: #991b1b;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ number_format($stats['unique_visitors']) }}</div>
                <div class="stat-label">Unique Visitors</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="quick-actions-bar">
                <div class="quick-actions-left">
                    <a href="{{ route('admin.activity-logs.analytics') }}" class="btn btn-primary">
                        <i class="fas fa-chart-bar"></i> View Analytics
                    </a>
                </div>
                <div class="quick-actions-right">
                    <button type="button" class="btn btn-warning" onclick="showClearModal()">
                        <i class="fas fa-broom"></i> Clear Logs
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Card - UPDATED -->
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Filter & Pencarian</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.activity-logs.index') }}" method="GET">
                <div class="filter-grid">
                    <div class="filter-item">
                        <input type="text" name="search" class="form-control" placeholder="Cari IP, URL, Route..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="filter-item">
                        <select name="page_type" class="form-select">
                            <option value="">Semua Tipe Halaman</option>
                            <option value="home" {{ request('page_type') == 'home' ? 'selected' : '' }}>Home</option>
                            <option value="blog" {{ request('page_type') == 'blog' ? 'selected' : '' }}>Blog</option>
                            <option value="programs" {{ request('page_type') == 'programs' ? 'selected' : '' }}>Programs
                            </option>
                            <option value="donations" {{ request('page_type') == 'donations' ? 'selected' : '' }}>Donations
                            </option>
                            <option value="gallery" {{ request('page_type') == 'gallery' ? 'selected' : '' }}>Gallery
                            </option>
                            <option value="schedules" {{ request('page_type') == 'schedules' ? 'selected' : '' }}>Schedules
                            </option>
                            <option value="about" {{ request('page_type') == 'about' ? 'selected' : '' }}>About/Staff
                            </option>
                            <option value="contact" {{ request('page_type') == 'contact' ? 'selected' : '' }}>Contact
                            </option>
                            <option value="other" {{ request('page_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <input type="date" name="date_from" class="form-control" placeholder="Dari Tanggal"
                            value="{{ request('date_from') }}">
                    </div>
                    <div class="filter-item">
                        <input type="date" name="date_to" class="form-control" placeholder="Sampai Tanggal"
                            value="{{ request('date_to') }}">
                    </div>
                    <div class="filter-item">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Aktivitas</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="15%">User</th>
                            <th width="15%">Route</th>
                            <th width="10%">Method</th>
                            <th width="15%">IP Address</th>
                            <th width="15%">Browser</th>
                            <th width="15%">Waktu</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                            <tr>
                                <td>{{ $activity->id }}</td>
                                <td>
                                    @if ($activity->causer)
                                        <div class="user-info">
                                            <div class="user-avatar-sm">
                                                {{ strtoupper(substr($activity->causer->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <strong>{{ $activity->causer->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $activity->causer->email }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">System</span>
                                    @endif
                                </td>
                                <td>
                                    <code class="route-code">
                                        {{ $activity->properties['route'] ?? 'N/A' }}
                                    </code>
                                </td>
                                <td>
                                    <span
                                        class="badge badge-method-{{ strtolower($activity->properties['method'] ?? 'get') }}">
                                        {{ $activity->properties['method'] ?? 'GET' }}
                                    </span>
                                </td>
                                <td>
                                    <code>{{ $activity->properties['ip'] ?? 'N/A' }}</code>
                                </td>
                                <td>
                                    <div class="browser-info">
                                        @php
                                            $userAgent = $activity->properties['user_agent'] ?? '';
                                            if (preg_match('/Chrome/i', $userAgent)) {
                                                $browser = 'Chrome';
                                                $icon = 'fa-chrome';
                                                $color = '#4285f4';
                                            } elseif (preg_match('/Firefox/i', $userAgent)) {
                                                $browser = 'Firefox';
                                                $icon = 'fa-firefox';
                                                $color = '#ff7139';
                                            } elseif (preg_match('/Safari/i', $userAgent)) {
                                                $browser = 'Safari';
                                                $icon = 'fa-safari';
                                                $color = '#006cff';
                                            } elseif (preg_match('/Edge/i', $userAgent)) {
                                                $browser = 'Edge';
                                                $icon = 'fa-edge';
                                                $color = '#0078d7';
                                            } else {
                                                $browser = 'Other';
                                                $icon = 'fa-globe';
                                                $color = '#6b7280';
                                            }
                                        @endphp
                                        <i class="fab {{ $icon }}" style="color: {{ $color }};"></i>
                                        <span>{{ $browser }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="time-info">
                                        {{ $activity->created_at->format('d M Y') }}
                                        <br>
                                        <small class="text-muted">{{ $activity->created_at->format('H:i:s') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-info"
                                            onclick="showDetails({{ $activity->id }})" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <form action="{{ route('admin.activity-logs.destroy', $activity) }}"
                                            method="POST" style="display: inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus log ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada aktivitas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($activities->hasPages())
            <div class="card-footer">
                {{ $activities->links() }}
            </div>
        @endif
    </div>

    <!-- Clear Modal -->
    <div class="modal" id="clearModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Clear Activity Logs</h3>
                <button type="button" class="btn-close" onclick="hideClearModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.activity-logs.clear') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Pilih periode log yang akan dihapus:</p>
                    <div class="form-group">
                        <label>
                            <input type="radio" name="period" value="week" required>
                            Hapus log lebih dari 1 minggu
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="radio" name="period" value="month" required>
                            Hapus log lebih dari 1 bulan
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="radio" name="period" value="all" required>
                            Hapus semua log
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="hideClearModal()">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal" id="detailModal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h3>Detail Aktivitas</h3>
                <button type="button" class="btn-close" onclick="hideDetailModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Reuse existing styles */
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
        }

        .card-body {
            padding: 20px;
        }

        .card-footer {
            padding: 15px 20px;
            border-top: 1px solid var(--border);
            background: var(--light);
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

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

        .quick-actions-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr auto;
            gap: 1rem;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 83, 197, 0.3);
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-info {
            background: var(--info);
            color: white;
        }

        .btn-info:hover {
            background: #2563eb;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .w-100 {
            width: 100%;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            background: var(--light);
            color: var(--dark);
            font-weight: 600;
            padding: 12px;
            border-bottom: 2px solid var(--border);
            font-size: 0.9rem;
            text-align: left;
        }

        .table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border);
        }

        .table tbody tr:hover {
            background: var(--light);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar-sm {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .route-code {
            background: var(--light);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            color: var(--primary);
            font-family: 'Courier New', monospace;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-method-get {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-method-post {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-method-put,
        .badge-method-patch {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-method-delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .browser-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .time-info {
            font-size: 0.9rem;
        }

        .text-muted {
            color: #6b7280;
        }

        .text-center {
            text-align: center;
        }

        .py-5 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .fa-3x {
            font-size: 3rem;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 1.3rem;
        }

        .modal-large {
            max-width: 900px;
            /* Ubah dari 800px menjadi 900px */
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-close:hover {
            color: var(--danger);
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-group label:hover {
            background: var(--light);
            border-color: var(--primary);
        }

        .form-group input[type="radio"] {
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .filter-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions-bar {
                flex-direction: column;
                gap: 10px;
            }

            .modal-content {
                width: 95%;
            }

            /* Detail Styles */
            .loading-spinner {
                text-align: center;
                padding: 40px;
                color: #6b7280;
            }

            .loading-spinner i {
                color: var(--primary);
                margin-bottom: 15px;
            }

            .error-message {
                text-align: center;
                padding: 40px;
                color: var(--danger);
            }

            .error-message i {
                font-size: 3rem;
                margin-bottom: 15px;
            }

            .detail-section {
                margin-bottom: 25px;
            }

            .detail-section:last-child {
                margin-bottom: 0;
            }

            .detail-section-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: var(--dark);
                margin-bottom: 15px;
                padding-bottom: 10px;
                border-bottom: 2px solid var(--border);
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .detail-section-title i {
                color: var(--primary);
            }

            .detail-table {
                width: 100%;
                border-collapse: collapse;
            }

            .detail-table tr {
                border-bottom: 1px solid var(--border);
            }

            .detail-table tr:last-child {
                border-bottom: none;
            }

            .detail-label {
                padding: 12px;
                font-weight: 600;
                color: #6b7280;
                width: 180px;
                vertical-align: top;
            }

            .detail-value {
                padding: 12px;
                color: var(--dark);
            }

            .detail-value a {
                color: var(--primary);
                text-decoration: none;
            }

            .detail-value a:hover {
                text-decoration: underline;
            }

            .user-agent-box {
                background: var(--light);
                padding: 15px;
                border-radius: 8px;
                border: 1px solid var(--border);
                font-family: 'Courier New', monospace;
                font-size: 0.85rem;
                color: #374151;
                word-break: break-all;
                line-height: 1.6;
            }

            .route-code {
                background: var(--light);
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 0.85rem;
                color: var(--primary);
                font-family: 'Courier New', monospace;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function showClearModal() {
            document.getElementById('clearModal').classList.add('show');
        }

        function hideClearModal() {
            document.getElementById('clearModal').classList.remove('show');
        }

        function showDetails(activityId) {
            document.getElementById('detailModal').classList.add('show');
            document.getElementById('detailContent').innerHTML = `
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin fa-3x"></i>
                    <p>Loading data...</p>
                </div>
            `;

            // Fetch activity details via AJAX
            fetch(`/admin/activity-logs/${activityId}/show`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayActivityDetails(data.data);
                    } else {
                        showError('Failed to load activity details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('An error occurred while loading data');
                });
        }

        function displayActivityDetails(activity) {
            const properties = activity.properties || {};

            let html = `
                <div class="detail-section">
                    <h4 class="detail-section-title">
                        <i class="fas fa-info-circle"></i> Informasi Dasar
                    </h4>
                    <table class="detail-table">
                        <tr>
                            <td class="detail-label">ID Aktivitas</td>
                            <td class="detail-value">#${activity.id}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Deskripsi</td>
                            <td class="detail-value">${activity.description}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Log Name</td>
                            <td class="detail-value">
                                <span class="badge badge-info">${activity.log_name || 'N/A'}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="detail-label">Waktu</td>
                            <td class="detail-value">
                                ${activity.created_at}
                                <br>
                                <small class="text-muted">${activity.created_at_human}</small>
                            </td>
                        </tr>
                    </table>
                </div>
            `;

            if (activity.causer && activity.causer.id) {
                html += `
                    <div class="detail-section">
                        <h4 class="detail-section-title">
                            <i class="fas fa-user"></i> Informasi User
                        </h4>
                        <table class="detail-table">
                            <tr>
                                <td class="detail-label">User ID</td>
                                <td class="detail-value">#${activity.causer.id}</td>
                            </tr>
                            <tr>
                                <td class="detail-label">Nama</td>
                                <td class="detail-value">
                                    <strong>${activity.causer.name}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="detail-label">Email</td>
                                <td class="detail-value">
                                    <a href="mailto:${activity.causer.email}">${activity.causer.email}</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                `;
            }

            if (properties && Object.keys(properties).length > 0) {
                html += `
                    <div class="detail-section">
                        <h4 class="detail-section-title">
                            <i class="fas fa-cog"></i> Request Details
                        </h4>
                        <table class="detail-table">
                            ${properties.route ? `
                                            <tr>
                                                <td class="detail-label">Route</td>
                                                <td class="detail-value">
                                                    <code class="route-code">${properties.route}</code>
                                                </td>
                                            </tr>` : ''}
                            ${properties.method ? `
                                            <tr>
                                                <td class="detail-label">Method</td>
                                                <td class="detail-value">
                                                    <span class="badge badge-method-${properties.method.toLowerCase()}">${properties.method}</span>
                                                </td>
                                            </tr>` : ''}
                            ${properties.url ? `
                                            <tr>
                                                <td class="detail-label">URL</td>
                                                <td class="detail-value">
                                                    <small style="word-break: break-all;">${properties.url}</small>
                                                </td>
                                            </tr>` : ''}
                            ${properties.ip ? `
                                            <tr>
                                                <td class="detail-label">IP Address</td>
                                                <td class="detail-value">
                                                    <code>${properties.ip}</code>
                                                </td>
                                            </tr>` : ''}
                            ${properties.referer ? `
                                            <tr>
                                                <td class="detail-label">Referer</td>
                                                <td class="detail-value">
                                                    <small style="word-break: break-all;">${properties.referer || '-'}</small>
                                                </td>
                                            </tr>` : ''}
                            ${properties.session_id ? `
                                            <tr>
                                                <td class="detail-label">Session ID</td>
                                                <td class="detail-value">
                                                    <code>${properties.session_id}</code>
                                                </td>
                                            </tr>` : ''}
                        </table>
                    </div>
                `;

                if (properties.user_agent) {
                    html += `
                        <div class="detail-section">
                            <h4 class="detail-section-title">
                                <i class="fas fa-desktop"></i> Browser & Device Info
                            </h4>
                            <div class="user-agent-box">
                                ${properties.user_agent}
                            </div>
                        </div>
                    `;
                }
            }

            document.getElementById('detailContent').innerHTML = html;
        }

        function showError(message) {
            document.getElementById('detailContent').innerHTML = `
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>${message}</p>
                </div>
            `;
        }

        function hideDetailModal() {
            document.getElementById('detailModal').classList.remove('show');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const clearModal = document.getElementById('clearModal');
            const detailModal = document.getElementById('detailModal');

            if (event.target == clearModal) {
                hideClearModal();
            }
            if (event.target == detailModal) {
                hideDetailModal();
            }
        }
    </script>
@endpush
