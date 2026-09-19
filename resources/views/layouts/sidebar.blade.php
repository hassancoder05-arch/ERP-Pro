<aside class="erp-sidebar" id="erpSidebar">

    <div class="p-4">

        {{-- LOGO --}}
        <h3 class="text-white fw-bold mb-4">
            <i class="bi bi-grid-1x2-fill"></i>
            ERP Pro
        </h3>


        {{-- =====================================================
             MAIN MENU
        ====================================================== --}}

        <div class="text-secondary small mb-2">
            MAIN MENU
        </div>

        <ul class="nav flex-column gap-1">


            {{-- DASHBOARD --}}
            @auth
                @if(in_array(auth()->user()->role, ['admin', 'manager']))

                    <li class="nav-item">

                        <a href="{{ route('dashboard') }}"
                           class="nav-link
                           {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard

                        </a>

                    </li>

                @endif
            @endauth


            {{-- EMPLOYEES --}}
            @auth
                @if(in_array(auth()->user()->role, ['admin', 'manager']))

                    <li class="nav-item">

                        <a href="{{ route('employees.index') }}"
                           class="nav-link
                           {{ request()->routeIs('employees.*') ? 'active' : '' }}">

                            <i class="bi bi-people me-2"></i>
                            Employees

                        </a>

                    </li>

                @endif
            @endauth


            {{-- CUSTOMERS --}}
            @auth
                @if(in_array(auth()->user()->role, [
                    'admin',
                    'manager',
                    'sales'
                ]))

                    <li class="nav-item">

                        <a href="{{ route('customers.index') }}"
                           class="nav-link
                           {{ request()->routeIs('customers.*') ? 'active' : '' }}">

                            <i class="bi bi-person-lines-fill me-2"></i>
                            Customers

                        </a>

                    </li>

                @endif
            @endauth


            {{-- SUPPLIERS --}}
            @auth
                @if(in_array(auth()->user()->role, [
                    'admin',
                    'manager'
                ]))

                    <li class="nav-item">

                        <a href="{{ route('suppliers.index') }}"
                           class="nav-link
                           {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">

                            <i class="bi bi-building me-2"></i>
                            Suppliers

                        </a>

                    </li>

                @endif
            @endauth


            {{-- PRODUCTS --}}
            @auth
                @if(in_array(auth()->user()->role, [
                    'admin',
                    'manager',
                    'sales'
                ]))

                    <li class="nav-item">

                        <a href="{{ route('products.index') }}"
                           class="nav-link
                           {{ request()->routeIs('products.*') ? 'active' : '' }}">

                            <i class="bi bi-box-seam me-2"></i>
                            Products

                        </a>

                    </li>

                @endif
            @endauth


            {{-- INVENTORY --}}
            @auth
                @if(in_array(auth()->user()->role, [
                    'admin',
                    'manager',
                    'sales'
                ]))

                    <li class="nav-item">

                        <a href="{{ route('inventory.index') }}"
                           class="nav-link
                           {{ request()->routeIs('inventory.*') ? 'active' : '' }}">

                            <i class="bi bi-boxes me-2"></i>
                            Inventory

                        </a>

                    </li>

                @endif
            @endauth


            {{-- SALES --}}
            @auth
                @if(in_array(auth()->user()->role, [
                    'admin',
                    'manager',
                    'sales'
                ]))

                    <li class="nav-item">

                        <a href="{{ route('sales.index') }}"
                           class="nav-link
                           {{ request()->routeIs('sales.*') ? 'active' : '' }}">

                            <i class="bi bi-receipt me-2"></i>
                            Sales

                        </a>

                    </li>

                @endif
            @endauth


            {{-- FINANCE --}}
            @auth
                @if(in_array(auth()->user()->role, [
                    'admin',
                    'manager',
                    'accountant'
                ]))

                    <li class="nav-item">

                        <a href="{{ route('finance.index') }}"
                           class="nav-link
                           {{
                               request()->routeIs(
                                   'finance.*',
                                   'expenses.*',
                                   'incomes.*',
                                   'payments.*',
                                   'expense-categories.*'
                               )
                               ? 'active'
                               : ''
                           }}">

                            <i class="bi bi-wallet2 me-2"></i>
                            Finance

                        </a>

                    </li>

                @endif
            @endauth


            {{-- ACCOUNTING --}}
            @auth
                @if(in_array(auth()->user()->role, [
                    'admin',
                    'manager',
                    'accountant'
                ]))

                    <li class="nav-item">

                        <a href="{{ route('accounting.index') }}"
                           class="nav-link
                           {{ request()->routeIs('accounting.*') ? 'active' : '' }}">

                            <i class="bi bi-calculator me-2"></i>
                            Accounting

                        </a>

                    </li>

                @endif
            @endauth


            {{-- REPORTS --}}
            @auth
                @if(in_array(auth()->user()->role, [
                    'admin',
                    'manager',
                    'accountant'
                ]))

                    <li class="nav-item">

                        <a href="{{ route('reports.index') }}"
                           class="nav-link
                           {{ request()->routeIs('reports.*') ? 'active' : '' }}">

                            <i class="bi bi-bar-chart-line me-2"></i>
                            Reports

                        </a>

                    </li>

                @endif
            @endauth

        </ul>


        {{-- =====================================================
             SYSTEM
        ====================================================== --}}

        <hr class="border-secondary my-4">

        <div class="text-secondary small mb-2">
            SYSTEM
        </div>


        <ul class="nav flex-column gap-1">


            {{-- NOTIFICATIONS --}}
            @auth

                @if(in_array(auth()->user()->role, [
                    'admin',
                    'manager',
                    'sales'
                ]))

                    @php

                        $notificationCount =
                            \App\Models\Product::where(
                                'stock',
                                '<=',
                                0
                            )->count()
                            +
                            \App\Models\Product::where(
                                'stock',
                                '>',
                                0
                            )
                            ->whereColumn(
                                'stock',
                                '<=',
                                'minimum_stock'
                            )
                            ->count();

                    @endphp


                    <li class="nav-item">

                        <a href="{{ route('notifications.index') }}"
                           class="nav-link d-flex align-items-center
                           {{ request()->routeIs('notifications.*') ? 'active' : '' }}">

                            <i class="bi bi-bell me-2"></i>

                            <span>
                                Notifications
                            </span>

                            @if($notificationCount > 0)

                                <span class="badge bg-danger rounded-pill ms-auto">
                                    {{ $notificationCount }}
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
                           class="nav-link
                           {{ request()->routeIs('settings.*') ? 'active' : '' }}">

                            <i class="bi bi-gear me-2"></i>
                            Settings

                        </a>

                    </li>

                @endif

            @endauth


            {{-- LOGOUT --}}
            @auth

                <li class="nav-item mt-2">

                    <form method="POST"
                          action="{{ route('logout') }}">

                        @csrf

                        <button type="submit"
                                class="nav-link logout-link border-0 bg-transparent w-100 text-start rounded">

                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout

                        </button>

                    </form>

                </li>

            @endauth

        </ul>

    </div>

</aside>


<style>

.erp-sidebar .nav-link {

    color: #cbd5e1;

    padding: 11px 14px;

    border-radius: 10px;

    transition: all .2s ease;

}


.erp-sidebar .nav-link:hover {

    background: rgba(99, 102, 241, .12);

    color: #ffffff;

}


.erp-sidebar .nav-link.active {

    background: linear-gradient(
        135deg,
        #4f46e5,
        #6366f1
    );

    color: #ffffff;

    box-shadow:
        0 6px 16px rgba(79, 70, 229, .20);

}


.erp-sidebar .nav-link i {

    width: 20px;

    text-align: center;

}


.logout-link {

    color: #cbd5e1 !important;

    transition: all .2s ease;

}


.logout-link:hover {

    background: rgba(239, 68, 68, .12) !important;

    color: #f87171 !important;

}


.erp-sidebar .badge {

    font-size: 10px;

    min-width: 20px;

    padding: 4px 6px;

}

</style>