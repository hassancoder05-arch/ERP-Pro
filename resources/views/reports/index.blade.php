@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')

<div class="container-fluid py-4 reports-dashboard">

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div class="d-flex align-items-center gap-3">

        <div class="reports-header-icon">
            <i class="bi bi-bar-chart-line"></i>
        </div>

        <div>
            <h2 class="fw-bold mb-1">Reports &amp; Analytics</h2>

            <p class="text-muted mb-0">
                Business performance and financial reports
            </p>
        </div>

    </div>

    <button onclick="window.print()" class="btn btn-outline-dark reports-print-btn">
        <i class="bi bi-printer me-2"></i>
        Print Report
    </button>

</div>


{{-- Date Filter --}}
<div class="card report-card report-filter-card mb-4">

    <div class="card-body p-4">

        <div class="d-flex align-items-center gap-2 mb-3">
            <div class="filter-icon">
                <i class="bi bi-calendar-range"></i>
            </div>

            <div>
                <h5 class="fw-bold mb-1">Report Filters</h5>
                <p class="text-muted small mb-0">
                    Select a date range to view business performance
                </p>
            </div>
        </div>

        <form method="GET" action="{{ route('reports.index') }}">

            <div class="row g-3 align-items-end">

                <div class="col-xl-4 col-md-4">
                    <label for="start_date" class="form-label">
                        Start Date
                    </label>

                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        class="form-control report-input"
                        value="{{ $startDate }}"
                    >
                </div>

                <div class="col-xl-4 col-md-4">
                    <label for="end_date" class="form-label">
                        End Date
                    </label>

                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        class="form-control report-input"
                        value="{{ $endDate }}"
                    >
                </div>

                <div class="col-xl-2 col-md-2 col-6">
                    <button type="submit" class="btn btn-primary w-100 report-apply-btn">
                        <i class="bi bi-funnel me-1"></i>
                        Apply
                    </button>
                </div>

                <div class="col-xl-2 col-md-2 col-6">
                    <a
                        href="{{ route('reports.index') }}"
                        class="btn btn-outline-secondary w-100 report-reset-btn"
                    >
                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        Reset
                    </a>
                </div>

            </div>

        </form>

    </div>

</div>


{{-- KPI Section --}}
<div class="d-flex align-items-center gap-2 mb-3">
    <i class="bi bi-speedometer2 text-primary fs-5"></i>
    <h5 class="fw-bold mb-0">Business Overview</h5>
</div>

<div class="row g-4 mb-4">

    {{-- Total Sales --}}
    <div class="col-xxl-3 col-md-6">

        <div class="card report-card kpi-card sales-kpi h-100">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start gap-2">

                    <div class="flex-grow-1">
                        <p class="kpi-label">TOTAL SALES</p>

                        <h3 class="kpi-value">
                            Rs. {{ number_format($totalSales, 2) }}
                        </h3>

                        <span class="kpi-description">
                            <i class="bi bi-receipt me-1"></i>
                            Sales revenue
                        </span>
                    </div>

                    <div class="kpi-icon sales-kpi-icon">
                        <i class="bi bi-cart-check"></i>
                    </div>

                </div>

            </div>
        </div>

    </div>


    {{-- Total Expenses --}}
    <div class="col-xxl-3 col-md-6">

        <div class="card report-card kpi-card expenses-kpi h-100">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start gap-2">

                    <div class="flex-grow-1">
                        <p class="kpi-label">TOTAL EXPENSES</p>

                        <h3 class="kpi-value text-danger">
                            Rs. {{ number_format($totalExpenses, 2) }}
                        </h3>

                        <span class="kpi-description">
                            <i class="bi bi-wallet2 me-1"></i>
                            Business expenses
                        </span>
                    </div>

                    <div class="kpi-icon expenses-kpi-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                </div>

            </div>
        </div>

    </div>


    {{-- Other Income --}}
    <div class="col-xxl-3 col-md-6">

        <div class="card report-card kpi-card income-kpi h-100">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start gap-2">

                    <div class="flex-grow-1">
                        <p class="kpi-label">OTHER INCOME</p>

                        <h3 class="kpi-value text-success">
                            Rs. {{ number_format($totalIncome, 2) }}
                        </h3>

                        <span class="kpi-description">
                            <i class="bi bi-graph-up-arrow me-1"></i>
                            Additional income
                        </span>
                    </div>

                    <div class="kpi-icon income-kpi-icon">
                        <i class="bi bi-currency-exchange"></i>
                    </div>

                </div>

            </div>
        </div>

    </div>


    {{-- Net Profit --}}
    <div class="col-xxl-3 col-md-6">

        <div class="card report-card kpi-card profit-kpi h-100">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start gap-2">

                    <div class="flex-grow-1">
                        <p class="kpi-label">NET PROFIT</p>

                        <h3 class="kpi-value {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
                            Rs. {{ number_format($netProfit, 2) }}
                        </h3>

                        <span class="kpi-description">
                            <i class="bi bi-pie-chart me-1"></i>
                            Overall profitability
                        </span>
                    </div>

                    <div class="kpi-icon profit-kpi-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>


