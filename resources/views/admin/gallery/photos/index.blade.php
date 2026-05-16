@extends('admin.layouts.app')

@section('title', 'Gallery Photos')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h1 class="page-title">Gallery Photos</h1>
                <p class="page-subtitle">Kelola foto & video galeri</p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
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

    <!-- Table Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Foto & Video</h3>
            <div class="card-tools">
                <span class="badge" style="background: var(--primary); color: white;">{{ $galleries->total() }} Total</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Judul</th>
                            <th width="20%">Album</th>
                            <th width="10%">Tipe</th>
                            <th width="10%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($galleries as $photo)
                            <tr>
                                <td>{{ $galleries->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="gallery-title-cell">
                                        @if ($photo->image)
                                            <div class="gallery-thumb-container">
                                                <img src="{{ asset('storage/' . $photo->image) }}"
                                                    alt="{{ $photo->title }}" class="gallery-thumb">
                                                @if ($photo->type == 'video')
                                                    <div class="video-overlay-icon">
                                                        <i class="fas fa-play-circle"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="gallery-thumb-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ Str::limit($photo->title, 50) }}</strong>
                                            <div class="gallery-badges">
                                                @if ($photo->is_featured)
                                                    <span class="badge badge-sm badge-warning">
                                                        <i class="fas fa-star"></i> Featured
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge" style="background: #f3e8ff; color: #6b21a8; font-weight: 500;">
                                        <i class="fas fa-folder"></i> {{ $photo->album ? $photo->album->name : 'Tanpa Album' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-type-{{ $photo->type }}">
                                        @if($photo->type == 'video')
                                            <i class="fas fa-video"></i>
                                        @else
                                            <i class="fas fa-image"></i>
                                        @endif
                                        {{ ucfirst($photo->type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-status-{{ $photo->is_active ? 'active' : 'inactive' }}">
                                        {{ $photo->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <!-- Toggle Status -->
                                        <form action="{{ route('admin.gallery.photos.toggle', $photo) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-action {{ $photo->is_active ? 'btn-success' : 'btn-secondary' }}" title="{{ $photo->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $photo->is_active ? 'eye' : 'eye-slash' }}"></i>
                                            </button>
                                        </form>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.gallery.photos.edit', $photo) }}" class="btn btn-sm btn-info btn-action" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.gallery.photos.destroy', $photo) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-action" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada foto</p>
                                    <a href="{{ route('admin.gallery.photos.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus"></i> Upload Foto Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($galleries->hasPages())
            <!-- Pagination -->
            <div style="margin-top: 20px; text-align:center; padding: 20px; border-top: 1px solid var(--border);">
                {{ $galleries->links('vendor.pagination.simple') }}
            </div>
        @endif
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
                        <select name="album_id" id="bulk_album" class="form-control" required style="width: 100%;">
                            <option value="">-- Pilih Album --</option>
                            @foreach ($albums as $album)
                                <option value="{{ $album->id }}">{{ $album->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bulk_images">Upload Foto (Max 20 foto) <span class="required">*</span></label>
                        <input type="file" name="images[]" id="bulk_images" class="form-control"
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
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            margin-bottom: 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .card-tools {
            display: flex;
            gap: 10px;
        }

        .card-body {
            padding: 20px;
        }

        /* Badge */
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

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-type-image {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-type-video {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Buttons */
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

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 6px;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .form-control {
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
        }

        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            background: var(--light);
            color: var(--dark);
            font-weight: 600;
            padding: 12px;
            border-bottom: 2px solid var(--border);
            font-size: 0.9rem;
            text-align: left;
        }

        .table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border);
        }

        .table tbody tr:hover {
            background: var(--light);
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Gallery specific styles */
        .gallery-title-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .gallery-thumb-container {
            position: relative;
            width: 60px;
            height: 60px;
            flex-shrink: 0;
        }

        .gallery-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid var(--border);
        }

        .video-overlay-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0,0,0,0.5);
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
        }

        .gallery-thumb-placeholder {
            width: 60px;
            height: 60px;
            background: var(--light);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 1.5rem;
            border: 2px solid var(--border);
            flex-shrink: 0;
        }

        .gallery-badges {
            display: flex;
            gap: 5px;
            margin-top: 5px;
            flex-wrap: wrap;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #6b7280;
        }

        .py-5 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .fa-3x {
            font-size: 3rem;
        }

        /* Pagination */
        nav[role="navigation"] {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination {
            display: flex;
            gap: 5px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li span,
        .pagination li a {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .pagination li a:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination li.active span {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination li.disabled span {
            color: #9ca3af;
            cursor: not-allowed;
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
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .modal-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #9ca3af;
        }

        .close-modal:hover {
            color: var(--danger);
        }

        .modal-body {
            padding: 20px 25px;
        }

        .modal-footer {
            padding: 15px 25px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            background: var(--light);
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
            .gallery-title-cell {
                flex-direction: column;
                align-items: flex-start;
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
