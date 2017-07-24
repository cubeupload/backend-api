<?php

$factory->define('App\Models\Ban', function($faker){
    return [
        'reason' => 'Test Ban',
        'notes' => 'This is a test ban'
    ];
});