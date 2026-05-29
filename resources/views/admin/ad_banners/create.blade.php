@extends('admin.layouts.app')

@section('title', 'Tambah Ads Banner')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Tambah Ads Banner</h1>
                <p class="page-subtitle">Tambahkan banner iklan baru untuk homepage</p>
            </div>
            <a href="{{ route('admin.ad-banners.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="padding: 30px;">
            <form action="{{ route('admin.ad-banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="title">Judul Banner (Internal) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    <small class="text-muted">Hanya untuk identifikasi di panel admin.</small>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="url_link">Tautan Target (URL)</label>
                    <input type="url" class="form-control @error('url_link') is-invalid @enderror" id="url_link" name="url_link" value="{{ old('url_link') }}" placeholder="https://example.com">
                    <small class="text-muted">Tautan yang akan dibuka ketika banner diklik. Biarkan kosong jika tidak bisa diklik.</small>
                    @error('url_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="target_routes">Target Halaman Munculnya Iklan (Opsional)</label>
                    <input type="text" class="form-control @error('target_routes') is-invalid @enderror" id="target_routes" name="target_routes" value="{{ old('target_routes') }}" placeholder="Contoh: blog/detail/judul-artikel">
                    <small class="text-muted">Jika diisi, banner tidak akan muncul di slider beranda, tetapi akan muncul pada bagian atas halaman yang Anda tentukan. Kosongkan jika ingin menjadikannya slider di beranda. Pisahkan dengan koma jika lebih dari satu halaman.</small>
                    @error('target_routes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="image">Gambar Banner <span class="text-danger">*</span></label>
                    <div class="image-upload-wrapper">
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/jpeg,image/png,image/webp" required onchange="previewImage(this)">
                        <div class="image-preview" id="imagePreview" style="display: none; margin-top: 15px;">
                            <img src="" alt="Preview" style="max-width: 100%; height: auto; border-radius: 8px; border: 1px solid #e2e8f0;">
                        </div>
                    </div>
                    <small class="text-muted">Format: JPG, PNG, WEBP. Maksimal: 2MB. Rekomendasi rasio gambar memanjang (misal 1200x250 piksel).</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" style="margin-top: 20px;">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Aktifkan banner ini</label>
                    </div>
                </div>

                <div class="form-actions" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Banner
                    </button>
                    <a href="{{ route('admin.ad-banners.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card { background: white; border-radius: 15px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08); }
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--dark); }
    .form-control { display: block; width: 100%; padding: 0.75rem 1rem; font-size: 1rem; font-weight: 400; line-height: 1.5; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: 0.5rem; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; }
    .form-control:focus { color: #495057; background-color: #fff; border-color: var(--primary); outline: 0; box-shadow: 0 0 0 0.2rem rgba(0, 83, 197, 0.25); }
    .invalid-feedback { display: block; width: 100%; margin-top: .25rem; font-size: 80%; color: #dc3545; }
    .text-danger { color: #dc3545; }
    .text-muted { color: #6c757d; font-size: 0.85rem; }
    .btn { padding: 10px 20px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease; text-decoration: none; }
    .btn-primary { background: var(--primary); color: white; }
    .btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 83, 197, 0.3); }
    .btn-secondary { background: #6c757d; color: white; }
    .btn-secondary:hover { background: #5a6268; transform: translateY(-2px); }
    .custom-control { position: relative; display: block; min-height: 1.5rem; padding-left: 2.5rem; }
    .custom-control-input { position: absolute; left: 0; z-index: -1; width: 1rem; height: 1.25rem; opacity: 0; }
    .custom-control-label { position: relative; margin-bottom: 0; vertical-align: top; cursor: pointer; }
    .custom-control-label::before { position: absolute; top: 0.25rem; left: -2.5rem; display: block; width: 2rem; height: 1rem; pointer-events: none; content: ""; background-color: #e9ecef; border: #adb5bd solid 1px; border-radius: 1rem; transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out; }
    .custom-control-label::after { position: absolute; top: calc(0.25rem + 2px); left: calc(-2.5rem + 2px); width: calc(1rem - 4px); height: calc(1rem - 4px); background-color: #adb5bd; border-radius: 1rem; transition: transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out; content: ""; }
    .custom-switch .custom-control-input:checked~.custom-control-label::before { color: #fff; border-color: var(--primary); background-color: var(--primary); }
    .custom-switch .custom-control-input:checked~.custom-control-label::after { background-color: #fff; transform: translateX(1rem); }
</style>
@endpush

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const previewImg = preview.querySelector('img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
@endpush
