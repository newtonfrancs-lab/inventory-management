<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Stock;
use App\Models\Supplier; 
use App\Models\Product;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Show the purchase order form.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        
        // Ensure this matches your blade file path
        return view('purchase', compact('suppliers', 'products'));
    }

    /**
     * Store a new purchase and notify the supplier.
     */
    public function store(Request $request)
    {
        // Basic validation to ensure items exist
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            // 1. Fetch Supplier details for the WhatsApp message
            $supplier = Supplier::findOrFail($request->supplier_id);
            
            // 2. Initialize the message header
            $message = "📦 *NEW PURCHASE ORDER*\n";
            $message .= "--------------------------\n";
            $message .= "Hello " . $supplier->supplier_name . ",\n\n";
            $message .= "I would like to place an order for the following items:\n\n";

            DB::transaction(function () use ($request, &$message) {
                foreach ($request->items as $item) {
                    // Fetch product name for the message string
                    $product = Product::find($item['product_id']);
                    $message .= "🔹 " . $product->product_name . " | Qty: " . $item['quantity'] . "\n";

                    // 3. Call your SQL Stored Procedure
                    // Logic: SupplierID, ProductID, Quantity, UnitPrice
                    DB::statement("CALL RestockProduct(?, ?, ?, ?)", [
                        $request->supplier_id,
                        $item['product_id'],
                        $item['quantity'],
                        $item['price']
                    ]);
                }
            });

            $message .= "\nTotal Investment: ₹" . number_format($request->grand_total, 2) . "\n";
            $message .= "--------------------------\n";
            $message .= "Please confirm the availability. Regards!";

            // 4. Generate WhatsApp Link
            // Note: We clean the phone number to ensure only digits are passed to the URL
            $cleanPhone = preg_replace('/[^0-9]/', '', $supplier->phone);
            $waUrl = "https://wa.me/" . $cleanPhone . "?text=" . urlencode($message);

            // 5. Redirect back with success message and the WhatsApp URL
            return redirect()->back()->with([
                'success' => 'Restock successful! Database and stock levels updated.',
                'wa_url' => $waUrl
            ]);

        } catch (\Exception $e) {
            // Log the error if necessary and return back with the error message
            return back()->withErrors(['error' => 'Deployment Error: ' . $e->getMessage()]);
        }
    }
}