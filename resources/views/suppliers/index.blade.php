@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Suppliers
            </h2>

            <p class="text-muted mb-0">
                Manage your supplier records.
            </p>
        </div>

        <a href="{{ route('suppliers.create') }}"
           class="btn btn-primary">

            <i class="bi bi-building-add me-1"></i>
            Add Supplier

        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Search --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('suppliers.index') }}">

                <div class="input-group">

                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search supplier..."
                        value="{{ $search }}"
                    >

                    @if($search)

                        <a href="{{ route('suppliers.index') }}"
                           class="btn btn-outline-secondary">

                            Clear

                        </a>

                    @endif

                    <button class="btn btn-dark"
                            type="submit">

                        Search

                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 p-3">

            <h5 class="mb-0 fw-semibold">
                Supplier Directory
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-3">
                                Supplier ID
                            </th>

                            <th>
                                Supplier
                            </th>

                            <th>
                                Company
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Phone
                            </th>

                            <th>
                                Balance
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end px-3">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($suppliers as $supplier)

                        <tr>

                            <td class="px-3">

                                <span class="fw-semibold">
                                    {{ $supplier->supplier_id }}
                                </span>

                            </td>

                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="supplier-avatar me-2">

                                        {{ strtoupper(substr($supplier->name, 0, 1)) }}

                                    </div>

                                    <span class="fw-semibold">
                                        {{ $supplier->name }}
                                    </span>

                                </div>

                            </td>

                            <td>
                                {{ $supplier->company_name ?? '—' }}
                            </td>

                            <td>
                                {{ $supplier->email ?? '—' }}
                            </td>

                            <td>
                                {{ $supplier->phone ?? '—' }}
                            </td>

                            <td>
                                Rs. {{ number_format($supplier->opening_balance, 2) }}
                            </td>

                            <td>

                                @if($supplier->status === 'active')

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

                                    {{-- View --}}
                                    <a href="{{ route('suppliers.show', $supplier) }}"
                                       class="btn btn-sm btn-outline-info"
                                       title="View">

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    {{-- Edit --}}
                                    <a href="{{ route('suppliers.edit', $supplier) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('suppliers.destroy', $supplier) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this supplier?');"
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

                                <i class="bi bi-building display-5 text-muted"></i>

                                <h5 class="mt-3">
                                    No suppliers found
                                </h5>

                                <p class="text-muted">
                                    Add your first supplier.
                                </p>

                                <a href="{{ route('suppliers.create') }}"
                                   class="btn btn-primary">

                                    <i class="bi bi-building-add me-1"></i>
                                    Add Supplier

                                </a>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Pagination --}}
        @if($suppliers->hasPages())

            <div class="card-footer bg-white border-0 p-3">

                {{ $suppliers->links() }}

            </div>

        @endif

    </div>

</div>


<style>

.supplier-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e9ecef;
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