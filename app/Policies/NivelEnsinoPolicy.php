<?php

namespace App\Policies;

use App\User;
use App\NivelEnsino;
use Illuminate\Auth\Access\HandlesAuthorization;

class NivelEnsinoPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view.
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->role->name == 'super-admin' || $user->role->name == 'admin';
    }
    
    /**
     * Determine whether the user can view any nivel ensinos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the nivel ensino.
     *
     * @param  \App\User  $user
     * @param  \App\NivelEnsino  $nivelEnsino
     * @return mixed
     */
    public function view(User $user, NivelEnsino $nivelEnsino)
    {
        //
    }

    /**
     * Determine whether the user can create nivel ensinos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the nivel ensino.
     *
     * @param  \App\User  $user
     * @param  \App\NivelEnsino  $nivelEnsino
     * @return mixed
     */
    public function update(User $user, NivelEnsino $nivelEnsino)
    {
        //
    }

    /**
     * Determine whether the user can delete the nivel ensino.
     *
     * @param  \App\User  $user
     * @param  \App\NivelEnsino  $nivelEnsino
     * @return mixed
     */
    public function delete(User $user, NivelEnsino $nivelEnsino)
    {
        //
    }

    /**
     * Determine whether the user can restore the nivel ensino.
     *
     * @param  \App\User  $user
     * @param  \App\NivelEnsino  $nivelEnsino
     * @return mixed
     */
    public function restore(User $user, NivelEnsino $nivelEnsino)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the nivel ensino.
     *
     * @param  \App\User  $user
     * @param  \App\NivelEnsino  $nivelEnsino
     * @return mixed
     */
    public function forceDelete(User $user, NivelEnsino $nivelEnsino)
    {
        //
    }
}
