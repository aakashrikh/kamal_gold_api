<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_inventory_product extends Model
{
    use HasFactory;
    protected $table="vendor_inventory_products";


    public function category()
    {
        return $this->belongsTo(vendor_inventory_category::class,'inventory_category_id');
    }
}
