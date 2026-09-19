<?php

namespace App\Http\Controllers;

use App\Models\Product;

class NotificationController extends Controller
{
    public function index()
    {
        // Out of stock products
        $outOfStockProducts = Product::where('stock', '<=', 0)
            ->orderBy('name')
            ->get();

        // Low stock products
        $lowStockProducts = Product::where('stock', '>', 0)
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->get();

        return view('notifications.index', compact(
            'outOfStockProducts',
            'lowStockProducts'
        ));
    }
}