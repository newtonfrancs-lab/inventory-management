<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $customers = Customer::all();
        return view('customers', compact('customers'));
    }

    public function store(Request $request)
    {
        Customer::create($request->all());
        return back()->with('success', 'Customer added');
    }

    public function show($id) // Added $id here
    {
        // Eager load everything so the customer profile shows their whole history
        $customer = Customer::with(['sales.items.product'])->findOrFail($id);
        return view('customers.show', compact('customer'));
    }
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
    
    // Optional: Check if they have sales before deleting
    // if($customer->sales()->count() > 0) {
    //     return back()->with('error', 'Cannot delete customer with existing sales history.');
    // }

        $customer->delete();

        return back()->with('success', 'Customer removed successfully.');
    }
}
