<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_inventory_category extends Model
{
    use HasFactory;
    protected $table="vendor_inventory_categories";

    public function products()
    {
        return $this->hasMany(vendor_inventory_product::class,'inventory_category_id');
		
    }

    public function parent()
    {
        return $this->belongsTo(vendor_inventory_category::class,'category_parent');
    }

}
