<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Slider ;
use App\Models\Service ;

class SettingController extends Controller
{
    //
    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */
    public function slider(){
        $data = Slider::get();
        $resultJson = ["data" => $data, "message" => "", "status" => 200];
        return response()->json($resultJson, 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function services(){
        $data = Service::get();
        $resultJson = ["data" => $data, "message" => "", "status" => 200];
        return response()->json($resultJson, 200);
    }



    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */
    public function showSetting()
    {
        $data = Setting::where("id",1)->first();
        $data->about_link = "api/about-us";
        $data->terms_link = "api/our-terms";
        $resultJson = ["data" => $data, "message" => "", "status" => 200];
        return response()->json($resultJson, 200);

    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function contactUs(Request $request){
        $validator = Validator::make($request->all(),
            [
                'name' => 'nullable',
                'phone' => 'nullable',
                'email' => 'nullable',
                'message' => 'nullable',
            ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }

        $Idata =  collect($validator->validated())->toArray();
        $obj = Contact::create($Idata);
        $data = Contact::where("id",$obj->id)->first();
        $resultJson = ["data" => $data, "message" => "", "status" => 200];
        return response()->json($resultJson, 200);
    }




} // end class
