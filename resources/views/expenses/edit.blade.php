@extends('layouts.app')

@section('title', 'Edit Expense')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold">Edit Expense</h2>
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

            <form action="{{ route('expenses.update', $expense) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Expense Category
                        </label>

                        <select name="expense_category_id"
                                class="form-select"
                                required>

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}"
                                    @selected(old('expense_category_id', $expense->expense_category_id) == $category->id)>
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
                               value="{{ old('title', $expense->title) }}"
                               required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Amount
                        </label>

                        <input type="number"
                               name="amount"
                               class="form-control"
                               value="{{ old('amount', $expense->amount) }}"
                               min="0.01"
                               step="0.01"
                               required>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Expense Date
                        </label>

                        <input type="date"
                               name="expense_date"
                               class="form-control"
                               value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}"
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
                                @selected(old('payment_method', $expense->payment_method) === 'cash')>
                                Cash
                            </option>

                            <option value="bank"
                                @selected(old('payment_method', $expense->payment_method) === 'bank')>
                                Bank
                            </option>

                            <option value="other"
                                @selected(old('payment_method', $expense->payment_method) === 'other')>
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
                                  rows="4">{{ old('description', $expense->description) }}</textarea>

                    </div>

                </div>

                <div class="mt-4">

                    <button class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Update Expense
                    </button>

                    <a href="{{ route('expenses.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection