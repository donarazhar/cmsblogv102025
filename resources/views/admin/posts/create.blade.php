@extends('admin.layouts.app')

@section('title', 'Tambah Post Baru')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Tambah Post Baru</h1>
        <div class="breadcrumb">
            <a href="{{ route('admin.posts.index') }}">Posts</a>
            <span>/</span>
            <span>Tambah Baru</span>
        </div>
    </div>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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
                            <label for="title">Judul Post <span class="required">*</span></label>
                            <input type="text" id="title" name="title"
                                class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                required placeholder="Masukkan judul post">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" id="slug" name="slug"
                                class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}"
                                placeholder="akan-otomatis-dibuat-dari-judul">
                            <small class="form-text">Kosongkan untuk generate otomatis dari judul</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="excerpt">Excerpt</label>
                            <textarea id="excerpt" name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3"
                                placeholder="Ringkasan singkat post (opsional)">{{ old('excerpt') }}</textarea>
                            <small class="form-text">Maksimal 500 karakter</small>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Konten <span class="required">*</span></label>
                            <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="15"
                                required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Featured Media Card -->
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        <h3>Featured Media</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="featured_image">Featured Image</label>
                            <input type="file" id="featured_image" name="featured_image"
                                class="form-control @error('featured_image') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/webp">
                            <small class="form-text">Format: JPEG, PNG, JPG, WEBP. Maksimal: 2MB</small>
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreview" style="margin-top: 15px; display: none;">
                                <img id="preview" src="" alt="Preview"
                                    style="max-width: 100%; border-radius: 8px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="featured_video">Featured Video URL</label>
                            <input type="url" id="featured_video" name="featured_video"
                                class="form-control @error('featured_video') is-invalid @enderror"
                                value="{{ old('featured_video') }}" placeholder="https://youtube.com/watch?v=...">
                            <small class="form-text">YouTube atau Vimeo URL</small>
                            @error('featured_video')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                value="{{ old('meta_title') }}" placeholder="Judul untuk SEO">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea id="meta_description" name="meta_description"
                                class="form-control @error('meta_description') is-invalid @enderror" rows="3"
                                placeholder="Deskripsi untuk SEO">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" id="meta_keywords" name="meta_keywords"
                                class="form-control @error('meta_keywords') is-invalid @enderror"
                                value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2, keyword3">
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
                <!-- Publish Card -->
                <div class="card">
                    <div class="card-header">
                        <h3>Publish</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status">Status <span class="required">*</span></label>
                            <select id="status" name="status"
                                class="form-control @error('status') is-invalid @enderror" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published
                                </option>
                                <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled
                                </option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="publishedAtGroup" style="display: none;">
                            <label for="published_at">Tanggal Publish</label>
                            <input type="datetime-local" id="published_at" name="published_at"
                                class="form-control @error('published_at') is-invalid @enderror"
                                value="{{ old('published_at') }}">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="scheduledAtGroup" style="display: none;">
                            <label for="scheduled_at">Tanggal Jadwal</label>
                            <input type="datetime-local" id="scheduled_at" name="scheduled_at"
                                class="form-control @error('scheduled_at') is-invalid @enderror"
                                value="{{ old('scheduled_at') }}">
                            @error('scheduled_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="is_featured" name="is_featured" class="form-check-input"
                                value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label for="is_featured" class="form-check-label">
                                <i class="fas fa-star"></i> Featured Post
                            </label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="allow_comments" name="allow_comments" class="form-check-input"
                                value="1" {{ old('allow_comments', true) ? 'checked' : '' }}>
                            <label for="allow_comments" class="form-check-label">
                                <i class="fas fa-comments"></i> Allow Comments
                            </label>
                        </div>

                        <div
                            style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border); display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-primary" style="flex: 1;">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Category & Tags Card -->
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header">
                        <h3>Category & Tags</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category_id">Category <span class="required">*</span></label>
                            <select id="category_id" name="category_id"
                                class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="">Pilih Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post_type">Post Type <span class="required">*</span></label>
                            <select id="post_type" name="post_type"
                                class="form-control @error('post_type') is-invalid @enderror" required>
                                <option value="article" {{ old('post_type') == 'article' ? 'selected' : '' }}>Article
                                </option>
                                <option value="news" {{ old('post_type') == 'news' ? 'selected' : '' }}>News</option>
                                <option value="announcement" {{ old('post_type') == 'announcement' ? 'selected' : '' }}>
                                    Announcement</option>
                                <option value="event" {{ old('post_type') == 'event' ? 'selected' : '' }}>Event</option>
                            </select>
                            @error('post_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Tags</label>
                            <div
                                style="max-height: 200px; overflow-y: auto; border: 1px solid var(--border); border-radius: 8px; padding: 10px;">
                                @foreach ($tags as $tag)
                                    <div class="form-check">
                                        <input type="checkbox" id="tag_{{ $tag->id }}" name="tags[]"
                                            class="form-check-input" value="{{ $tag->id }}"
                                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                        <label for="tag_{{ $tag->id }}" class="form-check-label">
                                            {{ $tag->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
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

        textarea.form-control {
            resize: vertical;
            font-family: inherit;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto generate slug from title
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value;
            const slug = title.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            document.getElementById('slug').value = slug;
        });

        // Image preview
        document.getElementById('featured_image').addEventListener('change', function(e) {
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

        // Show/hide date fields based on status
        document.getElementById('status').addEventListener('change', function() {
            const status = this.value;
            const publishedAtGroup = document.getElementById('publishedAtGroup');
            const scheduledAtGroup = document.getElementById('scheduledAtGroup');

            publishedAtGroup.style.display = 'none';
            scheduledAtGroup.style.display = 'none';

            if (status === 'published') {
                publishedAtGroup.style.display = 'block';
            } else if (status === 'scheduled') {
                scheduledAtGroup.style.display = 'block';
            }
        });

        // Trigger on page load
        document.getElementById('status').dispatchEvent(new Event('change'));
    </script>
@endpush
