@extends('layouts.app')

@section('title', 'Sales')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="bi bi-receipt me-2"></i>
                Sales
            </h2>

            <p class="text-muted mb-0">
                Manage sales invoices and transactions.
            </p>

        </div>

        <a href="{{ route('sales.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg me-1"></i>
            New Sale

        </a>

    </div>


    {{-- Messages --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="bi bi-exclamation-circle me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Search --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('sales.index') }}"
            >

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
                                placeholder="Search invoice number or customer..."
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


    {{-- Sales Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-3">
                                Invoice
                            </th>

                            <th>
                                Customer
                            </th>

                            <th>
                                Date
                            </th>

                            <th>
                                Subtotal
                            </th>

                            <th>
                                Discount
                            </th>

                            <th>
                                Grand Total
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end px-3">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($sales as $sale)

                            <tr>

                                <td class="px-3">

                                    <div class="fw-semibold">
                                        {{ $sale->invoice_number }}
                                    </div>

                                </td>


                                <td>
                                    {{ $sale->customer->name }}
                                </td>


                                <td>
                                    {{ $sale->sale_date->format('d M Y') }}
                                </td>


                                <td>
                                    Rs.
                                    {{ number_format($sale->subtotal, 2) }}
                                </td>


                                <td>
                                    Rs.
                                    {{ number_format($sale->discount, 2) }}
                                </td>


                                <td class="fw-bold">

                                    Rs.
                                    {{ number_format($sale->grand_total, 2) }}

                                </td>


                                <td>

                                    @if($sale->status === 'completed')

                                        <span class="badge bg-success">
                                            Completed
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Cancelled
                                        </span>

                                    @endif

                                </td>


                                <td class="text-end px-3">

                                    <div class="btn-group">

                                        <a
    href="{{ route('invoices.show', $sale) }}"
    class="btn btn-sm btn-outline-primary"
    title="View Invoice"
>
    <i class="bi bi-receipt"></i>
</a>


                                        @if($sale->status === 'completed')

                                            <form
                                                action="{{ route('sales.destroy', $sale) }}"
                                                method="POST"
                                                onsubmit="return confirm('Cancel this sale? Stock will be restored.');"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Cancel Sale"
                                                >

                                                    <i class="bi bi-x-circle"></i>

                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center py-5"
                                >

                                    <i class="bi bi-receipt fs-1 text-muted"></i>

                                    <h5 class="mt-3">
                                        No sales found
                                    </h5>

                                    <p class="text-muted">
                                        Create your first sales invoice.
                                    </p>

                                    <a
                                        href="{{ route('sales.create') }}"
                                        class="btn btn-primary"
                                    >

                                        <i class="bi bi-plus-lg me-1"></i>
                                        New Sale

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if($sales->hasPages())

            <div class="card-footer bg-white border-0">

                {{ $sales->links() }}

            </div>

        @endif

    </div>

</div>

@endsection