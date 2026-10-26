<nav class="erp-navbar">

    <div class="erp-navbar-inner">

        <!-- LEFT SECTION -->
        <div class="erp-navbar-left">

            <!-- Mobile Sidebar Toggle -->
            <button
                class="erp-menu-toggle"
                id="sidebarToggle"
                type="button"
                aria-label="Toggle sidebar"
                aria-controls="erpSidebar"
                aria-expanded="false">

                <i class="bi bi-list"></i>

            </button>

            <!-- Page Title -->
            <div class="erp-page-heading">

                <div class="erp-page-title">
                    @yield('page-title', 'Dashboard')
                </div>

                <div class="erp-page-subtitle">
                    <span class="erp-breadcrumb-home">
                        <i class="bi bi-grid-1x2"></i>
                        ERP Pro
                    </span>

                    <i class="bi bi-chevron-right erp-breadcrumb-arrow"></i>

                    <span class="erp-breadcrumb-current">
                        @yield('page-title', 'Dashboard')
                    </span>
                </div>

            </div>

        </div>

        <!-- RIGHT SECTION -->
        <div class="erp-navbar-right">

            <!-- Date -->
            <div class="erp-navbar-date">
                <div class="erp-date-icon">
                    <i class="bi bi-calendar3"></i>
                </div>

                <div class="erp-date-content">
                    <span class="erp-date-label">Today</span>

                    <span class="erp-date-value">
                        {{ now()->format('d M Y') }}
                    </span>
                </div>
            </div>

            <!-- Notifications -->
            <a
                href="{{ \Illuminate\Support\Facades\Route::has('notifications.index') ? route('notifications.index') : '#' }}"
                class="erp-notification-btn"
                aria-label="Notifications">

                <i class="bi bi-bell"></i>

                <span class="erp-notification-dot"></span>

            </a>

            <!-- User Profile Dropdown -->
            <div class="dropdown erp-user-dropdown">

                <button
                    class="erp-user-button dropdown-toggle"
                    type="button"
                    id="erpUserDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <div class="erp-user-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>

                    <div class="erp-user-info">

                        <span class="erp-user-name">
                            {{ Auth::user()->name ?? 'Admin' }}
                        </span>

                        <span class="erp-user-role">
                            {{ ucfirst(Auth::user()->role ?? 'Administrator') }}
                        </span>

                    </div>

                    <i class="bi bi-chevron-down erp-user-chevron"></i>

                </button>

                <ul class="dropdown-menu dropdown-menu-end erp-user-menu"
                    aria-labelledby="erpUserDropdown">

                    <!-- Profile Header -->
                    <li>
                        <div class="erp-dropdown-profile">

                            <div class="erp-dropdown-avatar">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>

                            <div class="erp-dropdown-user-details">

                                <div class="erp-dropdown-user-name">
                                    {{ Auth::user()->name ?? 'Admin' }}
                                </div>

                                <div class="erp-dropdown-user-email">
                                    {{ Auth::user()->email ?? '' }}
                                </div>

                            </div>

                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Profile -->
                    <li>
                        <a class="dropdown-item erp-dropdown-item" href="#">
                            <span class="erp-dropdown-icon">
                                <i class="bi bi-person"></i>
                            </span>

                            <span>My Profile</span>
                        </a>
                    </li>

                    <!-- Settings -->
                    <li>
                        <a class="dropdown-item erp-dropdown-item" href="#">
                            <span class="erp-dropdown-icon">
                                <i class="bi bi-gear"></i>
                            </span>

                            <span>Settings</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Logout -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button
                                type="submit"
                                class="dropdown-item erp-dropdown-item erp-logout-item">

                                <span class="erp-dropdown-icon">
                                    <i class="bi bi-box-arrow-right"></i>
                                </span>

                                <span>Sign Out</span>

                            </button>

                        </form>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>


