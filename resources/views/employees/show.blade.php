@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">Employee Details</h2>

            <p class="text-muted mb-0">
                View employee information.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('employees.index') }}"
               class="btn btn-light">

                <i class="bi bi-arrow-left me-1"></i>
                Back

            </a>

            <a href="{{ route('employees.edit', $employee) }}"
               class="btn btn-primary">

                <i class="bi bi-pencil me-1"></i>
                Edit

            </a>

        </div>

    </div>

    <div class="row g-4">

        {{-- Profile Card --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm text-center">

                <div class="card-body p-4">

                    <div class="employee-avatar mx-auto mb-3">

                        {{ strtoupper(substr($employee->first_name, 0, 1)) }}

                    </div>

                    <h4 class="fw-bold mb-1">

                        {{ $employee->first_name }}
                        {{ $employee->last_name }}

                    </h4>

                    <p class="text-muted mb-2">

                        {{ $employee->designation ?? 'Employee' }}

                    </p>

                    <span class="badge bg-primary-subtle text-primary">

                        {{ $employee->employee_id }}

                    </span>

                    <hr>

                    <div class="text-start">

                        <div class="mb-3">

                            <small class="text-muted d-block">
                                Email
                            </small>

                            <span>
                                {{ $employee->email }}
                            </span>

                        </div>

                        <div class="mb-3">

                            <small class="text-muted d-block">
                                Phone
                            </small>

                            <span>
                                {{ $employee->phone ?? 'Not provided' }}
                            </span>

                        </div>

                        <div>

                            <small class="text-muted d-block">
                                Status
                            </small>

                            @if($employee->status === 'active')

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

        {{-- Information --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0 fw-bold">
                        Employment Information
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Department
                            </small>

                            <strong>
                                {{ $employee->department ?? 'Not assigned' }}
                            </strong>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Designation
                            </small>

                            <strong>
                                {{ $employee->designation ?? 'Not assigned' }}
                            </strong>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Salary
                            </small>

                            <strong>
                                Rs. {{ number_format($employee->salary, 2) }}
                            </strong>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Joining Date
                            </small>

                            <strong>
                                {{ $employee->joining_date?->format('d M Y') ?? 'Not provided' }}
                            </strong>

                        </div>

                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold mb-3">
                        Address
                    </h6>

                    <p class="text-muted mb-0">

                        {{ $employee->address ?? 'No address provided.' }}

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

    .employee-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e9ecef;
        color: #212529;
        font-size: 32px;
        font-weight: 700;
    }

</style>

@endsection