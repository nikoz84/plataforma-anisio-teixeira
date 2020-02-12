<?php

namespace App\Traits;

use Tymon\JWTAuth\Facades\JWTAuth;

trait UserCan
{
    public function getUserCanAttribute()
    {
        $user = JWTAuth::user();
        if ($user) {
            return [
                'update' => $user->can('update', $this),
                'delete' => $user->can('delete', $this)
            ];
        }
    }
}
