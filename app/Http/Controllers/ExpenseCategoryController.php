<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::latest()
            ->paginate(10);

        return view('expense-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('expense-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:expense_categories,name',
            ],
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);

        ExpenseCategory::create($validated);

        return redirect()
            ->route('expense-categories.index')
            ->with('success', 'Expense category created successfully.');
    }

    public function show(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->load('expenses');

        return view(
            'expense-categories.show',
            compact('expenseCategory')
        );
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        return view(
            'expense-categories.edit',
            compact('expenseCategory')
        );
    }

    public function update(
        Request $request,
        ExpenseCategory $expenseCategory
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('expense_categories', 'name')
                    ->ignore($expenseCategory->id),
            ],
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);

        $expenseCategory->update($validated);

        return redirect()
            ->route('expense-categories.index')
            ->with('success', 'Expense category updated successfully.');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        if ($expenseCategory->expenses()->exists()) {
            return redirect()
                ->route('expense-categories.index')
                ->with(
                    'error',
                    'This category cannot be deleted because it has expenses.'
                );
        }

        $expenseCategory->delete();

        return redirect()
            ->route('expense-categories.index')
            ->with('success', 'Expense category deleted successfully.');
    }
}