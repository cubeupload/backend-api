<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list other users.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\User  $target
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->isModerator();
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\User  $target
     * @return mixed
     */
    public function show(User $user, User $target)
    {
        if ($user->isModerator())
            return true;

        return $user->id == $target->id;
    }

    /**
     * Determine whether the user can create users.
     * Admins can create users manually.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  App\User  $user
     * @param  App\User  $user
     * @return mixed
     */
    public function update(User $user, User $target)
    {
        if ($user->id == $target->id)
            return true;

        return $user->isModerator();
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  App\User  $user
     * @param  App\User  $user
     * @return mixed
     */
    public function destroy(User $user, User $target)
    {
        // Non-admins cannot delete users (duh)
        if (!$user->isAdmin())
            return false;

        // Admins cannot delete themselves
        if ($user->id == $target->id)
            return false;

        // Admins cannot delete other mods or admins (have to demote first)
        if ($target->isModerator())
            return false;

        return true;
    }
}
