@extends('admin.layouts.app')

@section('title', 'Sosial Embed')

@push('styles')
<style>
    /* ===== SOCIAL EMBED PAGE STYLES ===== */
    .se-page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .se-page-header-info .page-title {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .se-page-header-info .page-title i {
        color: var(--primary);
        font-size: 1.4rem;
    }

    /* Platform Cards Container */
    .se-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(440px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    /* Card Wrapper */
    .se-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);
        border: 1px solid var(--border);
        transition: box-shadow 0.3s ease;
    }
    .se-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }

    /* Card Header */
    .se-card-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
    }
    .se-card-header-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        color: #fff;
        flex-shrink: 0;
    }
    .se-card-header-icon.ig {
        background: linear-gradient(135deg, #833AB4, #E1306C, #F77737);
    }
    .se-card-header-icon.yt {
        background: linear-gradient(135deg, #ff0000, #cc0000);
    }
    .se-card-header-text h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
        line-height: 1.3;
    }
    .se-card-header-text p {
        font-size: 0.8rem;
        color: #9ca3af;
        margin: 2px 0 0;
        line-height: 1.4;
    }

    /* Card Body */
    .se-card-body {
        padding: 1.5rem;
    }

    /* Field Group */
    .se-field-group {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    /* Field Item */
    .se-field {
        position: relative;
    }
    .se-field-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }
    .se-field-label .se-field-number {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        background: var(--light);
        color: var(--primary);
        font-size: 0.7rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
    }
    .se-field-input-wrap {
        position: relative;
    }
    .se-field-input-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #d1d5db;
        font-size: 0.9rem;
        transition: color 0.2s ease;
        pointer-events: none;
    }
    .se-field-input-wrap input {
        width: 100%;
        padding: 0.75rem 0.875rem 0.75rem 2.5rem;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        color: var(--dark);
        background: #fff;
        transition: all 0.2s ease;
        outline: none;
    }
    .se-field-input-wrap input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.08);
    }
    .se-field-input-wrap input:focus + i,
    .se-field-input-wrap:focus-within i {
        color: var(--primary);
    }
    .se-field-input-wrap input::placeholder {
        color: #d1d5db;
    }
    .se-field-hint {
        display: flex;
        align-items: flex-start;
        gap: 0.4rem;
        margin-top: 0.4rem;
        font-size: 0.78rem;
        color: #9ca3af;
        line-height: 1.5;
    }
    .se-field-hint i {
        font-size: 0.7rem;
        margin-top: 3px;
        flex-shrink: 0;
        color: #d1d5db;
    }
    .se-field-hint code {
        background: #f3f4f6;
        padding: 1px 5px;
        border-radius: 4px;
        font-size: 0.76rem;
        font-family: 'JetBrains Mono', 'Fira Code', 'Consolas', monospace;
        color: #6366f1;
        border: 1px solid #e5e7eb;
    }
    .se-field-error {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        color: var(--danger);
        font-size: 0.8rem;
        margin-top: 0.35rem;
    }
    .se-field-error i {
        font-size: 0.75rem;
    }

    /* Preview Badge */
    .se-preview-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.65rem;
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 600;
        margin-top: 0.4rem;
    }
    .se-preview-badge i {
        font-size: 0.65rem;
    }

    /* Submit Footer */
    .se-submit-footer {
        background: #fff;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .se-submit-info {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        color: #9ca3af;
        font-size: 0.85rem;
    }
    .se-submit-info i {
        color: #d1d5db;
        font-size: 1rem;
    }
    .se-submit-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.8rem 2rem;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(0, 83, 197, 0.2);
    }
    .se-submit-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(0, 83, 197, 0.3);
    }
    .se-submit-btn:active {
        transform: translateY(0);
    }
    .se-submit-btn i {
        font-size: 0.85rem;
    }

    /* Responsive */
    @media (max-width: 920px) {
        .se-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 600px) {
        .se-submit-footer {
            flex-direction: column;
            text-align: center;
        }
        .se-submit-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div class="se-page-header">
            <div class="se-page-header-info">
                <h1 class="page-title">
                    <i class="fas fa-code"></i> Sosial Embed
                </h1>
                <p class="page-subtitle">Kelola ID video YouTube dan postingan Instagram yang ditampilkan di halaman depan website.</p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.social-embeds.update') }}" method="POST">
        @csrf

        <div class="se-grid">
            
            {{-- ===== Instagram Card ===== --}}
            <div class="se-card">
                <div class="se-card-header">
                    <div class="se-card-header-icon ig">
                        <i class="fab fa-instagram"></i>
                    </div>
                    <div class="se-card-header-text">
                        <h3>Instagram Feed</h3>
                        <p>3 postingan yang tampil di halaman depan</p>
                    </div>
                </div>
                <div class="se-card-body">
                    <div class="se-field-group">
                        {{-- Instagram Post 1 --}}
                        <div class="se-field">
                            <label class="se-field-label">
                                <span class="se-field-number">1</span> Instagram Post ID
                            </label>
                            <div class="se-field-input-wrap">
                                <input type="text" name="ig_post_1" 
                                    value="{{ old('ig_post_1', $embeds['ig_post_1']) }}" 
                                    placeholder="Contoh: C-v1M-LykbU">
                                <i class="fab fa-instagram"></i>
                            </div>
                            <div class="se-field-hint">
                                <i class="fas fa-info-circle"></i>
                                <span>Dari URL: instagram.com/p/<code>C-v1M-LykbU</code>/ → masukkan <code>C-v1M-LykbU</code></span>
                            </div>
                            @error('ig_post_1')
                                <div class="se-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Instagram Post 2 --}}
                        <div class="se-field">
                            <label class="se-field-label">
                                <span class="se-field-number">2</span> Instagram Post ID
                            </label>
                            <div class="se-field-input-wrap">
                                <input type="text" name="ig_post_2" 
                                    value="{{ old('ig_post_2', $embeds['ig_post_2']) }}" 
                                    placeholder="Contoh: C-v0_Z_S2c7">
                                <i class="fab fa-instagram"></i>
                            </div>
                            @error('ig_post_2')
                                <div class="se-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Instagram Post 3 --}}
                        <div class="se-field">
                            <label class="se-field-label">
                                <span class="se-field-number">3</span> Instagram Post ID
                            </label>
                            <div class="se-field-input-wrap">
                                <input type="text" name="ig_post_3" 
                                    value="{{ old('ig_post_3', $embeds['ig_post_3']) }}" 
                                    placeholder="Contoh: C-v01qNSsL4">
                                <i class="fab fa-instagram"></i>
                            </div>
                            @error('ig_post_3')
                                <div class="se-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== YouTube Card ===== --}}
            <div class="se-card">
                <div class="se-card-header">
                    <div class="se-card-header-icon yt">
                        <i class="fab fa-youtube"></i>
                    </div>
                    <div class="se-card-header-text">
                        <h3>YouTube Gallery</h3>
                        <p>3 video yang tampil di halaman depan</p>
                    </div>
                </div>
                <div class="se-card-body">
                    <div class="se-field-group">
                        {{-- YouTube Video 1 --}}
                        <div class="se-field">
                            <label class="se-field-label">
                                <span class="se-field-number">1</span> YouTube Video ID
                            </label>
                            <div class="se-field-input-wrap">
                                <input type="text" name="yt_video_1" 
                                    value="{{ old('yt_video_1', $embeds['yt_video_1']) }}" 
                                    placeholder="Contoh: LXb3EKWsInQ">
                                <i class="fab fa-youtube"></i>
                            </div>
                            <div class="se-field-hint">
                                <i class="fas fa-info-circle"></i>
                                <span>Dari URL: youtube.com/watch?v=<code>LXb3EKWsInQ</code> → masukkan <code>LXb3EKWsInQ</code></span>
                            </div>
                            @error('yt_video_1')
                                <div class="se-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- YouTube Video 2 --}}
                        <div class="se-field">
                            <label class="se-field-label">
                                <span class="se-field-number">2</span> YouTube Video ID
                            </label>
                            <div class="se-field-input-wrap">
                                <input type="text" name="yt_video_2" 
                                    value="{{ old('yt_video_2', $embeds['yt_video_2']) }}" 
                                    placeholder="Contoh: wXhTHyIgQ_U">
                                <i class="fab fa-youtube"></i>
                            </div>
                            @error('yt_video_2')
                                <div class="se-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- YouTube Video 3 --}}
                        <div class="se-field">
                            <label class="se-field-label">
                                <span class="se-field-number">3</span> YouTube Video ID
                            </label>
                            <div class="se-field-input-wrap">
                                <input type="text" name="yt_video_3" 
                                    value="{{ old('yt_video_3', $embeds['yt_video_3']) }}" 
                                    placeholder="Contoh: jfKfPfyJRdk">
                                <i class="fab fa-youtube"></i>
                            </div>
                            @error('yt_video_3')
                                <div class="se-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit Footer --}}
        <div class="se-submit-footer">
            <div class="se-submit-info">
                <i class="fas fa-info-circle"></i>
                <span>Perubahan akan langsung tampil di halaman depan setelah disimpan.</span>
            </div>
            <button type="submit" class="se-submit-btn">
                <i class="fas fa-save"></i>
                Simpan Pengaturan
            </button>
        </div>
    </form>
@endsection
