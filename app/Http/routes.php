<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::group(['middlewere' => ['web']], function () {
	Route::get('/', 'CatalogsController@index');
	Route::get('/catalogs', 'CatalogsController@index');
	Route::auth();
	Route::get('/home', 'HomeController@index');
	Route::resource('/categories', 'CategoriesController');
	Route::resource('/products', 'ProductsController');
	Route::post('cart', 'CartController@addProduct');
	Route::get('cart', 'CartController@show');
	Route::delete('cart/{product_id}', 'CartController@removeProduct');
	Route::put('cart/{product_id}', 'CartController@changeQuantity');
	Route::get('checkout/login', 'CheckoutController@login');
	Route::post('checkout/login', 'CheckoutController@postLogin');
	Route::get('checkout/address', 'CheckoutController@address');
	Route::post('checkout/address', 'CheckoutController@postAddress');
	Route::get('checkout/payment', 'CheckoutController@payment');
	Route::post('checkout/payment', 'CheckoutController@postPayment');
	Route::get('checkout/success', 'CheckoutController@success');
	Route::resource('orders', 'OrdersController', ['only' => ['index', 'edit', 'update']]);
	Route::get('/home/orders', 'HomeController@viewOrders');
});

Route::group(['middleware' => 'api'], function () {
	Route::get('address/regencies', 'AddressController@regencies');
});