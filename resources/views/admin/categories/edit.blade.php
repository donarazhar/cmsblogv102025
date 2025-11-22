@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Category</h1>
        <div class="breadcrumb">
            <a href="{{ route('admin.categories.index') }}">Categories</a>
            <span>/</span>
            <span>Edit</span>
        </div>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 20px;">
            <!-- Main Content -->
            <div>
                <!-- Basic Info Card -->
                <div class="card">
                    <div class="card-header">
                        <h3>Informasi Dasar</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Category <span class="required">*</span></label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}" required placeholder="Masukkan nama category">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" id="slug" name="slug"
                                class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug', $category->slug) }}" placeholder="akan-otomatis-dibuat-dari-nama">
                            <small class="form-text">Kosongkan untuk generate otomatis dari nama</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                rows="5" placeholder="Deskripsi category (opsional)">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div class="form-group">
                                <label for="order">Order</label>
                                <input type="number" id="order" name="order"
                                    class="form-control @error('order') is-invalid @enderror"
                                    value="{{ old('order', $category->order) }}" min="0">
                                <small class="form-text">Urutan tampilan category</small>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="parent_id">Parent Category</label>
                                <select id="parent_id" name="parent_id"
                                    class="form-control @error('parent_id') is-invalid @enderror">
                                    <option value="">None (Parent Category)</option>
                                    @foreach ($parentCategories as $parent)
                                        <option value="{{ $parent->id }}"
                                            {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appearance Card -->
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        <h3>Tampilan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="image">Category Image</label>

                            @if ($category->image)
                                <div style="margin-bottom: 15px; position: relative;">
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                        style="max-width: 200px; border-radius: 8px; display: block;">
                                    <div style="margin-top: 10px;">
                                        <a href="{{ route('admin.categories.remove-image', $category) }}"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus gambar ini?')">
                                            <i class="fas fa-trash"></i> Hapus Gambar
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <input type="file" id="image" name="image"
                                class="form-control @error('image') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/webp">
                            <small class="form-text">Format: JPEG, PNG, JPG, WEBP. Maksimal: 2MB</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreview" style="margin-top: 15px; display: none;">
                                <img id="preview" src="" alt="Preview"
                                    style="max-width: 200px; border-radius: 8px;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px;">
                            <div class="form-group">
                                <label for="icon">Icon Class (Font Awesome)</label>
                                <input type="text" id="icon" name="icon"
                                    class="form-control @error('icon') is-invalid @enderror"
                                    value="{{ old('icon', $category->icon) }}" placeholder="fas fa-folder">
                                <small class="form-text">Contoh: fas fa-folder, fas fa-book, fas fa-star</small>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="color">Warna</label>
                                <input type="color" id="color" name="color"
                                    class="form-control @error('color') is-invalid @enderror"
                                    value="{{ old('color', $category->color) }}" style="height: 45px;">
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="iconPreview"
                            style="margin-top: 15px; padding: 20px; background: var(--light); border-radius: 8px; text-align: center;">
                            <div
                                style="width: 80px; height: 80px; background: {{ $category->color }}; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; color: white;">
                                <i id="previewIcon" class="{{ $category->icon ?: 'fas fa-folder' }}"
                                    style="font-size: 2rem;"></i>
                            </div>
                            <div style="margin-top: 10px; font-size: 0.9rem; color: #6b7280;">Preview Icon & Color</div>
                        </div>
                    </div>
                </div>

                <!-- SEO Card -->
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        <h3>SEO Settings</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title"
                                class="form-control @error('meta_title') is-invalid @enderror"
                                value="{{ old('meta_title', $category->meta_title) }}" placeholder="Judul untuk SEO">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea id="meta_description" name="meta_description"
                                class="form-control @error('meta_description') is-invalid @enderror" rows="3"
                                placeholder="Deskripsi untuk SEO">{{ old('meta_description', $category->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" id="meta_keywords" name="meta_keywords"
                                class="form-control @error('meta_keywords') is-invalid @enderror"
                                value="{{ old('meta_keywords', $category->meta_keywords) }}"
                                placeholder="keyword1, keyword2, keyword3">
                            <small class="form-text">Pisahkan dengan koma</small>
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Status Card -->
                <div class="card">
                    <div class="card-header">
                        <h3>Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input type="checkbox" id="is_active" name="is_active" class="form-check-input"
                                value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">
                                <i class="fas fa-check-circle"></i> Active
                            </label>
                        </div>
                        <small class="form-text" style="display: block; margin-top: 10px;">
                            Category yang tidak aktif tidak akan ditampilkan di frontend
                        </small>

                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border);">
                            <div style="background: var(--light); padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-size: 0.9rem; color: #6b7280;">Total Posts:</span>
                                    <strong>{{ $category->posts->count() }}</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-size: 0.9rem; color: #6b7280;">Sub Categories:</span>
                                    <strong>{{ $category->children->count() }}</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="font-size: 0.9rem; color: #6b7280;">Order:</span>
                                    <strong>{{ $category->order }}</strong>
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-primary" style="flex: 1;">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        <h3>Informasi</h3>
                    </div>
                    <div class="card-body">
                        <div style="font-size: 0.9rem; line-height: 1.6; color: #6b7280;">
                            <div style="margin-bottom: 15px;">
                                <div style="font-weight: 600; color: var(--dark); margin-bottom: 5px;">Created At</div>
                                <div>{{ $category->created_at->format('d M Y H:i') }}</div>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <div style="font-weight: 600; color: var(--dark); margin-bottom: 5px;">Last Updated</div>
                                <div>{{ $category->updated_at->format('d M Y H:i') }}</div>
                            </div>
                            @if ($category->parent)
                                <div>
                                    <div style="font-weight: 600; color: var(--dark); margin-bottom: 5px;">Parent Category
                                    </div>
                                    <div>{{ $category->parent->name }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark);
        }

        .required {
            color: var(--danger);
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }

        .form-text {
            display: block;
            margin-top: 5px;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .form-check-label {
            cursor: pointer;
            font-size: 0.95rem;
            margin: 0;
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

        textarea.form-control {
            resize: vertical;
            font-family: inherit;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto generate slug from name
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value;
            const slug = name.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            document.getElementById('slug').value = slug;
        });

        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // Icon preview
        document.getElementById('icon').addEventListener('input', function() {
            const iconClass = this.value || 'fas fa-folder';
            const previewIcon = document.getElementById('previewIcon');
            previewIcon.className = iconClass;
        });

        // Color preview
        document.getElementById('color').addEventListener('input', function() {
            const color = this.value;
            const previewBox = document.getElementById('iconPreview').querySelector('div');
            previewBox.style.background = color;
        });
    </script>
@endpush
