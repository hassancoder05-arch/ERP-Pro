@extends('layouts.app')

@section('title', 'Add Product')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-box-seam me-2"></i>
                Add Product
            </h2>

            <p class="text-muted mb-0">
                Create a new product.
            </p>
        </div>

        <a href="{{ route('products.index') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Back

        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                Please fix the following errors:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form action="{{ route('products.store') }}"
                  method="POST">

                @csrf


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
                            value="{{ old('product_code') }}"
                            class="form-control @error('product_code') is-invalid @enderror"
                            placeholder="e.g. PROD-001"
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
                            value="{{ old('name') }}"
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


                    {{-- Category --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Category
                        </label>

                        <input
                            type="text"
                            name="category"
                            value="{{ old('category') }}"
                            class="form-control"
                            placeholder="e.g. Electronics"
                        >

                    </div>


                    {{-- Brand --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Brand
                        </label>

                        <input
                            type="text"
                            name="brand"
                            value="{{ old('brand') }}"
                            class="form-control"
                            placeholder="e.g. Samsung"
                        >

                    </div>


                    {{-- Purchase Price --}}
                    <div class="col-md-4">

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
                                value="{{ old('purchase_price', 0) }}"
                                class="form-control"
                                step="0.01"
                                min="0"
                                required
                            >

                        </div>

                    </div>


                    {{-- Selling Price --}}
                    <div class="col-md-4">

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
                                value="{{ old('selling_price', 0) }}"
                                class="form-control"
                                step="0.01"
                                min="0"
                                required
                            >

                        </div>

                    </div>


                    {{-- Stock --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Current Stock
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="number"
                            name="stock"
                            value="{{ old('stock', 0) }}"
                            class="form-control"
                            min="0"
                            required
                        >

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
                            value="{{ old('minimum_stock', 5) }}"
                            class="form-control"
                            min="0"
                            required
                        >

                        <small class="text-muted">
                            Low-stock warning will appear when stock reaches this level.
                        </small>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Status
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="status"
                            class="form-select"
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

                    </div>


                    {{-- Description --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="form-control"
                            placeholder="Enter product description..."
                        >{{ old('description') }}</textarea>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-12">

                        <hr>

                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('products.index') }}"
                               class="btn btn-light">

                                Cancel

                            </a>

                            <button type="submit"
                                    class="btn btn-primary">

                                <i class="bi bi-check-lg me-1"></i>
                                Save Product

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection