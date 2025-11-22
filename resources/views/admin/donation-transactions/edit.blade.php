@extends('admin.layouts.app')

@section('title', 'Edit Transaksi Donasi')

@push('styles')
    <style>
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 40px;
        }

        .payment-proof-preview {
            max-width: 300px;
            margin-top: 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .file-upload-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-upload-label {
            display: block;
            padding: 12px;
            background: var(--light);
            border: 2px dashed var(--border);
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-label:hover {
            border-color: var(--primary);
            background: rgba(0, 83, 197, 0.05);
        }

        .file-upload-input {
            display: none;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            background: var(--light);
            border-radius: 8px;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .required {
            color: var(--danger);
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: var(--light);
            color: var(--dark);
        }

        .btn-secondary:hover {
            background: var(--border);
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
        }

        .alert-error ul {
            margin: 8px 0 0 20px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Edit Transaksi Donasi</h1>
                <p class="page-subtitle">Edit data transaksi donasi #{{ $transaction->transaction_code }}</p>
            </div>
            <a href="{{ route('admin.donation-transactions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <strong><i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form action="{{ route('admin.donation-transactions.update', $transaction) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                <!-- Campaign -->
                <div class="form-group">
                    <label class="form-label">
                        Campaign <span class="required">*</span>
                    </label>
                    <select name="donation_id" class="form-control form-select" required>
                        <option value="">Pilih Campaign</option>
                        @foreach ($donations as $donation)
                            <option value="{{ $donation->id }}"
                                {{ old('donation_id', $transaction->donation_id) == $donation->id ? 'selected' : '' }}>
                                {{ $donation->campaign_name }} ({{ ucfirst($donation->category) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Amount -->
                <div class="form-group">
                    <label class="form-label">
                        Jumlah Donasi <span class="required">*</span>
                    </label>
                    <input type="number" name="amount" class="form-control"
                        value="{{ old('amount', $transaction->amount) }}" min="10000" step="1000" required
                        placeholder="Minimal Rp 10.000">
                </div>

                <!-- Donor Name -->
                <div class="form-group">
                    <label class="form-label">
                        Nama Donatur <span class="required">*</span>
                    </label>
                    <input type="text" name="donor_name" class="form-control"
                        value="{{ old('donor_name', $transaction->donor_name) }}" required
                        placeholder="Nama lengkap donatur">
                </div>

                <!-- Donor Email -->
                <div class="form-group">
                    <label class="form-label">Email Donatur</label>
                    <input type="email" name="donor_email" class="form-control"
                        value="{{ old('donor_email', $transaction->donor_email) }}" placeholder="email@example.com">
                </div>

                <!-- Donor Phone -->
                <div class="form-group">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="donor_phone" class="form-control"
                        value="{{ old('donor_phone', $transaction->donor_phone) }}" placeholder="08xxxxxxxxxx">
                </div>

                <!-- Payment Method -->
                <div class="form-group">
                    <label class="form-label">
                        Metode Pembayaran <span class="required">*</span>
                    </label>
                    <select name="payment_method" class="form-control form-select" required>
                        <option value="bank_transfer"
                            {{ old('payment_method', $transaction->payment_method) == 'bank_transfer' ? 'selected' : '' }}>
                            Bank Transfer
                        </option>
                        <option value="qris"
                            {{ old('payment_method', $transaction->payment_method) == 'qris' ? 'selected' : '' }}>
                            QRIS
                        </option>
                        <option value="cash"
                            {{ old('payment_method', $transaction->payment_method) == 'cash' ? 'selected' : '' }}>
                            Cash
                        </option>
                        <option value="other"
                            {{ old('payment_method', $transaction->payment_method) == 'other' ? 'selected' : '' }}>
                            Lainnya
                        </option>
                    </select>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label class="form-label">
                        Status <span class="required">*</span>
                    </label>
                    <select name="status" class="form-control form-select" required>
                        <option value="pending" {{ old('status', $transaction->status) == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="verified" {{ old('status', $transaction->status) == 'verified' ? 'selected' : '' }}>
                            Verified
                        </option>
                        <option value="rejected" {{ old('status', $transaction->status) == 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>
                        <option value="cancelled"
                            {{ old('status', $transaction->status) == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>
                    </select>
                </div>

                <!-- Payment Proof -->
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label">Bukti Pembayaran</label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="payment_proof" id="payment_proof" class="file-upload-input"
                            accept="image/*">
                        <label for="payment_proof" class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"
                                style="font-size: 2rem; color: var(--primary); margin-bottom: 8px;"></i>
                            <div>Klik untuk upload bukti pembayaran</div>
                            <small style="color: #6b7280;">Format: JPG, PNG, JPEG (Max 2MB)</small>
                        </label>
                    </div>
                    @if ($transaction->payment_proof)
                        <div style="margin-top: 12px;">
                            <strong>Bukti pembayaran saat ini:</strong>
                            <img src="{{ Storage::url($transaction->payment_proof) }}" alt="Payment Proof"
                                class="payment-proof-preview">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label class="form-label">Catatan Donatur</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="Catatan atau pesan dari donatur">{{ old('notes', $transaction->notes) }}</textarea>
            </div>

            <!-- Admin Notes -->
            <div class="form-group">
                <label class="form-label">Catatan Admin</label>
                <textarea name="admin_notes" class="form-control" rows="3" placeholder="Catatan internal admin">{{ old('admin_notes', $transaction->admin_notes) }}</textarea>
            </div>

            <!-- Is Anonymous -->
            <div class="form-group">
                <div class="checkbox-wrapper">
                    <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1"
                        {{ old('is_anonymous', $transaction->is_anonymous) ? 'checked' : '' }}>
                    <label for="is_anonymous" style="margin: 0; cursor: pointer;">
                        <strong>Donasi Anonim</strong>
                        <small style="display: block; color: #6b7280;">
                            Nama donatur tidak akan ditampilkan di website
                        </small>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div
                style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border);">
                <a href="{{ route('admin.donation-transactions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Transaksi
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Preview uploaded image
        document.getElementById('payment_proof')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const label = document.querySelector('.file-upload-label');
                label.innerHTML = `
                <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--success); margin-bottom: 8px;"></i>
                <div>${file.name}</div>
                <small style="color: #6b7280;">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
            `;
            }
        });
    </script>
@endpush
