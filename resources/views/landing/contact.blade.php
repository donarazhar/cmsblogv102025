@extends('landing.layouts.app')

@section('title', 'Hubungi Kami - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Contact Section -->
    <section class="contact-section" style="padding-top: 120px;">
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


                        <form action="{{ route('contact.submit') }}" method="POST" class="contact-form" id="contactForm">
                            @csrf
                            <input type="hidden" name="google_verified" id="googleVerified" value="0">

                            <!-- Google Verification Section -->
                            <div class="google-verify-section" id="verifySection">
                                <div class="verify-icon">
                                    <svg viewBox="0 0 24 24" width="28" height="28">
                                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                    </svg>
                                </div>
                                <div class="verify-content">
                                    <h4>Verifikasi Akun Google</h4>
                                    <p>Silakan verifikasi dengan akun Google Anda untuk mengirim pesan</p>
                                </div>
                                <button type="button" class="btn-google-verify" id="btnGoogleVerify" onclick="googleSignIn()">
                                    <svg viewBox="0 0 24 24" width="18" height="18">
                                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                    </svg>
                                    Verifikasi dengan Google
                                </button>
                            </div>

                            <!-- Verified User Info (Hidden initially) -->
                            <div class="verified-user-card" id="verifiedCard" style="display: none;">
                                <div class="verified-avatar" id="verifiedAvatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="verified-info">
                                    <div class="verified-name" id="verifiedName"></div>
                                    <div class="verified-email" id="verifiedEmail"></div>
                                </div>
                                <div class="verified-badge">
                                    <i class="fas fa-check-circle"></i> Terverifikasi
                                </div>
                                <button type="button" class="btn-change-account" onclick="changeAccount()">
                                    <i class="fas fa-exchange-alt"></i>
                                </button>
                            </div>

                            <input type="hidden" name="name" id="nameHidden">
                            <input type="hidden" name="email" id="emailHidden">

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

                            <button type="submit" class="btn-submit" id="btnSubmit" disabled>
                                <i class="fas fa-paper-plane"></i>
                                <span>Kirim Pesan</span>
                            </button>
                            <p class="submit-hint" id="submitHint">
                                <i class="fas fa-info-circle"></i>
                                Silakan verifikasi akun Google terlebih dahulu untuk mengirim pesan
                            </p>
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
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.79927791536988!3d-6.238270695484529!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f15a76a3b1e7%3A0x39600e7ef1a2ef7e!2sMasjid%20Agung%20Al%20Azhar!5e0!3m2!1sid!2sid!4v1715756887000!5m2!1sid!2sid"
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
            background: url("{{ asset('storage/img/background.svg') }}"); background-size: cover; background-position: center;
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

        /* Google Verify Section */
        .google-verify-section {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%);
            border: 2px dashed var(--primary);
            border-radius: var(--radius-md);
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .verify-icon {
            width: 52px;
            height: 52px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-sm);
            flex-shrink: 0;
        }

        .verify-content {
            flex: 1;
            min-width: 180px;
        }

        .verify-content h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .verify-content p {
            font-size: 0.85rem;
            color: var(--gray-500);
            line-height: 1.4;
        }

        .btn-google-verify {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            background: var(--white);
            border: 2px solid var(--gray-300);
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--gray-700);
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
            box-shadow: var(--shadow-sm);
        }

        .btn-google-verify:hover {
            border-color: #4285F4;
            box-shadow: 0 4px 12px rgba(66, 133, 244, 0.2);
            transform: translateY(-1px);
        }

        /* Verified User Card */
        .verified-user-card {
            background: linear-gradient(135deg, #d1fae5 0%, #ecfdf5 100%);
            border: 2px solid #10b981;
            border-radius: var(--radius-md);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            animation: slideDown 0.3s ease;
        }

        .verified-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid #10b981;
            flex-shrink: 0;
        }

        .verified-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .verified-avatar i {
            font-size: 1.2rem;
            color: #10b981;
        }

        .verified-info {
            flex: 1;
            min-width: 0;
        }

        .verified-name {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--dark);
        }

        .verified-email {
            font-size: 0.82rem;
            color: #065f46;
        }

        .verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            background: #10b981;
            color: var(--white);
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .btn-change-account {
            width: 34px;
            height: 34px;
            border: none;
            background: rgba(0,0,0,0.08);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--gray-700);
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .btn-change-account:hover {
            background: rgba(0,0,0,0.15);
        }

        .submit-hint {
            font-size: 0.82rem;
            color: var(--gray-500);
            text-align: center;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .submit-hint i {
            color: var(--primary);
        }

        .submit-hint.hidden {
            display: none;
        }

        /* Focus Styles */
        .btn-submit:focus,
        .social-link:focus {
            outline: 3px solid var(--primary);
            outline-offset: 2px;
        }
    </style>

    <!-- Google Identity Services -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        const GOOGLE_CLIENT_ID = '{{ config("services.google.client_id", "") }}';
        let isVerified = false;

        function googleSignIn() {
            if (!GOOGLE_CLIENT_ID) {
                alert('Google Client ID belum dikonfigurasi. Hubungi administrator.');
                return;
            }

            google.accounts.id.initialize({
                client_id: GOOGLE_CLIENT_ID,
                callback: handleGoogleResponse,
                auto_select: false,
            });

            google.accounts.id.prompt((notification) => {
                if (notification.isNotDisplayed() || notification.isSkippedMoment()) {
                    // Fallback: use popup mode
                    google.accounts.oauth2.initTokenClient({
                        client_id: GOOGLE_CLIENT_ID,
                        scope: 'email profile',
                        callback: handleOAuthResponse,
                    }).requestAccessToken();
                }
            });
        }

        function handleGoogleResponse(response) {
            const payload = parseJwt(response.credential);
            if (payload && payload.email_verified) {
                setVerifiedUser(payload.name, payload.email, payload.picture);
            }
        }

        function handleOAuthResponse(tokenResponse) {
            fetch('https://www.googleapis.com/oauth2/v3/userinfo', {
                headers: { 'Authorization': 'Bearer ' + tokenResponse.access_token }
            })
            .then(res => res.json())
            .then(userInfo => {
                if (userInfo.email_verified) {
                    setVerifiedUser(userInfo.name, userInfo.email, userInfo.picture);
                }
            })
            .catch(err => {
                console.error('Error fetching user info:', err);
                alert('Gagal memverifikasi akun Google. Silakan coba lagi.');
            });
        }

        function setVerifiedUser(name, email, picture) {
            isVerified = true;

            // Set hidden fields
            document.getElementById('nameHidden').value = name;
            document.getElementById('emailHidden').value = email;
            document.getElementById('googleVerified').value = '1';

            // Update UI
            document.getElementById('verifiedName').textContent = name;
            document.getElementById('verifiedEmail').textContent = email;

            if (picture) {
                document.getElementById('verifiedAvatar').innerHTML = '<img src="' + picture + '" alt="Avatar">';
            }

            document.getElementById('verifySection').style.display = 'none';
            document.getElementById('verifiedCard').style.display = 'flex';

            // Enable submit
            document.getElementById('btnSubmit').disabled = false;
            document.getElementById('submitHint').classList.add('hidden');
        }

        function changeAccount() {
            isVerified = false;
            document.getElementById('nameHidden').value = '';
            document.getElementById('emailHidden').value = '';
            document.getElementById('googleVerified').value = '0';
            document.getElementById('verifySection').style.display = 'flex';
            document.getElementById('verifiedCard').style.display = 'none';
            document.getElementById('btnSubmit').disabled = true;
            document.getElementById('submitHint').classList.remove('hidden');
        }

        function parseJwt(token) {
            try {
                const base64Url = token.split('.')[1];
                const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
                return JSON.parse(decodeURIComponent(atob(base64).split('').map(function(c) {
                    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                }).join('')));
            } catch (e) {
                return null;
            }
        }

        // Prevent submit without verification
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!isVerified) {
                        e.preventDefault();
                        alert('Silakan verifikasi akun Google Anda terlebih dahulu.');
                    }
                });
            }
        });
    </script>
@endsection
