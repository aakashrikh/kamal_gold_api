<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_scheme extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scheme()
    {
        return $this->belongsTo(scheme::class,'scheme_id','id');
    }

    public function last()
    {
        return $this->hasOne(user_scheme_emi::class,'user_scheme_id','id')->orderBy('id','desc');
    }

    public function paid()
    {
        return $this->hasOne(user_scheme_emi::class,'user_scheme_id','id')->where('emi_status','paid')->orderBy('id','desc');
    }

    public function unpaid()
    {
        return $this->hasOne(user_scheme_emi::class,'user_scheme_id','id')->where('emi_status','pending')->orderBy('id','desc');
    }

}
