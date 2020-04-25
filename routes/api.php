<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Unauthed routes
Route::group([

], function () {
    Route::post('auth/login', 'AuthController@login');
    Route::get('auth/logout', 'AuthController@logout');
    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/request-reset', 'AuthController@requestReset');
    Route::post('auth/reset', 'AuthController@reset');
    Route::post('auth/validate-verify', 'AuthController@validVerify');
    Route::post('auth/verify', 'AuthController@verify');
});
