@extends('layouts.app')

@section('title', 'Invoice ' . $sale->invoice_number)

@section('content')

<div class="container-fluid py-4 invoice-page">


{{-- Page Header --}}
<div class="invoice-page-header d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 d-print-none">

    <div class="d-flex align-items-center gap-3">

        <div class="invoice-header-icon">
            <i class="bi bi-receipt-cutoff"></i>
        </div>

        <div>
            <h2 class="fw-bold mb-1">Invoice Details</h2>
            <p class="text-muted mb-0">
                Manage, print and download your sales invoice.
            </p>
        </div>

    </div>

    <div class="d-flex flex-wrap gap-2">

        <button onclick="window.print()" class="btn btn-light border invoice-action-btn">
            <i class="bi bi-printer me-2"></i>Print Invoice
        </button>

        <a href="{{ route('invoices.pdf', $sale) }}" class="btn btn-primary invoice-action-btn">
            <i class="bi bi-file-earmark-pdf me-2"></i>Download PDF
        </a>

        <a href="{{ route('sales.index') }}" class="btn btn-light border invoice-action-btn">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>

    </div>

</div>


{{-- Invoice Card --}}
<div class="card invoice-card border-0">

    <div class="card-body p-4 p-lg-5">

        {{-- Invoice Top Section --}}
        <div class="row align-items-start pb-4 mb-4 invoice-top-section">

            <div class="col-md-7">

                <div class="company-brand mb-3">

                    <div class="company-brand-icon">
                        <i class="bi bi-buildings"></i>
                    </div>

                    <div>
                        <h2 class="company-name mb-1">
                            {{ $settings->company_name ?: 'ERP Pro' }}
                        </h2>

                        <span class="company-tagline">
                            Business Management System
                        </span>
                    </div>

                </div>

                <div class="company-details">

                    @if($settings->company_address)
                        <div class="company-detail-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>{{ $settings->company_address }}</span>
                        </div>
                    @endif

                    @if($settings->company_phone)
                        <div class="company-detail-item">
                            <i class="bi bi-telephone"></i>
                            <span>{{ $settings->company_phone }}</span>
                        </div>
                    @endif

                    @if($settings->company_email)
                        <div class="company-detail-item">
                            <i class="bi bi-envelope"></i>
                            <span>{{ $settings->company_email }}</span>
                        </div>
                    @endif

                </div>

            </div>


            <div class="col-md-5 text-md-end mt-4 mt-md-0">

                <div class="invoice-title-label">SALES INVOICE</div>

                <h3 class="invoice-number-heading mb-3">
                    {{ $sale->invoice_number }}
                </h3>

                <div class="invoice-meta-item">
                    <span>Invoice Date</span>
                    <strong>
                        {{ $sale->sale_date->format('d M Y') }}
                    </strong>
                </div>

                <div class="invoice-meta-item">
                    <span>Payment Status</span>

                    @if($sale->status === 'completed')
                        <span class="invoice-status status-completed">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            Completed
                        </span>
                    @else
                        <span class="invoice-status status-other">
                            {{ ucfirst($sale->status) }}
                        </span>
                    @endif
                </div>

            </div>

        </div>


        {{-- Customer Information --}}
        <div class="row g-4 mb-5">

            <div class="col-md-7">

                <div class="invoice-info-box">

                    <div class="invoice-section-heading">
                        <i class="bi bi-person-vcard me-2"></i>
                        BILL TO
                    </div>

                    <h5 class="customer-name">
                        {{ $sale->customer->name ?? 'Walk-in Customer' }}
                    </h5>

                    <div class="customer-details">

                        @if($sale->customer && $sale->customer->email)
                            <div>
                                <i class="bi bi-envelope me-2"></i>
                                {{ $sale->customer->email }}
                            </div>
                        @endif

                        @if($sale->customer && $sale->customer->phone)
                            <div>
                                <i class="bi bi-telephone me-2"></i>
                                {{ $sale->customer->phone }}
                            </div>
                        @endif

                        @if($sale->customer && $sale->customer->address)
                            <div>
                                <i class="bi bi-geo-alt me-2"></i>
                                {{ $sale->customer->address }}
                            </div>
                        @endif

                    </div>

                </div>

            </div>


            <div class="col-md-5">

                <div class="invoice-reference-box">

                    <div class="invoice-section-heading">
                        <i class="bi bi-shield-check me-2"></i>
                        INVOICE SUMMARY
                    </div>

                    <div class="reference-row">
                        <span>Invoice Number</span>
                        <strong>{{ $sale->invoice_number }}</strong>
                    </div>

                    <div class="reference-row">
                        <span>Items</span>
                        <strong>{{ $sale->items->count() }}</strong>
                    </div>

                    <div class="reference-row">
                        <span>Total Quantity</span>
                        <strong>{{ $sale->items->sum('quantity') }}</strong>
                    </div>

                </div>

            </div>

        </div>


        {{-- Products Table --}}
        <div class="invoice-section-heading products-heading mb-3">
            <i class="bi bi-box-seam me-2"></i>
            ORDER DETAILS
        </div>

        <div class="table-responsive invoice-table-wrapper">

            <table class="table invoice-table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="item-number-column">#</th>
                        <th>Product Description</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-end">Unit Price</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($sale->items as $index => $item)

                        <tr>

                            <td class="item-number">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </td>

                            <td>
                                <div class="product-name">
                                    {{ $item->product->name ?? 'Product unavailable' }}
                                </div>

                                @if($item->product && $item->product->product_code)
                                    <small class="product-code">
                                        SKU: {{ $item->product->product_code }}
                                    </small>
                                @endif
                            </td>

                            <td class="text-center">
                                <span class="quantity-badge">
                                    {{ $item->quantity }}
                                </span>
                            </td>

                            <td class="text-end text-nowrap">
                                {{ $settings->currency }}
                                {{ number_format($item->price, 2) }}
                            </td>

                            <td class="text-end text-nowrap product-total">
                                {{ $settings->currency }}
                                {{ number_format($item->total, 2) }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                No products found for this invoice.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Totals Section --}}
        <div class="row justify-content-end mt-4">

            <div class="col-md-6 col-lg-5">

                <div class="invoice-totals-box">

                    <div class="total-row">
                        <span>Subtotal</span>
                        <strong>
                            {{ $settings->currency }}
                            {{ number_format($sale->subtotal, 2) }}
                        </strong>
                    </div>

                    <div class="total-row discount-row">
                        <span>
                            <i class="bi bi-tag me-1"></i>
                            Discount
                        </span>

                        <strong>
                            - {{ $settings->currency }}
                            {{ number_format($sale->discount, 2) }}
                        </strong>
                    </div>

                    <div class="total-divider"></div>

                    <div class="grand-total-row">

                        <div>
                            <span class="grand-total-label">Grand Total</span>
                            <small class="d-block text-muted">Total amount due</small>
                        </div>

                        <div class="grand-total-amount">
                            <span class="currency-label">{{ $settings->currency }}</span>
                            {{ number_format($sale->grand_total, 2) }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Invoice Footer --}}
        <div class="invoice-footer mt-5 pt-4">

            <div class="row align-items-center g-3">

                <div class="col-md-8">

                    <div class="footer-thank-you">
                        <i class="bi bi-heart me-2"></i>
                        Thank you for your business!
                    </div>

                    <p class="text-muted mb-0 mt-2">
                        {{ $settings->invoice_footer ?: 'We appreciate your trust and look forward to serving you again.' }}
                    </p>

                </div>

                <div class="col-md-4 text-md-end">
                    <div class="footer-brand">ERP PRO</div>
                    <small class="text-muted">Business Management System</small>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="text-center mt-3 text-muted small d-print-none">
    <i class="bi bi-lock me-1"></i>
    Invoice generated by ERP-Pro
