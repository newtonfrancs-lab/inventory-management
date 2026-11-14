<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category_relation')->get();
        return view('products', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'product_name'  => 'required',
        'unit_price'    => 'required|numeric|min:1',
        'category_id'   => 'required|exists:categories,id', // Validates against Tinker data
        'opening_stock' => 'required|numeric|min:0'
    ]);

    $cat = Category::find($request->category_id);

    $product = Product::create([
        'product_name'  => $request->product_name,
        'unit_price'    => $request->unit_price,
        'category'      => $cat->category_name, // Pulls the name you entered in Tinker
        'opening_stock' => $request->opening_stock,
        'category_id'   => $request->category_id
    ]);
    
    // ... stock creation logic ...

        // Create stock
        Stock::create([
    'product_id' => $product->id,
    'available_quantity' => $request->opening_stock // Fixed spelling
]);

        return redirect()->route('dashboard')
                         ->with('success', 'Product added successfully!');
    }
}