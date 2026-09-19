@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-pencil-square me-2"></i>
                Edit Product
            </h2>

            <p class="text-muted mb-0">
                Update product information.
            </p>
        </div>

        <a href="{{ route('products.index') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Back

        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form
                action="{{ route('products.update', $product) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                <div class="row g-4">


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
                            required
                        >

                        @error('product_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Product Name
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $product->name) }}"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Category
                        </label>

                        <input
                            type="text"
                            name="category"
                            value="{{ old('category', $product->category) }}"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Brand
                        </label>

                        <input
                            type="text"
                            name="brand"
                            value="{{ old('brand', $product->brand) }}"
                            class="form-control"
                        >

                    </div>


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
                                value="{{ old('purchase_price', $product->purchase_price) }}"
                                class="form-control"
                                step="0.01"
                                min="0"
                                required
                            >

                        </div>

                    </div>


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
                                value="{{ old('selling_price', $product->selling_price) }}"
                                class="form-control"
                                step="0.01"
                                min="0"
                                required
                            >

                        </div>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Current Stock
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="number"
                            name="stock"
                            value="{{ old('stock', $product->stock) }}"
                            class="form-control"
                            min="0"
                            required
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Minimum Stock Level
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="number"
                            name="minimum_stock"
                            value="{{ old('minimum_stock', $product->minimum_stock) }}"
                            class="form-control"
                            min="0"
                            required
                        >

                    </div>


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
                                {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>


                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="form-control"
                        >{{ old('description', $product->description) }}</textarea>

                    </div>


                    <div class="col-12">

                        <hr>

                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('products.index') }}"
                                class="btn btn-light"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >

                                <i class="bi bi-save me-1"></i>
                                Update Product

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection