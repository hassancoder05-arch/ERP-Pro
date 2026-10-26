@extends('layouts.app')

@section('title', 'Purchase Management')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<div class="container-fluid py-4 purchase-page">


{{-- Page Header --}}
<div class="purchase-header mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

        <div class="d-flex align-items-center gap-3">
            <div class="purchase-header-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>

            <div>
                <h2 class="purchase-page-title mb-1">Purchase Management</h2>
                <p class="text-muted mb-0">
                    Manage purchase orders, suppliers and incoming stock.
                </p>
            </div>
        </div>

        <a href="{{ route('purchases.create') }}"
           class="btn purchase-primary-btn">
            <i class="fas fa-plus me-2"></i>
            New Purchase
        </a>

    </div>
</div>


{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show purchase-alert" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
@endif


{{-- Error Message --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show purchase-alert" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
@endif


{{-- Validation Errors --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show purchase-alert" role="alert">

        <strong>
            <i class="fas fa-exclamation-triangle me-2"></i>
            Please check the following errors:
        </strong>

        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
@endif


{{-- Statistics Cards --}}
<div class="row g-3 mb-4">

    {{-- Total Purchases --}}
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-2">
        <div class="purchase-stat-card stat-blue">
            <div class="purchase-stat-top">
                <span class="purchase-stat-label">Total Purchases</span>
                <span class="purchase-stat-icon">
                    <i class="fas fa-shopping-bag"></i>
                </span>
            </div>

            <h3 class="purchase-stat-value">
                {{ $totalPurchases }}
            </h3>

            <span class="purchase-stat-caption">All purchase records</span>
        </div>
    </div>


    {{-- Total Purchase Value --}}
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-2">
        <div class="purchase-stat-card stat-green">
            <div class="purchase-stat-top">
                <span class="purchase-stat-label">Purchase Value</span>
                <span class="purchase-stat-icon">
                    <i class="fas fa-wallet"></i>
                </span>
            </div>

            <h3 class="purchase-stat-value purchase-stat-money">
                Rs. {{ number_format((float) $totalAmount, 2) }}
            </h3>

            <span class="purchase-stat-caption">Total recorded value</span>
        </div>
    </div>


    {{-- Draft Purchases --}}
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-2">
        <div class="purchase-stat-card stat-gray">
            <div class="purchase-stat-top">
                <span class="purchase-stat-label">Draft Purchases</span>
                <span class="purchase-stat-icon">
                    <i class="fas fa-file-alt"></i>
                </span>
            </div>

            <h3 class="purchase-stat-value">
                {{ $draftPurchases }}
            </h3>

            <span class="purchase-stat-caption">Awaiting order confirmation</span>
        </div>
    </div>


    {{-- Ordered Purchases --}}
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-2">
        <div class="purchase-stat-card stat-cyan">
            <div class="purchase-stat-top">
                <span class="purchase-stat-label">Ordered Purchases</span>
                <span class="purchase-stat-icon">
                    <i class="fas fa-truck"></i>
                </span>
            </div>

            <h3 class="purchase-stat-value">
                {{ $orderedPurchases }}
            </h3>

            <span class="purchase-stat-caption">Awaiting stock receipt</span>
        </div>
    </div>


    {{-- Received Purchases --}}
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-2">
        <div class="purchase-stat-card stat-green">
            <div class="purchase-stat-top">
                <span class="purchase-stat-label">Received Purchases</span>
                <span class="purchase-stat-icon">
                    <i class="fas fa-check-circle"></i>
                </span>
            </div>

            <h3 class="purchase-stat-value">
                {{ $receivedPurchases }}
            </h3>

            <span class="purchase-stat-caption">Stock received</span>
        </div>
    </div>


    {{-- Cancelled Purchases --}}
    <div class="col-12 col-sm-6 col-xl-4 col-xxl-2">
        <div class="purchase-stat-card stat-red">
            <div class="purchase-stat-top">
                <span class="purchase-stat-label">Cancelled Purchases</span>
                <span class="purchase-stat-icon">
                    <i class="fas fa-times-circle"></i>
                </span>
            </div>

            <h3 class="purchase-stat-value">
                {{ $cancelledPurchases }}
            </h3>

            <span class="purchase-stat-caption">Cancelled records</span>
        </div>
    </div>

</div>


{{-- Pending Purchases Notice --}}
<div class="purchase-pending-banner mb-4">

    <div class="purchase-pending-icon">
        <i class="fas fa-clock"></i>
    </div>

    <div class="flex-grow-1">
        <div class="fw-bold mb-1">Pending Purchases</div>

        <div class="text-muted small">
            {{ $draftPurchases }} draft + {{ $orderedPurchases }} ordered
            purchases are awaiting completion.
        </div>
    </div>

    <div class="purchase-pending-count">
        {{ $pendingPurchases }}
    </div>

</div>


{{-- Purchase History Card --}}
<div class="purchase-main-card">

    {{-- Card Header --}}
    <div class="purchase-card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

            <div class="d-flex align-items-center gap-3">
                <div class="purchase-section-icon">
                    <i class="fas fa-list-alt"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">Purchase History</h5>
                    <p class="text-muted small mb-0">
                        Search, filter and manage your purchase orders.
                    </p>
                </div>
            </div>

            <span class="purchase-record-count">
                <i class="fas fa-database me-1"></i>
                {{ $purchases->total() }} Records
            </span>

        </div>
    </div>


    {{-- Search and Filters --}}
    <div class="purchase-filter-panel">

        <form action="{{ route('purchases.index') }}" method="GET">

            <div class="row g-3 align-items-end">

                <div class="col-12 col-lg-5">

                    <label for="search" class="purchase-form-label">
                        Search Purchases
                    </label>

                    <div class="purchase-input-wrapper">
                        <i class="fas fa-search"></i>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            class="form-control purchase-search-input"
                            placeholder="Purchase number or supplier..."
                            value="{{ $search }}"
                            maxlength="100"
                        >
                    </div>

                </div>


                <div class="col-12 col-sm-6 col-lg-3">

                    <label for="status" class="purchase-form-label">
                        Purchase Status
                    </label>

                    <select id="status" name="status"
                            class="form-select purchase-select">

                        <option value="">All Statuses</option>

                        <option value="draft" @selected($status === 'draft')>
                            Draft
                        </option>

                        <option value="ordered" @selected($status === 'ordered')>
                            Ordered
                        </option>

                        <option value="received" @selected($status === 'received')>
                            Received
                        </option>

                        <option value="cancelled" @selected($status === 'cancelled')>
                            Cancelled
                        </option>

                    </select>

                </div>


                <div class="col-6 col-sm-3 col-lg-2">

                    <button type="submit"
                            class="btn purchase-filter-btn w-100">
                        <i class="fas fa-filter me-2"></i>
                        Filter
                    </button>

                </div>


                <div class="col-6 col-sm-3 col-lg-2">

                    <a href="{{ route('purchases.index') }}"
                       class="btn purchase-reset-btn w-100">
                        <i class="fas fa-undo me-2"></i>
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>


    {{-- Purchases Table --}}
    <div class="table-responsive purchase-table-wrapper">

        <table class="table purchase-table align-middle mb-0">

            <thead>
                <tr>
                    <th class="ps-4">Purchase Details</th>
                    <th>Supplier</th>
                    <th>Purchase Date</th>
                    <th class="text-end">Grand Total</th>
                    <th>Status</th>
                    <th class="text-center pe-4">Actions</th>
                </tr>
            </thead>


            <tbody>

                @forelse($purchases as $purchase)

                    @php
                        $statusClasses = [
                            'draft' => 'purchase-status-draft',
                            'ordered' => 'purchase-status-ordered',
                            'received' => 'purchase-status-received',
                            'cancelled' => 'purchase-status-cancelled',
                        ];

                        $statusIcons = [
                            'draft' => 'fa-file-alt',
                            'ordered' => 'fa-truck',
                            'received' => 'fa-check-circle',
                            'cancelled' => 'fa-times-circle',
                        ];
                    @endphp


                    <tr>

                        {{-- Purchase Number --}}
                        <td class="ps-4">

                            <div class="d-flex align-items-center gap-3">

                                <div class="purchase-row-icon">
                                    <i class="fas fa-receipt"></i>
                                </div>

                                <div>
                                    <div class="purchase-number">
                                        {{ $purchase->purchase_number }}
                                    </div>

                                    <div class="purchase-row-subtitle">
                                        Purchase #{{ $purchase->id }}
                                    </div>
                                </div>

                            </div>

                        </td>


                        {{-- Supplier --}}
                        <td>

                            <div class="purchase-supplier">
                                <i class="fas fa-building me-2"></i>
                                {{ $purchase->supplier->name ?? 'N/A' }}
                            </div>

                        </td>


                        {{-- Purchase Date --}}
                        <td>

                            <div class="purchase-date">
                                <i class="far fa-calendar-alt me-2"></i>

                                {{ $purchase->purchase_date
                                    ? $purchase->purchase_date->format('d M Y')
                                    : 'N/A' }}
                            </div>

                        </td>


                        {{-- Grand Total --}}
                        <td class="text-end">

                            <span class="purchase-total">
                                Rs. {{ number_format((float) $purchase->grand_total, 2) }}
                            </span>

                        </td>


                        {{-- Status --}}
                        <td>

                            <span class="purchase-status
                                {{ $statusClasses[$purchase->status] ?? 'purchase-status-draft' }}">

                                <i class="fas {{ $statusIcons[$purchase->status] ?? 'fa-question-circle' }}"></i>

                                {{ ucfirst($purchase->status) }}

                            </span>

                        </td>


                        {{-- Actions --}}
                        <td class="text-center pe-4">

                            <div class="purchase-actions">

                                {{-- View Purchase --}}
                                <a
                                    href="{{ route('purchases.show', $purchase) }}"
                                    class="btn purchase-action-view"
                                    title="View Purchase"
                                    aria-label="View purchase {{ $purchase->purchase_number }}"
                                >
                                    <i class="fas fa-eye"></i>
                                    <span>View</span>
                                </a>


                                {{-- Mark as Ordered --}}
                                @if($purchase->status === 'draft')

                                    <form
                                        action="{{ route('purchases.order', $purchase->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to mark this purchase as ordered?');"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="btn purchase-action-order"
                                            title="Mark as Ordered"
                                        >
                                            <i class="fas fa-truck"></i>
                                            <span>Order</span>
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    {{-- Empty State --}}
                    <tr>
                        <td colspan="6" class="purchase-empty-cell">

                            <div class="purchase-empty-state">

                                <div class="purchase-empty-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>

                                <h5>No Purchases Found</h5>

                                <p class="text-muted mb-3">
                                    @if($search !== '' || $status !== '')
                                        No purchases match your current filters.
                                    @else
                                        You haven't created any purchases yet.
                                    @endif
                                </p>

                                @if($search !== '' || $status !== '')

                                    <a href="{{ route('purchases.index') }}"
                                       class="btn purchase-reset-btn">
                                        <i class="fas fa-undo me-2"></i>
                                        Clear Filters
                                    </a>

                                @else

                                    <a href="{{ route('purchases.create') }}"
                                       class="btn purchase-primary-btn">
                                        <i class="fas fa-plus me-2"></i>
                                        Create First Purchase
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
    @if($purchases->hasPages() || $purchases->total() > 0)

        <div class="purchase-pagination">

            <div class="purchase-pagination-info">

                Showing
                <strong>{{ $purchases->firstItem() ?? 0 }}</strong>
                to
                <strong>{{ $purchases->lastItem() ?? 0 }}</strong>
                of
                <strong>{{ $purchases->total() }}</strong>
                purchases

            </div>

            <div class="purchase-pagination-links">
                {{ $purchases->appends(request()->query())->links() }}
            </div>

        </div>

    @endif

</div>


</div>

{{-- Page-Specific Styles --}}

<style>
    .purchase-page {
        --purchase-primary: #4f46e5;
        --purchase-primary-dark: #4338ca;
        --purchase-text: #172033;
        --purchase-muted: #718096;
        --purchase-border: #e8edf4;
        --purchase-surface: #ffffff;
        color: var(--purchase-text);
    }

    .purchase-page .purchase-header {
        padding: 8px 0 12px;
    }

    .purchase-page .purchase-header-icon {
        width: 58px;
        height: 58px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        background: linear-gradient(135deg, #4f46e5, #818cf8);
        color: #fff;
        font-size: 23px;
        box-shadow: 0 8px 20px rgba(79, 70, 229, .2);
    }

    .purchase-page .purchase-page-title {
        font-size: clamp(1.45rem, 2vw, 1.9rem);
        font-weight: 800;
        letter-spacing: -.6px;
        color: var(--purchase-text);
    }

    .purchase-page .purchase-primary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 19px;
        border: 0;
        border-radius: 10px;
        background: var(--purchase-primary);
        color: #fff;
        font-weight: 600;
        box-shadow: 0 5px 13px rgba(79, 70, 229, .17);
        transition: all .2s ease;
    }

    .purchase-page .purchase-primary-btn:hover {
        background: var(--purchase-primary-dark);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(79, 70, 229, .23);
    }

    .purchase-page .purchase-alert {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .04);
    }

    /* Statistics Cards */
    .purchase-page .purchase-stat-card {
        height: 100%;
        min-height: 153px;
        padding: 19px;
        background: var(--purchase-surface);
        border: 1px solid var(--purchase-border);
        border-radius: 15px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .035);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .purchase-page .purchase-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .07);
    }

    .purchase-page .purchase-stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
    }

    .purchase-page .purchase-stat-label {
        color: var(--purchase-muted);
        font-size: 12px;
        font-weight: 700;
        line-height: 1.5;
    }

    .purchase-page .purchase-stat-icon {
        width: 39px;
        height: 39px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 16px;
    }

    .purchase-page .purchase-stat-value {
        margin: 13px 0 5px;
        color: var(--purchase-text);
        font-size: 29px;
        line-height: 1.2;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .purchase-page .purchase-stat-money {
        font-size: clamp(17px, 1.2vw, 22px);
        padding-top: 5px;
    }

    .purchase-page .purchase-stat-caption {
        display: block;
        color: #94a3b8;
        font-size: 11px;
        line-height: 1.5;
    }

    .purchase-page .stat-blue .purchase-stat-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .purchase-page .stat-green .purchase-stat-icon {
        background: #dcfce7;
        color: #15803d;
    }

    .purchase-page .stat-gray .purchase-stat-icon {
        background: #f1f5f9;
        color: #64748b;
    }

    .purchase-page .stat-cyan .purchase-stat-icon {
        background: #cffafe;
        color: #0e7490;
    }

    .purchase-page .stat-red .purchase-stat-icon {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Pending Purchases Banner */
    .purchase-page .purchase-pending-banner {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 17px 20px;
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 14px;
    }

    .purchase-page .purchase-pending-icon {
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fef3c7;
        color: #b45309;
        border-radius: 12px;
        font-size: 19px;
    }

    .purchase-page .purchase-pending-count {
        min-width: 43px;
        height: 43px;
        padding: 0 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f59e0b;
        color: #fff;
        border-radius: 12px;
        font-size: 20px;
        font-weight: 800;
    }

    /* Main Purchase Card */
    .purchase-page .purchase-main-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--purchase-border);
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, .045);
    }

    .purchase-page .purchase-card-header {
        padding: 21px 24px;
        border-bottom: 1px solid var(--purchase-border);
    }

    .purchase-page .purchase-card-header h5 {
        color: var(--purchase-text);
        font-size: 17px;
    }

    .purchase-page .purchase-section-icon {
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 12px;
        background: #eef2ff;
        color: var(--purchase-primary);
        font-size: 18px;
    }

    .purchase-page .purchase-record-count {
        padding: 8px 12px;
        background: #f8fafc;
        border: 1px solid var(--purchase-border);
        border-radius: 8px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    /* Filter Panel */
    .purchase-page .purchase-filter-panel {
        padding: 21px 24px;
        background: #fbfcfe;
        border-bottom: 1px solid var(--purchase-border);
    }

    .purchase-page .purchase-form-label {
        display: block;
        margin-bottom: 8px;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
    }

    .purchase-page .purchase-input-wrapper {
        position: relative;
    }

    .purchase-page .purchase-input-wrapper > i {
        position: absolute;
        top: 50%;
        left: 14px;
        z-index: 2;
        color: #94a3b8;
        transform: translateY(-50%);
    }

    .purchase-page .purchase-search-input {
        padding-left: 40px;
    }

    .purchase-page .purchase-search-input,
    .purchase-page .purchase-select {
        min-height: 43px;
        border: 1px solid #dfe5ee;
        border-radius: 9px;
        background-color: #fff;
        color: #334155;
        font-size: 13px;
        box-shadow: none;
    }

    .purchase-page .purchase-search-input:focus,
    .purchase-page .purchase-select:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, .10);
    }

    .purchase-page .purchase-filter-btn,
    .purchase-page .purchase-reset-btn {
        min-height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        transition: all .2s ease;
    }

    .purchase-page .purchase-filter-btn {
        background: var(--purchase-primary);
        color: #fff;
        border: 1px solid var(--purchase-primary);
    }

    .purchase-page .purchase-filter-btn:hover {
        background: var(--purchase-primary-dark);
        color: #fff;
    }

    .purchase-page .purchase-reset-btn {
        background: #fff;
        border: 1px solid #dbe2ea;
        color: #475569;
    }

    .purchase-page .purchase-reset-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
    }

    /* Purchase Table */
    .purchase-page .purchase-table {
        min-width: 950px;
    }

    .purchase-page .purchase-table thead th {
        padding: 15px 13px;
        background: #f8fafc;
        border-bottom: 1px solid var(--purchase-border);
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .45px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .purchase-page .purchase-table tbody td {
        padding: 17px 13px;
        border-bottom: 1px solid #eef2f7;
        color: #475569;
        font-size: 12px;
    }

    .purchase-page .purchase-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .purchase-page .purchase-table tbody tr {
        transition: background .15s ease;
    }

    .purchase-page .purchase-table tbody tr:hover {
        background: #fafbff;
    }

    .purchase-page .purchase-row-icon {
        width: 41px;
        height: 41px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        color: var(--purchase-primary);
        border-radius: 11px;
        font-size: 16px;
    }

    .purchase-page .purchase-number {
        color: #1e293b;
        font-weight: 800;
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .purchase-page .purchase-row-subtitle {
        margin-top: 4px;
        color: #94a3b8;
        font-size: 11px;
    }

    .purchase-page .purchase-supplier {
        color: #334155;
        font-weight: 600;
        white-space: nowrap;
    }

    .purchase-page .purchase-supplier i {
        color: #94a3b8;
    }

    .purchase-page .purchase-date {
        color: #64748b;
        white-space: nowrap;
    }

    .purchase-page .purchase-date i {
        color: #94a3b8;
    }

    .purchase-page .purchase-total {
        color: #0f172a;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* Status Badges */
    .purchase-page .purchase-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 10px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .purchase-page .purchase-status-draft {
        background: #f1f5f9;
        color: #475569;
    }

    .purchase-page .purchase-status-ordered {
        background: #e0f2fe;
        color: #0369a1;
    }

    .purchase-page .purchase-status-received {
        background: #dcfce7;
        color: #15803d;
    }

    .purchase-page .purchase-status-cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* Action Buttons */
    .purchase-page .purchase-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        white-space: nowrap;
    }

    .purchase-page .purchase-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 7px 10px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 700;
        transition: all .2s ease;
    }

    .purchase-page .purchase-action-view {
        background: #eef2ff;
        color: #4338ca;
        border: 1px solid #e0e7ff;
    }

    .purchase-page .purchase-action-view:hover {
        background: #4f46e5;
        color: #fff;
        border-color: #4f46e5;
    }

    .purchase-page .purchase-action-order {
        background: #ecfeff;
        color: #0e7490;
        border: 1px solid #cffafe;
    }

    .purchase-page .purchase-action-order:hover {
        background: #0891b2;
        color: #fff;
        border-color: #0891b2;
    }

    /* Empty State */
    .purchase-page .purchase-empty-cell {
        padding: 0 !important;
    }

    .purchase-page .purchase-empty-state {
        padding: 55px 20px;
        text-align: center;
    }

    .purchase-page .purchase-empty-icon {
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

    .purchase-page .purchase-empty-state h5 {
        color: #1e293b;
        font-weight: 800;
    }

    .purchase-page .purchase-empty-state p {
        font-size: 13px;
    }

    /* Pagination */
    .purchase-page .purchase-pagination {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 17px 24px;
        border-top: 1px solid var(--purchase-border);
        background: #fff;
    }

    .purchase-page .purchase-pagination-info {
        color: #64748b;
        font-size: 12px;
    }

    .purchase-page .purchase-pagination-info strong {
        color: #334155;
    }

    .purchase-page .purchase-pagination-links nav {
        margin: 0;
    }

    .purchase-page .purchase-pagination-links p {
        margin-bottom: 0;
    }

    .purchase-page .purchase-pagination-links .pagination {
        margin-bottom: 0;
        gap: 4px;
    }

    .purchase-page .purchase-pagination-links .page-link {
        border-radius: 7px;
        border-color: #e2e8f0;
        color: #475569;
        font-size: 12px;
    }

    .purchase-page .purchase-pagination-links .active > .page-link {
        background: var(--purchase-primary);
        border-color: var(--purchase-primary);
        color: #fff;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .purchase-page {
            padding-top: 20px !important;
        }

        .purchase-page .purchase-header-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            font-size: 20px;
        }

        .purchase-page .purchase-page-title {
            font-size: 21px;
        }

        .purchase-page .purchase-primary-btn {
            width: 100%;
        }

        .purchase-page .purchase-stat-card {
            padding: 15px;
            min-height: 140px;
        }

        .purchase-page .purchase-stat-value {
            font-size: 25px;
        }

        .purchase-page .purchase-stat-money {
            font-size: 18px;
        }

        .purchase-page .purchase-card-header,
        .purchase-page .purchase-filter-panel {
            padding: 17px;
        }

        .purchase-page .purchase-pagination {
            padding: 16px;
        }

        .purchase-page .purchase-pagination-links {
            width: 100%;
            overflow-x: auto;
        }

        .purchase-page .purchase-pagination-links .pagination {
            flex-wrap: wrap;
        }

        .purchase-page .purchase-pending-banner {
            padding: 14px;
            gap: 10px;
        }

        .purchase-page .purchase-pending-icon {
            width: 38px;
            height: 38px;
        }

        .purchase-page .purchase-pending-count {
            min-width: 36px;
            height: 36px;
            font-size: 17px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .purchase-page *,
        .purchase-page *::before,
        .purchase-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }
</style>

@endsection
