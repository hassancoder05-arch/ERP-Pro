<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $incomes = Income::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('payment_method', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest('income_date')
            ->paginate(10)
            ->withQueryString();

        return view('incomes.index', compact('incomes', 'search'));
    }

    public function create()
    {
        return view('incomes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'income_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:cash,bank,other'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Income::create($validated);

        return redirect()
            ->route('incomes.index')
            ->with('success', 'Income added successfully.');
    }

    public function show(Income $income)
    {
        return view('incomes.show', compact('income'));
    }

    public function edit(Income $income)
    {
        return view('incomes.edit', compact('income'));
    }

    public function update(Request $request, Income $income)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'income_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:cash,bank,other'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $income->update($validated);

        return redirect()
            ->route('incomes.index')
            ->with('success', 'Income updated successfully.');
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()
            ->route('incomes.index')
            ->with('success', 'Income deleted successfully.');
    }
}