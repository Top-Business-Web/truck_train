<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_service extends Model
{
    //
    protected $hidden = ['updated_at', 'updated_at'];

    public function service_data(){
        return $this->belongsTo(Service::class,"service_id","id");
    }
//    public function User_service()
//    {
//        return $this->belongsTo(User::class, 'user_id', 'id');
//    }
}
