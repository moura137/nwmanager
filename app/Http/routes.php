<?php

/**
 * FrontEnd
 */
Route::get('/',      ['uses' => 'HomeController@index',  'as' => 'home']);
Route::any('/status', function(){
    return 'OK';
});

/**
 * API
 */
Route::group(['middleware' => 'accept.json'], function() {

    Route::post('oauth/access-token', 'OAuthController@access');
    Route::post('oauth/forgot', 'OAuthController@forgot');
    Route::post('oauth/token', 'OAuthController@token');
    Route::post('oauth/reset', 'OAuthController@reset');

    Route::group([
        'middleware' => 'api.oauth',
        'where' => [
            'user' => '\d+',
            'client' => '\d+',
            'project' => '\d+',
            'note' => '\d+',
            'task' => '\d+',
            'file' => '\d+',
        ]],
        function() {

        Route::get('oauth/user', 'OAuthController@user');

        Route::get('user',           'UserController@index');
        Route::post('user',          'UserController@store');
        Route::put('user/{user}',    'UserController@update');
        Route::get('user/{user}',    'UserController@show');
        Route::delete('user/{user}', 'UserController@destroy');

        Route::get('client',             'ClientController@index');
        Route::post('client',            'ClientController@store');
        Route::put('client/{client}',    'ClientController@update');
        Route::get('client/{client}',    'ClientController@show');
        Route::delete('client/{client}', 'ClientController@destroy');
        Route::get('client/limit',       'ClientController@limit');

        Route::get('project',              'ProjectController@index');
        Route::post('project',             'ProjectController@store');
        Route::put('project/{project}',    'ProjectController@update');
        Route::get('project/{project}',    'ProjectController@show');
        Route::delete('project/{project}', 'ProjectController@destroy');

        Route::post('project/{project}/members/add',    'ProjectController@addMember');
        Route::post('project/{project}/members/remove', 'ProjectController@removeMember');
        Route::post('project/{project}/members/sync',   'ProjectController@syncMember');

        Route::get('project/{project}/note',            'ProjectNoteController@index');
        Route::post('project/{project}/note',           'ProjectNoteController@store');
        Route::put('project/{project}/note/{note}',     'ProjectNoteController@update');
        Route::get('project/{project}/note/{note}',     'ProjectNoteController@show');
        Route::delete('project/{project}/note/{note}',  'ProjectNoteController@destroy');

        Route::get('project/{project}/task',            'ProjectTaskController@index');
        Route::post('project/{project}/task',           'ProjectTaskController@store');
        Route::get('project/{project}/task/{task}',     'ProjectTaskController@show');
        Route::put('project/{project}/task/{task}',     'ProjectTaskController@update');
        Route::delete('project/{project}/task/{task}',  'ProjectTaskController@destroy');
        Route::post('project/{project}/task/{task}/finish',  'ProjectTaskController@finish');

        Route::get('project/{project}/file',                 'ProjectFileController@index');
        Route::post('project/{project}/file',                'ProjectFileController@store');
        Route::get('project/{project}/file/{file}',          'ProjectFileController@show');
        Route::delete('project/{project}/file/{file}',       'ProjectFileController@destroy');
        Route::delete('project/{project}/files',             'ProjectFileController@destroyAll');
        Route::get('project/{project}/file/{file}/download', 'ProjectFileController@download');

        Route::get('activities', 'ActivityController@index');
    });

    Route::any('/{uri?}', function () {
        throw new \Symfony\Component\HttpKernel\Exception\HttpException(404, 'Method Not Allowed');
    })->where('uri', '.*');
});