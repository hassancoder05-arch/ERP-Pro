
@extends('layouts.app')

@section('title', 'Income Details')

@section('content')

<div class="container-fluid income-details-page py-3">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div class="d-flex align-items-center gap-3">

            <div class="income-header-icon">
                <i class="bi bi-wallet2"></i>
            </div>

            <div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h2 class="fw-bold mb-1">Income Details</h2>
                    <span class="status-badge">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        Recorded
                    </span>
                </div>

                <p class="text-muted mb-0">
                    View complete information about this income transaction.
                </p>
            </div>

        </div>

        <div class="d-flex flex-wrap gap-2">

            <a href="{{ route('incomes.index') }}" class="btn btn-light border action-btn">
                <i class="bi bi-arrow-left me-1"></i>
                Back to Income
            </a>

            <a href="{{ route('incomes.edit', $income) }}" class="btn btn-primary action-btn">
                <i class="bi bi-pencil-square me-1"></i>
                Edit Income
            </a>

        </div>

    </div>


    {{-- Main Summary --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-8">

            <div class="card border-0 summary-card h-100">

                <div class="card-body p-4 p-lg-5">

                    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">

                        <div>
                            <span class="section-eyebrow">INCOME SUMMARY</span>

                            <h4 class="fw-bold mt-2 mb-1">
                                {{ $income->title ?: 'Income Transaction' }}
                            </h4>

                            <p class="text-muted mb-0 small">
                                Income transaction overview
                            </p>
                        </div>

                        <div class="summary-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>

                    </div>

                    <div class="amount-panel">

                        <span class="amount-label">Total Income Amount</span>

                        <div class="income-amount">
                            <span class="currency-label">PKR</span>
                            Rs. {{ number_format((float) $income->amount, 2) }}
                        </div>

                        <div class="amount-footer">
                            <span>
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $income->income_date
                                    ? \Illuminate\Support\Carbon::parse($income->income_date)->format('d M Y')
                                    : 'Date not available' }}
                            </span>

                            <span class="amount-dot"></span>

                            <span>
                                <i class="bi bi-shield-check me-1"></i>
                                Income Record
                            </span>
                        </div>

                    </div>

                    <div class="row g-3 mt-3">

                        <div class="col-sm-6">

                            <div class="mini-detail-card">
                                <div class="mini-detail-icon date-icon">
                                    <i class="bi bi-calendar-event"></i>
                                </div>

                                <div>
                                    <small>Transaction Date</small>

                                    <h6 class="mb-0 fw-bold">
                                        {{ $income->income_date
                                            ? \Illuminate\Support\Carbon::parse($income->income_date)->format('d M Y')
                                            : 'Not specified' }}
                                    </h6>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-6">

                            <div class="mini-detail-card">
                                <div class="mini-detail-icon payment-icon">
                                    <i class="bi bi-credit-card"></i>
                                </div>

                                <div>
                                    <small>Payment Method</small>

                                    <h6 class="mb-0 fw-bold text-capitalize">
                                        {{ $income->payment_method ?: 'Not specified' }}
                                    </h6>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Right Information Panel --}}
        <div class="col-xl-4">

            <div class="card border-0 side-card h-100">

                <div class="card-body p-4">

                    <div class="side-card-heading mb-4">
                        <div class="side-icon">
                            <i class="bi bi-receipt-cutoff"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Transaction Info</h5>
                            <p class="text-muted small mb-0">
                                Record identification
                            </p>
                        </div>
                    </div>

                    <div class="info-row">
                        <span>Record ID</span>
                        <strong>#{{ $income->id }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Income Title</span>
                        <strong class="text-end">
                            {{ $income->title ?: '—' }}
                        </strong>
                    </div>

                    <div class="info-row">
                        <span>Payment Type</span>

                        @php
                            $method = strtolower($income->payment_method ?? 'other');
                        @endphp

                        <span class="payment-badge
                            {{ $method === 'cash' ? 'payment-cash' : '' }}
                            {{ $method === 'bank' ? 'payment-bank' : '' }}
                            {{ !in_array($method, ['cash', 'bank']) ? 'payment-other' : '' }}">
                            <i class="bi
                                {{ $method === 'cash' ? 'bi-cash' : '' }}
                                {{ $method === 'bank' ? 'bi-bank' : '' }}
                                {{ !in_array($method, ['cash', 'bank']) ? 'bi-wallet2' : '' }} me-1"></i>

                            {{ $income->payment_method
                                ? ucfirst($income->payment_method)
                                : 'Not specified' }}
                        </span>
                    </div>

                    <div class="info-row">
                        <span>Created On</span>
                        <strong>
                            {{ $income->created_at
                                ? $income->created_at->format('d M Y')
                                : '—' }}
                        </strong>
                    </div>

                    <div class="info-row">
                        <span>Last Updated</span>
                        <strong>
                            {{ $income->updated_at
                                ? $income->updated_at->format('d M Y')
                                : '—' }}
                        </strong>
                    </div>

                    <div class="side-note mt-4">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Keep income records accurate to maintain reliable financial reports.
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Description --}}
    <div class="card border-0 description-card">

        <div class="card-body p-4">

            <div class="d-flex align-items-center gap-3 mb-3">

                <div class="description-icon">
                    <i class="bi bi-card-text"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">Income Description</h5>
                    <p class="text-muted small mb-0">
                        Additional information about this transaction
                    </p>
                </div>

            </div>

            <div class="description-content">
                @if($income->description)
                    {{ $income->description }}
                @else
                    <div class="empty-description">
                        <i class="bi bi-chat-square-text me-2"></i>
                        No description has been provided for this income.
                    </div>
                @endif
            </div>

        </div>

    </div>


    {{-- Footer Actions --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4">

        <div class="text-muted small">
            <i class="bi bi-lock-fill me-1"></i>
            Financial record details
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('incomes.index') }}" class="btn btn-light border action-btn">
                <i class="bi bi-list-ul me-1"></i>
                All Income Records
            </a>

            <a href="{{ route('incomes.edit', $income) }}" class="btn btn-primary action-btn">
                <i class="bi bi-pencil me-1"></i>
                Update Record
            </a>

        </div>

    </div>

