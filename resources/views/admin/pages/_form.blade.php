<form action="{{ $page ? route('admin.pages.update', $page) : route('admin.pages.store') }}" method="POST"
    enctype="multipart/form-data" id="pageForm">
    @csrf
    @if ($page)
        @method('PUT')
    @endif

    <div class="row">
        <!-- Left Column -->
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Halaman</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Judul Halaman <span class="required">*</span></label>
                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $page->title ?? '') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug (URL)</label>
                        <input type="text" name="slug" id="slug"
                            class="form-control @error('slug') is-invalid @enderror"
                            value="{{ old('slug', $page->slug ?? '') }}" placeholder="akan dibuat otomatis">
                        <small class="form-text">Kosongkan untuk generate otomatis dari judul</small>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ✅ CUSTOM URL FIELD --}}
                    <div class="form-group">
                        <label for="custom_url">Custom URL (Opsional)</label>
                        <input type="text" name="custom_url" id="custom_url"
                            class="form-control @error('custom_url') is-invalid @enderror"
                            value="{{ old('custom_url', $page->custom_url ?? '') }}"
                            placeholder="Contoh: /programs atau https://example.com">
                        <small class="form-text">
                            <strong>Gunakan untuk link ke route Laravel atau URL eksternal.</strong><br>
                            <i class="fas fa-lightbulb" style="color: #f59e0b;"></i>
                            Contoh route internal: <code>{{ url('/programs') }}</code> atau <code>/programs</code><br>
                            <i class="fas fa-lightbulb" style="color: #f59e0b;"></i>
                            Contoh URL eksternal: <code>https://google.com</code><br>
                            <i class="fas fa-info-circle" style="color: #3b82f6;"></i>
                            Jika diisi, link ini akan digunakan. Jika kosong, akan menggunakan slug.
                        </small>
                        @error('custom_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">Konten <span class="required">*</span></label>
                        <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror">{{ old('content', $page->content ?? '') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Editor sedang memuat...</small>
                    </div>

                    <div class="form-group">
                        <label for="featured_image">Featured Image</label>
                        <div class="image-upload-wrapper">
                            <input type="file" name="featured_image" id="featured_image"
                                class="form-control-file @error('featured_image') is-invalid @enderror" accept="image/*"
                                onchange="previewImage(this)">
                            <div class="image-preview" id="imagePreview">
                                @if ($page && $page->featured_image)
                                    <img src="{{ asset('storage/' . $page->featured_image) }}"
                                        alt="{{ $page->title }}">
                                @else
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Klik atau drag gambar ke sini</p>
                                    <small>Maksimal 2MB (JPEG, PNG, JPG, WEBP)</small>
                                @endif
                            </div>
                        </div>
                        @if ($page && $page->featured_image)
                            <small class="form-text">
                                <a href="{{ route('admin.pages.remove-image', $page) }}"
                                    onclick="return confirm('Hapus gambar ini?')" style="color: var(--danger);">
                                    <i class="fas fa-trash"></i> Hapus gambar saat ini
                                </a>
                            </small>
                        @endif
                        @error('featured_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SEO Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">SEO Settings</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control"
                            value="{{ old('meta_title', $page->meta_title ?? '') }}"
                            placeholder="Kosongkan untuk menggunakan judul halaman">
                    </div>

                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="3" class="form-control">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control"
                            value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}"
                            placeholder="keyword1, keyword2, keyword3">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pengaturan</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="status">Status <span class="required">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="draft"
                                {{ old('status', $page->status ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft
                            </option>
                            <option value="published"
                                {{ old('status', $page->status ?? '') == 'published' ? 'selected' : '' }}>Published
                            </option>
                            <option value="private"
                                {{ old('status', $page->status ?? '') == 'private' ? 'selected' : '' }}>Private
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="template">Template <span class="required">*</span></label>
                        <select name="template" id="template" class="form-control" required>
                            <option value="default"
                                {{ old('template', $page->template ?? 'default') == 'default' ? 'selected' : '' }}>
                                Default</option>
                            <option value="full-width"
                                {{ old('template', $page->template ?? '') == 'full-width' ? 'selected' : '' }}>Full
                                Width</option>
                            <option value="sidebar-left"
                                {{ old('template', $page->template ?? '') == 'sidebar-left' ? 'selected' : '' }}>
                                Sidebar Left</option>
                            <option value="sidebar-right"
                                {{ old('template', $page->template ?? '') == 'sidebar-right' ? 'selected' : '' }}>
                                Sidebar Right</option>
                            <option value="contact"
                                {{ old('template', $page->template ?? '') == 'contact' ? 'selected' : '' }}>Contact
                            </option>
                            <option value="about"
                                {{ old('template', $page->template ?? '') == 'about' ? 'selected' : '' }}>About
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Parent Page</label>
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value="">-- Tidak Ada Parent --</option>
                            @foreach ($parentPages as $parent)
                                <option value="{{ $parent->id }}"
                                    {{ old('parent_id', $page->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->title }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text">Pilih parent untuk membuat submenu</small>
                    </div>

                    <div class="form-group">
                        <label for="icon">Icon (Font Awesome)</label>
                        <input type="text" name="icon" id="icon" class="form-control"
                            value="{{ old('icon', $page->icon ?? '') }}" placeholder="fas fa-home">
                        <small class="form-text">
                            Contoh: <code>fas fa-home</code>, <code>fas fa-info-circle</code><br>
                            <a href="https://fontawesome.com/icons" target="_blank">
                                <i class="fas fa-external-link-alt"></i> Lihat daftar icons
                            </a>
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="menu_order">Menu Order</label>
                        <input type="number" name="menu_order" id="menu_order" class="form-control" min="0"
                            value="{{ old('menu_order', $page->menu_order ?? '') }}">
                        <small class="form-text">Angka kecil = posisi lebih depan</small>
                    </div>

                    <hr style="margin: 20px 0;">

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="show_in_menu" value="1"
                                {{ old('show_in_menu', $page->show_in_menu ?? false) ? 'checked' : '' }}>
                            <span>Tampilkan di Menu Navigasi</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary" id="submitBtn"
                        style="width: 100%; margin-bottom: 10px;">
                        <i class="fas fa-save"></i>
                        <span>{{ $page ? 'Update Halaman' : 'Simpan Halaman' }}</span>
                    </button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary" style="width: 100%;">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </div>

            {{-- Preview Card (Only for Edit) --}}
            @if ($page)
                <div class="card"
                    style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white;">
                    <div class="card-body">
                        <h4 style="color: white; margin-bottom: 15px; font-size: 1rem;">
                            <i class="fas fa-info-circle"></i> Preview URL
                        </h4>
                        @if ($page->custom_url)
                            <a href="{{ $page->custom_url }}" target="_blank"
                                style="color: white; text-decoration: none; display: flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.2); padding: 10px; border-radius: 8px;">
                                <i class="fas fa-external-link-alt"></i>
                                <span
                                    style="word-break: break-all; font-size: 0.85rem;">{{ $page->custom_url }}</span>
                            </a>
                            <small style="display: block; margin-top: 8px; opacity: 0.9;">Custom URL</small>
                        @else
                            <a href="{{ route('page.show', $page->slug) }}" target="_blank"
                                style="color: white; text-decoration: none; display: flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.2); padding: 10px; border-radius: 8px;">
                                <i class="fas fa-link"></i>
                                <span style="font-size: 0.85rem;">/{{ $page->slug }}</span>
                            </a>
                            <small style="display: block; margin-top: 8px; opacity: 0.9;">Page Slug</small>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</form>

@push('styles')
    <style>
        .row {
            display: flex;
            gap: 20px;
            margin: 0 -10px;
        }

        .col-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
            padding: 0 10px;
        }

        .col-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 0 10px;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
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

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }

        .form-text {
            font-size: 0.85rem;
            color: #9ca3af;
            margin-top: 5px;
            display: block;
            line-height: 1.6;
        }

        .form-text code {
            background: var(--light);
            padding: 2px 6px;
            border-radius: 4px;
            color: var(--primary);
            font-size: 0.85rem;
        }

        .form-text a {
            color: var(--primary);
            text-decoration: none;
        }

        .form-text a:hover {
            text-decoration: underline;
        }

        textarea.form-control {
            resize: vertical;
        }

        select.form-control {
            cursor: pointer;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-weight: 500;
        }

        .checkbox-label input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        /* Image Upload */
        .image-upload-wrapper {
            position: relative;
        }

        .form-control-file {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }

        .image-preview {
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            background: var(--light);
            transition: all 0.3s ease;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .image-preview:hover {
            border-color: var(--primary);
            background: rgba(0, 83, 197, 0.05);
        }

        .image-preview i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .image-preview p {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .image-preview small {
            color: #9ca3af;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            object-fit: cover;
        }

        .btn {
            padding: 10px 20px;
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

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
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
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        /* Loading State */
        .btn.loading {
            pointer-events: none;
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

        @media (max-width: 1024px) {
            .row {
                flex-direction: column;
            }

            .col-8,
            .col-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.2/tinymce.min.js"></script>
    <script>
        let editorLoaded = false;

        // Initialize TinyMCE
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
                    const loadingText = document.querySelector('#content + .form-text');
                    if (loadingText) {
                        loadingText.textContent = 'Editor siap digunakan';
                        loadingText.style.color = '#10b981';
                    }
                });
            }
        });

        // Image Preview
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Auto generate slug from title (only if slug is empty)
        document.getElementById('title').addEventListener('input', function() {
            const slugField = document.getElementById('slug');
            if (!slugField.value || slugField.value === '') {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                slugField.value = slug;
            }
        });

        // Form Submit Handler
        document.getElementById('pageForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const form = this;

            if (!editorLoaded) {
                alert('Editor masih loading, mohon tunggu sebentar...');
                return false;
            }

            const content = tinymce.get('content').getContent();
            const title = document.getElementById('title').value.trim();
            const status = document.getElementById('status').value;
            const template = document.getElementById('template').value;

            if (!title) {
                alert('Judul halaman harus diisi!');
                document.getElementById('title').focus();
                return false;
            }

            if (!content) {
                alert('Konten halaman harus diisi!');
                tinymce.get('content').focus();
                return false;
            }

            if (!status) {
                alert('Status halaman harus dipilih!');
                document.getElementById('status').focus();
                return false;
            }

            if (!template) {
                alert('Template halaman harus dipilih!');
                document.getElementById('template').focus();
                return false;
            }

            submitBtn.classList.add('loading');
            submitBtn.disabled = true;

            form.submit();
        });

        // Prevent accidental navigation
        window.addEventListener('beforeunload', function(e) {
            if (tinymce.get('content') && tinymce.get('content').isDirty()) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    </script>
@endpush
