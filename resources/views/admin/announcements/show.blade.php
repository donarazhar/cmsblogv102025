@extends('admin.layouts.app')

@section('title', 'Detail Pengumuman')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Detail Pengumuman</h1>
        <p class="page-subtitle">Informasi lengkap pengumuman</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.announcements.index') }}">Pengumuman</a>
            <span>/</span>
            <span>Detail</span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-bar mb-4">
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div class="action-right">
            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" style="display: inline;"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="detail-grid">
        <!-- Main Info Card -->
        <div class="card detail-main">
            <div class="card-header">
                <h3 class="card-title">Informasi Pengumuman</h3>
                <form action="{{ route('admin.announcements.toggle-active', $announcement) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    <button type="submit"
                        class="badge badge-{{ $announcement->is_currently_active ? 'success' : 'secondary' }} badge-clickable">
                        <i class="fas fa-{{ $announcement->is_currently_active ? 'check-circle' : 'times-circle' }}"></i>
                        {{ $announcement->is_currently_active ? 'Aktif' : 'Nonaktif' }}
                    </button>
                </form>
            </div>
            <div class="card-body">
                <!-- Title & Icon -->
                <div class="announcement-header">
                    @if ($announcement->icon)
                        <div class="announcement-icon" style="background: {{ $announcement->type_color }}15;">
                            <i class="{{ $announcement->icon }}" style="color: {{ $announcement->type_color }};"></i>
                        </div>
                    @endif
                    <div>
                        <h2 class="announcement-title-main">{{ $announcement->title }}</h2>
                        <div class="announcement-meta">
                            <span class="badge badge-type-{{ $announcement->type }}">
                                {{ ucfirst($announcement->type) }}
                            </span>
                            <span class="badge badge-priority-{{ $announcement->priority }}">
                                <i class="fas fa-flag"></i>
                                {{ ucfirst($announcement->priority) }} Priority
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="announcement-content">
                    <h4 class="section-title">Konten Pengumuman</h4>
                    <div class="content-box">
                        {!! nl2br(e($announcement->content)) !!}
                    </div>
                </div>

                <!-- Link -->
                @if ($announcement->link)
                    <div class="announcement-link">
                        <h4 class="section-title">Link Terkait</h4>
                        <a href="{{ $announcement->link }}" target="_blank" class="link-box">
                            <i class="fas fa-external-link-alt"></i>
                            <span>{{ $announcement->link_text ?? 'Buka Link' }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="detail-sidebar">
            <!-- Period Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt"></i>
                        Periode Tampil
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">Mulai</div>
                        <div class="info-value">
                            @if ($announcement->start_date)
                                <i class="fas fa-calendar-check text-success"></i>
                                {{ $announcement->start_date->format('d M Y, H:i') }}
                            @else
                                <span class="text-muted">Tidak dibatasi</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Berakhir</div>
                        <div class="info-value">
                            @if ($announcement->end_date)
                                <i class="fas fa-calendar-times text-danger"></i>
                                {{ $announcement->end_date->format('d M Y, H:i') }}
                            @else
                                <span class="text-muted">Tidak dibatasi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Display Settings Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye"></i>
                        Pengaturan Tampilan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="setting-item">
                        <div class="setting-label">
                            <i class="fas fa-home"></i>
                            Homepage
                        </div>
                        <div class="setting-toggle">
                            @if ($announcement->show_on_homepage)
                                <span class="badge badge-success"><i class="fas fa-check"></i> Ya</span>
                            @else
                                <span class="badge badge-secondary"><i class="fas fa-times"></i> Tidak</span>
                            @endif
                        </div>
                    </div>
                    <div class="setting-item">
                        <div class="setting-label">
                            <i class="fas fa-window-maximize"></i>
                            Popup
                        </div>
                        <div class="setting-toggle">
                            @if ($announcement->show_popup)
                                <span class="badge badge-success"><i class="fas fa-check"></i> Ya</span>
                            @else
                                <span class="badge badge-secondary"><i class="fas fa-times"></i> Tidak</span>
                            @endif
                        </div>
                    </div>
                    <div class="setting-item">
                        <div class="setting-label">
                            <i class="fas fa-sort-numeric-down"></i>
                            Urutan
                        </div>
                        <div class="setting-toggle">
                            <span class="badge badge-info">{{ $announcement->order }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Creator Info Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Informasi Lainnya
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">Dibuat oleh</div>
                        <div class="info-value">
                            <i class="fas fa-user"></i>
                            {{ $announcement->creator->name ?? 'System' }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Tanggal dibuat</div>
                        <div class="info-value">
                            <i class="fas fa-clock"></i>
                            {{ $announcement->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Terakhir diubah</div>
                        <div class="info-value">
                            <i class="fas fa-history"></i>
                            {{ $announcement->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .action-right {
            display: flex;
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
            gap: 8px;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 20px;
        }

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
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .announcement-header {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border);
        }

        .announcement-icon {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            flex-shrink: 0;
        }

        .announcement-title-main {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 12px;
        }

        .announcement-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .announcement-content {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: var(--primary);
            border-radius: 2px;
        }

        .content-box {
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px;
            line-height: 1.8;
            color: #374151;
            font-size: 0.95rem;
        }

        .announcement-link {
            margin-top: 25px;
        }

        .link-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .link-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 83, 197, 0.3);
        }

        .link-box i {
            font-size: 1.2rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 500;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .info-value {
            font-weight: 500;
            color: var(--dark);
            text-align: right;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .setting-item:last-child {
            border-bottom: none;
        }

        .setting-label {
            font-weight: 500;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
        }

        .setting-label i {
            width: 20px;
            text-align: center;
            color: #6b7280;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-clickable {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .badge-clickable:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
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

        .badge-type-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-type-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-type-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-type-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-priority-urgent {
            background: #fee2e2;
            color: #991b1b;
            font-weight: 600;
        }

        .badge-priority-high {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-priority-medium {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-priority-low {
            background: #e5e7eb;
            color: #374151;
        }

        .text-muted {
            color: #9ca3af;
        }

        .text-success {
            color: #10b981;
        }

        .text-danger {
            color: #ef4444;
        }

        @media (max-width: 1024px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .detail-sidebar {
                order: 2;
            }
        }

        @media (max-width: 768px) {
            .action-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .action-right {
                width: 100%;
            }

            .btn {
                flex: 1;
                justify-content: center;
            }

            .announcement-header {
                flex-direction: column;
            }

            .announcement-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .announcement-title-main {
                font-size: 1.4rem;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }

            .info-value {
                text-align: left;
            }
        }
    </style>
@endpush