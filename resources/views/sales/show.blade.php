
@extends('layouts.app')

@section('title', 'Invoice ' . $sale->invoice_number)

@section('content')

<div class="container-fluid sales-invoice-page py-3 py-lg-4">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4 no-print">

        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="invoice-page-icon">
                    <i class="bi bi-receipt-cutoff"></i>
                </span>
                <span class="text-uppercase small fw-bold text-primary tracking-wide">
                    Sales Management
                </span>
            </div>

            <h2 class="fw-bold mb-1">Invoice Details</h2>

            <p class="text-muted mb-0">
                View, review and print your sales invoice.
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <button type="button" onclick="window.print()" class="btn btn-primary px-4">
                <i class="bi bi-printer me-2"></i>Print Invoice
            </button>

            <a href="{{ route('sales.index') }}" class="btn btn-light border px-4">
                <i class="bi bi-arrow-left me-2"></i>Back to Sales
            </a>
        </div>
    </div>


    {{-- Invoice Document --}}
    <div class="invoice-paper">

        {{-- Accent Line --}}
        <div class="invoice-accent"></div>

        <div class="invoice-content">

            {{-- Brand and Invoice Number --}}
            <div class="row align-items-start g-4 pb-4 invoice-top-section">

                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="brand-logo">
                            <i class="bi bi-grid-1x2-fill"></i>
                        </div>

                        <div>
                            <h3 class="fw-bold mb-0 brand-name">ERP PRO</h3>
                            <p class="text-muted small mb-0">Enterprise Resource Planning</p>
                        </div>
                    </div>

                    <div class="invoice-document-label">
                        SALES INVOICE
                    </div>

                    <p class="text-muted small mt-2 mb-0">
                        Official sales transaction record
                    </p>
                </div>

                <div class="col-md-6 text-md-end">

                    <div class="invoice-number-label">INVOICE NUMBER</div>

                    <h3 class="fw-bold invoice-number mt-1 mb-3">
                        {{ $sale->invoice_number }}
                    </h3>

                    <div class="d-flex flex-wrap justify-content-md-end align-items-center gap-2">

                        <span class="invoice-status
                            {{ $sale->status === 'completed' ? 'status-completed' : 'status-cancelled' }}">

                            <span class="status-dot"></span>

                            {{ ucfirst($sale->status) }}
                        </span>

                        <span class="invoice-date-badge">
                            <i class="bi bi-calendar3 me-2"></i>
                            {{ $sale->sale_date ? \Illuminate\Support\Carbon::parse($sale->sale_date)->format('d M Y') : 'N/A' }}
                        </span>

                    </div>
                </div>
            </div>


            {{-- Divider --}}
            <div class="invoice-divider"></div>


            {{-- Customer Information --}}
            <div class="row g-4 my-3">

                <div class="col-md-7">

                    <div class="section-label mb-3">
                        <i class="bi bi-person-lines-fill me-2"></i>
                        BILL TO
                    </div>

                    <div class="customer-card">

                        <div class="customer-avatar">
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <div class="customer-details">

                            <h5 class="fw-bold mb-2">
                                {{ $sale->customer->name ?? 'Walk-in Customer' }}
                            </h5>

                            @if($sale->customer && $sale->customer->phone)
                                <div class="customer-detail-line">
                                    <i class="bi bi-telephone"></i>
                                    <span>{{ $sale->customer->phone }}</span>
                                </div>
                            @endif

                            @if($sale->customer && $sale->customer->email)
                                <div class="customer-detail-line">
                                    <i class="bi bi-envelope"></i>
                                    <span>{{ $sale->customer->email }}</span>
                                </div>
                            @endif

                            @if($sale->customer && $sale->customer->address)
                                <div class="customer-detail-line">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>{{ $sale->customer->address }}</span>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>


                <div class="col-md-5">

                    <div class="section-label mb-3">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        INVOICE SUMMARY
                    </div>

                    <div class="summary-info-card">

                        <div class="summary-info-row">
                            <span>Invoice Reference</span>
                            <strong>{{ $sale->invoice_number }}</strong>
                        </div>

                        <div class="summary-info-row">
                            <span>Invoice Date</span>
                            <strong>
                                {{ $sale->sale_date ? \Illuminate\Support\Carbon::parse($sale->sale_date)->format('d M Y') : 'N/A' }}
                            </strong>
                        </div>

                        <div class="summary-info-row">
                            <span>Payment Status</span>

                            <strong class="{{ $sale->status === 'completed' ? 'text-success' : 'text-danger' }}">
                                {{ ucfirst($sale->status) }}
                            </strong>
                        </div>

                        <div class="summary-info-row">
                            <span>Items</span>
                            <strong>{{ $sale->items->count() }} product(s)</strong>
                        </div>

                    </div>
                </div>

            </div>


            {{-- Items Table --}}
            <div class="section-label mt-4 mb-3">
                <i class="bi bi-basket2 me-2"></i>
                INVOICE ITEMS
            </div>

            <div class="table-responsive invoice-table-wrapper">

                <table class="table invoice-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th class="item-number-column">#</th>
                            <th>PRODUCT DESCRIPTION</th>
                            <th>PRODUCT CODE</th>
                            <th class="text-center">QTY</th>
                            <th class="text-end">UNIT PRICE</th>
                            <th class="text-end">LINE TOTAL</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($sale->items as $item)

                            <tr>
                                <td class="text-muted">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </td>

                                <td>
                                    <div class="product-cell">
                                        <div class="product-mini-icon">
                                            <i class="bi bi-box-seam"></i>
                                        </div>

                                        <div>
                                            <div class="product-name">
                                                {{ $item->product->name ?? 'Deleted Product' }}
                                            </div>

                                            <div class="product-subtitle">
                                                Sales item
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="product-code">
                                        {{ $item->product->product_code ?? 'N/A' }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="quantity-badge">
                                        {{ $item->quantity }}
                                    </span>
                                </td>

                                <td class="text-end text-nowrap">
                                    Rs. {{ number_format((float) $item->price, 2) }}
                                </td>

                                <td class="text-end text-nowrap fw-bold">
                                    Rs. {{ number_format((float) $item->total, 2) }}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-inbox fs-2 d-block text-muted mb-2"></i>
                                    <span class="text-muted">No invoice items found.</span>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>


            {{-- Bottom Section --}}
            <div class="row g-4 mt-4">

                {{-- Note --}}
                <div class="col-lg-6">

                    <div class="invoice-note-card">
                        <div class="note-icon">
                            <i class="bi bi-info-circle"></i>
                        </div>

                        <div>
                            <h6 class="fw-bold mb-1">Thank you for your business!</h6>

                            <p class="text-muted small mb-0">
                                We appreciate your trust. Please keep this invoice
                                for your records and future reference.
                            </p>
                        </div>
                    </div>

                    <div class="invoice-security-note mt-3">
                        <i class="bi bi-shield-check me-2"></i>
                        Generated by ERP PRO Sales Management
                    </div>

                </div>


                {{-- Totals --}}
                <div class="col-lg-6">

                    <div class="totals-card">

                        <div class="totals-heading">
                            <i class="bi bi-calculator me-2"></i>
                            PAYMENT SUMMARY
                        </div>

                        <div class="totals-body">

                            <div class="total-row">
                                <span>Subtotal</span>

                                <span>
                                    Rs. {{ number_format((float) $sale->subtotal, 2) }}
                                </span>
                            </div>

                            <div class="total-row discount-row">
                                <span>
                                    <i class="bi bi-tag me-1"></i>
                                    Discount
                                </span>

                                <span>
                                    − Rs. {{ number_format((float) $sale->discount, 2) }}
                                </span>
                            </div>

                            <div class="totals-separator"></div>

                            <div class="grand-total-row">
                                <div>
                                    <div class="grand-total-label">Grand Total</div>
                                    <div class="grand-total-caption">Final invoice amount</div>
                                </div>

                                <div class="grand-total-amount">
                                    Rs. {{ number_format((float) $sale->grand_total, 2) }}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>


            {{-- Footer --}}
            <div class="invoice-footer">

                <div>
                    <span class="footer-brand">ERP PRO</span>
                    <span class="footer-separator">|</span>
                    <span class="text-muted">Sales Invoice</span>
                </div>

                <div class="text-muted">
                    Invoice: {{ $sale->invoice_number }}
                </div>

            </div>

        </div>
    </div>

</div>


<style>
.sales-invoice-page {
    --invoice-primary: #4f46e5;
    --invoice-primary-dark: #3730a3;
    --invoice-text: #172033;
    --invoice-muted: #718096;
    --invoice-border: #e8edf4;
    color: var(--invoice-text);
}

.sales-invoice-page .tracking-wide {
    letter-spacing: 1.2px;
}

.invoice-page-icon {
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    color: var(--invoice-primary);
    background: #eef2ff;
    font-size: 21px;
}

.sales-invoice-page .btn {
    min-height: 43px;
    border-radius: 10px;
    font-weight: 600;
    transition: all .2s ease;
}

.sales-invoice-page .btn-primary {
    background: var(--invoice-primary);
    border-color: var(--invoice-primary);
}

.sales-invoice-page .btn-primary:hover {
    background: var(--invoice-primary-dark);
    border-color: var(--invoice-primary-dark);
    transform: translateY(-1px);
}

.sales-invoice-page .btn-light {
    background: #fff;
}

.invoice-paper {
    max-width: 1200px;
    margin: 0 auto;
    background: #fff;
    border: 1px solid var(--invoice-border);
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(15, 23, 42, .06);
}

.invoice-accent {
    height: 6px;
    background: linear-gradient(90deg, #4f46e5, #818cf8, #c4b5fd);
}

.invoice-content {
    padding: 36px 42px;
}

.invoice-top-section {
    margin-bottom: 6px;
}

.brand-logo {
    width: 55px;
    height: 55px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
    color: #fff;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    box-shadow: 0 7px 18px rgba(79, 70, 229, .22);
    font-size: 25px;
}

.brand-name {
    letter-spacing: 1px;
}

.invoice-document-label {
    display: inline-block;
    padding: 8px 13px;
    border: 1px solid #e0e7ff;
    border-radius: 7px;
    background: #f5f7ff;
    color: #4338ca;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.7px;
}

.invoice-number-label,
.section-label {
    color: #64748b;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.3px;
}

.invoice-number {
    overflow-wrap: anywhere;
    color: #1e293b;
}

.invoice-status,
.invoice-date-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
}

.status-completed {
    background: #dcfce7;
    color: #166534;
}

.status-cancelled {
    background: #fee2e2;
    color: #991b1b;
}

.status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: currentColor;
}

