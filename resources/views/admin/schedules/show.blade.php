@extends('admin.layouts.app')

@section('title', 'Detail Jadwal')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Detail Jadwal</h1>
        <p class="page-subtitle">Informasi lengkap jadwal</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.schedules.index') }}">Jadwal</a>
            <span>/</span>
            <span>Detail</span>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-main">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-flex">
                        <h3 class="card-title">Informasi Jadwal</h3>
                        <div class="btn-group">
                            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="detail-list">
                        <div class="detail-item">
                            <div class="detail-label">Judul</div>
                            <div class="detail-value">
                                <strong>{{ $schedule->title }}</strong>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Tipe</div>
                            <div class="detail-value">
                                <span class="badge badge-type-{{ $schedule->type }}">
                                    {{ ucfirst($schedule->type) }}
                                </span>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Deskripsi</div>
                            <div class="detail-value">
                                {{ $schedule->description ?? '-' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Jadwal</div>
                            <div class="detail-value">
                                @if ($schedule->is_recurring)
                                    <span class="badge badge-info">
                                        <i class="fas fa-repeat"></i> Berulang
                                    </span>
                                    <div style="margin-top: 8px;">
                                        <i class="fas fa-calendar-week"></i>
                                        <strong>{{ ucfirst($schedule->day_of_week) }}</strong>
                                    </div>
                                @else
                                    <i class="fas fa-calendar"></i>
                                    {{ $schedule->date ? $schedule->date->format('d F Y') : '-' }}
                                @endif
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Waktu</div>
                            <div class="detail-value">
                                <i class="fas fa-clock"></i> {{ $schedule->formatted_time }}
                            </div>
                        </div>

                        @if ($schedule->location)
                            <div class="detail-item">
                                <div class="detail-label">Lokasi</div>
                                <div class="detail-value">
                                    <i class="fas fa-map-marker-alt"></i> {{ $schedule->location }}
                                </div>
                            </div>
                        @endif

                        @if ($schedule->imam)
                            <div class="detail-item">
                                <div class="detail-label">Imam</div>
                                <div class="detail-value">
                                    <i class="fas fa-user"></i> {{ $schedule->imam }}
                                </div>
                            </div>
                        @endif

                        @if ($schedule->speaker)
                            <div class="detail-item">
                                <div class="detail-label">Pemateri/Pembicara</div>
                                <div class="detail-value">
                                    <i class="fas fa-chalkboard-teacher"></i> {{ $schedule->speaker }}
                                </div>
                            </div>
                        @endif

                        <div class="detail-item">
                            <div class="detail-label">Warna Label</div>
                            <div class="detail-value">
                                <div class="color-preview" style="background: {{ $schedule->color ?? '#0053C5' }}"></div>
                                <span style="margin-left: 10px;">{{ $schedule->color ?? '#0053C5' }}</span>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                <form action="{{ route('admin.schedules.toggle-active', $schedule) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit"
                                        class="badge badge-{{ $schedule->is_active ? 'success' : 'secondary' }}"
                                        style="border: none; cursor: pointer;">
                                        {{ $schedule->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-sidebar">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Tambahan</h3>
                </div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-item">
                            <i class="fas fa-calendar-plus" style="color: var(--primary);"></i>
                            <div>
                                <div class="info-label">Dibuat</div>
                                <div class="info-value">{{ $schedule->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="fas fa-calendar-check" style="color: var(--success);"></i>
                            <div>
                                <div class="info-label">Terakhir Diupdate</div>
                                <div class="info-value">{{ $schedule->updated_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>

                        @if ($schedule->deleted_at)
                            <div class="info-item">
                                <i class="fas fa-calendar-times" style="color: var(--danger);"></i>
                                <div>
                                    <div class="info-label">Dihapus</div>
                                    <div class="info-value">{{ $schedule->deleted_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: 20px;">
                <div class="card-header">
                    <h3 class="card-title">Aksi Cepat</h3>
                </div>
                <div class="card-body">
                    <div class="action-buttons">
                        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                        <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-primary btn-block">
                            <i class="fas fa-edit"></i> Edit Jadwal
                        </a>
                        <form action="{{ route('admin.schedules.toggle-active', $schedule) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-{{ $schedule->is_active ? 'warning' : 'success' }} btn-block">
                                <i class="fas fa-power-off"></i>
                                {{ $schedule->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-trash"></i> Hapus Jadwal
                            </button>
                        </form>
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

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 20px;
        }

        .detail-list {
            display: flex;
            flex-direction: column;
        }

        .detail-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid var(--border);
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            flex: 0 0 180px;
            font-weight: 600;
            color: var(--dark);
        }

        .detail-value {
            flex: 1;
            color: #4b5563;
        }

        .color-preview {
            display: inline-block;
            width: 40px;
            height: 25px;
            border-radius: 6px;
            border: 2px solid var(--border);
            vertical-align: middle;
        }

        .info-list {
            display: flex;
            flex-direction: column;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid var(--border);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item i {
            font-size: 1.5rem;
            width: 30px;
            text-align: center;
        }

        .info-label {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 3px;
        }

        .info-value {
            font-weight: 600;
            color: var(--dark);
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
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
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .btn-block {
            width: 100%;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
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

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
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

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-info {
            background: var(--info);
            color: white;
        }

        .btn-info:hover {
            background: #2563eb;
        }

        .btn-group {
            display: flex;
            gap: 5px;
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

        @media (max-width: 992px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .detail-item {
                flex-direction: column;
                gap: 8px;
            }

            .detail-label {
                flex: none;
            }
        }
    </style>
@endpush
