<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GoogleMaps;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Service;
use Yajra\DataTables\DataTables;

class AdminOrders extends Controller
{

    public function newOrders(Request $request)
    {

        //filters data
        $clients = User::where(['user_type'=>'client'])->get();
        $drivers = User::where(['user_type'=>'driver'])->get();
        $services = Service::get(['id', 'title']);

        if($request->ajax()){
            //return '111';
            $orders  = Order::whereIn('order_status', ['new_order', 'drivers_not_found'])
            ->with(['user_data', 'driver_data']);



        if(isset($request->service_id) && !is_null($request->service_id))
        {
            $orders->where('service_id', $request->service_id);
        }

        if(isset($request->client_id) && !is_null($request->client_id))
        {
            $orders->where('user_id', $request->client_id);
        }

        if(isset($request->driver_id) && !is_null($request->driver_id))
        {
            $orders->where('driver_id', $request->driver_id);
        }

        if(isset($request->start_date) && isset($request->end_date))
        {
            $start = date("Y-m-d", strtotime($request->start_date));
            $end   = date("Y-m-d", strtotime($request->end_date));

            $orders->whereBetween('order_date', [$start, $end]);
        }

        $data = $orders->orderBy('id','DESC')->get();


            return DataTables::of($data)
                ->addColumn('order_status', function($order){
                     if($order->order_status == 'new_order')
                         $status = '<span class="badge badge-success">'. __('messages.new_order').'</span>';
                     elseif($order->order_status == 'drivers_not_found')
                         $status = '<span class="badge badge-warning">'. __('messages.drivers_not_found').'</span>';
                     elseif($order->order_status == 'all_drivers_refuse')
                        $status = '<span class="badge badge-danger">'. __('messages.all_drivers_refuse').'</span>';
                     elseif($order->order_status == 'client_refuse_all_offers')
                        $status = '<span class="badge badge-danger">'. __('messages.client_refuse_all_offers').'</span>';
                     elseif($order->order_status == 'shipment_order')
                        $status = '<span class="badge badge-success">'. __('messages.shipment_order').'</span>';
                     elseif($order->order_status == 'client_select_driver')
                        $status = '<span class="badge badge-info">'. __('messages.client_select_driver').'</span>';
                     elseif($order->order_status == 'delivery_order')
                        $status = '<span class="badge badge-info">'. __('messages.delivery_order').'</span>';
                     elseif($order->order_status == 'end_delivered')
                        $status = '<span class="badge badge-info">'. __('messages.end_delivered').'</span>';
                     elseif($order->order_status == 'client_rate_driver')
                        $status = '<span class="badge badge-success">'. __('messages.client_rate_driver').'</span>';
                     elseif($order->order_status == 'client_cancel_order')
                        $status = '<span class="badge badge-warning">'. __('messages.client_cancel_order').'</span>';
                     elseif($order->order_status == 'driver_cancel_order')
                        $status = '<span class="badge badge-danger">'. __('messages.driver_cancel_order').'</span>';

                        return $status;
                })
                ->addColumn('service_id', function ($data) {

                        return $data->service['title'];
                })
                ->addColumn('user_id', function ($data) {

                        return $data->user_data['name'];
                })
                ->addColumn('driver_id', function ($data) {
                    if($data->driver != '' || $data->driver != null) {
                        return $data->driver['name'];
                    }
                    return '';
                        })
                ->addColumn('driver_phone', function ($data) {
                       if($data->driver != '' || $data->driver != null) {
                           return $data->driver['phone'];
                       }
                       return '';
                })
                ->addColumn('actions', function($data){
                    $link = '<a href="'.route('orderDetails', $data->id).'" class="btn btn-info">'.__('messages.orderDetails').'</a>';
                    return $link;
                })
                ->addColumn('delete', function($data){
                    $del = '<a href="'.route('orderDelete',$data->id).'" class="btn btn-danger">'.__('messages.orderDelete').'</a>';
                    return $del;
                })

                ->rawColumns(['actions', 'order_status','delete'])->make(true);
        }

        $output = [
            //'orders' => $orders,

            'clients'  => $clients,
            'drivers'  => $drivers,
            'services' => $services,

            'page_title' => __('messages.AllOrders'),
            'route_url'  => route('AllNewOrders'),

            //menu links
            'orders_links' => true,
            'refused_orders_class' => 'm-menu__item--active'
            ];

        return view('Admin.CRUD.OrdersGrid')->with($output);

    }







