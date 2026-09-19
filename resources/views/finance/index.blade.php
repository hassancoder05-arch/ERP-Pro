
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

