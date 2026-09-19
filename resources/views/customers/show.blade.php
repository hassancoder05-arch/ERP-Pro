@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Customer Details
            </h2>

            <p class="text-muted mb-0">
                View customer information.
            </p>

        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('customers.index') }}"
               class="btn btn-light">

                <i class="bi bi-arrow-left me-1"></i>
                Back

            </a>

            <a href="{{ route('customers.edit', $customer) }}"
               class="btn btn-primary">

                <i class="bi bi-pencil me-1"></i>
                Edit

            </a>

        </div>

    </div>

    <div class="row g-4">

        {{-- Customer Profile --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center p-4">

                    <div class="customer-avatar mx-auto mb-3">

                        {{ strtoupper(substr($customer->name, 0, 1)) }}

                    </div>

                    <h4 class="fw-bold mb-1">
                        {{ $customer->name }}
                    </h4>

                    <p class="text-muted mb-2">
                        Customer
                    </p>

                    <span class="badge bg-primary-subtle text-primary">
                        {{ $customer->customer_id }}
                    </span>

                    <hr>

                    <div class="text-start">

                        <div class="mb-3">

                            <small class="text-muted d-block">
                                Email
                            </small>

                            <span>
                                {{ $customer->email ?? 'Not provided' }}
                            </span>

                        </div>

                        <div class="mb-3">

                            <small class="text-muted d-block">
                                Phone
                            </small>

                            <span>
                                {{ $customer->phone ?? 'Not provided' }}
                            </span>

                        </div>

                        <div>

                            <small class="text-muted d-block">
                                Status
                            </small>

                            @if($customer->status === 'active')

                                <span class="badge bg-success">
                                    Active
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Inactive
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Financial Information --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0 fw-bold">
                        Financial Information
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Credit Limit
                            </small>

                            <h5 class="fw-bold">
                                Rs. {{ number_format($customer->credit_limit, 2) }}
                            </h5>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Opening Balance
                            </small>

                            <h5 class="fw-bold">
                                Rs. {{ number_format($customer->opening_balance, 2) }}
                            </h5>

                        </div>

                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold mb-3">
                        Address
                    </h6>

                    <p class="text-muted mb-0">

                        {{ $customer->address ?? 'No address provided.' }}

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

.customer-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e9ecef;
    font-size: 32px;
    font-weight: 700;
}

</style>

@endsection