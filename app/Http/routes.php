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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'accept.json'], function(){

    Route::get('user', 'UserController@index');
    Route::post('user', 'UserController@store');
    Route::delete('user/{id}', 'UserController@destroy')->where('id', '\d+');
    Route::put('user/{id}', 'UserController@update')->where('id', '\d+');
    Route::get('user/{id}', 'UserController@show')->where('id', '\d+');

    Route::get('client', 'ClientController@index');
    Route::post('client', 'ClientController@store');
    Route::delete('client/{id}', 'ClientController@destroy')->where('id', '\d+');
    Route::put('client/{id}', 'ClientController@update')->where('id', '\d+');
    Route::get('client/{id}', 'ClientController@show')->where('id', '\d+');

    Route::get('project', 'ProjectController@index');
    Route::post('project', 'ProjectController@store');
    Route::delete('project/{id}', 'ProjectController@destroy')->where('id', '\d+');
    Route::put('project/{id}', 'ProjectController@update')->where('id', '\d+');
    Route::get('project/{id}', 'ProjectController@show')->where('id', '\d+');
    
});