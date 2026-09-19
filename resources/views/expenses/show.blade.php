@extends('layouts.app')

@section('title', 'Expense Details')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">Expense Details</h2>
            <p class="text-muted mb-0">
                View expense information.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('expenses.edit', $expense) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i>
                Edit
            </a>

            <a href="{{ route('expenses.index') }}"
               class="btn btn-secondary">
                Back
            </a>

        </div>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-6">
                    <small class="text-muted">Title</small>
                    <h5>{{ $expense->title }}</h5>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Category</small>
                    <h5>{{ $expense->category->name }}</h5>
                </div>

                <div class="col-md-4">
                    <small class="text-muted">Amount</small>
                    <h4 class="text-danger">
                        Rs. {{ number_format($expense->amount, 2) }}
                    </h4>
                </div>

                <div class="col-md-4">
                    <small class="text-muted">Date</small>
                    <h5>
                        {{ $expense->expense_date->format('d M Y') }}
                    </h5>
                </div>

                <div class="col-md-4">
                    <small class="text-muted">Payment Method</small>
                    <h5 class="text-capitalize">
                        {{ $expense->payment_method }}
                    </h5>
                </div>

                <div class="col-12">

                    <small class="text-muted">
                        Description
                    </small>

                    <p class="mt-2">
                        {{ $expense->description ?: 'No description provided.' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection