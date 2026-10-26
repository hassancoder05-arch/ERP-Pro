@extends('layouts.app')

@section('title', 'Settings')

@section('content')

<div class="container-fluid py-4 settings-dashboard">


{{-- Page Header --}}
<div class="settings-page-header d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div class="d-flex align-items-center gap-3">

        <div class="settings-header-icon">
            <i class="bi bi-gear-wide-connected"></i>
        </div>

        <div>
            <h2 class="fw-bold mb-1">System Settings</h2>

            <p class="text-muted mb-0">
                Configure your company profile and invoice preferences.
            </p>
        </div>

    </div>

    <div class="settings-header-badge">
        <i class="bi bi-shield-check me-2"></i>
        System Configuration
    </div>

</div>


{{-- Success Message --}}
@if(session('success'))

    <div class="alert settings-alert settings-success-alert alert-dismissible fade show mb-4" role="alert">

        <div class="d-flex align-items-center gap-3">

            <div class="alert-icon success-alert-icon">
                <i class="bi bi-check-lg"></i>
            </div>

            <div>
                <h6 class="fw-bold mb-1">Settings Updated</h6>
                <p class="mb-0">{{ session('success') }}</p>
            </div>

        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close">
        </button>

    </div>

@endif


{{-- Validation Errors --}}
@if($errors->any())

    <div class="alert settings-alert settings-error-alert alert-dismissible fade show mb-4" role="alert">

        <div class="d-flex align-items-start gap-3">

            <div class="alert-icon error-alert-icon">
                <i class="bi bi-exclamation-lg"></i>
            </div>

            <div class="flex-grow-1">

                <h6 class="fw-bold mb-2">
                    Please check the following errors
                </h6>

                <ul class="mb-0 ps-3">

                    @foreach($errors->all() as $error)

                        <li class="mb-1">{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close">
        </button>

    </div>

@endif


{{-- Settings Form --}}
<form
    action="{{ route('settings.update') }}"
    method="POST"
>

    @csrf
    @method('PUT')


    {{-- Company Information --}}
    <div class="card settings-card mb-4">

        <div class="card-header settings-section-header">

            <div class="d-flex align-items-center gap-3">

                <div class="settings-section-icon company-section-icon">
                    <i class="bi bi-building"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">
                        Company Information
                    </h5>

                    <p class="text-muted small mb-0">
                        Manage your business identity and contact details.
                    </p>
                </div>

            </div>

            <span class="settings-section-number">01</span>

        </div>


        <div class="card-body p-4">

            <div class="row g-4">

                {{-- Company Name --}}
                <div class="col-lg-6">

                    <label for="company_name" class="form-label settings-label">
                        Company Name
                    </label>

                    <div class="settings-input-wrapper">

                        <span class="settings-input-icon">
                            <i class="bi bi-building"></i>
                        </span>

                        <input
                            type="text"
                            id="company_name"
                            name="company_name"
                            class="form-control settings-input"
                            value="{{ old('company_name', $settings->company_name) }}"
                            placeholder="Enter your company name"
                            autocomplete="organization"
                        >

                    </div>

                </div>


                {{-- Company Email --}}
                <div class="col-lg-6">

                    <label for="company_email" class="form-label settings-label">
                        Company Email
                    </label>

                    <div class="settings-input-wrapper">

                        <span class="settings-input-icon">
                            <i class="bi bi-envelope"></i>
                        </span>

                        <input
                            type="email"
                            id="company_email"
                            name="company_email"
                            class="form-control settings-input"
                            value="{{ old('company_email', $settings->company_email) }}"
                            placeholder="company@example.com"
                            autocomplete="email"
                        >

                    </div>

                </div>


                {{-- Company Phone --}}
                <div class="col-lg-6">

                    <label for="company_phone" class="form-label settings-label">
                        Company Phone
                    </label>

                    <div class="settings-input-wrapper">

                        <span class="settings-input-icon">
                            <i class="bi bi-telephone"></i>
                        </span>

                        <input
                            type="text"
                            id="company_phone"
                            name="company_phone"
                            class="form-control settings-input"
                            value="{{ old('company_phone', $settings->company_phone) }}"
                            placeholder="+92 XXX XXXXXXX"
                            autocomplete="tel"
                        >

                    </div>

                </div>


                {{-- Currency --}}
                <div class="col-lg-6">

                    <label for="currency" class="form-label settings-label">
                        Currency
                    </label>

                    <div class="settings-input-wrapper">

                        <span class="settings-input-icon">
                            <i class="bi bi-currency-exchange"></i>
                        </span>

                        <select
                            id="currency"
                            name="currency"
                            class="form-select settings-input settings-select"
                        >

                            <option
                                value="PKR"
                                {{ old('currency', $settings->currency) == 'PKR' ? 'selected' : '' }}
                            >
                                PKR - Pakistani Rupee
                            </option>

                            <option
                                value="USD"
                                {{ old('currency', $settings->currency) == 'USD' ? 'selected' : '' }}
                            >
                                USD - US Dollar
                            </option>

                            <option
                                value="EUR"
                                {{ old('currency', $settings->currency) == 'EUR' ? 'selected' : '' }}
                            >
                                EUR - Euro
                            </option>

                            <option
                                value="GBP"
                                {{ old('currency', $settings->currency) == 'GBP' ? 'selected' : '' }}
                            >
                                GBP - British Pound
                            </option>

                        </select>

                    </div>

                    <small class="settings-help-text">
                        <i class="bi bi-info-circle me-1"></i>
                        Select the currency used by your business.
                    </small>

                </div>


                {{-- Company Address --}}
                <div class="col-12">

                    <label for="company_address" class="form-label settings-label">
                        Company Address
                    </label>

                    <div class="settings-textarea-wrapper">

                        <span class="settings-textarea-icon">
                            <i class="bi bi-geo-alt"></i>
                        </span>

                        <textarea
                            id="company_address"
                            name="company_address"
                            rows="4"
                            class="form-control settings-textarea"
                            placeholder="Enter your complete company address"
                        >{{ old('company_address', $settings->company_address) }}</textarea>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Invoice Settings --}}
    <div class="card settings-card mb-4">

        <div class="card-header settings-section-header">

            <div class="d-flex align-items-center gap-3">

                <div class="settings-section-icon invoice-section-icon">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-1">
                        Invoice Settings
                    </h5>

                    <p class="text-muted small mb-0">
                        Customize invoice numbering and customer-facing messages.
                    </p>
                </div>

            </div>

            <span class="settings-section-number">02</span>

        </div>


        <div class="card-body p-4">

            <div class="row g-4">

                {{-- Invoice Prefix --}}
                <div class="col-lg-6">

                    <label for="invoice_prefix" class="form-label settings-label">
                        Invoice Prefix
                    </label>

                    <div class="settings-input-wrapper">

                        <span class="settings-input-icon">
                            <i class="bi bi-hash"></i>
                        </span>

                        <input
                            type="text"
                            id="invoice_prefix"
                            name="invoice_prefix"
                            class="form-control settings-input"
                            value="{{ old('invoice_prefix', $settings->invoice_prefix) }}"
                            placeholder="INV"
                        >

                    </div>

                    <div class="settings-help-box mt-3">

                        <i class="bi bi-lightbulb me-2"></i>

                        <div>
                            <strong>Invoice number prefix</strong>

                            <p class="mb-0 mt-1">
                                Example: INV-20260912-1234
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Invoice Footer --}}
                <div class="col-lg-6">

                    <label for="invoice_footer" class="form-label settings-label">
                        Invoice Footer Message
                    </label>

                    <div class="settings-input-wrapper">

                        <span class="settings-input-icon">
                            <i class="bi bi-chat-square-text"></i>
                        </span>

                        <input
                            type="text"
                            id="invoice_footer"
                            name="invoice_footer"
                            class="form-control settings-input"
                            value="{{ old('invoice_footer', $settings->invoice_footer) }}"
                            placeholder="Thank you for your business!"
                        >

                    </div>

                    <div class="settings-help-box mt-3">

                        <i class="bi bi-info-circle me-2"></i>

                        <div>
                            <strong>Customer-facing message</strong>

                            <p class="mb-0 mt-1">
                                Display a short message at the bottom of invoices.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Save Settings Footer --}}
    <div class="settings-save-panel">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="save-info-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>

                <div>
                    <h6 class="fw-bold mb-1">
                        Save your configuration
                    </h6>

                    <p class="text-muted small mb-0">
                        Review your details before saving changes.
                    </p>
                </div>

            </div>

            <button
                type="submit"
                class="btn btn-primary settings-save-btn"
            >
                <i class="bi bi-floppy me-2"></i>
                Save Settings
            </button>

        </div>

    </div>

