<?php

namespace App\Policies;

use App\Models\LogArtisan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LogArtisanPolicy
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
     * Determine whether the user can view any aplicativo categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role->name == 'super-admin' || $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can view the aplicativo category.
     *
     * @param  \App\User  $user
     * @param  \App\LogArtisan $logartisan
     * @return mixed
     */
    public function view(User $user, LogArtisan $logartisan)
    {
        return $user->role->name == 'super-admin' || $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can create aplicativo categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the aplicativo category.
     *
     * @param  \App\User  $user
     * @param  \App\AplicativoCategory  $aplicativoCategory
     * @return mixed
     */
    public function update(User $user,  LogArtisan $logartisan)
    {
        //
    }

    /**
     * Determine whether the user can delete the aplicativo category.
     *
     * @param  \App\User  $user
     * @param  \App\AplicativoCategory  $aplicativoCategory
     * @return mixed
     */
    public function delete(User $user,  LogArtisan $logartisan)
    {
        //
    }

    /**
     * Determine whether the user can restore the aplicativo category.
     *
     * @param  \App\User  $user
     * @param  \App\AplicativoCategory  $aplicativoCategory
     * @return mixed
     */
    public function restore(User $user,  LogArtisan $logartisan)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the aplicativo category.
     *
     * @param  \App\User  $user
     * @param  \App\AplicativoCategory  $aplicativoCategory
     * @return mixed
     */
    public function forceDelete(User $user,  LogArtisan $logartisan)
    {
        //
    }
}
