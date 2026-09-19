<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
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

        // Sales
        $sales = Sale::with('customer')
            ->where('status', 'completed')
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->latest('sale_date')
            ->get();

        $totalSales = $sales->sum('grand_total');

        // Expenses
        $expenses = Expense::with('category')
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->latest('expense_date')
            ->get();

        $totalExpenses = $expenses->sum('amount');

        // Other Income
        $incomes = Income::whereBetween(
            'income_date',
            [$startDate, $endDate]
        )
        ->latest('income_date')
        ->get();

        $totalIncome = $incomes->sum('amount');

        // Customer Payments
        $customerPayments = Payment::with('customer')
            ->where('type', 'customer')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->latest('payment_date')
            ->get();

        $totalCustomerPayments = $customerPayments->sum('amount');

        // Supplier Payments
        $supplierPayments = Payment::with('supplier')
            ->where('type', 'supplier')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->latest('payment_date')
            ->get();

        $totalSupplierPayments = $supplierPayments->sum('amount');

        // Summary
        $totalRevenue = $totalSales + $totalIncome;

        $netProfit = $totalRevenue - $totalExpenses;

        $cashIn = $totalSales
            + $totalIncome
            + $totalCustomerPayments;

        $cashOut = $totalExpenses
            + $totalSupplierPayments;

        $cashBalance = $cashIn - $cashOut;

        // Product stock summary
        $totalProducts = Product::count();

        $totalStock = Product::sum('stock');

        $lowStockProducts = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        // Top selling products
        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.status', 'completed')
            ->whereBetween('sales.sale_date', [$startDate, $endDate])
            ->select(
                'products.name',
                DB::raw('SUM(sale_items.quantity) as total_quantity'),
                DB::raw('SUM(sale_items.total) as total_sales')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        return view('reports.index', compact(
            'startDate',
            'endDate',
            'sales',
            'expenses',
            'incomes',
            'customerPayments',
            'supplierPayments',
            'totalSales',
            'totalExpenses',
            'totalIncome',
            'totalCustomerPayments',
            'totalSupplierPayments',
            'totalRevenue',
            'netProfit',
            'cashIn',
            'cashOut',
            'cashBalance',
            'totalProducts',
            'totalStock',
            'lowStockProducts',
            'topProducts'
        ));
    }
}