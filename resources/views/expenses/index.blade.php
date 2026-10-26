
@extends('layouts.app')

@section('title', 'Expenses Management')

@section('content')

<div class="container-fluid expenses-page py-3">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div class="d-flex align-items-center gap-3">

            <div class="expenses-header-icon">
                <i class="bi bi-wallet2"></i>
            </div>

            <div>
                <h2 class="fw-bold mb-1">Expenses Management</h2>
                <p class="text-muted mb-0">
                    Track, review and manage your business expenses.
                </p>
            </div>

        </div>

        <a href="{{ route('expenses.create') }}" class="btn btn-danger add-expense-btn">
            <i class="bi bi-plus-lg me-2"></i>
            Add New Expense
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show custom-success-alert mb-4" role="alert">

            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <span>{{ session('success') }}</span>
            </div>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>

        </div>

    @endif


    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-4">

            <div class="expense-stat-card">

                <div class="stat-icon stat-icon-red">
                    <i class="bi bi-receipt"></i>
                </div>

                <div class="stat-content">
                    <span>Total Records</span>

                    <h3>{{ $expenses->total() }}</h3>

                    <small>
                        <i class="bi bi-list-check me-1"></i>
                        Matching expense records
                    </small>
                </div>

            </div>

        </div>


        <div class="col-sm-6 col-xl-4">

            <div class="expense-stat-card">

                <div class="stat-icon stat-icon-blue">
                    <i class="bi bi-search"></i>
                </div>

                <div class="stat-content">
                    <span>Current Page</span>

                    <h3>
                        {{ $expenses->count() }}
                    </h3>

                    <small>
                        <i class="bi bi-file-earmark-text me-1"></i>
                        Records displayed
                    </small>
                </div>

            </div>

        </div>


        <div class="col-sm-12 col-xl-4">

            <div class="expense-stat-card">

                <div class="stat-icon stat-icon-purple">
                    <i class="bi bi-funnel"></i>
                </div>

                <div class="stat-content">
                    <span>Search Status</span>

                    <h3 class="stat-status">
                        {{ filled($search) ? 'Filtered' : 'All Records' }}
                    </h3>

                    <small>
                        <i class="bi bi-filter me-1"></i>
                        {{ filled($search) ? 'Search results are active' : 'Showing available expenses' }}
                    </small>
                </div>

            </div>

        </div>

    </div>


    {{-- Main Table Card --}}
    <div class="card expenses-table-card border-0">

        {{-- Card Header --}}
        <div class="card-header expenses-card-header bg-white border-0">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-list-ul me-2 text-danger"></i>
                        All Expenses
                    </h5>

                    <p class="text-muted small mb-0">
                        Search and manage recorded business expenses.
                    </p>
                </div>

                <span class="records-badge">
                    <i class="bi bi-database me-1"></i>
                    {{ $expenses->total() }} Records
                </span>

            </div>

        </div>


        <div class="card-body p-4">


            {{-- Search Form --}}
            <form method="GET"
                  action="{{ route('expenses.index') }}"
                  class="expense-search-form mb-4">

                <div class="row g-3 align-items-end">

                    <div class="col-lg-8">

                        <label for="expenseSearch" class="form-label search-label">
                            Search Expenses
                        </label>

                        <div class="search-input-wrapper">

                            <i class="bi bi-search"></i>

                            <input type="text"
                                   id="expenseSearch"
                                   name="search"
                                   class="form-control"
                                   value="{{ $search }}"
                                   placeholder="Search by title, category or payment method..."
                                   autocomplete="off">

                            @if(filled($search))
                                <a href="{{ route('expenses.index') }}"
                                   class="clear-search"
                                   title="Clear search"
                                   aria-label="Clear search">
                                    <i class="bi bi-x-circle-fill"></i>
                                </a>
                            @endif

                        </div>

                    </div>


                    <div class="col-lg-4">

                        <div class="d-flex flex-wrap gap-2 search-actions">

                            <button type="submit" class="btn btn-primary search-btn">
                                <i class="bi bi-search me-2"></i>
                                Search
                            </button>

                            <a href="{{ route('expenses.index') }}"
                               class="btn btn-light border reset-btn">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Reset
                            </a>

                        </div>

                    </div>

                </div>

                @if(filled($search))
                    <div class="active-search-info mt-3">
                        <i class="bi bi-funnel-fill me-1"></i>
                        Search results for:
                        <strong>{{ $search }}</strong>
                    </div>
                @endif

            </form>


            {{-- Table Toolbar --}}
            <div class="table-toolbar d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">

                <div class="text-muted small">
                    Showing
                    <strong>{{ $expenses->firstItem() ?? 0 }}</strong>
                    to
                    <strong>{{ $expenses->lastItem() ?? 0 }}</strong>
                    of
                    <strong>{{ $expenses->total() }}</strong>
                    expenses
                </div>

                <div class="table-toolbar-label">
                    <i class="bi bi-arrow-down-up me-1"></i>
                    Expense Records
                </div>

            </div>


            {{-- Expenses Table --}}
            <div class="table-responsive expenses-table-wrapper">

                <table class="table expenses-table align-middle mb-0">

                    <thead>

                        <tr>
                            <th class="number-column">#</th>
                            <th>Expense Details</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Payment Method</th>
                            <th class="text-end actions-column">Actions</th>
                        </tr>

                    </thead>


                    <tbody>

                    @forelse($expenses as $expense)

                        <tr>

                            {{-- Number --}}
                            <td>
                                <span class="row-number">
                                    {{ $expenses->firstItem() + $loop->index }}
                                </span>
                            </td>


                            {{-- Expense Details --}}
                            <td>

                                <div class="expense-details-cell">

                                    <div class="expense-title-icon">
                                        <i class="bi bi-receipt-cutoff"></i>
                                    </div>

                                    <div class="expense-title-content">

                                        <strong>
                                            {{ $expense->title ?: 'Untitled Expense' }}
                                        </strong>

                                        <small>
                                            Expense #{{ $expense->id }}
                                        </small>

                                    </div>

                                </div>

                            </td>


                            {{-- Category --}}
                            <td>

                                <span class="category-badge">
                                    <i class="bi bi-tag-fill me-1"></i>

                                    {{ $expense->category->name ?? 'Uncategorized' }}
                                </span>

                            </td>


                            {{-- Amount --}}
                            <td>

                                <div class="expense-amount">
                                    <span class="currency-small">PKR</span>

                                    Rs. {{ number_format((float) $expense->amount, 2) }}
                                </div>

                            </td>


                            {{-- Date --}}
                            <td>

                                <div class="expense-date">

                                    <i class="bi bi-calendar3 me-2"></i>

                                    {{ $expense->expense_date
                                        ? \Illuminate\Support\Carbon::parse($expense->expense_date)->format('d M Y')
                                        : '—' }}

                                </div>

                            </td>


                            {{-- Payment Method --}}
                            <td>

                                @php
                                    $paymentMethod = strtolower($expense->payment_method ?? 'other');
                                @endphp

                                <span class="payment-badge
                                    {{ $paymentMethod === 'cash' ? 'payment-cash' : '' }}
                                    {{ $paymentMethod === 'bank' ? 'payment-bank' : '' }}
                                    {{ !in_array($paymentMethod, ['cash', 'bank']) ? 'payment-other' : '' }}">

                                    <i class="bi
                                        {{ $paymentMethod === 'cash' ? 'bi-cash-stack' : '' }}
                                        {{ $paymentMethod === 'bank' ? 'bi-bank' : '' }}
                                        {{ !in_array($paymentMethod, ['cash', 'bank']) ? 'bi-wallet2' : '' }} me-1"></i>

                                    {{ $expense->payment_method
                                        ? ucfirst($expense->payment_method)
                                        : 'Other' }}

                                </span>

                            </td>


                            {{-- Actions --}}
                            <td>

                                <div class="d-flex justify-content-end align-items-center gap-1 expense-actions">

                                    <a href="{{ route('expenses.show', $expense) }}"
                                       class="table-action-btn view-action"
                                       title="View Expense"
                                       aria-label="View Expense">

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    <a href="{{ route('expenses.edit', $expense) }}"
                                       class="table-action-btn edit-action"
                                       title="Edit Expense"
                                       aria-label="Edit Expense">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>


                                    <form action="{{ route('expenses.destroy', $expense) }}"
                                          method="POST"
                                          class="d-inline delete-expense-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="table-action-btn delete-action"
                                                title="Delete Expense"
                                                aria-label="Delete Expense">

                                            <i class="bi bi-trash3"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7">

                                <div class="empty-state">

                                    <div class="empty-state-icon">
                                        <i class="bi bi-receipt"></i>
                                    </div>

                                    <h5>No Expenses Found</h5>

                                    <p>
                                        @if(filled($search))
                                            No expenses match your search. Try a different keyword.
                                        @else
                                            You have not added any expenses yet.
                                        @endif
                                    </p>

                                    <div class="d-flex justify-content-center flex-wrap gap-2">

                                        @if(filled($search))

                                            <a href="{{ route('expenses.index') }}"
                                               class="btn btn-light border btn-sm">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                                Clear Search
                                            </a>

                                        @endif

                                        <a href="{{ route('expenses.create') }}"
                                           class="btn btn-danger btn-sm">

                                            <i class="bi bi-plus-lg me-1"></i>
                                            Add Expense

                                        </a>

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($expenses->hasPages())

                <div class="pagination-container d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4 pt-3">

                    <p class="text-muted small mb-0">
                        Page {{ $expenses->currentPage() }}
                        of {{ $expenses->lastPage() }}
                    </p>

                    <div class="expense-pagination">
                        {{ $expenses->appends(request()->query())->links() }}
                    </div>

                </div>

            @endif

        </div>

    </div>


    {{-- Footer Note --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-4 px-1">

        <small class="text-muted">
            <i class="bi bi-shield-check me-1"></i>
            Keep your business expense records up to date.
        </small>

        <small class="text-muted">
            Total matching records: {{ $expenses->total() }}
        </small>

    </div>

</div>


{{-- Page Styles --}}
<style>
    .expenses-page {
        color: #172033;
    }

    .expenses-header-icon {
        width: 58px;
        height: 58px;
        min-width: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #dc2626;
        font-size: 26px;
    }

    .expenses-page h2 {
        font-size: clamp(1.4rem, 2.5vw, 1.85rem);
        letter-spacing: -0.6px;
    }

    .add-expense-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 11px 18px;
        border-radius: 11px;
        background: #dc2626;
        border-color: #dc2626;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 5px 12px rgba(220, 38, 38, 0.12);
        transition: all 0.2s ease;
    }

    .add-expense-btn:hover {
        background: #b91c1c;
        border-color: #b91c1c;
        transform: translateY(-2px);
    }

    .custom-success-alert {
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        background: #f0fdf4;
        color: #166534;
        font-size: 13px;
    }

    .expense-stat-card {
        display: flex;
        align-items: center;
        gap: 16px;
        height: 100%;
        padding: 22px;
        border: 1px solid #edf0f5;
        border-radius: 17px;
        background: #fff;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.035);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .expense-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 9px 25px rgba(15, 23, 42, 0.065);
    }

    .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 53px;
        height: 53px;
        min-width: 53px;
        border-radius: 15px;
        font-size: 23px;
    }

    .stat-icon-red {
        background: #fee2e2;
        color: #dc2626;
    }

    .stat-icon-blue {
        background: #dbeafe;
        color: #2563eb;
    }

    .stat-icon-purple {
        background: #ede9fe;
        color: #7c3aed;
    }

    .stat-content {
        min-width: 0;
    }

    .stat-content > span {
        display: block;
        margin-bottom: 5px;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .stat-content h3 {
        margin-bottom: 6px;
        color: #172033;
        font-size: 25px;
        font-weight: 800;
        letter-spacing: -0.5px;
        overflow-wrap: anywhere;
    }

    .stat-content h3.stat-status {
        font-size: 21px;
    }

    .stat-content small {
        color: #94a3b8;
        font-size: 10px;
    }

    .expenses-table-card {
        overflow: hidden;
        border-radius: 19px;
        box-shadow: 0 5px 25px rgba(15, 23, 42, 0.045);
    }

    .expenses-card-header {
        padding: 24px 25px 20px;
    }

    .expenses-card-header h5 {
        font-size: 16px;
    }

    .records-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border: 1px solid #fee2e2;
        border-radius: 9px;
        background: #fff5f5;
        color: #dc2626;
        font-size: 11px;
        font-weight: 700;
    }

    .search-label {
        margin-bottom: 8px;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
    }

    .expense-search-form {
        padding: 20px;
        border: 1px solid #edf0f5;
        border-radius: 14px;
        background: #fafbfe;
    }

    .search-input-wrapper {
        position: relative;
    }

    .search-input-wrapper > i {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
        pointer-events: none;
    }

    .search-input-wrapper .form-control {
        min-height: 46px;
        padding: 11px 43px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #fff;
        font-size: 12px;
        box-shadow: none;
    }

    .search-input-wrapper .form-control:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.09);
    }

    .search-input-wrapper .form-control::placeholder {
        color: #a0aabd;
    }

    .clear-search {
        position: absolute;
        top: 50%;
        right: 13px;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 15px;
        text-decoration: none;
    }

    .clear-search:hover {
        color: #dc2626;
    }

    .search-actions {
        min-height: 46px;
    }

    .search-btn,
    .reset-btn {
        min-height: 44px;
        padding: 10px 17px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
    }

    .search-btn {
        background: #4f46e5;
        border-color: #4f46e5;
    }

    .search-btn:hover {
        background: #4338ca;
        border-color: #4338ca;
    }

    .active-search-info {
        color: #64748b;
        font-size: 11px;
    }

    .active-search-info i {
        color: #6366f1;
    }

    .active-search-info strong {
        color: #334155;
        overflow-wrap: anywhere;
    }

    .table-toolbar-label {
        color: #94a3b8;
        font-size: 11px;
    }

    .expenses-table-wrapper {
        border: 1px solid #edf0f5;
        border-radius: 13px;
    }

    .expenses-table {
        min-width: 1000px;
    }

    .expenses-table thead th {
        padding: 16px 15px;
        border-bottom: 1px solid #e9edf4;
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.45px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .expenses-table tbody td {
        padding: 17px 15px;
        border-bottom: 1px solid #f1f5f9;
        background: #fff;
        font-size: 12px;
    }

    .expenses-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .expenses-table tbody tr {
        transition: background 0.15s ease;
    }

    .expenses-table tbody tr:hover td {
        background: #fcfcff;
    }

    .number-column {
        width: 55px;
    }

    .actions-column {
        min-width: 130px;
    }

    .row-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 9px;
        background: #f1f5f9;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
    }

    .expense-details-cell {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 180px;
    }

    .expense-title-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 39px;
        height: 39px;
        min-width: 39px;
        border-radius: 11px;
        background: #fff1f2;
        color: #dc2626;
        font-size: 17px;
    }

    .expense-title-content {
        display: flex;
        flex-direction: column;
        gap: 5px;
        min-width: 0;
    }

    .expense-title-content strong {
        color: #1e293b;
        font-size: 12px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .expense-title-content small {
        color: #94a3b8;
        font-size: 10px;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        max-width: 180px;
        padding: 7px 9px;
        border: 1px solid #e0e7ff;
        border-radius: 8px;
        background: #eef2ff;
        color: #4338ca;
        font-size: 10px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .expense-amount {
        color: #dc2626;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .currency-small {
        display: block;
        margin-bottom: 3px;
        color: #94a3b8;
        font-size: 9px;
        font-weight: 600;
    }

    .expense-date {
        display: flex;
        align-items: center;
        color: #475569;
        font-size: 11px;
        white-space: nowrap;
    }

    .expense-date i {
        color: #94a3b8;
    }

    .payment-badge {
        display: inline-flex;
        align-items: center;
        padding: 7px 9px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .payment-cash {
        background: #dcfce7;
        color: #15803d;
    }

    .payment-bank {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .payment-other {
        background: #f1f5f9;
        color: #475569;
    }

    .expense-actions {
        white-space: nowrap;
    }

    .table-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 33px;
        height: 33px;
        padding: 0;
        border: 1px solid transparent;
        border-radius: 9px;
        background: #fff;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.18s ease;
        cursor: pointer;
    }

    .view-action {
        border-color: #bae6fd;
        background: #f0f9ff;
        color: #0284c7;
    }

    .view-action:hover {
        border-color: #0284c7;
        background: #0284c7;
        color: #fff;
    }

    .edit-action {
        border-color: #c7d2fe;
        background: #eef2ff;
        color: #4f46e5;
    }

    .edit-action:hover {
        border-color: #4f46e5;
        background: #4f46e5;
        color: #fff;
    }

    .delete-action {
        border-color: #fecaca;
        background: #fff1f2;
        color: #dc2626;
    }

    .delete-action:hover {
        border-color: #dc2626;
        background: #dc2626;
        color: #fff;
    }

    .empty-state {
        padding: 55px 20px;
        text-align: center;
    }

    .empty-state-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        height: 70px;
        margin: 0 auto 18px;
        border-radius: 22px;
        background: #fff1f2;
        color: #dc2626;
        font-size: 30px;
    }

    .empty-state h5 {
        color: #1e293b;
        font-size: 16px;
        font-weight: 800;
    }

    .empty-state p {
        margin: 8px auto 18px;
        max-width: 380px;
        color: #94a3b8;
        font-size: 12px;
        line-height: 1.8;
    }

    .empty-state .btn {
        border-radius: 9px;
        padding: 8px 12px;
        font-weight: 600;
    }

    .pagination-container {
        border-top: 1px solid #f1f5f9;
    }

    .expense-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    .expense-pagination .pagination {
        margin-bottom: 0;
        gap: 4px;
    }

    .expense-pagination .page-link {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #475569;
        font-size: 11px;
        box-shadow: none;
    }

    .expense-pagination .page-item.active .page-link {
        border-color: #4f46e5;
        background: #4f46e5;
        color: #fff;
    }

    @media (max-width: 767.98px) {
        .expenses-page {
            padding-right: 10px;
            padding-left: 10px;
        }

        .expenses-header-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            font-size: 22px;
        }

        .add-expense-btn {
            width: 100%;
        }

        .expenses-card-header {
            padding: 20px;
        }

        .expenses-table-card .card-body {
            padding: 15px !important;
        }

        .expense-search-form {
            padding: 15px;
        }

        .search-actions {
            width: 100%;
        }

        .search-actions > * {
            flex: 1;
        }

        .expense-stat-card {
            padding: 18px;
        }

        .pagination-container {
            align-items: flex-start !important;
        }

        .expense-pagination nav {
            justify-content: flex-start;
        }
    }
</style>


{{-- Delete Confirmation --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-expense-form').forEach(function (form) {

        form.addEventListener('submit', function (event) {

            const confirmed = window.confirm(
                'Are you sure you want to delete this expense? This action cannot be undone.'
            );

            if (!confirmed) {
                event.preventDefault();
            }

        });

    });

});
</script>

@endsection