.invoice-date-badge {
    background: #f1f5f9;
    color: #475569;
}

.invoice-divider {
    height: 1px;
    background: var(--invoice-border);
}

.section-label {
    display: flex;
    align-items: center;
}

.section-label i {
    color: var(--invoice-primary);
    font-size: 15px;
}

.customer-card {
    display: flex;
    gap: 16px;
    padding: 20px;
    height: 100%;
    border: 1px solid var(--invoice-border);
    border-radius: 13px;
    background: #fbfcff;
}

.customer-avatar {
    flex: 0 0 48px;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #e0e7ff;
    color: #4338ca;
    font-size: 24px;
}

.customer-details {
    min-width: 0;
}

.customer-details h5 {
    overflow-wrap: anywhere;
}

.customer-detail-line {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    margin-top: 9px;
    color: #64748b;
    font-size: 13px;
    overflow-wrap: anywhere;
}

.customer-detail-line i {
    margin-top: 2px;
    color: #818cf8;
}

.summary-info-card {
    padding: 8px 17px;
    height: 100%;
    border: 1px solid var(--invoice-border);
    border-radius: 13px;
    background: #fff;
}

.summary-info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px dashed #e8edf4;
    font-size: 12px;
}

.summary-info-row:last-child {
    border-bottom: 0;
}

