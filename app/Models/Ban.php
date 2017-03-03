<?php

namespace App\Models;

use App\Models\Traits\CreatorRelation;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use CreatorRelation;

    public function recipient()
    {
        return $this->belongsTo('App\Models\User', 'recipient_id');
    }
}
