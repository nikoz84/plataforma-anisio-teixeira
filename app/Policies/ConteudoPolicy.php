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
    public function view(User $user, Conteudo $conteudo)
    {
        //
    }

    /**
     * Determine whether the user can create conteudos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
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
        //
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
        //
    }

    /**
     * Determine whether the user can restore the conteudo.
     *
     * @param  \App\User  $user
     * @param  \App\Conteudo  $conteudo
     * @return mixed
     */
    public function restore(User $user, Conteudo $conteudo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the conteudo.
     *
     * @param  \App\User  $user
     * @param  \App\Conteudo  $conteudo
     * @return mixed
     */
    public function forceDelete(User $user, Conteudo $conteudo)
    {
        //
    }
}
