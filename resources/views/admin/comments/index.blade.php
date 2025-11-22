@extends('admin.layouts.app')

@section('title', 'Comments')

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
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
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

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .bulk-actions {
            display: none;
            padding: 15px 25px;
            background: #fef3c7;
            border-bottom: 1px solid #fbbf24;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .bulk-actions.active {
            display: flex;
        }

        .comment-list {
            padding: 0;
        }

        .comment-item {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
            transition: background 0.3s ease;
        }

        .comment-item:hover {
            background: var(--light);
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
            gap: 15px;
        }

        .comment-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .author-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .author-info h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 3px;
        }

        .author-meta {
            font-size: 0.8rem;
            color: #9ca3af;
        }

        .comment-content {
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 15px;
            padding-left: 57px;
        }

        .comment-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 57px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .comment-post {
            font-size: 0.85rem;
            color: #6b7280;
        }

        .comment-post a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .comment-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-spam {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-trash {
            background: #e5e7eb;
            color: #374151;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding: 25px;
            border-top: 1px solid var(--border);
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

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filter-bar {
                flex-direction: column;
            }

            .comment-header {
                flex-direction: column;
            }

            .comment-content {
                padding-left: 0;
            }

            .comment-footer {
                padding-left: 0;
                flex-direction: column;
                align-items: start;
            }
        }
    </style>

    <div class="page-header">
        <h1 class="page-title">Comments Management</h1>
        <p class="page-subtitle">Kelola dan moderasi komentar dari pengunjung</p>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #dbeafe; color: #1e40af;">
                <i class="fas fa-comments"></i>
            </div>
            <div class="stat-label">Total Comments</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7; color: #92400e;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-label">Pending</div>
            <div class="stat-value">{{ $stats['pending'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #d1fae5; color: #065f46;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-label">Approved</div>
            <div class="stat-value">{{ $stats['approved'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fee2e2; color: #991b1b;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-label">Spam</div>
            <div class="stat-value">{{ $stats['spam'] }}</div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Semua Comments</h2>
        </div>

        <!-- Filter Bar -->
        <form method="GET" action="{{ route('admin.comments.index') }}" class="filter-bar">
            <div class="filter-group">
                <label class="filter-label">Cari Comment</label>
                <input type="text" name="search" class="filter-input" placeholder="Nama, email, atau konten..."
                    value="{{ request('search') }}">
            </div>
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select name="status" class="filter-input">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="spam" {{ request('status') == 'spam' ? 'selected' : '' }}>Spam</option>
                    <option value="trash" {{ request('status') == 'trash' ? 'selected' : '' }}>Trash</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Post</label>
                <select name="post_id" class="filter-input">
                    <option value="">Semua Post</option>
                    @foreach ($posts as $post)
                        <option value="{{ $post->id }}" {{ request('post_id') == $post->id ? 'selected' : '' }}>
                            {{ Str::limit($post->title, 50) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group" style="display: flex; align-items: flex-end; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="fas fa-search"></i>
                    Filter
                </button>
                <a href="{{ route('admin.comments.index') }}" class="btn"
                    style="background: #e5e7eb; color: var(--dark);">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>

        <!-- Bulk Actions -->
        <form method="POST" action="{{ route('admin.comments.bulk-action') }}" id="bulkForm" class="bulk-actions">
            @csrf
            <span style="font-weight: 600;">
                <span id="selectedCount">0</span> komentar dipilih
            </span>
            <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">
                <i class="fas fa-check"></i> Approve
            </button>
            <button type="submit" name="action" value="spam" class="btn btn-warning btn-sm">
                <i class="fas fa-exclamation-triangle"></i> Spam
            </button>
            <button type="submit" name="action" value="trash" class="btn" style="background: #6b7280; color: white;"
                class="btn-sm">
                <i class="fas fa-trash-alt"></i> Trash
            </button>
            <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm"
                onclick="return confirm('Apakah Anda yakin ingin menghapus permanen?')">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>

        <!-- Comments List -->
        @if ($comments->count() > 0)
            <div class="comment-list">
                @foreach ($comments as $comment)
                    <div class="comment-item">
                        <div class="comment-header">
                            <div style="display: flex; align-items: start; gap: 12px; flex: 1;">
                                <input type="checkbox" class="comment-checkbox" name="ids[]"
                                    value="{{ $comment->id }}" form="bulkForm" style="margin-top: 15px;">
                                <div class="comment-author">
                                    <div class="author-avatar">
                                        {{ strtoupper(substr($comment->author, 0, 1)) }}
                                    </div>
                                    <div class="author-info">
                                        <h4>{{ $comment->author }}</h4>
                                        <div class="author-meta">
                                            @if ($comment->user)
                                                <i class="fas fa-user"></i> Registered User
                                            @else
                                                <i class="fas fa-envelope"></i> {{ $comment->author_email }}
                                            @endif
                                            • {{ $comment->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($comment->status === 'pending')
                                <span class="badge badge-pending"><i class="fas fa-clock"></i> Pending</span>
                            @elseif($comment->status === 'approved')
                                <span class="badge badge-approved"><i class="fas fa-check"></i> Approved</span>
                            @elseif($comment->status === 'spam')
                                <span class="badge badge-spam"><i class="fas fa-ban"></i> Spam</span>
                            @else
                                <span class="badge badge-trash"><i class="fas fa-trash"></i> Trash</span>
                            @endif
                        </div>

                        <div class="comment-content">
                            {{ Str::limit($comment->content, 200) }}
                        </div>

                        <div class="comment-footer">
                            <div class="comment-post">
                                <i class="fas fa-file-alt"></i>
                                Pada: <a
                                    href="{{ route('admin.posts.show', $comment->post) }}">{{ Str::limit($comment->post->title, 50) }}</a>
                                @if ($comment->parent_id)
                                    • <i class="fas fa-reply"></i> Reply
                                @endif
                            </div>
                            <div class="comment-actions">
                                <a href="{{ route('admin.comments.show', $comment) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                @if ($comment->status !== 'approved')
                                    <form method="POST" action="{{ route('admin.comments.approve', $comment) }}"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                @endif
                                @if ($comment->status !== 'spam')
                                    <form method="POST" action="{{ route('admin.comments.spam', $comment) }}"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="fas fa-exclamation-triangle"></i> Spam
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}"
                                    style="display: inline;" onsubmit="return confirm('Hapus permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 10px;">Belum Ada Komentar</h3>
                <p style="color: #6b7280;">Belum ada komentar yang masuk.</p>
            </div>
        @endif

        <!-- Pagination -->
        @if ($comments->hasPages())
            <!-- Pagination -->
            <div style="margin-top: 50px; text-align:center; padding: 10px; border-radius: 5px;">
                {{ $comments->links('vendor.pagination.simple') }}
            </div>
        @endif
    </div>

    <script>
        // Checkbox functionality
        const checkboxes = document.querySelectorAll('.comment-checkbox');
        const bulkForm = document.querySelector('.bulk-actions');
        const selectedCount = document.getElementById('selectedCount');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checked = document.querySelectorAll('.comment-checkbox:checked');
            selectedCount.textContent = checked.length;

            if (checked.length > 0) {
                bulkForm.classList.add('active');
            } else {
                bulkForm.classList.remove('active');
            }
        }
    </script>
@endsection
