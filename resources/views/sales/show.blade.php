@extends('layouts.app')

@section('title', 'Invoice {{ $sale->invoice_number }}')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="bi bi-receipt me-2"></i>
                {{ $sale->invoice_number }}
            </h2>

            <p class="text-muted mb-0">
                Sales invoice details.
            </p>

        </div>

        <div class="d-flex gap-2">

            <button
                type="button"
                onclick="window.print()"
                class="btn btn-outline-dark"
            >

                <i class="bi bi-printer me-1"></i>
                Print

            </button>

            <a
                href="{{ route('sales.index') }}"
                class="btn btn-outline-secondary"
            >

                <i class="bi bi-arrow-left me-1"></i>
                Back

            </a>

        </div>

    </div>


    {{-- Invoice --}}
    <div class="card border-0 shadow-sm" id="invoice">

        <div class="card-body p-4 p-lg-5">


            {{-- Invoice Header --}}
            <div class="row mb-5">

                <div class="col-md-6">

                    <h3 class="fw-bold mb-1">
                        ERP PRO
                    </h3>

                    <p class="text-muted mb-0">
                        Sales Invoice
                    </p>

                </div>


                <div class="col-md-6 text-md-end mt-4 mt-md-0">

                    <h5 class="fw-bold">
                        {{ $sale->invoice_number }}
                    </h5>

                    <p class="text-muted mb-0">

                        Date:
                        {{ $sale->sale_date->format('d M Y') }}

                    </p>

                    <p class="mt-2">

                        @if($sale->status === 'completed')

                            <span class="badge bg-success">
                                Completed
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Cancelled
                            </span>

                        @endif

                    </p>

                </div>

            </div>


            {{-- Customer --}}
            <div class="row mb-4">

                <div class="col-md-6">

                    <small class="text-muted">
                        BILL TO
                    </small>

                    <h5 class="fw-bold mt-1">
                        {{ $sale->customer->name }}
                    </h5>

                    @if($sale->customer->phone)

                        <p class="mb-1">
                            {{ $sale->customer->phone }}
                        </p>

                    @endif

                    @if($sale->customer->email)

                        <p class="mb-1">
                            {{ $sale->customer->email }}
                        </p>

                    @endif

                    @if($sale->customer->address)

                        <p class="text-muted">
                            {{ $sale->customer->address }}
                        </p>

                    @endif

                </div>

            </div>


            {{-- Items --}}
            <div class="table-responsive">

                <table class="table align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Product</th>

                            <th>SKU</th>

                            <th class="text-center">
                                Qty
                            </th>

                            <th class="text-end">
                                Price
                            </th>

                            <th class="text-end">
                                Total
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($sale->items as $item)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $item->product->name }}
                                </td>

                                <td>
                                    {{ $item->product->product_code }}
                                </td>

                                <td class="text-center">
                                    {{ $item->quantity }}
                                </td>

                                <td class="text-end">
                                    Rs.
                                    {{ number_format($item->price, 2) }}
                                </td>

                                <td class="text-end fw-semibold">
                                    Rs.
                                    {{ number_format($item->total, 2) }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Totals --}}
            <div class="row justify-content-end mt-4">

                <div class="col-md-5 col-lg-4">

                    <div class="d-flex justify-content-between mb-2">

                        <span class="text-muted">
                            Subtotal
                        </span>

                        <span>
                            Rs.
                            {{ number_format($sale->subtotal, 2) }}
                        </span>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Discount
                        </span>

                        <span>
                            Rs.
                            {{ number_format($sale->discount, 2) }}
                        </span>

                    </div>


                    <hr>


                    <div class="d-flex justify-content-between">

                        <strong>
                            Grand Total
                        </strong>

                        <strong class="fs-5">
                            Rs.
                            {{ number_format($sale->grand_total, 2) }}
                        </strong>

                    </div>

                </div>

            </div>


            <div class="text-center text-muted mt-5 pt-4 border-top">

                Thank you for your business.

            </div>

        </div>

    </div>

</div>


<style>

@media print {

    body {
        background: white !important;
    }

    .sidebar,
    .navbar,
    footer,
    .btn,
    .d-flex.justify-content-between {
        display: none !important;
    }

    main {
        margin-left: 0 !important;
    }

    .card {
        box-shadow: none !important;
        border: none !important;
    }

}

</style>

@endsection