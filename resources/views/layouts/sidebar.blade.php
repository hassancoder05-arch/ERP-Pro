<aside class="erp-sidebar" id="erpSidebar">

    <div class="erp-sidebar-inner">

        {{-- =========================================
             BRAND / LOGO
        ========================================== --}}
        <a href="{{ route('dashboard') }}" class="erp-sidebar-brand">

            <div class="erp-brand-icon">
                <i class="bi bi-grid-1x2-fill"></i>
            </div>

            <div class="erp-brand-text">
                <span class="erp-brand-name">
                    ERP <span>Pro</span>
                </span>

                <span class="erp-brand-caption">
                    BUSINESS MANAGEMENT
                </span>
            </div>

        </a>


        {{-- =========================================
             MAIN MENU
        ========================================== --}}
        <div class="erp-menu-section">

            <div class="erp-menu-heading">
                <span>MAIN MENU</span>
                <span class="erp-menu-heading-line"></span>
            </div>

            <ul class="nav flex-column erp-nav-list">

                {{-- DASHBOARD --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager']))
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-speedometer2"></i>
                                </span>

                                <span class="erp-nav-label">Dashboard</span>

                                @if(request()->routeIs('dashboard'))
                                    <span class="erp-active-indicator"></span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- EMPLOYEES --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager']))
                        <li class="nav-item">
                            <a href="{{ route('employees.index') }}"
                               class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-people"></i>
                                </span>

                                <span class="erp-nav-label">Employees</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- CUSTOMERS --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager', 'sales']))
                        <li class="nav-item">
                            <a href="{{ route('customers.index') }}"
                               class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-person-lines-fill"></i>
                                </span>

                                <span class="erp-nav-label">Customers</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- SUPPLIERS --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager']))
                        <li class="nav-item">
                            <a href="{{ route('suppliers.index') }}"
                               class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-building"></i>
                                </span>

                                <span class="erp-nav-label">Suppliers</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- PRODUCTS --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager', 'sales']))
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}"
                               class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-box-seam"></i>
                                </span>

                                <span class="erp-nav-label">Products</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- INVENTORY --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager', 'sales']))
                        <li class="nav-item">
                            <a href="{{ route('inventory.index') }}"
                               class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-boxes"></i>
                                </span>

                                <span class="erp-nav-label">Inventory</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- PURCHASE MANAGEMENT --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager', 'accountant']))
                        <li class="nav-item">
                            <a href="{{ route('purchases.index') }}"
                               class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-cart-check"></i>
                                </span>

                                <span class="erp-nav-label">Purchase Management</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- SALES --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager', 'sales']))
                        <li class="nav-item">
                            <a href="{{ route('sales.index') }}"
                               class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-receipt"></i>
                                </span>

                                <span class="erp-nav-label">Sales</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- FINANCE --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager', 'accountant']))
                        <li class="nav-item">
                            <a href="{{ route('finance.index') }}"
                               class="nav-link {{
                                   request()->routeIs(
                                       'finance.*',
                                       'expenses.*',
                                       'incomes.*',
                                       'payments.*',
                                       'expense-categories.*'
                                   ) ? 'active' : ''
                               }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-wallet2"></i>
                                </span>

                                <span class="erp-nav-label">Finance</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- ACCOUNTING --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager', 'accountant']))
                        <li class="nav-item">
                            <a href="{{ route('accounting.index') }}"
                               class="nav-link {{ request()->routeIs('accounting.*') ? 'active' : '' }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-calculator"></i>
                                </span>

                                <span class="erp-nav-label">Accounting</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- REPORTS --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager', 'accountant']))
                        <li class="nav-item">
                            <a href="{{ route('reports.index') }}"
                               class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-bar-chart-line"></i>
                                </span>

                                <span class="erp-nav-label">Reports</span>
                            </a>
                        </li>
                    @endif
                @endauth

            </ul>
        </div>


        {{-- =========================================
             CATEGORY MANAGEMENT
        ========================================== --}}
        @auth
            @if(in_array(auth()->user()->role, ['admin', 'manager', 'accountant']))

                <div class="erp-menu-section">

                    <div class="erp-menu-heading">
                        <span>CATALOG & CATEGORIES</span>
                        <span class="erp-menu-heading-line"></span>
                    </div>

                    <ul class="nav flex-column erp-nav-list">

                        {{-- PRODUCT CATEGORIES --}}
                        @if(\Illuminate\Support\Facades\Route::has('categories.index'))
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}"
                                   class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">

                                    <span class="erp-nav-icon">
                                        <i class="bi bi-tags"></i>
                                    </span>

                                    <span class="erp-nav-label">Product Categories</span>

                                    <span class="erp-nav-small-badge">
                                        <i class="bi bi-box-seam"></i>
                                    </span>

                                </a>
                            </li>
                        @endif


                        {{-- EXPENSE CATEGORIES --}}
                        @if(\Illuminate\Support\Facades\Route::has('expense-categories.index'))
                            @if(in_array(auth()->user()->role, ['admin', 'manager', 'accountant']))
                                <li class="nav-item">
                                    <a href="{{ route('expense-categories.index') }}"
                                       class="nav-link {{ request()->routeIs('expense-categories.*') ? 'active' : '' }}">

                                        <span class="erp-nav-icon">
                                            <i class="bi bi-tag"></i>
                                        </span>

                                        <span class="erp-nav-label">Expense Categories</span>
                                    </a>
                                </li>
                            @endif
                        @endif

                    </ul>

                </div>

            @endif
        @endauth


        {{-- =========================================
             SYSTEM MENU
        ========================================== --}}
        <div class="erp-menu-section">

            <div class="erp-menu-heading">
                <span>SYSTEM</span>
                <span class="erp-menu-heading-line"></span>
            </div>

            <ul class="nav flex-column erp-nav-list">

                {{-- NOTIFICATIONS --}}
                @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager', 'sales']))

                        @php
                            $notificationCount =
                                \App\Models\Product::where('stock', '<=', 0)->count()
                                +
                                \App\Models\Product::where('stock', '>', 0)
                                    ->whereColumn('stock', '<=', 'minimum_stock')
                                    ->count();
                        @endphp

                        <li class="nav-item">
                            <a href="{{ route('notifications.index') }}"
                               class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-bell"></i>
                                </span>

                                <span class="erp-nav-label">Notifications</span>

                                @if($notificationCount > 0)
                                    <span class="erp-notification-badge">
                                        {{ $notificationCount > 99 ? '99+' : $notificationCount }}
                                    </span>
                                @endif

                            </a>
                        </li>

                    @endif
                @endauth


                {{-- SETTINGS --}}
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a href="{{ route('settings.index') }}"
                               class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-gear"></i>
                                </span>

                                <span class="erp-nav-label">Settings</span>
                            </a>
                        </li>
                    @endif
                @endauth


                {{-- LOGOUT --}}
                @auth
                    <li class="nav-item erp-logout-container">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="nav-link erp-logout-link">

                                <span class="erp-nav-icon">
                                    <i class="bi bi-box-arrow-right"></i>
                                </span>

                                <span class="erp-nav-label">Sign Out</span>

                            </button>
                        </form>

                    </li>
                @endauth

            </ul>
        </div>


        {{-- =========================================
             BOTTOM USER CARD
        ========================================== --}}
        @auth
            <div class="erp-sidebar-user-card">

                <div class="erp-sidebar-user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>

                <div class="erp-sidebar-user-details">

                    <span class="erp-sidebar-user-name">
                        {{ auth()->user()->name }}
                    </span>

                    <span class="erp-sidebar-user-role">
                        <span class="erp-user-status-dot"></span>
                        {{ ucfirst(auth()->user()->role ?? 'User') }}
                    </span>

                </div>

                <i class="bi bi-shield-check erp-sidebar-user-shield"></i>

            </div>
        @endauth

    </div>

