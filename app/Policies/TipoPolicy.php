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
    public function view(User $user, Tipo $tipo)
    {
        //
    }

    /**
     * Determine whether the user can create tipos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the tipo.
     *
     * @param  \App\User  $user
     * @param  \App\Tipo  $tipo
     * @return mixed
     */
    public function update(User $user, Tipo $tipo)
    {
        //
    }

    /**
     * Determine whether the user can delete the tipo.
     *
     * @param  \App\User  $user
     * @param  \App\Tipo  $tipo
     * @return mixed
     */
    public function delete(User $user, Tipo $tipo)
    {
        //
    }

    /**
     * Determine whether the user can restore the tipo.
     *
     * @param  \App\User  $user
     * @param  \App\Tipo  $tipo
     * @return mixed
     */
    public function restore(User $user, Tipo $tipo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the tipo.
     *
     * @param  \App\User  $user
     * @param  \App\Tipo  $tipo
     * @return mixed
     */
    public function forceDelete(User $user, Tipo $tipo)
    {
        //
    }
}
