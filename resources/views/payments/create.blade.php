@extends('layouts.app')

@section('title', 'Record Payment')

@section('content')

@php
$selectedType = old('type', '');
$selectedMethod = old('payment_method', 'cash');
$selectedCustomer = old('customer_id', '');
$selectedSupplier = old('supplier_id', '');
$paymentDate = old('payment_date', now()->format('Y-m-d'));
@endphp

<div class="container-fluid py-4 record-payment-page">


{{-- Page Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="page-icon">
                <i class="bi bi-wallet2"></i>
            </span>

            <span class="text-uppercase small fw-semibold text-primary">
                Finance Management
            </span>
        </div>

        <h2 class="fw-bold mb-1">Record Payment</h2>

        <p class="text-muted mb-0">
            Record money received from customers or paid to suppliers.
        </p>
    </div>

    <a href="{{ route('payments.index') }}" class="btn btn-light border px-3">
        <i class="bi bi-arrow-left me-1"></i>
        Back to Payments
    </a>

</div>

{{-- Validation Errors --}}
@if($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
        <div class="d-flex align-items-start gap-2">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>

            <div>
                <h6 class="fw-bold mb-2">Please correct the following errors:</h6>

                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<form action="{{ route('payments.store') }}"
      method="POST"
      id="recordPaymentForm">

    @csrf

    <div class="row g-4">

        {{-- Main Form --}}
        <div class="col-xl-8 col-lg-7">

            <div class="card border-0 shadow-sm payment-form-card">

                <div class="card-header bg-white border-0 px-4 pt-4 pb-0">

                    <div class="d-flex align-items-center gap-3">

                        <div class="section-icon">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Payment Information</h5>

                            <p class="text-muted small mb-0">
                                Enter the transaction details below.
                            </p>
                        </div>

                    </div>

                </div>

                <div class="card-body p-4">

                    {{-- Payment Type --}}
                    <div class="mb-4">

                        <label for="paymentType" class="form-label fw-semibold">
                            Payment Type <span class="text-danger">*</span>
                        </label>

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="type-option {{ $selectedType === 'customer' ? 'active' : '' }}"
                                       for="typeCustomer">

                                    <input type="radio"
                                           name="type"
                                           id="typeCustomer"
                                           value="customer"
                                           class="type-radio"
                                           @checked($selectedType === 'customer')
                                           required>

                                    <span class="type-option-icon customer-type-icon">
                                        <i class="bi bi-arrow-down-left-circle"></i>
                                    </span>

                                    <span class="type-option-content">
                                        <strong>Customer Payment</strong>
                                        <small>Money received from a customer</small>
                                    </span>

                                    <i class="bi bi-check-circle-fill type-check"></i>

                                </label>

                            </div>

                            <div class="col-md-6">

                                <label class="type-option {{ $selectedType === 'supplier' ? 'active' : '' }}"
                                       for="typeSupplier">

                                    <input type="radio"
                                           name="type"
                                           id="typeSupplier"
                                           value="supplier"
                                           class="type-radio"
                                           @checked($selectedType === 'supplier')
                                           required>

                                    <span class="type-option-icon supplier-type-icon">
                                        <i class="bi bi-arrow-up-right-circle"></i>
                                    </span>

                                    <span class="type-option-content">
                                        <strong>Supplier Payment</strong>
                                        <small>Money paid to a supplier</small>
                                    </span>

                                    <i class="bi bi-check-circle-fill type-check"></i>

                                </label>

                            </div>

                        </div>

                        @error('type')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- Customer / Supplier --}}
                    <div class="row g-3 mb-4">

                        <div class="col-md-6 {{ $selectedType === 'supplier' ? 'd-none' : '' }}"
                             id="customerBox">

                            <label for="customer_id" class="form-label fw-semibold">
                                Select Customer
                                <span class="text-danger">*</span>
                            </label>

                            <select name="customer_id"
                                    id="customer_id"
                                    class="form-select custom-input @error('customer_id') is-invalid @enderror"
                                    {{ $selectedType === 'customer' ? 'required' : '' }}
                                    {{ $selectedType === 'supplier' ? 'disabled' : '' }}>

                                <option value="">Choose a customer</option>

                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        @selected((string) $selectedCustomer === (string) $customer->id)>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($customers->isEmpty())
                                <div class="form-text text-warning">
                                    No customers available.
                                </div>
                            @endif

                        </div>

                        <div class="col-md-6 {{ $selectedType === 'supplier' ? '' : 'd-none' }}"
                             id="supplierBox">

                            <label for="supplier_id" class="form-label fw-semibold">
                                Select Supplier
                                <span class="text-danger">*</span>
                            </label>

                            <select name="supplier_id"
                                    id="supplier_id"
                                    class="form-select custom-input @error('supplier_id') is-invalid @enderror"
                                    {{ $selectedType === 'supplier' ? 'required' : '' }}
                                    {{ $selectedType === 'supplier' ? '' : 'disabled' }}>

                                <option value="">Choose a supplier</option>

                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        @selected((string) $selectedSupplier === (string) $supplier->id)>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($suppliers->isEmpty())
                                <div class="form-text text-warning">
                                    No suppliers available.
                                </div>
                            @endif

                        </div>

                        <div class="col-md-6">

                            <label for="amount" class="form-label fw-semibold">
                                Payment Amount (Rs.) <span class="text-danger">*</span>
                            </label>

                            <div class="input-group input-group-lg amount-input-group">

                                <span class="input-group-text">Rs.</span>

                                <input type="number"
                                       name="amount"
                                       id="amount"
                                       class="form-control @error('amount') is-invalid @enderror"
                                       value="{{ old('amount') }}"
                                       min="0.01"
                                       step="0.01"
                                       placeholder="0.00"
                                       required>

                            </div>

                            @error('amount')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                        </div>

                    </div>

                    {{-- Date and Reference --}}
                    <div class="row g-3 mb-4">

                        <div class="col-md-6">

                            <label for="payment_date" class="form-label fw-semibold">
                                Payment Date <span class="text-danger">*</span>
                            </label>

                            <input type="date"
                                   name="payment_date"
                                   id="payment_date"
                                   class="form-control custom-input @error('payment_date') is-invalid @enderror"
                                   value="{{ $paymentDate }}"
                                   required>

                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-md-6">

                            <label for="reference" class="form-label fw-semibold">
                                Reference Number
                            </label>

                            <input type="text"
                                   name="reference"
                                   id="reference"
                                   class="form-control custom-input @error('reference') is-invalid @enderror"
                                   value="{{ old('reference') }}"
                                   maxlength="255"
                                   placeholder="Receipt or transaction number">

                            @error('reference')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                    </div>

                    {{-- Payment Method --}}
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Payment Method <span class="text-danger">*</span>
                        </label>

                        <div class="row g-3">

                            <div class="col-md-4">

                                <label class="method-option {{ $selectedMethod === 'cash' ? 'active' : '' }}">

                                    <input type="radio"
                                           name="payment_method"
                                           value="cash"
                                           class="method-radio"
                                           @checked($selectedMethod === 'cash')
                                           required>

                                    <span class="method-icon cash-icon">
                                        <i class="bi bi-cash-stack"></i>
                                    </span>

                                    <strong>Cash</strong>
                                    <small>Cash transaction</small>

                                    <i class="bi bi-check-circle-fill method-check"></i>

                                </label>

                            </div>

                            <div class="col-md-4">

                                <label class="method-option {{ $selectedMethod === 'bank' ? 'active' : '' }}">

                                    <input type="radio"
                                           name="payment_method"
                                           value="bank"
                                           class="method-radio"
                                           @checked($selectedMethod === 'bank')
                                           required>

                                    <span class="method-icon bank-icon">
                                        <i class="bi bi-bank"></i>
                                    </span>

                                    <strong>Bank</strong>
                                    <small>Bank transfer</small>

                                    <i class="bi bi-check-circle-fill method-check"></i>

                                </label>

                            </div>

                            <div class="col-md-4">

                                <label class="method-option {{ $selectedMethod === 'other' ? 'active' : '' }}">

                                    <input type="radio"
                                           name="payment_method"
                                           value="other"
                                           class="method-radio"
                                           @checked($selectedMethod === 'other')
                                           required>

                                    <span class="method-icon other-icon">
                                        <i class="bi bi-three-dots"></i>
                                    </span>

                                    <strong>Other</strong>
                                    <small>Other payment method</small>

                                    <i class="bi bi-check-circle-fill method-check"></i>

                                </label>

                            </div>

                        </div>

                        @error('payment_method')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- Notes --}}
                    <div>

                        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">

                            <label for="notes" class="form-label fw-semibold mb-0">
                                Notes
                            </label>

                            <span class="text-muted small">
                                <span id="notesCount">0</span> characters
                            </span>

                        </div>

                        <textarea name="notes"
                                  id="notes"
                                  class="form-control custom-input"
                                  rows="4"
                                  maxlength="2000"
                                  placeholder="Add optional transaction notes...">{{ old('notes') }}</textarea>

                        <div class="form-text">
                            Add extra information to make this payment easier to track later.
                        </div>

                    </div>

                </div>

                {{-- Form Footer --}}
                <div class="card-footer bg-white border-top px-4 py-3">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                        <span class="text-muted small">
                            <i class="bi bi-shield-check me-1"></i>
                            Verify details before recording the payment.
                        </span>

                        <div class="d-flex flex-wrap gap-2">

                            <a href="{{ route('payments.index') }}"
                               class="btn btn-light border px-4">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check2-circle me-1"></i>
                                Record Payment
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Payment Preview --}}
        <div class="col-xl-4 col-lg-5">

            <div class="card border-0 shadow-sm payment-preview-card mb-4">

                <div class="preview-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-eye fs-5"></i>
                        <h5 class="fw-bold mb-0">Payment Preview</h5>
                    </div>

                    <p class="mb-0 mt-2">
                        Review the transaction before saving.
                    </p>
                </div>

                <div class="card-body p-4">

                    <span class="preview-label">Transaction Type</span>

                    <div class="d-flex align-items-center gap-2 mb-4 mt-2">
                        <span id="previewTypeIcon" class="preview-type-icon">
                            <i class="bi bi-wallet2"></i>
                        </span>

                        <div>
                            <h6 class="fw-bold mb-1" id="previewType">
                                Select payment type
                            </h6>

                            <span class="text-muted small" id="previewDirection">
                                Transaction direction
                            </span>
                        </div>
                    </div>

                    <div class="preview-amount-box mb-4">

                        <span class="preview-label">Payment Amount</span>

                        <div class="preview-amount mt-2">
                            <span>Rs.</span>
                            <span id="previewAmount">0.00</span>
                        </div>

                    </div>

                    <div class="preview-detail">
                        <span><i class="bi bi-person me-2"></i>Party</span>
                        <strong id="previewParty">Not selected</strong>
                    </div>

                    <div class="preview-detail">
                        <span><i class="bi bi-calendar3 me-2"></i>Date</span>
                        <strong id="previewDate">Not selected</strong>
                    </div>

                    <div class="preview-detail">
                        <span><i class="bi bi-credit-card me-2"></i>Method</span>
                        <strong id="previewMethod">Cash</strong>
                    </div>

                    <div class="preview-detail">
                        <span><i class="bi bi-hash me-2"></i>Reference</span>
                        <strong id="previewReference">Not provided</strong>
                    </div>

                    <hr class="my-4">

                    <div class="preview-note">
                        <i class="bi bi-info-circle me-2"></i>

                        <span>
                            This preview does not save or process a payment.
                            Submit the form to record the transaction.
                        </span>
                    </div>

                </div>

            </div>

            {{-- Helpful Tips --}}
            <div class="card border-0 shadow-sm tips-card">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-lightbulb text-warning fs-5"></i>
                        <h6 class="fw-bold mb-0">Payment Guidelines</h6>
                    </div>

                    <ul class="tips-list mb-0">
                        <li>Choose the correct customer or supplier.</li>
                        <li>Enter the exact transaction amount.</li>
                        <li>Verify the payment date and method.</li>
                        <li>Keep the receipt or reference number if available.</li>
                    </ul>

                </div>

            </div>

        </div>

    </div>

</form>


</div>

<style>
    .record-payment-page {
        color: #1e293b;
    }

    .record-payment-page .page-icon {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 21px;
    }

    .record-payment-page .card {
        border-radius: 17px;
        overflow: hidden;
    }

    .record-payment-page .payment-form-card {
        border-top: 3px solid #4f46e5 !important;
    }

    .record-payment-page .section-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 22px;
        flex-shrink: 0;
    }

    .record-payment-page .form-label {
        color: #334155;
        font-size: 13px;
        margin-bottom: 9px;
    }

    .record-payment-page .custom-input,
    .record-payment-page .amount-input-group .form-control,
    .record-payment-page .amount-input-group .input-group-text {
        min-height: 46px;
        border-color: #dbe3ee;
        border-radius: 10px;
        font-size: 14px;
    }

    .record-payment-page .custom-input:focus,
    .record-payment-page .amount-input-group .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, .09);
    }

    .record-payment-page .amount-input-group .input-group-text {
        display: flex;
        align-items: center;
        border-radius: 10px 0 0 10px;
        background: #eef2ff;
        color: #4338ca;
        font-weight: 700;
    }

    .record-payment-page .amount-input-group .form-control {
        border-radius: 0 10px 10px 0;
    }

    .record-payment-page textarea.custom-input {
        min-height: 110px;
        resize: vertical;
    }

    .record-payment-page .type-option {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        height: 100%;
        min-height: 100px;
        padding: 17px;
        border: 1px solid #dbe3ee;
        border-radius: 14px;
        background: #fff;
        cursor: pointer;
        transition: all .2s ease;
    }

    .record-payment-page .type-option:hover {
        border-color: #a5b4fc;
        background: #fafaff;
    }

    .record-payment-page .type-option.active {
        border-color: #6366f1;
        background: #f5f5ff;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, .06);
    }

    .record-payment-page .type-radio,
    .record-payment-page .method-radio {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .record-payment-page .type-option:focus-within,
    .record-payment-page .method-option:focus-within {
        outline: 2px solid #6366f1;
        outline-offset: 2px;
    }

    .record-payment-page .type-option-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 23px;
        flex-shrink: 0;
    }

    .record-payment-page .customer-type-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .record-payment-page .supplier-type-icon {
        background: #fff1f2;
        color: #e11d48;
    }

    .record-payment-page .type-option-content {
        display: block;
        padding-right: 10px;
    }

    .record-payment-page .type-option-content strong,
    .record-payment-page .type-option-content small {
        display: block;
    }

    .record-payment-page .type-option-content strong {
        margin-bottom: 5px;
        font-size: 13px;
    }

    .record-payment-page .type-option-content small {
        color: #64748b;
        font-size: 11px;
        line-height: 1.5;
    }

    .record-payment-page .type-check {
        position: absolute;
        top: 10px;
        right: 10px;
        display: none;
        color: #4f46e5;
        font-size: 16px;
    }

    .record-payment-page .type-option.active .type-check {
        display: block;
    }

    .record-payment-page .method-option {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        height: 100%;
        min-height: 130px;
        padding: 16px;
        border: 1px solid #dbe3ee;
        border-radius: 13px;
        background: #fff;
        cursor: pointer;
        transition: all .2s ease;
    }

    .record-payment-page .method-option:hover {
        border-color: #a5b4fc;
    }

    .record-payment-page .method-option.active {
        border-color: #6366f1;
        background: #f5f5ff;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, .06);
    }

    .record-payment-page .method-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        border-radius: 11px;
        font-size: 20px;
    }

    .record-payment-page .cash-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .record-payment-page .bank-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .record-payment-page .other-icon {
        background: #f5f3ff;
        color: #7c3aed;
    }

    .record-payment-page .method-option strong {
        font-size: 13px;
        margin-bottom: 4px;
    }

    .record-payment-page .method-option small {
        color: #64748b;
        font-size: 11px;
        line-height: 1.5;
    }

    .record-payment-page .method-check {
        position: absolute;
        top: 10px;
        right: 10px;
        display: none;
        color: #4f46e5;
    }

    .record-payment-page .method-option.active .method-check {
        display: block;
    }

    .record-payment-page .payment-preview-card {
        border-top: 3px solid #4f46e5 !important;
    }

    .record-payment-page .preview-header {
        padding: 22px 24px;
        background: linear-gradient(135deg, #4f46e5, #3730a3);
        color: #fff;
    }

    .record-payment-page .preview-header p {
        color: rgba(255, 255, 255, .8);
        font-size: 12px;
    }

    .record-payment-page .preview-label {
        color: #64748b;
        font-size: 12px;
    }

    .record-payment-page .preview-type-icon {
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 21px;
        flex-shrink: 0;
    }

    .record-payment-page .preview-amount-box {
        padding: 20px;
        border: 1px solid #e0e7ff;
        border-radius: 14px;
        background: #f5f7ff;
    }

    .record-payment-page .preview-amount {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        color: #4338ca;
        font-size: clamp(24px, 2.5vw, 32px);
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .record-payment-page .preview-amount > span:first-child {
        padding-top: 7px;
        font-size: 15px;
    }

    .record-payment-page .preview-detail {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 12px;
    }

    .record-payment-page .preview-detail > span {
        color: #64748b;
        flex-shrink: 0;
    }

    .record-payment-page .preview-detail strong {
        text-align: right;
        overflow-wrap: anywhere;
    }

    .record-payment-page .preview-note {
        display: flex;
        align-items: flex-start;
        padding: 13px;
        border-radius: 11px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 11px;
        line-height: 1.7;
    }

    .record-payment-page .tips-list {
        padding-left: 19px;
        color: #64748b;
        font-size: 12px;
        line-height: 2;
    }

    .record-payment-page .btn {
        min-height: 42px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
    }

    .record-payment-page .btn-primary {
        background: #4f46e5;
        border-color: #4f46e5;
    }

    .record-payment-page .btn-primary:hover {
        background: #4338ca;
        border-color: #4338ca;
    }

    @media (max-width: 576px) {
        .record-payment-page .card-header,
        .record-payment-page .card-body {
            padding-right: 18px !important;
            padding-left: 18px !important;
        }

        .record-payment-page .preview-header {
            padding: 20px;
        }

        .record-payment-page .type-option {
            min-height: 90px;
            padding: 13px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('recordPaymentForm');

    const typeRadios = document.querySelectorAll('.type-radio');
    const methodRadios = document.querySelectorAll('.method-radio');

    const customerBox = document.getElementById('customerBox');
    const supplierBox = document.getElementById('supplierBox');

    const customerSelect = document.getElementById('customer_id');
    const supplierSelect = document.getElementById('supplier_id');

    const amountInput = document.getElementById('amount');
    const dateInput = document.getElementById('payment_date');
    const referenceInput = document.getElementById('reference');
    const notesInput = document.getElementById('notes');

    const previewType = document.getElementById('previewType');
    const previewDirection = document.getElementById('previewDirection');
    const previewTypeIcon = document.getElementById('previewTypeIcon');
    const previewParty = document.getElementById('previewParty');
    const previewAmount = document.getElementById('previewAmount');
    const previewDate = document.getElementById('previewDate');
    const previewMethod = document.getElementById('previewMethod');
    const previewReference = document.getElementById('previewReference');
    const notesCount = document.getElementById('notesCount');

    function getSelectedType() {
        const selected = document.querySelector('.type-radio:checked');
        return selected ? selected.value : '';
    }

    function getSelectedMethod() {
        const selected = document.querySelector('.method-radio:checked');
        return selected ? selected.value : 'cash';
    }

    function updateType() {
        const type = getSelectedType();

        customerBox.classList.toggle('d-none', type === 'supplier');
        supplierBox.classList.toggle('d-none', type !== 'supplier');

        customerSelect.disabled = type !== 'customer';
        supplierSelect.disabled = type !== 'supplier';

        customerSelect.required = type === 'customer';
        supplierSelect.required = type === 'supplier';

        typeRadios.forEach(function (radio) {
            const label = radio.closest('.type-option');
            if (label) {
                label.classList.toggle('active', radio.checked);
            }
        });

        if (type === 'customer') {
            previewType.textContent = 'Customer Payment';
            previewDirection.textContent = 'Money received';
            previewTypeIcon.innerHTML = '<i class="bi bi-arrow-down-left-circle"></i>';
            previewTypeIcon.style.background = '#ecfdf5';
            previewTypeIcon.style.color = '#059669';
        } else if (type === 'supplier') {
            previewType.textContent = 'Supplier Payment';
            previewDirection.textContent = 'Money paid';
            previewTypeIcon.innerHTML = '<i class="bi bi-arrow-up-right-circle"></i>';
            previewTypeIcon.style.background = '#fff1f2';
            previewTypeIcon.style.color = '#e11d48';
        } else {
            previewType.textContent = 'Select payment type';
            previewDirection.textContent = 'Transaction direction';
            previewTypeIcon.innerHTML = '<i class="bi bi-wallet2"></i>';
            previewTypeIcon.style.background = '#eef2ff';
            previewTypeIcon.style.color = '#4f46e5';
        }

        updateParty();
    }

    function updateParty() {
        const type = getSelectedType();
        let party = '';

        if (type === 'customer' && customerSelect.selectedOptions.length) {
            party = customerSelect.selectedOptions[0].text.trim();
        } else if (type === 'supplier' && supplierSelect.selectedOptions.length) {
            party = supplierSelect.selectedOptions[0].text.trim();
        }

        if (!party || (type === 'customer' && !customerSelect.value) ||
            (type === 'supplier' && !supplierSelect.value)) {
            party = 'Not selected';
        }

        previewParty.textContent = party;
    }

    function updateAmount() {
        const amount = Number.parseFloat(amountInput.value);

        previewAmount.textContent = Number.isFinite(amount)
            ? amount.toLocaleString('en-PK', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })
            : '0.00';
    }

    function updateDate() {
        if (!dateInput.value) {
            previewDate.textContent = 'Not selected';
            return;
        }

        const parts = dateInput.value.split('-');

        if (parts.length !== 3) {
            previewDate.textContent = dateInput.value;
            return;
        }

        const date = new Date(
            Number(parts[0]),
            Number(parts[1]) - 1,
            Number(parts[2])
        );

        previewDate.textContent = date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    function updateMethod() {
        const method = getSelectedMethod();

        methodRadios.forEach(function (radio) {
            const label = radio.closest('.method-option');

            if (label) {
                label.classList.toggle('active', radio.checked);
            }
        });

        previewMethod.textContent =
            method.charAt(0).toUpperCase() + method.slice(1);
    }

    function updateReference() {
        previewReference.textContent =
            referenceInput.value.trim() || 'Not provided';
    }

    function updateNotesCount() {
        notesCount.textContent = notesInput.value.length;
    }

    typeRadios.forEach(function (radio) {
        radio.addEventListener('change', updateType);
    });

    methodRadios.forEach(function (radio) {
        radio.addEventListener('change', updateMethod);
    });

    customerSelect.addEventListener('change', updateParty);
    supplierSelect.addEventListener('change', updateParty);

    amountInput.addEventListener('input', updateAmount);
    dateInput.addEventListener('change', updateDate);
    referenceInput.addEventListener('input', updateReference);
    notesInput.addEventListener('input', updateNotesCount);

    form.addEventListener('submit', function (event) {
        const type = getSelectedType();

        if (type === 'customer' && !customerSelect.value) {
            event.preventDefault();
            customerSelect.focus();
        }

        if (type === 'supplier' && !supplierSelect.value) {
            event.preventDefault();
            supplierSelect.focus();
        }
    });

    updateType();
    updateAmount();
    updateDate();
    updateMethod();
    updateReference();
    updateNotesCount();
});
</script>

@endsection