    public function refusedOrders(Request $request)
    {
        //filters data
        $clients = User::where(['user_type'=>'client'])->get();
        $drivers = User::where(['user_type'=>'driver'])->get();
        $services = Service::get(['id', 'title']);

        if($request->ajax()){

            $orders = Order::whereIn('order_status', ['all_drivers_refuse', 'client_refuse_all_offers'])
            ->with(['user_data', 'driver_data'])->orderBy('id','DESC');

            if(isset($request->service_id) && !is_null($request->service_id))
            {
                $orders->where('service_id', $request->service_id);
            }

            if(isset($request->client_id) && !is_null($request->client_id))
            {
                $orders->where('user_id', $request->client_id);
            }

            if(isset($request->driver_id) && !is_null($request->driver_id))
            {
                $orders->where('driver_id', $request->driver_id);
            }

            if(isset($request->start_date) && isset($request->end_date))
            {
                $start = date("Y-m-d", strtotime($request->start_date));
                $end   = date("Y-m-d", strtotime($request->end_date));

                $orders->whereBetween('order_date', [$start, $end]);
            }

            $data = $orders->get();

            //return $orders;
            return DataTables::of($orders)
                ->addColumn('order_status', function($order){
                     if($order->order_status == 'new_order')
                         $status = '<span class="badge badge-success">'. __('messages.new_order').'</span>';
                     elseif($order->order_status == 'drivers_not_found')
                         $status = '<span class="badge badge-warning">'. __('messages.drivers_not_found').'</span>';
                     elseif($order->order_status == 'all_drivers_refuse')
                        $status = '<span class="badge badge-danger">'. __('messages.all_drivers_refuse').'</span>';
                     elseif($order->order_status == 'client_refuse_all_offers')
                        $status = '<span class="badge badge-danger">'. __('messages.client_refuse_all_offers').'</span>';
                     elseif($order->order_status == 'shipment_order')
                        $status = '<span class="badge badge-success">'. __('messages.shipment_order').'</span>';
                     elseif($order->order_status == 'client_select_driver')
                        $status = '<span class="badge badge-info">'. __('messages.client_select_driver').'</span>';
                     elseif($order->order_status == 'delivery_order')
                        $status = '<span class="badge badge-info">'. __('messages.delivery_order').'</span>';
                     elseif($order->order_status == 'end_delivered')
                        $status = '<span class="badge badge-info">'. __('messages.end_delivered').'</span>';
                     elseif($order->order_status == 'client_rate_driver')
                        $status = '<span class="badge badge-success">'. __('messages.client_rate_driver').'</span>';
                     elseif($order->order_status == 'client_cancel_order')
                        $status = '<span class="badge badge-warning">'. __('messages.client_cancel_order').'</span>';
                     elseif($order->order_status == 'driver_cancel_order')
                        $status = '<span class="badge badge-danger">'. __('messages.driver_cancel_order').'</span>';

                        return $status;
                })
                ->addColumn('service_id', function ($data) {

                        return $data->service['title'];
                })
                ->addColumn('user_id', function ($data) {

                        return $data->user_data['name'];
                })
                ->addColumn('driver_id', function ($data) {
                    if($data->driver != '' || $data->driver != null) {
                        return $data->driver['name'];
                    }
                    return '';
                })
                ->addColumn('driver_phone', function ($data) {
                    if($data->driver != '' || $data->driver != null) {
                        return $data->driver['phone'];
                    }
                    return '';
                })
                ->addColumn('actions', function($data){
                    $link = '<a href="'.route('orderDetails', $data->id).'" class="btn btn-info">'.__('messages.orderDetails').'</a>';
                    return $link;
                })
                ->addColumn('delete', function($data){
                    $del = '<a href="'.route('orderDelete',$data->id).'" class="btn btn-danger">'.__('messages.orderDelete').'</a>';
                    return $del;
                })

                ->rawColumns(['actions', 'order_status','delete'])->make(true);
        }


        $output = [
            //'orders' => $orders,

            'clients'  => $clients,
            'drivers'  => $drivers,
            'services' => $services,

            'page_title' => __('messages.refused_orders'),
            'route_url'  => route('RefusedOrders'),

            //menu links
            'orders_links' => true,
            'refused_orders_class' => 'm-menu__item--active'
            ];

        return view('Admin.CRUD.OrdersGrid')->with($output);
    }


