@extends('layouts.app')

@section('title', 'Product Details')

@section('content')

<div class="container-fluid">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-box-seam me-2"></i>
                Product Details
            </h2>

            <p class="text-muted mb-0">
                View complete product information.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('products.edit', $product) }}"
                class="btn btn-primary"
            >
                <i class="bi bi-pencil me-1"></i>
                Edit
            </a>

            <a
                href="{{ route('products.index') }}"
                class="btn btn-outline-secondary"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Back
            </a>

        </div>

    </div>


    <div class="row g-4">


        {{-- Main Information --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0 fw-bold">
                        Product Information
                    </h5>

                </div>


                <div class="card-body">

                    <div class="row g-4">


                        <div class="col-md-6">

                            <small class="text-muted">
                                Product Code / SKU
                            </small>

                            <div class="fw-semibold fs-5">
                                {{ $product->product_code }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Product Name
                            </small>

                            <div class="fw-semibold fs-5">
                                {{ $product->name }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Category
                            </small>

                            <div>
                                {{ $product->category ?: 'Not specified' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Brand
                            </small>

                            <div>
                                {{ $product->brand ?: 'Not specified' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Purchase Price
                            </small>

                            <div class="fw-semibold">
                                Rs. {{ number_format($product->purchase_price, 2) }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Selling Price
                            </small>

                            <div class="fw-semibold">
                                Rs. {{ number_format($product->selling_price, 2) }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Minimum Stock
                            </small>

                            <div>
                                {{ $product->minimum_stock }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Status
                            </small>

                            <div>

                                @if($product->status === 'active')

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Inactive
                                    </span>

                                @endif

                            </div>

                        </div>


                        <div class="col-12">

                            <small class="text-muted">
                                Description
                            </small>

                            <p class="mb-0 mt-1">

                                {{ $product->description ?: 'No description available.' }}

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Stock Card --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center p-4">

                    <i class="bi bi-box-seam fs-1 text-primary"></i>

                    <h6 class="text-muted mt-3 mb-2">
                        Current Stock
                    </h6>

                    <h1 class="fw-bold">

                        {{ $product->stock }}

                    </h1>


                    @if($product->stock <= $product->minimum_stock)

                        <span class="badge bg-danger px-3 py-2">

                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Low Stock

                        </span>

                    @else

                        <span class="badge bg-success px-3 py-2">

                            <i class="bi bi-check-circle me-1"></i>
                            Stock Available

                        </span>

                    @endif

                </div>

            </div>


            {{-- Profit Card --}}
            <div class="card border-0 shadow-sm mt-4">

                <div class="card-body">

                    <h6 class="text-muted">
                        Estimated Profit / Unit
                    </h6>

                    <h3 class="fw-bold text-success">

                        Rs.
                        {{ number_format($product->selling_price - $product->purchase_price, 2) }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection