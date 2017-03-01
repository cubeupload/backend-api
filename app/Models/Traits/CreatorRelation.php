<?php namespace App\Models\Traits;

/**
 * 
 */
trait CreatorRelation
{
    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'creator_id');
    }
}
