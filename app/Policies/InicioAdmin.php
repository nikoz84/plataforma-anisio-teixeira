<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InicioAdmin
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create aplicativos.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->role->name === 'super-admin' ||
            $user->role->name === 'admin' ||
            $user->role->name === 'coordenador';
    }
}
