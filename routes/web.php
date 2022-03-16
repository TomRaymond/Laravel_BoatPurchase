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

Route::get('/', array('uses' => 'App\Http\Controllers\PagesController@index', 'as' => 'pages.index'));

Route::get('/purchase', array('uses' => 'App\Http\Controllers\PagesController@purchase', 'as' => 'pages.purchase'));

Route::get('checkout', array('uses' => 'App\Http\Controllers\CheckoutController@checkout', 'as' => 'checkout.credit-card'));
Route::post('purchase-complete', array('uses' => 'App\Http\Controllers\CheckoutController@purchaseComplete', 'as' => 'checkout.purchase-complete'));

Auth::routes();
