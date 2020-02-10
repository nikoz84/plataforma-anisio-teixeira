<?php

namespace App\Policies;

use App\User;
use App\AplicativoCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class AplicativoCategoryPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any aplicativo categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the aplicativo category.
     *
     * @param  \App\User  $user
     * @param  \App\AplicativoCategory  $aplicativoCategory
     * @return mixed
     */
    public function view(User $user, AplicativoCategory $aplicativoCategory)
    {
        //
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
    public function update(User $user, AplicativoCategory $aplicativoCategory)
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
    public function delete(User $user, AplicativoCategory $aplicativoCategory)
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
    public function restore(User $user, AplicativoCategory $aplicativoCategory)
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
    public function forceDelete(User $user, AplicativoCategory $aplicativoCategory)
    {
        //
    }
}
