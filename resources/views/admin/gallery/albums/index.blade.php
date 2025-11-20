@extends('admin.layouts.app')

@section('title', 'Gallery Albums')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Gallery Albums</h1>
                <p class="page-subtitle">Kelola album foto & video kegiatan</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.gallery.photos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-images"></i>
                    Kelola Foto
                </a>
                <a href="{{ route('admin.gallery.albums.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Tambah Album
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Album</h3>
            <div class="card-tools">
                <span class="badge">{{ $albums->total() }} Total</span>
            </div>
        </div>
        <div class="card-body">
            @if ($albums->count() > 0)
                <div class="albums-grid">
                    @foreach ($albums as $album)
                        <div class="album-card">
                            <!-- Cover Image -->
                            <div class="album-cover">
                                @if ($album->cover_image)
                                    <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->name }}">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-images"></i>
                                    </div>
                                @endif

                                <!-- Status Badge -->
                                <div class="album-status">
                                    <span class="badge badge-{{ $album->is_active ? 'success' : 'danger' }}">
                                        {{ $album->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>

                                <!-- Photo Count -->
                                <div class="photo-count">
                                    <i class="fas fa-images"></i>
                                    <span>{{ $album->galleries_count }} Foto</span>
                                </div>
                            </div>

                            <!-- Album Info -->
                            <div class="album-info">
                                <h3 class="album-title">{{ $album->name }}</h3>

                                @if ($album->description)
                                    <p class="album-description">{{ Str::limit($album->description, 80) }}</p>
                                @endif

                                <div class="album-meta">
                                    @if ($album->event_date)
                                        <span><i class="fas fa-calendar"></i>
                                            {{ $album->event_date->format('d M Y') }}</span>
                                    @endif
                                    @if ($album->location)
                                        <span><i class="fas fa-map-marker-alt"></i> {{ $album->location }}</span>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="album-actions">
                                    <a href="{{ route('admin.gallery.photos.index', ['album' => $album->id]) }}"
                                        class="btn-action btn-view" title="Lihat Foto">
                                        <i class="fas fa-images"></i>
                                    </a>

                                    <form action="{{ route('admin.gallery.albums.toggle', $album) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn-action btn-status {{ $album->is_active ? 'active' : '' }}"
                                            title="{{ $album->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas fa-{{ $album->is_active ? 'eye' : 'eye-slash' }}"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.gallery.albums.edit', $album) }}" class="btn-action btn-edit"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.gallery.albums.destroy', $album) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus album ini beserta semua foto di dalamnya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="card-footer">
                    {{ $albums->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-images"></i>
                    <h3>Belum Ada Album</h3>
                    <p>Mulai tambahkan album foto kegiatan</p>
                    <a href="{{ route('admin.gallery.albums.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Tambah Album Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .card-tools {
            display: flex;
            gap: 10px;
        }

        .card-body {
            padding: 25px;
        }

        .card-footer {
            padding: 20px 25px;
            border-top: 1px solid var(--border);
        }

        .badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: var(--success);
            color: white;
        }

        .badge-danger {
            background: var(--danger);
            color: white;
        }

        .albums-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .album-card {
            background: white;
            border: 2px solid var(--border);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .album-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-color: var(--primary);
        }

        .album-cover {
            width: 100%;
            height: 220px;
            position: relative;
            overflow: hidden;
        }

        .album-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .album-card:hover .album-cover img {
            transform: scale(1.1);
        }

        .no-image {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .album-status {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .photo-count {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .album-info {
            padding: 20px;
        }

        .album-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--dark);
            line-height: 1.4;
        }

        .album-description {
            color: #6b7280;
            margin-bottom: 12px;
            line-height: 1.6;
            font-size: 0.9rem;
        }

        .album-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 15px;
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .album-meta i {
            margin-right: 5px;
            width: 16px;
        }

        .album-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            padding-top: 15px;
            border-top: 1px solid var(--border);
        }

        .btn-action {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-view {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-view:hover {
            background: #3b82f6;
            color: white;
        }

        .btn-status {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-status.active {
            background: #d1fae5;
            color: #059669;
        }

        .btn-status:hover {
            transform: scale(1.1);
        }

        .btn-edit {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-edit:hover {
            background: #3b82f6;
            color: white;
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        .empty-state {
            padding: 80px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 4rem;
            color: #e5e7eb;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .empty-state p {
            color: #9ca3af;
            margin-bottom: 25px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 83, 197, 0.3);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .d-inline {
            display: inline;
        }

        @media (max-width: 768px) {
            .albums-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

