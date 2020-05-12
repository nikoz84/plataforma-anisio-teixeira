<?php

namespace App\Policies;

use App\User;
use App\Contato;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContatoPolicy
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
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin' ||
            $user->role->name == 'coordenador';
    }

    /**
     * Determine whether the user can create denuncias.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the denuncia.
     *
     * @param  \App\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function update(User $user, Contato $contato)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin' ||
            $user->role->name == 'coordenador';
    }

    /**
     * Determine whether the user can delete the denuncia.
     *
     * @param  \App\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function delete(User $user, Contato $contato)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin' ||
            $user->role->name == 'coordenador';
    }

    /**
     * Determine whether the user can restore the denuncia.
     *
     * @param  \App\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function restore(User $user, Contato $contato)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can permanently delete the denuncia.
     *
     * @param  \App\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function forceDelete(User $user, Contato $contato)
    {
        return $user->role->name == 'super-admin';
    }
}
