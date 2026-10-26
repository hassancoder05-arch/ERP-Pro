@extends('layouts.app')

@section('title', 'Payments')

@section('content')

<div class="container-fluid py-4 payments-page">


{{-- Page Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="page-icon">
                <i class="bi bi-wallet2"></i>
            </span>

            <span class="text-uppercase small fw-semibold text-primary">
                Finance Management
            </span>
        </div>

        <h2 class="fw-bold mb-1">Payments</h2>

        <p class="text-muted mb-0">
            Manage and track customer and supplier payment records.
        </p>
    </div>

    <a href="{{ route('payments.create') }}" class="btn btn-primary px-4">
        <i class="bi bi-plus-lg me-2"></i>
        Record Payment
    </a>

</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4"
         role="alert">

        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
@endif

{{-- Summary Cards --}}
<div class="row g-3 mb-4">

    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm summary-card h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center gap-3">

                    <div>
                        <p class="text-muted small fw-semibold mb-2">
                            Total Payment Records
                        </p>

                        <h3 class="fw-bold mb-0">
                            {{ $payments->total() }}
                        </h3>

                        <span class="summary-caption">
                            Matching your current search
                        </span>
                    </div>

                    <div class="summary-icon blue-icon">
                        <i class="bi bi-receipt"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm summary-card h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center gap-3">

                    <div>
                        <p class="text-muted small fw-semibold mb-2">
                            Customer Payments
                        </p>

                        <h3 class="fw-bold text-success mb-0">
                            {{ $payments->getCollection()->where('type', 'customer')->count() }}
                        </h3>

                        <span class="summary-caption">
                            On this page
                        </span>
                    </div>

                    <div class="summary-icon green-icon">
                        <i class="bi bi-person-check"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card border-0 shadow-sm summary-card h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center gap-3">

                    <div>
                        <p class="text-muted small fw-semibold mb-2">
                            Supplier Payments
                        </p>

                        <h3 class="fw-bold text-danger mb-0">
                            {{ $payments->getCollection()->where('type', 'supplier')->count() }}
                        </h3>

                        <span class="summary-caption">
                            On this page
                        </span>
                    </div>

                    <div class="summary-icon red-icon">
                        <i class="bi bi-truck"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

{{-- Payments Table Card --}}
<div class="card border-0 shadow-sm payments-table-card">

    {{-- Table Heading --}}
    <div class="card-header bg-white border-0 px-4 pt-4 pb-3">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

            <div>
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-list-ul text-primary me-2"></i>
                    Payment Records
                </h5>

                <p class="text-muted small mb-0">
                    View and search recorded transactions.
                </p>
            </div>

            <span class="record-count">
                {{ $payments->total() }} Records
            </span>

        </div>

    </div>

    <div class="card-body px-4 pb-4">

        {{-- Search Form --}}
        <form method="GET"
              action="{{ route('payments.index') }}"
              class="search-panel mb-4">

            <div class="row g-3 align-items-end">

                <div class="col-lg-8">

                    <label for="paymentSearch" class="form-label fw-semibold">
                        Search Payments
                    </label>

                    <div class="input-group search-input-group">

                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text"
                               id="paymentSearch"
                               name="search"
                               value="{{ $search ?? '' }}"
                               class="form-control"
                               placeholder="Customer, supplier or reference...">

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="d-flex flex-wrap gap-2">

                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-search me-1"></i>
                            Search
                        </button>

                        <a href="{{ route('payments.index') }}"
                           class="btn btn-light border">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                            Reset
                        </a>

                    </div>

                </div>

            </div>

        </form>

        {{-- Table --}}
        <div class="table-responsive">

            <table class="table align-middle payments-table">

                <thead>
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Payment Type</th>
                        <th>Customer / Supplier</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Reference</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($payments as $payment)

                    <tr>

                        <td class="ps-3">
                            <span class="row-number">
                                {{ $payments->firstItem() + $loop->index }}
                            </span>
                        </td>

                        {{-- Payment Type --}}
                        <td>

                            @if($payment->type === 'customer')

                                <span class="payment-type-badge customer-badge">
                                    <i class="bi bi-arrow-down-left-circle me-1"></i>
                                    Customer
                                </span>

                            @else

                                <span class="payment-type-badge supplier-badge">
                                    <i class="bi bi-arrow-up-right-circle me-1"></i>
                                    Supplier
                                </span>

                            @endif

                        </td>

                        {{-- Party --}}
                        <td>

                            <div class="d-flex align-items-center gap-2">

                                <div class="party-avatar {{ $payment->type === 'customer' ? 'customer-avatar' : 'supplier-avatar' }}">
                                    @if($payment->type === 'customer')
                                        <i class="bi bi-person"></i>
                                    @else
                                        <i class="bi bi-truck"></i>
                                    @endif
                                </div>

                                <div>
                                    <div class="party-name">
                                        @if($payment->type === 'customer')
                                            {{ $payment->customer?->name ?? 'Deleted Customer' }}
                                        @else
                                            {{ $payment->supplier?->name ?? 'Deleted Supplier' }}
                                        @endif
                                    </div>

                                    <span class="party-subtitle">
                                        {{ $payment->type === 'customer' ? 'Customer account' : 'Supplier account' }}
                                    </span>
                                </div>

                            </div>

                        </td>

                        {{-- Amount --}}
                        <td>

                            <span class="amount-value {{ $payment->type === 'customer' ? 'text-success' : 'text-danger' }}">
                                Rs. {{ number_format((float) $payment->amount, 2) }}
                            </span>

                        </td>

                        {{-- Date --}}
                        <td>
                            <div class="date-cell">
                                <i class="bi bi-calendar3 me-2"></i>

                                {{ $payment->payment_date
                                    ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y')
                                    : '—' }}
                            </div>
                        </td>

                        {{-- Method --}}
                        <td>
                            <span class="method-badge">
                                <i class="bi bi-credit-card me-1"></i>
                                {{ ucfirst($payment->payment_method ?? 'Other') }}
                            </span>
                        </td>

                        {{-- Reference --}}
                        <td>
                            @if($payment->reference)
                                <span class="reference-value">
                                    <i class="bi bi-hash me-1"></i>{{ $payment->reference }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="border-0">

                            <div class="empty-state">

                                <div class="empty-icon">
                                    <i class="bi bi-wallet2"></i>
                                </div>

                                <h5 class="fw-bold mb-2">No Payments Found</h5>

                                <p class="text-muted mb-3">
                                    No payment records match your search.
                                    Try another keyword or record a new payment.
                                </p>

                                @if(!empty($search))
                                    <a href="{{ route('payments.index') }}"
                                       class="btn btn-light border me-2">
                                        Clear Search
                                    </a>
                                @endif

                                <a href="{{ route('payments.create') }}"
                                   class="btn btn-primary">
                                    <i class="bi bi-plus-lg me-1"></i>
                                    Record Payment
                                </a>

                            </div>

                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if($payments->hasPages())
            <div class="pagination-wrapper d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4">

                <span class="text-muted small">
                    Showing
                    <strong>{{ $payments->firstItem() ?? 0 }}</strong>
                    to
                    <strong>{{ $payments->lastItem() ?? 0 }}</strong>
                    of
                    <strong>{{ $payments->total() }}</strong>
                    records
                </span>

                <div>
                    {{ $payments->appends(request()->query())->links() }}
                </div>

            </div>
        @endif

    </div>

</div>


</div>

<style>
    .payments-page {
        color: #1e293b;
    }

    .payments-page .page-icon {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 21px;
    }

    .payments-page .summary-card {
        border-radius: 16px;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .payments-page .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .07) !important;
    }

    .payments-page .summary-icon {
        width: 53px;
        height: 53px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        font-size: 24px;
        flex-shrink: 0;
    }

    .payments-page .blue-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .payments-page .green-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .payments-page .red-icon {
        background: #fff1f2;
        color: #e11d48;
    }

    .payments-page .summary-caption {
        display: block;
        color: #94a3b8;
        font-size: 11px;
        margin-top: 7px;
    }

    .payments-page .payments-table-card {
        border-radius: 17px;
        overflow: hidden;
    }

    .payments-page .record-count {
        padding: 8px 12px;
        border-radius: 9px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 700;
    }

    .payments-page .search-panel {
        padding: 20px;
        border: 1px solid #e8edf4;
        border-radius: 14px;
        background: #f8fafc;
    }

    .payments-page .form-label {
        color: #334155;
        font-size: 13px;
    }

    .payments-page .search-input-group .input-group-text,
    .payments-page .search-input-group .form-control {
        min-height: 44px;
        border-color: #dbe3ee;
        background: #fff;
    }

    .payments-page .search-input-group .input-group-text {
        border-radius: 10px 0 0 10px;
        color: #64748b;
    }

    .payments-page .search-input-group .form-control {
        border-radius: 0 10px 10px 0;
        font-size: 13px;
    }

    .payments-page .search-input-group .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, .09);
    }

    .payments-page .btn {
        min-height: 42px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
    }

    .payments-page .btn-primary {
        background: #4f46e5;
        border-color: #4f46e5;
    }

    .payments-page .btn-primary:hover {
        background: #4338ca;
        border-color: #4338ca;
    }

    .payments-page .payments-table {
        min-width: 950px;
        margin-bottom: 0;
    }

    .payments-page .payments-table thead th {
        padding: 15px 12px;
        background: #f8fafc;
        border-top: 1px solid #e8edf4;
        border-bottom: 1px solid #e8edf4;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .45px;
        white-space: nowrap;
    }

    .payments-page .payments-table tbody td {
        padding: 16px 12px;
        border-color: #f1f5f9;
        font-size: 12px;
        white-space: nowrap;
    }

    .payments-page .payments-table tbody tr {
        transition: background .15s ease;
    }

    .payments-page .payments-table tbody tr:hover {
        background: #fafbff;
    }

    .payments-page .row-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 29px;
        height: 29px;
        padding: 0 7px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
    }

    .payments-page .payment-type-badge {
        display: inline-flex;
        align-items: center;
        padding: 7px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
    }

    .payments-page .customer-badge {
        background: #ecfdf5;
        color: #047857;
    }

    .payments-page .supplier-badge {
        background: #fff1f2;
        color: #be123c;
    }

    .payments-page .party-avatar {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        font-size: 17px;
        flex-shrink: 0;
    }

    .payments-page .customer-avatar {
        background: #ecfdf5;
        color: #059669;
    }

    .payments-page .supplier-avatar {
        background: #fff1f2;
        color: #e11d48;
    }

    .payments-page .party-name {
        color: #1e293b;
        font-weight: 700;
        font-size: 12px;
    }

    .payments-page .party-subtitle {
        display: block;
        margin-top: 4px;
        color: #94a3b8;
        font-size: 10px;
    }

    .payments-page .amount-value {
        font-weight: 800;
        font-size: 12px;
    }

    .payments-page .date-cell {
        color: #475569;
        font-size: 12px;
    }

    .payments-page .date-cell i {
        color: #94a3b8;
    }

    .payments-page .method-badge {
        display: inline-flex;
        align-items: center;
        padding: 7px 9px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        color: #475569;
        font-size: 11px;
        font-weight: 600;
    }

    .payments-page .reference-value {
        color: #475569;
        font-size: 11px;
        font-weight: 600;
    }

    .payments-page .empty-state {
        padding: 50px 20px;
        text-align: center;
        white-space: normal;
    }

    .payments-page .empty-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        border-radius: 22px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 30px;
    }

    .payments-page .empty-state p {
        max-width: 430px;
        margin-right: auto;
        margin-left: auto;
        font-size: 13px;
        line-height: 1.7;
    }

    .payments-page .pagination-wrapper {
        padding-top: 18px;
        border-top: 1px solid #f1f5f9;
    }

    .payments-page .pagination {
        margin-bottom: 0;
    }

    .payments-page .page-link {
        border-radius: 8px;
        margin: 0 2px;
        color: #475569;
        border-color: #e2e8f0;
        font-size: 12px;
    }

    .payments-page .page-item.active .page-link {
        background: #4f46e5;
        border-color: #4f46e5;
        color: #fff;
    }

    @media (max-width: 576px) {
        .payments-page .card-header,
        .payments-page .card-body {
            padding-right: 16px !important;
            padding-left: 16px !important;
        }

        .payments-page .search-panel {
            padding: 15px;
        }

        .payments-page .summary-card .card-body {
            padding: 20px !important;
        }
    }
</style>

@endsection
