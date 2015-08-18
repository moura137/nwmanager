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

Route::get('/', function() {
    return view('app');
});

/**
 * API
 */
Route::group(['middleware' => 'accept.json'], function() {

    Route::post('oauth/access-token', 'OAuthController@access');
    
    Route::group(['middleware' => 'oauth', 'where' => ['id' => '\d+', 'project' => '\d+']], function() {

        Route::get('oauth/user', 'OAuthController@user');

        Route::resource('user',         'UserController',        ['except' => ['create', 'edit']]);
        Route::resource('client',       'ClientController',      ['except' => ['create', 'edit']]);
        Route::resource('project',      'ProjectController',     ['except' => ['create', 'edit']]);
        
        Route::get('project/{project}/members',         ['uses' => 'ProjectController@members',     'as' => 'project.members']);
        Route::post('project/{project}/members/add',    ['uses' => 'ProjectController@addMember',   'as' => 'project.members.store']);
        Route::post('project/{project}/members/remove', ['uses' => 'ProjectController@removeMember','as' => 'project.members.destroy']);
        Route::post('project/{project}/members/sync',   ['uses' => 'ProjectController@syncMember',  'as' => 'project.members.sync']);
        
        Route::get('project/{project}/note',        ['uses' => 'ProjectNoteController@index',   'as' => 'project.note.index']);
        Route::post('project/{project}/note',       ['uses' => 'ProjectNoteController@store',   'as' => 'project.note.store']);
        Route::get('project/{project}/note/{note}', ['uses' => 'ProjectNoteController@show',    'as' => 'project.note.show']);

        Route::get('project/{project}/task',            ['uses' => 'ProjectTaskController@index',    'as' => 'project.task.index']);
        Route::post('project/{project}/task',           ['uses' => 'ProjectTaskController@store',    'as' => 'project.task.store']);
        Route::get('project/{project}/task/{task}',     ['uses' => 'ProjectTaskController@show',     'as' => 'project.task.show']);
        Route::put('project/{project}/task/{task}',     ['uses' => 'ProjectTaskController@update',   'as' => 'project.task.update']);
        Route::delete('project/{project}/task/{task}',  ['uses' => 'ProjectTaskController@destroy',  'as' => 'project.task.destroy']);

        Route::get('project/{project}/file',            ['uses' => 'ProjectFileController@index',    'as' => 'project.file.index']);
        Route::post('project/{project}/file',           ['uses' => 'ProjectFileController@store',    'as' => 'project.file.store']);
        Route::get('project/{project}/file/{file}',     ['uses' => 'ProjectFileController@show',     'as' => 'project.file.show']);
        Route::delete('project/{project}/file/{file}',  ['uses' => 'ProjectFileController@destroy',  'as' => 'project.file.destroy']);
    });
    
    Route::any('/{uri?}', function () {
        throw new \Symfony\Component\HttpKernel\Exception\HttpException(404, 'Method Not Allowed');
    })->where('uri', '.*');
});