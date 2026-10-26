@extends('layouts.app')

@section('title', 'Add Income')

@section('content')

<div class="container-fluid add-income-page py-3 py-lg-4">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="income-create-header-icon">
                    <i class="bi bi-wallet2"></i>
                </span>

                <span class="income-create-eyebrow">
                    FINANCE MANAGEMENT
                </span>
            </div>

            <h2 class="fw-bold mb-1">Add Income</h2>

            <p class="text-muted mb-0">
                Record and organize additional business income.
            </p>
        </div>

        <a href="{{ route('incomes.index') }}" class="btn btn-light border income-back-btn">
            <i class="bi bi-arrow-left me-2"></i>
            Back to Income
        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="alert alert-danger income-validation-alert alert-dismissible fade show" role="alert">

            <div class="d-flex align-items-start gap-3">

                <i class="bi bi-exclamation-triangle-fill fs-5"></i>

                <div>
                    <h6 class="fw-bold mb-2">Please check the following fields</h6>

                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        </div>

    @endif


    <div class="row g-4">

        {{-- Main Form --}}
        <div class="col-12 col-xl-8">

            <div class="income-form-card">

                <div class="income-form-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="income-form-heading-icon">
                            <i class="bi bi-plus-circle"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Income Information</h5>

                            <p class="text-muted small mb-0">
                                Enter the details of the income transaction.
                            </p>
                        </div>

                    </div>

                    <span class="income-required-label">
                        * Required fields
                    </span>

                </div>


                <form action="{{ route('incomes.store') }}"
                      method="POST"
                      id="incomeCreateForm">

                    @csrf

                    <div class="income-form-body">

                        {{-- Income Details --}}
                        <div class="income-section-heading">
                            <span class="income-section-number">01</span>

                            <div>
                                <h6 class="fw-bold mb-1">Income Details</h6>

                                <p class="text-muted small mb-0">
                                    Identify the income and its amount.
                                </p>
                            </div>
                        </div>


                        <div class="row g-4">

                            {{-- Title --}}
                            <div class="col-12">

                                <label for="title" class="form-label income-label">
                                    Income Title <span class="text-danger">*</span>
                                </label>

                                <div class="income-input-wrapper">

                                    <i class="bi bi-card-heading income-input-icon"></i>

                                    <input
                                        type="text"
                                        id="title"
                                        name="title"
                                        class="form-control income-input @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}"
                                        placeholder="e.g. Service Income, Rental Income"
                                        maxlength="255"
                                        required
                                        autofocus
                                    >

                                </div>

                                @error('title')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror

                                <div class="form-text">
                                    Use a clear title that describes the source of income.
                                </div>

                            </div>


                            {{-- Amount --}}
                            <div class="col-12">

                                <label for="amount" class="form-label income-label">
                                    Income Amount <span class="text-danger">*</span>
                                </label>

                                <div class="income-amount-input-group">

                                    <span class="income-currency-prefix">Rs.</span>

                                    <input
                                        type="number"
                                        id="amount"
                                        name="amount"
                                        class="form-control income-amount-input @error('amount') is-invalid @enderror"
                                        value="{{ old('amount') }}"
                                        min="0.01"
                                        step="0.01"
                                        placeholder="0.00"
                                        required
                                    >

                                </div>

                                @error('amount')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror

                                <div class="form-text">
                                    Enter the actual amount received. Minimum amount is Rs. 0.01.
                                </div>

                            </div>

                        </div>


                        <div class="income-form-divider"></div>


                        {{-- Transaction Details --}}
                        <div class="income-section-heading">

                            <span class="income-section-number">02</span>

                            <div>
                                <h6 class="fw-bold mb-1">Transaction Details</h6>

                                <p class="text-muted small mb-0">
                                    Specify when and how the income was received.
                                </p>
                            </div>

                        </div>


                        <div class="row g-4">

                            {{-- Date --}}
                            <div class="col-12 col-md-6">

                                <label for="income_date" class="form-label income-label">
                                    Income Date <span class="text-danger">*</span>
                                </label>

                                <div class="income-input-wrapper">

                                    <i class="bi bi-calendar3 income-input-icon"></i>

                                    <input
                                        type="date"
                                        id="income_date"
                                        name="income_date"
                                        class="form-control income-input @error('income_date') is-invalid @enderror"
                                        value="{{ old('income_date', now()->format('Y-m-d')) }}"
                                        required
                                    >

                                </div>

                                @error('income_date')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror

                            </div>


                            {{-- Payment Method --}}
                            <div class="col-12 col-md-6">

                                <label for="payment_method" class="form-label income-label">
                                    Payment Method <span class="text-danger">*</span>
                                </label>

                                <div class="income-input-wrapper">

                                    <i class="bi bi-credit-card income-input-icon"></i>

                                    <select
                                        name="payment_method"
                                        id="payment_method"
                                        class="form-select income-input income-select @error('payment_method') is-invalid @enderror"
                                        required
                                    >

                                        <option value="" disabled
                                            {{ old('payment_method') ? '' : 'selected' }}>
                                            Select payment method
                                        </option>

                                        <option value="cash"
                                            {{ old('payment_method') === 'cash' ? 'selected' : '' }}>
                                            Cash
                                        </option>

                                        <option value="bank"
                                            {{ old('payment_method') === 'bank' ? 'selected' : '' }}>
                                            Bank
                                        </option>

                                        <option value="other"
                                            {{ old('payment_method') === 'other' ? 'selected' : '' }}>
                                            Other
                                        </option>

                                    </select>

                                </div>

                                @error('payment_method')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror

                            </div>


                            {{-- Description --}}
                            <div class="col-12">

                                <label for="description" class="form-label income-label">
                                    Description
                                    <span class="text-muted fw-normal">(Optional)</span>
                                </label>

                                <textarea
                                    name="description"
                                    id="description"
                                    class="form-control income-textarea @error('description') is-invalid @enderror"
                                    rows="4"
                                    maxlength="2000"
                                    placeholder="Add notes about this income, its source or any other relevant information..."
                                >{{ old('description') }}</textarea>

                                @error('description')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror

                                <div class="d-flex justify-content-between gap-2 mt-2">

                                    <div class="form-text">
                                        Keep the description clear and relevant.
                                    </div>

                                    <small class="text-muted" id="descriptionCounter">
                                        {{ strlen(old('description', '')) }}/2000
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Form Footer --}}
                    <div class="income-form-footer">

                        <p class="text-muted small mb-0">
                            <i class="bi bi-shield-check me-1"></i>
                            Review the information before saving.
                        </p>

                        <div class="d-flex flex-wrap gap-2">

                            <a href="{{ route('incomes.index') }}"
                               class="btn btn-light border income-cancel-btn">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="btn btn-success income-save-btn"
                                    id="saveIncomeButton">

                                <i class="bi bi-check2-circle me-2"></i>
                                Save Income

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- Right Sidebar --}}
        <div class="col-12 col-xl-4">

            <div class="income-sidebar-stack">

                {{-- Preview Card --}}
                <div class="income-preview-card">

                    <div class="income-preview-top">

                        <div class="d-flex justify-content-between align-items-center gap-2">

                            <span class="income-preview-label">
                                TRANSACTION PREVIEW
                            </span>

                            <span class="income-preview-status">
                                <span class="income-preview-dot"></span>
                                New Entry
                            </span>

                        </div>

                        <div class="income-preview-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <p class="income-preview-caption mb-1">
                            Income Amount
                        </p>

                        <h2 class="income-preview-amount mb-0" id="incomeAmountPreview">
                            Rs. 0.00
                        </h2>

                    </div>


                    <div class="income-preview-details">

                        <div class="income-preview-row">

                            <span>
                                <i class="bi bi-card-text me-2"></i>
                                Title
                            </span>

                            <strong id="incomeTitlePreview">Not entered</strong>

                        </div>

                        <div class="income-preview-row">

                            <span>
                                <i class="bi bi-calendar3 me-2"></i>
                                Date
                            </span>

                            <strong id="incomeDatePreview">
                                {{ now()->format('d M Y') }}
                            </strong>

                        </div>

                        <div class="income-preview-row">

                            <span>
                                <i class="bi bi-credit-card me-2"></i>
                                Payment
                            </span>

                            <strong id="incomePaymentPreview">Not selected</strong>

                        </div>

                    </div>

                </div>


                {{-- Payment Methods --}}
                <div class="income-side-card">

                    <div class="income-side-card-heading">
                        <div class="income-side-icon green">
                            <i class="bi bi-credit-card-2-front"></i>
                        </div>

                        <h6 class="fw-bold mb-0">Payment Methods</h6>
                    </div>

                    <div class="income-payment-option">

                        <span class="income-payment-option-icon cash">
                            <i class="bi bi-cash"></i>
                        </span>

                        <div>
                            <div class="fw-semibold">Cash</div>
                            <small class="text-muted">Physical cash received</small>
                        </div>

                    </div>

                    <div class="income-payment-option">

                        <span class="income-payment-option-icon bank">
                            <i class="bi bi-bank"></i>
                        </span>

                        <div>
                            <div class="fw-semibold">Bank</div>
                            <small class="text-muted">Bank-related transaction</small>
                        </div>

                    </div>

                    <div class="income-payment-option">

                        <span class="income-payment-option-icon other">
                            <i class="bi bi-three-dots"></i>
                        </span>

                        <div>
                            <div class="fw-semibold">Other</div>
                            <small class="text-muted">Other accepted methods</small>
                        </div>

                    </div>

                </div>


                {{-- Tips --}}
                <div class="income-tips-card">

                    <div class="income-tips-heading">
                        <i class="bi bi-lightbulb me-2"></i>
                        Helpful Tips
                    </div>

                    <div class="income-tip">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Enter the amount actually received.</span>
                    </div>

                    <div class="income-tip">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Choose the correct payment method.</span>
                    </div>

                    <div class="income-tip">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Use a clear title for easier reporting.</span>
                    </div>

                    <div class="income-tip">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Add a description when extra context is useful.</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<style>
