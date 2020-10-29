<?php

use Illuminate\Http\Request;

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

Route::post('user', 'Auth\RegisterController@index');
Route::get('user/handle', 'Auth\RegisterController@handle');

Route::get('categories', 'CategoriesController@list');
Route::post('categories/create', 'CategoriesController@create');
Route::post('categories/delete', 'CategoriesController@delete');

Route::get('items', 'ItemsController@list');
Route::post('items/payment', 'ItemsController@payment');
Route::post('items/create', 'ItemsController@create');
Route::post('items/delete', 'ItemsController@delete');

Route::post('payment', 'PaymentController@make');
Route::post('payments', 'PaymentController@get');

Route::get('server', 'ServersController@get');

Route::post('purchases', 'PurchasesController@create');
Route::get('purchases/list', 'PurchasesController@list');
Route::post('purchases/inventory', 'PurchasesController@inventory');