@extends('admin.layouts.app')

@section('title', 'Sejarah Masjid')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Sejarah Masjid</h1>
        <p class="page-subtitle">Kelola konten sejarah Masjid Agung Al Azhar</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.profile.index') }}">Profil Masjid</a>
            <span>/</span>
            <span>Sejarah Masjid</span>
        </div>
    </div>

    <div class="profile-header-banner">
        <div class="profile-header-icon">
            <i class="fas fa-landmark"></i>
        </div>
        <div>
            <div class="profile-header-title">Sejarah Masjid</div>
            <div class="profile-header-desc">Tuliskan riwayat dan perjalanan Masjid Agung Al Azhar</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-edit" style="color: var(--primary); margin-right: 8px;"></i>Editor Konten</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.profile.sejarah.update') }}" id="profileForm">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="content">Konten Sejarah <span class="required">*</span></label>
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
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        <span>Simpan Sejarah</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.profile._editor')
@endsection
