<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_scheme_emi extends Model
{
    use HasFactory;

    protected $table = 'user_scheme_emis';

    public function scheme()
    {
        return $this->belongsTo(user_scheme::class, 'user_scheme_id', 'id')->with('scheme')->with('user');
    }

    public function staff()
    {
        return $this->belongsTo(vendor_staff_account::class, 'staff_id', 'staff_id');
    }
}
