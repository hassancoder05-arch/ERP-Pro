@extends('layouts.app')

@section('title', 'New Sale')

@section('content')

<div class="container-fluid new-sale-page py-3">


{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div class="d-flex align-items-center gap-3">
        <div class="ns-header-icon">
            <i class="bi bi-receipt-cutoff"></i>
        </div>

        <div>
            <div class="ns-eyebrow mb-1">SALES MANAGEMENT</div>
            <h2 class="fw-bold mb-1">Create New Sale</h2>
            <p class="text-muted mb-0">
                Prepare an invoice and add products to the sale.
            </p>
        </div>
    </div>

    <a href="{{ route('sales.index') }}" class="btn ns-btn-back">
        <i class="bi bi-arrow-left me-2"></i>
        Back to Sales
    </a>

</div>


{{-- Validation Errors --}}
@if($errors->any())
    <div class="ns-error-alert mb-4">
        <div class="d-flex align-items-start gap-3">
            <i class="bi bi-exclamation-triangle-fill fs-4"></i>

            <div>
                <h6 class="fw-bold mb-2">Please correct the following errors</h6>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif


<form action="{{ route('sales.store') }}" method="POST" id="saleForm">
    @csrf

    <div class="row g-4">

        {{-- Main Column --}}
        <div class="col-xl-8">

            {{-- Customer Information --}}
            <div class="ns-panel mb-4">

                <div class="ns-panel-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="ns-section-icon ns-icon-purple">
                            <i class="bi bi-person-lines-fill"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Customer Information</h5>
                            <p class="text-muted small mb-0">
                                Select the customer and invoice date.
                            </p>
                        </div>
                    </div>

                    <span class="ns-step-badge">STEP 01</span>
                </div>

                <div class="ns-panel-body">
                    <div class="row g-4">

                        <div class="col-md-7">

                            <label for="customer_id" class="form-label ns-label">
                                Customer <span class="text-danger">*</span>
                            </label>

                            <div class="ns-input-wrap">
                                <i class="bi bi-person ns-input-icon"></i>

                                <select
                                    name="customer_id"
                                    id="customer_id"
                                    class="form-select ns-input @error('customer_id') is-invalid @enderror"
                                    required
                                >
                                    <option value="">Select a customer</option>

                                    @foreach($customers as $customer)
                                        <option
                                            value="{{ $customer->id }}"
                                            data-phone="{{ $customer->phone }}"
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

                            @error('customer_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            <div id="customerPreview" class="ns-customer-preview mt-3" style="display:none;">
                                <div class="ns-customer-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>

                                <div>
                                    <div class="ns-mini-label">Selected Customer</div>
                                    <div class="fw-bold" id="previewCustomerName"></div>
                                    <div class="text-muted small" id="previewCustomerPhone"></div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-5">

                            <label for="sale_date" class="form-label ns-label">
                                Sale Date <span class="text-danger">*</span>
                            </label>

                            <div class="ns-input-wrap">
                                <i class="bi bi-calendar3 ns-input-icon"></i>

                                <input
                                    type="date"
                                    name="sale_date"
                                    id="sale_date"
                                    value="{{ old('sale_date', date('Y-m-d')) }}"
                                    class="form-control ns-input @error('sale_date') is-invalid @enderror"
                                    required
                                >
                            </div>

                            @error('sale_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Date recorded on the sales invoice.
                            </small>

                        </div>

                    </div>
                </div>

            </div>


            {{-- Invoice Items --}}
            <div class="ns-panel mb-4">

                <div class="ns-panel-header ns-items-header">

                    <div class="d-flex align-items-center gap-3">
                        <div class="ns-section-icon ns-icon-blue">
                            <i class="bi bi-basket2"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Invoice Items</h5>
                            <p class="text-muted small mb-0">
                                Add products and set quantities.
                            </p>
                        </div>
                    </div>

                    <button type="button" class="btn ns-btn-add" id="addItem">
                        <i class="bi bi-plus-lg me-1"></i>
                        Add Product
                    </button>

                </div>


                <div class="ns-table-wrap">

                    <table class="table ns-items-table align-middle mb-0" id="itemsTable">

                        <thead>
                            <tr>
                                <th class="ps-4" style="min-width:260px;">PRODUCT</th>
                                <th style="min-width:115px;">PRICE (RS.)</th>
                                <th style="min-width:125px;">QUANTITY</th>
                                <th style="min-width:130px;">TOTAL (RS.)</th>
                                <th class="text-center" style="width:65px;">ACTION</th>
                            </tr>
                        </thead>

                        <tbody id="itemsBody">

                            <tr class="item-row">

                                <td class="ps-4">

                                    <select
                                        name="products[0][id]"
                                        class="form-select ns-input product-select"
                                        required
                                    >
                                        <option value="">Select product</option>

                                        @foreach($products as $product)
                                            <option
                                                value="{{ $product->id }}"
                                                data-price="{{ $product->selling_price }}"
                                                data-stock="{{ $product->stock }}"
                                                data-name="{{ $product->name }}"
                                                data-code="{{ $product->product_code }}"
                                                {{ old('products.0.id') == $product->id ? 'selected' : '' }}
                                            >
                                                {{ $product->name }} — {{ $product->product_code }}
                                                (Stock: {{ $product->stock }})
                                            </option>
                                        @endforeach

                                    </select>

                                    <small class="ns-row-stock stock-info"></small>

                                </td>

                                <td>
                                    <input
                                        type="number"
                                        class="form-control ns-input price-input"
                                        value="0.00"
                                        readonly
                                        tabindex="-1"
                                        aria-label="Product unit price"
                                    >
                                </td>

                                <td>
                                    <input
                                        type="number"
                                        name="products[0][quantity]"
                                        class="form-control ns-input quantity-input"
                                        value="{{ old('products.0.quantity', 1) }}"
                                        min="1"
                                        step="1"
                                        required
                                        aria-label="Product quantity"
                                    >

                                    <small class="ns-row-stock quantity-error" style="display:none;"></small>
                                </td>

                                <td>
                                    <input
                                        type="text"
                                        class="form-control ns-total-input total-input"
                                        value="0.00"
                                        readonly
                                        tabindex="-1"
                                        aria-label="Product line total"
                                    >
                                </td>

                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn ns-remove-btn remove-item"
                                        aria-label="Remove product"
                                        title="Remove product"
                                    >
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                <div class="ns-items-footer">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle text-primary"></i>
                        <span>
                            <strong id="itemCount">1</strong>
                            product row(s) in this invoice.
                        </span>
                    </div>

                    <span class="text-muted small">
                        Prices are taken from product selling prices.
                    </span>
                </div>

            </div>


            {{-- Discount --}}
            <div class="ns-panel mb-4">

                <div class="ns-panel-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="ns-section-icon ns-icon-green">
                            <i class="bi bi-tag"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Discount</h5>
                            <p class="text-muted small mb-0">
                                Apply a discount to the invoice subtotal.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="ns-panel-body">

                    <div class="row align-items-center g-3">

                        <div class="col-md-7">
                            <label for="discount" class="form-label ns-label">
                                Discount Amount
                            </label>

                            <div class="input-group ns-discount-group">
                                <span class="input-group-text">Rs.</span>

                                <input
                                    type="number"
                                    name="discount"
                                    id="discount"
                                    value="{{ old('discount', 0) }}"
                                    class="form-control"
                                    min="0"
                                    step="0.01"
                                    inputmode="decimal"
                                >
                            </div>

                            @error('discount')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            <small class="text-muted d-block mt-2">
                                Discount cannot exceed the subtotal.
                            </small>
                        </div>

                        <div class="col-md-5">
                            <div class="ns-discount-preview">
                                <div class="ns-mini-label">Discount Applied</div>
                                <div class="ns-discount-amount">
                                    Rs. <span id="discountPreview">0.00</span>
                                </div>
                                <div class="text-muted small">
                                    <span id="discountPercent">0.0</span>% of subtotal
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Right Column --}}
        <div class="col-xl-4">

            {{-- Invoice Summary --}}
            <div class="ns-summary-panel mb-4">

                <div class="ns-summary-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="ns-summary-icon">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Invoice Summary</h5>
                            <p class="small mb-0">Review your sale totals.</p>
                        </div>
                    </div>
                </div>


                <div class="ns-summary-body">

                    <div class="ns-summary-row">
                        <span>Product Rows</span>
                        <strong id="summaryRows">1</strong>
                    </div>

                    <div class="ns-summary-row">
                        <span>Total Units</span>
                        <strong id="summaryUnits">1</strong>
                    </div>

                    <div class="ns-summary-row">
                        <span>Subtotal</span>
                        <strong>Rs. <span id="subtotal">0.00</span></strong>
                    </div>

                    <div class="ns-summary-row ns-discount-row">
                        <span>
                            <i class="bi bi-tag me-1"></i>
                            Discount
                        </span>
                        <strong>− Rs. <span id="summaryDiscount">0.00</span></strong>
                    </div>

                    <div class="ns-summary-divider"></div>

                    <div class="ns-grand-total-label">Grand Total</div>

                    <div class="ns-grand-total">
                        <span class="ns-currency">Rs.</span>
                        <span id="grandTotal">0.00</span>
                    </div>

                    <div class="ns-total-note">
                        <i class="bi bi-shield-check me-1"></i>
                        Final totals must be validated by the server.
                    </div>

                    <button
                        type="submit"
                        class="btn ns-btn-create w-100 mt-4"
                        id="createInvoiceButton"
                    >
                        <i class="bi bi-check-circle me-2"></i>
                        Create Invoice
                    </button>

                    <a href="{{ route('sales.index') }}" class="btn ns-btn-cancel w-100 mt-2">
                        Cancel Sale
                    </a>

                </div>

            </div>


            {{-- Selected Customer Card --}}
            <div class="ns-side-card mb-4">

                <div class="ns-side-card-heading">
                    <i class="bi bi-person-check me-2"></i>
                    Customer Overview
                </div>

                <div class="ns-side-card-body">

                    <div class="ns-customer-empty" id="customerEmpty">
                        <div class="ns-side-empty-icon">
                            <i class="bi bi-person"></i>
                        </div>

                        <p class="text-muted small mb-0 mt-2">
                            Select a customer to see their details here.
                        </p>
                    </div>

                    <div id="customerSideInfo" style="display:none;">

                        <div class="ns-side-customer-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <h6 class="fw-bold text-center mt-3 mb-1" id="sideCustomerName"></h6>

                        <p class="text-muted small text-center mb-3" id="sideCustomerPhone"></p>

                        <div class="ns-side-info-row">
                            <span>Sale Date</span>
                            <strong id="sideSaleDate">—</strong>
                        </div>

                        <div class="ns-side-info-row">
                            <span>Product Rows</span>
                            <strong id="sideItemCount">1</strong>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Sale Checklist --}}
            <div class="ns-side-card">

                <div class="ns-side-card-heading">
                    <i class="bi bi-clipboard-check me-2"></i>
                    Before You Save
                </div>

                <div class="ns-checklist">

                    <div class="ns-check-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Choose the correct customer</span>
                    </div>

                    <div class="ns-check-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Verify products and quantities</span>
                    </div>

                    <div class="ns-check-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Confirm the discount amount</span>
                    </div>

                    <div class="ns-check-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Review the grand total</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</form>


