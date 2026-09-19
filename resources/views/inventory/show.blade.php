@extends('layouts.app')

@section('title', 'Inventory Details')

@section('content')

<div class="container-fluid">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="bi bi-box-seam me-2"></i>
                {{ $product->name }}
            </h2>

            <p class="text-muted mb-0">
                Inventory movement history.
            </p>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('inventory.create') }}?product_id={{ $product->id }}"
                class="btn btn-primary"
            >

                <i class="bi bi-plus-lg me-1"></i>
                Update Stock

            </a>

            <a
                href="{{ route('inventory.index') }}"
                class="btn btn-outline-secondary"
            >

                <i class="bi bi-arrow-left me-1"></i>
                Back

            </a>

        </div>

    </div>


    {{-- Product Summary --}}
    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Product Code
                    </small>

                    <h5 class="fw-bold mt-2 mb-0">
                        {{ $product->product_code }}
                    </h5>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Current Stock
                    </small>

                    <h3 class="fw-bold mt-2 mb-0">

                        {{ $product->stock }}

                        @if($product->stock <= $product->minimum_stock)

                            <span class="badge bg-danger fs-6">
                                Low Stock
                            </span>

                        @endif

                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Minimum Stock
                    </small>

                    <h3 class="fw-bold mt-2 mb-0">
                        {{ $product->minimum_stock }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- History --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <h5 class="fw-bold mb-0">
                Transaction History
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-3">Date</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Before</th>
                            <th>After</th>
                            <th>Reference</th>
                            <th>Notes</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($transactions as $transaction)

                            <tr>

                                <td class="px-3">

                                    {{ $transaction->created_at->format('d M Y') }}

                                    <small class="text-muted d-block">
                                        {{ $transaction->created_at->format('h:i A') }}
                                    </small>

                                </td>


                                <td>

                                    @if($transaction->type === 'stock_in')

                                        <span class="badge bg-success">
                                            Stock In
                                        </span>

                                    @elseif($transaction->type === 'stock_out')

                                        <span class="badge bg-danger">
                                            Stock Out
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">
                                            Adjustment
                                        </span>

                                    @endif

                                </td>


                                <td class="fw-semibold">
                                    {{ $transaction->quantity }}
                                </td>


                                <td>
                                    {{ $transaction->stock_before }}
                                </td>


                                <td class="fw-semibold">
                                    {{ $transaction->stock_after }}
                                </td>


                                <td>
                                    {{ $transaction->reference ?: '—' }}
                                </td>


                                <td>
                                    {{ $transaction->notes ?: '—' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center py-5">

                                    <i class="bi bi-clock-history fs-1 text-muted"></i>

                                    <h5 class="mt-3">
                                        No transactions found
                                    </h5>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if($transactions->hasPages())

            <div class="card-footer bg-white border-0">

                {{ $transactions->links() }}

            </div>

        @endif

    </div>

</div>

@endsection