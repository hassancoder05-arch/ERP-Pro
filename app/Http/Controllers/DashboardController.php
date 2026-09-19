<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Date Ranges
        |--------------------------------------------------------------------------
        */

        $today = Carbon::today();

        $monthStart = Carbon::now()->startOfMonth();

        $monthEnd = Carbon::now()->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | Today's Sales
        |--------------------------------------------------------------------------
        */

        $todaySales = Sale::where('status', 'completed')
            ->whereDate('sale_date', $today)
            ->sum('grand_total');


        /*
        |--------------------------------------------------------------------------
        | Monthly Sales
        |--------------------------------------------------------------------------
        */

        $monthlySales = Sale::where('status', 'completed')
            ->whereBetween('sale_date', [
                $monthStart,
                $monthEnd
            ])
            ->sum('grand_total');


        /*
        |--------------------------------------------------------------------------
        | Monthly COGS
        |--------------------------------------------------------------------------
        */

        $monthlySalesData = Sale::with('items')
            ->where('status', 'completed')
            ->whereBetween('sale_date', [
                $monthStart,
                $monthEnd
            ])
            ->get();

        $monthlyCogs = 0;

        foreach ($monthlySalesData as $sale) {

            foreach ($sale->items as $item) {

                $monthlyCogs +=
                    (float) $item->cost_price *
                    (int) $item->quantity;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Gross Profit
        |--------------------------------------------------------------------------
        */

        $grossProfit = $monthlySales - $monthlyCogs;


        /*
        |--------------------------------------------------------------------------
        | Expenses
        |--------------------------------------------------------------------------
        */

        $monthlyExpenses = Expense::whereBetween(
            'expense_date',
            [$monthStart, $monthEnd]
        )->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | Net Profit
        |--------------------------------------------------------------------------
        */

        $netProfit = $grossProfit - $monthlyExpenses;


        /*
        |--------------------------------------------------------------------------
        | Counts
        |--------------------------------------------------------------------------
        */

        $totalCustomers = Customer::count();

        $totalSuppliers = Supplier::count();

        $totalProducts = Product::count();


        /*
        |--------------------------------------------------------------------------
        | Inventory
        |--------------------------------------------------------------------------
        */

        $totalStock = Product::sum('stock');



     $lowStockProducts = Product::where('stock', '>', 0)
    ->whereColumn('stock', '<=', 'minimum_stock')
    ->count();

$outOfStockProducts = Product::where('stock', '<=', 0)
    ->count();

$lowStockProductList = Product::where('stock', '>', 0)
    ->whereColumn('stock', '<=', 'minimum_stock')
    ->orderBy('stock', 'asc')
    ->take(5)
    ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Sales
        |--------------------------------------------------------------------------
        */

        $recentSales = Sale::with('customer')
            ->latest()
            ->limit(8)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Top Products
        |--------------------------------------------------------------------------
        */

        $topProducts = DB::table('sale_items')
            ->join(
                'products',
                'sale_items.product_id',
                '=',
                'products.id'
            )
            ->join(
                'sales',
                'sale_items.sale_id',
                '=',
                'sales.id'
            )
            ->where(
                'sales.status',
                'completed'
            )
            ->select(
                'products.name',
                DB::raw(
                    'SUM(sale_items.quantity) as total_quantity'
                ),
                DB::raw(
                    'SUM(sale_items.total) as total_sales'
                )
            )
            ->groupBy(
                'products.id',
                'products.name'
            )
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Monthly Sales Chart
        |--------------------------------------------------------------------------
        */

        $chartData = [];

        for ($i = 1; $i <= $today->day; $i++) {

            $date = Carbon::create(
                $today->year,
                $today->month,
                $i
            );

            $amount = Sale::where(
                'status',
                'completed'
            )
            ->whereDate(
                'sale_date',
                $date
            )
            ->sum('grand_total');

            $chartData[] = [
                'date' => $date->format('d M'),
                'sales' => (float) $amount,
            ];
        }


        return view(
            'dashboard.index',
            compact(
                'todaySales',
                'monthlySales',
                'monthlyCogs',
                'grossProfit',
                'monthlyExpenses',
                'netProfit',
                'totalCustomers',
                'totalSuppliers',
                'totalProducts',
                'totalStock',
                'lowStockProducts',
                'outOfStockProducts',
                'lowStockProductList',
                'recentSales',
                'topProducts',
                'chartData'
            )
        );
    }
}