@extends('layouts.app')

@section('title', 'Add Supplier')

@section('content')

<div class="container-fluid py-4 supplier-create-page">


{{-- Page Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div class="d-flex align-items-center gap-3">

        <a href="{{ route('suppliers.index') }}"
           class="back-button"
           aria-label="Back to suppliers">

            <i class="bi bi-arrow-left"></i>

        </a>

        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="page-icon">
                    <i class="bi bi-building-add"></i>
                </span>

                <span class="page-eyebrow">SUPPLIER MANAGEMENT</span>
            </div>

            <h2 class="fw-bold mb-1">Add Supplier</h2>

            <p class="text-muted mb-0">
                Register a new supplier and manage their account information.
            </p>
        </div>

    </div>

    <div class="header-badge">
        <i class="bi bi-shield-check me-2"></i>
        New Supplier Record
    </div>

</div>


{{-- Validation Errors --}}
@if($errors->any())

    <div class="alert validation-alert mb-4">

        <div class="d-flex align-items-start gap-3">

            <div class="validation-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>

            <div>
                <h6 class="fw-bold mb-2">
                    Please correct the following errors
                </h6>

                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </div>

    </div>

@endif


{{-- Supplier Form --}}
<form action="{{ route('suppliers.store') }}" method="POST">

    @csrf

    <div class="row g-4">

        {{-- Main Form --}}
        <div class="col-xl-8 col-lg-7">

            {{-- Supplier Information --}}
            <div class="card supplier-card mb-4">

                <div class="card-header supplier-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="section-icon supplier-icon">
                            <i class="bi bi-building"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">
                                Supplier Information
                            </h5>

                            <p class="text-muted small mb-0">
                                Enter the supplier's identification and contact details.
                            </p>
                        </div>

                    </div>

                    <span class="required-note">
                        * Required fields
                    </span>

                </div>

                <div class="card-body p-4">

                    <div class="row g-4">

                        {{-- Supplier ID --}}
                        <div class="col-md-6">

                            <label for="supplier_id" class="form-label">
                                Supplier ID <span class="text-danger">*</span>
                            </label>

                            <div class="input-group custom-input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-upc-scan"></i>
                                </span>

                                <input
                                    type="text"
                                    id="supplier_id"
                                    name="supplier_id"
                                    class="form-control @error('supplier_id') is-invalid @enderror"
                                    value="{{ old('supplier_id') }}"
                                    placeholder="e.g. SUP-001"
                                    maxlength="50"
                                    required
                                    autocomplete="off"
                                >

                            </div>

                            @error('supplier_id')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="field-hint">
                                <i class="bi bi-info-circle me-1"></i>
                                Enter a unique supplier reference ID.
                            </div>

                        </div>


                        {{-- Supplier Name --}}
                        <div class="col-md-6">

                            <label for="name" class="form-label">
                                Supplier Name <span class="text-danger">*</span>
                            </label>

                            <div class="input-group custom-input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="Enter supplier name"
                                    maxlength="255"
                                    required
                                    autocomplete="name"
                                >

                            </div>

                            @error('name')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Company Name --}}
                        <div class="col-md-6">

                            <label for="company_name" class="form-label">
                                Company Name
                            </label>

                            <div class="input-group custom-input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-buildings"></i>
                                </span>

                                <input
                                    type="text"
                                    id="company_name"
                                    name="company_name"
                                    class="form-control @error('company_name') is-invalid @enderror"
                                    value="{{ old('company_name') }}"
                                    placeholder="Enter company name"
                                    maxlength="255"
                                    autocomplete="organization"
                                >

                            </div>

                            @error('company_name')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Email --}}
                        <div class="col-md-6">

                            <label for="email" class="form-label">
                                Email Address
                            </label>

                            <div class="input-group custom-input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="supplier@example.com"
                                    maxlength="255"
                                    autocomplete="email"
                                >

                            </div>

                            @error('email')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Phone --}}
                        <div class="col-md-6">

                            <label for="phone" class="form-label">
                                Phone Number
                            </label>

                            <div class="input-group custom-input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-telephone"></i>
                                </span>

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

                            </div>

                            @error('phone')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Status --}}
                        <div class="col-md-6">

                            <label for="status" class="form-label">
                                Supplier Status
                            </label>

                            <div class="input-group custom-input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-toggle-on"></i>
                                </span>

                                <select
                                    name="status"
                                    id="status"
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

                            </div>

                            @error('status')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="field-hint">
                                <i class="bi bi-info-circle me-1"></i>
                                Choose whether this supplier is active.
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Financial Information --}}
            <div class="card supplier-card mb-4">

                <div class="card-header supplier-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="section-icon finance-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">
                                Financial Information
                            </h5>

                            <p class="text-muted small mb-0">
                                Configure the supplier's initial account balance.
                            </p>
                        </div>

                    </div>

                </div>

                <div class="card-body p-4">

                    <div class="row g-4">

                        <div class="col-md-8">

                            <label for="opening_balance" class="form-label">
                                Opening Balance
                            </label>

                            <div class="input-group custom-input-group money-input">

                                <span class="input-group-text currency-label">
                                    Rs.
                                </span>

                                <input
                                    type="number"
                                    id="opening_balance"
                                    name="opening_balance"
                                    class="form-control @error('opening_balance') is-invalid @enderror"
                                    value="{{ old('opening_balance', '0.00') }}"
                                    placeholder="0.00"
                                    step="0.01"
                                    min="0"
                                >

                            </div>

                            @error('opening_balance')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="field-hint">
                                <i class="bi bi-info-circle me-1"></i>
                                Enter the starting balance according to your accounting records.
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Address Information --}}
            <div class="card supplier-card mb-4">

                <div class="card-header supplier-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="section-icon address-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">
                                Address Information
                            </h5>

                            <p class="text-muted small mb-0">
                                Add the supplier's business or contact address.
                            </p>
                        </div>

                    </div>

                </div>

                <div class="card-body p-4">

                    <label for="address" class="form-label">
                        Full Address
                    </label>

                    <textarea
                        name="address"
                        id="address"
                        rows="4"
                        class="form-control custom-textarea @error('address') is-invalid @enderror"
                        placeholder="Enter street, city, area and other address details..."
                    >{{ old('address') }}</textarea>

                    @error('address')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Right Sidebar --}}
        <div class="col-xl-4 col-lg-5">

            {{-- Information Card --}}
            <div class="card supplier-card info-card mb-4">

                <div class="info-card-banner">
                    <div class="info-banner-icon">
                        <i class="bi bi-building-check"></i>
                    </div>

                    <h5 class="fw-bold mb-2">
                        Supplier Registration
                    </h5>

                    <p class="mb-0">
                        Keep your supplier records organized and accurate.
                    </p>
                </div>

                <div class="card-body p-4">

                    <div class="info-list-item">

                        <span class="info-list-icon">
                            <i class="bi bi-check2"></i>
                        </span>

                        <div>
                            <div class="info-list-title">
                                Unique Identification
                            </div>

                            <div class="info-list-text">
                                Use a unique ID for each supplier.
                            </div>
                        </div>

                    </div>

                    <div class="info-list-item">

                        <span class="info-list-icon">
                            <i class="bi bi-check2"></i>
                        </span>

                        <div>
                            <div class="info-list-title">
                                Contact Information
                            </div>

                            <div class="info-list-text">
                                Keep email and phone details up to date.
                            </div>
                        </div>

                    </div>

                    <div class="info-list-item">

                        <span class="info-list-icon">
                            <i class="bi bi-check2"></i>
                        </span>

                        <div>
                            <div class="info-list-title">
                                Financial Records
                            </div>

                            <div class="info-list-text">
                                Enter the opening balance accurately.
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Status Guide --}}
            <div class="card supplier-card status-guide-card mb-4">

                <div class="card-body p-4">

                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        Supplier Status Guide
                    </h6>

                    <div class="status-guide-item mb-3">

                        <span class="guide-status-dot active-dot"></span>

                        <div>
                            <div class="fw-semibold small">
                                Active
                            </div>

                            <div class="text-muted small">
                                Supplier is available for regular operations.
                            </div>
                        </div>

                    </div>

                    <div class="status-guide-item">

                        <span class="guide-status-dot inactive-dot"></span>

                        <div>
                            <div class="fw-semibold small">
                                Inactive
                            </div>

                            <div class="text-muted small">
                                Supplier is marked as inactive.
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Form Actions --}}
            <div class="card supplier-card action-card">

                <div class="card-body p-4">

                    <h6 class="fw-bold mb-2">
                        Ready to save?
                    </h6>

                    <p class="text-muted small mb-4">
                        Review the information before creating the supplier record.
                    </p>

                    <button type="submit"
                            class="btn btn-primary save-button w-100 mb-2">

                        <i class="bi bi-check-circle me-2"></i>
                        Save Supplier

                    </button>

                    <a href="{{ route('suppliers.index') }}"
                       class="btn btn-light cancel-button w-100">

                        <i class="bi bi-x-circle me-2"></i>
                        Cancel

                    </a>

                </div>

            </div>

        </div>

    </div>

