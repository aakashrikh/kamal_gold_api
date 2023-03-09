<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_cart extends Model
{
    use HasFactory;
	
	protected $table="user_carts";
	protected $fillable = ['product_id','user_id','variants_id','product_price','product_quantity','cart_type'];
	
	public function product(){
		return $this->belongsTo(Vendor_Product::class,'product_id');
	}
	
	public function variant(){
		return $this->belongsTo(vendor_products_variant::class,'variants_id');
	}
	
	public function addons(){
		return $this->belongsToMany(vendor_products_addon::class,user_cart_addon::class, 'cart_id', 'addon_id');;
	}
	
	public function local_addons()
	{
		return $this->hasMany(user_cart_addon::class, 'cart_id',);
	}
	
	public function delete_addons()
    {
        // delete all related photos 
        $this->photos()->delete();
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Photo::where("user_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }
	
}
