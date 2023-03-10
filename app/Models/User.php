<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'access_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function last_order()
    {
        return $this->hasOne(UserOrders::class)->orderBy('id', 'desc');
    }

    public function avg_order()
    {
        return $this->hasOne(UserOrders::class);
    }


    // public function cashback()
    // {
    //     return $this->hasMany(Vendor_category::class);
    // }

    // public function followers()
    // {
    //     return $this->hasMany(Vendor_category::class);
    // }

    // public function following()
    // {
    //     return $this->hasMany(Vendor_category::class);
    // }
}
