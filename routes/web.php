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
    Route::post('/foodEdit/{foodId}', 'App\Http\Controllers\FoodsController@foodEdit');
    Route::delete('/deleteFood/{foodId}', 'App\Http\Controllers\FoodsController@deleteFood');

    Route::get('/c/create', 'App\Http\Controllers\CategoriesController@create')->name('admin.categories.create');
    Route::post('/c', 'App\Http\Controllers\CategoriesController@store');
    Route::post('/categoryEdit/{categoryId}', 'App\Http\Controllers\CategoriesController@categoryEdit');
    Route::get('/categoryDelete/{categoryId}', 'App\Http\Controllers\CategoriesController@categoryDelete');

    Route::get('/coupon/create', 'App\Http\Controllers\CouponController@create')->name('admin.createCoupon.create');
    Route::post('/coupon', 'App\Http\Controllers\CouponController@store');

    Route::get('/orderManagement', 'App\Http\Controllers\OrderManagementController@index')->name('admin.orderManagement.index');
    Route::delete('/orderRemove/{id}', 'App\Http\Controllers\OrderManagementController@orderRemove');
    Route::put('/status/{orderId}/{statusId}', 'App\Http\Controllers\OrderManagementController@changeOrderStatus');

    Route::get('/couponManagement', 'App\Http\Controllers\CouponManagementController@index')->name('admin.couponManagement.index');
    Route::delete('/couponsRemove/{id}', 'App\Http\Controllers\CouponManagementController@couponsRemove');
    Route::put('/usage/{couponId}/{usageId}', 'App\Http\Controllers\CouponManagementController@changeCouponUsage');
    Route::put('/couponEdit/{couponId}', 'App\Http\Controllers\CouponManagementController@couponEdit');

});

Route::post('/addToUserCart/{foodId}/{userId}', 'App\Http\Controllers\CartsController@addToUserCart')->middleware('auth');
Route::delete('/userItemRemove/{foodId}/{userId}', 'App\Http\Controllers\CartsController@removeFromUserCart')->middleware('auth');
Route::post('/userUseCoupon/{userId}/{couponId}', 'App\Http\Controllers\CartsController@userUseCoupon')->middleware('auth');
Route::post('/couponUseOnce/{userId}/{couponId}', 'App\Http\Controllers\CartsController@couponUseOnce')->middleware('auth');
Route::post('/setRating/{foodId}/{rate}', 'App\Http\Controllers\MenuController@setRating')->middleware('auth');
Route::put('/putRating/{rateId}/{rate}', 'App\Http\Controllers\MenuController@putRating')->middleware('auth');

Route::get('/avgRating/{foodId}', 'App\Http\Controllers\MenuController@avgRating');
Route::get('/getRating/{foodId}/{userId}', 'App\Http\Controllers\MenuController@getRating');
Route::get('/menu', 'App\Http\Controllers\MenuController@index')->name('menu.index');
Route::get('/', 'App\Http\Controllers\WelcomeController@index');
Route::get('/getBestFood', 'App\Http\Controllers\WelcomeController@getBestFood');

Route::get('/cart', 'App\Http\Controllers\CartsController@index')->name('cart.index');
Route::post('/add-to-cart/{food}', 'App\Http\Controllers\CartsController@addToCart');
Route::delete('/itemRemove/{id}', 'App\Http\Controllers\CartsController@removeFromCart');
Route::put('/updateItemSum/{id}', 'App\Http\Controllers\CartsController@updateItemSum');
Route::put('/updateItemSub/{id}', 'App\Http\Controllers\CartsController@updateItemSub');

Route::post('/order', 'App\Http\Controllers\OrdersController@createOrderFromRequest');
Route::post('/orderItem/{orderId}', 'App\Http\Controllers\OrderItemsController@createOrderItems');

Route::get('/paymentSuccessFull', 'App\Http\Controllers\PaymentSuccessFullController@index')->name('paymentSuccess.index');
