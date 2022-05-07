<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Canal;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CanalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any canals.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the canal.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Canal  $canal
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->role->name == 'super-admin' || $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can create canals.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, Canal $canal)
    {
        return $user->role->name === 'super-admin' ||
        $user->role->name === 'admin';
    }

    /**
     * Determine whether the user can update the canal.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Canal  $canal
     * @return mixed
     */
    public function update(User $user, Canal $canal)
    {
        return $user->role->name === 'super-admin' ||
        $user->role->name === 'admin';
    }

    /**
     * Determine whether the user can delete the canal.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Canal  $canal
     * @return mixed
     */
    public function delete(User $user, Canal $canal)
    {
        if ($user->is('super-admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the canal.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Canal  $canal
     * @return mixed
     */
    public function restore(User $user, Canal $canal)
    {
        if ($user->is('super-admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the canal.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Canal  $canal
     * @return mixed
     */
    public function forceDelete(User $user, Canal $canal)
    {
        if ($user->is('super-admin')) {
            return true;
        }
    }
}
