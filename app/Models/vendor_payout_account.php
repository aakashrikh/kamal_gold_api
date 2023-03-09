<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendor_payout_account extends Model
{
    use HasFactory;
	
	 protected $hidden = [
        'payout_fund_id',
        'payout_account_id',
		 'payout_account_status'
    ];
}
