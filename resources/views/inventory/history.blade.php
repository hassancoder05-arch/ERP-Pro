@extends('layouts.app')

@section('title', 'Stock History')

@section('content')

<div class="container-fluid py-4 stock-history-page">


{{-- Page Header --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="header-icon">
                <i class="bi bi-clock-history"></i>
            </span>

            <span class="text-uppercase small fw-semibold text-primary">
                Inventory Management
            </span>
        </div>

        <h2 class="fw-bold mb-1">Stock History</h2>

        <p class="text-muted mb-0">
            Track stock movements, quantity changes and inventory transactions.
        </p>
    </div>

    <a href="{{ route('inventory.create') }}" class="btn btn-primary px-4">
        <i class="bi bi-plus-lg me-2"></i>
        New Transaction
    </a>

</div>

{{-- Summary Cards --}}
<div class="row g-3 mb-4">

    <div class="col-sm-6 col-xl-3">
        <div class="summary-card">
            <div class="summary-icon icon-blue">
                <i class="bi bi-receipt"></i>
            </div>

            <div>
                <span class="summary-label">Transactions Listed</span>
                <h4 class="summary-value mb-0">
                    {{ $transactions->count() }}
                </h4>
                <small class="summary-hint">Current page records</small>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="summary-card">
            <div class="summary-icon icon-green">
                <i class="bi bi-box-arrow-in-down"></i>
            </div>

            <div>
                <span class="summary-label">Stock In</span>
                <h4 class="summary-value mb-0">
                    {{ $transactions->where('type', 'stock_in')->count() }}
                </h4>
                <small class="summary-hint">Incoming transactions on this page</small>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="summary-card">
            <div class="summary-icon icon-red">
                <i class="bi bi-box-arrow-up"></i>
            </div>

            <div>
                <span class="summary-label">Stock Out</span>
                <h4 class="summary-value mb-0">
                    {{ $transactions->where('type', 'stock_out')->count() }}
                </h4>
                <small class="summary-hint">Outgoing transactions on this page</small>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="summary-card">
            <div class="summary-icon icon-orange">
                <i class="bi bi-sliders"></i>
            </div>

            <div>
                <span class="summary-label">Adjustments</span>
                <h4 class="summary-value mb-0">
                    {{ $transactions->filter(function ($transaction) {
                        return !in_array($transaction->type, ['stock_in', 'stock_out']);
                    })->count() }}
                </h4>
                <small class="summary-hint">Other transaction types on this page</small>
            </div>
        </div>
    </div>

</div>

{{-- Transaction History Table --}}
<div class="history-card">

    <div class="history-card-header d-flex flex-wrap justify-content-between align-items-center gap-3">

        <div class="d-flex align-items-center gap-3">

            <div class="table-heading-icon">
                <i class="bi bi-list-ul"></i>
            </div>

            <div>
                <h5 class="fw-bold mb-1">Transaction History</h5>

                <p class="text-muted small mb-0">
                    Inventory movements recorded in the system
                </p>
            </div>

        </div>

        <span class="record-count">
            <i class="bi bi-database me-1"></i>
            {{ $transactions->total() }} total records
        </span>

    </div>

    <div class="table-responsive">

        <table class="table align-middle mb-0 history-table">

            <thead>
                <tr>
                    <th class="ps-4">Date & Time</th>
                    <th>Product</th>
                    <th>Transaction Type</th>
                    <th>Quantity</th>
                    <th>Before</th>
                    <th>After</th>
                    <th>Reference</th>
                    <th>Notes</th>
                </tr>
            </thead>

            <tbody>

                @forelse($transactions as $transaction)

                    <tr>

                        {{-- Date --}}
                        <td class="ps-4">
                            <div class="date-value">
                                {{ $transaction->created_at?->format('d M Y') ?? '—' }}
                            </div>

                            <small class="time-value">
                                <i class="bi bi-clock me-1"></i>
                                {{ $transaction->created_at?->format('h:i A') ?? '—' }}
                            </small>
                        </td>

                        {{-- Product --}}
                        <td>
                            @if($transaction->product)
                                <div class="product-cell">

                                    <div class="product-icon">
                                        <i class="bi bi-box-seam"></i>
                                    </div>

                                    <div class="product-info">
                                        <span class="product-name">
                                            {{ $transaction->product->name }}
                                        </span>

                                        <small class="product-code">
                                            {{ $transaction->product->product_code ?: 'No product code' }}
                                        </small>
                                    </div>

                                </div>
                            @else
                                <span class="text-muted small">
                                    Product unavailable
                                </span>
                            @endif
                        </td>

                        {{-- Transaction Type --}}
                        <td>
                            @if($transaction->type === 'stock_in')

                                <span class="transaction-badge badge-stock-in">
                                    <i class="bi bi-arrow-down-circle-fill"></i>
                                    Stock In
                                </span>

                            @elseif($transaction->type === 'stock_out')

                                <span class="transaction-badge badge-stock-out">
                                    <i class="bi bi-arrow-up-circle-fill"></i>
                                    Stock Out
                                </span>

                            @else

                                <span class="transaction-badge badge-adjustment">
                                    <i class="bi bi-sliders"></i>
                                    {{ ucwords(str_replace('_', ' ', $transaction->type ?? 'Adjustment')) }}
                                </span>

                            @endif
                        </td>

                        {{-- Quantity --}}
                        <td>
                            <span class="quantity-value">
                                {{ number_format((float) $transaction->quantity) }}
                            </span>
                        </td>

                        {{-- Before --}}
                        <td>
                            <span class="stock-before">
                                {{ number_format((float) $transaction->stock_before) }}
                            </span>
                        </td>

                        {{-- After --}}
                        <td>
                            <span class="stock-after">
                                {{ number_format((float) $transaction->stock_after) }}
                            </span>
                        </td>

                        {{-- Reference --}}
                        <td>
                            @if($transaction->reference)
                                <span class="reference-value" title="{{ $transaction->reference }}">
                                    {{ $transaction->reference }}
                                </span>
                            @else
                                <span class="empty-value">—</span>
                            @endif
                        </td>

                        {{-- Notes --}}
                        <td>
                            @if($transaction->notes)
                                <span class="notes-value" title="{{ $transaction->notes }}">
                                    {{ $transaction->notes }}
                                </span>
                            @else
                                <span class="empty-value">—</span>
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="empty-table-cell">

                            <div class="empty-state">

                                <div class="empty-state-icon">
                                    <i class="bi bi-clock-history"></i>
                                </div>

                                <h5>No Inventory Transactions</h5>

                                <p>
                                    No stock movements have been recorded yet.
                                    Create your first transaction to see it here.
                                </p>

                                <a href="{{ route('inventory.create') }}" class="btn btn-primary mt-2">
                                    <i class="bi bi-plus-lg me-1"></i>
                                    Create Transaction
                                </a>

                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Table Footer --}}
    @if($transactions->hasPages() || $transactions->total() > 0)

        <div class="history-card-footer d-flex flex-wrap justify-content-between align-items-center gap-3">

            <div class="pagination-info">
                Showing
                <strong>{{ $transactions->firstItem() ?? 0 }}</strong>
                to
                <strong>{{ $transactions->lastItem() ?? 0 }}</strong>
                of
                <strong>{{ $transactions->total() }}</strong>
                transactions
            </div>

            @if($transactions->hasPages())
                <div class="pagination-wrapper">
                    {{ $transactions->links() }}
                </div>
            @endif

        </div>

    @endif

