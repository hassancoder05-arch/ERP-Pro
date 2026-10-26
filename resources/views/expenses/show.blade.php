@extends('layouts.app')

@section('title', 'Expense Details')

@section('content')

<div class="container-fluid py-4 expense-details-page">


{{-- Page Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="page-icon">
                <i class="bi bi-receipt-cutoff"></i>
            </span>

            <span class="text-uppercase small fw-semibold text-danger">
                Finance Management
            </span>
        </div>

        <h2 class="fw-bold mb-1">Expense Details</h2>

        <p class="text-muted mb-0">
            Review expense information, payment details and transaction summary.
        </p>
    </div>

    <div class="d-flex flex-wrap gap-2">

        <a href="{{ route('expenses.index') }}" class="btn btn-light border px-3">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Expenses
        </a>

        <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-primary px-4">
            <i class="bi bi-pencil-square me-1"></i>
            Edit Expense
        </a>

    </div>

</div>

{{-- Main Summary --}}
<div class="row g-4 mb-4">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm h-100 main-expense-card">

            <div class="card-body p-4 p-lg-5">

                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="expense-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <div>
                            <span class="text-muted small d-block mb-1">
                                Expense Title
                            </span>

                            <h4 class="fw-bold mb-0">
                                {{ $expense->title }}
                            </h4>
                        </div>

                    </div>

                    <span class="status-badge">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        Recorded
                    </span>

                </div>

                <div class="amount-panel mb-4">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                        <div>
                            <span class="text-muted small d-block mb-2">
                                Total Expense Amount
                            </span>

                            <h1 class="expense-amount mb-0">
                                <span class="currency-label">Rs.</span>
                                {{ number_format((float) $expense->amount, 2) }}
                            </h1>
                        </div>

                        <div class="amount-icon">
                            <i class="bi bi-graph-down-arrow"></i>
                        </div>

                    </div>

                </div>

                <div class="row g-4">

                    <div class="col-md-6">

                        <div class="detail-item">

                            <div class="detail-icon category-icon">
                                <i class="bi bi-grid"></i>
                            </div>

                            <div>
                                <span class="detail-label">Expense Category</span>

                                <h6 class="detail-value mb-0">
                                    {{ $expense->category->name ?? 'Uncategorized' }}
                                </h6>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="detail-item">

                            <div class="detail-icon date-icon">
                                <i class="bi bi-calendar-event"></i>
                            </div>

                            <div>
                                <span class="detail-label">Expense Date</span>

                                <h6 class="detail-value mb-0">
                                    {{ $expense->expense_date
                                        ? \Carbon\Carbon::parse($expense->expense_date)->format('d M Y')
                                        : 'Not available' }}
                                </h6>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="detail-item">

                            <div class="detail-icon payment-icon">
                                <i class="bi bi-credit-card"></i>
                            </div>

                            <div>
                                <span class="detail-label">Payment Method</span>

                                <h6 class="detail-value mb-0 text-capitalize">
                                    {{ $expense->payment_method ?: 'Not specified' }}
                                </h6>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="detail-item">

                            <div class="detail-icon reference-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>
                                <span class="detail-label">Record ID</span>

                                <h6 class="detail-value mb-0">
                                    EXP-{{ str_pad($expense->id, 5, '0', STR_PAD_LEFT) }}
                                </h6>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Right Side Summary --}}
    <div class="col-lg-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-info-circle text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0">Transaction Summary</h5>
                </div>

                <div class="summary-row">
                    <span>Record Number</span>
                    <strong>#{{ $expense->id }}</strong>
                </div>

                <div class="summary-row">
                    <span>Category</span>
                    <strong class="text-end">
                        {{ $expense->category->name ?? 'Uncategorized' }}
                    </strong>
                </div>

                <div class="summary-row">
                    <span>Payment</span>
                    <strong class="text-capitalize">
                        {{ $expense->payment_method ?: 'N/A' }}
                    </strong>
                </div>

                <div class="summary-row">
                    <span>Transaction Date</span>
                    <strong>
                        {{ $expense->expense_date
                            ? \Carbon\Carbon::parse($expense->expense_date)->format('d M Y')
                            : 'N/A' }}
                    </strong>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center gap-3">
                    <span class="fw-semibold text-muted">Total Recorded</span>

                    <h5 class="fw-bold text-danger mb-0">
                        Rs. {{ number_format((float) $expense->amount, 2) }}
                    </h5>
                </div>

                <div class="summary-note mt-4">
                    <i class="bi bi-lightbulb me-2"></i>
                    <span>
                        Check the category, date and payment method before updating this record.
                    </span>
                </div>

            </div>

        </div>

    </div>

