@extends('layouts.app')

@section('title', 'Add Income')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold">Add Income</h2>
        <p class="text-muted">
            Record additional business income.
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

            <form action="{{ route('incomes.store') }}"
                  method="POST">

                @csrf

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Income Title
                        </label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title') }}"
                               placeholder="e.g. Service Income"
                               required>

                    </div>

                    <div class="col-md-6">

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

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Income Date
                        </label>

                        <input type="date"
                               name="income_date"
                               class="form-control"
                               value="{{ old('income_date', now()->format('Y-m-d')) }}"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Payment Method
                        </label>

                        <select name="payment_method"
                                class="form-select"
                                required>

                            <option value="cash">Cash</option>
                            <option value="bank">Bank</option>
                            <option value="other">Other</option>

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

                    <button class="btn btn-success">
                        <i class="bi bi-save me-1"></i>
                        Save Income
                    </button>

                    <a href="{{ route('incomes.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection