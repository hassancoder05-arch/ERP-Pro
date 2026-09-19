@extends('layouts.app')

@section('title', 'Edit Expense Category')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold">Edit Expense Category</h2>
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

            <form action="{{ route('expense-categories.update', $expenseCategory) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Category Name
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $expenseCategory->name) }}"
                           required>

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Description
                    </label>

                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description', $expenseCategory->description) }}</textarea>

                </div>

                <button type="submit"
                        class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Update Category
                </button>

                <a href="{{ route('expense-categories.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

@endsection