@extends('layouts.app')

@section('title', 'Invoice ' . $sale->invoice_number)

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-receipt me-2"></i>
                Invoice
            </h2>

            <p class="text-muted mb-0">
                {{ $sale->invoice_number }}
            </p>
        </div>

        <div class="d-flex gap-2">

            <button
                onclick="window.print()"
                class="btn btn-outline-dark"
            >
                <i class="bi bi-printer me-2"></i>
                Print
            </button>

            <a
                href="{{ route('invoices.pdf', $sale) }}"
                class="btn btn-primary"
            >
                <i class="bi bi-file-earmark-pdf me-2"></i>
                Download PDF
            </a>

            <a
                href="{{ route('sales.index') }}"
                class="btn btn-outline-secondary"
            >
                <i class="bi bi-arrow-left me-2"></i>
                Back
            </a>

        </div>

    </div>


    {{-- Invoice --}}
    <div class="card border-0 shadow-sm invoice-card">

        <div class="card-body p-4 p-md-5">

            {{-- Company + Invoice --}}
            <div class="row mb-5">

                <div class="col-md-7">

                    <h1 class="fw-bold mb-2">
                        {{ $settings->company_name ?: 'ERP Pro' }}
                    </h1>

                    @if($settings->company_address)
                        <div class="text-muted">
                            {{ $settings->company_address }}
                        </div>
                    @endif

                    @if($settings->company_phone)
                        <div class="text-muted">
                            <i class="bi bi-telephone me-1"></i>
                            {{ $settings->company_phone }}
                        </div>
                    @endif

                    @if($settings->company_email)
                        <div class="text-muted">
                            <i class="bi bi-envelope me-1"></i>
                            {{ $settings->company_email }}
                        </div>
                    @endif

                </div>


                <div class="col-md-5 text-md-end mt-4 mt-md-0">

                    <h2 class="fw-bold">
                        INVOICE
                    </h2>

                    <p class="mb-1">
                        <strong>Invoice #:</strong>
                        {{ $sale->invoice_number }}
                    </p>

                    <p class="mb-1">
                        <strong>Date:</strong>
                        {{ $sale->sale_date->format('d M Y') }}
                    </p>

                    <p class="mb-0">

                        <strong>Status:</strong>

                        @if($sale->status === 'completed')

                            <span class="badge bg-success">
                                Completed
                            </span>

                        @else

                            <span class="badge bg-danger">
                                {{ ucfirst($sale->status) }}
                            </span>

                        @endif

                    </p>

                </div>

            </div>


            {{-- Customer --}}
            <div class="row mb-4">

                <div class="col-md-6">

                    <div class="invoice-section-title">
                        BILL TO
                    </div>

                    <h5 class="fw-bold mb-1">
                        {{ $sale->customer->name }}
                    </h5>

                    @if($sale->customer->email)
                        <div class="text-muted">
                            {{ $sale->customer->email }}
                        </div>
                    @endif

                    @if($sale->customer->phone)
                        <div class="text-muted">
                            {{ $sale->customer->phone }}
                        </div>
                    @endif

                    @if($sale->customer->address)
                        <div class="text-muted">
                            {{ $sale->customer->address }}
                        </div>
                    @endif

                </div>

            </div>


            {{-- Products --}}
            <div class="table-responsive">

                <table class="table align-middle invoice-table">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Product</th>

                            <th class="text-center">
                                Qty
                            </th>

                            <th class="text-end">
                                Unit Price
                            </th>

                            <th class="text-end">
                                Total
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($sale->items as $index => $item)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td>

                                    <div class="fw-semibold">
                                        {{ $item->product->name }}
                                    </div>

                                    @if($item->product->product_code)
                                        <small class="text-muted">
                                            SKU:
                                            {{ $item->product->product_code }}
                                        </small>
                                    @endif

                                </td>

                                <td class="text-center">
                                    {{ $item->quantity }}
                                </td>

                                <td class="text-end">
                                    {{ $settings->currency }}
                                    {{ number_format($item->price, 2) }}
                                </td>

                                <td class="text-end fw-semibold">
                                    {{ $settings->currency }}
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

                        <span>
                            Subtotal
                        </span>

                        <strong>
                            {{ $settings->currency }}
                            {{ number_format($sale->subtotal, 2) }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-2">

                        <span>
                            Discount
                        </span>

                        <strong>
                            - {{ $settings->currency }}
                            {{ number_format($sale->discount, 2) }}
                        </strong>

                    </div>


                    <hr>


                    <div class="d-flex justify-content-between">

                        <span class="fw-bold fs-5">
                            Grand Total
                        </span>

                        <strong class="fw-bold fs-5">
                            {{ $settings->currency }}
                            {{ number_format($sale->grand_total, 2) }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- Footer --}}
            <div class="border-top mt-5 pt-4 text-center">

                <p class="text-muted mb-1">
                    {{ $settings->invoice_footer ?: 'Thank you for your business!' }}
                </p>

                <small class="text-muted">
                    Generated by ERP Pro
                </small>

            </div>

        </div>

    </div>

</div>


<style>

.invoice-card {
    max-width: 1100px;
    margin: auto;
}

.invoice-section-title {
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
    color: #6c757d;
    margin-bottom: 8px;
}

.invoice-table thead {
    border-top: 2px solid #212529;
    border-bottom: 2px solid #212529;
}

.invoice-table th {
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: .4px;
}

.invoice-table td {
    padding-top: 14px;
    padding-bottom: 14px;
}

@media print {

    body {
        background: #fff !important;
    }

    .sidebar,
    .navbar,
    footer,
    .btn,
    .d-print-none {
        display: none !important;
    }

    .main-content,
    main {
        margin-left: 0 !important;
        padding: 0 !important;
    }

    .container-fluid {
        padding: 0 !important;
    }

    .invoice-card {
        box-shadow: none !important;
        border: none !important;
    }

    .card-body {
        padding: 20px !important;
    }

}

</style>

@endsection