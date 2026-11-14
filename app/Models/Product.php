<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Multitenantable;

class Product extends Model
{
    use Multitenantable;
    use HasFactory;

    protected $fillable = [
        'product_name',
        'unit_price',
        'category',
        'opening_stock',
        'category_id'
    ];

    public function category_relation()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function stock()
    {
        // Based on your ERD, one product has one stock entry
        return $this->hasOne(Stock::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}