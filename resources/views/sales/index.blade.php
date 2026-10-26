@extends('layouts.app')

@section('title', 'Sales Management')

@section('content')

<div class="container-fluid py-4 sales-page">


{{-- Page Header --}}
<div class="sales-header mb-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

        <div class="d-flex align-items-center gap-3">

            <div class="sales-header-icon">
                <i class="bi bi-receipt-cutoff"></i>
            </div>

            <div>
                <h2 class="sales-page-title mb-1">Sales Management</h2>

                <p class="text-muted mb-0">
                    Manage sales invoices, customers and transactions.
                </p>
            </div>

        </div>

        <a href="{{ route('sales.create') }}"
           class="btn sales-primary-btn">

            <i class="bi bi-plus-lg me-2"></i>
            New Sale

        </a>

    </div>

</div>


{{-- Success Message --}}
@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show sales-alert">

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

    <div class="alert alert-danger alert-dismissible fade show sales-alert">

        <i class="bi bi-exclamation-circle-fill me-2"></i>

        {{ session('error') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"></button>

    </div>

@endif


{{-- Statistics Cards --}}
<div class="row g-3 mb-4">

    {{-- Total Sales --}}
    <div class="col-12 col-sm-6 col-xl-3">

        <div class="sales-stat-card sales-stat-blue">

            <div class="sales-stat-top">
                <span class="sales-stat-label">Total Sales</span>

                <div class="sales-stat-icon">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>

            <h3 class="sales-stat-value">
                {{ $sales->total() }}
            </h3>

            <span class="sales-stat-caption">
                Sales records matching current filters
            </span>

        </div>

    </div>


    {{-- Completed Sales --}}
    <div class="col-12 col-sm-6 col-xl-3">

        <div class="sales-stat-card sales-stat-green">

            <div class="sales-stat-top">
                <span class="sales-stat-label">Completed Sales</span>

                <div class="sales-stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>

            <h3 class="sales-stat-value">
                {{ $sales->getCollection()->where('status', 'completed')->count() }}
            </h3>

            <span class="sales-stat-caption">
                Completed on this page
            </span>

        </div>

    </div>


    {{-- Cancelled Sales --}}
    <div class="col-12 col-sm-6 col-xl-3">

        <div class="sales-stat-card sales-stat-red">

            <div class="sales-stat-top">
                <span class="sales-stat-label">Cancelled Sales</span>

                <div class="sales-stat-icon">
                    <i class="bi bi-x-circle"></i>
                </div>
            </div>

            <h3 class="sales-stat-value">
                {{ $sales->getCollection()->where('status', 'cancelled')->count() }}
            </h3>

            <span class="sales-stat-caption">
                Cancelled on this page
            </span>

        </div>

    </div>


    {{-- Records Displayed --}}
    <div class="col-12 col-sm-6 col-xl-3">

        <div class="sales-stat-card sales-stat-purple">

            <div class="sales-stat-top">
                <span class="sales-stat-label">Current Page</span>

                <div class="sales-stat-icon">
                    <i class="bi bi-files"></i>
                </div>
            </div>

            <h3 class="sales-stat-value">
                {{ $sales->count() }}
            </h3>

            <span class="sales-stat-caption">
                Records currently displayed
            </span>

        </div>

    </div>

</div>


{{-- Sales History Card --}}
<div class="sales-main-card">

    {{-- Card Header --}}
    <div class="sales-card-header">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="sales-section-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">Sales History</h5>

                    <p class="text-muted small mb-0">
                        Review invoices and manage sales transactions.
                    </p>
                </div>

            </div>

            <span class="sales-record-count">
                <i class="bi bi-database me-1"></i>
                {{ $sales->total() }} Records
            </span>

        </div>

    </div>


    {{-- Search Panel --}}
    <div class="sales-search-panel">

        <form method="GET" action="{{ route('sales.index') }}">

            <div class="row g-3 align-items-end">

                <div class="col-12 col-lg-9">

                    <label for="sales-search" class="sales-form-label">
                        Search Sales
                    </label>

                    <div class="sales-search-wrapper">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="sales-search"
                            name="search"
                            value="{{ $search }}"
                            class="form-control sales-search-input"
                            placeholder="Search invoice number or customer..."
                            maxlength="100"
                        >

                    </div>

                </div>


                <div class="col-6 col-lg-2">

                    <button type="submit"
                            class="btn sales-search-btn w-100">

                        <i class="bi bi-search me-2"></i>
                        Search

                    </button>

                </div>


                <div class="col-6 col-lg-1">

                    <a href="{{ route('sales.index') }}"
                       class="btn sales-reset-btn w-100"
                       title="Clear search">

                        <i class="bi bi-arrow-counterclockwise"></i>

                    </a>

                </div>

            </div>

        </form>

    </div>


    {{-- Sales Table --}}
    <div class="table-responsive sales-table-wrapper">

        <table class="table sales-table align-middle mb-0">

            <thead>

                <tr>
                    <th class="ps-4">Invoice Details</th>
                    <th>Customer</th>
                    <th>Sale Date</th>
                    <th class="text-end">Subtotal</th>
                    <th class="text-end">Discount</th>
                    <th class="text-end">Grand Total</th>
                    <th>Status</th>
                    <th class="text-center pe-4">Actions</th>
                </tr>

            </thead>


            <tbody>

                @forelse($sales as $sale)

                    <tr>

                        {{-- Invoice --}}
                        <td class="ps-4">

                            <div class="d-flex align-items-center gap-3">

                                <div class="sales-invoice-icon">
                                    <i class="bi bi-receipt"></i>
                                </div>

                                <div>

                                    <div class="sales-invoice-number">
                                        {{ $sale->invoice_number }}
                                    </div>

                                    <div class="sales-row-subtitle">
                                        Invoice #{{ $sale->id }}
                                    </div>

                                </div>

                            </div>

                        </td>


                        {{-- Customer --}}
                        <td>

                            <div class="sales-customer">

                                <div class="sales-customer-avatar">
                                    <i class="bi bi-person"></i>
                                </div>

                                <span>
                                    {{ $sale->customer->name ?? 'N/A' }}
                                </span>

                            </div>

                        </td>


                        {{-- Sale Date --}}
                        <td>

                            <div class="sales-date">

                                <i class="bi bi-calendar3 me-2"></i>

                                {{ $sale->sale_date
                                    ? $sale->sale_date->format('d M Y')
                                    : 'N/A' }}

                            </div>

                        </td>


                        {{-- Subtotal --}}
                        <td class="text-end">

                            <span class="sales-amount">
                                Rs. {{ number_format((float) $sale->subtotal, 2) }}
                            </span>

                        </td>


                        {{-- Discount --}}
                        <td class="text-end">

                            <span class="sales-discount">
                                Rs. {{ number_format((float) $sale->discount, 2) }}
                            </span>

                        </td>


                        {{-- Grand Total --}}
                        <td class="text-end">

                            <span class="sales-grand-total">
                                Rs. {{ number_format((float) $sale->grand_total, 2) }}
                            </span>

                        </td>


                        {{-- Status --}}
                        <td>

                            @if($sale->status === 'completed')

                                <span class="sales-status sales-status-completed">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Completed
                                </span>

                            @else

                                <span class="sales-status sales-status-cancelled">
                                    <i class="bi bi-x-circle-fill"></i>
                                    {{ ucfirst($sale->status) }}
                                </span>

                            @endif

                        </td>


                        {{-- Actions --}}
                        <td class="text-center pe-4">

                            <div class="sales-actions">

                                {{-- View Invoice --}}
                                <a
                                    href="{{ route('invoices.show', $sale) }}"
                                    class="btn sales-action-view"
                                    title="View Invoice"
                                    aria-label="View invoice {{ $sale->invoice_number }}"
                                >

                                    <i class="bi bi-eye"></i>
                                    <span>View</span>

                                </a>


                                {{-- Cancel Sale --}}
                                @if($sale->status === 'completed')

                                    <form
                                        action="{{ route('sales.destroy', $sale) }}"
                                        method="POST"
                                        onsubmit="return confirm('Cancel this sale? Stock will be restored.');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn sales-action-cancel"
                                            title="Cancel Sale"
                                            aria-label="Cancel sale {{ $sale->invoice_number }}"
                                        >

                                            <i class="bi bi-x-circle"></i>
                                            <span>Cancel</span>

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    {{-- Empty State --}}
                    <tr>

                        <td colspan="8" class="sales-empty-cell">

                            <div class="sales-empty-state">

                                <div class="sales-empty-icon">
                                    <i class="bi bi-receipt"></i>
                                </div>

                                <h5>No Sales Found</h5>

                                <p class="text-muted mb-3">

                                    @if($search !== '')
                                        No sales match your search. Try another invoice number or customer.
                                    @else
                                        You haven't created any sales invoices yet.
                                    @endif

                                </p>

                                @if($search !== '')

                                    <a href="{{ route('sales.index') }}"
                                       class="btn sales-reset-btn">

                                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                                        Clear Search

                                    </a>

                                @else

                                    <a href="{{ route('sales.create') }}"
                                       class="btn sales-primary-btn">

                                        <i class="bi bi-plus-lg me-2"></i>
                                        Create First Sale

                                    </a>

                                @endif

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- Pagination --}}
    @if($sales->hasPages() || $sales->total() > 0)

        <div class="sales-pagination">

            <div class="sales-pagination-info">

                Showing
                <strong>{{ $sales->firstItem() ?? 0 }}</strong>
                to
                <strong>{{ $sales->lastItem() ?? 0 }}</strong>
                of
                <strong>{{ $sales->total() }}</strong>
                sales

            </div>

            <div class="sales-pagination-links">
                {{ $sales->appends(request()->query())->links() }}
            </div>

        </div>

    @endif