{{-- Cash Flow Section --}}
<div class="d-flex align-items-center gap-2 mb-3">
    <i class="bi bi-arrow-left-right text-primary fs-5"></i>
    <h5 class="fw-bold mb-0">Cash Flow Overview</h5>
</div>

<div class="row g-4 mb-4">

    {{-- Cash In --}}
    <div class="col-xl-4 col-md-6">

        <div class="card report-card cash-card cash-in-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center gap-2">

                    <div>
                        <p class="kpi-label">TOTAL CASH IN</p>

                        <h3 class="cash-value text-success">
                            Rs. {{ number_format($cashIn, 2) }}
                        </h3>
                    </div>

                    <div class="cash-icon cash-in-icon">
                        <i class="bi bi-box-arrow-in-down-left"></i>
                    </div>

                </div>

                <div class="cash-divider"></div>

                <div class="cash-detail-row">
                    <span>
                        <i class="bi bi-cart-check me-2"></i>
                        Sales
                    </span>

                    <strong>
                        Rs. {{ number_format($totalSales, 2) }}
                    </strong>
                </div>

                <div class="cash-detail-row">
                    <span>
                        <i class="bi bi-plus-circle me-2"></i>
                        Other Income
                    </span>

                    <strong>
                        Rs. {{ number_format($totalIncome, 2) }}
                    </strong>
                </div>

                <div class="cash-detail-row">
                    <span>
                        <i class="bi bi-people me-2"></i>
                        Customer Payments
                    </span>

                    <strong>
                        Rs. {{ number_format($totalCustomerPayments, 2) }}
                    </strong>
                </div>

            </div>

            <div class="cash-card-bottom cash-in-bottom"></div>

        </div>

    </div>


    {{-- Cash Out --}}
    <div class="col-xl-4 col-md-6">

        <div class="card report-card cash-card cash-out-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center gap-2">

                    <div>
                        <p class="kpi-label">TOTAL CASH OUT</p>

                        <h3 class="cash-value text-danger">
                            Rs. {{ number_format($cashOut, 2) }}
                        </h3>
                    </div>

                    <div class="cash-icon cash-out-icon">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </div>

                </div>

                <div class="cash-divider"></div>

                <div class="cash-detail-row">
                    <span>
                        <i class="bi bi-receipt-cutoff me-2"></i>
                        Expenses
                    </span>

                    <strong>
                        Rs. {{ number_format($totalExpenses, 2) }}
                    </strong>
                </div>

                <div class="cash-detail-row">
                    <span>
                        <i class="bi bi-truck me-2"></i>
                        Supplier Payments
                    </span>

                    <strong>
                        Rs. {{ number_format($totalSupplierPayments, 2) }}
                    </strong>
                </div>

            </div>

            <div class="cash-card-bottom cash-out-bottom"></div>

        </div>

    </div>


    {{-- Cash Balance --}}
    <div class="col-xl-4 col-md-12">

        <div class="card report-card cash-card cash-balance-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center gap-2">

                    <div>
                        <p class="kpi-label">CASH BALANCE</p>

                        <h3 class="cash-value {{ $cashBalance >= 0 ? 'text-success' : 'text-danger' }}">
                            Rs. {{ number_format($cashBalance, 2) }}
                        </h3>
                    </div>

                    <div class="cash-icon cash-balance-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>

                </div>

                <div class="cash-divider"></div>

                <div class="cash-detail-row">
                    <span>
                        <i class="bi bi-bar-chart me-2"></i>
                        Total Revenue
                    </span>

                    <strong>
                        Rs. {{ number_format($totalRevenue, 2) }}
                    </strong>
                </div>

                <div class="cash-detail-row">
                    <span>
                        <i class="bi bi-arrow-up-right-circle me-2"></i>
                        Cash Out
                    </span>

                    <strong>
                        Rs. {{ number_format($cashOut, 2) }}
                    </strong>
                </div>

                <div class="mt-3">
                    <span class="badge {{ $cashBalance >= 0 ? 'text-bg-success' : 'text-bg-danger' }}">
                        <i class="bi {{ $cashBalance >= 0 ? 'bi-check-circle' : 'bi-exclamation-circle' }} me-1"></i>
                        {{ $cashBalance >= 0 ? 'Positive Balance' : 'Negative Balance' }}
                    </span>
                </div>

            </div>

            <div class="cash-card-bottom cash-balance-bottom"></div>

        </div>

    </div>

