@extends('admin.layouts.app')

@section('title', 'Staff Management')

@section('content')
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            padding: 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark);
        }

        .filter-bar {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            padding: 20px 25px;
            background: var(--light);
            border-bottom: 1px solid var(--border);
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .filter-input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
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

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 83, 197, 0.3);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .btn-icon {
            width: 35px;
            height: 35px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .bulk-actions {
            display: none;
            padding: 15px 25px;
            background: #fef3c7;
            border-bottom: 1px solid #fbbf24;
            align-items: center;
            gap: 15px;
        }

        .bulk-actions.active {
            display: flex;
        }

        .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 25px;
        }

        .staff-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .staff-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .staff-checkbox {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 10;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .staff-photo {
            width: 100%;
            height: 280px;
            object-fit: cover;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .staff-photo-placeholder {
            width: 100%;
            height: 280px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4rem;
        }

        .staff-body {
            padding: 20px;
        }

        .staff-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .staff-position {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .staff-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-primary {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .staff-actions {
            display: flex;
            gap: 8px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding: 25px;
            border-top: 1px solid var(--border);
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .staff-grid {
                grid-template-columns: 1fr;
            }

            .filter-bar {
                flex-direction: column;
            }
        }
    </style>

    <div class="page-header">
        <h1 class="page-title">Staff Management</h1>
        <p class="page-subtitle">Kelola data pengurus, imam, ustadz, dan staf masjid</p>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #dbeafe; color: #1e40af;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-label">Total Staff</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #d1fae5; color: #065f46;">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-label">Active</div>
            <div class="stat-value">{{ $stats['active'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7; color: #92400e;">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-label">Featured</div>
            <div class="stat-value">{{ $stats['featured'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fce7f3; color: #9f1239;">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-label">Board</div>
            <div class="stat-value">{{ $stats['by_type']['board'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #e0e7ff; color: #3730a3;">
                <i class="fas fa-mosque"></i>
            </div>
            <div class="stat-label">Imam</div>
            <div class="stat-value">{{ $stats['by_type']['imam'] }}</div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Semua Staff</h2>
            <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Staff
            </a>
        </div>

        <!-- Filter Bar -->
        <form method="GET" action="{{ route('admin.staff.index') }}" class="filter-bar">
            <div class="filter-group">
                <label class="filter-label">Cari Staff</label>
                <input type="text" name="search" class="filter-input" placeholder="Nama, posisi, email..."
                    value="{{ request('search') }}">
            </div>
            <div class="filter-group">
                <label class="filter-label">Tipe</label>
                <select name="type" class="filter-input">
                    <option value="">Semua Tipe</option>
                    <option value="board" {{ request('type') == 'board' ? 'selected' : '' }}>Board/Pengurus</option>
                    <option value="imam" {{ request('type') == 'imam' ? 'selected' : '' }}>Imam</option>
                    <option value="teacher" {{ request('type') == 'teacher' ? 'selected' : '' }}>Ustadz/Teacher</option>
                    <option value="staff" {{ request('type') == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="volunteer" {{ request('type') == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select name="status" class="filter-input">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="filter-group" style="display: flex; align-items: flex-end; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    <i class="fas fa-search"></i>
                    Filter
                </button>
                <a href="{{ route('admin.staff.index') }}" class="btn" style="background: #e5e7eb; color: var(--dark);">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>

        <!-- Bulk Actions -->
        <form method="POST" action="{{ route('admin.staff.bulk-delete') }}" id="bulkForm" class="bulk-actions"
            onsubmit="return confirm('Hapus staff yang dipilih?')">
            @csrf
            @method('DELETE')
            <span style="font-weight: 600;">
                <span id="selectedCount">0</span> staff dipilih
            </span>
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i> Hapus Terpilih
            </button>
        </form>

        <!-- Staff Grid -->
        @if ($staff->count() > 0)
            <div class="staff-grid">
                @foreach ($staff as $member)
                    <div class="staff-card">
                        <input type="checkbox" class="staff-checkbox" name="ids[]" value="{{ $member->id }}"
                            form="bulkForm">

                        @if ($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}"
                                class="staff-photo">
                        @else
                            <div class="staff-photo-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif

                        <div class="staff-body">
                            <h3 class="staff-name">{{ $member->name }}</h3>
                            <p class="staff-position">{{ $member->position }}</p>

                            <div class="staff-meta">
                                @if ($member->type === 'board')
                                    <span class="badge badge-primary"><i class="fas fa-user-tie"></i> Board</span>
                                @elseif($member->type === 'imam')
                                    <span class="badge" style="background: #e0e7ff; color: #3730a3;"><i
                                            class="fas fa-mosque"></i> Imam</span>
                                @elseif($member->type === 'teacher')
                                    <span class="badge badge-warning"><i class="fas fa-chalkboard-teacher"></i>
                                        Teacher</span>
                                @elseif($member->type === 'volunteer')
                                    <span class="badge" style="background: #fce7f3; color: #9f1239;"><i
                                            class="fas fa-hands-helping"></i> Volunteer</span>
                                @else
                                    <span class="badge" style="background: #f3f4f6; color: #374151;"><i
                                            class="fas fa-user"></i> Staff</span>
                                @endif

                                @if ($member->is_featured)
                                    <span class="badge" style="background: #fef3c7; color: #92400e;"><i
                                            class="fas fa-star"></i> Featured</span>
                                @endif

                                @if ($member->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </div>

                            <div class="staff-actions">
                                <a href="{{ route('admin.staff.show', $member) }}" class="btn btn-primary btn-sm"
                                    style="flex: 1;">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('admin.staff.edit', $member) }}"
                                    class="btn btn-primary btn-sm btn-icon">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.staff.destroy', $member) }}"
                                    style="display: inline;" onsubmit="return confirm('Hapus staff ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 10px;">Belum Ada Staff</h3>
                <p style="color: #6b7280; margin-bottom: 25px;">Mulai tambahkan data staff masjid Anda</p>
                <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Staff Pertama
                </a>
            </div>
        @endif

        <!-- Pagination -->
        @if ($staff->hasPages())
            <div class="pagination">
                <!-- Pagination -->
                <div style="margin-top: 50px; text-align:center; padding: 10px; border-radius: 5px;">
                    {{ $staff->links('vendor.pagination.simple') }}
                </div>
            </div>
        @endif
    </div>

    <script>
        // Checkbox functionality
        const checkboxes = document.querySelectorAll('.staff-checkbox');
        const bulkForm = document.querySelector('.bulk-actions');
        const selectedCount = document.getElementById('selectedCount');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checked = document.querySelectorAll('.staff-checkbox:checked');
            selectedCount.textContent = checked.length;

            if (checked.length > 0) {
                bulkForm.classList.add('active');
            } else {
                bulkForm.classList.remove('active');
            }
        }
    </script>
@endsection