.summary-info-row > span {
    color: var(--invoice-muted);
}

.summary-info-row strong {
    text-align: right;
    overflow-wrap: anywhere;
}

.invoice-table-wrapper {
    border: 1px solid var(--invoice-border);
    border-radius: 12px;
    overflow: hidden;
}

.invoice-table {
    min-width: 740px;
}

.invoice-table thead th {
    padding: 16px 14px;
    background: #f8fafc;
    color: #64748b;
    border-bottom: 1px solid var(--invoice-border);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .7px;
    white-space: nowrap;
}

.invoice-table tbody td {
    padding: 16px 14px;
    border-bottom: 1px solid #edf1f6;
    color: #334155;
    font-size: 13px;
}

.invoice-table tbody tr:last-child td {
    border-bottom: 0;
}

.invoice-table tbody tr:hover {
    background: #fafbff;
}

.item-number-column {
    width: 55px;
}

.product-cell {
    display: flex;
    align-items: center;
    gap: 11px;
    min-width: 180px;
}

.product-mini-icon {
    width: 38px;
    height: 38px;
    flex: 0 0 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #eef2ff;
    color: #4f46e5;
    font-size: 18px;
}

.product-name {
    color: #1e293b;
    font-weight: 700;
    overflow-wrap: anywhere;
}

.product-subtitle {
    margin-top: 3px;
    color: #94a3b8;
    font-size: 11px;
}

.product-code {
    display: inline-block;
    padding: 5px 8px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    white-space: nowrap;
}

.quantity-badge {
    display: inline-flex;
    min-width: 34px;
    min-height: 30px;
    justify-content: center;
    align-items: center;
    padding: 4px 8px;
    border-radius: 7px;
    background: #f1f5f9;
    color: #334155;
    font-weight: 700;
}

.invoice-note-card {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    padding: 18px;
    border: 1px solid #dbeafe;
    border-radius: 12px;
    background: #f8fbff;
}

.note-icon {
    flex: 0 0 36px;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #dbeafe;
    color: #2563eb;
    font-size: 18px;
}

.invoice-security-note {
    color: #94a3b8;
    font-size: 11px;
}

.totals-card {
    border: 1px solid var(--invoice-border);
    border-radius: 13px;
    overflow: hidden;
}

.totals-heading {
    padding: 15px 19px;
    background: #f8fafc;
    border-bottom: 1px solid var(--invoice-border);
    color: #475569;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1px;
}

.totals-body {
    padding: 20px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 17px;
    color: #64748b;
    font-size: 13px;
}

.total-row > span:last-child {
    color: #334155;
    font-weight: 700;
    text-align: right;
}

.discount-row > span:last-child {
    color: #dc2626;
}

.totals-separator {
    height: 1px;
    margin: 7px 0 19px;
    background: #e2e8f0;
}

.grand-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
}

.grand-total-label {
    color: #1e293b;
    font-size: 15px;
    font-weight: 800;
}

.grand-total-caption {
    margin-top: 4px;
    color: #94a3b8;
    font-size: 11px;
}

.grand-total-amount {
    color: #4338ca;
    font-size: clamp(17px, 2vw, 23px);
    font-weight: 800;
    text-align: right;
    overflow-wrap: anywhere;
}

.invoice-footer {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 38px;
    padding-top: 20px;
    border-top: 1px solid var(--invoice-border);
    font-size: 11px;
}

.footer-brand {
    color: #475569;
    font-weight: 800;
    letter-spacing: 1px;
}

.footer-separator {
    margin: 0 8px;
    color: #cbd5e1;
}


/* Responsive */
@media (max-width: 767.98px) {
    .invoice-content {
        padding: 24px 17px;
    }

    .invoice-number {
        font-size: 21px;
    }

    .customer-card {
        padding: 15px;
    }

    .grand-total-row {
        align-items: flex-start;
        flex-direction: column;
    }

    .grand-total-amount {
        text-align: left;
    }
}


/* Print */
@page {
    size: A4;
    margin: 12mm;
}

@media print {

    html,
    body {
        background: #fff !important;
        color: #111827 !important;
    }

    body * {
        visibility: hidden;
    }

    #invoice,
    #invoice * {
        visibility: visible;
    }

    .no-print,
    .sidebar,
    .navbar,
    footer,
    .btn,
    aside {
        display: none !important;
    }

    .sales-invoice-page {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .invoice-paper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        max-width: none;
        margin: 0;
        border: 0;
        border-radius: 0;
        box-shadow: none;
        overflow: visible;
    }

    .invoice-content {
        padding: 10px 0;
    }

    .invoice-accent {
        height: 4px;
        background: #4f46e5 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .invoice-table-wrapper {
        overflow: visible;
    }

    .invoice-table {
        min-width: 0;
        width: 100%;
        table-layout: auto;
    }

    .invoice-table thead {
        display: table-header-group;
    }

    .invoice-table tr {
        break-inside: avoid;
        page-break-inside: avoid;
    }

    .invoice-table thead th,
    .invoice-status,
    .invoice-date-badge,
    .brand-logo,
    .product-mini-icon,
    .quantity-badge,
    .invoice-note-card,
    .totals-heading,
    .invoice-document-label {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .invoice-footer {
        break-inside: avoid;
        page-break-inside: avoid;
    }

    a {
        color: inherit !important;
        text-decoration: none !important;
    }
}
</style>

@endsection

