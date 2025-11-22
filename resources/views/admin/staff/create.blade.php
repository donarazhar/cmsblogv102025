@extends('admin.layouts.app')

@section('title', 'Tambah Staff')

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
        }

        .breadcrumb span {
            color: #9ca3af;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            max-width: 1000px;
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

        .form-section {
            margin-bottom: 35px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary);
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

        .photo-upload {
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .photo-upload:hover {
            border-color: var(--primary);
            background: var(--light);
        }

        .photo-preview {
            max-width: 300px;
            margin: 0 auto 15px;
            border-radius: 12px;
            overflow: hidden;
            display: none;
        }

        .photo-preview img {
            width: 100%;
            height: auto;
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
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.staff.index') }}">Staff</a>
        <span>/</span>
        <span style="color: var(--dark); font-weight: 600;">Tambah Staff</span>
    </div>

    <div class="form-card">
        <div class="form-header">
            <h2 class="form-title">Tambah Staff Baru</h2>
            <p class="form-subtitle">Tambahkan data pengurus, imam, ustadz, atau staf masjid</p>
        </div>

        <form method="POST" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-body">
                <!-- Basic Information -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-user"></i> Informasi Dasar</h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="form-label form-label-required">Nama Lengkap</label>
                            <input type="text" id="name" name="name"
                                class="form-input @error('name') error @enderror" value="{{ old('name') }}" required
                                autofocus>
                            @error('name')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" id="slug" name="slug"
                                class="form-input @error('slug') error @enderror" value="{{ old('slug') }}">
                            @error('slug')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @else
                                <div class="form-help">Biarkan kosong untuk generate otomatis</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="position" class="form-label form-label-required">Jabatan</label>
                            <input type="text" id="position" name="position"
                                class="form-input @error('position') error @enderror" value="{{ old('position') }}"
                                placeholder="Contoh: Ketua, Imam, Ustadz" required>
                            @error('position')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="department" class="form-label">Departemen</label>
                            <input type="text" id="department" name="department"
                                class="form-input @error('department') error @enderror" value="{{ old('department') }}"
                                placeholder="Contoh: Pendidikan, Keuangan">
                            @error('department')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="type" class="form-label form-label-required">Tipe</label>
                            <select id="type" name="type" class="form-input @error('type') error @enderror"
                                required>
                                <option value="">Pilih Tipe</option>
                                <option value="board" {{ old('type') == 'board' ? 'selected' : '' }}>Board/Pengurus
                                </option>
                                <option value="imam" {{ old('type') == 'imam' ? 'selected' : '' }}>Imam</option>
                                <option value="teacher" {{ old('type') == 'teacher' ? 'selected' : '' }}>Ustadz/Teacher
                                </option>
                                <option value="staff" {{ old('type') == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="volunteer" {{ old('type') == 'volunteer' ? 'selected' : '' }}>Volunteer
                                </option>
                            </select>
                            @error('type')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="specialization" class="form-label">Spesialisasi</label>
                            <input type="text" id="specialization" name="specialization"
                                class="form-input @error('specialization') error @enderror"
                                value="{{ old('specialization') }}" placeholder="Contoh: Fiqih, Tahfidz">
                            @error('specialization')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @else
                                <div class="form-help">Khusus untuk Imam/Ustadz</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="biography" class="form-label">Biografi</label>
                        <textarea id="biography" name="biography" class="form-input @error('biography') error @enderror" rows="5"
                            placeholder="Tulis biografi singkat...">{{ old('biography') }}</textarea>
                        @error('biography')
                            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Photo Upload -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-camera"></i> Foto</h3>

                    <div class="form-group">
                        <label class="form-label">Upload Foto</label>
                        <div class="photo-upload" onclick="document.getElementById('photo').click()">
                            <div class="photo-preview" id="photoPreview">
                                <img src="" alt="Preview" id="previewImage">
                            </div>
                            <i class="fas fa-cloud-upload-alt"
                                style="font-size: 3rem; color: var(--primary); margin-bottom: 15px;"></i>
                            <p style="font-weight: 600; margin-bottom: 5px;">Klik untuk upload foto</p>
                            <p style="font-size: 0.85rem; color: #6b7280;">JPG, PNG (Max 2MB)</p>
                        </div>
                        <input type="file" id="photo" name="photo" class="form-input" style="display: none;"
                            accept="image/*" onchange="previewPhoto(this)">
                        @error('photo')
                            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-address-card"></i> Informasi Kontak</h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email"
                                class="form-input @error('email') error @enderror" value="{{ old('email') }}"
                                placeholder="email@example.com">
                            @error('email')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Telepon</label>
                            <input type="text" id="phone" name="phone"
                                class="form-input @error('phone') error @enderror" value="{{ old('phone') }}"
                                placeholder="+62...">
                            @error('phone')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-share-alt"></i> Social Media</h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="url" id="facebook" name="facebook"
                                class="form-input @error('facebook') error @enderror" value="{{ old('facebook') }}"
                                placeholder="https://facebook.com/...">
                            @error('facebook')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input type="url" id="instagram" name="instagram"
                                class="form-input @error('instagram') error @enderror" value="{{ old('instagram') }}"
                                placeholder="https://instagram.com/...">
                            @error('instagram')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="twitter" class="form-label">Twitter</label>
                            <input type="url" id="twitter" name="twitter"
                                class="form-input @error('twitter') error @enderror" value="{{ old('twitter') }}"
                                placeholder="https://twitter.com/...">
                            @error('twitter')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="linkedin" class="form-label">LinkedIn</label>
                            <input type="url" id="linkedin" name="linkedin"
                                class="form-input @error('linkedin') error @enderror" value="{{ old('linkedin') }}"
                                placeholder="https://linkedin.com/...">
                            @error('linkedin')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-cog"></i> Pengaturan</h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="join_date" class="form-label">Tanggal Bergabung</label>
                            <input type="date" id="join_date" name="join_date"
                                class="form-input @error('join_date') error @enderror" value="{{ old('join_date') }}">
                            @error('join_date')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="order" class="form-label">Urutan</label>
                            <input type="number" id="order" name="order"
                                class="form-input @error('order') error @enderror" value="{{ old('order', 0) }}"
                                min="0">
                            @error('order')
                                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @else
                                <div class="form-help">Semakin kecil angka, semakin atas urutannya</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Featured</label>
                            <div class="switch-wrapper">
                                <label class="switch">
                                    <input type="checkbox" name="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                                <span style="color: #6b7280;">Tampilkan di halaman utama</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="switch-wrapper">
                                <label class="switch">
                                    <input type="checkbox" name="is_active"
                                        {{ old('is_active', true) ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                                <span style="color: #6b7280;">Aktifkan staff</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Staff
                </button>
            </div>
        </form>
    </div>

    <script>
        // Auto generate slug
        document.getElementById('name').addEventListener('input', function() {
            const slugInput = document.getElementById('slug');
            if (!slugInput.dataset.manualEdit) {
                slugInput.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            }
        });

        document.getElementById('slug').addEventListener('input', function() {
            this.dataset.manualEdit = 'true';
        });

        // Photo preview
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreview').style.display = 'block';
                    document.getElementById('previewImage').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
