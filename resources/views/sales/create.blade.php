@extends('layouts.app')

@section('title', 'New Sale')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="bi bi-receipt me-2"></i>
                New Sale
            </h2>

            <p class="text-muted mb-0">
                Create a new sales invoice.
            </p>

        </div>

        <a
            href="{{ route('sales.index') }}"
            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-1"></i>
            Back

        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                Please fix the following errors:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('sales.store') }}"
        method="POST"
        id="saleForm"
    >

        @csrf


        {{-- Customer Information --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="fw-bold mb-0">
                    Customer Information
                </h5>

            </div>

            <div class="card-body">

                <div class="row g-4">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">

                            Customer
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="customer_id"
                            class="form-select"
                            required
                        >

                            <option value="">
                                Select Customer
                            </option>

                            @foreach($customers as $customer)

                                <option
                                    value="{{ $customer->id }}"
                                    {{ old('customer_id') == $customer->id ? 'selected' : '' }}
                                >

                                    {{ $customer->name }}

                                    @if($customer->phone)
                                        — {{ $customer->phone }}
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">

                            Sale Date
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="date"
                            name="sale_date"
                            value="{{ old('sale_date', date('Y-m-d')) }}"
                            class="form-control"
                            required
                        >

                    </div>

                </div>

            </div>

        </div>


        {{-- Products --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">

                <h5 class="fw-bold mb-0">
                    Invoice Items
                </h5>

                <button
                    type="button"
                    class="btn btn-sm btn-primary"
                    id="addItem"
                >

                    <i class="bi bi-plus-lg me-1"></i>
                    Add Product

                </button>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle"
                           id="itemsTable">

                        <thead class="table-light">

                            <tr>

                                <th style="min-width:280px;">
                                    Product
                                </th>

                                <th style="width:150px;">
                                    Price
                                </th>

                                <th style="width:140px;">
                                    Quantity
                                </th>

                                <th style="width:180px;">
                                    Total
                                </th>

                                <th style="width:60px;">
                                </th>

                            </tr>

                        </thead>

                        <tbody id="itemsBody">

                            <tr class="item-row">

                                <td>

                                    <select
                                        name="products[0][id]"
                                        class="form-select product-select"
                                        required
                                    >

                                        <option value="">
                                            Select Product
                                        </option>

                                        @foreach($products as $product)

                                            <option
                                                value="{{ $product->id }}"
                                                data-price="{{ $product->selling_price }}"
                                                data-stock="{{ $product->stock }}"
                                            >

                                                {{ $product->name }}

                                                —
                                                {{ $product->product_code }}

                                                (Stock:
                                                {{ $product->stock }})

                                            </option>

                                        @endforeach

                                    </select>

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        class="form-control price-input"
                                        value="0"
                                        readonly
                                    >

                                </td>


                                <td>

                                    <input
                                        type="number"
                                        name="products[0][quantity]"
                                        class="form-control quantity-input"
                                        value="1"
                                        min="1"
                                        required
                                    >

                                    <small class="text-muted stock-info">
                                    </small>

                                </td>


                                <td>

                                    <input
                                        type="text"
                                        class="form-control total-input"
                                        value="0.00"
                                        readonly
                                    >

                                </td>


                                <td>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger remove-item"
                                    >

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- Totals --}}
        <div class="row justify-content-end">

            <div class="col-lg-5">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">
                                Subtotal
                            </span>

                            <strong>
                                Rs. <span id="subtotal">0.00</span>
                            </strong>

                        </div>


                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Discount
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rs.
                                </span>

                                <input
                                    type="number"
                                    name="discount"
                                    id="discount"
                                    value="{{ old('discount', 0) }}"
                                    class="form-control"
                                    min="0"
                                    step="0.01"
                                >

                            </div>

                        </div>


                        <hr>


                        <div class="d-flex justify-content-between">

                            <span class="fw-bold">
                                Grand Total
                            </span>

                            <h4 class="fw-bold mb-0">

                                Rs.
                                <span id="grandTotal">
                                    0.00
                                </span>

                            </h4>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-success w-100 mt-4"
                        >

                            <i class="bi bi-check-circle me-1"></i>
                            Create Invoice

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const itemsBody = document.getElementById('itemsBody');
    const addItemButton = document.getElementById('addItem');
    const discountInput = document.getElementById('discount');

    let itemIndex = 1;


    function updateRow(row) {

        const select =
            row.querySelector('.product-select');

        const priceInput =
            row.querySelector('.price-input');

        const quantityInput =
            row.querySelector('.quantity-input');

        const totalInput =
            row.querySelector('.total-input');

        const stockInfo =
            row.querySelector('.stock-info');


        const option =
            select.options[select.selectedIndex];


        if (!option || !option.value) {

            priceInput.value = '0.00';
            totalInput.value = '0.00';
            stockInfo.textContent = '';

            calculateTotals();

            return;
        }


        const price =
            parseFloat(option.dataset.price || 0);

        const stock =
            parseInt(option.dataset.stock || 0);


        priceInput.value =
            price.toFixed(2);


        quantityInput.max = stock;


        stockInfo.textContent =
            'Available: ' + stock;


        let quantity =
            parseInt(quantityInput.value || 1);


        if (quantity > stock) {
            quantity = stock;
            quantityInput.value = stock;
        }


        const total =
            price * quantity;


        totalInput.value =
            total.toFixed(2);


        calculateTotals();
    }


    function calculateTotals() {

        let subtotal = 0;


        document
            .querySelectorAll('.item-row')
            .forEach(function (row) {

                const price =
                    parseFloat(
                        row.querySelector('.price-input').value
                    ) || 0;

                const quantity =
                    parseInt(
                        row.querySelector('.quantity-input').value
                    ) || 0;

                const total =
                    price * quantity;


                row.querySelector('.total-input').value =
                    total.toFixed(2);


                subtotal += total;
            });


        let discount =
            parseFloat(discountInput.value) || 0;


        if (discount > subtotal) {
            discount = subtotal;
        }


        const grandTotal =
            subtotal - discount;


        document.getElementById('subtotal')
            .textContent =
            subtotal.toFixed(2);


        document.getElementById('grandTotal')
            .textContent =
            grandTotal.toFixed(2);
    }


    addItemButton.addEventListener('click', function () {

        const firstRow =
            document.querySelector('.item-row');

        const newRow =
            firstRow.cloneNode(true);


        newRow
            .querySelector('.product-select')
            .name =
            `products[${itemIndex}][id]`;


        newRow
            .querySelector('.product-select')
            .selectedIndex = 0;


        newRow
            .querySelector('.quantity-input')
            .name =
            `products[${itemIndex}][quantity]`;


        newRow
            .querySelector('.quantity-input')
            .value = 1;


        newRow
            .querySelector('.price-input')
            .value = '0.00';


        newRow
            .querySelector('.total-input')
            .value = '0.00';


        newRow
            .querySelector('.stock-info')
            .textContent = '';


        itemsBody.appendChild(newRow);

        itemIndex++;

        calculateTotals();
    });


    itemsBody.addEventListener('change', function (event) {

        if (
            event.target.classList.contains(
                'product-select'
            )
        ) {

            updateRow(
                event.target.closest('.item-row')
            );
        }

    });


    itemsBody.addEventListener('input', function (event) {

        if (
            event.target.classList.contains(
                'quantity-input'
            )
        ) {

            updateRow(
                event.target.closest('.item-row')
            );
        }

    });


    itemsBody.addEventListener('click', function (event) {

        const button =
            event.target.closest('.remove-item');


        if (!button) {
            return;
        }


        const rows =
            document.querySelectorAll('.item-row');


        if (rows.length === 1) {

            alert(
                'At least one product is required.'
            );

            return;
        }


        button
            .closest('.item-row')
            .remove();


        calculateTotals();
    });


    discountInput.addEventListener(
        'input',
        calculateTotals
    );


    calculateTotals();

});

</script>

@endsection