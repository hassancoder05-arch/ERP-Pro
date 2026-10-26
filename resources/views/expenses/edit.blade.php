@extends('layouts.app')

@section('title', 'Edit Expense')

@section('content')

@php
$selectedMethod = old('payment_method', $expense->payment_method ?? 'cash');
$currentAmount = old('amount', $expense->amount);
$currentDate = old(
'expense_date',
$expense->expense_date
? \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d')
: ''
);
@endphp

<div class="container-fluid py-4 edit-expense-page">


{{-- Page Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="page-icon">
                <i class="bi bi-pencil-square"></i>
            </span>

            <span class="text-uppercase small fw-semibold text-danger">
                Finance Management
            </span>
        </div>

        <h2 class="fw-bold mb-1">Edit Expense</h2>

        <p class="text-muted mb-0">
            Update expense details and keep your financial records accurate.
        </p>
    </div>

    <a href="{{ route('expenses.show', $expense) }}"
       class="btn btn-light border px-3">
        <i class="bi bi-arrow-left me-1"></i>
        Back to Details
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

<form action="{{ route('expenses.update', $expense) }}"
      method="POST"
      id="editExpenseForm">

    @csrf
    @method('PUT')

    <div class="row g-4">

        {{-- Main Form --}}
        <div class="col-xl-8 col-lg-7">

            <div class="card border-0 shadow-sm form-card">

                <div class="card-header bg-white border-0 px-4 pt-4 pb-0">
                    <div class="d-flex align-items-center gap-3">

                        <div class="section-icon">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Expense Information</h5>
                            <p class="text-muted small mb-0">
                                Edit the fields below to update this expense.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="card-body p-4">

                    {{-- Category --}}
                    <div class="mb-4">

                        <label for="expense_category_id" class="form-label fw-semibold">
                            Expense Category <span class="text-danger">*</span>
                        </label>

                        <select name="expense_category_id"
                                id="expense_category_id"
                                class="form-select custom-input @error('expense_category_id') is-invalid @enderror"
                                required>

                            <option value="">Select expense category</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    @selected((string) old('expense_category_id', $expense->expense_category_id) === (string) $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>

                        @error('expense_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if($categories->isEmpty())
                            <div class="form-text text-danger">
                                No expense categories available.
                                <a href="{{ route('expense-categories.create') }}">
                                    Create a category
                                </a>
                                before updating this expense.
                            </div>
                        @endif

                    </div>

                    {{-- Title --}}
                    <div class="mb-4">

                        <label for="title" class="form-label fw-semibold">
                            Expense Title <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="title"
                               id="title"
                               class="form-control custom-input @error('title') is-invalid @enderror"
                               value="{{ old('title', $expense->title) }}"
                               placeholder="e.g. Office rent, electricity bill"
                               maxlength="255"
                               required>

                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- Amount and Date --}}
                    <div class="row g-3 mb-4">

                        <div class="col-md-6">

                            <label for="amount" class="form-label fw-semibold">
                                Amount (Rs.) <span class="text-danger">*</span>
                            </label>

                            <div class="input-group input-group-lg custom-input-group">
                                <span class="input-group-text">Rs.</span>

                                <input type="number"
                                       name="amount"
                                       id="amount"
                                       class="form-control @error('amount') is-invalid @enderror"
                                       value="{{ $currentAmount }}"
                                       min="0.01"
                                       step="0.01"
                                       placeholder="0.00"
                                       required>
                            </div>

                            @error('amount')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-md-6">

                            <label for="expense_date" class="form-label fw-semibold">
                                Expense Date <span class="text-danger">*</span>
                            </label>

                            <input type="date"
                                   name="expense_date"
                                   id="expense_date"
                                   class="form-control custom-input @error('expense_date') is-invalid @enderror"
                                   value="{{ $currentDate }}"
                                   required>

                            @error('expense_date')
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
                                <label class="payment-option {{ $selectedMethod === 'cash' ? 'active' : '' }}">

                                    <input type="radio"
                                           name="payment_method"
                                           value="cash"
                                           class="payment-radio"
                                           @checked($selectedMethod === 'cash')
                                           required>

                                    <span class="payment-option-content">
                                        <span class="payment-option-icon cash-icon">
                                            <i class="bi bi-cash-stack"></i>
                                        </span>

                                        <span>
                                            <strong>Cash</strong>
                                            <small>Cash payment</small>
                                        </span>
                                    </span>

                                    <i class="bi bi-check-circle-fill payment-check"></i>
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label class="payment-option {{ $selectedMethod === 'bank' ? 'active' : '' }}">

                                    <input type="radio"
                                           name="payment_method"
                                           value="bank"
                                           class="payment-radio"
                                           @checked($selectedMethod === 'bank')
                                           required>

                                    <span class="payment-option-content">
                                        <span class="payment-option-icon bank-icon">
                                            <i class="bi bi-bank"></i>
                                        </span>

                                        <span>
                                            <strong>Bank</strong>
                                            <small>Bank transfer</small>
                                        </span>
                                    </span>

                                    <i class="bi bi-check-circle-fill payment-check"></i>
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label class="payment-option {{ $selectedMethod === 'other' ? 'active' : '' }}">

                                    <input type="radio"
                                           name="payment_method"
                                           value="other"
                                           class="payment-radio"
                                           @checked($selectedMethod === 'other')
                                           required>

                                    <span class="payment-option-content">
                                        <span class="payment-option-icon other-icon">
                                            <i class="bi bi-three-dots"></i>
                                        </span>

                                        <span>
                                            <strong>Other</strong>
                                            <small>Other method</small>
                                        </span>
                                    </span>

                                    <i class="bi bi-check-circle-fill payment-check"></i>
                                </label>
                            </div>

                        </div>

                        @error('payment_method')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- Description --}}
                    <div class="mb-2">

                        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                            <label for="description" class="form-label fw-semibold mb-0">
                                Description
                            </label>

                            <span class="text-muted small">
                                <span id="descriptionCount">0</span> characters
                            </span>
                        </div>

                        <textarea name="description"
                                  id="description"
                                  class="form-control custom-input"
                                  rows="4"
                                  maxlength="2000"
                                  placeholder="Add notes or additional information about this expense...">{{ old('description', $expense->description) }}</textarea>

                        <div class="form-text">
                            Add any useful details to help identify this expense later.
                        </div>

                    </div>

                </div>

                {{-- Form Footer --}}
                <div class="card-footer bg-white border-top px-4 py-3">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                        <span class="text-muted small">
                            <i class="bi bi-shield-check me-1"></i>
                            Review your changes before saving.
                        </span>

                        <div class="d-flex flex-wrap gap-2">

                            <a href="{{ route('expenses.show', $expense) }}"
                               class="btn btn-light border px-4">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary px-4" id="updateExpenseBtn">
                                <i class="bi bi-check2-circle me-1"></i>
                                Update Expense
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Live Preview --}}
        <div class="col-xl-4 col-lg-5">

            <div class="card border-0 shadow-sm preview-card mb-4">

                <div class="preview-header">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-eye fs-5"></i>
                        <h5 class="fw-bold mb-0">Expense Preview</h5>
                    </div>

                    <p class="mb-0 mt-2">
                        Preview updates as you edit the form.
                    </p>
                </div>

                <div class="card-body p-4">

                    <span class="preview-label">Expense Title</span>

                    <h5 class="fw-bold mb-4" id="previewTitle">
                        {{ old('title', $expense->title) ?: 'Expense title' }}
                    </h5>

                    <div class="preview-amount-box mb-4">

                        <span class="preview-label">Updated Amount</span>

                        <div class="preview-amount mt-2">
                            <span>Rs.</span>
                            <span id="previewAmount">
                                {{ number_format((float) $currentAmount, 2) }}
                            </span>
                        </div>

                    </div>

                    <div class="preview-detail">
                        <span><i class="bi bi-grid me-2"></i>Category</span>
                        <strong id="previewCategory">
                            @php
                                $selectedCategory = $categories->firstWhere(
                                    'id',
                                    old('expense_category_id', $expense->expense_category_id)
                                );
                            @endphp

                            {{ $selectedCategory->name ?? 'Not selected' }}
                        </strong>
                    </div>

                    <div class="preview-detail">
                        <span><i class="bi bi-calendar3 me-2"></i>Date</span>
                        <strong id="previewDate">
                            {{ $currentDate ? \Carbon\Carbon::parse($currentDate)->format('d M Y') : 'Not selected' }}
                        </strong>
                    </div>

                    <div class="preview-detail">
                        <span><i class="bi bi-credit-card me-2"></i>Payment</span>
                        <strong id="previewMethod" class="text-capitalize">
                            {{ $selectedMethod ?: 'Not selected' }}
                        </strong>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex align-items-start gap-2 text-muted small">
                        <i class="bi bi-info-circle text-primary fs-5"></i>

                        <p class="mb-0">
                            This preview is for reference. Your changes are saved only after you select
                            <strong>Update Expense</strong>.
                        </p>
                    </div>

                </div>

            </div>

            {{-- Helpful Tips --}}
            <div class="card border-0 shadow-sm tips-card">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-lightbulb text-warning fs-5"></i>
                        <h6 class="fw-bold mb-0">Helpful Tips</h6>
                    </div>

                    <ul class="tips-list mb-0">
                        <li>Choose the correct expense category.</li>
                        <li>Enter the exact amount paid.</li>
                        <li>Verify the transaction date.</li>
                        <li>Keep a useful description for future reference.</li>
                    </ul>

                </div>

            </div>

        </div>

    </div>

</form>


</div>

<style>
    .edit-expense-page {
        color: #1e293b;
    }

    .edit-expense-page .page-icon {
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

    .edit-expense-page .card {
        border-radius: 17px;
        overflow: hidden;
    }

    .edit-expense-page .form-card {
        border-top: 3px solid #e11d48 !important;
    }

    .edit-expense-page .section-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: #fff1f2;
        color: #e11d48;
        font-size: 22px;
        flex-shrink: 0;
    }

    .edit-expense-page .form-label {
        color: #334155;
        font-size: 13px;
        margin-bottom: 9px;
    }

    .edit-expense-page .custom-input,
    .edit-expense-page .custom-input-group .form-control,
    .edit-expense-page .custom-input-group .input-group-text {
        min-height: 46px;
        border-color: #dbe3ee;
        border-radius: 10px;
        font-size: 14px;
    }

    .edit-expense-page .custom-input:focus,
    .edit-expense-page .custom-input-group .form-control:focus {
        border-color: #e11d48;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, .09);
    }

    .edit-expense-page .custom-input-group .input-group-text {
        display: flex;
        align-items: center;
        background: #fff1f2;
        color: #be123c;
        font-weight: 700;
        border-radius: 10px 0 0 10px;
    }

    .edit-expense-page .custom-input-group .form-control {
        border-radius: 0 10px 10px 0;
    }

    .edit-expense-page textarea.custom-input {
        min-height: 120px;
        resize: vertical;
    }

    .edit-expense-page .payment-option {
        position: relative;
        display: block;
        height: 100%;
        padding: 14px;
        border: 1px solid #dbe3ee;
        border-radius: 13px;
        background: #fff;
        cursor: pointer;
        transition: border-color .2s ease, background .2s ease;
    }

    .edit-expense-page .payment-option:hover {
        border-color: #fda4af;
        background: #fffafa;
    }

    .edit-expense-page .payment-option.active {
        border-color: #e11d48;
        background: #fff5f6;
        box-shadow: 0 0 0 2px rgba(225, 29, 72, .06);
    }

    .edit-expense-page .payment-radio {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .edit-expense-page .payment-option:focus-within {
        outline: 2px solid #e11d48;
        outline-offset: 2px;
    }

    .edit-expense-page .payment-option-content {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .edit-expense-page .payment-option-content strong,
    .edit-expense-page .payment-option-content small {
        display: block;
    }

    .edit-expense-page .payment-option-content strong {
        font-size: 13px;
        margin-bottom: 3px;
    }

    .edit-expense-page .payment-option-content small {
        color: #64748b;
        font-size: 11px;
    }

    .edit-expense-page .payment-option-icon {
        width: 39px;
        height: 39px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        font-size: 19px;
        flex-shrink: 0;
    }

    .edit-expense-page .cash-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .edit-expense-page .bank-icon {
        background: #eff6ff;
        color: #2563eb;
    }

    .edit-expense-page .other-icon {
        background: #f5f3ff;
        color: #7c3aed;
    }

    .edit-expense-page .payment-check {
        position: absolute;
        top: 8px;
        right: 8px;
        display: none;
        color: #e11d48;
        font-size: 15px;
    }

    .edit-expense-page .payment-option.active .payment-check {
        display: block;
    }

    .edit-expense-page .preview-card {
        border-top: 3px solid #e11d48 !important;
    }

    .edit-expense-page .preview-header {
        padding: 22px 24px;
        background: linear-gradient(135deg, #e11d48, #be123c);
        color: #fff;
    }

    .edit-expense-page .preview-header p {
        color: rgba(255, 255, 255, .8);
        font-size: 12px;
    }

    .edit-expense-page .preview-label {
        color: #64748b;
        font-size: 12px;
    }

    .edit-expense-page .preview-amount-box {
        padding: 19px;
        border: 1px solid #ffe4e6;
        border-radius: 13px;
        background: #fff7f8;
    }

    .edit-expense-page .preview-amount {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        color: #e11d48;
        font-size: clamp(23px, 2.5vw, 30px);
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .edit-expense-page .preview-amount > span:first-child {
        font-size: 15px;
        padding-top: 7px;
    }

    .edit-expense-page .preview-detail {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 12px;
    }

    .edit-expense-page .preview-detail > span {
        color: #64748b;
        flex-shrink: 0;
    }

    .edit-expense-page .preview-detail strong {
        text-align: right;
        overflow-wrap: anywhere;
    }

    .edit-expense-page .tips-list {
        padding-left: 19px;
        color: #64748b;
        font-size: 12px;
        line-height: 2;
    }

    .edit-expense-page .btn {
        min-height: 42px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
    }

    .edit-expense-page .btn-primary {
        background: #4f46e5;
        border-color: #4f46e5;
    }

    .edit-expense-page .btn-primary:hover {
        background: #4338ca;
        border-color: #4338ca;
    }

    @media (max-width: 576px) {
        .edit-expense-page .card-body {
            padding: 20px !important;
        }

        .edit-expense-page .preview-header {
            padding: 20px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const titleInput = document.getElementById('title');
    const amountInput = document.getElementById('amount');
    const categoryInput = document.getElementById('expense_category_id');
    const dateInput = document.getElementById('expense_date');
    const descriptionInput = document.getElementById('description');
    const paymentInputs = document.querySelectorAll('.payment-radio');

    const previewTitle = document.getElementById('previewTitle');
    const previewAmount = document.getElementById('previewAmount');
    const previewCategory = document.getElementById('previewCategory');
    const previewDate = document.getElementById('previewDate');
    const previewMethod = document.getElementById('previewMethod');
    const descriptionCount = document.getElementById('descriptionCount');

    function updateTitle() {
        previewTitle.textContent = titleInput.value.trim() || 'Expense title';
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

    function updateCategory() {
        const option = categoryInput.options[categoryInput.selectedIndex];
        previewCategory.textContent =
            option && option.value ? option.text.trim() : 'Not selected';
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

    function updatePayment() {
        paymentInputs.forEach(function (input) {
            const card = input.closest('.payment-option');

            if (card) {
                card.classList.toggle('active', input.checked);
            }

            if (input.checked) {
                previewMethod.textContent =
                    input.value.charAt(0).toUpperCase() + input.value.slice(1);
            }
        });
    }

    function updateDescriptionCount() {
        descriptionCount.textContent = descriptionInput.value.length;
    }

    titleInput.addEventListener('input', updateTitle);
    amountInput.addEventListener('input', updateAmount);
    categoryInput.addEventListener('change', updateCategory);
    dateInput.addEventListener('change', updateDate);
    descriptionInput.addEventListener('input', updateDescriptionCount);

    paymentInputs.forEach(function (input) {
        input.addEventListener('change', updatePayment);
    });

    updateTitle();
    updateAmount();
    updateCategory();
    updateDate();
    updatePayment();
    updateDescriptionCount();
});
</script>

@endsection
