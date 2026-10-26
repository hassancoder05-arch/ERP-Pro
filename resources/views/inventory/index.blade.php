@extends('layouts.app')

@section('title', 'Inventory')

@section('content')

<div class="container-fluid py-4 inventory-page">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div class="d-flex align-items-center gap-3">

            <div class="inventory-page-icon">
                <i class="bi bi-boxes"></i>
            </div>

            <div>
                <h2 class="fw-bold mb-1">Inventory Management</h2>
                <p class="text-muted mb-0">
                    Monitor product availability, stock levels and inventory movements.
                </p>
            </div>

        </div>

        <div class="d-flex flex-wrap gap-2 inventory-header-actions">

            <a href="{{ route('inventory.history') }}"
               class="btn btn-outline-dark inventory-history-btn">

                <i class="bi bi-clock-history me-2"></i>
                Stock History

            </a>

            <a href="{{ route('inventory.create') }}"
               class="btn btn-primary inventory-add-btn">

                <i class="bi bi-plus-lg me-2"></i>
                Stock Transaction

            </a>

        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show inventory-alert"
             role="alert">

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

        <div class="alert alert-danger alert-dismissible fade show inventory-alert"
             role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>

        </div>

    @endif


    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">

        {{-- Total Products --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="inventory-stat-card">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="inventory-stat-label">Total Products</p>

                        <h3 class="inventory-stat-value">
                            {{ number_format($totalProducts) }}
                        </h3>

                        <span class="inventory-stat-note">
                            Products in inventory
                        </span>
                    </div>

                    <div class="inventory-stat-icon icon-blue">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- Total Units --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="inventory-stat-card">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="inventory-stat-label">Total Units</p>

                        <h3 class="inventory-stat-value">
                            {{ number_format($totalUnits) }}
                        </h3>

                        <span class="inventory-stat-note">
                            Combined stock quantity
                        </span>
                    </div>

                    <div class="inventory-stat-icon icon-green">
                        <i class="bi bi-stack"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- Low Stock --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="inventory-stat-card">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="inventory-stat-label">Low Stock</p>

                        <h3 class="inventory-stat-value text-warning">
                            {{ number_format($lowStockProducts) }}
                        </h3>

                        <span class="inventory-stat-note">
                            Replenishment may be needed
                        </span>
                    </div>

                    <div class="inventory-stat-icon icon-orange">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- Out of Stock --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="inventory-stat-card">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="inventory-stat-label">Out of Stock</p>

                        <h3 class="inventory-stat-value text-danger">
                            {{ number_format($outOfStockProducts) }}
                        </h3>

                        <span class="inventory-stat-note">
                            Products with zero stock
                        </span>
                    </div>

                    <div class="inventory-stat-icon icon-red">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Search Card --}}
    <div class="card inventory-card border-0 mb-4">

        <div class="card-body p-3 p-md-4">

            <form method="GET" action="{{ route('inventory.index') }}">

                <div class="row g-3 align-items-center">

                    <div class="col-12 col-lg-5">

                        <h5 class="fw-bold mb-1">
                            Find Products
                        </h5>

                        <p class="text-muted small mb-0">
                            Search inventory by product name or code.
                        </p>

                    </div>

                    <div class="col-12 col-lg-7">

                        <div class="inventory-search-group">

                            <span class="inventory-search-icon">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                name="search"
                                value="{{ $search ?? request('search') }}"
                                class="form-control inventory-search-input"
                                placeholder="Search product name or code..."
                                aria-label="Search inventory"
                            >

                            @if(!empty($search) || request()->filled('search'))

                                <a href="{{ route('inventory.index') }}"
                                   class="btn btn-outline-secondary inventory-clear-btn">

                                    <i class="bi bi-x-lg me-1"></i>
                                    Clear

                                </a>

                            @endif

                            <button class="btn btn-dark inventory-search-btn"
                                    type="submit">

                                Search

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Inventory Table --}}
    <div class="card inventory-card border-0">

        {{-- Table Header --}}
        <div class="card-header inventory-table-header bg-white">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div class="d-flex align-items-center gap-3">

                    <div class="inventory-directory-icon">
                        <i class="bi bi-clipboard-data-fill"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">
                            Current Stock
                        </h5>

                        <p class="text-muted small mb-0">

                            @if($products->total() > 0)

                                Showing {{ $products->firstItem() }}–{{ $products->lastItem() }}
                                of {{ $products->total() }} products

                            @else

                                No inventory records available

                            @endif

                        </p>
                    </div>

                </div>

                <span class="inventory-record-badge">
                    <i class="bi bi-boxes me-1"></i>
                    {{ number_format($products->total()) }} Products
                </span>

            </div>

        </div>


        {{-- Table Body --}}
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table inventory-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th class="ps-4">Product</th>
                            <th>Category</th>
                            <th>Current Stock</th>
                            <th>Minimum Stock</th>
                            <th>Stock Level</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($products as $product)

                        @php
                            $currentStock = (float) $product->stock;
                            $minimumStock = (float) $product->minimum_stock;

                            if ($currentStock <= 0) {
                                $stockStatus = 'out';
                                $stockLabel = 'Out of Stock';
                                $stockPercentage = 0;
                            } elseif ($currentStock <= $minimumStock) {
                                $stockStatus = 'low';
                                $stockLabel = 'Low Stock';

                                $stockPercentage = $minimumStock > 0
                                    ? min(100, ($currentStock / $minimumStock) * 100)
                                    : 100;
                            } else {
                                $stockStatus = 'available';
                                $stockLabel = 'Available';

                                $stockPercentage = $minimumStock > 0
                                    ? min(100, ($currentStock / ($minimumStock * 2)) * 100)
                                    : 100;
                            }
                        @endphp

                        <tr>

                            {{-- Product --}}
                            <td class="ps-4">

                                <div class="d-flex align-items-center gap-3">

                                    <div class="inventory-product-icon
                                        {{ $stockStatus === 'out' ? 'product-icon-red' : ($stockStatus === 'low' ? 'product-icon-orange' : 'product-icon-blue') }}">

                                        <i class="bi bi-box-seam"></i>

                                    </div>

                                    <div class="inventory-product-info">

                                        <div class="inventory-product-name">
                                            {{ $product->name }}
                                        </div>

                                        <div class="inventory-product-code">
                                            <i class="bi bi-upc-scan me-1"></i>
                                            {{ $product->product_code ?: 'No product code' }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Category --}}
                            <td>

                                <span class="inventory-category">
                                    <i class="bi bi-tag me-1"></i>
                                    {{ $product->category ?: 'Uncategorized' }}
                                </span>

                            </td>


                            {{-- Current Stock --}}
                            <td>

                                <span class="inventory-stock-value
                                    {{ $stockStatus === 'out' ? 'stock-value-red' : ($stockStatus === 'low' ? 'stock-value-orange' : 'stock-value-green') }}">

                                    {{ number_format($currentStock, 2) }}

                                </span>

                            </td>


                            {{-- Minimum Stock --}}
                            <td>

                                <span class="inventory-minimum-stock">
                                    {{ number_format($minimumStock, 2) }}
                                </span>

                            </td>


                            {{-- Stock Level Progress --}}
                            <td>

                                <div class="inventory-level-wrapper">

                                    <div class="inventory-level-label">

                                        <span>
                                            {{ $stockStatus === 'out' ? 'Empty' : ($stockStatus === 'low' ? 'Below target' : 'Healthy') }}
                                        </span>

                                        <span>
                                            {{ number_format($stockPercentage, 0) }}%
                                        </span>

                                    </div>

                                    <div class="inventory-progress">

                                        <div
                                            class="inventory-progress-bar
                                                {{ $stockStatus === 'out' ? 'progress-red' : ($stockStatus === 'low' ? 'progress-orange' : 'progress-green') }}"
                                            role="progressbar"
                                            style="width: {{ $stockPercentage }}%"
                                            aria-valuenow="{{ $stockPercentage }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($stockStatus === 'out')

                                    <span class="inventory-status status-out">
                                        <span class="inventory-status-dot"></span>
                                        Out of Stock
                                    </span>

                                @elseif($stockStatus === 'low')

                                    <span class="inventory-status status-low">
                                        <span class="inventory-status-dot"></span>
                                        Low Stock
                                    </span>

                                @else

                                    <span class="inventory-status status-available">
                                        <span class="inventory-status-dot"></span>
                                        Available
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="text-end pe-4">

                                <div class="inventory-actions">

                                    {{-- View History --}}
                                    <a
                                        href="{{ route('inventory.show', $product) }}"
                                        class="inventory-action-btn action-view"
                                        title="View Stock History"
                                        aria-label="View stock history">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                    {{-- Update Stock --}}
                                    <a
                                        href="{{ route('inventory.create') }}?product_id={{ $product->id }}"
                                        class="inventory-action-btn action-update"
                                        title="Update Stock"
                                        aria-label="Update stock">

                                        <i class="bi bi-plus-slash-minus"></i>

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        {{-- Empty State --}}
                        <tr>

                            <td colspan="7" class="text-center py-5">

                                <div class="inventory-empty-state">

                                    <div class="inventory-empty-icon">
                                        <i class="bi bi-boxes"></i>
                                    </div>

                                    <h5 class="fw-bold mt-3 mb-2">
                                        No products found
                                    </h5>

                                    <p class="text-muted mb-3">

                                        @if(!empty($search) || request()->filled('search'))

                                            Try another search term or clear the search.

                                        @else

                                            Products will appear here when available in your inventory.

                                        @endif

                                    </p>

                                    @if(!empty($search) || request()->filled('search'))

                                        <a href="{{ route('inventory.index') }}"
                                           class="btn btn-outline-secondary">

                                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                                            Clear Search

                                        </a>

                                    @else

                                        <a href="{{ route('products.index') }}"
                                           class="btn btn-primary inventory-add-btn">

                                            <i class="bi bi-box-seam me-2"></i>
                                            View Products

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
        @if($products->hasPages())

            <div class="card-footer inventory-pagination-footer">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <span class="text-muted small">
                        Page {{ $products->currentPage() }}
                        of {{ $products->lastPage() }}
                    </span>

                    <div class="inventory-pagination">
                        {{ $products->appends(request()->query())->links() }}
                    </div>

                </div>

            </div>

        @endif

    </div>


    {{-- Footer --}}
    <div class="inventory-page-footer mt-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

            <span>
                <i class="bi bi-shield-check me-1"></i>
                Inventory Management
            </span>

            <span>
                <i class="bi bi-boxes me-1"></i>
                {{ number_format($products->total()) }} matching products
            </span>

        </div>

    </div>

