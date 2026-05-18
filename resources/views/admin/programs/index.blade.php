@extends('admin.layouts.app')

@section('title', 'Manajemen Layanan & Kegiatan')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Manajemen Layanan & Kegiatan</h1>
        <p class="page-subtitle">Kelola layanan dan kegiatan masjid</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Layanan</span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-flex">
                <h3 class="card-title">Daftar Layanan</h3>
                <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Layanan
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Nama Layanan</th>
                            <th width="12%">Tipe</th>
                            <th width="15%">Info Kegiatan</th>
                            <th width="10%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $program)
                            <tr>
                                <td>{{ $programs->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="program-title-cell">
                                        @if ($program->image)
                                            <img src="{{ asset('storage/' . $program->image) }}"
                                                alt="{{ $program->name }}" class="program-thumb">
                                        @else
                                            <div class="program-thumb-placeholder">
                                                <i class="{{ $program->icon ?? 'fas fa-calendar-check' }}"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ Str::limit($program->name, 50) }}</strong>
                                            <div class="program-badges">
                                                @if ($program->is_featured)
                                                    <span class="badge badge-sm badge-warning">
                                                        <i class="fas fa-star"></i> Featured
                                                    </span>
                                                @endif
                                                @if ($program->registration_fee === 0)
                                                    <span class="badge badge-sm badge-success">
                                                        Gratis
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-type-{{ $program->type }}">
                                        {{ ucfirst($program->type) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="info-cell">
                                        @if ($program->frequency)
                                            <div class="info-item">
                                                <i class="fas fa-redo text-muted"></i> {{ ucfirst($program->frequency) }}
                                            </div>
                                        @endif
                                        @if ($program->location)
                                            <div class="info-item">
                                                <i class="fas fa-map-marker-alt text-muted"></i> {{ Str::limit($program->location, 15) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-status-{{ $program->is_active ? 'active' : 'inactive' }}">
                                        {{ $program->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <!-- Toggle Status -->
                                        <form action="{{ route('admin.programs.toggle', $program) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-action {{ $program->is_active ? 'btn-success' : 'btn-secondary' }}" title="{{ $program->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $program->is_active ? 'eye' : 'eye-slash' }}"></i>
                                            </button>
                                        </form>

                                        <!-- Toggle Featured -->
                                        <form action="{{ route('admin.programs.toggle-featured', $program) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-action {{ $program->is_featured ? 'btn-warning' : 'btn-outline-warning' }}" title="{{ $program->is_featured ? 'Hapus dari Featured' : 'Jadikan Featured' }}">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        </form>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-sm btn-info btn-action" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-action" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada layanan kegiatan</p>
                                    <a href="{{ route('admin.programs.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus"></i> Tambah Layanan Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($programs->hasPages())
            <!-- Pagination -->
            <div style="margin-top: 20px; text-align:center; padding: 20px; border-top: 1px solid var(--border);">
                {{ $programs->links('vendor.pagination.simple') }}
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

        /* Buttons */
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

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 6px;
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

        .btn-outline-warning {
            background: transparent;
            color: var(--warning);
            border: 1px solid var(--warning);
        }

        .btn-outline-warning:hover {
            background: var(--warning);
            color: white;
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
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

        .btn-group {
            display: flex;
            gap: 5px;
        }

        /* Table */
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

        /* Program specific styles */
        .program-title-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .program-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid var(--border);
            flex-shrink: 0;
        }

        .program-thumb-placeholder {
            width: 50px;
            height: 50px;
            background: var(--light);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 1.2rem;
            border: 2px solid var(--border);
            flex-shrink: 0;
        }

        .program-badges {
            display: flex;
            gap: 5px;
            margin-top: 5px;
            flex-wrap: wrap;
        }

        /* Badges */
        .badge {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-sm {
            padding: 3px 8px;
            font-size: 0.7rem;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-type-regular {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-type-event {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-type-course {
            background: #e0e7ff;
            color: #4338ca;
        }

        .badge-type-charity {
            background: #fce7f3;
            color: #be185d;
        }

        .badge-status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .info-cell {
            font-size: 0.85rem;
            color: var(--dark);
        }

        .info-item {
            margin-bottom: 3px;
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

        .mt-2 {
            margin-top: 0.5rem;
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
            .card-header-flex {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .btn-group {
                flex-wrap: wrap;
            }

            .program-title-cell {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush
