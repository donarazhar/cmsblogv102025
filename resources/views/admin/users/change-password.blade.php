@extends('admin.layouts.app')

@section('title', 'Ubah Password')

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

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-2px);
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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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

        .warning-box {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .warning-box i {
            color: #d97706;
            font-size: 1.2rem;
            margin-top: 2px;
        }

        .warning-box-text {
            color: #92400e;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="page-header">
        <h1 class="page-title">Ubah Password</h1>
        <p class="page-subtitle">Reset password untuk user {{ $user->name }}</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.users.index') }}">User Management</a>
            <span>/</span>
            <span>Ubah Password</span>
        </div>
    </div>

    {{-- User Info Banner --}}
    <div class="user-info-card">
        <div class="user-info-avatar">
            <i class="fas fa-key"></i>
        </div>
        <div>
            <div class="user-info-name">{{ $user->name }}</div>
            <div class="user-info-email">{{ $user->email }}</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-lock" style="color: var(--warning); margin-right: 10px;"></i>Reset Password</h2>
        </div>
        <div class="card-body">
            <div class="warning-box">
                <i class="fas fa-exclamation-triangle"></i>
                <div class="warning-box-text">
                    <strong>Perhatian:</strong> Setelah password diubah, user ini harus menggunakan password baru untuk login.
                    Pastikan Anda menginformasikan password baru kepada user yang bersangkutan.
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.update-password', $user) }}">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password Baru <span class="required">*</span></label>
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
                                placeholder="Ulangi password baru" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Yakin ingin mengubah password user ini?')">
                        <i class="fas fa-key"></i> Ubah Password
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