</aside>


<style>
/* =========================================
   SIDEBAR BASE
========================================= */

.erp-sidebar {
    width: 250px;
    height: 100vh;
    max-height: 100vh;

    position: fixed;
    top: 0;
    left: 0;

    z-index: 1040;

    overflow-x: hidden;
    overflow-y: auto;

    color: #cbd5e1;

    background:
        radial-gradient(
            circle at top left,
            rgba(99, 102, 241, 0.13),
            transparent 35%
        ),
        linear-gradient(
            180deg,
            #111827 0%,
            #0f172a 100%
        );

    border-right: 1px solid rgba(148, 163, 184, 0.09);

    scrollbar-width: thin;
    scrollbar-color: #374151 #111827;

    overscroll-behavior-y: contain;

    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
}

.erp-sidebar,
.erp-sidebar * {
    box-sizing: border-box;
}

.erp-sidebar::-webkit-scrollbar {
    width: 5px;
}

.erp-sidebar::-webkit-scrollbar-track {
    background: #111827;
}

.erp-sidebar::-webkit-scrollbar-thumb {
    background: #374151;
    border-radius: 20px;
}

.erp-sidebar::-webkit-scrollbar-thumb:hover {
    background: #6366f1;
}

/* Inner layout */

.erp-sidebar-inner {
    min-height: 100%;
    display: flex;
    flex-direction: column;

    padding: 0 14px 18px;
}

