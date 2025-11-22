@extends('admin.layouts.app')

@section('title', 'Detail Tag')

@section('content')
    <style>
        .breadcrumb {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            align-items: center;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: var(--primary-dark);
        }

        .breadcrumb span {
            color: #9ca3af;
        }

        .detail-header {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .detail-header-top {
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 20px;
            margin-bottom: 25px;
        }

        .tag-info {
            flex: 1;
        }

        .tag-preview-large {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
        }

        .tag-color-indicator {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .tag-description {
            color: #6b7280;
            font-size: 1rem;
            line-height: 1.6;
            margin-top: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 12px 24px;
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
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-secondary {
            background: #e5e7eb;
            color: var(--dark);
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid var(--border);
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .info-card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-card-icon {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .info-value {
            font-weight: 600;
            color: var(--dark);
            text-align: right;
        }

        .posts-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .posts-card-header {
            padding: 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .posts-card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
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

        .post-title {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .post-excerpt {
            font-size: 0.85rem;
            color: #6b7280;
        }

        .post-thumbnail {
            width: 80px;
            height: 50px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid var(--border);
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

        @media (max-width: 768px) {
            .detail-header-top {
                flex-direction: column;
            }

            .action-buttons {
                width: 100%;
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
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

    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <span>/</span>
        <a href="{{ route('admin.tags.index') }}">Tags</a>
        <span>/</span>
        <span style="color: var(--dark); font-weight: 600;">{{ $tag->name }}</span>
    </div>

    <!-- Detail Header -->
    <div class="detail-header">
        <div class="detail-header-top">
            <div class="tag-info">
                <div class="tag-preview-large" style="background: {{ $tag->color }};">
                    <div class="tag-color-indicator" style="background: {{ $tag->color }};"></div>
                    <span>{{ $tag->name }}</span>
                </div>

                @if ($tag->is_active)
                    <span class="badge badge-success">
                        <i class="fas fa-check-circle"></i> Active
                    </span>
                @else
                    <span class="badge badge-danger">
                        <i class="fas fa-times-circle"></i> Inactive
                    </span>
                @endif

                @if ($tag->description)
                    <p class="tag-description">{{ $tag->description }}</p>
                @else
                    <p class="tag-description" style="font-style: italic;">Tidak ada deskripsi</p>
                @endif
            </div>

            <div class="action-buttons">
                <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" style="display: inline;"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus tag ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        Hapus
                    </button>
                </form>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">{{ $tag->posts_count }}</div>
                <div class="stat-label">Total Posts</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $tag->posts()->where('status', 'published')->count() }}</div>
                <div class="stat-label">Published Posts</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $tag->posts()->where('status', 'draft')->count() }}</div>
                <div class="stat-label">Draft Posts</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $tag->created_at->diffForHumans() }}</div>
                <div class="stat-label">Dibuat</div>
            </div>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="info-grid">
        <!-- Tag Information -->
        <div class="info-card">
            <h3 class="info-card-title">
                <div class="info-card-icon" style="background: #dbeafe; color: #1e40af;">
                    <i class="fas fa-info-circle"></i>
                </div>
                Informasi Tag
            </h3>
            <div class="info-row">
                <span class="info-label">Nama</span>
                <span class="info-value">{{ $tag->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Slug</span>
                <span class="info-value">
                    <code
                        style="background: var(--light); padding: 4px 8px; border-radius: 4px;">{{ $tag->slug }}</code>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Warna</span>
                <span class="info-value">
                    <div style="display: flex; align-items: center; gap: 8px; justify-content: flex-end;">
                        <div
                            style="width: 24px; height: 24px; background: {{ $tag->color }}; border-radius: 4px; border: 2px solid var(--border);">
                        </div>
                        <code>{{ strtoupper($tag->color) }}</code>
                    </div>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="info-value">
                    @if ($tag->is_active)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </span>
            </div>
        </div>

        <!-- Timestamps -->
        <div class="info-card">
            <h3 class="info-card-title">
                <div class="info-card-icon" style="background: #fef3c7; color: #92400e;">
                    <i class="fas fa-clock"></i>
                </div>
                Waktu
            </h3>
            <div class="info-row">
                <span class="info-label">Dibuat</span>
                <span class="info-value">{{ $tag->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Diupdate</span>
                <span class="info-value">{{ $tag->updated_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Relatif</span>
                <span class="info-value">{{ $tag->updated_at->diffForHumans() }}</span>
            </div>
        </div>

        <!-- URL -->
        <div class="info-card">
            <h3 class="info-card-title">
                <div class="info-card-icon" style="background: #d1fae5; color: #065f46;">
                    <i class="fas fa-link"></i>
                </div>
                URL & Akses
            </h3>
            <div class="info-row">
                <span class="info-label">Frontend URL</span>
                <span class="info-value">
                    <a href="{{ $tag->url }}" target="_blank" style="color: var(--primary); text-decoration: none;">
                        Lihat <i class="fas fa-external-link-alt" style="font-size: 0.75rem;"></i>
                    </a>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">ID</span>
                <span class="info-value">#{{ $tag->id }}</span>
            </div>
        </div>
    </div>

    <!-- Posts Table -->
    <div class="posts-card">
        <div class="posts-card-header">
            <h2 class="posts-card-title">Posts dengan Tag Ini</h2>
            <span style="color: #6b7280; font-size: 0.9rem;">
                {{ $posts->total() }} post
            </span>
        </div>

        <div class="table-container">
            @if ($posts->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Thumbnail</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Penulis</th>
                            <th>Tanggal</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>
                                    @if ($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}"
                                            alt="{{ $post->title }}" class="post-thumbnail">
                                    @else
                                        <div class="post-thumbnail"
                                            style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); display: flex; align-items: center; justify-content: center; color: white;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="post-title">{{ Str::limit($post->title, 50) }}</div>
                                    <div class="post-excerpt">
                                        {{ Str::limit(strip_tags($post->excerpt ?? $post->content), 80) }}</div>
                                </td>
                                <td>
                                    @if ($post->category)
                                        <span
                                            style="background: var(--light); padding: 4px 10px; border-radius: 6px; font-size: 0.85rem;">
                                            {{ $post->category->name }}
                                        </span>
                                    @else
                                        <span style="color: #9ca3af; font-size: 0.85rem;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($post->status === 'published')
                                        <span class="badge badge-success">Published</span>
                                    @elseif($post->status === 'draft')
                                        <span class="badge" style="background: #fef3c7; color: #92400e;">Draft</span>
                                    @else
                                        <span class="badge badge-danger">{{ ucfirst($post->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div
                                            style="width: 30px; height: 30px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 600;">
                                            {{ strtoupper(substr($post->author->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <span style="font-size: 0.9rem;">{{ $post->author->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 0.9rem;">{{ $post->created_at->format('d M Y') }}</div>
                                    <div style="font-size: 0.8rem; color: #9ca3af;">{{ $post->created_at->format('H:i') }}
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-primary"
                                        style="padding: 6px 12px; font-size: 0.85rem;">
                                        <i class="fas fa-eye"></i>
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="empty-title">Belum Ada Post</h3>
                    <p class="empty-text">Tag ini belum digunakan pada post manapun.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if ($posts->hasPages())
            <div class="pagination">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

@endsection