.add-income-page {
    --income-green: #059669;
    --income-green-dark: #047857;
    --income-text: #172033;
    --income-muted: #718096;
    --income-border: #e8edf4;
    color: var(--income-text);
}

.income-create-header-icon {
    display: inline-flex;
    width: 43px;
    height: 43px;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #dcfce7;
    color: #047857;
    font-size: 22px;
}

.income-create-eyebrow {
    color: #059669;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.2px;
}

.income-back-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 43px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 600;
}

.income-validation-alert {
    border: 0;
    border-radius: 12px;
    box-shadow: 0 5px 18px rgba(220, 38, 38, .06);
}

.income-form-card,
.income-side-card {
    overflow: hidden;
    border: 1px solid var(--income-border);
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 5px 22px rgba(15, 23, 42, .035);
}

.income-form-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    padding: 23px 25px;
    border-bottom: 1px solid var(--income-border);
}

.income-form-heading-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 45px;
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: #ecfdf5;
    color: #059669;
    font-size: 22px;
}

.income-required-label {
    color: #94a3b8;
    font-size: 11px;
    white-space: nowrap;
}

.income-form-body {
    padding: 27px 25px;
}

.income-section-heading {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 24px;
}

.income-section-number {
    display: flex;
    flex: 0 0 38px;
    width: 38px;
    height: 38px;
    align-items: center;
    justify-content: center;
    border: 1px solid #d1fae5;
    border-radius: 10px;
    background: #ecfdf5;
    color: #047857;
    font-size: 12px;
    font-weight: 800;
}

