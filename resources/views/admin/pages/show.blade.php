@extends('admin.layouts.app')

@section('title', 'Detail Halaman')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Detail Halaman</h1>
        <p class="page-subtitle">Informasi lengkap halaman website</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.pages.index') }}">Halaman</a>
            <span>/</span>
            <span>Detail</span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-bar mb-4">
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div class="action-right">
            <a href="{{ $page->url }}" target="_blank" class="btn btn-info">
                <i class="fas fa-external-link-alt"></i> Lihat Halaman
            </a>
            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" style="display: inline;"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="detail-grid">
        <!-- Main Content -->
        <div class="detail-main">
            <!-- Page Header Card -->
            <div class="card">
                <div class="card-header">
                    <div class="page-header-content">
                        <div class="page-title-section">
                            @if ($page->icon)
                                <div class="page-icon">
                                    <i class="{{ $page->icon }}"></i>
                                </div>
                            @endif
                            <div>
                                <h2 class="page-title-main">{{ $page->title }}</h2>
                                <div class="page-meta">
                                    <span class="badge badge-status-{{ $page->status }}">
                                        <i class="fas fa-circle"></i>
                                        {{ ucfirst($page->status) }}
                                    </span>
                                    <span class="badge badge-template">
                                        <i class="fas fa-palette"></i>
                                        {{ ucfirst(str_replace('-', ' ', $page->template)) }}
                                    </span>
                                    @if ($page->show_in_menu)
                                        <span class="badge badge-menu">
                                            <i class="fas fa-bars"></i>
                                            In Menu ({{ $page->menu_order }})
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="page-url">
                            <label>URL:</label>
                            <code class="url-code">{{ $page->url }}</code>
                            <button type="button" class="btn-copy" onclick="copyToClipboard('{{ $page->url }}')"
                                title="Copy URL">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Image Card -->
            @if ($page->featured_image)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-image"></i>
                            Gambar Unggulan
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="featured-image">
                            <img src="{{ Storage::url($page->featured_image) }}" alt="{{ $page->title }}">
                        </div>
                        <div class="image-info">
                            <i class="fas fa-info-circle"></i>
                            <span>{{ basename($page->featured_image) }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Content Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt"></i>
                        Konten Halaman
                    </h3>
                </div>
                <div class="card-body">
                    <div class="content-box">
                        {!! nl2br(e($page->content)) !!}
                    </div>
                </div>
            </div>

            <!-- SEO Card -->
            @if ($page->meta_title || $page->meta_description || $page->meta_keywords)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-search"></i>
                            SEO Meta Tags
                        </h3>
                    </div>
                    <div class="card-body">
                        @if ($page->meta_title)
                            <div class="seo-item">
                                <label>Meta Title:</label>
                                <p>{{ $page->meta_title }}</p>
                            </div>
                        @endif

                        @if ($page->meta_description)
                            <div class="seo-item">
                                <label>Meta Description:</label>
                                <p>{{ $page->meta_description }}</p>
                            </div>
                        @endif

                        @if ($page->meta_keywords)
                            <div class="seo-item">
                                <label>Meta Keywords:</label>
                                <div class="keywords-tags">
                                    @foreach (explode(',', $page->meta_keywords) as $keyword)
                                        <span class="keyword-tag">{{ trim($keyword) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="detail-sidebar">
            <!-- Page Info Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Informasi Halaman
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-plus"></i>
                            Dibuat
                        </div>
                        <div class="info-value">
                            {{ $page->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-check"></i>
                            Diperbarui
                        </div>
                        <div class="info-value">
                            {{ $page->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-link"></i>
                            Slug
                        </div>
                        <div class="info-value">
                            <code>{{ $page->slug }}</code>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Template Info Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-palette"></i>
                        Template & Layout
                    </h3>
                </div>
                <div class="card-body">
                    <div class="template-display">
                        <div class="template-icon">
                            @switch($page->template)
                                @case('full-width')
                                    <i class="fas fa-window-maximize"></i>
                                @break

                                @case('sidebar-left')
                                    <i class="fas fa-columns"></i>
                                @break

                                @case('sidebar-right')
                                    <i class="fas fa-columns"></i>
                                @break

                                @case('contact')
                                    <i class="fas fa-envelope"></i>
                                @break

                                @case('about')
                                    <i class="fas fa-info-circle"></i>
                                @break

                                @default
                                    <i class="fas fa-th-large"></i>
                            @endswitch
                        </div>
                        <div class="template-name">
                            {{ ucfirst(str_replace('-', ' ', $page->template)) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hierarchy Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-sitemap"></i>
                        Hierarki
                    </h3>
                </div>
                <div class="card-body">
                    @if ($page->parent)
                        <div class="hierarchy-item parent">
                            <i class="fas fa-level-up-alt"></i>
                            <div>
                                <label>Parent:</label>
                                <a href="{{ route('admin.pages.show', $page->parent) }}">
                                    {{ $page->parent->title }}
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="hierarchy-item root">
                            <i class="fas fa-home"></i>
                            <div>
                                <label>Level:</label>
                                <span>Parent / Root Page</span>
                            </div>
                        </div>
                    @endif

                    @if ($page->children->count() > 0)
                        <div class="children-list">
                            <label>Sub-halaman ({{ $page->children->count() }}):</label>
                            <ul>
                                @foreach ($page->children as $child)
                                    <li>
                                        <i class="fas fa-angle-right"></i>
                                        <a href="{{ route('admin.pages.show', $child) }}">
                                            {{ $child->title }}
                                        </a>
                                        <span class="badge badge-sm badge-status-{{ $child->status }}">
                                            {{ ucfirst($child->status) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Menu Settings Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bars"></i>
                        Pengaturan Menu
                    </h3>
                </div>
                <div class="card-body">
                    <div class="setting-row">
                        <div class="setting-label">Tampil di Menu</div>
                        <div class="setting-value">
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

                    @if ($page->show_in_menu)
                        <div class="setting-row">
                            <div class="setting-label">Urutan Menu</div>
                            <div class="setting-value">
                                <span class="badge badge-info">
                                    <i class="fas fa-sort-numeric-down"></i>
                                    {{ $page->menu_order }}
                                </span>
                            </div>
                        </div>
                    @endif

                    @if ($page->icon)
                        <div class="setting-row">
                            <div class="setting-label">Icon</div>
                            <div class="setting-value">
                                <div class="icon-display">
                                    <i class="{{ $page->icon }}"></i>
                                    <code>{{ $page->icon }}</code>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <a href="{{ $page->url }}" target="_blank" class="quick-action-btn">
                        <i class="fas fa-eye"></i>
                        <span>Preview Halaman</span>
                    </a>
                    <a href="{{ route('admin.pages.edit', $page) }}" class="quick-action-btn">
                        <i class="fas fa-edit"></i>
                        <span>Edit Halaman</span>
                    </a>
                    <button type="button" class="quick-action-btn" onclick="copyToClipboard('{{ $page->url }}')">
                        <i class="fas fa-copy"></i>
                        <span>Copy URL</span>
                    </button>
                    @if ($page->featured_image)
                        <a href="{{ Storage::url($page->featured_image) }}" target="_blank" class="quick-action-btn">
                            <i class="fas fa-download"></i>
                            <span>Download Gambar</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .action-right {
            display: flex;
            gap: 10px;
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

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }

        .btn-info {
            background: var(--info);
            color: white;
        }

        .btn-info:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
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

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 20px;
        }

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

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-body {
            padding: 20px;
        }

        .page-header-content {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .page-title-section {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .page-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            flex-shrink: 0;
        }

        .page-title-main {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 12px;
        }

        .page-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .page-url {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            background: var(--light);
            border-radius: 8px;
        }

        .page-url label {
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .url-code {
            flex: 1;
            background: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            color: var(--primary);
            font-family: 'Courier New', monospace;
            border: 1px solid var(--border);
        }

        .btn-copy {
            background: var(--primary);
            color: white;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-copy:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        .featured-image {
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid var(--border);
            margin-bottom: 10px;
        }

        .featured-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .image-info {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            font-size: 0.85rem;
        }

        .content-box {
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 25px;
            line-height: 1.8;
            color: #374151;
            font-size: 0.95rem;
            min-height: 200px;
        }

        .seo-item {
            margin-bottom: 20px;
        }

        .seo-item:last-child {
            margin-bottom: 0;
        }

        .seo-item label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .seo-item p {
            color: #374151;
            line-height: 1.6;
            margin: 0;
        }

        .keywords-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .keyword-tag {
            background: var(--primary);
            color: white;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 500;
            color: #6b7280;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-label i {
            width: 20px;
            text-align: center;
        }

        .info-value {
            font-weight: 500;
            color: var(--dark);
            font-size: 0.9rem;
            text-align: right;
        }

        .info-value code {
            background: var(--light);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            color: var(--primary);
        }

        .template-display {
            text-align: center;
            padding: 20px;
        }

        .template-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .template-icon i {
            font-size: 2.5rem;
            color: #6b21a8;
        }

        .template-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
        }

        .hierarchy-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: var(--light);
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .hierarchy-item i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .hierarchy-item label {
            display: block;
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .hierarchy-item span,
        .hierarchy-item a {
            font-weight: 500;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .hierarchy-item a {
            text-decoration: none;
            color: var(--primary);
        }

        .hierarchy-item a:hover {
            text-decoration: underline;
        }

        .children-list {
            margin-top: 15px;
        }

        .children-list label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .children-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .children-list li {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: var(--light);
            border-radius: 6px;
            margin-bottom: 6px;
        }

        .children-list li:last-child {
            margin-bottom: 0;
        }

        .children-list li i {
            color: var(--primary);
        }

        .children-list li a {
            flex: 1;
            color: var(--dark);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .children-list li a:hover {
            color: var(--primary);
        }

        .setting-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .setting-row:last-child {
            border-bottom: none;
        }

        .setting-label {
            font-weight: 500;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .icon-display {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-display i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .icon-display code {
            background: var(--light);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            color: #6b7280;
        }

        .quick-action-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: 8px;
            text-decoration: none;
            color: var(--dark);
            transition: all 0.3s ease;
            margin-bottom: 10px;
            cursor: pointer;
            width: 100%;
        }

        .quick-action-btn:last-child {
            margin-bottom: 0;
        }

        .quick-action-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateX(5px);
        }

        .quick-action-btn i {
            width: 20px;
            text-align: center;
        }

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

        .badge-menu {
            background: #fef3c7;
            color: #92400e;
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

        .badge i.fa-circle {
            font-size: 0.5rem;
        }

        @media (max-width: 1024px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .action-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .action-right {
                width: 100%;
            }

            .btn {
                flex: 1;
                justify-content: center;
            }

            .page-title-section {
                flex-direction: column;
            }

            .page-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .page-title-main {
                font-size: 1.4rem;
            }

            .page-url {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const btn = event.currentTarget;
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i>';
                btn.style.background = '#10b981';

                setTimeout(function() {
                    btn.innerHTML = originalHTML;
                    btn.style.background = '';
                }, 2000);
            }, function(err) {
                alert('Gagal menyalin: ' + err);
            });
        }
    </script>
@endpush