    public function inProgressOrders(Request $request)
    {
         //filters data
        $clients = User::where(['user_type'=>'client'])->get();
        $drivers = User::where(['user_type'=>'driver'])->get();
        $services = Service::get(['id', 'title']);

        if($request->ajax()){

            $orders = Order::whereIn('order_status', ['shipment_order', 'client_select_driver', 'delivery_order', 'end_delivered', 'client_rate_driver'])
            ->with(['user_data', 'driver_data'])->orderBy('id','DESC');

            if(isset($request->service_id) && !is_null($request->service_id))
            {
                $orders->where('service_id', $request->service_id);
            }

            if(isset($request->client_id) && !is_null($request->client_id))
            {
                $orders->where('user_id', $request->client_id);
            }

            if(isset($request->driver_id) && !is_null($request->driver_id))
            {
                $orders->where('driver_id', $request->driver_id);
            }

            if(isset($request->start_date) && isset($request->end_date))
            {
                $start = date("Y-m-d", strtotime($request->start_date));
                $end   = date("Y-m-d", strtotime($request->end_date));

                $orders->whereBetween('order_date', [$start, $end]);
            }

            $data = $orders->get();


            return DataTables::of($orders)
                ->addColumn('order_status', function($order){
                     if($order->order_status == 'new_order')
                         $status = '<span class="badge badge-success">'. __('messages.new_order').'</span>';
                     elseif($order->order_status == 'drivers_not_found')
                         $status = '<span class="badge badge-warning">'. __('messages.drivers_not_found').'</span>';
                     elseif($order->order_status == 'all_drivers_refuse')
                        $status = '<span class="badge badge-danger">'. __('messages.all_drivers_refuse').'</span>';
                     elseif($order->order_status == 'client_refuse_all_offers')
                        $status = '<span class="badge badge-danger">'. __('messages.client_refuse_all_offers').'</span>';
                     elseif($order->order_status == 'shipment_order')
                        $status = '<span class="badge badge-success">'. __('messages.shipment_order').'</span>';
                     elseif($order->order_status == 'client_select_driver')
                        $status = '<span class="badge badge-info">'. __('messages.client_select_driver').'</span>';
                     elseif($order->order_status == 'delivery_order')
                        $status = '<span class="badge badge-info">'. __('messages.delivery_order').'</span>';
                     elseif($order->order_status == 'end_delivered')
                        $status = '<span class="badge badge-info">'. __('messages.end_delivered').'</span>';
                     elseif($order->order_status == 'client_rate_driver')
                        $status = '<span class="badge badge-success">'. __('messages.client_rate_driver').'</span>';
                     elseif($order->order_status == 'client_cancel_order')
                        $status = '<span class="badge badge-warning">'. __('messages.client_cancel_order').'</span>';
                     elseif($order->order_status == 'driver_cancel_order')
                        $status = '<span class="badge badge-danger">'. __('messages.driver_cancel_order').'</span>';

                        return $status;
                })
                ->addColumn('service_id', function ($data) {

                        return $data->service['title'];
                })
                ->addColumn('user_id', function ($data) {

                        return $data->user_data['name'];
                })
                ->addColumn('driver_id', function ($data) {
                    if($data->driver != '' || $data->driver != null) {
                        return $data->driver['name'];
                    }
                    return '';
                })
                ->addColumn('driver_phone', function ($data) {
                    if($data->driver != '' || $data->driver != null) {
                        return $data->driver['phone'];
                    }
                    return '';
                })
                ->addColumn('actions', function($data){
                    $link = '<a href="'.route('orderDetails', $data->id).'" class="btn btn-info">'.__('messages.orderDetails').'</a>';
                    return $link;
                })
                ->addColumn('delete', function($data){
                    $del = '<a href="'.route('orderDelete',$data->id).'" class="btn btn-danger">'.__('messages.orderDelete').'</a>';
                    return $del;
                })

                ->rawColumns(['actions', 'order_status','delete'])->make(true);
        }


        $output = [
            'clients'  => $clients,
            'drivers'  => $drivers,
            'services' => $services,

            'page_title' => __('messages.inprogress_orders'),
            'route_url'  => route('ProgressOrders'),

            //menu links
            'orders_links' => true,
            'inprogress_orders_class' => 'm-menu__item--active'
            ];

        return view('Admin.CRUD.OrdersGrid')->with($output);
    }

