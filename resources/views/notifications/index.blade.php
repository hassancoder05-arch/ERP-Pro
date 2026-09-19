@extends('layouts.app')

@section('title', 'Notifications')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-bell me-2"></i>
                Notifications
            </h2>

            <p class="text-muted mb-0">
                Important ERP alerts and stock notifications
            </p>
        </div>

        <a href="{{ route('dashboard') }}"
           class="btn btn-outline-primary">

            <i class="bi bi-arrow-left me-2"></i>
            Dashboard

        </a>

    </div>


    {{-- SUMMARY CARDS --}}
    <div class="row g-4 mb-4">

        {{-- OUT OF STOCK --}}
        <div class="col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="bg-danger bg-opacity-10 text-danger rounded p-3 me-3">
                            <i class="bi bi-x-circle fs-3"></i>
                        </div>

                        <div>

                            <div class="text-muted small">
                                Out of Stock
                            </div>

                            <h3 class="fw-bold mb-0">
                                {{ $outOfStockProducts->count() }}
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- LOW STOCK --}}
        <div class="col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center">

                        <div class="bg-warning bg-opacity-10 text-warning rounded p-3 me-3">
                            <i class="bi bi-exclamation-triangle fs-3"></i>
                        </div>

                        <div>

                            <div class="text-muted small">
                                Low Stock
                            </div>

                            <h3 class="fw-bold mb-0">
                                {{ $lowStockProducts->count() }}
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- OUT OF STOCK PRODUCTS --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white border-0 py-3">

            <h5 class="fw-bold mb-0 text-danger">

                <i class="bi bi-x-circle me-2"></i>

                Out of Stock Products

            </h5>

        </div>


        <div class="card-body">

            @if($outOfStockProducts->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>
                                <th>Product</th>
                                <th>Code</th>
                                <th>Stock</th>
                                <th>Minimum Stock</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($outOfStockProducts as $product)

                                <tr>

                                    <td>
                                        <strong>
                                            {{ $product->name }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $product->product_code }}
                                    </td>

                                    <td>
                                        <span class="badge bg-danger">
                                            {{ $product->stock }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $product->minimum_stock }}
                                    </td>

                                    <td>

                                        <a href="{{ route('products.edit', $product) }}"
                                           class="btn btn-sm btn-outline-primary">

                                            <i class="bi bi-pencil"></i>
                                            Update

                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-4">

                    <i class="bi bi-check-circle text-success fs-1"></i>

                    <h5 class="mt-3">
                        No out-of-stock products
                    </h5>

                    <p class="text-muted mb-0">
                        All products currently have stock.
                    </p>

                </div>

            @endif

        </div>

    </div>


    {{-- LOW STOCK PRODUCTS --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">

            <h5 class="fw-bold mb-0 text-warning">

                <i class="bi bi-exclamation-triangle me-2"></i>

                Low Stock Products

            </h5>

        </div>


        <div class="card-body">

            @if($lowStockProducts->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>
                                <th>Product</th>
                                <th>Code</th>
                                <th>Current Stock</th>
                                <th>Minimum Stock</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($lowStockProducts as $product)

                                <tr>

                                    <td>
                                        <strong>
                                            {{ $product->name }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $product->product_code }}
                                    </td>

                                    <td>

                                        <span class="badge bg-warning text-dark">

                                            {{ $product->stock }}

                                        </span>

                                    </td>

                                    <td>
                                        {{ $product->minimum_stock }}
                                    </td>

                                    <td>

                                        <span class="badge bg-warning text-dark">

                                            Low Stock

                                        </span>

                                    </td>

                                    <td>

                                        <a href="{{ route('products.edit', $product) }}"
                                           class="btn btn-sm btn-outline-primary">

                                            <i class="bi bi-pencil"></i>
                                            Update

                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-4">

                    <i class="bi bi-check-circle text-success fs-1"></i>

                    <h5 class="mt-3">
                        Stock levels are healthy
                    </h5>

                    <p class="text-muted mb-0">
                        No low-stock products found.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection