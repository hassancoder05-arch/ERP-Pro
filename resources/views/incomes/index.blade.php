
@extends('layouts.app')

@section('title', 'Income Management')

@section('content')

<div class="container-fluid income-page py-3 py-lg-4">

    {{-- Header --}}
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">

        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="income-header-icon">
                    <i class="bi bi-wallet2"></i>
                </span>

                <span class="small text-success fw-bold income-eyebrow">
                    FINANCE MANAGEMENT
                </span>
            </div>

            <h2 class="fw-bold mb-1">Income Management</h2>

            <p class="text-muted mb-0">
                Track and manage additional business income.
            </p>
        </div>

        <a href="{{ route('incomes.create') }}" class="btn btn-success income-add-btn">
            <i class="bi bi-plus-lg me-2"></i>
            Add New Income
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show income-alert" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="income-stat-card">
                <div class="income-stat-icon green">
                    <i class="bi bi-cash-stack"></i>
                </div>

                <div>
                    <p class="income-stat-label">Income Records</p>
                    <h4 class="income-stat-value">{{ $incomes->total() }}</h4>
                    <span class="income-stat-note">Total matching records</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="income-stat-card">
                <div class="income-stat-icon blue">
                    <i class="bi bi-calendar-check"></i>
                </div>

                <div>
                    <p class="income-stat-label">Current Page</p>
                    <h4 class="income-stat-value">
                        {{ $incomes->count() }}
                    </h4>
                    <span class="income-stat-note">Records displayed below</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="income-stat-card">
                <div class="income-stat-icon purple">
                    <i class="bi bi-search"></i>
                </div>

                <div>
                    <p class="income-stat-label">Search Results</p>
                    <h4 class="income-stat-value">
                        {{ $incomes->total() }}
                    </h4>
                    <span class="income-stat-note">
                        {{ filled($search) ? 'Filtered results' : 'All available records' }}
                    </span>
                </div>
            </div>
        </div>

    </div>


    {{-- Main Card --}}
    <div class="income-main-card">

        {{-- Card Header --}}
        <div class="income-card-header">

            <div>
                <h5 class="fw-bold mb-1">Income Records</h5>
                <p class="text-muted small mb-0">
                    Review, search and manage your income entries.
                </p>
            </div>

            <span class="income-record-badge">
                <i class="bi bi-list-ul me-1"></i>
                {{ $incomes->total() }} Records
            </span>

        </div>


        {{-- Search --}}
        <div class="income-search-section">

            <form method="GET"
                  action="{{ route('incomes.index') }}"
                  class="income-search-form">

                <div class="income-search-input">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        class="form-control"
                        placeholder="Search by title, payment method or description..."
                        aria-label="Search income records"
                    >

                    @if(filled($search))
                        <a href="{{ route('incomes.index') }}"
                           class="income-clear-search"
                           title="Clear search"
                           aria-label="Clear search">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif

                </div>

                <button type="submit" class="btn btn-primary income-search-btn">
                    <i class="bi bi-search me-2"></i>
                    Search
                </button>

                @if(filled($search))
                    <a href="{{ route('incomes.index') }}" class="btn btn-light border income-reset-btn">
                        Reset
                    </a>
                @endif

            </form>

        </div>


        {{-- Table --}}
        <div class="table-responsive income-table-wrapper">

            <table class="table income-table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="income-number-column">#</th>
                        <th>INCOME DETAILS</th>
                        <th>AMOUNT</th>
                        <th>INCOME DATE</th>
                        <th>PAYMENT METHOD</th>
                        <th>DESCRIPTION</th>
                        <th class="text-end">ACTIONS</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($incomes as $income)

                        <tr>

                            {{-- Number --}}
                            <td>
                                <span class="income-row-number">
                                    {{ $incomes->firstItem() + $loop->index }}
                                </span>
                            </td>


                            {{-- Income Details --}}
                            <td>
                                <div class="income-detail-cell">

                                    <div class="income-row-icon">
                                        <i class="bi bi-wallet"></i>
                                    </div>

                                    <div class="income-detail-text">
                                        <div class="income-title">
                                            {{ $income->title }}
                                        </div>

                                        <div class="income-reference">
                                            Income ID: #{{ $income->id }}
                                        </div>
                                    </div>

                                </div>
                            </td>


                            {{-- Amount --}}
                            <td>
                                <div class="income-amount">
                                    Rs. {{ number_format((float) $income->amount, 2) }}
                                </div>

                                <div class="income-amount-label">
                                    Income received
                                </div>
                            </td>


                            {{-- Date --}}
                            <td>
                                <div class="income-date">
                                    <i class="bi bi-calendar3 me-2"></i>

                                    {{ $income->income_date
                                        ? \Illuminate\Support\Carbon::parse($income->income_date)->format('d M Y')
                                        : 'N/A' }}
                                </div>
                            </td>


                            {{-- Payment Method --}}
                            <td>
                                @php
                                    $paymentMethod = strtolower((string) $income->payment_method);

                                    $paymentBadgeClass = match ($paymentMethod) {
                                        'cash' => 'payment-cash',
                                        'bank', 'bank transfer', 'bank_transfer' => 'payment-bank',
                                        'card', 'credit card', 'debit card' => 'payment-card',
                                        'cheque', 'check' => 'payment-cheque',
                                        default => 'payment-other',
                                    };
                                @endphp

                                <span class="income-payment-badge {{ $paymentBadgeClass }}">
                                    <span class="payment-dot"></span>
                                    {{ ucfirst(str_replace('_', ' ', $income->payment_method ?? 'Other')) }}
                                </span>
                            </td>


                            {{-- Description --}}
                            <td>
                                <div class="income-description"
                                     title="{{ $income->description }}">
                                    {{ $income->description ?: 'No description provided' }}
                                </div>
                            </td>


                            {{-- Actions --}}
                            <td class="text-end">

                                <div class="income-actions">

                                    <a
                                        href="{{ route('incomes.show', $income) }}"
                                        class="income-action-btn view"
                                        title="View income"
                                        aria-label="View income"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a
                                        href="{{ route('incomes.edit', $income) }}"
                                        class="income-action-btn edit"
                                        title="Edit income"
                                        aria-label="Edit income"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form
                                        action="{{ route('incomes.destroy', $income) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this income record?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="income-action-btn delete"
                                            title="Delete income"
                                            aria-label="Delete income"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7">

                                <div class="income-empty-state">

                                    <div class="income-empty-icon">
                                        <i class="bi bi-wallet2"></i>
                                    </div>

                                    <h5 class="fw-bold mt-3 mb-2">
                                        No Income Records Found
                                    </h5>

                                    <p class="text-muted mb-3">
                                        @if(filled($search))
                                            No records match your search. Try another keyword.
                                        @else
                                            You haven't added any income records yet.
                                        @endif
                                    </p>

                                    @if(filled($search))

                                        <a href="{{ route('incomes.index') }}"
                                           class="btn btn-light border">
                                            <i class="bi bi-arrow-counterclockwise me-2"></i>
                                            Clear Search
                                        </a>

                                    @else

                                        <a href="{{ route('incomes.create') }}"
                                           class="btn btn-success">
                                            <i class="bi bi-plus-lg me-2"></i>
                                            Add First Income
                                        </a>

                                    @endif

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Footer / Pagination --}}
        @if($incomes->hasPages() || $incomes->total() > 0)

            <div class="income-card-footer">

                <div class="income-pagination-info">
                    @if($incomes->total() > 0)
                        Showing
                        <strong>{{ $incomes->firstItem() }}</strong>
                        to
                        <strong>{{ $incomes->lastItem() }}</strong>
                        of
                        <strong>{{ $incomes->total() }}</strong>
                        records
                    @else
                        No records to display
                    @endif
                </div>

                <div class="income-pagination">
                    {{ $incomes->appends(request()->query())->links() }}
                </div>

            </div>

        @endif

    </div>


    {{-- Helpful Note --}}
    <div class="income-bottom-note mt-3">
        <i class="bi bi-info-circle me-2"></i>
        Keep income entries accurate so your financial reports remain reliable.
    </div>

