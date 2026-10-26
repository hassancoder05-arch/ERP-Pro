@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <div class="d-flex align-items-center gap-3">

                <div class="product-header-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>

                <div>
                    <h2 class="fw-bold mb-1">Edit Product</h2>

                    <p class="text-muted mb-0">
                        Update product information, pricing and inventory details.
                    </p>
                </div>

            </div>
        </div>

        <a href="{{ route('products.index') }}"
           class="btn btn-outline-secondary px-4">

            <i class="bi bi-arrow-left me-2"></i>
            Back to Products

        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show shadow-sm"
             role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Error Messages --}}
    @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show shadow-sm"
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


    {{-- Product Information Card --}}
    <div class="card product-form-card border-0 shadow-sm">

        <div class="card-header bg-white border-bottom p-4">

            <div class="d-flex align-items-center gap-3">

                <div class="section-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">Product Information</h5>

                    <p class="text-muted small mb-0">
                        Modify the basic information of your product.
                    </p>
                </div>

            </div>

        </div>


        <div class="card-body p-4">

            <form
                action="{{ route('products.update', $product) }}"
                method="POST"
            >

                @csrf
                @method('PUT')


                {{-- Basic Information --}}
                <div class="form-section mb-5">

                    <div class="section-heading mb-4">

                        <h6 class="fw-bold mb-1">
                            <i class="bi bi-info-circle me-2"></i>
                            Basic Information
                        </h6>

                        <p class="text-muted small mb-0">
                            Enter the product name, code, category and brand.
                        </p>

                    </div>


                    <div class="row g-4">

                        {{-- Product Code --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Product Code / SKU
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="product_code"
                                value="{{ old('product_code', $product->product_code) }}"
                                class="form-control @error('product_code') is-invalid @enderror"
                                placeholder="e.g. PRD-001"
                                required
                            >

                            @error('product_code')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Product Name --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Product Name
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $product->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter product name"
                                required
                            >

                            @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Category Dropdown --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Category
                            </label>

                            <select
                                name="category"
                                class="form-select @error('category') is-invalid @enderror"
                            >

                                <option value="">
                                    Select Category
                                </option>

                                @isset($categories)

                                    @foreach($categories as $category)

                                        <option
                                            value="{{ $category->name }}"
                                            @selected(
                                                old('category', $product->category) == $category->name
                                            )
                                        >
                                            {{ $category->name }}
                                        </option>

                                    @endforeach

                                @endisset

                                {{-- Preserve an existing category if it is not in the list --}}
                                @if(
                                    old('category', $product->category) &&
                                    (!isset($categories) ||
                                    !$categories->contains('name', old('category', $product->category)))
                                )

                                    <option
                                        value="{{ old('category', $product->category) }}"
                                        selected
                                    >
                                        {{ old('category', $product->category) }}
                                        (Existing Category)
                                    </option>

                                @endif

                            </select>

                            @error('category')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                            <small class="text-muted">
                                Select a category from the available list.
                            </small>

                        </div>


                        {{-- Brand --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Brand
                            </label>

                            <input
                                type="text"
                                name="brand"
                                value="{{ old('brand', $product->brand) }}"
                                class="form-control @error('brand') is-invalid @enderror"
                                placeholder="Enter brand name"
                            >

                            @error('brand')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Description --}}
                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Product Description
                            </label>

                            <textarea
                                name="description"
                                rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Enter product description..."
                            >{{ old('description', $product->description) }}</textarea>

                            @error('description')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Pricing Information --}}
                <div class="form-section mb-5">

                    <div class="section-heading mb-4">

                        <h6 class="fw-bold mb-1">
                            <i class="bi bi-currency-exchange me-2"></i>
                            Pricing Information
                        </h6>

                        <p class="text-muted small mb-0">
                            Manage purchase and selling prices.
                        </p>

                    </div>


                    <div class="row g-4">

                        {{-- Purchase Price --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Purchase Price
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rs.
                                </span>

                                <input
                                    type="number"
                                    name="purchase_price"
                                    value="{{ old('purchase_price', $product->purchase_price) }}"
                                    class="form-control @error('purchase_price') is-invalid @enderror"
                                    placeholder="0.00"
                                    step="0.01"
                                    min="0"
                                    required
                                >

                                @error('purchase_price')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>


                        {{-- Selling Price --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Selling Price
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rs.
                                </span>

                                <input
                                    type="number"
                                    name="selling_price"
                                    value="{{ old('selling_price', $product->selling_price) }}"
                                    class="form-control @error('selling_price') is-invalid @enderror"
                                    placeholder="0.00"
                                    step="0.01"
                                    min="0"
                                    required
                                >

                                @error('selling_price')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Inventory Information --}}
                <div class="form-section mb-5">

                    <div class="section-heading mb-4">

                        <h6 class="fw-bold mb-1">
                            <i class="bi bi-boxes me-2"></i>
                            Inventory Information
                        </h6>

                        <p class="text-muted small mb-0">
                            Configure current stock and low-stock alerts.
                        </p>

                    </div>


                    <div class="row g-4">

                        {{-- Current Stock --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Current Stock
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="number"
                                name="stock"
                                value="{{ old('stock', $product->stock) }}"
                                class="form-control @error('stock') is-invalid @enderror"
                                min="0"
                                required
                            >

                            @error('stock')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                            <small class="text-muted">
                                Current quantity available in inventory.
                            </small>

                        </div>


                        {{-- Minimum Stock --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Minimum Stock Level
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="number"
                                name="minimum_stock"
                                value="{{ old('minimum_stock', $product->minimum_stock) }}"
                                class="form-control @error('minimum_stock') is-invalid @enderror"
                                min="0"
                                required
                            >

                            @error('minimum_stock')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                            <small class="text-muted">
                                The threshold used to identify low-stock products.
                            </small>

                        </div>

                    </div>


                    {{-- Inventory Warning --}}
                    <div class="alert alert-info d-flex align-items-start gap-2 mt-4 mb-0">

                        <i class="bi bi-info-circle-fill mt-1"></i>

                        <div class="small">
                            <strong>Inventory reminder:</strong>
                            If your ERP tracks stock through purchases and inventory
                            transactions, make sure stock adjustments are recorded
                            consistently so inventory reports remain accurate.
                        </div>

                    </div>

                </div>


                {{-- Product Status --}}
                <div class="form-section mb-4">

                    <div class="section-heading mb-4">

                        <h6 class="fw-bold mb-1">
                            <i class="bi bi-toggle-on me-2"></i>
                            Product Status
                        </h6>

                        <p class="text-muted small mb-0">
                            Choose whether this product is active.
                        </p>

                    </div>


                    <div class="row">

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Status
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required
                            >

                                <option
                                    value="active"
                                    @selected(old('status', $product->status) === 'active')
                                >
                                    Active
                                </option>

                                <option
                                    value="inactive"
                                    @selected(old('status', $product->status) === 'inactive')
                                >
                                    Inactive
                                </option>

                            </select>

                            @error('status')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Form Actions --}}
                <div class="form-actions pt-4 border-top">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                        <div class="text-muted small">
                            <i class="bi bi-shield-check me-1"></i>
                            Review your changes before saving.
                        </div>

                        <div class="d-flex gap-2">

                            <a
                                href="{{ route('products.index') }}"
                                class="btn btn-light border px-4"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary px-4"
                            >

                                <i class="bi bi-check2-circle me-2"></i>
                                Update Product

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Product Information Footer --}}
    <div class="text-muted small mt-3">

        <i class="bi bi-info-circle me-1"></i>

        Product ID: {{ $product->id }}

        <span class="mx-2">|</span>

        Product Code: {{ $product->product_code }}

    </div>

</div>


{{-- Page Styles --}}
<style>

    .product-header-icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: rgba(99, 102, 241, 0.12);
        color: #6366f1;
        font-size: 25px;
        flex-shrink: 0;
    }

    .product-form-card {
        border-radius: 16px;
        overflow: hidden;
    }

    .product-form-card .card-header {
        border-radius: 16px 16px 0 0;
    }

    .section-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #475569;
        border-radius: 12px;
        font-size: 21px;
        flex-shrink: 0;
    }

    .section-heading {
        padding-bottom: 14px;
        border-bottom: 1px solid #e9edf2;
    }

    .section-heading h6 {
        color: #1e293b;
        font-size: 15px;
    }

    .section-heading h6 i {
        color: #6366f1;
    }

    .form-label {
        color: #334155;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select,
    .input-group-text {
        min-height: 44px;
        border-color: #dbe2ea;
        border-radius: 8px;
    }

    .form-control,
    .form-select {
        font-size: 14px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.12);
    }

    .input-group .input-group-text {
        border-radius: 8px 0 0 8px;
        background: #f8fafc;
        color: #475569;
        font-weight: 600;
    }

    .input-group .form-control {
        border-radius: 0 8px 8px 0;
    }

    .input-group .form-control.is-invalid {
        z-index: 3;
    }

    .form-actions .btn {
        min-height: 42px;
        border-radius: 8px;
        font-weight: 600;
    }

    .form-actions .btn-primary {
        background: #4f46e5;
        border-color: #4f46e5;
    }

    .form-actions .btn-primary:hover {
        background: #4338ca;
        border-color: #4338ca;
    }

    @media (max-width: 576px) {

        .product-form-card .card-body,
        .product-form-card .card-header {
            padding: 20px !important;
        }

        .form-actions > div {
            align-items: stretch !important;
        }

        .form-actions .d-flex.gap-2 {
            width: 100%;
        }

        .form-actions .btn {
            flex: 1;
        }

    }

</style>

@endsection

