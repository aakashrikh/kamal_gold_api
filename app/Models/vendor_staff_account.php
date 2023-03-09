<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class vendor_staff_account  extends Authenticatable
{
   use HasApiTokens, HasFactory, Notifiable;

   protected $primaryKey = 'staff_id';

   protected $hidden = [
    'password',
    'remember_token',
];

   protected $casts = [
    'email_verified_at' => 'datetime',
    ];
}
