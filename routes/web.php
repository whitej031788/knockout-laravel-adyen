<?php

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

Route::get('/', function () {
  return view('home');
});

Route::get('/united-utilities', function () {
  return view('united-utilities');
});

Route::get('/components', function () {
  return view('components');
});

Route::get('/adyen-platforms-vias', function () {
  return view('adyen-platforms-vias');
});

Route::get('/adyen-platforms-bank', function () {
  return view('adyen-platforms-bank');
});

Route::get('/secured-fields', function () {
  return view('secured-fields');
});

Route::get('/apple-pay-native', function () {
  return view('apple-pay-native');
});

Route::get('/apple-pay-adyen-pure-2', function () {
  return view('apple-pay-adyen-pure-2');
});

Route::get('/custom-card-component', function () {
  return view('custom-card-component');
});

Route::get('/moto-iframe', function () {
  return view('moto-iframe');
});

Route::get('/classic-hpp', function () {
  $datetime = new DateTime();
  $datetime->modify('+1 day');

  return view('classic-hpp', ['datetime' => $datetime->format(DateTime::ATOM)]);
});

Route::get('/pos-terminal-api', function () {
  return view('pos-terminal-api');
});

Route::get('/classic-client-encryption', function () {
  $datetime = new DateTime();

  return view('classic-client-encryption', ['datetime' => $datetime->format(DateTime::ATOM)]);
});

Route::get('/api-only', function () {
  return view('api-only');
});

Route::get('/invoice', function () {
  return view('greggs');
});

Route::get('/copysite', function () {
  return view('menso');
});

Route::get('/simple-card', function () {
  return view('simple-card');
});

Route::get('/peter-imp', function () {
  return view('peter-imp');
});

Route::post('/threeds-redirect/{payRef}', 'AdyenController@threeDSRedirect');

Route::get('/threeds-redirect/{payRef}', 'AdyenController@threeDSRedirect');

Route::get('/normal-redirect/{payRef}', 'AdyenController@normalRedirect');

Route::post('/normal-redirect/{payRef}', 'AdyenController@normalRedirect');
