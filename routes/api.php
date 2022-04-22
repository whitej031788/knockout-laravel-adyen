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
Route::post('/adyen/getPaymentSession', 'AdyenController@checkoutApiSessions');

Route::post('/adyen/classicPayment', 'AdyenController@classicPayment');

Route::post('/adyen/payGiftCard', 'AdyenController@payGiftCard');

// Checkout API gift card orders
Route::post('/adyen/checkBalance', 'AdyenController@checkoutApiCheckBalance');
Route::post('/adyen/createOrder', 'AdyenController@createOrder');

Route::post('/adyen/makePaymentSimple', 'AdyenController@makePaymentSimple');

Route::post('/payments', 'AdyenController@makeFlutterPayment');

Route::post('/adyen/doCostEstimate', 'AdyenController@doCostEstimate');

Route::post('/adyen/submitDonation', 'AdyenController@submitDonation');

Route::post('/adyen/makePayment3DS2', 'AdyenController@makePayment3DS2');

Route::post('/adyen/paymentDetails', 'AdyenController@paymentDetails');

Route::post('/adyen/signHppHmac', 'AdyenController@signHppHmac');

Route::post('/adyen/capturePayment', 'AdyenController@capturePayment');

Route::post('/adyen/applePaySession', 'AdyenController@getApplePaySession');

Route::post('/greggs/generateAndSendLink', 'GreggsController@generateAndSendLink');

Route::post('/greggs/generateAndShowInvoice', 'GreggsController@generateAndShowInvoice');

Route::post('/marketplace/createAccountHolder', 'AdyenController@createAccountHolder');

Route::post('/marketplace/createNotificationConfiguration', 'AdyenController@createNotificationConfiguration');

Route::post('/marketplace/uploadDocument', 'AdyenController@uploadDocument');

Route::post('/marketplace/getAccountHolder', 'AdyenController@getAccountHolder');

Route::post('/marketplace/updateAccountHolder', 'AdyenController@updateAccountHolder');

Route::post('/marketplace/checkAccountHolder', 'AdyenController@checkAccountHolder');

Route::post('/marketplace/getOnboardingUrl', 'AdyenController@getOnboardingUrl');

Route::post('/marketplace/getPciQuestionnaireUrl', 'AdyenController@getPciQuestionnaireUrl');