   public function allCanceledOrders(Request $request)
   {
         //filters data
        $clients = User::where(['user_type'=>'client'])->get();
        $drivers = User::where(['user_type'=>'driver'])->get();
        $services = Service::get(['id', 'title']);

        if($request->ajax()){

            $orders = Order::whereIn('order_status', ['client_cancel_order', 'driver_cancel_order'])
                            ->with(['user_data', 'driver_data'])->orderBy('id','DESC');;

            if(isset($request->service_id) && !is_null($request->service_id))
            {
                $orders->where('service_id', $request->service_id);
            }

            if(isset($request->client_id) && !is_null($request->client_id))
            {
                $orders->where('user_id', $request->client_id);
            }

            if(isset($request->driver_id) && !is_null($request->driver_id))
            {
                $orders->where('driver_id', $request->driver_id);
            }

            if(isset($request->start_date) && isset($request->end_date))
            {
                $start = date("Y-m-d", strtotime($request->start_date));
                $end   = date("Y-m-d", strtotime($request->end_date));

                $orders->whereBetween('order_date', [$start, $end]);
            }

            $data = $orders->get();


            return DataTables::of($orders)
                ->addColumn('order_status', function($order){
                     if($order->order_status == 'new_order')
                         $status = '<span class="badge badge-success">'. __('messages.new_order').'</span>';
                     elseif($order->order_status == 'drivers_not_found')
                         $status = '<span class="badge badge-warning">'. __('messages.drivers_not_found').'</span>';
                     elseif($order->order_status == 'all_drivers_refuse')
                        $status = '<span class="badge badge-danger">'. __('messages.all_drivers_refuse').'</span>';
                     elseif($order->order_status == 'client_refuse_all_offers')
                        $status = '<span class="badge badge-danger">'. __('messages.client_refuse_all_offers').'</span>';
                     elseif($order->order_status == 'shipment_order')
                        $status = '<span class="badge badge-success">'. __('messages.shipment_order').'</span>';
                     elseif($order->order_status == 'client_select_driver')
                        $status = '<span class="badge badge-info">'. __('messages.client_select_driver').'</span>';
                     elseif($order->order_status == 'delivery_order')
                        $status = '<span class="badge badge-info">'. __('messages.delivery_order').'</span>';
                     elseif($order->order_status == 'end_delivered')
                        $status = '<span class="badge badge-info">'. __('messages.end_delivered').'</span>';
                     elseif($order->order_status == 'client_rate_driver')
                        $status = '<span class="badge badge-success">'. __('messages.client_rate_driver').'</span>';
                     elseif($order->order_status == 'client_cancel_order')
                        $status = '<span class="badge badge-warning">'. __('messages.client_cancel_order').'</span>';
                     elseif($order->order_status == 'driver_cancel_order')
                        $status = '<span class="badge badge-danger">'. __('messages.driver_cancel_order').'</span>';

                        return $status;
                })
                ->addColumn('service_id', function ($data) {

                        return $data->service['title'];
                })
                ->addColumn('user_id', function ($data) {

                        return $data->user_data['name'];
                })
                ->addColumn('driver_id', function ($data) {
                    if($data->driver != '' || $data->driver != null) {
                        return $data->driver['name'];
                    }
                    return '';
                })
                ->addColumn('driver_phone', function ($data) {
                    if($data->driver != '' || $data->driver != null) {
                        return $data->driver['phone'];
                    }
                    return '';
                })
                ->addColumn('actions', function($data){
                    $link = '<a href="'.route('orderDetails', $data->id).'" class="btn btn-info">'.__('messages.orderDetails').'</a>';
                    return $link;
                })
                ->addColumn('delete', function($data){
                    $del = '<a href="'.route('orderDelete',$data->id).'" class="btn btn-danger">'.__('messages.orderDelete').'</a>';
                    return $del;
                })

                ->rawColumns(['actions', 'order_status','delete'])->make(true);
        }


        $output = [
            'clients'  => $clients,
            'drivers'  => $drivers,
            'services' => $services,

            'page_title' => __('messages.cancelled_orders'),
            'route_url'  => route('CancelledOrders'),

            //menu links
            'orders_links' => true,
            'cancelled_orders_class' => 'm-menu__item--active'
            ];

        return view('Admin.CRUD.OrdersGrid')->with($output);
   }



