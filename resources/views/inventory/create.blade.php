@extends('layouts.app')

@section('title', 'Stock Transaction')

@section('content')

<div class="container-fluid stock-transaction-page py-3">


{{-- Page Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>
        <div class="d-flex align-items-center gap-3 mb-2">
            <div class="st-header-icon">
                <i class="bi bi-arrow-left-right"></i>
            </div>

            <div>
                <h2 class="fw-bold mb-1">Stock Transaction</h2>
                <p class="text-muted mb-0">
                    Manage stock movements and inventory adjustments.
                </p>
            </div>
        </div>
    </div>

    <a href="{{ route('inventory.index') }}" class="btn st-btn-back">
        <i class="bi bi-arrow-left me-2"></i>Back to Inventory
    </a>

</div>


{{-- Validation Errors --}}
@if($errors->any())
    <div class="alert st-error-alert border-0 mb-4">
        <div class="d-flex align-items-start gap-3">
            <i class="bi bi-exclamation-triangle-fill fs-4"></i>

            <div>
                <h6 class="fw-bold mb-2">Please fix the following errors</h6>

                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif


<div class="row g-4">

    {{-- Main Form --}}
    <div class="col-xl-8">

        <div class="st-card">

            <div class="st-card-header">
                <div>
                    <h5 class="fw-bold mb-1">Transaction Details</h5>
                    <p class="text-muted mb-0 small">
                        Enter the details for this stock movement.
                    </p>
                </div>

                <span class="st-required-badge">
                    <span class="text-danger">*</span> Required fields
                </span>
            </div>

            <div class="st-card-body">

                <form action="{{ route('inventory.store') }}" method="POST" id="stockTransactionForm">
                    @csrf

                    {{-- Product Selection --}}
                    <div class="st-section-title">
                        <span class="st-section-icon">
                            <i class="bi bi-box-seam"></i>
                        </span>
                        <span>Product Information</span>
                    </div>

                    <div class="mb-4">

                        <label for="product_id" class="form-label st-label">
                            Select Product <span class="text-danger">*</span>
                        </label>

                        <select
                            name="product_id"
                            id="product_id"
                            class="form-select st-input @error('product_id') is-invalid @enderror"
                            required
                        >
                            <option value="">Choose a product...</option>

                            @foreach($products as $product)
                                <option
                                    value="{{ $product->id }}"
                                    data-stock="{{ $product->stock }}"
                                    data-code="{{ $product->product_code }}"
                                    {{ old('product_id', request('product_id')) == $product->id ? 'selected' : '' }}
                                >
                                    {{ $product->name }} — {{ $product->product_code }}
                                    (Stock: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>

                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            Select the product whose inventory you want to update.
                        </small>

                        <div id="selectedProductInfo" class="st-selected-product mt-3" style="display:none;">
                            <div class="st-product-symbol">
                                <i class="bi bi-box"></i>
                            </div>

                            <div class="flex-grow-1">
                                <span class="st-mini-label">Selected Product</span>
                                <div id="selectedProductCode" class="fw-semibold"></div>
                            </div>

                            <div class="text-end">
                                <span class="st-mini-label">Current Stock</span>
                                <div class="fw-bold fs-5" id="selectedProductStock">0</div>
                            </div>
                        </div>

                    </div>


                    {{-- Transaction Type --}}
                    <div class="st-section-title mt-4">
                        <span class="st-section-icon">
                            <i class="bi bi-arrow-down-up"></i>
                        </span>
                        <span>Transaction Type</span>
                    </div>

                    <div class="row g-3 mb-4">

                        <div class="col-md-4">
                            <label class="st-type-option w-100" for="type_stock_in">
                                <input
                                    type="radio"
                                    name="type"
                                    id="type_stock_in"
                                    value="stock_in"
                                    class="st-type-radio"
                                    {{ old('type') === 'stock_in' ? 'checked' : '' }}
                                    required
                                >

                                <div class="st-type-card st-type-in">
                                    <span class="st-type-icon">
                                        <i class="bi bi-box-arrow-in-down"></i>
                                    </span>

                                    <span class="st-type-name">Stock In</span>

                                    <span class="st-type-description">
                                        Add stock
                                    </span>

                                    <span class="st-type-check">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </span>
                                </div>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <label class="st-type-option w-100" for="type_stock_out">
                                <input
                                    type="radio"
                                    name="type"
                                    id="type_stock_out"
                                    value="stock_out"
                                    class="st-type-radio"
                                    {{ old('type') === 'stock_out' ? 'checked' : '' }}
                                >

                                <div class="st-type-card st-type-out">
                                    <span class="st-type-icon">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </span>

                                    <span class="st-type-name">Stock Out</span>

                                    <span class="st-type-description">
                                        Remove stock
                                    </span>

                                    <span class="st-type-check">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </span>
                                </div>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <label class="st-type-option w-100" for="type_adjustment">
                                <input
                                    type="radio"
                                    name="type"
                                    id="type_adjustment"
                                    value="adjustment"
                                    class="st-type-radio"
                                    {{ old('type') === 'adjustment' ? 'checked' : '' }}
                                >

                                <div class="st-type-card st-type-adjust">
                                    <span class="st-type-icon">
                                        <i class="bi bi-sliders"></i>
                                    </span>

                                    <span class="st-type-name">Adjustment</span>

                                    <span class="st-type-description">
                                        Set total stock
                                    </span>

                                    <span class="st-type-check">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </span>
                                </div>
                            </label>
                        </div>

                    </div>


                    {{-- Quantity & Reference --}}
                    <div class="st-section-title mt-4">
                        <span class="st-section-icon">
                            <i class="bi bi-hash"></i>
                        </span>
                        <span>Quantity & Reference</span>
                    </div>

                    <div class="row g-4 mb-4">

                        <div class="col-md-6">

                            <label for="quantity" class="form-label st-label">
                                <span id="quantityLabel">Quantity</span>
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group st-input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-123"></i>
                                </span>

                                <input
                                    type="number"
                                    name="quantity"
                                    id="quantity"
                                    value="{{ old('quantity', 1) }}"
                                    class="form-control st-input @error('quantity') is-invalid @enderror"
                                    min="1"
                                    step="1"
                                    required
                                >
                            </div>

                            @error('quantity')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            <small class="text-muted d-block mt-2" id="quantityHelp">
                                Enter the quantity for this transaction.
                            </small>

                            <div id="stockCalculation" class="st-stock-calculation mt-3" style="display:none;">
                                <div>
                                    <span class="st-mini-label">Estimated New Stock</span>
                                    <div class="fw-bold fs-5" id="estimatedStock">—</div>
                                </div>

                                <span id="stockChangeBadge" class="st-change-badge">—</span>
                            </div>

                            <div id="stockWarning" class="small text-danger mt-2" style="display:none;">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                Stock out quantity cannot exceed available stock.
                            </div>

                        </div>

                        <div class="col-md-6">

                            <label for="reference" class="form-label st-label">
                                Reference Number
                            </label>

                            <div class="input-group st-input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-receipt"></i>
                                </span>

                                <input
                                    type="text"
                                    name="reference"
                                    id="reference"
                                    value="{{ old('reference') }}"
                                    class="form-control st-input @error('reference') is-invalid @enderror"
                                    placeholder="e.g. PURCHASE-001"
                                    maxlength="255"
                                >
                            </div>

                            @error('reference')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            <small class="text-muted d-block mt-2">
                                Optional invoice, purchase or document reference.
                            </small>

                        </div>

                    </div>


                    {{-- Notes --}}
                    <div class="st-section-title mt-4">
                        <span class="st-section-icon">
                            <i class="bi bi-card-text"></i>
                        </span>
                        <span>Additional Information</span>
                    </div>

                    <div class="mb-4">

                        <label for="notes" class="form-label st-label">
                            Transaction Notes
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            rows="4"
                            class="form-control st-input @error('notes') is-invalid @enderror"
                            placeholder="Explain the reason for this stock transaction..."
                        >{{ old('notes') }}</textarea>

                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted d-block mt-2">
                            Add details for future reference and inventory auditing.
                        </small>

                    </div>


                    {{-- Form Footer --}}
                    <div class="st-form-footer">

                        <div class="st-footer-note">
                            <i class="bi bi-shield-check me-2"></i>
                            Verify the product and quantity before saving.
                        </div>

                        <div class="d-flex flex-wrap gap-2">

                            <a href="{{ route('inventory.index') }}" class="btn st-btn-cancel">
                                Cancel
                            </a>

                            <button type="submit" class="btn st-btn-submit" id="submitTransaction">
                                <i class="bi bi-check2-circle me-2"></i>
                                Save Transaction
                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>


    {{-- Sidebar --}}
    <div class="col-xl-4">

        {{-- Guidance Card --}}
        <div class="st-card mb-4">

            <div class="st-card-header">
                <div>
                    <h5 class="fw-bold mb-1">Transaction Guide</h5>
                    <p class="text-muted small mb-0">Understand each movement type.</p>
                </div>

                <i class="bi bi-lightbulb st-header-secondary-icon"></i>
            </div>

            <div class="st-guide-list">

                <div class="st-guide-item">
                    <span class="st-guide-icon st-guide-in">
                        <i class="bi bi-plus-lg"></i>
                    </span>

                    <div>
                        <h6 class="fw-bold mb-1">Stock In</h6>
                        <p class="text-muted small mb-0">
                            Increases available stock. Use for additional stock received.
                        </p>
                    </div>
                </div>

                <div class="st-guide-item">
                    <span class="st-guide-icon st-guide-out">
                        <i class="bi bi-dash-lg"></i>
                    </span>

                    <div>
                        <h6 class="fw-bold mb-1">Stock Out</h6>
                        <p class="text-muted small mb-0">
                            Decreases available stock. The transaction must not exceed current stock.
                        </p>
                    </div>
                </div>

                <div class="st-guide-item">
                    <span class="st-guide-icon st-guide-adjust">
                        <i class="bi bi-sliders"></i>
                    </span>

                    <div>
                        <h6 class="fw-bold mb-1">Stock Adjustment</h6>
                        <p class="text-muted small mb-0">
                            Sets the new total stock quantity to match a physical stock count.
                        </p>
                    </div>
                </div>

            </div>

        </div>


        {{-- Safety Reminder --}}
        <div class="st-safety-card mb-4">
            <div class="st-safety-icon">
                <i class="bi bi-shield-check"></i>
            </div>

            <h6 class="fw-bold mb-2">Inventory Accuracy</h6>

            <p class="text-muted small mb-3">
                Every stock movement should have a clear reason. Add a reference or notes whenever possible to make future audits easier.
            </p>

            <div class="st-safety-divider"></div>

            <div class="d-flex align-items-center gap-2 small">
                <i class="bi bi-check-circle-fill text-success"></i>
                <span>Review the selected product</span>
            </div>

            <div class="d-flex align-items-center gap-2 small mt-2">
                <i class="bi bi-check-circle-fill text-success"></i>
                <span>Confirm the quantity and movement type</span>
            </div>

            <div class="d-flex align-items-center gap-2 small mt-2">
                <i class="bi bi-check-circle-fill text-success"></i>
                <span>Save a useful transaction reference</span>
            </div>
        </div>


        {{-- Quick Summary --}}
        <div class="st-summary-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="fw-bold">Transaction Summary</span>
                <i class="bi bi-clipboard-data"></i>
            </div>

            <div class="st-summary-row">
                <span>Selected Product</span>
                <strong id="summaryProduct">Not selected</strong>
            </div>

            <div class="st-summary-row">
                <span>Movement Type</span>
                <strong id="summaryType">Not selected</strong>
            </div>

            <div class="st-summary-row">
                <span>Quantity</span>
                <strong id="summaryQuantity">1</strong>
            </div>

            <div class="st-summary-row">
                <span>Current Stock</span>
                <strong id="summaryCurrentStock">—</strong>
            </div>

            <div class="st-summary-row st-summary-total">
                <span>Estimated New Stock</span>
                <strong id="summaryNewStock">—</strong>
            </div>

            <p class="text-muted small mt-3 mb-0">
                <i class="bi bi-info-circle me-1"></i>
                This is a browser-side estimate. The server must validate stock before saving.
            </p>
        </div>

    </div>

</div>


</div>

<style>
    .stock-transaction-page {
        color: #172033;
    }

    .stock-transaction-page .st-header-icon {
        width: 54px;
        height: 54px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        color: #fff;
        font-size: 23px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        box-shadow: 0 8px 20px rgba(79, 70, 229, .20);
    }

    .stock-transaction-page h2 {
        font-size: clamp(1.45rem, 2vw, 1.85rem);
        letter-spacing: -.5px;
    }

    .stock-transaction-page .st-btn-back,
    .stock-transaction-page .st-btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 10px 17px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: .2s ease;
    }

    .stock-transaction-page .st-btn-back {
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #475569;
    }

    .stock-transaction-page .st-btn-back:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .stock-transaction-page .st-card {
        background: #fff;
        border: 1px solid #e9edf5;
        border-radius: 17px;
        overflow: hidden;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .035);
    }

    .stock-transaction-page .st-card-header {
        padding: 23px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        border-bottom: 1px solid #edf0f5;
    }

    .stock-transaction-page .st-card-header h5 {
        font-size: 1.05rem;
        color: #172033;
    }

    .stock-transaction-page .st-required-badge {
        white-space: nowrap;
        padding: 7px 10px;
        border-radius: 8px;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }

    .stock-transaction-page .st-card-body {
        padding: 26px;
    }

    .stock-transaction-page .st-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 19px;
        color: #1e293b;
        font-size: 14px;
        font-weight: 750;
    }

    .stock-transaction-page .st-section-icon {
        width: 31px;
        height: 31px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        color: #4f46e5;
        background: #eef2ff;
        font-size: 15px;
    }

    .stock-transaction-page .st-label {
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .stock-transaction-page .st-input,
    .stock-transaction-page .st-input-group .input-group-text {
        min-height: 45px;
        border-color: #e2e8f0;
        border-radius: 10px;
        font-size: 13px;
    }

    .stock-transaction-page .st-input {
        color: #1e293b;
        background-color: #fff;
    }

    .stock-transaction-page .st-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, .10);
    }

    .stock-transaction-page textarea.st-input {
        min-height: 110px;
        resize: vertical;
        padding-top: 12px;
    }

    .stock-transaction-page .st-input-group .input-group-text {
        display: flex;
        align-items: center;
        padding: 0 13px;
        color: #64748b;
        background: #f8fafc;
        border-right: 0;
        border-radius: 10px 0 0 10px;
    }

    .stock-transaction-page .st-input-group .st-input {
        border-radius: 0 10px 10px 0;
    }

    .stock-transaction-page .st-selected-product {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 15px;
        border: 1px solid #e0e7ff;
        background: #f8faff;
        border-radius: 12px;
    }

    .stock-transaction-page .st-product-symbol {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        color: #4f46e5;
        background: #e0e7ff;
        font-size: 19px;
    }

    .stock-transaction-page .st-mini-label {
        display: block;
        margin-bottom: 4px;
        color: #64748b;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .55px;
    }

    .stock-transaction-page .st-type-option {
        position: relative;
        display: block;
        cursor: pointer;
    }

    .stock-transaction-page .st-type-radio {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .stock-transaction-page .st-type-card {
        position: relative;
        display: flex;
        min-height: 153px;
        flex-direction: column;
        align-items: flex-start;
        padding: 17px;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        background: #fff;
        transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
    }

    .stock-transaction-page .st-type-card:hover {
        border-color: #c7d2fe;
        background: #fafaff;
    }

    .stock-transaction-page .st-type-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        margin-bottom: 13px;
        border-radius: 11px;
        font-size: 18px;
    }

    .stock-transaction-page .st-type-in .st-type-icon {
        color: #059669;
        background: #d1fae5;
    }

    .stock-transaction-page .st-type-out .st-type-icon {
        color: #dc2626;
        background: #fee2e2;
    }

    .stock-transaction-page .st-type-adjust .st-type-icon {
        color: #7c3aed;
        background: #ede9fe;
    }

    .stock-transaction-page .st-type-name {
        margin-bottom: 4px;
        color: #1e293b;
        font-size: 13px;
        font-weight: 750;
    }

    .stock-transaction-page .st-type-description {
        color: #64748b;
        font-size: 11px;
    }

    .stock-transaction-page .st-type-check {
        position: absolute;
        top: 12px;
        right: 12px;
        display: none;
        font-size: 16px;
    }

    .stock-transaction-page .st-type-radio:checked + .st-type-in {
        border-color: #10b981;
        background: #f0fdf8;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, .08);
    }

    .stock-transaction-page .st-type-radio:checked + .st-type-out {
        border-color: #ef4444;
        background: #fff7f7;
        box-shadow: 0 0 0 2px rgba(239, 68, 68, .07);
    }

    .stock-transaction-page .st-type-radio:checked + .st-type-adjust {
        border-color: #8b5cf6;
        background: #faf7ff;
        box-shadow: 0 0 0 2px rgba(139, 92, 246, .07);
    }

    .stock-transaction-page .st-type-radio:checked + .st-type-card .st-type-check {
        display: block;
    }

    .stock-transaction-page .st-type-radio:focus-visible + .st-type-card {
        outline: 3px solid rgba(99, 102, 241, .25);
        outline-offset: 3px;
    }

    .stock-transaction-page .st-stock-calculation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 14px;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        background: #f8fafc;
    }

    .stock-transaction-page .st-change-badge {
        padding: 6px 9px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 750;
        background: #e2e8f0;
        color: #475569;
    }

    .stock-transaction-page .st-form-footer {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        padding-top: 22px;
        margin-top: 10px;
        border-top: 1px solid #edf0f5;
    }

    .stock-transaction-page .st-footer-note {
        color: #64748b;
        font-size: 11px;
    }

    .stock-transaction-page .st-btn-cancel {
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #475569;
    }

    .stock-transaction-page .st-btn-cancel:hover {
        background: #f8fafc;
    }

    .stock-transaction-page .st-btn-submit {
        min-height: 43px;
        padding: 10px 18px;
        border: 0;
        border-radius: 10px;
        color: #fff;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 5px 12px rgba(79, 70, 229, .17);
        transition: .2s ease;
    }

    .stock-transaction-page .st-btn-submit:hover {
        background: linear-gradient(135deg, #4338ca, #4f46e5);
        transform: translateY(-1px);
    }

    .stock-transaction-page .st-btn-submit:disabled {
        opacity: .7;
        cursor: wait;
        transform: none;
    }

    .stock-transaction-page .st-error-alert {
        padding: 18px 20px;
        border-radius: 13px;
        color: #991b1b;
        background: #fef2f2;
    }

    .stock-transaction-page .st-header-secondary-icon {
        color: #6366f1;
        font-size: 22px;
    }

    .stock-transaction-page .st-guide-list {
        padding: 5px 23px 20px;
    }

    .stock-transaction-page .st-guide-item {
        display: flex;
        gap: 13px;
        padding: 17px 0;
        border-bottom: 1px solid #edf0f5;
    }

    .stock-transaction-page .st-guide-item:last-child {
        border-bottom: 0;
        padding-bottom: 4px;
    }

    .stock-transaction-page .st-guide-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        border-radius: 11px;
        font-size: 16px;
    }

    .stock-transaction-page .st-guide-in {
        color: #059669;
        background: #d1fae5;
    }

    .stock-transaction-page .st-guide-out {
        color: #dc2626;
        background: #fee2e2;
    }

    .stock-transaction-page .st-guide-adjust {
        color: #7c3aed;
        background: #ede9fe;
    }

    .stock-transaction-page .st-guide-item h6 {
        font-size: 12px;
    }

    .stock-transaction-page .st-guide-item p {
        line-height: 1.6;
    }

    .stock-transaction-page .st-safety-card {
        padding: 23px;
        border: 1px solid #e9edf5;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 5px 22px rgba(15, 23, 42, .035);
    }

    .stock-transaction-page .st-safety-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 43px;
        margin-bottom: 15px;
        border-radius: 12px;
        color: #4f46e5;
        background: #eef2ff;
        font-size: 20px;
    }

    .stock-transaction-page .st-safety-card h6 {
        font-size: 14px;
    }

    .stock-transaction-page .st-safety-card p {
        line-height: 1.75;
    }

    .stock-transaction-page .st-safety-divider {
        height: 1px;
        margin: 17px 0;
        background: #edf0f5;
    }

    .stock-transaction-page .st-summary-card {
        padding: 22px;
        border: 1px solid #e0e7ff;
        border-radius: 16px;
        background: linear-gradient(145deg, #fff, #f8faff);
        box-shadow: 0 5px 22px rgba(15, 23, 42, .035);
    }

    .stock-transaction-page .st-summary-card > div:first-child {
        color: #1e293b;
        font-size: 14px;
    }

    .stock-transaction-page .st-summary-card > div:first-child i {
        color: #6366f1;
        font-size: 19px;
    }

    .stock-transaction-page .st-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #e9edf5;
        font-size: 11px;
    }

    .stock-transaction-page .st-summary-row span {
        color: #64748b;
    }

    .stock-transaction-page .st-summary-row strong {
        max-width: 58%;
        color: #334155;
        text-align: right;
        overflow-wrap: anywhere;
    }

    .stock-transaction-page .st-summary-total {
        margin-top: 4px;
        padding: 14px 12px;
        border: 1px solid #e0e7ff;
        border-radius: 10px;
        background: #eef2ff;
    }

    .stock-transaction-page .st-summary-total strong {
        color: #4338ca;
        font-size: 15px;
    }

    @media (max-width: 767px) {
        .stock-transaction-page .st-card-header,
        .stock-transaction-page .st-card-body {
            padding: 18px;
        }

        .stock-transaction-page .st-required-badge {
            white-space: normal;
        }

        .stock-transaction-page .st-form-footer {
            align-items: stretch;
        }

        .stock-transaction-page .st-form-footer > div:last-child {
            width: 100%;
        }

        .stock-transaction-page .st-form-footer .btn {
            flex: 1;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const quantityLabel = document.getElementById('quantityLabel');
    const quantityHelp = document.getElementById('quantityHelp');
    const productInfo = document.getElementById('selectedProductInfo');
    const productCode = document.getElementById('selectedProductCode');
    const productStock = document.getElementById('selectedProductStock');
    const stockCalculation = document.getElementById('stockCalculation');
    const estimatedStock = document.getElementById('estimatedStock');
    const stockChangeBadge = document.getElementById('stockChangeBadge');
    const stockWarning = document.getElementById('stockWarning');

    const summaryProduct = document.getElementById('summaryProduct');
    const summaryType = document.getElementById('summaryType');
    const summaryQuantity = document.getElementById('summaryQuantity');
    const summaryCurrentStock = document.getElementById('summaryCurrentStock');
    const summaryNewStock = document.getElementById('summaryNewStock');

    function getTransactionType() {
        const selected = document.querySelector('input[name="type"]:checked');
        return selected ? selected.value : '';
    }

    function getSelectedProduct() {
        const option = productSelect.options[productSelect.selectedIndex];

        if (!option || !option.value) {
            return null;
        }

        return {
            id: option.value,
            name: option.textContent.trim(),
            code: option.dataset.code || '',
            stock: Number(option.dataset.stock || 0)
        };
    }

    function getTypeLabel(type) {
        const labels = {
            stock_in: 'Stock In',
            stock_out: 'Stock Out',
            adjustment: 'Adjustment'
        };

        return labels[type] || 'Not selected';
    }

    function updateQuantityHelp(type) {
        if (type === 'stock_in') {
            quantityLabel.textContent = 'Quantity to Add';
            quantityHelp.textContent = 'This quantity will be added to current stock.';
        } else if (type === 'stock_out') {
            quantityLabel.textContent = 'Quantity to Remove';
            quantityHelp.textContent = 'This quantity will be deducted from current stock.';
        } else if (type === 'adjustment') {
            quantityLabel.textContent = 'New Total Stock';
            quantityHelp.textContent = 'Enter the final physical stock quantity, not the difference.';
        } else {
            quantityLabel.textContent = 'Quantity';
            quantityHelp.textContent = 'Select a transaction type to see quantity guidance.';
        }
    }

    function updateSummary() {
        const product = getSelectedProduct();
        const type = getTransactionType();
        const quantity = Number(quantityInput.value || 0);

        updateQuantityHelp(type);

        if (!product) {
            productInfo.style.display = 'none';
            stockCalculation.style.display = 'none';

            summaryProduct.textContent = 'Not selected';
            summaryType.textContent = getTypeLabel(type);
            summaryQuantity.textContent = quantity;
            summaryCurrentStock.textContent = '—';
            summaryNewStock.textContent = '—';

            stockWarning.style.display = 'none';
            return;
        }

        productInfo.style.display = 'flex';
        productCode.textContent = product.code || product.name;
        productStock.textContent = product.stock;

        summaryProduct.textContent = product.code || product.name;
        summaryType.textContent = getTypeLabel(type);
        summaryQuantity.textContent = quantity;
        summaryCurrentStock.textContent = product.stock;

        if (!type || quantity < 1 || !Number.isFinite(quantity)) {
            stockCalculation.style.display = 'none';
            summaryNewStock.textContent = '—';
            stockWarning.style.display = 'none';
            return;
        }

        let newStock = product.stock;
        let change = 0;

        if (type === 'stock_in') {
            newStock = product.stock + quantity;
            change = quantity;
        } else if (type === 'stock_out') {
            newStock = product.stock - quantity;
            change = -quantity;
        } else if (type === 'adjustment') {
            newStock = quantity;
            change = newStock - product.stock;
        }

        stockCalculation.style.display = 'flex';
        estimatedStock.textContent = newStock;
        summaryNewStock.textContent = newStock;

        if (change > 0) {
            stockChangeBadge.textContent = '+' + change;
            stockChangeBadge.style.color = '#047857';
            stockChangeBadge.style.background = '#d1fae5';
        } else if (change < 0) {
            stockChangeBadge.textContent = String(change);
            stockChangeBadge.style.color = '#b91c1c';
            stockChangeBadge.style.background = '#fee2e2';
        } else {
            stockChangeBadge.textContent = 'No change';
            stockChangeBadge.style.color = '#475569';
            stockChangeBadge.style.background = '#e2e8f0';
        }

        const invalidStockOut = type === 'stock_out' && quantity > product.stock;
        const invalidNewStock = newStock < 0;

        stockWarning.style.display = (invalidStockOut || invalidNewStock) ? 'block' : 'none';

        if (invalidStockOut || invalidNewStock) {
            stockWarning.textContent = 'Stock out quantity cannot exceed available stock.';
        }
    }

    productSelect.addEventListener('change', updateSummary);
    quantityInput.addEventListener('input', updateSummary);

    document.querySelectorAll('input[name="type"]').forEach(function (radio) {
        radio.addEventListener('change', updateSummary);
    });

    updateSummary();
});
</script>

@endsection
