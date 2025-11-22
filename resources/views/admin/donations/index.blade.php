@extends('admin.layouts.app')

@section('title', 'Campaign Donasi')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Campaign Donasi</h1>
                <p class="page-subtitle">Kelola campaign donasi dan galang dana</p>
            </div>
            <a href="{{ route('admin.donations.create') }}"
                style="padding: 12px 24px; background: var(--primary); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-plus"></i>
                Tambah Campaign
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 8px;">Total Campaign</div>
                    <div style="font-size: 2rem; font-weight: 700;">{{ $donations->total() }}</div>
                </div>
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-bullhorn" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div
            style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 8px;">Campaign Aktif</div>
                    <div style="font-size: 2rem; font-weight: 700;">{{ $donations->where('is_active', true)->count() }}
                    </div>
                </div>
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div
            style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 8px;">Total Terkumpul</div>
                    <div style="font-size: 1.5rem; font-weight: 700;">Rp
                        {{ number_format($donations->sum('current_amount'), 0, ',', '.') }}</div>
                </div>
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-hand-holding-usd" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div
            style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; padding: 24px; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 8px;">Total Donatur</div>
                    <div style="font-size: 2rem; font-weight: 700;">{{ $donations->sum('donor_count') }}</div>
                </div>
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-users" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        @if ($donations->count() > 0)
            <div style="display: grid; gap: 20px;">
                @foreach ($donations as $donation)
                    <div
                        style="border: 1px solid var(--border); border-radius: 12px; overflow: hidden; transition: all 0.3s ease;">
                        <div style="display: grid; grid-template-columns: 200px 1fr; gap: 0;">
                            <!-- Image -->
                            <div style="position: relative; background: #f3f4f6;">
                                @if ($donation->image)
                                    <img src="{{ Storage::url($donation->image) }}" alt="{{ $donation->campaign_name }}"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div
                                        style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                        <i class="fas fa-image" style="font-size: 3rem;"></i>
                                    </div>
                                @endif

                                <!-- Badges on Image -->
                                <div
                                    style="position: absolute; top: 12px; left: 12px; display: flex; flex-direction: column; gap: 6px;">
                                    @if ($donation->is_urgent)
                                        <span
                                            style="padding: 4px 12px; background: var(--danger); color: white; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                            <i class="fas fa-exclamation-circle"></i> Urgent
                                        </span>
                                    @endif
                                    @if ($donation->is_featured)
                                        <span
                                            style="padding: 4px 12px; background: #f59e0b; color: white; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                            <i class="fas fa-star"></i> Featured
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div style="padding: 20px;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                    <div style="flex: 1;">
                                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                            <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0;">
                                                {{ $donation->campaign_name }}</h3>
                                            @if (!$donation->is_active)
                                                <span
                                                    style="padding: 4px 12px; background: #fee2e2; color: #991b1b; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                        <div
                                            style="display: flex; align-items: center; gap: 12px; font-size: 0.85rem; color: #6b7280;">
                                            <span
                                                style="padding: 4px 10px; background: #e0e7ff; color: #3730a3; border-radius: 6px; font-weight: 600;">
                                                {{ ucfirst($donation->category) }}
                                            </span>
                                            <span><i class="fas fa-calendar"></i>
                                                {{ $donation->created_at->format('d M Y') }}</span>
                                            @if ($donation->end_date)
                                                <span><i class="fas fa-clock"></i> {{ $donation->days_left }} hari
                                                    lagi</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div style="display: flex; gap: 8px;">
                                        <a href="{{ route('admin.donations.show', $donation) }}"
                                            style="padding: 8px 12px; background: var(--info); color: white; border-radius: 6px; text-decoration: none; font-size: 0.85rem;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.donations.edit', $donation) }}"
                                            style="padding: 8px 12px; background: var(--warning); color: white; border-radius: 6px; text-decoration: none; font-size: 0.85rem;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.donations.destroy', $donation) }}" method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Yakin ingin menghapus campaign ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                style="padding: 8px 12px; background: var(--danger); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <p style="color: #6b7280; margin-bottom: 16px; font-size: 0.95rem;">
                                    {{ Str::limit($donation->description, 150) }}</p>

                                <!-- Progress -->
                                <div style="margin-bottom: 12px;">
                                    <div
                                        style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.9rem;">
                                        <span style="font-weight: 600; color: var(--primary);">
                                            Rp {{ number_format($donation->current_amount, 0, ',', '.') }}
                                        </span>
                                        @if ($donation->target_amount)
                                            <span style="color: #6b7280;">
                                                Target: Rp {{ number_format($donation->target_amount, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div
                                        style="width: 100%; height: 8px; background: #e5e7eb; border-radius: 10px; overflow: hidden;">
                                        <div
                                            style="width: {{ $donation->percentage }}%; height: 100%; background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%); transition: width 0.3s ease;">
                                        </div>
                                    </div>
                                    <div
                                        style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 0.85rem; color: #6b7280;">
                                        <span><i class="fas fa-percentage"></i>
                                            {{ number_format($donation->percentage, 1) }}% tercapai</span>
                                        <span><i class="fas fa-users"></i> {{ $donation->donor_count }} donatur</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <form action="{{ route('admin.donations.toggle-active', $donation) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit"
                                            style="padding: 6px 16px; background: {{ $donation->is_active ? '#10b981' : '#6b7280' }}; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                            <i class="fas fa-{{ $donation->is_active ? 'check' : 'times' }}-circle"></i>
                                            {{ $donation->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.donations.toggle-featured', $donation) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit"
                                            style="padding: 6px 16px; background: {{ $donation->is_featured ? '#f59e0b' : '#e5e7eb' }}; color: {{ $donation->is_featured ? 'white' : '#6b7280' }}; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                            <i class="fas fa-star"></i>
                                            {{ $donation->is_featured ? 'Featured' : 'Set Featured' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination">
                <!-- Pagination -->
                <div style="margin-top: 50px; text-align:center; padding: 10px; border-radius: 5px;">
                    {{ $donations->links('vendor.pagination.simple') }}
                </div>
            </div>
        @else
            <div style="text-align: center; padding: 48px 24px; color: #6b7280;">
                <i class="fas fa-hand-holding-heart" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.3;"></i>
                <p style="font-size: 1.1rem; margin-bottom: 8px;">Belum ada campaign donasi</p>
                <p style="font-size: 0.95rem;">Klik tombol "Tambah Campaign" untuk membuat campaign donasi pertama</p>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        @media (max-width: 768px) {
            [style*="grid-template-columns: 200px 1fr"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endpush
