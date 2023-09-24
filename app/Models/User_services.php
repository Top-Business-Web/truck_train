<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_services extends Model
{
    protected $guarded = [];
    protected $table = 'user_services';
    //

    public function service_data(){
        return $this->belongsTo(Service::class,"service_id","id");
    }

}
