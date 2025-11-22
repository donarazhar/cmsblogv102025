@extends('admin.layouts.app')

@section('title', 'Edit Halaman')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Halaman</h1>
        <p class="page-subtitle">Perbarui informasi halaman website</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.pages.index') }}">Halaman</a>
            <span>/</span>
            <span>Edit</span>
        </div>
    </div>

    <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <!-- Main Content -->
            <div class="form-main">
                <!-- Basic Info Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Dasar</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title" class="form-label required">Judul Halaman</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $page->title) }}" required autofocus>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Judul akan otomatis generate slug URL</small>
                        </div>

                        <div class="form-group">
                            <label for="slug" class="form-label">Slug URL</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-link"></i>
                                </span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                    id="slug" name="slug" value="{{ old('slug', $page->slug) }}"
                                    placeholder="otomatis-dari-judul">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text">Kosongkan untuk generate otomatis dari judul</small>
                        </div>

                        <div class="form-group">
                            <label for="content" class="form-label required">Konten</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="15"
                                required>{{ old('content', $page->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Gunakan HTML untuk formatting konten</small>
                        </div>
                    </div>
                </div>

                <!-- Featured Image Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-image"></i>
                            Gambar Unggulan
                        </h3>
                    </div>
                    <div class="card-body">
                        @if ($page->featured_image)
                            <div class="current-image">
                                <img src="{{ Storage::url($page->featured_image) }}" alt="{{ $page->title }}">
                                <div class="image-actions">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeCurrentImage()">
                                        <i class="fas fa-trash"></i> Hapus Gambar
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="featured_image" class="form-label">
                                {{ $page->featured_image ? 'Ganti Gambar' : 'Upload Gambar' }}
                            </label>
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                id="featured_image" name="featured_image" accept="image/*" onchange="previewImage(this)">
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Format: JPG, PNG, WEBP. Max: 2MB</small>
                        </div>

                        <div id="imagePreview" class="image-preview" style="display: none;">
                            <img id="preview" src="" alt="Preview">
                            <button type="button" class="btn-remove-preview" onclick="removePreview()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SEO Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-search"></i>
                            SEO Meta Tags
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
                                maxlength="255">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Kosongkan untuk menggunakan judul halaman</small>
                        </div>

                        <div class="form-group">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
                                name="meta_description" rows="3" maxlength="500">{{ old('meta_description', $page->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Deskripsi singkat untuk search engine (max 500 karakter)</small>
                        </div>

                        <div class="form-group">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                id="meta_keywords" name="meta_keywords"
                                value="{{ old('meta_keywords', $page->meta_keywords) }}"
                                placeholder="masjid, al azhar, bekasi">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Pisahkan dengan koma</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="form-sidebar">
                <!-- Publish Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-paper-plane"></i>
                            Publikasi
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status" class="form-label required">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status"
                                name="status" required>
                                <option value="draft" {{ old('status', $page->status) == 'draft' ? 'selected' : '' }}>
                                    Draft</option>
                                <option value="published"
                                    {{ old('status', $page->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="private" {{ old('status', $page->status) == 'private' ? 'selected' : '' }}>
                                    Private</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror>
                        </div>

                        <div class="status-info">
                            <div class="status-item">
                                <i class="fas fa-circle" style="color: #10b981;"></i>
                                <span><strong>Published:</strong> Terlihat publik</span>
                            </div>
                            <div class="status-item">
                                <i class="fas fa-circle" style="color: #f59e0b;"></i>
                                <span><strong>Draft:</strong> Belum dipublikasi</span>
                            </div>
                            <div class="status-item">
                                <i class="fas fa-circle" style="color: #6b7280;"></i>
                                <span><strong>Private:</strong> Hanya admin</span>
                            </div>
                        </div>

                        <div class="page-info">
                            <div class="info-item">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Dibuat: {{ $page->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-calendar-check"></i>
                                <span>Diperbarui: {{ $page->updated_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Template Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-palette"></i>
                            Template Layout
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="template" class="form-label required">Template</label>
                            <select class="form-select @error('template') is-invalid @enderror" id="template"
                                name="template" required>
                                <option value="default"
                                    {{ old('template', $page->template) == 'default' ? 'selected' : '' }}>
                                    Default</option>
                                <option value="full-width"
                                    {{ old('template', $page->template) == 'full-width' ? 'selected' : '' }}>Full Width
                                </option>
                                <option value="sidebar-left"
                                    {{ old('template', $page->template) == 'sidebar-left' ? 'selected' : '' }}>Sidebar Left
                                </option>
                                <option value="sidebar-right"
                                    {{ old('template', $page->template) == 'sidebar-right' ? 'selected' : '' }}>Sidebar
                                    Right</option>
                                <option value="contact"
                                    {{ old('template', $page->template) == 'contact' ? 'selected' : '' }}>Contact</option>
                                <option value="about"
                                    {{ old('template', $page->template) == 'about' ? 'selected' : '' }}>
                                    About</option>
                            </select>
                            @error('template')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="template-preview">
                            <div class="template-box" data-template="default">
                                <i class="fas fa-th-large"></i>
                                <span>Default</span>
                            </div>
                            <div class="template-box" data-template="full-width">
                                <i class="fas fa-window-maximize"></i>
                                <span>Full Width</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hierarchy Card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-sitemap"></i>
                            Hierarki Halaman
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="parent_id" class="form-label">Parent Halaman</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id"
                                name="parent_id">
                                <option value="">Tidak ada parent</option>
                                @foreach ($parentPages as $parent)
                                    <option value="{{ $parent->id }}"
                                        {{ old('parent_id', $page->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Jadikan sebagai sub-halaman</small>
                        </div>

                        @if ($page->children->count() > 0)
                            <div class="children-info">
                                <strong>Sub-halaman:</strong>
                                <ul>
                                    @foreach ($page->children as $child)
                                        <li>
                                            <i class="fas fa-angle-right"></i>
                                            {{ $child->title }}
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
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="show_in_menu" name="show_in_menu"
                                value="1" {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_in_menu">
                                Tampilkan di Menu
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="menu_order" class="form-label">Urutan Menu</label>
                            <input type="number" class="form-control @error('menu_order') is-invalid @enderror"
                                id="menu_order" name="menu_order" value="{{ old('menu_order', $page->menu_order) }}"
                                min="0">
                            @error('menu_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text">Kosongkan untuk urutan otomatis</small>
                        </div>

                        <div class="form-group">
                            <label for="icon" class="form-label">Icon (Font Awesome)</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    @if ($page->icon)
                                        <i class="{{ $page->icon }}"></i>
                                    @else
                                        <i class="fas fa-icons"></i>
                                    @endif
                                </span>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                    id="icon" name="icon" value="{{ old('icon', $page->icon) }}"
                                    placeholder="fas fa-home">
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text">
                                <a href="https://fontawesome.com/icons" target="_blank">Lihat icon</a>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save"></i>
                            Update Halaman
                        </button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-times"></i>
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Hidden form for image removal -->
    <form id="removeImageForm" action="{{ route('admin.pages.remove-image', $page) }}" method="POST"
        style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('styles')
    <style>
        .form-grid {
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .form-label.required::after {
            content: '*';
            color: var(--danger);
            margin-left: 4px;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            display: block;
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .form-text {
            display: block;
            margin-top: 5px;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .form-text a {
            color: var(--primary);
            text-decoration: none;
        }

        .form-text a:hover {
            text-decoration: underline;
        }

        .input-group {
            display: flex;
        }

        .input-group-text {
            background: var(--light);
            border: 1px solid var(--border);
            border-right: none;
            border-radius: 8px 0 0 8px;
            padding: 10px 15px;
            color: #6b7280;
        }

        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }

        .form-check-input {
            width: 45px;
            height: 24px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            margin-left: 10px;
            cursor: pointer;
            font-weight: 500;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .current-image {
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid var(--border);
        }

        .current-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .image-actions {
            padding: 10px;
            background: var(--light);
            text-align: center;
        }

        .image-preview {
            margin-top: 15px;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid var(--border);
        }

        .image-preview img {
            width: 100%;
            height: auto;
            display: block;
        }

        .btn-remove-preview {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--danger);
            color: white;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-remove-preview:hover {
            background: #dc2626;
            transform: scale(1.1);
        }

        .status-info {
            margin-top: 15px;
            padding: 15px;
            background: var(--light);
            border-radius: 8px;
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 0.85rem;
        }

        .status-item:last-child {
            margin-bottom: 0;
        }

        .status-item i {
            font-size: 0.6rem;
        }

        .page-info {
            margin-top: 15px;
            padding: 15px;
            background: #dbeafe;
            border-radius: 8px;
            border-left: 4px solid var(--info);
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 0.85rem;
            color: #1e40af;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-item i {
            width: 20px;
        }

        .template-preview {
            margin-top: 15px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .template-box {
            padding: 15px;
            border: 2px solid var(--border);
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .template-box:hover {
            border-color: var(--primary);
            background: var(--light);
        }

        .template-box i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 8px;
            display: block;
        }

        .template-box span {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--dark);
        }

        .children-info {
            margin-top: 15px;
            padding: 15px;
            background: var(--light);
            border-radius: 8px;
        }

        .children-info strong {
            display: block;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .children-info ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .children-info li {
            padding: 5px 0;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .children-info li i {
            color: var(--primary);
            margin-right: 5px;
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
            justify-content: center;
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

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.85rem;
        }

        .w-100 {
            width: 100%;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-sidebar {
                order: 2;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto-generate slug from title (only if slug is empty or matches old title)
        const originalTitle = "{{ $page->title }}";
        const originalSlug = "{{ $page->slug }}";

        document.getElementById('title').addEventListener('input', function() {
            const currentSlug = document.getElementById('slug').value;
            const title = this.value;

            // Only auto-generate if slug is empty or unchanged from original
            if (!currentSlug || currentSlug === originalSlug) {
                const slug = title.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim();
                document.getElementById('slug').value = slug;
            }
        });

        // Image preview
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Remove preview
        function removePreview() {
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('featured_image').value = '';
            document.getElementById('preview').src = '';
        }

        // Remove current image
        function removeCurrentImage() {
            if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                document.getElementById('removeImageForm').submit();
            }
        }

        // Template selection highlight
        document.getElementById('template').addEventListener('change', function() {
            const selected = this.value;
            document.querySelectorAll('.template-box').forEach(box => {
                box.style.borderColor = 'var(--border)';
                box.style.background = 'white';
            });

            const selectedBox = document.querySelector(`.template-box[data-template="${selected}"]`);
            if (selectedBox) {
                selectedBox.style.borderColor = 'var(--primary)';
                selectedBox.style.background = 'var(--light)';
            }
        });

        // Trigger on page load
        document.addEventListener('DOMContentLoaded', function() {
            const event = new Event('change');
            document.getElementById('template').dispatchEvent(event);
        });

        // Icon preview update
        document.getElementById('icon').addEventListener('input', function() {
            const iconClass = this.value;
            const iconPreview = document.querySelector('.input-group-text i');
            if (iconClass) {
                iconPreview.className = iconClass;
            } else {
                iconPreview.className = 'fas fa-icons';
            }
        });
    </script>
@endpush