</form>


</div>

<style>
/* ========================================
   ERP-PRO PREMIUM ADD SUPPLIER PAGE
======================================== */

.supplier-create-page {
    --supplier-primary: #4f46e5;
    --supplier-primary-dark: #3730a3;
    --supplier-text: #172033;
    --supplier-muted: #64748b;
    --supplier-border: #e7ecf4;
    color: var(--supplier-text);
}

.supplier-create-page .back-button {
    width: 46px;
    height: 46px;
    flex: 0 0 46px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--supplier-border);
    border-radius: 13px;
    background: #ffffff;
    color: #475569;
    font-size: 19px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.supplier-create-page .back-button:hover {
    background: #eef2ff;
    color: var(--supplier-primary);
    border-color: #c7d2fe;
    transform: translateX(-2px);
}

.supplier-create-page .page-icon {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #eef2ff;
    color: var(--supplier-primary);
    font-size: 17px;
}

.supplier-create-page .page-eyebrow {
    color: var(--supplier-primary);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.4px;
}

.supplier-create-page h2 {
    color: var(--supplier-text);
    font-size: 27px;
    letter-spacing: -0.7px;
}

.supplier-create-page .header-badge {
    padding: 11px 15px;
    border: 1px solid #c7d2fe;
    border-radius: 12px;
    background: #eef2ff;
    color: #4338ca;
    font-size: 12px;
    font-weight: 700;
}