</div>


</div>

<style>
/* =====================================
   INVOICE PAGE — ERP PRO
===================================== */

.invoice-page {
    color: #1e293b;
}

.invoice-page-header h2 {
    font-size: 1.55rem;
    color: #0f172a;
}

.invoice-header-icon {
    width: 54px;
    height: 54px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
    background: #eef2ff;
    color: #4f46e5;
    font-size: 1.6rem;
    flex-shrink: 0;
}

.invoice-action-btn {
    min-height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 9px;
    font-weight: 600;
    font-size: 0.88rem;
    padding: 10px 15px;
    transition: all 0.2s ease;
}

.invoice-action-btn:hover {
    transform: translateY(-1px);
}

.invoice-action-btn.btn-primary {
    background: #4f46e5;
    border-color: #4f46e5;
}

.invoice-action-btn.btn-primary:hover {
    background: #4338ca;
    border-color: #4338ca;
}

.invoice-card {
    max-width: 1150px;
    margin: 0 auto;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 12px 40px rgba(15, 23, 42, 0.07);
    overflow: hidden;
}

.invoice-top-section {
    border-bottom: 1px solid #e9edf5;
}

.company-brand {
    display: flex;
    align-items: center;
    gap: 14px;
}

.company-brand-icon {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    background: #eef2ff;
    color: #4f46e5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    flex-shrink: 0;
}

