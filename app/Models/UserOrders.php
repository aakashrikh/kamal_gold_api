<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrders extends Model
{
    use HasFactory;

    protected $table="user_orders";

    public function user()
    {
          return $this->belongsTo(User::class);
    }

    public function vendor()
    {
          return $this->belongsTo(Vendor::class);
    }


	public function product(){
		return $this->belongsToMany(Vendor_Product::class,user_order_product::class, 'order_id','product_id')->withPivot('product_quantity');
	}

    public function cart()
    {
        return $this->hasMany(user_order_product::class,'order_id');
    }

    public function kot(){
        return $this->hasMany(user_order_product::class,'order_id')->with('kot_products')->groupBy('kot');
	}



	// public function allproduct(){
	// 	return $this->belongsToMany(Vendor_Product::class,user_order_product::class, 'order_id','product_id')->with(['addons'])->with('product_variant')->withPivot('product_quantity');
	// }

	// public function product_variant(){
	// 	return $this->belongsToMany(vendor_products_variant::class,user_order_product::class, 'order_id','product_id')->withPivot('product_quantity');
	// }

	public function table(){
		return $this->belongsTo(vendor_table::class,'order_type');
	}


	public function variant(){
		return $this->belongsToMany(vendor_products_variant::class,user_order_product::class,'order_id','variant_id',);
	}

	public function addons(){
		return $this->belongsTo(user_order_product_addon::class, 'u_o_product_id');;
	}

	public function transactions(){
		return $this->hasMany(user_orders_txn_log::class, 'order_id')->where('txn_status','success');
	}

    public function staff(){
        return $this->belongsTo(vendor_staff_account::class,'staff_id');
    }

}
