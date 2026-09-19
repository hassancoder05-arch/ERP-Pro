<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $expenses = Expense::with('category')
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('payment_method', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($category) use ($search) {

                            $category->where(
                                'name',
                                'like',
                                "%{$search}%"
                            );

                        });

                });

            })
            ->latest('expense_date')
            ->paginate(10)
            ->withQueryString();

        return view(
            'expenses.index',
            compact('expenses', 'search')
        );
    }

    public function create()
    {
        $categories = ExpenseCategory::orderBy('name')->get();

        return view(
            'expenses.create',
            compact('categories')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_category_id' => [
                'required',
                'exists:expense_categories,id',
            ],

            'title' => [
                'required',
                'string',
                'max:150',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'expense_date' => [
                'required',
                'date',
            ],

            'payment_method' => [
                'required',
                'in:cash,bank,other',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        Expense::create($validated);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense added successfully.');
    }

    public function show(Expense $expense)
    {
        $expense->load('category');

        return view(
            'expenses.show',
            compact('expense')
        );
    }

    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::orderBy('name')->get();

        return view(
            'expenses.edit',
            compact('expense', 'categories')
        );
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'expense_category_id' => [
                'required',
                'exists:expense_categories,id',
            ],

            'title' => [
                'required',
                'string',
                'max:150',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'expense_date' => [
                'required',
                'date',
            ],

            'payment_method' => [
                'required',
                'in:cash,bank,other',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $expense->update($validated);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}