</div>

{{-- Information Note --}}
<div class="history-note mt-4">
    <div class="history-note-icon">
        <i class="bi bi-info-circle"></i>
    </div>

    <div>
        <strong>Inventory Audit Trail</strong>

        <p class="mb-0">
            Each transaction records the stock movement, quantity before and after the change,
            and its reference where available.
        </p>
    </div>
</div>


</div>

<style>
.stock-history-page {
    --history-primary: #4f46e5;
    --history-text: #172033;
    --history-muted: #718096;
    --history-border: #e8edf4;
    color: var(--history-text);
}

.stock-history-page .header-icon {
    width: 39px;
    height: 39px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    color: var(--history-primary);
    background: #eef2ff;
    font-size: 20px;
}

.stock-history-page h2 {
    color: var(--history-text);
    font-size: clamp(1.5rem, 2vw, 1.9rem);
    letter-spacing: -.6px;
}

.stock-history-page .btn {
    padding-top: 10px;
    padding-bottom: 10px;
    border-radius: 10px;
    font-weight: 600;
    transition: all .2s ease;
}

.stock-history-page .btn-primary {
    background: var(--history-primary);
    border-color: var(--history-primary);
    box-shadow: 0 4px 12px rgba(79, 70, 229, .13);
}

.stock-history-page .btn-primary:hover {
    background: #4338ca;
    border-color: #4338ca;
    transform: translateY(-1px);
}

.stock-history-page .summary-card {
    display: flex;
    align-items: center;
    gap: 15px;
    height: 100%;
    min-height: 112px;
    padding: 19px;
    border: 1px solid var(--history-border);
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 4px 16px rgba(15, 23, 42, .025);
}

.stock-history-page .summary-icon {
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    font-size: 21px;
}

.stock-history-page .icon-blue {
    color: #2563eb;
    background: #eaf2ff;
}

.stock-history-page .icon-green {
    color: #15803d;
    background: #e6f8ef;
}

.stock-history-page .icon-red {
    color: #dc2626;
    background: #fee2e2;
}

.stock-history-page .icon-orange {
    color: #c2410c;
    background: #fff0df;
}

.stock-history-page .summary-label {
    display: block;
    margin-bottom: 5px;
    color: var(--history-muted);
    font-size: 11px;
    font-weight: 650;
}

.stock-history-page .summary-value {
    font-size: 23px;
    font-weight: 800;
    color: var(--history-text);
}

.stock-history-page .summary-hint {
    display: block;
    margin-top: 5px;
    color: #94a3b8;
    font-size: 10px;
}

.stock-history-page .history-card {
    overflow: hidden;
    border: 1px solid var(--history-border);
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 5px 20px rgba(15, 23, 42, .035);
}

.stock-history-page .history-card-header {
    padding: 21px 24px;
    border-bottom: 1px solid var(--history-border);
}

.stock-history-page .table-heading-icon {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 12px;
    color: var(--history-primary);
    background: #eef2ff;
    font-size: 20px;
}

.stock-history-page .history-card-header h5 {
    font-size: 16px;
}

.stock-history-page .history-card-header p {
    font-size: 12px;
}

.stock-history-page .record-count {
    display: inline-block;
    padding: 8px 12px;
    border: 1px solid #e0e7ff;
    border-radius: 9px;
    color: #4338ca;
    background: #eef2ff;
    font-size: 11px;
    font-weight: 700;
}

.stock-history-page .history-table {
    min-width: 1150px;
}

.stock-history-page .history-table thead th {
    padding: 15px 13px;
    border-bottom: 1px solid var(--history-border);
    background: #f8fafc;
    color: #64748b;
    font-size: 10px;
    font-weight: 750;
    letter-spacing: .45px;
    text-transform: uppercase;
    white-space: nowrap;
}

.stock-history-page .history-table tbody td {
    padding: 17px 13px;
    border-bottom: 1px solid #f1f5f9;
    color: var(--history-text);
    font-size: 12px;
    vertical-align: middle;
}

.stock-history-page .history-table tbody tr:last-child td {
    border-bottom: 0;
}

.stock-history-page .history-table tbody tr {
    transition: background .15s ease;
}

.stock-history-page .history-table tbody tr:hover {
    background: #fafbff;
}

