@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')

<div class="container-fluid py-4 supplier-edit-page">


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
                    <i class="bi bi-building-gear"></i>
                </span>

                <span class="page-eyebrow">SUPPLIER MANAGEMENT</span>

            </div>

            <h2 class="fw-bold mb-1">Edit Supplier</h2>

            <p class="text-muted mb-0">
                Update supplier contact, account and business information.
            </p>
        </div>

    </div>

    <div class="header-badge">
        <i class="bi bi-pencil-square me-2"></i>
        Editing Supplier Record
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


<form action="{{ route('suppliers.update', $supplier) }}" method="POST">

    @csrf
    @method('PUT')

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
                                Manage supplier identification and contact details.
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
                                    value="{{ old('supplier_id', $supplier->supplier_id) }}"
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
                                    value="{{ old('name', $supplier->name) }}"
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
                                    value="{{ old('company_name', $supplier->company_name) }}"
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
                                    value="{{ old('email', $supplier->email) }}"
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
                                    value="{{ old('phone', $supplier->phone) }}"
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
                                        {{ old('status', $supplier->status) === 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="inactive"
                                        {{ old('status', $supplier->status) === 'inactive' ? 'selected' : '' }}>
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
                                Choose the supplier's current status.
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
                                Update the supplier's opening account balance.
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
                                    value="{{ old('opening_balance', $supplier->opening_balance ?? 0) }}"
                                    placeholder="0.00"
                                    step="0.01"
                                >

                            </div>

                            @error('opening_balance')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="field-hint">
                                <i class="bi bi-info-circle me-1"></i>
                                Verify the balance against your accounting records.
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
                                Update the supplier's business or contact address.
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
                    >{{ old('address', $supplier->address) }}</textarea>

                    @error('address')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            {{-- Form Actions --}}
            <div class="form-actions d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div class="action-note">
                    <i class="bi bi-info-circle me-2"></i>
                    Review your changes before saving.
                </div>

                <div class="d-flex flex-wrap gap-2">

                    <a href="{{ route('suppliers.index') }}"
                       class="btn btn-light cancel-button">

                        <i class="bi bi-x-circle me-2"></i>
                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary save-button">

                        <i class="bi bi-check-circle me-2"></i>
                        Update Supplier

                    </button>

                </div>

            </div>

        </div>


        {{-- Right Sidebar --}}
        <div class="col-xl-4 col-lg-5">

            {{-- Supplier Profile --}}
            <div class="card supplier-card profile-card mb-4">

                <div class="profile-banner">
                    <div class="profile-banner-decoration"></div>

                    <span class="profile-label">
                        <i class="bi bi-person-vcard me-1"></i>
                        Supplier Profile
                    </span>
                </div>

                <div class="card-body profile-body">

                    <div class="supplier-avatar">
                        {{ strtoupper(substr($supplier->name ?? 'S', 0, 1)) }}
                    </div>

                    <div class="text-center profile-heading">

                        <h5 class="fw-bold mb-2">
                            {{ $supplier->name }}
                        </h5>

                        @if($supplier->company_name)
                            <p class="text-muted small mb-2">
                                {{ $supplier->company_name }}
                            </p>
                        @endif

                        <div class="supplier-code">
                            <i class="bi bi-upc-scan me-1"></i>
                            {{ $supplier->supplier_id }}
                        </div>

                        <div class="mt-3">

                            @if($supplier->status === 'active')
                                <span class="status-badge status-active">
                                    <span class="status-dot"></span>
                                    Active Supplier
                                </span>
                            @else
                                <span class="status-badge status-inactive">
                                    <span class="status-dot"></span>
                                    Inactive Supplier
                                </span>
                            @endif

                        </div>

                    </div>

                    <hr class="profile-divider">

                    <h6 class="fw-bold section-title mb-3">
                        Current Contact Details
                    </h6>

                    <div class="profile-contact-item">

                        <span class="contact-icon email-icon">
                            <i class="bi bi-envelope"></i>
                        </span>

                        <div class="contact-content">
                            <small>Email Address</small>

                            <div class="contact-value">
                                {{ $supplier->email ?: 'Not provided' }}
                            </div>
                        </div>

                    </div>

                    <div class="profile-contact-item">

                        <span class="contact-icon phone-icon">
                            <i class="bi bi-telephone"></i>
                        </span>

                        <div class="contact-content">
                            <small>Phone Number</small>

                            <div class="contact-value">
                                {{ $supplier->phone ?: 'Not provided' }}
                            </div>
                        </div>

                    </div>

                    <div class="profile-contact-item mb-0">

                        <span class="contact-icon location-icon">
                            <i class="bi bi-geo-alt"></i>
                        </span>

                        <div class="contact-content">
                            <small>Address</small>

                            <div class="contact-value">
                                {{ $supplier->address ?: 'Not provided' }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Editing Guide --}}
            <div class="card supplier-card guide-card mb-4">

                <div class="card-body p-4">

                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-lightbulb me-2 text-warning"></i>
                        Editing Guidelines
                    </h6>

                    <div class="guide-item">

                        <span class="guide-check">
                            <i class="bi bi-check2"></i>
                        </span>

                        <div>
                            <div class="guide-title">
                                Verify Supplier ID
                            </div>

                            <div class="guide-description">
                                Ensure the supplier ID remains unique.
                            </div>
                        </div>

                    </div>

                    <div class="guide-item">

                        <span class="guide-check">
                            <i class="bi bi-check2"></i>
                        </span>

                        <div>
                            <div class="guide-title">
                                Check Contact Details
                            </div>

                            <div class="guide-description">
                                Confirm email and phone information.
                            </div>
                        </div>

                    </div>

                    <div class="guide-item mb-0">

                        <span class="guide-check">
                            <i class="bi bi-check2"></i>
                        </span>

                        <div>
                            <div class="guide-title">
                                Review Financial Data
                            </div>

                            <div class="guide-description">
                                Make sure the opening balance is correct.
                            </div>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Financial Summary --}}
            <div class="card supplier-card balance-card">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3 mb-3">

                        <div class="balance-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>

                        <div>
                            <span class="balance-label">
                                CURRENT OPENING BALANCE
                            </span>

                            <h5 class="fw-bold mb-0 mt-1">
                                Rs. {{ number_format((float) ($supplier->opening_balance ?? 0), 2) }}
                            </h5>
                        </div>

                    </div>

                    <p class="text-muted small mb-0">
                        The value above reflects the saved record. Your edited value will take effect after a successful update.
                    </p>

                </div>

            </div>

        </div>

    </div>

