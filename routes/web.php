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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Admin
Route::middleware(['auth:sanctum', 'verified', 'authadmin'])->group(function(){

    Route::get('/adminMenu', 'App\Http\Controllers\MenuController@indexAdmin')->name('menu.indexAdmin');

    Route::get('/f/create', 'App\Http\Controllers\FoodsController@create')->name('foods.create');
    Route::post('/f', 'App\Http\Controllers\FoodsController@store');

    Route::get('/c/create', 'App\Http\Controllers\CategoriesController@create')->name('categories.create');
    Route::post('/c', 'App\Http\Controllers\CategoriesController@store');
});

Route::get('/menu', 'App\Http\Controllers\MenuController@index')->name('menu.index');

Route::post('/add-to-cart/{food}', 'App\Http\Controllers\CartController@addToCart');
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index');

Route::delete('/remove/{id}', 'App\Http\Controllers\CartController@removeFromCart');

Route::put('/updateSum/{id}', 'App\Http\Controllers\CartController@updateSum');
Route::put('/updateSub/{id}', 'App\Http\Controllers\CartController@updateSub');



