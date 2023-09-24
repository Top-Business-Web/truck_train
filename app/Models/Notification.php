<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];

    public function order(){
        return $this->belongsTo(Order::class,"order_id","id");
    }

    public function offer(){
        return $this->belongsTo(Offer::class,"offer_id","id");
    }

}
