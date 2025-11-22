@extends('admin.layouts.app')

@section('title', 'Pengaturan')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Pengaturan</h1>
                <p class="page-subtitle">Kelola pengaturan website</p>
            </div>
            <div style="display: flex; gap: 12px;">
                <form action="{{ route('admin.settings.clear-cache') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit"
                        style="padding: 12px 24px; background: var(--warning); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-sync"></i>
                        Clear Cache
                    </button>
                </form>
                <a href="{{ route('admin.settings.create') }}"
                    style="padding: 12px 24px; background: var(--primary); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-plus"></i>
                    Tambah Setting
                </a>
            </div>
        </div>
    </div>

    <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @foreach ($settings as $group => $groupSettings)
            <div
                style="background: white; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <h3
                    style="font-size: 1.3rem; font-weight: 700; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 2px solid var(--border); color: var(--dark); display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-{{ $group === 'general' ? 'cog' : ($group === 'contact' ? 'address-book' : ($group === 'social' ? 'share-alt' : ($group === 'seo' ? 'search' : 'palette'))) }}"
                        style="color: var(--primary);"></i>
                    {{ ucfirst($group) }} Settings
                </h3>

                <div style="display: grid; gap: 24px;">
                    @foreach ($groupSettings as $setting)
                        <div>
                            <div
                                style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                <label style="display: block; font-weight: 600; color: var(--dark);">
                                    {{ $setting->label }}
                                    @if ($setting->description)
                                        <i class="fas fa-info-circle"
                                            style="color: #9ca3af; font-size: 0.85rem; cursor: help;"
                                            title="{{ $setting->description }}"></i>
                                    @endif
                                </label>

                                {{-- Button delete tanpa nested form --}}
                                <button type="button"
                                    onclick="deleteSetting('{{ route('admin.settings.destroy', $setting) }}')"
                                    style="padding: 4px 8px; background: var(--danger); color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 0.8rem;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            @if ($setting->description)
                                <p style="font-size: 0.85rem; color: #6b7280; margin-bottom: 8px;">
                                    {{ $setting->description }}</p>
                            @endif

                            @if ($setting->type === 'text')
                                <input type="text" name="settings[{{ $setting->key }}]"
                                    value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            @elseif($setting->type === 'textarea')
                                <textarea name="settings[{{ $setting->key }}]" rows="4"
                                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem; resize: vertical;">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                            @elseif($setting->type === 'email')
                                <input type="email" name="settings[{{ $setting->key }}]"
                                    value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            @elseif($setting->type === 'url')
                                <input type="url" name="settings[{{ $setting->key }}]"
                                    value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;"
                                    placeholder="https://">
                            @elseif($setting->type === 'number')
                                <input type="number" name="settings[{{ $setting->key }}]"
                                    value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                            @elseif($setting->type === 'boolean')
                                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                    <input type="hidden" name="settings[{{ $setting->key }}]" value="0">
                                    <input type="checkbox" name="settings[{{ $setting->key }}]" value="1"
                                        {{ old('settings.' . $setting->key, $setting->value) == '1' ? 'checked' : '' }}
                                        style="width: 20px; height: 20px; cursor: pointer;">
                                    <span style="color: #6b7280;">Aktifkan</span>
                                </label>
                            @elseif($setting->type === 'image')
                                @if ($setting->value)
                                    <div style="margin-bottom: 12px;">
                                        <img src="{{ Storage::url($setting->value) }}" alt="{{ $setting->label }}"
                                            style="max-width: 200px; height: auto; border-radius: 8px; border: 1px solid var(--border);">
                                        <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Current:
                                            {{ basename($setting->value) }}</p>
                                    </div>
                                @endif
                                <input type="file" name="settings[{{ $setting->key }}]" accept="image/*"
                                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                                <p style="font-size: 0.85rem; color: #6b7280; margin-top: 4px;">Format: JPG, PNG.
                                    Maksimal 2MB</p>
                            @endif

                            @error('settings.' . $setting->key)
                                <span
                                    style="color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <button type="submit"
                style="padding: 14px 32px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-save"></i>
                Simpan Semua Pengaturan
            </button>
        </div>
    </form>

    {{-- Form tersembunyi untuk delete --}}
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        // Function untuk delete setting
        function deleteSetting(url) {
            if (confirm('Yakin ingin menghapus setting ini?')) {
                const form = document.getElementById('delete-form');
                form.action = url;
                form.submit();
            }
        }

        // Debug & Handle form submit
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('settings-form');

            console.log('Form ditemukan:', !!form);
            if (form) {
                console.log('Form action:', form.action);
                console.log('Form method:', form.method);
            }

            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form sedang disubmit!');

                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.6';
                    submitBtn.style.cursor = 'not-allowed';
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                });
            } else {
                console.error('Form tidak ditemukan!');
            }
        });
    </script>
@endsection
