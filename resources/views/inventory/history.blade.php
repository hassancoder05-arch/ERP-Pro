@extends('layouts.app')

@section('title', 'Stock History')

@section('content')

<div class="container-fluid">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="bi bi-clock-history me-2"></i>
                Stock History
            </h2>

            <p class="text-muted mb-0">
                Complete inventory transaction history.
            </p>

        </div>

        <a href="{{ route('inventory.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg me-1"></i>
            New Transaction

        </a>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-3">Date</th>

                            <th>Product</th>

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

                                    <div class="fw-semibold">
                                        {{ $transaction->product->name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $transaction->product->product_code }}
                                    </small>

                                </td>


                                <td>

                                    @if($transaction->type === 'stock_in')

                                        <span class="badge bg-success">
                                            <i class="bi bi-arrow-down-circle me-1"></i>
                                            Stock In
                                        </span>

                                    @elseif($transaction->type === 'stock_out')

                                        <span class="badge bg-danger">
                                            <i class="bi bi-arrow-up-circle me-1"></i>
                                            Stock Out
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-sliders me-1"></i>
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

                                <td colspan="8"
                                    class="text-center py-5">

                                    <i class="bi bi-clock-history fs-1 text-muted"></i>

                                    <h5 class="mt-3">
                                        No inventory transactions
                                    </h5>

                                    <p class="text-muted">
                                        Stock transactions will appear here.
                                    </p>

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