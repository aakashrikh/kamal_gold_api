<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_product_recipes_raw_material extends Model
{
    use HasFactory;

    public function raw_material()
    {
        return $this->belongsTo( vendor_inventory_product::class,'raw_product_id','id');
    }

}