</div>


{{-- Page Styles --}}
<style>
    .income-details-page {
        color: #172033;
    }

    .income-header-icon {
        width: 58px;
        height: 58px;
        min-width: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #15803d;
        font-size: 27px;
    }

    .income-details-page h2 {
        font-size: clamp(1.45rem, 2.5vw, 1.9rem);
        letter-spacing: -0.6px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 30px;
        padding: 5px 10px;
        background: #dcfce7;
        color: #15803d;
        font-size: 11px;
        font-weight: 700;
    }

    .action-btn {
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .income-details-page .btn-primary {
        background: #4f46e5;
        border-color: #4f46e5;
    }

    .income-details-page .btn-primary:hover {
        background: #4338ca;
        border-color: #4338ca;
    }

    .summary-card,
    .side-card,
    .description-card {
        border-radius: 20px;
        box-shadow: 0 5px 25px rgba(15, 23, 42, 0.045);
    }

    .summary-icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 16px;
        background: #dcfce7;
        color: #16a34a;
        font-size: 25px;
    }

    .section-eyebrow {
        color: #64748b;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.5px;
    }

    .amount-panel {
        padding: 27px;
        border: 1px solid #d1fae5;
        border-radius: 17px;
        background: linear-gradient(135deg, #f0fdf4, #f8fffb);
    }

    .amount-label {
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .income-amount {
        margin-top: 9px;
        color: #15803d;
        font-size: clamp(1.7rem, 3vw, 2.45rem);
        font-weight: 800;
        letter-spacing: -1px;
        overflow-wrap: anywhere;
    }

    .currency-label {
        display: inline-block;
        margin-right: 4px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0;
        vertical-align: middle;
    }

    .amount-footer {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin-top: 13px;
        color: #64748b;
        font-size: 11px;
    }

    .amount-dot {
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #94a3b8;
    }

    .mini-detail-card {
        display: flex;
        align-items: center;
        gap: 12px;
        height: 100%;
        padding: 16px;
        border: 1px solid #edf0f5;
        border-radius: 14px;
        background: #fff;
    }

    .mini-detail-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 19px;
    }

    .date-icon {
        color: #4f46e5;
        background: #eef2ff;
    }

    .payment-icon {
        color: #0284c7;
        background: #e0f2fe;
    }

    .mini-detail-card small {
        display: block;
        margin-bottom: 5px;
        color: #64748b;
        font-size: 11px;
    }

    .mini-detail-card h6 {
        font-size: 13px;
        overflow-wrap: anywhere;
    }

    .side-card-heading {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .side-icon,
    .description-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 21px;
        flex-shrink: 0;
    }

    .side-card-heading h5,
    .description-card h5 {
        font-size: 16px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        padding: 15px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 12px;
    }

    .info-row:last-of-type {
        border-bottom: 0;
    }

    .info-row > span:first-child {
        color: #64748b;
        flex-shrink: 0;
    }

    .info-row strong {
        color: #1e293b;
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .payment-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .payment-cash {
        background: #dcfce7;
        color: #15803d;
    }

    .payment-bank {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .payment-other {
        background: #f1f5f9;
        color: #475569;
    }

    .side-note {
        padding: 13px;
        border-radius: 11px;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        line-height: 1.7;
    }

    .side-note i {
        color: #6366f1;
    }

    .description-card {
        margin-top: 0;
    }

    .description-content {
        margin-top: 18px;
        padding: 20px;
        border: 1px solid #edf0f5;
        border-radius: 13px;
        background: #fafbff;
        color: #475569;
        font-size: 13px;
        line-height: 1.9;
        overflow-wrap: anywhere;
        white-space: pre-line;
    }

    .empty-description {
        color: #94a3b8;
        font-style: italic;
    }

    @media (max-width: 767.98px) {
        .income-details-page {
            padding-left: 10px;
            padding-right: 10px;
        }

        .income-header-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            font-size: 22px;
        }

        .income-details-page .summary-card .card-body,
        .income-details-page .side-card .card-body,
        .income-details-page .description-card .card-body {
            padding: 20px !important;
        }

        .amount-panel {
            padding: 20px;
        }

        .income-amount {
            font-size: 1.65rem;
        }

        .amount-footer {
            align-items: flex-start;
            flex-direction: column;
            gap: 7px;
        }

        .amount-dot {
            display: none;
        }

        .action-btn {
            padding: 9px 12px;
        }
    }
</style>

@endsection

