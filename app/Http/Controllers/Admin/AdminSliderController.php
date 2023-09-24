<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Traits\ImageUploading;


class AdminSliderController extends Controller{

    use ImageUploading;


    public function index(){
        $sliders = Slider::where('type','global')->latest()->get();

        $output = [
            'sliders' => $sliders,
            //menu links
            'settings_links' => true,
            'slider_class' => 'm-menu__item--active',
        ];


        return view('Admin/CRUD/Slider/index')->with($output);
    }//end fun


    public function store(Request $request){
        if ($request->image != ''){
            $data['image'] = $this->UploadImage($request->image, 'slider');

            $data['type'] = 'global';

            Slider::create($data);

            return back()->with(['success'=>__('messages.row added successfully')]);

        }else{
            return back()->with(['error'=>__('messages.imageRequired')]);
        }
    }

    public function show($id){
        Slider::destroy($id);

        return back()->with(['success'=>__('messages.row deleted successfully')]);
    }

}//end class
