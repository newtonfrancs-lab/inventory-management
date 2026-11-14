<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display the sales form
     */
    public function index()
    {
        // We load products with their stock so the "In Stock" badges work
        $products = Product::with('stock')->get();
        $customers = Customer::all();

        // Ensure this matches your file name: sale.blade.php
        return view('sales', compact('products', 'customers'));
    }

    /**
     * Store a new sale and update inventory
     */
    public function store(Request $request)
    {
        // 1. Validation (Optional but recommended)
        $request->validate([
            'customer_id' => 'required',
            'items' => 'required|array',
            'grand_total' => 'required|numeric',
        ]);

        // Use a Transaction to ensure if one part fails, nothing is saved
        DB::transaction(function () use ($request) {
            
            // 2. Save the main Sale record
            $sale = Sale::create([
                'customer_id' => $request->customer_id,
                'total_amount' => $request->total_amount,
                'gst_amount' => $request->gst_amount,
                'grand_total' => $request->grand_total,
                'sale_date' => now(),
            ]);

            // 3. Loop through items and update Stock
            foreach ($request->items as $item) {
                // Save to sale_items table (for Dashboard & Profit)
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'selling_price' => $item['price'],
                ]);

                // 4. Direct Stock Update
                // We use the query builder directly to avoid "ID is null" errors
                Stock::where('product_id', $item['id'])
                    ->decrement('available_quantity', $item['qty']);
            }
        });

        return redirect()->route('sales')->with('success', 'Sale completed successfully!');
    }
}