<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        // Default: current month
        $startDate = $request->input(
            'start_date',
            now()->startOfMonth()->format('Y-m-d')
        );

        $endDate = $request->input(
            'end_date',
            now()->endOfMonth()->format('Y-m-d')
        );

        // Total completed sales
        $totalSales = Sale::where('status', 'completed')
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->sum('grand_total');

        // Other income
        $totalIncome = Income::whereBetween(
            'income_date',
            [$startDate, $endDate]
        )->sum('amount');

        // Total expenses
        $totalExpenses = Expense::whereBetween(
            'expense_date',
            [$startDate, $endDate]
        )->sum('amount');

        // Customer payments
        $customerPayments = Payment::where('type', 'customer')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->sum('amount');

        // Supplier payments
        $supplierPayments = Payment::where('type', 'supplier')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Financial calculations
        |--------------------------------------------------------------------------
        */

        $totalRevenue = $totalSales + $totalIncome;

        $netProfit = $totalRevenue - $totalExpenses;

        $cashIn = $totalSales
            + $totalIncome
            + $customerPayments;

        $cashOut = $totalExpenses
            + $supplierPayments;

        $cashBalance = $cashIn - $cashOut;

        return view('finance.index', compact(
            'startDate',
            'endDate',
            'totalSales',
            'totalIncome',
            'totalExpenses',
            'customerPayments',
            'supplierPayments',
            'totalRevenue',
            'netProfit',
            'cashIn',
            'cashOut',
            'cashBalance'
        ));
    }
}