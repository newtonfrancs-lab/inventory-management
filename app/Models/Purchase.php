<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Multitenantable;

class Purchase extends Model
{
    use Multitenantable;
    //
    protected $fillable = ['supplier_id', 'purchase_date', 'total_amount', 'gst_amount','grand_total'];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
    public function items()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id');
    }
    public function store(Request $request)
    {
    // ... validate items ...

        DB::transaction(function () use ($request) {
            foreach ($request->items as $item) {
            // CALL the procedure. 
            // The DB Trigger handles 'available_quantity = available_quantity + qty'
            DB::statement("CALL RestockProduct(?, ?, ?, ?)", [
                $request->supplier_id,
                $item['product_id'],
                $item['quantity'],
                $item['price']
            ]);
        }
    });

    return redirect()->back()->with('success', 'Stock replenished successfully!');
    }
   
}
