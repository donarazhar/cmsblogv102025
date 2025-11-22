@extends('admin.layouts.app')

@section('title', 'Detail Pesan Kontak')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Detail Pesan Kontak</h1>
        <p class="page-subtitle">Informasi lengkap pesan dari pengunjung</p>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.contacts.index') }}">Contacts</a>
            <span>/</span>
            <span>Detail</span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-bar mb-4">
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div class="action-right">
            @if ($contact->status !== 'archived')
                <form action="{{ route('admin.contacts.archive', $contact) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-archive"></i> Arsipkan
                    </button>
                </form>
            @endif
            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display: inline;"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="detail-grid">
        <!-- Main Content -->
        <div class="detail-main">
            <!-- Message Card -->
            <div class="card">
                <div class="card-header">
                    <div class="message-header-content">
                        <div class="message-status">
                            <span class="badge badge-lg badge-status-{{ $contact->status }}">
                                @switch($contact->status)
                                    @case('new')
                                        <i class="fas fa-envelope"></i> Pesan Baru
                                    @break

                                    @case('read')
                                        <i class="fas fa-envelope-open"></i> Sudah Dibaca
                                    @break

                                    @case('replied')
                                        <i class="fas fa-reply"></i> Sudah Dibalas
                                    @break

                                    @case('archived')
                                        <i class="fas fa-archive"></i> Terarsip
                                    @break
                                @endswitch
                            </span>
                        </div>
                        <h2 class="message-subject">{{ $contact->subject }}</h2>
                        <div class="message-meta">
                            <span><i class="fas fa-calendar"></i>
                                {{ $contact->created_at->format('d F Y, H:i') }}</span>
                            <span><i class="fas fa-clock"></i>
                                {{ $contact->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="message-content">
                        <h4 class="section-title">Isi Pesan</h4>
                        <div class="message-text">
                            {{ $contact->message }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reply Section -->
            @if ($contact->admin_reply)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-reply"></i>
                            Balasan Admin
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="reply-info">
                            <div class="reply-meta">
                                <i class="fas fa-user"></i>
                                <span>Dibalas oleh: <strong>{{ $contact->replier->name ?? 'Admin' }}</strong></span>
                            </div>
                            <div class="reply-meta">
                                <i class="fas fa-clock"></i>
                                <span>{{ $contact->replied_at->format('d F Y, H:i') }}</span>
                            </div>
                        </div>
                        <div class="reply-content">
                            {{ $contact->admin_reply }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Reply Form -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-reply"></i>
                            Balas Pesan
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="admin_reply" class="form-label required">Balasan Anda</label>
                                <textarea class="form-control @error('admin_reply') is-invalid @enderror" id="admin_reply" name="admin_reply"
                                    rows="8" required placeholder="Tulis balasan Anda di sini...">{{ old('admin_reply') }}</textarea>
                                @error('admin_reply')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text">
                                    <i class="fas fa-info-circle"></i>
                                    Balasan akan disimpan di sistem. Anda dapat mengirim email manual ke
                                    {{ $contact->email }}
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Kirim Balasan
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="detail-sidebar">
            <!-- Sender Info Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        Informasi Pengirim
                    </h3>
                </div>
                <div class="card-body">
                    <div class="sender-profile">
                        <div class="sender-avatar">
                            {{ strtoupper(substr($contact->name, 0, 2)) }}
                        </div>
                        <h4 class="sender-name">{{ $contact->name }}</h4>
                    </div>

                    <div class="info-list">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Email</div>
                                <a href="mailto:{{ $contact->email }}" class="info-value">{{ $contact->email }}</a>
                            </div>
                        </div>

                        @if ($contact->phone)
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Telepon</div>
                                    <a href="tel:{{ $contact->phone }}" class="info-value">{{ $contact->phone }}</a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="contact-actions">
                        <a href="mailto:{{ $contact->email }}" class="contact-action-btn">
                            <i class="fas fa-envelope"></i>
                            <span>Kirim Email</span>
                        </a>
                        @if ($contact->phone)
                            <a href="tel:{{ $contact->phone }}" class="contact-action-btn">
                                <i class="fas fa-phone"></i>
                                <span>Telepon</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Technical Info Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Informasi Teknis
                    </h3>
                </div>
                <div class="card-body">
                    <div class="tech-info-item">
                        <label>ID Pesan:</label>
                        <span>#{{ $contact->id }}</span>
                    </div>
                    @if ($contact->ip_address)
                        <div class="tech-info-item">
                            <label>IP Address:</label>
                            <code>{{ $contact->ip_address }}</code>
                        </div>
                    @endif
                    @if ($contact->user_agent)
                        <div class="tech-info-item">
                            <label>User Agent:</label>
                            <small class="user-agent">{{ Str::limit($contact->user_agent, 80) }}</small>
                        </div>
                    @endif
                    <div class="tech-info-item">
                        <label>Diterima:</label>
                        <span>{{ $contact->created_at->format('d F Y, H:i:s') }}</span>
                    </div>
                    <div class="tech-info-item">
                        <label>Update Terakhir:</label>
                        <span>{{ $contact->updated_at->format('d F Y, H:i:s') }}</span>
                    </div>
                </div>
            </div>

            <!-- Status Timeline Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history"></i>
                        Timeline Status
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item active">
                            <div class="timeline-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="timeline-content">
                                <strong>Pesan Diterima</strong>
                                <small>{{ $contact->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>

                        @if ($contact->status !== 'new')
                            <div class="timeline-item active">
                                <div class="timeline-icon">
                                    <i class="fas fa-envelope-open"></i>
                                </div>
                                <div class="timeline-content">
                                    <strong>Dibaca</strong>
                                    <small>{{ $contact->updated_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        @endif

                        @if ($contact->status === 'replied')
                            <div class="timeline-item active">
                                <div class="timeline-icon">
                                    <i class="fas fa-reply"></i>
                                </div>
                                <div class="timeline-content">
                                    <strong>Dibalas</strong>
                                    <small>{{ $contact->replied_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        @endif

                        @if ($contact->status === 'archived')
                            <div class="timeline-item active">
                                <div class="timeline-icon">
                                    <i class="fas fa-archive"></i>
                                </div>
                                <div class="timeline-content">
                                    <strong>Diarsipkan</strong>
                                    <small>{{ $contact->updated_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .action-right {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
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

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-body {
            padding: 20px;
        }

        .message-header-content {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message-status {
            display: flex;
            justify-content: flex-start;
        }

        .message-subject {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .message-meta {
            display: flex;
            gap: 20px;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .message-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: var(--primary);
            border-radius: 2px;
        }

        .message-content {
            margin-bottom: 20px;
        }

        .message-text {
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 25px;
            line-height: 1.8;
            color: #374151;
            font-size: 0.95rem;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .reply-info {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            padding: 15px;
            background: var(--light);
            border-radius: 8px;
        }

        .reply-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .reply-content {
            background: #dbeafe;
            border-left: 4px solid var(--info);
            padding: 20px;
            border-radius: 8px;
            line-height: 1.8;
            color: #1e40af;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .form-label.required::after {
            content: '*';
            color: var(--danger);
            margin-left: 4px;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            display: block;
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .form-text {
            display: block;
            margin-top: 8px;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .sender-profile {
            text-align: center;
            margin-bottom: 20px;
        }

        .sender-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 700;
            margin: 0 auto 15px;
        }

        .sender-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .info-list {
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: var(--light);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .info-value {
            font-weight: 500;
            color: var(--dark);
            font-size: 0.95rem;
            text-decoration: none;
            display: block;
            word-break: break-all;
        }

        .info-value:hover {
            color: var(--primary);
        }

        .contact-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .contact-action-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: 8px;
            text-decoration: none;
            color: var(--dark);
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .contact-action-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateX(5px);
        }

        .contact-action-btn i {
            width: 20px;
            text-align: center;
        }

        .tech-info-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }

        .tech-info-item:last-child {
            border-bottom: none;
        }

        .tech-info-item label {
            font-weight: 600;
            color: #6b7280;
            flex-shrink: 0;
            margin-right: 10px;
        }

        .tech-info-item code {
            background: var(--light);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            color: var(--primary);
        }

        .user-agent {
            color: #6b7280;
            word-break: break-all;
            text-align: right;
        }

        .timeline {
            position: relative;
            padding-left: 40px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--border);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-icon {
            position: absolute;
            left: -33px;
            width: 32px;
            height: 32px;
            background: white;
            border: 2px solid var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 0.85rem;
        }

        .timeline-item.active .timeline-icon {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .timeline-content strong {
            display: block;
            color: var(--dark);
            margin-bottom: 4px;
            font-size: 0.9rem;
        }

        .timeline-content small {
            color: #6b7280;
            font-size: 0.8rem;
        }

        .badge {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .badge-lg {
            padding: 10px 20px;
            font-size: 1rem;
        }

        .badge-status-new {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-status-read {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-status-replied {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-status-archived {
            background: #e5e7eb;
            color: #374151;
        }

        @media (max-width: 1024px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .action-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .action-right {
                width: 100%;
            }

            .btn {
                flex: 1;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .message-subject {
                font-size: 1.4rem;
            }

            .message-meta {
                flex-direction: column;
                gap: 8px;
            }

            .reply-info {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
@endpush
