@extends('layouts.app')

@section('title', 'Employees')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Employees</h2>
            <p class="text-muted mb-0">
                Manage your organization's employees.
            </p>
        </div>

        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i>
            Add Employee
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    {{-- Validation Errors --}}
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

    {{-- Employee Table Card --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 p-3">

            <div class="row g-3 align-items-center">

                <div class="col-md-6">
                    <h5 class="mb-0 fw-semibold">
                        Employee Directory
                    </h5>
                </div>

                <div class="col-md-6">

                    <form method="GET"
                          action="{{ route('employees.index') }}">

                        <div class="input-group">

                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Search employee..."
                                value="{{ $search }}"
                            >

                            @if($search)
                                <a href="{{ route('employees.index') }}"
                                   class="btn btn-outline-secondary">
                                    Clear
                                </a>
                            @endif

                            <button class="btn btn-dark" type="submit">
                                Search
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th class="px-3">Employee ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th class="text-end px-3">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($employees as $employee)

                            <tr>

                                <td class="px-3">
                                    <span class="fw-semibold">
                                        {{ $employee->employee_id }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">

                                        <div class="employee-avatar me-2">
                                            {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <div class="fw-semibold">
                                                {{ $employee->first_name }}
                                                {{ $employee->last_name }}
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    {{ $employee->email }}
                                </td>

                                <td>
                                    {{ $employee->department ?? '—' }}
                                </td>

                                <td>
                                    {{ $employee->designation ?? '—' }}
                                </td>

                                <td>
                                    Rs. {{ number_format($employee->salary, 2) }}
                                </td>

                                <td>

                                    @if($employee->status === 'active')

                                        <span class="badge bg-success-subtle text-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-secondary-subtle text-secondary">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                                <td class="text-end px-3">

                                    <div class="btn-group">

                                        <a href="{{ route('employees.show', $employee) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="View">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                        <a href="{{ route('employees.edit', $employee) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Edit">

                                            <i class="bi bi-pencil"></i>

                                        </a>

                                        <form
                                            action="{{ route('employees.destroy', $employee) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this employee?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center py-5">

                                    <div class="mb-3">
                                        <i class="bi bi-people display-5 text-muted"></i>
                                    </div>

                                    <h5>No employees found</h5>

                                    <p class="text-muted mb-3">
                                        Add your first employee to get started.
                                    </p>

                                    <a href="{{ route('employees.create') }}"
                                       class="btn btn-primary">

                                        <i class="bi bi-person-plus me-1"></i>
                                        Add Employee

                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if($employees->hasPages())

            <div class="card-footer bg-white border-0 p-3">

                {{ $employees->links() }}

            </div>

        @endif

    </div>

</div>

<style>

    .employee-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e9ecef;
        color: #212529;
        font-weight: 700;
    }

    .table th {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .table td {
        font-size: 14px;
    }

</style>

@endsection