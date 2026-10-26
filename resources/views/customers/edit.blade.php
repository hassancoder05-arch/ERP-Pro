@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')

<style>
    /* ==========================================
       ERP PRO — EDIT CUSTOMER
    ========================================== */

    .edit-customer-page {
        --ec-primary: #6366f1;
        --ec-primary-dark: #4f46e5;
        --ec-text: #172033;
        --ec-muted: #64748b;
        --ec-border: #e2e8f0;
        color: var(--ec-text);
    }

    .edit-customer-page .page-title {
        font-size: clamp(1.45rem, 2.5vw, 1.9rem);
        font-weight: 800;
        letter-spacing: -0.7px;
    }

    .edit-customer-page .page-subtitle {
        color: var(--ec-muted);
        font-size: 0.9rem;
    }

    /* Header */

    .edit-customer-page .back-btn {
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--ec-border);
        border-radius: 14px;
        color: #475569;
        background: #fff;
        font-size: 1.15rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .edit-customer-page .back-btn:hover {
        color: var(--ec-primary);
        background: #eef2ff;
        border-color: #c7d2fe;
        transform: translateX(-2px);
    }

    .edit-customer-page .header-icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 16px;
        color: #fff;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.22);
        font-size: 1.45rem;
    }

    .edit-customer-page .header-badge {
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

    /* Form card */

    .edit-customer-page .form-card {
        overflow: hidden;
        border: 1px solid #e8edf5;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 8px 35px rgba(15, 23, 42, 0.045);
    }

    .edit-customer-page .card-heading {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 23px 27px;
        border-bottom: 1px solid #eef2f7;
        background: linear-gradient(120deg, #fff, #f8faff);
    }

    .edit-customer-page .card-heading h5 {
        margin: 0 0 4px;
        font-size: 1rem;
        font-weight: 800;
    }

    .edit-customer-page .card-heading p {
        margin: 0;
        color: var(--ec-muted);
        font-size: 0.82rem;
    }

    .edit-customer-page .card-content {
        padding: 28px;
    }

    /* Sections */

    .edit-customer-page .form-section {
        margin-bottom: 30px;
    }

    .edit-customer-page .section-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 23px;
    }

    .edit-customer-page .section-icon {
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 1.2rem;
    }

    .edit-customer-page .icon-purple {
        color: #6366f1;
        background: #eef2ff;
    }

    .edit-customer-page .icon-green {
        color: #059669;
        background: #ecfdf5;
    }

    .edit-customer-page .icon-orange {
        color: #d97706;
        background: #fffbeb;
    }

    .edit-customer-page .section-title {
        margin: 0 0 4px;
        color: #172033;
        font-size: 0.96rem;
        font-weight: 800;
    }

    .edit-customer-page .section-subtitle {
        margin: 0;
        color: #94a3b8;
        font-size: 0.78rem;
    }

    .edit-customer-page .section-divider {
        margin: 29px 0;
        border: 0;
        border-top: 1px solid #e9edf5;
        opacity: 1;
    }

    /* Inputs */

    .edit-customer-page .form-label {
        margin-bottom: 8px;
        color: #334155;
        font-size: 0.83rem;
        font-weight: 750;
    }

    .edit-customer-page .required-star {
        color: #ef4444;
    }

    .edit-customer-page .form-control,
    .edit-customer-page .form-select {
        min-height: 46px;
        border: 1px solid #dfe5ef;
        border-radius: 11px;
        color: #172033;
        background-color: #fff;
        font-size: 0.87rem;
        box-shadow: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .edit-customer-page .form-control {
        padding: 11px 13px;
    }

    .edit-customer-page .form-select {
        padding: 11px 36px 11px 13px;
    }

    .edit-customer-page .form-control:focus,
    .edit-customer-page .form-select:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.10);
    }

    .edit-customer-page .form-control::placeholder {
        color: #a0aec0;
    }

    .edit-customer-page textarea.form-control {
        min-height: 125px;
        resize: vertical;
        line-height: 1.7;
    }

    .edit-customer-page .input-group-text {
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

    .edit-customer-page .input-group .form-control {
        border-radius: 0 11px 11px 0;
    }

    .edit-customer-page .field-hint {
        margin-top: 7px;
        color: #94a3b8;
        font-size: 0.75rem;
        line-height: 1.5;
    }

    /* Current customer information */

    .edit-customer-page .customer-summary {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 17px 20px;
        margin-bottom: 28px;
        border: 1px solid #e0e7ff;
        border-radius: 15px;
        background: linear-gradient(110deg, #f5f7ff, #fff);
    }

    .edit-customer-page .customer-avatar {
        width: 49px;
        height: 49px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        color: #fff;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        font-size: 1.3rem;
    }

    .edit-customer-page .summary-label {
        margin-bottom: 4px;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 650;
    }

    .edit-customer-page .summary-name {
        margin-bottom: 3px;
        color: #172033;
        font-size: 0.95rem;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .edit-customer-page .summary-id {
        color: #64748b;
        font-size: 0.78rem;
    }

    .edit-customer-page .current-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-left: auto;
        padding: 7px 10px;
        border-radius: 9px;
        font-size: 0.75rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .edit-customer-page .status-active {
        color: #047857;
        background: #d1fae5;
    }

    .edit-customer-page .status-inactive {
        color: #b91c1c;
        background: #fee2e2;
    }

    .edit-customer-page .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Financial note */

    .edit-customer-page .financial-note {
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

    .edit-customer-page .financial-note i {
        margin-top: 2px;
    }

    /* Validation */

    .edit-customer-page .validation-card {
        padding: 18px 20px;
        border: 1px solid #fecaca;
        border-radius: 14px;
        color: #991b1b;
        background: #fef2f2;
    }

    .edit-customer-page .validation-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 10px;
        font-size: 0.9rem;
        font-weight: 800;
    }

    .edit-customer-page .validation-card ul {
        padding-left: 23px;
        margin-bottom: 0;
        font-size: 0.83rem;
        line-height: 1.8;
    }

    /* Footer actions */

    .edit-customer-page .form-footer {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 30px;
        padding-top: 24px;
        border-top: 1px solid #e9edf5;
    }

    .edit-customer-page .footer-note {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #94a3b8;
        font-size: 0.77rem;
    }

    .edit-customer-page .footer-note i {
        color: #10b981;
        font-size: 1rem;
    }

    .edit-customer-page .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .edit-customer-page .btn-cancel,
    .edit-customer-page .btn-update {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 11px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 800;
        transition: all 0.2s ease;
    }

    .edit-customer-page .btn-cancel {
        border: 1px solid #e2e8f0;
        color: #475569;
        background: #fff;
    }

    .edit-customer-page .btn-cancel:hover {
        color: #172033;
        border-color: #cbd5e1;
        background: #f8fafc;
    }

    .edit-customer-page .btn-update {
        border: 1px solid var(--ec-primary);
        color: #fff;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        box-shadow: 0 5px 14px rgba(99, 102, 241, 0.2);
        cursor: pointer;
    }

    .edit-customer-page .btn-update:hover {
        color: #fff;
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        transform: translateY(-1px);
    }

    .edit-customer-page .required-note {
        margin-top: 18px;
        color: #94a3b8;
        font-size: 0.76rem;
    }

    /* Responsive */

    @media (max-width: 767.98px) {
        .edit-customer-page .card-heading {
            padding: 19px;
        }

        .edit-customer-page .card-content {
            padding: 20px;
        }

        .edit-customer-page .form-footer {
            align-items: stretch;
        }

        .edit-customer-page .footer-note {
            width: 100%;
        }

        .edit-customer-page .action-buttons {
            width: 100%;
        }

        .edit-customer-page .action-buttons > * {
            flex: 1;
        }
    }

    @media (max-width: 480px) {
        .edit-customer-page .page-title {
            font-size: 1.35rem;
        }

        .edit-customer-page .header-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
        }

        .edit-customer-page .card-content {
            padding: 16px;
        }

        .edit-customer-page .customer-summary {
            align-items: flex-start;
            flex-wrap: wrap;
            padding: 14px;
        }

        .edit-customer-page .current-status {
            margin-left: 63px;
        }

        .edit-customer-page .section-divider {
            margin: 23px 0;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .edit-customer-page *,
        .edit-customer-page *::before,
        .edit-customer-page *::after {
            transition: none !important;
        }
    }
</style>

<div class="container-fluid py-4 edit-customer-page">


{{-- PAGE HEADER --}}
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">

    <div class="d-flex align-items-center gap-3">

        <a href="{{ route('customers.index') }}"
           class="back-btn"
           aria-label="Back to customers">

            <i class="bi bi-arrow-left"></i>

        </a>

        <div class="header-icon">
            <i class="bi bi-person-gear"></i>
        </div>

        <div>
            <h2 class="page-title mb-1">
                Edit Customer
            </h2>

            <p class="page-subtitle mb-0">
                Update customer contact and account information.
            </p>
        </div>

    </div>

    <div class="header-badge">
        <i class="bi bi-pencil-square"></i>
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

    <div class="card-heading">

        <div class="section-icon icon-purple">
            <i class="bi bi-person-vcard-fill"></i>
        </div>

        <div>
            <h5>Customer Profile</h5>

            <p>
                Review and update the customer's saved information.
            </p>
        </div>

    </div>


    <div class="card-content">

        {{-- CURRENT CUSTOMER SUMMARY --}}
        <div class="customer-summary">

            <div class="customer-avatar">
                <i class="bi bi-person-fill"></i>
            </div>

            <div>
                <div class="summary-label">
                    Currently Editing
                </div>

                <div class="summary-name">
                    {{ $customer->name }}
                </div>

                <div class="summary-id">
                    Customer ID:
                    {{ $customer->customer_id }}
                </div>
            </div>

            <div class="current-status {{ $customer->status === 'active' ? 'status-active' : 'status-inactive' }}">

                <span class="status-dot"></span>

                {{ ucfirst($customer->status ?? 'unknown') }}

            </div>

        </div>


        <form action="{{ route('customers.update', $customer) }}"
              method="POST">

            @csrf
            @method('PUT')


            {{-- CUSTOMER INFORMATION --}}
            <section class="form-section">

                <div class="section-heading">

                    <div class="section-icon icon-purple">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <div>
                        <h5 class="section-title">
                            Customer Information
                        </h5>

                        <p class="section-subtitle">
                            Identification and contact details.
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
                            value="{{ old('customer_id', $customer->customer_id) }}"
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
                                Enter a unique customer identification code.
                            </div>
                        @enderror

                    </div>


                    {{-- NAME --}}
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
                            value="{{ old('name', $customer->name) }}"
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
                            value="{{ old('email', $customer->email) }}"
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
                            value="{{ old('phone', $customer->phone) }}"
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

                    <div class="section-icon icon-green">
                        <i class="bi bi-wallet2"></i>
                    </div>

                    <div>
                        <h5 class="section-title">
                            Financial Information
                        </h5>

                        <p class="section-subtitle">
                            Manage the customer's credit and opening balance.
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
                                value="{{ old('credit_limit', $customer->credit_limit) }}"
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
                                Maximum permitted credit amount.
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
                                value="{{ old('opening_balance', $customer->opening_balance) }}"
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
                                Starting balance recorded for the account.
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
                                {{ old('status', $customer->status) === 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old('status', $customer->status) === 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @else
                            <div class="field-hint">
                                Select the customer's current status.
                            </div>
                        @enderror

                    </div>

                </div>


                <div class="financial-note">

                    <i class="bi bi-info-circle-fill"></i>

                    <div>
                        <strong>Financial information:</strong>
                        Verify the credit limit and opening balance before updating.
                        These values should match your business records.
                    </div>

                </div>

            </section>


            <hr class="section-divider">


            {{-- ADDRESS --}}
            <section class="form-section">

                <div class="section-heading">

                    <div class="section-icon icon-orange">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <div>
                        <h5 class="section-title">
                            Address Information
                        </h5>

                        <p class="section-subtitle">
                            Update the customer's billing or contact address.
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
                        >{{ old('address', $customer->address) }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @else
                            <div class="field-hint">
                                Provide an accurate address for customer records.
                            </div>
                        @enderror

                    </div>

                </div>

            </section>


            {{-- ACTIONS --}}
            <div class="form-footer">

                <div class="footer-note">
                    <i class="bi bi-shield-check"></i>
                    <span>Review your changes before saving.</span>
                </div>

                <div class="action-buttons">

                    <a href="{{ route('customers.index') }}"
                       class="btn-cancel">

                        <i class="bi bi-x-lg"></i>
                        Cancel

                    </a>

                    <button type="submit" class="btn-update">

                        <i class="bi bi-check2-circle"></i>
                        Update Customer

                    </button>

                </div>

            </div>


            <div class="required-note">
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
        Tip: Double-check customer contact details before saving changes.
    </span>

</div>


</div>

@endsection
