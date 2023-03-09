<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_orders_txn_log extends Model
{
    use HasFactory;

    public function orders()
    {
          return $this->belongsTo(UserOrders::class,'order_id');
    }
}