.company-name {
    font-size: 1.7rem;
    font-weight: 800;
    letter-spacing: -0.6px;
    color: #0f172a;
    overflow-wrap: anywhere;
}

.company-tagline {
    font-size: 0.78rem;
    color: #64748b;
    letter-spacing: 0.4px;
}

.company-details {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: 18px;
}

.company-detail-item {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    color: #64748b;
    font-size: 0.88rem;
    overflow-wrap: anywhere;
}

.company-detail-item i {
    color: #64748b;
    margin-top: 2px;
}

.invoice-title-label {
    display: inline-block;
    padding: 7px 13px;
    background: #eef2ff;
    color: #4f46e5;
    border-radius: 6px;
    font-size: 0.73rem;
    font-weight: 800;
    letter-spacing: 1.5px;
    margin-bottom: 12px;
}

.invoice-number-heading {
    font-weight: 800;
    color: #0f172a;
    font-size: 1.35rem;
    overflow-wrap: anywhere;
}

.invoice-meta-item {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
    margin-top: 12px;
    font-size: 0.88rem;
}

.invoice-meta-item > span:first-child {
    color: #64748b;
}

.invoice-meta-item strong {
    color: #1e293b;
}

.invoice-status {
    display: inline-flex;
    align-items: center;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.76rem;
    font-weight: 700;
}

.status-completed {
    color: #15803d;
    background: #dcfce7;
}

.status-other {
    color: #b91c1c;
    background: #fee2e2;
}

.invoice-info-box,
.invoice-reference-box {
    height: 100%;
    padding: 22px;
    border-radius: 12px;
    border: 1px solid #e8edf5;
    background: #f8fafc;
}

.invoice-section-heading {
    color: #64748b;
    font-size: 0.76rem;
    font-weight: 800;
    letter-spacing: 1px;
    margin-bottom: 16px;
}

.invoice-section-heading i {
    color: #4f46e5;
}

.customer-name {
    color: #0f172a;
    font-weight: 750;
    margin-bottom: 12px;
    overflow-wrap: anywhere;
}

.customer-details {
    display: flex;
    flex-direction: column;
    gap: 8px;
    color: #64748b;
    font-size: 0.88rem;
}

.customer-details > div {
    overflow-wrap: anywhere;
}

.customer-details i {
    color: #94a3b8;
}

.invoice-reference-box {
    background: #ffffff;
}

.invoice-reference-box .invoice-section-heading {
    margin-bottom: 10px;
}

.reference-row {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #edf0f5;
    font-size: 0.85rem;
}

.reference-row:last-child {
    border-bottom: 0;
}

.reference-row span {
    color: #64748b;
}

.reference-row strong {
    color: #1e293b;
    text-align: right;
    overflow-wrap: anywhere;
}

.products-heading {
    margin-top: 4px;
    margin-bottom: 15px;
}

.invoice-table-wrapper {
    border: 1px solid #e8edf5;
    border-radius: 12px;
    overflow: hidden;
}

.invoice-table {
    min-width: 650px;
}

.invoice-table thead th {
    padding: 16px 18px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    color: #64748b;
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.7px;
    text-transform: uppercase;
    white-space: nowrap;
}

.invoice-table tbody td {
    padding: 18px;
    border-bottom: 1px solid #edf0f5;
    color: #475569;
    font-size: 0.88rem;
}

.invoice-table tbody tr:last-child td {
    border-bottom: 0;
}

.invoice-table tbody tr:hover {
    background: #fafbff;
}

.item-number {
    color: #94a3b8 !important;
    font-weight: 700;
}

.product-name {
    color: #1e293b;
    font-weight: 700;
}

.product-code {
    display: inline-block;
    color: #94a3b8;
    margin-top: 5px;
    font-size: 0.75rem;
}

.quantity-badge {
    display: inline-block;
    min-width: 35px;
    padding: 5px 9px;
    border-radius: 7px;
    background: #f1f5f9;
    color: #334155;
    font-weight: 700;
}

.product-total {
    color: #0f172a !important;
    font-weight: 750;
}

