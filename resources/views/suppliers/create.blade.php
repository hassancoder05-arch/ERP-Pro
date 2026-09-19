@extends('layouts.app')

@section('title', 'Add Supplier')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex align-items-center mb-4">

        <a href="{{ route('suppliers.index') }}"
           class="btn btn-light me-3">

            <i class="bi bi-arrow-left"></i>

        </a>

        <div>

            <h2 class="fw-bold mb-1">
                Add Supplier
            </h2>

            <p class="text-muted mb-0">
                Create a new supplier record.
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

            <form action="{{ route('suppliers.store') }}"
                  method="POST">

                @csrf

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-building me-2"></i>
                    Supplier Information
                </h5>

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label">
                            Supplier ID *
                        </label>

                        <input
                            type="text"
                            name="supplier_id"
                            class="form-control @error('supplier_id') is-invalid @enderror"
                            value="{{ old('supplier_id') }}"
                            placeholder="SUP-001"
                            required
                        >

                        @error('supplier_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Supplier Name *
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Supplier name"
                            required
                        >

                        @error('name')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Company Name
                        </label>

                        <input
                            type="text"
                            name="company_name"
                            class="form-control"
                            value="{{ old('company_name') }}"
                            placeholder="Company name"
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
                            value="{{ old('email') }}"
                            placeholder="supplier@example.com"
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
                            value="{{ old('phone') }}"
                            placeholder="+92 300 1234567"
                        >

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

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

                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-wallet2 me-2"></i>
                    Financial Information
                </h5>

                <div class="row g-3">

                    <div class="col-md-6">

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
                                value="{{ old('opening_balance', 0) }}"
                                step="0.01"
                            >

                        </div>

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
                    placeholder="Enter supplier address..."
                >{{ old('address') }}</textarea>

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('suppliers.index') }}"
                       class="btn btn-light">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-check-lg me-1"></i>
                        Save Supplier

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection