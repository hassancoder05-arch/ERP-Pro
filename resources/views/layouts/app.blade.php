<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ERP Pro')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <style>
        body {
            margin: 0;
            background: #f5f7fb;
            font-family: Arial, sans-serif;
        }

        .erp-wrapper {
            min-height: 100vh;
        }

        .erp-sidebar {
            width: 250px;
            min-height: 100vh;
            background: #111827;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
        }

        .erp-main {
            margin-left: 250px;
            min-height: 100vh;
        }

        .erp-content {
            padding: 25px;
        }

        @media (max-width: 991px) {
            .erp-sidebar {
                transform: translateX(-100%);
                transition: 0.3s;
            }

            .erp-sidebar.active {
                transform: translateX(0);
            }

            .erp-main {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="erp-wrapper">

    @include('layouts.sidebar')

    <div class="erp-main">

        @include('layouts.navbar')

        <main class="erp-content">
            @yield('content')
        </main>

        @include('layouts.footer')

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>