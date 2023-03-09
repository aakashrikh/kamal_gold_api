<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_inventory_purchase extends Model
{
    use HasFactory;

    protected $table = 'vendor_inventory_purchases';


	public function supplier(){
        return $this->belongsTo(vendor_inventory_supplier::class,'supplier_id');
	}

    public function payment(){

        return $this->hasMany(vendor_inventory_purchase_payment::class,'purchase_id')->where('txn_type','debit');
    }

    public function material(){
        return $this->hasMany(vendor_inventory_purchases_material::class,'purchase_id')->with('product');
    }
}
