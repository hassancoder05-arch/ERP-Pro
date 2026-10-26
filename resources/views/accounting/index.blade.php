@extends('layouts.app')

@section('title', 'Accounting')

@section('content')

<div class="container-fluid py-4 accounting-dashboard">


{{-- Dashboard Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>
        <div class="d-flex align-items-center gap-3">

            <div class="accounting-header-icon">
                <i class="bi bi-calculator"></i>
            </div>

            <div>
                <h2 class="fw-bold mb-1">Accounting</h2>

                <p class="text-muted mb-0">
                    Profit, COGS and cash flow analysis
                </p>
            </div>

        </div>
    </div>

    <div class="accounting-period-badge">
        <i class="bi bi-calendar3 me-2"></i>
        Financial Overview
    </div>

</div>


{{-- Date Filter --}}
<div class="card accounting-card filter-card mb-4">

    <div class="card-body p-4">

        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-funnel text-primary fs-5"></i>

            <h5 class="fw-bold mb-0">
                Filter Financial Period
            </h5>
        </div>

        <form method="GET" action="{{ route('accounting.index') }}">

            <div class="row g-3 align-items-end">

                <div class="col-lg-5 col-md-5">

                    <label for="start_date" class="form-label">
                        Start Date
                    </label>

                    <input
                        type="date"
                        id="start_date"
                        name="start_date"
                        value="{{ $startDate }}"
                        class="form-control accounting-input"
                    >

                </div>

                <div class="col-lg-5 col-md-5">

                    <label for="end_date" class="form-label">
                        End Date
                    </label>

                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ $endDate }}"
                        class="form-control accounting-input"
                    >

                </div>

                <div class="col-lg-2 col-md-2">

                    <button type="submit" class="btn btn-primary accounting-filter-btn w-100">
                        <i class="bi bi-filter me-1"></i>
                        Apply Filter
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- Profit Summary Cards --}}
<div class="d-flex align-items-center gap-2 mb-3">

    <i class="bi bi-bar-chart-line text-primary fs-5"></i>

    <h5 class="fw-bold mb-0">
        Financial Summary
    </h5>

</div>

<div class="row g-4 mb-4">

    {{-- Sales --}}
    <div class="col-xxl-3 col-md-6">

        <div class="card accounting-card summary-card sales-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="summary-label">TOTAL SALES</p>

                        <h3 class="summary-value">
                            PKR {{ number_format($totalSales, 2) }}
                        </h3>

                        <span class="summary-description">
                            <i class="bi bi-receipt me-1"></i>
                            Sales revenue
                        </span>
                    </div>

                    <div class="summary-icon sales-icon">
                        <i class="bi bi-cart-check"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- COGS --}}
    <div class="col-xxl-3 col-md-6">

        <div class="card accounting-card summary-card cogs-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="summary-label">COST OF GOODS SOLD</p>

                        <h3 class="summary-value text-danger">
                            PKR {{ number_format($cogs, 2) }}
                        </h3>

                        <span class="summary-description">
                            <i class="bi bi-box-seam me-1"></i>
                            Product costs
                        </span>
                    </div>

                    <div class="summary-icon cogs-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Gross Profit --}}
    <div class="col-xxl-3 col-md-6">

        <div class="card accounting-card summary-card gross-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="summary-label">GROSS PROFIT</p>

                        <h3 class="summary-value text-success">
                            PKR {{ number_format($grossProfit, 2) }}
                        </h3>

                        <span class="summary-description">
                            <i class="bi bi-graph-up-arrow me-1"></i>
                            Before other expenses
                        </span>
                    </div>

                    <div class="summary-icon gross-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Net Profit --}}
    <div class="col-xxl-3 col-md-6">

        <div class="card accounting-card summary-card net-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <p class="summary-label">NET PROFIT</p>

                        <h3 class="summary-value {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
                            PKR {{ number_format($netProfit, 2) }}
                        </h3>

                        <span class="summary-description">
                            <i class="bi bi-activity me-1"></i>
                            Overall profitability
                        </span>
                    </div>

                    <div class="summary-icon net-icon">
                        <i class="bi bi-currency-exchange"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- Profit & Loss Statement --}}
<div class="card accounting-card mb-4">

    <div class="card-header accounting-section-header">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div class="d-flex align-items-center gap-3">

                <div class="section-icon profit-section-icon">
                    <i class="bi bi-file-earmark-spreadsheet"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">
                        Profit &amp; Loss Statement
                    </h5>

                    <p class="text-muted small mb-0">
                        Revenue, product costs and operating results
                    </p>
                </div>

            </div>

            <span class="accounting-status-badge">
                <i class="bi bi-check-circle me-1"></i>
                Financial Report
            </span>

        </div>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table accounting-table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="ps-4">DESCRIPTION</th>
                        <th class="text-end pe-4">AMOUNT (PKR)</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">

                                <div class="table-row-icon revenue-row-icon">
                                    <i class="bi bi-cash-stack"></i>
                                </div>

                                <div>
                                    <div class="fw-semibold">Sales Revenue</div>
                                    <small class="text-muted">Total sales generated</small>
                                </div>

                            </div>
                        </td>

                        <td class="text-end pe-4 fw-semibold">
                            {{ number_format($totalSales, 2) }}
                        </td>
                    </tr>


                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">

                                <div class="table-row-icon expense-row-icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>

                                <div>
                                    <div class="fw-semibold">Cost of Goods Sold</div>
                                    <small class="text-muted">Cost of products sold</small>
                                </div>

                            </div>
                        </td>

                        <td class="text-end pe-4 fw-semibold text-danger">
                            − {{ number_format($cogs, 2) }}
                        </td>
                    </tr>


                    <tr class="profit-total-row">
                        <td class="ps-4 fw-bold">
                            <i class="bi bi-graph-up-arrow text-success me-2"></i>
                            Gross Profit
                        </td>

                        <td class="text-end pe-4 fw-bold text-success">
                            {{ number_format($grossProfit, 2) }}
                        </td>
                    </tr>


                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">

                                <div class="table-row-icon income-row-icon">
                                    <i class="bi bi-plus-circle"></i>
                                </div>

                                <div>
                                    <div class="fw-semibold">Other Income</div>
                                    <small class="text-muted">Additional recorded income</small>
                                </div>

                            </div>
                        </td>

                        <td class="text-end pe-4 fw-semibold text-success">
                            + {{ number_format($totalIncome, 2) }}
                        </td>
                    </tr>


                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">

                                <div class="table-row-icon expense-row-icon">
                                    <i class="bi bi-receipt-cutoff"></i>
                                </div>

                                <div>
                                    <div class="fw-semibold">Operating Expenses</div>
                                    <small class="text-muted">Business operating costs</small>
                                </div>

                            </div>
                        </td>

                        <td class="text-end pe-4 fw-semibold text-danger">
                            − {{ number_format($totalExpenses, 2) }}
                        </td>
                    </tr>


                    <tr class="net-profit-row">
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">

                                <div class="table-row-icon net-profit-row-icon">
                                    <i class="bi bi-calculator"></i>
                                </div>

                                <div>
                                    <div class="fw-bold">Net Profit</div>
                                    <small class="text-muted">Final reported profit or loss</small>
                                </div>

                            </div>
                        </td>

                        <td class="text-end pe-4 fw-bold {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($netProfit, 2) }}
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- Cash Flow --}}
<div class="d-flex align-items-center gap-2 mb-3">

    <i class="bi bi-arrow-left-right text-primary fs-5"></i>

    <h5 class="fw-bold mb-0">
        Cash Flow Overview
    </h5>

</div>

