@extends('admin.layouts.app')

@section('title', 'Detail Category')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Detail Category</h1>
                <div class="breadcrumb">
                    <a href="{{ route('admin.categories.index') }}">Categories</a>
                    <span>/</span>
                    <span>Detail</span>
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Category
                </a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 20px;">
        <!-- Main Content -->
        <div>
            <!-- Category Info Card -->
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3>{{ $category->name }}</h3>
                    <div>
                        @if ($category->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Image/Icon Display -->
                    <div
                        style="margin-bottom: 25px; text-align: center; padding: 30px; background: var(--light); border-radius: 12px;">
                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                style="max-width: 300px; border-radius: 12px; display: inline-block;">
                        @elseif($category->icon)
                            <div
                                style="width: 120px; height: 120px; background: {{ $category->color }}; border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; color: white;">
                                <i class="{{ $category->icon }}" style="font-size: 3rem;"></i>
                            </div>
                        @else
                            <div
                                style="width: 120px; height: 120px; background: #e5e7eb; border-radius: 20px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-folder" style="font-size: 3rem; color: #9ca3af;"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Meta Info Grid -->
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; padding: 20px; background: var(--light); border-radius: 12px; margin-bottom: 25px;">
                        <div>
                            <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 5px;">Slug</div>
                            <div style="font-weight: 600;">
                                <code style="font-size: 0.9rem;">{{ $category->slug }}</code>
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 5px;">Order</div>
                            <div style="font-weight: 600;">
                                <i class="fas fa-sort-numeric-down"></i> {{ $category->order }}
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 5px;">Color</div>
                            <div style="font-weight: 600; display: flex; align-items: center; gap: 8px;">
                                <div
                                    style="width: 24px; height: 24px; background: {{ $category->color }}; border-radius: 6px; border: 1px solid var(--border);">
                                </div>
                                {{ $category->color }}
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 5px;">Icon Class</div>
                            <div style="font-weight: 600;">
                                @if ($category->icon)
                                    <i class="{{ $category->icon }}"></i> {{ $category->icon }}
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if ($category->description)
                        <div style="margin-bottom: 20px;">
                            <label
                                style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Deskripsi</label>
                            <div style="padding: 15px; background: var(--light); border-radius: 8px; line-height: 1.6;">
                                {{ $category->description }}
                            </div>
                        </div>
                    @endif

                    <!-- Parent Category -->
                    @if ($category->parent)
                        <div style="margin-bottom: 20px;">
                            <label
                                style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Parent
                                Category</label>
                            <div style="padding: 15px; background: var(--light); border-radius: 8px;">
                                <a href="{{ route('admin.categories.show', $category->parent) }}"
                                    style="color: var(--primary); text-decoration: none; font-weight: 600;">
                                    <i class="fas fa-level-up-alt"></i> {{ $category->parent->name }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Sub Categories -->
                    @if ($category->children->count() > 0)
                        <div style="margin-bottom: 20px;">
                            <label
                                style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">
                                Sub Categories ({{ $category->children->count() }})
                            </label>
                            <div
                                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px;">
                                @foreach ($category->children as $child)
                                    <a href="{{ route('admin.categories.show', $child) }}"
                                        style="padding: 12px 15px; background: var(--light); border-radius: 8px; text-decoration: none; color: var(--dark); display: flex; align-items: center; gap: 10px; transition: all 0.3s ease;">
                                        @if ($child->icon)
                                            <div
                                                style="width: 35px; height: 35px; background: {{ $child->color }}; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                                <i class="{{ $child->icon }}"></i>
                                            </div>
                                        @endif
                                        <div style="flex: 1;">
                                            <div style="font-weight: 600;">{{ $child->name }}</div>
                                            <div style="font-size: 0.85rem; color: #6b7280;">{{ $child->posts->count() }}
                                                posts</div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEO Settings Card -->
            @if ($category->meta_title || $category->meta_description || $category->meta_keywords)
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        <h3>SEO Settings</h3>
                    </div>
                    <div class="card-body">
                        @if ($category->meta_title)
                            <div style="margin-bottom: 15px;">
                                <label
                                    style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Meta
                                    Title</label>
                                <div style="padding: 12px 15px; background: var(--light); border-radius: 8px;">
                                    {{ $category->meta_title }}
                                </div>
                            </div>
                        @endif

                        @if ($category->meta_description)
                            <div style="margin-bottom: 15px;">
                                <label
                                    style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Meta
                                    Description</label>
                                <div
                                    style="padding: 12px 15px; background: var(--light); border-radius: 8px; line-height: 1.6;">
                                    {{ $category->meta_description }}
                                </div>
                            </div>
                        @endif

                        @if ($category->meta_keywords)
                            <div>
                                <label
                                    style="font-weight: 600; color: #6b7280; font-size: 0.9rem; display: block; margin-bottom: 8px;">Meta
                                    Keywords</label>
                                <div style="padding: 12px 15px; background: var(--light); border-radius: 8px;">
                                    {{ $category->meta_keywords }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Recent Posts Card -->
            @if ($category->posts->count() > 0)
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h3>Recent Posts ({{ $category->posts->count() }})</h3>
                        <a href="{{ route('admin.posts.index', ['category' => $category->id]) }}"
                            class="btn btn-sm btn-primary">
                            View All <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="card-body" style="padding: 0;">
                        <div style="max-height: 500px; overflow-y: auto;">
                            @foreach ($category->posts as $post)
                                <a href="{{ route('admin.posts.show', $post) }}"
                                    style="display: flex; align-items: center; gap: 15px; padding: 15px 25px; text-decoration: none; color: var(--dark); border-bottom: 1px solid var(--border); transition: all 0.3s ease;">
                                    @if ($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}"
                                            alt="{{ $post->title }}"
                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <div
                                            style="width: 60px; height: 60px; background: var(--light); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-file-alt" style="color: #9ca3af;"></i>
                                        </div>
                                    @endif
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; margin-bottom: 5px;">{{ $post->title }}</div>
                                        <div style="font-size: 0.85rem; color: #6b7280;">
                                            <i class="fas fa-calendar"></i> {{ $post->created_at->format('d M Y') }}
                                            <span style="margin: 0 8px;">•</span>
                                            <i class="fas fa-eye"></i> {{ number_format($post->views_count) }}
                                        </div>
                                    </div>
                                    @if ($post->status == 'published')
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($post->status) }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
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
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary"
                            style="width: 100%;">
                            <i class="fas fa-edit"></i> Edit Category
                        </a>

                        <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $category->is_active ? 'warning' : 'success' }}"
                                style="width: 100%;">
                                <i class="fas fa-{{ $category->is_active ? 'times' : 'check' }}"></i>
                                {{ $category->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <hr style="margin: 10px 0; border: none; border-top: 1px solid var(--border);">

                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus category ini? Tindakan ini tidak dapat dibatalkan!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="width: 100%;">
                                <i class="fas fa-trash"></i> Delete Category
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
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <div style="font-size: 0.85rem; color: #6b7280;">Total Posts</div>
                                    <div style="font-weight: 700; font-size: 1.2rem;">{{ $category->posts->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div
                                    style="width: 40px; height: 40px; background: #d1fae5; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #065f46;">
                                    <i class="fas fa-sitemap"></i>
                                </div>
                                <div>
                                    <div style="font-size: 0.85rem; color: #6b7280;">Sub Categories</div>
                                    <div style="font-weight: 700; font-size: 1.2rem;">{{ $category->children->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div
                                    style="width: 40px; height: 40px; background: #fef3c7; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #92400e;">
                                    <i class="fas fa-sort-numeric-down"></i>
                                </div>
                                <div>
                                    <div style="font-size: 0.85rem; color: #6b7280;">Order</div>
                                    <div style="font-weight: 700; font-size: 1.2rem;">{{ $category->order }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card" style="margin-top: 20px;">
                <div class="card-header">
                    <h3>Informasi</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 15px; font-size: 0.9rem;">
                        <div>
                            <div style="color: #6b7280; margin-bottom: 5px;">Status</div>
                            <div style="font-weight: 600;">
                                @if ($category->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div style="color: #6b7280; margin-bottom: 5px;">Created At</div>
                            <div style="font-weight: 600;">
                                <i class="fas fa-calendar-plus"></i> {{ $category->created_at->format('d M Y H:i') }}
                            </div>
                        </div>

                        <div>
                            <div style="color: #6b7280; margin-bottom: 5px;">Last Updated</div>
                            <div style="font-weight: 600;">
                                <i class="fas fa-calendar-check"></i> {{ $category->updated_at->format('d M Y H:i') }}
                            </div>
                        </div>

                        @if ($category->parent)
                            <div>
                                <div style="color: #6b7280; margin-bottom: 5px;">Type</div>
                                <div style="font-weight: 600;">
                                    <span class="badge badge-secondary">Sub Category</span>
                                </div>
                            </div>
                        @else
                            <div>
                                <div style="color: #6b7280; margin-bottom: 5px;">Type</div>
                                <div style="font-weight: 600;">
                                    <span class="badge badge-primary">Parent Category</span>
                                </div>
                            </div>
                        @endif
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

        .badge-primary {
            background: #dbeafe;
            color: var(--primary);
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

        code {
            background: var(--light);
            padding: 4px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
        }

        a[style*="border-bottom"]:hover {
            background: var(--light);
        }

        a[style*="grid"]:hover {
            background: #e5e7eb;
            transform: translateX(5px);
        }
    </style>
@endpush