</div>


<style>
.income-page {
    --income-green: #059669;
    --income-green-dark: #047857;
    --income-text: #172033;
    --income-muted: #718096;
    --income-border: #e8edf4;
    color: var(--income-text);
}

.income-eyebrow {
    letter-spacing: 1.2px;
}

.income-header-icon {
    display: inline-flex;
    width: 43px;
    height: 43px;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #dcfce7;
    color: #047857;
    font-size: 22px;
}

.income-add-btn {
    min-height: 45px;
    padding: 11px 19px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 0;
    border-radius: 10px;
    background: var(--income-green);
    box-shadow: 0 5px 12px rgba(5, 150, 105, .14);
    font-weight: 700;
    transition: all .2s ease;
}

.income-add-btn:hover {
    background: var(--income-green-dark);
    transform: translateY(-1px);
}

.income-alert {
    border: 0;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(15, 23, 42, .04);
}

.income-stat-card {
    display: flex;
    align-items: center;
    gap: 16px;
    height: 100%;
    min-height: 125px;
    padding: 21px;
    border: 1px solid var(--income-border);
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 4px 15px rgba(15, 23, 42, .025);
    transition: transform .2s ease, box-shadow .2s ease;
}

.income-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 9px 22px rgba(15, 23, 42, .06);
}

