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

Route::get('/', 'HomeController@index');

Route::group(['middleware' => 'accept.json'], function() {

    Route::post('oauth/access-token', 'OAuthController@access');
    
    Route::group(['middleware' => 'oauth', 'where' => ['id' => '\d+', 'project' => '\d+']], function() {

        Route::resource('user',         'UserController',        ['except' => ['create', 'edit']]);
        Route::resource('client',       'ClientController',      ['except' => ['create', 'edit']]);
        Route::resource('project',      'ProjectController',     ['except' => ['create', 'edit']]);
        Route::resource('project/note', 'ProjectNoteController', ['except' => ['create', 'edit']]);
        Route::resource('project/task', 'ProjectTaskController', ['except' => ['create', 'edit']]);
        Route::get('project/{project}/members', ['uses' => 'ProjectController@members', 'as' => 'project.members']);
        Route::get('project/{project}/notes',   ['uses' => 'ProjectController@notes',   'as' => 'project.notes']);
        Route::get('project/{project}/tasks',   ['uses' => 'ProjectController@tasks',   'as' => 'project.tasks']);
    });
    
    Route::any('/{uri?}', function () {
        throw new \Symfony\Component\HttpKernel\Exception\HttpException(404, 'Method Not Allowed');
    })->where('uri', '.*');
});