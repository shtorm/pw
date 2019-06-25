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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'user'
], function () {
    Route::post('create', 'UserController@create');
    Route::get('list', 'UserController@getList');
    Route::put('update/{id}', 'UserController@update');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'operation'
], function () {
    Route::post('create', 'OperationController@create');
//    Route::get('list', 'UserController@getList');
//    Route::put('update/{id}', 'UserController@update');
});
