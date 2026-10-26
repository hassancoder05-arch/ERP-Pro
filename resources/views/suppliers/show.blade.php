@extends('layouts.app')

@section('title', 'Supplier Details')

@section('content')

<div class="container-fluid py-4 supplier-details-page">


{{-- Page Header --}}
<div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="header-icon">
                <i class="bi bi-building"></i>
            </span>
            <span class="text-uppercase small fw-semibold text-primary">
                Supplier Management
            </span>
        </div>

        <h2 class="fw-bold mb-1">Supplier Details</h2>

        <p class="text-muted mb-0">
            View supplier profile, contact information and financial details.
        </p>
    </div>

    <div class="d-flex flex-wrap gap-2">

        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary px-3">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Suppliers
        </a>

        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-primary px-4">
            <i class="bi bi-pencil-square me-1"></i>
            Edit Supplier
        </a>

    </div>

</div>

{{-- Summary Cards --}}
<div class="row g-3 mb-4">

    <div class="col-sm-6 col-xl-4">
        <div class="summary-card">
            <div class="summary-icon icon-blue">
                <i class="bi bi-person-badge"></i>
            </div>

            <div>
                <span class="summary-label">Supplier ID</span>
                <h5 class="summary-value mb-0">
                    {{ $supplier->supplier_id }}
                </h5>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="summary-card">
            <div class="summary-icon icon-purple">
                <i class="bi bi-wallet2"></i>
            </div>

            <div>
                <span class="summary-label">Opening Balance</span>
                <h5 class="summary-value mb-0">
                    Rs. {{ number_format((float) ($supplier->opening_balance ?? 0), 2) }}
                </h5>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="summary-card">
            <div class="summary-icon icon-green">
                <i class="bi bi-patch-check"></i>
            </div>

            <div>
                <span class="summary-label">Account Status</span>
                <div class="mt-1">
                    @if($supplier->status === 'active')
                        <span class="status-badge status-active">
                            <span class="status-dot"></span>
                            Active
                        </span>
                    @else
                        <span class="status-badge status-inactive">
                            <span class="status-dot"></span>
                            Inactive
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    {{-- Supplier Profile --}}
    <div class="col-lg-4">

        <div class="details-card profile-card h-100">

            <div class="profile-banner">
                <div class="profile-banner-pattern"></div>
                <span class="profile-banner-label">
                    <i class="bi bi-shield-check me-1"></i>
                    Supplier Profile
                </span>
            </div>

            <div class="card-body profile-body">

                <div class="supplier-avatar">
                    {{ strtoupper(substr($supplier->name ?? 'S', 0, 1)) }}
                </div>

                <h4 class="fw-bold text-center mb-1">
                    {{ $supplier->name }}
                </h4>

                <p class="text-muted text-center mb-3">
                    {{ $supplier->company_name ?: 'Independent Supplier' }}
                </p>

                <div class="text-center mb-4">
                    <span class="supplier-id-badge">
                        <i class="bi bi-hash me-1"></i>
                        {{ $supplier->supplier_id }}
                    </span>
                </div>

                <div class="section-divider"></div>

                <h6 class="section-heading mb-3">
                    <i class="bi bi-person-lines-fill me-2"></i>
                    Contact Information
                </h6>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="bi bi-envelope"></i>
                    </div>

                    <div class="contact-content">
                        <small>Email Address</small>
                        @if($supplier->email)
                            <a href="mailto:{{ $supplier->email }}">
                                {{ $supplier->email }}
                            </a>
                        @else
                            <span class="text-muted">Not provided</span>
                        @endif
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="bi bi-telephone"></i>
                    </div>

                    <div class="contact-content">
                        <small>Phone Number</small>
                        @if($supplier->phone)
                            <a href="tel:{{ $supplier->phone }}">
                                {{ $supplier->phone }}
                            </a>
                        @else
                            <span class="text-muted">Not provided</span>
                        @endif
                    </div>
                </div>

                <div class="contact-item mb-0">
                    <div class="contact-icon">
                        <i class="bi bi-building"></i>
                    </div>

                    <div class="contact-content">
                        <small>Company Name</small>
                        <span>
                            {{ $supplier->company_name ?: 'Not provided' }}
                        </span>
                    </div>
                </div>

                <div class="profile-footer mt-4">
                    <i class="bi bi-info-circle me-2"></i>
                    Supplier information is displayed from your ERP records.
                </div>

            </div>

        </div>

    </div>

    {{-- Supplier Details --}}
    <div class="col-lg-8">

        {{-- General Information --}}
        <div class="details-card mb-4">

            <div class="details-card-header">
                <div class="d-flex align-items-center gap-3">

                    <div class="card-heading-icon">
                        <i class="bi bi-card-list"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">General Information</h5>
                        <p class="text-muted small mb-0">
                            Basic identification and company details
                        </p>
                    </div>

                </div>
            </div>

            <div class="card-body p-4">

                <div class="row g-4">

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">Supplier Name</span>
                            <div class="info-value">
                                {{ $supplier->name ?: 'Not provided' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">Supplier ID</span>
                            <div class="info-value">
                                {{ $supplier->supplier_id }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">Company Name</span>
                            <div class="info-value">
                                {{ $supplier->company_name ?: 'Not provided' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">Account Status</span>
                            <div class="info-value">
                                @if($supplier->status === 'active')
                                    <span class="status-badge status-active">
                                        <span class="status-dot"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="status-badge status-inactive">
                                        <span class="status-dot"></span>
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">Email Address</span>
                            <div class="info-value text-break">
                                {{ $supplier->email ?: 'Not provided' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-field">
                            <span class="info-label">Phone Number</span>
                            <div class="info-value">
                                {{ $supplier->phone ?: 'Not provided' }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        {{-- Financial Information --}}
        <div class="details-card mb-4">

            <div class="details-card-header">
                <div class="d-flex align-items-center gap-3">

                    <div class="card-heading-icon financial-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">Financial Information</h5>
                        <p class="text-muted small mb-0">
                            Initial financial balance recorded for this supplier
                        </p>
                    </div>

                </div>
            </div>

            <div class="card-body p-4">

                <div class="financial-panel">

                    <div class="financial-panel-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>

                    <div>
                        <span class="financial-label">Opening Balance</span>

                        <h3 class="financial-amount mb-1">
                            Rs. {{ number_format((float) ($supplier->opening_balance ?? 0), 2) }}
                        </h3>

                        <p class="text-muted small mb-0">
                            Initial balance saved in the supplier account.
                        </p>
                    </div>

                </div>

                <div class="financial-note mt-3">
                    <i class="bi bi-info-circle me-2"></i>
                    This figure represents the opening balance only. It does not necessarily reflect the current outstanding payable amount.
                </div>

            </div>

        </div>

        {{-- Address --}}
        <div class="details-card">

            <div class="details-card-header">
                <div class="d-flex align-items-center gap-3">

                    <div class="card-heading-icon address-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">Address Information</h5>
                        <p class="text-muted small mb-0">
                            Supplier's registered or business address
                        </p>
                    </div>

                </div>
            </div>

            <div class="card-body p-4">

                <div class="address-box">
                    <div class="address-box-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <div class="address-text">
                        {{ $supplier->address ?: 'No address has been provided for this supplier.' }}
                    </div>
                </div>

            </div>

        </div>

        {{-- Bottom Actions --}}
        <div class="bottom-actions d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4">

            <p class="text-muted small mb-0">
                <i class="bi bi-check-circle me-1"></i>
                Review supplier details before making changes.
            </p>

            <div class="d-flex gap-2">

                <a href="{{ route('suppliers.index') }}" class="btn btn-light border px-3">
                    Close
                </a>

                <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-primary px-4">
                    <i class="bi bi-pencil-square me-1"></i>
                    Edit Supplier
                </a>

            </div>

        </div>

    </div>

</div>


</div>

<style>
.supplier-details-page {
    --supplier-primary: #4f46e5;
    --supplier-primary-light: #eef2ff;
    --supplier-text: #172033;
    --supplier-muted: #718096;
    --supplier-border: #e8edf4;
    color: var(--supplier-text);
}

.supplier-details-page .page-header {
    margin-bottom: 28px;
}

.supplier-details-page .header-icon {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--supplier-primary);
    background: var(--supplier-primary-light);
    font-size: 19px;
}

.supplier-details-page .page-header h2 {
    font-size: clamp(1.5rem, 2vw, 1.9rem);
    letter-spacing: -0.6px;
    color: var(--supplier-text);
}

.supplier-details-page .btn {
    border-radius: 10px;
    font-weight: 600;
    padding-top: 10px;
    padding-bottom: 10px;
    transition: all .2s ease;
}

.supplier-details-page .btn-primary {
    background: var(--supplier-primary);
    border-color: var(--supplier-primary);
    box-shadow: 0 4px 12px rgba(79, 70, 229, .14);
}

.supplier-details-page .btn-primary:hover {
    background: #4338ca;
    border-color: #4338ca;
    transform: translateY(-1px);
}

.supplier-details-page .summary-card {
    height: 100%;
    min-height: 100px;
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    background: #fff;
    border: 1px solid var(--supplier-border);
    border-radius: 15px;
    box-shadow: 0 4px 16px rgba(15, 23, 42, .025);
}

.supplier-details-page .summary-icon {
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    font-size: 21px;
}

.supplier-details-page .icon-blue {
    background: #eaf2ff;
    color: #2563eb;
}

.supplier-details-page .icon-purple {
    background: #f1eaff;
    color: #7c3aed;
}

.supplier-details-page .icon-green {
    background: #e6f8ef;
    color: #15803d;
}

.supplier-details-page .summary-label {
    display: block;
    margin-bottom: 5px;
    font-size: 12px;
    font-weight: 600;
    color: var(--supplier-muted);
}

.supplier-details-page .summary-value {
    font-size: 17px;
    font-weight: 750;
    overflow-wrap: anywhere;
}

.supplier-details-page .details-card {
    overflow: hidden;
    background: #fff;
    border: 1px solid var(--supplier-border);
    border-radius: 16px;
    box-shadow: 0 5px 20px rgba(15, 23, 42, .035);
}

.supplier-details-page .profile-banner {
    height: 112px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: flex-start;
    justify-content: flex-end;
    padding: 17px;
    background: linear-gradient(120deg, #3730a3, #6366f1 60%, #818cf8);
}

.supplier-details-page .profile-banner-pattern {
    position: absolute;
    width: 190px;
    height: 190px;
    right: -45px;
    top: -95px;
    border: 1px solid rgba(255,255,255,.22);
    border-radius: 50%;
    box-shadow:
        0 0 0 20px rgba(255,255,255,.05),
        0 0 0 42px rgba(255,255,255,.04);
}

.supplier-details-page .profile-banner-label {
    position: relative;
    z-index: 1;
    padding: 6px 10px;
    color: #fff;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.22);
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
}

.supplier-details-page .profile-body {
    padding: 0 24px 24px;
}

.supplier-details-page .supplier-avatar {
    position: relative;
    width: 86px;
    height: 86px;
    margin: -43px auto 17px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 5px solid #fff;
    border-radius: 25px;
    background: linear-gradient(135deg, #eef2ff, #dbeafe);
    color: #4338ca;
    font-size: 34px;
    font-weight: 800;
    box-shadow: 0 5px 18px rgba(15, 23, 42, .10);
}

.supplier-details-page .profile-body h4 {
    font-size: 21px;
    overflow-wrap: anywhere;
}

.supplier-details-page .supplier-id-badge {
    display: inline-block;
    padding: 7px 13px;
    border: 1px solid #dbeafe;
    border-radius: 8px;
    color: #3730a3;
    background: #eef2ff;
    font-size: 12px;
    font-weight: 700;
}

.supplier-details-page .section-divider {
    height: 1px;
    margin: 23px 0;
    background: var(--supplier-border);
}

.supplier-details-page .section-heading {
    font-size: 13px;
    font-weight: 750;
}

.supplier-details-page .section-heading i {
    color: var(--supplier-primary);
}

.supplier-details-page .contact-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 19px;
}

.supplier-details-page .contact-icon {
    width: 37px;
    height: 37px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #f1f5f9;
    color: #475569;
    font-size: 16px;
}

.supplier-details-page .contact-content {
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.supplier-details-page .contact-content small {
    color: var(--supplier-muted);
    font-size: 11px;
    font-weight: 600;
}

.supplier-details-page .contact-content span,
.supplier-details-page .contact-content a {
    color: var(--supplier-text);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    overflow-wrap: anywhere;
}

.supplier-details-page .contact-content a:hover {
    color: var(--supplier-primary);
}

.supplier-details-page .profile-footer {
    padding: 12px;
    border-radius: 10px;
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    line-height: 1.6;
}

.supplier-details-page .details-card-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--supplier-border);
    background: #fff;
}

.supplier-details-page .details-card-header h5 {
    color: var(--supplier-text);
    font-size: 16px;
}

.supplier-details-page .details-card-header p {
    font-size: 12px;
}

.supplier-details-page .card-heading-icon {
    width: 43px;
    height: 43px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #eef2ff;
    color: var(--supplier-primary);
    font-size: 20px;
}

.supplier-details-page .financial-icon {
    background: #e6f8ef;
    color: #15803d;
}

.supplier-details-page .address-icon {
    background: #fff4e5;
    color: #c2410c;
}

.supplier-details-page .info-field {
    min-height: 67px;
}

.supplier-details-page .info-label {
    display: block;
    margin-bottom: 8px;
    color: var(--supplier-muted);
    font-size: 12px;
    font-weight: 600;
}

.supplier-details-page .info-value {
    color: var(--supplier-text);
    font-size: 14px;
    font-weight: 650;
    overflow-wrap: anywhere;
}

.supplier-details-page .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 6px 11px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 750;
}

.supplier-details-page .status-active {
    color: #15803d;
    background: #dcfce7;
}

.supplier-details-page .status-inactive {
    color: #64748b;
    background: #f1f5f9;
}

.supplier-details-page .status-dot {
    width: 6px;
    height: 6px;
    display: inline-block;
    border-radius: 50%;
    background: currentColor;
}

.supplier-details-page .financial-panel {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 22px;
    border: 1px solid #d9f0e3;
    border-radius: 13px;
    background: linear-gradient(120deg, #f0fdf4, #ffffff);
}

.supplier-details-page .financial-panel-icon {
    width: 55px;
    height: 55px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
    color: #15803d;
    background: #dcfce7;
    font-size: 25px;
}

.supplier-details-page .financial-label {
    display: block;
    margin-bottom: 5px;
    color: #64748b;
    font-size: 12px;
    font-weight: 650;
}

.supplier-details-page .financial-amount {
    color: #166534;
    font-size: clamp(20px, 3vw, 28px);
    font-weight: 800;
    overflow-wrap: anywhere;
}

.supplier-details-page .financial-note {
    display: flex;
    align-items: flex-start;
    padding: 12px 14px;
    border-radius: 9px;
    color: #64748b;
    background: #f8fafc;
    font-size: 11px;
    line-height: 1.7;
}

.supplier-details-page .financial-note i {
    margin-top: 2px;
    color: #64748b;
}

.supplier-details-page .address-box {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 18px;
    border: 1px solid var(--supplier-border);
    border-radius: 12px;
    background: #f8fafc;
}

.supplier-details-page .address-box-icon {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    color: #c2410c;
    background: #ffedd5;
    font-size: 18px;
}

.supplier-details-page .address-text {
    padding-top: 8px;
    color: #475569;
    font-size: 14px;
    line-height: 1.8;
    overflow-wrap: anywhere;
    white-space: pre-line;
}

.supplier-details-page .bottom-actions {
    padding: 17px 0 0;
    border-top: 1px solid var(--supplier-border);
}

@media (max-width: 767.98px) {
    .supplier-details-page .details-card-header {
        padding: 17px;
    }

    .supplier-details-page .details-card .card-body {
        padding: 20px !important;
    }

    .supplier-details-page .profile-body {
        padding: 0 20px 20px !important;
    }

    .supplier-details-page .summary-card {
        padding: 15px;
    }

    .supplier-details-page .bottom-actions {
        align-items: stretch !important;
    }

    .supplier-details-page .bottom-actions > div {
        width: 100%;
    }

    .supplier-details-page .bottom-actions .btn {
        flex: 1;
    }
}
</style>

@endsection
