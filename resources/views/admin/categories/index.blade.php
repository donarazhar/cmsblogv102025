@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Categories Management</h1>
                <p class="page-subtitle">Kelola semua kategori konten</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Category Baru
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.categories.index') }}" id="filterForm">
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                    <div class="form-group">
                        <label>Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Cari category..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="parent" class="form-control">
                            <option value="">Semua Tipe</option>
                            <option value="only" {{ request('parent') == 'only' ? 'selected' : '' }}>Parent Only</option>
                            <option value="child" {{ request('parent') == 'child' ? 'selected' : '' }}>Child Only</option>
                        </select>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="card">
        <div class="card-body">
            @if ($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="60">Image</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent</th>
                                <th>Posts</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-categories">
                            @foreach ($categories as $category)
                                <tr data-id="{{ $category->id }}">
                                    <td>
                                        @if ($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                alt="{{ $category->name }}"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        @elseif($category->icon)
                                            <div
                                                style="width: 50px; height: 50px; background: {{ $category->color }}; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                                <i class="{{ $category->icon }}" style="font-size: 1.5rem;"></i>
                                            </div>
                                        @else
                                            <div
                                                style="width: 50px; height: 50px; background: #e5e7eb; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-folder" style="color: #9ca3af;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; margin-bottom: 5px;">{{ $category->name }}</div>
                                        @if ($category->children->count() > 0)
                                            <span class="badge badge-info">
                                                <i class="fas fa-sitemap"></i> {{ $category->children->count() }} Sub
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <code style="font-size: 0.85rem; color: #6b7280;">{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                        @if ($category->parent)
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-level-up-alt"></i> {{ $category->parent->name }}
                                            </span>
                                        @else
                                            <span style="color: #9ca3af; font-size: 0.85rem;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">
                                            <i class="fas fa-file-alt"></i> {{ $category->posts_count }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-dark">{{ $category->order }}</span>
                                    </td>
                                    <td>
                                        @if ($category->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ route('admin.categories.show', $category) }}"
                                                class="btn-action btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                                class="btn-action btn-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.toggle-status', $category) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn-action btn-{{ $category->is_active ? 'warning' : 'success' }}"
                                                    title="{{ $category->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fas fa-{{ $category->is_active ? 'times' : 'check' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                                method="POST" style="display: inline;"
                                                onsubmit="return confirm('Yakin ingin menghapus category ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div style="margin-top: 50px; text-align:center; padding: 10px; border-radius: 5px;">
                    {{ $categories->links('vendor.pagination.simple') }}
                </div>
            @else
                <div class="text-center" style="padding: 40px;">
                    <i class="fas fa-folder-open" style="font-size: 3rem; color: #9ca3af; margin-bottom: 15px;"></i>
                    <h4>Tidak ada category ditemukan</h4>
                    <p style="color: #9ca3af;">Mulai dengan menambahkan category baru</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" style="margin-top: 15px;">
                        <i class="fas fa-plus"></i> Tambah Category Baru
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-body {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: var(--light);
        }

        .table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark);
            border-bottom: 2px solid var(--border);
        }

        .table td {
            padding: 15px;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }

        .table tbody tr:hover {
            background: var(--light);
        }

        .badge {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-secondary {
            background: #e5e7eb;
            color: #4b5563;
        }

        .badge-dark {
            background: #374151;
            color: white;
        }

        .badge-primary {
            background: #dbeafe;
            color: var(--primary);
        }

        .btn-action {
            width: 35px;
            height: 35px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-action.btn-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-action.btn-info:hover {
            background: #3b82f6;
            color: white;
        }

        .btn-action.btn-primary {
            background: #dbeafe;
            color: var(--primary);
        }

        .btn-action.btn-primary:hover {
            background: var(--primary);
            color: white;
        }

        .btn-action.btn-success {
            background: #d1fae5;
            color: #065f46;
        }

        .btn-action.btn-success:hover {
            background: var(--success);
            color: white;
        }

        .btn-action.btn-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-action.btn-warning:hover {
            background: var(--warning);
            color: white;
        }

        .btn-action.btn-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-action.btn-danger:hover {
            background: var(--danger);
            color: white;
        }

        .text-center {
            text-align: center;
        }

        code {
            background: var(--light);
            padding: 4px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
    </style>
@endpush