   public function allFinishedOrders(Request $request)
   {
         //filters
        $clients = User::where(['user_type'=>'client'])->get();
        $drivers = User::where(['user_type'=>'driver'])->get();
        $services = Service::get(['id', 'title']);

        if($request->ajax()){

            $orders = Order::whereIn('order_status', ['end_delivered', 'client_rate_driver'])
                            ->with(['user_data', 'driver_data'])->orderBy('id','DESC');

            if(isset($request->service_id) && !is_null($request->service_id))
            {
                $orders->where('service_id', $request->service_id);
            }

            if(isset($request->client_id) && !is_null($request->client_id))
            {
                $orders->where('user_id', $request->client_id);
            }

            if(isset($request->driver_id) && !is_null($request->driver_id))
            {
                $orders->where('driver_id', $request->driver_id);
            }

            if(isset($request->start_date) && isset($request->end_date))
            {
                $start = date("Y-m-d", strtotime($request->start_date));
                $end   = date("Y-m-d", strtotime($request->end_date));

                $orders->whereBetween('order_date', [$start, $end]);
            }

            $data = $orders->get();


            return DataTables::of($orders)
                ->addColumn('order_status', function($order){
                     if($order->order_status == 'new_order')
                         $status = '<span class="badge badge-success">'. __('messages.new_order').'</span>';
                     elseif($order->order_status == 'drivers_not_found')
                         $status = '<span class="badge badge-warning">'. __('messages.drivers_not_found').'</span>';
                     elseif($order->order_status == 'all_drivers_refuse')
                        $status = '<span class="badge badge-danger">'. __('messages.all_drivers_refuse').'</span>';
                     elseif($order->order_status == 'client_refuse_all_offers')
                        $status = '<span class="badge badge-danger">'. __('messages.client_refuse_all_offers').'</span>';
                     elseif($order->order_status == 'shipment_order')
                        $status = '<span class="badge badge-success">'. __('messages.shipment_order').'</span>';
                     elseif($order->order_status == 'client_select_driver')
                        $status = '<span class="badge badge-info">'. __('messages.client_select_driver').'</span>';
                     elseif($order->order_status == 'delivery_order')
                        $status = '<span class="badge badge-info">'. __('messages.delivery_order').'</span>';
                     elseif($order->order_status == 'end_delivered')
                        $status = '<span class="badge badge-info">'. __('messages.end_delivered').'</span>';
                     elseif($order->order_status == 'client_rate_driver')
                        $status = '<span class="badge badge-success">'. __('messages.client_rate_driver').'</span>';
                     elseif($order->order_status == 'client_cancel_order')
                        $status = '<span class="badge badge-warning">'. __('messages.client_cancel_order').'</span>';
                     elseif($order->order_status == 'driver_cancel_order')
                        $status = '<span class="badge badge-danger">'. __('messages.driver_cancel_order').'</span>';

                        return $status;
                })
                ->addColumn('service_id', function ($data) {

                        return $data->service['title'];
                })
                ->addColumn('user_id', function ($data) {

                        return $data->user_data['name'];
                })
                ->addColumn('driver_id', function ($data) {
                    if($data->driver != '' || $data->driver != null) {
                        return $data->driver['name'];
                    }
                    return '';
                })
                ->addColumn('driver_phone', function ($data) {
                    if($data->driver != '' || $data->driver != null) {
                        return $data->driver['phone'];
                    }
                    return '';
                })
                ->addColumn('actions', function($data){
                    $link = '<a href="'.route('orderDetails', $data->id).'" class="btn btn-info">'.__('messages.orderDetails').'</a>';
                    return $link;
                })
                ->addColumn('delete', function($data){
                    $del = '<a href="'.route('orderDelete',$data->id).'" class="btn btn-danger">'.__('messages.orderDelete').'</a>';
                    return $del;
                })

                ->rawColumns(['actions', 'order_status','delete'])->make(true);
        }


        $output = [
            'clients'  => $clients,
            'drivers'  => $drivers,
            'services' => $services,

            'page_title' => __('messages.finished_orders'),
            'route_url'  => route('allFinishedOrders'),

            //menu links
            'orders_links' => true,
            'cancelled_orders_class' => 'm-menu__item--active'
            ];

        return view('Admin.CRUD.OrdersGrid')->with($output);
   }

    /*public function allCanceledOrders()
    {
        $orders = Order::whereIn('order_status', ['client_cancel_order', 'driver_cancel_order'])
        ->with(['user_data', 'driver_data'])
        ->paginate(10);

        $output = [
            'orders' => $orders,
            'page_title' => __('messages.cancelled_orders'),

            //menu links
            'orders_links' => true,
            'cancelled_orders_class' => 'm-menu__item--active'
            ];
        return view('Admin.CRUD.OrdersGrid')->with($output);
    }*/

    public function order_details($order_id)
    {
        $googleMaps = new GoogleMaps();

        $order = Order::findOrFail($order_id);


        $output = ['order' => $order, 'orders_links' => true];
        return view('Admin.CRUD.order_details')->with($output);
    }


    public function deleteOrder($id){
        $order = Order::findOrFail($id);
//        return $order;
        $order->delete();

        return back();

    }
    /*-------------------search in orders----------------*/
//
    public function search(Request $request) {
            $client  = $request->input('user_id');
            $service = $request->input('service_id');
//            dd($service);
            $driver  = $request->input('driver_id');
            $orders  = Order::query()
            ->where('user_id' ,$client)
            ->orWhere('service_id',$service)
//            ->orWhere('driver_id',$driver)
            ->orderBy('id','DESC')
            ->paginate(10);
        $output = [
            'orders' => $orders,
            'page_title' => __('messages.AllOrders'),

        ];
        return view('Admin.CRUD.OrdersGrid')->with($output);
    }


}
