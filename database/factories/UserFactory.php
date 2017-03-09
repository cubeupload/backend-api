<?php

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
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => app('hash')->make('cube_test_user'),
        'registration_ip' => $faker->ipv4,
        'access_level' => 1
    ];
});