.income-stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 53px;
    width: 53px;
    height: 53px;
    border-radius: 13px;
    font-size: 23px;
}

.income-stat-icon.green {
    background: #dcfce7;
    color: #15803d;
}

.income-stat-icon.blue {
    background: #dbeafe;
    color: #2563eb;
}

.income-stat-icon.purple {
    background: #ede9fe;
    color: #7c3aed;
}

.income-stat-label {
    margin-bottom: 5px;
    color: var(--income-muted);
    font-size: 12px;
    font-weight: 600;
}

.income-stat-value {
    margin-bottom: 4px;
    font-size: 25px;
    font-weight: 800;
    letter-spacing: -.5px;
}

.income-stat-note {
    color: #94a3b8;
    font-size: 11px;
}

.income-main-card {
    overflow: hidden;
    border: 1px solid var(--income-border);
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 6px 25px rgba(15, 23, 42, .035);
}

.income-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 24px 25px;
    border-bottom: 1px solid var(--income-border);
}

.income-card-header h5 {
    font-size: 17px;
}

.income-record-badge {
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    padding: 8px 12px;
    border: 1px solid #d1fae5;
    border-radius: 8px;
    background: #ecfdf5;
    color: #047857;
    font-size: 12px;
    font-weight: 700;
}

.income-search-section {
    padding: 20px 25px;
    border-bottom: 1px solid var(--income-border);
    background: #fcfdff;
}

.income-search-form {
    display: flex;
    align-items: center;
    gap: 10px;
}

.income-search-input {
    position: relative;
    flex: 1;
    min-width: 0;
}

.income-search-input > i {
    position: absolute;
    top: 50%;
    left: 15px;
    z-index: 2;
    transform: translateY(-50%);
    color: #94a3b8;
}

.income-search-input .form-control {
    min-height: 45px;
    padding-left: 43px;
    padding-right: 40px;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    background: #fff;
    font-size: 13px;
    box-shadow: none;
}

.income-search-input .form-control:focus {
    border-color: #6ee7b7;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, .09);
}

.income-clear-search {
    position: absolute;
    top: 50%;
    right: 13px;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 16px;
}

.income-clear-search:hover {
    color: #dc2626;
}

.income-search-btn,
.income-reset-btn {
    min-height: 45px;
    padding: 10px 17px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
}

.income-search-btn {
    background: #4f46e5;
    border-color: #4f46e5;
}

.income-search-btn:hover {
    background: #4338ca;
    border-color: #4338ca;
}

.income-reset-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.income-table-wrapper {
    width: 100%;
}

.income-table {
    min-width: 1050px;
}

.income-table thead th {
    padding: 16px 15px;
    background: #f8fafc;
    border-bottom: 1px solid var(--income-border);
    color: #64748b;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .7px;
    white-space: nowrap;
}

.income-table tbody td {
    padding: 17px 15px;
    border-bottom: 1px solid #edf1f6;
    font-size: 13px;
}

.income-table tbody tr:last-child td {
    border-bottom: 0;
}

.income-table tbody tr {
    transition: background .15s ease;
}

.income-table tbody tr:hover {
    background: #fbfdfc;
}

.income-number-column {
    width: 55px;
}

.income-row-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 29px;
    height: 29px;
    padding: 0 6px;
    border-radius: 7px;
    background: #f1f5f9;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
}

.income-detail-cell {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 180px;
}

.income-row-icon {
    display: flex;
    flex: 0 0 41px;
    width: 41px;
    height: 41px;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    background: #dcfce7;
    color: #15803d;
    font-size: 19px;
}

