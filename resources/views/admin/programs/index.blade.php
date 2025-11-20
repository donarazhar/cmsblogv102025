@extends('admin.layouts.app')

@section('title', 'Programs')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Programs & Kegiatan</h1>
                <p class="page-subtitle">Kelola program dan kegiatan masjid</p>
            </div>
            <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Program
            </a>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="filter-tab active" data-type="all">
            <i class="fas fa-th"></i> Semua ({{ $programs->total() }})
        </button>
        <button class="filter-tab" data-type="regular">
            <i class="fas fa-calendar"></i> Regular
        </button>
        <button class="filter-tab" data-type="event">
            <i class="fas fa-calendar-star"></i> Event
        </button>
        <button class="filter-tab" data-type="course">
            <i class="fas fa-graduation-cap"></i> Kursus
        </button>
        <button class="filter-tab" data-type="charity">
            <i class="fas fa-hand-holding-heart"></i> Sosial
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($programs->count() > 0)
                <div class="programs-grid">
                    @foreach ($programs as $program)
                        <div class="program-card" data-type="{{ $program->type }}">
                            <!-- Image -->
                            <div class="program-image">
                                @if ($program->image)
                                    <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->name }}">
                                @else
                                    <div class="no-image">
                                        <i class="{{ $program->icon ?? 'fas fa-calendar-check' }}"></i>
                                    </div>
                                @endif

                                <!-- Badges -->
                                <div class="program-badges">
                                    @if ($program->is_featured)
                                        <span class="badge badge-warning">
                                            <i class="fas fa-star"></i> Featured
                                        </span>
                                    @endif
                                    <span class="badge badge-{{ $program->is_active ? 'success' : 'danger' }}">
                                        {{ $program->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="program-content">
                                <div class="program-type">{{ ucfirst($program->type) }}</div>
                                <h3 class="program-title">{{ $program->name }}</h3>
                                <p class="program-description">{{ Str::limit($program->description, 100) }}</p>

                                <!-- Info Grid -->
                                <div class="program-info">
                                    @if ($program->frequency)
                                        <div class="info-item">
                                            <i class="fas fa-redo"></i>
                                            <span>{{ ucfirst($program->frequency) }}</span>
                                        </div>
                                    @endif

                                    @if ($program->location)
                                        <div class="info-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ Str::limit($program->location, 20) }}</span>
                                        </div>
                                    @endif

                                    @if ($program->max_participants)
                                        <div class="info-item">
                                            <i class="fas fa-users"></i>
                                            <span>{{ $program->current_participants }}/{{ $program->max_participants }}</span>
                                        </div>
                                    @endif

                                    @if ($program->registration_fee > 0)
                                        <div class="info-item">
                                            <i class="fas fa-money-bill-wave"></i>
                                            <span>Rp {{ number_format($program->registration_fee, 0, ',', '.') }}</span>
                                        </div>
                                    @elseif($program->registration_fee === 0)
                                        <div class="info-item">
                                            <i class="fas fa-check-circle"></i>
                                            <span style="color: var(--success); font-weight: 600;">Gratis</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="program-actions">
                                    <form action="{{ route('admin.programs.toggle', $program) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn-action btn-status {{ $program->is_active ? 'active' : '' }}"
                                            title="{{ $program->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas fa-{{ $program->is_active ? 'eye' : 'eye-slash' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.programs.toggle-featured', $program) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn-action btn-featured {{ $program->is_featured ? 'active' : '' }}"
                                            title="{{ $program->is_featured ? 'Hapus dari Featured' : 'Jadikan Featured' }}">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.programs.edit', $program) }}" class="btn-action btn-edit"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus program ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="card-footer">
                    {{ $programs->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-check"></i>
                    <h3>Belum Ada Program</h3>
                    <p>Mulai tambahkan program kegiatan masjid Anda</p>
                    <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Tambah Program Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 10px 20px;
            background: white;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-tab:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .filter-tab.active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .card-body {
            padding: 25px;
        }

        .card-footer {
            padding: 20px 25px;
            border-top: 1px solid var(--border);
        }

        .programs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .program-card {
            background: white;
            border: 2px solid var(--border);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-color: var(--primary);
        }

        .program-image {
            width: 100%;
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .program-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .program-card:hover .program-image img {
            transform: scale(1.1);
        }

        .no-image {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .program-badges {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 5px;
            flex-direction: column;
            align-items: flex-end;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-success {
            background: var(--success);
            color: white;
        }

        .badge-danger {
            background: var(--danger);
            color: white;
        }

        .badge-warning {
            background: var(--warning);
            color: white;
        }

        .program-content {
            padding: 20px;
        }

        .program-type {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .program-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--dark);
            line-height: 1.4;
        }

        .program-description {
            color: #6b7280;
            margin-bottom: 15px;
            line-height: 1.6;
            font-size: 0.9rem;
        }

        .program-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 15px;
            padding: 15px;
            background: var(--light);
            border-radius: 10px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .info-item i {
            color: var(--primary);
            width: 16px;
        }

        .program-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            padding-top: 15px;
            border-top: 1px solid var(--border);
        }

        .btn-action {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-status {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-status.active {
            background: #d1fae5;
            color: #059669;
        }

        .btn-status:hover {
            transform: scale(1.1);
        }

        .btn-featured {
            background: #fef3c7;
            color: #d97706;
        }

        .btn-featured.active {
            background: var(--warning);
            color: white;
        }

        .btn-featured:hover {
            transform: scale(1.1);
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
            margin-bottom: 25px;
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

        .d-inline {
            display: inline;
        }

        @media (max-width: 768px) {
            .programs-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Filter Tabs
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const type = this.dataset.type;

                // Update active tab
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                // Filter cards
                document.querySelectorAll('.program-card').forEach(card => {
                    if (type === 'all' || card.dataset.type === type) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush
