@extends('auth.layout')

@section('title', 'Lupa Password')

@section('content')
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-key"></i>
            </div>
            <h1 class="auth-title">Lupa Password?</h1>
            <p class="auth-subtitle">Reset password Anda dengan mudah</p>
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

            <p style="margin-bottom: 25px; color: #6b7280; font-size: 0.95rem;">
                Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
            </p>

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
            </form>
        </div>

        <div class="auth-footer">
            Ingat password Anda? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>
@endsection
