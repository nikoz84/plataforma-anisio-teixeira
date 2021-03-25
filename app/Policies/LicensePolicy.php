<?php

namespace App\Policies;

use App\Models\User;
use App\Models\License;
use Illuminate\Auth\Access\HandlesAuthorization;

class LicensePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any licenses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the license.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function getAnalytics(User $user)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can create licenses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can update the license.
     *
     * @param  \App\Models\User  $user
     * @param  \App\License  $license
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can delete the license.
     *
     * @param  \App\Models\User  $user
     * @param  \App\License  $license
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can restore the license.
     *
     * @param  \App\Models\User  $user
     * @param  \App\License  $license
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can permanently delete the license.
     *
     * @param  \App\Models\User  $user
     * @param  \App\License  $license
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->role->name == 'super-admin';
    }
}
