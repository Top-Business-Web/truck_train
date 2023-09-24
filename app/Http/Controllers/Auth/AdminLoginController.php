<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;

class AdminLoginController extends Controller
{
    
    use SendsPasswordResetEmails;
    use ResetsPasswords;
    
    //
    public function AdminLoginForm()
    {
        if (!auth('admin')->check()){
            return view('auth.login');
        }
        return redirect()->route('dashboard');
    }
    
    public function AdminDoLogin(Request $request)
    {
        //validation        
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {

            //return redirect()->intended('/admin');
             return view('Admin.dashboard');
        }
        //return back()->withInput($request->only('email'));
        return 'not admin';
    }
}
