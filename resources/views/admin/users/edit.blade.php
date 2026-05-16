@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
    <style>
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

        .card-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .form-label .required {
            color: var(--danger);
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
        }

        .form-hint {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 6px;
        }

        .form-error {
            font-size: 0.85rem;
            color: var(--danger);
            margin-top: 6px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: var(--light);
            border-radius: 8px;
            cursor: pointer;
        }

        .form-check input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .form-check-label {
            font-weight: 500;
            color: var(--dark);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
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

        .btn-secondary:hover {
            background: #d1d5db;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            margin-top: 10px;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            font-size: 1rem;
            padding: 5px;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .user-info-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-info-name {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .user-info-email {
            opacity: 0.8;
            font-size: 0.95rem;
        }

        .user-info-date {
            opacity: 0.7;
            font-size: 0.85rem;
            margin-top: 3px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="page-header">
        <h1 class="page-title">Edit User</h1>
        <p class="page-subtitle">Perbarui informasi akun pengguna</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.users.index') }}">User Management</a>
            <span>/</span>
            <span>Edit User</span>
        </div>
    </div>

    {{-- User Info Banner --}}
    <div class="user-info-card">
        <div class="user-info-avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <div class="user-info-name">{{ $user->name }}</div>
            <div class="user-info-email">{{ $user->email }}</div>
            <div class="user-info-date">Terdaftar sejak {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-user-edit" style="color: var(--primary); margin-right: 10px;"></i>Form Edit User</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}"
                        placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email <span class="required">*</span></label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}"
                        placeholder="contoh@email.com" required>
                    @error('email')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Role <span class="required">*</span></label>
                    <select name="role" class="form-input" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staf</option>
                    </select>
                    @if($user->id === auth()->id())
                        <input type="hidden" name="role" value="{{ $user->role }}">
                        <div class="form-hint"><i class="fas fa-lock"></i> Anda tidak dapat mengubah role akun Anda sendiri.</div>
                    @else
                        <div class="form-hint">Administrator: akses penuh. Staf: tanpa menu pengaturan, user, log & backup.</div>
                    @endif
                    @error('role')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" class="form-input" id="password"
                                placeholder="Kosongkan jika tidak diubah">
                            <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-hint">Kosongkan jika tidak ingin mengubah password. Minimal 8 karakter.</div>
                        @error('password')
                            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" class="form-input" id="password_confirmation"
                                placeholder="Ulangi password baru">
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="email_verified" value="1"
                            {{ old('email_verified', $user->email_verified_at ? true : false) ? 'checked' : '' }}>
                        <span class="form-check-label">Email terverifikasi</span>
                    </label>
                    <div class="form-hint">Jika dicentang, user langsung bisa login tanpa verifikasi email.</div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    </script>
@endsection
