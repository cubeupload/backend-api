<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\CreatorRelation;

class Album extends Model
{
    use CreatorRelation;
    
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
}
