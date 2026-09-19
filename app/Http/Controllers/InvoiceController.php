<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display invoice.
     */
    public function show(Sale $sale)
    {
        $sale->load([
            'customer',
            'items.product',
        ]);

        $settings = Setting::first();

        if (!$settings) {
            $settings = new Setting([
                'company_name' => 'ERP Pro',
                'company_email' => '',
                'company_phone' => '',
                'company_address' => '',
                'currency' => 'PKR',
                'invoice_prefix' => 'INV',
                'invoice_footer' => 'Thank you for your business!',
            ]);
        }

        return view('invoices.show', compact(
            'sale',
            'settings'
        ));
    }

    /**
     * Generate PDF invoice.
     */
    public function pdf(Sale $sale)
    {
        $sale->load([
            'customer',
            'items.product',
        ]);

        $settings = Setting::first();

        if (!$settings) {
            $settings = new Setting([
                'company_name' => 'ERP Pro',
                'company_email' => '',
                'company_phone' => '',
                'company_address' => '',
                'currency' => 'PKR',
                'invoice_prefix' => 'INV',
                'invoice_footer' => 'Thank you for your business!',
            ]);
        }

        $pdf = Pdf::loadView(
            'invoices.pdf',
            compact('sale', 'settings')
        );

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download(
            $sale->invoice_number . '.pdf'
        );
    }
}