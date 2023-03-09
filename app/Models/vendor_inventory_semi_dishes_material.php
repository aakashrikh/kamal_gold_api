<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_inventory_semi_dishes_material extends Model
{
    use HasFactory;

    //materials

    public function materials(){
        return $this->belongsTo(vendor_inventory_product::class, 'material_id');
    }
}
