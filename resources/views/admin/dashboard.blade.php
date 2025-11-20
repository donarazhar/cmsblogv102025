@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h2 class="page-title">Dashboard</h2>
        <p class="page-subtitle">Selamat datang di Admin Panel Masjid Agung Al Azhar</p>
        <div class="breadcrumb">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </div>
    </div>

    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.primary {
            background: rgba(0, 83, 197, 0.1);
            color: var(--primary);
        }

        .stat-icon.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .stat-icon.warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .stat-icon.danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>

    <!-- Statistics Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-value">{{ number_format($stats['total_posts'] ?? 0) }}</div>
                    <div class="stat-label">Total Posts</div>
                </div>
                <div class="stat-icon primary">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-value">{{ number_format($stats['published_posts'] ?? 0) }}</div>
                    <div class="stat-label">Published Posts</div>
                </div>
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-value">{{ number_format($stats['pending_comments'] ?? 0) }}</div>
                    <div class="stat-label">Pending Comments</div>
                </div>
                <div class="stat-icon warning">
                    <i class="fas fa-comments"></i>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-value">{{ number_format($stats['new_contacts'] ?? 0) }}</div>
                    <div class="stat-label">New Contacts</div>
                </div>
                <div class="stat-icon danger">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </div>
    </div>

    <div
        style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); text-align: center;">
        <i class="fas fa-chart-line" style="font-size: 4rem; color: var(--primary); margin-bottom: 20px;"></i>
        <h3 style="font-size: 1.5rem; margin-bottom: 10px;">Dashboard Content</h3>
        <p style="color: #6b7280; margin-bottom: 20px;">Konten dashboard lengkap akan dibuat pada tahap berikutnya</p>
        <p style="color: #9ca3af; font-size: 0.9rem;">Anda telah berhasil login ke sistem!</p>
    </div>
@endsection
