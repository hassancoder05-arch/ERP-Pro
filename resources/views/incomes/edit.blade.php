
@extends('layouts.app')

@section('title', 'Edit Income')

@section('content')

<div class="container-fluid edit-income-page py-3">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div class="d-flex align-items-center gap-3">

            <div class="edit-header-icon">
                <i class="bi bi-pencil-square"></i>
            </div>

            <div>
                <h2 class="fw-bold mb-1">Edit Income</h2>
                <p class="text-muted mb-0">
                    Update your income transaction details.
                </p>
            </div>

        </div>

        <a href="{{ route('incomes.show', $income) }}"
           class="btn btn-light border back-btn">

            <i class="bi bi-arrow-left me-2"></i>
            Back to Details

        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="alert custom-error-alert alert-dismissible fade show mb-4" role="alert">

            <div class="d-flex align-items-start gap-3">

                <i class="bi bi-exclamation-triangle-fill fs-4"></i>

                <div>
                    <h6 class="fw-bold mb-2">Please correct the following errors</h6>

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


    <div class="row g-4">

        {{-- Main Form --}}
        <div class="col-xl-8">

            <div class="card form-card border-0">

                <div class="card-body p-4 p-lg-5">

                    <div class="form-section-heading mb-4">

                        <div class="section-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Income Information</h5>
                            <p class="text-muted small mb-0">
                                Make changes to the fields below.
                            </p>
                        </div>

                    </div>


                    <form action="{{ route('incomes.update', $income) }}"
                          method="POST"
                          id="editIncomeForm">

                        @csrf
                        @method('PUT')


                        {{-- Income Title --}}
                        <div class="mb-4">

                            <label for="title" class="form-label">
                                Income Title <span class="required-star">*</span>
                            </label>

                            <div class="input-with-icon">

                                <i class="bi bi-card-heading"></i>

                                <input type="text"
                                       name="title"
                                       id="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       placeholder="e.g. Product Sales, Service Payment"
                                       value="{{ old('title', $income->title) }}"
                                       maxlength="255"
                                       required>

                            </div>

                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            <div class="form-text">
                                Enter a short and clear name for this income.
                            </div>

                        </div>


                        {{-- Amount and Date --}}
                        <div class="row g-4 mb-4">

                            <div class="col-md-6">

                                <label for="amount" class="form-label">
                                    Income Amount <span class="required-star">*</span>
                                </label>

                                <div class="input-with-icon amount-input">

                                    <i class="bi bi-currency-rupee"></i>

                                    <input type="number"
                                           name="amount"
                                           id="amount"
                                           class="form-control @error('amount') is-invalid @enderror"
                                           placeholder="0.00"
                                           value="{{ old('amount', $income->amount) }}"
                                           min="0.01"
                                           step="0.01"
                                           required>

                                </div>

                                @error('amount')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror

                            </div>


                            <div class="col-md-6">

                                <label for="income_date" class="form-label">
                                    Income Date <span class="required-star">*</span>
                                </label>

                                <div class="input-with-icon">

                                    <i class="bi bi-calendar-event"></i>

                                    <input type="date"
                                           name="income_date"
                                           id="income_date"
                                           class="form-control @error('income_date') is-invalid @enderror"
                                           value="{{ old('income_date', $income->income_date ? \Illuminate\Support\Carbon::parse($income->income_date)->format('Y-m-d') : '') }}"
                                           required>

                                </div>

                                @error('income_date')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>


                        {{-- Payment Method --}}
                        <div class="mb-4">

                            <label class="form-label">
                                Payment Method <span class="required-star">*</span>
                            </label>

                            <div class="row g-3 payment-options">

                                @php
                                    $selectedMethod = old('payment_method', $income->payment_method ?? 'cash');
                                @endphp

                                <div class="col-sm-4">

                                    <label class="payment-option
                                        {{ $selectedMethod === 'cash' ? 'active' : '' }}">

                                        <input type="radio"
                                               name="payment_method"
                                               value="cash"
                                               {{ $selectedMethod === 'cash' ? 'checked' : '' }}
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

                                    <label class="payment-option
                                        {{ $selectedMethod === 'bank' ? 'active' : '' }}">

                                        <input type="radio"
                                               name="payment_method"
                                               value="bank"
                                               {{ $selectedMethod === 'bank' ? 'checked' : '' }}
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

                                    <label class="payment-option
                                        {{ $selectedMethod === 'other' ? 'active' : '' }}">

                                        <input type="radio"
                                               name="payment_method"
                                               value="other"
                                               {{ $selectedMethod === 'other' ? 'checked' : '' }}
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
                                      placeholder="Add notes or details about this income...">{{ old('description', $income->description) }}</textarea>

                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            <div class="d-flex justify-content-between mt-2">
                                <small class="text-muted">
                                    Include any useful transaction notes.
                                </small>

                                <small class="text-muted">
                                    <span id="descriptionCount">0</span>/2000
                                </small>
                            </div>

                        </div>


                        {{-- Form Actions --}}
                        <div class="form-actions d-flex flex-wrap justify-content-between align-items-center gap-3 pt-4">

                            <a href="{{ route('incomes.show', $income) }}"
                               class="btn btn-light border cancel-btn">

                                <i class="bi bi-x-lg me-1"></i>
                                Cancel

                            </a>

                            <button type="submit"
                                    class="btn btn-primary save-btn"
                                    id="updateIncomeButton">

                                <i class="bi bi-check2-circle me-2"></i>
                                Update Income

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

                    <div class="d-flex align-items-center justify-content-between mb-4">

                        <div>
                            <h5 class="fw-bold mb-1">Income Preview</h5>
                            <p class="text-muted small mb-0">
                                Review your updated details.
                            </p>
                        </div>

                        <div class="preview-heading-icon">
                            <i class="bi bi-eye"></i>
                        </div>

                    </div>


                    <div class="preview-amount-box">

                        <span class="preview-label">Income Amount</span>

                        <div class="preview-amount" id="previewAmount">
                            Rs. {{ number_format((float) old('amount', $income->amount), 2) }}
                        </div>

                        <div class="preview-status">
                            <i class="bi bi-arrow-repeat me-1"></i>
                            Live preview
                        </div>

                    </div>


                    <div class="preview-details">

                        <div class="preview-detail-row">

                            <span class="preview-detail-icon">
                                <i class="bi bi-card-heading"></i>
                            </span>

                            <div class="flex-grow-1">
                                <small>Income Title</small>
                                <strong id="previewTitle">
                                    {{ old('title', $income->title) ?: 'Income title' }}
                                </strong>
                            </div>

                        </div>


                        <div class="preview-detail-row">

                            <span class="preview-detail-icon date-preview-icon">
                                <i class="bi bi-calendar3"></i>
                            </span>

                            <div class="flex-grow-1">
                                <small>Income Date</small>
                                <strong id="previewDate">
                                    {{ $income->income_date
                                        ? \Illuminate\Support\Carbon::parse(old('income_date', $income->income_date))->format('d M Y')
                                        : 'Select a date' }}
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
                                    {{ ucfirst(old('payment_method', $income->payment_method ?? 'cash')) }}
                                </strong>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Existing Record --}}
            <div class="card record-card border-0 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3 mb-3">

                        <div class="record-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <div>
                            <h6 class="fw-bold mb-1">Existing Record</h6>
                            <small class="text-muted">Record information</small>
                        </div>

                    </div>

                    <div class="record-info-row">
                        <span>Record ID</span>
                        <strong>#{{ $income->id }}</strong>
                    </div>

                    <div class="record-info-row">
                        <span>Created On</span>
                        <strong>
                            {{ $income->created_at
                                ? $income->created_at->format('d M Y')
                                : '—' }}
                        </strong>
                    </div>

                    <div class="record-info-row">
                        <span>Last Updated</span>
                        <strong>
                            {{ $income->updated_at
                                ? $income->updated_at->format('d M Y')
                                : '—' }}
                        </strong>
                    </div>

                </div>

            </div>


            {{-- Helpful Note --}}
            <div class="helpful-note">

                <div class="helpful-note-icon">
                    <i class="bi bi-lightbulb"></i>
                </div>

                <div>
                    <h6 class="fw-bold mb-2">Before Updating</h6>

                    <p class="mb-0">
                        Review the amount, date and payment method before saving.
                        Your changes will update this existing income record.
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>


