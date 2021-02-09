<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Admin
Route::middleware(['auth:sanctum', 'verified', 'authadmin'])->group(function(){
    Route::get('/f/create', 'App\Http\Controllers\FoodsController@create')->name('admin.foods.create');
    Route::post('/f', 'App\Http\Controllers\FoodsController@store');

    Route::get('/c/create', 'App\Http\Controllers\CategoriesController@create')->name('admin.categories.create');
    Route::post('/c', 'App\Http\Controllers\CategoriesController@store');

    Route::get('/coupon/create', 'App\Http\Controllers\CouponController@create')->name('admin.createCoupon.create');
    Route::post('/coupon', 'App\Http\Controllers\CouponController@store');

    Route::get('/orderManagement', 'App\Http\Controllers\OrderManagementController@index')->name('admin.orderManagement.index');
    Route::delete('/orderRemove/{id}', 'App\Http\Controllers\OrderManagementController@orderRemove');
    Route::put('/status/{orderId}/{statusId}', 'App\Http\Controllers\OrderManagementController@changeOrderStatus');

    Route::get('/couponManagement', 'App\Http\Controllers\CouponManagementController@index')->name('admin.couponManagement.index');

});

Route::post('/addToUserCart/{foodId}/{userId}', 'App\Http\Controllers\CartsController@addToUserCart')->middleware('auth');
Route::delete('/userItemRemove/{foodId}/{userId}', 'App\Http\Controllers\CartsController@removeFromUserCart')->middleware('auth');

Route::get('/menu', 'App\Http\Controllers\MenuController@index')->name('menu.index');

Route::get('/cart', 'App\Http\Controllers\CartsController@index')->name('cart.index');
Route::post('/add-to-cart/{food}', 'App\Http\Controllers\CartsController@addToCart');
Route::delete('/itemRemove/{id}', 'App\Http\Controllers\CartsController@removeFromCart');
Route::put('/updateItemSum/{id}', 'App\Http\Controllers\CartsController@updateItemSum');
Route::put('/updateItemSub/{id}', 'App\Http\Controllers\CartsController@updateItemSub');

Route::post('/order', 'App\Http\Controllers\OrdersController@createOrderFromRequest');
Route::post('/orderItem/{orderId}', 'App\Http\Controllers\OrderItemsController@createOrderItems');

Route::get('/paymentSuccessFull', 'App\Http\Controllers\PaymentSuccessFullController@index')->name('paymentSuccess.index');
