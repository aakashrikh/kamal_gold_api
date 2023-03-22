<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class scheme extends Model
{
    use HasFactory;

    protected $table = 'schemes';

    public function customer()
    {
        return $this->hasMany(user_scheme::class, 'scheme_id','id');
    }
}
