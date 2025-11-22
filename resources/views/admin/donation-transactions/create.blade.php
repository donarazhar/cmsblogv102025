@extends('admin.layouts.app')

@section('title', 'Tambah Transaksi Donasi')

@section('content')
    <div class="page-header">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 8px;">
            <a href="{{ route('admin.donation-transactions.index') }}"
                style="width: 40px; height: 40px; background: var(--light); border-radius: 10px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: var(--dark);">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="page-title">Tambah Transaksi Donasi</h1>
                <p class="page-subtitle">Input transaksi donasi manual</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.donation-transactions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 24px;">
            <!-- Main Content -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <!-- Donation Information -->
                <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                        <i class="fas fa-hand-holding-heart" style="color: var(--primary);"></i> Informasi Donasi
                    </h3>

                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                            Campaign Donasi <span style="color: var(--danger);">*</span>
                        </label>
                        <select name="donation_id" required
                            style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            <option value="">Pilih Campaign</option>
                            @foreach ($donations as $donation)
                                <option value="{{ $donation->id }}"
                                    {{ old('donation_id') == $donation->id ? 'selected' : '' }}>
                                    {{ $donation->campaign_name }} - {{ ucfirst($donation->category) }}
                                </option>
                            @endforeach
                        </select>
                        @error('donation_id')
                            <span
                                style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Donor Information -->
                <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                        <i class="fas fa-user" style="color: var(--primary);"></i> Informasi Donatur
                    </h3>

                    <div style="display: grid; gap: 20px;">
                        <!-- Donor Name -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Nama Donatur <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="text" name="donor_name" value="{{ old('donor_name') }}" required
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                placeholder="Nama lengkap donatur">
                            @error('donor_name')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                            <!-- Donor Email -->
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                    Email
                                </label>
                                <input type="email" name="donor_email" value="{{ old('donor_email') }}"
                                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                    placeholder="email@example.com">
                                @error('donor_email')
                                    <span
                                        style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Donor Phone -->
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                    No. Telepon
                                </label>
                                <input type="text" name="donor_phone" value="{{ old('donor_phone') }}"
                                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                    placeholder="08123456789">
                                @error('donor_phone')
                                    <span
                                        style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Anonymous -->
                        <div>
                            <label
                                style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; background: var(--light); border-radius: 8px;">
                                <input type="checkbox" name="is_anonymous" value="1"
                                    {{ old('is_anonymous') ? 'checked' : '' }}
                                    style="width: 18px; height: 18px; cursor: pointer;">
                                <div>
                                    <div style="font-weight: 600; color: var(--dark);">Donatur Anonim</div>
                                    <div style="font-size: 0.85rem; color: #6b7280;">Sembunyikan identitas donatur</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                        <i class="fas fa-credit-card" style="color: var(--primary);"></i> Informasi Pembayaran
                    </h3>

                    <div style="display: grid; gap: 20px;">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                            <!-- Amount -->
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                    Jumlah Donasi (Rp) <span style="color: var(--danger);">*</span>
                                </label>
                                <input type="number" name="amount" value="{{ old('amount') }}" required min="1000"
                                    step="1000"
                                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                    placeholder="50000">
                                @error('amount')
                                    <span
                                        style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                    Metode Pembayaran <span style="color: var(--danger);">*</span>
                                </label>
                                <select name="payment_method" required
                                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                                    <option value="">Pilih Metode</option>
                                    <option value="bank_transfer"
                                        {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank
                                    </option>
                                    <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>QRIS
                                    </option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tunai
                                    </option>
                                    <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('payment_method')
                                    <span
                                        style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Proof -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Bukti Pembayaran
                            </label>
                            <input type="file" name="payment_proof" accept="image/*" id="paymentProofInput"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Format: JPG, PNG. Maksimal 2MB
                            </p>
                            @error('payment_proof')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror

                            <!-- Preview -->
                            <div id="paymentProofPreview" style="margin-top: 12px; display: none;">
                                <img id="previewImg" src="" alt="Preview"
                                    style="max-width: 300px; height: auto; border-radius: 8px; border: 1px solid var(--border);">
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                                Catatan Donatur
                            </label>
                            <textarea name="notes" rows="3"
                                style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem; resize: vertical;"
                                placeholder="Catatan atau pesan dari donatur (opsional)">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <!-- Status -->
                <div
                    style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                        <i class="fas fa-check-circle" style="color: var(--primary);"></i> Status
                    </h3>

                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                            Status Transaksi <span style="color: var(--danger);">*</span>
                        </label>
                        <select name="status" required
                            style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="verified" {{ old('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <p style="font-size: 0.85rem; color: #6b7280; margin-top: 8px;">
                            <i class="fas fa-info-circle"></i> Pilih "Verified" jika transaksi sudah dikonfirmasi
                        </p>
                        @error('status')
                            <span
                                style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
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
                            <i class="fas fa-save"></i> Simpan Transaksi
                        </button>
                        <a href="{{ route('admin.donation-transactions.index') }}"
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
                            <h4 style="font-weight: 600; color: #1e40af; margin-bottom: 8px;">Informasi</h4>
                            <ul
                                style="font-size: 0.85rem; color: #1e40af; line-height: 1.6; margin: 0; padding-left: 20px;">
                                <li>Kode transaksi akan di-generate otomatis</li>
                                <li>Status "Verified" akan langsung memperbarui jumlah donasi</li>
                                <li>Upload bukti pembayaran jika ada</li>
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
        @media (max-width: 1024px) {
            [style*="grid-template-columns: 1fr 350px"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Payment Proof Preview
        document.getElementById('paymentProofInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('paymentProofPreview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
