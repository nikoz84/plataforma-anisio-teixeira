<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CurricularComponent;
use Illuminate\Auth\Access\HandlesAuthorization;

class CurricularComponentPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any curricular components.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the tipo.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->role->name == 'super-admin' || $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can view the curricular component.
     *
     * @param  \App\Models\User  $user
     * @param  \App\CurricularComponent  $curricularComponent
     * @return mixed
     */
    public function view(User $user, CurricularComponent $curricularComponent)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can create curricular components.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can update the curricular component.
     *
     * @param  \App\Models\User  $user
     * @param  \App\CurricularComponent  $curricularComponent
     * @return mixed
     */
    public function update(User $user, CurricularComponent $curricularComponent)
    {
        return $user->role->name == 'super-admin' || $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can delete the curricular component.
     *
     * @param  \App\Models\User  $user
     * @param  \App\CurricularComponent  $curricularComponent
     * @return mixed
     */
    public function delete(User $user, CurricularComponent $curricularComponent)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can restore the curricular component.
     *
     * @param  \App\Models\User  $user
     * @param  \App\CurricularComponent  $curricularComponent
     * @return mixed
     */
    public function restore(User $user, CurricularComponent $curricularComponent)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can permanently delete the curricular component.
     *
     * @param  \App\Models\User  $user
     * @param  \App\CurricularComponent  $curricularComponent
     * @return mixed
     */
    public function forceDelete(User $user, CurricularComponent $curricularComponent)
    {
        return $user->role->name == 'super-admin';
    }
}
