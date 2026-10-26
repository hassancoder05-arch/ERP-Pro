@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')

<div class="container-fluid py-4 supplier-page">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div class="d-flex align-items-center gap-3">

            <div class="supplier-page-icon">
                <i class="bi bi-buildings-fill"></i>
            </div>

            <div>
                <h2 class="fw-bold mb-1">Supplier Management</h2>
                <p class="text-muted mb-0">
                    Manage suppliers, company details and outstanding balances.
                </p>
            </div>

        </div>

        <a href="{{ route('suppliers.create') }}"
           class="btn btn-primary supplier-add-btn">

            <i class="bi bi-building-add me-2"></i>
            Add Supplier

        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show supplier-alert" role="alert">

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
        <div class="alert alert-danger alert-dismissible fade show supplier-alert" role="alert">

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
        <div class="alert alert-danger alert-dismissible fade show supplier-alert" role="alert">

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
        $visibleSuppliers = $suppliers->getCollection();

        $activeSuppliers = $visibleSuppliers
            ->where('status', 'active')
            ->count();

        $inactiveSuppliers = $visibleSuppliers
            ->where('status', 'inactive')
            ->count();

        $visibleBalance = $visibleSuppliers
            ->sum('opening_balance');
    @endphp

    <div class="row g-3 mb-4">

        {{-- Total Suppliers --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="supplier-stat-card">
                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="supplier-stat-label">Total Suppliers</p>

                        <h3 class="supplier-stat-value">
                            {{ number_format($suppliers->total()) }}
                        </h3>

                        <span class="supplier-stat-note">
                            Matching records
                        </span>
                    </div>

                    <div class="supplier-stat-icon icon-blue">
                        <i class="bi bi-buildings-fill"></i>
                    </div>

                </div>
            </div>
        </div>


        {{-- Active Suppliers --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="supplier-stat-card">
                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="supplier-stat-label">Active Suppliers</p>

                        <h3 class="supplier-stat-value">
                            {{ number_format($activeSuppliers) }}
                        </h3>

                        <span class="supplier-stat-note">
                            On current page
                        </span>
                    </div>

                    <div class="supplier-stat-icon icon-green">
                        <i class="bi bi-person-check-fill"></i>
                    </div>

                </div>
            </div>
        </div>


        {{-- Inactive Suppliers --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="supplier-stat-card">
                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="supplier-stat-label">Inactive Suppliers</p>

                        <h3 class="supplier-stat-value">
                            {{ number_format($inactiveSuppliers) }}
                        </h3>

                        <span class="supplier-stat-note">
                            On current page
                        </span>
                    </div>

                    <div class="supplier-stat-icon icon-orange">
                        <i class="bi bi-person-dash-fill"></i>
                    </div>

                </div>
            </div>
        </div>


        {{-- Opening Balance --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="supplier-stat-card">
                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="supplier-stat-label">Page Opening Balance</p>

                        <h3 class="supplier-stat-value supplier-stat-money">
                            Rs. {{ number_format((float) $visibleBalance, 2) }}
                        </h3>

                        <span class="supplier-stat-note">
                            Visible suppliers
                        </span>
                    </div>

                    <div class="supplier-stat-icon icon-purple">
                        <i class="bi bi-wallet2"></i>
                    </div>

                </div>
            </div>
        </div>

    </div>


    {{-- Search Card --}}
    <div class="card supplier-card border-0 mb-4">

        <div class="card-body p-3 p-md-4">

            <form method="GET" action="{{ route('suppliers.index') }}">

                <div class="row g-3 align-items-center">

                    <div class="col-12 col-lg-5">

                        <h5 class="fw-bold mb-1">
                            Supplier Directory
                        </h5>

                        <p class="text-muted small mb-0">
                            Find and manage your supplier records.
                        </p>

                    </div>

                    <div class="col-12 col-lg-7">

                        <div class="supplier-search-group">

                            <span class="supplier-search-icon">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                name="search"
                                class="form-control supplier-search-input"
                                placeholder="Search by supplier, ID, company, email or phone..."
                                value="{{ $search ?? request('search') }}"
                                aria-label="Search suppliers"
                            >

                            @if(!empty($search) || request()->filled('search'))

                                <a href="{{ route('suppliers.index') }}"
                                   class="btn btn-outline-secondary supplier-clear-btn">

                                    <i class="bi bi-x-lg me-1"></i>
                                    Clear

                                </a>

                            @endif

                            <button class="btn btn-dark supplier-search-btn"
                                    type="submit">

                                Search

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Supplier Table --}}
    <div class="card supplier-card border-0">

        {{-- Table Header --}}
        <div class="card-header supplier-table-header bg-white">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div class="d-flex align-items-center gap-3">

                    <div class="supplier-directory-icon">
                        <i class="bi bi-journal-text"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">
                            All Suppliers
                        </h5>

                        <p class="text-muted small mb-0">

                            @if($suppliers->total() > 0)
                                Showing {{ $suppliers->firstItem() }}–{{ $suppliers->lastItem() }}
                                of {{ $suppliers->total() }} suppliers
                            @else
                                No supplier records available
                            @endif

                        </p>
                    </div>

                </div>

                <span class="supplier-record-badge">
                    <i class="bi bi-database me-1"></i>
                    {{ number_format($suppliers->total()) }} Records
                </span>

            </div>

        </div>


        {{-- Table Body --}}
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table supplier-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th class="ps-4">Supplier ID</th>
                            <th>Supplier</th>
                            <th>Company</th>
                            <th>Contact Information</th>
                            <th>Opening Balance</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($suppliers as $supplier)

                        @php
                            $supplierName = trim($supplier->name ?? '');

                            $supplierInitial = $supplierName !== ''
                                ? strtoupper(substr($supplierName, 0, 1))
                                : 'S';
                        @endphp

                        <tr>

                            {{-- Supplier ID --}}
                            <td class="ps-4">

                                <span class="supplier-id">
                                    {{ $supplier->supplier_id ?: '—' }}
                                </span>

                            </td>


                            {{-- Supplier Name --}}
                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    <div class="supplier-avatar">
                                        {{ $supplierInitial }}
                                    </div>

                                    <div class="supplier-name-wrapper">

                                        <div class="supplier-name">
                                            {{ $supplier->name }}
                                        </div>

                                        <div class="supplier-subtitle">
                                            Supplier Account
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Company --}}
                            <td>

                                @if($supplier->company_name)

                                    <div class="supplier-company">
                                        <i class="bi bi-building me-1"></i>
                                        {{ $supplier->company_name }}
                                    </div>

                                @else

                                    <span class="text-muted">—</span>

                                @endif

                            </td>


                            {{-- Contact Information --}}
                            <td>

                                <div class="supplier-contact">

                                    @if($supplier->email)

                                        <div class="supplier-contact-line">
                                            <i class="bi bi-envelope"></i>
                                            <span>{{ $supplier->email }}</span>
                                        </div>

                                    @endif

                                    @if($supplier->phone)

                                        <div class="supplier-contact-line">
                                            <i class="bi bi-telephone"></i>
                                            <span>{{ $supplier->phone }}</span>
                                        </div>

                                    @endif

                                    @if(!$supplier->email && !$supplier->phone)

                                        <span class="text-muted">
                                            No contact details
                                        </span>

                                    @endif

                                </div>

                            </td>


                            {{-- Opening Balance --}}
                            <td>

                                <span class="supplier-money">
                                    Rs. {{ number_format((float) $supplier->opening_balance, 2) }}
                                </span>

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($supplier->status === 'active')

                                    <span class="supplier-status status-active">
                                        <span class="status-dot"></span>
                                        Active
                                    </span>

                                @else

                                    <span class="supplier-status status-inactive">
                                        <span class="status-dot"></span>
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="text-end pe-4">

                                <div class="supplier-actions">

                                    {{-- View --}}
                                    <a href="{{ route('suppliers.show', $supplier) }}"
                                       class="supplier-action-btn action-view"
                                       title="View Supplier"
                                       aria-label="View supplier">

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    {{-- Edit --}}
                                    <a href="{{ route('suppliers.edit', $supplier) }}"
                                       class="supplier-action-btn action-edit"
                                       title="Edit Supplier"
                                       aria-label="Edit supplier">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>


                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('suppliers.destroy', $supplier) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this supplier?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="supplier-action-btn action-delete"
                                            title="Delete Supplier"
                                            aria-label="Delete supplier"
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

                                <div class="supplier-empty-state">

                                    <div class="supplier-empty-icon">
                                        <i class="bi bi-buildings"></i>
                                    </div>

                                    <h5 class="fw-bold mt-3 mb-2">
                                        No suppliers found
                                    </h5>

                                    <p class="text-muted mb-3">

                                        @if(!empty($search) || request()->filled('search'))
                                            Try another search term or clear the search.
                                        @else
                                            Add your first supplier to get started.
                                        @endif

                                    </p>

                                    @if(!empty($search) || request()->filled('search'))

                                        <a href="{{ route('suppliers.index') }}"
                                           class="btn btn-outline-secondary">

                                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                                            Clear Search

                                        </a>

                                    @else

                                        <a href="{{ route('suppliers.create') }}"
                                           class="btn btn-primary supplier-add-btn">

                                            <i class="bi bi-building-add me-2"></i>
                                            Add Supplier

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
        @if($suppliers->hasPages())

            <div class="card-footer supplier-pagination-footer">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <span class="text-muted small">
                        Page {{ $suppliers->currentPage() }}
                        of {{ $suppliers->lastPage() }}
                    </span>

                    <div class="supplier-pagination">
                        {{ $suppliers->appends(request()->query())->links() }}
                    </div>

                </div>

            </div>

        @endif

    </div>


    {{-- Footer --}}
    <div class="supplier-page-footer mt-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

            <span>
                <i class="bi bi-shield-check me-1"></i>
                Supplier Management
            </span>

            <span>
                <i class="bi bi-list-ul me-1"></i>
                {{ number_format($suppliers->total()) }} matching records
            </span>

        </div>

    </div>

</div>


<style>
/* =========================================
   SUPPLIER MANAGEMENT PAGE
========================================= */

.supplier-page {
    color: #1e293b;
}

.supplier-page-icon {
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

.supplier-page h2 {
    color: #0f172a;
    font-size: 27px;
    letter-spacing: -0.6px;
}

.supplier-add-btn {
    padding: 11px 18px;
    border: 0;
    border-radius: 10px;
    background: #4f46e5;
    box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
    font-weight: 600;
    transition: all 0.2s ease;
}

.supplier-add-btn:hover {
    background: #4338ca;
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(79, 70, 229, 0.22);
}

.supplier-alert {
    border: 0;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}


/* =========================================
   STATISTICS CARDS
========================================= */

.supplier-stat-card {
    height: 100%;
    padding: 22px;
    border: 1px solid #edf0f5;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.035);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.supplier-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.07);
}

.supplier-stat-label {
    margin-bottom: 10px;
    color: #64748b;
    font-size: 13px;
    font-weight: 600;
}

.supplier-stat-value {
    margin-bottom: 7px;
    color: #0f172a;
    font-size: 27px;
    font-weight: 750;
    letter-spacing: -0.6px;
    overflow-wrap: anywhere;
}

.supplier-stat-money {
    font-size: 19px;
    line-height: 1.5;
}

.supplier-stat-note {
    color: #94a3b8;
    font-size: 12px;
}

.supplier-stat-icon {
    width: 47px;
    height: 47px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 13px;
    font-size: 22px;
}

.supplier-stat-icon.icon-blue {
    background: #eff6ff;
    color: #2563eb;
}

.supplier-stat-icon.icon-green {
    background: #ecfdf5;
    color: #059669;
}

.supplier-stat-icon.icon-orange {
    background: #fff7ed;
    color: #ea580c;
}

.supplier-stat-icon.icon-purple {
    background: #f5f3ff;
    color: #7c3aed;
}


/* =========================================
   CARDS AND SEARCH
========================================= */

.supplier-card {
    overflow: hidden;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.045);
}

.supplier-search-group {
    display: flex;
    align-items: center;
    min-height: 46px;
    gap: 0;
    padding: 4px;
    border: 1px solid #e2e8f0;
    border-radius: 11px;
    background: #f8fafc;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.supplier-search-group:focus-within {
    border-color: #818cf8;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.supplier-search-icon {
    padding: 0 10px;
    color: #94a3b8;
    font-size: 17px;
}

.supplier-search-input {
    min-width: 0;
    height: 38px;
    border: 0;
    outline: 0;
    background: transparent;
    box-shadow: none !important;
    font-size: 13px;
}

.supplier-search-input:focus {
    background: transparent;
}

.supplier-search-btn {
    height: 38px;
    padding: 0 17px;
    border: 0;
    border-radius: 8px !important;
    background: #0f172a;
    font-size: 13px;
    font-weight: 600;
}

.supplier-search-btn:hover {
    background: #334155;
}

.supplier-clear-btn {
    display: flex;
    align-items: center;
    height: 38px;
    margin-right: 5px;
    border-radius: 8px;
    font-size: 12px;
    white-space: nowrap;
}


/* =========================================
   TABLE HEADER
========================================= */

.supplier-table-header {
    padding: 20px 24px;
    border-bottom: 1px solid #edf0f5;
}

.supplier-directory-icon {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 12px;
    background: #f1f5f9;
    color: #475569;
    font-size: 21px;
}

.supplier-table-header h5 {
    color: #0f172a;
    font-size: 16px;
}

.supplier-record-badge {
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
   SUPPLIER TABLE
========================================= */

.supplier-table {
    min-width: 1050px;
    border-collapse: separate;
    border-spacing: 0;
}

.supplier-table thead th {
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

.supplier-table tbody td {
    padding-top: 17px;
    padding-bottom: 17px;
    border-bottom: 1px solid #f1f5f9;
    color: #475569;
    font-size: 13px;
    vertical-align: middle;
}

.supplier-table tbody tr:last-child td {
    border-bottom: 0;
}

.supplier-table tbody tr {
    transition: background-color 0.15s ease;
}

.supplier-table tbody tr:hover td {
    background: #fafbff;
}


/* =========================================
   SUPPLIER ID AND AVATAR
========================================= */

.supplier-id {
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

.supplier-avatar {
    width: 43px;
    height: 43px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 1px solid #d1fae5;
    border-radius: 13px;
    background: #ecfdf5;
    color: #059669;
    font-size: 16px;
    font-weight: 750;
    text-transform: uppercase;
}

.supplier-name {
    max-width: 180px;
    overflow-wrap: anywhere;
    color: #1e293b;
    font-size: 13px;
    font-weight: 700;
}

.supplier-subtitle {
    margin-top: 4px;
    color: #94a3b8;
    font-size: 11px;
}

.supplier-company {
    max-width: 180px;
    overflow-wrap: anywhere;
    color: #475569;
    font-size: 13px;
    font-weight: 500;
}

.supplier-company i {
    color: #94a3b8;
}


/* =========================================
   CONTACT INFORMATION
========================================= */

.supplier-contact {
    display: flex;
    flex-direction: column;
    gap: 6px;
    max-width: 230px;
}

.supplier-contact-line {
    display: flex;
    align-items: center;
    gap: 7px;
    min-width: 0;
}

.supplier-contact-line i {
    flex-shrink: 0;
    color: #94a3b8;
    font-size: 13px;
}

.supplier-contact-line span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.supplier-money {
    color: #334155;
    font-size: 12px;
    font-weight: 650;
    white-space: nowrap;
}


/* =========================================
   STATUS BADGES
========================================= */

.supplier-status {
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

.supplier-actions {
    display: inline-flex;
    align-items: center;
    justify-content: flex-end;
    gap: 6px;
}

.supplier-action-btn {
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

.supplier-empty-state {
    max-width: 420px;
    margin: 0 auto;
    padding: 20px 10px;
}

.supplier-empty-icon {
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

.supplier-empty-state h5 {
    color: #1e293b;
}


/* =========================================
   PAGINATION AND FOOTER
========================================= */

.supplier-pagination-footer {
    padding: 16px 24px;
    border-top: 1px solid #edf0f5;
    background: #fff;
}

.supplier-pagination .pagination {
    margin-bottom: 0;
    gap: 4px;
}

.supplier-pagination .page-link {
    min-width: 34px;
    border: 1px solid #e2e8f0;
    border-radius: 7px !important;
    color: #475569;
    font-size: 12px;
    text-align: center;
}

.supplier-pagination .page-item.active .page-link {
    border-color: #4f46e5;
    background: #4f46e5;
    color: #fff;
}

.supplier-pagination .page-link:focus {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
}

.supplier-page-footer {
    color: #94a3b8;
    font-size: 12px;
}

.supplier-page-footer i {
    color: #6366f1;
}


/* =========================================
   RESPONSIVE DESIGN
========================================= */

@media (max-width: 991.98px) {
    .supplier-page h2 {
        font-size: 23px;
    }

    .supplier-table-header {
        padding: 17px;
    }
}

@media (max-width: 575.98px) {
    .supplier-page {
        padding-top: 18px !important;
    }

    .supplier-page h2 {
        font-size: 21px;
    }

    .supplier-page-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        font-size: 21px;
    }

    .supplier-add-btn {
        width: 100%;
        justify-content: center;
    }

    .supplier-stat-card {
        padding: 17px;
    }

    .supplier-stat-value {
        font-size: 23px;
    }

    .supplier-stat-money {
        font-size: 17px;
    }

    .supplier-search-group {
        flex-wrap: wrap;
    }

    .supplier-search-input {
        flex: 1;
        width: 60%;
    }

    .supplier-search-btn {
        flex: 1;
    }

    .supplier-clear-btn {
        margin-right: 0;
    }

    .supplier-record-badge {
        font-size: 11px;
    }

    .supplier-pagination-footer {
        padding: 15px;
    }

    .supplier-pagination-footer > div {
        align-items: flex-start !important;
    }

    .supplier-page-footer {
        line-height: 1.8;
    }
}
</style>

@endsection

