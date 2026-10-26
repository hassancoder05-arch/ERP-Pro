@extends('layouts.app')

@section('title', 'Add Customer')

@section('content')

<style>
    /* =====================================
       ERP PRO - ADD CUSTOMER
    ===================================== */

    .customer-create-page {
        --cc-primary: #6366f1;
        --cc-primary-dark: #4f46e5;
        --cc-text: #172033;
        --cc-muted: #64748b;
        --cc-border: #e2e8f0;
        color: var(--cc-text);
    }

    .customer-create-page .page-heading {
        font-size: clamp(1.45rem, 2.5vw, 1.9rem);
        font-weight: 800;
        letter-spacing: -0.7px;
    }

    .customer-create-page .page-subtitle {
        color: var(--cc-muted);
        font-size: 0.9rem;
    }

    /* Header */

    .customer-create-page .back-button {
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--cc-border);
        border-radius: 14px;
        color: #475569;
        background: #fff;
        font-size: 1.15rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .customer-create-page .back-button:hover {
        color: var(--cc-primary);
        border-color: #c7d2fe;
        background: #eef2ff;
        transform: translateX(-2px);
    }

    .customer-create-page .header-icon {
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        color: #fff;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.22);
        font-size: 1.5rem;
    }

    .customer-create-page .header-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 13px;
        border: 1px solid #c7d2fe;
        border-radius: 10px;
        color: #4f46e5;
        background: #eef2ff;
        font-size: 0.78rem;
        font-weight: 750;
    }

    /* Main form card */

    .customer-create-page .form-card {
        overflow: hidden;
        border: 1px solid #e8edf5;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 8px 35px rgba(15, 23, 42, 0.045);
    }

    .customer-create-page .form-card-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 23px 27px;
        border-bottom: 1px solid #eef2f7;
        background: linear-gradient(120deg, #fff 0%, #f8faff 100%);
    }

    .customer-create-page .form-card-header h5 {
        margin: 0 0 4px;
        font-size: 1rem;
        font-weight: 800;
    }

    .customer-create-page .form-card-header p {
        margin: 0;
        color: var(--cc-muted);
        font-size: 0.82rem;
    }

    .customer-create-page .form-card-body {
        padding: 28px;
    }

    /* Sections */

    .customer-create-page .form-section {
        margin-bottom: 30px;
    }

    .customer-create-page .form-section:last-of-type {
        margin-bottom: 0;
    }

    .customer-create-page .section-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 23px;
    }

    .customer-create-page .section-icon {
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 1.2rem;
    }

    .customer-create-page .section-icon-purple {
        color: #6366f1;
        background: #eef2ff;
    }

    .customer-create-page .section-icon-green {
        color: #059669;
        background: #ecfdf5;
    }

    .customer-create-page .section-icon-orange {
        color: #d97706;
        background: #fffbeb;
    }

    .customer-create-page .section-title {
        margin: 0 0 4px;
        color: #172033;
        font-size: 0.96rem;
        font-weight: 800;
    }

    .customer-create-page .section-description {
        margin: 0;
        color: #94a3b8;
        font-size: 0.78rem;
    }

    .customer-create-page .section-divider {
        margin: 29px 0;
        border: 0;
        border-top: 1px solid #e9edf5;
        opacity: 1;
    }

    /* Form controls */

    .customer-create-page .form-label {
        margin-bottom: 8px;
        color: #334155;
        font-size: 0.83rem;
        font-weight: 750;
    }

    .customer-create-page .required-star {
        color: #ef4444;
    }

    .customer-create-page .form-control,
    .customer-create-page .form-select {
        min-height: 46px;
        border: 1px solid #dfe5ef;
        border-radius: 11px;
        color: #172033;
        background-color: #fff;
        font-size: 0.87rem;
        box-shadow: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .customer-create-page .form-control {
        padding: 11px 13px;
    }

    .customer-create-page .form-select {
        padding: 11px 36px 11px 13px;
    }

    .customer-create-page .form-control::placeholder {
        color: #a0aec0;
    }

    .customer-create-page .form-control:focus,
    .customer-create-page .form-select:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.10);
    }

    .customer-create-page textarea.form-control {
        min-height: 125px;
        resize: vertical;
        line-height: 1.7;
    }

    .customer-create-page .input-group-text {
        min-width: 54px;
        justify-content: center;
        border: 1px solid #dfe5ef;
        border-right: 0;
        border-radius: 11px 0 0 11px;
        color: #64748b;
        background: #f8fafc;
        font-size: 0.84rem;
        font-weight: 750;
    }

    .customer-create-page .input-group .form-control {
        border-radius: 0 11px 11px 0;
    }

    .customer-create-page .field-hint {
        margin-top: 7px;
        color: #94a3b8;
        font-size: 0.75rem;
        line-height: 1.5;
    }

    .customer-create-page .field-icon {
        margin-right: 5px;
        color: #94a3b8;
    }

    /* Status information */

    .customer-create-page .status-info {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        margin-top: 20px;
        padding: 14px 16px;
        border: 1px solid #dbeafe;
        border-radius: 12px;
        color: #1d4ed8;
        background: #eff6ff;
        font-size: 0.8rem;
        line-height: 1.6;
    }

    .customer-create-page .status-info i {
        margin-top: 2px;
        font-size: 1rem;
    }

    /* Validation errors */

    .customer-create-page .validation-card {
        padding: 18px 20px;
        border: 1px solid #fecaca;
        border-radius: 14px;
        color: #991b1b;
        background: #fef2f2;
    }

    .customer-create-page .validation-card .validation-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 10px;
        font-size: 0.9rem;
        font-weight: 800;
    }

    .customer-create-page .validation-card ul {
        padding-left: 23px;
        margin-bottom: 0;
        font-size: 0.83rem;
        line-height: 1.8;
    }

    /* Form footer */

    .customer-create-page .form-footer {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 30px;
        padding-top: 24px;
        border-top: 1px solid #e9edf5;
    }

    .customer-create-page .footer-note {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #94a3b8;
        font-size: 0.77rem;
    }

    .customer-create-page .footer-note i {
        color: #10b981;
        font-size: 1rem;
    }

    .customer-create-page .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .customer-create-page .btn-cancel {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 17px;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        color: #475569;
        background: #fff;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 750;
        transition: all 0.2s ease;
    }

    .customer-create-page .btn-cancel:hover {
        color: #172033;
        border-color: #cbd5e1;
        background: #f8fafc;
    }

    .customer-create-page .btn-save {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 20px;
        border: 1px solid var(--cc-primary);
        border-radius: 11px;
        color: #fff;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        box-shadow: 0 5px 14px rgba(99, 102, 241, 0.2);
        font-size: 0.85rem;
        font-weight: 800;
        transition: all 0.2s ease;
    }

    .customer-create-page .btn-save:hover {
        color: #fff;
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        transform: translateY(-1px);
    }

    .customer-create-page .form-required-note {
        margin-top: 18px;
        color: #94a3b8;
        font-size: 0.76rem;
    }

    @media (max-width: 767.98px) {
        .customer-create-page .form-card-header {
            padding: 19px;
        }

        .customer-create-page .form-card-body {
            padding: 20px;
        }

        .customer-create-page .section-heading {
            margin-bottom: 18px;
        }

        .customer-create-page .form-footer {
            align-items: stretch;
        }

        .customer-create-page .footer-note {
            width: 100%;
        }

        .customer-create-page .action-buttons {
            width: 100%;
        }

        .customer-create-page .action-buttons > * {
            flex: 1;
        }
    }

    @media (max-width: 480px) {
        .customer-create-page .header-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
        }

        .customer-create-page .page-heading {
            font-size: 1.35rem;
        }

        .customer-create-page .form-card-body {
            padding: 16px;
        }

        .customer-create-page .section-divider {
            margin: 23px 0;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .customer-create-page *,
        .customer-create-page *::before,
        .customer-create-page *::after {
            transition: none !important;
        }
    }
</style>

<div class="container-fluid py-4 customer-create-page">


{{-- PAGE HEADER --}}
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">

    <div class="d-flex align-items-center gap-3">

        <a href="{{ route('customers.index') }}"
           class="back-button"
           aria-label="Back to customers">

            <i class="bi bi-arrow-left"></i>

        </a>

        <div class="header-icon">
            <i class="bi bi-person-plus-fill"></i>
        </div>

        <div>
            <h2 class="page-heading mb-1">
                Add Customer
            </h2>

            <p class="page-subtitle mb-0">
                Create a customer profile and manage account details.
            </p>
        </div>

    </div>

    <div class="header-badge">
        <i class="bi bi-shield-check"></i>
        Customer Management
    </div>

</div>


{{-- VALIDATION ERRORS --}}
@if($errors->any())

    <div class="validation-card mb-4">

        <div class="validation-title">
            <i class="bi bi-exclamation-triangle-fill"></i>
            Please correct the following errors.
        </div>

        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>

@endif


{{-- MAIN FORM CARD --}}
<div class="form-card">

    <div class="form-card-header">

        <div class="section-icon section-icon-purple">
            <i class="bi bi-person-vcard-fill"></i>
        </div>

        <div>
            <h5>New Customer Registration</h5>

            <p>
                Enter the customer information below to create a record.
            </p>
        </div>

    </div>


    <div class="form-card-body">

        <form action="{{ route('customers.store') }}"
              method="POST">

            @csrf


            {{-- CUSTOMER INFORMATION --}}
            <section class="form-section">

                <div class="section-heading">

                    <div class="section-icon section-icon-purple">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <div>
                        <h5 class="section-title">
                            Customer Information
                        </h5>

                        <p class="section-description">
                            Basic contact and identification details.
                        </p>
                    </div>

                </div>


                <div class="row g-4">

                    {{-- CUSTOMER ID --}}
                    <div class="col-12 col-md-6">

                        <label for="customer_id" class="form-label">
                            Customer ID
                            <span class="required-star">*</span>
                        </label>

                        <input
                            type="text"
                            id="customer_id"
                            name="customer_id"
                            class="form-control @error('customer_id') is-invalid @enderror"
                            value="{{ old('customer_id') }}"
                            placeholder="e.g. CUS-001"
                            maxlength="50"
                            required
                            autocomplete="off"
                        >

                        @error('customer_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @else
                            <div class="field-hint">
                                <i class="bi bi-info-circle field-icon"></i>
                                Enter a unique identification code.
                            </div>
                        @enderror

                    </div>


                    {{-- CUSTOMER NAME --}}
                    <div class="col-12 col-md-6">

                        <label for="name" class="form-label">
                            Customer Name
                            <span class="required-star">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Enter full customer name"
                            maxlength="255"
                            required
                            autocomplete="name"
                        >

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- EMAIL --}}
                    <div class="col-12 col-md-6">

                        <label for="email" class="form-label">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="customer@example.com"
                            maxlength="255"
                            autocomplete="email"
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- PHONE --}}
                    <div class="col-12 col-md-6">

                        <label for="phone" class="form-label">
                            Phone Number
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}"
                            placeholder="+92 300 1234567"
                            maxlength="30"
                            autocomplete="tel"
                        >

                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </section>


            <hr class="section-divider">


            {{-- FINANCIAL INFORMATION --}}
            <section class="form-section">

                <div class="section-heading">

                    <div class="section-icon section-icon-green">
                        <i class="bi bi-wallet2"></i>
                    </div>

                    <div>
                        <h5 class="section-title">
                            Financial Information
                        </h5>

                        <p class="section-description">
                            Configure the customer's opening account values.
                        </p>
                    </div>

                </div>


                <div class="row g-4">

                    {{-- CREDIT LIMIT --}}
                    <div class="col-12 col-md-4">

                        <label for="credit_limit" class="form-label">
                            Credit Limit
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rs.
                            </span>

                            <input
                                type="number"
                                id="credit_limit"
                                name="credit_limit"
                                class="form-control @error('credit_limit') is-invalid @enderror"
                                value="{{ old('credit_limit', 0) }}"
                                min="0"
                                step="0.01"
                                placeholder="0.00"
                            >

                        </div>

                        @error('credit_limit')
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @else
                            <div class="field-hint">
                                Maximum allowed customer credit.
                            </div>
                        @enderror

                    </div>


                    {{-- OPENING BALANCE --}}
                    <div class="col-12 col-md-4">

                        <label for="opening_balance" class="form-label">
                            Opening Balance
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rs.
                            </span>

                            <input
                                type="number"
                                id="opening_balance"
                                name="opening_balance"
                                class="form-control @error('opening_balance') is-invalid @enderror"
                                value="{{ old('opening_balance', 0) }}"
                                step="0.01"
                                placeholder="0.00"
                            >

                        </div>

                        @error('opening_balance')
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @else
                            <div class="field-hint">
                                Starting balance for the account.
                            </div>
                        @enderror

                    </div>


                    {{-- STATUS --}}
                    <div class="col-12 col-md-4">

                        <label for="status" class="form-label">
                            Account Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-select @error('status') is-invalid @enderror"
                        >

                            <option value="active"
                                {{ old('status', 'active') === 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @else
                            <div class="field-hint">
                                Choose the customer's account status.
                            </div>
                        @enderror

                    </div>

                </div>


                <div class="status-info">

                    <i class="bi bi-info-circle-fill"></i>

                    <div>
                        <strong>Financial note:</strong>
                        Set the credit limit according to your business policy.
                        Confirm the opening balance before saving the customer record.
                    </div>

                </div>

            </section>


            <hr class="section-divider">


            {{-- ADDRESS --}}
            <section class="form-section">

                <div class="section-heading">

                    <div class="section-icon section-icon-orange">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <div>
                        <h5 class="section-title">
                            Address Information
                        </h5>

                        <p class="section-description">
                            Add the customer's billing or contact address.
                        </p>
                    </div>

                </div>


                <div class="row">

                    <div class="col-12">

                        <label for="address" class="form-label">
                            Customer Address
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="4"
                            class="form-control @error('address') is-invalid @enderror"
                            placeholder="Enter street, city, area or complete address..."
                        >{{ old('address') }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @else
                            <div class="field-hint">
                                <i class="bi bi-geo-alt field-icon"></i>
                                Provide an address that helps identify the customer's location.
                            </div>
                        @enderror

                    </div>

                </div>

            </section>


            {{-- FORM ACTIONS --}}
            <div class="form-footer">

                <div class="footer-note">
                    <i class="bi bi-shield-check"></i>
                    <span>Your customer information will be saved securely.</span>
                </div>

                <div class="action-buttons">

                    <a href="{{ route('customers.index') }}"
                       class="btn-cancel">

                        <i class="bi bi-x-lg"></i>
                        Cancel

                    </a>

                    <button type="submit" class="btn-save">

                        <i class="bi bi-check2-circle"></i>
                        Save Customer

                    </button>

                </div>

            </div>


            <div class="form-required-note">
                <span class="required-star">*</span>
                Required fields
            </div>

        </form>

    </div>

</div>


{{-- BOTTOM NOTE --}}
<div class="d-flex align-items-center gap-2 mt-4 text-muted small">

    <i class="bi bi-lightbulb text-primary"></i>

    <span>
        Tip: Use a unique Customer ID to make customer records easier to manage.
    </span>

</div>


</div>

@endsection
