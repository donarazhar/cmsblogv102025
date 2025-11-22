@extends('admin.layouts.app')

@section('title', 'Manajemen Halaman')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Manajemen Halaman</h1>
        <p class="page-subtitle">Kelola halaman statis website masjid</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Halaman</span>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Filter & Pencarian</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pages.index') }}" method="GET">
                <div class="filter-grid">
                    <div class="filter-item">
                        <input type="text" name="search" class="form-control" placeholder="Cari halaman..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="filter-item">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published
                            </option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="private" {{ request('status') == 'private' ? 'selected' : '' }}>Private</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <select name="template" class="form-select">
                            <option value="">Semua Template</option>
                            <option value="default" {{ request('template') == 'default' ? 'selected' : '' }}>Default
                            </option>
                            <option value="full-width" {{ request('template') == 'full-width' ? 'selected' : '' }}>Full
                                Width
                            </option>
                            <option value="sidebar-left" {{ request('template') == 'sidebar-left' ? 'selected' : '' }}>
                                Sidebar Left</option>
                            <option value="sidebar-right" {{ request('template') == 'sidebar-right' ? 'selected' : '' }}>
                                Sidebar Right</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <select name="parent" class="form-select">
                            <option value="">Semua Parent</option>
                            <option value="none" {{ request('parent') == 'none' ? 'selected' : '' }}>Parent Only</option>
                            @foreach ($parentPages as $parent)
                                <option value="{{ $parent->id }}"
                                    {{ request('parent') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->title }}
                                </option>
                            @endforeach
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
                <h3 class="card-title">Daftar Halaman</h3>
                <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Halaman
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Judul</th>
                            <th width="15%">Slug</th>
                            <th width="12%">Template</th>
                            <th width="10%">Parent</th>
                            <th width="8%">Menu</th>
                            <th width="8%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                            <tr>
                                <td>{{ $pages->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="page-title-cell">
                                        @if ($page->icon)
                                            <i class="{{ $page->icon }}" style="color: var(--primary)"></i>
                                        @endif
                                        <div>
                                            <strong>{{ $page->title }}</strong>
                                            @if ($page->featured_image)
                                                <br>
                                                <span class="badge badge-sm badge-info">
                                                    <i class="fas fa-image"></i> Ada Gambar
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code class="slug-code">{{ $page->slug }}</code>
                                </td>
                                <td>
                                    <span class="badge badge-template">
                                        {{ ucfirst(str_replace('-', ' ', $page->template)) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($page->parent)
                                        <span class="text-muted small">
                                            <i class="fas fa-level-up-alt"></i>
                                            {{ $page->parent->title }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">Parent</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($page->show_in_menu)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> Ya
                                        </span>
                                        <br>
                                        <small class="text-muted">Order: {{ $page->menu_order }}</small>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-times"></i> Tidak
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-status-{{ $page->status }}">
                                        {{ ucfirst($page->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-sm btn-info"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?')">
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
                                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada halaman</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($pages->hasPages())
            <div class="card-footer">
                {{ $pages->links() }}
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

        .page-title-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-title-cell i {
            font-size: 1.2rem;
        }

        .slug-code {
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
            display: inline-block;
        }

        .badge-sm {
            padding: 3px 8px;
            font-size: 0.7rem;
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

        .badge-template {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .badge-status-published {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-status-draft {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-status-private {
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
