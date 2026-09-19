@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-bar-chart-line me-2"></i>
                Reports & Analytics
            </h2>

            <p class="text-muted mb-0">
                Business performance and financial reports
            </p>
        </div>

        <button
            onclick="window.print()"
            class="btn btn-outline-dark"
        >
            <i class="bi bi-printer me-1"></i>
            Print
        </button>

    </div>


    {{-- Date Filter --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET" action="{{ route('reports.index') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Start Date
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            class="form-control"
                            value="{{ $startDate }}"
                        >

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            End Date
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            class="form-control"
                            value="{{ $endDate }}"
                        >

                    </div>


                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">

                            <i class="bi bi-filter me-1"></i>
                            Apply

                        </button>

                    </div>


                    <div class="col-md-2">

                        <a
                            href="{{ route('reports.index') }}"
                            class="btn btn-outline-secondary w-100"
                        >

                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- KPI Cards --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Total Sales
                    </small>

                    <h3 class="fw-bold mt-2">
                        Rs. {{ number_format($totalSales, 2) }}
                    </h3>

                    <i class="bi bi-cart-check fs-2 text-primary"></i>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Total Expenses
                    </small>

                    <h3 class="fw-bold mt-2 text-danger">
                        Rs. {{ number_format($totalExpenses, 2) }}
                    </h3>

                    <i class="bi bi-cash-stack fs-2 text-danger"></i>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Other Income
                    </small>

                    <h3 class="fw-bold mt-2 text-success">
                        Rs. {{ number_format($totalIncome, 2) }}
                    </h3>

                    <i class="bi bi-graph-up-arrow fs-2 text-success"></i>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Net Profit
                    </small>

                    <h3 class="fw-bold mt-2
                        {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">

                        Rs. {{ number_format($netProfit, 2) }}

                    </h3>

                    <i class="bi bi-pie-chart fs-2
                        {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
                    </i>

                </div>

            </div>

        </div>

    </div>


    {{-- Cash Summary --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold">
                        <i class="bi bi-arrow-down-circle text-success me-2"></i>
                        Cash In
                    </h5>

                    <h3 class="text-success fw-bold mt-3">
                        Rs. {{ number_format($cashIn, 2) }}
                    </h3>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Sales</span>
                        <strong>
                            Rs. {{ number_format($totalSales, 2) }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <span>Other Income</span>
                        <strong>
                            Rs. {{ number_format($totalIncome, 2) }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <span>Customer Payments</span>
                        <strong>
                            Rs. {{ number_format($totalCustomerPayments, 2) }}
                        </strong>
                    </div>

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold">
                        <i class="bi bi-arrow-up-circle text-danger me-2"></i>
                        Cash Out
                    </h5>

                    <h3 class="text-danger fw-bold mt-3">
                        Rs. {{ number_format($cashOut, 2) }}
                    </h3>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Expenses</span>
                        <strong>
                            Rs. {{ number_format($totalExpenses, 2) }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <span>Supplier Payments</span>
                        <strong>
                            Rs. {{ number_format($totalSupplierPayments, 2) }}
                        </strong>
                    </div>

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold">
                        <i class="bi bi-wallet2 me-2"></i>
                        Cash Balance
                    </h5>

                    <h3 class="fw-bold mt-3
                        {{ $cashBalance >= 0 ? 'text-success' : 'text-danger' }}">

                        Rs. {{ number_format($cashBalance, 2) }}

                    </h3>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Total Revenue</span>

                        <strong>
                            Rs. {{ number_format($totalRevenue, 2) }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <span>Cash Out</span>

                        <strong>
                            Rs. {{ number_format($cashOut, 2) }}
                        </strong>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Top Products --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white py-3">

            <h5 class="fw-bold mb-0">
                <i class="bi bi-trophy me-2"></i>
                Top Selling Products
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Quantity Sold</th>
                            <th>Total Sales</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($topProducts as $index => $product)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $product->name }}
                                </td>

                                <td>
                                    {{ $product->total_quantity }}
                                </td>

                                <td>
                                    Rs.
                                    {{ number_format($product->total_sales, 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    No sales found for this period.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- Sales Report --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white py-3">

            <h5 class="fw-bold mb-0">
                <i class="bi bi-receipt me-2"></i>
                Sales Report
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Discount</th>
                            <th>Total</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($sales as $sale)

                            <tr>

                                <td class="fw-semibold">
                                    {{ $sale->invoice_number }}
                                </td>

                                <td>
                                    {{ $sale->customer->name ?? 'Walk-in Customer' }}
                                </td>

                                <td>
                                    {{ $sale->sale_date->format('d M Y') }}
                                </td>

                                <td>
                                    Rs. {{ number_format($sale->discount, 2) }}
                                </td>

                                <td class="fw-semibold">
                                    Rs. {{ number_format($sale->grand_total, 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No sales found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- Inventory Summary --}}
    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Total Products
                    </small>

                    <h3 class="fw-bold">
                        {{ number_format($totalProducts) }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Total Stock Units
                    </small>

                    <h3 class="fw-bold">
                        {{ number_format($totalStock) }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Low Stock Products
                    </small>

                    <h3 class="fw-bold text-danger">
                        {{ number_format($lowStockProducts) }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- Period --}}
    <div class="alert alert-light border">

        <i class="bi bi-calendar3 me-2"></i>

        Report period:

        <strong>
            {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
        </strong>

        to

        <strong>
            {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        </strong>

    </div>

</div>


{{-- Print CSS --}}
<style>
@media print {

    .sidebar,
    .navbar,
    .btn,
    form {
        display: none !important;
    }

    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
    }

    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }

}
</style>

@endsection