
@extends('layouts.app')

@section('title', 'Customers')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">Customers</h2>

            <p class="text-muted mb-0">
                Manage your customer records.
            </p>
        </div>

        <a href="{{ route('customers.create') }}"
           class="btn btn-primary">

            <i class="bi bi-person-plus me-1"></i>
            Add Customer

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
                  action="{{ route('customers.index') }}">

                <div class="input-group">

                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search by ID, name, email or phone..."
                        value="{{ $search }}"
                    >

                    @if($search)

                        <a href="{{ route('customers.index') }}"
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


    {{-- Customer Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 p-3">

            <h5 class="mb-0 fw-semibold">
                Customer Directory
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-3">
                                Customer ID
                            </th>

                            <th>
                                Customer
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Phone
                            </th>

                            <th>
                                Credit Limit
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

                    @forelse($customers as $customer)

                        <tr>

                            <td class="px-3">

                                <span class="fw-semibold">
                                    {{ $customer->customer_id }}
                                </span>

                            </td>


                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="customer-avatar me-2">

                                        {{ strtoupper(substr($customer->name, 0, 1)) }}

                                    </div>

                                    <div>

                                        <div class="fw-semibold">
                                            {{ $customer->name }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            <td>
                                {{ $customer->email ?? '—' }}
                            </td>


                            <td>
                                {{ $customer->phone ?? '—' }}
                            </td>


                            <td>
                                Rs. {{ number_format($customer->credit_limit, 2) }}
                            </td>


                            <td>
                                Rs. {{ number_format($customer->opening_balance, 2) }}
                            </td>


                            <td>

                                @if($customer->status === 'active')

                                    <span class="badge bg-success-subtle text-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge bg-secondary-subtle text-secondary">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="text-end px-3">

                                <div class="btn-group">

                                    {{-- View --}}
                                    <a href="{{ route('customers.show', $customer) }}"
                                       class="btn btn-sm btn-outline-info"
                                       title="View">

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    {{-- Edit --}}
                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('customers.destroy', $customer) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this customer?');"
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

                                <i class="bi bi-people display-5 text-muted"></i>

                                <h5 class="mt-3">
                                    No customers found
                                </h5>

                                <p class="text-muted">
                                    Add your first customer.
                                </p>

                                <a href="{{ route('customers.create') }}"
                                   class="btn btn-primary">

                                    <i class="bi bi-person-plus me-1"></i>

                                    Add Customer

                                </a>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Pagination --}}
        @if($customers->hasPages())

            <div class="card-footer bg-white border-0 p-3">

                {{ $customers->links() }}

            </div>

        @endif

    </div>

</div>


<style>

.customer-avatar {
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

