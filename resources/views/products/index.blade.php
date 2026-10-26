
@extends('layouts.app')

@section('title', 'Product Management')

@section('content')

<div class="container-fluid product-page py-4">

    {{-- ================= PAGE HEADER ================= --}}
    <div class="product-page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">

        <div class="d-flex align-items-center gap-3">

            <div class="page-icon">
                <i class="bi bi-box-seam"></i>
            </div>

            <div>
                <h2 class="page-title mb-1">Product Management</h2>

                <p class="page-subtitle mb-0">
                    Manage products, pricing and inventory levels.
                </p>
            </div>

        </div>

        <a href="{{ route('products.create') }}"
           class="btn btn-add-product">

            <i class="bi bi-plus-lg me-2"></i>
            Add New Product

        </a>

    </div>


    {{-- ================= FLASH MESSAGES ================= --}}
    @if(session('success'))

        <div class="alert custom-alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert custom-alert alert-danger alert-dismissible fade show"
             role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if($errors->any())

        <div class="alert custom-alert alert-danger alert-dismissible fade show"
             role="alert">

            <div class="d-flex align-items-start">

                <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>

                <div>
                    <strong>Please correct the following errors:</strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>
                </div>

            </div>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ================= STATISTICS ================= --}}
    <div class="row g-3 mb-4">

        {{-- Total Products --}}
        <div class="col-12 col-sm-6 col-xl">

            <div class="stat-card stat-blue h-100">

                <div class="stat-card-top">

                    <div>
                        <p class="stat-label">Total Products</p>
                        <h3 class="stat-number">{{ $totalProducts }}</h3>
                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>

                </div>

                <div class="stat-footer">
                    <span>All registered products</span>
                    <i class="bi bi-arrow-up-right"></i>
                </div>

            </div>

        </div>


        {{-- Active Products --}}
        <div class="col-12 col-sm-6 col-xl">

            <div class="stat-card stat-green h-100">

                <div class="stat-card-top">

                    <div>
                        <p class="stat-label">Active Products</p>
                        <h3 class="stat-number">{{ $activeProducts }}</h3>
                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>

                </div>

                <div class="stat-footer">
                    <span>Currently active</span>
                    <i class="bi bi-check2-circle"></i>
                </div>

            </div>

        </div>


        {{-- Inactive Products --}}
        <div class="col-12 col-sm-6 col-xl">

            <div class="stat-card stat-gray h-100">

                <div class="stat-card-top">

                    <div>
                        <p class="stat-label">Inactive Products</p>
                        <h3 class="stat-number">{{ $inactiveProducts }}</h3>
                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-pause-circle"></i>
                    </div>

                </div>

                <div class="stat-footer">
                    <span>Currently inactive</span>
                    <i class="bi bi-dash-circle"></i>
                </div>

            </div>

        </div>


        {{-- Low Stock --}}
        <div class="col-12 col-sm-6 col-xl">

            <div class="stat-card stat-orange h-100">

                <div class="stat-card-top">

                    <div>
                        <p class="stat-label">Low Stock</p>
                        <h3 class="stat-number">{{ $lowStockProducts }}</h3>
                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>

                </div>

                <div class="stat-footer">
                    <span>Below minimum threshold</span>
                    <i class="bi bi-arrow-down-right"></i>
                </div>

            </div>

        </div>


        {{-- Out of Stock --}}
        <div class="col-12 col-sm-6 col-xl">

            <div class="stat-card stat-red h-100">

                <div class="stat-card-top">

                    <div>
                        <p class="stat-label">Out of Stock</p>
                        <h3 class="stat-number">{{ $outOfStockProducts }}</h3>
                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-x-circle"></i>
                    </div>

                </div>

                <div class="stat-footer">
                    <span>No stock available</span>
                    <i class="bi bi-exclamation-circle"></i>
                </div>

            </div>

        </div>

    </div>


    {{-- ================= INVENTORY ALERT ================= --}}
    @if($outOfStockProducts > 0 || $lowStockProducts > 0)

        <div class="inventory-alert mb-4">

            <div class="inventory-alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>

            <div class="flex-grow-1">

                <h6 class="fw-bold mb-1">Inventory Attention Required</h6>

                <p class="mb-0">

                    @if($outOfStockProducts > 0)
                        <span>
                            {{ $outOfStockProducts }} product(s) are out of stock.
                        </span>
                    @endif

                    @if($outOfStockProducts > 0 && $lowStockProducts > 0)
                        <span class="mx-1">|</span>
                    @endif

                    @if($lowStockProducts > 0)
                        <span>
                            {{ $lowStockProducts }} product(s) have low stock.
                        </span>
                    @endif

                </p>

            </div>

            <i class="bi bi-arrow-right inventory-alert-arrow"></i>

        </div>

    @else

        <div class="inventory-success mb-4">

            <i class="bi bi-check-circle-fill me-2"></i>

            <span>
                Inventory looks good. All products are above their minimum stock levels.
            </span>

        </div>

    @endif


    {{-- ================= SEARCH PANEL ================= --}}
    <div class="content-card mb-4">

        <div class="content-card-header">

            <div class="d-flex align-items-center gap-2">

                <div class="small-section-icon">
                    <i class="bi bi-search"></i>
                </div>

                <div>
                    <h5 class="content-title mb-1">Find Products</h5>

                    <p class="content-subtitle mb-0">
                        Search by product name, SKU, category or brand.
                    </p>
                </div>

            </div>

        </div>


        <div class="content-card-body">

            <form method="GET"
                  action="{{ route('products.index') }}">

                <div class="row g-3 align-items-center">

                    <div class="col-12 col-lg-9">

                        <div class="search-input-wrapper">

                            <i class="bi bi-search search-input-icon"></i>

                            <input
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                class="form-control product-search-input"
                                placeholder="Search products, SKU, category or brand..."
                                maxlength="100"
                                aria-label="Search products"
                            >

                            @if($search !== '')
                                <a href="{{ route('products.index') }}"
                                   class="search-clear"
                                   title="Clear search"
                                   aria-label="Clear search">

                                    <i class="bi bi-x-circle"></i>

                                </a>
                            @endif

                        </div>

                    </div>


                    <div class="col-12 col-lg-3">

                        <div class="d-flex gap-2">

                            <button type="submit"
                                    class="btn btn-search flex-grow-1">

                                <i class="bi bi-search me-2"></i>
                                Search

                            </button>

                            @if($search !== '')

                                <a href="{{ route('products.index') }}"
                                   class="btn btn-clear"
                                   title="Clear search">

                                    <i class="bi bi-arrow-counterclockwise"></i>

                                </a>

                            @endif

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ================= PRODUCT INVENTORY TABLE ================= --}}
    <div class="content-card inventory-table-card">

        {{-- Table Header --}}
        <div class="content-card-header table-header-flex">

            <div class="d-flex align-items-center gap-3">

                <div class="small-section-icon table-heading-icon">
                    <i class="bi bi-grid-1x2"></i>
                </div>

                <div>

                    <h5 class="content-title mb-1">
                        Product Inventory
                    </h5>

                    <p class="content-subtitle mb-0">
                        View and manage your registered products.
                    </p>

                </div>

            </div>


            <div class="table-count">

                <i class="bi bi-box-seam me-2"></i>

                {{ $products->total() }} Products

            </div>

        </div>


        {{-- Table --}}
        <div class="table-responsive">

            <table class="table product-table align-middle mb-0">

                <thead>

                    <tr>
                        <th class="ps-4">#</th>
                        <th>Product Details</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Purchase Price</th>
                        <th>Selling Price</th>
                        <th>Stock Status</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Actions</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse($products as $product)

                        @php
                            $isOutOfStock = $product->stock <= 0;

                            $isLowStock = !$isOutOfStock
                                && $product->stock <= $product->minimum_stock;
                        @endphp


                        <tr>

                            {{-- Number --}}
                            <td class="ps-4">

                                <span class="row-number">
                                    {{ $products->firstItem() + $loop->index }}
                                </span>

                            </td>


                            {{-- Product Details --}}
                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    <div class="product-avatar">
                                        <i class="bi bi-box-seam"></i>
                                    </div>

                                    <div class="product-info">

                                        <div class="product-name">
                                            {{ $product->name }}
                                        </div>

                                        <div class="product-sku">
                                            <i class="bi bi-upc-scan me-1"></i>
                                            {{ $product->product_code }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Category --}}
                            <td>

                                @if($product->category)

                                    <span class="category-badge">
                                        {{ $product->category }}
                                    </span>

                                @else

                                    <span class="text-muted">—</span>

                                @endif

                            </td>


                            {{-- Brand --}}
                            <td>

                                <span class="brand-text">
                                    {{ $product->brand ?: '—' }}
                                </span>

                            </td>


                            {{-- Purchase Price --}}
                            <td>

                                <span class="price-text">
                                    Rs. {{ number_format((float) $product->purchase_price, 2) }}
                                </span>

                            </td>


                            {{-- Selling Price --}}
                            <td>

                                <span class="selling-price">
                                    Rs. {{ number_format((float) $product->selling_price, 2) }}
                                </span>

                            </td>


                            {{-- Stock --}}
                            <td>

                                <div class="stock-information">

                                    @if($isOutOfStock)

                                        <span class="stock-badge stock-danger">
                                            <i class="bi bi-x-circle-fill me-1"></i>
                                            {{ $product->stock }} Units
                                        </span>

                                        <small class="stock-description text-danger">
                                            Out of stock
                                        </small>

                                    @elseif($isLowStock)

                                        <span class="stock-badge stock-warning">
                                            <i class="bi bi-exclamation-circle-fill me-1"></i>
                                            {{ $product->stock }} Units
                                        </span>

                                        <small class="stock-description text-warning-emphasis">
                                            Low stock
                                        </small>

                                    @else

                                        <span class="stock-badge stock-success">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            {{ $product->stock }} Units
                                        </span>

                                        <small class="stock-description text-success">
                                            In stock
                                        </small>

                                    @endif

                                    <small class="minimum-stock">
                                        Minimum: {{ $product->minimum_stock }}
                                    </small>

                                </div>

                            </td>


                            {{-- Product Status --}}
                            <td>

                                @if($product->status === 'active')

                                    <span class="status-badge status-active">
                                        <span class="status-dot"></span>
                                        Active
                                    </span>

                                @else

                                    <span class="status-badge status-inactive">
                                        <span class="status-dot"></span>
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="text-center pe-4">

                                <div class="product-actions">

                                    {{-- View --}}
                                    <a
                                        href="{{ route('products.show', $product) }}"
                                        class="action-btn action-view"
                                        title="View Product"
                                        aria-label="View Product"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </a>


                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('products.edit', $product) }}"
                                        class="action-btn action-edit"
                                        title="Edit Product"
                                        aria-label="Edit Product"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </a>


                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('products.destroy', $product) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this product?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-btn action-delete"
                                            title="Delete Product"
                                            aria-label="Delete Product"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="9">

                                <div class="empty-state">

                                    <div class="empty-state-icon">
                                        <i class="bi bi-box-seam"></i>
                                    </div>

                                    <h5 class="fw-bold mt-3 mb-2">
                                        No Products Found
                                    </h5>

                                    <p class="text-muted mb-3">

                                        @if($search !== '')

                                            No products match your search.
                                            Try another keyword.

                                        @else

                                            You haven't added any products yet.
                                            Start by adding your first product.

                                        @endif

                                    </p>


                                    @if($search !== '')

                                        <a href="{{ route('products.index') }}"
                                           class="btn btn-clear">

                                            <i class="bi bi-arrow-counterclockwise me-2"></i>
                                            Clear Search

                                        </a>

                                    @else

                                        <a href="{{ route('products.create') }}"
                                           class="btn btn-add-product">

                                            <i class="bi bi-plus-lg me-2"></i>
                                            Add Your First Product

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
        @if($products->hasPages() || $products->total() > 0)

            <div class="pagination-footer">

                <div class="pagination-info">

                    Showing

                    <strong>{{ $products->firstItem() ?? 0 }}</strong>

                    to

                    <strong>{{ $products->lastItem() ?? 0 }}</strong>

                    of

                    <strong>{{ $products->total() }}</strong>

                    products

                </div>


                <div class="pagination-links">

                    {{ $products->appends(request()->query())->links() }}

                </div>

            </div>

        @endif

    </div>


    {{-- Footer --}}
    <div class="product-page-footer">

        <span>
            <i class="bi bi-shield-check me-1"></i>
            ERP-Pro Inventory Management
        </span>

        <span>
            Product records: {{ $products->total() }}
        </span>

    </div>

