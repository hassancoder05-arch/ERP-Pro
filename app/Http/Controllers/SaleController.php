<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    /**
     * Sales list.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $sales = Sale::with('customer')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {

                    $q->where(
                        'invoice_number',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas('customer', function ($customer) use ($search) {

                        $customer->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'sales.index',
            compact('sales', 'search')
        );
    }

    /**
     * Create sale.
     */
    public function create()
    {
        $customers = Customer::where('status', 'active')
            ->orderBy('name')
            ->get();

        $products = Product::where('status', 'active')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view(
            'sales.create',
            compact('customers', 'products')
        );
    }

    /**
     * Store sale.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => [
                'required',
                'exists:customers,id',
            ],

            'sale_date' => [
                'required',
                'date',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'products' => [
                'required',
                'array',
                'min:1',
            ],

            'products.*.id' => [
                'required',
                'exists:products,id',
            ],

            'products.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $sale = DB::transaction(function () use ($validated) {

            $subtotal = 0;

            $items = [];

            foreach ($validated['products'] as $item) {

                $product = Product::lockForUpdate()
                    ->findOrFail($item['id']);

                $quantity = (int) $item['quantity'];

                /*
                 * Stock check
                 */
                if ($quantity > $product->stock) {

                    abort(
                        422,
                        "Insufficient stock for {$product->name}. Available stock: {$product->stock}."
                    );
                }

                $price = (float) $product->selling_price;

                $total = $price * $quantity;

                $subtotal += $total;

                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $total,
                ];
            }

            $discount = (float) ($validated['discount'] ?? 0);

            if ($discount > $subtotal) {
                abort(
                    422,
                    'Discount cannot be greater than subtotal.'
                );
            }

            $grandTotal = $subtotal - $discount;

            /*
             * Generate invoice number
             */
            $invoiceNumber = $this->generateInvoiceNumber();

            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'customer_id' => $validated['customer_id'],
                'sale_date' => $validated['sale_date'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'grand_total' => $grandTotal,
                'status' => 'completed',
            ]);

            /*
             * Create sale items
             * + Deduct stock
             * + Create inventory history
             */
            foreach ($items as $item) {

                $product = $item['product'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'cost_price' => $product->purchase_price,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['total'],
                ]);

                $stockBefore = $product->stock;

                $stockAfter =
                    $stockBefore - $item['quantity'];

                $product->update([
                    'stock' => $stockAfter,
                ]);

                InventoryTransaction::create([
                    'product_id' => $product->id,
                    'type' => 'stock_out',
                    'quantity' => $item['quantity'],
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'reference' => $invoiceNumber,
                    'notes' => 'Stock deducted from sale.',
                ]);
            }

            return $sale;
        });

        return redirect()
            ->route('sales.show', $sale)
            ->with(
                'success',
                'Sale created successfully.'
            );
    }

    /**
     * Show invoice.
     */
    public function show(Sale $sale)
    {
        $sale->load([
            'customer',
            'items.product',
        ]);

        return view(
            'sales.show',
            compact('sale')
        );
    }

    /**
     * Cancel sale.
     *
     * Stock is restored.
     */
    public function destroy(Sale $sale)
    {
        if ($sale->status === 'cancelled') {

            return redirect()
                ->route('sales.index')
                ->with(
                    'error',
                    'This sale is already cancelled.'
                );
        }

        DB::transaction(function () use ($sale) {

            $sale->load('items.product');

            foreach ($sale->items as $item) {

                $product = Product::lockForUpdate()
                    ->findOrFail($item->product_id);

                $stockBefore = $product->stock;

                $stockAfter =
                    $stockBefore + $item->quantity;

                $product->update([
                    'stock' => $stockAfter,
                ]);

                InventoryTransaction::create([
                    'product_id' => $product->id,
                    'type' => 'stock_in',
                    'quantity' => $item->quantity,
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'reference' => $sale->invoice_number,
                    'notes' => 'Stock restored after sale cancellation.',
                ]);
            }

            $sale->update([
                'status' => 'cancelled',
            ]);
        });

        return redirect()
            ->route('sales.index')
            ->with(
                'success',
                'Sale cancelled and stock restored.'
            );
    }

    /**
     * Generate unique invoice number.
     */
    private function generateInvoiceNumber(): string
    {
        do {
            $number =
                'INV-' .
                now()->format('Ymd') .
                '-' .
                strtoupper(
                    Str::random(5)
                );

        } while (
            Sale::where(
                'invoice_number',
                $number
            )->exists()
        );

        return $number;
    }
}