<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\CreatorRelation;

class AbuseReport extends Model
{
    use CreatorRelation;

    public function actioner()
    {
        return $this->belongsTo('App\Models\User', 'actioner_id');
    }
}