/* =========================================
   BRAND
========================================= */

.erp-sidebar-brand {
    display: flex;
    align-items: center;

    gap: 12px;

    padding: 23px 8px 24px;
    margin-bottom: 12px;

    text-decoration: none;

    border-bottom: 1px solid rgba(148, 163, 184, 0.12);
}

.erp-brand-icon {
    width: 43px;
    height: 43px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    color: #ffffff;
    font-size: 20px;

    background: linear-gradient(
        135deg,
        #818cf8,
        #4f46e5
    );

    border-radius: 13px;

    box-shadow: 0 6px 18px rgba(79, 70, 229, 0.30);

    transition: transform 0.25s ease;
}

.erp-sidebar-brand:hover .erp-brand-icon {
    transform: translateY(-2px);
}

.erp-brand-text {
    display: flex;
    flex-direction: column;

    gap: 2px;
    min-width: 0;
}

.erp-brand-name {
    color: #ffffff;

    font-size: 21px;
    font-weight: 800;

    line-height: 1.25;
    letter-spacing: -0.6px;
}

.erp-brand-name span {
    color: #818cf8;
}

.erp-brand-caption {
    color: #64748b;

    font-size: 8px;
    font-weight: 700;

    letter-spacing: 1.1px;
}

/* =========================================
   MENU SECTIONS
========================================= */

.erp-menu-section {
    margin-bottom: 22px;
}

.erp-menu-heading {
    display: flex;
    align-items: center;

    gap: 9px;

    padding: 0 10px;
    margin: 10px 0 10px;

    color: #64748b;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: 1.3px;
}

.erp-menu-heading-line {
    height: 1px;
    flex: 1;

    background: rgba(148, 163, 184, 0.13);
}

.erp-nav-list {
    gap: 4px;
}

/* =========================================
   NAV LINKS
========================================= */

.erp-sidebar .nav-link {
    min-height: 43px;
    width: 100%;

    display: flex;
    align-items: center;

    gap: 11px;

    position: relative;

    padding: 10px 11px;

    color: #aab7ca;

    background: transparent;

    border: 1px solid transparent;
    border-radius: 10px;

    font-size: 12px;
    font-weight: 500;

    line-height: 1.4;

    text-align: left;
    text-decoration: none;

    transition:
        background 0.2s ease,
        color 0.2s ease,
        border-color 0.2s ease,
        transform 0.2s ease;
}

.erp-sidebar .nav-link:hover {
    color: #ffffff;

    background: rgba(148, 163, 184, 0.08);

    border-color: rgba(148, 163, 184, 0.06);

    transform: translateX(2px);
}

.erp-sidebar .nav-link.active {
    color: #ffffff;

    background: linear-gradient(
        100deg,
        rgba(99, 102, 241, 0.26),
        rgba(79, 70, 229, 0.13)
    );

    border-color: rgba(129, 140, 248, 0.22);

    box-shadow: inset 3px 0 0 #818cf8;
}

/* Icons */

.erp-nav-icon {
    width: 23px;
    height: 23px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    color: #8391a7;

    font-size: 16px;

    transition: color 0.2s ease;
}

