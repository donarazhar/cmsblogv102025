@extends('admin.layouts.app')

@section('title', 'Tambah Program')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Tambah Program</h1>
                <div class="breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('admin.programs.index') }}">Programs</a>
                    <span>/</span>
                    <span>Tambah</span>
                </div>
            </div>
            <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Left Column -->
            <div class="col-8">
                <!-- Basic Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Dasar</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Program <span class="required">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required placeholder="Masukkan nama program">
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
                            <label for="description">Deskripsi Singkat <span class="required">*</span></label>
                            <textarea name="description" id="description" rows="3"
                                class="form-control @error('description') is-invalid @enderror" required placeholder="Deskripsi singkat program">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Konten Detail</label>
                            <textarea name="content" id="content" rows="8" class="form-control @error('content') is-invalid @enderror"
                                placeholder="Detail lengkap program (opsional)">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Gambar Program</label>
                            <div class="image-upload-wrapper">
                                <input type="file" name="image" id="image"
                                    class="form-control-file @error('image') is-invalid @enderror" accept="image/*"
                                    onchange="previewImage(this)">
                                <div class="image-preview" id="imagePreview">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Klik atau drag gambar ke sini</p>
                                    <small>Maksimal 2MB (JPEG, PNG, JPG, WEBP)</small>
                                </div>
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Schedule & Location -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jadwal & Lokasi</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date') }}">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="end_date">Tanggal Selesai</label>
                                    <input type="date" name="end_date" id="end_date"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date') }}">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="start_time">Waktu Mulai</label>
                                    <input type="time" name="start_time" id="start_time"
                                        class="form-control @error('start_time') is-invalid @enderror"
                                        value="{{ old('start_time') }}">
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="end_time">Waktu Selesai</label>
                                    <input type="time" name="end_time" id="end_time"
                                        class="form-control @error('end_time') is-invalid @enderror"
                                        value="{{ old('end_time') }}">
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location">Lokasi</label>
                            <input type="text" name="location" id="location"
                                class="form-control @error('location') is-invalid @enderror"
                                value="{{ old('location') }}" placeholder="Contoh: Aula Masjid Lt. 2">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Tambahan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="organizer">Penyelenggara</label>
                                    <input type="text" name="organizer" id="organizer"
                                        class="form-control @error('organizer') is-invalid @enderror"
                                        value="{{ old('organizer') }}" placeholder="Nama penyelenggara">
                                    @error('organizer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="speaker">Pembicara/Ustadz</label>
                                    <input type="text" name="speaker" id="speaker"
                                        class="form-control @error('speaker') is-invalid @enderror"
                                        value="{{ old('speaker') }}" placeholder="Nama pembicara">
                                    @error('speaker')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="contact_person">Contact Person</label>
                                    <input type="text" name="contact_person" id="contact_person"
                                        class="form-control @error('contact_person') is-invalid @enderror"
                                        value="{{ old('contact_person') }}" placeholder="Nama kontak">
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="contact_phone">Nomor Telepon</label>
                                    <input type="text" name="contact_phone" id="contact_phone"
                                        class="form-control @error('contact_phone') is-invalid @enderror"
                                        value="{{ old('contact_phone') }}" placeholder="081234567890">
                                    @error('contact_phone')
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
                <!-- Program Type & Settings -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengaturan Program</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="type">Tipe Program <span class="required">*</span></label>
                            <select name="type" id="type"
                                class="form-control @error('type') is-invalid @enderror" required>
                                <option value="">Pilih Tipe</option>
                                <option value="regular" {{ old('type') == 'regular' ? 'selected' : '' }}>Regular</option>
                                <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                                <option value="course" {{ old('type') == 'course' ? 'selected' : '' }}>Kursus</option>
                                <option value="charity" {{ old('type') == 'charity' ? 'selected' : '' }}>Sosial</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="frequency">Frekuensi</label>
                            <select name="frequency" id="frequency"
                                class="form-control @error('frequency') is-invalid @enderror">
                                <option value="">Pilih Frekuensi</option>
                                <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}>Harian</option>
                                <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Mingguan
                                </option>
                                <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }}>Bulanan
                                </option>
                                <option value="yearly" {{ old('frequency') == 'yearly' ? 'selected' : '' }}>Tahunan
                                </option>
                                <option value="once" {{ old('frequency') == 'once' ? 'selected' : '' }}>Sekali</option>
                            </select>
                            @error('frequency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="icon">Icon (Font Awesome)</label>
                            <input type="text" name="icon" id="icon"
                                class="form-control @error('icon') is-invalid @enderror"
                                value="{{ old('icon', 'fas fa-calendar-check') }}" placeholder="fas fa-calendar-check">
                            <small class="form-text">Contoh: fas fa-mosque, fas fa-book, fas fa-users</small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="order">Urutan</label>
                            <input type="number" name="order" id="order"
                                class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}"
                                min="0">
                            <small class="form-text">Kosongkan untuk auto increment</small>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr style="margin: 20px 0;">

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', 1) ? 'checked' : '' }}>
                                <span>Program Aktif</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_featured" value="1"
                                    {{ old('is_featured') ? 'checked' : '' }}>
                                <span>Tampilkan di Featured</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Registration Settings -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengaturan Pendaftaran</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_registration_open" value="1"
                                    {{ old('is_registration_open', 1) ? 'checked' : '' }}>
                                <span>Buka Pendaftaran</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="registration_fee">Biaya Pendaftaran (Rp)</label>
                            <input type="number" name="registration_fee" id="registration_fee"
                                class="form-control @error('registration_fee') is-invalid @enderror"
                                value="{{ old('registration_fee', 0) }}" min="0" step="1000" placeholder="0">
                            <small class="form-text">Isi 0 untuk gratis</small>
                            @error('registration_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="max_participants">Maksimal Peserta</label>
                            <input type="number" name="max_participants" id="max_participants"
                                class="form-control @error('max_participants') is-invalid @enderror"
                                value="{{ old('max_participants') }}" min="1" placeholder="Unlimited">
                            <small class="form-text">Kosongkan untuk unlimited</small>
                            @error('max_participants')
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
                            Simpan Program
                        </button>
                        <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary" style="width: 100%;">
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

        // Auto generate slug from name
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

