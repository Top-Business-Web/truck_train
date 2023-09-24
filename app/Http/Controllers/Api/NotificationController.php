<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


use App\Models\Notification;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Traits\Api\FireBase;
use Illuminate\Support\Facades\DB;


class NotificationController extends Controller
{
    use FireBase;
    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function getMyNotification(Request $request){
        $user_id = ($request->user_id)? $request->user_id:0;
        $pagination_status = (isset($request->pagination))? $request->pagination:"off";
        $limit_per_page = (isset($request->limit_per_page))? $request->limit_per_page:"20";
        //===============================================
        Notification::where("to_user_id",$user_id)->update(["is_read"=>"yes"]);
        //===============================================
        $query  = Notification::where("to_user_id",$user_id)->orderBy("id","DESC");
        if ($pagination_status == 'on') {
            $data = $query->paginate($limit_per_page);
            $json = collect(["message" => "My Notification","status" => 200]) ;
            $json =  $json->merge($data);
            return response()->json($json, 200);
        }

        return response()->json(["data" => $query->get(),"message" => "My Notification",  "status" => 200], 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function countUread(Request $request){
        $user_id = ($request->user_id)? $request->user_id:0;
        $data["count_unread"] = Notification::where("to_user_id",$user_id)->where(["is_read"=>"no"])->count();
        $json  = [
            "data" => $data,
            "message" => "success refuse to send offer ",
            "status" => 200 ,
        ] ;
        return response()->json($json, 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

     public function delete(Request $request){
         $validator = Validator::make($request->all(),
             [
                 'notification_id' => 'required|exists:notifications,id',
             ], []);
         if ($validator->fails()) {
             return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
         }
         //----------------------------------------------
         Notification::where("id",$request->notification_id)->delete();
         //----------------------------------------------
         $json  = [
             "data" => null,
             "message" => "success delete",
             "status" => 200 ,
         ] ;
         return response()->json($json, 200);
     }

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

}// end class