</form>


</div>

<style>
/* ========================================
   ERP-PRO PREMIUM EDIT SUPPLIER UI
======================================== */

.supplier-edit-page {
    --supplier-primary: #4f46e5;
    --supplier-primary-dark: #3730a3;
    --supplier-text: #172033;
    --supplier-muted: #64748b;
    --supplier-border: #e7ecf4;
    color: var(--supplier-text);
}

.supplier-edit-page .back-button {
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

.supplier-edit-page .back-button:hover {
    background: #eef2ff;
    color: var(--supplier-primary);
    border-color: #c7d2fe;
    transform: translateX(-2px);
}

.supplier-edit-page .page-icon {
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

.supplier-edit-page .page-eyebrow {
    color: var(--supplier-primary);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.4px;
}

.supplier-edit-page h2 {
    color: var(--supplier-text);
    font-size: 27px;
    letter-spacing: -0.7px;
}

.supplier-edit-page .header-badge {
    padding: 11px 15px;
    border: 1px solid #c7d2fe;
    border-radius: 12px;
    background: #eef2ff;
    color: #4338ca;
    font-size: 12px;
    font-weight: 700;
}

.supplier-edit-page .supplier-card {
    overflow: hidden;
    border: 1px solid var(--supplier-border);
    border-radius: 17px;
    background: #ffffff;
    box-shadow: 0 5px 22px rgba(15, 23, 42, 0.04);
}

.supplier-edit-page .supplier-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
    padding: 21px 24px;
    border-bottom: 1px solid var(--supplier-border);
    background: #ffffff;
}

.supplier-edit-page .supplier-card-header h5 {
    color: var(--supplier-text);
    font-size: 15px;
}

.supplier-edit-page .supplier-card-header p {
    font-size: 11px;
    line-height: 1.6;
}

.supplier-edit-page .section-icon {
    width: 45px;
    height: 45px;
    flex: 0 0 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    font-size: 20px;
}

.supplier-edit-page .supplier-icon {
    background: #eef2ff;
    color: #4f46e5;
}

.supplier-edit-page .finance-icon {
    background: #d1fae5;
    color: #047857;
}

.supplier-edit-page .address-icon {
    background: #ffedd5;
    color: #c2410c;
}

.supplier-edit-page .required-note {
    color: #94a3b8;
    font-size: 10px;
    font-weight: 600;
}

.supplier-edit-page .form-label {
    display: block;
    margin-bottom: 9px;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
}

.supplier-edit-page .custom-input-group {
    min-height: 47px;
}

.supplier-edit-page .custom-input-group .input-group-text {
    padding: 0 14px;
    border-color: #e2e8f0;
    border-radius: 10px 0 0 10px;
    background: #f8fafc;
    color: #64748b;
    font-size: 15px;
}

.supplier-edit-page .custom-input-group .form-control,
.supplier-edit-page .custom-input-group .form-select {
    min-height: 47px;
    border-color: #e2e8f0;
    border-radius: 0 10px 10px 0;
    color: var(--supplier-text);
    background-color: #ffffff;
    font-size: 12px;
    box-shadow: none;
}

.supplier-edit-page .custom-input-group .form-control::placeholder,
.supplier-edit-page .custom-textarea::placeholder {
    color: #a0aabc;
}

.supplier-edit-page .custom-input-group .form-control:focus,
.supplier-edit-page .custom-input-group .form-select:focus,
.supplier-edit-page .custom-textarea:focus {
    position: relative;
    z-index: 2;
    border-color: #818cf8;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.11);
}

.supplier-edit-page .field-hint {
    margin-top: 8px;
    color: #94a3b8;
    font-size: 10px;
    line-height: 1.6;
}

.supplier-edit-page .money-input .currency-label {
    padding: 0 18px;
    background: #ecfdf5;
    border-color: #bbf7d0;
    color: #047857;
    font-weight: 800;
}

.supplier-edit-page .custom-textarea {
    min-height: 120px;
    padding: 14px;
    border: 1px solid #e2e8f0;
    border-radius: 11px;
    color: var(--supplier-text);
    font-size: 12px;
    resize: vertical;
    box-shadow: none;
}

.supplier-edit-page .validation-alert {
    padding: 18px 20px;
    border: 1px solid #fecaca;
    border-radius: 14px;
    background: #fef2f2;
    color: #991b1b;
    font-size: 12px;
}

.supplier-edit-page .validation-icon {
    color: #dc2626;
    font-size: 22px;
}

.supplier-edit-page .validation-alert ul {
    line-height: 1.9;
}


/* Supplier Profile */

.supplier-edit-page .profile-banner {
    height: 110px;
    padding: 20px;
    position: relative;
    overflow: hidden;
    background: linear-gradient(125deg, #312e81, #4f46e5 65%, #818cf8);
}

.supplier-edit-page .profile-banner-decoration {
    position: absolute;
    width: 170px;
    height: 170px;
    top: -100px;
    right: -25px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 50%;
}

.supplier-edit-page .profile-label {
    position: relative;
    z-index: 1;
    display: inline-block;
    padding: 7px 11px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.12);
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
}

.supplier-edit-page .profile-body {
    padding: 0 23px 25px;
}

.supplier-edit-page .supplier-avatar {
    width: 78px;
    height: 78px;
    margin: -39px auto 14px;
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 5px solid #ffffff;
    border-radius: 22px;
    background: linear-gradient(135deg, #eef2ff, #ddd6fe);
    color: #4338ca;
    font-size: 30px;
    font-weight: 800;
    box-shadow: 0 5px 18px rgba(49, 46, 129, 0.12);
}

.supplier-edit-page .profile-heading h5 {
    color: var(--supplier-text);
    overflow-wrap: anywhere;
}

.supplier-edit-page .supplier-code {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    background: #f1f5f9;
    color: #475569;
    font-size: 11px;
    font-weight: 700;
}

.supplier-edit-page .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 11px;
    border-radius: 30px;
    font-size: 10px;
    font-weight: 700;
}

.supplier-edit-page .status-active {
    background: #dcfce7;
    color: #15803d;
}

.supplier-edit-page .status-inactive {
    background: #f1f5f9;
    color: #64748b;
}

.supplier-edit-page .status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: currentColor;
}

