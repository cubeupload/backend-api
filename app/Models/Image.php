<?php

namespace App\Models;


use App\Models\Traits\CreatorRelation;
use Illuminate\Database\Eloquent\Model;


class Image extends Model
{
    use CreatorRelation;

    protected $fillable = [
        'name',
        'description'
    ];

    public function album()
    {
        return $this->belongsTo('App\Models\Album');
    }

    public function getImageUrlAttribute()
    {
        return env('IMAGE_SERVER') . '/' . $this->filename;
    }

    public function getThumbUrlAttribute()
    {
        $search = ['{hostname}', '{filename}'];
        $replace = [env('IMAGE_SERVER'), $this->filename];

        return str_replace($search, $replace, env('THUMB_FORMAT'));
    }
}
