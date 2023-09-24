<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class Rejected_drivers extends Controller
{
    public function index()
    {
        $users = User::where([
            'is_confirmed'=>'no',
            'user_type' => 'driver'
        ])->with(['user_details', 'User_service.service_data'])->orderBy('id','DESC')->paginate(50);
        
        $output = [
            'users' => $users,
            'showActions' => false,
            
            //menu classes
            'drivers_links' => true,
            'rejectes_drivers_class' => 'm-menu__item--active',
        ];
        
        return view('Admin.deriversRequestsGrid')->with($output);
    }
}
