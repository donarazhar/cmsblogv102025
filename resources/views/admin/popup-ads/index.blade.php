@extends('admin.layouts.app')

@section('title', 'Popup Iklan')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Popup Iklan</h1>
                <p class="page-subtitle">Kelola popup iklan yang muncul di halaman depan</p>
            </div>
            <a href="{{ route('admin.popup-ads.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Popup
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Popup Iklan</h3>
            <div class="card-tools">
                <span class="badge">{{ $popupAds->total() }} Total</span>
            </div>
        </div>
        <div class="card-body">
            @if ($popupAds->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="100">Banner</th>
                                <th>Judul</th>
                                <th>Target Link</th>
                                <th>Target Halaman</th>
                                <th>Periode Tampil</th>
                                <th width="120" class="text-center">Status</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($popupAds as $popup)
                                <tr>
                                    <td>
                                        <div class="table-image" style="width: 100px; height: 60px;">
                                            @if ($popup->banner_image)
                                                <img src="{{ asset('storage/' . $popup->banner_image) }}" alt="{{ $popup->title }}" style="width: 100%; height: 100%; object-fit: contain; background: #f3f4f6; border-radius: 4px;">
                                            @else
                                                <div class="no-image" style="background: #e5e7eb; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                                    <i class="fas fa-image" style="color: #9ca3af;"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="table-content">
                                            <strong style="display: block; font-size: 0.95rem; color: #1f2937; margin-bottom: 3px;">{{ $popup->title }}</strong>
                                            @if ($popup->subtitle)
                                                <small style="color: #6b7280; font-size: 0.85rem;">{{ $popup->subtitle }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($popup->pdf_file)
                                            <a href="{{ asset('storage/' . $popup->pdf_file) }}" target="_blank" class="badge badge-primary" style="background: #dbeafe; color: #1e40af; text-decoration: none;">
                                                <i class="fas fa-file-pdf"></i> File PDF
                                            </a>
                                        @elseif($popup->external_link)
                                            <a href="{{ $popup->external_link }}" target="_blank" class="badge badge-info" style="background: #e0e7ff; color: #4338ca; text-decoration: none;">
                                                <i class="fas fa-external-link-alt"></i> Link Eksternal
                                            </a>
                                        @else
                                            <span style="color: #9ca3af; font-size: 0.85rem;">- Tidak ada -</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($popup->target_routes)
                                            <div style="font-size: 0.85rem; color: #4b5563; max-width: 150px; word-wrap: break-word;">
                                                {{ $popup->target_routes }}
                                            </div>
                                        @else
                                            <span class="badge" style="background: #d1fae5; color: #065f46;">Semua Halaman</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="font-size: 0.85rem; color: #4b5563;">
                                            @if($popup->start_date && $popup->end_date)
                                                {{ $popup->start_date->format('d M Y, H:i') }} <br> s/d <br> {{ $popup->end_date->format('d M Y, H:i') }}
                                            @elseif($popup->start_date)
                                                Mulai: {{ $popup->start_date->format('d M Y, H:i') }}
                                            @elseif($popup->end_date)
                                                Hingga: {{ $popup->end_date->format('d M Y, H:i') }}
                                            @else
                                                <span style="color: #059669; font-weight: 500;">Selamanya</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.popup-ads.toggle', $popup) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="toggle-btn {{ $popup->is_active ? 'active' : '' }}" title="Klik untuk mengubah status">
                                                <i class="fas fa-{{ $popup->is_active ? 'check-circle' : 'times-circle' }}"></i>
                                                {{ $popup->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </form>
                                        @if($popup->is_active && !$popup->is_currently_active)
                                            <div style="font-size: 0.75rem; color: #d97706; margin-top: 4px;">Di luar jadwal</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.popup-ads.edit', $popup) }}" class="btn-action btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.popup-ads.destroy', $popup) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus popup iklan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Hapus">
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

                <div class="card-footer">
                    {{ $popupAds->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-images"></i>
                    <h3>Belum Ada Popup Iklan</h3>
                    <p>Buat popup iklan promosi atau pengumuman pertama Anda</p>
                    <a href="{{ route('admin.popup-ads.create') }}" class="btn btn-primary" style="margin-top: 15px;">
                        <i class="fas fa-plus"></i>
                        Tambah Popup Iklan
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .card-tools {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .card-body {
            padding: 0;
        }

        .card-footer {
            padding: 20px 25px;
            border-top: 1px solid var(--border);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 83, 197, 0.3);
        }

        .badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            background: var(--light);
            color: var(--dark);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: var(--light);
        }

        .table th {
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: var(--light);
        }

        .toggle-btn {
            padding: 6px 15px;
            border-radius: 50px;
            border: none;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fee2e2;
            color: #dc2626;
            transition: all 0.3s ease;
        }

        .toggle-btn.active {
            background: #d1fae5;
            color: #059669;
        }

        .toggle-btn:hover {
            transform: scale(1.05);
        }

        .btn-group {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn-action {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-edit {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-edit:hover {
            background: #3b82f6;
            color: white;
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        .empty-state {
            padding: 80px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 4rem;
            color: #e5e7eb;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .empty-state p {
            color: #9ca3af;
            margin-bottom: 0;
        }

        .text-center {
            text-align: center;
        }

        .d-inline {
            display: inline;
        }
    </style>
@endpush
