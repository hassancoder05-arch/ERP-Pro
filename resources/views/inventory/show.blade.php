@extends('layouts.app')

@section('title', 'Inventory Details')

@section('content')

<div class="container-fluid inventory-details-page py-3">


{{-- Page Header --}}
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">

    <div class="d-flex align-items-center gap-3">

        <div class="id-header-icon">
            <i class="bi bi-box-seam"></i>
        </div>

        <div>
            <div class="id-eyebrow mb-1">INVENTORY MANAGEMENT</div>

            <h2 class="fw-bold mb-1">
                {{ $product->name }}
            </h2>

            <p class="text-muted mb-0">
                View product stock levels and complete transaction history.
            </p>
        </div>

    </div>

    <div class="d-flex flex-wrap gap-2">

        <a
            href="{{ route('inventory.create') }}?product_id={{ $product->id }}"
            class="btn id-btn-primary"
        >
            <i class="bi bi-plus-circle me-2"></i>
            Update Stock
        </a>

        <a
            href="{{ route('inventory.index') }}"
            class="btn id-btn-secondary"
        >
            <i class="bi bi-arrow-left me-2"></i>
            Back to Inventory
        </a>

    </div>

</div>


{{-- Stock Status Alert --}}
@if($product->stock <= $product->minimum_stock)
    <div class="id-stock-alert mb-4">
        <div class="id-alert-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>

        <div class="flex-grow-1">
            <h6 class="fw-bold mb-1">Low Stock Alert</h6>

            <p class="mb-0 small">
                This product has {{ $product->stock }} units remaining.
                The minimum stock level is {{ $product->minimum_stock }} units.
                Consider replenishing inventory.
            </p>
        </div>

        <span class="id-alert-badge">Attention Required</span>
    </div>
@else
    <div class="id-success-alert mb-4">
        <i class="bi bi-check-circle-fill me-2"></i>

        <span>
            <strong>Stock Level Normal:</strong>
            Current inventory is above the minimum stock threshold.
        </span>
    </div>
@endif


{{-- Summary Cards --}}
<div class="row g-3 mb-4">

    {{-- Product Code --}}
    <div class="col-sm-6 col-xl-4">
        <div class="id-summary-card">

            <div class="d-flex justify-content-between align-items-start">

                <div>
                    <div class="id-card-label">Product Code</div>

                    <h4 class="id-card-value mt-2 mb-2">
                        {{ $product->product_code ?: 'N/A' }}
                    </h4>

                    <span class="id-card-subtitle">
                        <i class="bi bi-upc-scan me-1"></i>
                        Product identification
                    </span>
                </div>

                <div class="id-summary-icon id-icon-purple">
                    <i class="bi bi-upc"></i>
                </div>

            </div>

        </div>
    </div>


    {{-- Current Stock --}}
    <div class="col-sm-6 col-xl-4">
        <div class="id-summary-card">

            <div class="d-flex justify-content-between align-items-start">

                <div>
                    <div class="id-card-label">Current Stock</div>

                    <h3 class="id-card-value mt-2 mb-2">
                        {{ number_format((float) $product->stock, 2) }}
                        <span class="id-unit-label">units</span>
                    </h3>

                    @if($product->stock <= $product->minimum_stock)
                        <span class="id-status-badge id-status-low">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Low Stock
                        </span>
                    @else
                        <span class="id-status-badge id-status-normal">
                            <i class="bi bi-check-circle me-1"></i>
                            Stock Healthy
                        </span>
                    @endif
                </div>

                <div class="id-summary-icon id-icon-blue">
                    <i class="bi bi-box-seam"></i>
                </div>

            </div>

        </div>
    </div>


    {{-- Minimum Stock --}}
    <div class="col-sm-6 col-xl-4">
        <div class="id-summary-card">

            <div class="d-flex justify-content-between align-items-start">

                <div>
                    <div class="id-card-label">Minimum Stock</div>

                    <h3 class="id-card-value mt-2 mb-2">
                        {{ number_format((float) $product->minimum_stock, 2) }}
                        <span class="id-unit-label">units</span>
                    </h3>

                    <span class="id-card-subtitle">
                        <i class="bi bi-shield-check me-1"></i>
                        Reorder threshold
                    </span>
                </div>

                <div class="id-summary-icon id-icon-orange">
                    <i class="bi bi-speedometer2"></i>
                </div>

            </div>

        </div>
    </div>

