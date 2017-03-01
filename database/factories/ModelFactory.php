<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->defineAs('App\Models\User', 'test_admin', function($faker){
    return [
        'name' => 'Test Admin',
        'email' => 'testadmin@cubeupload.com',
        'password' => app('hash')->make('cube_test_admin'),
        'registration_ip' => '127.0.0.1',
        'access_level' => 9
    ];
});

$factory->defineAs('App\Models\User', 'test_mod', function($faker){
    return [
        'name' => 'Test Moderator',
        'email' => 'testmod@cubeupload.com',
        'password' => app('hash')->make('cube_test_mod'),
        'registration_ip' => '127.0.0.1',
        'access_level' => 5
    ];
});

$factory->defineAs('App\Models\User', 'test_user', function($faker){
    return [
        'name' => 'Test User',
        'email' => 'testuser@cubeupload.com',
        'password' => app('hash')->make('cube_test_user'),
        'registration_ip' => '127.0.0.1',
        'access_level' => 1
    ];
});