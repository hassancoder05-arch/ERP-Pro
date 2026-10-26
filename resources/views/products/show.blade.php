@extends('layouts.app')

@section('title', 'Product Details')

@section('content')

<div class="container-fluid py-4 product-details-page">


{{-- Page Header --}}
<div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="header-icon">
                <i class="bi bi-box-seam"></i>
            </span>
            <span class="text-uppercase small fw-semibold text-primary">
                Inventory Management
            </span>
        </div>

        <h2 class="fw-bold mb-1">Product Details</h2>

        <p class="text-muted mb-0">
            View product information, inventory levels and pricing details.
        </p>
    </div>

    <div class="d-flex flex-wrap gap-2">

        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-3">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Products
        </a>

        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary px-4">
            <i class="bi bi-pencil-square me-1"></i>
            Edit Product
        </a>

    </div>

</div>

{{-- Summary Cards --}}
<div class="row g-3 mb-4">

    <div class="col-sm-6 col-xl-3">
        <div class="summary-card">
            <div class="summary-icon icon-blue">
                <i class="bi bi-boxes"></i>
            </div>

            <div class="summary-content">
                <span class="summary-label">Current Stock</span>
                <h4 class="summary-value mb-0">
                    {{ number_format((float) ($product->stock ?? 0)) }}
                </h4>
                <small class="summary-hint">Units in inventory</small>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="summary-card">
            <div class="summary-icon icon-purple">
                <i class="bi bi-cart-check"></i>
            </div>

            <div class="summary-content">
                <span class="summary-label">Purchase Price</span>
                <h4 class="summary-value mb-0">
                    Rs. {{ number_format((float) ($product->purchase_price ?? 0), 2) }}
                </h4>
                <small class="summary-hint">Cost per unit</small>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="summary-card">
            <div class="summary-icon icon-green">
                <i class="bi bi-tags"></i>
            </div>

            <div class="summary-content">
                <span class="summary-label">Selling Price</span>
                <h4 class="summary-value mb-0">
                    Rs. {{ number_format((float) ($product->selling_price ?? 0), 2) }}
                </h4>
                <small class="summary-hint">Selling price per unit</small>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="summary-card">
            <div class="summary-icon icon-orange">
                <i class="bi bi-graph-up-arrow"></i>
            </div>

            <div class="summary-content">
                <span class="summary-label">Profit Per Unit</span>
                <h4 class="summary-value mb-0">
                    Rs. {{ number_format((float) $product->selling_price - (float) $product->purchase_price, 2) }}
                </h4>
                <small class="summary-hint">Estimated price difference</small>
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    {{-- Main Product Information --}}
    <div class="col-lg-8">

        <div class="details-card mb-4">

            <div class="details-card-header d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div class="d-flex align-items-center gap-3">
                    <div class="card-heading-icon">
                        <i class="bi bi-card-list"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">Product Information</h5>
                        <p class="text-muted small mb-0">
                            Product identification and specifications
                        </p>
                    </div>
                </div>

                @if($product->status === 'active')
                    <span class="status-badge status-active">
                        <span class="status-dot"></span>
                        Active Product
                    </span>
                @else
                    <span class="status-badge status-inactive">
                        <span class="status-dot"></span>
                        Inactive Product
                    </span>
                @endif

            </div>

            <div class="card-body p-4">

                <div class="row g-4">

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">
                                <i class="bi bi-upc me-1"></i>
                                Product Code / SKU
                            </span>

                            <div class="info-value">
                                <span class="product-code">
                                    {{ $product->product_code ?: 'Not assigned' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">
                                <i class="bi bi-box me-1"></i>
                                Product Name
                            </span>

                            <div class="info-value">
                                {{ $product->name }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">
                                <i class="bi bi-grid me-1"></i>
                                Category
                            </span>

                            <div class="info-value">
                                {{ $product->category ?: 'Not specified' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">
                                <i class="bi bi-award me-1"></i>
                                Brand
                            </span>

                            <div class="info-value">
                                {{ $product->brand ?: 'Not specified' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">
                                <i class="bi bi-cart me-1"></i>
                                Purchase Price
                            </span>

                            <div class="info-value">
                                Rs. {{ number_format((float) ($product->purchase_price ?? 0), 2) }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">
                                <i class="bi bi-tag me-1"></i>
                                Selling Price
                            </span>

                            <div class="info-value">
                                Rs. {{ number_format((float) ($product->selling_price ?? 0), 2) }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">
                                <i class="bi bi-boxes me-1"></i>
                                Current Stock
                            </span>

                            <div class="info-value">
                                {{ number_format((float) ($product->stock ?? 0)) }} units
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                Minimum Stock Level
                            </span>

                            <div class="info-value">
                                {{ number_format((float) ($product->minimum_stock ?? 0)) }} units
                            </div>
                        </div>
                    </div>

                </div>

                <div class="section-divider"></div>

                <div class="description-section">

                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-card-text me-2 text-primary"></i>
                        Product Description
                    </h6>

                    <div class="description-box">
                        {{ $product->description ?: 'No description has been provided for this product.' }}
                    </div>

                </div>

            </div>

        </div>

        {{-- Pricing Information --}}
        <div class="details-card">

            <div class="details-card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="card-heading-icon pricing-icon">
                        <i class="bi bi-currency-rupee"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">Pricing Overview</h5>
                        <p class="text-muted small mb-0">
                            Purchase cost compared with the selling price
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">

                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="price-box purchase-price-box">
                            <span class="price-label">Purchase Price</span>

                            <h4 class="price-value">
                                Rs. {{ number_format((float) ($product->purchase_price ?? 0), 2) }}
                            </h4>

                            <span class="price-caption">Cost per unit</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="price-box selling-price-box">
                            <span class="price-label">Selling Price</span>

                            <h4 class="price-value">
                                Rs. {{ number_format((float) ($product->selling_price ?? 0), 2) }}
                            </h4>

                            <span class="price-caption">Sale price per unit</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        @php
                            $unitProfit = (float) ($product->selling_price ?? 0)
                                - (float) ($product->purchase_price ?? 0);
                        @endphp

                        <div class="price-box profit-price-box">
                            <span class="price-label">Estimated Difference</span>

                            <h4 class="price-value {{ $unitProfit < 0 ? 'text-danger' : 'text-success' }}">
                                Rs. {{ number_format($unitProfit, 2) }}
                            </h4>

                            <span class="price-caption">Per unit before expenses</span>
                        </div>
                    </div>

                </div>

                <div class="pricing-note mt-3">
                    <i class="bi bi-info-circle me-2"></i>
                    This is a price difference, not guaranteed net profit. Taxes, discounts and operating expenses are not included.
                </div>

            </div>

        </div>

    </div>

    {{-- Inventory Sidebar --}}
    <div class="col-lg-4">

        {{-- Stock Status --}}
        <div class="details-card stock-card mb-4">

            <div class="stock-card-top">
                <div class="stock-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <span class="stock-overline">Inventory Overview</span>

                <h5 class="fw-bold mb-0">Current Stock</h5>
            </div>

            <div class="card-body p-4 text-center">

                <div class="stock-number">
                    {{ number_format((float) ($product->stock ?? 0)) }}
                </div>

                <div class="stock-unit">Units Available</div>

                @if((float) $product->stock <= (float) $product->minimum_stock)
                    <div class="stock-status stock-low mt-3">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        Low Stock
                    </div>

                    <p class="stock-message mt-3 mb-0">
                        Current stock has reached or fallen below the minimum stock level.
                    </p>
                @else
                    <div class="stock-status stock-available mt-3">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        Stock Available
                    </div>

                    <p class="stock-message mt-3 mb-0">
                        Current stock is above the minimum stock level.
                    </p>
                @endif

                <div class="stock-divider"></div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="stock-detail-label">Current Quantity</span>
                    <strong>{{ number_format((float) ($product->stock ?? 0)) }}</strong>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <span class="stock-detail-label">Minimum Required</span>
                    <strong>{{ number_format((float) ($product->minimum_stock ?? 0)) }}</strong>
                </div>

            </div>

        </div>

        {{-- Estimated Inventory Value --}}
        <div class="details-card mb-4">

            <div class="details-card-header compact-header">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-calculator me-2 text-primary"></i>
                    Inventory Valuation
                </h6>
            </div>

            <div class="card-body p-4">

                <div class="valuation-row">
                    <span>Purchase Value</span>

                    <strong>
                        Rs. {{ number_format((float) ($product->stock ?? 0) * (float) ($product->purchase_price ?? 0), 2) }}
                    </strong>
                </div>

                <div class="valuation-row">
                    <span>Potential Sales Value</span>

                    <strong>
                        Rs. {{ number_format((float) ($product->stock ?? 0) * (float) ($product->selling_price ?? 0), 2) }}
                    </strong>
                </div>

                <div class="valuation-footnote mt-3">
                    <i class="bi bi-info-circle me-1"></i>
                    Estimates based on current stock and recorded unit prices.
                </div>

            </div>

        </div>

        {{-- Quick Actions --}}
        <div class="details-card">

            <div class="details-card-header compact-header">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-lightning-charge me-2 text-primary"></i>
                    Quick Actions
                </h6>
            </div>

            <div class="card-body p-3">

                <a href="{{ route('products.edit', $product) }}" class="quick-action">
                    <span class="quick-action-icon">
                        <i class="bi bi-pencil-square"></i>
                    </span>

                    <span class="quick-action-content">
                        <strong>Edit Product</strong>
                        <small>Update product information</small>
                    </span>

                    <i class="bi bi-chevron-right quick-action-arrow"></i>
                </a>

                <a href="{{ route('products.index') }}" class="quick-action">
                    <span class="quick-action-icon secondary-action-icon">
                        <i class="bi bi-grid"></i>
                    </span>

                    <span class="quick-action-content">
                        <strong>All Products</strong>
                        <small>Return to product list</small>
                    </span>

                    <i class="bi bi-chevron-right quick-action-arrow"></i>
                </a>

            </div>

        </div>

    </div>

</div>


</div>

<style>
.product-details-page {
    --product-primary: #4f46e5;
    --product-primary-light: #eef2ff;
    --product-text: #172033;
    --product-muted: #718096;
    --product-border: #e8edf4;
    color: var(--product-text);
}

.product-details-page .page-header h2 {
    color: var(--product-text);
    font-size: clamp(1.5rem, 2vw, 1.9rem);
    letter-spacing: -.6px;
}

.product-details-page .header-icon {
    width: 39px;
    height: 39px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    color: var(--product-primary);
    background: var(--product-primary-light);
    font-size: 20px;
}

.product-details-page .btn {
    padding-top: 10px;
    padding-bottom: 10px;
    border-radius: 10px;
    font-weight: 600;
    transition: all .2s ease;
}

.product-details-page .btn-primary {
    background: var(--product-primary);
    border-color: var(--product-primary);
    box-shadow: 0 4px 12px rgba(79, 70, 229, .13);
}

.product-details-page .btn-primary:hover {
    background: #4338ca;
    border-color: #4338ca;
    transform: translateY(-1px);
}

.product-details-page .summary-card {
    display: flex;
    align-items: center;
    gap: 14px;
    min-height: 112px;
    height: 100%;
    padding: 19px;
    border: 1px solid var(--product-border);
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 4px 16px rgba(15, 23, 42, .025);
}

.product-details-page .summary-icon {
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    font-size: 21px;
}

.product-details-page .icon-blue {
    color: #2563eb;
    background: #eaf2ff;
}

.product-details-page .icon-purple {
    color: #7c3aed;
    background: #f1eaff;
}

.product-details-page .icon-green {
    color: #15803d;
    background: #e6f8ef;
}

.product-details-page .icon-orange {
    color: #c2410c;
    background: #fff0df;
}

.product-details-page .summary-content {
    min-width: 0;
}

.product-details-page .summary-label {
    display: block;
    margin-bottom: 6px;
    color: var(--product-muted);
    font-size: 11px;
    font-weight: 650;
}

.product-details-page .summary-value {
    font-size: 17px;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.product-details-page .summary-hint {
    display: block;
    margin-top: 5px;
    color: #94a3b8;
    font-size: 10px;
}

.product-details-page .details-card {
    overflow: hidden;
    border: 1px solid var(--product-border);
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 5px 20px rgba(15, 23, 42, .035);
}

.product-details-page .details-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--product-border);
    background: #fff;
}

.product-details-page .details-card-header h5 {
    color: var(--product-text);
    font-size: 16px;
}

.product-details-page .details-card-header p {
    font-size: 12px;
}

.product-details-page .card-heading-icon {
    width: 43px;
    height: 43px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    color: var(--product-primary);
    background: #eef2ff;
    font-size: 20px;
}

.product-details-page .pricing-icon {
    color: #15803d;
    background: #e6f8ef;
}

.product-details-page .info-field {
    min-height: 64px;
}

.product-details-page .info-label {
    display: block;
    margin-bottom: 8px;
    color: var(--product-muted);
    font-size: 12px;
    font-weight: 600;
}

.product-details-page .info-label i {
    color: #94a3b8;
}

.product-details-page .info-value {
    color: var(--product-text);
    font-size: 14px;
    font-weight: 650;
    overflow-wrap: anywhere;
}

.product-details-page .product-code {
    display: inline-block;
    padding: 5px 9px;
    border: 1px solid #dbeafe;
    border-radius: 7px;
    color: #3730a3;
    background: #eef2ff;
    font-size: 12px;
    font-weight: 750;
}

.product-details-page .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 11px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 750;
}

.product-details-page .status-active {
    color: #15803d;
    background: #dcfce7;
}

.product-details-page .status-inactive {
    color: #64748b;
    background: #f1f5f9;
}

.product-details-page .status-dot {
    width: 6px;
    height: 6px;
    display: inline-block;
    border-radius: 50%;
    background: currentColor;
}

.product-details-page .section-divider {
    height: 1px;
    margin: 25px 0;
    background: var(--product-border);
}

.product-details-page .description-section h6 {
    font-size: 14px;
}

.product-details-page .description-box {
    padding: 16px;
    border: 1px solid var(--product-border);
    border-radius: 11px;
    background: #f8fafc;
    color: #475569;
    font-size: 13px;
    line-height: 1.8;
    white-space: pre-line;
    overflow-wrap: anywhere;
}

.product-details-page .price-box {
    height: 100%;
    padding: 17px 14px;
    border: 1px solid var(--product-border);
    border-radius: 12px;
}

.product-details-page .purchase-price-box {
    background: #f8fafc;
}

.product-details-page .selling-price-box {
    border-color: #dbeafe;
    background: #eff6ff;
}

.product-details-page .profit-price-box {
    border-color: #d9f0e3;
    background: #f0fdf4;
}

.product-details-page .price-label {
    display: block;
    margin-bottom: 10px;
    color: var(--product-muted);
    font-size: 11px;
    font-weight: 650;
}

.product-details-page .price-value {
    font-size: 17px;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.product-details-page .price-caption {
    display: block;
    margin-top: 8px;
    color: #94a3b8;
    font-size: 10px;
}

.product-details-page .pricing-note {
    display: flex;
    align-items: flex-start;
    padding: 12px 14px;
    border-radius: 9px;
    color: #64748b;
    background: #f8fafc;
    font-size: 11px;
    line-height: 1.7;
}

.product-details-page .stock-card-top {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 25px 20px 22px;
    color: #fff;
    background: linear-gradient(135deg, #3730a3, #6366f1);
}

.product-details-page .stock-icon {
    width: 55px;
    height: 55px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 16px;
    background: rgba(255,255,255,.14);
    font-size: 27px;
}

.product-details-page .stock-overline {
    margin-bottom: 7px;
    color: #e0e7ff;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.product-details-page .stock-card-top h5 {
    font-size: 17px;
}

.product-details-page .stock-number {
    color: var(--product-text);
    font-size: clamp(44px, 5vw, 58px);
    font-weight: 850;
    letter-spacing: -2px;
    line-height: 1.2;
    overflow-wrap: anywhere;
}

.product-details-page .stock-unit {
    margin-top: 4px;
    color: var(--product-muted);
    font-size: 12px;
}

.product-details-page .stock-status {
    display: inline-flex;
    align-items: center;
    padding: 8px 13px;
    border-radius: 22px;
    font-size: 12px;
    font-weight: 750;
}

.product-details-page .stock-low {
    color: #b91c1c;
    background: #fee2e2;
}

.product-details-page .stock-available {
    color: #15803d;
    background: #dcfce7;
}

.product-details-page .stock-message {
    color: var(--product-muted);
    font-size: 11px;
    line-height: 1.7;
}

.product-details-page .stock-divider {
    height: 1px;
    margin: 22px 0;
    background: var(--product-border);
}

.product-details-page .stock-detail-label {
    color: var(--product-muted);
    font-size: 12px;
}

.product-details-page .stock-card .card-body strong {
    font-size: 13px;
}

.product-details-page .compact-header {
    padding: 17px 20px;
}

.product-details-page .valuation-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
}

.product-details-page .valuation-row:last-of-type {
    border-bottom: 0;
}

.product-details-page .valuation-row span {
    color: var(--product-muted);
    font-size: 12px;
}

.product-details-page .valuation-row strong {
    color: var(--product-text);
    font-size: 12px;
    text-align: right;
    overflow-wrap: anywhere;
}

.product-details-page .valuation-footnote {
    color: #94a3b8;
    font-size: 10px;
    line-height: 1.7;
}

.product-details-page .quick-action {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 10px;
    border-radius: 11px;
    color: var(--product-text);
    text-decoration: none;
    transition: background .2s ease;
}

.product-details-page .quick-action:hover {
    background: #f8fafc;
}

.product-details-page .quick-action-icon {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    color: var(--product-primary);
    background: #eef2ff;
    font-size: 17px;
}

.product-details-page .secondary-action-icon {
    color: #475569;
    background: #f1f5f9;
}

.product-details-page .quick-action-content {
    min-width: 0;
    display: flex;
    flex: 1;
    flex-direction: column;
    gap: 4px;
}

.product-details-page .quick-action-content strong {
    font-size: 12px;
}

.product-details-page .quick-action-content small {
    color: var(--product-muted);
    font-size: 10px;
}

.product-details-page .quick-action-arrow {
    color: #94a3b8;
    font-size: 13px;
}

@media (max-width: 767.98px) {
    .product-details-page .details-card-header {
        padding: 17px;
    }

    .product-details-page .details-card .card-body {
        padding: 20px !important;
    }

    .product-details-page .summary-card {
        padding: 15px;
    }

    .product-details-page .summary-value {
        font-size: 15px;
    }

    .product-details-page .price-value {
        font-size: 16px;
    }
}
</style>

@endsection
