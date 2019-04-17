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
//route::get('/','PagesController@root')->name('root')->middleware('verified');
Route::redirect('/', '/products')->name('root');
Route::get('products', 'ProductsController@index')->name('products.index');
Route::get('products/{product}', 'ProductsController@show')->name('products.show')->where(['product'=>'[0-9]+']);
Auth::routes(['verify'=>true]);
//auth 中间件代表需要登陆,verified中间件代表需要验证邮箱
Route::group(['middleware'=>['auth','verified']],function(){
    Route::get('user_addresses','UserAddressesController@index')->name('user_addresses.index');
    Route::get('user_addresses/create','UserAddressesController@create')->name('user_addresses.create');
    Route::post('user_addresses','UserAddressesController@store')->name('user_addresses.store');
    Route::post('products/{product}/favorite','ProductsController@favor')->name('products.favor');
    Route::delete('products/{product}/favorite','ProductsController@disfavor')->name('products.disfavor');
    Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');
    Route::post('cart','CartController@add')->name('cart.add');
    Route::get('cart','CartController@index')->name('cart.index');
    Route::delete('cart/{sku}','CartController@remove')->name('cart.remove');
    Route::post('orders','OrdersController@store')->name('orders.store');
    Route::get('orders','OrdersController@index')->name('orders.index');
    Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
});