.supplier-edit-page .profile-divider {
    margin: 24px 0;
    border-color: var(--supplier-border);
    opacity: 1;
}

.supplier-edit-page .section-title {
    color: var(--supplier-text);
    font-size: 12px;
}

.supplier-edit-page .profile-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 19px;
}

.supplier-edit-page .contact-icon {
    width: 39px;
    height: 39px;
    flex: 0 0 39px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 16px;
}

.supplier-edit-page .email-icon {
    background: #eef2ff;
    color: #4f46e5;
}

.supplier-edit-page .phone-icon {
    background: #e0f2fe;
    color: #0284c7;
}

.supplier-edit-page .location-icon {
    background: #ccfbf1;
    color: #0f766e;
}

.supplier-edit-page .contact-content {
    min-width: 0;
    padding-top: 2px;
}

.supplier-edit-page .contact-content small {
    display: block;
    margin-bottom: 4px;
    color: #94a3b8;
    font-size: 10px;
}

.supplier-edit-page .contact-value {
    color: #334155;
    font-size: 11px;
    font-weight: 600;
    line-height: 1.7;
    overflow-wrap: anywhere;
}


/* Editing Guide */

.supplier-edit-page .guide-card h6 {
    color: var(--supplier-text);
    font-size: 13px;
}

.supplier-edit-page .guide-item {
    display: flex;
    align-items: flex-start;
    gap: 11px;
    margin-bottom: 21px;
}

