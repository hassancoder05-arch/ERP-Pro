@extends('layouts.app')

@section('title', 'Notifications')

@section('content')

<style>
    /* =========================================
       ERP PRO — NOTIFICATIONS PAGE
    ========================================= */

    .notifications-page {
        --notify-primary: #6366f1;
        --notify-danger: #ef4444;
        --notify-warning: #f59e0b;
        --notify-text: #0f172a;
        --notify-muted: #64748b;
        --notify-border: #e8edf5;
        color: var(--notify-text);
    }

    .notifications-page .page-heading {
        font-size: clamp(1.45rem, 2.5vw, 1.9rem);
        font-weight: 800;
        letter-spacing: -0.8px;
    }

    .notifications-page .page-subtitle {
        color: var(--notify-muted);
        font-size: 0.92rem;
    }

    .notifications-page .header-icon {
        width: 52px;
        height: 52px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 16px;
        color: #fff;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.22);
    }

    .notifications-page .dashboard-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 17px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        color: #334155;
        background: #fff;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .notifications-page .dashboard-btn:hover {
        color: var(--notify-primary);
        border-color: #c7d2fe;
        background: #eef2ff;
        transform: translateY(-2px);
    }

    /* Summary cards */

    .notifications-page .summary-card {
        position: relative;
        height: 100%;
        overflow: hidden;
        border: 1px solid var(--notify-border);
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 5px 22px rgba(15, 23, 42, 0.035);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .notifications-page .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
    }

    .notifications-page .summary-card::after {
        content: "";
        position: absolute;
        width: 125px;
        height: 125px;
        right: -38px;
        top: -45px;
        border-radius: 50%;
        background: currentColor;
        opacity: 0.035;
        pointer-events: none;
    }

    .notifications-page .summary-card-body {
        position: relative;
        z-index: 1;
        padding: 24px;
    }

    .notifications-page .summary-icon {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        font-size: 1.65rem;
        flex-shrink: 0;
    }

    .notifications-page .summary-label {
        color: var(--notify-muted);
        font-size: 0.84rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .notifications-page .summary-number {
        font-size: 2.15rem;
        line-height: 1.1;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 7px;
    }

    .notifications-page .summary-caption {
        font-size: 0.77rem;
        color: var(--notify-muted);
    }

    .notifications-page .summary-danger {
        color: #dc2626;
    }

    .notifications-page .summary-danger .summary-icon {
        color: #dc2626;
        background: #fef2f2;
    }

    .notifications-page .summary-warning {
        color: #b45309;
    }

    .notifications-page .summary-warning .summary-icon {
        color: #b45309;
        background: #fffbeb;
    }

    .notifications-page .summary-purple {
        color: #6366f1;
    }

    .notifications-page .summary-purple .summary-icon {
        color: #6366f1;
        background: #eef2ff;
    }

    .notifications-page .summary-total {
        color: #0f172a;
    }

    .notifications-page .summary-total .summary-icon {
        color: #0f766e;
        background: #ecfdf5;
    }

    /* Section cards */

    .notifications-page .notification-panel {
        border: 1px solid var(--notify-border);
        border-radius: 20px;
        background: #fff;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, 0.035);
    }

    .notifications-page .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
        padding: 21px 24px;
        border-bottom: 1px solid #eef2f7;
        background: linear-gradient(180deg, #fff 0%, #fcfdff 100%);
    }

    .notifications-page .panel-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1rem;
        font-weight: 800;
        margin: 0;
        color: #172033;
    }

    .notifications-page .panel-icon {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.2rem;
    }

    .notifications-page .panel-icon-danger {
        color: #dc2626;
        background: #fef2f2;
    }

    .notifications-page .panel-icon-warning {
        color: #b45309;
        background: #fffbeb;
    }

    .notifications-page .count-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        padding: 6px 11px;
        border-radius: 10px;
        font-size: 0.78rem;
        font-weight: 800;
    }

    .notifications-page .count-pill-danger {
        color: #b91c1c;
        background: #fef2f2;
    }

    .notifications-page .count-pill-warning {
        color: #92400e;
        background: #fffbeb;
    }

    .notifications-page .panel-body {
        padding: 0;
    }

    /* Table */

    .notifications-page .table-responsive {
        overflow-x: auto;
    }

    .notifications-page .notification-table {
        width: 100%;
        margin: 0;
        white-space: nowrap;
        vertical-align: middle;
    }

    .notifications-page .notification-table thead th {
        padding: 14px 22px;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e8edf5;
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.55px;
    }

    .notifications-page .notification-table tbody td {
        padding: 17px 22px;
        border-bottom: 1px solid #f0f3f8;
        color: #475569;
        font-size: 0.85rem;
    }

    .notifications-page .notification-table tbody tr {
        transition: background 0.2s ease;
    }

    .notifications-page .notification-table tbody tr:hover {
        background: #fafbff;
    }

    .notifications-page .notification-table tbody tr:last-child td {
        border-bottom: none;
    }

    .notifications-page .product-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 175px;
    }

    .notifications-page .product-icon {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 1.15rem;
    }

    .notifications-page .product-icon-danger {
        color: #dc2626;
        background: #fef2f2;
    }

    .notifications-page .product-icon-warning {
        color: #b45309;
        background: #fffbeb;
    }

    .notifications-page .product-name {
        color: #172033;
        font-weight: 750;
        font-size: 0.87rem;
        max-width: 230px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .notifications-page .product-caption {
        margin-top: 3px;
        color: #94a3b8;
        font-size: 0.74rem;
    }

    .notifications-page .product-code {
        display: inline-block;
        padding: 6px 9px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #475569;
        background: #f8fafc;
        font-size: 0.76rem;
        font-weight: 700;
    }

    .notifications-page .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 9px;
        font-size: 0.77rem;
        font-weight: 800;
    }

    .notifications-page .stock-badge-danger {
        color: #b91c1c;
        background: #fef2f2;
        border: 1px solid #fee2e2;
    }

    .notifications-page .stock-badge-warning {
        color: #92400e;
        background: #fffbeb;
        border: 1px solid #fde68a;
    }

    .notifications-page .minimum-stock {
        color: #334155;
        font-weight: 700;
    }

    .notifications-page .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 750;
    }

    .notifications-page .status-indicator-danger {
        color: #b91c1c;
        background: #fef2f2;
    }

    .notifications-page .status-indicator-warning {
        color: #92400e;
        background: #fffbeb;
    }

    .notifications-page .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .notifications-page .update-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 8px 12px;
        border: 1px solid #c7d2fe;
        border-radius: 9px;
        color: #4f46e5;
        background: #eef2ff;
        text-decoration: none;
        font-size: 0.78rem;
        font-weight: 800;
        transition: all 0.2s ease;
    }

    .notifications-page .update-btn:hover {
        color: #fff;
        border-color: #4f46e5;
        background: #4f46e5;
        transform: translateY(-1px);
    }

    /* Empty state */

    .notifications-page .empty-state {
        padding: 48px 20px;
        text-align: center;
    }

    .notifications-page .empty-icon {
        width: 76px;
        height: 76px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        border-radius: 24px;
        color: #059669;
        background: #ecfdf5;
        font-size: 2.2rem;
    }

    .notifications-page .empty-title {
        margin-bottom: 8px;
        color: #172033;
        font-size: 1.05rem;
        font-weight: 800;
    }

    .notifications-page .empty-description {
        margin: 0;
        color: #64748b;
        font-size: 0.86rem;
    }

    .notifications-page .page-footer-note {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #64748b;
        font-size: 0.79rem;
    }

    .notifications-page .page-footer-note i {
        color: #6366f1;
        font-size: 1rem;
    }

    /* Responsive */

    @media (max-width: 767.98px) {
        .notifications-page .page-header {
            align-items: flex-start !important;
        }

        .notifications-page .header-icon {
            width: 44px;
            height: 44px;
            border-radius: 13px;
            font-size: 1.25rem;
        }

        .notifications-page .summary-card-body {
            padding: 20px;
        }

        .notifications-page .summary-number {
            font-size: 1.85rem;
        }

        .notifications-page .panel-header {
            padding: 17px;
        }

        .notifications-page .notification-table thead th,
        .notifications-page .notification-table tbody td {
            padding: 13px 15px;
        }
    }

    @media (max-width: 480px) {
        .notifications-page .page-heading {
            font-size: 1.35rem;
        }

        .notifications-page .dashboard-btn {
            padding: 9px 11px;
            font-size: 0.8rem;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .notifications-page *,
        .notifications-page *::before,
        .notifications-page *::after {
            transition: none !important;
        }
    }
</style>

<div class="container-fluid py-4 notifications-page">


{{-- PAGE HEADER --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 page-header">

    <div class="d-flex align-items-center gap-3">

        <div class="header-icon">
            <i class="bi bi-bell-fill"></i>
        </div>

        <div>
            <h2 class="page-heading mb-1">
                Notifications
            </h2>

            <p class="page-subtitle mb-0">
                Monitor inventory alerts and manage stock levels.
            </p>
        </div>

    </div>

    <a href="{{ route('dashboard') }}" class="dashboard-btn">
        <i class="bi bi-arrow-left"></i>
        Back to Dashboard
    </a>

</div>


{{-- SUMMARY CARDS --}}
<div class="row g-4 mb-4">

    {{-- OUT OF STOCK --}}
    <div class="col-12 col-sm-6 col-xl-4">

        <div class="summary-card summary-danger">

            <div class="summary-card-body">

                <div class="d-flex align-items-center justify-content-between gap-3">

                    <div>
                        <div class="summary-label">
                            Out of Stock
                        </div>

                        <h3 class="summary-number mb-2">
                            {{ $outOfStockProducts->count() }}
                        </h3>

                        <div class="summary-caption">
                            Products requiring restock
                        </div>
                    </div>

                    <div class="summary-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- LOW STOCK --}}
    <div class="col-12 col-sm-6 col-xl-4">

        <div class="summary-card summary-warning">

            <div class="summary-card-body">

                <div class="d-flex align-items-center justify-content-between gap-3">

                    <div>
                        <div class="summary-label">
                            Low Stock
                        </div>

                        <h3 class="summary-number mb-2">
                            {{ $lowStockProducts->count() }}
                        </h3>

                        <div class="summary-caption">
                            Products below minimum stock
                        </div>
                    </div>

                    <div class="summary-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- TOTAL ALERTS --}}
    <div class="col-12 col-xl-4">

        <div class="summary-card summary-total">

            <div class="summary-card-body">

                <div class="d-flex align-items-center justify-content-between gap-3">

                    <div>
                        <div class="summary-label">
                            Total Stock Alerts
                        </div>

                        <h3 class="summary-number mb-2">
                            {{ $outOfStockProducts->count() + $lowStockProducts->count() }}
                        </h3>

                        <div class="summary-caption">
                            Combined inventory warnings
                        </div>
                    </div>

                    <div class="summary-icon">
                        <i class="bi bi-activity"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- OUT OF STOCK PRODUCTS --}}
<div class="notification-panel mb-4">

    <div class="panel-header">

        <div class="d-flex align-items-center gap-3">

            <div class="panel-icon panel-icon-danger">
                <i class="bi bi-x-circle-fill"></i>
            </div>

            <div>
                <h5 class="panel-title">
                    Out of Stock Products
                </h5>

                <div class="small text-muted mt-1">
                    Products that need immediate replenishment
                </div>
            </div>

        </div>

        <span class="count-pill count-pill-danger">
            {{ $outOfStockProducts->count() }} Products
        </span>

    </div>


    <div class="panel-body">

        @if($outOfStockProducts->count() > 0)

            <div class="table-responsive">

                <table class="table notification-table">

                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Product Code</th>
                            <th>Current Stock</th>
                            <th>Minimum Stock</th>
                            <th>Priority</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($outOfStockProducts as $product)

                            <tr>

                                <td>
                                    <div class="product-info">

                                        <div class="product-icon product-icon-danger">
                                            <i class="bi bi-box-seam"></i>
                                        </div>

                                        <div>
                                            <div class="product-name">
                                                {{ $product->name }}
                                            </div>

                                            <div class="product-caption">
                                                Inventory item
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <span class="product-code">
                                        {{ $product->product_code ?: 'N/A' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="stock-badge stock-badge-danger">
                                        <i class="bi bi-box"></i>
                                        {{ $product->stock }}
                                    </span>
                                </td>

                                <td>
                                    <span class="minimum-stock">
                                        {{ $product->minimum_stock }}
                                    </span>
                                </td>

                                <td>
                                    <span class="status-indicator status-indicator-danger">
                                        <span class="status-dot"></span>
                                        Critical
                                    </span>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('products.edit', $product) }}"
                                       class="update-btn">

                                        <i class="bi bi-pencil-square"></i>
                                        Update Stock

                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <h5 class="empty-title">
                    All Products Are in Stock
                </h5>

                <p class="empty-description">
                    There are currently no out-of-stock products requiring attention.
                </p>

            </div>

        @endif

    </div>

</div>


{{-- LOW STOCK PRODUCTS --}}
<div class="notification-panel">

    <div class="panel-header">

        <div class="d-flex align-items-center gap-3">

            <div class="panel-icon panel-icon-warning">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>

            <div>
                <h5 class="panel-title">
                    Low Stock Products
                </h5>

                <div class="small text-muted mt-1">
                    Products approaching their minimum stock level
                </div>
            </div>

        </div>

        <span class="count-pill count-pill-warning">
            {{ $lowStockProducts->count() }} Products
        </span>

    </div>


    <div class="panel-body">

        @if($lowStockProducts->count() > 0)

            <div class="table-responsive">

                <table class="table notification-table">

                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Product Code</th>
                            <th>Current Stock</th>
                            <th>Minimum Stock</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($lowStockProducts as $product)

                            <tr>

                                <td>
                                    <div class="product-info">

                                        <div class="product-icon product-icon-warning">
                                            <i class="bi bi-box-seam"></i>
                                        </div>

                                        <div>
                                            <div class="product-name">
                                                {{ $product->name }}
                                            </div>

                                            <div class="product-caption">
                                                Inventory item
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <span class="product-code">
                                        {{ $product->product_code ?: 'N/A' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="stock-badge stock-badge-warning">
                                        <i class="bi bi-box"></i>
                                        {{ $product->stock }}
                                    </span>
                                </td>

                                <td>
                                    <span class="minimum-stock">
                                        {{ $product->minimum_stock }}
                                    </span>
                                </td>

                                <td>
                                    <span class="status-indicator status-indicator-warning">
                                        <span class="status-dot"></span>
                                        Low Stock
                                    </span>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('products.edit', $product) }}"
                                       class="update-btn">

                                        <i class="bi bi-pencil-square"></i>
                                        Update Stock

                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="bi bi-shield-check"></i>
                </div>

                <h5 class="empty-title">
                    Inventory Levels Are Healthy
                </h5>

                <p class="empty-description">
                    No low-stock products were found. Your inventory is looking good.
                </p>

            </div>

        @endif

    </div>

</div>


{{-- FOOTER NOTE --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-4">

    <div class="page-footer-note">
        <i class="bi bi-info-circle-fill"></i>
        <span>
            Stock alerts are based on the current product quantities and minimum stock settings.
        </span>
    </div>

    <div class="small text-muted">
        ERP-Pro Inventory Management
    </div>

</div>


</div>

@endsection
