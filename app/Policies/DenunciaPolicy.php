<?php

namespace App\Policies;

use App\User;
use App\Denuncia;
use Illuminate\Auth\Access\HandlesAuthorization;

class DenunciaPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any denuncias.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the denuncia.
     *
     * @param  \App\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function view(User $user, Denuncia $denuncia)
    {
        //
    }

    /**
     * Determine whether the user can create denuncias.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the denuncia.
     *
     * @param  \App\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function update(User $user, Denuncia $denuncia)
    {
        //
    }

    /**
     * Determine whether the user can delete the denuncia.
     *
     * @param  \App\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function delete(User $user, Denuncia $denuncia)
    {
        //
    }

    /**
     * Determine whether the user can restore the denuncia.
     *
     * @param  \App\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function restore(User $user, Denuncia $denuncia)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the denuncia.
     *
     * @param  \App\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function forceDelete(User $user, Denuncia $denuncia)
    {
        //
    }
}