</form>


</div>

{{-- System Settings Styles --}}

<style>
    .settings-dashboard {
        --settings-primary: #4f46e5;
        --settings-border: #e8edf4;
        --settings-muted: #64748b;
        color: #1e293b;
    }

    .settings-dashboard .settings-page-header {
        margin-bottom: 28px;
    }

    .settings-dashboard .settings-header-icon {
        width: 58px;
        height: 58px;
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 27px;
    }

    .settings-dashboard .settings-header-badge {
        padding: 11px 15px;
        border: 1px solid #e0e7ff;
        border-radius: 11px;
        background: #f5f7ff;
        color: #4338ca;
        font-size: 12px;
        font-weight: 700;
    }

    .settings-dashboard .settings-card {
        border: 1px solid var(--settings-border) !important;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.035);
        overflow: hidden;
        transition: box-shadow 0.2s ease;
    }

    .settings-dashboard .settings-card:hover {
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    .settings-dashboard .settings-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 20px 24px;
        background: #fff;
        border-bottom: 1px solid var(--settings-border);
    }

    .settings-dashboard .settings-section-icon {
        width: 46px;
        height: 46px;
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
        font-size: 21px;
    }

    .settings-dashboard .company-section-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .settings-dashboard .invoice-section-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .settings-dashboard .settings-section-number {
        color: #94a3b8;
        font-size: 18px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .settings-dashboard .settings-label {
        display: block;
        margin-bottom: 9px;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .settings-dashboard .settings-input-wrapper {
        position: relative;
    }

    .settings-dashboard .settings-input-icon {
        position: absolute;
        top: 50%;
        left: 14px;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 16px;
        pointer-events: none;
        transform: translateY(-50%);
    }

    .settings-dashboard .settings-input {
        width: 100%;
        min-height: 47px;
        border: 1px solid #dce3ed;
        border-radius: 10px;
        background-color: #fff;
        color: #1e293b;
        padding: 11px 13px 11px 42px;
        font-size: 13px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .settings-dashboard .settings-input::placeholder,
    .settings-dashboard .settings-textarea::placeholder {
        color: #a0aaba;
    }

    .settings-dashboard .settings-input:focus,
    .settings-dashboard .settings-textarea:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .settings-dashboard .settings-select {
        cursor: pointer;
        padding-right: 34px;
    }

    .settings-dashboard .settings-help-text {
        display: block;
        margin-top: 9px;
        color: #64748b;
        font-size: 11px;
    }

    .settings-dashboard .settings-textarea-wrapper {
        position: relative;
    }

    .settings-dashboard .settings-textarea-icon {
        position: absolute;
        top: 15px;
        left: 14px;
        z-index: 2;
        color: #94a3b8;
        font-size: 17px;
        pointer-events: none;
    }

    .settings-dashboard .settings-textarea {
        display: block;
        width: 100%;
        min-height: 110px;
        resize: vertical;
        border: 1px solid #dce3ed;
        border-radius: 10px;
        padding: 13px 14px 13px 42px;
        color: #1e293b;
        font-size: 13px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .settings-dashboard .settings-help-box {
        display: flex;
        align-items: flex-start;
        gap: 5px;
        padding: 13px;
        border: 1px solid #e8edf4;
        border-radius: 10px;
        background: #f8fafc;
        color: #64748b;
        font-size: 12px;
    }

    .settings-dashboard .settings-help-box > i {
        margin-top: 2px;
        color: #6366f1;
    }

    .settings-dashboard .settings-help-box strong {
        color: #334155;
        font-size: 12px;
    }

    .settings-dashboard .settings-save-panel {
        padding: 20px 24px;
        border: 1px solid #e0e7ff;
        border-radius: 15px;
        background: #f8faff;
    }

    .settings-dashboard .save-info-icon {
        width: 44px;
        height: 44px;
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 20px;
    }

    .settings-dashboard .settings-save-btn {
        min-height: 47px;
        padding: 12px 23px;
        border: 1px solid var(--settings-primary);
        border-radius: 10px;
        background: var(--settings-primary);
        font-size: 13px;
        font-weight: 700;
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .settings-dashboard .settings-save-btn:hover {
        background: #4338ca;
        border-color: #4338ca;
        transform: translateY(-1px);
    }

    .settings-dashboard .settings-alert {
        padding: 18px 50px 18px 18px;
        border-radius: 13px;
    }

    .settings-dashboard .settings-success-alert {
        border: 1px solid #bbf7d0;
        background: #f0fdf4;
        color: #166534;
    }

    .settings-dashboard .settings-error-alert {
        border: 1px solid #fecaca;
        background: #fef2f2;
        color: #991b1b;
    }

    .settings-dashboard .alert-icon {
        width: 38px;
        height: 38px;
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        font-size: 21px;
    }

    .settings-dashboard .success-alert-icon {
        background: #dcfce7;
        color: #15803d;
    }

    .settings-dashboard .error-alert-icon {
        background: #fee2e2;
        color: #dc2626;
    }

    .settings-dashboard .settings-alert .btn-close {
        position: absolute;
        top: 18px;
        right: 18px;
    }

    @media (max-width: 767.98px) {
        .settings-dashboard {
            padding-top: 16px !important;
        }

        .settings-dashboard .settings-header-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            font-size: 23px;
        }

        .settings-dashboard h2 {
            font-size: 22px;
        }

        .settings-dashboard .settings-header-badge {
            width: 100%;
            text-align: center;
        }

        .settings-dashboard .settings-section-header {
            padding: 16px;
        }

        .settings-dashboard .settings-section-icon {
            width: 40px;
            height: 40px;
            font-size: 19px;
        }

        .settings-dashboard .settings-section-number {
            font-size: 14px;
        }

        .settings-dashboard .settings-card .card-body {
            padding: 20px !important;
        }

        .settings-dashboard .settings-save-panel {
            padding: 18px;
        }

        .settings-dashboard .settings-save-btn {
            width: 100%;
        }
    }
</style>

@endsection
