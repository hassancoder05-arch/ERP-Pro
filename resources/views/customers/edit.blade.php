@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex align-items-center mb-4">

        <a href="{{ route('customers.index') }}"
           class="btn btn-light me-3">

            <i class="bi bi-arrow-left"></i>

        </a>

        <div>

            <h2 class="fw-bold mb-1">
                Edit Customer
            </h2>

            <p class="text-muted mb-0">
                Update customer information.
            </p>

        </div>

    </div>

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form action="{{ route('customers.update', $customer) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-person me-2"></i>
                    Customer Information
                </h5>

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label">
                            Customer ID *
                        </label>

                        <input
                            type="text"
                            name="customer_id"
                            class="form-control"
                            value="{{ old('customer_id', $customer->customer_id) }}"
                            required
                        >

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Customer Name *
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $customer->name) }}"
                            required
                        >

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $customer->email) }}"
                        >

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Phone
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone', $customer->phone) }}"
                        >

                    </div>

                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-wallet2 me-2"></i>
                    Financial Information
                </h5>

                <div class="row g-3">

                    <div class="col-md-4">

                        <label class="form-label">
                            Credit Limit
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rs.
                            </span>

                            <input
                                type="number"
                                name="credit_limit"
                                class="form-control"
                                value="{{ old('credit_limit', $customer->credit_limit) }}"
                                min="0"
                                step="0.01"
                            >

                        </div>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Opening Balance
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rs.
                            </span>

                            <input
                                type="number"
                                name="opening_balance"
                                class="form-control"
                                value="{{ old('opening_balance', $customer->opening_balance) }}"
                                step="0.01"
                            >

                        </div>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="active"
                                {{ old('status', $customer->status) === 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old('status', $customer->status) === 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-geo-alt me-2"></i>
                    Address
                </h5>

                <textarea
                    name="address"
                    rows="4"
                    class="form-control mb-4"
                >{{ old('address', $customer->address) }}</textarea>

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('customers.index') }}"
                       class="btn btn-light">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-save me-1"></i>
                        Update Customer

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection