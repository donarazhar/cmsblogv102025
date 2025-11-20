@extends('landing.layouts.app')

@section('title', 'Hubungi Kami - ' . ($settings['site_name'] ?? 'Masjid Agung Al Azhar'))

@section('content')
    <!-- Page Header -->
    <section
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); padding: 100px 0 60px; color: white;">
        <div class="container">
            <div style="text-align: center; max-width: 800px; margin: 0 auto;" data-aos="fade-up">
                <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 20px;">Hubungi Kami</h1>
                <p style="font-size: 1.2rem; opacity: 0.95;">
                    Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan atau ingin berpartisipasi
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="section">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                <!-- Contact Form -->
                <div data-aos="fade-right">
                    <div class="contact-form-box">
                        <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 10px;">Kirim Pesan</h2>
                        <p style="color: #6b7280; margin-bottom: 30px;">Isi form di bawah ini dan kami akan segera
                            menghubungi Anda kembali.</p>

                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Nama Lengkap <span style="color: var(--danger);">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    placeholder="Nama Anda">
                            </div>

                            <div class="form-group">
                                <label>Email <span style="color: var(--danger);">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    placeholder="email@example.com">
                            </div>

                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="081234567890">
                            </div>

                            <div class="form-group">
                                <label>Subjek <span style="color: var(--danger);">*</span></label>
                                <input type="text" name="subject" value="{{ old('subject') }}" required
                                    placeholder="Subjek pesan Anda">
                            </div>

                            <div class="form-group">
                                <label>Pesan <span style="color: var(--danger);">*</span></label>
                                <textarea name="message" rows="6" required placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                                <i class="fas fa-paper-plane"></i>
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Contact Info -->
                <div data-aos="fade-left">
                    <div class="contact-info-box">
                        <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 30px;">Informasi Kontak</h2>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4>Alamat</h4>
                                <p>{{ $settings['contact_address'] ?? 'Jl. Sisingamangaraja, Kebayoran Baru, Jakarta Selatan 12110' }}
                                </p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h4>Telepon</h4>
                                <p>{{ $settings['contact_phone'] ?? '(021) 7394-0923' }}</p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h4>Email</h4>
                                <p>{{ $settings['contact_email'] ?? 'info@alazhar.or.id' }}</p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <h4>WhatsApp</h4>
                                <p>{{ $settings['contact_whatsapp'] ?? '081234567890' }}</p>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div style="margin-top: 40px; padding-top: 30px; border-top: 2px solid var(--border);">
                            <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 20px;">Ikuti Kami</h4>
                            <div style="display: flex; gap: 15px;">
                                @if (isset($settings['social_facebook']))
                                    <a href="{{ $settings['social_facebook'] }}" target="_blank" class="social-icon-large"
                                        style="background: #1877f2;">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @endif
                                @if (isset($settings['social_instagram']))
                                    <a href="{{ $settings['social_instagram'] }}" target="_blank" class="social-icon-large"
                                        style="background: #e4405f;">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                                @if (isset($settings['social_twitter']))
                                    <a href="{{ $settings['social_twitter'] }}" target="_blank" class="social-icon-large"
                                        style="background: #1da1f2;">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                @endif
                                @if (isset($settings['social_youtube']))
                                    <a href="{{ $settings['social_youtube'] }}" target="_blank" class="social-icon-large"
                                        style="background: #ff0000;">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Office Hours -->
                        <div style="margin-top: 40px; padding: 25px; background: var(--light); border-radius: 15px;">
                            <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 15px;">Jam Operasional</h4>
                            <div style="display: flex; flex-direction: column; gap: 10px; color: #6b7280;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span>Senin - Jumat</span>
                                    <strong>05:00 - 22:00</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span>Sabtu - Minggu</span>
                                    <strong>05:00 - 22:00</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span>Jumat (Sholat Jumat)</span>
                                    <strong>11:00 - 14:00</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section style="padding: 0;">
        <div
            style="width: 100%; height: 450px; background: var(--light); display: flex; align-items: center; justify-content: center;">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.1234567890!2d106.8123456!3d-6.2345678!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTQnMDQuNCJTIDEwNsKwNDgnNDQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>
    </section>

    <style>
        .contact-form-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .contact-info-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        .contact-info-item {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .contact-info-item h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark);
        }

        .contact-info-item p {
            color: #6b7280;
            line-height: 1.6;
        }

        .social-icon-large {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border-radius: 12px;
            text-decoration: none;
            font-size: 1.3rem;
            transition: all 0.3s ease;
        }

        .social-icon-large:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn {
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 1rem;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 10px 30px rgba(0, 83, 197, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 83, 197, 0.4);
        }

        @media (max-width: 1024px) {
            section>div>div[style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }

            .contact-info-box {
                position: relative;
                top: 0;
            }
        }
    </style>
@endsection
