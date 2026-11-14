<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    // 1. This fixes the MassAssignmentException
    protected $fillable = [
        'product_id',
        'available_quantity',
        'last_restock_date' // Add any other columns you have in your stocks table
    ];

    // 2. Your existing primary key configuration
    protected $primaryKey = 'product_id';
    public $incrementing = false;
    
    // 3. Relationship to the Product model
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}