</div>


{{-- Stock Level Overview --}}
<div class="id-panel mb-4">

    <div class="id-panel-header">
        <div>
            <h5 class="fw-bold mb-1">Stock Level Overview</h5>

            <p class="text-muted small mb-0">
                Current quantity compared with the minimum stock threshold.
            </p>
        </div>

        <span class="id-panel-header-icon">
            <i class="bi bi-bar-chart-line"></i>
        </span>
    </div>

    <div class="id-panel-body">

        @php
            $currentStock = max(0, (float) $product->stock);
            $minimumStock = max(0, (float) $product->minimum_stock);

            $stockPercentage = $minimumStock > 0
                ? min(100, ($currentStock / $minimumStock) * 100)
                : ($currentStock > 0 ? 100 : 0);

            $stockIsLow = $currentStock <= $minimumStock;
        @endphp

        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-3">

            <div>
                <div class="id-card-label mb-1">Available Quantity</div>

                <div class="id-overview-quantity">
                    {{ number_format((float) $product->stock, 2) }}
                    <span>units</span>
                </div>
            </div>

            <div class="text-md-end">
                <div class="id-card-label mb-1">Minimum Required</div>

                <div class="fw-bold fs-5">
                    {{ number_format((float) $product->minimum_stock, 2) }}
                    <span class="id-unit-label">units</span>
                </div>
            </div>

        </div>

        <div class="id-progress-track">
            <div
                class="id-progress-bar {{ $stockIsLow ? 'id-progress-low' : 'id-progress-normal' }}"
                role="progressbar"
                style="width: {{ $stockPercentage }}%;"
                aria-valuenow="{{ round($stockPercentage, 2) }}"
                aria-valuemin="0"
                aria-valuemax="100"
                aria-label="Current stock compared with minimum stock"
            ></div>
        </div>

        <div class="d-flex flex-wrap justify-content-between gap-2 mt-3">

            <span class="id-card-subtitle">
                <span class="id-legend-dot {{ $stockIsLow ? 'id-dot-low' : 'id-dot-normal' }}"></span>
                Current stock level
            </span>

            @if($currentStock <= $minimumStock)
                <span class="id-stock-difference id-difference-low">
                    {{ number_format($minimumStock - $currentStock, 2) }} units at or below threshold
                </span>
            @else
                <span class="id-stock-difference id-difference-normal">
                    {{ number_format($currentStock - $minimumStock, 2) }} units above minimum
                </span>
            @endif

        </div>

        <p class="text-muted small mt-3 mb-0">
            <i class="bi bi-info-circle me-1"></i>
            The bar is a visual comparison against the minimum stock level, capped at 100%.
        </p>

    </div>

</div>


