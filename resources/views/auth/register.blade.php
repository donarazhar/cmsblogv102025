@extends('auth.layout')

@section('title', 'Register')

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

                <h2 class="brand-title">Bergabunglah Bersama Kami</h2>
                <p class="brand-description">
                    Daftar sekarang untuk menjadi bagian dari komunitas digital Masjid Al Azhar dan nikmati berbagai layanan
                    eksklusif.
                </p>

                <ul class="brand-features">
                    <li>
                        <i class="fas fa-user-check"></i>
                        <span>Pendaftaran Mudah & Cepat</span>
                    </li>
                    <li>
                        <i class="fas fa-bell"></i>
                        <span>Notifikasi Kegiatan Terbaru</span>
                    </li>
                    <li>
                        <i class="fas fa-photo-video"></i>
                        <span>Akses Galeri & Dokumentasi</span>
                    </li>
                    <li>
                        <i class="fas fa-hand-holding-heart"></i>
                        <span>Program Sosial & Charity</span>
                    </li>
                </ul>
            </div>

            <div class="brand-illustration">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="auth-form-side">
            <div class="form-header">
                <h1>Daftar Akun</h1>
                <p>Buat akun baru untuk memulai</p>
            </div>

            <div class="form-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <div class="input-icon">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Ahmad Fauzi" value="{{ old('name') }}" required autofocus>
                            <i class="fas fa-user"></i>
                        </div>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="input-icon">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="nama@email.com" value="{{ old('email') }}" required>
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
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimal 8 karakter" required>
                            <i class="fas fa-lock"></i>
                            <span class="password-toggle">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-icon">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Ulangi password" required>
                            <i class="fas fa-lock"></i>
                            <span class="password-toggle">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i>
                        <span>Daftar Sekarang</span>
                    </button>
                </form>
            </div>

            <div class="form-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </div>
    </div>
@endsection
