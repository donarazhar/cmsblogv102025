@extends('auth.layout')

@section('title', 'Login')

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

                <h2 class="brand-title">Selamat Datang Kembali!</h2>
                <p class="brand-description">
                    Masuk ke akun Anda untuk mengakses layanan digital masjid dan tetap terhubung dengan kegiatan jamaah.
                </p>

                <ul class="brand-features">
                    <li>
                        <i class="fas fa-calendar-check"></i>
                        <span>Jadwal Kajian & Event</span>
                    </li>
                    <li>
                        <i class="fas fa-donate"></i>
                        <span>Infaq & Donasi Online</span>
                    </li>
                    <li>
                        <i class="fas fa-book-quran"></i>
                        <span>Perpustakaan Digital</span>
                    </li>
                    <li>
                        <i class="fas fa-users"></i>
                        <span>Komunitas Jamaah</span>
                    </li>
                </ul>
            </div>

            <div class="brand-illustration">
                <i class="fas fa-mosque"></i>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="auth-form-side">
            <div class="form-header">
                <h1>Login</h1>
                <p>Silakan masuk dengan akun Anda</p>
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
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="••••••••"
                                required>
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
                        <span>Masuk Sekarang</span>
                    </button>

                    <a href="{{ route('password.request') }}" class="auth-link">
                        <i class="fas fa-key"></i> Lupa Password?
                    </a>
                </form>
            </div>

            <div class="form-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
            </div>
        </div>
    </div>
@endsection
