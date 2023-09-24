<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/**
 *  ============================================================
 *
 *  ------------------------------------------------------------
 *
 *  ============================================================
 */


Route::post('login', 'AuthController@login');
Route::post('register-client', 'AuthController@registerClient');
Route::post('register-driver', 'AuthController@registerDriver');



Route::post('send-confirm-code', 'AuthController@sendConfirmCode');
Route::post('check-confirm-code', 'AuthController@checkConfirmCode');


//------------------------------------------------------------

Route::get('about-us', function (){
    return view( 'about_us' );
});

Route::get('our-terms', function (){
    return view( 'terms' );
});

//------------------------------------------------------------
Route::get('slider', 'SettingController@slider');
Route::get('services', 'SettingController@services');
Route::get('setting', 'SettingController@showSetting');
Route::post('contact-us', 'SettingController@contactUs');

//====================================================================================
 // Route::group(['middleware' => "checkheader"], function () {

    Route::post('logout', 'AuthController@logout');
    Route::post('update-firebase', 'AuthController@updateFirebase');
    Route::get('get-profile', 'AuthController@getProfile');
    Route::post('update-profile', 'AuthController@updateProfile');
    //------------------------------------------------------------
    Route::post('logout', 'AuthController@logout');
    //------------------------------------------------------------
    Route::post('create-order', 'OrdersController@create');
    Route::get('driver-new-orders', 'OrdersController@driverNewOrders');
    Route::get('get-one-order', 'OrdersController@getOneOrder');
    Route::post('change-order-status', 'OrdersController@changeOrderStatus');
    Route::get('client-orders', 'OrdersController@clientOrders');
    Route::get('driver-orders', 'OrdersController@driverOrders');
    Route::post('cancel-order', 'OrdersController@cancelOrder');
    Route::post('deiver-cancel-order', 'OrdersController@driverCancelOrder');
    Route::post('client-rate-driver', 'OrdersController@clientRateDriver');
    //------------------------------------------------------------
    Route::post('send-offer', 'OfferController@create');
    Route::post('resend-offer', 'OfferController@resend');
    Route::post('refuse-send-offer', 'OfferController@driverRefuseSendOffer');
    Route::get('show-drivers-offer', 'OfferController@showDriversOffer');
    Route::get('show-one-order-drivers-offer', 'OfferController@showDriversOffer');
    Route::get('filter-show-drivers-offer', 'OfferController@filterShowDriversOffer');
    Route::post('client-refuse-offer', 'OfferController@clientRefuseOffer');
    Route::post('client-accept-offer', 'OfferController@clientAcceptOffer');
    //------------------------------------------------------------
    Route::get('my-notification', 'NotificationController@getMyNotification');
    Route::get('count-unread', 'NotificationController@countUread');
    Route::post('delete-notification', 'NotificationController@delete');
 //});
/**
 *  ============================================================
 *W
 *  ------------------------------------------------------------
 *
 *  ============================================================
 */


