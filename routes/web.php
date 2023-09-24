<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', 'Admin\AdminLoginController@login_form');
Route::get('ContactUs', 'ContactUs@index');
Route::post('submit_contact_us', 'ContactUs@submit')->name('submit_contact_us');

//Auth::routes();

//admin routes

Route::get('AdminLogin', 'Admin\AdminLoginController@login_form')->name('login');
Route::post('AdminLogin', 'Admin\AdminLoginController@submit_login')->name('AdminLogin');

Route::group(['prefix'=>'Admin/', 'namespace'=>'Admin', 'middleware'=>['auth:admin']], function(){

    Route::get('/logout', 'AdminController@logout')->name('AdminLogout');
    Route::post('/logout', 'AdminController@logout')->name('AdminLogout');

    Route::get('/home', 'AdminController@dashboard')->name('home');
    Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');

    //-----Users Routes
    Route::get('AllUsers', 'AdminUsers@index')->name('AllUsers');
    Route::post('AllUsers', 'AdminUsers@search')->name('user.search');

    //add
    Route::get('AddAdminUser', 'AdminUsers@add')->name('AddAdminUser');
    Route::post('createAdmin', 'AdminUsers@create')->name('createAdmin');

    //edit
    Route::get('editAdmin/{adminId}', 'AdminUsers@edit')->name('editAdmin');
    Route::post('update', 'AdminUsers@update')->name('updateAdmin');

    //delete
    Route::get('deleteAdmin/{adminId}', 'AdminUsers@delete')->name('deleteAdmin');

    //-----End Users

    //-----Services Routes
    Route::get('AllServices', 'AdminServices@index')->name('AllServices');

    //add
    Route::get('AddService', 'AdminServices@add')->name('AddService');
    Route::post('createService', 'AdminServices@create')->name('createService');

    //edit
    Route::get('EditService/{ID}', 'AdminServices@edit')->name('EditService');
    Route::post('UpdateService', 'AdminServices@update')->name('UpdateService');

    //delete
    Route::get('deleteService/{Id}', 'AdminServices@delete')->name('deleteService');
    //search
    Route::post('Service_search', 'AdminServices@search')->name('service.search');


    //-----END SERVICES

    //-----Users Requests
    Route::get('ALlUsersRequests', 'DriversRequests@index')->name('ALlUsersRequests');
    Route::post('refuseReason', 'DriversRequests@refuseDriver')->name('refuseReason');

    Route::get('approveDriver/{ID}', 'DriversRequests@approveDriver')->name('approveDriver');

    Route::get('AllRejectedDrivers', 'Rejected_drivers@index')->name('AllRejectedDrivers');
    Route::get('AllAcceptedDrivers', 'Accepted_drivers@index')->name('AllAcceptedDrivers');

    Route::get('driverRates/{driverId}', 'Accepted_drivers@driverRateDetails')->name('driverRates');
    Route::get('blockThisDriver/{driverId}', 'Accepted_drivers@blockDriver')->name('blockThisDriver');
    Route::get('unblockThisDriver/{driverId}', 'Accepted_drivers@unblockThisDriver')->name('unblockThisDriver');
    //-----END Users Requests

    //-----START registed users routes
    Route::get('AllRegisteredUsers', 'AllUsers@index')->name('AllRegisteredUsers');
    Route::get('usersDT', 'AllUsers@indexDT')->name('users');
    //-----END registed users routes

    //-----START orders routes
    Route::get('AllNewOrders', 'AdminOrders@newOrders')->name('AllNewOrders');
    Route::get('RefusedOrders', 'AdminOrders@refusedOrders')->name('RefusedOrders');
    Route::get('ProgressOrders', 'AdminOrders@inProgressOrders')->name('ProgressOrders');
    Route::get('CancelledOrders', 'AdminOrders@allCanceledOrders')->name('CancelledOrders');
    Route::get('allFinishedOrders', 'AdminOrders@allFinishedOrders')->name('allFinishedOrders');
    Route::get('orderDetails/{id}', 'AdminOrders@order_details')->name('orderDetails');
    Route::get('orderDelete/{id}', 'AdminOrders@deleteOrder')->name('orderDelete');
    Route::post('AllNewOrders', 'AdminOrders@search')->name('order.search');
    //-----END orders routes

    //-----START settings routes
    Route::get('AppSettings', 'AppSettings@index')->name('AppSettings');
    Route::get('editSettings/{id}', 'AppSettings@edit')->name('editSettings');
    Route::post('UpdateSettings/', 'AppSettings@update')->name('UpdateSettings');
    //-----END settings routes

    //-----START Slider routes
    Route::resource('slider', 'AdminSliderController');

    //-----END Slider routes

    //-----START contact us routes
    Route::get('Contact_us_messages', 'AdminContactUs@index')->name('Contact_us_messages');
    Route::get('MessageDetails/{msgId}', 'AdminContactUs@message_details')->name('MessageDetails');
    //-----END contact us routes

    Route::get("deleteUser/{id}",'AllUsers@deleteUser')->name('deleteUser');

    //------------- drivers --------------
    Route::resource('drivers', 'AdminDriversController');
    Route::get('drivers/changeBlock/{id}','AdminDriversController@changeBlock')
        ->name('drivers.changeBlock');

});

//End Admin routes



//Clear route cache:
Route::get('route-cacher', function () {
    $exitCode = Artisan::call('route:cache');
    return 'Routes cache cleared';
});

//Clear config cache:
Route::get('config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache cleared';
});

// Clear application cache:
Route::get('clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return 'Application cache cleared';
});

// Clear view cache:
Route::get('view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return 'View cache cleared';
});
// Clear view cache:
Route::get('optimize-clear', function () {
    $exitCode = Artisan::call('optimize:clear');
    return 'View cache cleared';
});