</div>


<style>
/* =========================================
   INVENTORY MANAGEMENT
========================================= */

.inventory-page {
    color: #1e293b;
}

.inventory-page-icon {
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

.inventory-page h2 {
    color: #0f172a;
    font-size: 27px;
    letter-spacing: -0.6px;
}

.inventory-add-btn {
    padding: 11px 18px;
    border: 0;
    border-radius: 10px;
    background: #4f46e5;
    box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
    font-weight: 600;
    transition: all 0.2s ease;
}

.inventory-add-btn:hover {
    background: #4338ca;
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(79, 70, 229, 0.22);
}

.inventory-history-btn {
    padding: 10px 16px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.inventory-history-btn:hover {
    transform: translateY(-1px);
}

.inventory-alert {
    border: 0;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}


/* =========================================
   KPI CARDS
========================================= */

.inventory-stat-card {
    height: 100%;
    padding: 22px;
    border: 1px solid #edf0f5;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 4px 18px rgba(15, 23, 42, 0.035);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.inventory-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.07);
}

.inventory-stat-label {
    margin-bottom: 10px;
    color: #64748b;
    font-size: 13px;
    font-weight: 600;
}

.inventory-stat-value {
    margin-bottom: 7px;
    color: #0f172a;
    font-size: 29px;
    font-weight: 750;
    letter-spacing: -0.6px;
}

.inventory-stat-note {
    color: #94a3b8;
    font-size: 12px;
}

.inventory-stat-icon {
    width: 47px;
    height: 47px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 13px;
    font-size: 22px;
}

.inventory-stat-icon.icon-blue {
    background: #eff6ff;
    color: #2563eb;
}

.inventory-stat-icon.icon-green {
    background: #ecfdf5;
    color: #059669;
}

.inventory-stat-icon.icon-orange {
    background: #fff7ed;
    color: #ea580c;
}

.inventory-stat-icon.icon-red {
    background: #fff1f2;
    color: #e11d48;
}


/* =========================================
   CARDS AND SEARCH
========================================= */

.inventory-card {
    overflow: hidden;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.045);
}

.inventory-search-group {
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

.inventory-search-group:focus-within {
    border-color: #818cf8;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.inventory-search-icon {
    padding: 0 10px;
    color: #94a3b8;
    font-size: 17px;
}

.inventory-search-input {
    min-width: 0;
    height: 38px;
    border: 0;
    outline: 0;
    background: transparent;
    box-shadow: none !important;
    font-size: 13px;
}

.inventory-search-input:focus {
    background: transparent;
}

.inventory-search-btn {
    height: 38px;
    padding: 0 17px;
    border: 0;
    border-radius: 8px !important;
    background: #0f172a;
    font-size: 13px;
    font-weight: 600;
}

.inventory-search-btn:hover {
    background: #334155;
}

.inventory-clear-btn {
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

.inventory-table-header {
    padding: 20px 24px;
    border-bottom: 1px solid #edf0f5;
}

.inventory-directory-icon {
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

.inventory-table-header h5 {
    color: #0f172a;
    font-size: 16px;
}

.inventory-record-badge {
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
   INVENTORY TABLE
========================================= */

.inventory-table {
    min-width: 1100px;
    border-collapse: separate;
    border-spacing: 0;
}

.inventory-table thead th {
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

.inventory-table tbody td {
    padding-top: 17px;
    padding-bottom: 17px;
    border-bottom: 1px solid #f1f5f9;
    color: #475569;
    font-size: 13px;
    vertical-align: middle;
}

.inventory-table tbody tr:last-child td {
    border-bottom: 0;
}

.inventory-table tbody tr {
    transition: background-color 0.15s ease;
}

.inventory-table tbody tr:hover td {
    background: #fafbff;
}


/* =========================================
   PRODUCT DETAILS
========================================= */

.inventory-product-icon {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 1px solid transparent;
    border-radius: 12px;
    font-size: 20px;
}

.product-icon-blue {
    border-color: #dbeafe;
    background: #eff6ff;
    color: #2563eb;
}

.product-icon-orange {
    border-color: #fed7aa;
    background: #fff7ed;
    color: #ea580c;
}

.product-icon-red {
    border-color: #fecdd3;
    background: #fff1f2;
    color: #e11d48;
}

.inventory-product-name {
    max-width: 200px;
    overflow-wrap: anywhere;
    color: #1e293b;
    font-size: 13px;
    font-weight: 700;
}

.inventory-product-code {
    margin-top: 5px;
    color: #94a3b8;
    font-size: 11px;
}

.inventory-category {
    display: inline-block;
    max-width: 160px;
    padding: 6px 9px;
    overflow-wrap: anywhere;
    border: 1px solid #e2e8f0;
    border-radius: 7px;
    background: #f8fafc;
    color: #475569;
    font-size: 11px;
    font-weight: 600;
}


/* =========================================
   STOCK VALUES
========================================= */

.inventory-stock-value {
    display: inline-block;
    min-width: 50px;
    padding: 7px 10px;
    border: 1px solid transparent;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 750;
    text-align: center;
}

.stock-value-green {
    border-color: #a7f3d0;
    background: #ecfdf5;
    color: #047857;
}

.stock-value-orange {
    border-color: #fed7aa;
    background: #fff7ed;
    color: #c2410c;
}

.stock-value-red {
    border-color: #fecdd3;
    background: #fff1f2;
    color: #be123c;
}

.inventory-minimum-stock {
    color: #64748b;
    font-size: 12px;
    font-weight: 600;
}


/* =========================================
   STOCK LEVEL PROGRESS
========================================= */

.inventory-level-wrapper {
    width: 125px;
    max-width: 100%;
}

.inventory-level-label {
    display: flex;
    justify-content: space-between;
    gap: 7px;
    margin-bottom: 7px;
    color: #64748b;
    font-size: 10px;
    white-space: nowrap;
}

.inventory-progress {
    height: 6px;
    overflow: hidden;
    border-radius: 20px;
    background: #e2e8f0;
}

.inventory-progress-bar {
    height: 100%;
    border-radius: 20px;
    transition: width 0.3s ease;
}

.progress-green {
    background: #10b981;
}

.progress-orange {
    background: #f59e0b;
}

.progress-red {
    background: #ef4444;
}


/* =========================================
   STATUS BADGES
========================================= */

.inventory-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 10px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.status-available {
    background: #ecfdf5;
    color: #047857;
}

.status-low {
    background: #fff7ed;
    color: #c2410c;
}

.status-out {
    background: #fff1f2;
    color: #be123c;
}

.inventory-status-dot {
    width: 7px;
    height: 7px;
    display: inline-block;
    flex-shrink: 0;
    border-radius: 50%;
    background: currentColor;
}


/* =========================================
   ACTION BUTTONS
========================================= */

.inventory-actions {
    display: inline-flex;
    align-items: center;
    justify-content: flex-end;
    gap: 6px;
}

.inventory-action-btn {
    width: 34px;
    height: 34px;
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

.action-update {
    border-color: #c7d2fe;
    background: #eef2ff;
    color: #4f46e5;
}

.action-update:hover {
    border-color: #4f46e5;
    background: #4f46e5;
    color: #fff;
}


/* =========================================
   EMPTY STATE
========================================= */

.inventory-empty-state {
    max-width: 420px;
    margin: 0 auto;
    padding: 20px 10px;
}

.inventory-empty-icon {
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

.inventory-empty-state h5 {
    color: #1e293b;
}


/* =========================================
   PAGINATION AND FOOTER
========================================= */

.inventory-pagination-footer {
    padding: 16px 24px;
    border-top: 1px solid #edf0f5;
    background: #fff;
}

.inventory-pagination .pagination {
    margin-bottom: 0;
    gap: 4px;
}

.inventory-pagination .page-link {
    min-width: 34px;
    border: 1px solid #e2e8f0;
    border-radius: 7px !important;
    color: #475569;
    font-size: 12px;
    text-align: center;
}

.inventory-pagination .page-item.active .page-link {
    border-color: #4f46e5;
    background: #4f46e5;
    color: #fff;
}

.inventory-pagination .page-link:focus {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
}

.inventory-page-footer {
    color: #94a3b8;
    font-size: 12px;
}

.inventory-page-footer i {
    color: #6366f1;
}


/* =========================================
   RESPONSIVE DESIGN
========================================= */

@media (max-width: 991.98px) {
    .inventory-page h2 {
        font-size: 23px;
    }

    .inventory-table-header {
        padding: 17px;
    }
}

@media (max-width: 575.98px) {
    .inventory-page {
        padding-top: 18px !important;
    }

    .inventory-page h2 {
        font-size: 21px;
    }

    .inventory-page-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        font-size: 21px;
    }

    .inventory-header-actions {
        width: 100%;
    }

    .inventory-header-actions > a {
        flex: 1;
        justify-content: center;
        font-size: 12px;
    }

    .inventory-add-btn,
    .inventory-history-btn {
        padding: 10px;
    }

    .inventory-stat-card {
        padding: 17px;
    }

    .inventory-stat-value {
        font-size: 24px;
    }

    .inventory-search-group {
        flex-wrap: wrap;
    }

    .inventory-search-input {
        flex: 1;
        width: 60%;
    }

    .inventory-search-btn {
        flex: 1;
    }

    .inventory-clear-btn {
        margin-right: 0;
    }

    .inventory-record-badge {
        font-size: 11px;
    }

    .inventory-pagination-footer {
        padding: 15px;
    }

    .inventory-pagination-footer > div {
        align-items: flex-start !important;
    }

    .inventory-page-footer {
        line-height: 1.8;
    }
}
</style>

@endsection

