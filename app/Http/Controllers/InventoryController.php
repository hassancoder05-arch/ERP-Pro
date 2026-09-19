<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InventoryController extends Controller
{
    /**
     * Inventory dashboard.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('product_code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalProducts = Product::count();

        $lowStockProducts = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        $outOfStockProducts = Product::where('stock', 0)->count();

        $totalUnits = Product::sum('stock');

        return view('inventory.index', compact(
            'products',
            'search',
            'totalProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'totalUnits'
        ));
    }

    /**
     * Show stock transaction form.
     */
    public function create()
    {
        $products = Product::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('inventory.create', compact('products'));
    }

    /**
     * Store inventory transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'exists:products,id',
            ],

            'type' => [
                'required',
                Rule::in([
                    'stock_in',
                    'stock_out',
                    'adjustment',
                ]),
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
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

        DB::transaction(function () use ($validated) {

            $product = Product::lockForUpdate()
                ->findOrFail($validated['product_id']);

            $stockBefore = $product->stock;

            /*
             * STOCK IN
             */
            if ($validated['type'] === 'stock_in') {

                $stockAfter = $stockBefore + $validated['quantity'];
            }

            /*
             * STOCK OUT
             */
            elseif ($validated['type'] === 'stock_out') {

                if ($validated['quantity'] > $stockBefore) {
                    abort(
                        422,
                        'Stock out quantity cannot be greater than current stock.'
                    );
                }

                $stockAfter = $stockBefore - $validated['quantity'];
            }

            /*
             * ADJUSTMENT
             *
             * Here quantity becomes the NEW stock quantity.
             */
            else {

                $stockAfter = $validated['quantity'];
            }

            $product->update([
                'stock' => $stockAfter,
            ]);

            InventoryTransaction::create([
                'product_id' => $product->id,
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'reference' => $validated['reference'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);
        });

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Inventory updated successfully.');
    }

    /**
     * Show inventory history.
     */
    public function history(Request $request)
    {
        $transactions = InventoryTransaction::with('product')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'inventory.history',
            compact('transactions')
        );
    }

    /**
     * Show product inventory details.
     */
    public function show(Product $product)
    {
        $transactions = $product
            ->inventoryTransactions()
            ->latest()
            ->paginate(15);

        return view(
            'inventory.show',
            compact('product', 'transactions')
        );
    }
}