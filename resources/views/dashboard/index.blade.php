@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid py-4">

    {{-- =========================================================
        DASHBOARD HEADER
    ========================================================== --}}

    <div class="dashboard-header d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>

            <div class="d-flex align-items-center gap-2 mb-2">

                <span class="dashboard-title-icon">
                    <i class="bi bi-grid-1x2-fill"></i>
                </span>

                <h2 class="dashboard-page-title mb-0">
                    Dashboard
                </h2>

            </div>

            <p class="dashboard-subtitle mb-0">
                Welcome back! Here's your business overview.
            </p>

        </div>

        <div class="mt-3 mt-md-0">

            <div class="dashboard-date">

                <i class="bi bi-calendar3"></i>

                <span>
                    {{ now()->format('d M Y') }}
                </span>

            </div>

        </div>

    </div>


    {{-- =========================================================
        KPI CARDS
    ========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- TODAY'S SALES --}}
        <div class="col-xl-3 col-md-6">

            <div class="dashboard-card">

                <div class="card-icon">
                    <i class="bi bi-cart-check"></i>
                </div>

                <div>

                    <p class="text-muted mb-1">
                        Today's Sales
                    </p>

                    <h3 class="fw-bold mb-1">
                        PKR {{ number_format($todaySales, 2) }}
                    </h3>

                    <small class="text-success">
                        <i class="bi bi-arrow-up"></i>
                        Today's revenue
                    </small>

                </div>

            </div>

        </div>


        {{-- MONTHLY SALES --}}
        <div class="col-xl-3 col-md-6">

            <div class="dashboard-card">

                <div class="card-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>

                <div>

                    <p class="text-muted mb-1">
                        Monthly Sales
                    </p>

                    <h3 class="fw-bold mb-1">
                        PKR {{ number_format($monthlySales, 2) }}
                    </h3>

                    <small class="text-muted">
                        Current month
                    </small>

                </div>

            </div>

        </div>


        {{-- MONTHLY EXPENSES --}}
        <div class="col-xl-3 col-md-6">

            <div class="dashboard-card">

                <div class="card-icon">
                    <i class="bi bi-wallet2"></i>
                </div>

                <div>

                    <p class="text-muted mb-1">
                        Monthly Expenses
                    </p>

                    <h3 class="fw-bold mb-1">
                        PKR {{ number_format($monthlyExpenses, 2) }}
                    </h3>

                    <small class="text-danger">
                        Business expenses
                    </small>

                </div>

            </div>

        </div>


        {{-- NET PROFIT --}}
        <div class="col-xl-3 col-md-6">

            <div class="dashboard-card">

                <div class="card-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>

                <div>

                    <p class="text-muted mb-1">
                        Net Profit
                    </p>

                    <h3 class="fw-bold mb-1
                        {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">

                        PKR {{ number_format($netProfit, 2) }}

                    </h3>

                    <small class="text-muted">
                        After COGS & expenses
                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        SALES CHART + PROFIT SUMMARY
    ========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- SALES CHART --}}
        <div class="col-lg-8">

            <div class="card dashboard-panel h-100">

                <div class="card-header">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Sales Overview
                        </h5>

                        <p class="text-muted small mb-0">
                            Daily sales for this month
                        </p>

                    </div>

                </div>

                <div class="card-body chart-container">

                    <canvas id="salesChart"></canvas>

                </div>

            </div>

        </div>


        {{-- PROFIT SUMMARY --}}
        <div class="col-lg-4">

            <div class="card dashboard-panel h-100">

                <div class="card-header">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Profit Summary
                        </h5>

                        <p class="text-muted small mb-0">
                            Current month
                        </p>

                    </div>

                </div>

                <div class="card-body">

                    <div class="summary-row">

                        <span>
                            Sales
                        </span>

                        <strong>
                            PKR {{ number_format($monthlySales, 2) }}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            COGS
                        </span>

                        <strong class="text-danger">
                            - PKR {{ number_format($monthlyCogs, 2) }}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Gross Profit
                        </span>

                        <strong class="text-success">
                            PKR {{ number_format($grossProfit, 2) }}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Expenses
                        </span>

                        <strong class="text-danger">
                            - PKR {{ number_format($monthlyExpenses, 2) }}
                        </strong>

                    </div>


                    <hr>


                    <div class="d-flex justify-content-between align-items-center">

                        <strong>
                            Net Profit
                        </strong>

                        <strong class="
                            {{ $netProfit >= 0
                                ? 'text-success'
                                : 'text-danger' }}
                        ">

                            PKR {{ number_format($netProfit, 2) }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        BUSINESS STATISTICS
    ========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- CUSTOMERS --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>

                <div>

                    <small class="text-muted">
                        Customers
                    </small>

                    <h4 class="fw-bold mb-0">
                        {{ number_format($totalCustomers) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- SUPPLIERS --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-building"></i>
                </div>

                <div>

                    <small class="text-muted">
                        Suppliers
                    </small>

                    <h4 class="fw-bold mb-0">
                        {{ number_format($totalSuppliers) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- PRODUCTS --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div>

                    <small class="text-muted">
                        Products
                    </small>

                    <h4 class="fw-bold mb-0">
                        {{ number_format($totalProducts) }}
                    </h4>

                </div>

            </div>

        </div>


        {{-- TOTAL STOCK --}}
        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-boxes"></i>
                </div>

                <div>

                    <small class="text-muted">
                        Total Stock
                    </small>

                    <h4 class="fw-bold mb-0">
                        {{ number_format($totalStock) }}
                    </h4>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        RECENT SALES + LOW STOCK
    ========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- RECENT SALES --}}
        <div class="col-lg-8">

            <div class="card dashboard-panel">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Recent Sales
                        </h5>

                        <p class="text-muted small mb-0">
                            Latest invoices
                        </p>

                    </div>

                    <a href="{{ route('sales.index') }}"
                       class="btn btn-sm btn-outline-primary">

                        <i class="bi bi-arrow-right me-1"></i>
                        View All

                    </a>

                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table dashboard-table align-middle mb-0">

                            <thead>

                                <tr>

                                    <th class="ps-4">
                                        Invoice
                                    </th>

                                    <th>
                                        Customer
                                    </th>

                                    <th>
                                        Date
                                    </th>

                                    <th class="text-end pe-4">
                                        Total
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($recentSales as $sale)

                                    <tr>

                                        <td class="ps-4">

                                            <a href="{{ route('sales.show', $sale) }}"
                                               class="invoice-link">

                                                {{ $sale->invoice_number }}

                                            </a>

                                        </td>


                                        <td>

                                            {{ $sale->customer->name ?? 'Walk-in Customer' }}

                                        </td>


                                        <td>

                                            {{ $sale->sale_date->format('d M Y') }}

                                        </td>


                                        <td class="text-end pe-4 fw-semibold">

                                            PKR
                                            {{ number_format($sale->grand_total, 2) }}

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="4"
                                            class="text-center text-muted py-5">

                                            <i class="bi bi-receipt fs-2 d-block mb-2"></i>

                                            No sales found.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        {{-- LOW STOCK --}}
        <div class="col-lg-4">

            <div class="card dashboard-panel h-100">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Low Stock
                        </h5>

                        <p class="text-muted small mb-0">
                            Products requiring attention
                        </p>

                    </div>

                    <span class="badge bg-danger rounded-pill">

                        {{ $lowStockProducts }}

                    </span>

                </div>


                <div class="card-body">

                    {{-- IMPORTANT:
                         $lowStockProducts = COUNT
                         $lowStockProductList = COLLECTION
                    --}}

                    @forelse($lowStockProductList as $product)

                        <div class="low-stock-item">

                            <div class="d-flex align-items-center gap-3">

                                <div class="stock-product-icon">

                                    <i class="bi bi-box-seam"></i>

                                </div>

                                <div>

                                    <div class="fw-semibold">
                                        {{ $product->name }}
                                    </div>

                                    <small class="text-muted">

                                        Minimum:
                                        {{ $product->minimum_stock }}

                                    </small>

                                </div>

                            </div>


                            <span class="badge bg-danger-subtle text-danger">

                                {{ $product->stock }}

                            </span>

                        </div>

                    @empty

                        <div class="text-center py-4">

                            <i class="bi bi-check-circle text-success fs-2"></i>

                            <p class="text-muted mt-2 mb-0">

                                All products have sufficient stock.

                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        TOP PRODUCTS + QUICK ACTIONS
    ========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- TOP PRODUCTS --}}
        <div class="col-lg-7">

            <div class="card dashboard-panel">

                <div class="card-header">

                    <h5 class="fw-bold mb-1">
                        Top Selling Products
                    </h5>

                    <p class="text-muted small mb-0">
                        Best performing products
                    </p>

                </div>


                <div class="card-body">

                    @forelse($topProducts as $index => $product)

                        <div class="top-product">

                            <div class="product-rank">

                                {{ $index + 1 }}

                            </div>


                            <div class="flex-grow-1">

                                <div class="fw-semibold">

                                    {{ $product->name }}

                                </div>

                                <small class="text-muted">

                                    {{ $product->total_quantity }}
                                    units sold

                                </small>

                            </div>


                            <strong>

                                PKR
                                {{ number_format($product->total_sales, 2) }}

                            </strong>

                        </div>

                    @empty

                        <div class="text-center text-muted py-4">

                            <i class="bi bi-box-seam fs-2 d-block mb-2"></i>

                            No product sales available.

                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- QUICK ACTIONS --}}
        <div class="col-lg-5">

            <div class="card dashboard-panel">

                <div class="card-header">

                    <h5 class="fw-bold mb-1">
                        Quick Actions
                    </h5>

                    <p class="text-muted small mb-0">
                        Common ERP operations
                    </p>

                </div>


                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-6">

                            <a href="{{ route('sales.create') }}"
                               class="quick-action">

                                <i class="bi bi-cart-plus"></i>

                                <span>
                                    New Sale
                                </span>

                            </a>

                        </div>


                        <div class="col-6">

                            <a href="{{ route('products.create') }}"
                               class="quick-action">

                                <i class="bi bi-box-seam"></i>

                                <span>
                                    Add Product
                                </span>

                            </a>

                        </div>


                        <div class="col-6">

                            <a href="{{ route('customers.create') }}"
                               class="quick-action">

                                <i class="bi bi-person-plus"></i>

                                <span>
                                    Add Customer
                                </span>

                            </a>

                        </div>


                        <div class="col-6">

                            <a href="{{ route('expenses.create') }}"
                               class="quick-action">

                                <i class="bi bi-wallet2"></i>

                                <span>
                                    Add Expense
                                </span>

                            </a>

                        </div>


                        <div class="col-6">

                            <a href="{{ route('reports.index') }}"
                               class="quick-action">

                                <i class="bi bi-bar-chart"></i>

                                <span>
                                    Reports
                                </span>

                            </a>

                        </div>


                        <div class="col-6">

                            <a href="{{ route('accounting.index') }}"
                               class="quick-action">

                                <i class="bi bi-calculator"></i>

                                <span>
                                    Accounting
                                </span>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        STOCK ALERTS
    ========================================================== --}}

    <div class="row g-4 mb-4">

        {{-- LOW STOCK --}}
        <div class="col-md-6">

            <div class="card dashboard-panel stock-alert-card h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center">

                            <div class="alert-icon warning">

                                <i class="bi bi-exclamation-triangle-fill"></i>

                            </div>

                            <div>

                                <h6 class="text-muted mb-1">
                                    Low Stock
                                </h6>

                                <h3 class="fw-bold mb-1">
                                    {{ $lowStockProducts }}
                                </h3>

                                <small class="text-muted">
                                    Products need restocking
                                </small>

                            </div>

                        </div>


                        @if($lowStockProducts > 0)

                            <a href="{{ route('notifications.index') }}"
                               class="btn btn-sm btn-outline-warning">

                                View

                            </a>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- OUT OF STOCK --}}
        <div class="col-md-6">

            <div class="card dashboard-panel stock-alert-card h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center">

                            <div class="alert-icon danger">

                                <i class="bi bi-x-circle-fill"></i>

                            </div>

                            <div>

                                <h6 class="text-muted mb-1">
                                    Out of Stock
                                </h6>

                                <h3 class="fw-bold mb-1">
                                    {{ $outOfStockProducts }}
                                </h3>

                                <small class="text-muted">
                                    Products unavailable
                                </small>

                            </div>

                        </div>


                        @if($outOfStockProducts > 0)

                            <a href="{{ route('notifications.index') }}"
                               class="btn btn-sm btn-outline-danger">

                                View

                            </a>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    CHART.JS
========================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('salesChart');

    if (!canvas) {
        return;
    }

    const chartData = @json($chartData);

    const labels = chartData.map(item => item.date);
    const sales = chartData.map(item => Number(item.sales));


    const ctx = canvas.getContext('2d');


    new Chart(ctx, {

        type: 'line',

        data: {

            labels: labels,

            datasets: [{

                label: 'Sales',

                data: sales,

                tension: 0.4,

                fill: true,

                borderWidth: 2,

                pointRadius: 3,

                pointHoverRadius: 6

            }]

        },


        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {
                intersect: false,
                mode: 'index'
            },


            plugins: {

                legend: {
                    display: false
                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return 'PKR ' +
                                Number(context.raw)
                                .toLocaleString();

                        }

                    }

                }

            },


            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        callback: function(value) {

                            return 'PKR ' +
                                Number(value).toLocaleString();

                        }

                    }

                },


                x: {

                    grid: {
                        display: false
                    }

                }

            }

        }

    });

});

</script>


{{-- =========================================================
    DASHBOARD CSS
========================================================== --}}

<style>

/* =========================================================
   MAIN DASHBOARD
========================================================= */

.dashboard-page-title {
    color: #0f172a;
    font-size: 28px;
    font-weight: 800;
    letter-spacing: -0.6px;
}

.dashboard-subtitle {
    color: #64748b;
}


/* =========================================================
   TITLE ICON
========================================================= */

.dashboard-title-icon {

    width: 42px;
    height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: linear-gradient(
        135deg,
        #4f46e5,
        #6366f1
    );

    color: #ffffff;

    box-shadow:
        0 8px 20px rgba(79, 70, 229, .20);

}


/* =========================================================
   DATE
========================================================= */

.dashboard-date {

    display: flex;
    align-items: center;
    gap: 8px;

    padding: 10px 15px;

    border: 1px solid #e5e7eb;

    border-radius: 12px;

    background: #ffffff;

    color: #475569;

    font-size: 13px;

    font-weight: 600;

    box-shadow:
        0 4px 15px rgba(15, 23, 42, .05);

}


/* =========================================================
   KPI CARD
========================================================= */

.dashboard-card {

    min-height: 145px;

    padding: 24px;

    display: flex;
    align-items: center;

    gap: 18px;

    background: #ffffff;

    border: 1px solid #e8ecf4;

    border-radius: 18px;

    box-shadow:
        0 6px 24px rgba(15, 23, 42, .06);

    transition:
        transform .25s ease,
        box-shadow .25s ease;

}


.dashboard-card:hover {

    transform: translateY(-4px);

    box-shadow:
        0 12px 32px rgba(15, 23, 42, .10);

}


/* =========================================================
   KPI ICON
========================================================= */

.dashboard-card .card-icon {

    width: 58px;
    height: 58px;

    min-width: 58px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 16px;

    background: linear-gradient(
        135deg,
        #eef2ff,
        #e0e7ff
    );

    color: #4f46e5;

    font-size: 25px;

}


/* =========================================================
   ERP PANEL
========================================================= */

.dashboard-panel {

    background: #ffffff;

    border: 1px solid #e8ecf4 !important;

    border-radius: 18px !important;

    overflow: hidden;

    box-shadow:
        0 6px 24px rgba(15, 23, 42, .06) !important;

}


/* =========================================================
   CARD HEADER
========================================================= */

.dashboard-panel .card-header {

    background: #ffffff !important;

    border-bottom: 1px solid #eef1f6 !important;

    padding: 20px 24px;

}


/* =========================================================
   CARD BODY
========================================================= */

.dashboard-panel .card-body {

    padding: 22px 24px;

}


/* =========================================================
   CHART
========================================================= */

.chart-container {

    height: 330px;

}


/* =========================================================
   SUMMARY
========================================================= */

.summary-row {

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 14px 0;

    border-bottom: 1px dashed #e5e7eb;

}


.summary-row:last-child {

    border-bottom: none;

}


/* =========================================================
   BUSINESS STATISTICS
========================================================= */

.stat-card {

    min-height: 95px;

    padding: 18px;

    display: flex;

    align-items: center;

    gap: 15px;

    background: #ffffff;

    border: 1px solid #e8ecf4;

    border-radius: 16px;

    box-shadow:
        0 6px 20px rgba(15, 23, 42, .05);

    transition: all .25s ease;

}