<div class="ns-page-footer">
    <i class="bi bi-shield-check me-1"></i>
    Sales Management · Review invoice details before submission.
</div>


</div>

<style>
    .new-sale-page {
        color: #172033;
    }

    .new-sale-page .ns-header-icon {
        width: 55px;
        height: 55px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        color: #fff;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        box-shadow: 0 8px 20px rgba(79, 70, 229, .20);
        font-size: 24px;
    }

    .new-sale-page .ns-eyebrow {
        color: #6366f1;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.3px;
    }

    .new-sale-page h2 {
        color: #172033;
        font-size: clamp(1.4rem, 2vw, 1.8rem);
        letter-spacing: -.5px;
    }

    .new-sale-page .ns-btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 10px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        color: #475569;
        background: #fff;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .new-sale-page .ns-btn-back:hover {
        background: #f8fafc;
    }

    .new-sale-page .ns-error-alert {
        padding: 18px 20px;
        border: 1px solid #fecaca;
        border-radius: 13px;
        color: #991b1b;
        background: #fef2f2;
    }

    .new-sale-page .ns-panel {
        overflow: hidden;
        border: 1px solid #e9edf5;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .035);
    }

    .new-sale-page .ns-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 21px 24px;
        border-bottom: 1px solid #edf0f5;
    }

    .new-sale-page .ns-panel-header h5 {
        color: #172033;
        font-size: 14px;
    }

    .new-sale-page .ns-panel-header p {
        line-height: 1.6;
    }

    .new-sale-page .ns-panel-body {
        padding: 24px;
    }

    .new-sale-page .ns-section-icon {
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 19px;
    }

    .new-sale-page .ns-icon-purple {
        color: #7c3aed;
        background: #ede9fe;
    }

    .new-sale-page .ns-icon-blue {
        color: #2563eb;
        background: #dbeafe;
    }

    .new-sale-page .ns-icon-green {
        color: #059669;
        background: #d1fae5;
    }

    .new-sale-page .ns-step-badge {
        padding: 7px 9px;
        border-radius: 7px;
        color: #6366f1;
        background: #eef2ff;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .7px;
        white-space: nowrap;
    }

    .new-sale-page .ns-label {
        margin-bottom: 9px;
        color: #334155;
        font-size: 12px;
        font-weight: 750;
    }

    .new-sale-page .ns-input-wrap {
        position: relative;
    }

    .new-sale-page .ns-input-icon {
        position: absolute;
        z-index: 2;
        top: 50%;
        left: 13px;
        color: #94a3b8;
        font-size: 15px;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .new-sale-page .ns-input {
        min-height: 44px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        color: #1e293b;
        background-color: #fff;
        font-size: 12px;
    }

    .new-sale-page .ns-input-wrap .ns-input {
        padding-left: 38px;
    }

    .new-sale-page .ns-input:focus,
    .new-sale-page .ns-discount-group .form-control:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, .10);
    }

    .new-sale-page .ns-customer-preview {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px;
        border: 1px solid #e0e7ff;
        border-radius: 11px;
        background: #f8faff;
    }

    .new-sale-page .ns-customer-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 39px;
        height: 39px;
        flex-shrink: 0;
        border-radius: 11px;
        color: #4f46e5;
        background: #e0e7ff;
        font-size: 18px;
    }

    .new-sale-page .ns-mini-label {
        margin-bottom: 4px;
        color: #94a3b8;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .7px;
    }

    .new-sale-page .ns-btn-add {
        padding: 9px 12px;
        border: 0;
        border-radius: 9px;
        color: #fff;
        background: #4f46e5;
        font-size: 11px;
        font-weight: 750;
        white-space: nowrap;
    }

    .new-sale-page .ns-btn-add:hover {
        color: #fff;
        background: #4338ca;
    }

    .new-sale-page .ns-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .new-sale-page .ns-items-table {
        min-width: 700px;
    }

    .new-sale-page .ns-items-table thead th {
        padding: 15px 12px;
        border-bottom: 1px solid #e9edf5;
        color: #64748b;
        background: #f8fafc;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .7px;
        white-space: nowrap;
    }

    .new-sale-page .ns-items-table tbody td {
        padding: 16px 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: top;
    }

    .new-sale-page .ns-items-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .new-sale-page .ns-items-table .ns-input {
        min-height: 42px;
        padding: 9px 10px;
    }

    .new-sale-page .ns-items-table .price-input {
        color: #475569;
        background: #f8fafc;
        font-weight: 650;
    }

    .new-sale-page .ns-items-table .ns-total-input {
        color: #312e81;
        background: #f5f3ff;
        border-color: #e0e7ff;
        font-weight: 800;
    }

    .new-sale-page .ns-row-stock {
        display: block;
        margin-top: 6px;
        color: #94a3b8;
        font-size: 10px;
        line-height: 1.5;
    }

    .new-sale-page .ns-row-stock.stock-available {
        color: #059669;
    }

    .new-sale-page .ns-row-stock.stock-warning {
        color: #dc2626;
        font-weight: 700;
    }

    .new-sale-page .ns-remove-btn {
        width: 34px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #fee2e2;
        border-radius: 9px;
        color: #dc2626;
        background: #fff7f7;
        font-size: 14px;
    }

    .new-sale-page .ns-remove-btn:hover {
        color: #fff;
        background: #dc2626;
        border-color: #dc2626;
    }

    .new-sale-page .ns-items-footer {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 15px 23px;
        border-top: 1px solid #edf0f5;
        color: #64748b;
        background: #fcfdff;
        font-size: 11px;
    }

    .new-sale-page .ns-discount-group .input-group-text {
        min-height: 44px;
        border-color: #e2e8f0;
        border-radius: 9px 0 0 9px;
        color: #64748b;
        background: #f8fafc;
        font-size: 12px;
        font-weight: 700;
    }

    .new-sale-page .ns-discount-group .form-control {
        min-height: 44px;
        border-color: #e2e8f0;
        border-radius: 0 9px 9px 0;
        font-size: 12px;
    }

    .new-sale-page .ns-discount-preview {
        padding: 15px;
        border: 1px solid #d1fae5;
        border-radius: 11px;
        background: #f0fdf4;
    }

    .new-sale-page .ns-discount-amount {
        margin: 5px 0;
        color: #047857;
        font-size: 21px;
        font-weight: 800;
    }

    .new-sale-page .ns-summary-panel {
        overflow: hidden;
        border: 1px solid #e0e7ff;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 7px 26px rgba(15, 23, 42, .055);
    }

    .new-sale-page .ns-summary-header {
        padding: 23px;
        color: #fff;
        background: linear-gradient(135deg, #312e81, #4f46e5);
    }

    .new-sale-page .ns-summary-header h5 {
        font-size: 15px;
    }

    .new-sale-page .ns-summary-header p {
        color: #c7d2fe;
    }

    .new-sale-page .ns-summary-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 43px;
        border-radius: 12px;
        color: #fff;
        background: rgba(255, 255, 255, .15);
        font-size: 19px;
    }

    .new-sale-page .ns-summary-body {
        padding: 23px;
    }

    .new-sale-page .ns-summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 0;
        color: #64748b;
        font-size: 12px;
    }

    .new-sale-page .ns-summary-row strong {
        color: #334155;
        font-size: 12px;
        font-weight: 750;
        text-align: right;
    }

    .new-sale-page .ns-discount-row strong {
        color: #059669;
    }

    .new-sale-page .ns-summary-divider {
        height: 1px;
        margin: 8px 0 18px;
        background: #e9edf5;
    }

    .new-sale-page .ns-grand-total-label {
        margin-bottom: 6px;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
    }

    .new-sale-page .ns-grand-total {
        display: flex;
        align-items: baseline;
        gap: 8px;
        color: #312e81;
        font-size: clamp(1.8rem, 3vw, 2.35rem);
        font-weight: 850;
        letter-spacing: -1px;
        overflow-wrap: anywhere;
    }

    .new-sale-page .ns-currency {
        color: #818cf8;
        font-size: 13px;
        font-weight: 750;
        letter-spacing: 0;
    }

    .new-sale-page .ns-total-note {
        margin-top: 12px;
        color: #94a3b8;
        font-size: 10px;
        line-height: 1.6;
    }

    .new-sale-page .ns-btn-create {
        min-height: 47px;
        padding: 12px 16px;
        border: 0;
        border-radius: 10px;
        color: #fff;
        background: linear-gradient(135deg, #059669, #10b981);
        box-shadow: 0 6px 15px rgba(16, 185, 129, .18);
        font-size: 12px;
        font-weight: 800;
        transition: .2s ease;
    }

    .new-sale-page .ns-btn-create:hover {
        color: #fff;
        background: #047857;
        transform: translateY(-1px);
    }

    .new-sale-page .ns-btn-create:disabled {
        opacity: .65;
        cursor: wait;
        transform: none;
    }

    .new-sale-page .ns-btn-cancel {
        min-height: 42px;
        padding: 10px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        color: #64748b;
        background: #fff;
        font-size: 11px;
        font-weight: 700;
    }

    .new-sale-page .ns-btn-cancel:hover {
        background: #f8fafc;
    }

    .new-sale-page .ns-side-card {
        overflow: hidden;
        border: 1px solid #e9edf5;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .035);
    }

    .new-sale-page .ns-side-card-heading {
        padding: 18px 20px;
        border-bottom: 1px solid #edf0f5;
        color: #334155;
        font-size: 12px;
        font-weight: 800;
    }

    .new-sale-page .ns-side-card-heading i {
        color: #6366f1;
        font-size: 15px;
    }

    .new-sale-page .ns-side-card-body {
        padding: 21px;
    }

    .new-sale-page .ns-customer-empty {
        padding: 8px 0;
        text-align: center;
    }

    .new-sale-page .ns-side-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        margin: auto;
        border-radius: 14px;
        color: #94a3b8;
        background: #f1f5f9;
        font-size: 22px;
    }

    .new-sale-page .ns-side-customer-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 55px;
        height: 55px;
        margin: auto;
        border-radius: 17px;
        color: #4f46e5;
        background: #eef2ff;
        font-size: 25px;
    }

    .new-sale-page .ns-side-info-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 0;
        border-top: 1px solid #f1f5f9;
        font-size: 11px;
    }

    .new-sale-page .ns-side-info-row span {
        color: #64748b;
    }

    .new-sale-page .ns-side-info-row strong {
        color: #334155;
        text-align: right;
    }

    .new-sale-page .ns-checklist {
        padding: 8px 20px 20px;
    }

    .new-sale-page .ns-check-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 0;
        color: #64748b;
        font-size: 11px;
        line-height: 1.5;
    }

    .new-sale-page .ns-check-item i {
        color: #10b981;
        font-size: 14px;
    }

    .new-sale-page .ns-page-footer {
        padding: 5px 0 12px;
        color: #94a3b8;
        font-size: 10px;
        text-align: center;
    }

    @media (max-width: 767px) {
        .new-sale-page .ns-panel-header,
        .new-sale-page .ns-panel-body {
            padding: 17px;
        }

        .new-sale-page .ns-items-header {
            align-items: flex-start;
        }

        .new-sale-page .ns-items-footer {
            padding: 14px 17px;
        }

        .new-sale-page .ns-summary-header,
        .new-sale-page .ns-summary-body {
            padding: 19px;
        }

        .new-sale-page .ns-step-badge {
            display: none;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('saleForm');
    const itemsBody = document.getElementById('itemsBody');
    const addItemButton = document.getElementById('addItem');
    const discountInput = document.getElementById('discount');
    const customerSelect = document.getElementById('customer_id');
    const saleDateInput = document.getElementById('sale_date');
    const createInvoiceButton = document.getElementById('createInvoiceButton');

    let itemIndex = 1;

   
const productOptions = {{ Illuminate\Support\Js::from(
    $products->map(function ($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'code' => $product->product_code,
            'price' => (float) $product->selling_price,
            'stock' => (int) $product->stock,
        ];
    })->values()
) }};




    function money(value) {
        return (Number(value) || 0).toLocaleString('en-PK', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
            useGrouping: false
        });
    }


    function getProductOptionsHtml() {
        let html = '<option value="">Select product</option>';

        productOptions.forEach(function (product) {
            const label = `${product.name} — ${product.code} (Stock: ${product.stock})`;

            html += `<option
                value="${product.id}"
                data-price="${product.price}"
                data-stock="${product.stock}"
                data-name="${escapeHtml(product.name)}"
                data-code="${escapeHtml(product.code || '')}"
            >${escapeHtml(label)}</option>`;
        });

        return html;
    }


    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (character) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[character];
        });
    }


    function getRowProduct(row) {
        const select = row.querySelector('.product-select');
        const option = select.options[select.selectedIndex];

        if (!option || !option.value) {
            return null;
        }

        return {
            id: option.value,
            name: option.dataset.name || option.textContent.trim(),
            code: option.dataset.code || '',
            price: Number(option.dataset.price || 0),
            stock: Number(option.dataset.stock || 0)
        };
    }


    function getRowQuantity(row) {
        const input = row.querySelector('.quantity-input');
        const parsed = Number.parseInt(input.value, 10);

        return Number.isFinite(parsed) ? parsed : 0;
    }


    function updateRow(row) {
        const product = getRowProduct(row);
        const priceInput = row.querySelector('.price-input');
        const quantityInput = row.querySelector('.quantity-input');
        const totalInput = row.querySelector('.total-input');
        const stockInfo = row.querySelector('.stock-info');
        const quantityError = row.querySelector('.quantity-error');

        quantityError.style.display = 'none';
        quantityError.textContent = '';
        quantityInput.setCustomValidity('');

        if (!product) {
            priceInput.value = '0.00';
            totalInput.value = '0.00';
            quantityInput.removeAttribute('max');
            stockInfo.textContent = 'Select a product to see stock.';
            stockInfo.className = 'ns-row-stock stock-info';
            calculateTotals();
            return;
        }

        priceInput.value = money(product.price);
        quantityInput.max = String(product.stock);

        stockInfo.textContent = `Available stock: ${product.stock}`;
        stockInfo.className = 'ns-row-stock stock-info stock-available';

        const quantity = getRowQuantity(row);

        if (product.stock < 1) {
            stockInfo.textContent = 'Out of stock';
            stockInfo.className = 'ns-row-stock stock-info stock-warning';
            quantityError.textContent = 'This product is currently out of stock.';
            quantityError.style.display = 'block';
            quantityInput.setCustomValidity('This product is out of stock.');
        } else if (quantity > product.stock) {
            stockInfo.className = 'ns-row-stock stock-info stock-warning';
            quantityError.textContent = `Available stock is ${product.stock}. Reduce the quantity.`;
            quantityError.style.display = 'block';
            quantityInput.setCustomValidity('Quantity exceeds available stock.');
        }

        totalInput.value = money(product.price * Math.max(0, quantity));

        calculateTotals();
    }


    function calculateTotals() {
        let subtotal = 0;
        let totalUnits = 0;
        let validRows = 0;

        document.querySelectorAll('.item-row').forEach(function (row) {
            const product = getRowProduct(row);
            const quantity = getRowQuantity(row);
            const price = product ? product.price : 0;
            const lineTotal = product && quantity > 0 ? price * quantity : 0;

            row.querySelector('.total-input').value = money(lineTotal);

            subtotal += lineTotal;

            if (product && quantity > 0) {
                validRows++;
                totalUnits += quantity;
            }
        });

        const requestedDiscount = Math.max(0, Number(discountInput.value) || 0);
        const appliedDiscount = Math.min(requestedDiscount, subtotal);
        const grandTotal = Math.max(0, subtotal - appliedDiscount);
        const discountPercent = subtotal > 0 ? (appliedDiscount / subtotal) * 100 : 0;

        document.getElementById('subtotal').textContent = money(subtotal);
        document.getElementById('grandTotal').textContent = money(grandTotal);
        document.getElementById('discountPreview').textContent = money(appliedDiscount);
        document.getElementById('discountPercent').textContent = discountPercent.toFixed(1);
        document.getElementById('summaryDiscount').textContent = money(appliedDiscount);

        document.getElementById('itemCount').textContent =
            document.querySelectorAll('.item-row').length;

        document.getElementById('summaryRows').textContent = validRows;
        document.getElementById('summaryUnits').textContent = totalUnits;
        document.getElementById('sideItemCount').textContent = validRows;
    }


    function updateCustomerPreview() {
        const option = customerSelect.options[customerSelect.selectedIndex];
        const hasCustomer = option && option.value;

        document.getElementById('customerPreview').style.display =
            hasCustomer ? 'flex' : 'none';

        document.getElementById('customerEmpty').style.display =
            hasCustomer ? 'none' : 'block';

        document.getElementById('customerSideInfo').style.display =
            hasCustomer ? 'block' : 'none';

        if (hasCustomer) {
            const customerName = option.textContent.trim();
            const customerPhone = option.dataset.phone || 'No phone provided';

            document.getElementById('previewCustomerName').textContent = customerName;
            document.getElementById('previewCustomerPhone').textContent = customerPhone;

            document.getElementById('sideCustomerName').textContent = customerName;
            document.getElementById('sideCustomerPhone').textContent = customerPhone;
        }
    }


    function updateSaleDate() {
        const value = saleDateInput.value;

        document.getElementById('sideSaleDate').textContent = value || '—';
    }


    addItemButton.addEventListener('click', function () {
        const row = document.createElement('tr');
        row.className = 'item-row';

        row.innerHTML = `
            <td class="ps-4">
                <select name="products[${itemIndex}][id]" class="form-select ns-input product-select" required>
                    ${getProductOptionsHtml()}
                </select>
                <small class="ns-row-stock stock-info">Select a product to see stock.</small>
            </td>

            <td>
                <input type="number" class="form-control ns-input price-input"
                       value="0.00" readonly tabindex="-1" aria-label="Product unit price">
            </td>

            <td>
                <input type="number" name="products[${itemIndex}][quantity]"
                       class="form-control ns-input quantity-input"
                       value="1" min="1" step="1" required aria-label="Product quantity">
                <small class="ns-row-stock quantity-error" style="display:none;"></small>
            </td>

            <td>
                <input type="text" class="form-control ns-total-input total-input"
                       value="0.00" readonly tabindex="-1" aria-label="Product line total">
            </td>

            <td class="text-center">
                <button type="button" class="btn ns-remove-btn remove-item"
                        aria-label="Remove product" title="Remove product">
                    <i class="bi bi-trash3"></i>
                </button>
            </td>
        `;

        itemsBody.appendChild(row);
        itemIndex++;

        updateRow(row);
        row.querySelector('.product-select').focus();
    });


    itemsBody.addEventListener('change', function (event) {
        if (event.target.classList.contains('product-select')) {
            updateRow(event.target.closest('.item-row'));
        }
    });


    itemsBody.addEventListener('input', function (event) {
        if (event.target.classList.contains('quantity-input')) {
            updateRow(event.target.closest('.item-row'));
        }
    });


    itemsBody.addEventListener('click', function (event) {
        const button = event.target.closest('.remove-item');

        if (!button) {
            return;
        }

        const rows = document.querySelectorAll('.item-row');

        if (rows.length <= 1) {
            alert('At least one product row is required.');
            return;
        }

        button.closest('.item-row').remove();
        calculateTotals();
    });


    discountInput.addEventListener('input', calculateTotals);

    customerSelect.addEventListener('change', updateCustomerPreview);

    saleDateInput.addEventListener('change', updateSaleDate);


    form.addEventListener('submit', function (event) {
        let hasInvalidProduct = false;
        const rows = document.querySelectorAll('.item-row');

        if (rows.length === 0) {
            event.preventDefault();
            alert('Add at least one product to the invoice.');
            return;
        }

        rows.forEach(function (row) {
            const product = getRowProduct(row);
            const quantity = getRowQuantity(row);
            const quantityInput = row.querySelector('.quantity-input');

            if (!product) {
                hasInvalidProduct = true;
                row.querySelector('.product-select').setCustomValidity('Please select a product.');
            } else if (product.stock < 1 || quantity < 1 || quantity > product.stock) {
                hasInvalidProduct = true;
                quantityInput.setCustomValidity('Enter a valid quantity within available stock.');
            }
        });

        const subtotal = rows.reduce(function (sum, row) {
            const product = getRowProduct(row);
            const quantity = getRowQuantity(row);

            return sum + (product && quantity > 0 ? product.price * quantity : 0);
        }, 0);

        const discount = Number(discountInput.value || 0);

        if (!Number.isFinite(discount) || discount < 0 || discount > subtotal) {
            event.preventDefault();
            discountInput.setCustomValidity('Discount must be between zero and the subtotal.');
        } else {
            discountInput.setCustomValidity('');
        }

        if (hasInvalidProduct || !form.checkValidity()) {
            event.preventDefault();
            form.reportValidity();
            return;
        }

        createInvoiceButton.disabled = true;
        createInvoiceButton.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Creating Invoice...';
    });


    // Restore calculations when the page is reopened after validation errors.
    document.querySelectorAll('.item-row').forEach(function (row) {
        updateRow(row);
    });

    updateCustomerPreview();
    updateSaleDate();
    calculateTotals();

});
</script>

@endsection
