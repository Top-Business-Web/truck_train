<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function login_form()
    {
        return view('Admin.login_form');
    }
    
    public function submit_login(Request $request)
    {
        ///validation
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        //check the admin auth
        $rememberme = request('remember_me') == 1?true:false;
        if (Auth('admin')->attempt(['email' => request('email'), 'password' => request('password')], $rememberme)) {
            return redirect('Admin/dashboard');
            
        }
        
        return redirect()->back()->with('error', __('messages.loginError'));
        
    }
    
    
}
