@extends('admin.layouts.app')

@section('title', 'Sosial Embed')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Sosial Embed (Landing Page)</h1>
                <p class="page-subtitle">Kelola ID video YouTube dan postingan Instagram yang tampil di halaman depan.</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.social-embeds.update') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
            
            <!-- Bagian Instagram -->
            <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid var(--border); color: var(--dark); display: flex; align-items: center; gap: 10px;">
                    <i class="fab fa-instagram" style="color: #e1306c;"></i> Pengaturan Instagram Feed
                </h3>
                
                <div style="display: grid; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 8px;">Instagram Post ID 1</label>
                        <input type="text" name="ig_post_1" value="{{ old('ig_post_1', $embeds['ig_post_1']) }}" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                        <small style="color: #6b7280; display: block; margin-top: 6px;">Contoh URL: https://www.instagram.com/p/<b>C-v1M-LykbU</b>/ -> Masukkan: <b>C-v1M-LykbU</b></small>
                        @error('ig_post_1')
                            <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 8px;">Instagram Post ID 2</label>
                        <input type="text" name="ig_post_2" value="{{ old('ig_post_2', $embeds['ig_post_2']) }}" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                        @error('ig_post_2')
                            <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 8px;">Instagram Post ID 3</label>
                        <input type="text" name="ig_post_3" value="{{ old('ig_post_3', $embeds['ig_post_3']) }}" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                        @error('ig_post_3')
                            <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Bagian YouTube -->
            <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid var(--border); color: var(--dark); display: flex; align-items: center; gap: 10px;">
                    <i class="fab fa-youtube" style="color: #ff0000;"></i> Pengaturan YouTube Gallery
                </h3>

                <div style="display: grid; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 8px;">YouTube Video ID 1</label>
                        <input type="text" name="yt_video_1" value="{{ old('yt_video_1', $embeds['yt_video_1']) }}" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                        <small style="color: #6b7280; display: block; margin-top: 6px;">Contoh URL: https://www.youtube.com/watch?v=<b>LXb3EKWsInQ</b> -> Masukkan: <b>LXb3EKWsInQ</b></small>
                        @error('yt_video_1')
                            <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 8px;">YouTube Video ID 2</label>
                        <input type="text" name="yt_video_2" value="{{ old('yt_video_2', $embeds['yt_video_2']) }}" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                        @error('yt_video_2')
                            <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; color: var(--dark); margin-bottom: 8px;">YouTube Video ID 3</label>
                        <input type="text" name="yt_video_3" value="{{ old('yt_video_3', $embeds['yt_video_3']) }}" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                        @error('yt_video_3')
                            <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-top: 24px; text-align: right;">
            <button type="submit" style="padding: 14px 32px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem; display: inline-flex; align-items: center; gap: 8px; transition: opacity 0.3s;">
                <i class="fas fa-save"></i>
                Simpan Semua Pengaturan
            </button>
        </div>
    </form>
@endsection
