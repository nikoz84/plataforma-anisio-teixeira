<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;
trait UserCan
{
    public function getUserCanAttribute(): array
    {
        $user = Auth::user();
        $permissions = [];

        if ($user) {
            $permissions = [
                'create' => $user->can('create', $this),
                'update' => $user->can('update', $this),
                'delete' => $user->can('delete', $this),
            ];
        };

        return $permissions;
    }
}
