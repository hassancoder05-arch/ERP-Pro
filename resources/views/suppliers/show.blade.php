@extends('layouts.app')

@section('title', 'Supplier Details')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Supplier Details
            </h2>

            <p class="text-muted mb-0">
                View supplier information.
            </p>

        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('suppliers.index') }}"
               class="btn btn-light">

                <i class="bi bi-arrow-left me-1"></i>
                Back

            </a>

            <a href="{{ route('suppliers.edit', $supplier) }}"
               class="btn btn-primary">

                <i class="bi bi-pencil me-1"></i>
                Edit

            </a>

        </div>

    </div>

    <div class="row g-4">

        {{-- Profile --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center p-4">

                    <div class="supplier-avatar mx-auto mb-3">

                        {{ strtoupper(substr($supplier->name, 0, 1)) }}

                    </div>

                    <h4 class="fw-bold mb-1">
                        {{ $supplier->name }}
                    </h4>

                    <p class="text-muted mb-2">
                        {{ $supplier->company_name ?? 'Supplier' }}
                    </p>

                    <span class="badge bg-primary-subtle text-primary">

                        {{ $supplier->supplier_id }}

                    </span>

                    <hr>

                    <div class="text-start">

                        <div class="mb-3">

                            <small class="text-muted d-block">
                                Email
                            </small>

                            <span>
                                {{ $supplier->email ?? 'Not provided' }}
                            </span>

                        </div>

                        <div class="mb-3">

                            <small class="text-muted d-block">
                                Phone
                            </small>

                            <span>
                                {{ $supplier->phone ?? 'Not provided' }}
                            </span>

                        </div>

                        <div>

                            <small class="text-muted d-block">
                                Status
                            </small>

                            @if($supplier->status === 'active')

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

        {{-- Details --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0 fw-bold">
                        Supplier Information
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Supplier ID
                            </small>

                            <strong>
                                {{ $supplier->supplier_id }}
                            </strong>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Company
                            </small>

                            <strong>
                                {{ $supplier->company_name ?? 'Not provided' }}
                            </strong>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Opening Balance
                            </small>

                            <h5 class="fw-bold">
                                Rs. {{ number_format($supplier->opening_balance, 2) }}
                            </h5>

                        </div>

                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold mb-3">
                        Address
                    </h6>

                    <p class="text-muted mb-0">

                        {{ $supplier->address ?? 'No address provided.' }}

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

.supplier-avatar {
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