.supplier-create-page .supplier-card {
    overflow: hidden;
    border: 1px solid var(--supplier-border);
    border-radius: 17px;
    background: #ffffff;
    box-shadow: 0 5px 22px rgba(15, 23, 42, 0.04);
}

.supplier-create-page .supplier-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
    padding: 21px 24px;
    border-bottom: 1px solid var(--supplier-border);
    background: #ffffff;
}

.supplier-create-page .supplier-card-header h5 {
    color: var(--supplier-text);
    font-size: 15px;
}

.supplier-create-page .supplier-card-header p {
    font-size: 11px;
    line-height: 1.6;
}

.supplier-create-page .section-icon {
    width: 45px;
    height: 45px;
    flex: 0 0 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    font-size: 20px;
}

.supplier-create-page .supplier-icon {
    background: #eef2ff;
    color: #4f46e5;
}

.supplier-create-page .finance-icon {
    background: #d1fae5;
    color: #047857;
}

.supplier-create-page .address-icon {
    background: #ffedd5;
    color: #c2410c;
}

.supplier-create-page .required-note {
    color: #94a3b8;
    font-size: 10px;
    font-weight: 600;
}

.supplier-create-page .form-label {
    display: block;
    margin-bottom: 9px;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
}

.supplier-create-page .custom-input-group {
    min-height: 47px;
}

.supplier-create-page .custom-input-group .input-group-text {
    padding: 0 14px;
    border-color: #e2e8f0;
    border-radius: 10px 0 0 10px;
    background: #f8fafc;
    color: #64748b;
    font-size: 15px;
}

.supplier-create-page .custom-input-group .form-control,
.supplier-create-page .custom-input-group .form-select {
    min-height: 47px;
    border-color: #e2e8f0;
    border-radius: 0 10px 10px 0;
    color: var(--supplier-text);
    background-color: #ffffff;
    font-size: 12px;
    box-shadow: none;
}

.supplier-create-page .custom-input-group .form-control::placeholder,
.supplier-create-page .custom-textarea::placeholder {
    color: #a0aabc;
}

.supplier-create-page .custom-input-group .form-control:focus,
.supplier-create-page .custom-input-group .form-select:focus,
.supplier-create-page .custom-textarea:focus {
    position: relative;
    z-index: 2;
    border-color: #818cf8;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.11);
}

.supplier-create-page .custom-input-group .form-control.is-invalid,
.supplier-create-page .custom-input-group .form-select.is-invalid {
    border-color: #dc3545;
}

.supplier-create-page .field-hint {
    margin-top: 8px;
    color: #94a3b8;
    font-size: 10px;
    line-height: 1.6;
}

.supplier-create-page .money-input .currency-label {
    padding: 0 18px;
    background: #ecfdf5;
    border-color: #bbf7d0;
    color: #047857;
    font-weight: 800;
}

