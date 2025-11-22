@extends('admin.layouts.app')

@section('title', 'Tambah Setting')

@section('content')
    <div class="page-header">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 8px;">
            <a href="{{ route('admin.settings.index') }}" style="width: 40px; height: 40px; background: var(--light); border-radius: 10px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: var(--dark);">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="page-title">Tambah Setting Baru</h1>
                <p class="page-subtitle">Tambahkan pengaturan baru untuk website</p>
            </div>
        </div>
    </div>

    <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form action="{{ route('admin.settings.store') }}" method="POST">
            @csrf

            <div style="display: grid; gap: 20px;">
                <!-- Key -->
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                        Key <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="text" name="key" value="{{ old('key') }}" required
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                        placeholder="example_setting_key">
                    <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Gunakan lowercase dan underscore (contoh: site_name)</p>
                    @error('key')
                        <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Label -->
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                        Label <span style="color: var(--danger);">*</span>
                    </label>
                    <input type="text" name="label" value="{{ old('label') }}" required
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                        placeholder="Nama Setting">
                    @error('label')
                        <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <!-- Type -->
                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                            Type <span style="color: var(--danger);">*</span>
                        </label>
                        <select name="type" required
                            style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="textarea" {{ old('type') == 'textarea' ? 'selected' : '' }}>Textarea</option>
                            <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="url" {{ old('type') == 'url' ? 'selected' : '' }}>URL</option>
                            <option value="number" {{ old('type') == 'number' ? 'selected' : '' }}>Number</option>
                            <option value="boolean" {{ old('type') == 'boolean' ? 'selected' : '' }}>Boolean</option>
                            <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
                        </select>
                        @error('type')
                            <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Group -->
                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                            Group <span style="color: var(--danger);">*</span>
                        </label>
                        <select name="group" required
                            style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            @foreach($groups as $group)
                                <option value="{{ $group }}" {{ old('group') == $group ? 'selected' : '' }}>{{ ucfirst($group) }}</option>
                            @endforeach
                        </select>
                        @error('group')
                            <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                            Order
                        </label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                            style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                        @error('order')
                            <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Value -->
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                        Value
                    </label>
                    <textarea name="value" rows="3"
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem; resize: vertical;"
                        placeholder="Default value">{{ old('value') }}</textarea>
                    @error('value')
                        <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark);">
                        Description
                    </label>
                    <textarea name="description" rows="2"
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem; resize: vertical;"
                        placeholder="Deskripsi setting">{{ old('description') }}</textarea>
                    @error('description')
                        <span style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="margin-top: 32px; display: flex; gap: 12px;">
                <button type="submit"
                    style="padding: 12px 32px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.settings.index') }}"
                    style="padding: 12px 32px; background: var(--light); color: var(--dark); border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block;">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
@endsection