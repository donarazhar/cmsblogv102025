@extends('admin.layouts.app')

@section('title', 'User Management')

@section('content')
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            padding: 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark);
        }

        .filter-bar {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            padding: 20px 25px;
            background: var(--light);
            border-bottom: 1px solid var(--border);
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .filter-input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .btn {
            padding: 10px 20px;
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

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .btn-icon {
            width: 35px;
            height: 35px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead th {
            background: var(--light);
            padding: 14px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border);
        }

        .data-table tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 0.95rem;
            vertical-align: middle;
        }

        .data-table tbody tr {
            transition: background 0.2s ease;
        }

        .data-table tbody tr:hover {
            background: #f0f7ff;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark);
        }

        .user-email {
            font-size: 0.85rem;
            color: #6b7280;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .actions-cell {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding: 25px;
            border-top: 1px solid var(--border);
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.4s ease-out;
        }

        .self-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-left: 8px;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .data-table thead {
                display: none;
            }

            .data-table tbody tr {
                display: block;
                padding: 15px 20px;
                border-bottom: 1px solid var(--border);
            }

            .data-table tbody td {
                display: block;
                padding: 5px 0;
                border: none;
            }

            .data-table tbody td:before {
                content: attr(data-label);
                font-weight: 600;
                font-size: 0.8rem;
                color: #6b7280;
                display: block;
                margin-bottom: 3px;
            }

            .actions-cell {
                margin-top: 10px;
                padding-top: 10px;
                border-top: 1px solid var(--border);
            }

            .filter-bar {
                flex-direction: column;
            }
        }
    </style>

    <div class="page-header">
        <h1 class="page-title">User Management</h1>
        <p class="page-subtitle">Kelola akun pengguna sistem admin</p>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #dbeafe; color: var(--primary);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-label">Total User</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #d1fae5; color: #059669;">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-label">Terverifikasi</div>
            <div class="stat-value">{{ $stats['verified'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7; color: #d97706;">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="stat-label">Belum Verifikasi</div>
            <div class="stat-value">{{ $stats['unverified'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #e0e7ff; color: #4f46e5;">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="stat-label">Baru (30 Hari)</div>
            <div class="stat-value">{{ $stats['recent'] }}</div>
        </div>
    </div>

    {{-- Alert for errors --}}
    @if (session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Main Card --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Semua User</h2>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah User
            </a>
        </div>

        {{-- Filter Bar --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="filter-bar">
            <div class="filter-group" style="flex: 2;">
                <label class="filter-label">Cari User</label>
                <input type="text" name="search" class="filter-input" placeholder="Nama atau email..."
                    value="{{ request('search') }}">
            </div>
            <div class="filter-group" style="display: flex; align-items: flex-end; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="fas fa-search"></i>
                    Cari
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn" style="background: #e5e7eb; color: var(--dark);">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>

        {{-- User Table --}}
        @if ($users->count() > 0)
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Status</th>
                            <th>Terdaftar</th>
                            <th>Login Terakhir</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td data-label="User">
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="user-name">
                                                {{ $user->name }}
                                                @if ($user->id === auth()->id())
                                                    <span class="self-badge">ANDA</span>
                                                @endif
                                            </div>
                                            <div class="user-email">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Status">
                                    @if ($user->email_verified_at)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Terverifikasi
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Belum Verifikasi
                                        </span>
                                    @endif
                                </td>
                                <td data-label="Terdaftar">
                                    <span style="color: #6b7280; font-size: 0.9rem;">
                                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                    </span>
                                    <br>
                                    <span style="color: #9ca3af; font-size: 0.8rem;">
                                        {{ $user->created_at ? $user->created_at->diffForHumans() : '' }}
                                    </span>
                                </td>
                                <td data-label="Login Terakhir">
                                    <span style="color: #6b7280; font-size: 0.9rem;">
                                        {{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : '-' }}
                                    </span>
                                </td>
                                <td data-label="Aksi">
                                    <div class="actions-cell" style="justify-content: center;">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="btn btn-primary btn-sm btn-icon" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.users.change-password', $user) }}"
                                            class="btn btn-warning btn-sm btn-icon" title="Ubah Password">
                                            <i class="fas fa-key"></i>
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                style="display: inline;"
                                                onsubmit="return confirm('Yakin hapus user {{ $user->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm btn-icon"
                                                    title="Hapus User">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 10px;">Belum Ada User</h3>
                <p style="color: #6b7280; margin-bottom: 25px;">Mulai tambahkan user baru untuk mengelola admin panel</p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah User Pertama
                </a>
            </div>
        @endif

        {{-- Pagination --}}
        @if ($users->hasPages())
            <div class="pagination">
                <div style="margin-top: 50px; text-align:center; padding: 10px; border-radius: 5px;">
                    {{ $users->links('vendor.pagination.simple') }}
                </div>
            </div>
        @endif
    </div>
@endsection