{{-- Transaction History --}}
<div class="id-panel">

    <div class="id-panel-header">

        <div>
            <h5 class="fw-bold mb-1">
                <i class="bi bi-clock-history me-2 id-heading-icon"></i>
                Transaction History
            </h5>

            <p class="text-muted small mb-0">
                Review stock movements recorded for this product.
            </p>
        </div>

        <div class="id-history-count">
            <i class="bi bi-list-ul me-1"></i>
            {{ $transactions->total() }} records
        </div>

    </div>


    <div class="table-responsive">

        <table class="table id-history-table align-middle mb-0">

            <thead>
                <tr>
                    <th class="ps-4">DATE & TIME</th>
                    <th>TRANSACTION TYPE</th>
                    <th>QUANTITY</th>
                    <th>STOCK BEFORE</th>
                    <th>STOCK AFTER</th>
                    <th>REFERENCE</th>
                    <th>NOTES</th>
                </tr>
            </thead>

            <tbody>

                @forelse($transactions as $transaction)

                    <tr>

                        {{-- Date --}}
                        <td class="ps-4">

                            <div class="id-date-main">
                                {{ $transaction->created_at?->format('d M Y') ?? '—' }}
                            </div>

                            <div class="id-date-time">
                                <i class="bi bi-clock me-1"></i>
                                {{ $transaction->created_at?->format('h:i A') ?? '—' }}
                            </div>

                        </td>


                        {{-- Type --}}
                        <td>

                            @if($transaction->type === 'stock_in')

                                <span class="id-transaction-badge id-badge-in">
                                    <i class="bi bi-arrow-down-left me-1"></i>
                                    Stock In
                                </span>

                            @elseif($transaction->type === 'stock_out')

                                <span class="id-transaction-badge id-badge-out">
                                    <i class="bi bi-arrow-up-right me-1"></i>
                                    Stock Out
                                </span>

                            @else

                                <span class="id-transaction-badge id-badge-adjust">
                                    <i class="bi bi-sliders me-1"></i>
                                    Adjustment
                                </span>

                            @endif

                        </td>


                        {{-- Quantity --}}
                        <td>

                            @if($transaction->type === 'stock_in')
                                <span class="id-quantity-in">
                                    +{{ number_format((float) $transaction->quantity, 2) }}
                                </span>
                            @elseif($transaction->type === 'stock_out')
                                <span class="id-quantity-out">
                                    −{{ number_format((float) $transaction->quantity, 2) }}
                                </span>
                            @else
                                <span class="id-quantity-adjust">
                                    {{ number_format((float) $transaction->quantity, 2) }}
                                </span>
                            @endif

                        </td>


                        {{-- Before --}}
                        <td>
                            <span class="id-stock-value">
                                {{ number_format((float) $transaction->stock_before, 2) }}
                            </span>
                        </td>


                        {{-- After --}}
                        <td>
                            <span class="id-stock-after">
                                {{ number_format((float) $transaction->stock_after, 2) }}
                            </span>
                        </td>


                        {{-- Reference --}}
                        <td>
                            @if($transaction->reference)
                                <span class="id-reference">
                                    <i class="bi bi-receipt me-1"></i>
                                    {{ $transaction->reference }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>


                        {{-- Notes --}}
                        <td>
                            @if($transaction->notes)
                                <span
                                    class="id-notes"
                                    title="{{ $transaction->notes }}"
                                >
                                    {{ \Illuminate\Support\Str::limit($transaction->notes, 55) }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center py-5">

                            <div class="id-empty-state">

                                <div class="id-empty-icon">
                                    <i class="bi bi-clock-history"></i>
                                </div>

                                <h6 class="fw-bold mt-3 mb-2">
                                    No Transactions Found
                                </h6>

                                <p class="text-muted small mb-3">
                                    No stock movements have been recorded for this product yet.
                                </p>

                                <a
                                    href="{{ route('inventory.create') }}?product_id={{ $product->id }}"
                                    class="btn id-btn-primary btn-sm"
                                >
                                    <i class="bi bi-plus-lg me-1"></i>
                                    Create First Transaction
                                </a>

                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- Pagination --}}
    @if($transactions->hasPages())

        <div class="id-pagination-footer">

            <div class="text-muted small">
                Showing
                <strong>{{ $transactions->firstItem() ?? 0 }}</strong>
                to
                <strong>{{ $transactions->lastItem() ?? 0 }}</strong>
                of
                <strong>{{ $transactions->total() }}</strong>
                transactions
            </div>

            <div>
                {{ $transactions->links() }}
            </div>

        </div>

    @endif

</div>


{{-- Footer --}}
<div class="id-page-footer">
    <i class="bi bi-shield-check me-1"></i>
    Inventory transaction history · Review movements to help maintain accurate stock records.
</div>


</div>