.income-section-heading h6 {
    color: #1e293b;
    font-size: 14px;
}

.income-section-heading p {
    font-size: 12px;
}

.income-label {
    display: block;
    margin-bottom: 9px;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
}

.income-input-wrapper {
    position: relative;
}

.income-input-icon {
    position: absolute;
    top: 50%;
    left: 14px;
    z-index: 2;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 16px;
    pointer-events: none;
}

.income-input {
    width: 100%;
    min-height: 47px;
    padding: 11px 13px 11px 42px;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    background-color: #fff;
    color: #334155;
    font-size: 13px;
    box-shadow: none;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.income-input:focus,
.income-textarea:focus,
.income-amount-input:focus {
    border-color: #6ee7b7;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, .09);
}

.income-input.is-invalid,
.income-textarea.is-invalid,
.income-amount-input.is-invalid {
    border-color: #dc3545;
}

.income-select {
    appearance: auto;
}

.income-amount-input-group {
    display: flex;
    min-height: 54px;
    overflow: hidden;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    background: #f0fdf4;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.income-amount-input-group:focus-within {
    border-color: #34d399;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, .09);
}

.income-currency-prefix {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 60px;
    padding: 0 13px;
    border-right: 1px solid #bbf7d0;
    background: #dcfce7;
    color: #047857;
    font-size: 15px;
    font-weight: 800;
}

.income-amount-input {
    width: 100%;
    min-width: 0;
    padding: 12px 15px;
    border: 0;
    outline: 0;
    background: transparent;
    color: #047857;
    font-size: 21px;
    font-weight: 800;
    box-shadow: none;
}

.income-amount-input:focus {
    border: 0;
    box-shadow: none;
}

.income-amount-input::placeholder {
    color: #a7cdb7;
}

.income-form-body .form-text {
    color: #94a3b8;
    font-size: 11px;
}

.income-form-divider {
    height: 1px;
    margin: 29px 0;
    background: var(--income-border);
}

.income-textarea {
    min-height: 115px;
    padding: 13px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    font-size: 13px;
    resize: vertical;
    box-shadow: none;
}

.income-form-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
    padding: 20px 25px;
    border-top: 1px solid var(--income-border);
    background: #fcfdff;
}

.income-cancel-btn,
.income-save-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 43px;
    padding: 10px 18px;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 700;
    transition: all .2s ease;
}

.income-save-btn {
    border-color: var(--income-green);
    background: var(--income-green);
    box-shadow: 0 4px 10px rgba(5, 150, 105, .12);
}

.income-save-btn:hover {
    border-color: var(--income-green-dark);
    background: var(--income-green-dark);
    transform: translateY(-1px);
}

.income-sidebar-stack {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.income-preview-card {
    overflow: hidden;
    border: 1px solid #d1fae5;
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 6px 25px rgba(15, 23, 42, .035);
}

.income-preview-top {
    padding: 23px;
    background: linear-gradient(135deg, #047857 0%, #059669 58%, #10b981 100%);
    color: #fff;
}

.income-preview-label {
    color: rgba(255, 255, 255, .85);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.1px;
}

.income-preview-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 9px;
    border: 1px solid rgba(255, 255, 255, .2);
    border-radius: 7px;
    background: rgba(255, 255, 255, .13);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
}

.income-preview-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #86efac;
}

.income-preview-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    margin-top: 25px;
    margin-bottom: 19px;
    border: 1px solid rgba(255, 255, 255, .2);
    border-radius: 12px;
    background: rgba(255, 255, 255, .13);
    font-size: 22px;
}

.income-preview-caption {
    color: rgba(255, 255, 255, .8);
    font-size: 12px;
}

.income-preview-amount {
    overflow-wrap: anywhere;
    font-size: clamp(24px, 3vw, 31px);
    font-weight: 800;
    letter-spacing: -.7px;
}

.income-preview-details {
    padding: 7px 20px;
}

.income-preview-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 0;
    border-bottom: 1px solid #edf2f7;
    font-size: 12px;
}

.income-preview-row:last-child {
    border-bottom: 0;
}

.income-preview-row > span {
    flex: 0 0 auto;
    color: #94a3b8;
}

.income-preview-row > strong {
    min-width: 0;
    max-width: 60%;
    color: #334155;
    text-align: right;
    overflow-wrap: anywhere;
}

.income-side-card {
    padding: 21px;
}

.income-side-card-heading {
    display: flex;
    align-items: center;
    gap: 11px;
    margin-bottom: 19px;
}

.income-side-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 39px;
    height: 39px;
    border-radius: 11px;
    font-size: 19px;
}

.income-side-icon.green {
    background: #dcfce7;
    color: #15803d;
}

