<?php

namespace App\Traits;

use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

trait UserCan
{
    public function getUserCanAttribute()
    {
        $user = JWTAuth::user();
        if ($user) {
            return [
                'create' => $user->can('create', $this),
                'update' => $user->can('update', $this),
                'delete' => $user->can('delete', $this)
            ];
        }
    }
}
