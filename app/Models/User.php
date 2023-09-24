<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $softDelete = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function details()
    {
        return $this->hasOne(User_details::class, 'user_id', 'id');
    }

    public function service(){
        return $this->hasOne(User_services::class,"user_id","id");
    }

    public function user_details()
    {
        return $this->hasOne(User_details::class, 'user_id', 'id');
    }

    public function User_service()
    {
        return $this->hasOne(User_service::class, 'user_id', 'id');
    }

    public function driver_rates()
    {
        return $this->hasMany(Comment::class, 'driver_id', 'id');
    }
}
