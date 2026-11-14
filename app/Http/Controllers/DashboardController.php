<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Fetch Low Stock (Querying Stock table directly so it's never zero)
        $lowStockAlerts = Product::join('stocks', 'products.id', '=', 'stocks.product_id')
            ->where('stocks.available_quantity', '<=', 5)
            ->select('products.product_name', 'stocks.available_quantity as current_qty', 'stocks.updated_at as alert_date')
            ->get();

        // 2. Core Stats
        $totalProducts = Product::count();
        $totalSales = Sale::sum('grand_total'); 
        $totalPurchases = Purchase::sum('total_amount');

        // 3. Recent Sales (Eager load 'product' so names show up in the table)
        $salesData = SaleItem::with('product')->latest()->take(10)->get();

        // 4. Simple Daily Profit (Just for the main card)
        $dailyProfit = SaleItem::join('products', 'sale_items.product_id', '=', 'products.id')
            ->whereDate('sale_items.created_at', today())
            ->selectRaw('SUM((sale_items.selling_price - products.unit_price) * sale_items.quantity) as profit')
            ->value('profit') ?? 0;

        // Reset others to 0 or remove them if you aren't using them in Blade anymore
        $monthlyProfit = 0;
        $yearlyProfit = 0;
        $totalProfit = 0;
        $lastSevenDays = [];

        return view('dashboard', compact(
            'totalProducts', 
            'totalSales', 
            'totalPurchases', 
            'totalProfit', 
            'dailyProfit',
            'monthlyProfit',
            'yearlyProfit',
            'salesData',
            'lowStockAlerts',
            'lastSevenDays'
        ));
    }
}