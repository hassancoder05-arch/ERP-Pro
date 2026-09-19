@extends('layouts.app')

@section('title', 'Expenses')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">Expenses</h2>
            <p class="text-muted mb-0">
                Track business expenses.
            </p>
        </div>

        <a href="{{ route('expenses.create') }}"
           class="btn btn-danger">
            <i class="bi bi-plus-lg me-1"></i>
            Add Expense
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('expenses.index') }}"
                  class="row g-2 mb-4">

                <div class="col-md-8">

                    <input type="text"
                           name="search"
                           class="form-control"
                           value="{{ $search }}"
                           placeholder="Search expense, category or payment method...">

                </div>

                <div class="col-md-4 d-flex gap-2">

                    <button class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>
                        Search
                    </button>

                    <a href="{{ route('expenses.index') }}"
                       class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </form>


            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Payment</th>
                            <th class="text-end">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($expenses as $expense)

                        <tr>

                            <td>
                                {{ $expenses->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>{{ $expense->title }}</strong>
                            </td>

                            <td>
                                {{ $expense->category->name }}
                            </td>

                            <td class="fw-bold text-danger">
                                Rs. {{ number_format($expense->amount, 2) }}
                            </td>

                            <td>
                                {{ $expense->expense_date->format('d M Y') }}
                            </td>

                            <td>
                                <span class="badge bg-secondary text-capitalize">
                                    {{ $expense->payment_method }}
                                </span>
                            </td>

                            <td class="text-end">

                                <a href="{{ route('expenses.show', $expense) }}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('expenses.edit', $expense) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('expenses.destroy', $expense) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this expense?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7"
                                class="text-center text-muted py-5">
                                No expenses found.
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $expenses->links() }}
            </div>

        </div>

    </div>

</div>

@endsection