<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();

        if (!$settings) {
            $settings = new Setting([
                'company_name' => '',
                'company_email' => '',
                'company_phone' => '',
                'company_address' => '',
                'currency' => 'PKR',
                'invoice_prefix' => 'INV',
                'invoice_footer' => 'Thank you for your business!',
            ]);
        }

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['nullable', 'string', 'max:150'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:30'],
            'company_address' => ['nullable', 'string', 'max:1000'],
            'currency' => ['required', 'string', 'max:10'],
            'invoice_prefix' => ['required', 'string', 'max:20'],
            'invoice_footer' => ['nullable', 'string', 'max:1000'],
        ]);

        Setting::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return redirect()
            ->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}