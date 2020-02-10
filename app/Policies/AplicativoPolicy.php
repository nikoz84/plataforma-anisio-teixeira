<?php

namespace App\Policies;

use App\User;
use App\Aplicativo;
use Illuminate\Auth\Access\HandlesAuthorization;

class AplicativoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any aplicativos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the aplicativo.
     *
     * @param  \App\User  $user
     * @param  \App\Aplicativo  $aplicativo
     * @return mixed
     */
    public function index(User $user, Aplicativo $aplicativo)
    {
        if (
            $user->is('super-admin') ||
            $user->is('admin') ||
            $user->is('coordenador')
        ) {
            return true;
        }
    }

    /**
     * Determine whether the user can create aplicativos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->is('super-admin') || $user->is('admin') || $user->is('coordenador')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the aplicativo.
     *
     * @param  \App\User  $user
     * @param  \App\Aplicativo  $aplicativo
     * @return mixed
     */
    public function update(User $user, Aplicativo $aplicativo)
    {
        return ($user->role->name === 'super-admin' ||
            $user->role->name === 'admin' ||
            $aplicativo->user_id === $user->id);
    }

    /**
     * Determine whether the user can delete the aplicativo.
     *
     * @param  \App\User  $user
     * @param  \App\Aplicativo  $aplicativo
     * @return mixed
     */
    public function delete(User $user, Aplicativo $aplicativo)
    {
        if (
            $user->is('super-admin') ||
            $user->is('admin') ||
            $user->is('coordenador') ||
            $user->isOwner($aplicativo->user_id)
        ) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the aplicativo.
     *
     * @param  \App\User  $user
     * @param  \App\Aplicativo  $aplicativo
     * @return mixed
     */
    public function restore(User $user, Aplicativo $aplicativo)
    {
        if ($user->is('super-admin') || $user->is('admin')) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the aplicativo.
     *
     * @param  \App\User  $user
     * @param  \App\Aplicativo  $aplicativo
     * @return mixed
     */
    public function forceDelete(User $user, Aplicativo $aplicativo)
    {
        if ($user->is('super-admin')) {
            return true;
        }
    }
}
