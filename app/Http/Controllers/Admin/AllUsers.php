<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class AllUsers extends Controller
{
     public function index()
     {

        $users  = User::whereIn('user_type', ['client','driver'])->paginate(10);
        $output = [
                    'users'=> $users,
                    'users_atcive_class' => 'm-menu__item--active',
                    'users_links_users' => true
                  ];

        return view('Admin.CRUD.AllRegisteredUsers')->with($output);
     }

     public function deleteUser($id)
     {
         User::findOrFail($id)->delete();
         return response()->json(1,200);
     }

     public function indexDT(Request $request)
    {

        if ($request->ajax()) {

            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('users');
    }
}