<div class="row g-4 mb-4">

    {{-- Cash In --}}
    <div class="col-xl-4 col-md-6">

        <div class="card accounting-card cash-flow-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>
                        <p class="summary-label mb-1">TOTAL CASH IN</p>

                        <h3 class="fw-bold text-success mb-0">
                            PKR {{ number_format($cashIn, 2) }}
                        </h3>
                    </div>

                    <div class="summary-icon cash-in-icon">
                        <i class="bi bi-box-arrow-in-down-left"></i>
                    </div>

                </div>

                <div class="cash-flow-divider"></div>

                <div class="d-flex justify-content-between align-items-center gap-2">

                    <span class="text-muted">
                        <i class="bi bi-people me-2"></i>
                        Customer Payments
                    </span>

                    <strong class="text-nowrap">
                        PKR {{ number_format($customerPayments, 2) }}
                    </strong>

                </div>

            </div>

            <div class="cash-flow-bottom cash-in-bottom"></div>

        </div>

    </div>


    {{-- Cash Out --}}
    <div class="col-xl-4 col-md-6">

        <div class="card accounting-card cash-flow-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>
                        <p class="summary-label mb-1">TOTAL CASH OUT</p>

                        <h3 class="fw-bold text-danger mb-0">
                            PKR {{ number_format($cashOut, 2) }}
                        </h3>
                    </div>

                    <div class="summary-icon cash-out-icon">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </div>

                </div>

                <div class="cash-flow-divider"></div>

                <div class="d-flex justify-content-between align-items-center gap-2">

                    <span class="text-muted">
                        <i class="bi bi-truck me-2"></i>
                        Supplier Payments
                    </span>

                    <strong class="text-nowrap">
                        PKR {{ number_format($supplierPayments, 2) }}
                    </strong>

                </div>

            </div>

            <div class="cash-flow-bottom cash-out-bottom"></div>

        </div>

    </div>


    {{-- Cash Balance --}}
    <div class="col-xl-4 col-md-12">

        <div class="card accounting-card cash-flow-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>
                        <p class="summary-label mb-1">CASH BALANCE</p>

                        <h3 class="fw-bold mb-0 {{ $cashBalance >= 0 ? 'text-success' : 'text-danger' }}">
                            PKR {{ number_format($cashBalance, 2) }}
                        </h3>
                    </div>

                    <div class="summary-icon cash-balance-icon">
                        <i class="bi bi-safe2"></i>
                    </div>

                </div>

                <div class="cash-flow-divider"></div>

                <div class="d-flex justify-content-between align-items-center gap-2">

                    <span class="text-muted">
                        <i class="bi bi-calendar-check me-2"></i>
                        Selected Period
                    </span>

                    <span class="badge {{ $cashBalance >= 0 ? 'text-bg-success' : 'text-bg-danger' }}">
                        {{ $cashBalance >= 0 ? 'Positive' : 'Negative' }}
                    </span>

                </div>

            </div>

            <div class="cash-flow-bottom cash-balance-bottom"></div>

        </div>

    </div>

</div>


{{-- Inventory Overview --}}
<div class="d-flex align-items-center gap-2 mb-3">

    <i class="bi bi-boxes text-primary fs-5"></i>

    <h5 class="fw-bold mb-0">
        Inventory Overview
    </h5>

</div>

