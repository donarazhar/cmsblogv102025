@extends('admin.layouts.app')

@section('title', 'Gallery Albums')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h1 class="page-title">Gallery Albums</h1>
                <p class="page-subtitle">Kelola album foto & video kegiatan</p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('admin.gallery.photos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-images"></i>
                    Kelola Foto
                </a>
                <a href="{{ route('admin.gallery.albums.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Tambah Album
                </a>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Album</h3>
            <div class="card-tools">
                <span class="badge" style="background: var(--primary); color: white;">{{ $albums->total() }} Total</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Nama Album</th>
                            <th width="15%">Tanggal Event</th>
                            <th width="15%">Jumlah Foto</th>
                            <th width="10%">Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($albums as $album)
                            <tr>
                                <td>{{ $albums->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="album-title-cell">
                                        @if ($album->cover_image)
                                            <div class="album-thumb-container">
                                                <img src="{{ asset('storage/' . $album->cover_image) }}"
                                                    alt="{{ $album->name }}" class="album-thumb">
                                            </div>
                                        @else
                                            <div class="album-thumb-placeholder">
                                                <i class="fas fa-images"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ Str::limit($album->name, 50) }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="info-cell">
                                        @if ($album->event_date)
                                            <div class="info-item">
                                                <i class="fas fa-calendar text-muted"></i> {{ \Carbon\Carbon::parse($album->event_date)->format('d M Y') }}
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge" style="background: #e0e7ff; color: #4338ca; font-weight: 500;">
                                        <i class="fas fa-images"></i> {{ $album->galleries_count }} Foto
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-status-{{ $album->is_active ? 'active' : 'inactive' }}">
                                        {{ $album->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <!-- Lihat Foto -->
                                        <a href="{{ route('admin.gallery.photos.index', ['album' => $album->id]) }}"
                                            class="btn-action btn-view" title="Lihat Foto">
                                            <i class="fas fa-images"></i>
                                        </a>

                                        <!-- Toggle Status -->
                                        <form action="{{ route('admin.gallery.albums.toggle', $album) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-action {{ $album->is_active ? 'btn-success' : 'btn-secondary' }}" title="{{ $album->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $album->is_active ? 'eye' : 'eye-slash' }}"></i>
                                            </button>
                                        </form>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.gallery.albums.edit', $album) }}" class="btn btn-sm btn-info btn-action" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.gallery.albums.destroy', $album) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus album ini beserta semua foto di dalamnya?')">
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
                                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada album</p>
                                    <a href="{{ route('admin.gallery.albums.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus"></i> Tambah Album Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($albums->hasPages())
            <!-- Pagination -->
            <div style="margin-top: 20px; text-align:center; padding: 20px; border-top: 1px solid var(--border);">
                {{ $albums->links('vendor.pagination.simple') }}
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
            padding: 20px 25px;
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
        }

        .card-tools {
            display: flex;
            gap: 10px;
        }

        .card-body {
            padding: 20px;
        }

        /* Badge */
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

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-status-inactive {
            background: #fee2e2;
            color: #991b1b;
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

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
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
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-view {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-view:hover {
            background: #3b82f6;
            color: white;
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

        /* Album specific styles */
        .album-title-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .album-thumb-container {
            position: relative;
            width: 60px;
            height: 60px;
            flex-shrink: 0;
        }

        .album-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid var(--border);
        }

        .album-thumb-placeholder {
            width: 60px;
            height: 60px;
            background: var(--light);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 1.5rem;
            border: 2px solid var(--border);
            flex-shrink: 0;
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
            .album-title-cell {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush
