<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_inventory_purchases_material extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo(vendor_inventory_product::class,'material_id');
    }
	
}
