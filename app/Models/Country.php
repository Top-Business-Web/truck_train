<?php

namespace App\Models;
use App\Models\Country_trans;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $guarded = [];
    //
    protected $appends = ['word'];
    public function getWordAttribute() {
        $lang = (request()->lang)? request()->lang:"ar" ;
        return  Country_trans::where("country_id",$this->id_country)->where("lang",$lang)->first();
    }

}
