<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


use App\Models\Notification;
use App\Models\Offer;
use App\Models\Order;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Traits\Api\FireBase;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\queue;


class OfferController extends Controller
{
    use FireBase;
    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function create(Request $request ){
        $validator = Validator::make($request->all(),
            [
                'driver_id' => 'required|exists:users,id',
                'client_id' => 'required|exists:users,id',
                'order_id' => 'required|exists:orders,id',
                'offer_value' => 'required|numeric',
            ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        //----------------------------------------------
        $where = [
            "from_user_id"=>$request->client_id,
            "to_user_id"=>$request->driver_id,
            "order_id"=>$request->order_id,
            "action"=>"make_offer"
        ];
        Notification::where($where)->update(["action"=>"nothing"]);
        //----------------------------------------------
        $order = Order::where("id",$request->order_id)->first();
        if(!isset($order->order_status) || $order->order_status != "new_order" ){
            $json  = ["data" => null, "message" => "order is canceled", "status" => 201] ;
            return response()->json($json, 200);
        }
        //----------------------------------------------
        $offerData = collect($validator->validated())->toArray() ;
        $offerData["offer_time"] = time() ;
        $offer = Offer::create($offerData);
        //----------------------------------------------
        $note = [
            "from_user_id" => $request->driver_id,
            "to_user_id" => $request->client_id ,
            "order_id" => $request->order_id ,
            "title" => "Truck Trip" ,
            "title_en" => "Truck Trip ",
            "message" => "لديك عرض جديد ",
            "message_en" => "You have a new offer",
            "action" => "accept_refuse_offer",
            "notification_date"=> time()
        ];
        Notification::create($note);
        $note = $this->sendNotificatios([$request->client_id],$note,"offer");
        return response()->json(["data" => $offer,"message" => "success send offer","status" => 200,"note"=>$note], 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function resend(Request $request ){
        $validator = Validator::make($request->all(),
            [
                'driver_id' => 'required|exists:users,id',
                'client_id' => 'required|exists:users,id',
                'order_id' => 'required|exists:orders,id',
                'offer_value' => 'required|numeric',
            ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        //----------------------------------------------
        $where = [
            "from_user_id"=>$request->client_id,
            "to_user_id"=>$request->driver_id,
            "order_id"=>$request->order_id,
            "action"=>"resend_offer"
        ];
        Notification::where($where)->update(["action"=>"nothing"]);
        //----------------------------------------------
        $order = Order::where("id",$request->order_id)->first();
        if(!isset($order->order_status) || $order->order_status != "new_order" ){
            $json  = ["data" => null, "message" => "order is canceled", "status" => 201] ;
            return response()->json($json, 200);
        }
        //----------------------------------------------
        $offerData = collect($validator->validated())->toArray() ;
        $offerData["offer_time"] = time() ;
        $offer = Offer::create($offerData);
        //----------------------------------------------
        $note = [
            "from_user_id" => $request->driver_id,
            "to_user_id" => $request->client_id ,
            "order_id" => $request->order_id ,
            "title" => "Truck Trip" ,
            "title_en" => "Truck Trip ",
            "message" => "لديك عرض جديد ",
            "message_en" => "You have a new offer",
            "action" => "accept_refuse_offer",
            "notification_date"=> time()
        ];
        Notification::create($note);
        $note = $this->sendNotificatios([$request->client_id],$note,"offer");
        return response()->json(["data" => $offer,"message" => "success send offer","status" => 200,"note"=>$note], 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function driverRefuseSendOffer(Request $request){
        $validator = Validator::make($request->all(),
            [
                'driver_id' => 'required|exists:users,id',
                'client_id' => 'required|exists:users,id',
                'order_id' => 'required|exists:orders,id',
            ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        //----------------------------------------------
        $where = [
            "from_user_id"=>$request->client_id,
            "to_user_id"=>$request->driver_id,
            "order_id"=>$request->order_id,
        ];
        Notification::where($where)->whereIn('action',["make_offer","resend_offer"])->update(["action"=>"nothing"]);
        //----------------------------------------------
        $order = Order::where("id",$request->order_id)->first();
        if(!isset($order->order_status) || $order->order_status != "new_order" ){
            $json  = ["data" => null, "message" => "order is canceled", "status" => 201] ;
            return response()->json($json, 200);
        }
        //----------------------------------------------
        $driverCount = Notification::where('order_id',$request->order_id)
                    ->whereIn('action',["make_offer","resend_offer"])
                    ->count();
        $note = [] ;
        if($driverCount == 0){
            $note = [
                "from_user_id" => $request->driver_id,
                "to_user_id" => $request->client_id ,
                "order_id" => $request->order_id ,
                "title" => "Truck Trip" ,
                "title_en" => "Truck Trip ",
                "message" => "تم رفض الطلب من كافة المناديب   ",
                "message_en" => "The order was rejected by all delegates",
                "action" => "nothing",
                "notification_date"=> time()
            ];
            Notification::create($note);
            Order::where("id",$order->id)->update(["order_status"=>"all_drivers_refuse"]);
            $note = $this->sendNotificatios([$request->client_id],$note,"order");
        }
        $json  = [
            "data" => null,
            "message" => "success refuse to send offer ",
            "status" => 200 ,
            "note" => $note
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

    public function showDriversOffer(Request $request){
        $user_id = ($request->user_id)? $request->user_id:0;
        $order_id = ($request->order_id)? $request->order_id:"all";
        $latitude = ($request->latitude)? $request->latitude:0;
        $longitude = ($request->longitude)? $request->longitude:0;
        $pagination_status = (isset($request->pagination))? $request->pagination:"off";
        $limit_per_page = (isset($request->limit_per_page))? $request->limit_per_page:"20";
        //===============================================
        $query  = Offer::where("client_id",$user_id)
             ->where("status","new")
             ->with(['driver'=>function($query) use ($latitude ,$longitude ){
                 return  $query->select(DB::raw(" * ,
                    ( 3959 * acos( cos( radians(" . $latitude . ") ) * cos( radians( latitude ) ) *
                      cos( radians( longitude ) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) *
                      sin( radians( latitude ) ) ) ) AS distance"));
             }]) ;
        //----------------------
        if ($request->order_id != "all") {
            $query = $query->where("order_id", $order_id);
        }
        $query = $query->orderBy("id","ASC");
        if ($pagination_status == 'on') {
            $data = $query->paginate($limit_per_page);
            $json = collect(["message" => "my offers","status" => 200]) ;
            $json =  $json->merge($data);
            return response()->json($json, 200);
        }

        return response()->json(["data" => $query->get(),"message" => "my offers",  "status" => 200], 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function filterShowDriversOffer(Request $request){
        $user_id = ($request->user_id)? $request->user_id:0;
        $filter_type = ($request->filter_type)? $request->filter_type:"closest";  // closest lowest_price
        $latitude = ($request->latitude)? $request->latitude:0;
        $longitude = ($request->longitude)? $request->longitude:0;
        if($filter_type == "closest"){
            $drivers_id =  Offer::where("client_id",$user_id)->where("status","new")->groupBy("driver_id")->get()->pluck("driver_id");



        }
    }
    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function clientRefuseOffer(Request $request){
        $validator = Validator::make($request->all(),
            [
                'driver_id' => 'required|exists:users,id',
                'client_id' => 'required|exists:users,id',
                'order_id' => 'required|exists:orders,id',
                'offer_id' => 'required|exists:offers,id',
                'action' => 'required|in:refuse,less_offer',
            ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        //----------------------------------------------
        $order = Order::where("id",$request->order_id)->first();
        if(!isset($order->order_status) || $order->order_status != "new_order" ){
            $json  = ["data" => null, "message" => "order is canceled", "status" => 201] ;
            return response()->json($json, 200);
        }
        //----------------------------------------------
        Offer::where("id",$request->offer_id)->update(["status"=>$request->action]);
        $offer = Offer::where("id",$request->offer_id)->first();
        //----------------------------------------------
        if($request->action == "refuse"){
            $message = "تم رفض عرضك";
            $message_en = "Your offer was rejected";
            $action = "nothing";
        }
        else{
            $message = "قم بارسال عرض اقل من " . $offer->offer_value;
            $message_en = "Submit an offer less than ". $offer->offer_value;
            $action = "resend_offer";
        }
        $note = [
            "from_user_id" => $request->client_id,
            "to_user_id" => $request->driver_id ,
            "order_id" => $request->order_id ,
            "offer_id" => $request->offer_id ,
            "title" => "Truck Trip" ,
            "title_en" => "Truck Trip ",
            "message" => $message,
            "message_en" => $message_en,
            "action" => $action,
            "notification_date"=> time()
        ];
        Notification::create($note);
        $note = $this->sendNotificatios([$request->driver_id],$note,"order");
        //--------------------------------------------
        $driverCount = Notification::where('order_id',$request->order_id)
            ->whereIn('action',["make_offer","resend_offer"])
            ->count();
        if($driverCount == 0){
            Order::where("id",$order->id)->update(["order_status"=>"client_refuse_all_offers"]);
            $json  = ["data" => null, "message" => "You rejected all delegates",  "status" => 202,"note"=>$note ] ;
            return response()->json($json, 200);
        }
        $json  = ["data" => null, "message" => "Success refuse delegates", "status" => 200,"note"=>$note ] ;
        return response()->json($json, 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function clientAcceptOffer(Request $request){
        $validator = Validator::make($request->all(),
            [
                'driver_id' => 'required|exists:users,id',
                'client_id' => 'required|exists:users,id',
                'order_id' => 'required|exists:orders,id',
                'offer_id' => 'required|exists:offers,id',
            ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        //----------------------------------------------
        $order = Order::where("id",$request->order_id)->first();
        if(!isset($order->order_status) || $order->order_status != "new_order" ){
            $json  = ["data" => null, "message" => "order is canceled", "status" => 201] ;
            return response()->json($json, 200);
        }
        //----------------------------------------------
        $otherDriver = Offer::where("id","!=",$request->offer_id)
            ->where("order_id",$request->order_id)
            ->where("driver_id","!=",$request->driver_id)
            ->whereIn("status",["new","less_offer"])->get()->pluck("driver_id");

        Offer::where("id","!=",$request->offer_id)
             ->where("order_id",$request->order_id)
             ->whereIn("status",["new","less_offer"])
             ->update(["status"=>"not_use"]);

        Offer::where("id",$request->offer_id)->update(["status"=>"accept"]);
        $offer = Offer::where("id",$request->offer_id)->first();
        //-------------------------------------------------
        Order::where("id",$request->order_id)
            ->update(
                [
                    "driver_id"=>$request->driver_id,
                    "order_status"=>"client_select_driver",
                    "order_price"=>$offer->offer_value
                ]
            );
        $note = [
            "from_user_id" => $request->client_id,
            "to_user_id" => $request->driver_id ,
            "order_id" => $request->order_id ,
            "offer_id" => $request->offer_id ,
            "title" => "Truck Trip" ,
            "title_en" => "Truck Trip ",
            "message" => "تم قبول عرضك ",
            "message_en" => "Your offer has been accepted",
            "action" => "nothing",
            "notification_date"=> time()
        ];
        Notification::create($note);
        $note[] = $this->sendNotificatios([$request->driver_id],$note,"order");
        if (!empty($otherDriver)) {
            $note[] = $this->sendToOtherDrivers($otherDriver,$request);
        }
        //-------------------------------------------------
        $json  = ["data" => null, "message" => "Success accept delegates","note"=>$note, "status" => 200] ;
        return response()->json($json, 200);
    }

    private function sendToOtherDrivers($drivers,$request){
        $note = [
            "from_user_id" => $request->client_id,
            "to_user_id" => $request->driver_id ,
            "order_id" => $request->order_id ,
            "offer_id" => $request->offer_id ,
            "title" => "Truck Trip" ,
            "title_en" => "Truck Trip ",
            "message" => "تم قبول عرض مندوب اخر ",
            "message_en" => "Another delegate's offer was accepted",
            "action" => "nothing",
            "notification_date"=> time()
        ];
       return $this->sendNotificatios($drivers,$note,"order");
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

}// end class
