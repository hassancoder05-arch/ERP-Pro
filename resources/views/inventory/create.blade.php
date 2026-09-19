@extends('layouts.app')

@section('title', 'Stock Transaction')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="bi bi-arrow-left-right me-2"></i>
                Stock Transaction
            </h2>

            <p class="text-muted mb-0">
                Add, remove or adjust product stock.
            </p>

        </div>

        <a href="{{ route('inventory.index') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Back

        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form action="{{ route('inventory.store') }}"
                  method="POST">

                @csrf

                <div class="row g-4">


                    {{-- Product --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Product
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="product_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Select Product
                            </option>

                            @foreach($products as $product)

                                <option
                                    value="{{ $product->id }}"
                                    {{ old('product_id', request('product_id')) == $product->id ? 'selected' : '' }}
                                >

                                    {{ $product->name }}
                                    — {{ $product->product_code }}
                                    (Stock: {{ $product->stock }})

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Type --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Transaction Type
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="type"
                            id="transactionType"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Select Type
                            </option>

                            <option
                                value="stock_in"
                                {{ old('type') === 'stock_in' ? 'selected' : '' }}
                            >
                                Stock In
                            </option>

                            <option
                                value="stock_out"
                                {{ old('type') === 'stock_out' ? 'selected' : '' }}
                            >
                                Stock Out
                            </option>

                            <option
                                value="adjustment"
                                {{ old('type') === 'adjustment' ? 'selected' : '' }}
                            >
                                Stock Adjustment
                            </option>

                        </select>

                    </div>


                    {{-- Quantity --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Quantity
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="number"
                            name="quantity"
                            value="{{ old('quantity', 1) }}"
                            class="form-control"
                            min="1"
                            required
                        >

                        <small class="text-muted">
                            For Adjustment, enter the new total stock quantity.
                        </small>

                    </div>


                    {{-- Reference --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Reference
                        </label>

                        <input
                            type="text"
                            name="reference"
                            value="{{ old('reference') }}"
                            class="form-control"
                            placeholder="e.g. PURCHASE-001"
                        >

                    </div>


                    {{-- Notes --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Notes
                        </label>

                        <textarea
                            name="notes"
                            rows="4"
                            class="form-control"
                            placeholder="Enter transaction notes..."
                        >{{ old('notes') }}</textarea>

                    </div>


                    {{-- Information --}}
                    <div class="col-12">

                        <div class="alert alert-info mb-0">

                            <i class="bi bi-info-circle me-2"></i>

                            <strong>Stock In:</strong>
                            Current stock mein quantity add hogi.

                            <br>

                            <strong>Stock Out:</strong>
                            Current stock se quantity minus hogi.

                            <br>

                            <strong>Adjustment:</strong>
                            Quantity ko new total stock maana jayega.

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-12">

                        <hr>

                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('inventory.index') }}"
                                class="btn btn-light"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >

                                <i class="bi bi-check-lg me-1"></i>
                                Save Transaction

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection