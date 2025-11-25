@extends('landing.layouts.app')

@section('title', 'Hubungi Kami - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Compact Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="header-content" data-aos="fade-up">
                <h1>Hubungi Kami</h1>
                <p>Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan atau ingin berpartisipasi</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-layout">
                <!-- Contact Form -->
                <div class="form-wrapper" data-aos="fade-right">
                    <div class="contact-card">
                        <div class="card-header">
                            <div class="header-icon">
                                <i class="far fa-envelope"></i>
                            </div>
                            <div>
                                <h2>Kirim Pesan</h2>
                                <p>Isi form di bawah ini dan kami akan segera menghubungi Anda kembali</p>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $errors->first() }}</span>
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
                            @csrf

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Nama Lengkap <span class="required">*</span></label>
                                    <div class="input-wrapper">
                                        <i class="far fa-user"></i>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            placeholder="Masukkan nama lengkap Anda" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="required">*</span></label>
                                    <div class="input-wrapper">
                                        <i class="far fa-envelope"></i>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            placeholder="email@example.com" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Nomor Telepon</label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-phone"></i>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                            placeholder="081234567890">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="subject">Subjek <span class="required">*</span></label>
                                    <div class="input-wrapper">
                                        <i class="far fa-bookmark"></i>
                                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                                            placeholder="Subjek pesan Anda" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message">Pesan <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <i class="far fa-comment-dots"></i>
                                    <textarea id="message" name="message" rows="6" placeholder="Tulis pesan Anda di sini..." required>{{ old('message') }}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i>
                                <span>Kirim Pesan</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Contact Info Sidebar -->
                <aside class="sidebar" data-aos="fade-left">
                    <!-- Contact Info Card -->
                    <div class="info-card">
                        <h3 class="info-title">Informasi Kontak</h3>

                        <div class="info-list">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <h4>Alamat</h4>
                                    <p>{{ $settings['contact_address'] ?? 'Jl. Sisingamangaraja, Kebayoran Baru, Jakarta Selatan 12110' }}
                                    </p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <h4>Telepon</h4>
                                    <p>{{ $settings['contact_phone'] ?? '(021) 7394-0923' }}</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="far fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <h4>Email</h4>
                                    <p>{{ $settings['contact_email'] ?? 'info@alazhar.or.id' }}</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div class="info-content">
                                    <h4>WhatsApp</h4>
                                    <p>{{ $settings['contact_whatsapp'] ?? '081234567890' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Card -->
                    <div class="info-card">
                        <h3 class="info-title">Ikuti Kami</h3>
                        <div class="social-grid">
                            @if (isset($settings['social_facebook']))
                                <a href="{{ $settings['social_facebook'] }}" target="_blank" class="social-link"
                                    style="--social-color: #1877f2;">
                                    <i class="fab fa-facebook-f"></i>
                                    <span>Facebook</span>
                                </a>
                            @endif
                            @if (isset($settings['social_instagram']))
                                <a href="{{ $settings['social_instagram'] }}" target="_blank" class="social-link"
                                    style="--social-color: #e4405f;">
                                    <i class="fab fa-instagram"></i>
                                    <span>Instagram</span>
                                </a>
                            @endif
                            @if (isset($settings['social_twitter']))
                                <a href="{{ $settings['social_twitter'] }}" target="_blank" class="social-link"
                                    style="--social-color: #1da1f2;">
                                    <i class="fab fa-twitter"></i>
                                    <span>Twitter</span>
                                </a>
                            @endif
                            @if (isset($settings['social_youtube']))
                                <a href="{{ $settings['social_youtube'] }}" target="_blank" class="social-link"
                                    style="--social-color: #ff0000;">
                                    <i class="fab fa-youtube"></i>
                                    <span>YouTube</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Office Hours Card -->
                    <div class="info-card hours-card">
                        <h3 class="info-title">Jam Operasional</h3>
                        <div class="hours-list">
                            <div class="hours-item">
                                <span class="day">Senin - Jumat</span>
                                <span class="time">05:00 - 22:00</span>
                            </div>
                            <div class="hours-item">
                                <span class="day">Sabtu - Minggu</span>
                                <span class="time">05:00 - 22:00</span>
                            </div>
                            <div class="hours-item highlight">
                                <span class="day">Jumat (Sholat Jumat)</span>
                                <span class="time">11:00 - 14:00</span>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="map-wrapper">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.1234567890!2d106.8123456!3d-6.2345678!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTQnMDQuNCJTIDEwNsKwNDgnNDQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <style>
        :root {
            --primary: #0053C5;
            --primary-dark: #003d94;
            --primary-light: #e6f0ff;
            --dark: #1a1a1a;
            --gray-900: #2d3748;
            --gray-700: #4a5568;
            --gray-500: #718096;
            --gray-300: #cbd5e0;
            --gray-100: #f7fafc;
            --white: #ffffff;
            --success: #10b981;
            --success-light: #d1fae5;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Compact Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 80px 0 50px;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></svg>');
            opacity: 0.3;
        }

        .header-content {
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .header-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .header-content p {
            font-size: 1.1rem;
            opacity: 0.95;
            font-weight: 400;
        }

        /* Contact Section */
        .contact-section {
            padding: 60px 0;
            background: var(--gray-100);
        }

        .contact-layout {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 30px;
            align-items: start;
        }

        /* Contact Card */
        .contact-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 35px;
        }

        .card-header {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid var(--gray-100);
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-light) 0%, #cfe2ff 100%);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary);
            flex-shrink: 0;
        }

        .card-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .card-header p {
            color: var(--gray-500);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: var(--radius-md);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            animation: slideDown 0.3s ease;
        }

        .alert i {
            font-size: 1.2rem;
        }

        .alert-success {
            background: var(--success-light);
            color: #065f46;
            border-left: 4px solid var(--success);
        }

        .alert-danger {
            background: var(--danger-light);
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        /* Contact Form */
        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .required {
            color: var(--danger);
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            color: var(--gray-500);
            font-size: 1rem;
            z-index: 1;
        }

        .input-wrapper input,
        .input-wrapper textarea {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid var(--gray-300);
            border-radius: var(--radius-md);
            font-size: 0.95rem;
            font-family: inherit;
            transition: var(--transition);
            background: var(--white);
        }

        .input-wrapper textarea {
            resize: vertical;
            min-height: 120px;
            padding-top: 15px;
        }

        .input-wrapper input:focus,
        .input-wrapper textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 83, 197, 0.1);
        }

        .input-wrapper input::placeholder,
        .input-wrapper textarea::placeholder {
            color: var(--gray-500);
        }

        /* Submit Button */
        .btn-submit {
            padding: 15px 30px;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(0, 83, 197, 0.3);
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 83, 197, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: sticky;
            top: 100px;
        }

        /* Info Card */
        .info-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 30px;
            box-shadow: var(--shadow-sm);
        }

        .info-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: var(--primary);
            border-radius: 2px;
        }

        /* Info List */
        .info-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-item {
            display: flex;
            gap: 15px;
        }

        .info-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .info-content h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .info-content p {
            color: var(--gray-700);
            line-height: 1.6;
            font-size: 0.9rem;
        }

        /* Social Grid */
        .social-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .social-link {
            padding: 12px 15px;
            background: var(--gray-100);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--gray-700);
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .social-link:hover {
            background: var(--social-color);
            color: var(--white);
            border-color: var(--social-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .social-link i {
            font-size: 1.2rem;
        }

        /* Office Hours Card */
        .hours-card {
            background: linear-gradient(135deg, var(--primary-light) 0%, #cfe2ff 100%);
        }

        .hours-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .hours-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 15px;
            background: var(--white);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
        }

        .hours-item .day {
            color: var(--gray-700);
            font-weight: 500;
        }

        .hours-item .time {
            color: var(--dark);
            font-weight: 700;
        }

        .hours-item.highlight {
            background: var(--primary);
            color: var(--white);
        }

        .hours-item.highlight .day,
        .hours-item.highlight .time {
            color: var(--white);
        }

        /* Map Section */
        .map-section {
            padding: 0;
        }

        .map-wrapper {
            width: 100%;
            height: 450px;
            background: var(--gray-100);
            position: relative;
        }

        .map-wrapper iframe {
            filter: grayscale(20%);
            transition: filter 0.3s ease;
        }

        .map-wrapper:hover iframe {
            filter: grayscale(0%);
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .contact-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .hours-card {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 60px 0 40px;
            }

            .header-content h1 {
                font-size: 2rem;
            }

            .header-content p {
                font-size: 1rem;
            }

            .contact-section {
                padding: 40px 0;
            }

            .contact-card {
                padding: 25px;
            }

            .card-header {
                flex-direction: column;
                text-align: center;
            }

            .header-icon {
                margin: 0 auto;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .sidebar {
                grid-template-columns: 1fr;
            }

            .social-grid {
                grid-template-columns: 1fr;
            }

            .map-wrapper {
                height: 350px;
            }
        }

        @media (max-width: 480px) {
            .contact-card {
                padding: 20px;
            }

            .card-header h2 {
                font-size: 1.5rem;
            }

            .input-wrapper input,
            .input-wrapper textarea {
                padding-left: 40px;
                font-size: 0.9rem;
            }

            .info-card {
                padding: 20px;
            }

            .map-wrapper {
                height: 300px;
            }
        }

        /* Loading State */
        .btn-submit:disabled {
            background: var(--gray-300);
            cursor: not-allowed;
            transform: none;
        }

        /* Focus Styles */
        .btn-submit:focus,
        .social-link:focus {
            outline: 3px solid var(--primary);
            outline-offset: 2px;
        }
    </style>
@endsection
