@extends('layouts.app')

@section('title', 'Employee Management')

@section('content')

<div class="container-fluid employee-page py-4">

    {{-- ================= PAGE HEADER ================= --}}
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">

        <div class="d-flex align-items-center gap-3">

            <div class="employee-page-icon">
                <i class="bi bi-people-fill"></i>
            </div>

            <div>
                <h2 class="employee-page-title mb-1">
                    Employee Management
                </h2>

                <p class="employee-page-subtitle mb-0">
                    Manage your workforce, departments and employee records.
                </p>
            </div>

        </div>

        <a href="{{ route('employees.create') }}"
           class="btn employee-add-btn">

            <i class="bi bi-person-plus-fill me-2"></i>
            Add New Employee

        </a>

    </div>


    {{-- ================= FLASH MESSAGES ================= --}}
    @if(session('success'))

        <div class="alert employee-alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert employee-alert alert-danger alert-dismissible fade show"
             role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if($errors->any())

        <div class="alert employee-alert alert-danger alert-dismissible fade show"
             role="alert">

            <div class="d-flex align-items-start">

                <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>

                <div>

                    <strong>Please correct the following errors:</strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ================= EMPLOYEE STATISTICS ================= --}}
    <div class="row g-3 mb-4">

        {{-- Total Employees --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="employee-stat-card stat-indigo h-100">

                <div class="employee-stat-top">

                    <div>
                        <p class="employee-stat-label">Total Employees</p>

                        <h3 class="employee-stat-number">
                            {{ $employees->total() }}
                        </h3>
                    </div>

                    <div class="employee-stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>

                </div>

                <div class="employee-stat-footer">
                    <span>Employee directory</span>
                    <i class="bi bi-person-lines-fill"></i>
                </div>

            </div>

        </div>


        {{-- Active Employees --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="employee-stat-card stat-emerald h-100">

                <div class="employee-stat-top">

                    <div>
                        <p class="employee-stat-label">Active Employees</p>

                        <h3 class="employee-stat-number">
                            {{ $employees->getCollection()->where('status', 'active')->count() }}
                        </h3>
                    </div>

                    <div class="employee-stat-icon">
                        <i class="bi bi-person-check-fill"></i>
                    </div>

                </div>

                <div class="employee-stat-footer">
                    <span>Active on this page</span>
                    <i class="bi bi-check-circle"></i>
                </div>

            </div>

        </div>


        {{-- Inactive Employees --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="employee-stat-card stat-slate h-100">

                <div class="employee-stat-top">

                    <div>
                        <p class="employee-stat-label">Inactive Employees</p>

                        <h3 class="employee-stat-number">
                            {{ $employees->getCollection()->where('status', 'inactive')->count() }}
                        </h3>
                    </div>

                    <div class="employee-stat-icon">
                        <i class="bi bi-person-dash-fill"></i>
                    </div>

                </div>

                <div class="employee-stat-footer">
                    <span>Inactive on this page</span>
                    <i class="bi bi-dash-circle"></i>
                </div>

            </div>

        </div>


        {{-- Search Results --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="employee-stat-card stat-amber h-100">

                <div class="employee-stat-top">

                    <div>
                        <p class="employee-stat-label">Directory Results</p>

                        <h3 class="employee-stat-number">
                            {{ $employees->count() }}
                        </h3>
                    </div>

                    <div class="employee-stat-icon">
                        <i class="bi bi-search"></i>
                    </div>

                </div>

                <div class="employee-stat-footer">
                    <span>Records on this page</span>
                    <i class="bi bi-list-ul"></i>
                </div>

            </div>

        </div>

    </div>


    {{-- ================= EMPLOYEE DIRECTORY ================= --}}
    <div class="employee-content-card">

        {{-- Card Header --}}
        <div class="employee-card-header">

            <div class="d-flex align-items-center gap-3">

                <div class="employee-section-icon">
                    <i class="bi bi-person-vcard-fill"></i>
                </div>

                <div>
                    <h5 class="employee-card-title mb-1">
                        Employee Directory
                    </h5>

                    <p class="employee-card-subtitle mb-0">
                        Search, view and manage employee information.
                    </p>
                </div>

            </div>

            <div class="employee-record-count">
                <i class="bi bi-people me-2"></i>
                {{ $employees->total() }} Records
            </div>

        </div>


        {{-- ================= SEARCH BAR ================= --}}
        <div class="employee-search-panel">

            <form method="GET"
                  action="{{ route('employees.index') }}">

                <div class="row g-3 align-items-center">

                    <div class="col-12 col-lg-9">

                        <div class="employee-search-wrapper">

                            <i class="bi bi-search employee-search-icon"></i>

                            <input
                                type="text"
                                name="search"
                                class="form-control employee-search-input"
                                placeholder="Search by employee name, ID, email, department..."
                                value="{{ $search }}"
                                maxlength="100"
                                aria-label="Search employees"
                            >

                            @if($search)
                                <a href="{{ route('employees.index') }}"
                                   class="employee-search-clear"
                                   title="Clear search"
                                   aria-label="Clear search">

                                    <i class="bi bi-x-circle"></i>

                                </a>
                            @endif

                        </div>

                    </div>

                    <div class="col-12 col-lg-3">

                        <div class="d-flex gap-2">

                            <button type="submit"
                                    class="btn employee-search-btn flex-grow-1">

                                <i class="bi bi-search me-2"></i>
                                Search

                            </button>

                            @if($search)

                                <a href="{{ route('employees.index') }}"
                                   class="btn employee-clear-btn"
                                   title="Clear search">

                                    <i class="bi bi-arrow-counterclockwise"></i>

                                </a>

                            @endif

                        </div>

                    </div>

                </div>

            </form>

        </div>


        {{-- ================= EMPLOYEE TABLE ================= --}}
        <div class="table-responsive">

            <table class="table employee-table align-middle mb-0">

                <thead>

                    <tr>

                        <th class="ps-4">Employee ID</th>
                        <th>Employee</th>
                        <th>Email Address</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Monthly Salary</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Actions</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($employees as $employee)

                        @php
                            $firstName = trim((string) $employee->first_name);

                            $lastName = trim((string) $employee->last_name);

                            $initials = strtoupper(
                                substr($firstName, 0, 1) .
                                substr($lastName, 0, 1)
                            );

                            if ($initials === '') {
                                $initials = 'E';
                            }
                        @endphp


                        <tr>

                            {{-- Employee ID --}}
                            <td class="ps-4">

                                <span class="employee-id-badge">
                                    {{ $employee->employee_id }}
                                </span>

                            </td>


                            {{-- Employee Information --}}
                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    <div class="employee-avatar">
                                        {{ $initials }}
                                    </div>

                                    <div class="employee-information">

                                        <div class="employee-name">
                                            {{ $employee->first_name }}
                                            {{ $employee->last_name }}
                                        </div>

                                        <div class="employee-designation-mobile">
                                            {{ $employee->designation ?: 'Employee' }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Email --}}
                            <td>

                                @if($employee->email)

                                    <div class="employee-email">

                                        <i class="bi bi-envelope me-2"></i>

                                        {{ $employee->email }}

                                    </div>

                                @else

                                    <span class="text-muted">—</span>

                                @endif

                            </td>


                            {{-- Department --}}
                            <td>

                                @if($employee->department)

                                    <span class="employee-department-badge">
                                        <i class="bi bi-diagram-3 me-1"></i>
                                        {{ $employee->department }}
                                    </span>

                                @else

                                    <span class="text-muted">—</span>

                                @endif

                            </td>


                            {{-- Designation --}}
                            <td>

                                <span class="employee-designation">
                                    {{ $employee->designation ?: '—' }}
                                </span>

                            </td>


                            {{-- Salary --}}
                            <td>

                                <span class="employee-salary">
                                    Rs. {{ number_format((float) $employee->salary, 2) }}
                                </span>

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($employee->status === 'active')

                                    <span class="employee-status status-active">
                                        <span class="employee-status-dot"></span>
                                        Active
                                    </span>

                                @else

                                    <span class="employee-status status-inactive">
                                        <span class="employee-status-dot"></span>
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="text-center pe-4">

                                <div class="employee-actions">

                                    {{-- View --}}
                                    <a
                                        href="{{ route('employees.show', $employee) }}"
                                        class="employee-action-btn employee-view-btn"
                                        title="View Employee"
                                        aria-label="View Employee"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </a>


                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('employees.edit', $employee) }}"
                                        class="employee-action-btn employee-edit-btn"
                                        title="Edit Employee"
                                        aria-label="Edit Employee"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </a>


                                    {{-- Delete --}}
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
                                            class="employee-action-btn employee-delete-btn"
                                            title="Delete Employee"
                                            aria-label="Delete Employee"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="8">

                                <div class="employee-empty-state">

                                    <div class="employee-empty-icon">
                                        <i class="bi bi-people"></i>
                                    </div>

                                    <h5 class="mt-3 mb-2">
                                        No Employees Found
                                    </h5>

                                    <p class="text-muted mb-3">

                                        @if($search)

                                            No employees match your search.
                                            Try a different keyword.

                                        @else

                                            Your employee directory is empty.
                                            Add your first employee to get started.

                                        @endif

                                    </p>

                                    @if($search)

                                        <a href="{{ route('employees.index') }}"
                                           class="btn employee-clear-btn">

                                            <i class="bi bi-arrow-counterclockwise me-2"></i>
                                            Clear Search

                                        </a>

                                    @else

                                        <a href="{{ route('employees.create') }}"
                                           class="btn employee-add-btn">

                                            <i class="bi bi-person-plus-fill me-2"></i>
                                            Add First Employee

                                        </a>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- ================= PAGINATION ================= --}}
        @if($employees->hasPages() || $employees->total() > 0)

            <div class="employee-pagination-footer">

                <div class="employee-pagination-info">

                    Showing

                    <strong>{{ $employees->firstItem() ?? 0 }}</strong>

                    to

                    <strong>{{ $employees->lastItem() ?? 0 }}</strong>

                    of

                    <strong>{{ $employees->total() }}</strong>

                    employees

                </div>

                <div class="employee-pagination-links">
                    {{ $employees->appends(request()->query())->links() }}
                </div>

            </div>

        @endif

    </div>


    {{-- ================= PAGE FOOTER ================= --}}
    <div class="employee-page-footer">

        <span>
            <i class="bi bi-shield-check me-1"></i>
            ERP-Pro Human Resources
        </span>

        <span>
            Employee records: {{ $employees->total() }}
        </span>

    </div>

</div>


{{-- ================= PAGE STYLES ================= --}}
<style>

    .employee-page {
        color: #1e293b;
    }

    /* Header */

    .employee-page-icon {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 16px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        font-size: 26px;
        box-shadow: 0 7px 18px rgba(79, 70, 229, 0.2);
    }

    .employee-page-title {
        color: #0f172a;
        font-size: clamp(22px, 2vw, 29px);
        font-weight: 750;
        letter-spacing: -0.6px;
    }

    .employee-page-subtitle {
        color: #64748b;
        font-size: 13px;
    }

    .employee-add-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        min-height: 44px;
        padding: 11px 19px;
        border: 1px solid #4f46e5;
        border-radius: 10px;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: #fff;
        font-size: 13px;
        font-weight: 650;
        box-shadow: 0 5px 12px rgba(79, 70, 229, 0.14);
        transition: all 0.2s ease;
    }

    .employee-add-btn:hover {
        transform: translateY(-1px);
        border-color: #4338ca;
        background: #4338ca;
        color: #fff;
    }


    /* Alerts */

    .employee-alert {
        padding: 16px 18px;
        border: 0;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
    }


    /* Statistics */

    .employee-stat-card {
        padding: 21px;
        overflow: hidden;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.035);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .employee-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 9px 22px rgba(15, 23, 42, 0.075);
    }

    .employee-stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .employee-stat-label {
        margin-bottom: 8px;
        color: #64748b;
        font-size: 12px;
        font-weight: 650;
    }

    .employee-stat-number {
        margin: 0;
        color: #0f172a;
        font-size: 30px;
        line-height: 1.2;
        font-weight: 750;
    }

    .employee-stat-icon {
        width: 49px;
        height: 49px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 14px;
        font-size: 22px;
    }

    .employee-stat-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-top: 19px;
        padding-top: 13px;
        border-top: 1px solid #f1f5f9;
        color: #94a3b8;
        font-size: 11px;
    }

    .employee-stat-footer i {
        font-size: 14px;
    }

    .stat-indigo .employee-stat-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .stat-emerald .employee-stat-icon {
        background: #d1fae5;
        color: #059669;
    }

    .stat-slate .employee-stat-icon {
        background: #f1f5f9;
        color: #64748b;
    }

    .stat-amber .employee-stat-icon {
        background: #fef3c7;
        color: #d97706;
    }


    /* Main Card */

    .employee-content-card {
        overflow: hidden;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 3px 14px rgba(15, 23, 42, 0.035);
    }

    .employee-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        padding: 21px 24px;
        border-bottom: 1px solid #edf1f6;
        background: #fff;
    }

    .employee-section-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 12px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 20px;
    }

    .employee-card-title {
        color: #0f172a;
        font-size: 16px;
        font-weight: 750;
    }

    .employee-card-subtitle {
        color: #94a3b8;
        font-size: 12px;
    }

    .employee-record-count {
        padding: 9px 13px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 650;
        white-space: nowrap;
    }


    /* Search */

    .employee-search-panel {
        padding: 21px 24px;
        border-bottom: 1px solid #edf1f6;
        background: #fff;
    }

    .employee-search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .employee-search-icon {
        position: absolute;
        left: 15px;
        color: #94a3b8;
        font-size: 16px;
        pointer-events: none;
    }

    .employee-search-input {
        min-height: 46px;
        padding: 11px 43px;
        border: 1px solid #e2e8f0;
        border-radius: 10px !important;
        background: #f8fafc;
        color: #334155;
        font-size: 13px;
    }

    .employee-search-input:focus {
        border-color: #818cf8;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .employee-search-clear {
        position: absolute;
        right: 14px;
        color: #94a3b8;
        font-size: 18px;
        text-decoration: none;
    }

    .employee-search-clear:hover {
        color: #dc2626;
    }

    .employee-search-btn {
        min-height: 46px;
        border-radius: 9px;
        background: #0f172a;
        color: #fff;
        font-size: 13px;
        font-weight: 650;
    }

    .employee-search-btn:hover {
        background: #334155;
        color: #fff;
    }

    .employee-clear-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        min-height: 42px;
        padding: 10px 14px;
        border: 1px solid #dbe2ea;
        border-radius: 9px;
        background: #fff;
        color: #475569;
        text-decoration: none;
    }

    .employee-clear-btn:hover {
        background: #f8fafc;
        color: #0f172a;
    }


    /* Employee Table */

    .employee-table {
        min-width: 1100px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .employee-table thead th {
        padding: 15px 12px;
        border-top: 0;
        border-bottom: 1px solid #e8edf4;
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        font-weight: 750;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .employee-table tbody td {
        padding: 16px 12px;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 12px;
        vertical-align: middle;
    }

    .employee-table tbody tr {
        transition: background 0.15s ease;
    }

    .employee-table tbody tr:hover {
        background: #fafbff;
    }

    .employee-table tbody tr:last-child td {
        border-bottom: 0;
    }


    /* Employee Avatar */

    .employee-avatar {
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #e0e7ff;
        border-radius: 13px;
        background: linear-gradient(135deg, #eef2ff, #f5f3ff);
        color: #4f46e5;
        font-size: 13px;
        font-weight: 800;
    }

    .employee-name {
        max-width: 200px;
        overflow-wrap: anywhere;
        color: #1e293b;
        font-size: 12px;
        font-weight: 750;
        line-height: 1.6;
    }

    .employee-designation-mobile {
        display: none;
        margin-top: 4px;
        color: #94a3b8;
        font-size: 10px;
    }

    .employee-id-badge {
        display: inline-block;
        padding: 7px 9px;
        border: 1px solid #e0e7ff;
        border-radius: 7px;
        background: #eef2ff;
        color: #4338ca;
        font-size: 10px;
        font-weight: 750;
        white-space: nowrap;
    }

    .employee-email {
        display: flex;
        align-items: center;
        color: #64748b;
        font-size: 11px;
        overflow-wrap: anywhere;
    }

    .employee-email i {
        color: #94a3b8;
        flex-shrink: 0;
    }

    .employee-department-badge {
        display: inline-block;
        padding: 7px 9px;
        border: 1px solid #e0e7ff;
        border-radius: 7px;
        background: #eef2ff;
        color: #4338ca;
        font-size: 10px;
        font-weight: 650;
        white-space: nowrap;
    }

    .employee-designation {
        color: #475569;
        font-size: 11px;
        font-weight: 600;
    }

    .employee-salary {
        color: #0f172a;
        font-size: 11px;
        font-weight: 750;
        white-space: nowrap;
    }


    /* Employee Status */

    .employee-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 750;
        white-space: nowrap;
    }

    .employee-status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-active {
        background: #d1fae5;
        color: #047857;
    }

    .status-inactive {
        background: #f1f5f9;
        color: #64748b;
    }


    /* Action Buttons */

    .employee-actions {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .employee-action-btn {
        width: 33px;
        height: 33px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        border-radius: 8px;
        background: #fff;
        font-size: 14px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.18s ease;
    }

    .employee-view-btn {
        border-color: #bae6fd;
        background: #f0f9ff;
        color: #0284c7;
    }

    .employee-view-btn:hover {
        border-color: #0284c7;
        background: #0284c7;
        color: #fff;
    }

    .employee-edit-btn {
        border-color: #c7d2fe;
        background: #eef2ff;
        color: #4f46e5;
    }

    .employee-edit-btn:hover {
        border-color: #4f46e5;
        background: #4f46e5;
        color: #fff;
    }

    .employee-delete-btn {
        border-color: #fecaca;
        background: #fff1f2;
        color: #e11d48;
    }

    .employee-delete-btn:hover {
        border-color: #e11d48;
        background: #e11d48;
        color: #fff;
    }


    /* Empty State */

    .employee-empty-state {
        display: flex;
        align-items: center;
        flex-direction: column;
        padding: 65px 20px;
        text-align: center;
    }

    .employee-empty-icon {
        width: 76px;
        height: 76px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 22px;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 35px;
    }

    .employee-empty-state h5 {
        color: #1e293b;
        font-weight: 750;
    }

    .employee-empty-state p {
        max-width: 410px;
        font-size: 13px;
        line-height: 1.8;
    }


    /* Pagination */

    .employee-pagination-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        padding: 20px 24px;
        border-top: 1px solid #edf1f6;
        background: #fff;
    }

    .employee-pagination-info {
        color: #94a3b8;
        font-size: 12px;
    }

    .employee-pagination-info strong {
        color: #475569;
    }

    .employee-pagination-links .pagination {
        margin-bottom: 0;
        gap: 4px;
    }

    .employee-pagination-links .page-link {
        border-color: #e2e8f0;
        border-radius: 7px;
        color: #475569;
        font-size: 12px;
    }

    .employee-pagination-links .page-item.active .page-link {
        border-color: #4f46e5;
        background: #4f46e5;
        color: #fff;
    }


    /* Footer */

    .employee-page-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 18px 4px 4px;
        color: #94a3b8;
        font-size: 11px;
    }


    /* Responsive */

    @media (max-width: 991.98px) {

        .employee-card-header {
            padding: 18px;
        }

        .employee-search-panel {
            padding: 18px;
        }

        .employee-stat-number {
            font-size: 27px;
        }

    }


    @media (max-width: 575.98px) {

        .employee-page {
            padding-top: 18px !important;
        }

        .employee-page-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            font-size: 22px;
        }

        .employee-page-title {
            font-size: 21px;
            letter-spacing: -0.4px;
        }

        .employee-page-subtitle {
            font-size: 12px;
            line-height: 1.6;
        }

        .employee-add-btn {
            width: 100%;
        }

        .employee-stat-card {
            padding: 16px;
        }

        .employee-stat-number {
            font-size: 26px;
        }

        .employee-stat-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            font-size: 20px;
        }

        .employee-card-header {
            align-items: flex-start;
            padding: 16px;
        }

        .employee-section-icon {
            width: 39px;
            height: 39px;
            font-size: 18px;
        }

        .employee-card-title {
            font-size: 14px;
        }

        .employee-card-subtitle {
            font-size: 11px;
        }

        .employee-record-count {
            font-size: 11px;
        }

        .employee-search-panel {
            padding: 16px;
        }

        .employee-search-input {
            font-size: 12px;
        }

        .employee-pagination-footer {
            align-items: flex-start;
            flex-direction: column;
            padding: 16px;
        }

        .employee-pagination-links {
            max-width: 100%;
            overflow-x: auto;
        }

        .employee-page-footer {
            align-items: flex-start;
            flex-direction: column;
        }

    }

</style>

@endsection