.stock-history-page .date-value {
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.stock-history-page .time-value {
    display: block;
    margin-top: 5px;
    color: #94a3b8;
    font-size: 10px;
    white-space: nowrap;
}

.stock-history-page .product-cell {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 165px;
}

.stock-history-page .product-icon {
    width: 37px;
    height: 37px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e0e7ff;
    border-radius: 10px;
    color: var(--history-primary);
    background: #eef2ff;
    font-size: 16px;
}

.stock-history-page .product-info {
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.stock-history-page .product-name {
    max-width: 190px;
    color: var(--history-text);
    font-size: 12px;
    font-weight: 750;
    overflow-wrap: anywhere;
}

.stock-history-page .product-code {
    color: #94a3b8;
    font-size: 10px;
    overflow-wrap: anywhere;
}

.stock-history-page .transaction-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 10px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 750;
    white-space: nowrap;
}

.stock-history-page .badge-stock-in {
    color: #15803d;
    background: #dcfce7;
}

.stock-history-page .badge-stock-out {
    color: #b91c1c;
    background: #fee2e2;
}

.stock-history-page .badge-adjustment {
    color: #a16207;
    background: #fef3c7;
}

.stock-history-page .quantity-value {
    display: inline-block;
    min-width: 30px;
    color: var(--history-text);
    font-size: 13px;
    font-weight: 800;
}

.stock-history-page .stock-before,
.stock-history-page .stock-after {
    display: inline-block;
    min-width: 25px;
    font-size: 12px;
    font-weight: 650;
}

.stock-history-page .stock-before {
    color: #64748b;
}

.stock-history-page .stock-after {
    color: #15803d;
}

.stock-history-page .reference-value {
    display: inline-block;
    max-width: 145px;
    padding: 5px 7px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    color: #475569;
    background: #f8fafc;
    font-size: 10px;
    overflow-wrap: anywhere;
}

.stock-history-page .notes-value {
    display: inline-block;
    max-width: 160px;
    color: #64748b;
    font-size: 11px;
    overflow-wrap: anywhere;
}

.stock-history-page .empty-value {
    color: #cbd5e1;
    font-size: 17px;
}

.stock-history-page .empty-table-cell {
    padding: 0 !important;
}

.stock-history-page .empty-state {
    max-width: 420px;
    margin: 0 auto;
    padding: 55px 20px;
    text-align: center;
}

.stock-history-page .empty-state-icon {
    width: 75px;
    height: 75px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    border: 1px solid #e0e7ff;
    border-radius: 23px;
    color: var(--history-primary);
    background: #eef2ff;
    font-size: 32px;
}

.stock-history-page .empty-state h5 {
    margin-bottom: 10px;
    font-size: 17px;
    font-weight: 750;
}

.stock-history-page .empty-state p {
    margin-bottom: 10px;
    color: var(--history-muted);
    font-size: 12px;
    line-height: 1.8;
}

.stock-history-page .history-card-footer {
    padding: 17px 24px;
    border-top: 1px solid var(--history-border);
    background: #fff;
}

.stock-history-page .pagination-info {
    color: var(--history-muted);
    font-size: 11px;
}

.stock-history-page .pagination-info strong {
    color: var(--history-text);
}

.stock-history-page .pagination-wrapper nav {
    margin-bottom: 0;
}

.stock-history-page .pagination-wrapper nav > div:first-child {
    display: none;
}

.stock-history-page .pagination-wrapper .pagination {
    flex-wrap: wrap;
    gap: 5px;
    margin-bottom: 0;
}

.stock-history-page .pagination-wrapper .page-link {
    border: 1px solid var(--history-border);
    border-radius: 8px;
    color: #475569;
    font-size: 11px;
}

.stock-history-page .pagination-wrapper .page-item.active .page-link {
    border-color: var(--history-primary);
    color: #fff;
    background: var(--history-primary);
}

.stock-history-page .history-note {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    padding: 17px 19px;
    border: 1px solid #dbeafe;
    border-radius: 13px;
    background: #eff6ff;
}

.stock-history-page .history-note-icon {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 10px;
    color: #2563eb;
    background: #dbeafe;
    font-size: 16px;
}

.stock-history-page .history-note strong {
    display: block;
    margin-bottom: 5px;
    color: #1e40af;
    font-size: 12px;
}

.stock-history-page .history-note p {
    color: #475569;
    font-size: 11px;
    line-height: 1.7;
}

@media (max-width: 767.98px) {
    .stock-history-page .history-card-header {
        padding: 17px;
    }

    .stock-history-page .history-card-footer {
        padding: 17px;
    }

    .stock-history-page .summary-card {
        padding: 15px;
    }

    .stock-history-page .summary-value {
        font-size: 20px;
    }

    .stock-history-page .record-count {
        margin-left: 0;
    }
}
</style>

@endsection