</div>


{{-- ================= CUSTOM CSS ================= --}}
<style>

    .product-page {
        color: #1e293b;
    }

    /* Header */

    .page-icon {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        font-size: 27px;
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.20);
        flex-shrink: 0;
    }

    .page-title {
        color: #0f172a;
        font-size: clamp(22px, 2vw, 29px);
        font-weight: 750;
        letter-spacing: -0.7px;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 14px;
    }

    .btn-add-product {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        min-height: 45px;
        padding: 11px 20px;
        border-radius: 10px;
        border: 1px solid #4f46e5;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 5px 12px rgba(79, 70, 229, 0.15);
        transition: all 0.2s ease;
    }

    .btn-add-product:hover {
        background: #4338ca;
        border-color: #4338ca;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 7px 16px rgba(79, 70, 229, 0.22);
    }


    /* Alerts */

    .custom-alert {
        border: 0;
        border-radius: 12px;
        padding: 16px 18px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
    }


    /* Statistics */

    .stat-card {
        position: relative;
        padding: 20px;
        overflow: hidden;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.035);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 9px 22px rgba(15, 23, 42, 0.075);
    }

    .stat-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .stat-label {
        margin-bottom: 8px;
        color: #64748b;
        font-size: 12px;
        font-weight: 650;
        letter-spacing: 0.25px;
    }

    .stat-number {
        margin-bottom: 0;
        color: #0f172a;
        font-size: 30px;
        line-height: 1.2;
        font-weight: 750;
    }

    .stat-icon {
        width: 49px;
        height: 49px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 23px;
        flex-shrink: 0;
    }

    .stat-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 5px;
        margin-top: 19px;
        padding-top: 13px;
        border-top: 1px solid #f1f5f9;
        color: #94a3b8;
        font-size: 11px;
    }

    .stat-footer i {
        font-size: 14px;
    }

    .stat-blue .stat-icon {
        color: #4f46e5;
        background: #eef2ff;
    }

    .stat-green .stat-icon {
        color: #059669;
        background: #d1fae5;
    }

    .stat-gray .stat-icon {
        color: #64748b;
        background: #f1f5f9;
    }

    .stat-orange .stat-icon {
        color: #d97706;
        background: #fef3c7;
    }

    .stat-red .stat-icon {
        color: #dc2626;
        background: #fee2e2;
    }


    /* Inventory Alerts */

    .inventory-alert {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 19px 21px;
        border: 1px solid #fde68a;
        border-radius: 13px;
        background: #fffbeb;
        color: #92400e;
    }

    .inventory-alert-icon {
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #fef3c7;
        color: #d97706;
        font-size: 21px;
        flex-shrink: 0;
    }

    .inventory-alert h6 {
        color: #78350f;
    }

    .inventory-alert p {
        color: #92400e;
        font-size: 13px;
        line-height: 1.7;
    }

    .inventory-alert-arrow {
        margin-left: auto;
        font-size: 21px;
        opacity: 0.6;
    }

    .inventory-success {
        display: flex;
        align-items: center;
        padding: 17px 20px;
        border: 1px solid #a7f3d0;
        border-radius: 12px;
        background: #ecfdf5;
        color: #047857;
        font-size: 13px;
    }


    /* Main Cards */

    .content-card {
        overflow: hidden;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 3px 14px rgba(15, 23, 42, 0.035);
    }

    .content-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 21px 24px;
        border-bottom: 1px solid #edf1f6;
        background: #fff;
    }

    .content-card-body {
        padding: 22px 24px;
    }

    .content-title {
        color: #0f172a;
        font-size: 16px;
        font-weight: 750;
    }

    .content-subtitle {
        color: #94a3b8;
        font-size: 12px;
        line-height: 1.6;
    }

    .small-section-icon {
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 19px;
        flex-shrink: 0;
    }


    /* Search */

    .search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input-icon {
        position: absolute;
        left: 15px;
        color: #94a3b8;
        font-size: 17px;
        pointer-events: none;
    }

    .product-search-input {
        min-height: 47px;
        padding: 12px 44px;
        border: 1px solid #e2e8f0;
        border-radius: 10px !important;
        background: #f8fafc;
        color: #334155;
        font-size: 13px;
    }

    .product-search-input:focus {
        border-color: #818cf8;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.10);
    }

    .search-clear {
        position: absolute;
        right: 14px;
        display: flex;
        align-items: center;
        color: #94a3b8;
        font-size: 18px;
        text-decoration: none;
    }

    .search-clear:hover {
        color: #dc2626;
    }

    .btn-search {
        min-height: 47px;
        border-radius: 10px;
        background: #0f172a;
        color: #fff;
        font-size: 13px;
        font-weight: 650;
        transition: background 0.2s ease;
    }

    .btn-search:hover {
        background: #334155;
        color: #fff;
    }

    .btn-clear {
        min-height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dbe2ea;
        border-radius: 9px;
        background: #fff;
        color: #475569;
    }

    .btn-clear:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
        color: #0f172a;
    }


    /* Table Header */

    .table-heading-icon {
        background: #f1f5f9;
        color: #475569;
    }

    .table-count {
        padding: 9px 13px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 650;
        white-space: nowrap;
    }


    /* Product Table */

    .product-table {
        min-width: 1120px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .product-table thead th {
        padding: 15px 12px;
        border-top: 0;
        border-bottom: 1px solid #e8edf4;
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        font-weight: 750;
        letter-spacing: 0.65px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .product-table tbody td {
        padding: 17px 12px;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 12px;
        vertical-align: middle;
    }

    .product-table tbody tr {
        transition: background 0.15s ease;
    }

    .product-table tbody tr:hover {
        background: #fafbff;
    }

    .product-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .row-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 29px;
        height: 29px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
    }


    /* Product Information */

    .product-avatar {
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e0e7ff;
        border-radius: 12px;
        background: linear-gradient(135deg, #eef2ff, #f5f3ff);
        color: #6366f1;
        font-size: 20px;
        flex-shrink: 0;
    }

    .product-name {
        max-width: 220px;
        overflow-wrap: anywhere;
        color: #1e293b;
        font-size: 12px;
        font-weight: 750;
        line-height: 1.6;
    }

    .product-sku {
        margin-top: 4px;
        color: #94a3b8;
        font-size: 10px;
        white-space: nowrap;
    }

    .category-badge {
        display: inline-block;
        padding: 6px 9px;
        border: 1px solid #e0e7ff;
        border-radius: 7px;
        background: #eef2ff;
        color: #4338ca;
        font-size: 10px;
        font-weight: 650;
    }

    .brand-text {
        color: #475569;
        font-weight: 550;
    }

    .price-text {
        color: #64748b;
        font-size: 11px;
        font-weight: 550;
        white-space: nowrap;
    }

    .selling-price {
        color: #0f172a;
        font-size: 11px;
        font-weight: 750;
        white-space: nowrap;
    }


    /* Stock Badges */

    .stock-information {
        display: flex;
        align-items: flex-start;
        flex-direction: column;
        gap: 5px;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 8px;
        border-radius: 7px;
        font-size: 10px;
        font-weight: 750;
        white-space: nowrap;
    }

    .stock-danger {
        background: #fee2e2;
        color: #b91c1c;
    }

    .stock-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .stock-success {
        background: #d1fae5;
        color: #047857;
    }

    .stock-description {
        font-size: 10px;
        font-weight: 650;
    }

    .minimum-stock {
        color: #94a3b8;
        font-size: 10px;
    }


    /* Status Badges */

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 750;
        white-space: nowrap;
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-active {
        background: #d1fae5;
        color: #047857;
    }

    .status-inactive {
        background: #f1f5f9;
        color: #64748b;
    }


    /* Action Buttons */

    .product-actions {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
    }

    .action-btn {
        width: 33px;
        height: 33px;
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

    .action-edit {
        border-color: #c7d2fe;
        background: #eef2ff;
        color: #4f46e5;
    }

    .action-edit:hover {
        border-color: #4f46e5;
        background: #4f46e5;
        color: #fff;
    }

    .action-delete {
        border-color: #fecaca;
        background: #fff1f2;
        color: #e11d48;
    }

    .action-delete:hover {
        border-color: #e11d48;
        background: #e11d48;
        color: #fff;
    }


    /* Empty State */

    .empty-state {
        display: flex;
        align-items: center;
        flex-direction: column;
        padding: 65px 20px;
        text-align: center;
    }

    .empty-state-icon {
        width: 75px;
        height: 75px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 22px;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 35px;
    }

    .empty-state h5 {
        color: #1e293b;
    }

    .empty-state p {
        max-width: 400px;
        font-size: 13px;
        line-height: 1.8;
    }


    /* Pagination */

    .pagination-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        padding: 20px 24px;
        border-top: 1px solid #edf1f6;
        background: #fff;
    }

    .pagination-info {
        color: #94a3b8;
        font-size: 12px;
    }

    .pagination-info strong {
        color: #475569;
    }

    .pagination-links nav p {
        margin-bottom: 0;
    }

    .pagination-links .pagination {
        margin-bottom: 0;
        gap: 4px;
    }

    .pagination-links .page-link {
        border-radius: 7px;
        border-color: #e2e8f0;
        color: #475569;
        font-size: 12px;
    }

    .pagination-links .page-item.active .page-link {
        border-color: #4f46e5;
        background: #4f46e5;
        color: #fff;
    }


    /* Footer */

    .product-page-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 18px 4px 4px;
        color: #94a3b8;
        font-size: 11px;
    }


    /* Responsive Design */

    @media (max-width: 991.98px) {

        .content-card-header {
            padding: 18px;
        }

        .content-card-body {
            padding: 18px;
        }

        .table-header-flex {
            align-items: flex-start;
        }

        .stat-number {
            font-size: 27px;
        }

    }


    @media (max-width: 575.98px) {

        .product-page {
            padding-top: 18px !important;
        }

        .page-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            font-size: 22px;
        }

        .page-title {
            font-size: 21px;
            letter-spacing: -0.4px;
        }

        .page-subtitle {
            font-size: 12px;
        }

        .btn-add-product {
            width: 100%;
        }

        .stat-card {
            padding: 16px;
        }

        .stat-number {
            font-size: 26px;
        }

        .stat-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            font-size: 20px;
        }

        .stat-footer {
            font-size: 10px;
        }

        .inventory-alert {
            align-items: flex-start;
            padding: 15px;
            gap: 10px;
        }

        .inventory-alert-icon {
            width: 36px;
            height: 36px;
            font-size: 17px;
        }

        .inventory-alert-arrow {
            display: none;
        }

        .content-card-header {
            align-items: flex-start;
            padding: 16px;
        }

        .content-card-body {
            padding: 16px;
        }

        .table-header-flex {
            flex-direction: column;
        }

        .table-count {
            align-self: flex-start;
        }

        .pagination-footer {
            align-items: flex-start;
            padding: 16px;
        }

        .pagination-links {
            max-width: 100%;
            overflow-x: auto;
        }

        .product-page-footer {
            align-items: flex-start;
            flex-direction: column;
        }

    }

</style>

@endsection
