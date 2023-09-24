<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DriversRequests extends Controller
{
    public function index()
    {
        $users = User::where([
            'is_confirmed'=>'new',
            'user_type' => 'driver'
        ])->with(['user_details', 'User_service.service_data'])->orderBy('id','DESC')->paginate(50);

        $output = [
            'users' => $users,
            'showActions' => true,

            //menu classes
            'drivers_links' => true,
            'all_drivers_class' => 'm-menu__item--active',

        ];

        return view('Admin.deriversRequestsGrid')->with($output);
    }

    public function refuseDriver(Request $request)
    {

        $user = User::findOrFail($request->driver_id);

        $user->update([
            'refuse_reason'=> $request->reason,
            'is_confirmed' => 'no'
            ]);
        return redirect()->back()->with(['success'=>__('messages.driver refused successfully')]);
    }

    public function approveDriver($driver_id)
    {
        $driver_data = User::findOrFail($driver_id);

        $driver_data->update([
            'is_confirmed' => 'yes'
        ]);
        //return $driver_data;

        return redirect()->back()->with(['success'=>__('messages.driver approved successfully')]);
    }
    public function DeleteReq(Request $request , $id){
        $user = User::findOrFail($id);
//        dd($user);
        $user->delete();
        return redirect()->route('AllAcceptedDrivers');
    }
}