.income-side-card-heading h6 {
    color: #1e293b;
    font-size: 14px;
}

.income-payment-option {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 0;
    border-bottom: 1px solid #edf2f7;
}

.income-payment-option:last-child {
    padding-bottom: 0;
    border-bottom: 0;
}

.income-payment-option-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 39px;
    width: 39px;
    height: 39px;
    border-radius: 10px;
    font-size: 18px;
}

.income-payment-option-icon.cash {
    background: #dcfce7;
    color: #15803d;
}

.income-payment-option-icon.bank {
    background: #dbeafe;
    color: #2563eb;
}

.income-payment-option-icon.other {
    background: #ede9fe;
    color: #7c3aed;
}

.income-payment-option .fw-semibold {
    color: #334155;
    font-size: 12px;
}

.income-payment-option small {
    font-size: 11px;
}

.income-tips-card {
    padding: 21px;
    border: 1px solid #dbeafe;
    border-radius: 15px;
    background: #f8fbff;
}

.income-tips-heading {
    margin-bottom: 16px;
    color: #1e40af;
    font-size: 13px;
    font-weight: 800;
}

.income-tip {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    margin-bottom: 13px;
    color: #64748b;
    font-size: 12px;
    line-height: 1.5;
}

.income-tip:last-child {
    margin-bottom: 0;
}

.income-tip i {
    margin-top: 2px;
    color: #059669;
    font-size: 14px;
}


/* Responsive */
@media (max-width: 767.98px) {

    .income-form-card-header {
        align-items: flex-start;
        flex-direction: column;
        padding: 19px;
    }

    .income-form-body {
        padding: 22px 18px;
    }

    .income-form-footer {
        align-items: stretch;
        flex-direction: column;
        padding: 18px;
    }

    .income-form-footer > .d-flex {
        width: 100%;
    }

    .income-form-footer .btn {
        flex: 1;
    }

    .income-preview-top {
        padding: 20px;
    }

    .income-side-card,
    .income-tips-card {
        padding: 18px;
    }
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const titleInput = document.getElementById('title');
    const amountInput = document.getElementById('amount');
    const dateInput = document.getElementById('income_date');
    const paymentInput = document.getElementById('payment_method');
    const descriptionInput = document.getElementById('description');

    const titlePreview = document.getElementById('incomeTitlePreview');
    const amountPreview = document.getElementById('incomeAmountPreview');
    const datePreview = document.getElementById('incomeDatePreview');
    const paymentPreview = document.getElementById('incomePaymentPreview');
    const descriptionCounter = document.getElementById('descriptionCounter');

    const form = document.getElementById('incomeCreateForm');
    const saveButton = document.getElementById('saveIncomeButton');

    function updateIncomePreview() {

        const title = titleInput.value.trim();
        const amount = Number.parseFloat(amountInput.value);
        const date = dateInput.value;
        const payment = paymentInput.value;

        titlePreview.textContent = title || 'Not entered';

        amountPreview.textContent = 'Rs. ' + (
            Number.isFinite(amount) && amount > 0
                ? amount.toLocaleString('en-PK', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
                : '0.00'
        );

        if (date) {
            const parsedDate = new Date(date + 'T00:00:00');

            datePreview.textContent = Number.isNaN(parsedDate.getTime())
                ? date
                : parsedDate.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
        } else {
            datePreview.textContent = 'Not selected';
        }

        if (payment) {
            paymentPreview.textContent =
                payment.charAt(0).toUpperCase() + payment.slice(1);
        } else {
            paymentPreview.textContent = 'Not selected';
        }

        descriptionCounter.textContent =
            descriptionInput.value.length + '/2000';
    }

    [titleInput, amountInput, dateInput, paymentInput, descriptionInput]
        .forEach(function (input) {
            input.addEventListener('input', updateIncomePreview);
            input.addEventListener('change', updateIncomePreview);
        });

    form.addEventListener('submit', function () {

        if (!form.checkValidity()) {
            return;
        }

        saveButton.disabled = true;
        saveButton.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving Income...';
    });

    updateIncomePreview();
});
</script>

@endsection

