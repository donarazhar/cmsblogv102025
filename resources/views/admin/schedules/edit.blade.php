@extends('admin.layouts.app')

@section('title', 'Edit Jadwal')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Jadwal</h1>
        <p class="page-subtitle">Perbarui informasi jadwal</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.schedules.index') }}">Jadwal</a>
            <span>/</span>
            <span>Edit</span>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Jadwal</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <!-- Judul -->
                    <div class="form-group col-span-2">
                        <label for="title" class="form-label required">Judul Jadwal</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title', $schedule->title) }}"
                            placeholder="Contoh: Sholat Dzuhur, Kajian Fiqih, dll" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tipe -->
                    <div class="form-group">
                        <label for="type" class="form-label required">Tipe Jadwal</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type"
                            required>
                            <option value="">Pilih Tipe</option>
                            <option value="prayer" {{ old('type', $schedule->type) == 'prayer' ? 'selected' : '' }}>Sholat
                            </option>
                            <option value="event" {{ old('type', $schedule->type) == 'event' ? 'selected' : '' }}>Acara
                            </option>
                            <option value="lecture" {{ old('type', $schedule->type) == 'lecture' ? 'selected' : '' }}>Kajian
                            </option>
                            <option value="class" {{ old('type', $schedule->type) == 'class' ? 'selected' : '' }}>Kelas
                            </option>
                            <option value="other" {{ old('type', $schedule->type) == 'other' ? 'selected' : '' }}>Lainnya
                            </option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group col-span-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3" placeholder="Deskripsi singkat tentang jadwal ini">{{ old('description', $schedule->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jadwal Berulang -->
                    <div class="form-group col-span-3">
                        <div class="form-check-switch">
                            <input type="checkbox" id="is_recurring" name="is_recurring" value="1"
                                {{ old('is_recurring', $schedule->is_recurring) ? 'checked' : '' }}
                                onchange="toggleRecurring()">
                            <label for="is_recurring">
                                <strong>Jadwal Berulang</strong>
                                <small>Aktifkan jika jadwal ini berulang setiap minggu</small>
                            </label>
                        </div>
                    </div>

                    <!-- Tanggal (untuk non-recurring) -->
                    <div class="form-group" id="date-field">
                        <label for="date" class="form-label">Tanggal</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                            name="date"
                            value="{{ old('date', $schedule->date ? $schedule->date->format('Y-m-d') : '') }}">
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hari (untuk recurring) -->
                    <div class="form-group" id="day-field" style="display: none;">
                        <label for="day_of_week" class="form-label">Hari</label>
                        <select class="form-select @error('day_of_week') is-invalid @enderror" id="day_of_week"
                            name="day_of_week">
                            <option value="">Pilih Hari</option>
                            <option value="monday"
                                {{ old('day_of_week', $schedule->day_of_week) == 'monday' ? 'selected' : '' }}>Senin
                            </option>
                            <option value="tuesday"
                                {{ old('day_of_week', $schedule->day_of_week) == 'tuesday' ? 'selected' : '' }}>Selasa
                            </option>
                            <option value="wednesday"
                                {{ old('day_of_week', $schedule->day_of_week) == 'wednesday' ? 'selected' : '' }}>Rabu
                            </option>
                            <option value="thursday"
                                {{ old('day_of_week', $schedule->day_of_week) == 'thursday' ? 'selected' : '' }}>Kamis
                            </option>
                            <option value="friday"
                                {{ old('day_of_week', $schedule->day_of_week) == 'friday' ? 'selected' : '' }}>Jumat
                            </option>
                            <option value="saturday"
                                {{ old('day_of_week', $schedule->day_of_week) == 'saturday' ? 'selected' : '' }}>Sabtu
                            </option>
                            <option value="sunday"
                                {{ old('day_of_week', $schedule->day_of_week) == 'sunday' ? 'selected' : '' }}>Minggu
                            </option>
                        </select>
                        @error('day_of_week')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Waktu Mulai -->
                    <div class="form-group">
                        <label for="start_time" class="form-label required">Waktu Mulai</label>
                        <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time"
                            name="start_time"
                            value="{{ old('start_time', $schedule->start_time ? substr($schedule->start_time, 0, 5) : '') }}"
                            required>
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Waktu Selesai -->
                    <div class="form-group">
                        <label for="end_time" class="form-label">Waktu Selesai</label>
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time"
                            name="end_time"
                            value="{{ old('end_time', $schedule->end_time ? substr($schedule->end_time, 0, 5) : '') }}">
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lokasi -->
                    <div class="form-group">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                            name="location" value="{{ old('location', $schedule->location) }}"
                            placeholder="Contoh: Ruang Utama, Aula, dll">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Imam -->
                    <div class="form-group">
                        <label for="imam" class="form-label">Imam</label>
                        <input type="text" class="form-control @error('imam') is-invalid @enderror" id="imam"
                            name="imam" value="{{ old('imam', $schedule->imam) }}" placeholder="Nama Imam">
                        @error('imam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pemateri/Pembicara -->
                    <div class="form-group">
                        <label for="speaker" class="form-label">Pemateri/Pembicara</label>
                        <input type="text" class="form-control @error('speaker') is-invalid @enderror" id="speaker"
                            name="speaker" value="{{ old('speaker', $schedule->speaker) }}" placeholder="Nama Pemateri">
                        @error('speaker')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Warna -->
                    <div class="form-group">
                        <label for="color" class="form-label">Warna Label</label>
                        <div class="color-input-group">
                            <input type="color" class="form-control-color @error('color') is-invalid @enderror"
                                id="color" name="color" value="{{ old('color', $schedule->color ?? '#0053C5') }}">
                            <input type="text" class="form-control" id="color-hex"
                                value="{{ old('color', $schedule->color ?? '#0053C5') }}" readonly>
                        </div>
                        <small class="form-text">Pilih warna untuk membedakan jenis jadwal</small>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Aktif -->
                    <div class="form-group col-span-3">
                        <div class="form-check-switch">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', $schedule->is_active) ? 'checked' : '' }}>
                            <label for="is_active">
                                <strong>Aktifkan Jadwal</strong>
                                <small>Jadwal yang aktif akan ditampilkan di website</small>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Jadwal
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

        .color-input-group {
            display: flex;
            gap: 10px;
        }

        .form-control-color {
            width: 80px;
            height: 45px;
            padding: 5px;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
        }

        .form-text {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.85rem;
            color: #6b7280;
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

@push('scripts')
    <script>
        // Toggle Recurring Fields
        function toggleRecurring() {
            const isRecurring = document.getElementById('is_recurring').checked;
            const dateField = document.getElementById('date-field');
            const dayField = document.getElementById('day-field');
            const dateInput = document.getElementById('date');
            const dayInput = document.getElementById('day_of_week');

            if (isRecurring) {
                dateField.style.display = 'none';
                dayField.style.display = 'block';
                dateInput.removeAttribute('required');
                dayInput.setAttribute('required', 'required');
            } else {
                dateField.style.display = 'block';
                dayField.style.display = 'none';
                dateInput.setAttribute('required', 'required');
                dayInput.removeAttribute('required');
            }
        }

        // Sync Color Picker with Hex Input
        document.getElementById('color').addEventListener('input', function() {
            document.getElementById('color-hex').value = this.value.toUpperCase();
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleRecurring();
        });
    </script>
@endpush
