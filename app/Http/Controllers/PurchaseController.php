<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransaction;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PurchaseController extends Controller
{
/**
 * Display purchases with search, status filters and dashboard statistics.
 */
public function index(Request $request)
{
    $request->validate([
        'status' => [
            'nullable',
            'in:draft,ordered,received,cancelled',
        ],
        'search' => [
            'nullable',
            'string',
            'max:100',
        ],
    ]);

    $search = trim($request->input('search', ''));
    $status = $request->input('status', '');

    // Purchase list with search and status filters.
    $purchases = Purchase::with('supplier')
        ->when($search !== '', function ($query) use ($search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery
                    ->where('purchase_number', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function ($supplierQuery) use ($search) {
                        $supplierQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('company_name', 'like', "%{$search}%");
                    });
            });
        })
        ->when($status !== '', function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    // Dashboard statistics: all purchases, independent of active filters.
    $totalPurchases = Purchase::count();

    $totalAmount = Purchase::sum('grand_total');

    $draftPurchases = Purchase::where('status', 'draft')->count();

    $orderedPurchases = Purchase::where('status', 'ordered')->count();

    $receivedPurchases = Purchase::where('status', 'received')->count();

    $cancelledPurchases = Purchase::where('status', 'cancelled')->count();

    // Draft and ordered purchases are still pending.
    $pendingPurchases = $draftPurchases + $orderedPurchases;

    return view('purchases.index', compact(
        'purchases',
        'search',
        'status',
        'totalPurchases',
        'totalAmount',
        'pendingPurchases',
        'draftPurchases',
        'orderedPurchases',
        'receivedPurchases',
        'cancelledPurchases'
    ));
}



    /**
     * Show the create purchase form.
     */
    public function create()
    {
        $suppliers = Supplier::where('status', 'active')
            ->orderBy('name')
            ->get();

        $products = Product::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('purchases.create', compact(
            'suppliers',
            'products'
        ));
    }

    /**
     * Store a new purchase.
     *
     * Stock is not changed until the purchase is received.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => [
                'required',
                'integer',
                'exists:suppliers,id',
            ],

            'purchase_date' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
                'decimal:0,2',
            ],

            'tax' => [
                'nullable',
                'numeric',
                'min:0',
                'decimal:0,2',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.product_id' => [
                'required',
                'integer',
                'distinct',
                'exists:products,id',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.cost_price' => [
                'required',
                'numeric',
                'gt:0',
                'decimal:0,2',
            ],
        ]);

        $purchase = DB::transaction(function () use ($validated) {

            // Lock and verify supplier.
            $supplier = Supplier::whereKey(
                $validated['supplier_id']
            )
                ->lockForUpdate()
                ->firstOrFail();

            if ($supplier->status !== 'active') {
                throw ValidationException::withMessages([
                    'supplier_id' => 'Please select an active supplier.',
                ]);
            }

            $items = collect($validated['items']);

            $productIds = $items
                ->pluck('product_id')
                ->unique()
                ->values();

            // Lock selected products.
            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== $productIds->count()) {
                throw ValidationException::withMessages([
                    'items' => 'One or more selected products no longer exist.',
                ]);
            }

            // Validate product status.
            foreach ($items as $item) {
                $product = $products->get($item['product_id']);

                if (!$product || $product->status !== 'active') {
                    throw ValidationException::withMessages([
                        'items' => 'Please select active products only.',
                    ]);
                }
            }

            // Calculate money using integer cents.
            $subtotalCents = 0;

            foreach ($items as $item) {
                $priceCents = (int) round(
                    (float) $item['cost_price'] * 100
                );

                $quantity = (int) $item['quantity'];

                $subtotalCents += $priceCents * $quantity;
            }

            $discountCents = (int) round(
                (float) ($validated['discount'] ?? 0) * 100
            );

            $taxCents = (int) round(
                (float) ($validated['tax'] ?? 0) * 100
            );

            if ($discountCents > $subtotalCents) {
                throw ValidationException::withMessages([
                    'discount' => 'Discount cannot exceed the subtotal.',
                ]);
            }

            $grandTotalCents =
                $subtotalCents - $discountCents + $taxCents;

            // Create purchase.
            $purchase = Purchase::create([
                'purchase_number' => $this->generatePurchaseNumber(),

                'supplier_id' => $supplier->id,

                'purchase_date' => $validated['purchase_date'],

                'status' => 'draft',

                'subtotal' => number_format(
                    $subtotalCents / 100,
                    2,
                    '.',
                    ''
                ),

                'discount' => number_format(
                    $discountCents / 100,
                    2,
                    '.',
                    ''
                ),

                'tax' => number_format(
                    $taxCents / 100,
                    2,
                    '.',
                    ''
                ),

                'grand_total' => number_format(
                    $grandTotalCents / 100,
                    2,
                    '.',
                    ''
                ),

                'notes' => $validated['notes'] ?? null,
            ]);

            // Create purchase items.
            foreach ($items as $item) {
                $priceCents = (int) round(
                    (float) $item['cost_price'] * 100
                );

                $quantity = (int) $item['quantity'];

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,

                    'product_id' => $item['product_id'],

                    'quantity' => $quantity,

                    'cost_price' => number_format(
                        $priceCents / 100,
                        2,
                        '.',
                        ''
                    ),

                    'total' => number_format(
                        ($priceCents * $quantity) / 100,
                        2,
                        '.',
                        ''
                    ),
                ]);
            }

            return $purchase;
        }, 3);

        return redirect()
            ->route('purchases.show', $purchase)
            ->with(
                'success',
                'Purchase created successfully. Stock has not been changed.'
            );
    }

    /**
 * Mark a draft purchase as ordered.
 */
