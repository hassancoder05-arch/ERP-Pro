@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')

<div class="container-fluid py-4 customer-details-page">

{{-- Page Header --}}
<div class="details-header d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="header-icon">
                <i class="bi bi-person-vcard"></i>
            </span>

            <span class="header-label">CUSTOMER MANAGEMENT</span>
        </div>

        <h2 class="fw-bold mb-1">Customer Details</h2>

        <p class="text-muted mb-0">
            View customer profile, contact information and financial details.
        </p>
    </div>

    <div class="d-flex flex-wrap gap-2">

        <a href="{{ route('customers.index') }}" class="btn btn-light border action-btn">
            <i class="bi bi-arrow-left me-2"></i>Back to Customers
        </a>

        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary action-btn">
            <i class="bi bi-pencil-square me-2"></i>Edit Customer
        </a>

    </div>

</div>


{{-- Customer Overview --}}
<div class="row g-4">

    {{-- Left: Customer Profile --}}
    <div class="col-xl-4 col-lg-5">

        <div class="card premium-card profile-card h-100">

            <div class="profile-cover">
                <div class="cover-decoration cover-decoration-one"></div>
                <div class="cover-decoration cover-decoration-two"></div>

                <span class="profile-cover-label">
                    <i class="bi bi-shield-check me-1"></i>
                    Customer Profile
                </span>
            </div>

            <div class="card-body profile-body">

                <div class="customer-avatar">
                    {{ strtoupper(substr($customer->name ?? 'C', 0, 1)) }}
                </div>

                <div class="text-center customer-heading">

                    <h4 class="fw-bold mb-2">
                        {{ $customer->name }}
                    </h4>

                    <div class="customer-code">
                        <i class="bi bi-upc-scan me-1"></i>
                        {{ $customer->customer_id }}
                    </div>

                    <div class="mt-3">

                        @if($customer->status === 'active')
                            <span class="status-badge status-active">
                                <span class="status-dot"></span>
                                Active Customer
                            </span>
                        @else
                            <span class="status-badge status-inactive">
                                <span class="status-dot"></span>
                                Inactive Customer
                            </span>
                        @endif

                    </div>

                </div>

                <hr class="profile-divider">

                {{-- Contact Details --}}
                <div class="section-heading mb-3">
                    <i class="bi bi-person-lines-fill me-2"></i>
                    Contact Information
                </div>

                <div class="contact-item">

                    <div class="contact-icon email-icon">
                        <i class="bi bi-envelope"></i>
                    </div>

                    <div class="contact-content">
                        <small>Email Address</small>

                        <div class="contact-value">
                            @if($customer->email)
                                <a href="mailto:{{ $customer->email }}">
                                    {{ $customer->email }}
                                </a>
                            @else
                                <span class="text-muted">Not provided</span>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="contact-item">

                    <div class="contact-icon phone-icon">
                        <i class="bi bi-telephone"></i>
                    </div>

                    <div class="contact-content">
                        <small>Phone Number</small>

                        <div class="contact-value">
                            @if($customer->phone)
                                <a href="tel:{{ $customer->phone }}">
                                    {{ $customer->phone }}
                                </a>
                            @else
                                <span class="text-muted">Not provided</span>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="contact-item mb-0">

                    <div class="contact-icon location-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>

                    <div class="contact-content">
                        <small>Address</small>

                        <div class="contact-value address-value">
                            {{ $customer->address ?: 'No address provided.' }}
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Right: Financial Details --}}
    <div class="col-xl-8 col-lg-7">

        {{-- Financial Summary --}}
        <div class="row g-3 mb-4">

            <div class="col-md-6">

                <div class="financial-card credit-card h-100">

                    <div class="financial-card-top">
                        <div class="financial-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>

                        <span class="financial-label">CREDIT LIMIT</span>
                    </div>

                    <div class="financial-amount">
                        Rs. {{ number_format((float) ($customer->credit_limit ?? 0), 2) }}
                    </div>

                    <p class="financial-description mb-0">
                        Maximum permitted customer credit
                    </p>

                </div>

            </div>

            <div class="col-md-6">

                <div class="financial-card balance-card h-100">

                    <div class="financial-card-top">
                        <div class="financial-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>

                        <span class="financial-label">OPENING BALANCE</span>
                    </div>

                    <div class="financial-amount">
                        Rs. {{ number_format((float) ($customer->opening_balance ?? 0), 2) }}
                    </div>

                    <p class="financial-description mb-0">
                        Balance recorded when the account was created
                    </p>

                </div>

            </div>

        </div>


        {{-- Financial Information Card --}}
        <div class="card premium-card financial-details-card mb-4">

            <div class="card-header premium-card-header">

                <div class="d-flex align-items-center gap-3">

                    <div class="card-heading-icon">
                        <i class="bi bi-receipt-cutoff"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-1">Financial Information</h5>

                        <p class="text-muted small mb-0">
                            Customer credit and opening account balance
                        </p>
                    </div>

                </div>

            </div>

            <div class="card-body p-4">

                <div class="financial-detail-row">

                    <div class="detail-label">
                        <i class="bi bi-credit-card me-2"></i>
                        Credit Limit
                    </div>

                    <div class="detail-value">
                        Rs. {{ number_format((float) ($customer->credit_limit ?? 0), 2) }}
                    </div>

                </div>

                <div class="financial-detail-row">

                    <div class="detail-label">
                        <i class="bi bi-currency-exchange me-2"></i>
                        Opening Balance
                    </div>

                    <div class="detail-value">
                        Rs. {{ number_format((float) ($customer->opening_balance ?? 0), 2) }}
                    </div>

                </div>

                <div class="financial-detail-row">

                    <div class="detail-label">
                        <i class="bi bi-person-check me-2"></i>
                        Account Status
                    </div>

                    <div>
                        @if($customer->status === 'active')
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

                <div class="financial-detail-row">

                    <div class="detail-label">
                        <i class="bi bi-upc me-2"></i>
                        Customer ID
                    </div>

                    <div class="detail-value customer-id-value">
                        {{ $customer->customer_id }}
                    </div>

                </div>

            </div>

        </div>


        {{-- Address Card --}}
        <div class="card premium-card address-card">

            <div class="card-body p-4">

                <div class="d-flex align-items-start gap-3">

                    <div class="address-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <div class="flex-grow-1">

                        <h5 class="fw-bold mb-2">Billing / Contact Address</h5>

                        <p class="address-text mb-0">
                            {{ $customer->address ?: 'No address has been added for this customer yet.' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- Footer Note --}}