.erp-sidebar .nav-link:hover .erp-nav-icon,
.erp-sidebar .nav-link.active .erp-nav-icon {
    color: #a5b4fc;
}

.erp-nav-label {
    flex: 1;
    min-width: 0;

    overflow-wrap: anywhere;
}

/* Active indicator */

.erp-active-indicator {
    width: 6px;
    height: 6px;

    flex-shrink: 0;

    background: #a5b4fc;
    border-radius: 50%;

    box-shadow: 0 0 10px rgba(165, 180, 252, 0.5);
}

/* =========================================
   CATEGORY BADGE
========================================= */

.erp-nav-small-badge {
    width: 24px;
    height: 24px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    color: #a5b4fc;

    background: rgba(99, 102, 241, 0.12);

    border-radius: 7px;

    font-size: 11px;
}

/* =========================================
   NOTIFICATION BADGE
========================================= */

.erp-notification-badge {
    min-width: 22px;
    max-width: 40px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    margin-left: auto;
    padding: 4px 6px;

    color: #ffffff;

    background: #ef4444;

    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 7px;

    font-size: 9px;
    font-weight: 800;
}

/* =========================================
   LOGOUT
========================================= */

.erp-logout-container {
    margin-top: 7px;
    padding-top: 9px;

    border-top: 1px solid rgba(148, 163, 184, 0.12);
}

.erp-sidebar .erp-logout-link {
    color: #fca5a5;

    background: transparent;
    border: 1px solid transparent;

    cursor: pointer;
}

.erp-sidebar .erp-logout-link .erp-nav-icon {
    color: #f87171;
}

.erp-sidebar .erp-logout-link:hover {
    color: #fecaca;

    background: rgba(239, 68, 68, 0.10);

    border-color: rgba(239, 68, 68, 0.12);
}

.erp-sidebar .erp-logout-link:hover .erp-nav-icon {
    color: #fca5a5;
}

/* =========================================
   BOTTOM USER CARD
========================================= */

.erp-sidebar-user-card {
    display: flex;
    align-items: center;

    gap: 10px;

    margin-top: auto;
    padding: 13px 10px 0;

    border-top: 1px solid rgba(148, 163, 184, 0.13);
}

.erp-sidebar-user-avatar {
    width: 37px;
    height: 37px;

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

    border-radius: 11px;

    font-size: 14px;
    font-weight: 800;
}

.erp-sidebar-user-details {
    display: flex;
    flex-direction: column;

    gap: 4px;

    min-width: 0;
    flex: 1;
}

.erp-sidebar-user-name {
    color: #e2e8f0;

    font-size: 11px;
    font-weight: 700;

    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.erp-sidebar-user-role {
    display: flex;
    align-items: center;

    gap: 6px;

    color: #8190a7;

    font-size: 10px;
    font-weight: 500;
}

.erp-user-status-dot {
    width: 6px;
    height: 6px;

    background: #34d399;
    border-radius: 50%;
}

.erp-sidebar-user-shield {
    color: #64748b;
    font-size: 16px;
}

/* =========================================
   RESPONSIVE SIDEBAR
========================================= */

@media (max-width: 991.98px) {
    .erp-sidebar {
        width: min(250px, 85vw);

        transform: translateX(-100%);
    }

    .erp-sidebar.active {
        transform: translateX(0);

        box-shadow: 15px 0 40px rgba(0, 0, 0, 0.28);
    }
}

/* Short screens */

@media (max-height: 700px) {
    .erp-sidebar-brand {
        padding-top: 16px;
        padding-bottom: 17px;
        margin-bottom: 8px;
    }

    .erp-menu-section {
        margin-bottom: 15px;
    }

    .erp-menu-heading {
        margin-top: 7px;
        margin-bottom: 7px;
    }

    .erp-sidebar .nav-link {
        min-height: 39px;
        padding-top: 8px;
        padding-bottom: 8px;
    }
}

/* Accessibility */

@media (prefers-reduced-motion: reduce) {
    .erp-sidebar *,
    .erp-sidebar *::before,
    .erp-sidebar *::after {
        transition: none !important;
        animation: none !important;
    }
}
</style>

