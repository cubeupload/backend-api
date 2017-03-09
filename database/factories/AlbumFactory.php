<?php

$factory->define('App\Models\Album', function($faker){
    return [
        'name' => 'Test Album',
        'slug' => 'test-album',
        'description' => 'New album'
    ];
});