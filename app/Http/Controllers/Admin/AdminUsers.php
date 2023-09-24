<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Requests\AdminsRequest;
use Illuminate\Support\Facades\Hash;
use App\Traits\ImageUploading;

class AdminUsers extends Controller
{
    //
    use ImageUploading;

    public function index()
    {
        $users  = Admin::paginate(10);
        $output = [
                    'users'=> $users,
                    'admins_atcive_class' => 'm-menu__item--active',
                    'users_links' => true
                  ];

        return view('Admin.CRUD.AllUsers')->with($output);
    }

    public function add()
    {
        $output = [
                    'add_admins_atcive_class' => 'm-menu__item--active',
                    'users_links' => true
                  ];

        return view('Admin.CRUD.addAdminUserForm')->with($output);
    }

    public function create(AdminsRequest $request)
    {
        //return $request->logo;
        $file_name = $this->UploadImage($request->logo, 'admins');


        Admin::create([
            'name' => $request->name,
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'logo' => $file_name
        ]);

        return redirect('Admin/AllUsers')->with(['success'=>__('messages.row added successfully')]);
    }

    public function edit($adminId)
    {
        $user = Admin::findOrFail($adminId);

        $output = [
                    'user' => $user,
                    'users_links' => true
                  ];

        return view('Admin.CRUD.editAdminUserForm')->with($output);

    }

    public function update(AdminsRequest $request)
    {
        $user = Admin::FindOrFail($request->id);

        if(isset($request->logo))
        {
            $file_name = $this->UploadImage($request->logo, 'admins');
        }
        else
        {
            $file_name = $user->logo;
        }

        $updated_data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'logo' => $file_name
        ];

        if(isset($request->password))
        {
            $updated_data['password'] = Hash::make($request->password);
        }


        $user->update($updated_data);

        return redirect('Admin/AllUsers')->with(['success'=>__('messages.row updated successfully')]);
    }

    public function delete($id)
    {
        $user = Admin::FindOrFail($id);
        $user->delete();

        return redirect('Admin/AllUsers')->with(['success'=>__('messages.row deleted successfully')]);
    }


    public function search(Request $request) {
        $user  = $request->input('user_id');
        $phone = $request->input('phone_num');
//            dd($user);
        $users  = Admin::query()
            ->where('id' ,$user)
            ->orWhere('phone',$phone)
            ->paginate(10);
        $output = [
            'users'=> $users,
            'admins_atcive_class' => 'm-menu__item--active',
            'users_links' => true
        ];

        return view('Admin.CRUD.AllUsers')->with($output);
    }


}
