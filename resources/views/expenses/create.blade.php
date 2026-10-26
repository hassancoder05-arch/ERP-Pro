
@extends('layouts.app')

@section('title', 'Add Expense')

@section('content')

<div class="container-fluid add-expense-page py-3">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div class="d-flex align-items-center gap-3">

            <div class="expense-header-icon">
                <i class="bi bi-receipt-cutoff"></i>
            </div>

            <div>
                <h2 class="fw-bold mb-1">Add New Expense</h2>
                <p class="text-muted mb-0">
                    Record and organize your business expenses.
                </p>
            </div>

        </div>

        <a href="{{ route('expenses.index') }}" class="btn btn-light border back-btn">
            <i class="bi bi-arrow-left me-2"></i>
            Back to Expenses
        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="alert expense-error-alert alert-dismissible fade show mb-4" role="alert">

            <div class="d-flex align-items-start gap-3">
                <i class="bi bi-exclamation-triangle-fill fs-4"></i>

                <div>
                    <h6 class="fw-bold mb-2">Please check the following fields</h6>

                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>

        </div>

    @endif


    {{-- Category Required Notice --}}
    @if($categories->isEmpty())

        <div class="card border-0 category-empty-card">
            <div class="card-body text-center py-5 px-4">

                <div class="empty-category-icon">
                    <i class="bi bi-tags"></i>
                </div>

                <h4 class="fw-bold mt-3">Create an Expense Category First</h4>

                <p class="text-muted mx-auto category-empty-description">
                    Before recording an expense, create a category such as Rent,
                    Utilities, Transport or Office Supplies.
                </p>

                <a href="{{ route('expense-categories.create') }}"
                   class="btn btn-primary mt-2">

                    <i class="bi bi-plus-lg me-2"></i>
                    Create Expense Category

                </a>

                <div class="mt-3">
                    <a href="{{ route('expenses.index') }}" class="text-muted small text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>
                        Back to Expenses
                    </a>
                </div>

            </div>
        </div>

    @else


    <div class="row g-4">

        {{-- Main Form --}}
        <div class="col-xl-8">

            <div class="card expense-form-card border-0">

                <div class="card-body p-4 p-lg-5">

                    <div class="form-section-heading mb-4">

                        <div class="section-icon">
                            <i class="bi bi-clipboard2-plus"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Expense Information</h5>
                            <p class="text-muted small mb-0">
                                Complete the information to record your expense.
                            </p>
                        </div>

                    </div>


                    <form action="{{ route('expenses.store') }}"
                          method="POST"
                          id="createExpenseForm">

                        @csrf


                        {{-- Category --}}
                        <div class="mb-4">

                            <label for="expense_category_id" class="form-label">
                                Expense Category <span class="required-star">*</span>
                            </label>

                            <div class="input-with-icon">

                                <i class="bi bi-tags"></i>

                                <select name="expense_category_id"
                                        id="expense_category_id"
                                        class="form-select @error('expense_category_id') is-invalid @enderror"
                                        required>

                                    <option value="">Select an expense category</option>

                                    @foreach($categories as $category)

                                        <option value="{{ $category->id }}"
                                            @selected(old('expense_category_id') == $category->id)>

                                            {{ $category->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            @error('expense_category_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            <div class="form-text">
                                Choose the category that best describes this expense.
                            </div>

                        </div>


                        {{-- Expense Title --}}
                        <div class="mb-4">

                            <label for="title" class="form-label">
                                Expense Title <span class="required-star">*</span>
                            </label>

                            <div class="input-with-icon">

                                <i class="bi bi-card-heading"></i>

                                <input type="text"
                                       name="title"
                                       id="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}"
                                       placeholder="e.g. Electricity Bill, Office Rent"
                                       maxlength="255"
                                       required>

                            </div>

                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- Amount and Date --}}
                        <div class="row g-4 mb-4">

                            <div class="col-md-6">

                                <label for="amount" class="form-label">
                                    Expense Amount <span class="required-star">*</span>
                                </label>

                                <div class="input-with-icon">

                                    <i class="bi bi-currency-rupee"></i>

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

                                <div class="form-text">
                                    Enter the expense amount in PKR.
                                </div>

                            </div>


                            <div class="col-md-6">

                                <label for="expense_date" class="form-label">
                                    Expense Date <span class="required-star">*</span>
                                </label>

                                <div class="input-with-icon">

                                    <i class="bi bi-calendar-event"></i>

                                    <input type="date"
                                           name="expense_date"
                                           id="expense_date"
                                           class="form-control @error('expense_date') is-invalid @enderror"
                                           value="{{ old('expense_date', now()->format('Y-m-d')) }}"
                                           required>

                                </div>

                                @error('expense_date')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>


                        {{-- Payment Method --}}
                        <div class="mb-4">

                            <label class="form-label">
                                Payment Method <span class="required-star">*</span>
                            </label>

                            @php
                                $selectedMethod = old('payment_method', 'cash');
                            @endphp

                            <div class="row g-3 payment-options">

                                <div class="col-sm-4">

                                    <label class="payment-option {{ $selectedMethod === 'cash' ? 'active' : '' }}">

                                        <input type="radio"
                                               name="payment_method"
                                               value="cash"
                                               @checked($selectedMethod === 'cash')
                                               required>

                                        <span class="payment-option-icon cash-icon">
                                            <i class="bi bi-cash-stack"></i>
                                        </span>

                                        <span class="payment-option-text">
                                            <strong>Cash</strong>
                                            <small>Cash payment</small>
                                        </span>

                                        <span class="payment-check">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </span>

                                    </label>

                                </div>


                                <div class="col-sm-4">

                                    <label class="payment-option {{ $selectedMethod === 'bank' ? 'active' : '' }}">

                                        <input type="radio"
                                               name="payment_method"
                                               value="bank"
                                               @checked($selectedMethod === 'bank')
                                               required>

                                        <span class="payment-option-icon bank-icon">
                                            <i class="bi bi-bank"></i>
                                        </span>

                                        <span class="payment-option-text">
                                            <strong>Bank</strong>
                                            <small>Bank transfer</small>
                                        </span>

                                        <span class="payment-check">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </span>

                                    </label>

                                </div>


                                <div class="col-sm-4">

                                    <label class="payment-option {{ $selectedMethod === 'other' ? 'active' : '' }}">

                                        <input type="radio"
                                               name="payment_method"
                                               value="other"
                                               @checked($selectedMethod === 'other')
                                               required>

                                        <span class="payment-option-icon other-icon">
                                            <i class="bi bi-wallet2"></i>
                                        </span>

                                        <span class="payment-option-text">
                                            <strong>Other</strong>
                                            <small>Other payment</small>
                                        </span>

                                        <span class="payment-check">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </span>

                                    </label>

                                </div>

                            </div>

                            @error('payment_method')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- Description --}}
                        <div class="mb-4">

                            <label for="description" class="form-label">
                                Description
                                <span class="optional-label">(Optional)</span>
                            </label>

                            <textarea name="description"
                                      id="description"
                                      class="form-control description-input @error('description') is-invalid @enderror"
                                      rows="5"
                                      maxlength="2000"
                                      placeholder="Add notes about this expense...">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            <div class="d-flex justify-content-between gap-2 mt-2">
                                <small class="text-muted">
                                    Add any extra information if needed.
                                </small>

                                <small class="text-muted">
                                    <span id="descriptionCount">{{ strlen(old('description', '')) }}</span>/2000
                                </small>
                            </div>

                        </div>


                        {{-- Form Actions --}}
                        <div class="form-actions d-flex flex-wrap justify-content-between align-items-center gap-3 pt-4">

                            <a href="{{ route('expenses.index') }}"
                               class="btn btn-light border cancel-btn">

                                <i class="bi bi-x-lg me-1"></i>
                                Cancel

                            </a>

                            <button type="submit"
                                    class="btn btn-danger save-btn"
                                    id="saveExpenseButton">

                                <i class="bi bi-check2-circle me-2"></i>
                                Save Expense

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- Right Sidebar --}}
        <div class="col-xl-4">

            {{-- Live Preview --}}
            <div class="card preview-card border-0 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center justify-content-between gap-2 mb-4">

                        <div>
                            <h5 class="fw-bold mb-1">Expense Preview</h5>
                            <p class="text-muted small mb-0">
                                Live transaction summary
                            </p>
                        </div>

                        <div class="preview-heading-icon">
                            <i class="bi bi-eye"></i>
                        </div>

                    </div>


                    <div class="preview-amount-box">

                        <span class="preview-label">Total Expense</span>

                        <div class="preview-amount" id="previewAmount">
                            Rs. 0.00
                        </div>

                        <div class="preview-status">
                            <i class="bi bi-circle-fill me-1"></i>
                            Draft entry
                        </div>

                    </div>


                    <div class="preview-details">

                        <div class="preview-detail-row">

                            <span class="preview-detail-icon">
                                <i class="bi bi-card-heading"></i>
                            </span>

                            <div class="flex-grow-1">
                                <small>Expense Title</small>
                                <strong id="previewTitle">Expense title</strong>
                            </div>

                        </div>


                        <div class="preview-detail-row">

                            <span class="preview-detail-icon category-preview-icon">
                                <i class="bi bi-tags"></i>
                            </span>

                            <div class="flex-grow-1">
                                <small>Category</small>
                                <strong id="previewCategory">Not selected</strong>
                            </div>

                        </div>


                        <div class="preview-detail-row">

                            <span class="preview-detail-icon date-preview-icon">
                                <i class="bi bi-calendar3"></i>
                            </span>

                            <div class="flex-grow-1">
                                <small>Expense Date</small>
                                <strong id="previewDate">
                                    {{ now()->format('d M Y') }}
                                </strong>
                            </div>

                        </div>


                        <div class="preview-detail-row">

                            <span class="preview-detail-icon method-preview-icon">
                                <i class="bi bi-credit-card"></i>
                            </span>

                            <div class="flex-grow-1">
                                <small>Payment Method</small>
                                <strong id="previewMethod">
                                    {{ ucfirst($selectedMethod) }}
                                </strong>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Helpful Tips --}}
            <div class="card tips-card border-0 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3 mb-3">

                        <div class="tips-icon">
                            <i class="bi bi-lightbulb"></i>
                        </div>

                        <h6 class="fw-bold mb-0">Expense Recording Tips</h6>

                    </div>

                    <div class="tip-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Select the correct expense category.</span>
                    </div>

                    <div class="tip-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Enter the exact amount paid.</span>
                    </div>

                    <div class="tip-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Use the actual transaction date.</span>
                    </div>

                    <div class="tip-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Choose the payment method used.</span>
                    </div>

                </div>

            </div>


            {{-- Security Note --}}
            <div class="security-note">

                <div class="security-note-icon">
                    <i class="bi bi-shield-check"></i>
                </div>

                <div>
                    <h6 class="fw-bold mb-1">Accurate Records</h6>
                    <p class="mb-0">
                        Review the details before saving to keep your financial records organized.
                    </p>
                </div>

            </div>

        </div>

    </div>

    @endif

</div>


{{-- Page Styles --}}
<style>
    .add-expense-page {
        color: #172033;
    }

    .expense-header-icon {
        width: 58px;
        height: 58px;
        min-width: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #dc2626;
        font-size: 26px;
    }

    .add-expense-page h2 {
        font-size: clamp(1.4rem, 2.5vw, 1.85rem);
        letter-spacing: -0.6px;
    }

    .back-btn,
    .cancel-btn {
        padding: 10px 15px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
    }

    .expense-form-card,
    .preview-card,
    .tips-card {
        border-radius: 19px;
        box-shadow: 0 5px 25px rgba(15, 23, 42, 0.045);
    }

    .form-section-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        padding-bottom: 22px;
        border-bottom: 1px solid #eef0f5;
    }

    .section-icon,
    .preview-heading-icon {
        width: 45px;
        height: 45px;
        min-width: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: #fff1f2;
        color: #dc2626;
        font-size: 21px;
    }

    .form-section-heading h5,
    .preview-card h5 {
        font-size: 16px;
    }

    .form-label {
        display: block;
        margin-bottom: 9px;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .required-star {
        color: #ef4444;
    }

    .optional-label {
        color: #94a3b8;
        font-size: 11px;
        font-weight: 500;
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon > i {
        position: absolute;
        z-index: 2;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 17px;
        pointer-events: none;
    }

    .input-with-icon .form-control,
    .input-with-icon .form-select {
        min-height: 49px;
        padding: 12px 14px 12px 44px;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        background-color: #fff;
        color: #1e293b;
        font-size: 13px;
        box-shadow: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .input-with-icon .form-control:focus,
    .input-with-icon .form-select:focus,
    .description-input:focus {
        border-color: #f87171;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.08);
    }

    .input-with-icon .form-control::placeholder,
    .description-input::placeholder {
        color: #a0aabd;
    }

    .form-text {
        color: #94a3b8;
        font-size: 11px;
    }

    .payment-option {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 85px;
        padding: 13px 10px;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        background: #fff;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .payment-option:hover {
        border-color: #fca5a5;
        background: #fffafa;
    }

    .payment-option.active {
        border-color: #ef4444;
        background: #fff5f5;
        box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.06);
    }

    .payment-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .payment-option-icon {
        width: 39px;
        height: 39px;
        min-width: 39px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        font-size: 19px;
    }

    .cash-icon {
        color: #15803d;
        background: #dcfce7;
    }

    .bank-icon {
        color: #1d4ed8;
        background: #dbeafe;
    }

    .other-icon {
        color: #7c3aed;
        background: #ede9fe;
    }

    .payment-option-text {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .payment-option-text strong {
        color: #334155;
        font-size: 12px;
    }

    .payment-option-text small {
        color: #94a3b8;
        font-size: 10px;
    }

    .payment-check {
        display: none;
        position: absolute;
        top: 7px;
        right: 7px;
        color: #dc2626;
        font-size: 13px;
    }

    .payment-option.active .payment-check {
        display: block;
    }

    .payment-option:focus-within {
        outline: 2px solid #fca5a5;
        outline-offset: 2px;
    }

    .description-input {
        min-height: 130px;
        padding: 14px;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        font-size: 13px;
        line-height: 1.7;
        resize: vertical;
        box-shadow: none;
    }

    .form-actions {
        border-top: 1px solid #eef0f5;
    }

    .save-btn {
        min-height: 45px;
        padding: 11px 21px;
        border-radius: 10px;
        border-color: #dc2626;
        background: #dc2626;
        font-size: 13px;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .save-btn:hover {
        border-color: #b91c1c;
        background: #b91c1c;
        transform: translateY(-1px);
    }

    .save-btn:disabled {
        cursor: wait;
        opacity: 0.75;
        transform: none;
    }

    .expense-error-alert {
        border: 1px solid #fecaca;
        border-radius: 13px;
        background: #fff1f2;
        color: #b91c1c;
    }

    .expense-error-alert li {
        margin-bottom: 4px;
        font-size: 13px;
    }

    .preview-heading-icon {
        background: #fee2e2;
        color: #dc2626;
    }

    .preview-amount-box {
        padding: 23px 20px;
        border: 1px solid #fecaca;
        border-radius: 15px;
        background: linear-gradient(135deg, #fff1f2, #fffafa);
    }

    .preview-label {
        display: block;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }

    .preview-amount {
        margin-top: 8px;
        color: #dc2626;
        font-size: clamp(1.5rem, 2.3vw, 2rem);
        font-weight: 800;
        letter-spacing: -0.7px;
        overflow-wrap: anywhere;
    }

    .preview-status {
        display: inline-flex;
        align-items: center;
        margin-top: 10px;
        padding: 5px 9px;
        border-radius: 20px;
        background: #fee2e2;
        color: #b91c1c;
        font-size: 10px;
        font-weight: 600;
    }

    .preview-status i {
        font-size: 6px;
    }

    .preview-details {
        margin-top: 22px;
    }

    .preview-detail-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .preview-detail-row:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .preview-detail-icon {
        width: 39px;
        height: 39px;
        min-width: 39px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #f1f5f9;
        color: #475569;
        font-size: 17px;
    }

    .category-preview-icon {
        background: #ede9fe;
        color: #7c3aed;
    }

    .date-preview-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .method-preview-icon {
        background: #e0f2fe;
        color: #0284c7;
    }

    .preview-detail-row small {
        display: block;
        margin-bottom: 4px;
        color: #94a3b8;
        font-size: 10px;
    }

    .preview-detail-row strong {
        display: block;
        color: #334155;
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .tips-icon,
    .security-note-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #fef3c7;
        color: #b45309;
        font-size: 19px;
    }

    .tips-card h6 {
        font-size: 14px;
    }

    .tip-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-top: 15px;
        color: #64748b;
        font-size: 11px;
        line-height: 1.7;
    }

    .tip-item i {
        margin-top: 2px;
        color: #16a34a;
    }

    .security-note {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding: 20px;
        border: 1px solid #fecaca;
        border-radius: 16px;
        background: #fff7f7;
    }

    .security-note-icon {
        background: #fee2e2;
        color: #dc2626;
    }

    .security-note h6 {
        color: #991b1b;
        font-size: 13px;
    }

    .security-note p {
        color: #64748b;
        font-size: 11px;
        line-height: 1.8;
    }

    .category-empty-card {
        border-radius: 19px;
        box-shadow: 0 5px 25px rgba(15, 23, 42, 0.045);
    }

    .empty-category-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 75px;
        height: 75px;
        margin: 0 auto;
        border-radius: 22px;
        background: #fff1f2;
        color: #dc2626;
        font-size: 31px;
    }

    .category-empty-description {
        max-width: 440px;
        font-size: 13px;
        line-height: 1.8;
    }

    @media (max-width: 767.98px) {
        .add-expense-page {
            padding-right: 10px;
            padding-left: 10px;
        }

        .expense-header-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            font-size: 22px;
        }

        .back-btn {
            width: 100%;
            text-align: center;
        }

        .expense-form-card .card-body,
        .preview-card .card-body,
        .tips-card .card-body {
            padding: 20px !important;
        }

        .payment-option {
            min-height: 76px;
        }

        .form-actions {
            align-items: stretch !important;
        }

        .form-actions > * {
            flex: 1 1 auto;
            text-align: center;
        }

        .save-btn {
            order: -1;
        }
    }
</style>


{{-- Live Preview Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const titleInput = document.getElementById('title');
    const categoryInput = document.getElementById('expense_category_id');
    const amountInput = document.getElementById('amount');
    const dateInput = document.getElementById('expense_date');
    const descriptionInput = document.getElementById('description');

    const previewTitle = document.getElementById('previewTitle');
    const previewCategory = document.getElementById('previewCategory');
    const previewAmount = document.getElementById('previewAmount');
    const previewDate = document.getElementById('previewDate');
    const previewMethod = document.getElementById('previewMethod');

    const descriptionCount = document.getElementById('descriptionCount');
    const form = document.getElementById('createExpenseForm');
    const saveButton = document.getElementById('saveExpenseButton');

    if (!form) {
        return;
    }

    function updateTitlePreview() {
        previewTitle.textContent = titleInput.value.trim() || 'Expense title';
    }

    function updateCategoryPreview() {
        const selectedOption = categoryInput.options[categoryInput.selectedIndex];

        previewCategory.textContent =
            selectedOption && selectedOption.value
                ? selectedOption.text.trim()
                : 'Not selected';
    }

    function updateAmountPreview() {
        const amount = parseFloat(amountInput.value);

        const formattedAmount = Number.isFinite(amount) && amount >= 0
            ? amount.toLocaleString('en-PK', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })
            : '0.00';

        previewAmount.textContent = 'Rs. ' + formattedAmount;
    }

    function updateDatePreview() {
        if (!dateInput.value) {
            previewDate.textContent = 'Select a date';
            return;
        }

        const parts = dateInput.value.split('-');

        if (parts.length !== 3) {
            previewDate.textContent = 'Select a date';
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

    function updatePaymentPreview() {
        const selected = document.querySelector(
            'input[name="payment_method"]:checked'
        );

        previewMethod.textContent = selected
            ? selected.value.charAt(0).toUpperCase() + selected.value.slice(1)
            : 'Not selected';

        document.querySelectorAll('.payment-option').forEach(function (option) {
            const radio = option.querySelector('input[type="radio"]');

            option.classList.toggle('active', radio.checked);
        });
    }

    function updateDescriptionCount() {
        descriptionCount.textContent = descriptionInput.value.length;
    }

    titleInput.addEventListener('input', updateTitlePreview);
    categoryInput.addEventListener('change', updateCategoryPreview);
    amountInput.addEventListener('input', updateAmountPreview);
    dateInput.addEventListener('change', updateDatePreview);
    descriptionInput.addEventListener('input', updateDescriptionCount);

    document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
        radio.addEventListener('change', updatePaymentPreview);
    });

    form.addEventListener('submit', function () {
        if (!form.checkValidity()) {
            return;
        }

        saveButton.disabled = true;
        saveButton.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving Expense...';
    });

    updateTitlePreview();
    updateCategoryPreview();
    updateAmountPreview();
    updateDatePreview();
    updatePaymentPreview();
    updateDescriptionCount();

});
</script>

@endsection

