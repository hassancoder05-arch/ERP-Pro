@extends('layouts.app')

@section('title', 'Accounting')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="bi bi-calculator me-2"></i>
                Accounting
            </h2>

            <p class="text-muted mb-0">
                Profit, COGS and cash flow analysis
            </p>

        </div>

    </div>


    {{-- Date Filter --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('accounting.index') }}"
            >

                <div class="row g-3 align-items-end">

                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            Start Date
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            value="{{ $startDate }}"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            End Date
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            value="{{ $endDate }}"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            <i class="bi bi-filter me-1"></i>
                            Apply
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Profit Cards --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        SALES
                    </div>

                    <h3 class="fw-bold mt-2 mb-0">
                        PKR {{ number_format($totalSales, 2) }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        COGS
                    </div>

                    <h3 class="fw-bold mt-2 mb-0 text-danger">
                        PKR {{ number_format($cogs, 2) }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        GROSS PROFIT
                    </div>

                    <h3 class="fw-bold mt-2 mb-0 text-success">
                        PKR {{ number_format($grossProfit, 2) }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        NET PROFIT
                    </div>

                    <h3 class="fw-bold mt-2 mb-0
                        {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
                        PKR {{ number_format($netProfit, 2) }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- Profit & Loss --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white py-3">

            <h5 class="fw-bold mb-0">
                <i class="bi bi-graph-up-arrow me-2"></i>
                Profit & Loss
            </h5>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <tbody>

                        <tr>

                            <td>
                                Sales Revenue
                            </td>

                            <td class="text-end fw-semibold">
                                PKR {{ number_format($totalSales, 2) }}
                            </td>

                        </tr>


                        <tr>

                            <td>
                                Cost of Goods Sold
                            </td>

                            <td class="text-end text-danger">
                                - PKR {{ number_format($cogs, 2) }}
                            </td>

                        </tr>


                        <tr class="fw-bold">

                            <td>
                                Gross Profit
                            </td>

                            <td class="text-end text-success">
                                PKR {{ number_format($grossProfit, 2) }}
                            </td>

                        </tr>


                        <tr>

                            <td>
                                Other Income
                            </td>

                            <td class="text-end">
                                PKR {{ number_format($totalIncome, 2) }}
                            </td>

                        </tr>


                        <tr>

                            <td>
                                Operating Expenses
                            </td>

                            <td class="text-end text-danger">
                                - PKR {{ number_format($totalExpenses, 2) }}
                            </td>

                        </tr>


                        <tr class="table-light fw-bold">

                            <td>
                                Net Profit
                            </td>

                            <td class="text-end
                                {{ $netProfit >= 0
                                    ? 'text-success'
                                    : 'text-danger' }}">

                                PKR {{ number_format($netProfit, 2) }}

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- Cash Flow --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        CASH IN
                    </div>

                    <h4 class="fw-bold text-success mt-2">
                        PKR {{ number_format($cashIn, 2) }}
                    </h4>

                    <hr>

                    <div class="d-flex justify-content-between">

                        <span>Customer Payments</span>

                        <strong>
                            PKR {{ number_format($customerPayments, 2) }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        CASH OUT
                    </div>

                    <h4 class="fw-bold text-danger mt-2">
                        PKR {{ number_format($cashOut, 2) }}
                    </h4>

                    <hr>

                    <div class="d-flex justify-content-between">

                        <span>Supplier Payments</span>

                        <strong>
                            PKR {{ number_format($supplierPayments, 2) }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        CASH BALANCE
                    </div>

                    <h4 class="fw-bold mt-2
                        {{ $cashBalance >= 0
                            ? 'text-success'
                            : 'text-danger' }}">

                        PKR {{ number_format($cashBalance, 2) }}

                    </h4>

                    <hr>

                    <div class="text-muted">
                        Current period balance
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Inventory --}}
    <div class="row g-4">

        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="text-muted small">
                        INVENTORY VALUE
                    </div>

                    <h4 class="fw-bold mt-2">
                        PKR {{ number_format($inventoryValue, 2) }}
                    </h4>

                </div>

            </div>

        </div>


        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="text-muted small">
                        LOW STOCK PRODUCTS
                    </div>

                    <h4 class="fw-bold mt-2
                        {{ $lowStockProducts > 0
                            ? 'text-danger'
                            : 'text-success' }}">

                        {{ $lowStockProducts }}

                    </h4>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection