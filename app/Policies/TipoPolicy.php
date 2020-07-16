<?php

namespace App\Policies;

use App\User;
use App\Tipo;
use Illuminate\Auth\Access\HandlesAuthorization;

class TipoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tipos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the tipo.
     *
     * @param  \App\User  $user
     * @param  \App\Tipo  $tipo
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->role->name == 'super-admin' || $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can create tipos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->name == 'super-admin' || $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can update the tipo.
     *
     * @param  \App\User  $user
     * @param  \App\Tipo  $tipo
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can delete the tipo.
     *
     * @param  \App\User  $user
     * @param  \App\Tipo  $tipo
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can restore the tipo.
     *
     * @param  \App\User  $user
     * @param  \App\Tipo  $tipo
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can permanently delete the tipo.
     *
     * @param  \App\User  $user
     * @param  \App\Tipo  $tipo
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->role->name == 'super-admin';
    }
}
