@extends('admin.layouts.app')

@section('title', 'Visi & Misi')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Visi & Misi</h1>
        <p class="page-subtitle">Kelola konten visi dan misi Masjid Agung Al Azhar</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.profile.index') }}">Profil Masjid</a>
            <span>/</span>
            <span>Visi & Misi</span>
        </div>
    </div>

    <div class="profile-header-banner" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
        <div class="profile-header-icon">
            <i class="fas fa-bullseye"></i>
        </div>
        <div>
            <div class="profile-header-title">Visi & Misi</div>
            <div class="profile-header-desc">Tuliskan visi dan misi Masjid Agung Al Azhar</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-edit" style="color: #10b981; margin-right: 8px;"></i>Editor Konten</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.profile.visi-misi.update') }}" id="profileForm">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="content">Konten Visi & Misi <span class="required">*</span></label>
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
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="background: #10b981;">
                        <i class="fas fa-save"></i>
                        <span>Simpan Visi & Misi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.profile._editor')
@endsection
