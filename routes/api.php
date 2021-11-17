<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/products', 'App\Http\Controllers\ProductController@index');
Route::get('/stripe/{order}', 'App\Http\Controllers\StripePaymentController@stripe')->name('stripe');
Route::post('purchase', 'App\Http\Controllers\StripePaymentController@purchase')->name('purchase');
