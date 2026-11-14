<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Multitenantable;

class Supplier extends Model
{
    use Multitenantable;
    //
    protected $fillable = ['supplier_name', 'phone', 'address'];
  
}
