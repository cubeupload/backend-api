<?php

namespace App\Models;

use App\Models\Traits\CreatorRelation;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Returns true if the user has administrator capability (level 9).
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->access_level == 9;
    }

    /**
     * Returns true if the user has moderator capability (level >= 5).
     *
     * @return boolean
     */
    public function isModerator()
    {
        return $this->access_level >= 5;
    }

    /**
     * Abuse Reports the user has raised.
     *
     **/
    public function abuse_reports()
    {
        return $this->hasMany('App\Models\AbuseReport', 'creator_id');
    }

    /**
     * Abuse Reports the user has dealt with
     *
     **/
    public function actioned_reports()
    {
        return $this->hasMany('App\Models\AbuseReport', 'actioner_id');
    }

    /**
     * Albums created by the user
     *
     **/
    public function albums()
    {
        return $this->hasMany('App\Models\Album', 'creator_id');
    }

    /**
     * Bans applied to the user
     *
     **/
    public function bans()
    {
        return $this->hasMany('App\Models\Ban', 'recipient_id');
    }

    /**
     * Bans applied by this user
     *
     **/
    public function applied_bans()
    {
        return $this->hasMany('App\Models\Ban', 'creator_id');
    }
}
