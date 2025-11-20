@extends('auth.layout')

@section('title', 'Register')

@section('content')
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-mosque"></i>
            </div>
            <h1 class="auth-title">Buat Akun Baru</h1>
            <p class="auth-subtitle">Bergabung dengan Masjid Al Azhar</p>
        </div>

        <div class="auth-body">
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

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-icon">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••"
                            required>
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

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>
@endsection
