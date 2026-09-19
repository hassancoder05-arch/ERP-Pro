@extends('layouts.app')

@section('title', 'Add Employee')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex align-items-center mb-4">

        <a href="{{ route('employees.index') }}"
           class="btn btn-light me-3">

            <i class="bi bi-arrow-left"></i>

        </a>

        <div>
            <h2 class="fw-bold mb-1">Add Employee</h2>
            <p class="text-muted mb-0">
                Create a new employee record.
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

            <form action="{{ route('employees.store') }}"
                  method="POST">

                @csrf

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-person me-2"></i>
                    Personal Information
                </h5>

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label">
                            Employee ID <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="employee_id"
                            class="form-control @error('employee_id') is-invalid @enderror"
                            value="{{ old('employee_id') }}"
                            placeholder="EMP-001"
                            required
                        >

                        @error('employee_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            First Name <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="first_name"
                            class="form-control @error('first_name') is-invalid @enderror"
                            value="{{ old('first_name') }}"
                            placeholder="Hassan"
                            required
                        >

                        @error('first_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Last Name
                        </label>

                        <input
                            type="text"
                            name="last_name"
                            class="form-control"
                            value="{{ old('last_name') }}"
                            placeholder="Mehmood"
                        >

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Email <span class="text-danger">*</span>
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="employee@example.com"
                            required
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

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
                            Joining Date
                        </label>

                        <input
                            type="date"
                            name="joining_date"
                            class="form-control"
                            value="{{ old('joining_date') }}"
                        >

                    </div>

                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-briefcase me-2"></i>
                    Employment Information
                </h5>

                <div class="row g-3">

                    <div class="col-md-4">

                        <label class="form-label">
                            Department
                        </label>

                        <select name="department"
                                class="form-select">

                            <option value="">Select Department</option>

                            <option value="HR"
                                {{ old('department') == 'HR' ? 'selected' : '' }}>
                                HR
                            </option>

                            <option value="Sales"
                                {{ old('department') == 'Sales' ? 'selected' : '' }}>
                                Sales
                            </option>

                            <option value="Finance"
                                {{ old('department') == 'Finance' ? 'selected' : '' }}>
                                Finance
                            </option>

                            <option value="Inventory"
                                {{ old('department') == 'Inventory' ? 'selected' : '' }}>
                                Inventory
                            </option>

                            <option value="IT"
                                {{ old('department') == 'IT' ? 'selected' : '' }}>
                                IT
                            </option>

                            <option value="Management"
                                {{ old('department') == 'Management' ? 'selected' : '' }}>
                                Management
                            </option>

                        </select>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Designation
                        </label>

                        <input
                            type="text"
                            name="designation"
                            class="form-control"
                            value="{{ old('designation') }}"
                            placeholder="Software Developer"
                        >

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Salary <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rs.
                            </span>

                            <input
                                type="number"
                                name="salary"
                                class="form-control"
                                value="{{ old('salary', 0) }}"
                                min="0"
                                step="0.01"
                                required
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
                    <i class="bi bi-geo-alt me-2"></i>
                    Address
                </h5>

                <div class="mb-4">

                    <textarea
                        name="address"
                        rows="4"
                        class="form-control"
                        placeholder="Enter employee address..."
                    >{{ old('address') }}</textarea>

                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('employees.index') }}"
                       class="btn btn-light">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-check-lg me-1"></i>
                        Save Employee

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection