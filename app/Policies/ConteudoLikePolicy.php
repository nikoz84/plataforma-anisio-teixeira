<?php

namespace App\Policies;

use App\Models\Conteudo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConteudoLikePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any conteudos.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny()
    {
        //
        return true;
    }

    /**
     * Determine whether the user can view the conteudo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Conteudo  $conteudo
     * @return mixed
     */
    public function index()
    {
        return true;
    }

    /**
     * Determine whether the user can create conteudos.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the conteudo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Conteudo  $conteudo
     * @return mixed
     */
    public function update(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the conteudo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Conteudo  $conteudo
     * @return mixed
     */
    public function delete(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the conteudo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Conteudo  $conteudo
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->role->name === 'super-admin' ||
            $user->role->name === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the conteudo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Conteudo  $conteudo
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->role->name === 'super-admin' ||
            $user->role->name === 'admin';
    }
}