</div>


</div>

{{-- Sales Page Styles --}}

<style>

    .sales-page {
        --sales-primary: #4f46e5;
        --sales-primary-dark: #4338ca;
        --sales-text: #172033;
        --sales-muted: #718096;
        --sales-border: #e8edf4;

        color: var(--sales-text);
    }

    /* Header */

    .sales-page .sales-header {
        padding: 8px 0 12px;
    }

    .sales-page .sales-header-icon {
        width: 58px;
        height: 58px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #4f46e5, #818cf8);
        color: #fff;
        border-radius: 17px;
        font-size: 24px;
        box-shadow: 0 8px 20px rgba(79, 70, 229, .2);
    }

    .sales-page .sales-page-title {
        color: var(--sales-text);
        font-size: clamp(1.45rem, 2vw, 1.9rem);
        font-weight: 800;
        letter-spacing: -.6px;
    }

    .sales-page .sales-primary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 19px;
        border: 1px solid var(--sales-primary);
        border-radius: 10px;
        background: var(--sales-primary);
        color: #fff;
        font-weight: 600;
        box-shadow: 0 5px 13px rgba(79, 70, 229, .17);
        transition: all .2s ease;
    }

    .sales-page .sales-primary-btn:hover {
        background: var(--sales-primary-dark);
        border-color: var(--sales-primary-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .sales-page .sales-alert {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
    }

    /* Statistics */

    .sales-page .sales-stat-card {
        height: 100%;
        min-height: 153px;
        padding: 19px;
        background: #fff;
        border: 1px solid var(--sales-border);
        border-radius: 15px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .035);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .sales-page .sales-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .07);
    }

    .sales-page .sales-stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .sales-page .sales-stat-label {
        color: var(--sales-muted);
        font-size: 12px;
        font-weight: 700;
    }

    .sales-page .sales-stat-icon {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 18px;
    }

    .sales-page .sales-stat-value {
        margin: 14px 0 5px;
        color: var(--sales-text);
        font-size: 30px;
        font-weight: 800;
        line-height: 1.2;
    }

    .sales-page .sales-stat-caption {
        display: block;
        color: #94a3b8;
        font-size: 11px;
        line-height: 1.5;
    }

    .sales-page .sales-stat-blue .sales-stat-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .sales-page .sales-stat-green .sales-stat-icon {
        background: #dcfce7;
        color: #15803d;
    }

    .sales-page .sales-stat-red .sales-stat-icon {
        background: #fee2e2;
        color: #dc2626;
    }

    .sales-page .sales-stat-purple .sales-stat-icon {
        background: #f3e8ff;
        color: #9333ea;
    }

    /* Main Card */

    .sales-page .sales-main-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--sales-border);
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, .045);
    }

    .sales-page .sales-card-header {
        padding: 21px 24px;
        border-bottom: 1px solid var(--sales-border);
    }

    .sales-page .sales-card-header h5 {
        color: var(--sales-text);
        font-size: 17px;
    }

    .sales-page .sales-section-icon {
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        color: var(--sales-primary);
        border-radius: 12px;
        font-size: 19px;
    }

    .sales-page .sales-record-count {
        padding: 8px 12px;
        background: #f8fafc;
        border: 1px solid var(--sales-border);
        border-radius: 8px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    /* Search */

    .sales-page .sales-search-panel {
        padding: 21px 24px;
        background: #fbfcfe;
        border-bottom: 1px solid var(--sales-border);
    }

    .sales-page .sales-form-label {
        display: block;
        margin-bottom: 8px;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
    }

    .sales-page .sales-search-wrapper {
        position: relative;
    }

    .sales-page .sales-search-wrapper > i {
        position: absolute;
        top: 50%;
        left: 14px;
        z-index: 2;
        color: #94a3b8;
        transform: translateY(-50%);
    }

    .sales-page .sales-search-input {
        padding-left: 40px;
    }

    .sales-page .sales-search-input {
        min-height: 43px;
        border: 1px solid #dfe5ee;
        border-radius: 9px;
        background: #fff;
        color: #334155;
        font-size: 13px;
        box-shadow: none;
    }

    .sales-page .sales-search-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, .10);
    }

    .sales-page .sales-search-btn,
    .sales-page .sales-reset-btn {
        min-height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        transition: all .2s ease;
    }

    .sales-page .sales-search-btn {
        background: var(--sales-primary);
        color: #fff;
        border: 1px solid var(--sales-primary);
    }

    .sales-page .sales-search-btn:hover {
        background: var(--sales-primary-dark);
        border-color: var(--sales-primary-dark);
        color: #fff;
    }

    .sales-page .sales-reset-btn {
        background: #fff;
        border: 1px solid #dbe2ea;
        color: #475569;
        text-decoration: none;
    }

    .sales-page .sales-reset-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
    }

    /* Table */

    .sales-page .sales-table {
        min-width: 1100px;
    }

    .sales-page .sales-table thead th {
        padding: 15px 13px;
        background: #f8fafc;
        border-bottom: 1px solid var(--sales-border);
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .4px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .sales-page .sales-table tbody td {
        padding: 17px 13px;
        border-bottom: 1px solid #eef2f7;
        color: #475569;
        font-size: 12px;
    }

    .sales-page .sales-table tbody tr {
        transition: background .15s ease;
    }

    .sales-page .sales-table tbody tr:hover {
        background: #fafbff;
    }

    .sales-page .sales-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .sales-page .sales-invoice-icon {
        width: 41px;
        height: 41px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        color: var(--sales-primary);
        border-radius: 11px;
        font-size: 17px;
    }

    .sales-page .sales-invoice-number {
        color: #1e293b;
        font-size: 12px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .sales-page .sales-row-subtitle {
        margin-top: 4px;
        color: #94a3b8;
        font-size: 11px;
    }

    .sales-page .sales-customer {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #334155;
        font-weight: 600;
        white-space: nowrap;
    }

    .sales-page .sales-customer-avatar {
        width: 31px;
        height: 31px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #64748b;
        border-radius: 9px;
        font-size: 15px;
    }

    .sales-page .sales-date {
        color: #64748b;
        white-space: nowrap;
    }

    .sales-page .sales-date i {
        color: #94a3b8;
    }

    .sales-page .sales-amount {
        color: #475569;
        white-space: nowrap;
    }

    .sales-page .sales-discount {
        color: #dc2626;
        white-space: nowrap;
    }

    .sales-page .sales-grand-total {
        color: #0f172a;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* Status */

    .sales-page .sales-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 10px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .sales-page .sales-status-completed {
        background: #dcfce7;
        color: #15803d;
    }

    .sales-page .sales-status-cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* Actions */

    .sales-page .sales-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        white-space: nowrap;
    }

    .sales-page .sales-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 7px 9px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 700;
        transition: all .2s ease;
    }

    .sales-page .sales-action-view {
        background: #eef2ff;
        color: #4338ca;
        border: 1px solid #e0e7ff;
    }

    .sales-page .sales-action-view:hover {
        background: #4f46e5;
        border-color: #4f46e5;
        color: #fff;
    }

    .sales-page .sales-action-cancel {
        background: #fff1f2;
        color: #be123c;
        border: 1px solid #ffe4e6;
    }

    .sales-page .sales-action-cancel:hover {
        background: #e11d48;
        border-color: #e11d48;
        color: #fff;
    }

    /* Empty State */

    .sales-page .sales-empty-cell {
        padding: 0 !important;
    }

    .sales-page .sales-empty-state {
        padding: 55px 20px;
        text-align: center;
    }

    .sales-page .sales-empty-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 22px;
        background: #eef2ff;
        color: #6366f1;
        font-size: 28px;
    }

    .sales-page .sales-empty-state h5 {
        color: #1e293b;
        font-weight: 800;
    }

    .sales-page .sales-empty-state p {
        font-size: 13px;
    }

    /* Pagination */

    .sales-page .sales-pagination {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 17px 24px;
        border-top: 1px solid var(--sales-border);
        background: #fff;
    }

    .sales-page .sales-pagination-info {
        color: #64748b;
        font-size: 12px;
    }

    .sales-page .sales-pagination-info strong {
        color: #334155;
    }

    .sales-page .sales-pagination-links nav {
        margin: 0;
    }

    .sales-page .sales-pagination-links p {
        margin-bottom: 0;
    }

    .sales-page .sales-pagination-links .pagination {
        margin-bottom: 0;
        gap: 4px;
    }

    .sales-page .sales-pagination-links .page-link {
        border-radius: 7px;
        border-color: #e2e8f0;
        color: #475569;
        font-size: 12px;
    }

    .sales-page .sales-pagination-links .active > .page-link {
        background: var(--sales-primary);
        border-color: var(--sales-primary);
        color: #fff;
    }

    /* Responsive */

    @media (max-width: 767.98px) {

        .sales-page {
            padding-top: 20px !important;
        }

        .sales-page .sales-header-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            font-size: 20px;
        }

        .sales-page .sales-page-title {
            font-size: 21px;
        }

        .sales-page .sales-primary-btn {
            width: 100%;
        }

        .sales-page .sales-stat-card {
            min-height: 140px;
            padding: 15px;
        }

        .sales-page .sales-stat-value {
            font-size: 26px;
        }

        .sales-page .sales-card-header,
        .sales-page .sales-search-panel {
            padding: 17px;
        }

        .sales-page .sales-pagination {
            padding: 16px;
        }

        .sales-page .sales-pagination-links {
            width: 100%;
            overflow-x: auto;
        }

    }

    @media (prefers-reduced-motion: reduce) {

        .sales-page *,
        .sales-page *::before,
        .sales-page *::after {
            transition: none !important;
            animation: none !important;
        }

    }

</style>

@endsection
