<?php

$factory->define('App\Models\Ban', function($faker){
    return [
        'reason' => 'Misconduct',
        'notes' => 'Uploading bad content'
    ];
});