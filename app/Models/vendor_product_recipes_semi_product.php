<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_product_recipes_semi_product extends Model
{
    use HasFactory;

    public function semi_dish()
    {
        return $this->belongsTo(vendor_inventory_semi_dish::class,'semi_product_id','id');
    }
}
