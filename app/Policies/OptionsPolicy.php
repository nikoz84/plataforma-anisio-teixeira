<?php

namespace App\Policies;

use App\Models\Options;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OptionsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any options.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the options.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Options  $options
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can create options.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can update the options.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Options  $options
     * @return mixed
     */
    public function update(User $user, Options $options)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    public function destaques(User $user, Options $options)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can delete the options.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Options  $options
     * @return mixed
     */
    public function delete(User $user, Options $options)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    public function createDestaque(User $user, Options $options)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can restore the options.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Options  $options
     * @return mixed
     */
    public function restore(User $user, Options $options)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the options.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Options  $options
     * @return mixed
     */
    public function forceDelete(User $user, Options $options)
    {
        //
    }
}
