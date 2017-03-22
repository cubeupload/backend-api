<?php

namespace App\Models;

use App\Models\Traits\CreatorRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Cache;

class Ban extends Model
{
    use CreatorRelation;

    public function recipient()
    {
        return $this->belongsTo('App\Models\User', 'recipient_id');
    }

    public function scopeActive($query)
    {
        return $query->where('enabled', true)->where('expires_at', '>', date('Y-m-d H:i:s'));
    }
}
