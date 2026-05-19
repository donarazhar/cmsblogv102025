@extends('admin.layouts.app')

@section('title', 'Edit Campaign Donasi')

@section('content')
    <div class="page-header">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 8px;">
            <a href="{{ route('admin.donations.index') }}"
                style="width: 40px; height: 40px; background: var(--light); border-radius: 10px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: var(--dark);">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="page-title">Edit Campaign Donasi</h1>
                <p class="page-subtitle">Edit campaign: {{ $donation->campaign_name }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.donations.update', $donation) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 24px;">
            <!-- Main Content -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <!-- Basic Information -->
                <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                        <i class="fas fa-info-circle" style="color: var(--primary);"></i> Informasi Dasar
                    </h3>

                    <div style="display: grid; gap: 20px;">
                        <!-- Campaign Name -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Nama Campaign <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="text" name="campaign_name"
                                value="{{ old('campaign_name', $donation->campaign_name) }}" required
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                placeholder="Contoh: Renovasi Masjid Al Azhar">
                            @error('campaign_name')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Slug (URL)
                            </label>
                            <input type="text" name="slug" value="{{ old('slug', $donation->slug) }}"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                placeholder="renovasi-masjid-al-azhar">
                            <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Kosongkan untuk generate
                                otomatis dari nama campaign</p>
                            @error('slug')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Kategori <span style="color: var(--danger);">*</span>
                            </label>
                            <select name="category" required
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                                <option value="">Pilih Kategori</option>
                                <option value="infaq"
                                    {{ old('category', $donation->category) == 'infaq' ? 'selected' : '' }}>Infaq</option>
                                <option value="sedekah"
                                    {{ old('category', $donation->category) == 'sedekah' ? 'selected' : '' }}>Sedekah
                                </option>
                                <option value="zakat"
                                    {{ old('category', $donation->category) == 'zakat' ? 'selected' : '' }}>Zakat</option>
                                <option value="wakaf"
                                    {{ old('category', $donation->category) == 'wakaf' ? 'selected' : '' }}>Wakaf</option>
                                <option value="qurban"
                                    {{ old('category', $donation->category) == 'qurban' ? 'selected' : '' }}>Qurban
                                </option>
                                <option value="renovation"
                                    {{ old('category', $donation->category) == 'renovation' ? 'selected' : '' }}>Renovasi
                                </option>
                                <option value="program"
                                    {{ old('category', $donation->category) == 'program' ? 'selected' : '' }}>Program
                                </option>
                                <option value="other"
                                    {{ old('category', $donation->category) == 'other' ? 'selected' : '' }}>Lainnya
                                </option>
                            </select>
                            @error('category')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Deskripsi Singkat <span style="color: var(--danger);">*</span>
                            </label>
                            <textarea name="description" rows="3" required
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem; resize: vertical;"
                                placeholder="Deskripsi singkat campaign (maksimal 200 karakter)">{{ old('description', $donation->description) }}</textarea>
                            @error('description')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Konten Lengkap
                            </label>
                            <textarea name="content" rows="8"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem; resize: vertical;"
                                placeholder="Jelaskan detail campaign donasi Anda...">{{ old('content', $donation->content) }}</textarea>
                            @error('content')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Gambar Campaign
                            </label>

                            @if ($donation->image)
                                <div style="margin-bottom: 12px;">
                                    <img src="{{ asset('storage/' . $donation->image) }}" alt="{{ $donation->campaign_name }}"
                                        style="max-width: 300px; height: auto; border-radius: 8px; border: 1px solid var(--border);"
                                        id="currentImage">
                                </div>
                            @endif

                            <input type="file" name="image" accept="image/*" id="imageInput"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Format: JPG, PNG. Maksimal 2MB.
                                Kosongkan jika tidak ingin mengubah gambar.</p>
                            @error('image')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror

                            <!-- Image Preview -->
                            <div id="imagePreview" style="margin-top: 12px; display: none;">
                                <img id="previewImg" src="" alt="Preview"
                                    style="max-width: 100%; height: auto; border-radius: 8px; border: 1px solid var(--border);">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                        <i class="fas fa-bullseye" style="color: var(--primary);"></i> Timeline
                    </h3>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                        <!-- Start Date -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Tanggal Mulai
                            </label>
                            <input type="date" name="start_date"
                                value="{{ old('start_date', $donation->start_date?->format('Y-m-d')) }}"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            @error('start_date')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div
                    style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                        <i class="fas fa-credit-card" style="color: var(--primary);"></i> Informasi Pembayaran
                    </h3>

                    <div style="display: grid; gap: 20px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <!-- Bank Name -->
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                    Nama Bank
                                </label>
                                <input type="text" name="bank_name" value="{{ old('bank_name', $donation->bank_name) }}"
                                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                    placeholder="Contoh: Bank BSI">
                                @error('bank_name')
                                    <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Bank Account -->
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                    Nomor Rekening
                                </label>
                                <input type="text" name="bank_account" value="{{ old('bank_account', $donation->bank_account) }}"
                                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                    placeholder="Contoh: 1234567890 (A.N Masjid)">
                                @error('bank_account')
                                    <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- QRIS Image -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Gambar QRIS
                            </label>

                            @if ($donation->qris_image)
                                <div style="margin-bottom: 12px;">
                                    <img src="{{ asset('storage/' . $donation->qris_image) }}" alt="QRIS"
                                        style="max-width: 200px; height: auto; border-radius: 8px; border: 1px solid var(--border);"
                                        id="currentQrisImage">
                                </div>
                            @endif

                            <input type="file" name="qris_image" accept="image/*" id="qrisInput"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Upload kode QRIS jika tersedia. Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</p>
                            @error('qris_image')
                                <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror

                            <!-- QRIS Preview -->
                            <div id="qrisPreview" style="margin-top: 12px; display: none;">
                                <img id="qrisPreviewImg" src="" alt="QRIS Preview"
                                    style="max-width: 200px; height: auto; border-radius: 8px; border: 1px solid var(--border);">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div style="display: flex; flex-direction: column; gap: 20px;">


                <!-- Settings -->
                <div
                    style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                        <i class="fas fa-cog" style="color: var(--primary);"></i> Pengaturan
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <!-- Is Active -->
                        <label
                            style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; background: var(--light); border-radius: 8px;">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $donation->is_active) ? 'checked' : '' }}
                                style="width: 18px; height: 18px; cursor: pointer;">
                            <div>
                                <div style="font-weight: 600; color: var(--dark);">Campaign Aktif</div>
                                <div style="font-size: 0.85rem; color: #6b7280;">Tampilkan di website</div>
                            </div>
                        </label>

                        <!-- Is Featured -->
                        <label
                            style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; background: var(--light); border-radius: 8px;">
                            <input type="checkbox" name="is_featured" value="1"
                                {{ old('is_featured', $donation->is_featured) ? 'checked' : '' }}
                                style="width: 18px; height: 18px; cursor: pointer;">
                            <div>
                                <div style="font-weight: 600; color: var(--dark);">Featured</div>
                                <div style="font-size: 0.85rem; color: #6b7280;">Tampilkan di homepage</div>
                            </div>
                        </label>

                        <!-- Is Urgent -->
                        <label
                            style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; background: var(--light); border-radius: 8px;">
                            <input type="checkbox" name="is_urgent" value="1"
                                {{ old('is_urgent', $donation->is_urgent) ? 'checked' : '' }}
                                style="width: 18px; height: 18px; cursor: pointer;">
                            <div>
                                <div style="font-weight: 600; color: var(--dark);">Urgent</div>
                                <div style="font-size: 0.85rem; color: #6b7280;">Tandai sebagai mendesak</div>
                            </div>
                        </label>

                        <!-- Order -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Urutan Tampil
                            </label>
                            <input type="number" name="order" value="{{ old('order', $donation->order) }}"
                                min="0"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                placeholder="0">
                            <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Semakin kecil, semakin awal
                                ditampilkan</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                        <i class="fas fa-save" style="color: var(--primary);"></i> Aksi
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit"
                            style="width: 100%; padding: 14px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fas fa-save"></i> Update Campaign
                        </button>
                        <a href="{{ route('admin.donations.show', $donation) }}"
                            style="width: 100%; padding: 14px; background: var(--info); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                        <a href="{{ route('admin.donations.index') }}"
                            style="width: 100%; padding: 14px; background: var(--light); color: var(--dark); border-radius: 8px; text-decoration: none; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('styles')
    <style>
        .payment-method-label:hover {
            border-color: var(--primary);
            background: var(--light);
        }

        .payment-method-label input:checked~div {
            color: var(--primary);
        }

        @media (max-width: 1024px) {
            [style*="grid-template-columns: 1fr 350px"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Image Preview
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';

                    // Hide current image
                    const currentImage = document.getElementById('currentImage');
                    if (currentImage) {
                        currentImage.style.display = 'none';
                    }
                }
                reader.readAsDataURL(file);
            }
        });

        // Auto generate slug from campaign name
        document.querySelector('input[name="campaign_name"]').addEventListener('input', function(e) {
            const slugInput = document.querySelector('input[name="slug"]');
            const slug = e.target.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            slugInput.value = slug;
        });

        // QRIS Preview
        document.getElementById('qrisInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('qrisPreviewImg').src = e.target.result;
                    document.getElementById('qrisPreview').style.display = 'block';

                    // Hide current QRIS image
                    const currentQrisImage = document.getElementById('currentQrisImage');
                    if (currentQrisImage) {
                        currentQrisImage.style.display = 'none';
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
