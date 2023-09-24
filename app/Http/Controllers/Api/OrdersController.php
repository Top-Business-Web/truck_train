<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Comment;
use App\Models\Offer;
use App\Models\Order;
use App\Models\User;
use App\Models\General_setting;
use App\Models\Notification;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Traits\Upload_Files;
use App\Http\Traits\Api\FireBase;
use Illuminate\Support\Facades\DB;


class OrdersController extends Controller
{
    use Upload_Files;
    use FireBase;
    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function create(Request $request){
        $validator = Validator::make($request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'service_id' => 'required|exists:services,id',
                'order_time' => 'required|date_format:H:i',
                'order_date' => 'required|date_format:Y-m-d',
                'details' => 'nullable',
                'phone' => 'nullable',
                'from_address' => 'required',
                'from_latitude' => 'required|numeric',
                'from_longitude' => 'required|numeric',
                'to_address' => 'required',
                'to_latitude' => 'required|numeric',
                'to_longitude' => 'required|numeric',
                'distance' => 'required|numeric',
            ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        $data = collect($validator->validated())->toArray();
        $oneOrder = Order::create($data);
        $order_id =  $oneOrder->id ;
        //--------------------------------------
        $clientObj = User::where("id", $request->user_id)->first();
        $note =  $this->findDrivers($oneOrder,$clientObj);
        //--------------------------------------
        $Uorder["order_code"] = 'TRU-' . sprintf('%05u', rand(0, 99999)) . $order_id;
        Order::where('id', $order_id)->update($Uorder);
        //--------------------------------------
        $orderData = Order::where("id", $order_id)->first();
        $message = "success create ";
        $status = 200;
        if(($orderData->order_status != "new_order")){
            $message .= " and the are no drivers";
            $status = 201;
        }
        $json  = [
            "data" => $orderData,
            "message" => $message,
            "status" => $status ,
            "note" => $note
        ] ;
        return response()->json($json, 200);
    }

    private function findDrivers($orderObj , $clientObj )
    {
        $general = General_setting::where("key_setting", "distance")->first();
        $distanceGeneral = (isset($general->value)) ? $general->value : 0;
        $lat  =  $orderObj->from_latitude ;
        $long =  $orderObj->from_longitude ;
        $service_id = $orderObj->service_id ;
        $drivers = User::select(DB::raw(" id , longitude , latitude ,
                    ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( latitude ) ) *
                      cos( radians( longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) *
                      sin( radians( latitude ) ) ) ) AS distance"))
            ->where("id", "!=", $clientObj->id)
            ->where("phone_code", $clientObj->phone_code)
            ->where("user_type", 'driver')
            ->where("is_confirmed", 'yes')
            ->where("is_block", 'no')
            ->whereHas("service",function ($query) use ($service_id) {
                $query->where("service_id",$service_id);
            })
            ->having('distance', '<=', $distanceGeneral)
            ->get();
        if ($drivers->count() > 0) {
            $driverIds = [] ;
            foreach ($drivers as $one) {
                $note["from_user_id"] = $clientObj->id;
                $note["to_user_id"] = $one->id;
                $note["order_id"] = $orderObj->id;
                $note["title"] = 'Truck Trip';
                $note["title_en"] = 'Truck Trip';
                $note["message"] = 'لديك طلب  جديد ';
                $note["message_en"] = 'You have a new  order';
                $note["action"] = 'make_offer';
                $note["notification_date"] = time();
                Notification::create($note);
                $driverIds[] = $one->id;
            }
            $noteResult =  $this->sendNotificatios($driverIds,$note ,"order");
            return ["drivers"=>$drivers,"note"=>$noteResult];
        }
        Order::where("id",$orderObj->id)->update(["order_status"=>'drivers_not_found']);
        return [];
        //return response()->json(["data"=>$drivers,"lat"=>$lat,"long"=>$long], 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function driverNewOrders(Request $request){
        $user_id = ($request->user_id)? $request->user_id:0;
        $pagination_status = (isset($request->pagination))? $request->pagination:"off";
        $limit_per_page = (isset($request->limit_per_page))? $request->limit_per_page:"20";
        //===============================================
        $query = Notification::where("to_user_id",$user_id)
                    ->whereIn("action",["make_offer","resend_offer"])
                    ->with(['order','offer','order.client'])->orderBy("id","DESC");
        //-------------------------------------
        if ($pagination_status == 'on') {
            $data = $query->paginate($limit_per_page);
            $json = collect(["message" => "my orders","status" => 200]) ;
            $json =  $json->merge($data);
            return response()->json($json, 200);
        }
        return response()->json(["data" => $query->get(),"message" => "my orders",  "status" => 200], 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function getOneOrder(Request $request){
        $order_id = ($request->order_id)? $request->order_id:0;
        $orderData = Order::where("id", $order_id)
                     ->with(["client",'driver','service'])
                    ->first();
        $json  = [
            "data" => $orderData,
            "message" => "get one order",
            "status" => 200
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

    public function changeOrderStatus(Request $request){
        $validator = Validator::make($request->all(),
            [
                'driver_id' => 'required|exists:users,id',
                'client_id' => 'required|exists:users,id',
                'order_id' => 'required|exists:orders,id',
                'order_status' => 'required|in:shipment_order,delivery_order,end_delivered',
            ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        //----------------------------------------------
        Order::where("id",$request->order_id)->update(["order_status"=>$request->order_status]);
        $order = Order::where("id",$request->order_id)->with(["client",'driver','service'])->first();
        //--------------------------------------------
        switch ($request->order_status){
            case "shipment_order":
                $message = "يتم الان التوجه الي تحميل طلبك";
                $message_en = "We are now going to download your application";
                $action = "nothing";
                break;
            case "delivery_order":
                $message = "تم التحميل وجاري التوصيل في الطريق الي الوجهه المحدده";
                $message_en = "The download has been completed and the delivery is in progress on the way to the specified destination";
                $action = "nothing";
                break;
            case "end_delivered":
                $message = "تم التوصيل قم بتقييم المندوب";
                $message_en = "Delivered, rate the delegate";
                $action = "rate_driver";
                break;
        }
        $note = [
            "from_user_id" => $request->driver_id,
            "to_user_id" => $request->client_id ,
            "order_id" => $request->order_id ,
            "title" => "Truck Trip" ,
            "title_en" => "Truck Trip ",
            "message" => $message,
            "message_en" => $message_en,
            "action" => $action,
            "notification_date"=> time()
        ];
        Notification::create($note);
        $note = $this->sendNotificatios([$request->client_id],$note,"order");
        $json  = [
            "data" => $order,
            "message" => "success action ",
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

    public function clientOrders(Request $request){
        $user_id = ($request->user_id)? $request->user_id:0;
        $type = ($request->type)? $request->type:"all";
        $pagination_status = (isset($request->pagination))? $request->pagination:"off";
        $limit_per_page = (isset($request->limit_per_page))? $request->limit_per_page:"20";
        //==============================================
        $order_status = [
            "drivers_not_found","all_drivers_refuse",
            "client_refuse_all_offers","client_rate_driver",
            "new_order","client_select_driver","shipment_order",
            "delivery_order","end_delivered"
        ];
        if($type == "current"){
                $order_status = [
                    "new_order","client_select_driver","shipment_order",
                    "delivery_order","end_delivered"
                ];
        }
        elseif ($type == "old"){
            $order_status = [
                "drivers_not_found","all_drivers_refuse",
                "client_refuse_all_offers","client_rate_driver"
            ];
        }
        $query = Order::where("user_id" , $user_id)
                      ->whereIn("order_status",$order_status)
                      ->with(["client",'driver','service'])->orderBy("id","DESC");
        if ($pagination_status == 'on') {
            $data = $query->paginate($limit_per_page);
            $json = collect(["message" => "my orders","status" => 200]) ;
            $json =  $json->merge($data);
            return response()->json($json, 200);
        }
        return response()->json(["data" => $query->get(),"message" => "my orders",  "status" => 200], 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function driverOrders(Request $request){
        $user_id = ($request->user_id)? $request->user_id:0;
        $type = ($request->type)? $request->type:"all";
        $pagination_status = (isset($request->pagination))? $request->pagination:"off";
        $limit_per_page = (isset($request->limit_per_page))? $request->limit_per_page:"20";
        //==============================================
        $order_status = [
            "drivers_not_found","all_drivers_refuse",
            "client_refuse_all_offers","client_rate_driver",
            "new_order","client_select_driver","shipment_order",
            "delivery_order","end_delivered"
        ];
        if($type == "current"){
            $order_status = [
                "new_order","client_select_driver","shipment_order",
                "delivery_order"
            ];
        }
        elseif ($type == "old"){
            $order_status = [
                "drivers_not_found","all_drivers_refuse","end_delivered" ,
                "client_refuse_all_offers","client_rate_driver"
            ];
        }
        $query = Order::where("driver_id" , $user_id)
            ->whereIn("order_status",$order_status)
            ->with(["client",'driver','service'])->orderBy("id","DESC");
        if ($pagination_status == 'on') {
            $data = $query->paginate($limit_per_page);
            $json = collect(["message" => "my orders","status" => 200]) ;
            $json =  $json->merge($data);
            return response()->json($json, 200);
        }
        return response()->json(["data" => $query->get(),"message" => "my orders",  "status" => 200], 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function cancelOrder(Request $request){
        $validator = Validator::make($request->all(),
            [
                'client_id' => 'required|exists:users,id',
                'order_id' => 'required|exists:orders,id',
            ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        //----------------------------------------------
        Order::where("id",$request->order_id)->update(["order_status"=>"client_cancel_order"]);
        $order = Order::where("id",$request->order_id)->first();
        $drivres = Offer::where("order_id",$request->order_id)
                        ->whereIn("status",["new","accept","less_offer"])
                        ->get();
        Offer::where("order_id",$request->order_id)
             ->whereIn("status",["new","less_offer"])
             ->update(["status"=>"not_use"]);
        Notification::where("order_id",$request->order_id)->update(["action"=>"nothing"]);
        //-----------------------------------------------
        $noteResult = [] ;
        if($drivres->count() > 0 ){
            $drivres = $drivres->pluck("driver_id");
            foreach ($drivres as $key=>$val ) {
                $note = [
                    "from_user_id" => $order->user_id,
                    "to_user_id" => $val,
                    "order_id" => $order->id,
                    "title" => "Truck Trip",
                    "title_en" => "Truck Trip ",
                    "message" => "تم الغاء الطلب ",
                    "message_en" => "the order has been canceled",
                    "action" => "nothing",
                    "notification_date" => time()
                ];
                Notification::create($note);
            }
            $noteResult = $this->sendNotificatios($drivres,$note,"order");
        }
        return response()->json(["data" => null,"message" => "order canceled",  "status" => 200 , "note"=>$noteResult], 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function driverCancelOrder(Request $request){
        $validator = Validator::make($request->all(),
            [
                'driver_id' => 'required|exists:users,id',
                'order_id' => 'required|exists:orders,id',
            ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        //----------------------------------------------
        Order::where("id",$request->order_id)->update(["order_status"=>"driver_cancel_order"]);
        $order = Order::where("id",$request->order_id)->first();
       /*
       $drivres = Offer::where("order_id",$request->order_id)
                        ->whereIn("status",["new","accept","less_offer"])
                        ->get();
        Offer::where("order_id",$request->order_id)
             ->whereIn("status",["new","less_offer"])
             ->update(["status"=>"not_use"]);
       */
        Notification::where("order_id",$request->order_id)->update(["action"=>"nothing"]);
        //-----------------------------------------------
        $noteResult = [] ;
        $note = [
            "from_user_id" => $order->driver_id,
            "to_user_id" => $order->user_id,
            "order_id" => $order->id,
            "title" => "Truck Trip",
            "title_en" => "Truck Trip ",
            "message" => "تم الغاء الطلب من قبل السائق قم بارسال طلب جديد ",
            "message_en" => "The request has been canceled by the driver. Submit a new request",
            "action" => "nothing",
            "notification_date" => time()
        ];
        Notification::create($note);
        $noteResult = $this->sendNotificatios([$order->user_id],$note,"order");
        return response()->json(["data" => null,"message" => "order canceled",  "status" => 200 , "note"=>$noteResult], 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function clientRateDriver(Request $request){
        $validator = Validator::make($request->all(),
            [
                'driver_id' => 'required|exists:users,id',
                'client_id' => 'required|exists:users,id',
                'order_id' => 'required|exists:orders,id',
                'comment' => 'nullable',
                'rate' => 'required|numeric',
            ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        //----------------------------------------------
        Order::where("id",$request->order_id)->update(["order_status"=>"client_rate_driver"]);
        //----------------------------------------------
        $data = Comment::create([
            "order_id"=>$request->order_id ,
            "driver_id"=>$request->driver_id ,
            "user_id"=>$request->client_id ,
            "comment"=>$request->comment ,
            "rate"=>$request->rate ,
        ]);
        //--------------------------------------------
        $sum  = Comment::where("driver_id",$request->driver_id)->get() ;
        $rate = round( $sum->sum("rate") / $sum->count() , 2) ;
        User::where("id",$request->driver_id)->update(["rate"=>$rate]);
        //--------------------------------------------
        $note = [
            "from_user_id" => $request->client_id,
            "to_user_id" => $request->driver_id,
            "order_id" => $request->order_id,
            "title" => "Truck Trip",
            "title_en" => "Truck Trip ",
            "message" => "قام العميل بتقييمك : ".round($request->rate,2)." نجوم ",
            "message_en" => "The customer has rated you :".round($request->rate,2)." stars",
            "action" => "nothing",
            "notification_date" => time()
        ];
        Notification::create($note);
        $noteResult = $this->sendNotificatios([$request->driver_id], $note, "rate");
        return response()->json(["data" => $data,"message" => "client rate order ",  "status" => 200 , "note"=>$noteResult], 200);
    }

}// end class
