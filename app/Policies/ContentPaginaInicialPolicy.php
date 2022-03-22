<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ContentPaginaInicial;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentPaginaInicialPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view Content Edit.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view in Content Edit.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can create Content Edit.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, ContentPaginaInicial $contentPaginaInicial)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can update Content Edit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function update(User $user, ContentPaginaInicial $contentPaginaInicial)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can delete the denuncia.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function delete(User $user, ContentPaginaInicial $contentPaginaInicial)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }

    /**
     * Determine whether the user can restore the denuncia.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function restore(User $user, ContentPaginaInicial $contentPaginaInicial)
    {
        return $user->role->name == 'super-admin';
    }

    /**
     * Determine whether the user can permanently delete the denuncia.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Denuncia  $denuncia
     * @return mixed
     */
    public function forceDelete(User $user, ContentPaginaInicial $contentPaginaInicial)
    {
        return $user->role->name == 'super-admin';
    }
}
