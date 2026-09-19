<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $payments = Payment::with([
                'customer',
                'supplier'
            ])
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('reference', 'like', "%{$search}%")
                        ->orWhere('payment_method', 'like', "%{$search}%")
                        ->orWhereHas('customer', function ($customer) use ($search) {
                            $customer->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('supplier', function ($supplier) use ($search) {
                            $supplier->where('name', 'like', "%{$search}%");
                        });

                });

            })
            ->latest('payment_date')
            ->paginate(10)
            ->withQueryString();

        return view(
            'payments.index',
            compact('payments', 'search')
        );
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')
            ->orderBy('name')
            ->get();

        $suppliers = Supplier::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view(
            'payments.create',
            compact('customers', 'suppliers')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => [
                'required',
                'in:customer,supplier',
            ],

            'customer_id' => [
                'nullable',
                'exists:customers,id',
                'required_if:type,customer',
            ],

            'supplier_id' => [
                'nullable',
                'exists:suppliers,id',
                'required_if:type,supplier',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'payment_date' => [
                'required',
                'date',
            ],

            'payment_method' => [
                'required',
                'in:cash,bank,other',
            ],

            'reference' => [
                'nullable',
                'string',
                'max:100',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        if ($validated['type'] === 'customer') {
            $validated['supplier_id'] = null;
        } else {
            $validated['customer_id'] = null;
        }

        Payment::create($validated);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }
}