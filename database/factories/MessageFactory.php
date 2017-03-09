<?php

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