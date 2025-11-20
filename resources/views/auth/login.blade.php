@extends('auth.layout')

@section('title', 'Login')

@section('content')
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-mosque"></i>
            </div>
            <h1 class="auth-title">Selamat Datang</h1>
            <p class="auth-subtitle">Masjid Agung Al Azhar</p>
        </div>

        <div class="auth-body">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-icon">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                        <i class="fas fa-envelope"></i>
                    </div>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-icon">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="••••••••" required>
                        <i class="fas fa-lock"></i>
                        <span class="password-toggle">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Masuk</span>
                </button>

                <div class="divider">
                    <span>atau</span>
                </div>

                <a href="{{ route('password.request') }}"
                    style="display: block; text-align: center; color: var(--primary); text-decoration: none; font-size: 0.9rem; margin-top: 15px;">
                    <i class="fas fa-key"></i> Lupa Password?
                </a>
            </form>
        </div>

        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
        </div>
    </div>
@endsection
