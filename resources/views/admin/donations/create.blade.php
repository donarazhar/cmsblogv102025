@extends('admin.layouts.app')

@section('title', 'Tambah Campaign Donasi')

@section('content')
    <div class="page-header">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 8px;">
            <a href="{{ route('admin.donations.index') }}"
                style="width: 40px; height: 40px; background: var(--light); border-radius: 10px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: var(--dark);">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="page-title">Tambah Campaign Donasi</h1>
                <p class="page-subtitle">Buat campaign donasi atau galang dana baru</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.donations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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
                            <input type="text" name="campaign_name" value="{{ old('campaign_name') }}" required
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
                            <input type="text" name="slug" value="{{ old('slug') }}"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                placeholder="renovasi-masjid-al-azhar (otomatis jika kosong)">
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
                                <option value="infaq" {{ old('category') == 'infaq' ? 'selected' : '' }}>Infaq</option>
                                <option value="sedekah" {{ old('category') == 'sedekah' ? 'selected' : '' }}>Sedekah
                                </option>
                                <option value="zakat" {{ old('category') == 'zakat' ? 'selected' : '' }}>Zakat</option>
                                <option value="wakaf" {{ old('category') == 'wakaf' ? 'selected' : '' }}>Wakaf</option>
                                <option value="qurban" {{ old('category') == 'qurban' ? 'selected' : '' }}>Qurban</option>
                                <option value="renovation" {{ old('category') == 'renovation' ? 'selected' : '' }}>Renovasi
                                </option>
                                <option value="program" {{ old('category') == 'program' ? 'selected' : '' }}>Program
                                </option>
                                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
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
                                placeholder="Deskripsi singkat campaign (maksimal 200 karakter)">{{ old('description') }}</textarea>
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
                                placeholder="Jelaskan detail campaign donasi Anda...">{{ old('content') }}</textarea>
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
                            <input type="file" name="image" accept="image/*" id="imageInput"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Format: JPG, PNG. Maksimal 2MB.
                                Rekomendasi: 800x600px</p>
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

                <!-- Target & Timeline -->
                <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                        <i class="fas fa-bullseye" style="color: var(--primary);"></i> Target & Timeline
                    </h3>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                        <!-- Target Amount -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Target Donasi (Rp)
                            </label>
                            <input type="number" name="target_amount" value="{{ old('target_amount') }}" min="0"
                                step="1000"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                placeholder="5000000">
                            <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Kosongkan jika tidak ada target
                            </p>
                            @error('target_amount')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Tanggal Mulai
                            </label>
                            <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            @error('start_date')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Tanggal Berakhir
                            </label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Kosongkan jika tidak ada batas
                                waktu</p>
                            @error('end_date')
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
                        <i class="fas fa-credit-card" style="color: var(--primary);"></i> Metode Pembayaran
                    </h3>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                        <label
                            style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 1px solid var(--border); border-radius: 8px; cursor: pointer; transition: all 0.3s ease;"
                            class="payment-method-label">
                            <input type="checkbox" name="payment_methods[]" value="bank_transfer"
                                {{ is_array(old('payment_methods')) && in_array('bank_transfer', old('payment_methods')) ? 'checked' : '' }}
                                style="width: 18px; height: 18px; cursor: pointer;">
                            <div>
                                <div style="font-weight: 600; color: var(--dark);">Transfer Bank</div>
                                <div style="font-size: 0.85rem; color: #6b7280;">BCA, Mandiri, BNI, dll</div>
                            </div>
                        </label>

                        <label
                            style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 1px solid var(--border); border-radius: 8px; cursor: pointer; transition: all 0.3s ease;"
                            class="payment-method-label">
                            <input type="checkbox" name="payment_methods[]" value="qris"
                                {{ is_array(old('payment_methods')) && in_array('qris', old('payment_methods')) ? 'checked' : '' }}
                                style="width: 18px; height: 18px; cursor: pointer;">
                            <div>
                                <div style="font-weight: 600; color: var(--dark);">QRIS</div>
                                <div style="font-size: 0.85rem; color: #6b7280;">Scan QR Code</div>
                            </div>
                        </label>

                        <label
                            style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 1px solid var(--border); border-radius: 8px; cursor: pointer; transition: all 0.3s ease;"
                            class="payment-method-label">
                            <input type="checkbox" name="payment_methods[]" value="cash"
                                {{ is_array(old('payment_methods')) && in_array('cash', old('payment_methods')) ? 'checked' : '' }}
                                style="width: 18px; height: 18px; cursor: pointer;">
                            <div>
                                <div style="font-weight: 600; color: var(--dark);">Tunai</div>
                                <div style="font-size: 0.85rem; color: #6b7280;">Langsung ke masjid</div>
                            </div>
                        </label>

                        <label
                            style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 1px solid var(--border); border-radius: 8px; cursor: pointer; transition: all 0.3s ease;"
                            class="payment-method-label">
                            <input type="checkbox" name="payment_methods[]" value="other"
                                {{ is_array(old('payment_methods')) && in_array('other', old('payment_methods')) ? 'checked' : '' }}
                                style="width: 18px; height: 18px; cursor: pointer;">
                            <div>
                                <div style="font-weight: 600; color: var(--dark);">Lainnya</div>
                                <div style="font-size: 0.85rem; color: #6b7280;">Metode lain</div>
                            </div>
                        </label>
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
                                {{ old('is_active', true) ? 'checked' : '' }}
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
                                {{ old('is_featured') ? 'checked' : '' }}
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
                                {{ old('is_urgent') ? 'checked' : '' }}
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
                            <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
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
                            <i class="fas fa-save"></i> Simpan Campaign
                        </button>
                        <a href="{{ route('admin.donations.index') }}"
                            style="width: 100%; padding: 14px; background: var(--light); color: var(--dark); border-radius: 8px; text-decoration: none; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>

                <!-- Help -->
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 20px;">
                    <div style="display: flex; gap: 12px;">
                        <i class="fas fa-info-circle" style="color: #3b82f6; font-size: 1.5rem; flex-shrink: 0;"></i>
                        <div>
                            <h4 style="font-weight: 600; color: #1e40af; margin-bottom: 8px;">Tips</h4>
                            <ul
                                style="font-size: 0.85rem; color: #1e40af; line-height: 1.6; margin: 0; padding-left: 20px;">
                                <li>Gunakan gambar yang menarik dan berkualitas</li>
                                <li>Tulis deskripsi yang jelas dan menyentuh</li>
                                <li>Set target yang realistis</li>
                                <li>Update progress secara berkala</li>
                            </ul>
                        </div>
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
                }
                reader.readAsDataURL(file);
            }
        });

        // Auto generate slug from campaign name
        document.querySelector('input[name="campaign_name"]').addEventListener('input', function(e) {
            const slugInput = document.querySelector('input[name="slug"]');
            if (!slugInput.value || slugInput.value === '') {
                const slug = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                slugInput.value = slug;
            }
        });
    </script>
@endpush
