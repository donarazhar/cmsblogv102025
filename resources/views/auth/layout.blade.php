<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Masjid Agung Al Azhar</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0053C5;
            --primary-dark: #003d91;
            --primary-light: #3374d1;
            --secondary: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --success: #10b981;
            --dark: #1f2937;
            --light: #f9fafb;
            --border: #e5e7eb;
        }

        html {
            height: 100%;
            overflow: hidden;
        }

        body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0053C5 0%, #001f4d 50%, #000000 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
        }

        /* Animated Background Particles */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.15;
            animation: float 20s ease-in-out infinite;
            z-index: 0;
        }

        body::before {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        body::after {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, #3374d1 0%, transparent 70%);
            bottom: -250px;
            right: -250px;
            animation-delay: 5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(50px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-50px, 50px) scale(0.9);
            }
        }

        /* Decorative Lines */
        .bg-decoration {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .decoration-line {
            position: absolute;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: slide 8s linear infinite;
        }

        .decoration-line:nth-child(1) {
            top: 20%;
            width: 300px;
            left: -300px;
            animation-delay: 0s;
        }

        .decoration-line:nth-child(2) {
            top: 40%;
            width: 400px;
            right: -400px;
            animation-delay: 2s;
        }

        .decoration-line:nth-child(3) {
            top: 60%;
            width: 350px;
            left: -350px;
            animation-delay: 4s;
        }

        .decoration-line:nth-child(4) {
            top: 80%;
            width: 450px;
            right: -450px;
            animation-delay: 6s;
        }

        @keyframes slide {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(calc(100vw + 400px));
            }
        }

        .auth-container {
            width: 100%;
            max-width: 1100px;
            height: 100%;
            max-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
            padding: 20px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 100%;
            height: auto;
            max-height: calc(100vh - 40px);
            display: flex;
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5),
                0 0 1px rgba(255, 255, 255, 0.3) inset;
            animation: fadeInScale 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Left Side - Branding */
        .auth-brand-side {
            flex: 0 0 45%;
            max-width: 45%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            color: white;
        }

        /* Animated Background Pattern */
        .brand-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.1;
            background-image:
                repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255, 255, 255, 0.05) 20px, rgba(255, 255, 255, 0.05) 40px),
                repeating-linear-gradient(-45deg, transparent, transparent 20px, rgba(255, 255, 255, 0.05) 20px, rgba(255, 255, 255, 0.05) 40px);
            animation: pattern-move 20s linear infinite;
        }

        @keyframes pattern-move {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(40px, 40px);
            }
        }

        /* Floating Elements */
        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            animation: float-random 20s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 120px;
            height: 120px;
            top: 10%;
            right: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 80px;
            height: 80px;
            bottom: 15%;
            left: 15%;
            animation-delay: 3s;
        }

        .floating-element:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 60%;
            right: -50px;
            animation-delay: 6s;
        }

        @keyframes float-random {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            25% {
                transform: translate(20px, -30px) rotate(90deg);
            }

            50% {
                transform: translate(-15px, 20px) rotate(180deg);
            }

            75% {
                transform: translate(30px, 10px) rotate(270deg);
            }
        }

        .brand-content {
            position: relative;
            z-index: 10;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 40px;
        }

        .brand-logo-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--primary);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: pulse-logo 3s ease-in-out infinite;
        }

        @keyframes pulse-logo {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            }
        }

        .brand-logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            line-height: 1.3;
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.3rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            letter-spacing: -0.5px;
        }

        .brand-description {
            font-size: 1rem;
            line-height: 1.7;
            opacity: 0.95;
            font-weight: 400;
            margin-bottom: 35px;
        }

        .brand-features {
            list-style: none;
        }

        .brand-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .brand-features li i {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .brand-illustration {
            position: relative;
            z-index: 10;
            text-align: center;
            opacity: 0.2;
            margin-top: 20px;
        }

        .brand-illustration i {
            font-size: 8rem;
            animation: float-illustration 6s ease-in-out infinite;
        }

        @keyframes float-illustration {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Right Side - Form */
        .auth-form-side {
            flex: 0 0 55%;
            max-width: 55%;
            padding: 50px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
            position: relative;
            overflow-y: auto;
        }

        /* Custom Scrollbar */
        .auth-form-side::-webkit-scrollbar {
            width: 8px;
        }

        .auth-form-side::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .auth-form-side::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        .auth-form-side::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        .form-header {
            margin-bottom: 35px;
        }

        .form-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .form-header p {
            font-size: 1rem;
            color: #6b7280;
            font-weight: 400;
        }

        .form-body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 14px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Poppins', sans-serif;
            background: #fafafa;
        }

        .form-control:hover {
            background: white;
            border-color: #cbd5e1;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 83, 197, 0.1);
            transform: translateY(-1px);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .input-icon .form-control {
            padding-left: 50px;
        }

        .input-icon .form-control:focus+i {
            color: var(--primary);
            transform: translateY(-50%) scale(1.1);
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
            transition: all 0.3s ease;
            font-size: 1rem;
            padding: 8px;
        }

        .password-toggle:hover {
            color: var(--primary);
            transform: translateY(-50%) scale(1.15);
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 22px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #6b7280;
            cursor: pointer;
        }

        .btn {
            width: 100%;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 6px 16px rgba(0, 83, 197, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 83, 197, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
            color: #9ca3af;
            font-size: 0.85rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 2px solid #e5e7eb;
        }

        .divider span {
            padding: 0 15px;
            font-weight: 500;
        }

        .form-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 2px solid #e5e7eb;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .form-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .form-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .auth-link {
            display: block;
            text-align: center;
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            margin-top: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 10px;
            border-radius: 8px;
        }

        .auth-link:hover {
            background: rgba(0, 83, 197, 0.05);
            color: var(--primary-dark);
        }

        .auth-link i {
            margin-right: 6px;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-size: 0.9rem;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert i {
            font-size: 1.2rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 2px solid #6ee7b7;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border: 2px solid #fca5a5;
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 6px;
            display: block;
            font-weight: 500;
        }

        .is-invalid {
            border-color: var(--danger) !important;
            background: #fef2f2 !important;
        }

        .info-text {
            margin-bottom: 25px;
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.6;
            padding: 14px;
            background: #f9fafb;
            border-radius: 10px;
            border-left: 3px solid var(--primary);
        }

        /* Loading Animation */
        .btn-loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive Design */

        /* Tablet Landscape (1024px and below) */
        @media (max-width: 1024px) {
            .auth-wrapper {
                max-height: calc(100vh - 40px);
            }

            .auth-brand-side {
                flex: 0 0 40%;
                max-width: 40%;
                padding: 40px 30px;
            }

            .auth-form-side {
                flex: 0 0 60%;
                max-width: 60%;
                padding: 40px 35px;
            }

            .brand-title {
                font-size: 2rem;
            }

            .brand-description {
                font-size: 0.95rem;
            }

            .form-header h1 {
                font-size: 2rem;
            }
        }

        /* Tablet Portrait (768px and below) */
        @media (max-width: 768px) {
            .auth-container {
                padding: 15px;
            }

            .auth-wrapper {
                flex-direction: column;
                max-width: 100%;
                max-height: calc(100vh - 30px);
                overflow-y: auto;
            }

            .auth-brand-side {
                flex: 0 0 auto;
                max-width: 100%;
                min-height: auto;
                padding: 35px 30px;
            }

            .brand-logo {
                margin-bottom: 25px;
            }

            .brand-title {
                font-size: 1.8rem;
                margin-bottom: 15px;
            }

            .brand-description {
                font-size: 0.9rem;
                margin-bottom: 25px;
            }

            .brand-features li {
                font-size: 0.9rem;
                margin-bottom: 12px;
            }

            .brand-illustration {
                display: none;
            }

            .auth-form-side {
                flex: 0 0 auto;
                max-width: 100%;
                padding: 35px 30px;
                overflow-y: visible;
            }

            .form-header h1 {
                font-size: 1.8rem;
            }

            .form-header p {
                font-size: 0.95rem;
            }
        }

        /* Mobile (480px and below) */
        @media (max-width: 480px) {
            .auth-container {
                padding: 10px;
            }

            .auth-wrapper {
                border-radius: 20px;
                max-height: calc(100vh - 20px);
            }

            .auth-brand-side {
                padding: 30px 25px;
            }

            .brand-logo-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }

            .brand-logo-text {
                font-size: 1.1rem;
            }

            .brand-title {
                font-size: 1.5rem;
            }

            .brand-description {
                font-size: 0.85rem;
            }

            .brand-features li {
                font-size: 0.85rem;
            }

            .brand-features li i {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }

            .auth-form-side {
                padding: 30px 25px;
            }

            .form-header h1 {
                font-size: 1.6rem;
            }

            .form-header p {
                font-size: 0.9rem;
            }

            .form-control {
                padding: 12px 18px;
                font-size: 0.9rem;
            }

            .input-icon .form-control {
                padding-left: 45px;
            }

            .input-icon i {
                left: 18px;
                font-size: 0.95rem;
            }

            .password-toggle {
                right: 18px;
                font-size: 0.95rem;
            }

            .btn {
                padding: 12px 18px;
                font-size: 0.95rem;
            }
        }

        /* Small Mobile (360px and below) */
        @media (max-width: 360px) {

            .auth-brand-side,
            .auth-form-side {
                padding: 25px 20px;
            }

            .brand-title {
                font-size: 1.3rem;
            }

            .form-header h1 {
                font-size: 1.4rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="bg-decoration">
        <div class="decoration-line"></div>
        <div class="decoration-line"></div>
        <div class="decoration-line"></div>
        <div class="decoration-line"></div>
    </div>

    <div class="auth-container">
        @yield('content')
    </div>

    @stack('scripts')

    <script>
        // Password toggle
        document.querySelectorAll('.password-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const inputWrapper = this.closest('.input-icon');
                const input = inputWrapper.querySelector('input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Form submit loading
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const btn = this.querySelector('.btn-primary');
                if (btn && !btn.classList.contains('btn-loading')) {
                    btn.classList.add('btn-loading');
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<span class="spinner"></span> <span>Memproses...</span>';
                }
            });
        });

        // Auto hide alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.animation = 'slideDown 0.5s cubic-bezier(0.16, 1, 0.3, 1) reverse';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>

</html>