</div>

{{-- Description --}}
<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <div class="d-flex align-items-center gap-2 mb-3">
            <div class="description-icon">
                <i class="bi bi-card-text"></i>
            </div>

            <div>
                <h5 class="fw-bold mb-1">Expense Description</h5>
                <p class="text-muted small mb-0">
                    Additional information about this expense.
                </p>
            </div>
        </div>

        <div class="description-box">
            @if(filled($expense->description))
                <p class="mb-0">{{ $expense->description }}</p>
            @else
                <p class="text-muted fst-italic mb-0">
                    No description provided for this expense.
                </p>
            @endif
        </div>

    </div>

</div>


</div>

<style>
    .expense-details-page {
        color: #1e293b;
    }

    .expense-details-page .page-icon {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #fff1f2;
        color: #e11d48;
        font-size: 21px;
    }

    .expense-details-page .card {
        border-radius: 18px;
        overflow: hidden;
    }

    .expense-details-page .main-expense-card {
        border-top: 3px solid #e11d48 !important;
    }

    .expense-details-page .expense-icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: #fff1f2;
        color: #e11d48;
        font-size: 25px;
        flex-shrink: 0;
    }

    .expense-details-page .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 30px;
        background: #ecfdf5;
        color: #047857;
        font-size: 12px;
        font-weight: 700;
    }

    .expense-details-page .amount-panel {
        padding: 24px;
        border: 1px solid #ffe4e6;
        border-radius: 16px;
        background: linear-gradient(135deg, #fff7f7, #fff1f2);
    }

    .expense-details-page .expense-amount {
        color: #e11d48;
        font-size: clamp(26px, 3vw, 38px);
        font-weight: 800;
        letter-spacing: -1px;
        overflow-wrap: anywhere;
    }

    .expense-details-page .currency-label {
        font-size: 18px;
        font-weight: 700;
        letter-spacing: 0;
    }

    .expense-details-page .amount-icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: #ffe4e6;
        color: #e11d48;
        font-size: 25px;
    }

    .expense-details-page .detail-item {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
    }

    .expense-details-page .detail-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 19px;
        flex-shrink: 0;
    }

    .expense-details-page .category-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .expense-details-page .date-icon {
        background: #f5f3ff;
        color: #7c3aed;
    }

    .expense-details-page .payment-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .expense-details-page .reference-icon {
        background: #f1f5f9;
        color: #475569;
    }

    .expense-details-page .detail-label {
        display: block;
        color: #64748b;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .expense-details-page .detail-value {
        color: #1e293b;
        font-size: 14px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .expense-details-page .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        padding: 15px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
    }

    .expense-details-page .summary-row span {
        color: #64748b;
        flex-shrink: 0;
    }

    .expense-details-page .summary-row strong {
        color: #1e293b;
        overflow-wrap: anywhere;
    }

    .expense-details-page .summary-note {
        display: flex;
        align-items: flex-start;
        padding: 14px;
        border-radius: 12px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 12px;
        line-height: 1.7;
    }

    .expense-details-page .description-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #fff1f2;
        color: #e11d48;
        font-size: 20px;
        flex-shrink: 0;
    }

    .expense-details-page .description-box {
        padding: 20px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        line-height: 1.8;
        overflow-wrap: anywhere;
    }

    .expense-details-page .btn {
        border-radius: 10px;
        font-weight: 600;
        padding-top: 10px;
        padding-bottom: 10px;
        transition: all .2s ease;
    }

    .expense-details-page .btn-primary {
        background: #4f46e5;
        border-color: #4f46e5;
    }

    .expense-details-page .btn-primary:hover {
        background: #4338ca;
        border-color: #4338ca;
        transform: translateY(-1px);
    }

    .expense-details-page .btn-light:hover {
        background: #f1f5f9;
    }

    @media (max-width: 576px) {
        .expense-details-page .amount-panel {
            padding: 18px;
        }

        .expense-details-page .summary-row {
            font-size: 12px;
        }
    }
</style>

@endsection
