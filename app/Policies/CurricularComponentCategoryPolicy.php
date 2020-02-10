<?php

namespace App\Policies;

use App\User;
use App\CurricularComponentCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class CurricularComponentCategoryPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any curricular component categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the curricular component category.
     *
     * @param  \App\User  $user
     * @param  \App\CurricularComponentCategory  $curricularComponentCategory
     * @return mixed
     */
    public function view(User $user, CurricularComponentCategory $curricularComponentCategory)
    {
        //
    }

    /**
     * Determine whether the user can create curricular component categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the curricular component category.
     *
     * @param  \App\User  $user
     * @param  \App\CurricularComponentCategory  $curricularComponentCategory
     * @return mixed
     */
    public function update(User $user, CurricularComponentCategory $curricularComponentCategory)
    {
        //
    }

    /**
     * Determine whether the user can delete the curricular component category.
     *
     * @param  \App\User  $user
     * @param  \App\CurricularComponentCategory  $curricularComponentCategory
     * @return mixed
     */
    public function delete(User $user, CurricularComponentCategory $curricularComponentCategory)
    {
        //
    }

    /**
     * Determine whether the user can restore the curricular component category.
     *
     * @param  \App\User  $user
     * @param  \App\CurricularComponentCategory  $curricularComponentCategory
     * @return mixed
     */
    public function restore(User $user, CurricularComponentCategory $curricularComponentCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the curricular component category.
     *
     * @param  \App\User  $user
     * @param  \App\CurricularComponentCategory  $curricularComponentCategory
     * @return mixed
     */
    public function forceDelete(User $user, CurricularComponentCategory $curricularComponentCategory)
    {
        //
    }
}