<style>
    .inventory-details-page {
        color: #172033;
    }

    .inventory-details-page .id-header-icon {
        width: 55px;
        height: 55px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        color: #fff;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        box-shadow: 0 8px 20px rgba(79, 70, 229, .2);
        font-size: 24px;
    }

    .inventory-details-page .id-eyebrow {
        color: #6366f1;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.3px;
    }

    .inventory-details-page h2 {
        color: #172033;
        font-size: clamp(1.4rem, 2vw, 1.8rem);
        letter-spacing: -.5px;
        overflow-wrap: anywhere;
    }

    .inventory-details-page .id-btn-primary,
    .inventory-details-page .id-btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .inventory-details-page .id-btn-primary {
        color: #fff;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        border: 1px solid #4f46e5;
        box-shadow: 0 5px 12px rgba(79, 70, 229, .15);
    }

    .inventory-details-page .id-btn-primary:hover {
        color: #fff;
        background: #4338ca;
        transform: translateY(-1px);
    }

    .inventory-details-page .id-btn-secondary {
        color: #475569;
        background: #fff;
        border: 1px solid #e2e8f0;
    }

    .inventory-details-page .id-btn-secondary:hover {
        color: #1e293b;
        background: #f8fafc;
    }

    .inventory-details-page .id-stock-alert,
    .inventory-details-page .id-success-alert {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 17px 20px;
        border-radius: 13px;
    }

    .inventory-details-page .id-stock-alert {
        color: #991b1b;
        background: #fff7f7;
        border: 1px solid #fecaca;
    }

    .inventory-details-page .id-alert-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        border-radius: 12px;
        color: #dc2626;
        background: #fee2e2;
        font-size: 18px;
    }

    .inventory-details-page .id-stock-alert h6 {
        font-size: 13px;
    }

    .inventory-details-page .id-stock-alert p {
        line-height: 1.6;
    }

    .inventory-details-page .id-alert-badge {
        margin-left: auto;
        padding: 7px 10px;
        border-radius: 8px;
        color: #b91c1c;
        background: #fee2e2;
        white-space: nowrap;
        font-size: 10px;
        font-weight: 750;
    }

    .inventory-details-page .id-success-alert {
        color: #065f46;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        font-size: 12px;
    }

    .inventory-details-page .id-summary-card {
        height: 100%;
        padding: 22px;
        border: 1px solid #e9edf5;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .035);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .inventory-details-page .id-summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 9px 24px rgba(15, 23, 42, .06);
    }

    .inventory-details-page .id-card-label {
        color: #64748b;
        font-size: 11px;
        font-weight: 650;
    }

    .inventory-details-page .id-card-value {
        color: #172033;
        font-weight: 800;
        letter-spacing: -.5px;
        overflow-wrap: anywhere;
    }

    .inventory-details-page .id-unit-label {
        color: #94a3b8;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0;
    }

    .inventory-details-page .id-card-subtitle {
        color: #94a3b8;
        font-size: 10px;
    }

    .inventory-details-page .id-summary-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        flex-shrink: 0;
        border-radius: 13px;
        font-size: 21px;
    }

    .inventory-details-page .id-icon-purple {
        color: #7c3aed;
        background: #ede9fe;
    }

    .inventory-details-page .id-icon-blue {
        color: #2563eb;
        background: #dbeafe;
    }

    .inventory-details-page .id-icon-orange {
        color: #d97706;
        background: #fef3c7;
    }

    .inventory-details-page .id-status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 9px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 750;
    }

    .inventory-details-page .id-status-low {
        color: #b91c1c;
        background: #fee2e2;
    }

    .inventory-details-page .id-status-normal {
        color: #047857;
        background: #d1fae5;
    }

    .inventory-details-page .id-panel {
        margin-bottom: 22px;
        overflow: hidden;
        border: 1px solid #e9edf5;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .035);
    }

    .inventory-details-page .id-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 22px 24px;
        border-bottom: 1px solid #edf0f5;
    }

    .inventory-details-page .id-panel-header h5 {
        color: #172033;
        font-size: 15px;
    }

    .inventory-details-page .id-panel-header p {
        line-height: 1.6;
    }

    .inventory-details-page .id-panel-header-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 11px;
        color: #6366f1;
        background: #eef2ff;
        font-size: 19px;
    }

    .inventory-details-page .id-panel-body {
        padding: 24px;
    }

    .inventory-details-page .id-overview-quantity {
        color: #172033;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -.7px;
    }

    .inventory-details-page .id-overview-quantity span {
        color: #94a3b8;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0;
    }

    .inventory-details-page .id-progress-track {
        width: 100%;
        height: 10px;
        overflow: hidden;
        border-radius: 99px;
        background: #eef2f7;
    }

    .inventory-details-page .id-progress-bar {
        height: 100%;
        min-width: 0;
        border-radius: 99px;
        transition: width .3s ease;
    }

    .inventory-details-page .id-progress-low {
        background: linear-gradient(90deg, #f87171, #dc2626);
    }

    .inventory-details-page .id-progress-normal {
        background: linear-gradient(90deg, #34d399, #059669);
    }

    .inventory-details-page .id-legend-dot {
        display: inline-block;
        width: 7px;
        height: 7px;
        margin-right: 5px;
        border-radius: 50%;
    }

    .inventory-details-page .id-dot-low {
        background: #dc2626;
    }

    .inventory-details-page .id-dot-normal {
        background: #059669;
    }

    .inventory-details-page .id-stock-difference {
        font-size: 11px;
        font-weight: 700;
    }

    .inventory-details-page .id-difference-low {
        color: #b91c1c;
    }

    .inventory-details-page .id-difference-normal {
        color: #047857;
    }

    .inventory-details-page .id-heading-icon {
        color: #6366f1;
    }

    .inventory-details-page .id-history-count {
        padding: 8px 11px;
        border-radius: 8px;
        color: #4f46e5;
        background: #eef2ff;
        white-space: nowrap;
        font-size: 11px;
        font-weight: 750;
    }

    .inventory-details-page .id-history-table {
        min-width: 1050px;
    }

    .inventory-details-page .id-history-table thead th {
        padding: 15px 13px;
        border-bottom: 1px solid #e9edf5;
        color: #64748b;
        background: #f8fafc;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .65px;
        white-space: nowrap;
    }

    .inventory-details-page .id-history-table tbody td {
        padding: 16px 13px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 11px;
    }

    .inventory-details-page .id-history-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .inventory-details-page .id-history-table tbody tr:hover td {
        background: #fafbff;
    }

    .inventory-details-page .id-date-main {
        color: #334155;
        font-size: 11px;
        font-weight: 750;
        white-space: nowrap;
    }

    .inventory-details-page .id-date-time {
        margin-top: 5px;
        color: #94a3b8;
        font-size: 10px;
        white-space: nowrap;
    }

    .inventory-details-page .id-transaction-badge {
        display: inline-flex;
        align-items: center;
        padding: 7px 9px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 750;
        white-space: nowrap;
    }

    .inventory-details-page .id-badge-in {
        color: #047857;
        background: #d1fae5;
    }

    .inventory-details-page .id-badge-out {
        color: #b91c1c;
        background: #fee2e2;
    }

    .inventory-details-page .id-badge-adjust {
        color: #6d28d9;
        background: #ede9fe;
    }

    .inventory-details-page .id-quantity-in,
    .inventory-details-page .id-quantity-out,
    .inventory-details-page .id-quantity-adjust {
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .inventory-details-page .id-quantity-in {
        color: #059669;
    }

    .inventory-details-page .id-quantity-out {
        color: #dc2626;
    }

    .inventory-details-page .id-quantity-adjust {
        color: #7c3aed;
    }

    .inventory-details-page .id-stock-value {
        color: #64748b;
        font-weight: 650;
    }

    .inventory-details-page .id-stock-after {
        color: #172033;
        font-weight: 800;
    }

    .inventory-details-page .id-reference {
        display: inline-block;
        max-width: 180px;
        overflow-wrap: anywhere;
        color: #475569;
        font-size: 10px;
        font-weight: 650;
    }

    .inventory-details-page .id-notes {
        display: inline-block;
        max-width: 220px;
        overflow-wrap: anywhere;
        color: #64748b;
        line-height: 1.6;
    }

    .inventory-details-page .id-empty-state {
        max-width: 330px;
        margin: auto;
        padding: 12px;
    }

    .inventory-details-page .id-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 65px;
        height: 65px;
        margin: auto;
        border-radius: 19px;
        color: #94a3b8;
        background: #f1f5f9;
        font-size: 29px;
    }

    .inventory-details-page .id-empty-state h6 {
        color: #334155;
        font-size: 14px;
    }

    .inventory-details-page .id-empty-state p {
        line-height: 1.7;
    }

    .inventory-details-page .id-pagination-footer {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 18px 24px;
        border-top: 1px solid #edf0f5;
        background: #fff;
    }

    .inventory-details-page .id-pagination-footer nav p {
        margin-bottom: 0;
    }

    .inventory-details-page .id-page-footer {
        padding: 3px 0 10px;
        color: #94a3b8;
        font-size: 10px;
        text-align: center;
    }

    @media (max-width: 767px) {
        .inventory-details-page .id-panel-header,
        .inventory-details-page .id-panel-body {
            padding: 18px;
        }

        .inventory-details-page .id-summary-card {
            padding: 18px;
        }

        .inventory-details-page .id-stock-alert {
            align-items: flex-start;
            flex-wrap: wrap;
            padding: 15px;
        }

        .inventory-details-page .id-alert-badge {
            margin-left: 56px;
        }

        .inventory-details-page .id-pagination-footer {
            padding: 16px;
        }

        .inventory-details-page .id-overview-quantity {
            font-size: 24px;
        }
    }
</style>

@endsection
