@extends('layouts.app')

@section('title', 'Create Purchase')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Create Purchase</h2>
            <p class="text-muted mb-0">Add a new supplier purchase.</p>
        </div>

        <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Purchases
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <form id="purchaseForm" action="{{ route('purchases.store') }}" method="POST">
       @csrf

        {{-- Purchase Information --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Purchase Information</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="supplier_id" class="form-label">
                            Supplier <span class="text-danger">*</span>
                        </label>

                        <select id="supplier_id" name="supplier_id" class="form-select" required>
                            <option value="">Select Supplier</option>

                            @foreach($suppliers as $supplier)
                                <option
                                    value="{{ $supplier->id }}"
                                    @selected(old('supplier_id') == $supplier->id)
                                >
                                    {{ $supplier->name }}
                                    @if($supplier->company_name)
                                        — {{ $supplier->company_name }}
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        @if($suppliers->isEmpty())
                            <small class="text-danger">
                                No suppliers found. Add a supplier first.
                            </small>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="purchase_date" class="form-label">
                            Purchase Date <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            id="purchase_date"
                            name="purchase_date"
                            class="form-control"
                            value="{{ old('purchase_date', now()->format('Y-m-d')) }}"
                            required
                        >
                    </div>

                    <div class="col-12">
                        <label for="notes" class="form-label">Notes</label>

                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            class="form-control"
                            placeholder="Optional purchase notes..."
                        >{{ old('notes') }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        {{-- Products --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0">Purchase Items</h5>

                <button type="button" id="addItemBtn" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Add Product
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="purchaseItemsTable">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width: 240px;">Product</th>
                                <th style="min-width: 130px;">Quantity</th>
                                <th style="min-width: 160px;">Cost Price (Rs.)</th>
                                <th style="min-width: 160px;">Total (Rs.)</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody id="purchaseItemsBody"></tbody>
                    </table>
                </div>

                <div id="noItemsMessage" class="text-center text-muted py-3">
                    No products added yet. Click "Add Product" to begin.
                </div>
            </div>
        </div>

        {{-- Totals --}}
        <div class="row justify-content-end mb-4">
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal</span>
                            <strong id="subtotalDisplay">Rs. 0.00</strong>
                        </div>

                        <div class="mb-3">
                            <label for="discount" class="form-label">Discount (Rs.)</label>

                            <input
                                type="number"
                                id="discount"
                                name="discount"
                                class="form-control"
                                min="0"
                                step="0.01"
                                value="{{ old('discount', '0.00') }}"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="tax" class="form-label">Tax (Rs.)</label>

                            <input
                                type="number"
                                id="tax"
                                name="tax"
                                class="form-control"
                                min="0"
                                step="0.01"
                                value="{{ old('tax', '0.00') }}"
                            >
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Grand Total</span>

                            <h4 class="fw-bold text-primary mb-0" id="grandTotalDisplay">
                                Rs. 0.00
                            </h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('purchases.index') }}" class="btn btn-light border">
                Cancel
            </a>

            <button type="submit" class="btn btn-primary">
    <i class="fas fa-save me-2"></i> Save Purchase
</button>
        </div>

    </form>
</div>

{{-- Product options template --}}
<template id="productOptionsTemplate">
    <option value="">Select Product</option>

    @foreach($products as $product)
        <option
            value="{{ $product->id }}"
            data-price="{{ $product->purchase_price }}"
        >
            {{ $product->name }}
            (Stock: {{ $product->stock }})
        </option>
    @endforeach
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const itemsBody = document.getElementById('purchaseItemsBody');
    const addItemBtn = document.getElementById('addItemBtn');
    const noItemsMessage = document.getElementById('noItemsMessage');
    const discountInput = document.getElementById('discount');
    const taxInput = document.getElementById('tax');
    const productOptionsTemplate = document.getElementById('productOptionsTemplate');

    let rowIndex = 0;

    function money(value) {
        return 'Rs. ' + Number(value).toLocaleString('en-PK', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function updateTotals() {
        let subtotal = 0;

        itemsBody.querySelectorAll('tr').forEach(function (row) {
            const quantity = Number(row.querySelector('.item-quantity').value) || 0;
            const price = Number(row.querySelector('.item-price').value) || 0;
            const total = quantity * price;

            row.querySelector('.item-total').textContent = money(total);
            subtotal += total;
        });

        const discount = Math.max(0, Number(discountInput.value) || 0);
        const tax = Math.max(0, Number(taxInput.value) || 0);
        const grandTotal = Math.max(0, subtotal - discount + tax);

        document.getElementById('subtotalDisplay').textContent = money(subtotal);
        document.getElementById('grandTotalDisplay').textContent = money(grandTotal);

        noItemsMessage.style.display = itemsBody.children.length ? 'none' : 'block';
    }

    function addItemRow() {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>
                <select
                    name="items[${rowIndex}][product_id]"
                    class="form-select item-product"
                    required
                ></select>
            </td>

            <td>
                <input
                    type="number"
                    name="items[${rowIndex}][quantity]"
                    class="form-control item-quantity"
                    min="1"
                    step="1"
                    value="1"
                    required
                >
            </td>

            <td>
                <input
                    type="number"
                    name="items[${rowIndex}][cost_price]"
                    class="form-control item-price"
                    min="0.01"
                    step="0.01"
                    value="0.00"
                    required
                >
            </td>

            <td class="item-total fw-semibold">Rs. 0.00</td>

            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                    Remove
                </button>
            </td>
        `;

        const productSelect = row.querySelector('.item-product');
        productSelect.appendChild(productOptionsTemplate.content.cloneNode(true));

        productSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.dataset.price;

            if (price !== undefined) {
                row.querySelector('.item-price').value = Number(price).toFixed(2);
            }

            updateTotals();
        });

        row.querySelector('.item-quantity').addEventListener('input', updateTotals);
        row.querySelector('.item-price').addEventListener('input', updateTotals);

        row.querySelector('.remove-item').addEventListener('click', function () {
            row.remove();
            updateTotals();
        });

        itemsBody.appendChild(row);
        rowIndex++;

        updateTotals();
    }

    addItemBtn.addEventListener('click', addItemRow);
    discountInput.addEventListener('input', updateTotals);
    taxInput.addEventListener('input', updateTotals);

    addItemRow();
});
</script>
@endsection

