<?php

namespace App\Policies;

use App\Models\PlayList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlayListPolicy
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

    public function create(User $user, PlayList $playList)
    {
        return $user->role->name == 'super-admin' ||
            $user->role->name == 'admin';
    }
}
