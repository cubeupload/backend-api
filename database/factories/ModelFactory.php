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

$factory->defineAs('App\Models\User', 'admin', function($faker){
    return [
        'name' => 'Test Admin',
        'email' => 'testadmin@cubeupload.com',
        'password' => app('hash')->make('cube_test_admin'),
        'registration_ip' => '127.0.0.1',
        'access_level' => 9
    ];
});

$factory->defineAs('App\Models\User', 'moderator', function($faker){
    return [
        'name' => 'Test Moderator',
        'email' => 'testmod@cubeupload.com',
        'password' => app('hash')->make('cube_test_mod'),
        'registration_ip' => '127.0.0.1',
        'access_level' => 5
    ];
});

$factory->define('App\Models\User', function($faker){
    return [
        'name' => 'Test User',
        'email' => 'testuser@cubeupload.com',
        'password' => app('hash')->make('cube_test_user'),
        'registration_ip' => '127.0.0.1',
        'access_level' => 1
    ];
});

$factory->define('App\Models\Album', function($faker){
    return [
        'name' => 'Test Album',
        'slug' => 'test-album',
        'description' => 'New album'
    ];
});

$factory->define('App\Models\Image', function($faker){
    return [
        'name' => 'Test Image',
        'description' => 'Test Description'
    ];
});

$factory->define('App\Models\Ban', function($faker){
    return [
        'reason' => 'Misconduct',
        'notes' => 'Uploading bad content'
    ];
});

$factory->define('App\Models\Message', function($faker){
    return [
        'title' => 'This is a test message',
        'text' => 'I would like to suggest you avoid procrastination. That is all.'
    ];
});

$factory->defineAs('App\Models\Message', 'read', function($faker){
    return [
        'title' => 'This is a test message',
        'text' => 'I would like to suggest you avoid procrastination. That is all.',
        'status' => 'read'
    ];
});

$factory->define('App\Models\AbuseReport', function($faker){
    return [
        'name' => 'This is a test message',
        'text' => 'I would like to suggest you avoid procrastination. That is all.'
    ];
});