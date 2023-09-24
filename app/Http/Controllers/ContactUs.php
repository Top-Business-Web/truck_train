<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\Contact_us_request;

class ContactUs extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('contact_us');
    }
    
    public function submit(Contact_us_request $request)
    {
        Contact::create([
        'name'      => $request->name,
        'phone'     => $request->phone,
        'email'     => $request->email,
        'subject'   => $request->subject,
        'message'   => $request->message,
        'status'    => 'new'
        ]);
        
        return redirect()->back()->with(['success'=>'تم إستلام الرسالة بنجاح']);
    }
}
