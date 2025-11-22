@extends('admin.layouts.app')

@section('title', 'Manajemen Jadwal')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Manajemen Jadwal</h1>
        <p class="page-subtitle">Kelola jadwal sholat, kajian, dan kegiatan masjid</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Jadwal</span>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Filter & Pencarian</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.schedules.index') }}" method="GET">
                <div class="filter-grid">
                    <div class="filter-item">
                        <input type="text" name="search" class="form-control" placeholder="Cari jadwal..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="filter-item">
                        <select name="type" class="form-select">
                            <option value="">Semua Tipe</option>
                            <option value="prayer" {{ request('type') == 'prayer' ? 'selected' : '' }}>Sholat</option>
                            <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Acara</option>
                            <option value="lecture" {{ request('type') == 'lecture' ? 'selected' : '' }}>Kajian</option>
                            <option value="class" {{ request('type') == 'class' ? 'selected' : '' }}>Kelas</option>
                            <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
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
            <div class="card-header-flex">
                <h3 class="card-title">Daftar Jadwal</h3>
                <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Jadwal
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Judul</th>
                            <th width="10%">Tipe</th>
                            <th width="12%">Tanggal/Hari</th>
                            <th width="12%">Waktu</th>
                            <th width="15%">Lokasi</th>
                            <th width="10%">Status</th>
                            <th width="16%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                            <tr>
                                <td>{{ $schedules->firstItem() + $loop->index }}</td>
                                <td>
                                    <strong>{{ $schedule->title }}</strong>
                                    @if ($schedule->is_recurring)
                                        <span class="badge badge-info badge-sm">
                                            <i class="fas fa-repeat"></i> Berulang
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-type-{{ $schedule->type }}">
                                        {{ ucfirst($schedule->type) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($schedule->is_recurring)
                                        <i class="fas fa-calendar-week"></i> {{ ucfirst($schedule->day_of_week) }}
                                    @else
                                        <i class="fas fa-calendar"></i>
                                        {{ $schedule->date ? $schedule->date->format('d M Y') : '-' }}
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-clock"></i> {{ $schedule->formatted_time }}
                                </td>
                                <td>{{ $schedule->location ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('admin.schedules.toggle-active', $schedule) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit"
                                            class="badge badge-{{ $schedule->is_active ? 'success' : 'secondary' }}"
                                            style="border: none; cursor: pointer;">
                                            {{ $schedule->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.schedules.show', $schedule) }}"
                                            class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.schedules.edit', $schedule) }}"
                                            class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
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
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada jadwal</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($schedules->hasPages())
            <!-- Pagination -->
            <div style="margin-top: 50px; text-align:center; padding: 10px; border-radius: 5px;">
                {{ $schedules->links('vendor.pagination.simple') }}
            </div>
        @endif
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

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
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

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .btn-info {
            background: var(--info);
            color: white;
        }

        .btn-info:hover {
            background: #2563eb;
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-group {
            display: flex;
            gap: 5px;
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

        .w-100 {
            width: 100%;
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

        .badge {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-secondary {
            background: #e5e7eb;
            color: #6b7280;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-sm {
            padding: 3px 8px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .badge-type-prayer {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-type-event {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-type-lecture {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-type-class {
            background: #ede9fe;
            color: #5b21b6;
        }

        .badge-type-other {
            background: #e5e7eb;
            color: #374151;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #6b7280;
        }

        .py-5 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .fa-3x {
            font-size: 3rem;
        }

        /* Pagination */
        nav[role="navigation"] {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination {
            display: flex;
            gap: 5px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li span,
        .pagination li a {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .pagination li a:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination li.active span {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination li.disabled span {
            color: #9ca3af;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .filter-grid {
                grid-template-columns: 1fr;
            }

            .card-header-flex {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .btn-group {
                flex-wrap: wrap;
            }
        }
    </style>
@endpush
