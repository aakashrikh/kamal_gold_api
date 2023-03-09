<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_kitchen extends Model
{
    use HasFactory;

    protected $table="vendor_kitchens";

    public function kitchen_product()
    {
        return $this->hasMany(Vendor_kitchen_product::class,'kitchen_id');
    }

}
