@extends('admin.layouts.app')

@section('title', 'Detail Comment')

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
        }

        .breadcrumb span {
            color: #9ca3af;
        }

        .comment-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .comment-header {
            padding: 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 20px;
        }

        .author-section {
            display: flex;
            gap: 15px;
            align-items: start;
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .author-info h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .author-meta {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .comment-body {
            padding: 30px 25px;
        }

        .comment-content {
            font-size: 1rem;
            line-height: 1.8;
            color: #374151;
            margin-bottom: 25px;
        }

        .comment-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
            background: var(--light);
            border-radius: 8px;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .meta-label {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 600;
        }

        .meta-value {
            font-size: 0.95rem;
            color: var(--dark);
        }

        .comment-actions {
            padding: 20px 25px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            background: var(--light);
            border-radius: 0 0 12px 12px;
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

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: var(--dark);
        }

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
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

        .reply-section {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .reply-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
            font-size: 1.2rem;
            font-weight: 700;
        }

        .reply-form {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .replies-list {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .reply-item {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
        }

        .reply-item:last-child {
            border-bottom: none;
        }

        @media (max-width: 768px) {
            .comment-header {
                flex-direction: column;
            }

            .comment-actions {
                flex-direction: column;
            }

            .comment-meta-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <span>/</span>
        <a href="{{ route('admin.comments.index') }}">Comments</a>
        <span>/</span>
        <span style="color: var(--dark); font-weight: 600;">Detail</span>
    </div>

    <!-- Comment Card -->
    <div class="comment-card">
        <div class="comment-header">
            <div class="author-section">
                <div class="author-avatar">
                    {{ strtoupper(substr($comment->author, 0, 1)) }}
                </div>
                <div class="author-info">
                    <h3>{{ $comment->author }}</h3>
                    <div class="author-meta">
                        @if ($comment->user)
                            <i class="fas fa-user-check"></i> Registered User
                        @else
                            <i class="fas fa-envelope"></i> {{ $comment->author_email }}
                        @endif
                    </div>
                    <div class="author-meta">
                        <i class="fas fa-clock"></i> {{ $comment->created_at->format('d M Y, H:i') }}
                        ({{ $comment->created_at->diffForHumans() }})
                    </div>
                </div>
            </div>
            @if ($comment->status === 'pending')
                <span class="badge badge-pending"><i class="fas fa-clock"></i> Pending</span>
            @elseif($comment->status === 'approved')
                <span class="badge badge-approved"><i class="fas fa-check"></i> Approved</span>
            @elseif($comment->status === 'spam')
                <span class="badge badge-spam"><i class="fas fa-ban"></i> Spam</span>
            @endif
        </div>

        <div class="comment-body">
            <div class="comment-content">
                {{ $comment->content }}
            </div>

            <div class="comment-meta-grid">
                <div class="meta-item">
                    <span class="meta-label">Post</span>
                    <a href="{{ route('admin.posts.show', $comment->post) }}" class="meta-value"
                        style="color: var(--primary); text-decoration: none;">
                        {{ Str::limit($comment->post->title, 50) }}
                    </a>
                </div>
                @if ($comment->parent_id)
                    <div class="meta-item">
                        <span class="meta-label">Reply To</span>
                        <span class="meta-value">{{ $comment->parent->author }}</span>
                    </div>
                @endif
                <div class="meta-item">
                    <span class="meta-label">IP Address</span>
                    <span class="meta-value">{{ $comment->ip_address ?? '-' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">User Agent</span>
                    <span class="meta-value">{{ Str::limit($comment->user_agent ?? '-', 30) }}</span>
                </div>
            </div>
        </div>

        <div class="comment-actions">
            <a href="{{ route('admin.comments.edit', $comment) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>

            @if ($comment->status !== 'approved')
                <form method="POST" action="{{ route('admin.comments.approve', $comment) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Approve
                    </button>
                </form>
            @endif

            @if ($comment->status !== 'spam')
                <form method="POST" action="{{ route('admin.comments.spam', $comment) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-exclamation-triangle"></i> Mark as Spam
                    </button>
                </form>
            @endif

            <form method="POST" action="{{ route('admin.comments.trash', $comment) }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn" style="background: #6b7280; color: white;">
                    <i class="fas fa-trash-alt"></i> Move to Trash
                </button>
            </form>

            <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" style="display: inline;"
                onsubmit="return confirm('Hapus permanen komentar ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Permanent
                </button>
            </form>

            <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Reply Form -->
    <div class="reply-section">
        <div class="reply-header">
            <i class="fas fa-reply"></i> Balas Komentar
        </div>
        <form method="POST" action="{{ route('admin.comments.reply', $comment) }}" class="reply-form">
            @csrf
            <div class="form-group">
                <label for="content" class="form-label">Balasan Anda</label>
                <textarea id="content" name="content" class="form-input" rows="4" placeholder="Tulis balasan Anda..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Kirim Balasan
            </button>
        </form>
    </div>

    <!-- Replies List -->
    @if ($comment->replies->count() > 0)
        <div class="replies-list">
            <div class="reply-header">
                <i class="fas fa-comments"></i> Balasan ({{ $comment->replies->count() }})
            </div>
            @foreach ($comment->replies as $reply)
                <div class="reply-item">
                    <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                        <div class="author-avatar" style="width: 40px; height: 40px; font-size: 1rem;">
                            {{ strtoupper(substr($reply->author, 0, 1)) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; margin-bottom: 5px;">{{ $reply->author }}</div>
                            <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 10px;">
                                {{ $reply->created_at->diffForHumans() }}
                            </div>
                            <div style="color: #374151;">{{ $reply->content }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
