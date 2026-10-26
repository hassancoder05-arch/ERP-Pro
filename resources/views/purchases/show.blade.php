@extends('layouts.app')

@section('title', 'Purchase Details')

@section('content')

<div class="container-fluid py-4">

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="fas fa-file-invoice me-2"></i>Purchase Details
        </h2>
        <p class="text-muted mb-0">
            Purchase #{{ $purchase->purchase_number }}
        </p>
    </div>

    <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Purchases
    </a>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Error Message --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Validation Errors --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Please check the following:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Status Workflow --}}
@if(in_array($purchase->status, ['draft', 'ordered'], true))
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <h5 class="fw-bold mb-3">
                <i class="fas fa-tasks me-2"></i>Purchase Actions
            </h5>

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div>
                    @if($purchase->status === 'draft')
                        <span class="badge bg-secondary mb-2">Draft</span>
                        <p class="text-muted mb-0">
                            This purchase is a draft. You can mark it as ordered
                            after sending the order to the supplier.
                        </p>
                    @else
                        <span class="badge bg-info text-dark mb-2">Ordered</span>
                        <p class="text-muted mb-0">
                            This purchase has been ordered. Receive it when
                            the products have arrived.
                        </p>
                    @endif

                    <p class="small text-muted mt-2 mb-0">
                        Stock increases only when the purchase is received.
                    </p>
                </div>

                <div class="d-flex flex-wrap gap-2">

                    {{-- Mark as Ordered --}}
                    @if($purchase->status === 'draft')
                        <form
                            action="{{ route('purchases.order', $purchase) }}"
                            method="POST"
                            onsubmit="return confirm('Mark this purchase as ordered? Stock will not change.');"
                        >
                            @csrf

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>
                                Mark as Ordered
                            </button>
                        </form>
                    @endif

                    {{-- Cancel Purchase --}}
                    @if(in_array($purchase->status, ['draft', 'ordered'], true))
                    <form
                         action="{{ route('purchases.cancel', $purchase) }}"
                                method="POST"
                                class="d-inline"
                    onsubmit="return confirm('Are you sure you want to cancel this purchase?');" >
                        @csrf

                     <button type="submit" class="btn btn-danger">
                         <i class="fas fa-times-circle me-1"></i>
                            Cancel Purchase
                     </button>
                        </form>
                    @endif

                    {{-- Receive Purchase --}}
                    <form
                        action="{{ route('purchases.receive', $purchase) }}"
                        method="POST"
                        onsubmit="return confirm('Confirm that all products have arrived? This will increase inventory stock.');"
                    >
                        @csrf

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-box-open me-2"></i>
                            Receive Purchase
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endif

{{-- Purchase Summary --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-info-circle me-2"></i>Purchase Information
        </h5>
    </div>

    <div class="card-body">
        <div class="row g-4">

            <div class="col-md-4">
                <small class="text-muted d-block">Purchase Number</small>
                <strong>{{ $purchase->purchase_number }}</strong>
            </div>

            <div class="col-md-4">
                <small class="text-muted d-block">Supplier</small>
                <strong>{{ $purchase->supplier->name ?? 'N/A' }}</strong>
            </div>

            <div class="col-md-4">
                <small class="text-muted d-block">Purchase Date</small>
                <strong>
                    {{ $purchase->purchase_date
                        ? $purchase->purchase_date->format('d M Y')
                        : 'N/A' }}
                </strong>
            </div>

            <div class="col-md-4">
                <small class="text-muted d-block">Status</small>

                @php
                    $statusClasses = [
                        'draft' => 'bg-secondary',
                        'ordered' => 'bg-info text-dark',
                        'received' => 'bg-success',
                        'cancelled' => 'bg-danger',
                    ];
                @endphp

                <span class="badge {{ $statusClasses[$purchase->status] ?? 'bg-secondary' }}">
                    {{ ucfirst($purchase->status) }}
                </span>
            </div>

            <div class="col-md-4">
                <small class="text-muted d-block">Received At</small>
                <strong>
                    {{ $purchase->received_at
                        ? $purchase->received_at->format('d M Y, h:i A')
                        : 'Not received yet' }}
                </strong>
            </div>

            <div class="col-md-4">
                <small class="text-muted d-block">Created At</small>
                <strong>
                    {{ $purchase->created_at
                        ? $purchase->created_at->format('d M Y, h:i A')
                        : 'N/A' }}
                </strong>
            </div>

            @if($purchase->notes)
                <div class="col-12">
                    <small class="text-muted d-block">Notes</small>
                    <p class="mb-0">{{ $purchase->notes }}</p>
                </div>
            @endif

        </div>
    </div>
</div>

{{-- Purchase Items --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-boxes me-2"></i>Purchased Products
        </h5>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Product</th>
                        <th>Product Code</th>
                        <th class="text-end">Quantity</th>
                        <th class="text-end">Cost Price</th>
                        <th class="text-end pe-3">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($purchase->items as $item)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>

                            <td>
                                {{ $item->product->name ?? 'Product unavailable' }}
                            </td>

                            <td>
                                {{ $item->product->product_code ?? 'N/A' }}
                            </td>

                            <td class="text-end">
                                {{ number_format($item->quantity) }}
                            </td>

                            <td class="text-end">
                                Rs. {{ number_format((float) $item->cost_price, 2) }}
                            </td>

                            <td class="text-end pe-3 fw-semibold">
                                Rs. {{ number_format((float) $item->total, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No purchase items found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

{{-- Purchase Totals --}}
<div class="row justify-content-end">
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="fw-bold mb-0">Purchase Summary</h5>
            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Subtotal</span>
                    <strong>
                        Rs. {{ number_format((float) $purchase->subtotal, 2) }}
                    </strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Discount</span>
                    <strong class="text-danger">
                        - Rs. {{ number_format((float) $purchase->discount, 2) }}
                    </strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Tax</span>
                    <strong>
                        Rs. {{ number_format((float) $purchase->tax, 2) }}
                    </strong>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Grand Total</span>
                    <h5 class="fw-bold text-primary mb-0">
                        Rs. {{ number_format((float) $purchase->grand_total, 2) }}
                    </h5>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Inventory Notice --}}
@if($purchase->status === 'received')
    <div class="alert alert-success mt-4 mb-0">
        <i class="fas fa-check-circle me-2"></i>
        This purchase has been received. Inventory stock was updated.
    </div>
@elseif($purchase->status === 'cancelled')
    <div class="alert alert-danger mt-4 mb-0">
        <i class="fas fa-ban me-2"></i>
        This purchase is cancelled. No further receiving action is available.
    </div>
@else
    <div class="alert alert-info mt-4 mb-0">
        <i class="fas fa-info-circle me-2"></i>
        This purchase has not been received yet. Product stock has not been increased.
    </div>
@endif

</div>
@endsection
