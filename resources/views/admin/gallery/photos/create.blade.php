@extends('admin.layouts.app')

@section('title', 'Tambah Foto Gallery')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Tambah Foto Gallery</h1>
                <div class="breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('admin.gallery.photos.index') }}">Gallery Photos</a>
                    <span>/</span>
                    <span>Tambah</span>
                </div>
            </div>
            <a href="{{ route('admin.gallery.photos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('admin.gallery.photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Foto</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul Foto <span class="required">*</span></label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                required placeholder="Masukkan judul foto">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror" placeholder="Deskripsi foto (opsional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type">Tipe <span class="required">*</span></label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror"
                                required onchange="toggleTypeFields()">
                                <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
                                <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="form-group" id="imageField">
                            <label for="image">Upload Foto <span class="required">*</span></label>
                            <div class="image-upload-wrapper">
                                <input type="file" name="image" id="image"
                                    class="form-control-file @error('image') is-invalid @enderror" accept="image/*"
                                    onchange="previewImage(this)">
                                <div class="image-preview" id="imagePreview">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Klik atau drag gambar ke sini</p>
                                    <small>Maksimal 5MB (JPEG, PNG, JPG, WEBP)</small>
                                </div>
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Video URL -->
                        <div class="form-group" id="videoField" style="display: none;">
                            <label for="video_url">URL Video YouTube/Vimeo <span class="required">*</span></label>
                            <input type="url" name="video_url" id="video_url"
                                class="form-control @error('video_url') is-invalid @enderror"
                                value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                            <small class="form-text">Masukkan URL video dari YouTube atau Vimeo</small>
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengaturan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="album_id">Album <span class="required">*</span></label>
                            <select name="album_id" id="album_id"
                                class="form-control @error('album_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Album --</option>
                                @foreach ($albums as $album)
                                    <option value="{{ $album->id }}"
                                        {{ old('album_id') == $album->id ? 'selected' : '' }}>
                                        {{ $album->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('album_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="order">Urutan</label>
                            <input type="number" name="order" id="order"
                                class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}"
                                min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr style="margin: 20px 0;">

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_featured" value="1"
                                    {{ old('is_featured') ? 'checked' : '' }}>
                                <span>Featured</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', 1) ? 'checked' : '' }}>
                                <span>Active</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">
                            <i class="fas fa-save"></i>
                            Simpan Foto
                        </button>
                        <a href="{{ route('admin.gallery.photos.index') }}" class="btn btn-secondary"
                            style="width: 100%;">
                            <i class="fas fa-times"></i>
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

        .form-control,
        .form-control-file {
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
            font-size: 0.85rem;
            color: #9ca3af;
            margin-top: 5px;
            display: block;
        }

        textarea.form-control {
            resize: vertical;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-weight: 500;
        }

        .checkbox-label input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .image-upload-wrapper {
            position: relative;
        }

        .form-control-file {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }

        .image-preview {
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            background: var(--light);
            transition: all 0.3s ease;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .image-preview:hover {
            border-color: var(--primary);
            background: rgba(0, 83, 197, 0.05);
        }

        .image-preview i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .image-preview p {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .image-preview small {
            color: #9ca3af;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            object-fit: cover;
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

@push('scripts')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function toggleTypeFields() {
            const type = document.getElementById('type').value;
            const imageField = document.getElementById('imageField');
            const videoField = document.getElementById('videoField');

            if (type === 'video') {
                imageField.style.display = 'none';
                videoField.style.display = 'block';
                document.getElementById('image').removeAttribute('required');
                document.getElementById('video_url').setAttribute('required', 'required');
            } else {
                imageField.style.display = 'block';
                videoField.style.display = 'none';
                document.getElementById('image').setAttribute('required', 'required');
                document.getElementById('video_url').removeAttribute('required');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleTypeFields();
        });
    </script>
@endpush
