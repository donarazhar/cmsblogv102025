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
                                    <img src="{{ Storage::url($donation->image) }}" alt="{{ $donation->campaign_name }}"
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
                            <input type="number" name="target_amount"
                                value="{{ old('target_amount', $donation->target_amount) }}" min="0" step="1000"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                placeholder="5000000">
                            <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Kosongkan jika tidak ada target
                            </p>
                            @error('target_amount')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Current Amount (Read Only) -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Terkumpul Saat Ini (Rp)
                            </label>
                            <input type="text" value="{{ number_format($donation->current_amount, 0, ',', '.') }}"
                                readonly
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem; background: var(--light); color: #6b7280;">
                            <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Otomatis dari transaksi</p>
                        </div>

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

                        <!-- End Date -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Tanggal Berakhir
                            </label>
                            <input type="date" name="end_date"
                                value="{{ old('end_date', $donation->end_date?->format('Y-m-d')) }}"
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
                        @php
                            $payment_methods = old('payment_methods', $donation->payment_methods ?? []);
                        @endphp

                        <label
                            style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 1px solid var(--border); border-radius: 8px; cursor: pointer; transition: all 0.3s ease;"
                            class="payment-method-label">
                            <input type="checkbox" name="payment_methods[]" value="bank_transfer"
                                {{ is_array($payment_methods) && in_array('bank_transfer', $payment_methods) ? 'checked' : '' }}
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
                                {{ is_array($payment_methods) && in_array('qris', $payment_methods) ? 'checked' : '' }}
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
                                {{ is_array($payment_methods) && in_array('cash', $payment_methods) ? 'checked' : '' }}
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
                                {{ is_array($payment_methods) && in_array('other', $payment_methods) ? 'checked' : '' }}
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
                <!-- Statistics -->
                <div
                    style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                        <i class="fas fa-chart-line" style="color: var(--primary);"></i> Statistik
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div
                            style="padding: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; color: white;">
                            <div style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 4px;">Terkumpul</div>
                            <div style="font-size: 1.5rem; font-weight: 700;">Rp
                                {{ number_format($donation->current_amount, 0, ',', '.') }}</div>
                            @if ($donation->target_amount)
                                <div style="font-size: 0.85rem; opacity: 0.9; margin-top: 4px;">
                                    {{ number_format($donation->percentage, 1) }}% dari target</div>
                            @endif
                        </div>

                        <div
                            style="padding: 16px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 10px; color: white;">
                            <div style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 4px;">Total Donatur</div>
                            <div style="font-size: 1.5rem; font-weight: 700;">{{ $donation->donor_count }}</div>
                        </div>

                        <div
                            style="padding: 16px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 10px; color: white;">
                            <div style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 4px;">Total Transaksi</div>
                            <div style="font-size: 1.5rem; font-weight: 700;">{{ $donation->transactions_count ?? 0 }}
                            </div>
                        </div>

                        @if ($donation->days_left !== null)
                            <div
                                style="padding: 16px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 10px; color: white;">
                                <div style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 4px;">Waktu Tersisa</div>
                                <div style="font-size: 1.5rem; font-weight: 700;">{{ $donation->days_left }} Hari</div>
                            </div>
                        @endif
                    </div>
                </div>

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
    </script>
@endpush
