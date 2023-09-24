<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Traits\Upload_Files;

use App\jwtClass\AUTHORIZATION;
use App\Models\User;
use App\Models\FirebaseToken;
use App\Models\User_details;
use App\Models\User_services;
use App\Models\Confirmed_codes;

class AuthController extends Controller
{
    use Upload_Files;
    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_code' => 'required|in:+20,+966',
            'phone' => 'required|numeric',
        ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        $credentials['phone_code'] = $request->phone_code;
        $credentials['phone'] = $request->phone;
        $credentials['password'] = '123456';
        //----------------------------------
        $resultJson = ["data" => null, "message" => "", "status" => 200];
        if (!$token = Auth::attempt($credentials)) {
            $resultJson["message"] = "user phone is correct";
            $resultJson["status"] = 404;
            return response()->json($resultJson, 200);
        }
        if (auth()->user()->is_block == 'blocked') {
            $resultJson["message"] = "user is blocked";
            $resultJson["status"] = 406;
            return response()->json($resultJson, 200);
        }
        $user_info = auth()->user();
        $user_id =  $user_info->id;
        User::where("id", $user_id)->update(["is_login" => 'yes']);
        $authToken = AUTHORIZATION::generateToken(User::find($user_id));
        $userData  = User::where("id",$user_id)->with(["details","service.service_data"])->first();
        $userData->token = $authToken ;
        $resultJson["data"] = $userData;
        $resultJson["message"] = "success login ";
        return response()->json($resultJson, 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function logout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'phone_token' => 'required',
            'software_type' => 'required|in:android,ios',
        ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        $where = [
                  'user_id' => $request->user_id,
                  'phone_token' => $request->phone_token,
                  'software_type' => $request->software_type
        ];
        FirebaseToken::where($where)->delete();
        User::where("id", $request->user_id)->update(["is_login" => 'no']);
        $resultJson = ["data" => null, "message" => "success logout ", "status" => 200];
        return response()->json($resultJson, 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function getProfile(Request $request)
    {
        $user_id = (isset($request->user_id)) ? $request->user_id : 0;
        $user = User::where('id', $user_id)->first();
        if (isset($user->id)) {
            $authToken = AUTHORIZATION::generateToken($user);
            $userData  = User::where("id",$user_id)->with(["details","service.service_data"])->first();
            $userData->token = $authToken ;
            $resultJson = ["data" => $userData, "message" => "my profile", "status" =>200];
            return response()->json($resultJson, 200);
        }
        return response()->json( ["data" => null, "message" => "user not found", "status" =>404], 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function updateFirebase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'phone_token' => 'required',
            'software_type' => 'required|in:android,ios',
        ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        $resultJson = ["data" => null, "message" => "success add token", "status" => 200];
        $arr = [
            'user_id' => $request->user_id,
            'phone_token' => $request->phone_token,
            'software_type' => $request->software_type
        ];
        FirebaseToken::updateOrCreate($arr, $arr);
        $tokens = FirebaseToken::where("user_id", $request->user_id)
                               ->where("software_type", $request->software_type)->get();
        $resultJson["data"] = $tokens;
        return response()->json($resultJson, 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    private function setArrImage( $request, $data,$imgArr , $folder){
        if(!empty($imgArr)){
            foreach ($imgArr as $key=>$val){
                if ($request->hasFile($val)){
                    $data[$val]=$this->uploadFiles($folder,$request->file($val),null);
                }
            }
        }
        return $data;
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'phone_code' => 'nullable|in:+20,+966',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'logo' =>'nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
                'form_expiry_date' =>'nullable|date_format:Y-m-d',
                'insurance_expiry_date' =>'nullable|date_format:Y-m-d',
                'residency_photo' =>'nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
                'form_photo' =>'nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
                'insurance_photo' =>'nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
                'vehicle_image' =>'nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
            ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        //------------------------------------------
        if($request->email){
            $validatorSer = Validator::make($request->all(),
                [
                    'email' => Rule::unique("users")->ignore($request->user_id),
                ], []);
            if ($validatorSer->fails()) {
                $resultJson = ["data" => null, "message" =>"the email has been aready token", "status" => 406];
                return response()->json($resultJson, 200);
            }
        }
        //------------------------------------------
        if($request->phone){
            $validatorSer = Validator::make($request->all(),
                [
                    'phone' => Rule::unique("users")->ignore($request->user_id),
                ], []);
            if ($validatorSer->fails()) {
                $resultJson = ["data" => null, "message" =>"the phone has been aready token", "status" => 409];
                return response()->json($resultJson, 200);
            }
        }
        //------------------------------------------
        if($request->national_id_num){
            $userDetails = User_details::where("user_id",$request->user_id)->first();
            $validatorSer = Validator::make($request->all(),
                [
                    'national_id_num' => Rule::unique("user_details")->ignore($userDetails->id),
                ], []);
            if ($validatorSer->fails()) {
                $resultJson = ["data" => null, "message" =>"the national Id number has been aready token", "status" => 405];
                return response()->json($resultJson, 200);
            }
        }
        //------------------------------------------
        if($request->service_id){
            $validatorSer = Validator::make($request->all(),
                [
                    'service_id' => 'exists:services,id',
                ], []);
            if ($validatorSer->fails()) {
                return response()->json(['error' => collect($validatorSer->errors())->flatten(1), 'code' => 422], 422);
            }
            User_services::where("user_id",$request->user_id)->update(["service_id"=>$request->service_id]);
        }
        //===========================================================================
        $expDriverData = [
            "user_id",'national_id_num','vehicle_id_num',
            'form_expiry_date','insurance_expiry_date','service_id',
            'residency_photo','form_photo','insurance_photo','vehicle_image'
        ] ;
        $UdataObj = collect($request->all())->except($expDriverData);
        if ($UdataObj->count() > 0) {
            $Udata  = $UdataObj->toArray() ;
            $Udata  = $this->setArrImage($request,$Udata,["logo"],"users");
            User::where('id', $request->user_id)->update($Udata);
        }
        //------------------------------------------
        $expClientData = [
            "user_id",'name','service_id',"logo",'phone_code',"phone" ,
            "address" , 'latitude' , 'longitude',"email"
        ];
        $DdataObj = collect($request->all())->except($expClientData);
        if ($DdataObj->count() > 0) {
            $Ddata = $DdataObj->toArray();
            $Ddata = $this->setArrImage($request,$Ddata,['residency_photo','form_photo','insurance_photo','vehicle_image'],"users_details");
            User_details::where('user_id', $request->user_id)->update($Ddata);
        }
        //------------------------------------------
        $authToken = AUTHORIZATION::generateToken(User::find( $request->user_id));
        $userData  = User::where("id", $request->user_id)->with(["details","service.service_data"])->first();
        $userData->token = $authToken ;
        $resultJson = ["data" => $userData, "message" => "success update ", "status" => 200];
        return response()->json($resultJson, 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function registerClient(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_code' => 'required|in:+20,+966',
            'phone' => 'required|numeric',
            'logo' =>'nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
            'software_type' =>'required|in:ios,android',
        ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        $data = collect($validator->validated())->except(["logo"])->toArray();
        //===========================================
        $resultJson = ["data" => null, "message" => "", "status" => ""];
        $validator = Validator::make($request->all(), ['phone' => 'unique:users'], []);
        if ($validator->fails()) {
            $resultJson["message"] = "the phone has been aready token";
            $resultJson["status"] = 409;
            return response()->json($resultJson, 200);
        }
        //===========================================
        $data['password']=bcrypt(123456);
        $data['is_confirmed']="yes";
        if ($request->hasFile('logo')){
            $data['logo']=$this->uploadFiles('users',$request->file('logo'),null);
        }
        $user = User::create($data);
        $user_id = $user->id ;
        $authToken = AUTHORIZATION::generateToken(User::find($user_id));
        $userData  = User::where("id",$user_id)->with(["details","service.service_data"])->first();
        $userData->token = $authToken ;
        $resultJson["data"] = $userData;
        $resultJson["status"] = 200;
        return response()->json($resultJson, 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    public function registerDriver(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_code' => 'required|in:+20,+966',
            'phone' => 'required|numeric',
            'email' => 'required',
            'logo' =>'nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
            'software_type' =>'required|in:ios,android',
            'address'=>'required',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
            //--------------------------------------------------
            'service_id' => 'required|exists:services,id',
            //--------------------------------------------------
            'national_id_num' =>'required',
            'vehicle_id_num' =>'required',
            'form_expiry_date' =>'required|date_format:Y-m-d',
            'insurance_expiry_date' =>'required|date_format:Y-m-d',
            'residency_photo' =>'required|image|mimes:jpeg,jpg,png,gif|max:10000',
            'form_photo' =>'required|image|mimes:jpeg,jpg,png,gif|max:10000',
            'insurance_photo' =>'required|image|mimes:jpeg,jpg,png,gif|max:10000',
            'vehicle_image' =>'required|image|mimes:jpeg,jpg,png,gif|max:10000',
        ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        //===========================================
        $resultJson = ["data" => null, "message" => "", "status" => ""];
        $validator = Validator::make($request->all(), ['phone' => 'unique:users,phone'], []);
        if ($validator->fails()) {
            $resultJson["message"] = "the phone has been aready token";
            $resultJson["status"] = 409;
            return response()->json($resultJson, 200);
        }
        $validator = Validator::make($request->all(), ['email' => 'unique:users,email'], []);
        if ($validator->fails()) {
            $resultJson["message"] = "the email has been aready token";
            $resultJson["status"] = 406;
            return response()->json($resultJson, 200);
        }
        $validator = Validator::make($request->all(), ['national_id_num' => 'unique:user_details,national_id_num'], []);
        if ($validator->fails()) {
            $resultJson["message"] = "the national Id number has been aready token";
            $resultJson["status"] = 405;
            return response()->json($resultJson, 200);
        }
        //===========================================
        $data = [
            "name" => $request->name,
            "phone_code" => $request->phone_code,
            "phone" => $request->phone,
            "email" => $request->email,
            "software_type" => $request->software_type,
            "address" => $request->address,
            "latitude" => $request->latitude,
            "longitude" => $request->longitude,
            'password' => bcrypt(123456),
            'user_type' => "driver",
            'is_confirmed' => "new"
        ];
        if ($request->hasFile('logo')){
            $data['logo']=$this->uploadFiles('users',$request->file('logo'),null);
        }
        $user = User::create($data);
        $user_id = $user->id ;
        $authToken = AUTHORIZATION::generateToken(User::find($user_id));
        //=============================================
        User_services::create(["user_id"=>$user_id,"service_id"=>$request->service_id]);
        //=============================================
        $residency_photo = $this->uploadFiles("users_details",$request->file("residency_photo"),null);
        $form_photo = $this->uploadFiles("users_details",$request->file("form_photo"),null);
        $insurance_photo = $this->uploadFiles("users_details",$request->file("insurance_photo"),null);
        $vehicle_image = $this->uploadFiles("users_details",$request->file("vehicle_image"),null);
        $userDet = [
            "user_id"=> $user_id,
            "national_id_num"=> $request->national_id_num,
            "vehicle_id_num"=> $request->vehicle_id_num,
            "form_expiry_date"=> $request->form_expiry_date,
            "insurance_expiry_date"=> $request->insurance_expiry_date,
            "residency_photo"=> $residency_photo ,
            "form_photo"=> $form_photo ,
            "insurance_photo"=>$insurance_photo ,
            "vehicle_image"=>$vehicle_image ,
        ];
        User_details::create($userDet);
        //=============================================
        $userData  = User::where("id",$user_id)->with(["details","service.service_data"])->first();
        $userData->token = $authToken ;
        $resultJson["data"] = $userData;
        $resultJson["status"] = 200;
        return response()->json($resultJson, 200);
    }

    /**
     *  ============================================================
     *
     *  ------------------------------------------------------------
     *
     *  ============================================================
     */

    private function sendSMS($number ,$message_text ){
      // https://www.hisms.ws/api.php?send_sms&username=xx&password=xx&numbers=966xxxx,966xxx
        $user_name    = '966555240773';// "creativeshare"; //  creativeshare
        $pass         = 'Hasan1421';  //  Hyaadodo@1010
        $sender       = "Truck Trip";  //  MIZ-WORLD
        $date = date("Y-m-d", time());
        $time = date("h:i", time());
        $api_url = 'https://www.hisms.ws/api.php?send_sms&';
        $api_url .= 'username=' . $user_name;
        $api_url .= '&password=' . $pass;
        $api_url .= '&numbers=' . $number;
        $api_url .= '&sender=' .urlencode($sender) ;
        $api_url .= '&unicode=E';
        $api_url .= '&return=full';
        $api_url .= '&message=' . urlencode($message_text) . "&";
        $crl = curl_init();
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crl, CURLOPT_URL, $api_url);
        curl_setopt($crl, CURLOPT_TIMEOUT, 10);
        $reply = curl_exec($crl);
        curl_close($crl);
        return [ "reply" =>$reply/*,"url"=>$api_url*/];
    }

    public function sendConfirmCode(Request $request){
        // Confirmed_codes
        $validator = Validator::make($request->all(), [
            'phone_code' => 'required|in:+20,+966',
            'phone' => 'required|numeric',
        ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        $confirm_code  = ($request->phone_code == "+20")? "123456":sprintf("%06d",rand(0,100000));

        $obj = Confirmed_codes::updateOrCreate(
            [
                "phone_code" =>$request->phone_code ,
                "phone" => $request->phone ,
                "confirm_code" => $confirm_code,
            ]
        );
        $sms = "not send" ;
        if ($request->phone_code == "+966") {
            $sms =  $this->sendSMS("966".$request->phone, " تطبيق Truck Trip  رقم التحقق : $confirm_code"  );
        }
        $resultJson = ["data" => $obj, "message" => $sms, "status" => 200];
        return response()->json($resultJson, 200);
    }

    public function checkConfirmCode(Request $request){

        $validator = Validator::make($request->all(), [
            'phone_code' => 'required|in:966,20',
            'phone' => 'required|numeric',
            'confirm_code' => 'required',
        ], []);
        if ($validator->fails()) {
            return response()->json(['error' => collect($validator->errors())->flatten(1), 'code' => 422], 422);
        }
        $sqlCheck = Confirmed_codes::where("phone_code",$request->phone_code)
                       ->where("phone",$request->phone)
                       ->where("confirm_code",$request->confirm_code)->count();

        if($sqlCheck > 0 ){
            $resultJson = ["data" => null, "message" => "successful  code  ", "status" => 200];
            return response()->json($resultJson, 200);
        }
        $resultJson = ["data" => null, "message" => "code is correct", "status" => 404];
        return response()->json($resultJson, 200);
    }



}// end class
