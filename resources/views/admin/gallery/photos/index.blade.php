@extends('admin.layouts.app')

@section('title', 'Gallery Photos')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Gallery Photos</h1>
                <p class="page-subtitle">Kelola foto & video galeri</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.gallery.albums.index') }}" class="btn btn-secondary">
                    <i class="fas fa-folder"></i>
                    Kelola Album
                </a>
                <button type="button" class="btn btn-success"
                    onclick="document.getElementById('bulkUploadModal').style.display='flex'">
                    <i class="fas fa-images"></i>
                    Upload Multiple
                </button>
                <a href="{{ route('admin.gallery.photos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Tambah Foto
                </a>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-section">
        <form method="GET" action="{{ route('admin.gallery.photos.index') }}"
            style="display: flex; gap: 15px; flex-wrap: wrap;">
            <select name="album" class="form-control" style="width: 250px;" onchange="this.form.submit()">
                <option value="">Semua Album</option>
                @foreach ($albums as $album)
                    <option value="{{ $album->id }}" {{ request('album') == $album->id ? 'selected' : '' }}>
                        {{ $album->name }} ({{ $album->galleries_count }})
                    </option>
                @endforeach
            </select>

            <select name="type" class="form-control" style="width: 150px;" onchange="this.form.submit()">
                <option value="">Semua Tipe</option>
                <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Image</option>
                <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
            </select>

            @if (request('album') || request('type'))
                <a href="{{ route('admin.gallery.photos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Reset Filter
                </a>
            @endif
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Foto</h3>
            <div class="card-tools">
                <span class="badge">{{ $galleries->total() }} Total</span>
            </div>
        </div>
        <div class="card-body">
            @if ($galleries->count() > 0)
                <div class="photos-grid">
                    @foreach ($galleries as $photo)
                        <div class="photo-card">
                            <!-- Photo Image -->
                            <div class="photo-image">
                                @if ($photo->image)
                                    <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif

                                <!-- Badges -->
                                <div class="photo-badges">
                                    @if ($photo->is_featured)
                                        <span class="badge badge-warning">
                                            <i class="fas fa-star"></i>
                                        </span>
                                    @endif
                                    <span class="badge badge-{{ $photo->is_active ? 'success' : 'danger' }}">
                                        {{ $photo->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>

                                @if ($photo->type == 'video')
                                    <div class="video-badge">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Photo Info -->
                            <div class="photo-info">
                                <h4 class="photo-title">{{ $photo->title }}</h4>
                                <p class="photo-album">
                                    <i class="fas fa-folder"></i>
                                    {{ $photo->album ? $photo->album->name : 'Tanpa Album' }}
                                </p>

                                @if ($photo->description)
                                    <p class="photo-description">{{ Str::limit($photo->description, 60) }}</p>
                                @endif

                                <!-- Actions -->
                                <div class="photo-actions">
                                    <form action="{{ route('admin.gallery.photos.toggle', $photo) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn-action btn-status {{ $photo->is_active ? 'active' : '' }}"
                                            title="{{ $photo->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas fa-{{ $photo->is_active ? 'eye' : 'eye-slash' }}"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.gallery.photos.edit', $photo) }}" class="btn-action btn-edit"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.gallery.photos.destroy', $photo) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
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
                    {{ $galleries->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-images"></i>
                    <h3>Belum Ada Foto</h3>
                    <p>Mulai upload foto untuk galeri</p>
                    <a href="{{ route('admin.gallery.photos.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Upload Foto Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Bulk Upload Modal -->
    <div id="bulkUploadModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Upload Multiple Photos</h3>
                <button type="button" class="close-modal"
                    onclick="document.getElementById('bulkUploadModal').style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.gallery.photos.bulk-upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bulk_album">Pilih Album <span class="required">*</span></label>
                        <select name="album_id" id="bulk_album" class="form-control" required>
                            <option value="">-- Pilih Album --</option>
                            @foreach ($albums as $album)
                                <option value="{{ $album->id }}">{{ $album->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bulk_images">Upload Foto (Max 20 foto) <span class="required">*</span></label>
                        <input type="file" name="images[]" id="bulk_images" class="form-control-file"
                            accept="image/*" multiple required>
                        <small class="form-text">Maksimal 5MB per foto</small>
                    </div>

                    <div id="preview-container"
                        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; margin-top: 15px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        onclick="document.getElementById('bulkUploadModal').style.display='none'">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i>
                        Upload Semua
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .filter-section {
            background: white;
            padding: 20px 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

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

        .badge-warning {
            background: var(--warning);
            color: white;
        }

        .photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .photo-card {
            background: white;
            border: 2px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .photo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-color: var(--primary);
        }

        .photo-image {
            width: 100%;
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .photo-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .photo-card:hover .photo-image img {
            transform: scale(1.1);
        }

        .no-image {
            width: 100%;
            height: 100%;
            background: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 2rem;
        }

        .photo-badges {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 5px;
            flex-direction: column;
            align-items: flex-end;
        }

        .video-badge {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }

        .photo-info {
            padding: 15px;
        }

        .photo-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark);
            line-height: 1.4;
        }

        .photo-album {
            font-size: 0.85rem;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .photo-album i {
            margin-right: 5px;
        }

        .photo-description {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .photo-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }

        .btn-action {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
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

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .form-control {
            padding: 10px 15px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .d-inline {
            display: inline;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #9ca3af;
        }

        .close-modal:hover {
            color: var(--danger);
        }

        .modal-body {
            padding: 25px;
        }

        .modal-footer {
            padding: 20px 25px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .required {
            color: var(--danger);
        }

        .form-text {
            font-size: 0.85rem;
            color: #9ca3af;
            margin-top: 5px;
            display: block;
        }

        @media (max-width: 768px) {
            .photos-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Preview multiple images
        document.getElementById('bulk_images')?.addEventListener('change', function(e) {
            const container = document.getElementById('preview-container');
            container.innerHTML = '';

            const files = Array.from(e.target.files);
            files.forEach(file => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.style.width = '100%';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    container.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('bulkUploadModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
@endpush
