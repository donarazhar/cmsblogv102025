@extends('admin.layouts.app')

@section('title', 'Edit Pengumuman')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Pengumuman</h1>
        <p class="page-subtitle">Perbarui informasi pengumuman</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.announcements.index') }}">Pengumuman</a>
            <span>/</span>
            <span>Edit</span>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Pengumuman</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <!-- Judul -->
                    <div class="form-group col-span-3">
                        <label for="title" class="form-label required">Judul Pengumuman</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title', $announcement->title) }}"
                            placeholder="Contoh: Kajian Rutin Jumat Malam" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="form-group col-span-3">
                        <label for="content" class="form-label required">Isi Pengumuman</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5"
                            placeholder="Tulis isi pengumuman di sini..." required>{{ old('content', $announcement->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tipe -->
                    <div class="form-group">
                        <label for="type" class="form-label required">Tipe</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type"
                            required>
                            <option value="">Pilih Tipe</option>
                            <option value="info" {{ old('type', $announcement->type) == 'info' ? 'selected' : '' }}>Info
                            </option>
                            <option value="success" {{ old('type', $announcement->type) == 'success' ? 'selected' : '' }}>
                                Success</option>
                            <option value="warning" {{ old('type', $announcement->type) == 'warning' ? 'selected' : '' }}>
                                Warning</option>
                            <option value="danger" {{ old('type', $announcement->type) == 'danger' ? 'selected' : '' }}>
                                Danger</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prioritas -->
                    <div class="form-group">
                        <label for="priority" class="form-label required">Prioritas</label>
                        <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority"
                            required>
                            <option value="">Pilih Prioritas</option>
                            <option value="urgent"
                                {{ old('priority', $announcement->priority) == 'urgent' ? 'selected' : '' }}>Urgent
                            </option>
                            <option value="high"
                                {{ old('priority', $announcement->priority) == 'high' ? 'selected' : '' }}>High</option>
                            <option value="medium"
                                {{ old('priority', $announcement->priority) == 'medium' ? 'selected' : '' }}>Medium
                            </option>
                            <option value="low"
                                {{ old('priority', $announcement->priority) == 'low' ? 'selected' : '' }}>Low</option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div class="form-group">
                        <label for="order" class="form-label">Urutan Tampil</label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" id="order"
                            name="order" value="{{ old('order', $announcement->order) }}" min="0" placeholder="0">
                        <small class="form-text">Angka lebih kecil akan tampil lebih dulu</small>
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Icon -->
                    <div class="form-group">
                        <label for="icon" class="form-label">Icon (FontAwesome)</label>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon"
                            name="icon" value="{{ old('icon', $announcement->icon) }}" placeholder="fas fa-bullhorn">
                        <small class="form-text">Contoh: fas fa-bullhorn, fas fa-info-circle</small>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Link -->
                    <div class="form-group">
                        <label for="link" class="form-label">Link (URL)</label>
                        <input type="url" class="form-control @error('link') is-invalid @enderror" id="link"
                            name="link" value="{{ old('link', $announcement->link) }}"
                            placeholder="https://example.com">
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Link Text -->
                    <div class="form-group">
                        <label for="link_text" class="form-label">Text Link</label>
                        <input type="text" class="form-control @error('link_text') is-invalid @enderror" id="link_text"
                            name="link_text" value="{{ old('link_text', $announcement->link_text) }}"
                            placeholder="Selengkapnya">
                        @error('link_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="form-group">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror"
                            id="start_date" name="start_date"
                            value="{{ old('start_date', $announcement->start_date ? $announcement->start_date->format('Y-m-d\TH:i') : '') }}">
                        <small class="form-text">Kosongkan untuk mulai sekarang</small>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="form-group">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror"
                            id="end_date" name="end_date"
                            value="{{ old('end_date', $announcement->end_date ? $announcement->end_date->format('Y-m-d\TH:i') : '') }}">
                        <small class="form-text">Kosongkan untuk tanpa batas waktu</small>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Display Options -->
                    <div class="form-group col-span-3">
                        <label class="form-label">Opsi Tampilan</label>
                        <div class="options-grid">
                            <div class="form-check-switch">
                                <input type="checkbox" id="show_on_homepage" name="show_on_homepage" value="1"
                                    {{ old('show_on_homepage', $announcement->show_on_homepage) ? 'checked' : '' }}>
                                <label for="show_on_homepage">
                                    <strong>Tampilkan di Homepage</strong>
                                    <small>Pengumuman akan muncul di halaman utama website</small>
                                </label>
                            </div>

                            <div class="form-check-switch">
                                <input type="checkbox" id="show_popup" name="show_popup" value="1"
                                    {{ old('show_popup', $announcement->show_popup) ? 'checked' : '' }}>
                                <label for="show_popup">
                                    <strong>Tampilkan sebagai Popup</strong>
                                    <small>Pengumuman akan muncul sebagai popup saat membuka website</small>
                                </label>
                            </div>

                            <div class="form-check-switch">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                    {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}>
                                <label for="is_active">
                                    <strong>Aktifkan Pengumuman</strong>
                                    <small>Hanya pengumuman aktif yang akan ditampilkan</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Pengumuman
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
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
        }

        .card-body {
            padding: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .col-span-2 {
            grid-column: span 2;
        }

        .col-span-3 {
            grid-column: span 3;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .form-label.required::after {
            content: "*";
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
            margin-top: 0.25rem;
        }

        .form-text {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .options-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .form-check-switch {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 15px;
            background: var(--light);
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .form-check-switch input[type="checkbox"] {
            width: 50px;
            height: 26px;
            cursor: pointer;
            -webkit-appearance: none;
            appearance: none;
            background: #d1d5db;
            border-radius: 50px;
            position: relative;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .form-check-switch input[type="checkbox"]:checked {
            background: var(--primary);
        }

        .form-check-switch input[type="checkbox"]::before {
            content: '';
            position: absolute;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: white;
            top: 2px;
            left: 2px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .form-check-switch input[type="checkbox"]:checked::before {
            left: 26px;
        }

        .form-check-switch label {
            cursor: pointer;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .form-check-switch label small {
            color: #6b7280;
            font-size: 0.85rem;
            font-weight: normal;
        }

        textarea.form-control {
            resize: vertical;
            font-family: inherit;
        }

        .form-footer {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
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

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .col-span-2,
            .col-span-3 {
                grid-column: span 1;
            }

            .card-body {
                padding: 20px;
            }
        }
    </style>
@endpush
