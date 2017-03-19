<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Album;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlbumPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list albums.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        // All users can list their own albums. The controller decides what the user is trying to do.
        // This could be expanded to check if the user is banned to refuse service.
        return true;
    }

    /**
     * Determine whether the user can list other user's albums.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function listall(User $user)
    {
        return $user->isModerator();
    }

    /**
     * Determine whether the user can view a single album.
     *
     * @param  App\User  $user
     * @param  App\Models\Album  $album
     * @return mixed
     */
    public function show(User $user, Album $album)
    {
        if ($user->id == $album->creator_id)
            return true;


        return $user->isModerator();
    }

    /**
     * Determine whether the user can create albums.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the album.
     *
     * @param  App\User  $user
     * @param  App\Album  $album
     * @return mixed
     */
    public function update(User $user, Album $album)
    {
        if ($user->id === $album->creator_id)
            return true;

        return $user->isModerator();
    }

    /**
     * Determine whether the user can delete the album.
     *
     * @param  App\User  $user
     * @param  App\Album  $album
     * @return mixed
     */
    public function destroy(User $user, Album $album)
    {
        if ($user->id === $album->creator_id)
            return true;

        return $user->isModerator();
    }
}
