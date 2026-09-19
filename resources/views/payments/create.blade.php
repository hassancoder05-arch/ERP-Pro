@extends('layouts.app')

@section('title', 'Record Payment')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold">Record Payment</h2>
        <p class="text-muted">
            Record money received from a customer or paid to a supplier.
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

            <form action="{{ route('payments.store') }}"
                  method="POST">

                @csrf

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Payment Type
                        </label>

                        <select name="type"
                                id="paymentType"
                                class="form-select"
                                required>

                            <option value="">
                                Select payment type
                            </option>

                            <option value="customer"
                                @selected(old('type') === 'customer')>
                                Customer Payment — Money Received
                            </option>

                            <option value="supplier"
                                @selected(old('type') === 'supplier')>
                                Supplier Payment — Money Paid
                            </option>

                        </select>

                    </div>


                    <div class="col-md-6"
                         id="customerBox">

                        <label class="form-label fw-semibold">
                            Customer
                        </label>

                        <select name="customer_id"
                                class="form-select">

                            <option value="">
                                Select customer
                            </option>

                            @foreach($customers as $customer)

                                <option value="{{ $customer->id }}"
                                    @selected(old('customer_id') == $customer->id)>
                                    {{ $customer->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-6 d-none"
                         id="supplierBox">

                        <label class="form-label fw-semibold">
                            Supplier
                        </label>

                        <select name="supplier_id"
                                class="form-select">

                            <option value="">
                                Select supplier
                            </option>

                            @foreach($suppliers as $supplier)

                                <option value="{{ $supplier->id }}"
                                    @selected(old('supplier_id') == $supplier->id)>
                                    {{ $supplier->name }}
                                </option>

                            @endforeach

                        </select>

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
                            Payment Date
                        </label>

                        <input type="date"
                               name="payment_date"
                               class="form-control"
                               value="{{ old('payment_date', now()->format('Y-m-d')) }}"
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


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Reference
                        </label>

                        <input type="text"
                               name="reference"
                               class="form-control"
                               value="{{ old('reference') }}"
                               placeholder="Receipt / transaction number">

                    </div>


                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Notes
                        </label>

                        <textarea name="notes"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Optional notes">{{ old('notes') }}</textarea>

                    </div>

                </div>


                <div class="mt-4">

                    <button class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Record Payment
                    </button>

                    <a href="{{ route('payments.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const type = document.getElementById('paymentType');
    const customerBox = document.getElementById('customerBox');
    const supplierBox = document.getElementById('supplierBox');

    function updatePaymentType() {

        customerBox.classList.add('d-none');
        supplierBox.classList.add('d-none');

        if (type.value === 'customer') {
            customerBox.classList.remove('d-none');
        }

        if (type.value === 'supplier') {
            supplierBox.classList.remove('d-none');
        }
    }

    type.addEventListener('change', updatePaymentType);

    updatePaymentType();

});

</script>

@endsection