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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::match(['get', 'post'],'/benefitpay', 'BenefitPayController@pay')->name('benefitpay');

Route::get('/payment_request', 'BenefitAPIController@payment_request')->name('payment_request');
Route::match(['get', 'post'],'/', 'BenefitAPIController@home')->name('home');
Route::match(['get', 'post'],'/payment_response', 'BenefitAPIController@payment_response')->name('payment_response');
Route::match(['get', 'post'],'/payment_approved', 'BenefitAPIController@payment_approved')->name('payment_approved');
Route::match(['get', 'post'],'/error_response', 'BenefitAPIController@error_response')->name('error_response');
Route::match(['get', 'post'],'/payment_declined', 'BenefitAPIController@payment_declined')->name('payment_declined');