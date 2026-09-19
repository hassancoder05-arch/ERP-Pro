@extends('layouts.app')

@section('title', 'Settings')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-1">
            <i class="bi bi-gear me-2"></i>
            System Settings
        </h2>

        <p class="text-muted mb-0">
            Configure your company and invoice information.
        </p>
    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('settings.update') }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        {{-- Company Information --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="fw-bold mb-0">
                    <i class="bi bi-building me-2"></i>
                    Company Information
                </h5>

            </div>

            <div class="card-body">

                <div class="row g-4">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Company Name
                        </label>

                        <input
                            type="text"
                            name="company_name"
                            class="form-control"
                            value="{{ old('company_name', $settings->company_name) }}"
                            placeholder="Your Company Name"
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Company Email
                        </label>

                        <input
                            type="email"
                            name="company_email"
                            class="form-control"
                            value="{{ old('company_email', $settings->company_email) }}"
                            placeholder="company@example.com"
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Company Phone
                        </label>

                        <input
                            type="text"
                            name="company_phone"
                            class="form-control"
                            value="{{ old('company_phone', $settings->company_phone) }}"
                            placeholder="+92 XXX XXXXXXX"
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Currency
                        </label>

                        <select
                            name="currency"
                            class="form-select"
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


                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Company Address
                        </label>

                        <textarea
                            name="company_address"
                            rows="3"
                            class="form-control"
                            placeholder="Enter company address"
                        >{{ old('company_address', $settings->company_address) }}</textarea>

                    </div>

                </div>

            </div>

        </div>


        {{-- Invoice Settings --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="fw-bold mb-0">
                    <i class="bi bi-receipt me-2"></i>
                    Invoice Settings
                </h5>

            </div>

            <div class="card-body">

                <div class="row g-4">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Invoice Prefix
                        </label>

                        <input
                            type="text"
                            name="invoice_prefix"
                            class="form-control"
                            value="{{ old('invoice_prefix', $settings->invoice_prefix) }}"
                            placeholder="INV"
                        >

                        <small class="text-muted">
                            Example: INV-20260912-1234
                        </small>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Invoice Footer
                        </label>

                        <input
                            type="text"
                            name="invoice_footer"
                            class="form-control"
                            value="{{ old('invoice_footer', $settings->invoice_footer) }}"
                            placeholder="Thank you for your business!"
                        >

                    </div>

                </div>

            </div>

        </div>


        {{-- Save --}}
        <div class="d-flex justify-content-end">

            <button
                type="submit"
                class="btn btn-primary px-4"
            >

                <i class="bi bi-save me-2"></i>

                Save Settings

            </button>

        </div>

    </form>

</div>

@endsection