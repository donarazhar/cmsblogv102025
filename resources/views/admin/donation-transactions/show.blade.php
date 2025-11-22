@extends('admin.layouts.app')

@section('title', 'Detail Transaksi Donasi')

@push('styles')
    <style>
        .detail-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--border);
            margin-bottom: 20px;
        }

        .detail-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .detail-item {
            padding: 16px;
            background: var(--light);
            border-radius: 8px;
        }

        .detail-label {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 1.05rem;
            color: var(--dark);
            font-weight: 600;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-verified {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-cancelled {
            background: #f3f4f6;
            color: #4b5563;
        }

        .payment-proof-container {
            text-align: center;
            padding: 20px;
            background: var(--light);
            border-radius: 8px;
        }

        .payment-proof-img {
            max-width: 100%;
            max-height: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
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

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-secondary {
            background: var(--light);
            color: var(--dark);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 24px;
        }

        .timeline-item:before {
            content: '';
            position: absolute;
            left: -23px;
            top: 8px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--primary);
        }

        .timeline-item:after {
            content: '';
            position: absolute;
            left: -19px;
            top: 18px;
            width: 2px;
            height: calc(100% - 10px);
            background: var(--border);
        }

        .timeline-item:last-child:after {
            display: none;
        }

        .timeline-date {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .timeline-content {
            font-weight: 600;
            color: var(--dark);
        }

        @media (max-width: 768px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 class="page-title">Detail Transaksi Donasi</h1>
                <p class="page-subtitle">Kode Transaksi: <strong>{{ $transaction->transaction_code }}</strong></p>
            </div>
            <a href="{{ route('admin.donation-transactions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Transaction Info -->
    <div class="detail-card">
        <div class="detail-header">
            <h2 class="detail-title">
                <i class="fas fa-info-circle"></i> Informasi Transaksi
            </h2>
            <div>
                @if ($transaction->status === 'verified')
                    <span class="status-badge status-verified">
                        <i class="fas fa-check-circle"></i> Verified
                    </span>
                @elseif($transaction->status === 'pending')
                    <span class="status-badge status-pending">
                        <i class="fas fa-clock"></i> Pending
                    </span>
                @elseif($transaction->status === 'rejected')
                    <span class="status-badge status-rejected">
                        <i class="fas fa-times-circle"></i> Rejected
                    </span>
                @else
                    <span class="status-badge status-cancelled">
                        <i class="fas fa-ban"></i> Cancelled
                    </span>
                @endif
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Kode Transaksi</div>
                <div class="detail-value">{{ $transaction->transaction_code }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Jumlah Donasi</div>
                <div class="detail-value" style="color: var(--primary); font-size: 1.5rem;">
                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Campaign</div>
                <div class="detail-value">{{ $transaction->donation->campaign_name }}</div>
                <small style="color: #6b7280;">{{ ucfirst($transaction->donation->category) }}</small>
            </div>

            <div class="detail-item">
                <div class="detail-label">Metode Pembayaran</div>
                <div class="detail-value">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Tanggal Transaksi</div>
                <div class="detail-value">{{ $transaction->created_at->format('d F Y, H:i') }} WIB</div>
            </div>

            @if ($transaction->verified_at)
                <div class="detail-item">
                    <div class="detail-label">Tanggal Verifikasi</div>
                    <div class="detail-value">{{ $transaction->verified_at->format('d F Y, H:i') }} WIB</div>
                    @if ($transaction->verifier)
                        <small style="color: #6b7280;">oleh {{ $transaction->verifier->name }}</small>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Donor Info -->
    <div class="detail-card">
        <div class="detail-header">
            <h2 class="detail-title">
                <i class="fas fa-user"></i> Informasi Donatur
            </h2>
            @if ($transaction->is_anonymous)
                <span
                    style="padding: 6px 12px; background: #e0e7ff; color: #3730a3; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">
                    <i class="fas fa-user-secret"></i> Anonim
                </span>
            @endif
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Nama</div>
                <div class="detail-value">
                    @if ($transaction->is_anonymous)
                        <i class="fas fa-user-secret"></i> Hamba Allah
                    @else
                        {{ $transaction->donor_name }}
                    @endif
                </div>
            </div>

            @if (!$transaction->is_anonymous)
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ $transaction->donor_email ?? '-' }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Nomor Telepon</div>
                    <div class="detail-value">{{ $transaction->donor_phone ?? '-' }}</div>
                </div>
            @endif

            @if ($transaction->user_id)
                <div class="detail-item">
                    <div class="detail-label">User Account</div>
                    <div class="detail-value">
                        <i class="fas fa-user-check" style="color: var(--success);"></i>
                        Terdaftar
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Payment Proof -->
    @if ($transaction->payment_proof)
        <div class="detail-card">
            <div class="detail-header">
                <h2 class="detail-title">
                    <i class="fas fa-receipt"></i> Bukti Pembayaran
                </h2>
                <a href="{{ Storage::url($transaction->payment_proof) }}" target="_blank" class="btn btn-primary"
                    style="padding: 8px 16px; font-size: 0.9rem;">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
            <div class="payment-proof-container">
                <img src="{{ Storage::url($transaction->payment_proof) }}" alt="Payment Proof" class="payment-proof-img">
            </div>
        </div>
    @endif

    <!-- Notes -->
    @if ($transaction->notes || $transaction->admin_notes)
        <div class="detail-card">
            <div class="detail-header">
                <h2 class="detail-title">
                    <i class="fas fa-sticky-note"></i> Catatan
                </h2>
            </div>

            @if ($transaction->notes)
                <div
                    style="margin-bottom: 20px; padding: 16px; background: #dbeafe; border-left: 4px solid #3b82f6; border-radius: 8px;">
                    <div style="font-weight: 600; margin-bottom: 8px; color: #1e40af;">
                        <i class="fas fa-comment-dots"></i> Catatan Donatur
                    </div>
                    <div style="color: #1e40af;">{{ $transaction->notes }}</div>
                </div>
            @endif

            @if ($transaction->admin_notes)
                <div style="padding: 16px; background: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 8px;">
                    <div style="font-weight: 600; margin-bottom: 8px; color: #92400e;">
                        <i class="fas fa-user-shield"></i> Catatan Admin
                    </div>
                    <div style="color: #92400e;">{{ $transaction->admin_notes }}</div>
                </div>
            @endif
        </div>
    @endif

    <!-- Timeline -->
    <div class="detail-card">
        <div class="detail-header">
            <h2 class="detail-title">
                <i class="fas fa-history"></i> Riwayat
            </h2>
        </div>

        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-date">{{ $transaction->created_at->format('d M Y, H:i') }}</div>
                <div class="timeline-content">
                    <i class="fas fa-plus-circle" style="color: var(--primary);"></i>
                    Transaksi dibuat
                </div>
            </div>

            @if ($transaction->verified_at)
                <div class="timeline-item">
                    <div class="timeline-date">{{ $transaction->verified_at->format('d M Y, H:i') }}</div>
                    <div class="timeline-content">
                        <i class="fas fa-check-circle" style="color: var(--success);"></i>
                        Transaksi diverifikasi
                        @if ($transaction->verifier)
                            oleh {{ $transaction->verifier->name }}
                        @endif
                    </div>
                </div>
            @endif

            @if ($transaction->status === 'rejected')
                <div class="timeline-item">
                    <div class="timeline-date">{{ $transaction->updated_at->format('d M Y, H:i') }}</div>
                    <div class="timeline-content">
                        <i class="fas fa-times-circle" style="color: var(--danger);"></i>
                        Transaksi ditolak
                    </div>
                </div>
            @endif

            <div class="timeline-item">
                <div class="timeline-date">{{ $transaction->updated_at->format('d M Y, H:i') }}</div>
                <div class="timeline-content">
                    <i class="fas fa-sync-alt" style="color: #6b7280;"></i>
                    Terakhir diupdate
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="detail-card">
        <div class="action-buttons">
            @if ($transaction->status === 'pending')
                <form action="{{ route('admin.donation-transactions.verify', $transaction) }}" method="POST"
                    style="flex: 1;">
                    @csrf
                    <button type="submit" class="btn btn-success" style="width: 100%;"
                        onclick="return confirm('Verifikasi transaksi ini?')">
                        <i class="fas fa-check"></i> Verifikasi Transaksi
                    </button>
                </form>

                <button type="button" onclick="showRejectModal()" class="btn btn-danger" style="flex: 1;">
                    <i class="fas fa-times"></i> Tolak Transaksi
                </button>
            @endif

            <a href="{{ route('admin.donation-transactions.edit', $transaction) }}" class="btn btn-warning"
                style="flex: 1;">
                <i class="fas fa-edit"></i> Edit Transaksi
            </a>

            <form action="{{ route('admin.donation-transactions.destroy', $transaction) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')" style="flex: 1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="width: 100%;">
                    <i class="fas fa-trash"></i> Hapus Transaksi
                </button>
            </form>
        </div>
    </div>

    <!-- Reject Modal -->
    @if ($transaction->status === 'pending')
        <div id="rejectModal"
            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
            <div style="background: white; border-radius: 12px; padding: 24px; max-width: 500px; width: 90%;">
                <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 16px;">Tolak Transaksi</h3>
                <form action="{{ route('admin.donation-transactions.reject', $transaction) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom<label style="display: block; margin-bottom: 8px;
                            font-weight: 600; color: var(--dark);">
                            Alasan Penolakan <span style="color: var(--danger);">*</span>
                        </label>
                        <textarea name="admin_notes" rows="4" required
                            style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem; resize: vertical;"
                            placeholder="Jelaskan alasan penolakan transaksi ini..."></textarea>
                    </div>
                    <div style="display: flex; gap: 12px; justify-content: flex-end;">
                        <button type="button" onclick="closeRejectModal()"
                            style="padding: 10px 24px; background: var(--light); color: var(--dark); border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            Batal
                        </button>
                        <button type="submit"
                            style="padding: 10px 24px; background: var(--danger); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            <i class="fas fa-times"></i> Tolak Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        function showRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.style.display = 'flex';
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.style.display = 'none';
        }

        // Close modal on outside click
        document.getElementById('rejectModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRejectModal();
            }
        });
    </script>
@endpush
