@extends('layouts.app')

@section('title', 'Add Expense Category')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold">Add Expense Category</h2>
        <p class="text-muted">
            Create a new expense category.
        </p>
    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('expense-categories.store') }}"
                  method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Category Name
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           placeholder="e.g. Electricity"
                           required>

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Description
                    </label>

                    <textarea name="description"
                              class="form-control"
                              rows="4"
                              placeholder="Optional description">{{ old('description') }}</textarea>

                </div>

                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>
                        Save Category
                    </button>

                    <a href="{{ route('expense-categories.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection