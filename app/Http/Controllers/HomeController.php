<?php

namespace App\Http\Controllers;

// Import the base controller we just fixed in Step 1
use App\Http\Controllers\Controller; 
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Purchase;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        // This method comes from Step 1's BaseController
        $this->middleware('auth');
    }

    public function index()
    {
        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();
        $recentPurchases = Purchase::with('supplier')->latest()->take(5)->get();

        // Ensure this matches the name of your landing page file (home.blade.php)
        return view('home', compact('totalProducts', 'totalSuppliers', 'recentPurchases'));
    }
}