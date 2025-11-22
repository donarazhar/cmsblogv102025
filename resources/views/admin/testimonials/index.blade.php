@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Testimonials</h1>
                <p class="page-subtitle">Kelola testimoni dari jamaah</p>
            </div>
            <a href="{{ route('admin.testimonials.create') }}"
                style="padding: 12px 24px; background: var(--primary); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-plus"></i>
                Tambah Testimonial
            </a>
        </div>
    </div>

    <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        @if ($testimonials->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border);">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Foto</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Nama</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Role</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Rating</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Status</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: var(--dark);">Featured</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: var(--dark);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonials as $testimonial)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 12px;">
                                    @if ($testimonial->photo)
                                        <img src="{{ Storage::url($testimonial->photo) }}" alt="{{ $testimonial->name }}"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                    @else
                                        <div
                                            style="width: 50px; height: 50px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                            {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td style="padding: 12px;">
                                    <div style="font-weight: 600;">{{ $testimonial->name }}</div>
                                    <div style="font-size: 0.85rem; color: #6b7280;">
                                        {{ Str::limit($testimonial->content, 50) }}</div>
                                </td>
                                <td style="padding: 12px;">
                                    <div>{{ $testimonial->role ?? '-' }}</div>
                                    @if ($testimonial->company)
                                        <div style="font-size: 0.85rem; color: #6b7280;">{{ $testimonial->company }}</div>
                                    @endif
                                </td>
                                <td style="padding: 12px;">
                                    <div style="color: #f59e0b;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $testimonial->rating ? '' : '-half-alt' }}"
                                                style="font-size: 0.85rem;"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td style="padding: 12px;">
                                    @if ($testimonial->status === 'approved')
                                        <span
                                            style="padding: 4px 12px; background: #d1fae5; color: #065f46; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <i class="fas fa-check-circle"></i> Approved
                                        </span>
                                    @elseif($testimonial->status === 'pending')
                                        <span
                                            style="padding: 4px 12px; background: #fef3c7; color: #92400e; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @else
                                        <span
                                            style="padding: 4px 12px; background: #fee2e2; color: #991b1b; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                                            <i class="fas fa-times-circle"></i> Rejected
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 12px;">
                                    @if ($testimonial->is_featured)
                                        <i class="fas fa-star" style="color: #f59e0b;"></i>
                                    @else
                                        <i class="far fa-star" style="color: #d1d5db;"></i>
                                    @endif
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        @if ($testimonial->status === 'pending')
                                            <form action="{{ route('admin.testimonials.approve', $testimonial) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit"
                                                    style="padding: 6px 12px; background: var(--success); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem;"
                                                    title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.testimonials.reject', $testimonial) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit"
                                                    style="padding: 6px 12px; background: var(--danger); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem;"
                                                    title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                            style="padding: 6px 12px; background: var(--info); color: white; border-radius: 6px; text-decoration: none; font-size: 0.85rem;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                            method="POST" style="display: inline;"
                                            onsubmit="return confirm('Yakin ingin menghapus testimonial ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                style="padding: 6px 12px; background: var(--danger); color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <!-- Pagination -->
                <div style="margin-top: 50px; text-align:center; padding: 10px; border-radius: 5px;">
                    {{ $testimonials->links('vendor.pagination.simple') }}
                </div>
            </div>
        @else
            <div style="text-align: center; padding: 48px 24px; color: #6b7280;">
                <i class="fas fa-comments" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.3;"></i>
                <p style="font-size: 1.1rem; margin-bottom: 8px;">Belum ada testimonial</p>
                <p style="font-size: 0.95rem;">Klik tombol "Tambah Testimonial" untuk menambahkan testimonial pertama</p>
            </div>
        @endif
    </div>
@endsection