.income-detail-text {
    min-width: 0;
}

.income-title {
    max-width: 230px;
    overflow-wrap: anywhere;
    color: #1e293b;
    font-weight: 700;
}

.income-reference {
    margin-top: 4px;
    color: #94a3b8;
    font-size: 11px;
}

.income-amount {
    color: #059669;
    font-weight: 800;
    white-space: nowrap;
}

.income-amount-label {
    margin-top: 4px;
    color: #94a3b8;
    font-size: 10px;
}

.income-date {
    display: inline-flex;
    align-items: center;
    color: #475569;
    white-space: nowrap;
    font-size: 12px;
}

.income-date i {
    color: #94a3b8;
}

.income-payment-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 10px;
    border-radius: 7px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.payment-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

.payment-cash {
    background: #dcfce7;
    color: #166534;
}

.payment-bank {
    background: #dbeafe;
    color: #1d4ed8;
}

.payment-card {
    background: #ede9fe;
    color: #6d28d9;
}

.payment-cheque {
    background: #fef3c7;
    color: #92400e;
}

.payment-other {
    background: #f1f5f9;
    color: #475569;
}

.income-description {
    max-width: 200px;
    overflow: hidden;
    color: #64748b;
    font-size: 12px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.income-actions {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.income-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    padding: 0;
    border: 1px solid transparent;
    border-radius: 8px;
    background: #fff;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    transition: all .18s ease;
}

.income-action-btn.view {
    border-color: #bae6fd;
    background: #f0f9ff;
    color: #0284c7;
}

.income-action-btn.view:hover {
    border-color: #0284c7;
    background: #0284c7;
    color: #fff;
}

.income-action-btn.edit {
    border-color: #c7d2fe;
    background: #eef2ff;
    color: #4f46e5;
}

.income-action-btn.edit:hover {
    border-color: #4f46e5;
    background: #4f46e5;
    color: #fff;
}

.income-action-btn.delete {
    border-color: #fecaca;
    background: #fef2f2;
    color: #dc2626;
}

.income-action-btn.delete:hover {
    border-color: #dc2626;
    background: #dc2626;
    color: #fff;
}

.income-empty-state {
    padding: 55px 20px;
    text-align: center;
}

.income-empty-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 75px;
    height: 75px;
    border-radius: 22px;
    background: #ecfdf5;
    color: #059669;
    font-size: 31px;
}

.income-empty-state p {
    max-width: 400px;
    margin-right: auto;
    margin-left: auto;
    font-size: 13px;
}

.income-empty-state .btn {
    border-radius: 9px;
    font-weight: 600;
}

.income-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
    padding: 19px 25px;
    border-top: 1px solid var(--income-border);
    background: #fcfdff;
}

.income-pagination-info {
    color: #64748b;
    font-size: 12px;
}

.income-pagination-info strong {
    color: #334155;
}

.income-pagination nav {
    display: flex;
    justify-content: flex-end;
}

.income-pagination .pagination {
    margin-bottom: 0;
    gap: 4px;
}

.income-pagination .page-link {
    border-radius: 7px !important;
    border-color: #e2e8f0;
    color: #475569;
    font-size: 12px;
    box-shadow: none;
}

.income-pagination .page-item.active .page-link {
    background: #059669;
    border-color: #059669;
    color: #fff;
}

.income-bottom-note {
    display: flex;
    align-items: center;
    color: #94a3b8;
    font-size: 12px;
}


/* Responsive */
@media (max-width: 767.98px) {

    .income-card-header {
        align-items: flex-start;
        flex-direction: column;
        padding: 19px;
    }

    .income-search-section {
        padding: 16px;
    }

    .income-search-form {
        align-items: stretch;
        flex-wrap: wrap;
    }

    .income-search-input {
        flex: 1 1 100%;
    }

    .income-search-btn,
    .income-reset-btn {
        flex: 1;
        justify-content: center;
    }

    .income-card-footer {
        align-items: flex-start;
        flex-direction: column;
        padding: 18px;
    }

    .income-pagination {
        width: 100%;
        overflow-x: auto;
    }

    .income-pagination nav {
        justify-content: flex-start;
    }

    .income-stat-card {
        padding: 17px;
    }

    .income-stat-value {
        font-size: 23px;
    }
}
</style>

@endsection

