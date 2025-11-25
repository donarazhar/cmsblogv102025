@extends('admin.layouts.app')

@section('title', 'Kelola Halaman')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h1 class="page-title">Kelola Halaman</h1>
                <div class="breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <span>Halaman</span>
                </div>
            </div>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Halaman
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.pages.index') }}">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <div>
                        <input type="text" name="search" placeholder="Cari halaman..." value="{{ request('search') }}"
                            class="form-control">
                    </div>
                    <div>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published
                            </option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="private" {{ request('status') == 'private' ? 'selected' : '' }}>Private</option>
                        </select>
                    </div>
                    <div>
                        <select name="template" class="form-control">
                            <option value="">Semua Template</option>
                            <option value="default" {{ request('template') == 'default' ? 'selected' : '' }}>Default
                            </option>
                            <option value="full-width" {{ request('template') == 'full-width' ? 'selected' : '' }}>Full
                                Width</option>
                            <option value="sidebar-left" {{ request('template') == 'sidebar-left' ? 'selected' : '' }}>
                                Sidebar Left</option>
                            <option value="sidebar-right" {{ request('template') == 'sidebar-right' ? 'selected' : '' }}>
                                Sidebar Right</option>
                            <option value="contact" {{ request('template') == 'contact' ? 'selected' : '' }}>Contact
                            </option>
                            <option value="about" {{ request('template') == 'about' ? 'selected' : '' }}>About</option>
                        </select>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Pages Table -->
    <div class="card">
        <div class="card-body" style="padding: 0;">
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="50" style="text-align: center;">
                                <i class="fas fa-grip-vertical" style="color: #9ca3af;"></i>
                            </th>
                            <th>Judul</th>
                            <th width="120">Status</th>
                            <th width="120">Template</th>
                            <th width="100">Menu</th>
                            <th width="80">Order</th>
                            <th width="150">Tanggal</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-pages">
                        @forelse ($pages as $page)
                            <tr data-id="{{ $page->id }}" style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center;">
                                    <i class="fas fa-grip-vertical drag-handle" style="cursor: move; color: #9ca3af;"></i>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        @if ($page->featured_image)
                                            <img src="{{ asset('storage/' . $page->featured_image) }}"
                                                alt="{{ $page->title }}"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        @endif
                                        <div>
                                            <strong style="color: var(--dark);">{{ $page->title }}</strong>
                                            <br>
                                            @if ($page->custom_url)
                                                <small style="color: #10b981;">
                                                    <i class="fas fa-external-link-alt"></i>
                                                    {{ Str::limit($page->custom_url, 40) }}
                                                </small>
                                            @else
                                                <small style="color: #6b7280;">
                                                    <i class="fas fa-link"></i> /{{ $page->slug }}
                                                </small>
                                            @endif
                                            @if ($page->parent)
                                                <br>
                                                <small style="color: #9ca3af;">
                                                    <i class="fas fa-folder"></i> Parent: {{ $page->parent->title }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($page->status == 'published')
                                        <span class="badge badge-success">Published</span>
                                    @elseif($page->status == 'draft')
                                        <span class="badge badge-warning">Draft</span>
                                    @else
                                        <span class="badge badge-secondary">Private</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ ucfirst($page->template) }}</span>
                                </td>
                                <td>
                                    @if ($page->show_in_menu)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> Ya
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-times"></i> Tidak
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-light">{{ $page->menu_order }}</span>
                                </td>
                                <td>
                                    <small style="color: #6b7280;">
                                        {{ $page->created_at->format('d M Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <a href="{{ route('page.show', $page->slug) }}" class="btn btn-sm btn-info"
                                            target="_blank" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 50px;">
                                    <i class="fas fa-file-alt"
                                        style="font-size: 3rem; color: #e5e7eb; margin-bottom: 15px; display: block;"></i>
                                    <p style="color: #9ca3af; margin-bottom: 15px;">Belum ada halaman</p>
                                    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Halaman Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($pages->hasPages())
            <div class="card-footer">
                {{ $pages->links() }}
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: var(--light);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
            border-bottom: 2px solid var(--border);
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
        }

        .drag-handle {
            cursor: move;
        }

        .drag-handle:hover {
            color: var(--primary) !important;
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
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.9rem;
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
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .card-body {
            padding: 25px;
        }

        .card-footer {
            padding: 20px 25px;
            border-top: 1px solid var(--border);
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
        }

        @media (max-width: 768px) {
            .table {
                font-size: 0.85rem;
            }

            .table th,
            .table td {
                padding: 10px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        const el = document.getElementById('sortable-pages');
        if (el) {
            const sortable = Sortable.create(el, {
                handle: '.drag-handle',
                animation: 150,
                onEnd: function(evt) {
                    const items = [];
                    document.querySelectorAll('#sortable-pages tr[data-id]').forEach((row, index) => {
                        items.push(row.dataset.id);
                    });

                    fetch('{{ route('admin.pages.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            items: items
                        })
                    });
                }
            });
        }
    </script>
@endpush
