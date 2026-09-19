<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>
        Invoice {{ $sale->invoice_number }}
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 0;
            padding: 30px;
        }

        .header {
            width: 100%;
            margin-bottom: 35px;
        }

        .company {
            width: 60%;
            float: left;
        }

        .invoice-info {
            width: 40%;
            float: right;
            text-align: right;
        }

        .clearfix {
            clear: both;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .invoice-title {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .muted {
            color: #666;
            line-height: 1.6;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #666;
            margin-bottom: 7px;
        }

        .customer {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .items th {
            background: #f2f2f2;
            border-top: 1px solid #222;
            border-bottom: 1px solid #222;
            padding: 10px 7px;
            text-align: left;
        }

        .items td {
            border-bottom: 1px solid #ddd;
            padding: 10px 7px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            width: 40%;
            margin-left: auto;
            margin-top: 25px;
        }

        .totals td {
            padding: 7px;
        }

        .grand-total {
            font-size: 15px;
            font-weight: bold;
            border-top: 2px solid #222;
        }

        .footer {
            margin-top: 60px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            text-align: center;
            color: #666;
        }

    </style>

</head>

<body>


    <div class="header">

        <div class="company">

            <div class="company-name">
                {{ $settings->company_name ?: 'ERP Pro' }}
            </div>

            @if($settings->company_address)
                <div class="muted">
                    {{ $settings->company_address }}
                </div>
            @endif

            @if($settings->company_phone)
                <div class="muted">
                    Phone: {{ $settings->company_phone }}
                </div>
            @endif

            @if($settings->company_email)
                <div class="muted">
                    Email: {{ $settings->company_email }}
                </div>
            @endif

        </div>


        <div class="invoice-info">

            <div class="invoice-title">
                INVOICE
            </div>

            <div>
                <strong>Invoice:</strong>
                {{ $sale->invoice_number }}
            </div>

            <div>
                <strong>Date:</strong>
                {{ $sale->sale_date->format('d M Y') }}
            </div>

            <div>
                <strong>Status:</strong>
                {{ ucfirst($sale->status) }}
            </div>

        </div>

        <div class="clearfix"></div>

    </div>


    <div class="customer">

        <div class="section-title">
            BILL TO
        </div>

        <strong>
            {{ $sale->customer->name }}
        </strong>

        @if($sale->customer->email)
            <div class="muted">
                {{ $sale->customer->email }}
            </div>
        @endif

        @if($sale->customer->phone)
            <div class="muted">
                {{ $sale->customer->phone }}
            </div>
        @endif

        @if($sale->customer->address)
            <div class="muted">
                {{ $sale->customer->address }}
            </div>
        @endif

    </div>


    <table class="items">

        <thead>

            <tr>

                <th style="width: 6%;">
                    #
                </th>

                <th>
                    Product
                </th>

                <th class="text-center">
                    Qty
                </th>

                <th class="text-right">
                    Price
                </th>

                <th class="text-right">
                    Total
                </th>

            </tr>

        </thead>


        <tbody>

            @foreach($sale->items as $index => $item)

                <tr>

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td>

                        {{ $item->product->name }}

                        @if($item->product->product_code)
                            <div class="muted">
                                SKU:
                                {{ $item->product->product_code }}
                            </div>
                        @endif

                    </td>

                    <td class="text-center">
                        {{ $item->quantity }}
                    </td>

                    <td class="text-right">
                        {{ $settings->currency }}
                        {{ number_format($item->price, 2) }}
                    </td>

                    <td class="text-right">
                        {{ $settings->currency }}
                        {{ number_format($item->total, 2) }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>


    <table class="totals">

        <tr>

            <td>
                Subtotal
            </td>

            <td class="text-right">
                {{ $settings->currency }}
                {{ number_format($sale->subtotal, 2) }}
            </td>

        </tr>

        <tr>

            <td>
                Discount
            </td>

            <td class="text-right">
                - {{ $settings->currency }}
                {{ number_format($sale->discount, 2) }}
            </td>

        </tr>

        <tr class="grand-total">

            <td>
                Grand Total
            </td>

            <td class="text-right">
                {{ $settings->currency }}
                {{ number_format($sale->grand_total, 2) }}
            </td>

        </tr>

    </table>


    <div class="footer">

        {{ $settings->invoice_footer ?: 'Thank you for your business!' }}

        <br>

        Generated by ERP Pro

    </div>


</body>

</html>