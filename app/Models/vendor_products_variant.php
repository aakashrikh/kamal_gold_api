<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_products_variant extends Model
{
    use HasFactory;
    protected $table="vendor_products_variants";
	
	protected $fillable = ['product_id','variants_name','variants_price','variants_discounted_price'];
}
