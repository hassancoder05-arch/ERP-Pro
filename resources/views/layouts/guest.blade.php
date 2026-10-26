<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'ERP Pro'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <!-- Laravel Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --auth-primary: #6366f1;
            --auth-primary-dark: #4f46e5;
            --auth-text: #111827;
            --auth-muted: #64748b;
            --auth-border: #e5eaf3;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            font-family: 'Inter', sans-serif;

            color: var(--auth-text);

            background: #f5f7fc;

            -webkit-font-smoothing: antialiased;
        }

        /* Main page */
        .auth-page {
            min-height: 100vh;
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 40px 20px;

            position: relative;
            overflow: hidden;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(99, 102, 241, 0.12),
                    transparent 35%
                ),
                radial-gradient(
                    circle at 90% 90%,
                    rgba(129, 140, 248, 0.12),
                    transparent 35%
                ),
                #f5f7fc;
        }

        /* Decorative background shapes */
        .auth-decoration {
            position: absolute;

            border-radius: 50%;

            pointer-events: none;

            filter: blur(1px);
        }

        .auth-decoration-one {
            width: 260px;
            height: 260px;

            top: -100px;
            right: -80px;

            background: rgba(99, 102, 241, 0.07);
        }

        .auth-decoration-two {
            width: 220px;
            height: 220px;

            bottom: -90px;
            left: -70px;

            background: rgba(129, 140, 248, 0.09);
        }

        /* Main container */
        .auth-container {
            width: 100%;
            max-width: 460px;

            position: relative;
            z-index: 1;

            animation: authFadeIn 0.45s ease both;
        }

        /* Brand section */
        .auth-brand {
            display: flex;
            flex-direction: column;
            align-items: center;

            text-align: center;

            margin-bottom: 28px;
        }

        .auth-logo {
            width: 66px;
            height: 66px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #ffffff;
            font-size: 29px;

            background: linear-gradient(
                135deg,
                #818cf8,
                #4f46e5
            );

            border-radius: 20px;

            box-shadow:
                0 10px 25px rgba(99, 102, 241, 0.25),
                inset 0 1px 0 rgba(255, 255, 255, 0.25);

            margin-bottom: 17px;
        }

        .auth-brand h1 {
            margin: 0;

            color: #111827;

            font-size: 27px;
            font-weight: 800;

            letter-spacing: -1px;
        }

        .auth-brand h1 span {
            color: var(--auth-primary);
        }

        .auth-brand p {
            margin: 8px 0 0;

            color: var(--auth-muted);

            font-size: 13px;
            line-height: 1.7;
        }

        /* Authentication card */
        .auth-card {
            width: 100%;

            padding: 34px;

            background: rgba(255, 255, 255, 0.96);

            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 22px;

            box-shadow:
                0 20px 60px rgba(15, 23, 42, 0.07),
                0 2px 8px rgba(15, 23, 42, 0.025);
        }

        /* Form typography */
        .auth-card h2 {
            margin: 0 0 8px;

            color: #111827;

            font-size: 23px;
            font-weight: 800;

            letter-spacing: -0.7px;
        }

        .auth-card p {
            color: var(--auth-muted);
            font-size: 13px;
            line-height: 1.7;
        }

        /* Labels */
        .auth-card label {
            color: #374151;

            font-size: 12px;
            font-weight: 700;
        }

        /* Inputs */
        .auth-card input:not([type="checkbox"]):not([type="radio"]),
        .auth-card select,
        .auth-card textarea {
            width: 100%;
            min-height: 46px;

            padding: 11px 13px;

            color: #111827;
            font-size: 13px;

            background: #ffffff;

            border: 1px solid var(--auth-border);
            border-radius: 11px;

            outline: none;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .auth-card input::placeholder {
            color: #9ca3af;
        }

        .auth-card input:focus,
        .auth-card select:focus,
        .auth-card textarea:focus {
            border-color: var(--auth-primary);

            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.10);
        }

        /* Buttons */
        .auth-card button[type="submit"],
        .auth-card input[type="submit"] {
            min-height: 46px;

            border: none;
            border-radius: 11px;

            color: #ffffff;

            background: linear-gradient(
                135deg,
                #6366f1,
                #4f46e5
            );

            font-size: 13px;
            font-weight: 700;

            cursor: pointer;

            box-shadow: 0 5px 14px rgba(99, 102, 241, 0.18);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                filter 0.2s ease;
        }

        .auth-card button[type="submit"]:hover,
        .auth-card input[type="submit"]:hover {
            filter: brightness(1.04);

            transform: translateY(-1px);

            box-shadow: 0 8px 18px rgba(99, 102, 241, 0.25);
        }

        .auth-card button[type="submit"]:active {
            transform: translateY(0);
        }

        /* Links */
        .auth-card a {
            color: var(--auth-primary);

            font-size: 12px;
            font-weight: 600;

            text-decoration: none;

            transition: color 0.2s ease;
        }

        .auth-card a:hover {
            color: var(--auth-primary-dark);
            text-decoration: underline;
        }

        /* Checkboxes */
        .auth-card input[type="checkbox"] {
            width: 15px;
            height: 15px;

            accent-color: var(--auth-primary);

            cursor: pointer;
        }

        /* Error messages */
        .auth-card .text-red-600,
        .auth-card .text-red-500 {
            color: #dc2626 !important;
            font-size: 12px;
        }

        /* Footer */
        .auth-footer {
            margin-top: 24px;

            text-align: center;

            color: #94a3b8;

            font-size: 11px;
            line-height: 1.8;
        }

        .auth-footer i {
            color: #818cf8;
            margin-right: 4px;
        }

        /* Animation */
        @keyframes authFadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tablet and mobile */
        @media (max-width: 575.98px) {
            .auth-page {
                padding: 28px 16px;
            }

            .auth-brand {
                margin-bottom: 22px;
            }

            .auth-logo {
                width: 58px;
                height: 58px;

                font-size: 25px;
                border-radius: 17px;
            }

            .auth-brand h1 {
                font-size: 24px;
            }

            .auth-card {
                padding: 25px 21px;
                border-radius: 18px;
            }

            .auth-card h2 {
                font-size: 21px;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body>

    <main class="auth-page">

        <!-- Decorative background -->
        <div class="auth-decoration auth-decoration-one"></div>
        <div class="auth-decoration auth-decoration-two"></div>

        <div class="auth-container">

            <!-- Brand -->
            <div class="auth-brand">

                <a href="{{ url('/') }}" aria-label="ERP Pro Home">
                    <div class="auth-logo">
                        <i class="bi bi-grid-1x2-fill"></i>
                    </div>
                </a>

                <h1>
                    ERP <span>Pro</span>
                </h1>

                <p>
                    Your business management platform
                </p>

            </div>

            <!-- Authentication Content -->
            <div class="auth-card">

                {{ $slot }}

            </div>

            <!-- Footer -->
            <div class="auth-footer">
                <div>
                    <i class="bi bi-shield-check"></i>
                    Secure Business Management
                </div>

                <div>
                    &copy; {{ date('Y') }} ERP Pro. All rights reserved.
                </div>
            </div>

        </div>

    </main>

</body>
</html>