<div class="details-footer mt-4">
    <i class="bi bi-info-circle me-2"></i>
    Customer information is displayed from the current customer record.
</div>


</div>

<style>
/* =====================================
   CUSTOMER DETAILS - PREMIUM UI
===================================== */

.customer-details-page {
    --customer-primary: #4f46e5;
    --customer-primary-dark: #3730a3;
    --customer-text: #172033;
    --customer-muted: #64748b;
    --customer-border: #e8edf5;
    color: var(--customer-text);
}

.customer-details-page .details-header {
    margin-bottom: 28px;
}

.customer-details-page .header-icon {
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    color: var(--customer-primary);
    background: #eef2ff;
    font-size: 19px;
}

.customer-details-page .header-label {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.4px;
    color: var(--customer-primary);
}

.customer-details-page .details-header h2 {
    color: var(--customer-text);
    letter-spacing: -0.7px;
}

.customer-details-page .action-btn {
    min-height: 43px;
    padding: 10px 17px;
    border-radius: 11px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.customer-details-page .btn-primary {
    background: var(--customer-primary);
    border-color: var(--customer-primary);
    box-shadow: 0 5px 12px rgba(79, 70, 229, 0.15);
}

.customer-details-page .btn-primary:hover {
    background: var(--customer-primary-dark);
    border-color: var(--customer-primary-dark);
    transform: translateY(-1px);
}

.customer-details-page .premium-card {
    background: #ffffff;
    border: 1px solid var(--customer-border);
    border-radius: 18px;
    box-shadow: 0 5px 22px rgba(15, 23, 42, 0.045);
    overflow: hidden;
}

.customer-details-page .profile-cover {
    height: 125px;
    padding: 20px;
    position: relative;
    overflow: hidden;
    background: linear-gradient(120deg, #312e81, #4f46e5 65%, #818cf8);
}

.customer-details-page .profile-cover-label {
    position: relative;
    z-index: 2;
    display: inline-block;
    padding: 7px 11px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 20px;
    color: #ffffff;
    background: rgba(255, 255, 255, 0.12);
    font-size: 11px;
    font-weight: 700;
}

.customer-details-page .cover-decoration {
    position: absolute;
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 50%;
}

.customer-details-page .cover-decoration-one {
    width: 190px;
    height: 190px;
    right: -45px;
    top: -100px;
}

.customer-details-page .cover-decoration-two {
    width: 130px;
    height: 130px;
    right: 55px;
    bottom: -100px;
}

.customer-details-page .profile-body {
    padding: 0 25px 28px;
}

.customer-details-page .customer-avatar {
    width: 92px;
    height: 92px;
    margin: -47px auto 14px;
    position: relative;
    z-index: 3;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 5px solid #ffffff;
    border-radius: 25px;
    background: linear-gradient(135deg, #eef2ff, #ddd6fe);
    color: #4338ca;
    font-size: 36px;
    font-weight: 800;
    box-shadow: 0 5px 18px rgba(49, 46, 129, 0.12);
}

.customer-details-page .customer-heading h4 {
    color: var(--customer-text);
    overflow-wrap: anywhere;
}

.customer-details-page .customer-code {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    background: #f1f5f9;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
}

.customer-details-page .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 11px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.customer-details-page .status-active {
    color: #15803d;
    background: #dcfce7;
}

.customer-details-page .status-inactive {
    color: #64748b;
    background: #f1f5f9;
}

.customer-details-page .status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: currentColor;
}

.customer-details-page .profile-divider {
    margin: 25px 0;
    border-color: var(--customer-border);
    opacity: 1;
}

.customer-details-page .section-heading {
    color: var(--customer-text);
    font-size: 13px;
    font-weight: 800;
}

.customer-details-page .section-heading i {
    color: var(--customer-primary);
    font-size: 16px;
}

.customer-details-page .contact-item {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    margin-bottom: 22px;
}

.customer-details-page .contact-icon {
    width: 42px;
    height: 42px;
    flex: 0 0 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    font-size: 17px;
}

.customer-details-page .email-icon {
    color: #4f46e5;
    background: #eef2ff;
}

.customer-details-page .phone-icon {
    color: #0284c7;
    background: #e0f2fe;
}

.customer-details-page .location-icon {
    color: #0f766e;
    background: #ccfbf1;
}

.customer-details-page .contact-content {
    min-width: 0;
    padding-top: 2px;
}

.customer-details-page .contact-content small {
    display: block;
    margin-bottom: 4px;
    color: var(--customer-muted);
    font-size: 11px;
}

.customer-details-page .contact-value {
    color: var(--customer-text);
    font-size: 13px;
    font-weight: 600;
    overflow-wrap: anywhere;
}

.customer-details-page .contact-value a {
    color: inherit;
    text-decoration: none;
}

.customer-details-page .contact-value a:hover {
    color: var(--customer-primary);
}

.customer-details-page .address-value {
    font-weight: 500;
    line-height: 1.6;
}

/* Financial Summary Cards */

.customer-details-page .financial-card {
    position: relative;
    padding: 23px;
    border: 1px solid var(--customer-border);
    border-radius: 17px;
    background: #ffffff;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.customer-details-page .financial-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(15, 23, 42, 0.07);
}

.customer-details-page .credit-card {
    background: linear-gradient(140deg, #ffffff, #f5f3ff);
}

.customer-details-page .balance-card {
    background: linear-gradient(140deg, #ffffff, #ecfdf5);
}

.customer-details-page .financial-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 23px;
}

.customer-details-page .financial-icon {
    width: 43px;
    height: 43px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    background: #e0e7ff;
    color: #4338ca;
    font-size: 20px;
}

.customer-details-page .balance-card .financial-icon {
    background: #d1fae5;
    color: #047857;
}

.customer-details-page .financial-label {
    color: var(--customer-muted);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1px;
}

.customer-details-page .financial-amount {
    margin-bottom: 8px;
    color: var(--customer-text);
    font-size: clamp(20px, 2vw, 26px);
    font-weight: 800;
    letter-spacing: -0.6px;
    overflow-wrap: anywhere;
}

.customer-details-page .financial-description {
    color: var(--customer-muted);
    font-size: 11px;
    line-height: 1.6;
}

/* Financial Details */

.customer-details-page .premium-card-header {
    padding: 20px 24px;
    background: #ffffff;
    border-bottom: 1px solid var(--customer-border);
}

.customer-details-page .card-heading-icon {
    width: 44px;
    height: 44px;
    flex: 0 0 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    background: #eef2ff;
    color: var(--customer-primary);
    font-size: 20px;
}

.customer-details-page .premium-card-header h5 {
    color: var(--customer-text);
}

.customer-details-page .financial-detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 18px;
    padding: 17px 0;
    border-bottom: 1px solid #edf1f7;
}

.customer-details-page .financial-detail-row:first-child {
    padding-top: 0;
}

.customer-details-page .financial-detail-row:last-child {
    padding-bottom: 0;
    border-bottom: 0;
}

.customer-details-page .detail-label {
    color: var(--customer-muted);
    font-size: 13px;
    font-weight: 600;
}

.customer-details-page .detail-label i {
    color: var(--customer-primary);
}

.customer-details-page .detail-value {
    color: var(--customer-text);
    font-size: 14px;
    font-weight: 800;
    text-align: right;
    overflow-wrap: anywhere;
}

.customer-details-page .customer-id-value {
    color: var(--customer-primary);
}

/* Address */

.customer-details-page .address-card {
    background: linear-gradient(120deg, #ffffff, #f8fafc);
}

.customer-details-page .address-icon {
    width: 48px;
    height: 48px;
    flex: 0 0 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    background: #ccfbf1;
    color: #0f766e;
    font-size: 21px;
}

.customer-details-page .address-card h5 {
    color: var(--customer-text);
}

.customer-details-page .address-text {
    color: var(--customer-muted);
    font-size: 13px;
    line-height: 1.8;
    overflow-wrap: anywhere;
}

.customer-details-page .details-footer {
    padding: 15px 18px;
    border: 1px solid var(--customer-border);
    border-radius: 12px;
    background: #ffffff;
    color: var(--customer-muted);
    font-size: 12px;
}

/* Responsive Layout */

@media (max-width: 767.98px) {

    .customer-details-page .details-header h2 {
        font-size: 24px;
    }

    .customer-details-page .details-header .action-btn {
        flex: 1 1 auto;
        text-align: center;
    }

    .customer-details-page .profile-body {
        padding-right: 20px;
        padding-left: 20px;
    }

    .customer-details-page .financial-card {
        padding: 19px;
    }

    .customer-details-page .financial-detail-row {
        align-items: flex-start;
        flex-direction: column;
        gap: 8px;
    }

    .customer-details-page .detail-value {
        text-align: left;
    }

    .customer-details-page .premium-card-header {
        padding: 18px;
    }

}

@media (prefers-reduced-motion: reduce) {

    .customer-details-page .financial-card,
    .customer-details-page .action-btn {
        transition: none;
    }

    .customer-details-page .financial-card:hover,
    .customer-details-page .btn-primary:hover {
        transform: none;
    }

}
</style>

@endsection
