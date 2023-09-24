<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Traits\Upload_Files;
use App\jwtClass\AUTHORIZATION;
use App\Models\FirebaseToken;
use App\Models\User_details;
use App\Models\User_services;
use App\Models\Service;
use App\Models\Confirmed_codes;

class AdminDriversController extends Controller
{
    use Upload_Files;


    /**
     * @param Request $request
     * @return mixed
     *
     * ALl Users
     *
     *
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $users = User::where('user_type','driver')->latest()->get();

            return \DataTables::of($users)
                ->editColumn('logo', function ($user) {
                    return ' <img src="'.get_file($user->logo).'" class=" w-50 rounded" style="height:50px"
                             onclick="window.open(this.src)">';
                })
                ->editColumn('created_at', function ($user) {
                    return date('Y/m/d',strtotime($user->created_at));
                })

                ->editColumn('is_block', function ($user) {
                    $re_block = '';
                    if ($user->is_block == 'no') {
                        $re_block = '<span class="badge badge-success">مفعل</span>';
                    }else{
                        $re_block = '<span class="badge badge-danger">موقوف</span>';

                    }
                    return $re_block;
                })
                ->editColumn('user_type', function ($user) {
                    $re_write_ = '';
                    if ($user->user_type == 'client') {
                        $re_write_ = '<span class="badge badge-success">عميل</span>';
                    }
                    if ($user->user_type == 'driver') {
                        $re_write_ = '<span class="badge badge-danger">سائق</span>';

                    }

                    return $re_write_;
                })
                ->editColumn('created_at', function ($user) {
                    return date('Y/m/d',strtotime($user->created_at));
                })
                ->addColumn('delete_all', function ($user) {
                    return "<input style='width: 19px;' type='checkbox' class='form-control delete-all' name='delete_all' id='" . $user->id . "'>";
                })
                ->addColumn('actions', function ($user) {
                    $edit = route('drivers.edit',$user->id);
                    return " <a href='".$edit."'   class='btn btn-info ' attr-type='" . $user->user_type . "' id='" . $user->id . "'> <i class='fa fa-edit'></i></a>
                            <button  class='btn btn-info status' id='" . $user->id . "'> <i class='fa fa-check'></i></button>
                   <button class='btn btn-danger  delete' id='" . $user->id . "'><i class='fa fa-trash'></i> </button>";
                })->rawColumns(['actions','logo','delete_all','user_type','is_block'])->make(true);
        }


        $output    = [

            //menu links
            'drivers__links' => true,
            'all_drivers__class' => 'm-menu__item--active'
        ];
        return view('Admin.CRUD.drivers.index',$output);
    }


    /**
     * @param Request $request
     * @return mixed
     *
     * Create
     */
    public function create(Request $request)
    {
        $output = [
            'services'=>Service::get(),
            //menu links
            'drivers__links' => true,
            'add_drivers__class' => 'm-menu__item--active'
        ];
        return view('Admin.CRUD.drivers.create',$output);
    }//end fun

    public function store(Request $request)
    {
        //return response()->json($request->all(), 200);
     //   return ;
        $request->validate([
            'name' => 'required',
            'phone_code' => 'required|in:+20,+966',
            'phone' => 'required|unique:users',
            'email' => 'required|unique:users',
            'logo' =>'nullable|image|mimes:jpeg,jpg,png,gif|max:10000',
            'address'=>'required',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
            //--------------------------------------------------
            'service_id' => 'required|exists:services,id',
            //--------------------------------------------------
            'national_id_num' =>'required|unique:user_details',
            'vehicle_id_num' =>'required',
            'form_expiry_date' =>'required|date_format:Y-m-d',
            'insurance_expiry_date' =>'required|date_format:Y-m-d',
            'residency_photo' =>'required|image|mimes:jpeg,jpg,png,gif|max:10000',
            'form_photo' =>'required|image|mimes:jpeg,jpg,png,gif|max:10000',
            'insurance_photo' =>'required|image|mimes:jpeg,jpg,png,gif|max:10000',
            'vehicle_image' =>'required|image|mimes:jpeg,jpg,png,gif|max:10000',
        ]);

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
        return response()->json(1, 200);

    }//end fun


    public function edit($id ,Request $request)
    {
        $services = Service::get();
        $driver = User::findOrFail($id);
        return view('Admin.CRUD.drivers.edit',compact('services','driver'));
    }//end fun


    public function update($id,Request $request)
    {
       $request->validate([
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
       ]);
        //------------------------------------------
        if($request->email){
            $request->validate(['email' => Rule::unique("users")->ignore($request->user_id)]);
        }
        //------------------------------------------
        if($request->phone){

            $request->validate(['phone' => Rule::unique("users")->ignore($request->user_id)]);

        }
        //------------------------------------------
        if($request->national_id_num){
            $userDetails = User_details::where("user_id",$request->user_id)->first();
            $request->validate([ 'national_id_num' => Rule::unique("user_details")->ignore($userDetails->id)]);
        }
        //------------------------------------------
        if($request->service_id){
            $request->validate(['service_id' => 'exists:services,id',]);
            User_services::where("user_id",$request->user_id)->update(["service_id"=>$request->service_id]);
        }
        //===========================================================================
        $expDriverData = [
            "user_id",'national_id_num','vehicle_id_num',
            'form_expiry_date','insurance_expiry_date','service_id',
            'residency_photo','form_photo','insurance_photo','vehicle_image','_token','_method'
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
            "address" , 'latitude' , 'longitude',"email",'_token','_method'
        ];
        $DdataObj = collect($request->all())->except($expClientData);
        if ($DdataObj->count() > 0) {
            $Ddata = $DdataObj->toArray();
            $Ddata = $this->setArrImage($request,$Ddata,['residency_photo','form_photo','insurance_photo','vehicle_image'],"users_details");
            User_details::where('user_id', $request->user_id)->update($Ddata);
        }
        //------------------------------------------
        $userData  = User::where("id", $request->user_id)->with(["details","service.service_data"])->first();
        $resultJson = ["data" => $userData, "message" => "success update ", "status" => 200];
        return response()->json($resultJson, 200);
    }

    /**
     * @param $id
     * @return mixed
     *
     * Delete Single Driver Model
     *
     */
    public function destroy($id)
    {
        return response()->json(User::destroy($id),200);
    }


    /**
     * @param $id
     * @return mixed
     *
     * Change Status of Driver
     *
     */
    public function changeBlock($id)
    {
        $row = User::findOrFail($id);
        $status = $row->is_block == 'yes'?'no':'yes';
        $row->update(['is_block' => $status]);
        return response()->json(1,200);
    }


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

    //==================== Helper =========================


}//end class
