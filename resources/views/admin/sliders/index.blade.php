@extends('admin.layouts.app')

@section('title', 'Sliders')

@section('content')
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 class="page-title">Sliders</h1>
                <p class="page-subtitle">Kelola slider hero homepage</p>
            </div>
            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Slider
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Slider</h3>
            <div class="card-tools">
                <span class="badge">{{ $sliders->total() }} Total</span>
            </div>
        </div>
        <div class="card-body">
            @if ($sliders->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="60">Order</th>
                                <th width="100">Preview</th>
                                <th>Judul</th>
                                <th>Posisi Text</th>
                                <th width="100" class="text-center">Status</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-sliders">
                            @foreach ($sliders as $slider)
                                <tr data-id="{{ $slider->id }}">
                                    <td>
                                        <div class="drag-handle">
                                            <i class="fas fa-grip-vertical"></i>
                                            <span>{{ $slider->order }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="table-image">
                                            @if ($slider->image)
                                                <img src="{{ asset('storage/' . $slider->image) }}"
                                                    alt="{{ $slider->title }}">
                                            @else
                                                <div class="no-image">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="table-content">
                                            <strong>{{ $slider->title }}</strong>
                                            @if ($slider->subtitle)
                                                <small>{{ $slider->subtitle }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">{{ ucfirst($slider->text_position) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.sliders.toggle', $slider) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                class="toggle-btn {{ $slider->is_active ? 'active' : '' }}">
                                                <i
                                                    class="fas fa-{{ $slider->is_active ? 'check-circle' : 'times-circle' }}"></i>
                                                {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.sliders.edit', $slider) }}"
                                                class="btn-action btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus slider ini?')">
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

                <!-- Pagination -->
                <div class="card-footer">
                    {{ $sliders->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-images"></i>
                    <h3>Belum Ada Slider</h3>
                    <p>Mulai tambahkan slider untuk homepage Anda</p>
                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Tambah Slider Pertama
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

        .badge-secondary {
            background: #e5e7eb;
            color: #6b7280;
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
        }

        .table tbody tr:hover {
            background: var(--light);
        }

        .table-image {
            width: 80px;
            height: 50px;
            border-radius: 8px;
            overflow: hidden;
        }

        .table-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image {
            width: 100%;
            height: 100%;
            background: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
        }

        .table-content strong {
            display: block;
            font-size: 0.95rem;
            color: var(--dark);
            margin-bottom: 3px;
        }

        .table-content small {
            display: block;
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .drag-handle {
            cursor: move;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #9ca3af;
        }

        .drag-handle:hover {
            color: var(--primary);
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
            margin-bottom: 25px;
        }

        .text-center {
            text-align: center;
        }

        .d-inline {
            display: inline;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        // Sortable for reordering
        const sortable = new Sortable(document.getElementById('sortable-sliders'), {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function(evt) {
                const orders = [];
                document.querySelectorAll('#sortable-sliders tr').forEach((row, index) => {
                    orders.push(row.dataset.id);
                });

                // Send AJAX request to update order
                fetch('{{ route('admin.sliders.update-order') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            orders: orders
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update order numbers in UI
                            document.querySelectorAll('#sortable-sliders tr').forEach((row, index) => {
                                row.querySelector('.drag-handle span').textContent = index + 1;
                            });
                        }
                    });
            }
        });
    </script>
@endpush
