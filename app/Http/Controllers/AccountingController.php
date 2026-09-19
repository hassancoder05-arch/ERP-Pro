<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountingController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input(
            'start_date',
            now()->startOfMonth()->format('Y-m-d')
        );

        $endDate = $request->input(
            'end_date',
            now()->endOfMonth()->format('Y-m-d')
        );

        /*
        |--------------------------------------------------------------------------
        | Sales
        |--------------------------------------------------------------------------
        */

        $sales = Sale::with('items')
            ->where('status', 'completed')
            ->whereBetween('sale_date', [
                $startDate,
                $endDate
            ])
            ->get();

        $totalSales = $sales->sum('grand_total');

        /*
        |--------------------------------------------------------------------------
        | COGS
        |--------------------------------------------------------------------------
        */

        $cogs = 0;

        foreach ($sales as $sale) {

            foreach ($sale->items as $item) {

                $cogs +=
                    (float) $item->cost_price *
                    (int) $item->quantity;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Gross Profit
        |--------------------------------------------------------------------------
        */

        $grossProfit = $totalSales - $cogs;

        /*
        |--------------------------------------------------------------------------
        | Other Income
        |--------------------------------------------------------------------------
        */

        $totalIncome = Income::whereBetween(
            'income_date',
            [$startDate, $endDate]
        )->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Expenses
        |--------------------------------------------------------------------------
        */

        $totalExpenses = Expense::whereBetween(
            'expense_date',
            [$startDate, $endDate]
        )->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Net Profit
        |--------------------------------------------------------------------------
        */

        $netProfit =
            $grossProfit +
            $totalIncome -
            $totalExpenses;

        /*
        |--------------------------------------------------------------------------
        | Customer Payments
        |--------------------------------------------------------------------------
        */

        $customerPayments = Payment::where(
            'type',
            'customer'
        )
        ->whereBetween('payment_date', [
            $startDate,
            $endDate
        ])
        ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Supplier Payments
        |--------------------------------------------------------------------------
        */

        $supplierPayments = Payment::where(
            'type',
            'supplier'
        )
        ->whereBetween('payment_date', [
            $startDate,
            $endDate
        ])
        ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Cash Flow
        |--------------------------------------------------------------------------
        */

        $cashIn =
            $totalSales +
            $totalIncome +
            $customerPayments;

        $cashOut =
            $totalExpenses +
            $supplierPayments;

        $cashBalance = $cashIn - $cashOut;

        /*
        |--------------------------------------------------------------------------
        | Inventory
        |--------------------------------------------------------------------------
        */

        $inventoryValue = Product::sum(
            DB::raw('stock * purchase_price')
        );

        $lowStockProducts = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        return view(
            'accounting.index',
            compact(
                'startDate',
                'endDate',
                'totalSales',
                'cogs',
                'grossProfit',
                'totalIncome',
                'totalExpenses',
                'netProfit',
                'customerPayments',
                'supplierPayments',
                'cashIn',
                'cashOut',
                'cashBalance',
                'inventoryValue',
                'lowStockProducts'
            )
        );
    }
}