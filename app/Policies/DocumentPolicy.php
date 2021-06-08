<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
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


    public function index(User $user)
    {
        return $user->role->name == 'super-admin' ||
        $user->role->name == 'admin' ||
        $user->role->name == 'coordenador';
    }
}
