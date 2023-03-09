<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor_Product extends Model
{
    use HasFactory;
    protected $table="vendor_products";
	protected $fillable = ['status','vendor_id','product_name','product_img','market_price','our_price','is_veg','description','vendor_category_id','type'];
	
	public function favourite(){
		return $this->hasOne(user_product_saves::class,'product_id');
	}
	
	public function category()
	{
		return $this->belongsTo(Vendor_category::class,'vendor_category_id');
	}
	
	public function variants(){
		return $this->hasMany(vendor_products_variant::class,'product_id');
	}
	
	public function addons(){
		return $this->hasMany(vendor_product_adons_map::class,'product_id');
	}
	
	 public function addon_map()
    {
      //  return $this->hasManyThrough(vendor_product_adons_map::class,vendor_products_addon::class,'id','product_id');
		 
		return $this->belongsToMany(vendor_products_addon::class,vendor_product_adons_map::class, 'product_id', 'addon_id');;
    }
}
