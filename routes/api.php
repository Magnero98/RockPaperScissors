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

    Route::middleware(['session.reuse','session.start'])->group(function() {

        Route::post('/login', 'PlayerController@login');
        Route::post('/register', 'PlayerController@register');

        Route::post('/rooms/create', 'RoomController@createRoom');
        Route::get('/rooms/join', 'RoomController@joinRoom');
        Route::get('/rooms/opponent', 'RoomController@getOpponent');
        Route::get('/player', 'PlayerController@getPlayer');
        Route::get('/players/total', 'RoomController@getTotalPlayer');
        Route::get('/rooms', 'RoomController@get15Rooms');

    });

    Route::get('/logout', 'PlayerController@logout');
    Route::get('/authenticate', 'PlayerController@authenticatePlayer');

});
