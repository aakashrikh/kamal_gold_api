<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_inventory_semi_dish extends Model
{
    use HasFactory;

    //semi_dish_materials

    public function semi_dish_materials(){
        return $this->hasMany(vendor_inventory_semi_dishes_material::class, 'dish_id')->with('materials');
    }
}
