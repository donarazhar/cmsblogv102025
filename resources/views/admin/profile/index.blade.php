@extends('admin.layouts.app')

@section('title', 'Profil Masjid')

@section('content')
    <style>
        .profile-overview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
            margin-top: 10px;
        }

        .profile-card {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .profile-card-banner {
            padding: 30px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .profile-card-banner::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .profile-card-banner.sejarah {
            background: linear-gradient(135deg, #0053C5, #003d91);
        }

        .profile-card-banner.visi-misi {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .profile-card-banner.struktur {
            background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        }

        .profile-card-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .profile-card-title {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .profile-card-subtitle {
            opacity: 0.8;
            font-size: 0.9rem;
            margin-top: 4px;
        }

        .profile-card-body {
            padding: 25px;
        }

        .profile-card-preview {
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.6;
            max-height: 80px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .profile-card-preview.empty {
            font-style: italic;
            color: #9ca3af;
        }

        .profile-card-status {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .status-dot.filled {
            background: #10b981;
        }

        .status-dot.empty {
            background: #f59e0b;
        }

        .status-text {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-text.filled {
            color: #065f46;
        }

        .status-text.empty {
            color: #92400e;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            justify-content: center;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 83, 197, 0.3);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .btn-purple {
            background: #8b5cf6;
            color: white;
        }

        .btn-purple:hover {
            background: #7c3aed;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .profile-overview-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="page-header">
        <h1 class="page-title">Profil Masjid</h1>
        <p class="page-subtitle">Kelola informasi profil Masjid Agung Al Azhar</p>
    </div>

    <div class="profile-overview-grid">
        {{-- Sejarah Masjid --}}
        <div class="profile-card">
            <div class="profile-card-banner sejarah">
                <div class="profile-card-icon">
                    <i class="fas fa-landmark"></i>
                </div>
                <div class="profile-card-title">Sejarah Masjid</div>
                <div class="profile-card-subtitle">Riwayat dan perjalanan masjid</div>
            </div>
            <div class="profile-card-body">
                <div class="profile-card-status">
                    @if (!empty($profileData['sejarah']))
                        <div class="status-dot filled"></div>
                        <span class="status-text filled">Konten sudah diisi</span>
                    @else
                        <div class="status-dot empty"></div>
                        <span class="status-text empty">Belum ada konten</span>
                    @endif
                </div>
                <div class="profile-card-preview {{ empty($profileData['sejarah']) ? 'empty' : '' }}">
                    {{ !empty($profileData['sejarah']) ? Str::limit(strip_tags($profileData['sejarah']), 120) : 'Belum ada konten sejarah. Klik tombol di bawah untuk menambahkan.' }}
                </div>
                <a href="{{ route('admin.profile.sejarah') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                    {{ !empty($profileData['sejarah']) ? 'Edit Sejarah' : 'Tulis Sejarah' }}
                </a>
            </div>
        </div>

        {{-- Visi & Misi --}}
        <div class="profile-card">
            <div class="profile-card-banner visi-misi">
                <div class="profile-card-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <div class="profile-card-title">Visi & Misi</div>
                <div class="profile-card-subtitle">Tujuan dan arah organisasi</div>
            </div>
            <div class="profile-card-body">
                <div class="profile-card-status">
                    @if (!empty($profileData['visi_misi']))
                        <div class="status-dot filled"></div>
                        <span class="status-text filled">Konten sudah diisi</span>
                    @else
                        <div class="status-dot empty"></div>
                        <span class="status-text empty">Belum ada konten</span>
                    @endif
                </div>
                <div class="profile-card-preview {{ empty($profileData['visi_misi']) ? 'empty' : '' }}">
                    {{ !empty($profileData['visi_misi']) ? Str::limit(strip_tags($profileData['visi_misi']), 120) : 'Belum ada konten visi & misi. Klik tombol di bawah untuk menambahkan.' }}
                </div>
                <a href="{{ route('admin.profile.visi-misi') }}" class="btn btn-success">
                    <i class="fas fa-edit"></i>
                    {{ !empty($profileData['visi_misi']) ? 'Edit Visi & Misi' : 'Tulis Visi & Misi' }}
                </a>
            </div>
        </div>

        {{-- Struktur Organisasi --}}
        <div class="profile-card">
            <div class="profile-card-banner struktur">
                <div class="profile-card-icon">
                    <i class="fas fa-sitemap"></i>
                </div>
                <div class="profile-card-title">Struktur Organisasi</div>
                <div class="profile-card-subtitle">Susunan kepengurusan masjid</div>
            </div>
            <div class="profile-card-body">
                <div class="profile-card-status">
                    @if (!empty($profileData['struktur_organisasi']))
                        <div class="status-dot filled"></div>
                        <span class="status-text filled">Konten sudah diisi</span>
                    @else
                        <div class="status-dot empty"></div>
                        <span class="status-text empty">Belum ada konten</span>
                    @endif
                </div>
                <div class="profile-card-preview {{ empty($profileData['struktur_organisasi']) ? 'empty' : '' }}">
                    {{ !empty($profileData['struktur_organisasi']) ? Str::limit(strip_tags($profileData['struktur_organisasi']), 120) : 'Belum ada konten struktur organisasi. Klik tombol di bawah untuk menambahkan.' }}
                </div>
                <a href="{{ route('admin.profile.struktur-organisasi') }}" class="btn btn-purple">
                    <i class="fas fa-edit"></i>
                    {{ !empty($profileData['struktur_organisasi']) ? 'Edit Struktur' : 'Tulis Struktur' }}
                </a>
            </div>
        </div>
    </div>
@endsection
