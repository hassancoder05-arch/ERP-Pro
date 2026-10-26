<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display all categories with search and statistics.
     */
   public function index(Request $request)
{
    $search = trim($request->input('search', ''));

    $categories = Category::query()
        ->when($search !== '', function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        })
        ->select('categories.*')
        ->selectSub(function ($query) {
            $query->from('products')
                ->selectRaw('COUNT(*)')
                ->whereColumn('products.category', 'categories.name');
        }, 'products_count')
        ->latest()
        ->paginate(10)
        ->withQueryString();

    $totalCategories = Category::count();

    $activeCategories = Category::where('status', true)->count();

    $inactiveCategories = Category::where('status', false)->count();

    return view('categories.index', compact(
        'categories',
        'search',
        'totalCategories',
        'activeCategories',
        'inactiveCategories'
    ));
}

    /**
     * Show the form for creating a category.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a new category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:categories,name',
            ],
            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'status' => [
                'required',
                Rule::in(['1', '0', 1, 0]),
            ],
        ]);

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category added successfully.');
    }

    /**
     * Display a specific category.
     */
    public function show(Category $category)
    {
        $products = Product::where(
            'category',
            $category->name
        )
            ->latest()
            ->paginate(10);

        return view('categories.show', compact(
            'category',
            'products'
        ));
    }

    /**
     * Show the form for editing a category.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update an existing category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')
                    ->ignore($category->id),
            ],
            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'status' => [
                'required',
                Rule::in(['1', '0', 1, 0]),
            ],
        ]);

        $oldName = $category->name;
        $newName = $validated['name'];

        /*
         * Keep existing product category values synchronized.
         * Update only products using the old category name.
         */
        if ($oldName !== $newName) {
            Product::where('category', $oldName)
                ->update(['category' => $newName]);
        }

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Delete a category if no products use it.
     */
    public function destroy(Category $category)
    {
        $usedByProducts = Product::where(
            'category',
            $category->name
        )->exists();

        if ($usedByProducts) {
            return redirect()
                ->route('categories.index')
                ->with(
                    'error',
                    'This category is assigned to existing products. Reassign those products before deleting this category.'
                );
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}

