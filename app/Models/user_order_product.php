<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_order_product extends Model
{
    use HasFactory;

	 public function order()
    {
          return $this->belongsTo(UserOrders::class)->with(['table']);
    }

	public function product(){
		return $this->belongsTo(Vendor_Product::class);
	}

	public function variant(){
		return $this->belongsTo(vendor_products_variant::class,'variant_id');
	}

	public function addons(){
		return $this->hasMany(user_order_product_addon::class,'u_o_product_id');
	}

    public function kot_products(){
        return $this->hasMany(user_order_product::class,'kot');
    }

    public function recipe(){
        return $this->hasMany(vendor_product_recipes_raw_material::class,'product_id','product_id');
    }

}
