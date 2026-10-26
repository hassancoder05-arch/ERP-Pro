@extends('layouts.app')

@section('title', 'Customers')

@section('content')

<div class="container-fluid py-4 customer-page">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="customer-page-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div>
                    <h2 class="fw-bold mb-1">Customer Management</h2>
                    <p class="text-muted mb-0">
                        Manage customer profiles, credit limits and balances.
                    </p>
                </div>
            </div>
        </div>

        <a href="{{ route('customers.create') }}"
           class="btn btn-primary customer-add-btn">

            <i class="bi bi-person-plus-fill me-2"></i>
            Add Customer

        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show customer-alert" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif


    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show customer-alert" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif


    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show customer-alert" role="alert">

            <div class="fw-semibold mb-2">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                Please fix the following errors:
            </div>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif


    {{-- Statistics --}}
    @php
        $visibleCustomers = $customers->getCollection();

        $activeCustomers = $visibleCustomers->where('status', 'active')->count();
        $inactiveCustomers = $visibleCustomers->where('status', 'inactive')->count();

        $visibleCredit = $visibleCustomers->sum('credit_limit');
        $visibleBalance = $visibleCustomers->sum('opening_balance');
    @endphp

    <div class="row g-3 mb-4">

        {{-- Total Customers --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="customer-stat-card">
                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="customer-stat-label">Total Customers</p>
                        <h3 class="customer-stat-value">
                            {{ number_format($customers->total()) }}
                        </h3>
                        <span class="customer-stat-note">Matching records</span>
                    </div>

                    <div class="customer-stat-icon icon-blue">
                        <i class="bi bi-people-fill"></i>
                    </div>

                </div>
            </div>
        </div>

        {{-- Active Customers --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="customer-stat-card">
                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="customer-stat-label">Active Customers</p>
                        <h3 class="customer-stat-value">
                            {{ number_format($activeCustomers) }}
                        </h3>
                        <span class="customer-stat-note">On current page</span>
                    </div>

                    <div class="customer-stat-icon icon-green">
                        <i class="bi bi-person-check-fill"></i>
                    </div>

                </div>
            </div>
        </div>

        {{-- Inactive Customers --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="customer-stat-card">
                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="customer-stat-label">Inactive Customers</p>
                        <h3 class="customer-stat-value">
                            {{ number_format($inactiveCustomers) }}
                        </h3>
                        <span class="customer-stat-note">On current page</span>
                    </div>

                    <div class="customer-stat-icon icon-orange">
                        <i class="bi bi-person-dash-fill"></i>
                    </div>

                </div>
            </div>
        </div>

        {{-- Credit Limits --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="customer-stat-card">
                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="customer-stat-label">Page Credit Limits</p>
                        <h3 class="customer-stat-value customer-stat-money">
                            Rs. {{ number_format($visibleCredit, 2) }}
                        </h3>
                        <span class="customer-stat-note">Visible customers</span>
                    </div>

                    <div class="customer-stat-icon icon-purple">
                        <i class="bi bi-wallet2"></i>
                    </div>

                </div>
            </div>
        </div>

    </div>


    {{-- Search Card --}}
    <div class="card customer-card border-0 mb-4">

        <div class="card-body p-3 p-md-4">

            <form method="GET" action="{{ route('customers.index') }}">

                <div class="row g-3 align-items-center">

                    <div class="col-12 col-lg-5">

                        <div>
                            <h5 class="fw-bold mb-1">Customer Directory</h5>
                            <p class="text-muted small mb-0">
                                Search and manage your customer records.
                            </p>
                        </div>

                    </div>

                    <div class="col-12 col-lg-7">

                        <div class="customer-search-group">

                            <span class="customer-search-icon">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                name="search"
                                class="form-control customer-search-input"
                                placeholder="Search by ID, name, email or phone..."
                                value="{{ $search ?? request('search') }}"
                                aria-label="Search customers"
                            >

                            @if(!empty($search) || request()->filled('search'))
                                <a href="{{ route('customers.index') }}"
                                   class="btn btn-outline-secondary customer-clear-btn">
                                    <i class="bi bi-x-lg me-1"></i>
                                    Clear
                                </a>
                            @endif

                            <button class="btn btn-dark customer-search-btn" type="submit">
                                Search
                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Customer Table Card --}}
    <div class="card customer-card border-0">

        {{-- Table Header --}}
        <div class="card-header customer-table-header bg-white">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div class="d-flex align-items-center gap-3">

                    <div class="customer-directory-icon">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">All Customers</h5>
                        <p class="text-muted small mb-0">
                            @if($customers->total() > 0)
                                Showing {{ $customers->firstItem() }}–{{ $customers->lastItem() }}
                                of {{ $customers->total() }} customers
                            @else
                                No customer records available
                            @endif
                        </p>
                    </div>

                </div>

                <span class="customer-record-badge">
                    <i class="bi bi-database me-1"></i>
                    {{ number_format($customers->total()) }} Records
                </span>

            </div>

        </div>


        {{-- Table Body --}}
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table customer-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th class="ps-4">Customer ID</th>
                            <th>Customer</th>
                            <th>Contact Information</th>
                            <th>Credit Limit</th>
                            <th>Opening Balance</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($customers as $customer)

                        @php
                            $customerName = trim($customer->name ?? '');
                            $customerInitial = $customerName !== ''
                                ? strtoupper(substr($customerName, 0, 1))
                                : 'C';
                        @endphp

                        <tr>

                            {{-- Customer ID --}}
                            <td class="ps-4">

                                <span class="customer-id">
                                    {{ $customer->customer_id ?: '—' }}
                                </span>

                            </td>


                            {{-- Customer Name --}}
                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    <div class="customer-avatar">
                                        {{ $customerInitial }}
                                    </div>

                                    <div class="customer-name-wrapper">

                                        <div class="customer-name">
                                            {{ $customer->name }}
                                        </div>

                                        <div class="customer-subtitle">
                                            Customer Account
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Contact Information --}}
                            <td>

                                <div class="customer-contact">

                                    @if($customer->email)
                                        <div class="customer-contact-line">
                                            <i class="bi bi-envelope"></i>
                                            <span>{{ $customer->email }}</span>
                                        </div>
                                    @endif

                                    @if($customer->phone)
                                        <div class="customer-contact-line">
                                            <i class="bi bi-telephone"></i>
                                            <span>{{ $customer->phone }}</span>
                                        </div>
                                    @endif

                                    @if(!$customer->email && !$customer->phone)
                                        <span class="text-muted">No contact details</span>
                                    @endif

                                </div>

                            </td>


                            {{-- Credit Limit --}}
                            <td>
                                <span class="customer-money">
                                    Rs. {{ number_format((float) $customer->credit_limit, 2) }}
                                </span>
                            </td>


                            {{-- Opening Balance --}}
                            <td>
                                <span class="customer-money">
                                    Rs. {{ number_format((float) $customer->opening_balance, 2) }}
                                </span>
                            </td>


                            {{-- Status --}}
                            <td>

                                @if($customer->status === 'active')
                                    <span class="customer-status status-active">
                                        <span class="status-dot"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="customer-status status-inactive">
                                        <span class="status-dot"></span>
                                        Inactive
                                    </span>
                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="text-end pe-4">

                                <div class="customer-actions">

                                    {{-- View --}}
                                    <a href="{{ route('customers.show', $customer) }}"
                                       class="customer-action-btn action-view"
                                       title="View Customer"
                                       aria-label="View customer">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="customer-action-btn action-edit"
                                       title="Edit Customer"
                                       aria-label="Edit customer">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('customers.destroy', $customer) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this customer?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="customer-action-btn action-delete"
                                            title="Delete Customer"
                                            aria-label="Delete customer"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        {{-- Empty State --}}
                        <tr>
                            <td colspan="7" class="text-center py-5">

                                <div class="customer-empty-state">

                                    <div class="customer-empty-icon">
                                        <i class="bi bi-people"></i>
                                    </div>

                                    <h5 class="fw-bold mt-3 mb-2">
                                        No customers found
                                    </h5>

                                    <p class="text-muted mb-3">
                                        @if(!empty($search) || request()->filled('search'))
                                            Try a different search term or clear the search.
                                        @else
                                            Add your first customer to get started.
                                        @endif
                                    </p>

                                    @if(!empty($search) || request()->filled('search'))

                                        <a href="{{ route('customers.index') }}"
                                           class="btn btn-outline-secondary">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                                            Clear Search
                                        </a>

                                    @else

                                        <a href="{{ route('customers.create') }}"
                                           class="btn btn-primary customer-add-btn">
                                            <i class="bi bi-person-plus-fill me-2"></i>
                                            Add Customer
                                        </a>

                                    @endif

                                </div>

                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Pagination --}}
        @if($customers->hasPages())

            <div class="card-footer customer-pagination-footer">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <span class="text-muted small">
                        Page {{ $customers->currentPage() }} of {{ $customers->lastPage() }}
                    </span>

                    <div class="customer-pagination">
                        {{ $customers->appends(request()->query())->links() }}
                    </div>

                </div>

            </div>

        @endif

    </div>


    {{-- Summary Footer --}}
    <div class="customer-page-footer mt-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

            <span>
                <i class="bi bi-shield-check me-1"></i>
                Customer Management
            </span>

            <span>
                <i class="bi bi-list-ul me-1"></i>
                {{ number_format($customers->total()) }} matching records
            </span>

        </div>

    </div>

</div>


<style>
/* =========================================
   CUSTOMER MANAGEMENT PAGE
========================================= */

.customer-page {
    color: #1e293b;
}

.customer-page-icon {
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 15px;
    background: #eef2ff;
    color: #4f46e5;
    font-size: 25px;
}

.customer-page h2 {
    font-size: 27px;
    letter-spacing: -0.6px;
    color: #0f172a;
}

.customer-add-btn {
    border: 0;
    border-radius: 10px;
    padding: 11px 18px;
    background: #4f46e5;
    box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
    font-weight: 600;
    transition: all 0.2s ease;
}

.customer-add-btn:hover {
    background: #4338ca;
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(79, 70, 229, 0.22);
}

.customer-alert {
    border: 0;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}


/* =========================================
   STATISTICS CARDS
========================================= */

.customer-stat-card {
    height: 100%;
    padding: 22px;
    background: #fff;
    border: 1px solid #edf0f5;
    border-radius: 15px;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.035);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.customer-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.07);
}

