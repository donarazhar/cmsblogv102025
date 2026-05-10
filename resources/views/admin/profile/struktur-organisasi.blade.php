@extends('admin.layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Struktur Organisasi</h1>
        <p class="page-subtitle">Kelola konten struktur organisasi Masjid Agung Al Azhar</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.profile.index') }}">Profil Masjid</a>
            <span>/</span>
            <span>Struktur Organisasi</span>
        </div>
    </div>

    <div class="profile-header-banner" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);">
        <div class="profile-header-icon">
            <i class="fas fa-sitemap"></i>
        </div>
        <div>
            <div class="profile-header-title">Struktur Organisasi</div>
            <div class="profile-header-desc">Tuliskan susunan kepengurusan Masjid Agung Al Azhar</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-edit" style="color: #8b5cf6; margin-right: 8px;"></i>Editor Konten</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.profile.struktur-organisasi.update') }}" id="profileForm">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="content">Konten Struktur Organisasi <span class="required">*</span></label>
                    <textarea name="content" id="content" rows="10" class="form-control">{{ old('content', $content) }}</textarea>
                    <small class="form-text editor-status">Editor sedang memuat...</small>
                    @error('content')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="background: #8b5cf6;">
                        <i class="fas fa-save"></i>
                        <span>Simpan Struktur Organisasi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.profile._editor')
@endsection
