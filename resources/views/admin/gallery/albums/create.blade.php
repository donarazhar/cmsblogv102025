@extends('admin.layouts.app')

@section('title', 'Tambah Album')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Tambah Album</h1>
                <div class="breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('admin.gallery.albums.index') }}">Gallery Albums</a>
                    <span>/</span>
                    <span>Tambah</span>
                </div>
            </div>
            <a href="{{ route('admin.gallery.albums.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('admin.gallery.albums.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Album</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Album <span class="required">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required placeholder="Contoh: Ramadhan 1445 H">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug (URL)</label>
                            <input type="text" name="slug" id="slug"
                                class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}"
                                placeholder="akan dibuat otomatis jika kosong">
                            <small class="form-text">Kosongkan untuk generate otomatis dari nama</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror" placeholder="Deskripsi album (opsional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cover_image">Cover Image</label>
                            <div class="image-upload-wrapper">
                                <input type="file" name="cover_image" id="cover_image"
                                    class="form-control-file @error('cover_image') is-invalid @enderror" accept="image/*"
                                    onchange="previewImage(this)">
                                <div class="image-preview" id="imagePreview">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Klik atau drag gambar ke sini</p>
                                    <small>Maksimal 2MB (JPEG, PNG, JPG, WEBP)</small>
                                </div>
                            </div>
                            @error('cover_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Event</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="event_date">Tanggal Event</label>
                            <input type="date" name="event_date" id="event_date"
                                class="form-control @error('event_date') is-invalid @enderror"
                                value="{{ old('event_date') }}">
                            @error('event_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="location">Lokasi</label>
                            <input type="text" name="location" id="location"
                                class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}"
                                placeholder="Lokasi kegiatan">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', 1) ? 'checked' : '' }}>
                                <span>Album Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">
                            <i class="fas fa-save"></i>
                            Simpan Album
                        </button>
                        <a href="{{ route('admin.gallery.albums.index') }}" class="btn btn-secondary" style="width: 100%;">
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

        document.getElementById('name').addEventListener('input', function() {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug').value = slug;
        });
    </script>
@endpush
