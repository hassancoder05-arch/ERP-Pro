@extends('layouts.app')

@section('title', 'Edit Income')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold">Edit Income</h2>
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

            <form action="{{ route('incomes.update', $income) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Income Title
                        </label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $income->title) }}"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Amount
                        </label>

                        <input type="number"
                               name="amount"
                               class="form-control"
                               value="{{ old('amount', $income->amount) }}"
                               min="0.01"
                               step="0.01"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Income Date
                        </label>

                        <input type="date"
                               name="income_date"
                               class="form-control"
                               value="{{ old('income_date', $income->income_date->format('Y-m-d')) }}"
                               required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Payment Method
                        </label>

                        <select name="payment_method"
                                class="form-select">

                            <option value="cash"
                                @selected($income->payment_method === 'cash')>
                                Cash
                            </option>

                            <option value="bank"
                                @selected($income->payment_method === 'bank')>
                                Bank
                            </option>

                            <option value="other"
                                @selected($income->payment_method === 'other')>
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
                                  rows="4">{{ old('description', $income->description) }}</textarea>

                    </div>

                </div>

                <div class="mt-4">

                    <button class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Update Income
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