</div>


{{-- Top Selling Products --}}
<div class="card report-card report-table-card mb-4">

    <div class="card-header report-section-header">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="section-icon top-products-icon">
                    <i class="bi bi-trophy"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">Top Selling Products</h5>

                    <p class="text-muted small mb-0">
                        Products ranked by sales performance
                    </p>
                </div>

            </div>

            <span class="report-section-badge">
                <i class="bi bi-box-seam me-1"></i>
                Product Performance
            </span>

        </div>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table report-table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="ps-4" style="width: 80px;">RANK</th>
                        <th>PRODUCT</th>
                        <th>QUANTITY SOLD</th>
                        <th class="text-end pe-4">TOTAL SALES</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($topProducts as $index => $product)

                        <tr>

                            <td class="ps-4">
                                @if($index === 0)
                                    <span class="rank-badge rank-gold">
                                        <i class="bi bi-trophy-fill"></i>
                                    </span>
                                @elseif($index === 1)
                                    <span class="rank-badge rank-silver">
                                        <i class="bi bi-award-fill"></i>
                                    </span>
                                @elseif($index === 2)
                                    <span class="rank-badge rank-bronze">
                                        <i class="bi bi-award"></i>
                                    </span>
                                @else
                                    <span class="rank-number">
                                        {{ $index + 1 }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">

                                    <div class="product-table-icon">
                                        <i class="bi bi-box-seam"></i>
                                    </div>

                                    <span class="fw-semibold">
                                        {{ $product->name }}
                                    </span>

                                </div>
                            </td>

                            <td>
                                <span class="quantity-badge">
                                    {{ number_format($product->total_quantity) }} units
                                </span>
                            </td>

                            <td class="text-end pe-4 fw-bold">
                                Rs. {{ number_format($product->total_sales, 2) }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center py-5">

                                <div class="empty-state-icon">
                                    <i class="bi bi-inbox"></i>
                                </div>

                                <h6 class="fw-bold mt-3 mb-1">
                                    No Product Sales
                                </h6>

                                <p class="text-muted small mb-0">
                                    No sales found for this period.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- Sales Report --}}
<div class="card report-card report-table-card mb-4">

    <div class="card-header report-section-header">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="section-icon sales-report-icon">
                    <i class="bi bi-receipt"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">Sales Report</h5>

                    <p class="text-muted small mb-0">
                        Invoice-level sales details for the selected period
                    </p>
                </div>

            </div>

            <span class="report-section-badge">
                <i class="bi bi-file-earmark-text me-1"></i>
                Sales Transactions
            </span>

        </div>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table report-table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="ps-4">INVOICE</th>
                        <th>CUSTOMER</th>
                        <th>DATE</th>
                        <th class="text-end">DISCOUNT</th>
                        <th class="text-end pe-4">TOTAL</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($sales as $sale)

                        <tr>

                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">

                                    <div class="invoice-icon">
                                        <i class="bi bi-file-earmark-check"></i>
                                    </div>

                                    <span class="fw-semibold">
                                        {{ $sale->invoice_number }}
                                    </span>

                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2">

                                    <div class="customer-icon">
                                        <i class="bi bi-person"></i>
                                    </div>

                                    <span>
                                        {{ $sale->customer->name ?? 'Walk-in Customer' }}
                                    </span>

                                </div>
                            </td>

                            <td class="text-nowrap">
                                <i class="bi bi-calendar3 text-muted me-1"></i>
                                {{ $sale->sale_date->format('d M Y') }}
                            </td>

                            <td class="text-end text-danger">
                                Rs. {{ number_format($sale->discount, 2) }}
                            </td>

                            <td class="text-end pe-4 fw-bold">
                                Rs. {{ number_format($sale->grand_total, 2) }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-5">

                                <div class="empty-state-icon">
                                    <i class="bi bi-receipt"></i>
                                </div>

                                <h6 class="fw-bold mt-3 mb-1">
                                    No Sales Found
                                </h6>

                                <p class="text-muted small mb-0">
                                    No sales transactions are available for this period.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- Inventory Summary --}}
