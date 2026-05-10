@extends('admin.layouts.app')

@section('title', 'Tambah User')

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

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="page-header">
        <h1 class="page-title">Tambah User Baru</h1>
        <p class="page-subtitle">Buat akun pengguna baru untuk akses admin panel</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.users.index') }}">User Management</a>
            <span>/</span>
            <span>Tambah User</span>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-user-plus" style="color: var(--primary); margin-right: 10px;"></i>Form User Baru</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="name" class="form-input" value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email <span class="required">*</span></label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}"
                        placeholder="contoh@email.com" required>
                    @error('email')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password <span class="required">*</span></label>
                        <div class="password-wrapper">
                            <input type="password" name="password" class="form-input" id="password"
                                placeholder="Minimal 8 karakter" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-hint">Password minimal 8 karakter</div>
                        @error('password')
                            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" class="form-input" id="password_confirmation"
                                placeholder="Ulangi password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="email_verified" value="1" {{ old('email_verified') ? 'checked' : '' }}>
                        <span class="form-check-label">Tandai email sebagai terverifikasi</span>
                    </label>
                    <div class="form-hint">Jika dicentang, user langsung bisa login tanpa verifikasi email.</div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan User
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
