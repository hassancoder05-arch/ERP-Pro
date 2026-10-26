
@extends('layouts.app')

@section('title', 'Finance Dashboard')

@section('content')

<div class="container-fluid py-4">

    {{-- =========================================================
         PAGE HEADER
    ========================================================== --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-cash-stack me-2"></i>
                Finance Dashboard
            </h2>

            <p class="text-muted mb-0">
                Manage income, expenses, payments and financial performance
            </p>
        </div>

        {{-- QUICK ACTIONS --}}
        <div class="d-flex flex-wrap gap-2 mt-3 mt-md-0">

            {{-- Add Income --}}
            <a href="{{ route('incomes.create') }}"
               class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i>
                Add Income
            </a>

            {{-- Add Expense --}}
            <a href="{{ route('expenses.create') }}"
               class="btn btn-danger">
                <i class="bi bi-dash-circle me-1"></i>
                Add Expense
            </a>

            {{-- Add Payment --}}
            <a href="{{ route('payments.create') }}"
               class="btn btn-primary">
                <i class="bi bi-credit-card me-1"></i>
                Add Payment
            </a>

        </div>

    </div>


    {{-- =========================================================
         MANAGEMENT BUTTONS
    ========================================================== --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex flex-wrap gap-2">

                {{-- Income List --}}
                <a href="{{ route('incomes.index') }}"
                   class="btn btn-outline-success">

                    <i class="bi bi-graph-up-arrow me-1"></i>
                    View Income
                </a>


                {{-- Expense List --}}
                <a href="{{ route('expenses.index') }}"
                   class="btn btn-outline-danger">

                    <i class="bi bi-receipt me-1"></i>
                    View Expenses
                </a>


                {{-- Payment List --}}
                <a href="{{ route('payments.index') }}"
                   class="btn btn-outline-primary">

                    <i class="bi bi-wallet2 me-1"></i>
                    View Payments
                </a>


                {{-- Expense Categories --}}
                <a href="{{ route('expense-categories.index') }}"
                   class="btn btn-outline-secondary">

                    <i class="bi bi-tags me-1"></i>
                    Expense Categories
                </a>

            </div>

        </div>

    </div>


    {{-- =========================================================
         DATE FILTER
    ========================================================== --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('finance.index') }}">

                <div class="row g-3 align-items-end">

                    {{-- Start Date --}}
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


                    {{-- End Date --}}
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


                    {{-- Filter --}}
                    <div class="col-md-2">

                        <button type="submit"
                                class="btn btn-primary w-100">

                            <i class="bi bi-filter me-1"></i>
                            Filter

                        </button>

                    </div>


                    {{-- Reset --}}
                    <div class="col-md-2">

                        <a href="{{ route('finance.index') }}"
                           class="btn btn-outline-secondary w-100">

                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
         FINANCIAL CARDS
    ========================================================== --}}
    <div class="row g-4 mb-4">


        {{-- TOTAL SALES --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Total Sales
                            </p>

                            <h3 class="fw-bold mb-0">
                                Rs.
                                {{ number_format($totalSales, 2) }}
                            </h3>

                        </div>

                        <div class="fs-2 text-primary">

                            <i class="bi bi-cart-check"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- TOTAL INCOME --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Other Income
                            </p>

                            <h3 class="fw-bold mb-0">
                                Rs.
                                {{ number_format($totalIncome, 2) }}
                            </h3>

                        </div>

                        <div class="fs-2 text-success">

                            <i class="bi bi-graph-up-arrow"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- TOTAL EXPENSE --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Total Expenses
                            </p>

                            <h3 class="fw-bold mb-0">
                                Rs.
                                {{ number_format($totalExpenses, 2) }}
                            </h3>

                        </div>

                        <div class="fs-2 text-danger">

                            <i class="bi bi-arrow-down-circle"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- NET PROFIT --}}
        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Net Profit
                            </p>

                            <h3 class="fw-bold mb-0
                                {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">

                                Rs.
                                {{ number_format($netProfit, 2) }}

                            </h3>

                        </div>

                        <div class="fs-2
                            {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">

                            <i class="bi bi-bar-chart-line"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         MONEY IN / MONEY OUT
    ========================================================== --}}
    <div class="row g-4 mb-4">


        {{-- MONEY IN --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <h5 class="fw-bold mb-0">

                        <i class="bi bi-wallet2 me-2 text-success"></i>
                        Money In

                    </h5>

                </div>


                <div class="card-body px-4">


                    {{-- Sales --}}
                    <div class="d-flex justify-content-between py-3 border-bottom">

                        <span>
                            Total Sales
                        </span>

                        <strong>
                            Rs.
                            {{ number_format($totalSales, 2) }}
                        </strong>

                    </div>


                    {{-- Other Income --}}
                    <div class="d-flex justify-content-between py-3 border-bottom">

                        <span>
                            Other Income
                        </span>

                        <strong>
                            Rs.
                            {{ number_format($totalIncome, 2) }}
                        </strong>

                    </div>


                    {{-- Customer Payments --}}
                    <div class="d-flex justify-content-between py-3 border-bottom">

                        <span>
                            Customer Payments
                        </span>

                        <strong>
                            Rs.
                            {{ number_format($customerPayments, 2) }}
                        </strong>

                    </div>


                    {{-- Cash In --}}
                    <div class="d-flex justify-content-between py-3">

                        <span class="fw-bold">
                            Total Cash In
                        </span>

                        <strong class="text-success">

                            Rs.
                            {{ number_format($cashIn, 2) }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- MONEY OUT --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <h5 class="fw-bold mb-0">

                        <i class="bi bi-cash me-2 text-danger"></i>
                        Money Out

                    </h5>

                </div>


                <div class="card-body px-4">


                    {{-- Expenses --}}
                    <div class="d-flex justify-content-between py-3 border-bottom">

                        <span>
                            Total Expenses
                        </span>

                        <strong>
                            Rs.
                            {{ number_format($totalExpenses, 2) }}
                        </strong>

                    </div>


                    {{-- Supplier Payments --}}
                    <div class="d-flex justify-content-between py-3 border-bottom">

                        <span>
                            Supplier Payments
                        </span>

                        <strong>
                            Rs.
                            {{ number_format($supplierPayments, 2) }}
                        </strong>

                    </div>


                    {{-- Revenue --}}
                    <div class="d-flex justify-content-between py-3 border-bottom">

                        <span>
                            Total Revenue
                        </span>

                        <strong>
                            Rs.
                            {{ number_format($totalRevenue, 2) }}
                        </strong>

                    </div>


                    {{-- Cash Balance --}}
                    <div class="d-flex justify-content-between py-3">

                        <span class="fw-bold">
                            Cash Balance
                        </span>

                        <strong
                            class="{{ $cashBalance >= 0 ? 'text-success' : 'text-danger' }}">

                            Rs.
                            {{ number_format($cashBalance, 2) }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         QUICK CREATE SECTION
    ========================================================== --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <h5 class="fw-bold mb-1">
                <i class="bi bi-lightning-charge-fill me-2"></i>
                Quick Finance Actions
            </h5>

            <p class="text-muted mb-0">
                Create new financial records quickly
            </p>

        </div>


        <div class="card-body">

            <div class="row g-3">


                {{-- ADD INCOME --}}
                <div class="col-md-4">

                    <a href="{{ route('incomes.create') }}"
                       class="text-decoration-none">

                        <div class="p-4 rounded-3 border
                                    bg-light
                                    h-100
                                    text-center">

                            <div class="fs-1 text-success mb-2">

                                <i class="bi bi-plus-circle-fill"></i>

                            </div>

                            <h5 class="fw-bold text-dark">
                                Add Income
                            </h5>

                            <p class="text-muted mb-0">
                                Record business income
                            </p>

                        </div>

                    </a>

                </div>


                {{-- ADD EXPENSE --}}
                <div class="col-md-4">

                    <a href="{{ route('expenses.create') }}"
                       class="text-decoration-none">

                        <div class="p-4 rounded-3 border
                                    bg-light
                                    h-100
                                    text-center">

                            <div class="fs-1 text-danger mb-2">

                                <i class="bi bi-dash-circle-fill"></i>

                            </div>

                            <h5 class="fw-bold text-dark">
                                Add Expense
                            </h5>

                            <p class="text-muted mb-0">
                                Record business expense
                            </p>

                        </div>

                    </a>

                </div>


                {{-- ADD PAYMENT --}}
                <div class="col-md-4">

                    <a href="{{ route('payments.create') }}"
                       class="text-decoration-none">

                        <div class="p-4 rounded-3 border
                                    bg-light
                                    h-100
                                    text-center">

                            <div class="fs-1 text-primary mb-2">

                                <i class="bi bi-credit-card-fill"></i>

                            </div>

                            <h5 class="fw-bold text-dark">
                                Add Payment
                            </h5>

                            <p class="text-muted mb-0">
                                Record customer or supplier payment
                            </p>

                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         SELECTED PERIOD
    ========================================================== --}}
    <div class="alert alert-light border">

        <i class="bi bi-calendar3 me-2"></i>

        Showing financial data from

        <strong>
            {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
        </strong>

        to

        <strong>
            {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        </strong>

    </div>


</div>


{{-- =========================================================
     CUSTOM FINANCE CSS
========================================================== --}}
<style>

    .card {
        border-radius: 16px;
    }

    .btn {
        border-radius: 10px;
        font-weight: 600;
    }

    .form-control {
        border-radius: 10px;
        min-height: 44px;
    }

    .card-header {
        border-radius: 16px 16px 0 0 !important;
    }

    .quick-action-card {
        transition: all 0.2s ease;
    }

    .quick-action-card:hover {
        transform: translateY(-3px);
    }

</style>

@endsection

@extends('layouts.app')

@section('title', 'Finance Dashboard')

@section('content')

<div class="container-fluid py-4 finance-page">


{{-- Page Header --}}
<div class="finance-header mb-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

        <div class="d-flex align-items-center gap-3">

            <div class="finance-header-icon">
                <i class="bi bi-cash-stack"></i>
            </div>

            <div>
                <h2 class="finance-page-title mb-1">Finance Dashboard</h2>

                <p class="text-muted mb-0">
                    Monitor income, expenses, payments and financial performance.
                </p>
            </div>

        </div>


        {{-- Quick Actions --}}
        <div class="d-flex flex-wrap gap-2 finance-header-actions">

            <a href="{{ route('incomes.create') }}"
               class="btn finance-btn-income">

                <i class="bi bi-plus-circle me-2"></i>
                Add Income

            </a>

            <a href="{{ route('expenses.create') }}"
               class="btn finance-btn-expense">

                <i class="bi bi-dash-circle me-2"></i>
                Add Expense

            </a>

            <a href="{{ route('payments.create') }}"
               class="btn finance-btn-payment">

                <i class="bi bi-credit-card me-2"></i>
                Add Payment

            </a>

        </div>

    </div>

</div>


{{-- Management Shortcuts --}}
<div class="finance-management-card mb-4">

    <div class="finance-management-heading">

        <div class="d-flex align-items-center gap-2">

            <div class="finance-small-icon">
                <i class="bi bi-grid"></i>
            </div>

            <div>
                <h6 class="fw-bold mb-1">Financial Management</h6>

                <p class="text-muted small mb-0">
                    Access your financial records and categories.
                </p>
            </div>

        </div>

    </div>


    <div class="finance-management-links">

        <a href="{{ route('incomes.index') }}"
           class="finance-management-link link-income">

            <i class="bi bi-graph-up-arrow"></i>
            <span>View Income</span>
            <i class="bi bi-arrow-up-right ms-auto"></i>

        </a>


        <a href="{{ route('expenses.index') }}"
           class="finance-management-link link-expense">

            <i class="bi bi-receipt"></i>
            <span>View Expenses</span>
            <i class="bi bi-arrow-up-right ms-auto"></i>

        </a>


        <a href="{{ route('payments.index') }}"
           class="finance-management-link link-payment">

            <i class="bi bi-wallet2"></i>
            <span>View Payments</span>
            <i class="bi bi-arrow-up-right ms-auto"></i>

        </a>


        <a href="{{ route('expense-categories.index') }}"
           class="finance-management-link link-category">

            <i class="bi bi-tags"></i>
            <span>Expense Categories</span>
            <i class="bi bi-arrow-up-right ms-auto"></i>

        </a>

    </div>

</div>


{{-- Date Filter --}}
<div class="finance-filter-card mb-4">

    <div class="finance-filter-heading">

        <div class="d-flex align-items-center gap-3">

            <div class="finance-filter-icon">
                <i class="bi bi-calendar3"></i>
            </div>

            <div>
                <h5 class="fw-bold mb-1">Financial Period</h5>

                <p class="text-muted small mb-0">
                    Select the date range for your financial report.
                </p>
            </div>

        </div>

    </div>


    <div class="finance-filter-body">

        <form method="GET" action="{{ route('finance.index') }}">

            <div class="row g-3 align-items-end">

                <div class="col-12 col-md-4">

                    <label for="start_date" class="finance-label">
                        Start Date
                    </label>

                    <div class="finance-date-wrapper">

                        <i class="bi bi-calendar-event"></i>

                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            class="form-control finance-input"
                            value="{{ $startDate }}"
                        >

                    </div>

                </div>


                <div class="col-12 col-md-4">

                    <label for="end_date" class="finance-label">
                        End Date
                    </label>

                    <div class="finance-date-wrapper">

                        <i class="bi bi-calendar-check"></i>

                        <input
                            type="date"
                            id="end_date"
                            name="end_date"
                            class="form-control finance-input"
                            value="{{ $endDate }}"
                        >

                    </div>

                </div>


                <div class="col-6 col-md-2">

                    <button type="submit"
                            class="btn finance-filter-btn w-100">

                        <i class="bi bi-funnel me-2"></i>
                        Filter

                    </button>

                </div>


                <div class="col-6 col-md-2">

                    <a href="{{ route('finance.index') }}"
                       class="btn finance-reset-btn w-100">

                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- Financial Overview --}}
<div class="finance-section-heading mb-3">

    <div>
        <h5 class="fw-bold mb-1">Financial Overview</h5>

        <p class="text-muted small mb-0">
            Summary of your financial performance for the selected period.
        </p>
    </div>

    <span class="finance-period-badge">
        <i class="bi bi-calendar3 me-1"></i>
        Selected Period
    </span>

</div>


{{-- Financial Summary Cards --}}
<div class="row g-3 mb-4">


    {{-- Total Sales --}}
    <div class="col-12 col-sm-6 col-xl-3">

        <div class="finance-stat-card stat-sales">

            <div class="finance-stat-top">

                <div>
                    <span class="finance-stat-label">Total Sales</span>

                    <div class="finance-stat-subtitle">
                        Sales revenue
                    </div>
                </div>

                <div class="finance-stat-icon">
                    <i class="bi bi-cart-check"></i>
                </div>

            </div>

            <h3 class="finance-stat-value">
                <span class="finance-currency">Rs.</span>
                {{ number_format((float) $totalSales, 2) }}
            </h3>

            <div class="finance-stat-footer">
                <i class="bi bi-receipt me-1"></i>
                Sales transactions
            </div>

        </div>

    </div>


    {{-- Other Income --}}
    <div class="col-12 col-sm-6 col-xl-3">

        <div class="finance-stat-card stat-income">

            <div class="finance-stat-top">

                <div>
                    <span class="finance-stat-label">Other Income</span>

                    <div class="finance-stat-subtitle">
                        Additional income
                    </div>
                </div>

                <div class="finance-stat-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>

            </div>

            <h3 class="finance-stat-value">
                <span class="finance-currency">Rs.</span>
                {{ number_format((float) $totalIncome, 2) }}
            </h3>

            <div class="finance-stat-footer">
                <i class="bi bi-plus-circle me-1"></i>
                Recorded income
            </div>

        </div>

    </div>


    {{-- Total Expenses --}}
    <div class="col-12 col-sm-6 col-xl-3">

        <div class="finance-stat-card stat-expense">

            <div class="finance-stat-top">

                <div>
                    <span class="finance-stat-label">Total Expenses</span>

                    <div class="finance-stat-subtitle">
                        Business expenses
                    </div>
                </div>

                <div class="finance-stat-icon">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>

            </div>

            <h3 class="finance-stat-value">
                <span class="finance-currency">Rs.</span>
                {{ number_format((float) $totalExpenses, 2) }}
            </h3>

            <div class="finance-stat-footer">
                <i class="bi bi-receipt me-1"></i>
                Recorded expenses
            </div>

        </div>

    </div>


    {{-- Net Profit --}}
    <div class="col-12 col-sm-6 col-xl-3">

        <div class="finance-stat-card {{ $netProfit >= 0 ? 'stat-profit' : 'stat-loss' }}">

            <div class="finance-stat-top">

                <div>
                    <span class="finance-stat-label">Net Profit</span>

                    <div class="finance-stat-subtitle">
                        {{ $netProfit >= 0 ? 'Positive balance' : 'Negative balance' }}
                    </div>
                </div>

                <div class="finance-stat-icon">
                    <i class="bi bi-bar-chart-line"></i>
                </div>

            </div>

            <h3 class="finance-stat-value">
                <span class="finance-currency">Rs.</span>
                {{ number_format((float) $netProfit, 2) }}
            </h3>

            <div class="finance-stat-footer">
                <i class="bi {{ $netProfit >= 0 ? 'bi-check-circle' : 'bi-exclamation-circle' }} me-1"></i>
                {{ $netProfit >= 0 ? 'Net positive result' : 'Net negative result' }}
            </div>

        </div>

    </div>

</div>


{{-- Money In / Money Out --}}
<div class="finance-section-heading mb-3">

    <div>
        <h5 class="fw-bold mb-1">Cash Flow Overview</h5>

        <p class="text-muted small mb-0">
            Review incoming funds, outgoing funds and balances.
        </p>
    </div>

</div>


<div class="row g-4 mb-4">


    {{-- Money In --}}
    <div class="col-12 col-xl-6">

        <div class="finance-flow-card h-100">

            <div class="finance-flow-header flow-in-header">

                <div class="d-flex align-items-center gap-3">

                    <div class="finance-flow-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">Money In</h5>

                        <p class="small mb-0">
                            Incoming financial activity
                        </p>
                    </div>

                </div>

                <span class="finance-flow-tag">
                    INFLOW
                </span>

            </div>


            <div class="finance-flow-body">

                {{-- Sales --}}
                <div class="finance-flow-row">

                    <div class="finance-flow-label">
                        <span class="flow-dot dot-blue"></span>
                        <span>Total Sales</span>
                    </div>

                    <strong>
                        Rs. {{ number_format((float) $totalSales, 2) }}
                    </strong>

                </div>


                {{-- Other Income --}}
                <div class="finance-flow-row">

                    <div class="finance-flow-label">
                        <span class="flow-dot dot-green"></span>
                        <span>Other Income</span>
                    </div>

                    <strong>
                        Rs. {{ number_format((float) $totalIncome, 2) }}
                    </strong>

                </div>


                {{-- Customer Payments --}}
                <div class="finance-flow-row">

                    <div class="finance-flow-label">
                        <span class="flow-dot dot-purple"></span>
                        <span>Customer Payments</span>
                    </div>

                    <strong>
                        Rs. {{ number_format((float) $customerPayments, 2) }}
                    </strong>

                </div>


                {{-- Cash In Total --}}
                <div class="finance-flow-total flow-in-total">

                    <div>
                        <span class="finance-total-label">Total Cash In</span>

                        <div class="finance-total-caption">
                            Total incoming amount
                        </div>
                    </div>

                    <strong>
                        Rs. {{ number_format((float) $cashIn, 2) }}
                    </strong>

                </div>

            </div>

        </div>

    </div>


    {{-- Money Out --}}
    <div class="col-12 col-xl-6">

        <div class="finance-flow-card h-100">

            <div class="finance-flow-header flow-out-header">

                <div class="d-flex align-items-center gap-3">

                    <div class="finance-flow-icon">
                        <i class="bi bi-cash-coin"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">Money Out</h5>

                        <p class="small mb-0">
                            Outgoing financial activity
                        </p>
                    </div>

                </div>

                <span class="finance-flow-tag">
                    OUTFLOW
                </span>

            </div>


            <div class="finance-flow-body">

                {{-- Expenses --}}
                <div class="finance-flow-row">

                    <div class="finance-flow-label">
                        <span class="flow-dot dot-red"></span>
                        <span>Total Expenses</span>
                    </div>

                    <strong>
                        Rs. {{ number_format((float) $totalExpenses, 2) }}
                    </strong>

                </div>


                {{-- Supplier Payments --}}
                <div class="finance-flow-row">

                    <div class="finance-flow-label">
                        <span class="flow-dot dot-orange"></span>
                        <span>Supplier Payments</span>
                    </div>

                    <strong>
                        Rs. {{ number_format((float) $supplierPayments, 2) }}
                    </strong>

                </div>


                {{-- Total Revenue --}}
                <div class="finance-flow-row">

                    <div class="finance-flow-label">
                        <span class="flow-dot dot-gray"></span>
                        <span>Total Revenue</span>
                    </div>

                    <strong>
                        Rs. {{ number_format((float) $totalRevenue, 2) }}
                    </strong>

                </div>


                {{-- Cash Balance --}}
                <div class="finance-flow-total {{ $cashBalance >= 0 ? 'flow-in-total' : 'flow-out-total' }}">

                    <div>
                        <span class="finance-total-label">Cash Balance</span>

                        <div class="finance-total-caption">
                            Current calculated balance
                        </div>
                    </div>

                    <strong>
                        Rs. {{ number_format((float) $cashBalance, 2) }}
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- Quick Finance Actions --}}
<div class="finance-quick-card mb-4">

    <div class="finance-quick-header">

        <div class="d-flex align-items-center gap-3">

            <div class="finance-quick-heading-icon">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>

            <div>
                <h5 class="fw-bold mb-1">Quick Finance Actions</h5>

                <p class="text-muted small mb-0">
                    Create financial records without navigating through menus.
                </p>
            </div>

        </div>

    </div>


    <div class="finance-quick-body">

        <div class="row g-3">


            {{-- Add Income --}}
            <div class="col-12 col-md-4">

                <a href="{{ route('incomes.create') }}"
                   class="finance-quick-action quick-income">

                    <div class="finance-quick-action-icon">
                        <i class="bi bi-plus-circle-fill"></i>
                    </div>

                    <div class="finance-quick-action-content">

                        <h6>Add Income</h6>

                        <p>
                            Record other business income.
                        </p>

                    </div>

                    <i class="bi bi-arrow-right finance-quick-arrow"></i>

                </a>

            </div>


            {{-- Add Expense --}}
            <div class="col-12 col-md-4">

                <a href="{{ route('expenses.create') }}"
                   class="finance-quick-action quick-expense">

                    <div class="finance-quick-action-icon">
                        <i class="bi bi-dash-circle-fill"></i>
                    </div>

                    <div class="finance-quick-action-content">

                        <h6>Add Expense</h6>

                        <p>
                            Record a business expense.
                        </p>

                    </div>

                    <i class="bi bi-arrow-right finance-quick-arrow"></i>

                </a>

            </div>


            {{-- Add Payment --}}
            <div class="col-12 col-md-4">

                <a href="{{ route('payments.create') }}"
                   class="finance-quick-action quick-payment">

                    <div class="finance-quick-action-icon">
                        <i class="bi bi-credit-card-fill"></i>
                    </div>

                    <div class="finance-quick-action-content">

                        <h6>Add Payment</h6>

                        <p>
                            Record customer or supplier payments.
                        </p>

                    </div>

                    <i class="bi bi-arrow-right finance-quick-arrow"></i>

                </a>

            </div>

        </div>

    </div>

</div>


{{-- Selected Period --}}
<div class="finance-selected-period">

    <div class="finance-selected-period-icon">
        <i class="bi bi-calendar-range"></i>
    </div>

    <div>
        <div class="fw-bold mb-1">Selected Reporting Period</div>

        <div class="text-muted small">

            Financial data from

            <strong>
                {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
            </strong>

            to

            <strong>
                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
            </strong>

        </div>
    </div>

</div>


</div>

{{-- Finance Dashboard CSS --}}

<style>

    .finance-page {
        --finance-primary: #4f46e5;
        --finance-primary-dark: #4338ca;
        --finance-text: #172033;
        --finance-muted: #718096;
        --finance-border: #e8edf4;

        color: var(--finance-text);
    }


    /* Header */

    .finance-page .finance-header {
        padding: 8px 0 12px;
    }

    .finance-page .finance-header-icon {
        width: 58px;
        height: 58px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        background: linear-gradient(135deg, #4f46e5, #818cf8);
        color: #fff;
        font-size: 25px;
        box-shadow: 0 8px 20px rgba(79, 70, 229, .2);
    }

    .finance-page .finance-page-title {
        color: var(--finance-text);
        font-size: clamp(1.45rem, 2vw, 1.9rem);
        font-weight: 800;
        letter-spacing: -.6px;
    }

    .finance-page .finance-header-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        transition: all .2s ease;
    }

    .finance-page .finance-header-actions .btn:hover {
        transform: translateY(-2px);
    }

    .finance-page .finance-btn-income {
        background: #15803d;
        border-color: #15803d;
        color: #fff;
    }

    .finance-page .finance-btn-income:hover {
        background: #166534;
        color: #fff;
    }

    .finance-page .finance-btn-expense {
        background: #dc2626;
        border-color: #dc2626;
        color: #fff;
    }

    .finance-page .finance-btn-expense:hover {
        background: #b91c1c;
        color: #fff;
    }

    .finance-page .finance-btn-payment {
        background: var(--finance-primary);
        border-color: var(--finance-primary);
        color: #fff;
    }

    .finance-page .finance-btn-payment:hover {
        background: var(--finance-primary-dark);
        color: #fff;
    }


    /* Management Shortcuts */

    .finance-page .finance-management-card,
    .finance-page .finance-filter-card,
    .finance-page .finance-quick-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--finance-border);
        border-radius: 15px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, .035);
    }

    .finance-page .finance-management-heading {
        padding: 18px 22px;
        border-bottom: 1px solid var(--finance-border);
    }

    .finance-page .finance-small-icon {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        color: var(--finance-primary);
        border-radius: 11px;
        font-size: 18px;
    }

    .finance-page .finance-management-links {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        padding: 18px 22px;
    }

    .finance-page .finance-management-link {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
        padding: 13px;
        border: 1px solid var(--finance-border);
        border-radius: 10px;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all .2s ease;
    }

    .finance-page .finance-management-link > i:first-child {
        font-size: 17px;
    }

    .finance-page .finance-management-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 14px rgba(15, 23, 42, .06);
    }

    .finance-page .link-income > i:first-child {
        color: #16a34a;
    }

    .finance-page .link-income:hover {
        background: #f0fdf4;
        border-color: #bbf7d0;
    }

    .finance-page .link-expense > i:first-child {
        color: #dc2626;
    }

    .finance-page .link-expense:hover {
        background: #fef2f2;
        border-color: #fecaca;
    }

    .finance-page .link-payment > i:first-child {
        color: #4f46e5;
    }

    .finance-page .link-payment:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
    }

    .finance-page .link-category > i:first-child {
        color: #64748b;
    }

    .finance-page .link-category:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .finance-page .finance-management-link > i:last-child {
        color: #94a3b8;
        font-size: 13px;
    }


    /* Date Filter */

    .finance-page .finance-filter-heading {
        padding: 19px 22px;
        border-bottom: 1px solid var(--finance-border);
    }

    .finance-page .finance-filter-icon {
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        color: var(--finance-primary);
        border-radius: 12px;
        font-size: 19px;
    }

    .finance-page .finance-filter-body {
        padding: 22px;
        background: #fbfcfe;
    }

    .finance-page .finance-label {
        display: block;
        margin-bottom: 8px;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
    }

    .finance-page .finance-date-wrapper {
        position: relative;
    }

    .finance-page .finance-date-wrapper > i {
        position: absolute;
        top: 50%;
        left: 13px;
        z-index: 2;
        color: #94a3b8;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .finance-page .finance-input {
        min-height: 44px;
        padding-left: 38px;
        border: 1px solid #dfe5ee;
        border-radius: 9px;
        background: #fff;
        color: #334155;
        font-size: 13px;
        box-shadow: none;
    }

    .finance-page .finance-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, .1);
    }

    .finance-page .finance-filter-btn,
    .finance-page .finance-reset-btn {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all .2s ease;
    }

    .finance-page .finance-filter-btn {
        background: var(--finance-primary);
        border: 1px solid var(--finance-primary);
        color: #fff;
    }

    .finance-page .finance-filter-btn:hover {
        background: var(--finance-primary-dark);
        color: #fff;
    }

    .finance-page .finance-reset-btn {
        background: #fff;
        border: 1px solid #dbe2ea;
        color: #475569;
    }

    .finance-page .finance-reset-btn:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #0f172a;
    }


    /* Section Headings */

    .finance-page .finance-section-heading {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .finance-page .finance-section-heading h5 {
        color: var(--finance-text);
    }

    .finance-page .finance-period-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border: 1px solid #e0e7ff;
        border-radius: 8px;
        background: #eef2ff;
        color: #4338ca;
        font-size: 11px;
        font-weight: 700;
    }


    /* Financial Summary Cards */

    .finance-page .finance-stat-card {
        position: relative;
        height: 100%;
        min-height: 174px;
        overflow: hidden;
        padding: 20px;
        background: #fff;
        border: 1px solid var(--finance-border);
        border-radius: 15px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .035);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .finance-page .finance-stat-card::after {
        position: absolute;
        right: -28px;
        bottom: -38px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: currentColor;
        opacity: .035;
        content: "";
        pointer-events: none;
    }

    .finance-page .finance-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .07);
    }

    .finance-page .finance-stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
    }

    .finance-page .finance-stat-label {
        display: block;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .finance-page .finance-stat-subtitle {
        margin-top: 5px;
        color: #94a3b8;
        font-size: 11px;
    }

    .finance-page .finance-stat-icon {
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 20px;
    }

    .finance-page .finance-stat-value {
        position: relative;
        z-index: 1;
        margin: 18px 0 12px;
        color: var(--finance-text);
        font-size: clamp(20px, 1.7vw, 28px);
        font-weight: 800;
        line-height: 1.3;
        overflow-wrap: anywhere;
    }

    .finance-page .finance-currency {
        font-size: 13px;
        font-weight: 700;
    }

    .finance-page .finance-stat-footer {
        position: relative;
        z-index: 1;
        padding-top: 11px;
        border-top: 1px solid #f1f5f9;
        color: #94a3b8;
        font-size: 10px;
    }

    .finance-page .stat-sales {
        color: #4f46e5;
    }

    .finance-page .stat-sales .finance-stat-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .finance-page .stat-income {
        color: #16a34a;
    }

    .finance-page .stat-income .finance-stat-icon {
        background: #dcfce7;
        color: #15803d;
    }

    .finance-page .stat-expense {
        color: #dc2626;
    }

    .finance-page .stat-expense .finance-stat-icon {
        background: #fee2e2;
        color: #dc2626;
    }

    .finance-page .stat-profit {
        color: #059669;
    }

    .finance-page .stat-profit .finance-stat-icon {
        background: #d1fae5;
        color: #047857;
    }

    .finance-page .stat-loss {
        color: #dc2626;
    }

    .finance-page .stat-loss .finance-stat-icon {
        background: #fee2e2;
        color: #dc2626;
    }


    /* Money In / Money Out */

    .finance-page .finance-flow-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--finance-border);
        border-radius: 15px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, .035);
    }

    .finance-page .finance-flow-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 20px 22px;
        border-bottom: 1px solid var(--finance-border);
    }

    .finance-page .flow-in-header {
        background: linear-gradient(120deg, #f0fdf4, #fff);
    }

    .finance-page .flow-out-header {
        background: linear-gradient(120deg, #fff1f2, #fff);
    }

    .finance-page .finance-flow-icon {
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #fff;
        color: #15803d;
        font-size: 21px;
        box-shadow: 0 2px 7px rgba(15, 23, 42, .04);
    }

    .finance-page .flow-out-header .finance-flow-icon {
        color: #dc2626;
    }

    .finance-page .finance-flow-header h5 {
        color: var(--finance-text);
    }

    .finance-page .finance-flow-header p {
        color: #64748b;
    }

    .finance-page .finance-flow-tag {
        padding: 6px 9px;
        border-radius: 6px;
        background: #dcfce7;
        color: #15803d;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .5px;
    }

    .finance-page .flow-out-header .finance-flow-tag {
        background: #fee2e2;
        color: #b91c1c;
    }

    .finance-page .finance-flow-body {
        padding: 8px 22px 20px;
    }

    .finance-page .finance-flow-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 17px 0;
        border-bottom: 1px solid #eef2f7;
        font-size: 12px;
    }

    .finance-page .finance-flow-label {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #64748b;
    }

    .finance-page .finance-flow-row > strong {
        color: #334155;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .finance-page .flow-dot {
        width: 8px;
        height: 8px;
        flex-shrink: 0;
        border-radius: 50%;
    }

    .finance-page .dot-blue {
        background: #6366f1;
    }

    .finance-page .dot-green {
        background: #22c55e;
    }

    .finance-page .dot-purple {
        background: #a855f7;
    }

    .finance-page .dot-red {
        background: #ef4444;
    }

    .finance-page .dot-orange {
        background: #f59e0b;
    }

    .finance-page .dot-gray {
        background: #94a3b8;
    }

    .finance-page .finance-flow-total {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 18px;
        padding: 16px;
        border: 1px solid #bbf7d0;
        border-radius: 11px;
        background: #f0fdf4;
    }

    .finance-page .flow-out-total {
        border-color: #fecaca;
        background: #fef2f2;
    }

    .finance-page .finance-total-label {
        display: block;
        color: #166534;
        font-size: 12px;
        font-weight: 800;
    }

    .finance-page .flow-out-total .finance-total-label {
        color: #b91c1c;
    }

    .finance-page .finance-total-caption {
        margin-top: 4px;
        color: #64748b;
        font-size: 10px;
    }

    .finance-page .finance-flow-total > strong {
        color: #15803d;
        font-size: clamp(14px, 1.5vw, 19px);
        text-align: right;
        overflow-wrap: anywhere;
    }

    .finance-page .flow-out-total > strong {
        color: #dc2626;
    }


    /* Quick Finance Actions */

    .finance-page .finance-quick-header {
        padding: 21px 22px;
        border-bottom: 1px solid var(--finance-border);
    }

    .finance-page .finance-quick-heading-icon {
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #fef3c7;
        color: #d97706;
        font-size: 19px;
    }

    .finance-page .finance-quick-body {
        padding: 22px;
    }

    .finance-page .finance-quick-action {
        display: flex;
        align-items: center;
        gap: 13px;
        height: 100%;
        min-height: 105px;
        padding: 17px;
        border: 1px solid var(--finance-border);
        border-radius: 13px;
        background: #fff;
        color: var(--finance-text);
        text-decoration: none;
        transition: all .2s ease;
    }

    .finance-page .finance-quick-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 9px 22px rgba(15, 23, 42, .07);
    }

    .finance-page .finance-quick-action-icon {
        width: 45px;
        height: 45px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 21px;
    }

    .finance-page .finance-quick-action-content {
        flex: 1;
        min-width: 0;
    }

    .finance-page .finance-quick-action-content h6 {
        margin-bottom: 6px;
        color: #1e293b;
        font-size: 13px;
        font-weight: 800;
    }

    .finance-page .finance-quick-action-content p {
        margin-bottom: 0;
        color: #94a3b8;
        font-size: 11px;
        line-height: 1.5;
    }

    .finance-page .finance-quick-arrow {
        color: #94a3b8;
        font-size: 16px;
        transition: transform .2s ease;
    }

    .finance-page .finance-quick-action:hover .finance-quick-arrow {
        transform: translateX(3px);
    }

    .finance-page .quick-income .finance-quick-action-icon {
        background: #dcfce7;
        color: #15803d;
    }

    .finance-page .quick-income:hover {
        border-color: #bbf7d0;
        background: #fcfffd;
    }

    .finance-page .quick-expense .finance-quick-action-icon {
        background: #fee2e2;
        color: #dc2626;
    }

    .finance-page .quick-expense:hover {
        border-color: #fecaca;
        background: #fffdfd;
    }

    .finance-page .quick-payment .finance-quick-action-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .finance-page .quick-payment:hover {
        border-color: #c7d2fe;
        background: #fdfdff;
    }


    /* Selected Period */

    .finance-page .finance-selected-period {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 17px 20px;
        border: 1px solid #dbeafe;
        border-radius: 13px;
        background: #eff6ff;
    }

    .finance-page .finance-selected-period-icon {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 19px;
    }

    .finance-page .finance-selected-period strong {
        color: #1e40af;
    }


    /* Responsive */

    @media (max-width: 1199.98px) {

        .finance-page .finance-management-links {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

    @media (max-width: 767.98px) {

        .finance-page {
            padding-top: 20px !important;
        }

        .finance-page .finance-header-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            font-size: 21px;
        }

        .finance-page .finance-page-title {
            font-size: 21px;
        }

        .finance-page .finance-header-actions {
            display: grid !important;
            grid-template-columns: 1fr;
            width: 100%;
        }

        .finance-page .finance-header-actions .btn {
            width: 100%;
        }

        .finance-page .finance-management-heading,
        .finance-page .finance-filter-heading,
        .finance-page .finance-quick-header {
            padding: 16px;
        }

        .finance-page .finance-management-links {
            grid-template-columns: 1fr;
            padding: 16px;
        }

        .finance-page .finance-filter-body,
        .finance-page .finance-quick-body {
            padding: 16px;
        }

        .finance-page .finance-stat-card {
            min-height: 160px;
            padding: 17px;
        }

        .finance-page .finance-flow-header {
            padding: 17px;
        }

        .finance-page .finance-flow-body {
            padding: 6px 16px 16px;
        }

        .finance-page .finance-flow-total {
            padding: 13px;
        }

        .finance-page .finance-quick-action {
            min-height: 90px;
        }

    }

    @media (max-width: 380px) {

        .finance-page .finance-flow-tag {
            display: none;
        }

        .finance-page .finance-stat-value {
            font-size: 19px;
        }

        .finance-page .finance-flow-row {
            font-size: 11px;
        }

    }

    @media (prefers-reduced-motion: reduce) {

        .finance-page *,
        .finance-page *::before,
        .finance-page *::after {
            transition: none !important;
            animation: none !important;
        }

    }

</style>

@endsection
