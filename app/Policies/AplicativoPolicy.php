<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Conteudo;

class AplicativoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    // public function updatePermission(User $user, Conteudo $conteudo)
    // {
    //     return $user->id == $conteudo->user_id;
    // }
}
