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

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::post('/adyen/getPaymentMethods', 'AdyenController@getPaymentMethods');

Route::post('/adyen/classicPayment', 'AdyenController@classicPayment');

Route::post('/adyen/makePaymentSimple', 'AdyenController@makePaymentSimple');

Route::post('/adyen/makePayment3DS2', 'AdyenController@makePayment3DS2');

Route::post('/adyen/paymentDetails', 'AdyenController@paymentDetails');
