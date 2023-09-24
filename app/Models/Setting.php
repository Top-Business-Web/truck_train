<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['desc', 'address1', 'phone1', 'android_app', 'ios_app', 'email1', 'facebook', 'twitter', 'instagram',
                            'telegram', 'youtube', 'whatsapp', 'about_app', 'ar_termis_condition', 'en_termis_condition', 'header_logo'];
    
}
