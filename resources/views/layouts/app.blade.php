
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ERP Pro') | ERP Management System</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0f172a">
    <meta name="description" content="ERP Pro - Enterprise Resource Planning and Business Management System">

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        /* =========================================
           ERP PRO - GLOBAL DESIGN SYSTEM
        ========================================= */

        :root {
            --erp-primary: #6366f1;
            --erp-primary-dark: #4f46e5;
            --erp-primary-light: #eef2ff;

            --erp-background: #f5f7fc;
            --erp-surface: #ffffff;

            --erp-sidebar: #111827;
            --erp-sidebar-hover: #1f2937;

            --erp-text: #111827;
            --erp-text-secondary: #64748b;
            --erp-border: #e8edf5;

            --erp-success: #10b981;
            --erp-danger: #ef4444;
            --erp-warning: #f59e0b;
            --erp-info: #0ea5e9;

            --erp-sidebar-width: 250px;

            --erp-radius-sm: 10px;
            --erp-radius-md: 16px;
            --erp-radius-lg: 22px;

            --erp-shadow-sm:
                0 2px 8px rgba(15, 23, 42, 0.04);

            --erp-shadow-md:
                0 8px 25px rgba(15, 23, 42, 0.06);

            --erp-transition: all 0.25s ease;
        }

        /* =========================================
           RESET & BASE
        ========================================= */

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 90px;
        }

        body {
            margin: 0;
            padding: 0;

            background: var(--erp-background);

            color: var(--erp-text);

            font-family: 'Inter', Arial, sans-serif;

            font-size: 14px;
            line-height: 1.6;

            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;

            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            transition: var(--erp-transition);
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }

        button {
            transition: var(--erp-transition);
        }

        img {
            max-width: 100%;
        }

        /* =========================================
           MAIN APPLICATION WRAPPER
        ========================================= */

        .erp-wrapper {
            min-height: 100vh;
            width: 100%;
            position: relative;
        }

        /* =========================================
           SIDEBAR
        ========================================= */

        .erp-sidebar {
            width: var(--erp-sidebar-width);
            height: 100vh;
            min-height: 100vh;

            position: fixed;
            top: 0;
            left: 0;

            z-index: 1040;

            background: var(--erp-sidebar);

            overflow-x: hidden;
            overflow-y: auto;

            scrollbar-width: thin;
            scrollbar-color: #374151 transparent;

            transition: transform 0.3s ease;
        }

        .erp-sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .erp-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .erp-sidebar::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 20px;
        }

        .erp-sidebar::-webkit-scrollbar-thumb:hover {
            background: #6366f1;
        }

        /* Sidebar content spacing */

        .erp-sidebar .sidebar-brand,
        .erp-sidebar .brand,
        .erp-sidebar .logo-area {
            transition: var(--erp-transition);
        }

        /* =========================================
           MAIN CONTENT AREA
        ========================================= */

        .erp-main {
            margin-left: var(--erp-sidebar-width);

            min-height: 100vh;
            min-width: 0;

            display: flex;
            flex-direction: column;

            transition: margin-left 0.3s ease;
        }

        /* =========================================
           NAVBAR
        ========================================= */

        .erp-main > nav,
        .erp-main > header {
            position: sticky;
            top: 0;

            z-index: 1020;
        }

        /* =========================================
           CONTENT AREA
        ========================================= */

        .erp-content {
            width: 100%;
            max-width: 100%;

            flex: 1 0 auto;

            padding: 28px;

            animation: erpFadeIn 0.35s ease both;
        }

        /* =========================================
           TYPOGRAPHY
        ========================================= */

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: var(--erp-text);
            font-weight: 700;
            letter-spacing: -0.025em;
        }

        h1 {
            font-size: clamp(1.65rem, 2.2vw, 2rem);
        }

        h2 {
            font-size: clamp(1.35rem, 2vw, 1.65rem);
        }

        h3 {
            font-size: 1.25rem;
        }

        p {
            color: var(--erp-text-secondary);
        }

        .text-muted {
            color: var(--erp-text-secondary) !important;
        }

        /* =========================================
           CARDS
        ========================================= */

        .card {
            background: var(--erp-surface);

            border: 1px solid var(--erp-border);
            border-radius: var(--erp-radius-md);

            box-shadow: var(--erp-shadow-sm);

            transition:
                box-shadow 0.25s ease,
                border-color 0.25s ease,
                transform 0.25s ease;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--erp-border);

            padding: 18px 22px;

            font-weight: 700;
        }

        .card-body {
            padding: 22px;
        }

        .card-footer {
            background: #fafbff;
            border-top: 1px solid var(--erp-border);

            padding: 16px 22px;
        }

        /* =========================================
           BUTTONS
        ========================================= */

        .btn {
            border-radius: var(--erp-radius-sm);

            font-size: 13px;
            font-weight: 600;

            padding: 9px 16px;

            transition: var(--erp-transition);
        }

        .btn-primary {
            background: var(--erp-primary);
            border-color: var(--erp-primary);

            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.15);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--erp-primary-dark);
            border-color: var(--erp-primary-dark);

            transform: translateY(-1px);

            box-shadow: 0 6px 15px rgba(99, 102, 241, 0.22);
        }

        .btn-outline-primary {
            color: var(--erp-primary);
            border-color: #c7d2fe;
        }

        .btn-outline-primary:hover {
            color: #ffffff;
            background: var(--erp-primary);
            border-color: var(--erp-primary);
        }

        .btn-success {
            background: var(--erp-success);
            border-color: var(--erp-success);
        }

        .btn-danger {
            background: var(--erp-danger);
            border-color: var(--erp-danger);
        }

        /* =========================================
           FORMS
        ========================================= */

        .form-label {
            color: #334155;

            font-size: 13px;
            font-weight: 600;

            margin-bottom: 7px;
        }

        .form-control,
        .form-select {
            min-height: 43px;

            background-color: #ffffff;

            border: 1px solid #dfe5ef;
            border-radius: var(--erp-radius-sm);

            color: var(--erp-text);

            font-size: 13px;

            padding: 10px 13px;

            transition: var(--erp-transition);
        }

        textarea.form-control {
            min-height: 100px;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #ffffff;

            border-color: var(--erp-primary);

            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.10);
        }

        .input-group-text {
            background: #f8fafc;
            border-color: #dfe5ef;

            color: var(--erp-text-secondary);
        }

        /* =========================================
           TABLES
        ========================================= */

        .table-responsive {
            border-radius: var(--erp-radius-sm);
        }

        .table {
            margin-bottom: 0;

            vertical-align: middle;

            --bs-table-bg: transparent;
            --bs-table-color: var(--erp-text);
        }

        .table thead th {
            background: #f8faff;

            color: #64748b;

            font-size: 11px;
            font-weight: 700;

            letter-spacing: 0.06em;
            text-transform: uppercase;

            white-space: nowrap;

            padding: 15px 18px;

            border-bottom: 1px solid var(--erp-border);
        }

        .table tbody td {
            padding: 15px 18px;

            border-bottom: 1px solid #f0f3f8;

            font-size: 13px;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background: #f8faff;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* =========================================
           BADGES
        ========================================= */

        .badge {
            border-radius: 7px;

            font-size: 11px;
            font-weight: 700;

            padding: 6px 9px;
        }

        /* =========================================
           ALERTS
        ========================================= */

        .alert {
            border: 1px solid transparent;
            border-radius: var(--erp-radius-sm);

            padding: 14px 17px;

            font-size: 13px;
        }

        .alert-success {
            color: #047857;
            background: #ecfdf5;
            border-color: #a7f3d0;
        }

        .alert-danger {
            color: #b91c1c;
            background: #fef2f2;
            border-color: #fecaca;
        }

        .alert-warning {
            color: #92400e;
            background: #fffbeb;
            border-color: #fde68a;
        }

        .alert-info {
            color: #075985;
            background: #f0f9ff;
            border-color: #bae6fd;
        }

        /* =========================================
           PAGINATION
        ========================================= */

        .pagination {
            gap: 5px;
        }

        .page-link {
            border: 1px solid var(--erp-border);
            border-radius: 8px !important;

            color: #475569;

            font-size: 13px;

            padding: 8px 12px;
        }

        .page-link:hover {
            color: var(--erp-primary);
            background: var(--erp-primary-light);
            border-color: #c7d2fe;
        }

        .page-item.active .page-link {
            background: var(--erp-primary);
            border-color: var(--erp-primary);
        }

        /* =========================================
           DROPDOWNS
        ========================================= */

        .dropdown-menu {
            border: 1px solid var(--erp-border);
            border-radius: 12px;

            padding: 7px;

            box-shadow: var(--erp-shadow-md);
        }

        .dropdown-item {
            border-radius: 7px;

            padding: 9px 12px;

            color: #334155;
            font-size: 13px;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            color: var(--erp-primary);
            background: var(--erp-primary-light);
        }

        /* =========================================
           MODALS
        ========================================= */

        .modal-content {
            border: 1px solid var(--erp-border);
            border-radius: var(--erp-radius-lg);

            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.15);
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--erp-border);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--erp-border);
        }

        /* =========================================
           SCROLLBARS
        ========================================= */

        body {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f5f7fc;
        }

        body::-webkit-scrollbar {
            width: 8px;
        }

        body::-webkit-scrollbar-track {
            background: #f5f7fc;
        }

        body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 20px;
        }

        body::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* =========================================
           FOCUS ACCESSIBILITY
        ========================================= */

        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 3px solid rgba(99, 102, 241, 0.35);
            outline-offset: 2px;
        }

        /* =========================================
           ANIMATIONS
        ========================================= */

        @keyframes erpFadeIn {
            from {
                opacity: 0;
                transform: translateY(7px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* =========================================
           TABLET RESPONSIVE
        ========================================= */

        @media (max-width: 1199.98px) {
            .erp-content {
                padding: 22px;
            }

            .card-body {
                padding: 18px;
            }
        }

        /* =========================================
           MOBILE RESPONSIVE
        ========================================= */

        @media (max-width: 991.98px) {

            .erp-sidebar {
                width: min(var(--erp-sidebar-width), 85vw);

                transform: translateX(-100%);

                box-shadow: none;
            }

            .erp-sidebar.active {
                transform: translateX(0);

                box-shadow: 15px 0 45px rgba(15, 23, 42, 0.18);
            }

            .erp-main {
                margin-left: 0;
                width: 100%;
            }

            .erp-content {
                padding: 20px;
            }

            .erp-main > nav,
            .erp-main > header {
                position: relative;
            }
        }

        /* =========================================
           SMALL MOBILE
        ========================================= */

        @media (max-width: 575.98px) {

            .erp-content {
                padding: 14px;
            }

            .card {
                border-radius: 13px;
            }

            .card-header {
                padding: 15px;
            }

            .card-body {
                padding: 15px;
            }

            .card-footer {
                padding: 13px 15px;
            }

            .table thead th {
                padding: 12px;
                font-size: 10px;
            }

            .table tbody td {
                padding: 12px;
                font-size: 12px;
            }

            .btn {
                font-size: 12px;
                padding: 8px 12px;
            }

            h1 {
                font-size: 1.5rem;
            }

            h2 {
                font-size: 1.3rem;
            }
        }

        /* =========================================
           REDUCED MOTION ACCESSIBILITY
        ========================================= */

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="erp-wrapper">

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Application -->
        <div class="erp-main">

            <!-- Navbar -->
            @include('layouts.navbar')

            <!-- Page Content -->
            <main class="erp-content">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('layouts.footer')

        </div>

    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>

