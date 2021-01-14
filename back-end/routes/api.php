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
Route::get('items/get', 'ItemsController@get');
Route::post('items/payment', 'ItemsController@payment');
Route::post('items/create', 'ItemsController@create');
Route::post('items/delete', 'ItemsController@delete');

Route::post('payment', 'PaymentController@make');
Route::post('payments', 'PaymentController@get');

Route::get('server', 'ServersController@get');
Route::get('server/rcon', 'ServersController@rcon');

Route::get('player/statistic', 'PlayerController@statistic');

Route::post('purchases', 'PurchasesController@create');
Route::get('purchases/list', 'PurchasesController@list');
Route::post('purchases/inventory', 'PurchasesController@inventory');

Route::get('kits', 'KitsController@getAll');
Route::post('kits/create', 'KitsController@create');
Route::get('kits/items', 'KitsItemsController@get');
Route::post('kits/items/create', 'KitsItemsController@create');

Route::get('bans', 'BansController@get');

Route::get('rullet/items', 'RulletController@items');
Route::post('rullet/add', 'RulletController@add');
Route::post('rullet/delete', 'RulletController@delete');
Route::post('rullet/predict', 'RulletController@predict');
Route::post('rullet/give', 'RulletController@givePrize');
Route::post('rullet/access', 'RulletController@access');
Route::post('rullet/use', 'RulletController@use');
Route::post('rullet/skin/set.state', 'RulletController@setSkinState');

Route::post('vk/notification', 'VK\NotificationController@send');