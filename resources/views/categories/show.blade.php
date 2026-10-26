@extends('layouts.app')

@section('title', 'Category Details')

@section('content')

<div class="container-fluid py-4">


{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Category Details</h2>
        <p class="text-muted mb-0">View category information and associated products.</p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i> Edit Category
        </a>

        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

{{-- Category Information --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Category Information</h5>
    </div>

    <div class="card-body">
        <div class="row g-4">

            <div class="col-md-6">
                <div class="text-muted small mb-1">Category Name</div>
                <h5 class="fw-semibold">{{ $category->name }}</h5>
            </div>

            <div class="col-md-6">
                <div class="text-muted small mb-1">Status</div>

                @if ($category->status)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Inactive</span>
                @endif
            </div>

            <div class="col-md-6">
                <div class="text-muted small mb-1">Total Products</div>
                <h5 class="fw-semibold">{{ $products->total() }}</h5>
            </div>

            <div class="col-md-6">
                <div class="text-muted small mb-1">Created At</div>
                <p class="mb-0">
                    {{ $category->created_at?->format('d M Y, h:i A') ?? 'N/A' }}
                </p>
            </div>

            <div class="col-12">
                <div class="text-muted small mb-1">Description</div>
                <p class="mb-0">
                    {{ $category->description ?: 'No description provided.' }}
                </p>
            </div>

        </div>
    </div>
</div>

{{-- Products Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0">Products in This Category</h5>
    </div>

    <div class="card-body p-0">
        @if ($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Brand</th>
                            <th>Purchase Price</th>
                            <th>Selling Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="ps-3">
                                    {{ $products->firstItem() + $loop->index }}
                                </td>

                                <td>{{ $product->product_code }}</td>

                                <td class="fw-semibold">{{ $product->name }}</td>

                                <td>{{ $product->brand ?: 'N/A' }}</td>

                                <td>
                                    {{ number_format((float) $product->purchase_price, 2) }}
                                </td>

                                <td>
                                    {{ number_format((float) $product->selling_price, 2) }}
                                </td>

                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $product->stock }}
                                    </span>
                                </td>

                                <td>
                                    @if ($product->status === 'active' || $product->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($product->status ?? 'Inactive') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5>No Products Found</h5>
                <p class="text-muted mb-0">
                    There are currently no products assigned to this category.
                </p>
            </div>
        @endif
    </div>
</div>


</div>
@endsection
