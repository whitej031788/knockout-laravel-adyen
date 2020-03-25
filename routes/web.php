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

Route::get('/components', function () {
  return view('components');
});

Route::get('/classic-hpp', function () {
  $datetime = new DateTime();
  $datetime->modify('+1 day');

  return view('classic-hpp', ['datetime' => $datetime->format(DateTime::ATOM)]);
});

Route::get('/classic-client-encryption', function () {
  $datetime = new DateTime();

  return view('classic-client-encryption', ['datetime' => $datetime->format(DateTime::ATOM)]);
});

Route::get('/api-only', function () {
  return view('api-only');
});

Route::post('/threeds-redirect/{payRef}', 'AdyenController@threeDSRedirect');

Route::get('/normal-redirect/{payRef}', 'AdyenController@normalRedirect');
