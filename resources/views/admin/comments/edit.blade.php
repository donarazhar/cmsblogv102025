@extends('admin.layouts.app')

@section('title', 'Edit Comment')

@section('content')
    <style>
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

        .breadcrumb span {
            color: #9ca3af;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            max-width: 900px;
        }

        .form-header {
            padding: 25px;
            border-bottom: 1px solid var(--border);
        }

        .form-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .form-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-body {
            padding: 30px 25px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-label-required::after {
            content: '*';
            color: var(--danger);
            margin-left: 4px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
        }

        .form-input.error {
            border-color: var(--danger);
        }

        .form-help {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 6px;
        }

        .form-error {
            font-size: 0.85rem;
            color: var(--danger);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .info-box {
            background: #dbeafe;
            border: 1px solid #93c5fd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .info-icon {
            color: #1e40af;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-title {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 5px;
        }

        .info-text {
            color: #1e40af;
            font-size: 0.9rem;
        }

        .form-footer {
            padding: 20px 25px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            gap: 15px;
            background: var(--light);
            border-radius: 0 0 12px 12px;
        }

        .btn {
            padding: 12px 24px;
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

        .btn-secondary {
            background: #e5e7eb;
            color: var(--dark);
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        @media (max-width: 768px) {
            .form-footer {
                flex-direction: column;
            }
        }
    </style>

    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <span>/</span>
        <a href="{{ route('admin.comments.index') }}">Comments</a>
        <span>/</span>
        <span style="color: var(--dark); font-weight: 600;">Edit</span>
    </div>

    <div class="form-card">
        <div class="form-header">
            <h2 class="form-title">Edit Comment</h2>
            <p class="form-subtitle">Edit komentar dari {{ $comment->author }}</p>
        </div>

        <form method="POST" action="{{ route('admin.comments.update', $comment) }}">
            @csrf
            @method('PUT')

            <div class="form-body">
                <!-- Info Box -->
                <div class="info-box">
                    <i class="fas fa-info-circle info-icon"></i>
                    <div class="info-content">
                        <div class="info-title">Informasi Komentar</div>
                        <div class="info-text">
                            Komentar pada post: <strong>{{ $comment->post->title }}</strong><br>
                            Dibuat: {{ $comment->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="form-group">
                    <label for="content" class="form-label form-label-required">Isi Komentar</label>
                    <textarea id="content" name="content" class="form-input @error('content') error @enderror" rows="6" required>{{ old('content', $comment->content) }}</textarea>
                    @error('content')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @else
                        <div class="form-help">Konten komentar yang akan ditampilkan</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="form-label form-label-required">Status</label>
                    <select id="status" name="status" class="form-input @error('status') error @enderror" required>
                        <option value="pending" {{ old('status', $comment->status) === 'pending' ? 'selected' : '' }}>
                            Pending - Menunggu Moderasi
                        </option>
                        <option value="approved" {{ old('status', $comment->status) === 'approved' ? 'selected' : '' }}>
                            Approved - Ditampilkan
                        </option>
                        <option value="spam" {{ old('status', $comment->status) === 'spam' ? 'selected' : '' }}>
                            Spam - Tandai sebagai Spam
                        </option>
                        <option value="trash" {{ old('status', $comment->status) === 'trash' ? 'selected' : '' }}>
                            Trash - Pindahkan ke Sampah
                        </option>
                    </select>
                    @error('status')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @else
                        <div class="form-help">Status moderasi komentar</div>
                    @enderror
                </div>

                <!-- Author Name (for guest comments) -->
                @if (!$comment->user_id)
                    <div class="form-group">
                        <label for="author_name" class="form-label">Nama Penulis</label>
                        <input type="text" id="author_name" name="author_name"
                            class="form-input @error('author_name') error @enderror"
                            value="{{ old('author_name', $comment->author_name) }}" placeholder="Nama penulis komentar">
                        @error('author_name')
                            <div class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @else
                            <div class="form-help">Nama penulis untuk komentar tamu</div>
                        @enderror
                    </div>

                    <!-- Author Email (for guest comments) -->
                    <div class="form-group">
                        <label for="author_email" class="form-label">Email Penulis</label>
                        <input type="email" id="author_email" name="author_email"
                            class="form-input @error('author_email') error @enderror"
                            value="{{ old('author_email', $comment->author_email) }}" placeholder="email@example.com">
                        @error('author_email')
                            <div class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @else
                            <div class="form-help">Email penulis untuk komentar tamu</div>
                        @enderror
                    </div>
                @endif

                <!-- Metadata -->
                <div class="form-group">
                    <label class="form-label">Informasi Tambahan</label>
                    <div style="background: var(--light); border-radius: 8px; padding: 15px;">
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; font-size: 0.9rem;">
                            <div>
                                <span style="color: #6b7280;">IP Address:</span>
                                <strong style="display: block; margin-top: 4px;">{{ $comment->ip_address ?? '-' }}</strong>
                            </div>
                            <div>
                                <span style="color: #6b7280;">User Agent:</span>
                                <strong
                                    style="display: block; margin-top: 4px;">{{ Str::limit($comment->user_agent ?? '-', 30) }}</strong>
                            </div>
                            <div>
                                <span style="color: #6b7280;">Dibuat:</span>
                                <strong
                                    style="display: block; margin-top: 4px;">{{ $comment->created_at->format('d M Y, H:i') }}</strong>
                            </div>
                            <div>
                                <span style="color: #6b7280;">Terakhir Diupdate:</span>
                                <strong
                                    style="display: block; margin-top: 4px;">{{ $comment->updated_at->format('d M Y, H:i') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.comments.show', $comment) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Comment
                </button>
            </div>
        </form>
    </div>

@endsection