{{-- Page Styling --}}
<style>
    .edit-income-page {
        color: #172033;
    }

    .edit-header-icon {
        width: 58px;
        height: 58px;
        min-width: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 17px;
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        color: #4338ca;
        font-size: 26px;
    }

    .edit-income-page h2 {
        font-size: clamp(1.45rem, 2.5vw, 1.9rem);
        letter-spacing: -0.6px;
    }

    .back-btn,
    .cancel-btn {
        border-radius: 10px;
        padding: 10px 15px;
        font-size: 13px;
        font-weight: 600;
    }

    .form-card,
    .preview-card,
    .record-card {
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
    .preview-heading-icon,
    .record-icon {
        width: 45px;
        height: 45px;
        min-width: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        background: #eef2ff;
        color: #4f46e5;
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

    .input-with-icon .form-control {
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
    .description-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.09);
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
        border-color: #a5b4fc;
        background: #fafaff;
    }

    .payment-option.active {
        border-color: #6366f1;
        background: #f5f5ff;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.07);
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
        color: #4f46e5;
        font-size: 13px;
    }

    .payment-option.active .payment-check {
        display: block;
    }

    .payment-option:focus-within {
        outline: 2px solid #a5b4fc;
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
        border-color: #4f46e5;
        background: #4f46e5;
        font-size: 13px;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .save-btn:hover {
        border-color: #4338ca;
        background: #4338ca;
        transform: translateY(-1px);
    }

    .save-btn:disabled {
        cursor: wait;
        opacity: 0.75;
        transform: none;
    }

    .custom-error-alert {
        border: 1px solid #fecaca;
        border-radius: 13px;
        background: #fff1f2;
        color: #b91c1c;
    }

    .custom-error-alert li {
        margin-bottom: 4px;
        font-size: 13px;
    }

    .preview-heading-icon {
        background: #dcfce7;
        color: #15803d;
    }

    .preview-amount-box {
        padding: 23px 20px;
        border: 1px solid #d1fae5;
        border-radius: 15px;
        background: linear-gradient(135deg, #f0fdf4, #f8fffb);
    }

    .preview-label {
        display: block;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }

    .preview-amount {
        margin-top: 8px;
        color: #15803d;
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
        background: #dcfce7;
        color: #15803d;
        font-size: 10px;
        font-weight: 600;
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

    .record-icon {
        background: #f1f5f9;
        color: #475569;
    }

    .record-info-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 13px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 12px;
    }

    .record-info-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .record-info-row span {
        color: #64748b;
    }

    .record-info-row strong {
        color: #1e293b;
        text-align: right;
    }

    .helpful-note {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        padding: 20px;
        border: 1px solid #e0e7ff;
        border-radius: 16px;
        background: #f5f7ff;
    }

    .helpful-note-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #e0e7ff;
        color: #4f46e5;
        font-size: 18px;
    }

    .helpful-note h6 {
        color: #3730a3;
        font-size: 13px;
    }

    .helpful-note p {
        color: #64748b;
        font-size: 11px;
        line-height: 1.8;
    }

    @media (max-width: 767.98px) {
        .edit-income-page {
            padding-right: 10px;
            padding-left: 10px;
        }

        .edit-header-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            font-size: 22px;
        }

        .form-card .card-body,
        .preview-card .card-body,
        .record-card .card-body {
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
    const amountInput = document.getElementById('amount');
    const dateInput = document.getElementById('income_date');
    const descriptionInput = document.getElementById('description');

    const previewTitle = document.getElementById('previewTitle');
    const previewAmount = document.getElementById('previewAmount');
    const previewDate = document.getElementById('previewDate');
    const previewMethod = document.getElementById('previewMethod');
    const descriptionCount = document.getElementById('descriptionCount');

    const form = document.getElementById('editIncomeForm');
    const updateButton = document.getElementById('updateIncomeButton');

    function updateTitlePreview() {
        const title = titleInput.value.trim();

        previewTitle.textContent = title || 'Income title';
    }

    function updateAmountPreview() {
        const amount = parseFloat(amountInput.value);

        previewAmount.textContent = 'Rs. ' + (
            Number.isFinite(amount) && amount >= 0
                ? amount.toLocaleString('en-PK', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
                : '0.00'
        );
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

        updateButton.disabled = true;
        updateButton.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Updating Income...';
    });

    updateTitlePreview();
    updateAmountPreview();
    updateDatePreview();
    updatePaymentPreview();
    updateDescriptionCount();

});
</script>

@endsection

