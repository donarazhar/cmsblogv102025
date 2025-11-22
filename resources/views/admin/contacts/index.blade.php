@extends('admin.layouts.app')

@section('title', 'Manajemen Kontak')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Manajemen Kontak</h1>
        <p class="page-subtitle">Kelola pesan dan pertanyaan dari pengunjung</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Contacts</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon" style="background: #dbeafe;">
                <i class="fas fa-envelope" style="color: #1e40af;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ \App\Models\Contact::count() }}</div>
                <div class="stat-label">Total Pesan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7;">
                <i class="fas fa-envelope-open" style="color: #92400e;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ \App\Models\Contact::where('status', 'new')->count() }}</div>
                <div class="stat-label">Pesan Baru</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #d1fae5;">
                <i class="fas fa-check-circle" style="color: #065f46;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ \App\Models\Contact::where('status', 'replied')->count() }}</div>
                <div class="stat-label">Sudah Dibalas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #e5e7eb;">
                <i class="fas fa-archive" style="color: #6b7280;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ \App\Models\Contact::where('status', 'archived')->count() }}</div>
                <div class="stat-label">Terarsip</div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Filter & Pencarian</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contacts.index') }}" method="GET">
                <div class="filter-grid">
                    <div class="filter-item">
                        <input type="text" name="search" class="form-control" placeholder="Cari pesan..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="filter-item">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Baru</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Dibaca</option>
                            <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Dibalas
                            </option>
                            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Terarsip
                            </option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <input type="date" name="date_from" class="form-control" placeholder="Dari Tanggal"
                            value="{{ request('date_from') }}">
                    </div>
                    <div class="filter-item">
                        <input type="date" name="date_to" class="form-control" placeholder="Sampai Tanggal"
                            value="{{ request('date_to') }}">
                    </div>
                    <div class="filter-item">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions & Export -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="bulk-actions-bar">
                <div class="bulk-actions-left">
                    <form action="{{ route('admin.contacts.bulk-action') }}" method="POST" id="bulkActionForm">
                        @csrf
                        <input type="hidden" name="contacts" id="selectedContacts">
                        <select name="action" id="bulkAction" class="form-select" style="width: auto;">
                            <option value="">Bulk Actions</option>
                            <option value="mark_read">Tandai Sudah Dibaca</option>
                            <option value="archive">Arsipkan</option>
                            <option value="delete">Hapus</option>
                        </select>
                        <button type="submit" class="btn btn-secondary" onclick="return applyBulkAction()">
                            <i class="fas fa-check"></i> Terapkan
                        </button>
                    </form>
                </div>
                <div class="bulk-actions-right">
                    <a href="{{ route('admin.contacts.export-csv', request()->query()) }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-flex">
                <h3 class="card-title">Daftar Pesan Kontak</h3>
                <div class="header-actions">
                    <span class="selected-count" id="selectedCount" style="display: none; margin-right: 15px;">
                        <strong>0</strong> dipilih
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="3%">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th width="5%">No</th>
                            <th width="15%">Pengirim</th>
                            <th width="25%">Subjek</th>
                            <th width="20%">Pesan</th>
                            <th width="10%">Status</th>
                            <th width="12%">Tanggal</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr class="{{ $contact->status == 'new' ? 'unread-row' : '' }}">
                                <td>
                                    <input type="checkbox" class="contact-checkbox" value="{{ $contact->id }}">
                                </td>
                                <td>{{ $contacts->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="sender-info">
                                        <strong>{{ $contact->name }}</strong>
                                        <div class="contact-details">
                                            <i class="fas fa-envelope"></i>
                                            <small>{{ $contact->email }}</small>
                                        </div>
                                        @if ($contact->phone)
                                            <div class="contact-details">
                                                <i class="fas fa-phone"></i>
                                                <small>{{ $contact->phone }}</small>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ Str::limit($contact->subject, 40) }}</strong>
                                    @if ($contact->status == 'new')
                                        <span class="badge badge-sm badge-warning">
                                            <i class="fas fa-star"></i> New
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="message-preview">
                                        {{ Str::limit($contact->message, 60) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-status-{{ $contact->status }}">
                                        @switch($contact->status)
                                            @case('new')
                                                <i class="fas fa-envelope"></i> Baru
                                            @break

                                            @case('read')
                                                <i class="fas fa-envelope-open"></i> Dibaca
                                            @break

                                            @case('replied')
                                                <i class="fas fa-reply"></i> Dibalas
                                            @break

                                            @case('archived')
                                                <i class="fas fa-archive"></i> Terarsip
                                            @break
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    <div class="date-info">
                                        {{ $contact->created_at->format('d M Y') }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $contact->created_at->format('H:i') }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.contacts.show', $contact) }}"
                                            class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada pesan kontak</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($contacts->hasPages())
                <div class="card-footer">
                    {{ $contacts->links('vendor.pagination.simple') }}
                </div>
            @endif
        </div>
    @endsection

    @push('styles')
        <style>
            /* Reuse existing styles + add contact-specific styles */
            .card {
                background: white;
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                border: 1px solid var(--border);
                margin-bottom: 20px;
            }

            .card-header {
                padding: 20px;
                border-bottom: 1px solid var(--border);
            }

            .card-header-flex {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .card-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: var(--dark);
                margin: 0;
            }

            .card-body {
                padding: 20px;
            }

            .card-footer {
                padding: 15px 20px;
                border-top: 1px solid var(--border);
                background: var(--light);
            }

            .mb-4 {
                margin-bottom: 1.5rem;
            }

            /* Stats Grid */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 20px;
            }

            .stat-card {
                background: white;
                border-radius: 12px;
                padding: 20px;
                display: flex;
                align-items: center;
                gap: 15px;
                border: 1px solid var(--border);
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
            }

            .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .stat-icon {
                width: 60px;
                height: 60px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                flex-shrink: 0;
            }

            .stat-value {
                font-size: 2rem;
                font-weight: 700;
                color: var(--dark);
                line-height: 1;
            }

            .stat-label {
                font-size: 0.9rem;
                color: #6b7280;
                margin-top: 4px;
            }

            /* Filter Grid */
            .filter-grid {
                display: grid;
                grid-template-columns: 2fr 1fr 1fr 1fr auto;
                gap: 1rem;
            }

            /* Bulk Actions */
            .bulk-actions-bar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 15px;
            }

            .bulk-actions-left {
                display: flex;
                gap: 10px;
                align-items: center;
            }

            /* Form Controls */
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

            /* Buttons */
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

            .btn-success {
                background: var(--success);
                color: white;
            }

            .btn-success:hover {
                background: #059669;
            }

            .btn-sm {
                padding: 6px 12px;
                font-size: 0.85rem;
            }

            .btn-info {
                background: var(--info);
                color: white;
            }

            .btn-info:hover {
                background: #2563eb;
            }

            .btn-danger {
                background: var(--danger);
                color: white;
            }

            .btn-danger:hover {
                background: #dc2626;
            }

            .btn-group {
                display: flex;
                gap: 5px;
            }

            .w-100 {
                width: 100%;
            }

            /* Table */
            .table {
                width: 100%;
                border-collapse: collapse;
            }

            .table thead th {
                background: var(--light);
                color: var(--dark);
                font-weight: 600;
                padding: 12px;
                border-bottom: 2px solid var(--border);
                font-size: 0.9rem;
                text-align: left;
            }

            .table tbody td {
                padding: 12px;
                vertical-align: middle;
                border-bottom: 1px solid var(--border);
            }

            .table tbody tr:hover {
                background: var(--light);
            }

            .unread-row {
                background: #fef3c7;
            }

            .unread-row:hover {
                background: #fde68a;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            /* Contact specific styles */
            .sender-info strong {
                display: block;
                color: var(--dark);
                margin-bottom: 4px;
            }

            .contact-details {
                display: flex;
                align-items: center;
                gap: 5px;
                color: #6b7280;
                font-size: 0.85rem;
                margin-top: 2px;
            }

            .contact-details i {
                width: 14px;
            }

            .message-preview {
                color: #6b7280;
                font-size: 0.9rem;
                line-height: 1.4;
            }

            .date-info {
                font-size: 0.9rem;
                color: var(--dark);
            }

            /* Badges */
            .badge {
                padding: 5px 12px;
                border-radius: 6px;
                font-size: 0.8rem;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }

            .badge-sm {
                padding: 3px 8px;
                font-size: 0.7rem;
            }

            .badge-warning {
                background: #fef3c7;
                color: #92400e;
            }

            .badge-status-new {
                background: #fef3c7;
                color: #92400e;
            }

            .badge-status-read {
                background: #dbeafe;
                color: #1e40af;
            }

            .badge-status-replied {
                background: #d1fae5;
                color: #065f46;
            }

            .badge-status-archived {
                background: #e5e7eb;
                color: #374151;
            }

            .selected-count {
                color: var(--primary);
                font-size: 0.95rem;
            }

            .text-center {
                text-align: center;
            }

            .text-muted {
                color: #6b7280;
            }

            .py-5 {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }

            .mb-3 {
                margin-bottom: 1rem;
            }

            .fa-3x {
                font-size: 3rem;
            }

            /* Responsive */
            @media (max-width: 1200px) {
                .filter-grid {
                    grid-template-columns: 1fr 1fr;
                }
            }

            @media (max-width: 768px) {
                .stats-grid {
                    grid-template-columns: 1fr;
                }

                .filter-grid {
                    grid-template-columns: 1fr;
                }

                .bulk-actions-bar {
                    flex-direction: column;
                    align-items: stretch;
                }

                .bulk-actions-left {
                    flex-direction: column;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Check All functionality
            document.getElementById('checkAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.contact-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSelectedCount();
            });

            // Individual checkbox change
            document.querySelectorAll('.contact-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            function updateSelectedCount() {
                const selected = document.querySelectorAll('.contact-checkbox:checked');
                const count = selected.length;
                const countDisplay = document.getElementById('selectedCount');
                const countNumber = countDisplay.querySelector('strong');

                if (count > 0) {
                    countNumber.textContent = count;
                    countDisplay.style.display = 'inline';
                } else {
                    countDisplay.style.display = 'none';
                }
            }

            function applyBulkAction() {
                const selected = document.querySelectorAll('.contact-checkbox:checked');
                const action = document.getElementById('bulkAction').value;

                if (selected.length === 0) {
                    alert('Pilih minimal satu pesan!');
                    return false;
                }

                if (!action) {
                    alert('Pilih aksi yang akan dilakukan!');
                    return false;
                }

                const ids = Array.from(selected).map(cb => cb.value);
                document.getElementById('selectedContacts').value = JSON.stringify(ids);

                if (action === 'delete') {
                    return confirm(`Apakah Anda yakin ingin menghapus ${selected.length} pesan?`);
                }

                return true;
            }
        </script>
    @endpush
