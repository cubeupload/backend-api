<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Image;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list images.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        echo "list policy";
        // All users can list their own images. The controller decides what the user is trying to do.
        // This could be expanded to check if the user is banned to refuse service.
        return true;
    }

    /**
     * Determine whether the user can list other user's images.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function listAll(User $user)
    {
        return $user->isModerator();
    }

    /**
     * Determine whether the user can view the image.
     *
     * @param  App\User  $user
     * @param  App\Models\Image  $image
     * @return mixed
     */
    public function view(User $user, Image $image)
    {
        if ($user->id == $image->creator_id)
            return true;

        return $user->isModerator();
    }

    /**
     * Determine whether the user can create images.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the image.
     *
     * @param  App\User  $user
     * @param  App\Image  $image
     * @return mixed
     */
    public function update(User $user, Image $image)
    {
        //
    }

    /**
     * Determine whether the user can delete the image.
     *
     * @param  App\User  $user
     * @param  App\Image  $image
     * @return mixed
     */
    public function delete(User $user, Image $image)
    {
        //
    }
}
