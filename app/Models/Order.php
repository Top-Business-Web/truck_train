<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    protected $guarded = [];

    public function order_images()
    {
        return $this->hasMany('App\Models\Order_image', 'order_id', 'id');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Driver_offer', 'order_id', 'id')->where("status","new");
    }

    public function user_data()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function driver_data()
    {
        return $this->belongsTo(User::class, 'driver_id', 'id');
    }


    public function client()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id','id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id','id');
    }

}
