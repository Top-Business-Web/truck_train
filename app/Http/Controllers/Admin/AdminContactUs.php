<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Yajra\DataTables\DataTables;

class AdminContactUs extends Controller
{
    public function index(Request $request)
    {
        
        $data = Contact::get();
        
        if($request->ajax()){
        
            return DataTables::of($data)
                
                ->addColumn('status', function ($data) {
                    if($data->status == 'new')
                        $status = '<span class="badge badge-success"> جديد</span>';
                    else
                        $status = '<span class="badge badge-warning">قديم</span>';
                    
                    return $status;
                })
                ->addColumn('message', function ($data) {
                    
                    return substr($data->message, 0, 150);
                })
                ->addColumn('actions', function($data){
                    $link = '<a href="'.route('MessageDetails', $data->id).'" class="btn btn-info">تفاصيل الرسالة</a>';
                    return $link;
                })
                
                ->rawColumns(['actions', 'status'])->make(true);
        
        }
        
        $output = [
            
            'page_title' => 'رسائل اتصل بنا',
            'route_url'  => route('Contact_us_messages'),
            
            //menu links
            'contact_links' => true,
            'contact_class' => 'm-menu__item--active'
            ];
            
        return view('Admin.CRUD.Contact_us')->with($output);
    
    }
    
    public function message_details($msg_id)
    {
        $messsage_details = Contact::findOrFail($msg_id);
        
        $messsage_details->update(['status'=>'old']);
        
        $output = [
            'msg_data'   => $messsage_details,
            
            'page_title' => 'تفاصيل الرسالة',
            'route_url'  => route('Contact_us_messages'),
            
            //menu links
            'contact_links' => true,
            'contact_class' => 'm-menu__item--active'
            ];
        
        return view('Admin.CRUD.Contact_us_details')->with($output);
    }
    
    
    
    
    
    
    
   


}
