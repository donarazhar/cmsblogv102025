@extends('admin.layouts.app')

@section('title', 'Tags')

@section('content')
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .card-header {
            padding: 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark);
        }

        .filter-bar {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            padding: 20px 25px;
            background: var(--light);
            border-bottom: 1px solid var(--border);
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .filter-input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .btn-icon {
            width: 35px;
            height: 35px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: var(--light);
        }

        .table th {
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
            border-bottom: 2px solid var(--border);
        }

        .table td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            color: #4b5563;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: var(--light);
        }

        .tag-preview {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
        }

        .tag-color-box {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
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

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding: 25px;
            border-top: 1px solid var(--border);
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border-radius: 8px;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background: var(--primary);
            color: white;
        }

        .pagination .active {
            background: var(--primary);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .empty-text {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .checkbox-cell {
            width: 50px;
        }

        .bulk-actions {
            display: none;
            padding: 15px 25px;
            background: #fef3c7;
            border-bottom: 1px solid #fbbf24;
            align-items: center;
            gap: 15px;
        }

        .bulk-actions.active {
            display: flex;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filter-bar {
                flex-direction: column;
            }

            .card-header {
                flex-direction: column;
                align-items: stretch;
            }

            .action-buttons {
                flex-direction: column;
            }

            .table {
                font-size: 0.85rem;
            }

            .table th,
            .table td {
                padding: 10px;
            }
        }
    </style>

    <div class="page-header">
        <h1 class="page-title">Tags Management</h1>
        <p class="page-subtitle">Kelola dan organisasi tags untuk konten Anda</p>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #dbeafe; color: #1e40af;">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-label">Total Tags</div>
            <div class="stat-value">{{ $tags->total() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #d1fae5; color: #065f46;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-label">Active Tags</div>
            <div class="stat-value">{{ App\Models\Tag::where('is_active', true)->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7; color: #92400e;">
                <i class="fas fa-fire"></i>
            </div>
            <div class="stat-label">Popular Tags</div>
            <div class="stat-value">{{ App\Models\Tag::popular(5)->count() }}</div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Semua Tags</h2>
            <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Tambah Tag</span>
            </a>
        </div>

        <!-- Filter Bar -->
        <form method="GET" action="{{ route('admin.tags.index') }}" class="filter-bar">
            <div class="filter-group">
                <label class="filter-label">Cari Tag</label>
                <input type="text" name="search" class="filter-input" placeholder="Nama atau deskripsi..."
                    value="{{ request('search') }}">
            </div>
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select name="status" class="filter-input">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Urutkan</label>
                <select name="sort" class="filter-input">
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
                    <option value="posts_count" {{ request('sort') == 'posts_count' ? 'selected' : '' }}>Jumlah Post
                    </option>
                </select>
            </div>
            <div class="filter-group" style="display: flex; align-items: flex-end; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="fas fa-search"></i>
                    Filter
                </button>
                <a href="{{ route('admin.tags.index') }}" class="btn" style="background: #e5e7eb; color: var(--dark);">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>

        <!-- Bulk Actions -->
        <form method="POST" action="{{ route('admin.tags.bulk-delete') }}" id="bulkDeleteForm" class="bulk-actions"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus tag yang dipilih?')">
            @csrf
            @method('DELETE')
            <span style="font-weight: 600;">
                <span id="selectedCount">0</span> tag dipilih
            </span>
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i>
                Hapus Terpilih
            </button>
        </form>

        <!-- Table -->
        <div class="table-container">
            @if ($tags->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th class="checkbox-cell">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>Tag</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Posts</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $tag)
                            <tr>
                                <td class="checkbox-cell">
                                    <input type="checkbox" class="tag-checkbox" name="ids[]" value="{{ $tag->id }}"
                                        form="bulkDeleteForm">
                                </td>
                                <td>
                                    <div class="tag-preview" style="background: {{ $tag->color }};">
                                        <div class="tag-color-box" style="background: {{ $tag->color }};"></div>
                                        <span>{{ $tag->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <code
                                        style="background: var(--light); padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">
                                        {{ $tag->slug }}
                                    </code>
                                </td>
                                <td>
                                    <span style="color: #6b7280;">
                                        {{ Str::limit($tag->description ?? 'Tidak ada deskripsi', 50) }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $tag->posts_count }}</strong> post
                                </td>
                                <td>
                                    @if ($tag->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $tag->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="action-buttons" style="justify-content: flex-end;">
                                        <a href="{{ route('admin.tags.show', $tag) }}"
                                            class="btn btn-secondary btn-sm btn-icon" title="Detail"
                                            style="background: var(--info); color: white;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tags.edit', $tag) }}"
                                            class="btn btn-primary btn-sm btn-icon" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}"
                                            style="display: inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus tag ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h3 class="empty-title">Belum Ada Tag</h3>
                    <p class="empty-text">Mulai dengan membuat tag pertama Anda untuk mengorganisasi konten.</p>
                    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Buat Tag Pertama
                    </a>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if ($tags->hasPages())
            <!-- Pagination -->
            <div style="margin-top: 50px; text-align:center; padding: 10px; border-radius: 5px;">
                {{ $tags->links('vendor.pagination.simple') }}
            </div>
        @endif
    </div>

    <script>
        // Select All Checkbox
        document.getElementById('selectAll')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.tag-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            updateBulkActions();
        });

        // Individual Checkboxes
        document.querySelectorAll('.tag-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.tag-checkbox:checked');
            const bulkActions = document.querySelector('.bulk-actions');
            const selectedCount = document.getElementById('selectedCount');

            selectedCount.textContent = checkboxes.length;

            if (checkboxes.length > 0) {
                bulkActions.classList.add('active');
            } else {
                bulkActions.classList.remove('active');
            }
        }
    </script>
@endsection
