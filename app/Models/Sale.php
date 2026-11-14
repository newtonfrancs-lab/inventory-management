<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    protected $fillable = [
        'customer_id', 
        'sale_date', 
        'total_amount', 
        'gst_amount',   // Add this
        'grand_total'   // Add this
    ];
    public function items()
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }
    public function product()
    {
        // Ensure 'product_id' is the column name in your sales table
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
   
}
