<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\CreatorRelation;

class Album extends Model
{
    use CreatorRelation;

    protected $fillable = [
        'name',
        'description'
    ];
    
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value, '-');
    }
    public function getSlugAttribute()
    {
        return str_slug($this->name, '-');
    }
}
