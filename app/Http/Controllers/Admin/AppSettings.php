<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\SettingsRequest;
use App\Traits\ImageUploading;

class AppSettings extends Controller
{
    use ImageUploading;

    public function index()
    {
        $settings  = Setting::paginate(1);
        $output = [
            'settings' => $settings,
            //menu links
            'settings_links' => true,
            'settings_class' => 'm-menu__item--active',
            ];

        return view('Admin.CRUD.AppSettings')->with($output);
    }

    public function edit($id)
    {
        $settings = Setting::findOrFail($id);
        $output = [
            'settings' => $settings,

            //menu links
            'settings_links' => true,
        ];

        return view('Admin.CRUD.EditAppSettings')->with($output);
    }

    public function update(SettingsRequest $request)
    {
        //return $request;
        $row = Setting::findOrFail($request->id);

        if($request->hasFile('image') )
        {
            $file_name = $this->UploadImage($request->image, 'setting');
        }
        else
        {
            $file_name = $row->header_logo;
        }
        //return $file_name;
        $updated_data = [
            'title' => $request->title,
            'desc' => $request->desc,
            'address1' => $request->address1,
            'phone1' => $request->phone1,
            'android_app' => $request->android_app,
            'ios_app' => $request->ios_app,
            'email1' => $request->email1,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'telegram' => $request->telegram,
            'youtube' => $request->youtube,
            'whatsapp' => $request->whatsapp,
            'about_app' => $request->about_app,
            'ar_termis_condition' => $request->ar_termis_condition,
            'en_termis_condition' => $request->en_termis_condition,
            'header_logo' => $file_name
        ];
       // return [$request->id ];
        Setting::where("id",$request->id)->update($updated_data);

        return redirect()->back()->with(['success'=>__('messages.row updated successfully')]);
    }
}
