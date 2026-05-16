@extends('admin.layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* === DASHBOARD GRID === */
    .dash-welcome {
        background: linear-gradient(135deg, var(--primary) 0%, #003d94 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .dash-welcome h2 { font-size: 1.5rem; font-weight: 700; margin-bottom: 4px; }
    .dash-welcome p { opacity: 0.85; font-size: 0.9rem; }
    .dash-welcome .cache-btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 20px; background: rgba(255,255,255,0.2);
        color: white; border: 1px solid rgba(255,255,255,0.3);
        border-radius: 8px; font-weight: 600; font-size: 0.85rem;
        cursor: pointer; transition: all 0.3s ease;
    }
    .dash-welcome .cache-btn:hover { background: rgba(255,255,255,0.35); }

    /* Stats Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: white; padding: 20px; border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        display: flex; align-items: center; gap: 16px;
        transition: all 0.3s ease; border: 1px solid #f0f0f0;
        text-decoration: none;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; flex-shrink: 0;
    }
    .stat-icon.blue { background: rgba(0,83,197,0.1); color: #0053C5; }
    .stat-icon.green { background: rgba(16,185,129,0.1); color: #10b981; }
    .stat-icon.amber { background: rgba(245,158,11,0.1); color: #f59e0b; }
    .stat-icon.red { background: rgba(239,68,68,0.1); color: #ef4444; }
    .stat-icon.purple { background: rgba(139,92,246,0.1); color: #8b5cf6; }
    .stat-icon.cyan { background: rgba(6,182,212,0.1); color: #06b6d4; }
    .stat-icon.pink { background: rgba(236,72,153,0.1); color: #ec4899; }
    .stat-icon.indigo { background: rgba(99,102,241,0.1); color: #6366f1; }
    .stat-value { font-size: 1.5rem; font-weight: 700; color: #1a1a1a; line-height: 1.2; }
    .stat-label { font-size: 0.78rem; color: #6b7280; margin-top: 2px; }

    /* Section Titles */
    .dash-section-title {
        font-size: 1.1rem; font-weight: 700; color: #1a1a1a;
        margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
    }
    .dash-section-title i { color: var(--primary); font-size: 0.95rem; }

    /* Two-Column Layout */
    .dash-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }
    .dash-grid-3 {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    /* Panel / Card */
    .dash-panel {
        background: white; border-radius: 14px; padding: 20px 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #f0f0f0;
    }
    .dash-panel-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #f3f4f6;
    }
    .dash-panel-header h3 {
        font-size: 1rem; font-weight: 700; color: #1a1a1a;
        display: flex; align-items: center; gap: 8px;
    }
    .dash-panel-header h3 i { color: var(--primary); }
    .dash-panel-link {
        font-size: 0.8rem; color: var(--primary); text-decoration: none;
        font-weight: 600; display: flex; align-items: center; gap: 4px;
    }
    .dash-panel-link:hover { text-decoration: underline; }

    /* List Items */
    .dash-list { list-style: none; padding: 0; margin: 0; }
    .dash-list-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 0; border-bottom: 1px solid #f9fafb;
    }
    .dash-list-item:last-child { border-bottom: none; }
    .dash-list-item .item-icon {
        width: 36px; height: 36px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem; flex-shrink: 0;
    }
    .dash-list-item .item-body { flex: 1; min-width: 0; }
    .dash-list-item .item-title {
        font-size: 0.85rem; font-weight: 600; color: #1a1a1a;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .dash-list-item .item-meta { font-size: 0.75rem; color: #9ca3af; }
    .dash-list-item .item-badge {
        font-size: 0.7rem; padding: 3px 8px; border-radius: 20px;
        font-weight: 600; flex-shrink: 0;
    }
    .badge-published { background: #d1fae5; color: #065f46; }
    .badge-draft { background: #fef3c7; color: #92400e; }
    .badge-pending { background: #fef3c7; color: #92400e; }
    .badge-new { background: #dbeafe; color: #1e40af; }
    .badge-views { background: #f3f4f6; color: #374151; }

    /* Chart Container */
    .chart-container { position: relative; height: 220px; }

    /* Activity Timeline */
    .activity-item {
        display: flex; gap: 12px; padding: 8px 0;
        border-bottom: 1px solid #f9fafb;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: var(--primary); margin-top: 6px; flex-shrink: 0;
    }
    .activity-text { font-size: 0.82rem; color: #374151; line-height: 1.4; }
    .activity-text strong { color: #1a1a1a; }
    .activity-time { font-size: 0.72rem; color: #9ca3af; margin-top: 2px; }

    /* Empty State */
    .dash-empty {
        text-align: center; padding: 24px; color: #9ca3af; font-size: 0.85rem;
    }
    .dash-empty i { font-size: 1.5rem; margin-bottom: 8px; display: block; }

    /* Responsive */
    @media (max-width: 1024px) {
        .dash-grid-2, .dash-grid-3 { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .dash-welcome { padding: 20px; }
    }
    @media (max-width: 480px) {
        .stats-row { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
    {{-- Welcome Banner --}}
    <div class="dash-welcome">
        <div>
            <h2>Assalamu'alaikum, {{ auth()->user()->name }} 👋</h2>
            <p>{{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }} — Berikut ringkasan data website Anda</p>
        </div>
        <form action="{{ route('admin.cache.clear') }}" method="POST">
            @csrf
            <button type="submit" class="cache-btn" onclick="return confirm('Clear semua cache?')">
                <i class="fas fa-sync-alt"></i> Clear Cache
            </button>
        </form>
    </div>

    {{-- ROW 1: Statistik Konten --}}
    <h3 class="dash-section-title"><i class="fas fa-chart-bar"></i> Ringkasan Konten</h3>
    <div class="stats-row">
        <a href="{{ route('admin.posts.index') }}" class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-newspaper"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_posts']) }}</div>
                <div class="stat-label">Total Berita</div>
            </div>
        </a>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['published_posts']) }}</div>
                <div class="stat-label">Dipublikasi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-edit"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['draft_posts']) }}</div>
                <div class="stat-label">Draft</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-eye"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_views']) }}</div>
                <div class="stat-label">Total Views</div>
            </div>
        </div>
    </div>

    {{-- ROW 2: Statistik Program & Galeri --}}
    <h3 class="dash-section-title"><i class="fas fa-mosque"></i> Program & Media</h3>
    <div class="stats-row">
        <a href="{{ route('admin.programs.index') }}" class="stat-card">
            <div class="stat-icon indigo"><i class="fas fa-calendar-check"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['active_programs']) }}<span style="font-size:0.8rem;color:#9ca3af">/{{ $stats['total_programs'] }}</span></div>
                <div class="stat-label">Program Aktif</div>
            </div>
        </a>
        <a href="{{ route('admin.gallery.albums.index') }}" class="stat-card">
            <div class="stat-icon cyan"><i class="fas fa-images"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_photos']) }}</div>
                <div class="stat-label">Foto ({{ $stats['total_albums'] }} Album)</div>
            </div>
        </a>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-sliders-h"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['active_sliders']) }}</div>
                <div class="stat-label">Hero Banner Aktif</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-clock"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['active_schedules']) }}</div>
                <div class="stat-label">Jadwal Aktif</div>
            </div>
        </div>
    </div>

    {{-- ROW 3: Statistik Interaksi & Donasi --}}
    <h3 class="dash-section-title"><i class="fas fa-handshake"></i> Interaksi & Donasi</h3>
    <div class="stats-row">
        <a href="{{ route('admin.comments.index') }}" class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-comments"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['pending_comments']) }}</div>
                <div class="stat-label">Komentar Pending</div>
            </div>
        </a>
        <a href="{{ route('admin.contacts.index') }}" class="stat-card">
            <div class="stat-icon red"><i class="fas fa-envelope-open"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['new_contacts']) }}</div>
                <div class="stat-label">Pesan Baru</div>
            </div>
        </a>
        <a href="{{ route('admin.donation-transactions.index') }}" class="stat-card">
            <div class="stat-icon pink"><i class="fas fa-hand-holding-usd"></i></div>
            <div>
                <div class="stat-value">Rp {{ number_format($stats['total_donation_amount'], 0, ',', '.') }}</div>
                <div class="stat-label">Total Donasi Terverifikasi</div>
            </div>
        </a>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-receipt"></i></div>
            <div>
                <div class="stat-value">{{ number_format($stats['pending_donations']) }}</div>
                <div class="stat-label">Donasi Menunggu Verifikasi</div>
            </div>
        </div>
    </div>

    {{-- CHART ROW --}}
    <div class="dash-grid-2">
        {{-- Chart Berita --}}
        <div class="dash-panel">
            <div class="dash-panel-header">
                <h3><i class="fas fa-chart-line"></i> Berita 7 Hari Terakhir</h3>
            </div>
            <div class="chart-container">
                <canvas id="postsChart"></canvas>
            </div>
        </div>
        {{-- Chart Donasi --}}
        <div class="dash-panel">
            <div class="dash-panel-header">
                <h3><i class="fas fa-chart-bar"></i> Donasi Bulan Ini</h3>
            </div>
            <div class="chart-container">
                <canvas id="donationsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- DETAIL ROW: Berita Terbaru + Terpopuler --}}
    <div class="dash-grid-2">
        {{-- Berita Terbaru --}}
        <div class="dash-panel">
            <div class="dash-panel-header">
                <h3><i class="fas fa-clock"></i> Berita Terbaru</h3>
                <a href="{{ route('admin.posts.index') }}" class="dash-panel-link">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
            @if($recentPosts->count())
                <ul class="dash-list">
                    @foreach($recentPosts as $post)
                        <li class="dash-list-item">
                            <div class="item-icon" style="background:rgba(0,83,197,0.08);color:#0053C5;"><i class="fas fa-file-alt"></i></div>
                            <div class="item-body">
                                <div class="item-title">{{ $post->title }}</div>
                                <div class="item-meta">{{ $post->category->name ?? '-' }} · {{ $post->created_at->diffForHumans() }}</div>
                            </div>
                            <span class="item-badge {{ $post->status === 'published' ? 'badge-published' : 'badge-draft' }}">{{ ucfirst($post->status) }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="dash-empty"><i class="fas fa-inbox"></i> Belum ada berita</div>
            @endif
        </div>

        {{-- Berita Terpopuler --}}
        <div class="dash-panel">
            <div class="dash-panel-header">
                <h3><i class="fas fa-fire"></i> Berita Terpopuler</h3>
            </div>
            @if($popularPosts->count())
                <ul class="dash-list">
                    @foreach($popularPosts as $i => $post)
                        <li class="dash-list-item">
                            <div class="item-icon" style="background:{{ $i < 3 ? 'rgba(245,158,11,0.1)' : '#f3f4f6' }};color:{{ $i < 3 ? '#f59e0b' : '#6b7280' }};font-weight:700;">{{ $i + 1 }}</div>
                            <div class="item-body">
                                <div class="item-title">{{ $post->title }}</div>
                                <div class="item-meta">{{ $post->category->name ?? '-' }}</div>
                            </div>
                            <span class="item-badge badge-views"><i class="fas fa-eye" style="margin-right:3px;"></i> {{ number_format($post->views_count) }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="dash-empty"><i class="fas fa-chart-bar"></i> Belum ada data</div>
            @endif
        </div>
    </div>

    {{-- DETAIL ROW: Komentar Pending + Kontak Baru + Aktivitas --}}
    <div class="dash-grid-3">
        <div>
            {{-- Komentar Pending --}}
            <div class="dash-panel" style="margin-bottom: 24px;">
                <div class="dash-panel-header">
                    <h3><i class="fas fa-comment-dots"></i> Komentar Menunggu Persetujuan</h3>
                    <a href="{{ route('admin.comments.index') }}" class="dash-panel-link">Kelola <i class="fas fa-arrow-right"></i></a>
                </div>
                @if($pendingComments->count())
                    <ul class="dash-list">
                        @foreach($pendingComments as $comment)
                            <li class="dash-list-item">
                                <div class="item-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;"><i class="fas fa-comment"></i></div>
                                <div class="item-body">
                                    <div class="item-title">{{ $comment->author_name ?? 'Anonim' }}</div>
                                    <div class="item-meta">{{ Str::limit($comment->content, 60) }}</div>
                                    <div class="item-meta">Pada: {{ Str::limit($comment->post->title ?? '-', 40) }} · {{ $comment->created_at->diffForHumans() }}</div>
                                </div>
                                <span class="item-badge badge-pending">Pending</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="dash-empty"><i class="fas fa-check-circle"></i> Semua komentar sudah ditinjau</div>
                @endif
            </div>

            {{-- Kontak / Pesan Baru --}}
            <div class="dash-panel">
                <div class="dash-panel-header">
                    <h3><i class="fas fa-envelope"></i> Pesan Baru</h3>
                    <a href="{{ route('admin.contacts.index') }}" class="dash-panel-link">Lihat Semua <i class="fas fa-arrow-right"></i></a>
                </div>
                @if($newContacts->count())
                    <ul class="dash-list">
                        @foreach($newContacts as $contact)
                            <li class="dash-list-item">
                                <div class="item-icon" style="background:rgba(239,68,68,0.1);color:#ef4444;"><i class="fas fa-envelope-open"></i></div>
                                <div class="item-body">
                                    <div class="item-title">{{ $contact->name }}</div>
                                    <div class="item-meta">{{ Str::limit($contact->subject ?? $contact->message, 50) }}</div>
                                    <div class="item-meta">{{ $contact->created_at->diffForHumans() }}</div>
                                </div>
                                <span class="item-badge badge-new">Baru</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="dash-empty"><i class="fas fa-inbox"></i> Tidak ada pesan baru</div>
                @endif
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="dash-panel">
            <div class="dash-panel-header">
                <h3><i class="fas fa-history"></i> Aktivitas Terbaru</h3>
                <a href="{{ route('admin.activity-logs.index') }}" class="dash-panel-link">Log <i class="fas fa-arrow-right"></i></a>
            </div>
            @if($recentActivities->count())
                @foreach($recentActivities as $activity)
                    <div class="activity-item">
                        <div class="activity-dot"></div>
                        <div>
                            <div class="activity-text">
                                <strong>{{ $activity->causer->name ?? 'System' }}</strong>
                                {{ $activity->description }}
                            </div>
                            <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="dash-empty"><i class="fas fa-stream"></i> Belum ada aktivitas</div>
            @endif
        </div>
    </div>

    {{-- Quick Shortcut Cards --}}
    <h3 class="dash-section-title"><i class="fas fa-th-large"></i> Ringkasan Sistem</h3>
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-bullhorn"></i></div>
            <div>
                <div class="stat-value">{{ $stats['active_announcements'] }}</div>
                <div class="stat-label">Pengumuman Aktif</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-user-tie"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_staff'] }}</div>
                <div class="stat-label">Pengurus & Staf</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-star"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_testimonials'] }}</div>
                <div class="stat-label">Testimoni</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon cyan"><i class="fas fa-user-shield"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Admin Users</div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Posts Chart
    new Chart(document.getElementById('postsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($postsChart['labels']) !!},
            datasets: [{
                label: 'Berita Dibuat',
                data: {!! json_encode($postsChart['data']) !!},
                borderColor: '#0053C5',
                backgroundColor: 'rgba(0,83,197,0.08)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#0053C5',
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: '#f3f4f6' } },
                x: { ticks: { font: { size: 11 } }, grid: { display: false } }
            }
        }
    });

    // Donations Chart
    new Chart(document.getElementById('donationsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($donationsChart['labels']) !!},
            datasets: [{
                label: 'Donasi (Rp)',
                data: {!! json_encode($donationsChart['data']) !!},
                backgroundColor: ['rgba(16,185,129,0.7)', 'rgba(16,185,129,0.55)', 'rgba(16,185,129,0.4)', 'rgba(16,185,129,0.3)'],
                borderColor: '#10b981',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { size: 11 },
                        callback: function(v) { return 'Rp ' + (v/1000000).toFixed(1) + 'jt'; }
                    },
                    grid: { color: '#f3f4f6' }
                },
                x: { ticks: { font: { size: 11 } }, grid: { display: false } }
            }
        }
    });
</script>
@endpush
