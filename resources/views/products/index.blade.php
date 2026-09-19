
@extends('layouts.app')

@section('title', 'Products')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-box-seam me-2"></i>
                Products
            </h2>

            <p class="text-muted mb-0">
                Manage your products and inventory.
            </p>
        </div>

        <a href="{{ route('products.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Add Product
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>
    @endif


    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>
    @endif


    {{-- Search --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('products.index') }}">

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
                                placeholder="Search by product code, name, category or brand..."
                            >

                        </div>

                    </div>

                    <div class="col-md-2 d-grid">

                        <button class="btn btn-dark">

                            <i class="bi bi-search me-1"></i>

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Products Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-3">#</th>

                            <th>Product</th>

                            <th>Category</th>

                            <th>Brand</th>

                            <th>Purchase</th>

                            <th>Selling</th>

                            <th>Stock</th>

                            <th>Status</th>

                            <th class="text-end px-3">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($products as $product)

                            <tr>

                                <td class="px-3">
                                    {{ $products->firstItem() + $loop->index }}
                                </td>


                                {{-- Product --}}
                                <td>

                                    <div class="fw-semibold">
                                        {{ $product->name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $product->product_code }}
                                    </small>

                                </td>


                                {{-- Category --}}
                                <td>
                                    {{ $product->category ?: '—' }}
                                </td>


                                {{-- Brand --}}
                                <td>
                                    {{ $product->brand ?: '—' }}
                                </td>


                                {{-- Purchase --}}
                                <td>
                                    Rs. {{ number_format($product->purchase_price, 2) }}
                                </td>


                                {{-- Selling --}}
                                <td class="fw-semibold">
                                    Rs. {{ number_format($product->selling_price, 2) }}
                                </td>


                                {{-- Stock --}}
                                <td>

                                    @if($product->stock <= $product->minimum_stock)

                                        <span class="badge bg-danger">
                                            {{ $product->stock }}
                                        </span>

                                        <small class="text-danger d-block">
                                            Low stock
                                        </small>

                                    @else

                                        <span class="badge bg-success">
                                            {{ $product->stock }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if($product->status === 'active')

                                        <span class="badge bg-success-subtle text-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Inactive
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="text-end px-3">

                                    <div class="btn-group">

                                        {{-- View --}}
                                        <a href="{{ route('products.show', $product) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="View">

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route('products.edit', $product) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Edit">

                                            <i class="bi bi-pencil"></i>

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
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete"
                                            >

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9"
                                    class="text-center py-5">

                                    <i class="bi bi-box-seam fs-1 text-muted"></i>

                                    <h5 class="mt-3">
                                        No products found
                                    </h5>

                                    <p class="text-muted">
                                        Add your first product to get started.
                                    </p>

                                    <a href="{{ route('products.create') }}"
                                       class="btn btn-primary">

                                        <i class="bi bi-plus-lg me-1"></i>

                                        Add Product

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Pagination --}}
        @if($products->hasPages())

            <div class="card-footer bg-white border-0">

                {{ $products->links() }}

            </div>

        @endif

    </div>

</div>

@endsection

