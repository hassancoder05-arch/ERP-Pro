<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display products with search and statistics.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $productQuery = Product::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('product_code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%");
                });
            });

        $products = (clone $productQuery)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Product statistics across all products.
        $totalProducts = Product::count();

        $activeProducts = Product::where('status', 'active')->count();

        $inactiveProducts = Product::where('status', 'inactive')->count();

        $lowStockProducts = Product::where('stock', '>', 0)
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->count();

        $outOfStockProducts = Product::where('stock', '<=', 0)->count();

        return view('products.index', compact(
            'products',
            'search',
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'lowStockProducts',
            'outOfStockProducts'
        ));
    }

    /**
     * Show the create product form.
     */
    public function create()
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a new product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => [
                'required',
                'string',
                'max:100',
                'unique:products,product_code',
            ],

            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'category' => [
                'nullable',
                'string',
                'max:100',
                Rule::exists('categories', 'name')
                    ->where('status', true),
            ],

            'brand' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'purchase_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully.');
    }

    /**
     * Display a specific product.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the edit product form.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact(
            'product',
            'categories'
        ));
    }

    /**
     * Update an existing product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'product_code')
                    ->ignore($product->id),
            ],

            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'category' => [
                'nullable',
                'string',
                'max:100',
                Rule::exists('categories', 'name'),
            ],

            'brand' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'purchase_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Delete a product when no protected records depend on it.
     */
    public function destroy(Product $product)
    {
        if ($product->saleItems()->exists()) {
            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'This product is used in sales records. Deactivate it instead.'
                );
        }

        if ($product->inventoryTransactions()->exists()) {
            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'This product has inventory transactions and cannot be deleted.'
                );
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}

