@extends('admin.layouts.app')

@section('title', 'Detail Staff')

@section('content')
    <style>
        /* Copy styles dari tag show.blade.php - sudah lengkap */
        .breadcrumb {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            align-items: center;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .detail-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .staff-header {
            padding: 30px;
            display: flex;
            gap: 30px;
            border-bottom: 1px solid var(--border);
        }

        .staff-photo-large {
            width: 200px;
            height: 200px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .staff-photo-placeholder {
            width: 200px;
            height: 200px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4rem;
        }

        .staff-info h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .staff-position {
            font-size: 1.2rem;
            color: #6b7280;
            margin-bottom: 15px;
        }

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-right: 8px;
        }

        .info-section {
            padding: 30px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .info-label {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 600;
        }

        .info-value {
            font-size: 1rem;
            color: var(--dark);
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
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: var(--dark);
        }
    </style>

    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.staff.index') }}">Staff</a>
        <span>/</span>
        <span style="color: var(--dark); font-weight: 600;">{{ $staff->name }}</span>
    </div>

    <div class="detail-card">
        <div class="staff-header">
            @if ($staff->photo)
                <img src="{{ asset('storage/' . $staff->photo) }}" alt="{{ $staff->name }}" class="staff-photo-large">
            @else
                <div class="staff-photo-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            @endif

            <div class="staff-info" style="flex: 1;">
                <h1>{{ $staff->name }}</h1>
                <p class="staff-position">{{ $staff->position }}</p>

                <div style="margin-bottom: 20px;">
                    @if ($staff->type === 'board')
                        <span class="badge" style="background: #dbeafe; color: #1e40af;">
                            <i class="fas fa-user-tie"></i> Board
                        </span>
                    @elseif($staff->type === 'imam')
                        <span class="badge" style="background: #e0e7ff; color: #3730a3;">
                            <i class="fas fa-mosque"></i> Imam
                        </span>
                    @elseif($staff->type === 'teacher')
                        <span class="badge" style="background: #fef3c7; color: #92400e;">
                            <i class="fas fa-chalkboard-teacher"></i> Teacher
                        </span>
                    @elseif($staff->type === 'volunteer')
                        <span class="badge" style="background: #fce7f3; color: #9f1239;">
                            <i class="fas fa-hands-helping"></i> Volunteer
                        </span>
                    @endif

                    @if ($staff->is_featured)
                        <span class="badge" style="background: #fef3c7; color: #92400e;">
                            <i class="fas fa-star"></i> Featured
                        </span>
                    @endif

                    @if ($staff->is_active)
                        <span class="badge" style="background: #d1fae5; color: #065f46;">
                            <i class="fas fa-check"></i> Active
                        </span>
                    @else
                        <span class="badge" style="background: #fee2e2; color: #991b1b;">
                            <i class="fas fa-times"></i> Inactive
                        </span>
                    @endif
                </div>

                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('admin.staff.destroy', $staff) }}" style="display: inline;"
                        onsubmit="return confirm('Hapus staff ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        @if ($staff->biography)
            <div class="info-section" style="border-bottom: 1px solid var(--border);">
                <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 15px;">
                    <i class="fas fa-info-circle"></i> Biografi
                </h3>
                <p style="line-height: 1.8; color: #374151;">{{ $staff->biography }}</p>
            </div>
        @endif

        <div class="info-section">
            <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 20px;">
                <i class="fas fa-address-card"></i> Informasi Detail
            </h3>
            <div class="info-grid">
                @if ($staff->department)
                    <div class="info-item">
                        <span class="info-label">Departemen</span>
                        <span class="info-value">{{ $staff->department }}</span>
                    </div>
                @endif

                @if ($staff->specialization)
                    <div class="info-item">
                        <span class="info-label">Spesialisasi</span>
                        <span class="info-value">{{ $staff->specialization }}</span>
                    </div>
                @endif

                @if ($staff->email)
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">
                            <a href="mailto:{{ $staff->email }}" style="color: var(--primary);">{{ $staff->email }}</a>
                        </span>
                    </div>
                @endif

                @if ($staff->phone)
                    <div class="info-item">
                        <span class="info-label">Telepon</span>
                        <span class="info-value">
                            <a href="tel:{{ $staff->phone }}" style="color: var(--primary);">{{ $staff->phone }}</a>
                        </span>
                    </div>
                @endif

                @if ($staff->join_date)
                    <div class="info-item">
                        <span class="info-label">Tanggal Bergabung</span>
                        <span class="info-value">{{ $staff->join_date->format('d M Y') }}</span>
                    </div>
                @endif

                <div class="info-item">
                    <span class="info-label">Dibuat</span>
                    <span class="info-value">{{ $staff->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        @if ($staff->social_media && array_filter((array) $staff->social_media))
            <div class="info-section" style="border-top: 1px solid var(--border);">
                <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 20px;">
                    <i class="fas fa-share-alt"></i> Social Media
                </h3>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    @if (!empty($staff->social_media['facebook']))
                        <a href="{{ $staff->social_media['facebook'] }}" target="_blank" class="btn"
                            style="background: #1877f2; color: white;">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                    @endif
                    @if (!empty($staff->social_media['instagram']))
                        <a href="{{ $staff->social_media['instagram'] }}" target="_blank" class="btn"
                            style="background: #e4405f; color: white;">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>
                    @endif
                    @if (!empty($staff->social_media['twitter']))
                        <a href="{{ $staff->social_media['twitter'] }}" target="_blank" class="btn"
                            style="background: #1da1f2; color: white;">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                    @endif
                    @if (!empty($staff->social_media['linkedin']))
                        <a href="{{ $staff->social_media['linkedin'] }}" target="_blank" class="btn"
                            style="background: #0077b5; color: white;">
                            <i class="fab fa-linkedin"></i> LinkedIn
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

@endsection
