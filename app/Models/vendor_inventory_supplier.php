<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_inventory_supplier extends Model
{
    use HasFactory;

    public function orders(){
        return $this->hasMany(vendor_inventory_purchase::class,'supplier_id');
	}
}
