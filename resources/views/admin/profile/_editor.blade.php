{{-- Shared Profile Editor Styles & Scripts --}}
@push('styles')
    <style>
        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .card-body {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .required {
            color: var(--danger);
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
        }

        .form-text {
            font-size: 0.85rem;
            color: #9ca3af;
            margin-top: 5px;
            display: block;
        }

        .form-error {
            font-size: 0.85rem;
            color: var(--danger);
            margin-top: 6px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 83, 197, 0.3);
        }

        .btn-secondary {
            background: #e5e7eb;
            color: var(--dark);
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            margin-top: 10px;
        }

        .profile-header-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-header-icon {
            width: 65px;
            height: 65px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        .profile-header-title {
            font-size: 1.4rem;
            font-weight: 700;
        }

        .profile-header-desc {
            opacity: 0.85;
            font-size: 0.95rem;
            margin-top: 4px;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn.loading {
            pointer-events: none;
            position: relative;
        }

        .btn.loading span {
            opacity: 0;
        }

        .btn.loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.js"></script>
    <script>
        let editorLoaded = false;

        tinymce.init({
            selector: '#content',
            height: 500,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks fontsize | ' +
                'bold italic underline strikethrough | forecolor backcolor | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | removeformat | ' +
                'link image media table | code fullscreen | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; }',
            setup: function(editor) {
                editor.on('init', function() {
                    editorLoaded = true;
                    const loadingText = document.querySelector('.editor-status');
                    if (loadingText) {
                        loadingText.textContent = 'Editor siap digunakan';
                        loadingText.style.color = '#10b981';
                    }
                });
            }
        });

        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = document.getElementById('submitBtn');
            const form = this;

            if (!editorLoaded) {
                alert('Editor masih loading, mohon tunggu sebentar...');
                return false;
            }

            const content = tinymce.get('content').getContent();
            if (!content) {
                alert('Konten harus diisi!');
                tinymce.get('content').focus();
                return false;
            }

            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            form.submit();
        });

        window.addEventListener('beforeunload', function(e) {
            if (tinymce.get('content') && tinymce.get('content').isDirty()) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    </script>
@endpush
