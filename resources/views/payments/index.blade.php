@extends('layouts.app')

@section('title', 'Payments')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">Payments</h2>
            <p class="text-muted mb-0">
                Manage customer and supplier payments.
            </p>
        </div>

        <a href="{{ route('payments.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Record Payment
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('payments.index') }}"
                  class="row g-2 mb-4">

                <div class="col-md-8">

                    <input type="text"
                           name="search"
                           value="{{ $search }}"
                           class="form-control"
                           placeholder="Search customer, supplier or reference...">

                </div>

                <div class="col-md-4 d-flex gap-2">

                    <button class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>
                        Search
                    </button>

                    <a href="{{ route('payments.index') }}"
                       class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Party</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Method</th>
                            <th>Reference</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($payments as $payment)

                        <tr>

                            <td>
                                {{ $payments->firstItem() + $loop->index }}
                            </td>

                            <td>

                                @if($payment->type === 'customer')

                                    <span class="badge bg-success">
                                        Customer Payment
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Supplier Payment
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($payment->type === 'customer')
                                    {{ $payment->customer?->name ?? 'Deleted Customer' }}
                                @else
                                    {{ $payment->supplier?->name ?? 'Deleted Supplier' }}
                                @endif

                            </td>

                            <td class="fw-bold
                                {{ $payment->type === 'customer'
                                    ? 'text-success'
                                    : 'text-danger' }}">

                                Rs. {{ number_format($payment->amount, 2) }}

                            </td>

                            <td>
                                {{ $payment->payment_date->format('d M Y') }}
                            </td>

                            <td class="text-capitalize">
                                {{ $payment->payment_method }}
                            </td>

                            <td>
                                {{ $payment->reference ?: '—' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7"
                                class="text-center text-muted py-5">
                                No payment records found.
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $payments->links() }}
            </div>

        </div>

    </div>

</div>

@endsection