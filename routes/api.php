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

Route::middleware(['cors'])->group(function(){

    Route::middleware(['session'])->group(function() {

        Route::post('/login', 'PlayerController@login');
        Route::post('/register', 'PlayerController@register');
        Route::get('/player', 'PlayerController@getPlayer');

    });

    Route::get('/logout', 'PlayerController@logout');
    Route::get('/authenticate', 'PlayerController@authenticatePlayer');

});
