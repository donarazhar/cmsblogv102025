@extends('admin.layouts.app')

@section('title', 'Detail Halaman - ' . $page->title)

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h1 class="page-title">Detail Halaman</h1>
                <div class="breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('admin.pages.index') }}">Halaman</a>
                    <span>/</span>
                    <span>{{ $page->title }}</span>
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('page.show', $page->slug) }}" class="btn btn-info" target="_blank">
                    <i class="fas fa-eye"></i>
                    Lihat Halaman
                </a>
                <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-8">
            <!-- Basic Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Halaman</h3>
                </div>
                <div class="card-body">
                    @if ($page->featured_image)
                        <div style="margin-bottom: 30px;">
                            <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}"
                                style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px;">
                        </div>
                    @endif

                    <div class="info-group">
                        <label>Judul</label>
                        <div class="info-value">{{ $page->title }}</div>
                    </div>

                    <div class="info-group">
                        <label>Slug (URL)</label>
                        <div class="info-value">
                            <code
                                style="background: var(--light); padding: 5px 10px; border-radius: 6px; color: var(--primary);">
                                /{{ $page->slug }}
                            </code>
                        </div>
                    </div>

                    <div class="info-group">
                        <label>Konten</label>
                        <div class="content-preview">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Info -->
            @if ($page->meta_title || $page->meta_description || $page->meta_keywords)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">SEO Information</h3>
                    </div>
                    <div class="card-body">
                        @if ($page->meta_title)
                            <div class="info-group">
                                <label>Meta Title</label>
                                <div class="info-value">{{ $page->meta_title }}</div>
                            </div>
                        @endif

                        @if ($page->meta_description)
                            <div class="info-group">
                                <label>Meta Description</label>
                                <div class="info-value">{{ $page->meta_description }}</div>
                            </div>
                        @endif

                        @if ($page->meta_keywords)
                            <div class="info-group">
                                <label>Meta Keywords</label>
                                <div class="info-value">
                                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                        @foreach (explode(',', $page->meta_keywords) as $keyword)
                                            <span class="keyword-tag">{{ trim($keyword) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Child Pages -->
            @if ($page->children->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sub Halaman ({{ $page->children->count() }})</h3>
                    </div>
                    <div class="card-body">
                        <div style="display: grid; gap: 15px;">
                            @foreach ($page->children as $child)
                                <div class="child-page-item">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        @if ($child->featured_image)
                                            <img src="{{ asset('storage/' . $child->featured_image) }}"
                                                alt="{{ $child->title }}"
                                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <div
                                                style="width: 60px; height: 60px; background: var(--light); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-file-alt" style="font-size: 1.5rem; color: #9ca3af;"></i>
                                            </div>
                                        @endif
                                        <div style="flex: 1;">
                                            <h4 style="font-size: 1rem; font-weight: 600; margin-bottom: 5px;">
                                                {{ $child->title }}
                                            </h4>
                                            <div style="display: flex; gap: 15px; font-size: 0.85rem; color: #6b7280;">
                                                <span>
                                                    <i class="fas fa-link"></i> /{{ $child->slug }}
                                                </span>
                                                @if ($child->status == 'published')
                                                    <span class="badge badge-success">Published</span>
                                                @else
                                                    <span class="badge badge-warning">{{ ucfirst($child->status) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ route('admin.pages.show', $child) }}" class="btn btn-sm btn-info"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.pages.edit', $child) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-4">
            <!-- Status Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Status & Pengaturan</h3>
                </div>
                <div class="card-body">
                    <div class="info-group">
                        <label>Status</label>
                        <div class="info-value">
                            @if ($page->status == 'published')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Published
                                </span>
                            @elseif($page->status == 'draft')
                                <span class="badge badge-warning">
                                    <i class="fas fa-edit"></i> Draft
                                </span>
                            @else
                                <span class="badge badge-secondary">
                                    <i class="fas fa-lock"></i> Private
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="info-group">
                        <label>Template</label>
                        <div class="info-value">
                            <span class="badge badge-info">{{ ucfirst(str_replace('-', ' ', $page->template)) }}</span>
                        </div>
                    </div>

                    <div class="info-group">
                        <label>URL</label>
                        <div class="info-value">
                            @if ($page->custom_url)
                                <a href="{{ $page->custom_url }}" target="_blank"
                                    style="color: var(--primary); text-decoration: none; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-external-link-alt"></i>
                                    {{ $page->custom_url }}
                                </a>
                                <small style="color: #9ca3af; display: block; margin-top: 5px;">
                                    Custom URL (External/Route)
                                </small>
                            @else
                                <a href="{{ route('page.show', $page->slug) }}" target="_blank"
                                    style="color: var(--primary); text-decoration: none; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-link"></i>
                                    /{{ $page->slug }}
                                </a>
                                <small style="color: #9ca3af; display: block; margin-top: 5px;">
                                    Page Slug
                                </small>
                            @endif
                        </div>
                    </div>

                    <div class="info-group">
                        <label>Tampil di Menu</label>
                        <div class="info-value">
                            @if ($page->show_in_menu)
                                <span class="badge badge-success">
                                    <i class="fas fa-check"></i> Ya
                                </span>
                            @else
                                <span class="badge badge-secondary">
                                    <i class="fas fa-times"></i> Tidak
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="info-group">
                        <label>Menu Order</label>
                        <div class="info-value">
                            <span class="badge badge-light">{{ $page->menu_order }}</span>
                        </div>
                    </div>

                    @if ($page->parent)
                        <div class="info-group">
                            <label>Parent Page</label>
                            <div class="info-value">
                                <a href="{{ route('admin.pages.show', $page->parent) }}"
                                    style="color: var(--primary); text-decoration: none; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-folder"></i>
                                    {{ $page->parent->title }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if ($page->icon)
                        <div class="info-group">
                            <label>Icon</label>
                            <div class="info-value">
                                <i class="{{ $page->icon }}" style="font-size: 1.5rem; color: var(--primary);"></i>
                                <code
                                    style="margin-left: 10px; background: var(--light); padding: 3px 8px; border-radius: 4px; font-size: 0.85rem;">
                                    {{ $page->icon }}
                                </code>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timestamps Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Timeline</h3>
                </div>
                <div class="card-body">
                    <div class="info-group">
                        <label>Dibuat</label>
                        <div class="info-value">
                            <i class="fas fa-calendar-plus" style="color: var(--success);"></i>
                            {{ $page->created_at->format('d M Y, H:i') }}
                            <br>
                            <small style="color: #9ca3af;">{{ $page->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    <div class="info-group">
                        <label>Terakhir Diupdate</label>
                        <div class="info-value">
                            <i class="fas fa-calendar-check" style="color: var(--info);"></i>
                            {{ $page->updated_at->format('d M Y, H:i') }}
                            <br>
                            <small style="color: #9ca3af;">{{ $page->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('page.show', $page->slug) }}" class="btn btn-info"
                        style="width: 100%; margin-bottom: 10px;" target="_blank">
                        <i class="fas fa-eye"></i>
                        Lihat Halaman
                    </a>
                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning"
                        style="width: 100%; margin-bottom: 10px;">
                        <i class="fas fa-edit"></i>
                        Edit Halaman
                    </a>
                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus halaman ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width: 100%;">
                            <i class="fas fa-trash"></i>
                            Hapus Halaman
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .row {
            display: flex;
            gap: 20px;
            margin: 0 -10px;
        }

        .col-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
            padding: 0 10px;
        }

        .col-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 0 10px;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .card-body {
            padding: 25px;
        }

        .info-group {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .info-group:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-group label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 1rem;
            color: var(--dark);
            line-height: 1.6;
        }

        .content-preview {
            background: var(--light);
            padding: 25px;
            border-radius: 12px;
            border: 1px solid var(--border);
            font-size: 1rem;
            line-height: 1.8;
            color: #374151;
        }

        .content-preview h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 20px 0 15px;
            color: var(--dark);
        }

        .content-preview h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 15px 0 10px;
            color: var(--dark);
        }

        .content-preview p {
            margin-bottom: 15px;
        }

        .content-preview ul,
        .content-preview ol {
            margin-bottom: 15px;
            padding-left: 25px;
        }

        .content-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 15px 0;
        }

        .keyword-tag {
            background: var(--light);
            color: var(--primary);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid var(--border);
        }

        .child-page-item {
            background: var(--light);
            padding: 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .child-page-item:hover {
            background: #e5e7eb;
            transform: translateX(5px);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-secondary {
            background: #f3f4f6;
            color: #6b7280;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-light {
            background: var(--light);
            color: var(--dark);
            border: 1px solid var(--border);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
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
            transform: translateY(-2px);
        }

        @media (max-width: 1024px) {
            .row {
                flex-direction: column;
            }

            .col-8,
            .col-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
@endpush