.invoice-totals-box {
    padding: 22px;
    background: #f8fafc;
    border: 1px solid #e8edf5;
    border-radius: 12px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 16px;
    color: #64748b;
    font-size: 0.9rem;
}

.total-row strong {
    color: #1e293b;
    text-align: right;
    white-space: nowrap;
}

.discount-row strong,
.discount-row span {
    color: #15803d;
}

.total-divider {
    border-top: 1px dashed #cbd5e1;
    margin: 20px 0;
}

.grand-total-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.grand-total-label {
    color: #0f172a;
    font-size: 1.05rem;
    font-weight: 800;
}

.grand-total-amount {
    color: #4f46e5;
    font-size: 1.4rem;
    font-weight: 850;
    text-align: right;
    overflow-wrap: anywhere;
}

.currency-label {
    font-size: 0.8rem;
    font-weight: 700;
    color: #64748b;
}

.invoice-footer {
    border-top: 1px solid #e8edf5;
}

.footer-thank-you {
    color: #0f172a;
    font-size: 1rem;
    font-weight: 750;
}

.footer-thank-you i {
    color: #4f46e5;
}

.footer-brand {
    color: #4f46e5;
    font-size: 1.15rem;
    font-weight: 900;
    letter-spacing: 2px;
}


/* =====================================
   RESPONSIVE DESIGN
===================================== */

@media (max-width: 767.98px) {

    .invoice-page {
        padding-top: 18px !important;
    }

    .invoice-page-header {
        align-items: flex-start !important;
    }

    .invoice-page-header h2 {
        font-size: 1.3rem;
    }

    .invoice-page-header > .d-flex:last-child {
        width: 100%;
    }

    .invoice-action-btn {
        flex: 1 1 auto;
        padding: 9px 11px;
        font-size: 0.8rem;
    }

    .invoice-card {
        border-radius: 12px;
    }

    .invoice-card > .card-body {
        padding: 22px !important;
    }

    .company-name {
        font-size: 1.4rem;
    }

    .invoice-meta-item {
        justify-content: space-between;
    }

    .invoice-info-box,
    .invoice-reference-box {
        padding: 18px;
    }

    .invoice-totals-box {
        padding: 18px;
    }

    .grand-total-amount {
        font-size: 1.15rem;
    }

}


/* =====================================
   PRINT-FRIENDLY INVOICE
===================================== */

@media print {

    @page {
        size: A4;
        margin: 12mm;
    }

    html,
    body {
        background: #ffffff !important;
        color: #111827 !important;
        font-size: 10pt !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .sidebar,
    .navbar,
    footer,
    .btn,
    .d-print-none,
    .invoice-page-header,
    .text-center.mt-3.text-muted.small {
        display: none !important;
    }

    .main-content,
    main,
    .content-wrapper {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .container-fluid,
    .invoice-page {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .invoice-card {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        border: 0 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        overflow: visible !important;
    }

    .invoice-card > .card-body {
        padding: 0 !important;
    }

    .invoice-top-section {
        margin-bottom: 20px !important;
        padding-bottom: 20px !important;
    }

    .company-name {
        font-size: 18pt !important;
    }

    .invoice-title-label {
        font-size: 8pt !important;
    }

    .invoice-number-heading {
        font-size: 13pt !important;
    }

    .invoice-info-box,
    .invoice-reference-box,
    .invoice-totals-box {
        background: #f8fafc !important;
        break-inside: avoid;
    }

    .invoice-info-box,
    .invoice-reference-box {
        padding: 14px !important;
    }

    .invoice-table-wrapper {
        overflow: visible !important;
        border-radius: 0 !important;
    }

    .invoice-table {
        width: 100% !important;
        min-width: 0 !important;
        border-collapse: collapse !important;
    }

    .invoice-table thead {
        display: table-header-group;
    }

    .invoice-table thead th {
        padding: 10px 8px !important;
        background: #f1f5f9 !important;
        color: #334155 !important;
        font-size: 8pt !important;
    }

    .invoice-table tbody td {
        padding: 10px 8px !important;
        font-size: 9pt !important;
    }

    .invoice-table tr {
        break-inside: avoid;
    }

    .invoice-totals-box {
        padding: 16px !important;
    }

    .invoice-footer {
        break-inside: avoid;
    }

    .grand-total-amount {
        font-size: 13pt !important;
    }

    a {
        color: inherit !important;
        text-decoration: none !important;
    }

}
</style>

@endsection