<div class="row g-4">

    {{-- Inventory Value --}}
    <div class="col-lg-6">

        <div class="card accounting-card inventory-card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3">

                    <div class="inventory-icon inventory-value-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div class="flex-grow-1">

                        <p class="summary-label mb-2">
                            TOTAL INVENTORY VALUE
                        </p>

                        <h3 class="fw-bold mb-1">
                            PKR {{ number_format($inventoryValue, 2) }}
                        </h3>

                        <p class="text-muted small mb-0">
                            <i class="bi bi-database me-1"></i>
                            Current inventory valuation
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Low Stock --}}
    <div class="col-lg-6">

        <div class="card accounting-card inventory-card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3">

                    <div class="inventory-icon {{ $lowStockProducts > 0 ? 'low-stock-warning-icon' : 'low-stock-success-icon' }}">
                        <i class="bi {{ $lowStockProducts > 0 ? 'bi-exclamation-triangle' : 'bi-check-circle' }}"></i>
                    </div>

                    <div class="flex-grow-1">

                        <p class="summary-label mb-2">
                            LOW STOCK PRODUCTS
                        </p>

                        <h3 class="fw-bold mb-1 {{ $lowStockProducts > 0 ? 'text-danger' : 'text-success' }}">
                            {{ $lowStockProducts }}
                        </h3>

                        <p class="text-muted small mb-0">
                            @if($lowStockProducts > 0)
                                <i class="bi bi-exclamation-circle me-1 text-danger"></i>
                                Products need stock attention
                            @else
                                <i class="bi bi-check-circle me-1 text-success"></i>
                                No low-stock products reported
                            @endif
                        </p>

                    </div>

                    <span class="badge {{ $lowStockProducts > 0 ? 'text-bg-danger' : 'text-bg-success' }}">
                        {{ $lowStockProducts > 0 ? 'Attention' : 'Normal' }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>


</div>

{{-- Accounting Dashboard Styles --}}

<style>
    .accounting-dashboard {
        --accounting-primary: #4f46e5;
        --accounting-border: #e8ecf3;
        --accounting-muted: #64748b;
        color: #1e293b;
    }

    .accounting-dashboard .accounting-header-icon {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 16px;
        background: #eef2ff;
        color: var(--accounting-primary);
        font-size: 28px;
    }

    .accounting-dashboard .accounting-period-badge {
        padding: 11px 16px;
        border: 1px solid #e0e7ff;
        border-radius: 12px;
        background: #f5f7ff;
        color: #4338ca;
        font-size: 13px;
        font-weight: 600;
    }

    .accounting-dashboard .accounting-card {
        background: #fff;
        border: 1px solid var(--accounting-border) !important;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.035);
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .accounting-dashboard .accounting-card:hover {
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.075);
    }

    .accounting-dashboard .filter-card {
        border-top: 3px solid var(--accounting-primary) !important;
    }

    .accounting-dashboard .form-label {
        color: #334155;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .accounting-dashboard .accounting-input {
        min-height: 45px;
        border: 1px solid #dce3ed;
        border-radius: 10px;
        padding: 10px 13px;
        color: #334155;
        font-size: 14px;
    }

    .accounting-dashboard .accounting-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .accounting-dashboard .accounting-filter-btn {
        min-height: 45px;
        border-radius: 10px;
        background: var(--accounting-primary);
        border-color: var(--accounting-primary);
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .accounting-dashboard .accounting-filter-btn:hover {
        background: #4338ca;
        border-color: #4338ca;
    }

    .accounting-dashboard .summary-card {
        position: relative;
        min-height: 160px;
    }

    .accounting-dashboard .summary-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }

    .accounting-dashboard .sales-card::before {
        background: #3b82f6;
    }

    .accounting-dashboard .cogs-card::before {
        background: #ef4444;
    }

    .accounting-dashboard .gross-card::before {
        background: #10b981;
    }

    .accounting-dashboard .net-card::before {
        background: #8b5cf6;
    }

    .accounting-dashboard .summary-label {
        color: var(--accounting-muted);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.8px;
        margin-bottom: 10px;
    }

    .accounting-dashboard .summary-value {
        font-size: clamp(18px, 1.6vw, 24px);
        font-weight: 750;
        letter-spacing: -0.6px;
        margin-bottom: 12px;
        overflow-wrap: anywhere;
    }

    .accounting-dashboard .summary-description {
        color: #64748b;
        font-size: 12px;
    }

    .accounting-dashboard .summary-icon {
        width: 48px;
        height: 48px;
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 22px;
    }

    .accounting-dashboard .sales-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .accounting-dashboard .cogs-icon {
        background: #fef2f2;
        color: #dc2626;
    }

    .accounting-dashboard .gross-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .accounting-dashboard .net-icon {
        background: #f5f3ff;
        color: #7c3aed;
    }

    .accounting-dashboard .accounting-section-header {
        padding: 20px 24px;
        background: #fff;
        border-bottom: 1px solid var(--accounting-border);
    }

    .accounting-dashboard .section-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 13px;
        font-size: 21px;
    }

    .accounting-dashboard .profit-section-icon {
        color: #4f46e5;
        background: #eef2ff;
    }

    .accounting-dashboard .accounting-status-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 9px;
        background: #ecfdf5;
        color: #047857;
        font-size: 11px;
        font-weight: 700;
    }

    .accounting-dashboard .accounting-table thead th {
        padding-top: 15px;
        padding-bottom: 15px;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.7px;
        border-bottom: 1px solid var(--accounting-border);
        white-space: nowrap;
    }

    .accounting-dashboard .accounting-table tbody td {
        padding-top: 15px;
        padding-bottom: 15px;
        border-color: #eef2f7;
        font-size: 13px;
    }

    .accounting-dashboard .accounting-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .accounting-dashboard .accounting-table tbody tr:hover {
        background: #fafbff;
    }

    .accounting-dashboard .table-row-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 11px;
        font-size: 17px;
    }

    .accounting-dashboard .revenue-row-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .accounting-dashboard .expense-row-icon {
        background: #fff1f2;
        color: #e11d48;
    }

    .accounting-dashboard .income-row-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .accounting-dashboard .net-profit-row-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .accounting-dashboard .profit-total-row {
        background: #f0fdf4;
    }

    .accounting-dashboard .net-profit-row {
        background: #f8fafc;
        border-top: 2px solid #e2e8f0;
    }

    .accounting-dashboard .cash-flow-card {
        position: relative;
        min-height: 190px;
    }

    .accounting-dashboard .cash-flow-divider {
        height: 1px;
        background: #edf0f5;
        margin: 20px 0;
    }

    .accounting-dashboard .cash-in-icon {
        color: #059669;
        background: #ecfdf5;
    }

    .accounting-dashboard .cash-out-icon {
        color: #dc2626;
        background: #fef2f2;
    }

    .accounting-dashboard .cash-balance-icon {
        color: #4f46e5;
        background: #eef2ff;
    }

    .accounting-dashboard .cash-flow-bottom {
        height: 4px;
        width: 100%;
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .accounting-dashboard .cash-in-bottom {
        background: #10b981;
    }

    .accounting-dashboard .cash-out-bottom {
        background: #ef4444;
    }

    .accounting-dashboard .cash-balance-bottom {
        background: #6366f1;
    }

    .accounting-dashboard .inventory-card {
        border-left: 4px solid #6366f1 !important;
    }

    .accounting-dashboard .inventory-icon {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 16px;
        font-size: 26px;
    }

    .accounting-dashboard .inventory-value-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .accounting-dashboard .low-stock-warning-icon {
        background: #fff1f2;
        color: #e11d48;
    }

    .accounting-dashboard .low-stock-success-icon {
        background: #ecfdf5;
        color: #059669;
    }

    @media (max-width: 767.98px) {
        .accounting-dashboard {
            padding-top: 16px !important;
        }

        .accounting-dashboard .accounting-header-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            font-size: 23px;
        }

        .accounting-dashboard h2 {
            font-size: 23px;
        }

        .accounting-dashboard .accounting-period-badge {
            width: 100%;
            text-align: center;
        }

        .accounting-dashboard .summary-card {
            min-height: auto;
        }

        .accounting-dashboard .summary-value {
            font-size: 20px;
        }

        .accounting-dashboard .accounting-section-header {
            padding: 16px;
        }

        .accounting-dashboard .accounting-table tbody td {
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .accounting-dashboard .accounting-table .ps-4 {
            padding-left: 12px !important;
        }

        .accounting-dashboard .accounting-table .pe-4 {
            padding-right: 12px !important;
        }

        .accounting-dashboard .table-row-icon {
            width: 32px;
            height: 32px;
            font-size: 15px;
        }

        .accounting-dashboard .inventory-card .card-body {
            padding: 18px !important;
        }
    }
</style>

@endsection