.supplier-create-page .money-input .form-control {
    border-radius: 0 10px 10px 0;
}

.supplier-create-page .custom-textarea {
    min-height: 120px;
    padding: 14px;
    border: 1px solid #e2e8f0;
    border-radius: 11px;
    color: var(--supplier-text);
    font-size: 12px;
    resize: vertical;
    box-shadow: none;
}

.supplier-create-page .validation-alert {
    padding: 18px 20px;
    border: 1px solid #fecaca;
    border-radius: 14px;
    background: #fef2f2;
    color: #991b1b;
    font-size: 12px;
}

.supplier-create-page .validation-icon {
    font-size: 22px;
    color: #dc2626;
}

.supplier-create-page .validation-alert ul {
    line-height: 1.9;
}


/* Sidebar Information Card */

.supplier-create-page .info-card-banner {
    padding: 25px 24px;
    background: linear-gradient(135deg, #312e81, #4f46e5 65%, #818cf8);
    color: #ffffff;
}

.supplier-create-page .info-banner-icon {
    width: 49px;
    height: 49px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.13);
    font-size: 22px;
}

.supplier-create-page .info-card-banner h5 {
    font-size: 17px;
}

.supplier-create-page .info-card-banner p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 12px;
    line-height: 1.8;
}

.supplier-create-page .info-list-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 22px;
}

.supplier-create-page .info-list-item:last-child {
    margin-bottom: 0;
}

.supplier-create-page .info-list-icon {
    width: 25px;
    height: 25px;
    flex: 0 0 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #dcfce7;
    color: #15803d;
    font-size: 14px;
}

.supplier-create-page .info-list-title {
    margin-bottom: 4px;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
}

.supplier-create-page .info-list-text {
    color: #94a3b8;
    font-size: 11px;
    line-height: 1.7;
}

.supplier-create-page .status-guide-card h6 {
    color: var(--supplier-text);
    font-size: 13px;
}

.supplier-create-page .status-guide-item {
    display: flex;
    align-items: flex-start;
    gap: 11px;
}

.supplier-create-page .guide-status-dot {
    width: 9px;
    height: 9px;
    flex: 0 0 9px;
    margin-top: 5px;
    border-radius: 50%;
}

.supplier-create-page .active-dot {
    background: #22c55e;
    box-shadow: 0 0 0 4px #dcfce7;
}

.supplier-create-page .inactive-dot {
    background: #94a3b8;
    box-shadow: 0 0 0 4px #f1f5f9;
}

.supplier-create-page .status-guide-item .fw-semibold {
    color: #334155;
    margin-bottom: 4px;
}

.supplier-create-page .status-guide-item .text-muted {
    font-size: 11px;
    line-height: 1.7;
}

.supplier-create-page .action-card {
    border-color: #c7d2fe;
    background: linear-gradient(145deg, #ffffff, #f8faff);
}

.supplier-create-page .action-card h6 {
    color: var(--supplier-text);
    font-size: 14px;
}

.supplier-create-page .action-card p {
    font-size: 11px;
    line-height: 1.8;
}

.supplier-create-page .save-button {
    min-height: 47px;
    border: none;
    border-radius: 11px;
    background: var(--supplier-primary);
    font-size: 12px;
    font-weight: 700;
    box-shadow: 0 6px 15px rgba(79, 70, 229, 0.18);
    transition: all 0.2s ease;
}

.supplier-create-page .save-button:hover {
    background: var(--supplier-primary-dark);
    transform: translateY(-1px);
}

.supplier-create-page .cancel-button {
    min-height: 44px;
    padding-top: 12px;
    border: 1px solid var(--supplier-border);
    border-radius: 11px;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
}

.supplier-create-page .cancel-button:hover {
    background: #f1f5f9;
}

@media (max-width: 767.98px) {

    .supplier-create-page h2 {
        font-size: 23px;
    }

    .supplier-create-page .header-badge {
        margin-left: 58px;
    }

    .supplier-create-page .supplier-card-header {
        padding: 18px;
    }

    .supplier-create-page .card-body {
        padding: 20px !important;
    }

    .supplier-create-page .required-note {
        margin-left: 58px;
    }

}

@media (prefers-reduced-motion: reduce) {

    .supplier-create-page .back-button,
    .supplier-create-page .save-button {
        transition: none;
    }

    .supplier-create-page .back-button:hover,
    .supplier-create-page .save-button:hover {
        transform: none;
    }

}
</style>

@endsection
