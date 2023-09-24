<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Traits\ImageUploading;
use App\Http\Requests\ServicesRequest;

class AdminServices extends Controller
{
    use ImageUploading;

    public function index()
    {
        $services  = Service::orderBy('id','DESC')->paginate(10);
        $output    = [
            'services'=> $services,

            //menu links
            'services_links' => true,
            'all_services_class' => 'm-menu__item--active'
            ];

        return view('Admin.CRUD.AllServices')->with($output);
    }

    public function add()
    {
        $output = [
            //menu links
            'services_links' => true,
            'add_services_class' => 'm-menu__item--active'
        ];
        return view('Admin.CRUD.addServiceForm')->with($output);
    }

    public function create(ServicesRequest $request)
    {
        $file_name = $this->UploadImage($request->image, 'services/');
        Service::create([
            'title' => $request->title,
            'title_en' => $request->title_en,
            'title_ur' => $request->title_ur,
            'image' => $file_name,
            'is_show' => 1//$request->is_show,
        ]);

        return redirect('Admin/AllServices')->with(['success'=>__('messages.row added sussfully')]);
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);

        $output = ['service' => $service];
        return view('Admin.CRUD.EditServiceForm')->with($output);

    }

    public function update(ServicesRequest $request)
    {
        $service = Service::findOrFail($request->id);

        if(isset($request->image))
        //if(hasFil)
        {
            $file_name = $this->UploadImage($request->image, 'services');

            $updated_data['image'] = $file_name;

        }

        $updated_data['title'] = $request->title;
        $updated_data['title_en'] = $request->title_en;
        $updated_data['title_ur'] = $request->title_ur;
        $service->update($updated_data);

        return redirect('Admin/AllServices')->with(['success'=>__('messages.row updated successfully')]);
    }

    public function delete($id)
    {
        $service = Service::FindOrFail($id);
        $service->delete();

        return redirect('Admin/AllServices')->with(['success'=>__('messages.row deleted successfully')]);
    }
    public function search(Request $request) {
        $service = $request->input('service_id');
        $services  = Service::query()
            ->Where('id',$service)
            ->paginate(10);
        $output    = [
            'services'=> $services,
            //menu links
            'services_links' => true,
            'all_services_class' => 'm-menu__item--active'
        ];

        return view('Admin.CRUD.AllServices')->with($output);
    }
}
