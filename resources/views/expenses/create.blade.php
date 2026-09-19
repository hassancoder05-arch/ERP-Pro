@extends('layouts.app')

@section('title', 'Add Expense')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold">Add Expense</h2>
        <p class="text-muted">
            Record a new business expense.
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

            @if($categories->isEmpty())

                <div class="alert alert-warning">
                    Please create an expense category first.

                    <a href="{{ route('expense-categories.create') }}"
                       class="alert-link">
                        Create Category
                    </a>
                </div>

            @else

            <form action="{{ route('expenses.store') }}"
                  method="POST">

                @csrf

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Expense Category
                        </label>

                        <select name="expense_category_id"
                                class="form-select"
                                required>

                            <option value="">
                                Select category
                            </option>

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}"
                                    @selected(old('expense_category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Expense Title
                        </label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title') }}"
                               placeholder="e.g. Electricity Bill"
                               required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Amount
                        </label>

                        <input type="number"
                               name="amount"
                               class="form-control"
                               value="{{ old('amount') }}"
                               min="0.01"
                               step="0.01"
                               placeholder="0.00"
                               required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Expense Date
                        </label>

                        <input type="date"
                               name="expense_date"
                               class="form-control"
                               value="{{ old('expense_date', now()->format('Y-m-d')) }}"
                               required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Payment Method
                        </label>

                        <select name="payment_method"
                                class="form-select"
                                required>

                            <option value="cash"
                                @selected(old('payment_method') === 'cash')>
                                Cash
                            </option>

                            <option value="bank"
                                @selected(old('payment_method') === 'bank')>
                                Bank
                            </option>

                            <option value="other"
                                @selected(old('payment_method') === 'other')>
                                Other
                            </option>

                        </select>

                    </div>


                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Description
                        </label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Optional details">{{ old('description') }}</textarea>

                    </div>

                </div>

                <div class="mt-4">

                    <button class="btn btn-danger">
                        <i class="bi bi-save me-1"></i>
                        Save Expense
                    </button>

                    <a href="{{ route('expenses.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

            @endif

        </div>

    </div>

</div>

@endsection