public function order(Purchase $purchase)
{
    DB::transaction(function () use ($purchase) {

        $lockedPurchase = Purchase::whereKey($purchase->id)
            ->lockForUpdate()
            ->firstOrFail();

        if ($lockedPurchase->status !== 'draft') {
            throw ValidationException::withMessages([
                'purchase' => 'Only draft purchases can be marked as ordered.',
            ]);
        }

        $lockedPurchase->status = 'ordered';
        $lockedPurchase->save();
    }, 3);

    return redirect()
        ->route('purchases.show', $purchase)
        ->with('success', 'Purchase marked as ordered successfully. Stock has not been changed.');
}

    /**
     * Receive a purchase and update inventory.
     */
    public function receive(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {

            // Lock purchase to prevent duplicate receiving.
            $lockedPurchase = Purchase::whereKey($purchase->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Prevent duplicate stock updates.
            if ($lockedPurchase->status === 'received') {
                throw ValidationException::withMessages([
                    'purchase' => 'This purchase has already been received.',
                ]);
            }

            // Only draft and ordered purchases can be received.
            if (!in_array(
                $lockedPurchase->status,
                ['draft', 'ordered'],
                true
            )) {
                throw ValidationException::withMessages([
                    'purchase' => 'Only draft or ordered purchases can be received.',
                ]);
            }

            // Load purchase items.
            $items = PurchaseItem::where(
                'purchase_id',
                $lockedPurchase->id
            )
                ->orderBy('product_id')
                ->get();

            if ($items->isEmpty()) {
                throw ValidationException::withMessages([
                    'purchase' => 'This purchase has no products to receive.',
                ]);
            }

            // Lock products in a consistent order.
            $productIds = $items
                ->pluck('product_id')
                ->unique()
                ->sort()
                ->values();

            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== $productIds->count()) {
                throw ValidationException::withMessages([
                    'purchase' => 'One or more products could not be found.',
                ]);
            }

            // Update stock and create inventory transactions.
            foreach ($items as $item) {
                $product = $products->get($item->product_id);

                $stockBefore = (int) $product->stock;
                $quantity = (int) $item->quantity;
                $stockAfter = $stockBefore + $quantity;

                $product->stock = $stockAfter;
                $product->save();

                InventoryTransaction::create([
                    'product_id' => $product->id,

                    'type' => 'stock_in',

                    'quantity' => $quantity,

                    'stock_before' => $stockBefore,

                    'stock_after' => $stockAfter,

                    'reference' => $lockedPurchase->purchase_number,

                    'notes' => 'Stock received from purchase '
                        . $lockedPurchase->purchase_number,
                ]);
            }

            // Mark purchase as received.
            $lockedPurchase->status = 'received';
            $lockedPurchase->received_at = now();
            $lockedPurchase->save();
        }, 3);

        return redirect()
            ->route('purchases.show', $purchase)
            ->with(
                'success',
                'Purchase received successfully. Product stock has been updated.'
            );
    }
    
    public function cancel(Purchase $purchase)
{
    return DB::transaction(function () use ($purchase) {

        $purchase = Purchase::whereKey($purchase->id)
            ->lockForUpdate()
            ->firstOrFail();

        if ($purchase->status === 'cancelled') {
            return redirect()
                ->route('purchases.show', $purchase)
                ->with('error', 'This purchase is already cancelled.');
        }

        if (! in_array($purchase->status, ['draft', 'ordered'], true)) {
            return redirect()
                ->route('purchases.show', $purchase)
                ->with('error', 'Only draft or ordered purchases can be cancelled.');
        }

        $purchase->status = 'cancelled';
        $purchase->save();

        return redirect()
            ->route('purchases.show', $purchase)
            ->with('success', 'Purchase cancelled successfully.');
    });
}
    /**
     * Display purchase details.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load([
            'supplier',
            'items.product',
        ]);

        return view('purchases.show', compact('purchase'));
    }

    /**
     * Generate a unique purchase number.
     */
    private function generatePurchaseNumber(): string
    {
        do {
            $number = 'PUR-'
                . now()->format('YmdHis')
                . '-'
                . strtoupper(Str::random(6));

        } while (
            Purchase::where('purchase_number', $number)->exists()
        );

        return $number;
    }
}
