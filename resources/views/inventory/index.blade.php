@extends('layouts.app')

@section('title', 'Inventory')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-boxes me-2"></i>
                Inventory
            </h2>

            <p class="text-muted mb-0">
                Monitor and manage your product stock.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('inventory.history') }}"
               class="btn btn-outline-dark">

                <i class="bi bi-clock-history me-1"></i>
                Stock History

            </a>

            <a href="{{ route('inventory.create') }}"
               class="btn btn-primary">

                <i class="bi bi-plus-lg me-1"></i>
                Stock Transaction

            </a>

        </div>

    </div>


    {{-- Success --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- KPI Cards --}}
    <div class="row g-4 mb-4">

        <div class="col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Total Products
                            </small>

                            <h3 class="fw-bold mt-2 mb-0">
                                {{ $totalProducts }}
                            </h3>

                        </div>

                        <i class="bi bi-box-seam fs-2 text-primary"></i>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Total Units
                            </small>

                            <h3 class="fw-bold mt-2 mb-0">
                                {{ number_format($totalUnits) }}
                            </h3>

                        </div>

                        <i class="bi bi-stack fs-2 text-success"></i>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Low Stock
                            </small>

                            <h3 class="fw-bold mt-2 mb-0 text-warning">
                                {{ $lowStockProducts }}
                            </h3>

                        </div>

                        <i class="bi bi-exclamation-triangle fs-2 text-warning"></i>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Out of Stock
                            </small>

                            <h3 class="fw-bold mt-2 mb-0 text-danger">
                                {{ $outOfStockProducts }}
                            </h3>

                        </div>

                        <i class="bi bi-x-circle fs-2 text-danger"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Search --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('inventory.index') }}">

                <div class="row g-2">

                    <div class="col-md-10">

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                class="form-control"
                                placeholder="Search product..."
                            >

                        </div>

                    </div>

                    <div class="col-md-2 d-grid">

                        <button class="btn btn-dark">
                            Search
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Products --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <h5 class="fw-bold mb-0">
                Current Stock
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-3">Product</th>

                            <th>Category</th>

                            <th>Current Stock</th>

                            <th>Minimum Stock</th>

                            <th>Status</th>

                            <th class="text-end px-3">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($products as $product)

                            <tr>

                                <td class="px-3">

                                    <div class="fw-semibold">
                                        {{ $product->name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $product->product_code }}
                                    </small>

                                </td>


                                <td>
                                    {{ $product->category ?: '—' }}
                                </td>


                                <td>

                                    @if($product->stock == 0)

                                        <span class="badge bg-danger">
                                            0
                                        </span>

                                    @elseif($product->stock <= $product->minimum_stock)

                                        <span class="badge bg-warning text-dark">
                                            {{ $product->stock }}
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            {{ $product->stock }}
                                        </span>

                                    @endif

                                </td>


                                <td>
                                    {{ $product->minimum_stock }}
                                </td>


                                <td>

                                    @if($product->stock == 0)

                                        <span class="badge bg-danger">
                                            Out of Stock
                                        </span>

                                    @elseif($product->stock <= $product->minimum_stock)

                                        <span class="badge bg-warning text-dark">
                                            Low Stock
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            Available
                                        </span>

                                    @endif

                                </td>


                                <td class="text-end px-3">

                                    <div class="btn-group">

                                        <a
                                            href="{{ route('inventory.show', $product) }}"
                                            class="btn btn-sm btn-outline-info"
                                            title="View History"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a
                                            href="{{ route('inventory.create') }}?product_id={{ $product->id }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Update Stock"
                                        >
                                            <i class="bi bi-plus-slash-minus"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5">

                                    <i class="bi bi-boxes fs-1 text-muted"></i>

                                    <h5 class="mt-3">
                                        No products found
                                    </h5>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if($products->hasPages())

            <div class="card-footer bg-white border-0">

                {{ $products->links() }}

            </div>

        @endif

    </div>

</div>

@endsection