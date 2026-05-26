@extends('admin.layouts.app')

@section('title', 'Edit Popup Iklan')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Edit Popup Iklan</h1>
                <div class="breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('admin.popup-ads.index') }}">Popup Iklan</a>
                    <span>/</span>
                    <span>Edit</span>
                </div>
            </div>
            <a href="{{ route('admin.popup-ads.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; border: 1px solid #f87171; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.popup-ads.update', $popupAd) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Left Column -->
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Popup</h3>
                    </div>
                    <div class="card-body">
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">Judul <span class="required">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $popupAd->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Subtitle -->
                        <div class="form-group">
                            <label for="subtitle">Subtitle</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $popupAd->subtitle) }}">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="form-group">
                            <label for="banner_image">Gambar Banner</label>
                            <div class="image-upload-wrapper">
                                <input type="file" name="banner_image" id="banner_image" class="form-control-file @error('banner_image') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
                                <div class="image-preview" id="imagePreview">
                                    @if($popupAd->banner_image)
                                        <img src="{{ asset('storage/' . $popupAd->banner_image) }}" alt="Preview">
                                    @else
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p>Klik atau drag gambar banner ke sini</p>
                                    @endif
                                    <small>Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                    <small style="color: var(--primary); font-weight: 500; display: block; margin-top: 5px;">
                                        Rekomendasi Ukuran: 1040 x 1040 px (Square) atau 1040 x 780 px (Landscape 4:3)
                                    </small>
                                </div>
                            </div>
                            @error('banner_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Aksi Klik (Pilih Salah Satu)</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- PDF Upload -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="pdf_file">Upload File PDF Baru</label>
                                    <input type="file" name="pdf_file" id="pdf_file" class="form-control @error('pdf_file') is-invalid @enderror" accept=".pdf">
                                    @if($popupAd->pdf_file)
                                        <div style="margin-top: 10px; padding: 10px; background: #f3f4f6; border-radius: 6px; display: flex; align-items: center; justify-content: space-between;">
                                            <div>
                                                <i class="fas fa-file-pdf" style="color: #dc2626; margin-right: 5px;"></i>
                                                <a href="{{ asset('storage/' . $popupAd->pdf_file) }}" target="_blank" style="color: #4b5563; text-decoration: none;">Lihat PDF Saat Ini</a>
                                            </div>
                                            <label style="margin: 0; display: flex; align-items: center; gap: 5px; cursor: pointer;">
                                                <input type="checkbox" name="remove_pdf_file" value="1">
                                                <span style="color: #dc2626; font-size: 0.85rem;">Hapus File</span>
                                            </label>
                                        </div>
                                    @endif
                                    <small class="form-text">Biarkan kosong jika tidak ingin mengubah file PDF.</small>
                                    @error('pdf_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- External Link -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="external_link">Atau Link Eksternal</label>
                                    <input type="url" name="external_link" id="external_link" class="form-control @error('external_link') is-invalid @enderror" value="{{ old('external_link', $popupAd->external_link) }}" placeholder="https://example.com">
                                    <small class="form-text">Gunakan ini jika ingin mengarahkan ke halaman web lain.</small>
                                    @error('external_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengaturan Tampil</h3>
                    </div>
                    <div class="card-body">
                        <!-- Active Status -->
                        <div class="form-group">
                            <label class="switch">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $popupAd->is_active) ? 'checked' : '' }}>
                                <span class="slider-switch"></span>
                            </label>
                            <label style="margin-left: 10px; display: inline-block; vertical-align: super;">Aktifkan Popup</label>
                        </div>

                        <!-- Order -->
                        <div class="form-group">
                            <label for="order">Urutan Prioritas</label>
                            <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $popupAd->order) }}" min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Show Delay -->
                        <div class="form-group">
                            <label for="show_delay">Delay Muncul (milidetik) <span class="required">*</span></label>
                            <input type="number" name="show_delay" id="show_delay" class="form-control @error('show_delay') is-invalid @enderror" value="{{ old('show_delay', $popupAd->show_delay) }}" min="0" required>
                            @error('show_delay')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Target Routes -->
                        <div class="form-group">
                            <label for="target_routes">Target Halaman (Spesifik Route)</label>
                            <input type="text" name="target_routes" id="target_routes" class="form-control @error('target_routes') is-invalid @enderror" value="{{ old('target_routes', $popupAd->target_routes) }}" placeholder="Misal: /programs, /berita/*">
                            <small class="form-text">Biarkan kosong agar popup tampil di semua halaman. Gunakan koma (,) untuk memisahkan beberapa URL. Anda juga bisa menggunakan wildcard (*).</small>
                            @error('target_routes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jadwal Tampil (Opsional)</h3>
                    </div>
                    <div class="card-body">
                        <!-- Start Date -->
                        <div class="form-group">
                            <label for="start_date">Mulai Tampil</label>
                            <input type="datetime-local" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $popupAd->start_date ? $popupAd->start_date->format('Y-m-d\TH:i') : '') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div class="form-group">
                            <label for="end_date">Selesai Tampil</label>
                            <input type="datetime-local" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $popupAd->end_date ? $popupAd->end_date->format('Y-m-d\TH:i') : '') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">
                            <i class="fas fa-save"></i>
                            Update Popup
                        </button>
                        <a href="{{ route('admin.popup-ads.index') }}" class="btn btn-secondary" style="width: 100%;">
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
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .col-8 { flex: 0 0 66.666667%; max-width: 66.666667%; padding: 0 10px; }
        .col-4 { flex: 0 0 33.333333%; max-width: 33.333333%; padding: 0 10px; }
        .col-6 { flex: 0 0 50%; max-width: 50%; padding: 0 10px; }

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

        .form-control, .form-control-file {
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

        /* Image Upload */
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

        .image-preview img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            object-fit: contain;
        }

        /* Switch Toggle */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider-switch {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider-switch:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked+.slider-switch {
            background-color: var(--success);
        }

        input:checked+.slider-switch:before {
            transform: translateX(24px);
        }

        /* Buttons */
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

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 83, 197, 0.3); }
        .btn-secondary { background: #6b7280; color: white; }
        .btn-secondary:hover { background: #4b5563; }

        @media (max-width: 1024px) {
            .col-8, .col-4, .col-6 { flex: 0 0 100%; max-width: 100%; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Image Preview
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
    </script>
@endpush
