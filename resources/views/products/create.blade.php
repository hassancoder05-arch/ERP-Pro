@extends('layouts.app')

@section('title', 'Add Product')

@section('content')

<div class="container-fluid py-3">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge rounded-pill text-bg-primary px-3 py-2">
                    <i class="bi bi-box-seam me-1"></i> Inventory
                </span>
                <span class="text-muted small">Product Management</span>
            </div>

            <h2 class="fw-bold mb-1">Add New Product</h2>

            <p class="text-muted mb-0">
                Add product details, pricing and stock information.
            </p>
        </div>

        <a href="{{ route('products.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Products
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex gap-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
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
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- Main Form --}}
            <div class="col-xl-8">

                {{-- Basic Information --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-info-circle text-primary me-2"></i>
                            Basic Information
                        </h5>
                        <p class="text-muted small mb-0">
                            Enter the product identification details.
                        </p>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">

                            {{-- Product Code --}}
                            <div class="col-md-6">
                                <label for="product_code" class="form-label fw-semibold">
                                    Product Code / SKU <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="product_code"
                                    name="product_code"
                                    value="{{ old('product_code') }}"
                                    class="form-control @error('product_code') is-invalid @enderror"
                                    placeholder="e.g. PROD-001"
                                    maxlength="100"
                                    autocomplete="off"
                                    required
                                >

                                @error('product_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Product Name --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">
                                    Product Name <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter product name"
                                    maxlength="255"
                                    required
                                >

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Category Dropdown --}}
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-semibold">
                                    Category
                                </label>

                                <select
                                    id="category"
                                    name="category"
                                    class="form-select @error('category') is-invalid @enderror"
                                >
                                    <option value="">Select a category</option>

                                    @forelse($categories as $category)
                                        <option
                                            value="{{ $category->name }}"
                                            {{ old('category') === $category->name ? 'selected' : '' }}
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @empty
                                        <option value="" disabled>No active categories available</option>
                                    @endforelse
                                </select>

                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if($categories->isEmpty())
                                    <small class="text-warning d-block mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        Create an active category before adding a categorized product.
                                    </small>
                                @endif
                            </div>

                            {{-- Brand --}}
                            <div class="col-md-6">
                                <label for="brand" class="form-label fw-semibold">
                                    Brand
                                </label>

                                <input
                                    type="text"
                                    id="brand"
                                    name="brand"
                                    value="{{ old('brand') }}"
                                    class="form-control @error('brand') is-invalid @enderror"
                                    placeholder="e.g. Samsung"
                                    maxlength="100"
                                >

                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">
                                    Description
                                </label>

                                <textarea
                                    id="description"
                                    name="description"
                                    rows="4"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter product details, specifications or notes..."
                                >{{ old('description') }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Pricing --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-currency-exchange text-success me-2"></i>
                            Pricing Information
                        </h5>
                        <p class="text-muted small mb-0">
                            Set the purchase cost and selling price in Pakistani rupees.
                        </p>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">

                            {{-- Purchase Price --}}
                            <div class="col-md-6">
                                <label for="purchase_price" class="form-label fw-semibold">
                                    Purchase Price (Rs.) <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">Rs.</span>
                                    <input
                                        type="number"
                                        id="purchase_price"
                                        name="purchase_price"
                                        value="{{ old('purchase_price', 0) }}"
                                        class="form-control @error('purchase_price') is-invalid @enderror"
                                        min="0"
                                        step="0.01"
                                        required
                                    >
                                </div>

                                @error('purchase_price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Selling Price --}}
                            <div class="col-md-6">
                                <label for="selling_price" class="form-label fw-semibold">
                                    Selling Price (Rs.) <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">Rs.</span>
                                    <input
                                        type="number"
                                        id="selling_price"
                                        name="selling_price"
                                        value="{{ old('selling_price', 0) }}"
                                        class="form-control @error('selling_price') is-invalid @enderror"
                                        min="0"
                                        step="0.01"
                                        required
                                    >
                                </div>

                                @error('selling_price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="alert alert-light border mb-0">
                                    <i class="bi bi-lightbulb text-warning me-2"></i>
                                    <span class="small text-muted">
                                        Selling price is the price charged to customers. Verify both prices before saving.
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Stock Information --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-boxes text-warning me-2"></i>
                            Stock Information
                        </h5>
                        <p class="text-muted small mb-0">
                            Configure available stock and the low-stock warning threshold.
                        </p>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">

                            {{-- Current Stock --}}
                            <div class="col-md-6">
                                <label for="stock" class="form-label fw-semibold">
                                    Opening Stock <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    id="stock"
                                    name="stock"
                                    value="{{ old('stock', 0) }}"
                                    class="form-control @error('stock') is-invalid @enderror"
                                    min="0"
                                    step="1"
                                    required
                                >

                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <small class="text-muted">
                                    Initial quantity available in inventory.
                                </small>
                            </div>

                            {{-- Minimum Stock --}}
                            <div class="col-md-6">
                                <label for="minimum_stock" class="form-label fw-semibold">
                                    Minimum Stock Level <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    id="minimum_stock"
                                    name="minimum_stock"
                                    value="{{ old('minimum_stock', 5) }}"
                                    class="form-control @error('minimum_stock') is-invalid @enderror"
                                    min="0"
                                    step="1"
                                    required
                                >

                                @error('minimum_stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <small class="text-muted">
                                    A low-stock warning appears when stock reaches this level.
                                </small>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-xl-4">

                {{-- Status --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-toggle-on text-primary me-2"></i>
                            Product Status
                        </h5>
                    </div>

                    <div class="card-body px-4 pb-4">
                        <label for="status" class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-select @error('status') is-invalid @enderror"
                            required
                        >
                            <option value="active"
                                {{ old('status', 'active') === 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>

                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted d-block mt-2">
                            Active products are available for normal use in the system.
                        </small>
                    </div>
                </div>

                {{-- Help Card --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-clipboard-check text-primary fs-4"></i>
                            <h6 class="fw-bold mb-0">Before You Save</h6>
                        </div>

                        <ul class="text-muted small ps-3 mb-0">
                            <li class="mb-2">Product code must be unique.</li>
                            <li class="mb-2">Enter the correct product name and category.</li>
                            <li class="mb-2">Check purchase and selling prices.</li>
                            <li>Set the correct opening stock and minimum stock level.</li>
                        </ul>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-check-circle me-1"></i>
                            Save Product
                        </button>

                        <a href="{{ route('products.index') }}"
                           class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-circle me-1"></i>
                            Cancel
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </form>

</div>

@endsection

