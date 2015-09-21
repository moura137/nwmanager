<?php

/**
 * FrontEnd
 */
Route::get('/',      ['uses' => 'HomeController@index',  'as' => 'home']);
Route::get('/login', ['uses' => 'HomeController@login',  'as' => 'login']);
Route::get('/forgot',['uses' => 'HomeController@forgot', 'as' => 'forgot']);
Route::get('/reset', ['uses' => 'HomeController@reset',  'as' => 'password.reset']);

/**
 * API
 */
Route::group(['middleware' => 'accept.json'], function() {

    Route::post('oauth/access-token', 'OAuthController@access');
    Route::post('oauth/forgot', 'OAuthController@forgot');
    Route::post('oauth/token', 'OAuthController@token');
    Route::post('oauth/reset', 'OAuthController@reset');
    
    Route::group(['middleware' => 'api.oauth', 'where' => ['project' => '\d+'], 'as' => 'api.'], function() {

        Route::get('oauth/user', ['uses' => 'OAuthController@user', 'as' => 'oauth.user']);

        Route::resource('user',         'UserController',        ['except' => ['create', 'edit']]);
        Route::resource('client',       'ClientController',      ['except' => ['create', 'edit']]);
        Route::resource('project',      'ProjectController',     ['except' => ['create', 'edit']]);
        
        Route::post('project/{project}/members/add',    ['uses' => 'ProjectController@addMember',   'as' => 'project.members.store']);
        Route::post('project/{project}/members/remove', ['uses' => 'ProjectController@removeMember','as' => 'project.members.destroy']);
        Route::post('project/{project}/members/sync',   ['uses' => 'ProjectController@syncMember',  'as' => 'project.members.sync']);
        
        Route::get('project/{project}/note',            ['uses' => 'ProjectNoteController@index',   'as' => 'project.note.index']);
        Route::post('project/{project}/note',           ['uses' => 'ProjectNoteController@store',   'as' => 'project.note.store']);
        Route::put('project/{project}/note/{note}',     ['uses' => 'ProjectNoteController@update',  'as' => 'project.note.update']);
        Route::get('project/{project}/note/{note}',     ['uses' => 'ProjectNoteController@show',    'as' => 'project.note.show']);
        Route::delete('project/{project}/note/{note}',  ['uses' => 'ProjectNoteController@destroy', 'as' => 'project.note.destroy']);

        Route::get('project/{project}/task',            ['uses' => 'ProjectTaskController@index',    'as' => 'project.task.index']);
        Route::post('project/{project}/task',           ['uses' => 'ProjectTaskController@store',    'as' => 'project.task.store']);
        Route::get('project/{project}/task/{task}',     ['uses' => 'ProjectTaskController@show',     'as' => 'project.task.show']);
        Route::put('project/{project}/task/{task}',     ['uses' => 'ProjectTaskController@update',   'as' => 'project.task.update']);
        Route::delete('project/{project}/task/{task}',  ['uses' => 'ProjectTaskController@destroy',  'as' => 'project.task.destroy']);

        Route::get('project/{project}/file',                 ['uses' => 'ProjectFileController@index',     'as' => 'project.file.index']);
        Route::post('project/{project}/file',                ['uses' => 'ProjectFileController@store',     'as' => 'project.file.store']);
        Route::get('project/{project}/file/{file}',          ['uses' => 'ProjectFileController@show',      'as' => 'project.file.show']);
        Route::delete('project/{project}/file/{file}',       ['uses' => 'ProjectFileController@destroy',   'as' => 'project.file.destroy']);
        Route::delete('project/{project}/files',             ['uses' => 'ProjectFileController@destroyAll','as' => 'project.file.destroy_all']);
        Route::get('project/{project}/file/{file}/download', ['uses' => 'ProjectFileController@download',  'as' => 'project.file.download']);
    });
    
    Route::any('/{uri?}', function () {
        throw new \Symfony\Component\HttpKernel\Exception\HttpException(404, 'Method Not Allowed');
    })->where('uri', '.*');
});