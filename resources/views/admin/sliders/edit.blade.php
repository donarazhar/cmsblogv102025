@extends('admin.layouts.app')

@section('title', 'Edit Slider')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Edit Slider</h1>
                <div class="breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('admin.sliders.index') }}">Sliders</a>
                    <span>/</span>
                    <span>Edit</span>
                </div>
            </div>
            <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Left Column -->
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Slider</h3>
                    </div>
                    <div class="card-body">
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">Judul <span class="required">*</span></label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $slider->title) }}" required placeholder="Masukkan judul slider">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Subtitle -->
                        <div class="form-group">
                            <label for="subtitle">Subtitle</label>
                            <input type="text" name="subtitle" id="subtitle"
                                class="form-control @error('subtitle') is-invalid @enderror"
                                value="{{ old('subtitle', $slider->subtitle) }}" placeholder="Masukkan subtitle (opsional)">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror" placeholder="Masukkan deskripsi slider (opsional)">{{ old('description', $slider->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="form-group">
                            <label for="image">Gambar Slider</label>
                            <div class="image-upload-wrapper">
                                <input type="file" name="image" id="image"
                                    class="form-control-file @error('image') is-invalid @enderror" accept="image/*"
                                    onchange="previewImage(this)">
                                <div class="image-preview" id="imagePreview">
                                    @if ($slider->image)
                                        <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}">
                                    @else
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p>Klik atau drag gambar ke sini</p>
                                        <small>Maksimal 2MB (JPEG, PNG, JPG, WEBP)</small>
                                    @endif
                                </div>
                            </div>
                            <small class="form-text">Kosongkan jika tidak ingin mengubah gambar</small>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Buttons Section -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Button Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Button 1 -->
                            <div class="col-6">
                                <h4 class="section-subtitle">Button Pertama</h4>
                                <div class="form-group">
                                    <label for="button_text">Text Button</label>
                                    <input type="text" name="button_text" id="button_text"
                                        class="form-control @error('button_text') is-invalid @enderror"
                                        value="{{ old('button_text', $slider->button_text) }}"
                                        placeholder="Contoh: Selengkapnya">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="button_link">Link Button</label>
                                    <input type="url" name="button_link" id="button_link"
                                        class="form-control @error('button_link') is-invalid @enderror"
                                        value="{{ old('button_link', $slider->button_link) }}"
                                        placeholder="https://example.com">
                                    @error('button_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Button 2 -->
                            <div class="col-6">
                                <h4 class="section-subtitle">Button Kedua (Opsional)</h4>
                                <div class="form-group">
                                    <label for="button_text_2">Text Button</label>
                                    <input type="text" name="button_text_2" id="button_text_2"
                                        class="form-control @error('button_text_2') is-invalid @enderror"
                                        value="{{ old('button_text_2', $slider->button_text_2) }}"
                                        placeholder="Contoh: Hubungi Kami">
                                    @error('button_text_2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="button_link_2">Link Button</label>
                                    <input type="url" name="button_link_2" id="button_link_2"
                                        class="form-control @error('button_link_2') is-invalid @enderror"
                                        value="{{ old('button_link_2', $slider->button_link_2) }}"
                                        placeholder="https://example.com">
                                    @error('button_link_2')
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
                <!-- Status & Order -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengaturan</h3>
                    </div>
                    <div class="card-body">
                        <!-- Active Status -->
                        <div class="form-group">
                            <label class="switch">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                                <span class="slider-switch"></span>
                            </label>
                            <label style="margin-left: 10px;">Aktifkan Slider</label>
                        </div>

                        <!-- Text Position -->
                        <div class="form-group">
                            <label for="text_position">Posisi Text <span class="required">*</span></label>
                            <select name="text_position" id="text_position"
                                class="form-control @error('text_position') is-invalid @enderror" required>
                                <option value="left"
                                    {{ old('text_position', $slider->text_position) == 'left' ? 'selected' : '' }}>Kiri
                                </option>
                                <option value="center"
                                    {{ old('text_position', $slider->text_position) == 'center' ? 'selected' : '' }}>Tengah
                                </option>
                                <option value="right"
                                    {{ old('text_position', $slider->text_position) == 'right' ? 'selected' : '' }}>Kanan
                                </option>
                            </select>
                            @error('text_position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Order -->
                        <div class="form-group">
                            <label for="order">Urutan</label>
                            <input type="number" name="order" id="order"
                                class="form-control @error('order') is-invalid @enderror"
                                value="{{ old('order', $slider->order) }}" min="0" placeholder="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Overlay Settings -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Overlay Settings</h3>
                    </div>
                    <div class="card-body">
                        <!-- Overlay Color -->
                        <div class="form-group">
                            <label for="overlay_color">Warna Overlay</label>
                            <div style="display: flex; gap: 10px; align-items: center;">
                                <input type="color" name="overlay_color" id="overlay_color" class="form-control-color"
                                    value="{{ old('overlay_color', $slider->overlay_color ?? '#000000') }}"
                                    style="width: 60px; height: 40px;">
                                <input type="text" id="overlay_color_text" class="form-control"
                                    value="{{ old('overlay_color', $slider->overlay_color ?? '#000000') }}" readonly>
                            </div>
                            @error('overlay_color')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Overlay Opacity -->
                        <div class="form-group">
                            <label for="overlay_opacity">Opacity Overlay (<span
                                    id="opacity_value">{{ old('overlay_opacity', $slider->overlay_opacity ?? 50) }}</span>%)</label>
                            <input type="range" name="overlay_opacity" id="overlay_opacity" class="form-range"
                                min="0" max="100"
                                value="{{ old('overlay_opacity', $slider->overlay_opacity ?? 50) }}"
                                oninput="document.getElementById('opacity_value').textContent = this.value">
                            @error('overlay_opacity')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">
                            <i class="fas fa-save"></i>
                            Update Slider
                        </button>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary" style="width: 100%;">
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

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
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

        .section-subtitle {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border);
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

        select.form-control {
            cursor: pointer;
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

        .image-preview small {
            color: #9ca3af;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            object-fit: cover;
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

        /* Range Input */
        .form-range {
            width: 100%;
            height: 6px;
            background: var(--border);
            outline: none;
            border-radius: 10px;
            -webkit-appearance: none;
        }

        .form-range::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: var(--primary);
            cursor: pointer;
            border-radius: 50%;
        }

        .form-range::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: var(--primary);
            cursor: pointer;
            border-radius: 50%;
            border: none;
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

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
        }

        @media (max-width: 1024px) {
            .row {
                flex-direction: column;
            }

            .col-8,
            .col-4,
            .col-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
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

        // Color Picker Sync
        document.getElementById('overlay_color').addEventListener('input', function() {
            document.getElementById('overlay_color_text').value = this.value;
        });

        // Set initial opacity value
        document.getElementById('opacity_value').textContent = document.getElementById('overlay_opacity').value;
    </script>
@endpush
