<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Aplicativo;

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
    // public function list(User $user, Aplicativo $aplicativo)
    // {
    //     return $user->id === $aplicativo->user_id;
    // }
}
