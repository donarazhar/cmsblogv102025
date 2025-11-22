@extends('admin.layouts.app')

@section('title', 'Tambah Testimonial')

@section('content')
    <div class="page-header">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 8px;">
            <a href="{{ route('admin.testimonials.index') }}"
                style="width: 40px; height: 40px; background: var(--light); border-radius: 10px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: var(--dark);">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="page-title">Tambah Testimonial</h1>
                <p class="page-subtitle">Tambahkan testimonial baru dari jamaah</p>
            </div>
        </div>
    </div>

    <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <!-- Nama -->
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                        Nama <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                        placeholder="Nama lengkap">
                    @error('name')
                        <span
                            style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                        Role/Jabatan
                    </label>
                    <input type="text" name="role" value="{{ old('role') }}"
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                        placeholder="Contoh: Jamaah, Pengurus, dll">
                    @error('role')
                        <span
                            style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Company -->
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                        Perusahaan/Institusi
                    </label>
                    <input type="text" name="company" value="{{ old('company') }}"
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                        placeholder="Nama perusahaan/institusi">
                    @error('company')
                        <span
                            style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Rating -->
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                        Rating <span style="color: var(--danger);">*</span>
                    </label>
                    <select name="rating" required
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                        <option value="">Pilih Rating</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                {{ $i }} Bintang
                            </option>
                        @endfor
                    </select>
                    @error('rating')
                        <span
                            style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Content -->
            <div style="margin-top: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                    Testimonial <span style="color: var(--danger);">*</span>
                </label>
                <textarea name="content" rows="5" required
                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem; resize: vertical;"
                    placeholder="Tulis testimonial di sini...">{{ old('content') }}</textarea>
                @error('content')
                    <span
                        style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Photo -->
            <div style="margin-top: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                    Foto
                </label>
                <input type="file" name="photo" accept="image/*"
                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Format: JPG, PNG. Maksimal 2MB</p>
                @error('photo')
                    <span
                        style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
                <!-- Status -->
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                        Status <span style="color: var(--danger);">*</span>
                    </label>
                    <select name="status" required
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <span
                            style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Order -->
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                        Urutan Tampil
                    </label>
                    <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                        placeholder="0">
                    <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Semakin kecil angka, semakin awal
                        ditampilkan</p>
                    @error('order')
                        <span
                            style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Featured -->
            <div style="margin-top: 20px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                        style="width: 18px; height: 18px; cursor: pointer;">
                    <span style="font-weight: 600; color: var(--dark);">Tampilkan sebagai Featured Testimonial</span>
                </label>
            </div>

            <!-- Buttons -->
            <div style="margin-top: 32px; display: flex; gap: 12px;">
                <button type="submit"
                    style="padding: 12px 32px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.testimonials.index') }}"
                    style="padding: 12px 32px; background: var(--light); color: var(--dark); border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block;">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection
