<?php

namespace App\Models;


use App\Models\Traits\CreatorRelation;
use Illuminate\Database\Eloquent\Model;


class Image extends Model
{
    use CreatorRelation;

    public function album()
    {
        return $this->belongsTo('App\Models\Album');
    }
}
