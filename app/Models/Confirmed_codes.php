<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Confirmed_codes extends Model
{
    protected $guarded = [];
    protected $table = 'confirmed_codes';
    protected $hidden = ['updated_at', 'created_at'];
    //
}
