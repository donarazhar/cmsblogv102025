@extends('admin.layouts.app')

@section('title', 'Manajemen Posts')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Manajemen Posts</h1>
        <p class="page-subtitle">Kelola artikel, berita, dan konten masjid</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Posts</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: #dbeafe;">
                <i class="fas fa-file-alt" style="color: #1e40af;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ \App\Models\Post::count() }}</div>
                <div class="stat-label">Total Posts</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #d1fae5;">
                <i class="fas fa-check-circle" style="color: #065f46;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ \App\Models\Post::where('status', 'published')->count() }}</div>
                <div class="stat-label">Published</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7;">
                <i class="fas fa-clock" style="color: #92400e;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ \App\Models\Post::where('status', 'draft')->count() }}</div>
                <div class="stat-label">Draft</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fee2e2;">
                <i class="fas fa-star" style="color: #991b1b;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ \App\Models\Post::where('is_featured', true)->count() }}</div>
                <div class="stat-label">Featured</div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Filter & Pencarian</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.posts.index') }}" method="GET">
                <div class="filter-grid">
                    <div class="filter-item">
                        <input type="text" name="search" class="form-control" placeholder="Cari post..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="filter-item">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published
                            </option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled
                            </option>
                            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived
                            </option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <select name="post_type" class="form-select">
                            <option value="">Semua Tipe</option>
                            <option value="article" {{ request('post_type') == 'article' ? 'selected' : '' }}>Article
                            </option>
                            <option value="news" {{ request('post_type') == 'news' ? 'selected' : '' }}>News</option>
                            <option value="announcement" {{ request('post_type') == 'announcement' ? 'selected' : '' }}>
                                Announcement</option>
                            <option value="event" {{ request('post_type') == 'event' ? 'selected' : '' }}>Event</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-item">
                        <select name="featured" class="form-select">
                            <option value="">Semua Featured</option>
                            <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured Only
                            </option>
                            <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Non-Featured</option>
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
                <h3 class="card-title">Daftar Posts</h3>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Post
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Judul</th>
                            <th width="12%">Kategori</th>
                            <th width="10%">Tipe</th>
                            <th width="10%">Author</th>
                            <th width="8%">Views</th>
                            <th width="10%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ $posts->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="post-title-cell">
                                        @if ($post->featured_image)
                                            <img src="{{ Storage::url($post->featured_image) }}"
                                                alt="{{ $post->title }}" class="post-thumb">
                                        @else
                                            <div class="post-thumb-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ Str::limit($post->title, 50) }}</strong>
                                            <div class="post-badges">
                                                @if ($post->is_featured)
                                                    <span class="badge badge-sm badge-warning">
                                                        <i class="fas fa-star"></i> Featured
                                                    </span>
                                                @endif
                                                @if ($post->featured_video)
                                                    <span class="badge badge-sm badge-info">
                                                        <i class="fas fa-video"></i> Video
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="category-badge">
                                        {{ $post->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-type-{{ $post->post_type }}">
                                        {{ ucfirst($post->post_type) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="author-cell">
                                        <i class="fas fa-user-circle"></i>
                                        <span>{{ $post->author->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="views-cell">
                                        <i class="fas fa-eye"></i>
                                        {{ number_format($post->views_count) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-status-{{ $post->status }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                    @if ($post->published_at)
                                        <br>
                                        <small class="text-muted">
                                            {{ $post->published_at->format('d M Y') }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-info"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus post ini?')">
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
                                    <p class="text-muted">Belum ada post</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($posts->hasPages())
            <!-- Pagination -->
            <div style="margin-top: 50px; text-align:center; padding: 10px; border-radius: 5px;">
                {{ $posts->links('vendor.pagination.simple') }}
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        /* Reuse existing card styles from app.php */
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

        /* Filter Grid */
        .filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr auto;
            gap: 1rem;
        }

        /* Form Controls */
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

        .w-100 {
            width: 100%;
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

        /* Post specific styles */
        .post-title-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .post-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid var(--border);
            flex-shrink: 0;
        }

        .post-thumb-placeholder {
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

        .post-badges {
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

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .category-badge {
            background: #f3e8ff;
            color: #6b21a8;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
        }

        .badge-type-article {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-type-news {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-type-announcement {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-type-event {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-status-published {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-status-draft {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-status-scheduled {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-status-archived {
            background: #e5e7eb;
            color: #374151;
        }

        .author-cell,
        .views-cell {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
            color: #6b7280;
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

        /* Responsive */
        @media (max-width: 1200px) {
            .filter-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

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

            .post-title-cell {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush
