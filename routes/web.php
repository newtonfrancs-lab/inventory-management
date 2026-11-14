<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;

// --- PUBLIC ROUTES (No Login Required) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// This ensures that when the controller says ->route('home'), 
// it loads the page that uses home.blade.php
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'subscribed']);

// The "Billing" page where expired users are sent
Route::middleware(['auth'])->get('/billing', function () {
    return view('billing'); // Create a simple view explaining how to pay via Whop
})->name('billing');


// --- PROTECTED ROUTES (Login Required) ---
Route::middleware('auth')->group(function () {
    
    // This is your main landing page after login
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    // Dashboard / Analytics
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::get('/products', [ProductController::class, 'create'])->name('products');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');

    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // Suppliers
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store'); // Changed name slightly to avoid conflict
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // Purchase
    Route::get('/purchase', [PurchaseController::class, 'create'])->name('purchase');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');

    // Sales
    Route::get('/sales', [SaleController::class, 'index'])->name('sales');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});