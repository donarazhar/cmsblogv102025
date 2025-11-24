@extends('auth.layout')

@section('title', 'Lupa Password')

@section('content')
<div class="auth-wrapper">
    <!-- Left Side - Branding -->
    <div class="auth-brand-side">
        <div class="brand-pattern"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>

        <div class="brand-content">
            <div class="brand-logo">
                <div class="brand-logo-icon">
                    <i class="fas fa-mosque"></i>
                </div>
                <div class="brand-logo-text">
                    Masjid Agung<br>Al Azhar
                </div>
            </div>

            <h2 class="brand-title">Reset Password</h2>
            <p class="brand-description">
                Jangan khawatir! Kami akan membantu Anda mendapatkan kembali akses ke akun Anda dengan mudah dan aman.
            </p>

            <ul class="brand-features">
                <li>
                    <i class="fas fa-shield-alt"></i>
                    <span>Proses Aman & Terenkripsi</span>
                </li>
                <li>
                    <i class="fas fa-envelope-open-text"></i>
                    <span>Link Dikirim ke Email</span>
                </li>
                <li>
                    <i class="fas fa-clock"></i>
                    <span>Berlaku 60 Menit</span>
                </li>
                <li>
                    <i class="fas fa-user-shield"></i>
                    <span>Data Anda Terlindungi</span>
                </li>
            </ul>
        </div>

        <div class="brand-illustration">
            <i class="fas fa-key"></i>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="auth-form-side">
        <div class="form-header">
            <h1>Lupa Password?</h1>
            <p>Kami akan kirimkan link reset password</p>
        </div>

        <div class="form-body">
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

            <div class="info-text">
                <i class="fas fa-info-circle"></i>
                Masukkan alamat email yang terdaftar. Kami akan mengirimkan link untuk reset password Anda.
            </div>

            <form method="POST" action="{{ route('password.email') }}">
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

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i>
                    <span>Kirim Link Reset</span>
                </button>

                <a href="{{ route('login') }}" class="auth-link">
                    <i class="fas fa-arrow-left"></i> Kembali ke Login
                </a>
            </form>
        </div>

        <div class="form-footer">
            Ingat password Anda? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>
</div>
@endsection
