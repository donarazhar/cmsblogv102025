@extends('admin.layouts.app')

@section('title', 'Detail Campaign Donasi')

@section('content')
    <div class="page-header">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <a href="{{ route('admin.donations.index') }}"
                    style="width: 40px; height: 40px; background: var(--light); border-radius: 10px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: var(--dark);">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="page-title">Detail Campaign Donasi</h1>
                    <p class="page-subtitle">{{ $donation->campaign_name }}</p>
                </div>
            </div>
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('admin.donations.edit', $donation) }}"
                    style="padding: 12px 24px; background: var(--warning); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.donations.destroy', $donation) }}" method="POST" style="display: inline;"
                    onsubmit="return confirm('Yakin ingin menghapus campaign ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        style="padding: 12px 24px; background: var(--danger); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 24px;">
        <!-- Main Content -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- Campaign Image -->
            @if ($donation->image)
                <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <img src="{{ Storage::url($donation->image) }}" alt="{{ $donation->campaign_name }}"
                        style="width: 100%; height: auto; border-radius: 8px;">
                </div>
            @endif

            <!-- Campaign Info -->
            <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <span
                        style="padding: 6px 16px; background: #e0e7ff; color: #3730a3; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                        {{ ucfirst($donation->category) }}
                    </span>
                    @if ($donation->is_urgent)
                        <span
                            style="padding: 6px 16px; background: var(--danger); color: white; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                            <i class="fas fa-exclamation-circle"></i> Urgent
                        </span>
                    @endif
                    @if ($donation->is_featured)
                        <span
                            style="padding: 6px 16px; background: #f59e0b; color: white; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                            <i class="fas fa-star"></i> Featured
                        </span>
                    @endif
                    @if (!$donation->is_active)
                        <span
                            style="padding: 6px 16px; background: #fee2e2; color: #991b1b; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                            Inactive
                        </span>
                    @endif
                </div>

                <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 12px;">{{ $donation->campaign_name }}</h2>

                <div
                    style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px; font-size: 0.9rem; color: #6b7280;">
                    <span><i class="fas fa-calendar"></i> Dibuat: {{ $donation->created_at->format('d M Y') }}</span>
                    @if ($donation->start_date)
                        <span><i class="fas fa-play-circle"></i> Mulai: {{ $donation->start_date->format('d M Y') }}</span>
                    @endif
                    @if ($donation->end_date)
                        <span><i class="fas fa-stop-circle"></i> Berakhir:
                            {{ $donation->end_date->format('d M Y') }}</span>
                    @endif
                </div>

                <div style="padding: 20px; background: var(--light); border-radius: 10px; margin-bottom: 20px;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 12px;">Deskripsi</h3>
                    <p style="color: #4b5563; line-height: 1.7;">{{ $donation->description }}</p>
                </div>

                @if ($donation->content)
                    <div>
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 12px;">Detail Campaign</h3>
                        <div style="color: #4b5563; line-height: 1.8;">
                            {!! nl2br(e($donation->content)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Progress -->
            <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px;">
                    <i class="fas fa-chart-line" style="color: var(--primary);"></i> Progress Donasi
                </h3>

                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <div>
                            <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 4px;">Terkumpul</div>
                            <div style="font-size: 1.8rem; font-weight: 700; color: var(--primary);">
                                Rp {{ number_format($donation->current_amount, 0, ',', '.') }}
                            </div>
                        </div>
                        @if ($donation->target_amount)
                            <div style="text-align: right;">
                                <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 4px;">Target</div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: #6b7280;">
                                    Rp {{ number_format($donation->target_amount, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($donation->target_amount)
                        <div
                            style="width: 100%; height: 12px; background: #e5e7eb; border-radius: 10px; overflow: hidden; margin-bottom: 12px;">
                            <div
                                style="width: {{ $donation->percentage }}%; height: 100%; background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%); transition: width 0.3s ease;">
                            </div>
                        </div>
                        <div style="text-align: center; font-size: 1.2rem; font-weight: 700; color: var(--primary);">
                            {{ number_format($donation->percentage, 1) }}% tercapai
                        </div>
                    @endif
                </div>

                <div
                    style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; padding-top: 20px; border-top: 1px solid var(--border);">
                    <div style="text-align: center;">
                        <div style="font-size: 2rem; font-weight: 700; color: var(--primary); margin-bottom: 4px;">
                            {{ $donation->donor_count }}
                        </div>
                        <div style="font-size: 0.9rem; color: #6b7280;">Total Donatur</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 2rem; font-weight: 700; color: var(--primary); margin-bottom: 4px;">
                            {{ $donation->transactions->count() }}
                        </div>
                        <div style="font-size: 0.9rem; color: #6b7280;">Transaksi</div>
                    </div>
                    @if ($donation->days_left !== null)
                        <div style="text-align: center;">
                            <div
                                style="font-size: 2rem; font-weight: 700; color: {{ $donation->days_left < 7 ? 'var(--danger)' : 'var(--primary)' }}; margin-bottom: 4px;">
                                {{ $donation->days_left }}
                            </div>
                            <div style="font-size: 0.9rem; color: #6b7280;">Hari Tersisa</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Transactions -->
            @if ($donation->transactions->count() > 0)
                <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px;">
                        <i class="fas fa-history" style="color: var(--primary);"></i> Transaksi Terbaru
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach ($donation->transactions->take(5) as $transaction)
                            <div
                                style="padding: 16px; border: 1px solid var(--border); border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div style="font-weight: 600; margin-bottom: 4px;">
                                        {{ $transaction->is_anonymous ? 'Hamba Allah' : $transaction->donor_name }}
                                    </div>
                                    <div style="font-size: 0.85rem; color: #6b7280;">
                                        <i class="fas fa-calendar"></i> {{ $transaction->created_at->format('d M Y H:i') }}
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div
                                        style="font-size: 1.2rem; font-weight: 700; color: var(--primary); margin-bottom: 4px;">
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </div>
                                    @if ($transaction->status === 'verified')
                                        <span
                                            style="padding: 4px 12px; background: #d1fae5; color: #065f46; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                            <i class="fas fa-check-circle"></i> Verified
                                        </span>
                                    @elseif($transaction->status === 'pending')
                                        <span
                                            style="padding: 4px 12px; background: #fef3c7; color: #92400e; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($donation->transactions->count() > 5)
                        <div style="text-align: center; margin-top: 16px;">
                            <a href="#" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                                Lihat Semua Transaksi <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- Quick Actions -->
            <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                    <i class="fas fa-bolt" style="color: var(--primary);"></i> Quick Actions
                </h3>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <form action="{{ route('admin.donations.toggle-active', $donation) }}" method="POST">
                        @csrf
                        <button type="submit"
                            style="width: 100%; padding: 12px; background: {{ $donation->is_active ? 'var(--success)' : '#6b7280' }}; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fas fa-{{ $donation->is_active ? 'check' : 'times' }}-circle"></i>
                            {{ $donation->is_active ? 'Campaign Active' : 'Campaign Inactive' }}
                        </button>
                    </form>

                    <form action="{{ route('admin.donations.toggle-featured', $donation) }}" method="POST">
                        @csrf
                        <button type="submit"
                            style="width: 100%; padding: 12px; background: {{ $donation->is_featured ? '#f59e0b' : '#e5e7eb' }}; color: {{ $donation->is_featured ? 'white' : '#6b7280' }}; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fas fa-star"></i>
                            {{ $donation->is_featured ? 'Remove Featured' : 'Set Featured' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Campaign Details -->
            <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: var(--dark);">
                    <i class="fas fa-info-circle" style="color: var(--primary);"></i> Detail
                </h3>

                <div style="display: flex; flex-direction: column; gap: 16px; font-size: 0.9rem;">
                    <div>
                        <div style="color: #6b7280; margin-bottom: 4px;">Slug</div>
                        <div style="font-weight: 600;">{{ $donation->slug }}</div>
                    </div>

                    <div>
                        <div style="color: #6b7280; margin-bottom: 4px;">Kategori</div>
                        <div style="font-weight: 600;">{{ ucfirst($donation->category) }}</div>
                    </div>

                    <div>
                        <div style="color: #6b7280; margin-bottom: 4px;">Urutan</div>
                        <div style="font-weight: 600;">{{ $donation->order }}</div>
                    </div>

                    @if ($donation->payment_methods && count($donation->payment_methods) > 0)
                        <div>
                            <div style="color: #6b7280; margin-bottom: 8px;">Metode Pembayaran</div>
                            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                @foreach ($donation->payment_methods as $method)
                                    <span
                                        style="padding: 4px 12px; background: var(--light); color: var(--dark); border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                        {{ ucfirst(str_replace('_', ' ', $method)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <div style="color: #6b7280; margin-bottom: 4px;">Dibuat</div>
                        <div style="font-weight: 600;">{{ $donation->created_at->format('d M Y H:i') }}</div>
                    </div>

                    <div>
                        <div style="color: #6b7280; margin-bottom: 4px;">Terakhir Diupdate</div>
                        <div style="font-weight: 600;">{{ $donation->updated_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>
            <!-- URL Preview -->
            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 20px;">
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 12px; color: #1e40af;">
                    <i class="fas fa-link"></i> URL Campaign
                </h3>
                <div
                    style="padding: 12px; background: white; border-radius: 8px; word-break: break-all; font-size: 0.85rem; color: #3b82f6;">
                    {{ $donation->url }}
                </div>
                <button onclick="copyToClipboard('{{ $donation->url }}')"
                    style="width: 100%; margin-top: 12px; padding: 10px; background: #3b82f6; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.85rem;">
                    <i class="fas fa-copy"></i> Salin URL
                </button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media (max-width: 1024px) {
            [style*="grid-template-columns: 1fr 350px"] {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('URL berhasil disalin!');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
@endpush
