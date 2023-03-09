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
        return $this->belongsTo('user_scheme', 'user_id','scheme_id');
    }
}
