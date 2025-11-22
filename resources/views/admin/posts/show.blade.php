@extends('admin.layouts.app')

@section('title', 'Detail Post')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Detail Post</h1>
                <div class="breadcrumb">
                    <a href="{{ route('admin.posts.index') }}">Posts</a>
                    <span>/</span>
                    <span>Detail</span>
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Post
                </a>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 20px;">
        <!-- Main Content -->
        <div>
            <!-- Post Info Card -->
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3>{{ $post->title }}</h3>
                    <div style="display: flex; gap: 10px;">
                        @if ($post->status == 'published')
                            <span class="badge badge-success">Published</span>
                        @elseif($post->status == 'draft')
                            <span class="badge badge-secondary">Draft</span>
                        @elseif($post->status == 'scheduled')
                            <span class="badge badge-warning">Scheduled</span>
                        @else
                            <span class="badge badge-dark">Archived</span>
                        @endif

                        @if ($post->is_featured)
                            <span class="badge badge-warning">
                                <i class="fas fa-star"></i> Featured
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Featured Image -->
                    @if ($post->featured_image)
                        <div style="margin-bottom: 25px;">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                style="width: 100%; border-radius: 12px; display: block;">
                        </div>
                    @endif

                    <!-- Meta Info -->
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; padding: 20px; background: var(--light); border-radius: 12px; margin-bottom: 25px;">
                        <div>
                            <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 5px;">Author</div>
                            <div style="font-weight: 600;">
                                <i class="fas fa-user"></i> {{ $post->author->name }}
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 5px;">Category</div>
                            <div style="font-weight: 600;">
                                <i class="fas fa-folder"></i> {{ $post->category->name }}
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 5px;">Post Type</div>
                            <div style="font-weight: 600;">
                                <i class="fas fa-file-alt"></i> {{ ucfirst($post->post_type) }}
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 5px;">Views</div>
                            <div style="font-weight: 600;">
                                <i class="fas fa-eye"></i> {{ number_format($post->views_count) }}
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 5px;">Reading Time</div>
                            <div style="font-weight: 600;">
                                <i class="fas fa-clock"></i> {{ $post->reading_time }} min
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; color:#6b7280; margin-bottom: 5px;">Created At</div>
                            <div style="font-weight: 600;">
                                <i class="fas fa-calendar"></i> {{ $post->created_at->format('d M Y H:i') }}
                            </div>
                        </div>
                    </div>

                    <!-- Slug -->
                    <div style="margin-bottom: 20px;">
                        <label
                            style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Slug</label>
                        <div
                            style="padding: 12px 15px; background: var(--light); border-radius: 8px; font-family: monospace; font-size: 0.9rem;">
                            {{ $post->slug }}
                        </div>
                    </div>

                    <!-- Excerpt -->
                    @if ($post->excerpt)
                        <div style="margin-bottom: 20px;">
                            <label
                                style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Excerpt</label>
                            <div style="padding: 15px; background: var(--light); border-radius: 8px; line-height: 1.6;">
                                {{ $post->excerpt }}
                            </div>
                        </div>
                    @endif

                    <!-- Content -->
                    <div style="margin-bottom: 20px;">
                        <label
                            style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Content</label>
                        <div style="padding: 20px; background: var(--light); border-radius: 8px; line-height: 1.8;">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                    </div>

                    <!-- Featured Video -->
                    @if ($post->featured_video)
                        <div style="margin-bottom: 20px;">
                            <label
                                style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Featured
                                Video</label>
                            <div style="padding: 12px 15px; background: var(--light); border-radius: 8px;">
                                <a href="{{ $post->featured_video }}" target="_blank"
                                    style="color: var(--primary); text-decoration: none;">
                                    <i class="fas fa-external-link-alt"></i> {{ $post->featured_video }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Tags -->
                    @if ($post->tags->count() > 0)
                        <div style="margin-bottom: 20px;">
                            <label
                                style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Tags</label>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                @foreach ($post->tags as $tag)
                                    <span class="badge badge-info">
                                        <i class="fas fa-tag"></i> {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEO Settings Card -->
            @if ($post->meta_title || $post->meta_description || $post->meta_keywords)
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        <h3>SEO Settings</h3>
                    </div>
                    <div class="card-body">
                        @if ($post->meta_title)
                            <div style="margin-bottom: 15px;">
                                <label
                                    style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Meta
                                    Title</label>
                                <div style="padding: 12px 15px; background: var(--light); border-radius: 8px;">
                                    {{ $post->meta_title }}
                                </div>
                            </div>
                        @endif

                        @if ($post->meta_description)
                            <div style="margin-bottom: 15px;">
                                <label
                                    style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Meta
                                    Description</label>
                                <div
                                    style="padding: 12px 15px; background: var(--light); border-radius: 8px; line-height: 1.6;">
                                    {{ $post->meta_description }}
                                </div>
                            </div>
                        @endif

                        @if ($post->meta_keywords)
                            <div>
                                <label
                                    style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Meta
                                    Keywords</label>
                                <div style="padding: 12px 15px; background: var(--light); border-radius: 8px;">
                                    {{ $post->meta_keywords }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Comments Card -->
            @if ($post->comments->count() > 0)
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        <h3>Comments ({{ $post->comments->count() }})</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($post->comments as $comment)
                            <div style="padding: 15px; background: var(--light); border-radius: 8px; margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                    <div>
                                        <strong>{{ $comment->author_name }}</strong>
                                        <span style="color: #6b7280; font-size: 0.85rem; margin-left: 10px;">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <span class="badge badge-{{ $comment->status == 'approved' ? 'success' : 'warning' }}">
                                        {{ ucfirst($comment->status) }}
                                    </span>
                                </div>
                                <div style="line-height: 1.6;">
                                    {{ $comment->content }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Actions Card -->
            <div class="card">
                <div class="card-header">
                    <h3>Actions</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-edit"></i> Edit Post
                        </a>

                        @if ($post->status != 'published')
                            <form action="{{ route('admin.posts.publish', $post) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success" style="width: 100%;">
                                    <i class="fas fa-check"></i> Publish Post
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.posts.unpublish', $post) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning" style="width: 100%;">
                                    <i class="fas fa-times"></i> Unpublish Post
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.posts.toggle-featured', $post) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-info" style="width: 100%;">
                                <i class="fas fa-star"></i>
                                {{ $post->is_featured ? 'Remove from Featured' : 'Make Featured' }}
                            </button>
                        </form>

                        <hr style="margin: 10px 0; border: none; border-top: 1px solid var(--border);">

                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus post ini? Tindakan ini tidak dapat dibatalkan!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="width: 100%;">
                                <i class="fas fa-trash"></i> Delete Post
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="card" style="margin-top: 20px;">
                <div class="card-header">
                    <h3>Statistics</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div
                                    style="width: 40px; height: 40px; background: #dbeafe; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #1e40af;">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div>
                                    <div style="font-size: 0.85rem; color: #6b7280;">Views</div>
                                    <div style="font-weight: 700; font-size: 1.2rem;">
                                        {{ number_format($post->views_count) }}</div>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div
                                    style="width: 40px; height: 40px; background: #d1fae5; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #065f46;">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div>
                                    <div style="font-size: 0.85rem; color: #6b7280;">Comments</div>
                                    <div style="font-weight: 700; font-size: 1.2rem;">{{ $post->comments->count() }}</div>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div
                                    style="width: 40px; height: 40px; background: #fef3c7; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #92400e;">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <div style="font-size: 0.85rem; color: #6b7280;">Reading Time</div>
                                    <div style="font-weight: 700; font-size: 1.2rem;">{{ $post->reading_time }} min</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Publish Info Card -->
            <div class="card" style="margin-top: 20px;">
                <div class="card-header">
                    <h3>Publish Info</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 15px; font-size: 0.9rem;">
                        <div>
                            <div style="color: #6b7280; margin-bottom: 5px;">Status</div>
                            <div style="font-weight: 600;">
                                @if ($post->status == 'published')
                                    <span class="badge badge-success">Published</span>
                                @elseif($post->status == 'draft')
                                    <span class="badge badge-secondary">Draft</span>
                                @elseif($post->status == 'scheduled')
                                    <span class="badge badge-warning">Scheduled</span>
                                @else
                                    <span class="badge badge-dark">Archived</span>
                                @endif
                            </div>
                        </div>

                        @if ($post->published_at)
                            <div>
                                <div style="color: #6b7280; margin-bottom: 5px;">Published At</div>
                                <div style="font-weight: 600;">
                                    <i class="fas fa-calendar"></i> {{ $post->published_at->format('d M Y H:i') }}
                                </div>
                            </div>
                        @endif

                        @if ($post->scheduled_at)
                            <div>
                                <div style="color: #6b7280; margin-bottom: 5px;">Scheduled At</div>
                                <div style="font-weight: 600;">
                                    <i class="fas fa-calendar-alt"></i> {{ $post->scheduled_at->format('d M Y H:i') }}
                                </div>
                            </div>
                        @endif

                        <div>
                            <div style="color: #6b7280; margin-bottom: 5px;">Created At</div>
                            <div style="font-weight: 600;">
                                <i class="fas fa-calendar-plus"></i> {{ $post->created_at->format('d M Y H:i') }}
                            </div>
                        </div>

                        <div>
                            <div style="color: #6b7280; margin-bottom: 5px;">Last Updated</div>
                            <div style="font-weight: 600;">
                                <i class="fas fa-calendar-check"></i> {{ $post->updated_at->format('d M Y H:i') }}
                            </div>
                        </div>

                        <div>
                            <div style="color: #6b7280; margin-bottom: 5px;">Comments</div>
                            <div style="font-weight: 600;">
                                <i class="fas fa-{{ $post->allow_comments ? 'check-circle' : 'times-circle' }}"></i>
                                {{ $post->allow_comments ? 'Allowed' : 'Disabled' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
            background: var(--light);
        }

        .card-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
        }

        .card-body {
            padding: 25px;
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
            justify-content: center;
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

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
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
    </style>
@endpush
