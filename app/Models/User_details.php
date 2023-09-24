<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_details extends Model
{
    protected $guarded = [];
    protected $table = 'user_details';
    protected $hidden = ['updated_at', 'updated_at'];
    //
//    public function user_details(){
//        return $this->belongsTo(User::class, 'user_id', 'id');
//
//    }
}
