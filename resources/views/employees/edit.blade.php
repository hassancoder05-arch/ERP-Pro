@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex align-items-center mb-4">

        <a href="{{ route('employees.index') }}"
           class="btn btn-light me-3">

            <i class="bi bi-arrow-left"></i>

        </a>

        <div>
            <h2 class="fw-bold mb-1">Edit Employee</h2>

            <p class="text-muted mb-0">
                Update {{ $employee->first_name }}'s information.
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

            <form action="{{ route('employees.update', $employee) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-person me-2"></i>
                    Personal Information
                </h5>

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label">
                            Employee ID *
                        </label>

                        <input
                            type="text"
                            name="employee_id"
                            class="form-control"
                            value="{{ old('employee_id', $employee->employee_id) }}"
                            required
                        >

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            First Name *
                        </label>

                        <input
                            type="text"
                            name="first_name"
                            class="form-control"
                            value="{{ old('first_name', $employee->first_name) }}"
                            required
                        >

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Last Name
                        </label>

                        <input
                            type="text"
                            name="last_name"
                            class="form-control"
                            value="{{ old('last_name', $employee->last_name) }}"
                        >

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Email *
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $employee->email) }}"
                            required
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
                            value="{{ old('phone', $employee->phone) }}"
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
                            value="{{ old('joining_date', optional($employee->joining_date)->format('Y-m-d')) }}"
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

                            @foreach([
                                'HR',
                                'Sales',
                                'Finance',
                                'Inventory',
                                'IT',
                                'Management'
                            ] as $department)

                                <option value="{{ $department }}"
                                    {{ old('department', $employee->department) === $department ? 'selected' : '' }}>

                                    {{ $department }}

                                </option>

                            @endforeach

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
                            value="{{ old('designation', $employee->designation) }}"
                        >

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Salary *
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rs.
                            </span>

                            <input
                                type="number"
                                name="salary"
                                class="form-control"
                                value="{{ old('salary', $employee->salary) }}"
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
                                {{ old('status', $employee->status) === 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old('status', $employee->status) === 'inactive' ? 'selected' : '' }}>
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
                >{{ old('address', $employee->address) }}</textarea>

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('employees.index') }}"
                       class="btn btn-light">

                        Cancel

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-save me-1"></i>
                        Update Employee

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection