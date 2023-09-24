<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class AdminController extends Controller
{
    //

    public function dashboard()
    {
        $ios_users_count = User::where(['user_type'=>'client', 'software_type' => 'ios'])->count();
        $android_users_count = User::where(['user_type'=>'client', 'software_type' => 'android'])->count();

        $new_orders_count = Order::where(['order_status' => 'new_order'])->count();
        $refused_orders_count = Order::wherein('order_status' , ['all_drivers_refuse', 'client_refuse_all_offers'])->count();
        $inprogress_orders_count = Order::whereIn('order_status', ['shipment_order', 'client_select_driver', 'delivery_order', 'end_delivered', 'client_rate_driver'])->count();
        $cancelled_orders = $orders = Order::whereIn('order_status', ['client_cancel_order', 'driver_cancel_order'])->count();

        $output = [
            'ios_users_count' => $ios_users_count,
            'android_users_count' => $android_users_count,

            //orders status
            'new_orders_count'        => $new_orders_count,
            'refused_orders_count'    => $refused_orders_count,
            'inprogress_orders_count' => $inprogress_orders_count,
            'cancelled_orders'        => $cancelled_orders,

        ];
        return view('Admin.dashboard')->with($output);
    }

    public function logout(Request $request)
    {
        Auth('admin')->logout();
        return redirect()->route('AdminLogin');
    }
}
