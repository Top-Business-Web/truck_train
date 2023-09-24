<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    //
    protected $table = 'comments';




    public function user_data()
    {
        return $this->hasOne(User::Class, 'id', 'user_id');
    }

    public function client()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function driver()
    {
        return $this->hasOne('App\User', 'id', 'driver_id');
    }




}
