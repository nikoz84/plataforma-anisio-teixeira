<?php

namespace App\Traits;

use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait UserCan
{
    public function userCan(): Attribute
    {
        $get = function(){
            $user = JWTAuth::user();
            if ($user) {
                return [
                    'create' => $user->can('create', $this),
                    'update' => $user->can('update', $this),
                    'delete' => $user->can('delete', $this)
                ];
            }
        };

        return new Attribute(
            get: $get
        );
    }
}
