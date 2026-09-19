@extends('layouts.app')

@section('title', 'Income')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">Income</h2>
            <p class="text-muted mb-0">
                Manage additional business income.
            </p>
        </div>

        <a href="{{ route('incomes.create') }}"
           class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>
            Add Income
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
                  action="{{ route('incomes.index') }}"
                  class="row g-2 mb-4">

                <div class="col-md-8">
                    <input type="text"
                           name="search"
                           value="{{ $search }}"
                           class="form-control"
                           placeholder="Search income...">
                </div>

                <div class="col-md-4 d-flex gap-2">

                    <button class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>
                        Search
                    </button>

                    <a href="{{ route('incomes.index') }}"
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
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Payment Method</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($incomes as $income)

                        <tr>

                            <td>
                                {{ $incomes->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>{{ $income->title }}</strong>
                            </td>

                            <td class="text-success fw-bold">
                                Rs. {{ number_format($income->amount, 2) }}
                            </td>

                            <td>
                                {{ $income->income_date->format('d M Y') }}
                            </td>

                            <td>
                                <span class="badge bg-secondary text-capitalize">
                                    {{ $income->payment_method }}
                                </span>
                            </td>

                            <td>
                                {{ $income->description ?: '—' }}
                            </td>

                            <td class="text-end">

                                <a href="{{ route('incomes.show', $income) }}"
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('incomes.edit', $income) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('incomes.destroy', $income) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this income?')">

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
                                No income records found.
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $incomes->links() }}
            </div>

        </div>

    </div>

</div>

@endsection