.supplier-edit-page .guide-check {
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

.supplier-edit-page .guide-title {
    margin-bottom: 4px;
    color: #334155;
    font-size: 11px;
    font-weight: 700;
}

.supplier-edit-page .guide-description {
    color: #94a3b8;
    font-size: 10px;
    line-height: 1.7;
}


/* Financial Summary */

.supplier-edit-page .balance-card {
    background: linear-gradient(145deg, #ffffff, #ecfdf5);
}

.supplier-edit-page .balance-icon {
    width: 44px;
    height: 44px;
    flex: 0 0 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    background: #d1fae5;
    color: #047857;
    font-size: 20px;
}

.supplier-edit-page .balance-label {
    display: block;
    margin-bottom: 5px;
    color: #64748b;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.6px;
}

.supplier-edit-page .balance-card h5 {
    color: #065f46;
    font-size: 18px;
    overflow-wrap: anywhere;
}

.supplier-edit-page .balance-card p {
    font-size: 10px;
    line-height: 1.8;
}


/* Form Actions */

.supplier-edit-page .form-actions {
    padding: 20px;
    border: 1px solid var(--supplier-border);
    border-radius: 15px;
    background: #ffffff;
}

.supplier-edit-page .action-note {
    color: #64748b;
    font-size: 11px;
}

.supplier-edit-page .save-button,
.supplier-edit-page .cancel-button {
    min-height: 44px;
    padding: 11px 17px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 700;
    transition: all 0.2s ease;
}

.supplier-edit-page .save-button {
    border-color: var(--supplier-primary);
    background: var(--supplier-primary);
    box-shadow: 0 5px 13px rgba(79, 70, 229, 0.15);
}

.supplier-edit-page .save-button:hover {
    border-color: var(--supplier-primary-dark);
    background: var(--supplier-primary-dark);
    transform: translateY(-1px);
}

.supplier-edit-page .cancel-button {
    border: 1px solid var(--supplier-border);
    background: #ffffff;
    color: #475569;
}

.supplier-edit-page .cancel-button:hover {
    background: #f1f5f9;
}

@media (max-width: 767.98px) {

    .supplier-edit-page h2 {
        font-size: 23px;
    }

    .supplier-edit-page .header-badge {
        margin-left: 58px;
    }

    .supplier-edit-page .supplier-card-header {
        padding: 18px;
    }

    .supplier-edit-page .supplier-card-header .required-note {
        margin-left: 58px;
    }

    .supplier-edit-page .profile-body {
        padding-right: 20px;
        padding-left: 20px;
    }

    .supplier-edit-page .form-actions {
        align-items: stretch !important;
    }

    .supplier-edit-page .form-actions > div:last-child {
        width: 100%;
    }

    .supplier-edit-page .form-actions .btn {
        flex: 1 1 auto;
    }

}

@media (prefers-reduced-motion: reduce) {

    .supplier-edit-page .back-button,
    .supplier-edit-page .save-button {
        transition: none;
    }

    .supplier-edit-page .back-button:hover,
    .supplier-edit-page .save-button:hover {
        transform: none;
    }

}
</style>

@endsection
