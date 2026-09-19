@extends('layouts.app')

@section('title', 'Expense Category')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                {{ $expenseCategory->name }}
            </h2>

            <p class="text-muted mb-0">
                Expense category details
            </p>
        </div>

        <a href="{{ route('expense-categories.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back
        </a>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <h5 class="fw-bold mb-3">
                Category Information
            </h5>

            <div class="row g-3">

                <div class="col-md-6">
                    <strong>Name</strong>
                    <p>{{ $expenseCategory->name }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Total Expenses</strong>
                    <p>{{ $expenseCategory->expenses->count() }}</p>
                </div>

                <div class="col-12">
                    <strong>Description</strong>
                    <p>
                        {{ $expenseCategory->description ?: 'No description.' }}
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection