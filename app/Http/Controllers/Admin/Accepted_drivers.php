<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class Accepted_drivers extends Controller
{
    public function index()
    {
        $users = User::where([
            'is_confirmed'=>'yes',
            'user_type' => 'driver'
        ])->with(['user_details', 'User_service.service_data'])->paginate(50);
//return $users;
        //return $users;
        $output = [
            'users' => $users,
            'showActions' => false,
            'show_rate' => true,

            //menu classes
            'drivers_links' => true,
            'accepted_drivers_class' => 'm-menu__item--active'
        ];

        return view('Admin.deriversRequestsGrid')->with($output);
    }

    public function driverRateDetails($driver_id)
    {
        $driver_data = User::findOrFail($driver_id);
        $driver_data = User::with(['driver_rates.user_data'])->find($driver_id);
        //return $driver_data;
        $rates = $driver_data->driver_rates;
        //return $rates;
        $output = [
            'rates' => $rates
        ];

        return view('Admin.CRUD.driverRates')->with($output);
    }

    public function blockDriver($driver_id)
    {
        $driver_data = User::findOrFail($driver_id);

        $driver_data->update(['is_block' => 'yes']);

        return redirect()->back()->with(['success'=>__('messages.row updated successfully')]);
    }

    public function unblockThisDriver($driver_id)
    {
        $driver_data = User::findOrFail($driver_id);

        $driver_data->update(['is_block' => 'no']);

        return redirect()->back()->with(['success'=>__('messages.row updated successfully')]);
    }


}
