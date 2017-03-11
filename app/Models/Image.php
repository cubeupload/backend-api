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
}
