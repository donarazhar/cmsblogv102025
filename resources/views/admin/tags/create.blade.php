@extends('admin.layouts.app')

@section('title', 'Tambah Tag')

@section('content')
    <style>
        .breadcrumb {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            align-items: center;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: var(--primary-dark);
        }

        .breadcrumb span {
            color: #9ca3af;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            max-width: 900px;
        }

        .form-header {
            padding: 25px;
            border-bottom: 1px solid var(--border);
        }

        .form-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .form-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-body {
            padding: 30px 25px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-label-required::after {
            content: '*';
            color: var(--danger);
            margin-left: 4px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
        }

        .form-input.error {
            border-color: var(--danger);
        }

        .form-help {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 6px;
        }

        .form-error {
            font-size: 0.85rem;
            color: var(--danger);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .color-picker-wrapper {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .color-input {
            width: 80px;
            height: 50px;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
        }

        .color-preview {
            flex: 1;
            height: 50px;
            border-radius: 8px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 0.9rem;
        }

        .switch-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .switch {
            position: relative;
            width: 50px;
            height: 28px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
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

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: var(--success);
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }

        .form-footer {
            padding: 20px 25px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            gap: 15px;
            background: var(--light);
            border-radius: 0 0 12px 12px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
            background: #e5e7eb;
            color: var(--dark);
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-footer {
                flex-direction: column;
            }
        }
    </style>

    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <span>/</span>
        <a href="{{ route('admin.tags.index') }}">Tags</a>
        <span>/</span>
        <span style="color: var(--dark); font-weight: 600;">Tambah Tag</span>
    </div>

    <div class="form-card">
        <div class="form-header">
            <h2 class="form-title">Tambah Tag Baru</h2>
            <p class="form-subtitle">Buat tag baru untuk mengorganisasi konten Anda</p>
        </div>

        <form method="POST" action="{{ route('admin.tags.store') }}">
            @csrf

            <div class="form-body">
                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label form-label-required">Nama Tag</label>
                    <input type="text" id="name" name="name" class="form-input @error('name') error @enderror"
                        value="{{ old('name') }}" placeholder="Contoh: Tutorial, Berita, Teknologi" required autofocus>
                    @error('name')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @else
                        <div class="form-help">Nama tag yang akan ditampilkan</div>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="form-group">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-input @error('slug') error @enderror"
                        value="{{ old('slug') }}" placeholder="akan-dibuat-otomatis">
                    @error('slug')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @else
                        <div class="form-help">Biarkan kosong untuk generate otomatis dari nama tag</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" class="form-input @error('description') error @enderror" rows="4"
                        placeholder="Deskripsi singkat tentang tag ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @else
                        <div class="form-help">Deskripsi opsional untuk memberikan konteks lebih</div>
                    @enderror
                </div>

                <!-- Color -->
                <div class="form-group">
                    <label for="color" class="form-label form-label-required">Warna Tag</label>
                    <div class="color-picker-wrapper">
                        <input type="color" id="color" name="color" class="color-input"
                            value="{{ old('color', '#0053C5') }}" required>
                        <div class="color-preview" id="colorPreview" style="background: {{ old('color', '#0053C5') }};">
                            <span id="colorText">{{ old('color', '#0053C5') }}</span>
                        </div>
                    </div>
                    @error('color')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @else
                        <div class="form-help">Pilih warna untuk membedakan tag</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="switch-wrapper">
                        <label class="switch">
                            <input type="checkbox" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                        <span style="color: #6b7280; font-size: 0.95rem;">Aktifkan tag ini</span>
                    </div>
                    <div class="form-help">Tag yang tidak aktif tidak akan ditampilkan di frontend</div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan Tag
                </button>
            </div>
        </form>
    </div>

    <script>
        // Auto generate slug from name
        document.getElementById('name').addEventListener('input', function() {
            const slugInput = document.getElementById('slug');
            if (!slugInput.dataset.manualEdit) {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                slugInput.value = slug;
            }
        });

        // Mark slug as manually edited
        document.getElementById('slug').addEventListener('input', function() {
            this.dataset.manualEdit = 'true';
        });

        // Color picker preview
        const colorInput = document.getElementById('color');
        const colorPreview = document.getElementById('colorPreview');
        const colorText = document.getElementById('colorText');

        colorInput.addEventListener('input', function() {
            const color = this.value;
            colorPreview.style.background = color;
            colorText.textContent = color.toUpperCase();
        });
    </script>
@endsection