.stat-card:hover {

    transform: translateY(-3px);

    box-shadow:
        0 10px 26px rgba(15, 23, 42, .08);

}


.stat-icon {

    width: 48px;
    height: 48px;

    min-width: 48px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 14px;

    background: #f1f5ff;

    color: #4f46e5;

    font-size: 21px;

}


/* =========================================================
   TABLE
========================================================= */

.dashboard-table thead th {

    background: #f8fafc;

    color: #64748b;

    font-size: 12px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .4px;

    border-bottom: 1px solid #e5e7eb;

    padding-top: 14px;

    padding-bottom: 14px;

}


.dashboard-table tbody td {

    padding-top: 15px;

    padding-bottom: 15px;

    border-bottom: 1px solid #f1f5f9;

    color: #334155;

}


.dashboard-table tbody tr {

    transition: background .2s ease;

}


.dashboard-table tbody tr:hover {

    background: #f8faff;

}


.invoice-link {

    color: #4f46e5;

    font-weight: 700;

    text-decoration: none;

}


.invoice-link:hover {

    color: #4338ca;

}


/* =========================================================
   LOW STOCK
========================================================= */

.low-stock-item {

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 13px 0;

    border-bottom: 1px solid #eef1f5;

}


.low-stock-item:last-child {

    border-bottom: none;

}


.stock-product-icon {

    width: 40px;
    height: 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 11px;

    background: #fff7ed;

    color: #f97316;

}


/* =========================================================
   TOP PRODUCTS
========================================================= */

.top-product {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 15px 0;

    border-bottom: 1px solid #eef1f5;

}


.top-product:last-child {

    border-bottom: none;

}


.product-rank {

    width: 38px;
    height: 38px;

    min-width: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background: #eef2ff;

    color: #4f46e5;

    font-weight: 700;

}


/* =========================================================
   QUICK ACTIONS
========================================================= */

.quick-action {

    min-height: 108px;

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    gap: 9px;

    border: 1px solid #e5e7eb;

    border-radius: 15px;

    background: #ffffff;

    color: #334155;

    text-decoration: none;

    transition: all .22s ease;

}


.quick-action i {

    font-size: 26px;

    color: #4f46e5;

}


.quick-action span {

    font-size: 13px;

    font-weight: 600;

}


.quick-action:hover {

    transform: translateY(-4px);

    border-color: #6366f1;

    background: #f8faff;

    color: #4f46e5;

    box-shadow:
        0 8px 20px rgba(79, 70, 229, .10);

}


/* =========================================================
   STOCK ALERTS
========================================================= */

.stock-alert-card {

    transition: all .25s ease;

}


.stock-alert-card:hover {

    transform: translateY(-3px);

}


.alert-icon {

    width: 58px;
    height: 58px;

    margin-right: 16px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 24px;

}


.alert-icon.warning {

    background: rgba(245, 158, 11, .10);

    color: #f59e0b;

}


.alert-icon.danger {

    background: rgba(239, 68, 68, .10);

    color: #ef4444;

}


/* =========================================================
   BADGES
========================================================= */

.badge {

    font-weight: 600;

    letter-spacing: .1px;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 992px) {

    .chart-container {

        height: 300px;

    }

}


@media (max-width: 768px) {

    .dashboard-page-title {

        font-size: 23px;

    }


    .dashboard-card {

        min-height: 120px;

        padding: 18px;

    }


    .dashboard-card h3 {

        font-size: 20px;

    }


    .stat-card {

        padding: 16px;

    }


    .dashboard-table {

        font-size: 13px;

    }


    .quick-action {

        min-height: 95px;

    }


    .chart-container {

        height: 260px;

    }

}


@media (max-width: 576px) {

    .dashboard-card {

        gap: 13px;

    }


    .dashboard-card .card-icon {

        width: 48px;

        height: 48px;

        min-width: 48px;

        font-size: 20px;

    }


    .dashboard-card h3 {

        font-size: 18px;

    }


    .dashboard-panel .card-header {

        padding: 17px;

    }


    .dashboard-panel .card-body {

        padding: 17px;

    }


    .dashboard-date {

        width: 100%;

        justify-content: center;

    }


    .chart-container {

        height: 230px;

    }

}

</style>

@endsection