.customer-stat-label {
    color: #64748b;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 10px;
}

.customer-stat-value {
    color: #0f172a;
    font-size: 27px;
    font-weight: 750;
    margin-bottom: 7px;
    letter-spacing: -0.6px;
    overflow-wrap: anywhere;
}

.customer-stat-money {
    font-size: 19px;
    line-height: 1.5;
}

.customer-stat-note {
    color: #94a3b8;
    font-size: 12px;
}

.customer-stat-icon {
    width: 47px;
    height: 47px;
    border-radius: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.icon-blue {
    background: #eff6ff;
    color: #2563eb;
}

.icon-green {
    background: #ecfdf5;
    color: #059669;
}

.icon-orange {
    background: #fff7ed;
    color: #ea580c;
}

.icon-purple {
    background: #f5f3ff;
    color: #7c3aed;
}


/* =========================================
   CARDS AND SEARCH
========================================= */

.customer-card {
    border-radius: 15px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.045);
}

.customer-search-group {
    display: flex;
    align-items: center;
    gap: 0;
    min-height: 46px;
    padding: 4px;
    border: 1px solid #e2e8f0;
    border-radius: 11px;
    background: #f8fafc;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.customer-search-group:focus-within {
    border-color: #818cf8;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    background: #fff;
}

.customer-search-icon {
    padding: 0 10px;
    color: #94a3b8;
    font-size: 17px;
}

.customer-search-input {
    min-width: 0;
    height: 38px;
    border: 0;
    outline: 0;
    box-shadow: none !important;
    background: transparent;
    font-size: 13px;
}

.customer-search-input:focus {
    background: transparent;
}

.customer-search-btn {
    height: 38px;
    padding: 0 17px;
    border: 0;
    border-radius: 8px !important;
    background: #0f172a;
    font-size: 13px;
    font-weight: 600;
}

.customer-search-btn:hover {
    background: #334155;
}

.customer-clear-btn {
    height: 38px;
    display: flex;
    align-items: center;
    white-space: nowrap;
    margin-right: 5px;
    border-radius: 8px;
    font-size: 12px;
}


/* =========================================
   TABLE HEADER
========================================= */

.customer-table-header {
    padding: 20px 24px;
    border-bottom: 1px solid #edf0f5;
}

.customer-directory-icon {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #f1f5f9;
    color: #475569;
    font-size: 21px;
    flex-shrink: 0;
}

.customer-table-header h5 {
    color: #0f172a;
    font-size: 16px;
}

.customer-record-badge {
    padding: 8px 12px;
    border: 1px solid #e0e7ff;
    border-radius: 8px;
    background: #eef2ff;
    color: #4338ca;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}


/* =========================================
   CUSTOMER TABLE
========================================= */

.customer-table {
    min-width: 1050px;
    border-collapse: separate;
    border-spacing: 0;
}

.customer-table thead th {
    padding-top: 15px;
    padding-bottom: 15px;
    border-top: 0;
    border-bottom: 1px solid #e9edf4;
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    font-weight: 750;
    letter-spacing: 0.55px;
    text-transform: uppercase;
    white-space: nowrap;
}

.customer-table tbody td {
    padding-top: 17px;
    padding-bottom: 17px;
    border-bottom: 1px solid #f1f5f9;
    color: #475569;
    font-size: 13px;
    vertical-align: middle;
}

.customer-table tbody tr:last-child td {
    border-bottom: 0;
}

.customer-table tbody tr {
    transition: background-color 0.15s ease;
}

.customer-table tbody tr:hover td {
    background: #fafbff;
}


/* =========================================
   CUSTOMER ID AND AVATAR
========================================= */

.customer-id {
    display: inline-block;
    padding: 6px 9px;
    border: 1px solid #e2e8f0;
    border-radius: 7px;
    background: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.customer-avatar {
    width: 43px;
    height: 43px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 1px solid #e0e7ff;
    border-radius: 13px;
    background: #eef2ff;
    color: #4f46e5;
    font-size: 16px;
    font-weight: 750;
    text-transform: uppercase;
}

.customer-name {
    max-width: 190px;
    overflow-wrap: anywhere;
    color: #1e293b;
    font-size: 13px;
    font-weight: 700;
}

.customer-subtitle {
    margin-top: 4px;
    color: #94a3b8;
    font-size: 11px;
}


/* =========================================
   CONTACT INFORMATION
========================================= */

.customer-contact {
    display: flex;
    flex-direction: column;
    gap: 6px;
    max-width: 230px;
}

.customer-contact-line {
    display: flex;
    align-items: center;
    gap: 7px;
    min-width: 0;
}

.customer-contact-line i {
    color: #94a3b8;
    flex-shrink: 0;
    font-size: 13px;
}

.customer-contact-line span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.customer-money {
    color: #334155;
    font-size: 12px;
    font-weight: 650;
    white-space: nowrap;
}


/* =========================================
   STATUS BADGES
========================================= */

.customer-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 10px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.status-active {
    background: #ecfdf5;
    color: #047857;
}

.status-inactive {
    background: #f1f5f9;
    color: #64748b;
}

.status-dot {
    width: 7px;
    height: 7px;
    display: inline-block;
    border-radius: 50%;
    background: currentColor;
}


/* =========================================
   ACTION BUTTONS
========================================= */

.customer-actions {
    display: inline-flex;
    align-items: center;
    justify-content: flex-end;
    gap: 6px;
}

.customer-action-btn {
    width: 33px;
    height: 33px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid transparent;
    border-radius: 8px;
    background: #fff;
    font-size: 14px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.18s ease;
}

.action-view {
    border-color: #bae6fd;
    background: #f0f9ff;
    color: #0284c7;
}

.action-view:hover {
    border-color: #0284c7;
    background: #0284c7;
    color: #fff;
}

.action-edit {
    border-color: #c7d2fe;
    background: #eef2ff;
    color: #4f46e5;
}

.action-edit:hover {
    border-color: #4f46e5;
    background: #4f46e5;
    color: #fff;
}

.action-delete {
    border-color: #fecaca;
    background: #fff1f2;
    color: #e11d48;
}

.action-delete:hover {
    border-color: #e11d48;
    background: #e11d48;
    color: #fff;
}


/* =========================================
   EMPTY STATE
========================================= */

.customer-empty-state {
    max-width: 420px;
    margin: 0 auto;
    padding: 20px 10px;
}

.customer-empty-icon {
    width: 75px;
    height: 75px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    border-radius: 22px;
    background: #f1f5f9;
    color: #94a3b8;
    font-size: 34px;
}

.customer-empty-state h5 {
    color: #1e293b;
}


/* =========================================
   PAGINATION AND FOOTER
========================================= */

.customer-pagination-footer {
    padding: 16px 24px;
    border-top: 1px solid #edf0f5;
    background: #fff;
}

.customer-pagination .pagination {
    margin-bottom: 0;
    gap: 4px;
}

.customer-pagination .page-link {
    min-width: 34px;
    border: 1px solid #e2e8f0;
    border-radius: 7px !important;
    color: #475569;
    font-size: 12px;
    text-align: center;
}

.customer-pagination .page-item.active .page-link {
    border-color: #4f46e5;
    background: #4f46e5;
    color: #fff;
}

.customer-pagination .page-link:focus {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
}

.customer-page-footer {
    color: #94a3b8;
    font-size: 12px;
}

.customer-page-footer i {
    color: #6366f1;
}


/* =========================================
   RESPONSIVE DESIGN
========================================= */

@media (max-width: 991.98px) {
    .customer-page h2 {
        font-size: 23px;
    }

    .customer-table-header {
        padding: 17px;
    }
}

@media (max-width: 575.98px) {
    .customer-page {
        padding-top: 18px !important;
    }

    .customer-page h2 {
        font-size: 21px;
    }

    .customer-page-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        font-size: 21px;
    }

    .customer-add-btn {
        width: 100%;
        justify-content: center;
    }

    .customer-stat-card {
        padding: 17px;
    }

    .customer-stat-value {
        font-size: 23px;
    }

    .customer-stat-money {
        font-size: 17px;
    }

    .customer-search-group {
        flex-wrap: wrap;
    }

    .customer-search-input {
        flex: 1;
        width: 60%;
    }

    .customer-search-btn {
        flex: 1;
    }

    .customer-clear-btn {
        margin-right: 0;
    }

    .customer-record-badge {
        font-size: 11px;
    }

    .customer-pagination-footer {
        padding: 15px;
    }

    .customer-pagination-footer > div {
        align-items: flex-start !important;
    }

    .customer-page-footer {
        line-height: 1.8;
    }
}
</style>

@endsection

