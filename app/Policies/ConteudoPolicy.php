<?php

namespace App\Policies;

use App\User;
use App\Conteudo;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConteudoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any conteudos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the conteudo.
     *
     * @param  \App\User  $user
     * @param  \App\Conteudo  $conteudo
     * @return mixed
     */
    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create conteudos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Conteudo $conteudo)
    {
        return $user->role->name === 'super-admin' ||
            $user->role->name === 'admin' || $user->role->name === 'coordenador';
    }

    /**
     * Determine whether the user can update the conteudo.
     *
     * @param  \App\User  $user
     * @param  \App\Conteudo  $conteudo
     * @return mixed
     */
    public function update(User $user, Conteudo $conteudo)
    {
        return $user->role->name === 'super-admin' ||
            $user->role->name === 'admin' || $user->role->name === 'coordenador' ||
            $user->id === $conteudo->user_id;
    }

    /**
     * Determine whether the user can delete the conteudo.
     *
     * @param  \App\User  $user
     * @param  \App\Conteudo  $conteudo
     * @return mixed
     */
    public function delete(User $user, Conteudo $conteudo)
    {
        return $user->role->name === 'super-admin' ||
            $user->role->name === 'admin' || $user->role->name === 'coordenador' ||
            $user->id === $conteudo->user_id;
    }

    /**
     * Determine whether the user can restore the conteudo.
     *
     * @param  \App\User  $user
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
     * @param  \App\User  $user
     * @param  \App\Conteudo  $conteudo
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->role->name === 'super-admin' ||
            $user->role->name === 'admin';
    }
}