<div class="d-flex align-items-center gap-2 mb-3">
    <i class="bi bi-boxes text-primary fs-5"></i>
    <h5 class="fw-bold mb-0">Inventory Summary</h5>
</div>

<div class="row g-4 mb-4">

    {{-- Total Products --}}
    <div class="col-xl-4 col-md-6">

        <div class="card report-card inventory-kpi-card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3">

                    <div class="inventory-kpi-icon products-inventory-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div>
                        <p class="kpi-label mb-2">TOTAL PRODUCTS</p>

                        <h3 class="fw-bold mb-1">
                            {{ number_format($totalProducts) }}
                        </h3>

                        <p class="text-muted small mb-0">
                            Registered products
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Total Stock --}}
    <div class="col-xl-4 col-md-6">

        <div class="card report-card inventory-kpi-card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3">

                    <div class="inventory-kpi-icon stock-inventory-icon">
                        <i class="bi bi-stack"></i>
                    </div>

                    <div>
                        <p class="kpi-label mb-2">TOTAL STOCK UNITS</p>

                        <h3 class="fw-bold mb-1">
                            {{ number_format($totalStock) }}
                        </h3>

                        <p class="text-muted small mb-0">
                            Units in inventory
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Low Stock --}}
    <div class="col-xl-4 col-md-6">

        <div class="card report-card inventory-kpi-card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3">

                    <div class="inventory-kpi-icon {{ $lowStockProducts > 0 ? 'low-stock-inventory-icon' : 'healthy-stock-icon' }}">
                        <i class="bi {{ $lowStockProducts > 0 ? 'bi-exclamation-triangle' : 'bi-check-circle' }}"></i>
                    </div>

                    <div>
                        <p class="kpi-label mb-2">LOW STOCK PRODUCTS</p>

                        <h3 class="fw-bold mb-1 {{ $lowStockProducts > 0 ? 'text-danger' : 'text-success' }}">
                            {{ number_format($lowStockProducts) }}
                        </h3>

                        <p class="text-muted small mb-0">
                            {{ $lowStockProducts > 0 ? 'Products require attention' : 'Stock levels look healthy' }}
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- Report Period --}}
<div class="report-period-card mb-4">

    <div class="d-flex align-items-start gap-3">

        <div class="period-icon">
            <i class="bi bi-calendar3"></i>
        </div>

        <div>
            <h6 class="fw-bold mb-2">
                Report Period
            </h6>

            <p class="text-muted small mb-1">
                Displaying report information between the following dates:
            </p>

            <div class="d-flex flex-wrap align-items-center gap-2">

                <span class="period-date">
                    {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
                </span>

                <i class="bi bi-arrow-right text-muted"></i>

                <span class="period-date">
                    {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                </span>

            </div>
        </div>

    </div>

</div>


</div>

{{-- Reports & Analytics Styles --}}

<style>
    .reports-dashboard {
        --report-primary: #4f46e5;
        --report-border: #e8edf4;
        --report-muted: #64748b;
        color: #1e293b;
    }

    .reports-dashboard .reports-header-icon {
        width: 58px;
        height: 58px;
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 28px;
    }

    .reports-dashboard .reports-print-btn {
        min-height: 43px;
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
    }

    .reports-dashboard .report-card {
        border: 1px solid var(--report-border) !important;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.035);
        overflow: hidden;
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }

    .reports-dashboard .report-card:hover {
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.07);
    }

    .reports-dashboard .report-filter-card {
        border-top: 3px solid var(--report-primary) !important;
    }

    .reports-dashboard .filter-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #eef2ff;
        color: var(--report-primary);
        font-size: 18px;
    }

    .reports-dashboard .form-label {
        color: #334155;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .reports-dashboard .report-input {
        min-height: 44px;
        border: 1px solid #dce3ed;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 13px;
        color: #334155;
    }

    .reports-dashboard .report-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .reports-dashboard .report-apply-btn,
    .reports-dashboard .report-reset-btn {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
    }

    .reports-dashboard .report-apply-btn {
        background: var(--report-primary);
        border-color: var(--report-primary);
    }

    .reports-dashboard .report-apply-btn:hover {
        background: #4338ca;
        border-color: #4338ca;
    }

    .reports-dashboard .kpi-card {
        position: relative;
        min-height: 155px;
    }

    .reports-dashboard .kpi-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }

    .reports-dashboard .sales-kpi::before {
        background: #3b82f6;
    }

    .reports-dashboard .expenses-kpi::before {
        background: #ef4444;
    }

    .reports-dashboard .income-kpi::before {
        background: #10b981;
    }

    .reports-dashboard .profit-kpi::before {
        background: #8b5cf6;
    }

    .reports-dashboard .kpi-label {
        color: var(--report-muted);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.8px;
        margin-bottom: 10px;
    }

    .reports-dashboard .kpi-value {
        font-size: clamp(18px, 1.5vw, 24px);
        font-weight: 750;
        letter-spacing: -0.5px;
        overflow-wrap: anywhere;
        margin-bottom: 12px;
    }

    .reports-dashboard .kpi-description {
        color: var(--report-muted);
        font-size: 12px;
    }

    .reports-dashboard .kpi-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 14px;
        font-size: 22px;
    }

    .reports-dashboard .sales-kpi-icon {
        color: #2563eb;
        background: #eff6ff;
    }

    .reports-dashboard .expenses-kpi-icon {
        color: #dc2626;
        background: #fef2f2;
    }

    .reports-dashboard .income-kpi-icon {
        color: #059669;
        background: #ecfdf5;
    }

    .reports-dashboard .profit-kpi-icon {
        color: #7c3aed;
        background: #f5f3ff;
    }

    .reports-dashboard .cash-card {
        position: relative;
        height: 100%;
        min-height: 240px;
    }

    .reports-dashboard .cash-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 14px;
        font-size: 22px;
    }

    .reports-dashboard .cash-in-icon {
        color: #059669;
        background: #ecfdf5;
    }

    .reports-dashboard .cash-out-icon {
        color: #dc2626;
        background: #fef2f2;
    }

    .reports-dashboard .cash-balance-icon {
        color: #4f46e5;
        background: #eef2ff;
    }

    .reports-dashboard .cash-value {
        font-size: clamp(19px, 1.7vw, 25px);
        font-weight: 750;
        letter-spacing: -0.5px;
        margin: 0;
        overflow-wrap: anywhere;
    }

    .reports-dashboard .cash-divider {
        height: 1px;
        background: #edf0f5;
        margin: 22px 0 12px;
    }

    .reports-dashboard .cash-detail-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 0;
        font-size: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .reports-dashboard .cash-detail-row:last-child {
        border-bottom: 0;
    }

    .reports-dashboard .cash-detail-row > span {
        color: #64748b;
    }

    .reports-dashboard .cash-detail-row > strong {
        text-align: right;
        overflow-wrap: anywhere;
    }

    .reports-dashboard .cash-card-bottom {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }

    .reports-dashboard .cash-in-bottom {
        background: #10b981;
    }

    .reports-dashboard .cash-out-bottom {
        background: #ef4444;
    }

    .reports-dashboard .cash-balance-bottom {
        background: #6366f1;
    }

    .reports-dashboard .report-section-header {
        padding: 20px 24px;
        background: #fff;
        border-bottom: 1px solid var(--report-border);
    }

    .reports-dashboard .section-icon {
        width: 46px;
        height: 46px;
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 21px;
    }

    .reports-dashboard .top-products-icon {
        background: #fffbeb;
        color: #d97706;
    }

    .reports-dashboard .sales-report-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .reports-dashboard .report-section-badge {
        padding: 8px 11px;
        border-radius: 9px;
        background: #f1f5f9;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
    }

    .reports-dashboard .report-table thead th {
        padding-top: 15px;
        padding-bottom: 15px;
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.7px;
        white-space: nowrap;
        border-bottom: 1px solid var(--report-border);
    }

    .reports-dashboard .report-table tbody td {
        padding-top: 15px;
        padding-bottom: 15px;
        font-size: 12px;
        border-color: #eef2f7;
    }

    .reports-dashboard .report-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .reports-dashboard .report-table tbody tr:hover {
        background: #fafbff;
    }

    .reports-dashboard .rank-badge,
    .reports-dashboard .rank-number {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
    }

    .reports-dashboard .rank-gold {
        background: #fef3c7;
        color: #b45309;
    }

    .reports-dashboard .rank-silver {
        background: #e2e8f0;
        color: #475569;
    }

    .reports-dashboard .rank-bronze {
        background: #ffedd5;
        color: #c2410c;
    }

    .reports-dashboard .rank-number {
        background: #f1f5f9;
        color: #475569;
    }

    .reports-dashboard .product-table-icon,
    .reports-dashboard .invoice-icon,
    .reports-dashboard .customer-icon {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 10px;
        font-size: 15px;
    }

    .reports-dashboard .product-table-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .reports-dashboard .invoice-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .reports-dashboard .customer-icon {
        background: #f1f5f9;
        color: #475569;
    }

    .reports-dashboard .quantity-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #334155;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .reports-dashboard .empty-state-icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border-radius: 15px;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 24px;
    }

    .reports-dashboard .inventory-kpi-card {
        border-left: 4px solid #6366f1 !important;
    }

    .reports-dashboard .inventory-kpi-icon {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 15px;
        font-size: 25px;
    }

    .reports-dashboard .products-inventory-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .reports-dashboard .stock-inventory-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .reports-dashboard .low-stock-inventory-icon {
        background: #fff1f2;
        color: #e11d48;
    }

    .reports-dashboard .healthy-stock-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .reports-dashboard .report-period-card {
        padding: 22px;
        border: 1px solid #e0e7ff;
        border-radius: 15px;
        background: #f8faff;
    }

    .reports-dashboard .period-icon {
        width: 45px;
        height: 45px;
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 20px;
    }

    .reports-dashboard .period-date {
        padding: 7px 11px;
        border: 1px solid #e0e7ff;
        border-radius: 8px;
        background: #fff;
        color: #3730a3;
        font-size: 12px;
        font-weight: 700;
    }

    @media (max-width: 767.98px) {
        .reports-dashboard {
            padding-top: 16px !important;
        }

        .reports-dashboard .reports-header-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            font-size: 23px;
        }

        .reports-dashboard h2 {
            font-size: 22px;
        }

        .reports-dashboard .reports-print-btn {
            width: 100%;
        }

        .reports-dashboard .kpi-card {
            min-height: auto;
        }

        .reports-dashboard .kpi-value {
            font-size: 19px;
        }

        .reports-dashboard .report-section-header {
            padding: 16px;
        }

        .reports-dashboard .report-table thead th,
        .reports-dashboard .report-table tbody td {
            padding-left: 12px;
            padding-right: 12px;
        }

        .reports-dashboard .report-table .ps-4 {
            padding-left: 12px !important;
        }

        .reports-dashboard .report-table .pe-4 {
            padding-right: 12px !important;
        }

        .reports-dashboard .report-period-card {
            padding: 16px;
        }
    }

    @media print {
        @page {
            size: landscape;
            margin: 12mm;
        }

        body {
            background: #fff !important;
            color: #000 !important;
            font-size: 10px !important;
        }

        .reports-dashboard {
            width: 100% !important;
            padding: 0 !important;
        }

        .sidebar,
        .navbar,
        .reports-print-btn,
        .report-filter-card,
        form,
        .btn {
            display: none !important;
        }

        .main-content {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .reports-dashboard .report-card,
        .reports-dashboard .report-period-card {
            box-shadow: none !important;
            break-inside: avoid;
            border: 1px solid #ddd !important;
        }

        .reports-dashboard .report-card:hover {
            box-shadow: none !important;
        }

        .reports-dashboard .row {
            break-inside: avoid;
        }

        .reports-dashboard .report-table thead th,
        .reports-dashboard .report-table tbody td {
            padding: 7px !important;
        }

        .reports-dashboard .cash-card,
        .reports-dashboard .kpi-card {
            min-height: auto !important;
        }

        .reports-dashboard .cash-card-bottom {
            display: none;
        }
    }
</style>

@endsection
