<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$api = $app->make(Dingo\Api\Routing\Router::class);

$api->version('v1', function ($api) {
    $api->post('/auth/login', [
        'as' => 'api.auth.login',
        'uses' => 'App\Http\Controllers\Auth\AuthController@postLogin',
    ]);

    $api->post('/upload/guest',[
        'as' => 'api.upload.guest',
        'uses' => 'App\Http\Controllers\UploadController@postUpload',
        'middleware' => ['bancheck','uploadcheck']
    ]);


    $api->group([
        'middleware' => ['bancheck', 'api.auth', 'bancheck'],
    ], function ($api) {
        $api->get('/', [
            'uses' => 'App\Http\Controllers\APIController@getIndex',
            'as' => 'api.index'
        ]);
        $api->get('/auth/user', [
            'uses' => 'App\Http\Controllers\Auth\AuthController@getUser',
            'as' => 'api.auth.user'
        ]);
        $api->patch('/auth/refresh', [
            'uses' => 'App\Http\Controllers\Auth\AuthController@patchRefresh',
            'as' => 'api.auth.refresh'
        ]);
        $api->delete('/auth/invalidate', [
            'uses' => 'App\Http\Controllers\Auth\AuthController@deleteInvalidate',
            'as' => 'api.auth.invalidate'
        ]);

        // Resource controllers
        $api->resource('/users', 'App\Http\Controllers\UserController');
        $api->resource('/images', 'App\Http\Controllers\ImageController');
        $api->resource('/albums', 'App\Http\Controllers\AlbumController');

        $api->put('/users/{id}/settings', 'App\Http\Controllers\UserController@putSettings');

        $api->post('/upload/authed',[
        'as' => 'api.upload.authed',
        'uses' => 'App\Http\Controllers\UploadController@postUpload',
        'middleware' => 'uploadcheck'
    ]);
    });
});