<style>
    /* =========================================
       NAVBAR BASE
    ========================================= */

    .erp-navbar {
        position: sticky;
        top: 0;
        z-index: 1020;

        width: 100%;

        background: rgba(255, 255, 255, 0.96);

        border-bottom: 1px solid #e8edf5;

        box-shadow: 0 3px 15px rgba(15, 23, 42, 0.025);

        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);

        font-family: 'Inter', Arial, sans-serif;
    }

    .erp-navbar-inner {
        min-height: 78px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        padding: 12px 28px;
    }

    /* =========================================
       LEFT SECTION
    ========================================= */

    .erp-navbar-left {
        display: flex;
        align-items: center;

        gap: 16px;

        min-width: 0;
    }

    /* Sidebar Toggle */

    .erp-menu-toggle {
        width: 42px;
        height: 42px;

        display: none;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        background: #f8fafc;

        border: 1px solid #e5eaf3;
        border-radius: 12px;

        color: #334155;

        font-size: 23px;

        cursor: pointer;

        transition: all 0.2s ease;
    }

    .erp-menu-toggle:hover {
        color: #4f46e5;

        background: #eef2ff;

        border-color: #c7d2fe;
    }

    /* Page Heading */

    .erp-page-heading {
        min-width: 0;
    }

    .erp-page-title {
        color: #111827;

        font-size: 21px;
        font-weight: 800;

        letter-spacing: -0.65px;
        line-height: 1.35;

        overflow-wrap: anywhere;
    }

    .erp-page-subtitle {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        margin-top: 5px;

        color: #94a3b8;

        font-size: 11px;
        font-weight: 500;
    }

    .erp-breadcrumb-home {
        display: inline-flex;
        align-items: center;

        gap: 5px;

        color: #64748b;
    }

    .erp-breadcrumb-home i {
        color: #818cf8;
        font-size: 12px;
    }

    .erp-breadcrumb-arrow {
        font-size: 9px;
        color: #cbd5e1;
    }

    .erp-breadcrumb-current {
        color: #6366f1;
        font-weight: 600;
    }

    /* =========================================
       RIGHT SECTION
    ========================================= */

    .erp-navbar-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 17px;

        flex-shrink: 0;
    }

    /* =========================================
       DATE
    ========================================= */

    .erp-navbar-date {
        display: flex;
        align-items: center;

        gap: 10px;

        padding-right: 17px;

        border-right: 1px solid #e8edf5;
    }

    .erp-date-icon {
        width: 38px;
        height: 38px;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #6366f1;

        background: #eef2ff;

        border-radius: 11px;

        font-size: 17px;
    }

    .erp-date-content {
        display: flex;
        flex-direction: column;

        gap: 1px;
    }

    .erp-date-label {
        color: #94a3b8;

        font-size: 10px;
        font-weight: 600;
    }

    .erp-date-value {
        color: #334155;

        font-size: 12px;
        font-weight: 700;

        white-space: nowrap;
    }

    /* =========================================
       NOTIFICATION BUTTON
    ========================================= */

    .erp-notification-btn {
        width: 42px;
        height: 42px;

        position: relative;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        color: #475569;

        background: #f8fafc;

        border: 1px solid #e8edf5;
        border-radius: 12px;

        font-size: 19px;

        transition: all 0.2s ease;
    }

    .erp-notification-btn:hover {
        color: #4f46e5;

        background: #eef2ff;

        border-color: #c7d2fe;

        transform: translateY(-1px);
    }

    .erp-notification-dot {
        width: 8px;
        height: 8px;

        position: absolute;
        top: 8px;
        right: 8px;

        background: #ef4444;

        border: 2px solid #ffffff;
        border-radius: 50%;
    }

    /* =========================================
       USER PROFILE BUTTON
    ========================================= */

    .erp-user-dropdown {
        position: relative;
    }

    .erp-user-button {
        display: flex;
        align-items: center;

        gap: 10px;

        padding: 5px 9px 5px 5px;

        background: transparent;

        border: 1px solid transparent;
        border-radius: 13px;

        cursor: pointer;

        transition: all 0.2s ease;
    }

    .erp-user-button::after {
        display: none !important;
    }

    .erp-user-button:hover,
    .erp-user-button.show {
        background: #f8fafc;
        border-color: #e8edf5;
    }

    .erp-user-avatar {
        width: 42px;
        height: 42px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        color: #ffffff;

        background: linear-gradient(
            135deg,
            #818cf8,
            #4f46e5
        );

        border-radius: 12px;

        font-size: 17px;
        font-weight: 800;

        box-shadow: 0 3px 8px rgba(99, 102, 241, 0.18);
    }

    .erp-user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;

        gap: 2px;

        min-width: 0;
        max-width: 145px;
    }

    .erp-user-name {
        max-width: 145px;

        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;

        color: #1e293b;

        font-size: 12px;
        font-weight: 700;
    }

    .erp-user-role {
        color: #94a3b8;

        font-size: 10px;
        font-weight: 500;
    }

    .erp-user-chevron {
        color: #94a3b8;

        font-size: 11px;

        transition: transform 0.2s ease;
    }

    .erp-user-button.show .erp-user-chevron {
        transform: rotate(180deg);
    }

    /* =========================================
       PROFILE DROPDOWN
    ========================================= */

    .erp-user-menu {
        min-width: 250px;

        margin-top: 12px !important;

        padding: 10px;

        background: #ffffff;

        border: 1px solid #e8edf5;
        border-radius: 16px;

        box-shadow: 0 15px 45px rgba(15, 23, 42, 0.12);
    }

    .erp-dropdown-profile {
        display: flex;
        align-items: center;

        gap: 11px;

        padding: 10px 8px;
    }

    .erp-dropdown-avatar {
        width: 43px;
        height: 43px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        color: #ffffff;

        background: linear-gradient(
            135deg,
            #818cf8,
            #4f46e5
        );

        border-radius: 12px;

        font-size: 17px;
        font-weight: 800;
    }

    .erp-dropdown-user-details {
        min-width: 0;
    }

    .erp-dropdown-user-name {
        overflow: hidden;
        text-overflow: ellipsis;

        color: #111827;

        font-size: 12px;
        font-weight: 800;

        overflow-wrap: anywhere;
    }

    .erp-dropdown-user-email {
        margin-top: 3px;

        color: #94a3b8;

        font-size: 10px;

        overflow-wrap: anywhere;
    }

    .erp-user-menu .dropdown-divider {
        margin: 7px 0;
        border-color: #edf0f6;
    }

    .erp-user-menu .erp-dropdown-item {
        display: flex;
        align-items: center;

        gap: 10px;

        padding: 10px;

        color: #475569;

        border-radius: 9px;

        font-size: 12px;
        font-weight: 600;

        transition: all 0.2s ease;
    }

    .erp-user-menu .erp-dropdown-item:hover {
        color: #4f46e5;
        background: #eef2ff;
    }

    .erp-dropdown-icon {
        width: 29px;
        height: 29px;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #6366f1;

        background: #eef2ff;

        border-radius: 8px;

        font-size: 14px;
    }

    .erp-logout-item {
        width: 100%;

        background: transparent;
        border: none;

        text-align: left;
    }

    .erp-user-menu .erp-logout-item {
        color: #dc2626;
    }

    .erp-user-menu .erp-logout-item .erp-dropdown-icon {
        color: #dc2626;
        background: #fef2f2;
    }

    .erp-user-menu .erp-logout-item:hover {
        color: #b91c1c;
        background: #fef2f2;
    }

    /* =========================================
       TABLET
    ========================================= */

    @media (max-width: 991.98px) {
        .erp-menu-toggle {
            display: flex;
        }

        .erp-navbar-inner {
            min-height: 72px;
            padding: 12px 20px;
            gap: 12px;
        }

        .erp-navbar-left {
            gap: 12px;
        }

        .erp-navbar-right {
            gap: 10px;
        }

        .erp-navbar-date {
            display: none;
        }
    }

    /* =========================================
       MOBILE
    ========================================= */

    @media (max-width: 575.98px) {
        .erp-navbar-inner {
            min-height: 66px;
            padding: 10px 14px;
            gap: 8px;
        }

        .erp-navbar-left {
            gap: 9px;
        }

        .erp-menu-toggle {
            width: 38px;
            height: 38px;

            font-size: 21px;
            border-radius: 10px;
        }

        .erp-page-title {
            font-size: 16px;
            letter-spacing: -0.3px;
        }

        .erp-page-subtitle {
            margin-top: 3px;
            gap: 5px;
            font-size: 9px;
        }

        .erp-navbar-right {
            gap: 7px;
        }

        .erp-notification-btn {
            width: 36px;
            height: 36px;

            font-size: 17px;
            border-radius: 10px;
        }

        .erp-notification-dot {
            top: 6px;
            right: 6px;
        }

        .erp-user-button {
            padding: 0;
            border: none;
        }

        .erp-user-button:hover,
        .erp-user-button.show {
            background: transparent;
            border-color: transparent;
        }

        .erp-user-avatar {
            width: 36px;
            height: 36px;

            border-radius: 10px;

            font-size: 14px;
        }

        .erp-user-info,
        .erp-user-chevron {
            display: none;
        }

        .erp-user-menu {
            min-width: 235px;
            margin-top: 10px !important;
        }
    }

    /* Extra-small devices */
    @media (max-width: 360px) {
        .erp-page-subtitle {
            display: none;
        }

        .erp-navbar-inner {
            padding: 10px;
        }

        .erp-navbar-right {
            gap: 5px;
        }
    }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        .erp-navbar *,
        .erp-navbar *::before,
        .erp-navbar *::after {
            transition: none !important;
        }
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const button = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('erpSidebar');

        if (button && sidebar) {

            button.addEventListener('click', function () {

                const isOpen = sidebar.classList.toggle('active');

                button.setAttribute('aria-expanded', String(isOpen));

            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function (event) {

                if (window.innerWidth > 991) {
                    return;
                }

                if (
                    sidebar.classList.contains('active') &&
                    !sidebar.contains(event.target) &&
                    !button.contains(event.target)
                ) {
                    sidebar.classList.remove('active');
                    button.setAttribute('aria-expanded', 'false');
                }

            });

            // Close sidebar with Escape
            document.addEventListener('keydown', function (event) {

                if (event.key === 'Escape') {
                    sidebar.classList.remove('active');
                    button.setAttribute('aria-expanded', 'false');
                }

            });

        }

    });
</script>

