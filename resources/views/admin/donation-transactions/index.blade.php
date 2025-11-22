@extends('admin.layouts.app')

@section('title', 'Transaksi Donasi')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Transaksi Donasi</h1>
                <p class="page-subtitle">Kelola dan verifikasi transaksi donasi</p>
            </div>
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('admin.donation-transactions.export', request()->query()) }}"
                    style="padding: 12px 24px; background: var(--success); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-file-excel"></i>
                    Export CSV
                </a>
                <a href="{{ route('admin.donation-transactions.create') }}"
                    style="padding: 12px 24px; background: var(--primary); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-plus"></i>
                    Tambah Transaksi
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 8px;">Total Transaksi</div>
                    <div style="font-size: 2rem; font-weight: 700;">{{ $stats['total'] }}</div>
                </div>
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-receipt" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div
            style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 8px;">Pending</div>
                    <div style="font-size: 2rem; font-weight: 700;">{{ $stats['pending'] }}</div>
                </div>
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-clock" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div
            style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 8px;">Verified</div>
                    <div style="font-size: 2rem; font-weight: 700;">{{ $stats['verified'] }}</div>
                </div>
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div
            style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 8px;">Total Terkumpul</div>
                    <div style="font-size: 1.3rem; font-weight: 700;">Rp
                        {{ number_format($stats['total_amount'], 0, ',', '.') }}</div>
                </div>
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-money-bill-wave" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div
        style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form method="GET" action="{{ route('admin.donation-transactions.index') }}">
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
                <div>
                    <label
                        style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem; color: var(--dark);">
                        Status
                    </label>
                    <select name="status"
                        style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.9rem;">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </div>

                <div>
                    <label
                        style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem; color: var(--dark);">
                        Campaign
                    </label>
                    <select name="donation_id"
                        style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.9rem;">
                        <option value="">Semua Campaign</option>
                        @foreach ($donations as $donation)
                            <option value="{{ $donation->id }}"
                                {{ request('donation_id') == $donation->id ? 'selected' : '' }}>
                                {{ $donation->campaign_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label
                        style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem; color: var(--dark);">
                        Cari
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Kode/Nama/Email/Phone..."
                        style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.9rem;">
                </div>

                <div style="display: flex; gap: 8px;">
                    <button type="submit"
                        style="flex: 1; padding: 10px 20px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.donation-transactions.index') }}"
                        style="padding: 10px 20px; background: var(--light); color: var(--dark); border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Transactions Table -->
    <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        @if ($transactions->count() > 0)
            <!-- Bulk Actions -->
            <form id="bulkForm" action="{{ route('admin.donation-transactions.bulk-verify') }}" method="POST">
                @csrf
                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid var(--border);">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <input type="checkbox" id="selectAll" style="width: 18px; height: 18px; cursor: pointer;">
                        <label for="selectAll" style="font-weight: 600; cursor: pointer;">Pilih Semua</label>
                        <span id="selectedCount" style="color: #6b7280; font-size: 0.9rem;"></span>
                    </div>
                    <button type="submit" id="bulkVerifyBtn"
                        style="padding: 8px 20px; background: var(--success); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: none;">
                        <i class="fas fa-check-double"></i> Verifikasi Terpilih
                    </button>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border);">
                                <th
                                    style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark); width: 40px;">
                                </th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Kode</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Campaign
                                </th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Donatur
                                </th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Jumlah
                                </th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Metode
                                </th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Status
                                </th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Tanggal
                                </th>
                                <th style="padding: 12px; text-align: center; font-weight: 600; color: var(--dark);">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr style="border-bottom: 1px solid var(--border);">
                                    <td style="padding: 12px;">
                                        @if ($transaction->status === 'pending')
                                            <input type="checkbox" name="transaction_ids[]"
                                                value="{{ $transaction->id }}" class="transaction-checkbox"
                                                style="width: 18px; height: 18px; cursor: pointer;">
                                        @endif
                                    </td>
                                    <td style="padding: 12px;">
                                        <div style="font-weight: 600; color: var(--primary); font-size: 0.9rem;">
                                            {{ $transaction->transaction_code }}</div>
                                    </td>
                                    <td style="padding: 12px;">
                                        <div style="font-weight: 600;">{{ $transaction->donation->campaign_name }}</div>
                                        <div style="font-size: 0.85rem; color: #6b7280;">
                                            {{ ucfirst($transaction->donation->category) }}</div>
                                    </td>
                                    <td style="padding: 12px;">
                                        <div style="font-weight: 600;">
                                            @if ($transaction->is_anonymous)
                                                <i class="fas fa-user-secret"></i> Hamba Allah
                                            @else
                                                {{ $transaction->donor_name }}
                                            @endif
                                        </div>
                                        @if (!$transaction->is_anonymous)
                                            <div style="font-size: 0.85rem; color: #6b7280;">
                                                @if ($transaction->donor_email)
                                                    <i class="fas fa-envelope"></i> {{ $transaction->donor_email }}
                                                @endif
                                                @if ($transaction->donor_phone)
                                                    <br><i class="fas fa-phone"></i> {{ $transaction->donor_phone }}
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 12px;">
                                        <div style="font-weight: 700; color: var(--primary); font-size: 1.1rem;">
                                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td style="padding: 12px;">
                                        <span
                                            style="padding: 4px 10px; background: #e0e7ff; color: #3730a3; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">
                                            {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px;">
                                        @if ($transaction->status === 'verified')
                                            <span
                                                style="padding: 4px 12px; background: #d1fae5; color: #065f46; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                                <i class="fas fa-check-circle"></i> Verified
                                            </span>
                                        @elseif($transaction->status === 'pending')
                                            <span
                                                style="padding: 4px 12px; background: #fef3c7; color: #92400e; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                                <i class="fas fa-clock"></i> Pending
                                            </span>
                                        @elseif($transaction->status === 'rejected')
                                            <span
                                                style="padding: 4px 12px; background: #fee2e2; color: #991b1b; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                                <i class="fas fa-times-circle"></i> Rejected
                                            </span>
                                        @else
                                            <span
                                                style="padding: 4px 12px; background: #f3f4f6; color: #4b5563; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                                <i class="fas fa-ban"></i> Cancelled
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 12px;">
                                        <div style="font-size: 0.9rem;">{{ $transaction->created_at->format('d M Y') }}
                                        </div>
                                        <div style="font-size: 0.85rem; color: #6b7280;">
                                            {{ $transaction->created_at->format('H:i') }}</div>
                                    </td>
                                    <td style="padding: 12px; text-align: center;">
                                        <div style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                                            <a href="{{ route('admin.donation-transactions.show', $transaction) }}"
                                                style="padding: 6px 12px; background: var(--info); color: white; border-radius: 6px; text-decoration: none; font-size: 0.85rem;"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($transaction->status === 'pending')
                                                <form
                                                    action="{{ route('admin.donation-transactions.verify', $transaction) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit"
                                                        style="padding: 6px 12px; background: var(--success); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem;"
                                                        title="Verifikasi"
                                                        onclick="return confirm('Verifikasi transaksi ini?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>

                                                <button type="button" onclick="showRejectModal({{ $transaction->id }})"
                                                    style="padding: 6px 12px; background: var(--danger); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem;"
                                                    title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif

                                            <a href="{{ route('admin.donation-transactions.edit', $transaction) }}"
                                                style="padding: 6px 12px; background: var(--warning); color: white; border-radius: 6px; text-decoration: none; font-size: 0.85rem;"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form
                                                action="{{ route('admin.donation-transactions.destroy', $transaction) }}"
                                                method="POST"
                                                style="display: inline;"onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="padding: 6px 12px; background: var(--danger); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem;"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
            
            <div class="pagination">
                <!-- Pagination -->
                <div style="margin-top: 50px; text-align:center; padding: 10px; border-radius: 5px;">
                    {{ $transactions->links('vendor.pagination.simple') }}
                </div>
            </div>
        @else
            <div style="text-align: center; padding: 48px 24px; color: #6b7280;">
                <i class="fas fa-receipt" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.3;"></i>
                <p style="font-size: 1.1rem; margin-bottom: 8px;">
                    @if (request()->has('status') || request()->has('search') || request()->has('donation_id'))
                        Tidak ada transaksi yang sesuai dengan filter
                    @else
                        Belum ada transaksi donasi
                    @endif
                </p>
                <p style="font-size: 0.95rem;">
                    @if (request()->has('status') || request()->has('search') || request()->has('donation_id'))
                        Coba ubah filter atau reset pencarian
                    @else
                        Transaksi donasi akan muncul di sini
                    @endif
                </p>
            </div>
        @endif
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 12px; padding: 24px; max-width: 500px; width: 90%;">
            <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 16px;">Tolak Transaksi</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
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
@endsection

@push('scripts')
    <script>
        // Select All Checkbox
        document.getElementById('selectAll')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.transaction-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateSelectedCount();
        });

        // Individual Checkbox
        document.querySelectorAll('.transaction-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });

        function updateSelectedCount() {
            const checked = document.querySelectorAll('.transaction-checkbox:checked').length;
            const selectedCount = document.getElementById('selectedCount');
            const bulkVerifyBtn = document.getElementById('bulkVerifyBtn');

            if (checked > 0) {
                selectedCount.textContent = `(${checked} dipilih)`;
                bulkVerifyBtn.style.display = 'block';
            } else {
                selectedCount.textContent = '';
                bulkVerifyBtn.style.display = 'none';
            }
        }

        // Reject Modal
        function showRejectModal(transactionId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/admin/donation-transactions/${transactionId}/reject`;
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
    </script>
@endpush
